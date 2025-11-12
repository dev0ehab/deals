<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div class="h-100">
    {{--admin user info--}}
    @include('dashboard::layouts.partials.sidebar.admin_info')

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
{{--                <li class="menu-title">Menu</li>--}}

                @include('dashboard::sidebar')

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
