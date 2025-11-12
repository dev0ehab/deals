@php
    use App\Enums\ServicesEnum;
    use Modules\Services\Entities\Service;

    $service = ServicesEnum::ReadyToWear->value;
    $serviceName = Service::find($service)->name;

    $tree = [
        [
            'name' => trans('services::services.actions.main'),
            'url' => route('dashboard.services.edit', $service),
            'can' => ['permission' => 'read_services'],
            'isActive' => request()->routeIs('dashboard.services.edit') && request('service') == $service,
            'module' => 'Collections',
        ],
        [
            'name' => trans('sliders::sliders.actions.list'),
            'url' => route('dashboard.sliders.index', ['service' => $service]),
            'can' => ['permission' => 'read_sliders'],
            'isActive' => request()->routeIs('*sliders.index') && request('service') == $service,
            'module' => 'Sliders',
        ],
        [
            'name' => trans('categories::categories.actions.list'),
            'url' => route('dashboard.categories.index'),
            'can' => ['permission' => 'read_categories'],
            'isActive' => request()->routeIs('*categories.index'),
            'module' => 'Categories',
        ],
        [
            'name' => trans('products::products.actions.list'),
            'url' => route('dashboard.products.index', ['service' => $service]),
            'can' => ['permission' => 'read_products'],
            'isActive' => request()->routeIs('*products.index') && request('service') == $service,
            'module' => 'Products',
        ],
    ];

@endphp


@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_services'])
    @slot('url', '#')
    {{-- @slot('name', trans('services::services.services.readyToWear')) --}}
    @slot('name', $serviceName)
    @slot('isActive', in_array(true, collect($tree)->pluck('isActive')->toArray(), true))
    @slot('svgIcon', asset('images/services/icons/ready_to_wear.svg'))
    @slot('tree', $tree)
@endcomponent
