@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_advertisements'])
    @slot('url', route('dashboard.advertisements.index'))
    @slot('name', trans('advertisements::advertisements.plural'))
    @slot('isActive', request()->routeIs('*advertisements*'))
    @slot('icon', 'fas fa-ad')
    @slot('tree', [
        [
            'name' => trans('advertisements::advertisements.actions.list'),
            'url' => route('dashboard.advertisements.index'),
            'can' => ['permission' => 'read_advertisements'],
            'isActive' => request()->routeIs('*advertisements.index'),
            'module' => 'Advertisements',
        ],
        [
            'name' => trans('advertisements::advertisements.actions.create'),
            'url' => route('dashboard.advertisements.create'),
            'can' => ['permission' => 'create_advertisements'],
            'isActive' => request()->routeIs('*advertisements.create'),
            'module' => 'Advertisements',
        ],
    ])
@endcomponent
