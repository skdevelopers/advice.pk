@extends('admin.layouts.app')

@section('title', 'Create Sub-Society')

@section('content')
    <div class="container-fluid px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Create Sub-Society</h5>
                <a href="{{ route('admin.subsocieties.index') }}"
                   class="text-green-600 hover:underline">All Sub-Societies</a>
            </div>

            <div class="mt-6 bg-white dark:bg-slate-900 rounded shadow p-6" x-data="subSocietyForm()" x-init="init()">
                <template x-if="loading">
                    <div class="text-center text-gray-400 py-10">Loading societies…</div>
                </template>

                <form x-show="!loading" @submit.prevent="submit" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Society -->
                    <div>
                        <label class="block font-medium">Parent Society <span class="text-red-500">*</span></label>
                        <select name="society_id"
                                x-model="form.society_id"
                                class="w-full border rounded px-3 py-2"
                                required>
                            <option value="">Select a Society</option>
                            <template x-for="s in societies" :key="s.id">
                                <option :value="s.id" x-text="s.name"></option>
                            </template>
                        </select>
                        <p class="text-red-600 text-sm" x-text="errors.society_id" x-show="errors.society_id"></p>
                    </div>

                    <!-- Name & Slug -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1">Name <span class="text-red-500">*</span></label>
                            <input type="text" x-model="form.name" @input="generateSlug()"
                                   class="w-full border px-3 py-2 rounded" required>
                            <p class="text-red-600 text-sm" x-text="errors.name" x-show="errors.name"></p>
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Slug <span class="text-red-500">*</span></label>
                            <input type="text" x-model="form.slug"
                                   class="w-full border px-3 py-2 rounded" required>
                            <p class="text-red-600 text-sm" x-text="errors.slug" x-show="errors.slug"></p>
                        </div>
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block font-medium mb-1">Type</label>
                        <input type="text" x-model="form.type"
                               class="w-full border px-3 py-2 rounded">
                    </div>

                    <!-- Detail -->
                    <div>
                        <label class="block font-medium mb-1">Detail</label>
                        <textarea x-model="form.detail" rows="3"
                                  class="w-full border px-3 py-2 rounded"></textarea>
                    </div>

                    <!-- Featured Image -->
                    <div>
                        <label class="block font-medium mb-2">Featured Image</label>
                        <div @click="$refs.fileInput.click()"
                             class="cursor-pointer preview-box flex items-center justify-center rounded-md border-dashed border-2 border-gray-300 p-6">
                            <template x-if="!previewUrl">
                                <span class="text-gray-500">Click to upload JPG/PNG (max 10MB)</span>
                            </template>
                            <template x-if="previewUrl">
                                <img :src="previewUrl" alt="Preview" class="max-h-48 object-contain" />
                            </template>
                        </div>
                        <input type="file" x-ref="fileInput" accept="image/*"
                               @change="onFileChange"
                               class="hidden" />
                        <p class="text-red-600 text-sm" x-text="errors.subsociety_image" x-show="errors.subsociety_image"></p>
                    </div>

                    <!-- Submit -->
                    <div class="text-right">
                        <button type="submit"
                                :disabled="submitting"
                                class="btn bg-green-600 hover:bg-green-700 transition border-green-600 hover:border-green-700 text-white rounded-md mt-5 px-6 py-2">
                            <span x-show="!submitting">Save</span>
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
        function subSocietyForm() {
            return {
                loading: true,
                submitting: false,
                societies: [],
                form: {
                    society_id: '',
                    name: '',
                    slug: '',
                    type: '',
                    detail: '',
                },
                file: null,
                previewUrl: null,
                errors: {},

                init() {
                    axios.get("{{ route('admin.societies.index') }}?ajax=1")
                        .then(({ data }) => {
                            this.societies = data.data.map(s => ({ id: s.id, name: s.name }));
                        })
                        .catch(() => showToast('Failed to load societies.', 'error'))
                        .finally(() => this.loading = false);
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
                        payload.append('subsociety_image', this.file);
                    }
                    payload.append('_token', '{{ csrf_token() }}');

                    try {
                        const res = await axios.post("{{ route('admin.subsocieties.store') }}", payload, {
                            headers: { 'Content-Type': 'multipart/form-data' }
                        });
                        showToast(res.data.message || 'Created!', 'success');
                        setTimeout(() => window.location = "{{ route('admin.subsocieties.index') }}", 800);
                    } catch (e) {
                        if (e.response?.data?.errors) {
                            this.errors = e.response.data.errors;
                        } else {
                            showToast('Failed to save.', 'error');
                        }
                    } finally {
                        this.submitting = false;
                    }
                }
            }
        }
    </script>
@endpush
