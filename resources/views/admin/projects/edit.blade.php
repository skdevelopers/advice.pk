@extends('admin.layouts.app')

@section('title', 'Edit Project')

@section('content')
    <div class="container-fluid px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center mb-6">
                <h5 class="text-lg font-semibold">Edit Project</h5>
                <ul class="inline-flex space-x-2 text-sm">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Dashboard</a></li>
                    <li><i class="mdi mdi-chevron-right text-gray-400"></i></li>
                    <li><a href="{{ route('admin.projects.index') }}" class="hover:text-green-600">Projects</a></li>
                    <li><i class="mdi mdi-chevron-right text-gray-400"></i></li>
                    <li class="text-green-600">Edit Project</li>
                </ul>
            </div>

            <div class="rounded-md shadow-sm bg-white p-6 dark:bg-slate-900"
                 x-data="projectEditForm()" x-init="fetchProject('{{ route('admin.projects.show', $project->id) }}')">

                @include('admin.components.toast')

                <form @submit.prevent="submitForm('{{ route('admin.projects.update', $project->id) }}')" class="space-y-6">

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

                    {{-- SEO --}}
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
                            <span x-text="loadingSeo ? 'Generating...' : 'Regenerate SEO'"></span>
                        </button>
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

                    {{-- Gallery (new uploads) --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Upload New Gallery Images</label>
                        <input type="file" multiple @change="handleGalleryUpload"
                               class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200">
                    </div>

                    {{-- Existing Images --}}
                    <div class="mt-4">
                        <h2 class="text-gray-600 font-semibold mb-2">Existing Gallery</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <template x-for="img in existing.gallery" :key="img.id">
                                <img :src="img.url" class="rounded shadow h-32 object-cover">
                            </template>
                        </div>
                    </div>

                    {{-- Floor Plan (new) --}}
                    <div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-1">Upload New Floor Plan</label>
                        <input type="file" @change="handleFloorPlanUpload"
                               class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200">
                    </div>

                    {{-- Existing Floor Plan --}}
                    <div class="mt-2">
                        <template x-if="existing.floor_plan">
                            <a :href="existing.floor_plan.url"
                               class="text-sm text-blue-500 underline"
                               target="_blank">View Current Floor Plan</a>
                        </template>
                    </div>

                    {{-- Submit --}}
                    <div class="text-right mt-6">
                        <button type="submit"
                                class="btn bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                            Update Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Alpine + Axios --}}
    <script>
        function projectEditForm() {
            return {
                form: {
                    title: '', slug: '', heading: '', description: '',
                    meta_keywords: '', meta_description: '', longitude: '', latitude: ''
                },
                existing: {
                    gallery: [], floor_plan: null
                },
                galleryFiles: [],
                floorPlanFile: null,
                quill: null,
                loadingSeo: false,

                fetchProject(url) {
                    axios.get(url).then(res => {
                        Object.assign(this.form, res.data);
                        if (res.data.description) {
                            this.initEditor(res.data.description);
                        }
                        this.existing.gallery = (res.data.gallery || []).map(media => ({
                            id: media.id,
                            url: media.original_url
                        }));
                        if (res.data.floor_plan?.original_url) {
                            this.existing.floor_plan = {
                                url: res.data.floor_plan.original_url
                            };
                        }
                    }).catch(() => showToast('Failed to load project', 'error'));
                },

                initEditor(content) {
                    this.quill = new Quill('#editor', { theme: 'snow' });
                    this.quill.root.innerHTML = content || '';
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
                        window.showToast('Title and Heading required for SEO generation', 'warning');
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
                            showToast('SEO regenerated', 'success');
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

                    const formData = new FormData();
                    Object.entries(this.form).forEach(([k, v]) => formData.append(k, v));
                    if (this.floorPlanFile) formData.append('floor_plan', this.floorPlanFile);
                    this.galleryFiles.forEach((f, i) => formData.append(`gallery[${i}]`, f));
                    formData.append('_method', 'PUT');

                    axios.post(url, formData)
                        .then(() => {
                            showToast('Project updated successfully', 'success');
                            window.location.href = '{{ route('admin.projects.index') }}';
                        })
                        .catch(err => {
                            showToast(err?.response?.data?.message || 'Update failed', 'error');
                        });
                }
            }
        }
    </script>
@endsection
