<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <img class="rounded-circle header-profile-user" src="{{ auth()->user()->getAvatar() }}" alt="Header Avatar">
        <span class="d-none d-xl-inline-block ml-1">{{ auth()->user()->name }}</span>
        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right">



        <!-- item-->
        <a class="dropdown-item" href="{{ route('dashboard.admins.profile') }}">
            <i class="bx bx-user font-size-16 align-middle mr-1"></i>
            @lang('accounts::admins.my_profile')
        </a>


        {{--        <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle mr-1"></i> Lock screen</a> --}}
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="#"
            onclick="event.preventDefault();document.getElementById('logoutForm').submit()">
            <i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i>
            @lang('admin.auth.logout')
        </a>

        <form style="display: none;" action="{{ route('logout') }}" method="post" id="logoutForm">
            @csrf
        </form>
    </div>
</div>
