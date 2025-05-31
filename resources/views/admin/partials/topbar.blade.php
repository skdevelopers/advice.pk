<!-- ====================== HEADER START ====================== -->
<div class="top-header">
    <div class="header-bar flex justify-between">

        <!-- LEFT HEADER SECTION: Logo and Navigation Controls -->
        <div class="flex items-center space-x-1">

            <!-- Responsive Logo: Visible on mobile/tablet (xl:hidden) -->
            <a href="#" class="xl:hidden block me-2">
                <!-- Mobile Logo Icon -->
                <img src="{{ asset('assets/admin/images/logo-icon-32.png') }}"
                     class="md:hidden block"
                     alt="Advice Logo">

                <!-- Desktop Logos (Dark/Light Mode Variants) -->
                <span class="md:block hidden">
                    <img src="{{ asset('assets/admin/images/logo-dark.png') }}"
                         class="inline-block dark:hidden"
                         alt="Dark Mode Logo">
                    <img src="{{ asset('assets/admin/images/logo-light.png') }}"
                         class="hidden dark:inline-block"
                         alt="Light Mode Logo">
                </span>
            </a>

            <!-- SIDEBAR TOGGLE BUTTON -->
            <a id="close-sidebar"
               class="size-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-blue rounded-md"
               href="javascript:void(0)"
               aria-label="Toggle sidebar navigation">
                <i data-feather="menu" class="size-4"></i>
            </a>

            <!-- SEARCH BAR: Visible on sm screens and up -->
            <div class="ps-1.5">
                <div class="form-icon relative sm:block hidden">
                    <i class="mdi mdi-magnify absolute top-1/2 -translate-y-1/2 mt-[1px] start-3"></i>
                    <input type="text"
                           class="form-input w-56 py-2 px-3 !ps-9 !h-8 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded-md outline-none border !border-gray-200 dark:!border-gray-800 focus:ring-0"
                           name="s"
                           id="searchItem"
                           placeholder="Search..."
                           aria-label="Search interface">
                </div>
            </div>
        </div>

        <!-- RIGHT HEADER SECTION: User Controls -->
        <ul class="list-none mb-0 space-x-1">

            <!-- LANGUAGE SELECTOR DROPDOWN -->
            <li class="dropdown inline-block relative">
                <!-- Trigger Button -->
                <button data-dropdown-toggle="dropdown"
                        class="dropdown-toggle size-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-blue rounded-md"
                        type="button"
                        aria-haspopup="true"
                        aria-expanded="false">
                    <img src="{{ asset('assets/admin/images/flags/usa.png') }}"
                         class="size-6 rounded-md"
                         alt="Current Language Flag">
                </button>

                <!-- Language List -->
                <div class="dropdown-menu absolute end-0 m-0 mt-4 z-10 w-36 rounded-md overflow-hidden bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-700 hidden">
                    <ul class="list-none py-2 text-start">
                        @foreach(['germany', 'italy', 'russia', 'spain'] as $country)
                            <li class="my-1">
                                <a href="#"
                                   class="flex items-center text-[15px] font-medium py-1.5 px-4 dark:text-blue/70 hover:text-green-600 dark:hover:text-white"
                                   role="menuitem">
                                    <img src="{{ asset('assets/admin/images/flags/' . $country . '.png') }}"
                                         class="size-6 rounded-md me-2 shadow-sm dark:shadow-gray-700"
                                         alt="{{ ucfirst($country) }} Flag">
                                    {{ ucfirst($country) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>

            <!-- NOTIFICATIONS DROPDOWN -->
            <li class="dropdown inline-block relative">
                <!-- Trigger Button with Badge -->
                <button data-dropdown-toggle="dropdown"
                        class="dropdown-toggle size-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-blue rounded-md"
                        type="button"
                        aria-label="Notifications">
                    <i data-feather="bell" class="size-4"></i>
                    <span class="absolute top-0 end-0 flex items-center justify-center bg-red-600 text-white text-[10px] font-bold rounded-md size-2 after:content-[''] after:absolute after:h-2 after:w-2 after:bg-red-600 after:top-0 after:end-0 after:rounded-md after:animate-ping">
                        {{-- Dynamic Notification Count --}}
                        {{ $notificationCount ?? 0 }}
                    </span>
                </button>

                <!-- Notifications Panel -->
                <div class="dropdown-menu absolute end-0 m-0 mt-4 z-10 w-64 rounded-md overflow-hidden bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-700 hidden">
                    <div class="px-4 py-4 flex justify-between">
                        <span class="font-semibold">Notifications</span>
                        <span class="flex items-center justify-center bg-red-600/20 text-red-600 text-[10px] font-bold rounded-md w-5 max-h-5 ms-1">
                            {{ $notificationCount ?? 0 }}
                        </span>
                    </div>

                    <!-- Notifications List with Scrollbar -->
                    <ul class="py-2 text-start h-64 border-t border-gray-100 dark:border-gray-800"
                        data-simplebar
                        role="menu">
                        @forelse($notifications ?? [] as $notification)
                            <li role="none">
                                <a href="#"
                                   class="block font-medium py-1.5 px-4"
                                   role="menuitem">
                                    <div class="flex items-center">
                                        <div class="size-10 rounded-md shadow-sm shadow-green-600/10 dark:shadow-gray-700 bg-green-600/10 dark:bg-slate-800 text-green-600 dark:text-blue flex items-center justify-center">
                                            <i data-feather="{{ $notification['icon'] }}" class="size-4"></i>
                                        </div>
                                        <div class="ms-2">
                                            <span class="text-[15px] font-medium block">{{ $notification['title'] }}</span>
                                            <small class="text-slate-400">{{ $notification['time'] }}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="px-4 py-6 text-center text-slate-400" role="none">
                                <i class="mdi mdi-bell-off-outline text-2xl"></i>
                                <p class="mt-2 text-sm">No new notifications</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </li>

            <!-- USER PROFILE DROPDOWN -->
            <li class="dropdown inline-block relative">
                <!-- Profile Avatar -->
                <button data-dropdown-toggle="dropdown"
                        class="dropdown-toggle items-center"
                        type="button"
                        aria-label="User menu">
                    <span class="size-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-blue rounded-md">
                        @auth
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/admin/images/client/07.jpg') }}"
                                 class="rounded-md"
                                 alt="User profile picture">
                        @else
                            <i class="mdi mdi-account-circle text-xl"></i>
                        @endauth
                    </span>
                </button>

                <!-- Dropdown Menu -->
                <div class="dropdown-menu absolute end-0 m-0 mt-4 z-10 w-44 rounded-md overflow-hidden bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-700 hidden">
                    <ul class="py-2 text-start" role="menu">
                        @auth
                            <!-- Authenticated Menu -->
                            <li role="none">
                                <a href="{{ route('profile') }}"
                                   class="block py-1 px-4 dark:text-blue/70 hover:text-green-600 dark:hover:text-white"
                                   role="menuitem">
                                    <i class="mdi mdi-account-outline me-2"></i>Profile
                                </a>
                            </li>
                            <li role="none">
                                <a href="{{ route('chat') }}"
                                   class="block py-1 px-4 dark:text-blue/70 hover:text-green-600 dark:hover:text-white"
                                   role="menuitem">
                                    <i class="mdi mdi-chat-outline me-2"></i>Chat
                                </a>
                            </li>
                            <li role="none">
                                <a href="{{ route('settings') }}"
                                   class="block py-1 px-4 dark:text-blue/70 hover:text-green-600 dark:hover:text-white"
                                   role="menuitem">
                                    <i class="mdi mdi-cog-outline me-2"></i>Settings
                                </a>
                            </li>
                            <li class="border-t border-gray-100 dark:border-gray-800 my-2" role="separator"></li>
                            <li role="none">
                                <a href="{{ route('lockscreen') }}"
                                   class="block py-1 px-4 dark:text-blue/70 hover:text-green-600 dark:hover:text-white"
                                   role="menuitem">
                                    <i class="mdi mdi-lock-outline me-2"></i>Lockscreen
                                </a>
                            </li>
                            <li role="none">
                                <a href="{{ route('logout') }}"
                                   class="block py-1 px-4 dark:text-blue/70 hover:text-green-600 dark:hover:text-white"
                                   role="menuitem"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-logout me-2"></i>Logout
                                </a>
                            </li>
                        @else
                            <!-- Guest Menu -->
                            <li role="none">
                                <a href="{{ route('login') }}"
                                   class="block py-1 px-4 dark:text-blue/70 hover:text-green-600 dark:hover:text-white"
                                   role="menuitem">
                                    <i class="mdi mdi-login me-2"></i>Login
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- ====================== HEADER END ====================== -->

<!-- Hidden Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>