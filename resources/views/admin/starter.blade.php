@extends('admin.layouts.app')

@section('title', 'Starter Page')

@section('meta_description', 'Advice Associates Real Estate AI CRM')
@section('meta_keywords', 'agency, application, business, clean, creative, real estate token, it solutions, modern, multipurpose, nft marketplace, portfolio, saas, software, tailwind css')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <!-- Page Header -->
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Starter Page</h5>

                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white-100/70 hover:text-green-600 dark:hover:text-white">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="inline-block text-base text-slate-950 dark:text-white-100/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white" aria-current="page">Starter Page</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="grid grid-cols-1 mt-6">
                <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900">
                    <p class="text-slate-400">Write your content here.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
