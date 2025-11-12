@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_admins'])
    @slot('url', route('dashboard.admins.index'))
    @slot('name', trans('accounts::admins.plural'))
    @slot('isActive', request()->routeIs('*admins*'))
    @slot('icon', 'fas fa-users-cog')
    @slot('tree', [
        [
            'name' => trans('accounts::admins.actions.list'),
            'url' => route('dashboard.admins.index'),
            'can' => ['permission' => 'read_admins'],
            'isActive' => request()->routeIs('*admins.index'),
            'module' => 'Accounts',
        ],
        [
            'name' => trans('accounts::admins.actions.create'),
            'url' => route('dashboard.admins.create'),
            'can' => ['permission' => 'create_admins'],
            'isActive' => request()->routeIs('*admins.create'),
            'module' => 'Accounts',
        ],
    ])
@endcomponent
