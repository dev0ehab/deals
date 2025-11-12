@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_payments'])
    @slot('url', route('dashboard.payments.index'))
    @slot('name', trans('payments::payments.plural'))
    @slot('isActive', request()->routeIs('*payments*'))
    @slot('icon', 'fas fa-money-check')
    @slot('tree', [
        [
            'name' => trans('payments::payments.actions.list'),
            'url' => route('dashboard.payments.index'),
            'can' => ['permission' => 'read_payments'],
            'isActive' => request()->routeIs('*payments.index'),
            'module' => 'Payments',
        ],
        [
            'name' => trans('payments::payments.actions.create'),
            'url' => route('dashboard.payments.create'),
            'can' => ['permission' => 'create_payments'],
            'isActive' => request()->routeIs('*payments.create'),
            'module' => 'Payments',
        ]
    ])
@endcomponent
