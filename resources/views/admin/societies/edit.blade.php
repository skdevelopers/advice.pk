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
                        <input type="text" x-model="form.title" class="w-full border px-3 py-2 rounded" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Slug</label>
                        <input type="text" x-model="form.slug" class="w-full border px-3 py-2 rounded" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Heading</label>
                        <input type="text" x-model="form.heading" class="w-full border px-3 py-2 rounded" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Page Content</label>
                        <div id="editor" class="h-48 bg-white border p-2 rounded shadow-sm"></div>
                        <input type="hidden" x-model="form.detail" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Meta Keywords</label>
                        <input type="text" x-model="form.meta_keywords" class="w-full border px-3 py-2 rounded" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Meta Description</label>
                        <input type="text" x-model="form.meta_description" class="w-full border px-3 py-2 rounded" />
                    </div>

                    <div class="text-right mt-6">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                            Update Page
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
