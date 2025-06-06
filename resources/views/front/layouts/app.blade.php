<!DOCTYPE html>
<html lang="en" class="light scroll-smooth" dir="ltr" x-data="{ dark: false }" :class="dark ? 'dark' : ''">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Advice Associates AI Real Estate CRM')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Advice Associates Real Estate AI CRM"  />
    <meta name="author" content="Salman@advice.pk" />
    <link rel="icon" href="{{ asset('assets/front/images/favicon.ico') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Vite CSS & JS --}}

    <link rel="stylesheet" href="{{ asset('assets/front/libs/tiny-slider/tiny-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/libs/tobii/css/tobii.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/libs/choices.js/public/assets/styles/choices.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/libs/swiper/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/libs/@iconscout/unicons/css/line.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/libs/@mdi/font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/tailwind.css') }}" />
    <!-- Additional Page-Specific Styles -->
    @stack('styles')
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

<!-- Switcher -->
    <div class="fixed top-1/4 -left-2 z-3">
            <span class="relative inline-block rotate-90">
                <input type="checkbox" class="checkbox opacity-0 absolute" id="chk" />
                <label class="label bg-slate-900 dark:bg-white shadow-sm dark:shadow-gray-700 cursor-pointer rounded-full flex justify-between items-center p-1 w-14 h-8" for="chk">
                    <i class="uil uil-moon text-[20px] text-yellow-500 mt-1"></i>
                    <i class="uil uil-sun text-[20px] text-yellow-500 mt-1"></i>
                    <span class="ball bg-white dark:bg-slate-900 rounded-full absolute top-[2px] start-[2px] size-7"></span>
                </label>
            </span>
    </div>
<!-- Switcher -->

<!-- LTR & RTL Mode Code -->
    <div class="fixed top-[40%] -left-3 z-50">
        <a href="" id="switchRtl">
            <span class="py-1 px-3 relative inline-block rounded-b-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow-sm dark:shadow-gray-800 font-semibold rtl:block ltr:hidden" >LTR</span>
            <span class="py-1 px-3 relative inline-block rounded-b-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow-sm dark:shadow-gray-800 font-semibold ltr:block rtl:hidden">RTL</span>
        </a>
    </div>
<!-- LTR & RTL Mode Code -->

<!-- Back to top -->
    <a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fixed hidden text-lg rounded-full z-10 bottom-5 end-5 size-9 text-center bg-green-600 text-white justify-center items-center"><i class="uil uil-arrow-up"></i></a>
<!-- Back to top -->

{{-- Global JS, --}}
<script src="{{ asset('assets/front/libs/tiny-slider/min/tiny-slider.js') }}"></script>
<script src="{{ asset('assets/front/libs/tobii/js/tobii.min.js') }}"></script>
<script src="{{ asset('assets/front/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
<script src="{{ asset('assets/front/libs/swiper/js/swiper.min.js') }}"></script>
<script src="{{ asset('assets/front/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/front/js/plugins.init.js') }}"></script>
<script src="{{ asset('assets/front/js/init.app.js') }}"></script>
{{-- Alpine.js (MUST load before any Alpine code runs) --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
{{-- Axios --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
