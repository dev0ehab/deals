@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_vendors'])
    @slot('url', route('dashboard.vendors.index'))
    @slot('name', trans('vendors::vendorss.plural'))
    @slot('isActive', request()->routeIs('*vendors*'))
    @slot('icon', 'fas fa-user-check')
    @slot('tree', [
        [
            'name' => trans('vendors::vendorss.actions.list'),
            'url' => route('dashboard.vendors.index'),
            'can' => ['permission' => 'read_vendors'],
            'isActive' => request()->routeIs('*vendors*'),
            'module' => 'Vendors',
        ],
        [
            'name' => trans('vendors::vendorss.actions.create'),
            'url' => route('dashboard.vendors.create'),
            'can' => ['permission' => 'create_vendors'],
            'isActive' => request()->routeIs('*vendors.create'),
            'module' => 'Vendors',
        ],
    ])
@endcomponent
