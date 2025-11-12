@php
    use Modules\Orders\Entities\Order;

    $count = Order::whereStatus(['PENDING'])->count();
@endphp

@component('dashboard::layouts.components.sidebarItem')
@slot('can', ['permission' => 'read_orders'])
@slot('url', route('dashboard.orders.index'))
@slot('name', trans('orders::orders.plural'))
@slot('isActive', request()->routeIs('*orders*'))
@slot('badge', $count)
@slot('icon', 'fas fa-shopping-basket')

@slot('tree', [
    [
        'name' => trans('orders::orders.actions.list'),
        'url' => route('dashboard.orders.index'),
        'can' => ['permission' => 'read_orders'],
        'isActive' => request()->routeIs('*orders.index'),
        'module' => 'Orders',
    ],
    [
        'name' => trans('orders::rates.actions.list'),
        'url' => route('dashboard.rates.index'),
        'can' => ['permission' => 'read_orders'],
        'isActive' => request()->routeIs('*rates.index'),
        'module' => 'Orders',
    ]
])
@endcomponent
