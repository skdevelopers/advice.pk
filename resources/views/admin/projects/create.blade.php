@extends('admin.layouts.app')

@section('title', 'Add Project')

@section('content')
    <div class="container-fluid px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center mb-6">
                <h5 class="text-lg font-semibold">Add Project</h5>
                <ul class="inline-flex space-x-2 text-sm">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Dashboard</a></li>
                    <li><i class="mdi mdi-chevron-right text-gray-400"></i></li>
                    <li class="text-green-600">Add Project</li>
                </ul>
            </div>

            <div class="rounded-md shadow-sm bg-white p-6 dark:bg-slate-900"
                 x-data="projectForm()" x-init="initForm()">

                @include('admin.components.toast')

                <form @submit.prevent="submitForm('{{ route('admin.projects.store') }}')" class="space-y-6">

                    {{-- Title --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Project Title</label>
                        <input type="text" x-model="form.title" @input="generateSlug"
                               class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200">
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Slug</label>
                        <input type="text" x-model="form.slug"
                               class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200">
                    </div>

                    {{-- Heading --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Heading</label>
                        <input type="text" x-model="form.heading"
                               class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200">
                    </div>

                    {{-- Rich Text Editor --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Description</label>
                        <div id="editor" class="h-48 bg-white border p-2 rounded shadow-sm"></div>
                        <input type="hidden" x-model="form.description">
                    </div>

                    {{-- SEO Fields --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Meta Keywords</label>
                            <input type="text" x-model="form.meta_keywords"
                                   class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Meta Description</label>
                            <input type="text" x-model="form.meta_description"
                                   class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200">
                        </div>
                    </div>

                    {{-- SEO Generator --}}
                    <div class="text-right">
                        <button type="button"
                                class="btn bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded flex items-center justify-center gap-2"
                                @click="generateSEO" :disabled="loadingSeo">
                            <svg x-show="loadingSeo" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                                <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span x-text="loadingSeo ? 'Generating...' : 'Auto-Generate SEO'"></span>
                        </button>
                    </div>

                    {{-- Preview --}}
                    <div class="bg-gray-50 dark:bg-slate-800 p-4 rounded text-sm text-gray-700 dark:text-gray-300">
                        <p><strong>Keywords:</strong> <span x-text="form.meta_keywords || 'N/A'"></span></p>
                        <p><strong>Description:</strong> <span x-text="form.meta_description || 'N/A'"></span></p>
                    </div>

                    {{-- Coordinates --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Longitude</label>
                            <input type="text" x-model="form.longitude"
                                   class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Latitude</label>
                            <input type="text" x-model="form.latitude"
                                   class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200">
                        </div>
                    </div>

                    {{-- Gallery Upload --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Gallery Images</label>
                        <input type="file" multiple @change="handleGalleryUpload"
                               class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200">
                    </div>

                    {{-- Floor Plan --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Floor Plan (PDF/Image)</label>
                        <input type="file" @change="handleFloorPlanUpload"
                               class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200">
                    </div>

                    {{-- Submit --}}
                    <div class="text-right">
                        <button type="submit"
                                class="btn bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                            Save Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Alpine + Axios Script --}}
    <script>
        function projectForm() {
            return {
                form: {
                    title: '', slug: '', heading: '', description: '',
                    meta_keywords: '', meta_description: '', longitude: '', latitude: ''
                },
                galleryFiles: [],
                floorPlanFile: null,
                quill: null,
                loadingSeo: false,

                initForm() {
                    if (window.Quill) {
                        this.quill = new Quill('#editor', { theme: 'snow' });
                    } else {
                        setTimeout(this.initForm, 100);
                    }
                },

                generateSlug() {
                    this.form.slug = this.form.title
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .trim()
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                },

                generateSEO() {
                    if (!this.form.title || !this.form.heading) {
                        window.showToast('Title and Heading required', 'warning');
                        return;
                    }

                    this.loadingSeo = true;
                    axios.post('{{ route('ai.generate.seo') }}', {
                        title: this.form.title,
                        city: this.form.heading
                    })
                        .then(res => {
                            this.form.meta_keywords = res.data.seo_keywords;
                            this.form.meta_description = res.data.seo_description;
                            showToast('SEO generated', 'success');
                        })
                        .catch(() => showToast('SEO generation failed', 'error'))
                        .finally(() => this.loadingSeo = false);
                },

                handleGalleryUpload(event) {
                    this.galleryFiles = Array.from(event.target.files);
                },

                handleFloorPlanUpload(event) {
                    this.floorPlanFile = event.target.files[0];
                },

                submitForm(url) {
                    this.form.description = this.quill?.root.innerHTML || '';

                    let formData = new FormData();
                    Object.entries(this.form).forEach(([k, v]) => formData.append(k, v));
                    if (this.floorPlanFile) formData.append('floor_plan', this.floorPlanFile);
                    this.galleryFiles.forEach((f, i) => formData.append(`gallery[${i}]`, f));

                    axios.post(url, formData)
                        .then(() => {
                            showToast('Project created successfully', 'success');
                            window.location.href = '{{ route('admin.projects.index') }}';
                        })
                        .catch(err => {
                            showToast(err?.response?.data?.message || 'Failed to save project', 'error');
                        });
                }
            }
        }
    </script>
@endsection
