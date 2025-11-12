@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_settings'])
    @slot('url', route('dashboard.pages'))
    @slot('name', trans('Pages'))
    @slot('isActive', request()->routeIs('dashboard.pages'))
    @slot('icon', 'fas fa-copy')
@endcomponent
