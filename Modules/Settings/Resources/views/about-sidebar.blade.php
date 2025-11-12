@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_settings'])
    @slot('url', route('dashboard.settings.index'))
    @slot('name', trans('settings::settings.tabs.about'))
    @slot('isActive', request()->routeIs('*about-us*') || request()->routeIs('*awards*'))
    @slot('icon', 'fas fa-file-invoice')
    @php(
    $trees = [
        [
            'name' => trans('Data'),
            'url' => route('dashboard.about-us'),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('dashboard.about-us'),
            'module' => 'Settings',
        ],
        [
            'name' => trans('Map One'),
            'url' => route('dashboard.map1'),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('dashboard.map1'),
            'module' => 'Settings',
        ],
        [
            'name' => trans('Map Two'),
            'url' => route('dashboard.map2'),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('dashboard.map2'),
            'module' => 'Settings',
        ]
    ]
)
    @slot('tree', $trees)
@endcomponent
