@if(auth()->user()->hasPermission('create_vendors'))
    <a href="{{ route('dashboard.vendors.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('vendors::vendors.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('vendors::vendors.actions.create')
    </button>
@endif
