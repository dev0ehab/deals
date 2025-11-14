@if(auth()->user()->hasPermission('create_vendors'))
    <a href="{{ route('dashboard.vendors.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('vendors::vendorsactions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('vendors::vendorsactions.create')
    </button>
@endif
