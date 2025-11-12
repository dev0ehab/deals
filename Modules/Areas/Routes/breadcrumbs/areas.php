<?php

Breadcrumbs::for('dashboard.areas.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('areas::areas.plural'), route('dashboard.areas.index'));
});

Breadcrumbs::for('dashboard.areas.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.areas.index');
    $breadcrumb->push(trans('areas::areas.actions.create'), route('dashboard.areas.create'));
});

Breadcrumbs::for('dashboard.areas.show', function ($breadcrumb, $area) {
    $breadcrumb->parent('dashboard.areas.index');
    $breadcrumb->push($area->name, route('dashboard.areas.show', $area));
});

Breadcrumbs::for('dashboard.areas.edit', function ($breadcrumb, $area) {
    $breadcrumb->parent('dashboard.areas.show', $area);
    $breadcrumb->push(trans('areas::areas.actions.edit'), route('dashboard.areas.edit', $area));
});
