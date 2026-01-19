@extends('admin.layouts.app')

@section('title', 'Add Society - Advice Associates')

@section('content')
    <div class="container-fluid px-3">
        <div class="layout-specing">

            {{-- Header --}}
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Create Society</h5>

                <ul class="tracking-[0.5px] inline-block mt-3 md:mt-0">
                    <li class="inline-block text-[16px] font-medium hover:text-green-600">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="inline-block mx-1">
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li class="inline-block text-[16px] font-medium text-green-600">
                        Create Society
                    </li>
                </ul>
            </div>

            {{-- Form --}}
            <div class="grid grid-cols-1 mt-6">
                <div class="bg-white dark:bg-slate-900 rounded-md shadow-sm p-6">

                    <form id="createSocietyForm" enctype="multipart/form-data">
                        @csrf

                        {{-- BASIC INFO --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label class="block font-medium text-green-600 mb-1">Society Name</label>
                                <input id="name" name="name" type="text" required
                                       class="w-full border rounded px-3 py-2">
                            </div>

                            <div>
                                <label class="block font-medium text-green-600 mb-1">Slug</label>
                                <input id="slug" name="slug" type="text" required
                                       class="w-full border rounded px-3 py-2">
                            </div>

                            <div>
                                <label class="block font-medium text-green-600 mb-1">City</label>
                                <select name="city_id" class="w-full border rounded px-3 py-2" required>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-green-600 mb-1">Assigned User</label>
                                <select name="user_id" class="w-full border rounded px-3 py-2" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        {{-- TEXT --}}
                        <div class="mt-4">
                            <label class="block font-medium text-green-600 mb-1">Overview</label>
                            <textarea name="overview" rows="3"
                                      class="w-full border rounded px-3 py-2"></textarea>
                        </div>

                        <div class="mt-4">
                            <label class="block font-medium text-green-600 mb-1">Detail</label>
                            <textarea name="detail" rows="4"
                                      class="w-full border rounded px-3 py-2"></textarea>
                        </div>

                        {{-- IMAGES --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                            @foreach(['society_image' => 'Main Image', 'banner' => 'Banner Image'] as $field => $label)
                                <div data-preview-wrap>
                                    <label class="block font-medium text-green-600 mb-2">{{ $label }}</label>

                                    <div class="preview-box h-56 border border-dashed rounded flex items-center justify-center text-sm text-gray-400">
                                        JPG / PNG / WEBP (10MB)
                                    </div>

                                    <input type="file" id="{{ $field }}" name="{{ $field }}"
                                           accept="image/*" hidden>

                                    <label for="{{ $field }}"
                                           class="inline-block mt-3 bg-green-600 text-white px-4 py-2 rounded cursor-pointer">
                                        Upload
                                    </label>
                                </div>
                            @endforeach

                        </div>

                        {{-- STATUS --}}
                        <div class="mt-6" x-data="{ enabled: true }">
                            <label class="block font-medium text-green-600 mb-2">Status</label>

                            <div class="flex items-center gap-3 cursor-pointer select-none"
                                 @click="enabled = !enabled">

                                <div :class="enabled ? 'bg-green-600' : 'bg-gray-300'"
                                     class="w-11 h-6 rounded-full relative transition">
                                <span :class="enabled ? 'translate-x-5' : ''"
                                      class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full transition"></span>
                                </div>

                                <span x-text="enabled ? 'Enabled' : 'Disabled'"></span>
                                <input type="hidden" name="status" :value="enabled ? 'enabled' : 'disabled'">
                            </div>
                        </div>

                        {{-- PROPERTY TYPES --}}
                        <div class="mt-8"
                             x-data="{ types: { residential_plots:false, commercial_plots:false, houses:false, apartments:false, farm_houses:false, shop:false } }">

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach(['residential_plots','commercial_plots','houses','apartments','farm_houses','shop'] as $type)
                                    <label class="flex items-center gap-2 cursor-pointer select-none">
                                        <input type="checkbox" x-model="types.{{ $type }}" class="hidden">
                                        <div :class="types.{{ $type }} ? 'bg-blue-600' : 'bg-gray-300'"
                                             class="w-10 h-5 rounded-full relative">
                                        <span :class="types.{{ $type }} ? 'translate-x-5' : ''"
                                              class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full transition"></span>
                                        </div>
                                        <span>{{ ucwords(str_replace('_',' ',$type)) }}</span>
                                        <input type="hidden" :name="'has_{{ $type }}'" :value="types.{{ $type }} ? 1 : 0">
                                    </label>
                                @endforeach
                            </div>

                            {{-- PROPERTY EDITORS --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                                @foreach(['residential_plots','commercial_plots','houses','apartments','farm_houses','shop'] as $type)
                                    <div x-show="types.{{ $type }}" x-cloak class="border border-green-400 rounded p-4">

                                        <h4 class="text-green-600 font-semibold mb-3">
                                            {{ ucwords(str_replace('_',' ',$type)) }} Page
                                        </h4>

                                        <input type="text"
                                               name="{{ $type }}_title"
                                               placeholder="Title"
                                               class="w-full border rounded px-3 py-2 mb-3">

                                        <textarea name="{{ $type }}_description"
                                                  rows="2"
                                                  placeholder="Meta Description"
                                                  class="w-full border rounded px-3 py-2 mb-3"></textarea>

                                        <x-admin.quill
                                            uid="{{ $type }}_about"
                                            name="{{ $type }}_about"
                                            placeholder="Write detailed content..."
                                            :ai="true"
                                            aiType="{{ $type }}"
                                        />
                                    </div>
                                @endforeach
                            </div>

                        </div>

                        {{-- SUB SECTORS --}}
                        <div class="mt-10"
                             x-data="{ has:false, rows:[{uid: crypto.randomUUID()}] }">

                            <label class="block font-medium text-green-600 mb-2">
                                Society Has Sub Sectors
                            </label>

                            <button type="button"
                                    @click="has = !has"
                                    class="mb-4 bg-green-600 text-white px-4 py-2 rounded">
                                Toggle
                            </button>

                            <div x-show="has" x-cloak>

                                <template x-for="(row,i) in rows" :key="row.uid">
                                    <div class="border rounded p-4 mb-4">

                                        <input type="text"
                                               :name="`sub_sectors[${i}][name]`"
                                               placeholder="Sub Sector Name"
                                               class="w-full border rounded px-3 py-2 mb-3">

                                        <x-admin::quill
                                            :uid="`sub_${row.uid}_detail`"
                                            :name="`sub_sectors[${i}][detail]`"
                                            placeholder="Describe sub sector..."
                                        />

                                        <button type="button"
                                                @click="rows.splice(i,1)"
                                                class="mt-3 text-red-600">
                                            Remove
                                        </button>
                                    </div>
                                </template>

                                <button type="button"
                                        @click="rows.push({uid: crypto.randomUUID()})"
                                        class="bg-green-600 text-white px-4 py-2 rounded">
                                    Add Sub Sector
                                </button>

                            </div>
                        </div>

                        {{-- SUBMIT --}}
                        <div class="flex justify-end mt-8">
                            <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
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
        document.addEventListener('DOMContentLoaded', () => {
            window.QuillManager?.initWithin(document);

            const name = document.getElementById('name');
            const slug = document.getElementById('slug');
            let manual = false;

            slug?.addEventListener('input', () => manual = true);
            name?.addEventListener('input', () => {
                if (!manual) slug.value = name.value
                    .toLowerCase().replace(/[^a-z0-9\s-]/g,'')
                    .trim().replace(/\s+/g,'-').replace(/-+/g,'-');
            });

            document.addEventListener('change', e => {
                const input = e.target;
                if (input?.type !== 'file') return;

                const wrap = input.closest('[data-preview-wrap]');
                const box = wrap?.querySelector('.preview-box');
                if (!box) return;

                const f = input.files[0];
                if (!f?.type.startsWith('image/')) return;

                const r = new FileReader();
                r.onload = () => box.innerHTML = `<img src="${r.result}" class="w-full h-full object-cover">`;
                r.readAsDataURL(f);
            });
        });
    </script>
@endpush
