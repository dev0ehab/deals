@component('dashboard::layouts.components.sidebarItem')
    @slot('can', [
        'permission' => 'read_settings',
        'read_countries',
        'read_roles',
        'read_users',
        ])
        @slot('name', trans('settings::settings.plural'))
        @slot('isActive', request()->routeIs('*settings*'))
            @slot('icon', 'fas fa-cogs')
            @php(
    $trees = [
        // settings app
        [
            'name' => trans('settings::settings.tabs.app'),
            'url' => route('dashboard.settings.index', ['tab' => 'app']),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('*settings*') && request('tab') == 'app',
            'module' => 'Settings',
            'icon' => 'fas fa-clinic-medical',
        ],
        // settings main
        [
            'name' => trans('settings::settings.tabs.main'),
            'url' => route('dashboard.settings.index', ['tab' => 'main']),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('*settings*') && request('tab') == 'main',
            'module' => 'Settings',
            'icon' => 'fas fa-cog',
        ],
        // settings contacts
        [
            'name' => trans('settings::settings.tabs.contacts'),
            'url' => route('dashboard.settings.index', ['tab' => 'contacts']),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('*settings*') && request('tab') == 'contacts',
            'module' => 'Settings',
            'icon' => 'fas fa-address-card',
        ],
        // settings social
        [
            'name' => trans('settings::settings.tabs.social'),
            'url' => route('dashboard.settings.index', ['tab' => 'social']),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('*settings*') && request('tab') == 'social',
            'module' => 'Settings',
            'icon' => 'fab fa-facebook',
        ],
        // static pages
        [
            'name' => trans('Pages'),
            'url' => route('dashboard.pages'),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('dashboard.pages'),
            'module' => 'Settings',
            'icon' => 'fas fa-copy',
        ],
    ]
)
            @slot('tree', $trees)
        @endcomponent
