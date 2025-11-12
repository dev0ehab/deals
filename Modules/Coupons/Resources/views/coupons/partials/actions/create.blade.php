@if(auth()->user()->hasPermission('create_coupons'))
    <a href="{{ route('dashboard.coupons.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('coupons::coupons.actions.create')
    </a>
@else
    {{-- <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('coupons::coupons.actions.create')
    </button> --}}
@endif
