{{--providers--}}
@component('dashboard::layouts.components.customReportWidget')
    @slot('color', 'primary')
    @slot('icon', 'mdi mdi-shield-car')
    @slot('route', route('dashboard.providers.index'))
    @slot('name', trans('accounts::providers.plural'))
    @slot('count', $providersCount)
@endcomponent
{{--spareParts--}}
@component('dashboard::layouts.components.customReportWidget')
    @slot('color', 'info')
    @slot('icon', 'mdi mdi-car-info')
    @slot('route', route('dashboard.spareParts.index'))
    @slot('name', trans('spareParts::spareParts.plural'))
    @slot('count', $providersPartsCount)
@endcomponent
{{--brands--}}
@component('dashboard::layouts.components.customReportWidget')
    @slot('color', 'warning')
    @slot('icon', 'mdi mdi-car-back')
    @slot('route', route('dashboard.brands.index'))
    @slot('name', trans('cars::brands.plural'))
    @slot('count', $brandsCount)
@endcomponent
{{--car_models--}}
@component('dashboard::layouts.components.customReportWidget')
    @slot('color', 'danger')
    @slot('icon', 'mdi mdi-car-3-plus')
    @slot('route', route('dashboard.car_models.index'))
    @slot('name', trans('cars::car_models.plural'))
    @slot('count', $carModelsCount)
@endcomponent
{{--car_classes--}}
@component('dashboard::layouts.components.customReportWidget')
    @slot('color', 'info')
    @slot('icon', 'mdi mdi-car-multiple')
    @slot('route', route('dashboard.car_classes.index'))
    @slot('name', trans('cars::car_classes.plural'))
    @slot('count', $carClassesCount)
@endcomponent
{{--categories--}}
@component('dashboard::layouts.components.customReportWidget')
    @slot('color', 'danger')
    @slot('icon', 'mdi mdi-car-door-lock')
    @slot('route', route('dashboard.categories.index'))
    @slot('name', trans('categories::categories.plural'))
    @slot('count', $categoriesCount)
@endcomponent
{{--parts--}}
@component('dashboard::layouts.components.customReportWidget')
    @slot('color', 'primary')
    @slot('icon', 'mdi mdi-car-wash')
    @slot('route', route('dashboard.parts.index'))
    @slot('name', trans('parts::parts.plural'))
    @slot('count', $partsCount)
@endcomponent
{{--bodies--}}
@component('dashboard::layouts.components.customReportWidget')
    @slot('color', 'warning')
    @slot('icon', 'mdi mdi-car-tire-alert')
    @slot('route', route('dashboard.bodies.index'))
    @slot('name', trans('bodies::bodies.plural'))
    @slot('count', $bodiesCount)
@endcomponent
{{--orders--}}
@component('dashboard::layouts.components.customReportWidget')
    @slot('color', 'warning')
    @slot('icon', 'mdi mdi-layers-search')
    @slot('route', route('dashboard.orders.index'))
    @slot('name', trans('orders::orders.plural'))
    @slot('count', $ordersCount)
@endcomponent
{{--completed orders--}}
@component('dashboard::layouts.components.customReportWidget')
    @slot('color', 'primary')
    @slot('icon', 'mdi mdi-bookmark-check')
    @slot('route', route('dashboard.orders.index',['completed' => true]))
    @slot('name', trans('orders::orders.completed'))
    @slot('count', $completedOrdersCount)
@endcomponent
{{--not_completed orders--}}
@component('dashboard::layouts.components.customReportWidget')
    @slot('color', 'danger')
    @slot('icon', 'mdi mdi-bookmark-remove')
    @slot('route', route('dashboard.orders.index',['not_completed' => true]))
    @slot('name', trans('orders::orders.not_completed'))
    @slot('count', $notCompletedOrdersCount)
@endcomponent
{{--most searched vin--}}
@component('dashboard::layouts.components.customReportWidget')
    @slot('color', 'info')
    @slot('icon', 'mdi mdi-file-document-box-search')
    @slot('route', route('dashboard.orders.index',['vin_number' => $mostSearchedVin->vin_number ?? null]))
    @slot('name', trans('dashboard::dashboard.most_searched_vin'))
    @slot('count', $mostSearchedVin->vin_number ?? null)
    @slot('fontSize', 'font-size-12')
@endcomponent
