@if (auth()->user()->hasPermission('show_payments'))
    <a href="{{ route('dashboard.payments.show', $payment) }}"
        class="btn btn-outline-warning waves-effect waves-light btn-sm">
        <i class="fas fa fa-fw fa-eye"></i>
    </a>
@else
    <button type="button" disabled class="btn btn-icon btn-light-warning btn-hover-warning btn-sm">
        <i class="fas fa fa-fw fa-eye"></i>
    </button>
@endcan
