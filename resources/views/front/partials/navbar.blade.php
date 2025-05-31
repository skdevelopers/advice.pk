<nav id="topnav" class="defaultscroll is-sticky">
    <div class="container relative flex justify-between items-center">
        <a class="logo" href="{{ url('/') }}">
            <img src="{{ asset('assets/front/images/logo-dark.png') }}" class="inline-block dark:hidden" alt="Logo">
            <img src="{{ asset('assets/front/images/logo-light.png') }}" class="hidden dark:inline-block" alt="Logo">
        </a>

        <div class="flex items-center space-x-6">
            <ul class="navigation-menu flex space-x-4">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/buy') }}">Buy</a></li>
                <li><a href="{{ url('/sell') }}">Sell</a></li>
                <li><a href="{{ url('/listings') }}">Listing</a></li>
                <li><a href="{{ url('/contact') }}">Contact</a></li>
            </ul>
        </div>
        <div class="flex items-center">
            <a href="{{ route('login') }}" class="btn btn-icon bg-green-600 text-white !rounded-full mr-2">
                <i class="mdi mdi-account"></i>
            </a>
            <a href="{{ route('register') }}" class="btn bg-green-600 text-white !rounded-full hidden sm:inline">
                Signup
            </a>
        </div>
    </div>
</nav>
