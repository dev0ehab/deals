<div class="user-wid text-center py-4">
    <div class="user-img">
        <img src="{{ auth()->user()->getAvatar() }}" alt="" class="avatar-md mx-auto rounded-circle">
    </div>

    <div class="mt-3">


        <a href="{{ route('dashboard.admins.profile') }}"
            class="text-dark font-weight-medium font-size-16">{{ auth()->user()->name }}</a>

    </div>
</div>
