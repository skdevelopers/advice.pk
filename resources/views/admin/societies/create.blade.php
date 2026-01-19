@extends('admin.layouts.app')

@section('title', 'Add Society - Advice Associates Real Estate Dashboard')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">

            <!-- Page Header -->
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Create Society</h5>

                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white-100/70 hover:text-green-600 dark:hover:text-white">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="inline-block text-base text-slate-950 dark:text-white-100/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white" aria-current="page">Starter Page</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="grid grid-cols-1 mt-6">
                <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900">

                    <form id="createSocietyForm" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-green-600 dark:text-gray-200 font-medium mb-2">Society Name</label>
                            <input type="text" name="name" id="name" class="w-full border px-3 py-2 rounded" required>
                        </div>

                        <div class="mb-4">
                            <label for="slug" class="block text-green-600 dark:text-gray-200 font-medium mb-2">Slug</label>
                            <input type="text" name="slug" id="slug" class="w-full border px-3 py-2 rounded" required>
                        </div>

                        <div class="mb-4">
                            <label for="city_id" class="block text-green-600 dark:text-gray-200 font-medium mb-2">City</label>
                            <select name="city_id" id="city_id" class="w-full border px-3 py-2 rounded" required>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="user_id" class="block text-green-600 dark:text-gray-200 font-medium mb-2">Assigned User</label>
                            <select name="user_id" id="user_id" class="w-full border px-3 py-2 rounded" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="overview" class="block text-green-600 dark:text-gray-200 font-medium mb-2">Overview</label>
                            <textarea name="overview" id="overview" rows="3" class="w-full border px-3 py-2 rounded"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="detail" class="block text-green-600 dark:text-gray-200 font-medium mb-2">Detail</label>
                            <textarea name="detail" id="detail" rows="4" class="w-full border px-3 py-2 rounded"></textarea>
                        </div>

                        <!-- Images -->
                        <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900 h-fit mt-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- MAIN IMAGE --}}
                                <div data-preview-wrap class="society-image-block">
                                    <p class="font-medium mb-4 text-green-600 dark:text-gray-200">Upload your main property image here</p>

                                    <div class="preview-box relative w-full h-60 overflow-hidden rounded-md border border-dashed border-gray-300 bg-gray-50 dark:bg-slate-800 flex items-center justify-center">
                                        <span class="text-xs text-gray-500 dark:text-slate-300 text-center px-4">
                                            Supports JPG, PNG, WEBP. Max file size: 10MB.
                                        </span>
                                    </div>

                                    <input type="file" id="society_image" name="society_image" accept="image/png,image/jpeg,image/webp" hidden>
                                    <label for="society_image"
                                           class="bg-green-600 hover:bg-green-700 text-white rounded-md mt-4 px-4 py-2 inline-block cursor-pointer">
                                        Upload Image
                                    </label>
                                </div>

                                {{-- BANNER IMAGE --}}
                                <div data-preview-wrap class="society-image-block">
                                    <p class="font-medium mb-4 text-green-600 dark:text-gray-200">Upload your banner property image here</p>

                                    <div class="preview-box relative w-full h-60 overflow-hidden rounded-md border border-dashed border-gray-300 bg-gray-50 dark:bg-slate-800 flex items-center justify-center">
                                        <span class="text-xs text-gray-500 dark:text-slate-300 text-center px-4">
                                            Supports JPG, PNG, WEBP. Max file size: 10MB.
                                        </span>
                                    </div>

                                    <input type="file" id="banner" name="banner" accept="image/png,image/jpeg,image/webp" hidden>
                                    <label for="banner"
                                           class="bg-green-600 hover:bg-green-700 text-white rounded-md mt-4 px-4 py-2 inline-block cursor-pointer">
                                        Upload Image
                                    </label>
                                </div>

                            </div>
                        </div>

                        <!-- Status Toggle -->
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

                        <!-- Property Type Toggles + Sections -->
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
                                            x-effect="if (types['{{ $type }}']) { $nextTick(() => window.initPropertyEditor('{{ $type }}')) }"
                                            id="section_{{ $type }}"
                                            class="border border-green-400 rounded-lg p-4"
                                            x-cloak
                                        >
                                            <h4 class="text-green-600 font-semibold mb-2">
                                                {{ ucwords(str_replace('_', ' ', $type)) }} Page
                                            </h4>

                                            <div class="mb-2">
                                                <label class="text-sm block mb-1 text-green-600 dark:text-gray-200">Title</label>
                                                <input type="text" name="{{ $type }}_title" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>

                                            <div class="mb-3">
                                                <label class="text-sm block mb-1 text-green-600 dark:text-gray-200">Meta Description</label>
                                                <textarea name="{{ $type }}_description" rows="2" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                            </div>

                                            <div class="mb-4">
                                                <label class="text-sm block mb-1 font-medium text-green-600 dark:text-gray-200">
                                                    About {{ ucwords(str_replace('_', ' ', $type)) }}
                                                </label>

                                                <div id="toolbar_{{ $type }}"
                                                     class="border border-gray-300 rounded-t bg-gray-50 px-2 py-1 sticky top-0 z-10 flex items-center gap-1">
                                                    <button type="button" class="ql-bold"></button>
                                                    <button type="button" class="ql-italic"></button>
                                                    <button type="button" class="ql-underline"></button>
                                                    <button type="button" class="ql-link"></button>
                                                    <button type="button" class="ql-list" value="ordered"></button>
                                                    <button type="button" class="ql-list" value="bullet"></button>
                                                    <button type="button" class="ql-clean"></button>

                                                    <!-- AI Action buttons -->
                                                    <div class="ml-auto flex items-center gap-1">
                                                        <button type="button"
                                                                class="inline-flex items-center justify-center h-7 px-2 rounded bg-indigo-600 text-white hover:bg-indigo-700 text-xs"
                                                                title="Rewrite"
                                                                @click="window.aiTransform('{{ $type }}', 'rewrite')">
                                                            R
                                                        </button>
                                                        <button type="button"
                                                                class="inline-flex items-center justify-center h-7 px-2 rounded bg-indigo-600 text-white hover:bg-indigo-700 text-xs"
                                                                title="Expand"
                                                                @click="window.aiTransform('{{ $type }}', 'expand')">
                                                            +
                                                        </button>
                                                        <button type="button"
                                                                class="inline-flex items-center justify-center h-7 px-2 rounded bg-indigo-600 text-white hover:bg-indigo-700 text-xs"
                                                                title="Shorten"
                                                                @click="window.aiTransform('{{ $type }}', 'shorten')">
                                                            -
                                                        </button>
                                                    </div>
                                                </div>

                                                <div id="editor_{{ $type }}" class="border border-t-0 border-gray-300 rounded-b min-h-[220px] max-h-[420px] overflow-y-auto bg-white"></div>
                                                <input type="hidden" name="{{ $type }}_about" id="{{ $type }}_about">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Sub-Sectors -->
                        <div class="mb-6"
                             x-data="{
                                hasSubSectors: false,
                                subSectors: [{ title: '', slug: '' }]
                             }"
                             x-effect="if (hasSubSectors) { $nextTick(() => { feather.replace(); window.reInitAllSubEditors(subSectors.length); }) }"
                        >
                            <label class="block text-green-600 dark:text-gray-200 font-medium mb-2">Society Has Sub Societies:</label>

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

                                    <template x-for="(subSector, index) in subSectors" :key="index">
                                        <div class="mb-6 border border-gray-200 p-4 rounded bg-white shadow-sm">

                                            <div class="flex justify-end mb-2" x-show="index > 0">
                                                <button type="button"
                                                        @click="
                                                            window.removeSubEditor(index);
                                                            subSectors.splice(index, 1);
                                                            $nextTick(() => {
                                                                feather.replace();
                                                                window.reInitAllSubEditors(subSectors.length);
                                                            });
                                                        "
                                                        class="text-red-600 hover:text-red-800"
                                                >
                                                    <i data-feather="x-circle" class="w-5 h-5"></i>
                                                </button>
                                            </div>

                                            <div class="grid grid-cols-1 gap-3">

                                                <input type="text" class="w-full border px-3 py-2 rounded" :name="`sub_sectors[${index}][name]`" placeholder="Sub Sector Name">

                                                <input type="text"
                                                       class="w-full border px-3 py-2 rounded"
                                                       :name="`sub_sectors[${index}][title]`"
                                                       placeholder="Title"
                                                       x-model="subSector.title"
                                                       @input="subSector.slug = (subSector.title || '').toLowerCase().replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-').replace(/-+/g, '-')">

                                                <input type="text"
                                                       class="w-full border px-3 py-2 rounded"
                                                       :name="`sub_sectors[${index}][slug]`"
                                                       placeholder="Slug (auto-generated)"
                                                       x-model="subSector.slug">

                                                <div class="mt-3">
                                                    <label class="block text-sm font-medium text-green-600 mb-1">Sub Description</label>

                                                    <!-- IMPORTANT: toolbar must NOT be x-ignore -->
                                                    <div :id="`sub_toolbar_${index}`"
                                                         class="border border-gray-300 rounded-t bg-gray-50 px-2 py-1 sticky top-0 z-10">
                                                        <button type="button" class="ql-bold"></button>
                                                        <button type="button" class="ql-italic"></button>
                                                        <button type="button" class="ql-underline"></button>
                                                        <button type="button" class="ql-link"></button>
                                                        <button type="button" class="ql-list" value="ordered"></button>
                                                        <button type="button" class="ql-list" value="bullet"></button>
                                                        <button type="button" class="ql-clean"></button>
                                                    </div>

                                                    <!-- editor must be x-ignore -->
                                                    <div x-ignore>
                                                        <div :id="`sub_editor_${index}`"
                                                             class="border border-t-0 border-gray-300 rounded-b min-h-[200px] max-h-[420px] overflow-y-auto bg-white">
                                                        </div>
                                                    </div>

                                                    <input type="hidden" :name="`sub_sectors[${index}][detail]`" :id="`sub_detail_${index}`">
                                                </div>

                                                <div class="mt-3" data-preview-wrap>
                                                    <label class="block text-sm text-green-600 mb-1">Sub Image</label>

                                                    <div class="preview-box relative w-full h-36 overflow-hidden rounded-md border border-dashed border-gray-300 bg-gray-100 flex items-center justify-center text-gray-500 text-sm">
                                                        Image preview here
                                                    </div>

                                                    <input type="file"
                                                           :id="`sub_image_${index}`"
                                                           :name="`sub_sectors[${index}][image]`"
                                                           accept="image/png,image/jpeg,image/webp"
                                                           hidden>

                                                    <label :for="`sub_image_${index}`"
                                                           class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded cursor-pointer mt-2">
                                                        Upload Image
                                                    </label>
                                                </div>

                                                <select :name="`sub_sectors[${index}][block]`" class="w-full border px-3 py-2 rounded">
                                                    <option value="Block">Block</option>
                                                    <option value="Sector">Sector</option>
                                                    <option value="Zone">Zone</option>
                                                    <option value="Phase">Phase</option>
                                                </select>

                                            </div>
                                        </div>
                                    </template>

                                    <div class="flex justify-end mt-4">
                                        <button
                                            type="button"
                                            @click="
                                                subSectors.push({ title: '', slug: '' });
                                                $nextTick(() => {
                                                    feather.replace();
                                                    window.initSubSectorEditor(subSectors.length - 1);
                                                });
                                            "
                                            class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                                        >
                                            <i data-feather="plus-circle" class="w-5 h-5"></i>
                                            <span>Add Sub Sector</span>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white rounded-md mt-5 px-6 py-2">
                                Add Society
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
        /**
         * Create Society Script
         * - Tailwind only
         * - Fix: preview overflow
         * - Fix: Alpine :id works (no x-ignore on toolbar)
         * - Quill init on show
         * - AI rewrite/expand/shorten (selection-aware)
         */
        (() => {
            'use strict';

            const toast = (message, type = 'info') => {
                if (typeof window.showToast === 'function') {
                    window.showToast(message, type);
                    return;
                }
                window.dispatchEvent(new CustomEvent('toast', { detail: { message, type } }));
            };

            const slugify = (value) => (value || '')
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');

            // 1) File preview (stable: find nearest [data-preview-wrap])
            document.addEventListener('change', (e) => {
                const input = e.target;
                if (!input || input.type !== 'file') return;

                const file = input.files && input.files[0] ? input.files[0] : null;
                if (!file) return;
                if (!file.type || !file.type.startsWith('image/')) return;

                const wrap = input.closest('[data-preview-wrap]') || input.closest('.society-image-block');
                if (!wrap) return;

                const preview = wrap.querySelector('.preview-box');
                if (!preview) return;

                const reader = new FileReader();
                reader.onload = () => {
                    preview.innerHTML = `
                        <img
                            src="${reader.result}"
                            alt="Preview"
                            class="w-full h-full object-cover"
                        />
                    `;
                };
                reader.readAsDataURL(file);
            });

            // 2) Slug autofill (non-destructive)
            document.addEventListener('DOMContentLoaded', () => {
                const name = document.getElementById('name');
                const slug = document.getElementById('slug');
                if (!name || !slug) return;

                let manual = false;
                slug.addEventListener('input', () => { manual = true; });

                name.addEventListener('input', () => {
                    if (manual) return;
                    slug.value = slugify(name.value);
                });
            });

            // 3) Submit (Axios)
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

                        toast('Society added successfully', 'success');
                        // window.location.href = '{{ route("admin.societies.index") }}';

                    } catch (err) {
                        console.error(err);
                        toast(err?.response?.data?.message || 'Failed to save society', 'error');
                    }
                });
            });

            // 4) Property editors
            const propertyEditors = {};
            window.propertyEditors = propertyEditors;

            window.initPropertyEditor = (type) => {
                if (propertyEditors[type]) return;

                const editorEl  = document.getElementById(`editor_${type}`);
                const toolbarEl = document.getElementById(`toolbar_${type}`);
                const hiddenEl  = document.getElementById(`${type}_about`);

                if (!editorEl || !toolbarEl || !hiddenEl) return;
                if (!window.Quill) return;

                propertyEditors[type] = new window.Quill(editorEl, {
                    theme: 'snow',
                    modules: { toolbar: toolbarEl },
                    placeholder: 'Write detailed about society content here...'
                });

                propertyEditors[type].on('text-change', () => {
                    hiddenEl.value = propertyEditors[type].root.innerHTML;
                });
            };

            // 5) Sub-sector editors (dynamic)
            const subEditors = {};

            window.initSubSectorEditor = (index) => {
                if (subEditors[index]) return;

                const editorEl  = document.getElementById(`sub_editor_${index}`);
                const toolbarEl = document.getElementById(`sub_toolbar_${index}`);
                const hiddenEl  = document.getElementById(`sub_detail_${index}`);

                if (!editorEl || !toolbarEl || !hiddenEl) return;
                if (!window.Quill) return;

                subEditors[index] = new window.Quill(editorEl, {
                    theme: 'snow',
                    modules: { toolbar: toolbarEl },
                    placeholder: 'Write detailed description for this sub sector...'
                });

                subEditors[index].on('text-change', () => {
                    hiddenEl.value = subEditors[index].root.innerHTML;
                });
            };

            window.removeSubEditor = (index) => {
                delete subEditors[index];
            };

            window.reInitAllSubEditors = (count) => {
                for (let i = 0; i < count; i++) {
                    window.initSubSectorEditor(i);
                }
            };

            // 6) AI Transform: rewrite / expand / shorten
            window.aiTransform = async (type, action) => {
                try {
                    const q = propertyEditors[type];
                    if (!q) {
                        toast('Editor not ready yet. Open section first.', 'warning');
                        return;
                    }

                    const selection = q.getSelection();
                    const hasSelection = selection && selection.length && selection.length > 0;

                    const sourceText = hasSelection
                        ? q.getText(selection.index, selection.length).trim()
                        : q.getText().trim();

                    if (!sourceText) {
                        toast('Write something first.', 'warning');
                        return;
                    }

                    toast('AI is working...', 'info');

                    const res = await axios.post('{{ route("admin.ai.editor.transform") }}', {
                        entity: 'society',
                        type,
                        action,
                        text: sourceText
                    });

                    const html = res?.data?.html || '';
                    if (!html) {
                        toast('AI returned empty content.', 'error');
                        return;
                    }

                    if (hasSelection) {
                        q.deleteText(selection.index, selection.length, 'user');
                        q.clipboard.dangerouslyPasteHTML(selection.index, html, 'user');
                    } else {
                        q.setText('', 'silent');
                        q.clipboard.dangerouslyPasteHTML(0, html, 'user');
                    }

                    const hiddenEl = document.getElementById(`${type}_about`);
                    if (hiddenEl) hiddenEl.value = q.root.innerHTML;

                    toast('Done ✅', 'success');

                } catch (e) {
                    console.error(e);
                    toast(e?.response?.data?.message || 'AI action failed', 'error');
                }
            };
        })();
    </script>
@endpush
