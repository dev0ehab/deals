@component('dashboard::layouts.components.sidebarItem')
    @slot('url', route('dashboard.home'))
    @slot('name', trans('dashboard::dashboard.home'))
    @slot('icon', 'fas fa-layer-group')
    @slot('routeActive', 'dashboard.home')
@endcomponent

<!-- Admins -->
@include('accounts::admins.sidebar')
<!-- Roles -->
@include('roles::_sidebar')
<!-- Users -->
@include('accounts::users.sidebar')
<!-- payments -->
{{-- @include('payments::payments.sidebar') --}}
<!-- services -->
{{-- @include('services::services.sidebar') --}}
<!-- attributes -->
@include('attributes::attributes.sidebar')
<!-- orders -->
@include('orders::orders.sidebar')
<!-- coupons -->
@include('coupons::coupons.sidebar')
<!-- areas -->
@include('areas::areas.sidebar')
<!-- notifications -->
@include('notifications::notifications.sidebar')
<!-- conatct-us -->
@include('settings::contact-us.sidebar')
<!-- sections -->
@include('sections::sections.sidebar')
<!-- products -->
@include('products::products.sidebar')
<!-- features -->
@include('features::features.sidebar')

<!-- f_a_qs -->
@include('f_a_qs::f_a_qs.sidebar')
<!-- advertisements -->
@include('advertisements::advertisements.sidebar')
<!-- settings -->
@include('dashboard::sidebar.settings')


