<?php

Breadcrumbs::for('dashboard.services.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('services::services.plural'), route('dashboard.services.index'));
});

Breadcrumbs::for('dashboard.services.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.services.index');
    $breadcrumb->push(trans('services::services.actions.create'), route('dashboard.services.create'));
});

Breadcrumbs::for('dashboard.services.show', function ($breadcrumb, $service) {
    $breadcrumb->parent('dashboard.services.index');
    $breadcrumb->push($service->name, route('dashboard.services.show', $service));
});

Breadcrumbs::for('dashboard.services.edit', function ($breadcrumb, $service) {
    $breadcrumb->parent('dashboard.services.show', $service);
    $breadcrumb->push(trans('services::services.actions.edit'), route('dashboard.services.edit', $service));
});
