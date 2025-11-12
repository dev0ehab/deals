@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_features'])
    @slot('url', route('dashboard.features.index'))
    @slot('name', trans('features::features.plural'))
    @slot('isActive', request()->routeIs('*features*'))
    @slot('icon', 'fas fa-tasks')
    @slot('tree', [
        [
            'name' => trans('features::features.actions.list'),
            'url' => route('dashboard.features.index'),
            'can' => ['permission' => 'read_features'],
            'isActive' => request()->routeIs('*features.index'),
            'module' => 'Features',
        ],
        [
            'name' => trans('features::features.actions.create'),
            'url' => route('dashboard.features.create'),
            'can' => ['permission' => 'create_features'],
            'isActive' => request()->routeIs('*features.create'),
            'module' => 'Features',
        ],
        // [
        //     'name' => trans('features::features.actions.order'),
        //     'url' => route('dashboard.order.form.features'),
        //     'can' => ['permission' => 'read_features'],
        //     'isActive' => request()->routeIs('*order.form.features'),
        //     'module' => 'Features',
        // ],
    ])
@endcomponent
