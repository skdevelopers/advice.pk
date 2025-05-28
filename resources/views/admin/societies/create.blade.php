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
                            <label for="name" class="block text-gray-700 font-medium mb-2">Society Name</label>
                            <input type="text" name="name" id="name" class="w-full border px-3 py-2 rounded" required>
                        </div>

                        <div class="mb-4">
                            <label for="slug" class="block text-gray-700 font-medium mb-2">Slug</label>
                            <input type="text" name="slug" id="slug" class="w-full border px-3 py-2 rounded" required>
                        </div>

                        <div class="mb-4">
                            <label for="city_id" class="block text-gray-700 font-medium mb-2">City</label>
                            <select name="city_id" id="city_id" class="w-full border px-3 py-2 rounded" required>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="user_id" class="block text-gray-700 font-medium mb-2">Assigned User</label>
                            <select name="user_id" id="user_id" class="w-full border px-3 py-2 rounded" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="overview" class="block text-gray-700 font-medium mb-2">Overview</label>
                            <textarea name="overview" id="overview" rows="3" class="w-full border px-3 py-2 rounded"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="detail" class="block text-gray-700 font-medium mb-2">Detail</label>
                            <textarea name="detail" id="detail" rows="4" class="w-full border px-3 py-2 rounded"></textarea>
                        </div>

                        <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900 h-fit">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- MAIN IMAGE --}}
                                <div>
                                    <p class="font-medium mb-4">Upload your main property image here</p>
                                    <div class="preview-box flex justify-center items-center rounded-md shadow-sm dark:shadow-gray-800 overflow-hidden bg-gray-50 dark:bg-slate-800 text-slate-400 p-2 text-center w-full h-60">Supports JPG, PNG and MP4 videos. Max file size: 10MB.</div>
                                    <input type="file" id="society_image" name="society_image" accept="image/*" hidden>
                                    <label for="society_image" class="btn-upload bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md mt-4 px-4 py-2 inline-block cursor-pointer">Upload Image</label>
                                </div>

                                {{-- BANNER IMAGE --}}
                                <div>
                                    <p class="font-medium mb-4">Upload your banner property image here</p>
                                    <div class="preview-box flex justify-center items-center rounded-md shadow-sm dark:shadow-gray-800 overflow-hidden bg-gray-50 dark:bg-slate-800 text-slate-400 p-2 text-center w-full h-60">Supports JPG, PNG and MP4 videos. Max file size: 10MB.</div>
                                    <input type="file" id="banner" name="banner" accept="image/*" hidden>
                                    <label for="banner" class="btn-upload bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md mt-4 px-4 py-2 inline-block cursor-pointer">Upload Image</label>
                                </div>
                            </div>
                        </div>


                        <!-- Status Toggle -->
                        <div class="mb-6" x-data="{ enabled: true }">
                            <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <!-- Visual toggle switch -->
                                <div
                                        :class="enabled ? 'bg-green-600' : 'bg-gray-300'"
                                        class="relative inline-block w-11 h-6 rounded-full transition-colors duration-300"
                                        @click="enabled = !enabled">
                                        <span
                                                :class="enabled ? 'translate-x-5' : 'translate-x-0'"
                                                class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-300"
                                        ></span>
                                </div>
                                <!-- Label -->
                                <span class="text-sm font-medium text-gray-900" x-text="enabled ? 'Enabled' : 'Disabled'"></span>
                                <!-- Actual status field -->
                                <input type="hidden" name="status" :value="enabled ? 'enabled' : 'disabled'">
                            </label>
                        </div>

                        <!-- Property Type Toggles with Reactive Sections -->
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
                                        <label class="flex items-center space-x-3 cursor-pointer">
                                            <!-- Toggle Switch -->
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

                                                    <!-- Label -->
                                                    <span class="text-sm font-medium text-gray-900">
                                            {{ ucwords(str_replace('_', ' ', $type)) }}
                                            </span>

                                            <!-- Hidden Input for Form Submission -->
                                            <input type="hidden" :name="'has_{{ $type }}'" :value="types['{{ $type }}'] ? 1 : 0">
                                        </label>
                                    @endforeach
                                </div>

                                <!-- Info Message -->
                                <div class="mt-8 mb-4">
                                    <label class="block font-bold text-center text-red-500 text-sm mb-2">
                                        ************* Select Properties Types Which Exist In This Society *************
                                    </label>

                                    <!-- Dynamic Detail Sections -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        @foreach(['residential_plots', 'commercial_plots', 'houses', 'apartments', 'farm_houses', 'shop'] as $type)
                                            <div x-show="types['{{ $type }}']" id="section_{{ $type }}" class="border border-green-400 rounded-lg p-4" x-cloak>
                                                <h4 class="text-green-600 font-semibold mb-2">
                                                    {{ ucwords(str_replace('_', ' ', $type)) }} Page
                                                </h4>

                                                <div class="mb-2">
                                                    <label class="text-sm block mb-1">Title</label>
                                                    <input type="text" name="{{ $type }}_title" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                </div>

                                                <div class="mb-2">
                                                    <label class="text-sm block mb-1">Meta Keywords</label>
                                                    <input type="text" name="{{ $type }}_keywords" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                </div>

                                                <div>
                                                    <label class="text-sm block mb-1">Meta Description</label>
                                                    <textarea name="{{ $type }}_description" rows="2" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                        </div>
                        <!-- Sub-Sectors Toggle Switch -->
                        <div class="mb-6" x-data="{ hasSubSectors: false, subSectors: [{ title: '', slug: '' }] }">
                            <label class="block text-gray-700 font-medium mb-2">Society Has Sub Societies:</label>

                            <!-- Toggle -->
                            <label class="flex items-center space-x-3 cursor-pointer">
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
                                <span class="text-sm font-medium text-gray-900" x-text="hasSubSectors ? 'YES' : 'NO'"></span>
                                <input type="hidden" name="has_sub_sectors" :value="hasSubSectors ? 'Y' : 'N'">
                            </label>

                            <!-- Sub-Sector Blocks -->
                            <div class="mt-6" x-show="hasSubSectors" x-cloak>
                                <div class="border border-blue-400 rounded-md p-4">
                                    <label class="text-center block font-semibold text-pink-500 mb-4">
                                        Fill Out Following Fields To Enter The Sub Sector
                                    </label>

                                    <template x-for="(subSector, index) in subSectors" :key="index">
                                        <div class="mb-6 border border-gray-200 p-4 rounded bg-white shadow-sm">
                                            <!-- Remove icon: shown only when index > 0 -->
                                            <div class="flex justify-end mb-2" x-show="index > 0">
                                                <button type="button"
                                                        @click="subSectors.splice(index, 1); $nextTick(() => feather.replace())"
                                                        class="text-red-600 hover:text-red-800">
                                                    <i data-feather="x-circle" class="w-5 h-5"></i>
                                                </button>
                                            </div>

                                            <!-- Sub-sector form fields -->
                                            <div class="grid grid-cols-1 gap-3">
                                                <input type="text" class="input" :name="`sub_sectors[${index}][name]`" placeholder="Sub Sector Name">

                                                <input type="text"
                                                       class="input"
                                                       :name="`sub_sectors[${index}][title]`"
                                                       placeholder="Title"
                                                       x-model="subSector.title"
                                                       @input="subSector.slug = subSector.title.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-')">

                                                <input type="text"
                                                       class="input"
                                                       :name="`sub_sectors[${index}][slug]`"
                                                       placeholder="Slug (auto-generated)"
                                                       x-model="subSector.slug">

                                                <input type="text" class="input" :name="`sub_sectors[${index}][meta_keywords]`" placeholder="Meta Keywords">
                                                <input type="text" class="input" :name="`sub_sectors[${index}][meta_detail]`" placeholder="Meta Detail">
                                                <input type="text" class="input" :name="`sub_sectors[${index}][detail]`" placeholder="Description / Detail">

                                                <div>
                                                    <label class="block text-sm text-gray-600">Image</label>
                                                    <div class="preview-box mb-2 flex justify-center items-center rounded bg-gray-100 text-gray-500 text-sm h-36">Image preview here</div>
                                                    <input type="file" :name="`sub_sectors[${index}][image]`" accept="image/*">
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

                                    <!-- Add Sub Sector Button -->
                                    <div class="flex justify-end mt-4">
                                        <button
                                                type="button"
                                                @click="subSectors.push({ title: '', slug: '' }); $nextTick(() => feather.replace())"
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
                            <button type="submit" class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md mt-5 px-6 py-2">Add Society</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('change', function (event) {
            const input = event.target;
            if (input.matches('input[type="file"]')) {
                const file = input.files[0];
                if (!file) return;

                // Ensure the preview-box is nearby or inside the parent block
                const wrapper = input.closest('div');
                const previewBox = wrapper?.querySelector('.preview-box');

                if (previewBox) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        previewBox.innerHTML = `<img src="${reader.result}" class="max-h-60 object-contain rounded-md" alt="Preview">`;
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        document.getElementById('name').addEventListener('input', function () {
            // Replace multiple - with single -
            document.getElementById('slug').value = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Remove invalid chars
                .trim()
                .replace(/\s+/g, '-')         // Replace spaces with -
                .replace(/-+/g, '-');
        });
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('createSocietyForm');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(form);

                axios.post('{{ route("admin.societies.store") }}', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                    .then(response => {
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: {
                                type: 'success',
                                message: 'Society added successfully',
                            }
                        }));
                        setTimeout(() => {
                            //window.location.href = '{{ route("admin.societies.index") }}';
                        }, 1200);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: {
                                type: 'error',
                                message: error.response?.data?.message || 'An error occurred while saving the society.'
                            }
                        }));
                    });

            });
        });
    </script>
@endpush
