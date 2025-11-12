@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_areas'])
    @slot('url', route('dashboard.areas.index'))
    @slot('name', trans('areas::areas.plural'))
    @slot('isActive', request()->routeIs('*areas*'))
    @slot('icon', 'fas fa-map-marked-alt')
@endcomponent
