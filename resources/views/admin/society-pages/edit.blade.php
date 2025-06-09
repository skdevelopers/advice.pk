@extends('admin.layouts.app')

@section('title', 'Edit Society Page')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Edit Society Page</h5>
            </div>

            <div class="grid grid-cols-1 mt-6">
                <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900"
                     x-data="pageForm()" x-init="initForm(@json($page))">

                    @include('admin.components.toast')

                    <form @submit.prevent="submitForm('{{ route('admin.society-pages.update', $page->id) }}', 'put')" class="space-y-6">
                        <input type="text" x-model="form.title" class="input w-full" />
                        <input type="text" x-model="form.slug" class="input w-full" />
                        <input type="text" x-model="form.heading" class="input w-full" />

                        <label class="block text-gray-700">Page Content</label>
                        <div id="editor" class="h-48 bg-white border p-2 rounded shadow-sm"></div>
                        <input type="hidden" x-model="form.detail" />

                        <input type="text" x-model="form.meta_keywords" placeholder="Meta Keywords" class="input w-full" />
                        <input type="text" x-model="form.meta_description" placeholder="Meta Description" class="input w-full" />

                        <button type="submit" class="btn bg-primary text-white hover:bg-blue-700 px-4 py-2 rounded">
                            Update
                        </button>
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
@endsection
