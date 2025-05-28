@extends('admin.layouts.app')

@section('title', 'Edit Society - Advice Associates Real Estate Dashboard')

@section('content')
    <div class="container-fluid px-3">
        <div class="layout-specing">

            {{-- Header & Breadcrumbs --}}
            <div class="md:flex justify-between items-center mb-6">
                <h5 class="text-lg font-semibold">Edit Society</h5>
                <ul class="inline-flex space-x-2 text-sm">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Dashboard</a></li>
                    <li><i class="mdi mdi-chevron-right text-gray-400"></i></li>
                    <li class="text-green-600">Edit Society</li>
                </ul>
            </div>

            {{-- Alpine root --}}
            <div
                    x-data="initializeSocietyEditor()"
                    class="rounded-md shadow-sm bg-white p-6 dark:bg-slate-900"
            >
                <form id="editSocietyForm" enctype="multipart/form-data">
                    @csrf

                    {{-- Name & Slug --}}
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-1 font-medium">Society Name</label>
                            <input
                                    x-model="name"
                                    @input="slug = name.toLowerCase().replace(/[^a-z0-9\s-]/g,'').trim().replace(/\s+/g,'-')"
                                    name="name"
                                    id="name"
                                    :value="name"
                                    class="w-full border px-3 py-2 rounded"
                                    required
                            >
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Slug</label>
                            <input
                                    x-model="slug"
                                    name="slug"
                                    id="slug"
                                    :value="slug"
                                    class="w-full border px-3 py-2 rounded"
                                    required
                            >
                        </div>
                    </div>

                    {{-- City & Assigned User --}}
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-1 font-medium">City</label>
                            <select
                                    x-model="city_id"
                                    name="city_id"
                                    class="w-full border px-3 py-2 rounded"
                                    required
                            >
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" @selected($society->city_id==$city->id)>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Assigned User</label>
                            <select
                                    x-model="user_id"
                                    name="user_id"
                                    class="w-full border px-3 py-2 rounded"
                                    required
                            >
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected($society->user_id==$user->id)>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Overview & Detail --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Overview</label>
                        <textarea
                                x-model="overview"
                                name="overview"
                                rows="3"
                                class="w-full border px-3 py-2 rounded"
                        >{{ $society->overview }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Detail</label>
                        <textarea
                                x-model="detail"
                                name="detail"
                                rows="4"
                                class="w-full border px-3 py-2 rounded"
                        >{{ $society->detail }}</textarea>
                    </div>

                    {{-- Society & Banner Images --}}
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        @foreach(['society_image'=>'Society','banner'=>'Banner'] as $field => $label)
                            <div>
                                <p class="font-medium mb-2">{{ $label }} Image</p>
                                <div class="preview-box h-60 bg-gray-50 dark:bg-slate-800 flex items-center justify-center rounded overflow-hidden mb-2">
                                    <template x-if="imageUrls['{{ $field }}']">
                                        <img :src="imageUrls['{{ $field }}']" class="max-h-60 object-contain">
                                    </template>
                                    <span x-show="! imageUrls['{{ $field }}']">Supports JPG, PNG, MP4 (≤10MB)</span>
                                </div>
                                <input
                                        type="file"
                                        x-ref="{{ $field }}Input"
                                        name="{{ $field }}"
                                        accept="image/*"
                                        hidden
                                        @change="previewFile($event, '{{ $field }}')"
                                >
                                <label
                                        @click="$refs.{{ $field }}Input.click()"
                                        class="btn-upload bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded cursor-pointer"
                                >Upload {{ $label }}</label>
                            </div>
                        @endforeach
                    </div>

                    {{-- Status Toggle --}}
                    <div class="mb-6">
                        <label class="block mb-1 font-medium">Status</label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <div
                                    :class="enabled ? 'bg-green-600' : 'bg-gray-300'"
                                    class="relative w-11 h-6 rounded-full transition-colors"
                                    @click="enabled = !enabled"
                            >
              <span
                      :class="enabled ? 'translate-x-5' : 'translate-x-0'"
                      class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform"
              ></span>
                            </div>
                            <span x-text="enabled ? 'Enabled' : 'Disabled'"></span>
                            <input type="hidden" name="status" :value="enabled ? 'enabled' : 'disabled'">
                        </label>
                    </div>

                    {{-- Property Types --}}
                    <div class="mb-8">
                        <label class="block mb-2 font-medium text-red-500 text-sm text-center">
                            ************* Select Property Types That Exist *************
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                            @foreach($flags as $type)
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <div
                                            :class="types['{{ $type }}'] ? 'bg-blue-600' : 'bg-gray-200'"
                                            class="relative w-11 h-6 rounded transition-colors"
                                            @click="types['{{ $type }}'] = !types['{{ $type }}']"
                                    >
                  <span
                          :class="types['{{ $type }}'] ? 'translate-x-5' : 'translate-x-0'"
                          class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded shadow transition-transform"
                  ></span>
                                    </div>
                                    <span class="capitalize">{{ str_replace('_',' ',$type) }}</span>
                                    <input
                                            type="hidden"
                                            :name="'has_{{ $type }}'"
                                            :value="types['{{ $type }}'] ? 1 : 0"
                                    >
                                </label>
                            @endforeach
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($flags as $type)
                                <div x-show="types['{{ $type }}']" x-cloak class="border border-green-400 p-4 rounded-lg">
                                    <h4 class="text-green-600 font-semibold mb-2">{{ str_replace('_',' ',$type) }} Page</h4>
                                    <label class="block text-sm mb-1">Title</label>
                                    <input
                                            type="text"
                                            name="{{ $type }}_title"
                                            :value="propertyMeta['{{ $type }}'].title"
                                            class="w-full border px-3 py-2 rounded mb-2"
                                    >
                                    <label class="block text-sm mb-1">Meta Keywords</label>
                                    <input
                                            type="text"
                                            name="{{ $type }}_keywords"
                                            :value="propertyMeta['{{ $type }}'].keywords"
                                            class="w-full border px-3 py-2 rounded mb-2"
                                    >
                                    <label class="block text-sm mb-1">Meta Description</label>
                                    <textarea
                                            name="{{ $type }}_description"
                                            rows="2"
                                            class="w-full border px-3 py-2 rounded"
                                            x-text="propertyMeta['{{ $type }}'].description"
                                    ></textarea>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Sub-Sectors Toggle & Blocks --}}
                    <div class="mb-6">
                        <label class="block mb-1 font-medium">Has Sub-Sectors?</label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <div
                                    :class="hasSubSectors ? 'bg-green-600' : 'bg-gray-300'"
                                    class="relative w-11 h-6 rounded transition-colors"
                                    @click="
                hasSubSectors = !hasSubSectors;
                if (hasSubSectors && subSectors.length === 0) {
                  subSectors.push({ id:null, name:'', title:'', slug:'', meta_keywords:'', meta_detail:'', detail:'', block:'Block', image_url:null });
                }
              "
                            >
              <span
                      :class="hasSubSectors ? 'translate-x-5' : 'translate-x-0'"
                      class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded shadow transition-transform"
              ></span>
                            </div>
                            <span x-text="hasSubSectors ? 'YES' : 'NO'"></span>
                            <input type="hidden" name="has_sub_sectors" :value="hasSubSectors ? 'Y' : 'N'">
                        </label>
                    </div>

                    <template x-if="hasSubSectors">
                        <div class="space-y-6">
                            <template x-for="(subSector, idx) in subSectors" :key="subSector.id ?? idx">
                                <div class="border p-4 rounded bg-white shadow-sm relative">
                                    <button type="button" class="absolute top-2 right-2 text-red-600" @click="subSectors.splice(idx,1)">&times;</button>
                                    <input type="hidden" :name="`sub_sectors[${idx}][id]`" x-model="subSector.id">

                                    {{-- Name & Title --}}
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-sm mb-1">Name</label>
                                            <input type="text" :name="`sub_sectors[${idx}][name]`" x-model="subSector.name" class="w-full border rounded px-3 py-2">
                                        </div>
                                        <div>
                                            <label class="block text-sm mb-1">Title</label>
                                            <input type="text" :name="`sub_sectors[${idx}][title]`" x-model="subSector.title" class="w-full border rounded px-3 py-2"
                                                   @input="subSector.slug = subSector.title.toLowerCase().replace(/[^a-z0-9\s-]/g,'').trim().replace(/\s+/g,'-')"
                                            >
                                        </div>
                                    </div>

                                    {{-- Slug / Meta / Detail / Block --}}
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <div>
                                            <label class="block text-sm mb-1">Slug</label>
                                            <input type="text" :name="`sub_sectors[${idx}][slug]`" x-model="subSector.slug" class="w-full border rounded px-3 py-2">
                                        </div>
                                        <div>
                                            <label class="block text-sm mb-1">Meta Keywords</label>
                                            <input type="text" :name="`sub_sectors[${idx}][meta_keywords]`" x-model="subSector.meta_keywords" class="w-full border rounded px-3 py-2">
                                        </div>
                                        <div>
                                            <label class="block text-sm mb-1">Meta Detail</label>
                                            <input type="text" :name="`sub_sectors[${idx}][meta_detail]`" x-model="subSector.meta_detail" class="w-full border rounded px-3 py-2">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm mb-1">Detail</label>
                                        <textarea :name="`sub_sectors[${idx}][detail]`" x-model="subSector.detail" class="w-full border rounded px-3 py-2"></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm mb-1">Block</label>
                                        <select :name="`sub_sectors[${idx}][block]`" x-model="subSector.block" class="w-full border rounded px-3 py-2">
                                            <option value="Block">Block</option>
                                            <option value="Sector">Sector</option>
                                            <option value="Zone">Zone</option>
                                            <option value="Phase">Phase</option>
                                        </select>
                                    </div>

                                    {{-- Image Preview & Upload --}}
                                    <div>
                                        <label class="block text-sm mb-1">Image</label>
                                        <div class="preview-box h-36 mb-2 bg-gray-100 flex items-center justify-center rounded">
                                            <template x-if="subSector.image_url"><img :src="subSector.image_url" class="max-h-36 object-contain"></template>
                                            <span x-show="! subSector.image_url">No image</span>
                                        </div>
                                        <input type="file" :name="`sub_sectors[${idx}][image]`" @change="previewFile($event, idx)" class="w-full">
                                    </div>
                                </div>
                            </template>

                            <div class="text-right">
                                <button type="button" class="bg-green-600 text-white px-4 py-2 rounded"
                                        @click="subSectors.push({ id:null, name:'', title:'', slug:'', meta_keywords:'', meta_detail:'', detail:'', block:'Block', image_url:null })"
                                >+ Add Sub Sector</button>
                            </div>
                        </div>
                    </template>

                    {{-- Submit --}}
                    <div class="text-right mt-6">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                            Update Society
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function initializeSocietyEditor() {
            const data = @json($jsData);
            return {
                ...data,
                previewFile(event, key) {
                    const file = event.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = () => {
                        if (typeof key === 'string') {
                            this.imageUrls[key] = reader.result;
                        } else {
                            this.subSectors[key].image_url = reader.result;
                        }
                    };
                    reader.readAsDataURL(file);
                }
            };
        }

        document.getElementById('editSocietyForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('_method', 'PUT');

            axios.post(
                "{{ route('admin.societies.update', $society->id) }}",
                formData,
                { headers: { 'Content-Type': 'multipart/form-data' } }
            )
                .then(res => {
                    window.showToast(res.data.message, 'success');
                    setTimeout(() => window.location.href = '{{ route("admin.societies.index") }}', 1200);
                })
                .catch(err => {
                    window.showToast(err.response?.data?.message || 'Error updating', 'error');
                });
        });
    </script>
@endpush

