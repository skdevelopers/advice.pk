@extends('admin.layouts.app')

@section('title', 'Add Blog')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <!-- Header -->
            <div class="md:flex justify-between items-center mb-6">
                <h5 class="text-lg font-semibold">Add Blog</h5>
                <a href="{{ route('admin.blogs.index') }}"
                   class="text-sm text-slate-600 hover:text-green-600">← Back to list</a>
            </div>

            <!-- Form -->
            <div class="rounded-md shadow-sm bg-white p-6" x-data="blogForm()" x-init="init()">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block mb-1">Title</label>
                        <input type="text" x-model="form.title" class="w-full border p-2 rounded" />
                    </div>
                    <div>
                        <label class="block mb-1">Slug</label>
                        <input type="text" x-model="form.slug" class="w-full border p-2 rounded" />
                    </div>
                    <div>
                        <label class="block mb-1">Heading</label>
                        <input type="text" x-model="form.heading" class="w-full border p-2 rounded" />
                    </div>
                    <div>
                        <label class="block mb-1">Detail</label>
                        <textarea x-model="form.detail" rows="5" class="w-full border p-2 rounded"></textarea>
                    </div>
                    <div>
                        <label class="block mb-1">Image</label>
                        <input type="file" @change="preview" x-ref="file" class="block" />
                        <template x-if="previewUrl">
                            <img :src="previewUrl" class="mt-2 w-full h-auto rounded shadow" />
                        </template>
                    </div>
                    <div class="flex space-x-2">
                        <button type="button" @click="generateSeo()"
                                class="px-4 py-2 bg-blue-600 text-white rounded">Generate AI SEO</button>
                    </div>
                    <div>
                        <label class="block mb-1">Meta Keywords</label>
                        <textarea x-model="form.meta_keywords" rows="2" class="w-full border p-2 rounded"></textarea>
                    </div>
                    <div>
                        <label class="block mb-1">Meta Description</label>
                        <textarea x-model="form.meta_description" rows="2" class="w-full border p-2 rounded"></textarea>
                    </div>
                    <div>
                        <button @click="submit()" class="px-6 py-2 bg-green-600 text-white rounded">Save Blog</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function blogForm(data = {}) {
                return {
                    form: {
                        heading: data.heading || '',
                        slug: data.slug || '',
                        title: data.title || '',
                        detail: data.detail || '',
                        meta_keywords: data.meta_keywords || '',
                        meta_description: data.meta_description || '',
                    },
                    previewUrl: null,
                    init() {
                        // optional: auto-generate slug from heading
                        this.$watch('form.heading', value => {
                            if (!this.form.slug) {
                                this.form.slug = value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]/g,'');
                            }
                        });
                    },
                    preview(e) {
                        this.previewUrl = URL.createObjectURL(e.target.files[0]);
                    },
                    async generateSeo() {
                        try {
                            let res = await axios.post('/admin/blogs', {
                                ...this.form,
                                prompt: 'seo'
                            });
                            this.form.meta_keywords    = res.data.seo_keywords;
                            this.form.meta_description = res.data.seo_description;
                            showToast('SEO fields populated', 'success');
                        } catch {
                            showToast('SEO generation failed', 'error');
                        }
                    },
                    async submit() {
                        let formData = new FormData();
                        Object.entries(this.form).forEach(([k,v]) => formData.append(k, v));
                        if (this.$refs.file.files[0]) {
                            formData.append('image', this.$refs.file.files[0]);
                        }
                        try {
                            await axios.post('/admin/blogs', formData, {
                                headers: {'Content-Type':'multipart/form-data'}
                            });
                            showToast('Blog created', 'success');
                            window.location = '/admin/blogs';
                        } catch {
                            showToast('Create failed', 'error');
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection
