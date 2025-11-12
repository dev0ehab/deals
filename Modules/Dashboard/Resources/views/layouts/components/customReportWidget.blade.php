<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <div>
                        <p class="text-muted fw-medium mt-1 mb-2">
                            <a href="{{ $route ?? '#' }}" class="text-{{ $color ?: 'primary' }}">
                                {{ $name ?? '----' }}
                            </a>
                        </p>
                        <h4 class="{{ $fontSize ?? '' }}">
                            {{ $count ?? '0' }}
                        </h4>
                    </div>
                </div>
                @isset($icon)
                    <div class="col-4">
                        <div class="font-size-20 me-3">
                            <span
                                class="avatar-title bg-soft-{{ $color ?: 'primary' }} text-{{ $color ?: 'primary' }} rounded">
                                <i class="{{ $icon }} fa-2x"></i>
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

