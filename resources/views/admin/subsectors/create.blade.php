@extends('admin.layouts.app')

@section('title', 'Create Sub-Sector')

@section('content')
    <div class="container-fluid px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center mb-6">
                <h5 class="text-lg font-semibold">Create Sub-Sector</h5>
                <a href="{{ route('admin.subsectors.index') }}" class="text-green-600 hover:underline">
                    All Sub-Sectors
                </a>
            </div>

            <div
                    class="mt-6 bg-white dark:bg-slate-900 rounded shadow p-6"
                    x-data="subSectorForm()"
                    x-init="init()"
            >
                <!-- Loading State -->
                <template x-if="loading">
                    <div class="text-center text-gray-400 py-10">
                        Loading societies & parents…
                    </div>
                </template>

                <!-- Form -->
                <form
                        x-show="!loading"
                        @submit.prevent="submit"
                        enctype="multipart/form-data"
                        class="space-y-6"
                >
                    @csrf

                    <!-- Parent Society -->
                    <div>
                        <label class="block font-medium mb-1">
                            Parent Society <span class="text-red-500">*</span>
                        </label>
                        <select
                                name="society_id"
                                x-model="form.society_id"
                                class="w-full border rounded px-3 py-2"
                                required
                        >
                            <option value="">Select a society</option>
                            <template x-for="s in societies" :key="s.id">
                                <option :value="s.id" x-text="s.name"></option>
                            </template>
                        </select>
                        <p
                                class="text-red-600 text-sm mt-1"
                                x-show="errors.society_id"
                                x-text="errors.society_id[0]"
                        ></p>
                    </div>

                    <!-- Parent Sub-Sector -->
                    <div>
                        <label class="block font-medium mb-1">Parent Sub-Sector</label>
                        <select
                                name="parent_id"
                                x-model="form.parent_id"
                                class="w-full border rounded px-3 py-2"
                        >
                            <option value="">None (top-level)</option>
                            <template x-for="p in parents" :key="p.id">
                                <option :value="p.id" x-text="p.name"></option>
                            </template>
                        </select>
                        <p
                                class="text-red-600 text-sm mt-1"
                                x-show="errors.parent_id"
                                x-text="errors.parent_id[0]"
                        ></p>
                    </div>

                    <!-- Name & Slug -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                    type="text"
                                    x-model="form.name"
                                    @input="generateSlug()"
                                    class="w-full border rounded px-3 py-2"
                                    required
                            >
                            <p
                                    class="text-red-600 text-sm mt-1"
                                    x-show="errors.name"
                                    x-text="errors.name[0]"
                            ></p>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">
                                Slug <span class="text-red-500">*</span>
                            </label>
                            <input
                                    type="text"
                                    x-model="form.slug"
                                    class="w-full border rounded px-3 py-2"
                                    required
                            >
                            <p
                                    class="text-red-600 text-sm mt-1"
                                    x-show="errors.slug"
                                    x-text="errors.slug[0]"
                            ></p>
                        </div>
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block font-medium mb-1">Title</label>
                        <input
                                type="text"
                                x-model="form.title"
                                class="w-full border rounded px-3 py-2"
                        >
                        <p
                                class="text-red-600 text-sm mt-1"
                                x-show="errors.title"
                                x-text="errors.title[0]"
                        ></p>
                    </div>

                    <!-- Meta Keywords & Detail -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1">Meta Keywords</label>
                            <input
                                    type="text"
                                    x-model="form.meta_keywords"
                                    class="w-full border rounded px-3 py-2"
                            >
                            <p
                                    class="text-red-600 text-sm mt-1"
                                    x-show="errors.meta_keywords"
                                    x-text="errors.meta_keywords[0]"
                            ></p>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Meta Detail</label>
                            <input
                                    type="text"
                                    x-model="form.meta_detail"
                                    class="w-full border rounded px-3 py-2"
                            >
                            <p
                                    class="text-red-600 text-sm mt-1"
                                    x-show="errors.meta_detail"
                                    x-text="errors.meta_detail[0]"
                            ></p>
                        </div>
                    </div>

                    <!-- Detail -->
                    <div>
                        <label class="block font-medium mb-1">Detail</label>
                        <textarea
                                x-model="form.detail"
                                rows="3"
                                class="w-full border rounded px-3 py-2"
                        ></textarea>
                        <p
                                class="text-red-600 text-sm mt-1"
                                x-show="errors.detail"
                                x-text="errors.detail[0]"
                        ></p>
                    </div>

                    <!-- Block -->
                    <div>
                        <label class="block font-medium mb-1">Block/Zone/Phase</label>
                        <select
                                x-model="form.block"
                                name="block"
                                class="w-full border rounded px-3 py-2"
                        >
                            <option value="">Select…</option>
                            <option value="Block">Block</option>
                            <option value="Sector">Sector</option>
                            <option value="Zone">Zone</option>
                            <option value="Phase">Phase</option>
                        </select>
                        <p
                                class="text-red-600 text-sm mt-1"
                                x-show="errors.block"
                                x-text="errors.block[0]"
                        ></p>
                    </div>

                    <!-- Featured Image -->
                    <div>
                        <label class="block font-medium mb-2">Featured Image</label>
                        <div
                                @click="$refs.fileInput.click()"
                                class="cursor-pointer preview-box flex items-center justify-center rounded-md border-dashed border-2 border-gray-300 p-6"
                        >
                            <template x-if="!previewUrl">
                                <span class="text-gray-500">
                                    Click to upload JPG/PNG (max 10MB)
                                </span>
                            </template>
                            <template x-if="previewUrl">
                                <img
                                        :src="previewUrl"
                                        alt="Preview"
                                        class="max-h-48 object-contain"
                                />
                            </template>
                        </div>
                        <input
                                type="file"
                                x-ref="fileInput"
                                accept="image/*"
                                @change="onFileChange"
                                class="hidden"
                        />
                        <p
                                class="text-red-600 text-sm mt-1"
                                x-show="errors.image"
                                x-text="errors.image[0]"
                        ></p>
                    </div>

                    <!-- Submit -->
                    <div class="text-right">
                        <button
                                type="submit"
                                :disabled="submitting"
                                class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md px-6 py-2"
                        >
                            <span x-show="!submitting">Save Sub-Sector</span>
                            <span x-show="submitting">Saving…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function subSectorForm() {
            return {
                loading: true,
                submitting: false,
                societies: [],
                parents: [],
                form: {
                    society_id: '',
                    parent_id: '',
                    name: '',
                    title: '',
                    slug: '',
                    meta_keywords: '',
                    meta_detail: '',
                    detail: '',
                    block: '',
                },
                file: null,
                previewUrl: null,
                errors: {},

                init() {
                    // Fetch societies
                    axios.get("{{ route('admin.societies.index') }}?ajax=1")
                        .then(({ data }) => {
                            this.societies = data.data;
                        })
                        .catch(() => {
                            window.showToast('Failed to load societies.', 'error');
                        });

                    // Fetch existing subSector-sectors for parent selection
                    axios.get("{{ route('admin.subsectors.index') }}?ajax=1")
                        .then(({ data }) => {
                            this.parents = data.data;
                        })
                        .catch(() => {
                            window.showToast('Failed to load parent subSector-sectors.', 'error');
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                },

                generateSlug() {
                    this.form.slug = this.form.name.toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .trim()
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                },

                onFileChange(e) {
                    this.file = e.target.files[0];
                    this.previewUrl = URL.createObjectURL(this.file);
                },

                async submit() {
                    this.submitting = true;
                    this.errors = {};

                    const payload = new FormData();
                    for (let key in this.form) {
                        payload.append(key, this.form[key]);
                    }
                    if (this.file) {
                        payload.append('image', this.file);
                    }
                    payload.append('_token', '{{ csrf_token() }}');

                    try {
                        const res = await axios.post(
                            "{{ route('admin.subsectors.store') }}",
                            payload,
                            { headers: { 'Content-Type': 'multipart/form-data' } }
                        );
                        window.showToast(res.data.message, 'success');
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.subsectors.index') }}";
                        }, 800);
                    } catch (e) {
                        if (e.response?.data?.errors) {
                            this.errors = e.response.data.errors;
                        } else {
                            window.showToast('Failed to save subSector-sector.', 'error');
                        }
                    } finally {
                        this.submitting = false;
                    }
                }
            }
        }
    </script>
@endpush
