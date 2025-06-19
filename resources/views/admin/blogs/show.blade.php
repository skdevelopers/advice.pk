@extends('admin.layouts.app')

@section('title', 'View Blog')

@section('content')
    <div class="container-fluid relative px-3" x-data="blogShow(@json($blog->id))" x-init="fetch()">
        <div class="layout-specing">
            <!-- Header -->
            <div class="md:flex justify-between items-center mb-6">
                <h5 class="text-lg font-semibold">View Blog</h5>
                <a href="{{ route('blogs.index') }}"
                   class="text-sm text-slate-600 hover:text-green-600">← Back to list</a>
            </div>

            <!-- Details -->
            <div class="rounded-md shadow-sm bg-white p-6 space-y-4">
                <h2 class="text-2xl font-bold" x-text="blog.heading"></h2>
                <p class="text-sm text-slate-500" x-text="new Date(blog.created_at).toLocaleString()"></p>
                <div>
                    <img :src="blogImage" class="w-full h-auto rounded" />
                </div>
                <div class="prose max-w-none" x-html="blog.detail"></div>
                <div class="space-y-2">
                    <p><strong>Meta Keywords:</strong> <span x-text="blog.meta_keywords"></span></p>
                    <p><strong>Meta Description:</strong> <span x-text="blog.meta_description"></span></p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function blogShow(id) {
                return {
                    blog: {},
                    blogImage: '',
                    async fetch() {
                        try {
                            let res = await axios.get(`/admin/blogs/${id}`);
                            this.blog = res.data;
                            this.blogImage = this.blogImage || this.blog.image_url;
                        } catch {
                            showToast('Failed to load blog', 'error');
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection
