@if(auth()->user()->hasPermission('create_payments'))
    <a href="{{ route('dashboard.payments.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('payments::payments.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('payments::payments.actions.create')
    </button>
@endif
