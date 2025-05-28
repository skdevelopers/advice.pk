<nav id="sidebar" class="sidebar-wrapper sidebar-dark">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <a href="{{ url('admin') }}">
                <img src="{{ asset('assets/admin/images/logo-light.png') }}" alt="Logo">
            </a>
        </div>

        <ul class="sidebar-menu border-t border-white/10" data-simplebar style="height: calc(100% - 70px);">
            <li class="menu-title">Navigation</li>

            <li>
                <a href="{{ url('admin') }}">
                    <i class="mdi mdi-view-dashboard"></i> Dashboard
                </a>
            </li>

            {{--            <li>--}}
            {{--                <a href="{{ url('admin/project_realtor') }}">--}}
            {{--                    <i class="mdi mdi-projector-screen"></i> Project Realtor--}}
            {{--                </a>--}}
            {{--            </li>--}}

            <li>
                <a href="{{ url('admin/crm') }}">
                    <i class="mdi mdi-leaf"></i> CRM
                </a>
            </li>

            <li class="sidebar-dropdown">
                <a href="javascript:void(0)">
                    <i class="mdi mdi-folder-multiple-image"></i> City
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ url('admin/cities/create') }}">Add New City</a></li>
                        <li><a href="{{ url('admin/cities') }}">View Cities</a></li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-dropdown">
                <a href="javascript:void(0)">
                    <i class="mdi mdi-home-map-marker"></i> Manage Societies
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ url('admin/societies/create') }}">Add New Society</a></li>
                        <li><a href="{{ url('admin/societies') }}">View All Societies</a></li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-dropdown">
                <a href="javascript:void(0)">
                    <i class="mdi mdi-home-map-marker"></i> Sub Society | Sector
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ url('admin/subsectors/create') }}">Add New Sub </a></li>
                        <li><a href="{{ url('admin/subsectors') }}">View All Sub </a></li>
                    </ul>
                </div>
            </li>

{{--            <li class="sidebar-dropdown">--}}
{{--                <a href="javascript:void(0)">--}}
{{--                    <i class="mdi mdi-home-map-marker"></i> Sub Societies--}}
{{--                </a>--}}
{{--                <div class="sidebar-submenu">--}}
{{--                    <ul>--}}
{{--                        <li><a href="{{ url('admin/subsocieties/create') }}">Add New Sub Society</a></li>--}}
{{--                        <li><a href="{{ url('admin/subsocieties') }}">View All Sub Societies</a></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}

            <li class="sidebar-dropdown">
                <a href="javascript:void(0)">
                    <i class="mdi mdi-home-map-marker"></i> Society Pages
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ url('admin/societies') }}">Add New Society Page</a></li>
                        <li><a href="{{ url('admin/societies/create') }}">View Society Pages</a></li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-dropdown">
                <a href="javascript:void(0)">
                    <i class="mdi mdi-home"></i> Manage Properties
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ url('admin/properties') }}">Properties</a></li>
                        <li><a href="{{ url('admin/properties/create') }}">Add New Property</a></li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-dropdown">
                <a href="javascript:void(0)">
                    <i class="mdi mdi-home-map-marker"></i> Manage Projects
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ url('admin/projects/create') }}">Add New Project</a></li>
                        <li><a href="{{ url('admin/projects') }}">View All Projects</a></li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-dropdown">
                <a href="javascript:void(0)">
                    <i class="mdi mdi-home-map-marker"></i> Manage Blogs
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ url('admin/blogs') }}">View All Blogs</a></li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-dropdown">
                <a href="javascript:void(0)">
                    <i class="mdi mdi-account-network"></i> Projects Inquiry
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ url('admin/projects-inquiry') }}">Projects Inquiry</a></li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</nav>
