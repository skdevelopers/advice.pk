@extends('admin.layouts.app')

@section('title', 'Edit Society Page')

@section('content')
    <div class="container-fluid px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center mb-6">
                <h5 class="text-lg font-semibold">Edit Society Page</h5>
                <ul class="inline-flex space-x-2 text-sm">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Dashboard</a></li>
                    <li><i class="mdi mdi-chevron-right text-gray-400"></i></li>
                    <li class="text-green-600">Edit Society Page</li>
                </ul>
            </div>

            <div class="rounded-md shadow-sm bg-white p-6 dark:bg-slate-900"
                 x-data="pageForm()" x-init="initForm(@json($page))">

                @include('admin.components.toast')

                <form @submit.prevent="submitForm('{{ route('admin.society-pages.update', $page->id) }}', 'put')" class="space-y-6">

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Title</label>
                        <input type="text" x-model="form.title" @input="generateSlug()" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Slug</label>
                        <input type="text" x-model="form.slug" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Heading</label>
                        <input type="text" x-model="form.heading" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Page Content</label>
                        <div id="editor" class="h-48 bg-white border p-2 rounded shadow-sm"></div>
                        <input type="hidden" x-model="form.detail" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-1">Meta Keywords</label>
                            <input type="text" x-model="form.meta_keywords" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-1">Meta Description</label>
                            <input type="text" x-model="form.meta_description" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:ring-green-200" />
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="button"
                                class="btn bg-blue-600 hover:bg-blue-700 text-white border-blue-600 hover:border-blue-700 px-6 py-2 rounded mb-4 flex items-center justify-center gap-2"
                                @click="generateSEO()" :disabled="loadingSeo">
                            <svg x-show="loadingSeo" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                                <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span x-text="loadingSeo ? 'Generating...' : 'Auto-Generate SEO'"></span>
                        </button>
                    </div>

                    <div class="bg-gray-50 dark:bg-slate-800 p-4 rounded shadow-sm text-sm text-gray-700 dark:text-gray-300">
                        <p class="mb-1"><strong>Preview Keywords:</strong> <span x-text="form.meta_keywords || 'N/A'"></span></p>
                        <p><strong>Preview Description:</strong> <span x-text="form.meta_description || 'N/A'"></span></p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md px-6 py-2">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function pageForm() {
            return {
                form: {
                    title: '', slug: '', heading: '', detail: '', meta_keywords: '', meta_description: ''
                },
                quill: null,
                loadingSeo: false,

                initForm(data) {
                    const waitForQuill = () => {
                        if (window.Quill) {
                            this.quill = new Quill('#editor', { theme: 'snow' });
                            this.form = data;
                            this.quill.root.innerHTML = data.detail;
                        } else {
                            setTimeout(waitForQuill, 100);
                        }
                    };
                    waitForQuill();
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
                        window.showToast('Title and Heading are required for SEO generation', 'warning');
                        return;
                    }

                    this.loadingSeo = true;
                    axios.post('{{ route("ai.generate.seo") }}', {
                        title: this.form.title,
                        city: this.form.heading
                    })
                        .then(res => {
                            this.form.meta_keywords = res.data.seo_keywords;
                            this.form.meta_description = res.data.seo_description;
                            window.showToast('SEO generated', 'success');
                        })
                        .catch(() => {
                            window.showToast('SEO generation failed', 'error');
                        })
                        .finally(() => {
                            this.loadingSeo = false;
                        });
                },

                submitForm(url, method = 'post') {
                    this.form.detail = this.quill.root.innerHTML;
                    axios({ url, method, data: this.form })
                        .then(() => window.location.href = '{{ route('admin.society-pages.index') }}')
                        .catch(err => $dispatch('toast', {
                            type: 'error',
                            message: err?.response?.data?.message || 'Update failed'
                        }));
                }
            }
        }
    </script>
@endpush
