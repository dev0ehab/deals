@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_restricted_areas'])
    @slot('url', route('dashboard.restricted_areas.index'))
    @slot('name', trans('restricted_areas::restricted_areas.plural'))
    @slot('isActive', request()->routeIs('*restricted_areas*'))
    @slot('icon', 'fas fa-map-marked-alt')
@endcomponent
