@if(auth()->user()->hasPermission($role))
    <div class="col-xl-3 mb-4">
        <!--begin::Stats Widget-->
        <div class="card card-custom {{ $color ? 'bg-' . $color : '' }} bgi-no-repeat card-stretch gutter-b">
            <!--begin::Body-->
            <div class="card-body">
                @isset($icon)
                    <i class="{{ $icon }} fa-2x text-white"></i>
                @endif
                <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">
                    {{ $count ?? '0' }}
                </span>
                <span class="font-weight-bold text-white font-size-sm">
                    {{ $name ?? '----' }}
                </span>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Stats Widget-->
    </div>
@endif
