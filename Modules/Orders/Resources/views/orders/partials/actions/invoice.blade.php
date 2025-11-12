@if(auth()->user()->hasPermission('show_orders') && $order->isCompleted())
    <a href="{{ route('dashboard.orders.invoice', $order) }}"
       class="btn btn-outline-success waves-effect waves-light btn-sm">
        <i class="fas fa-file-invoice"></i>
    </a>
@endcan
