@extends('admin.layouts.app')

@section('title', 'Blogs')

@section('content')
    <div class="container-fluid relative px-3" x-data="blogIndex()" x-init="fetch()">
        <div class="layout-specing">
            <!-- Header -->
            <div class="md:flex justify-between items-center mb-6">
                <h5 class="text-lg font-semibold">Blogs</h5>
                <a href="{{ route('admin.blogs.create') }}"
                   class="inline-block px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700">
                    Add Blog
                </a>
            </div>

            <!-- List -->
            <div class="rounded-md shadow-sm bg-white p-6">
                <template x-if="blogs.length">
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-slate-100">
                            <th class="p-2 text-left">Heading</th>
                            <th class="p-2 text-left">Slug</th>
                            <th class="p-2 text-left">Created</th>
                            <th class="p-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template x-for="blog in blogs" :key="blog.id">
                            <tr class="border-b hover:bg-slate-50">
                                <td class="p-2" x-text="blog.heading"></td>
                                <td class="p-2 text-sm text-slate-600" x-text="blog.slug"></td>
                                <td class="p-2 text-sm text-slate-500" x-text="new Date(blog.created_at).toLocaleDateString()"></td>
                                <td class="p-2 flex space-x-2 justify-center">
                                    <a :href="`/admin/blogs/${blog.id}`"
                                       class="px-2 py-1 bg-blue-500 text-white rounded text-xs">View</a>
                                    <a :href="`/admin/blogs/${blog.id}/edit`"
                                       class="px-2 py-1 bg-yellow-500 text-white rounded text-xs">Edit</a>
                                    <button @click="remove(blog.id)"
                                            class="px-2 py-1 bg-red-600 text-white rounded text-xs">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </template>
                <template x-if="!blogs.length">
                    <p class="text-center text-slate-400">No blogs found.</p>
                </template>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function blogIndex() {
                return {
                    blogs: [],
                    async fetch() {
                        try {
                            let res = await axios.get('/admin/blogs');
                            this.blogs = res.data.data || res.data;
                        } catch (e) {
                            showToast('Failed to load blogs', 'error');
                        }
                    },
                    async remove(id) {
                        if (!confirm('Delete this blog?')) return;
                        try {
                            await axios.delete(`/admin/blogs/${id}`);
                            this.blogs = this.blogs.filter(b => b.id !== id);
                            showToast('Blog deleted', 'success');
                        } catch (e) {
                            showToast('Delete failed', 'error');
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection
