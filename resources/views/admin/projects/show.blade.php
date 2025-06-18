@extends('admin.layouts.app')

@section('title', $project->title)

@section('content')
    <div class="container-fluid px-3">
        <div class="layout-specing">
            <div class="flex justify-between items-center mb-6">
                <h5 class="text-lg font-semibold">Project Details</h5>
                <ul class="inline-flex space-x-2 text-sm">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Dashboard</a></li>
                    <li><i class="mdi mdi-chevron-right text-gray-400"></i></li>
                    <li><a href="{{ route('admin.projects.index') }}" class="hover:text-green-600">Projects</a></li>
                    <li><i class="mdi mdi-chevron-right text-gray-400"></i></li>
                    <li class="text-green-600">{{ $project->title }}</li>
                </ul>
            </div>

            <div class="rounded-md shadow-sm bg-white p-6 dark:bg-slate-900">
                <h1 class="text-2xl font-bold mb-2 text-gray-900 dark:text-white">{{ $project->title }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Slug: <strong>{{ $project->slug }}</strong><br>
                    Heading: <strong>{{ $project->heading }}</strong><br>
                    Domain: <strong>{{ $project->domain }}</strong><br>
                    Coordinates: <strong>{{ $project->latitude }}, {{ $project->longitude }}</strong>
                </p>

                <div class="mb-6">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Meta</h2>
                    <p><strong>Keywords:</strong> {{ $project->meta_keywords }}</p>
                    <p><strong>Description:</strong> {{ $project->meta_description }}</p>
                </div>

                <div class="mb-6">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Description</h2>
                    <div class="prose max-w-none dark:prose-invert">
                        {!! $project->description !!}
                    </div>
                </div>

                @if($project->getMedia('gallery')->isNotEmpty())
                    <div class="mb-6">
                        <h2 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Gallery</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($project->getMedia('gallery') as $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    <img src="{{ $media->getUrl('thumb') }}"
                                         alt="Gallery Image"
                                         class="w-full h-40 object-cover rounded shadow">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($project->getFirstMediaUrl('floor_plan'))
                    <div class="mb-6">
                        <h2 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Floor Plan</h2>
                        <a href="{{ $project->getFirstMediaUrl('floor_plan') }}"
                           target="_blank"
                           class="text-blue-600 hover:underline">Download Floor Plan</a>
                    </div>
                @endif

                <div class="mt-6 text-right">
                    <a href="{{ route('admin.projects.edit', $project) }}"
                       class="btn bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">Edit Project</a>
                </div>
            </div>
        </div>
    </div>
@endsection
