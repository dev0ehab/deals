@php

    use App\Enums\ServicesEnum;

    $services = ServicesEnum::values();
    $tree = [
        [
            'name' => trans('services::services.actions.order'),
            'url' => route('dashboard.order.form.services'),
            'can' => ['permission' => 'read_services'],
            'isActive' => request()->routeIs('*order.form.services'),
            'module' => 'Services',
        ],
    ];

    foreach ($services as $serviceNum) {
        $serviceName = ServicesEnum::serviceName($serviceNum);

        $tree[] = [
            'name' => trans("services::services.services.$serviceName"),
            'url' => route('dashboard.services.edit', $serviceNum),
            'can' => ['permission' => 'read_services'],
            'isActive' => request()->routeIs('dashboard.services.edit') && request('service') == $serviceNum,
            'module' => 'Services',
        ];
    }

@endphp


@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_services'])
    @slot('url', route('dashboard.services.index'))
    @slot('name', trans('services::services.plural'))
    @slot('isActive', request()->routeIs('*services'))
    @slot('icon', 'fas fa-code-branch')
    @slot('tree', $tree)
@endcomponent
