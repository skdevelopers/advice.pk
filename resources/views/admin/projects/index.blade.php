@extends('admin.layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="container-fluid px-3">
        <div class="layout-specing" x-data="projectIndex()" x-init="loadProjects">
            <div class="flex justify-between items-center mb-6">
                <h5 class="text-lg font-semibold">All Projects</h5>
                <a href="{{ route('admin.projects.create') }}"
                   class="btn bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    + Add Project
                </a>
            </div>

            @include('admin.components.toast')

            <div class="overflow-x-auto bg-white shadow rounded-md">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-4 py-3 font-semibold">Title</th>
                        <th class="text-left px-4 py-3 font-semibold">Slug</th>
                        <th class="text-left px-4 py-3 font-semibold">Domain</th>
                        <th class="text-left px-4 py-3 font-semibold">Created</th>
                        <th class="text-left px-4 py-3 font-semibold">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" x-show="projects.length">
                    <template x-for="project in projects" :key="project.id">
                        <tr>
                            <td class="px-4 py-2" x-text="project.title"></td>
                            <td class="px-4 py-2" x-text="project.slug"></td>
                            <td class="px-4 py-2" x-text="project.domain"></td>
                            <td class="px-4 py-2 text-gray-500" x-text="formatDate(project.created_at)"></td>
                            <td class="px-4 py-2 space-x-2">
                                <a :href="`/admin/projects/${project.id}`"
                                   class="text-blue-600 hover:underline">View</a>
                                <a :href="`/admin/projects/${project.id}/edit`"
                                   class="text-green-600 hover:underline">Edit</a>
                                <button @click="deleteProject(project.id)"
                                        class="text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>

                <div x-show="!projects.length" class="p-6 text-center text-gray-500">
                    No projects found.
                </div>
            </div>
        </div>
    </div>

    <script>
        function projectIndex() {
            return {
                projects: [],

                loadProjects() {
                    axios.get('{{ route('admin.projects.index') }}')
                        .then(res => this.projects = res.data.data)
                        .catch(() => showToast('Failed to load projects', 'error'));
                },

                deleteProject(id) {
                    if (!confirm('Are you sure you want to delete this project?')) return;

                    axios.delete(`/admin/projects/${id}`)
                        .then(() => {
                            this.projects = this.projects.filter(p => p.id !== id);
                            showToast('Project deleted successfully', 'success');
                        })
                        .catch(() => showToast('Deletion failed', 'error'));
                },

                formatDate(date) {
                    return new Date(date).toLocaleString();
                }
            };
        }
    </script>
@endsection
