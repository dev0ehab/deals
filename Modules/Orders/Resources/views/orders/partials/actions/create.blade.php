@if(auth()->user()->hasPermission('create_orders'))
    <a href="{{ route('dashboard.orders.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('orders::orders.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('orders::orders.actions.create')
    </button>
@endif
