@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_roles'])
    @slot('url', route('dashboard.roles.index'))
    @slot('name', trans('roles::roles.plural'))
    @slot('isActive', request()->routeIs('*roles*'))
    @slot('icon', 'fas fa-user-lock')
    @slot('tree', [
        [
            'name' => trans('roles::roles.actions.list'),
            'url' => route('dashboard.roles.index'),
            'can' => ['permission' => 'read_roles'],
            'isActive' => request()->routeIs('*roles.index'),
            'module' => 'Roles',
        ],
        [
            'name' => trans('roles::roles.actions.create'),
            'url' => route('dashboard.roles.create'),
            'can' => ['permission' => 'create_roles'],
            'isActive' => request()->routeIs('*roles.create'),
            'module' => 'Roles',
        ],
    ])
@endcomponent
