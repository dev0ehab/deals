@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_categories'])
    @slot('url', route('dashboard.categories.index'))
    @slot('name', trans('attributes::categories.plural'))
    @slot('isActive', request()->routeIs('*categories*'))
    @slot('icon', 'fas fa-list')
    @slot('tree', [
        [
            'name' => trans('attributes::categories.actions.list'),
            'url' => route('dashboard.categories.index'),
            'can' => ['permission' => 'read_categories'],
            'isActive' => request()->routeIs('*categories.index'),
            'module' => 'Attributes',
        ],
        [
            'name' => trans('attributes::categories.actions.create'),
            'url' => route('dashboard.categories.create'),
            'can' => ['permission' => 'create_categories'],
            'isActive' => request()->routeIs('*categories.create'),
            'module' => 'Attributes',
        ],
        [
            'name' => trans('attributes::categories.actions.order'),
            'url' => route('dashboard.order.form.categories'),
            'can' => ['permission' => 'read_categories'],
            'isActive' => request()->routeIs('*order.form.categories'),
            'module' => 'Attributes',
        ]
    ])
@endcomponent



@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_attributes'])
    @slot('url', route('dashboard.attributes.index'))
    @slot('name', trans('attributes::attributes.plural'))
    @slot('isActive', request()->routeIs('*attributes*'))
    @slot('icon', 'fas fa-stream')
    @slot('tree', [
        [
            'name' => trans('attributes::attributes.actions.list'),
            'url' => route('dashboard.attributes.index'),
            'can' => ['permission' => 'read_attributes'],
            'isActive' => request()->routeIs('*attributes.index'),
            'module' => 'Attributes',
        ],
        [
            'name' => trans('attributes::attributes.actions.create'),
            'url' => route('dashboard.attributes.create'),
            'can' => ['permission' => 'create_attributes'],
            'isActive' => request()->routeIs('*attributes.create'),
            'module' => 'Attributes',
        ],
        [
            'name' => trans('attributes::attributes.actions.order'),
            'url' => route('dashboard.order.form.attributes'),
            'can' => ['permission' => 'read_attributes'],
            'isActive' => request()->routeIs('*order.form.attributes'),
            'module' => 'Attributes',
        ],
        [
            'name' => trans('attributes::attributes.pricing_matrix'),
            'url' => route('dashboard.attributes.pricing.matrix'),
            'can' => ['permission' => 'read_attributes'],
            'isActive' => request()->routeIs('*attributes.pricing.matrix*'),
            'module' => 'Attributes',
        ],
        [
            'name' => trans('attributes::attributes.bulk_discount_percent'),
            'url' => route('dashboard.attributes.bulk.discount'),
            'can' => ['permission' => 'read_attributes'],
            'isActive' => request()->routeIs('*attributes.bulk.discount*'),
            'module' => 'Attributes',
        ]
    ])
@endcomponent

