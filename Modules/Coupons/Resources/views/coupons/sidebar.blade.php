@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_coupons'])
    @slot('url', route('dashboard.coupons.index'))
    @slot('name', trans('coupons::coupons.plural'))
    @slot('isActive', request()->routeIs('*coupons*'))
    @slot('icon', 'fas fa-percent')
    @slot('tree', [
        [
            'name' => trans('coupons::coupons.actions.list'),
            'url' => route('dashboard.coupons.index'),
            'can' => ['permission' => 'read_coupons'],
            'isActive' => request()->routeIs('*coupons.index'),
            'module' => 'Coupons',
        ],
        [
            'name' => trans('coupons::coupons.actions.create'),
            'url' => route('dashboard.coupons.create'),
            'can' => ['permission' => 'create_coupons'],
            'isActive' => request()->routeIs('*coupons.create'),
            'module' => 'Coupons',
        ],
    ])
@endcomponent
