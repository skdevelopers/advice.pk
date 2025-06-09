@extends('admin.layouts.app')

@section('title', 'Society Pages')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Society Pages</h5>
                <a href="{{ route('admin.society-pages.create') }}"
                   class="btn bg-primary text-white hover:bg-blue-700 rounded px-4 py-2">+ Add Page</a>
            </div>

            @include('admin.components.toast')

            <div class="grid grid-cols-1 mt-6">
                <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium">Title</th>
                            <th class="px-6 py-3 text-left font-medium">Slug</th>
                            <th class="px-6 py-3 text-left font-medium">Created By</th>
                            <th class="px-6 py-3 text-right font-medium">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach ($societyPages as $page)
                            <tr>
                                <td class="px-6 py-4">{{ $page->title }}</td>
                                <td class="px-6 py-4">{{ $page->slug }}</td>
                                <td class="px-6 py-4">{{ $page->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.society-pages.edit', $page->id) }}"
                                           class="text-blue-600 hover:text-blue-800">Edit</a>
                                        <form action="{{ route('admin.society-pages.destroy', $page->id) }}" method="POST"
                                              onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
