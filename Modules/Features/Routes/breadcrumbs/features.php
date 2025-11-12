<?php

Breadcrumbs::for('dashboard.features.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('features::features.plural'), route('dashboard.features.index'));
});

Breadcrumbs::for('dashboard.features.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.features.index');
    $breadcrumb->push(trans('features::features.actions.create'), route('dashboard.features.create'));
});

Breadcrumbs::for('dashboard.features.show', function ($breadcrumb, $feature) {
    $breadcrumb->parent('dashboard.features.index');
    $breadcrumb->push($feature->name, route('dashboard.features.show', $feature));
});

Breadcrumbs::for('dashboard.features.order', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.features.index');
    $breadcrumb->push(trans('features::features.actions.order'), route('dashboard.order.form.features'));
});

Breadcrumbs::for('dashboard.features.edit', function ($breadcrumb, $feature) {
    $breadcrumb->parent('dashboard.features.show', $feature);
    $breadcrumb->push(trans('features::features.actions.edit'), route('dashboard.features.edit', $feature));
});
