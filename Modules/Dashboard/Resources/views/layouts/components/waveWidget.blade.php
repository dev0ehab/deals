@if(auth()->user()->hasPermission($role))
    <div class="col-lg-4">
        <!--begin::Callout-->
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <!--begin::Icon-->
                    <div>
                        @isset($icon)
                            <i class="{{ $icon }} fa-4x text-{{ $color ?? 'primary' }}"></i>
                        @endif
                    </div>
                    <!--end::Icon-->
                    <!--begin::Content-->
                    <div class="d-flex flex-column ml-3">
                        <a href="{{ $route }}"
                           class="text-{{ $color ?? 'primary' }} font-weight-bold font-size-h4 mb-3">
                            {{ $name ?? '----' }}
                        </a>
                        @isset($description)
                            <div class="text-dark-75">{{ $description }}</div>
                        @endif
                    </div>
                    <!--end::Content-->
                </div>
            </div>
        </div>
        <!--end::Callout-->
    </div>
@endif
