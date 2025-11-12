@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_notifications'])
    @slot('url', route('dashboard.notifications.index'))
    @slot('name', trans('notifications::notifications.plural'))
    @slot('isActive', request()->routeIs('*notifications*'))
    @slot('icon', 'fas fa-bell')
    @slot('tree', [
        [
            'name' => trans('notifications::notifications.actions.list'),
            'url' => route('dashboard.notifications.index'),
            'can' => ['permission' => 'read_notifications'],
            'isActive' => request()->routeIs('*notifications.index'),
            'module' => 'Notifications',
        ],
        [
            'name' => trans('notifications::notifications.actions.create'),
            'url' => route('dashboard.notifications.create'),
            'can' => ['permission' => 'create_notifications'],
            'isActive' => request()->routeIs('*notifications.create'),
            'module' => 'Notifications',
        ],
    ])
@endcomponent
