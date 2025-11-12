@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_users'])
    @slot('url', route('dashboard.users.index'))
    @slot('name', trans('accounts::user.plural'))
    @slot('isActive', request()->routeIs('*users*'))
    @slot('icon', 'fas fa-users')
@endcomponent
