/* global Quill, axios */
(() => {
    'use strict';

    const editors = Object.create(null);

    const q = (sel, root = document) => root.querySelector(sel);

    const toast = (type, message) => {
        window.dispatchEvent(new CustomEvent('toast', { detail: { type, message } }));
    };

    const slugify = (s) => (s || '')
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .trim()
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');

    const sanitizeBasic = (html) => {
        // Frontend “minimal safe” - backend should do SSR-safe sanitation too.
        const div = document.createElement('div');
        div.innerHTML = html || '';

        div.querySelectorAll('script, style, iframe, object, embed').forEach(n => n.remove());
        div.querySelectorAll('*').forEach(el => {
            el.removeAttribute('style');
            el.removeAttribute('class');
            el.removeAttribute('onload');
            el.removeAttribute('onclick');
            el.removeAttribute('onerror');
        });

        return div.innerHTML;
    };

    const initOnce = (uid, opts = {}) => {
        if (!uid || editors[uid]) return editors[uid] || null;

        const wrap = q(`[data-quill-wrap][data-quill-uid="${uid}"]`);
        if (!wrap) return null;

        const editorEl = q(`#editor_${uid}`, wrap);
        const toolbarEl = q(`#toolbar_${uid}`, wrap);
        const hiddenEl = q(`#${uid}[data-quill-hidden]`, wrap);
        if (!editorEl || !toolbarEl || !hiddenEl) return null;

        const placeholder = wrap.getAttribute('data-quill-placeholder') || 'Write here...';

        const instance = new Quill(editorEl, {
            theme: 'snow',
            modules: { toolbar: toolbarEl },
            placeholder,
        });

        // Prefill (EDIT page)
        const prefill = (opts.value ?? hiddenEl.value ?? '').trim();
        if (prefill) instance.clipboard.dangerouslyPasteHTML(prefill);

        // Sync hidden input
        let raf = 0;
        instance.on('text-change', () => {
            if (raf) cancelAnimationFrame(raf);
            raf = requestAnimationFrame(() => {
                hiddenEl.value = instance.root.innerHTML;
            });
        });

        editors[uid] = instance;
        return instance;
    };

    const initWithin = (root = document) => {
        root.querySelectorAll('[data-quill-wrap][data-quill-uid]').forEach((wrap) => {
            const uid = wrap.getAttribute('data-quill-uid');
            if (!uid) return;
            initOnce(uid);
        });
    };

    // ---------- AI helpers ----------
    const aiCall = async ({ mode, type, title, currentHtml }) => {
        // You will implement your backend endpoint accordingly
        const res = await axios.post('/admin/ai/quill', {
            entity: 'society',
            mode,           // generate | rewrite | expand | shorten
            type,           // residential_plots etc
            title,
            html: currentHtml || '',
        });
        return res?.data?.html || '';
    };

    const getTitleForType = (type) => {
        return (
            q(`[name="${type}_title"]`)?.value ||
            q('#name')?.value ||
            ''
        );
    };

    const bindAIButtons = () => {
        document.addEventListener('click', async (e) => {
            const btn = e.target?.closest?.('[data-ai-generate],[data-ai-rewrite],[data-ai-expand],[data-ai-shorten]');
            if (!btn) return;

            const type = btn.getAttribute('data-ai-type') || '';
            if (!type) return;

            const uid = `${type}_about`; // IMPORTANT: your hidden field id must follow this pattern
            const editor = editors[uid] || initOnce(uid);
            if (!editor) {
                toast('error', 'Editor not ready.');
                return;
            }

            const title = getTitleForType(type);
            if (!title) {
                toast('warning', 'Please enter a title first.');
                return;
            }

            const mode = btn.hasAttribute('data-ai-generate') ? 'generate'
                : btn.hasAttribute('data-ai-rewrite') ? 'rewrite'
                : btn.hasAttribute('data-ai-expand') ? 'expand'
                : 'shorten';

            btn.disabled = true;
            btn.classList.add('opacity-60');

            try {
                const current = editor.root.innerHTML || '';
                const html = await aiCall({ mode, type, title, currentHtml: current });
                const clean = sanitizeBasic(html);

                if (!clean) {
                    toast('error', 'AI returned empty content.');
                    return;
                }

                editor.clipboard.dangerouslyPasteHTML(clean);
                const hidden = q(`#${uid}`);
                if (hidden) hidden.value = clean;

                toast('success', `AI ${mode} done.`);
            } catch (err) {
                // eslint-disable-next-line no-console
                console.error(err);
                toast('error', 'AI request failed.');
            } finally {
                btn.disabled = false;
                btn.classList.remove('opacity-60');
            }
        });
    };

    const bindSlug = () => {
        const nameEl = q('#name');
        const slugEl = q('#slug');
        if (!nameEl || !slugEl) return;

        let manual = false;
        slugEl.addEventListener('input', () => { manual = true; });

        nameEl.addEventListener('input', () => {
            if (manual) return;
            slugEl.value = slugify(nameEl.value);
        });
    };

    const bindFilePreview = () => {
        document.addEventListener('change', (e) => {
            const input = e.target;
            if (!input || input.type !== 'file') return;

            const file = input.files?.[0];
            if (!file || !file.type?.startsWith('image/')) return;

            // Find nearest block that contains preview-box
            const wrap = input.closest('.society-image-block') || input.closest('[data-preview-wrap]') || input.parentElement;
            if (!wrap) return;

            const preview = wrap.querySelector('.preview-box');
            if (!preview) return;

            const reader = new FileReader();
            reader.onload = () => {
                preview.innerHTML = `
                    <img src="${reader.result}"
                         alt="Preview"
                         class="absolute inset-0 w-full h-full object-contain rounded-md" />
                `;
            };
            reader.readAsDataURL(file);
        });
    };

    const boot = () => {
        initWithin(document);
        bindAIButtons();
        bindSlug();
        bindFilePreview();
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    // Public API for Alpine dynamic rows:
    window.QuillManager = {
        initOnce,
        initWithin,
        editors,
    };
})();
