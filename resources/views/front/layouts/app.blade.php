<!DOCTYPE html>
<html lang="en" class="light scroll-smooth" dir="ltr" x-data="{ dark: false }" :class="dark ? 'dark' : ''">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Advice Associates AI Real Estate CRM')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Advice Associates Real Estate AI CRM"  />
    <meta name="author" content="Salman@advice.pk" />
    <link rel="icon" href="{{ asset('assets/front/images/favicon.ico') }}" />


    <link rel="stylesheet" href="{{ asset('assets/front/libs/tiny-slider/tiny-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/libs/tobii/css/tobii.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/libs/choices.js/public/assets/styles/choices.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/libs/@iconscout/unicons/css/line.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/libs/@mdi/font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/tailwind.css') }}" />
</head>
<body class="dark:bg-slate-900">

{{-- Navbar --}}
@include('front.partials.navbar')

{{-- Page Content --}}
<main>
    @yield('content')
</main>

{{-- Footer --}}
@include('front.partials.footer')

{{-- Global JS, --}}
<script src="{{ asset('assets/front/libs/tiny-slider/min/tiny-slider.js') }}"></script>
<script src="{{ asset('assets/front/libs/tobii/js/tobii.min.js') }}"></script>
<script src="{{ asset('assets/front/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
<script src="{{ asset('assets/front/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/front/js/plugins.init.js') }}"></script>
<script src="{{ asset('assets/front/js/init.app.js') }}"></script>

{{-- Example: Theme/Dark Switch --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('theme', {
            dark: false,
            toggle() { this.dark = !this.dark }
        });
    });
</script>
@stack('scripts')
</body>
</html>
