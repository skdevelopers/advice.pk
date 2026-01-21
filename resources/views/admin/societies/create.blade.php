@extends('admin.layouts.app')

@section('title', 'Add Society - Advice Associates AI Real Estate CRM')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">

            {{-- Header (UNCHANGED DESIGN) --}}
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Create Society</h5>

                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white-100/70 hover:text-green-600 dark:hover:text-white">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="inline-block text-base text-slate-950 dark:text-white-100/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white" aria-current="page">Create Society</li>
                </ul>
            </div>

            <div class="grid grid-cols-1 mt-6">
                <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900">

                    <form id="createSocietyForm" enctype="multipart/form-data">
                        @csrf

                        {{-- BASIC FIELDS (UNCHANGED DESIGN) --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-green-600 dark:text-gray-200 font-medium mb-2">Society Name</label>
                                <input type="text" name="name" id="name" class="w-full border px-3 py-2 rounded" required>
                            </div>

                            <div>
                                <label for="slug" class="block text-green-600 dark:text-gray-200 font-medium mb-2">Slug</label>
                                <input type="text" name="slug" id="slug" class="w-full border px-3 py-2 rounded" required>
                            </div>

                            <div>
                                <label for="city_id" class="block text-green-600 dark:text-gray-200 font-medium mb-2">City</label>
                                <select name="city_id" id="city_id" class="w-full border px-3 py-2 rounded" required>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="user_id" class="block text-green-600 dark:text-gray-200 font-medium mb-2">Assigned User</label>
                                <select name="user_id" id="user_id" class="w-full border px-3 py-2 rounded" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- OVERVIEW + DETAIL (Quill added, DESIGN kept) --}}
                        <div class="mt-4">
                            <label class="block text-green-600 dark:text-gray-200 font-medium mb-2">Overview</label>
                            <x-admin.quill
                                uid="overview"
                                name="overview"
                                placeholder="Write overview..."
                                minHeight="min-h-[140px]"
                                maxHeight="max-h-[260px]"
                            />
                        </div>

                        <div class="mt-4">
                            <label class="block text-green-600 dark:text-gray-200 font-medium mb-2">Detail</label>
                            <x-admin.quill
                                uid="detail"
                                name="detail"
                                placeholder="Write detail..."
                                minHeight="min-h-[180px]"
                                maxHeight="max-h-[320px]"
                            />
                        </div>

                        {{-- IMAGES (UNCHANGED DESIGN) --}}
                        <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900 h-fit mt-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div data-preview-wrap class="society-image-block">
                                    <p class="font-medium mb-4 text-green-600 dark:text-gray-200">Upload your main property image here</p>

                                    <div class="preview-box relative w-full h-60 overflow-hidden rounded-md border border-dashed border-gray-300 bg-gray-50 dark:bg-slate-800 flex items-center justify-center">
                                        <span class="text-xs text-gray-500 dark:text-slate-300 text-center px-4">
                                            Supports JPG, PNG, WEBP. Max file size: 10MB.
                                        </span>
                                    </div>

                                    <input type="file" id="society_image" name="society_image" accept="image/png,image/jpeg,image/webp" hidden>
                                    <label for="society_image" class="bg-green-600 hover:bg-green-700 text-white rounded-md mt-4 px-4 py-2 inline-block cursor-pointer">
                                        Upload
                                    </label>
                                </div>

                                <div data-preview-wrap class="society-image-block">
                                    <p class="font-medium mb-4 text-green-600 dark:text-gray-200">Upload your banner property image here</p>

                                    <div class="preview-box relative w-full h-60 overflow-hidden rounded-md border border-dashed border-gray-300 bg-gray-50 dark:bg-slate-800 flex items-center justify-center">
                                        <span class="text-xs text-gray-500 dark:text-slate-300 text-center px-4">
                                            Supports JPG, PNG, WEBP. Max file size: 10MB.
                                        </span>
                                    </div>

                                    <input type="file" id="banner" name="banner" accept="image/png,image/jpeg,image/webp" hidden>
                                    <label for="banner" class="bg-green-600 hover:bg-green-700 text-white rounded-md mt-4 px-4 py-2 inline-block cursor-pointer">
                                        Upload
                                    </label>
                                </div>

                            </div>
                        </div>

                        {{-- STATUS (UNCHANGED DESIGN) --}}
                        <div class="mb-6 mt-6" x-data="{ enabled: true }">
                            <label class="block text-green-600 dark:text-gray-200 font-medium mb-2">Status</label>
                            <label class="flex items-center space-x-3 cursor-pointer select-none">
                                <div
                                    :class="enabled ? 'bg-green-600' : 'bg-gray-300'"
                                    class="relative inline-block w-11 h-6 rounded-full transition-colors duration-300"
                                    @click="enabled = !enabled"
                                >
                                    <span
                                        :class="enabled ? 'translate-x-5' : 'translate-x-0'"
                                        class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-300"
                                    ></span>
                                </div>

                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="enabled ? 'Enabled' : 'Disabled'"></span>
                                <input type="hidden" name="status" :value="enabled ? 'enabled' : 'disabled'">
                            </label>
                        </div>

                        {{-- PROPERTY TYPES + QUILL ABOUT + AI BUTTONS (design untouched) --}}
                        <div x-data="{ types: {
                            residential_plots: false,
                            commercial_plots: false,
                            houses: false,
                            apartments: false,
                            farm_houses: false,
                            shop: false
                        }}">

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                                @foreach(['residential_plots', 'commercial_plots', 'houses', 'apartments', 'farm_houses', 'shop'] as $type)
                                    <label class="flex items-center space-x-3 cursor-pointer select-none">
                                        <div
                                            :class="types['{{ $type }}'] ? 'bg-blue-600' : 'bg-gray-200'"
                                            class="relative inline-block w-11 h-6 rounded-full transition-colors duration-300"
                                            @click="types['{{ $type }}'] = !types['{{ $type }}']"
                                        >
                                            <span
                                                :class="types['{{ $type }}'] ? 'translate-x-5' : 'translate-x-0'"
                                                class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-300"
                                            ></span>
                                        </div>

                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ ucwords(str_replace('_', ' ', $type)) }}
                                        </span>

                                        <input type="hidden" :name="'has_{{ $type }}'" :value="types['{{ $type }}'] ? 1 : 0">
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-8 mb-4">
                                <div class="block font-bold text-center text-red-500 text-sm mb-2">
                                    ************* Select Properties Types Which Exist In This Society *************
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach(['residential_plots', 'commercial_plots', 'houses', 'apartments', 'farm_houses', 'shop'] as $type)
                                        <div
                                            x-show="types['{{ $type }}']"
                                            x-effect="if (types['{{ $type }}']) { $nextTick(() => window.QuillManager?.initOnce('{{ $type }}_about')) }"
                                            class="border border-green-400 rounded-lg p-4"
                                            x-cloak
                                        >
                                            <h4 class="text-green-600 font-semibold mb-2">
                                                {{ ucwords(str_replace('_', ' ', $type)) }} Page
                                            </h4>

                                            <div class="mb-2">
                                                <label class="text-sm block mb-1 text-green-600 dark:text-gray-200">Title</label>
                                                <input type="text" name="{{ $type }}_title" class="w-full border px-3 py-2 rounded">
                                            </div>

                                            <div class="mb-3">
                                                <label class="text-sm block mb-1 text-green-600 dark:text-gray-200">Meta Description</label>
                                                <textarea name="{{ $type }}_description" rows="2" class="w-full border px-3 py-2 rounded"></textarea>
                                            </div>

                                            <div class="mb-2 flex items-center justify-between">
                                                <label class="text-sm font-medium text-green-600 dark:text-gray-200">
                                                    About {{ ucwords(str_replace('_', ' ', $type)) }}
                                                </label>

                                                {{-- AI buttons (WORKING via quill-manager.js) --}}
                                                <div class="flex items-center gap-1">
                                                    <button type="button"
                                                            class="inline-flex items-center justify-center h-7 px-2 rounded bg-indigo-600 text-white hover:bg-indigo-700 text-xs"
                                                            data-ai-action="rewrite"
                                                            data-ai-type="{{ $type }}"
                                                            title="Rewrite">R</button>

                                                    <button type="button"
                                                            class="inline-flex items-center justify-center h-7 px-2 rounded bg-indigo-600 text-white hover:bg-indigo-700 text-xs"
                                                            data-ai-action="expand"
                                                            data-ai-type="{{ $type }}"
                                                            title="Expand">+</button>

                                                    <button type="button"
                                                            class="inline-flex items-center justify-center h-7 px-2 rounded bg-indigo-600 text-white hover:bg-indigo-700 text-xs"
                                                            data-ai-action="shorten"
                                                            data-ai-type="{{ $type }}"
                                                            title="Shorten">-</button>
                                                </div>
                                            </div>

                                            {{-- Quill about (NO design change) --}}
                                            <x-admin.quill
                                                uid="{{ $type }}_about"
                                                name="{{ $type }}_about"
                                                placeholder="Write detailed content..."
                                            />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- SUB SECTORS (dynamic Quill without breaking Alpine) --}}
                        <div class="mb-6"
                             x-data="{
                                hasSubSectors: false,
                                subSectors: [{ uid: crypto.randomUUID() }]
                             }"
                             x-effect="if (hasSubSectors) { $nextTick(() => window.QuillManager?.initWithin($el)) }"
                        >
                            <label class="block text-green-600 dark:text-gray-200 font-medium mb-2">Society Has Sub Sectors:</label>

                            <label class="flex items-center space-x-3 cursor-pointer select-none">
                                <div
                                    :class="hasSubSectors ? 'bg-green-600' : 'bg-gray-300'"
                                    class="relative inline-block w-11 h-6 rounded-full transition-colors duration-300"
                                    @click="hasSubSectors = !hasSubSectors"
                                >
                                    <span
                                        :class="hasSubSectors ? 'translate-x-5' : 'translate-x-0'"
                                        class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-300"
                                    ></span>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="hasSubSectors ? 'YES' : 'NO'"></span>
                                <input type="hidden" name="has_sub_sectors" :value="hasSubSectors ? 'Y' : 'N'">
                            </label>

                            <div class="mt-6" x-show="hasSubSectors" x-cloak>
                                <div class="border border-blue-400 rounded-md p-4">
                                    <div class="text-center block font-semibold text-pink-500 mb-4">
                                        Fill Out Following Fields To Enter The Block / Sector / Zone / Phase
                                    </div>

                                    <template x-for="(row, index) in subSectors" :key="row.uid">
                                        <div class="mb-6 border border-gray-200 p-4 rounded bg-white shadow-sm">

                                            <div class="flex justify-end mb-2" x-show="index > 0">
                                                <button type="button"
                                                        @click="
                                                            subSectors.splice(index, 1);
                                                            $nextTick(() => window.QuillManager?.initWithin($root));
                                                        "
                                                        class="text-red-600 hover:text-red-800"
                                                >
                                                    Remove
                                                </button>
                                            </div>

                                            <input type="text"
                                                   class="w-full border px-3 py-2 rounded mb-3"
                                                   :name="`sub_sectors[${index}][name]`"
                                                   placeholder="Sub Sector Name">

                                            {{-- Dynamic Quill markup (Alpine controls ids) --}}
                                            <div class="mt-3"
                                                 data-quill-wrap
                                                 :data-quill-uid="`sub_${row.uid}_detail`"
                                                 data-quill-placeholder="Describe sub sector..."
                                            >
                                                <div
                                                    class="border border-gray-300 rounded-t bg-gray-50 px-2 py-1 flex items-center gap-1"
                                                    :id="`toolbar_sub_${row.uid}_detail`"
                                                >
                                                    <button type="button" class="ql-bold"></button>
                                                    <button type="button" class="ql-italic"></button>
                                                    <button type="button" class="ql-underline"></button>
                                                    <button type="button" class="ql-link"></button>
                                                    <button type="button" class="ql-list" value="ordered"></button>
                                                    <button type="button" class="ql-list" value="bullet"></button>
                                                    <button type="button" class="ql-clean"></button>
                                                </div>

                                                <div
                                                    class="border border-t-0 border-gray-300 rounded-b min-h-[200px] max-h-[420px] overflow-y-auto bg-white"
                                                    :id="`editor_sub_${row.uid}_detail`"
                                                ></div>

                                                <input type="hidden"
                                                       :id="`sub_${row.uid}_detail`"
                                                       :name="`sub_sectors[${index}][detail]`">
                                            </div>

                                            <div class="mt-3" data-preview-wrap>
                                                <label class="block text-sm text-green-600 mb-1">Sub Image</label>
                                                <div class="preview-box relative w-full h-36 overflow-hidden rounded-md border border-dashed border-gray-300 bg-gray-100 flex items-center justify-center text-gray-500 text-sm">
                                                    Image preview here
                                                </div>

                                                <input type="file"
                                                       :id="`sub_image_${row.uid}`"
                                                       :name="`sub_sectors[${index}][image]`"
                                                       accept="image/png,image/jpeg,image/webp"
                                                       hidden>

                                                <label :for="`sub_image_${row.uid}`"
                                                       class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded cursor-pointer mt-2">
                                                    Upload Image
                                                </label>
                                            </div>

                                            <select :name="`sub_sectors[${index}][block]`" class="w-full border px-3 py-2 rounded mt-3">
                                                <option value="Block">Block</option>
                                                <option value="Sector">Sector</option>
                                                <option value="Zone">Zone</option>
                                                <option value="Phase">Phase</option>
                                            </select>

                                        </div>
                                    </template>

                                    <div class="flex justify-end mt-4">
                                        <button
                                            type="button"
                                            @click="
                                                subSectors.push({ uid: crypto.randomUUID() });
                                                $nextTick(() => window.QuillManager?.initWithin($el));
                                            "
                                            class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                                        >
                                            Add Sub Sector
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white rounded-md mt-5 px-6 py-2">
                                Save Society
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            'use strict';

            // 1) Init all Quill on page load (DOES NOT change design)
            document.addEventListener('DOMContentLoaded', () => {
                window.QuillManager?.initWithin(document);
            });

            // 2) Society Name -> Slug (non-destructive)
            document.addEventListener('DOMContentLoaded', () => {
                const name = document.getElementById('name');
                const slug = document.getElementById('slug');
                if (!name || !slug) return;

                let manual = false;
                slug.addEventListener('input', () => { manual = true; });

                name.addEventListener('input', () => {
                    if (manual) return;
                    slug.value = (name.value || '')
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .trim()
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                });
            });

            // 3) File preview (stable, no overflow)
            document.addEventListener('change', (e) => {
                const input = e.target;
                if (!input || input.type !== 'file') return;

                const file = input.files && input.files[0] ? input.files[0] : null;
                if (!file || !file.type || !file.type.startsWith('image/')) return;

                const wrap = input.closest('[data-preview-wrap]');
                if (!wrap) return;

                const preview = wrap.querySelector('.preview-box');
                if (!preview) return;

                const r = new FileReader();
                r.onload = () => {
                    preview.innerHTML = `<img src="${r.result}" class="w-full h-full object-cover" alt="Preview">`;
                };
                r.readAsDataURL(file);
            });

            // 4) Axios submit
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.getElementById('createSocietyForm');
                if (!form) return;

                form.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    try {
                        const fd = new FormData(form);

                        await axios.post('{{ route("admin.societies.store") }}', fd, {
                            headers: { 'Content-Type': 'multipart/form-data' }
                        });

                        window.showToast?.('Society saved successfully', 'success');
                    } catch (err) {
                        // eslint-disable-next-line no-console
                        console.error(err);
                        window.showToast?.(err?.response?.data?.message || 'Failed to save society', 'error');
                    }
                });
            });
        })();
    </script>
    <script>
        (() => {
            'use strict';

            /**
             * AI → Quill bridge
             * - Uses existing buttons
             * - Uses existing QuillManager
             * - Uses existing controller
             * - ZERO UI changes
             */

            document.addEventListener('click', async (e) => {
                const btn = e.target.closest('[data-ai-action]');
                if (!btn) return;

                const action = btn.getAttribute('data-ai-action'); // rewrite | expand | shorten
                const type   = btn.getAttribute('data-ai-type');   // residential_plots etc
                if (!action || !type) return;

                const uid = `${type}_about`;
                const quill = window.QuillManager?.editors?.[uid];

                if (!quill) {
                    window.showToast?.('Editor not ready yet', 'warning');
                    return;
                }

                const selection = quill.getSelection();
                const hasSelection = selection && selection.length > 0;

                const text = hasSelection
                    ? quill.getText(selection.index, selection.length).trim()
                    : quill.getText().trim();

                if (!text) {
                    window.showToast?.('Write something first', 'warning');
                    return;
                }

                btn.disabled = true;

                try {
                    window.showToast?.('AI is working…', 'info');

                    const res = await axios.post(
                        '{{ route("admin.ai.editor.transform") }}',
                        {
                            entity: 'society',
                            type,
                            action,
                            text
                        }
                    );

                    const html = res?.data?.html;
                    if (!html) throw new Error('Empty AI response');

                    if (hasSelection) {
                        quill.deleteText(selection.index, selection.length, 'user');
                        quill.clipboard.dangerouslyPasteHTML(selection.index, html, 'user');
                    } else {
                        quill.setText('');
                        quill.clipboard.dangerouslyPasteHTML(0, html, 'user');
                    }

                    // sync hidden input
                    const hidden = document.getElementById(uid);
                    if (hidden) hidden.value = quill.root.innerHTML;

                    window.showToast?.('AI applied', 'success');
                } catch (err) {
                    console.error(err);
                    window.showToast?.('AI failed', 'error');
                } finally {
                    btn.disabled = false;
                }
            });
        })();
    </script>
    <script>
        (() => {
            'use strict';

            document.addEventListener('DOMContentLoaded', () => {

                if (!window.QuillManager) {
                    console.warn('QuillManager still not ready');
                    return;
                }

                document.addEventListener('click', async (e) => {
                    const btn = e.target.closest('[data-ai-action]');
                    if (!btn) return;

                    const action = btn.dataset.aiAction;
                    const type   = btn.dataset.aiType;

                    console.log('AI CLICK', action, type); // ✅ DEBUG LINE

                    const editorKey = `${type}_about`;
                    const quill = window.QuillManager.editors?.[editorKey];

                    if (!quill) {
                        window.showToast?.('Editor not found', 'warning');
                        return;
                    }

                    const selection = quill.getSelection();
                    const sourceText = selection && selection.length
                        ? quill.getText(selection.index, selection.length).trim()
                        : quill.getText().trim();

                    if (!sourceText) {
                        window.showToast?.('Write something first', 'warning');
                        return;
                    }

                    window.showToast?.('AI working…', 'info');

                    const res = await axios.post(
                        '{{ route("admin.ai.editor.transform") }}',
                        {
                            entity: 'society',
                            type,
                            action,
                            text: sourceText
                        }
                    );

                    const html = res?.data?.html;
                    if (!html) throw new Error('Empty AI response');

                    quill.setContents([], 'silent');
                    quill.clipboard.dangerouslyPasteHTML(0, html);

                    document.querySelector(`input[name="${editorKey}"]`).value =
                        quill.root.innerHTML;

                    window.showToast?.('AI done ✅', 'success');
                });
            });
        })();
    </script>

@endpush
