@extends('admin.layouts.app')

@section('title', $page->title)

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">{{ $page->title }}</h5>
            </div>

            <div class="grid grid-cols-1 mt-6">
                <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $page->heading }}</h2>
                    <div class="prose prose-lg mt-6 text-gray-800 dark:text-gray-200">
                        {!! $page->detail !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
