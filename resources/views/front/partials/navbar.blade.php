<nav id="topnav" class="defaultscroll is-sticky">
    <div class="container relative">
        <!-- Logo -->
        <a class="logo" href="{{ url('/') }}">
            <img src="{{ asset('assets/front/images/logo-dark.png') }}" class="inline-block dark:hidden" alt="Advice Associates">
            <img src="{{ asset('assets/front/images/logo-light.png') }}" class="hidden dark:inline-block" alt="Advice Associates">
        </a>

        <!-- Mobile Toggle -->
        <div class="menu-extras">
            <div class="menu-item">
                <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Login / Signup -->
        <ul class="buy-button list-none mb-0">
            <li class="inline mb-0">
                <a href="{{ route('login') }}" class="btn btn-icon bg-green-600 hover:bg-green-700 border-green-600 dark:border-green-600 text-white rounded-full">
                    <i class="uil uil-user-circle"></i>
                </a>
            </li>
            <li class="sm:inline ps-1 mb-0 hidden">
                <a href="{{ route('register') }}" class="btn bg-green-600 hover:bg-green-700 border-green-600 dark:border-green-600 text-white rounded-full"><i class="uil uil-user-plus me-1"></i>Signup</a>
            </li>
        </ul>

        <!-- Navigation Menu -->
        <div id="navigation">
            <ul class="navigation-menu justify-end">
                @foreach(config('menu.items', []) as $item)
                    <li class="{{ isset($item['children']) ? 'has-submenu parent-parent-menu-item' : '' }}">
                        <a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                        @if (!empty($item['children']) && is_array($item['children']))
                            <span class="menu-arrow"></span>
                            <ul class="submenu">
                                @foreach($item['children'] as $child)
                                    @if (!empty($child['children']) && is_array($child['children']))
                                        <li class="has-submenu parent-menu-item">
                                            <a href="javascript:void(0)">{{ $child['title'] }}</a>
                                            <span class="submenu-arrow"></span>
                                            <ul class="submenu">
                                                @foreach($child['children'] as $subchild)
                                                    <li><a href="{{ $subchild['url'] }}" class="sub-menu-item">{{ $subchild['title'] }}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li><a href="{{ $child['url'] }}" class="sub-menu-item">{{ $child['title'] }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
