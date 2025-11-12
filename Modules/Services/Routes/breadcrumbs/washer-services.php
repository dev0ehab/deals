<?php

Breadcrumbs::for('dashboard.washer-services.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('services::services.plural'), route('dashboard.washer-services.index'));
});

Breadcrumbs::for('dashboard.washer-services.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.washer-services.index');
    $breadcrumb->push(trans('services::services.actions.create'), route('dashboard.washer-services.create'));
});

Breadcrumbs::for('dashboard.washer-services.show', function ($breadcrumb, $service) {
    $breadcrumb->parent('dashboard.washer-services.index');
    $breadcrumb->push($service->name, route('dashboard.washer-services.show', $service));
});

Breadcrumbs::for('dashboard.washer-services.edit', function ($breadcrumb, $service) {
    $breadcrumb->parent('dashboard.washer-services.show', $service);
    $breadcrumb->push(trans('services::services.actions.edit'), route('dashboard.washer-services.edit', $service));
});
