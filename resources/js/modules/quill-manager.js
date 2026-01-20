/* global Quill, axios */
(() => {
    'use strict';

    /**
     * QuillManager
     * Written By Salman @ SK Developers https://skdevelopers.info
     * - Initializes Quill instances from markup that follows:
     *   toolbar:  #toolbar_<uid>
     *   editor:   #editor_<uid>
     *   hidden:   #<uid> (input[type="hidden"])
     *
     * - Supports dynamic Alpine rows (call initWithin(container) after DOM updates)
     * - Supports AI buttons using data-ai-* attributes:
     *   [data-ai-action="rewrite|expand|shorten"] + data-ai-type="residential_plots"
     *
     * IMPORTANT:
     * - DOES NOT change any layout/design.
     * - Purely behavior.
     */

    const editors = Object.create(null);

    const $ = (sel, root = document) => root.querySelector(sel);

    const toast = (message, type = 'info') => {
        if (typeof window.showToast === 'function') {
            window.showToast(message, type);
            return;
        }
        window.dispatchEvent(new CustomEvent('toast', { detail: { message, type } }));
    };

    const sanitizeBasic = (html) => {
        // Frontend minimal guard. Backend MUST sanitize too (you already do allowlist).
        const div = document.createElement('div');
        div.innerHTML = html || '';
        div.querySelectorAll('script, style, iframe, object, embed').forEach(n => n.remove());
        div.querySelectorAll('*').forEach(el => {
            // Remove obvious dangerous attributes
            [...el.attributes].forEach(attr => {
                const n = (attr.name || '').toLowerCase();
                if (n.startsWith('on')) el.removeAttribute(attr.name);
                if (n === 'style') el.removeAttribute(attr.name);
            });
        });
        return div.innerHTML.trim();
    };

    /**
     * Initialize a single editor by uid.
     * @param {string} uid
     * @param {{ value?: string }} opts
     * @returns {Quill|null}
     */
    const initOnce = (uid, opts = {}) => {
        if (!uid) return null;
        if (editors[uid]) return editors[uid];

        const wrap = document.querySelector(`[data-quill-wrap][data-quill-uid="${uid}"]`);
        if (!wrap) return null;

        const editorEl  = $(`#editor_${uid}`, wrap);
        const toolbarEl = $(`#toolbar_${uid}`, wrap);
        const hiddenEl  = $(`#${uid}`, wrap);

        if (!editorEl || !toolbarEl || !hiddenEl) return null;
        if (!window.Quill) return null;

        const placeholder = wrap.getAttribute('data-quill-placeholder') || 'Write here...';

        const ql = new Quill(editorEl, {
            theme: 'snow',
            modules: { toolbar: toolbarEl },
            placeholder,
        });

        // Prefill
        const prefill = (opts.value ?? hiddenEl.value ?? '').trim();
        if (prefill) {
            ql.clipboard.dangerouslyPasteHTML(prefill);
        }

        // Sync hidden input with RAF throttle (micro-optimized)
        let raf = 0;
        ql.on('text-change', () => {
            if (raf) cancelAnimationFrame(raf);
            raf = requestAnimationFrame(() => {
                hiddenEl.value = ql.root.innerHTML;
            });
        });

        editors[uid] = ql;
        return ql;
    };

    /**
     * Initialize all editors inside a DOM root.
     * @param {HTMLElement|Document} root
     * @returns {void}
     */
    const initWithin = (root = document) => {
        root.querySelectorAll('[data-quill-wrap][data-quill-uid]').forEach((wrap) => {
            const uid = wrap.getAttribute('data-quill-uid');
            if (!uid) return;
            initOnce(uid);
        });
    };

    /**
     * AI transform call (rewrite/expand/shorten)
     * Backend route MUST exist: admin.ai.editor.transform
     * Payload: { entity, type, action, text }
     */
    const aiTransform = async (type, action, text) => {
        const res = await axios.post('/admin/ai/editor/transform', {
            entity: 'society',
            type,
            action,
            text,
        });

        return (res?.data?.html || '').trim();
    };

    /**
     * Click handler for AI buttons.
     * Expected buttons:
     *  <button data-ai-action="rewrite" data-ai-type="apartments">R</button>
     */
    const bindAiButtons = () => {
        document.addEventListener('click', async (e) => {
            const btn = e.target?.closest?.('[data-ai-action][data-ai-type]');
            if (!btn) return;

            const action = btn.getAttribute('data-ai-action');
            const type = btn.getAttribute('data-ai-type');

            if (!action || !type) return;

            // Our convention: hidden input id for property "about" is: `${type}_about`
            const uid = `${type}_about`;

            const ql = editors[uid] || initOnce(uid);
            if (!ql) {
                toast('Editor not ready. Open the section first.', 'warning');
                return;
            }

            const sel = ql.getSelection();
            const hasSel = !!(sel && sel.length && sel.length > 0);

            const sourceText = hasSel
                ? (ql.getText(sel.index, sel.length) || '').trim()
                : (ql.getText() || '').trim();

            if (!sourceText) {
                toast('Write something first.', 'warning');
                return;
            }

            btn.disabled = true;
            btn.classList.add('opacity-60');

            try {
                toast('AI working...', 'info');

                const html = await aiTransform(type, action, sourceText);
                const clean = sanitizeBasic(html);

                if (!clean) {
                    toast('AI returned empty content.', 'error');
                    return;
                }

                if (hasSel) {
                    ql.deleteText(sel.index, sel.length, 'user');
                    ql.clipboard.dangerouslyPasteHTML(sel.index, clean, 'user');
                } else {
                    ql.setText('', 'silent');
                    ql.clipboard.dangerouslyPasteHTML(0, clean, 'user');
                }

                // Ensure hidden is updated now
                const hiddenEl = document.getElementById(uid);
                if (hiddenEl) hiddenEl.value = ql.root.innerHTML;

                toast('Done ✅', 'success');
            } catch (err) {
                // eslint-disable-next-line no-console
                console.error(err);
                toast(err?.response?.data?.message || 'AI failed', 'error');
            } finally {
                btn.disabled = false;
                btn.classList.remove('opacity-60');
            }
        });
    };

    const boot = () => {
        initWithin(document);
        bindAiButtons();
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    window.QuillManager = {
        initOnce,
        initWithin,
        editors,
    };
})();
