@extends('admin.layouts.app')

@section('title', 'Add Society Page')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Add Society Page</h5>
            </div>

            <div class="grid grid-cols-1 mt-6">
                <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900"
                     x-data="pageForm()" x-init="initForm()">

                    @include('admin.components.toast')

                    <form @submit.prevent="submitForm('{{ route('admin.society-pages.store') }}')" class="space-y-6">

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

                        <div class="flex justify-end">
                            <button type="submit" class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md px-6 py-2">
                                Save
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function pageForm() {
            return {
                form: {
                    title: '', slug: '', heading: '', detail: '', meta_keywords: '', meta_description: ''
                },
                quill: null,
                initForm() {
                    const waitForQuill = () => {
                        if (window.Quill) {
                            this.quill = new Quill('#editor', { theme: 'snow' });
                        } else {
                            setTimeout(waitForQuill, 100);
                        }
                    };
                    waitForQuill();
                },
                submitForm(url) {
                    this.form.detail = this.quill.root.innerHTML;
                    axios.post(url, this.form)
                        .then(() => window.location.href = '{{ route('admin.society-pages.index') }}')
                        .catch(err => $dispatch('toast', {
                            type: 'error',
                            message: err?.response?.data?.message || 'Save failed'
                        }));
                }
            }
        }
    </script>
@endsection
