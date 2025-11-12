<header id="page-topbar">
    <div class="navbar-header">
        <div class="container-fluid">
            <div class="float-right">

                {{-- languages --}}
                @include('dashboard::layouts.partials.topbar.languages')
                {{-- full screen --}}
                @include('dashboard::layouts.partials.topbar.full_screen')
                {{-- notifications --}}
                @include('dashboard::layouts.partials.topbar.notifications')
                {{-- admin info --}}
                @include('dashboard::layouts.partials.topbar.admin_info')
                {{-- side bar toggle --}}
                {{-- @include('dashboard::partials.settings') --}}

            </div>
            <div>
                <!-- LOGO -->
                @include('dashboard::layouts.partials.topbar.logo')

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                    id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <!-- App Search-->
                @include('dashboard::layouts.partials.topbar.search')
                <!-- Mega Menu-->
                {{-- @include('dashboard::partials.mega_menu') --}}
            </div>

        </div>
    </div>
</header>
