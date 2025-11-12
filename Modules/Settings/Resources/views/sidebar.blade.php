@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_settings'])
    @slot('url', route('dashboard.settings.index'))
    @slot('name', trans('settings::settings.plural'))
    @slot('isActive', request()->routeIs('*settings*'))
    @slot('icon', 'fas fa-cog')
    @php($trees = [
        [
            'name' => trans('settings::settings.main'),
            'url' => route('dashboard.settings.main'),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('*settings.main'),
            'module' => 'Settings',
        ],
        [
            'name' => trans('howknow::reasons.reason'),
            'url' => route('dashboard.reasons.index'),
            'can' => ['permission' => 'read_reasons'],
            'isActive' => request()->routeIs('*reasons.index'),
            'module' => 'HowKnow',
        ],
    ])
    @slot('tree', $trees)
@endcomponent
