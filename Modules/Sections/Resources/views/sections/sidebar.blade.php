@component('dashboard::layouts.components.sidebarItem')
        @slot('can', ['permission' => 'read_sections'])
    @slot('url', route('dashboard.sections.index'))
    @slot('name', trans('sections::sections.plural'))
    @slot('isActive', request()->routeIs('*sections*'))
    @slot('icon', 'fas fa-map-marked-alt')

    @slot('tree', [
        [
            'name' => trans('sections::sections.actions.list'),
            'url' => route('dashboard.sections.index'),
            'can' => ['permission' => 'read_sections'],
            'isActive' => request()->routeIs('*sections.index'),
            'module' => 'Sections',
        ],
        [
            'name' => trans('sections::sections.actions.create'),
            'url' => route('dashboard.sections.create'),
            'can' => ['permission' => 'create_sections'],
            'isActive' => request()->routeIs('*sections.create'),
            'module' => 'Sections',
        ]
    ])
@endcomponent
