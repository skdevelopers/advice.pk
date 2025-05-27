<!DOCTYPE html>
<html lang="en" class="light scroll-smooth" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Advice Associates Real Estate Dashboard')</title>
    <meta name="description" content="@yield('meta_description', 'Advice Associates real estate CRM & Software Landing Page')">
    <meta name="keywords" content="@yield('meta_keywords', 'real estate, saas, admin, advice associates')">
    <meta name="author" content="Salman@Advice.pk">
    <meta name="website" content="https://advice.pk">
    <meta name="email" content="support@advice.pk">
    <meta name="version" content="1.0.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">

    <!-- External CSS Libraries -->
    <link href="{{ asset('assets/admin/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/libs/simplebar/simplebar.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/tailwind.css') }}">

    <!-- Additional Page-Specific Styles -->
    @stack('styles')
</head>
<body class="font-league text-base text-black dark:text-white dark:bg-slate-900">

{{-- Loader (optional) --}}
{{-- @include('partials.loader') --}}

<div class="page-wrapper toggled">

    <!-- sidebar-wrapper -->
    @include('admin.partials.sidebar')
    <!-- sidebar-wrapper  -->
    <!-- Start Page Content -->
    <main class="page-content bg-gray-50 dark:bg-slate-800">
        <!-- Top Header -->
        @include('admin.partials.topbar')
        <!-- Top Header -->
        @include('admin.components.toast')
        @yield('content')
        <!-- Start Footer" -->
        @include('admin.partials.footer')
        <!--End Footer" -->
    </main>
    <!--End page-content" -->

</div>
<!-- page-wrapper -->
<!-- Switcher -->
@include('admin.partials.switcher') {{-- Optional component --}}
<!-- Switcher -->
<script src="{{ asset('assets/admin/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins.init.js') }}"></script>
<script src="{{ asset('assets/admin/js/theme.js') }}"></script>
<!-- JAVASCRIPT -->
@stack('scripts')
<!-- Scripts -->
</body>
</html>
