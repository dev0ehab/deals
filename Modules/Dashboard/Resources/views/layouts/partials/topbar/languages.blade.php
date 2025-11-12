<div class="dropdown d-none d-sm-inline-block">
    <button type="button" class="btn header-item waves-effect" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <img class="" src="{{ Locales::getFlag() }}" alt="Header Language" height="16">
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        @foreach (Locales::get() as $locale)
            <!-- item-->
            <a href="{{ route('dashboard.locale', $locale->code) }}" class="dropdown-item notify-item">
                <img src="{{ $locale->flag }}" alt="user-image" class="mr-1" height="12"> <span
                    class="align-middle">{{ $locale->name }}</span>
            </a>
        @endforeach
    </div>
</div>
