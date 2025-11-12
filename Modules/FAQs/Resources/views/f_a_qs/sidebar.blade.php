@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_f_a_qs'])
    @slot('url', route('dashboard.f_a_qs.index'))
    @slot('name', trans('f_a_qs::f_a_qs.plural'))
    @slot('isActive', request()->routeIs('*f_a_qs*'))
    @slot('icon', 'fas fa-question')
    @slot('tree', [
        [
            'name' => trans('f_a_qs::f_a_qs.actions.list'),
            'url' => route('dashboard.f_a_qs.index'),
            'can' => ['permission' => 'read_f_a_qs'],
            'isActive' => request()->routeIs('*f_a_qs.index'),
            'module' => 'FAQs',
        ],
        [
            'name' => trans('f_a_qs::f_a_qs.actions.create'),
            'url' => route('dashboard.f_a_qs.create'),
            'can' => ['permission' => 'create_f_a_qs'],
            'isActive' => request()->routeIs('*f_a_qs.create'),
            'module' => 'FAQs',
        ],
    ])
@endcomponent
