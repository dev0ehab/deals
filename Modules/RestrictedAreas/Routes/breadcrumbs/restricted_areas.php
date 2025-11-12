<?php

Breadcrumbs::for('dashboard.restricted_areas.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('restricted_areas::restricted_areas.plural'), route('dashboard.restricted_areas.index'));
});

Breadcrumbs::for('dashboard.restricted_areas.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.restricted_areas.index');
    $breadcrumb->push(trans('restricted_areas::restricted_areas.actions.create'), route('dashboard.restricted_areas.create'));
});

Breadcrumbs::for('dashboard.restricted_areas.show', function ($breadcrumb, $restricted_area) {
    $breadcrumb->parent('dashboard.restricted_areas.index');
    $breadcrumb->push($restricted_area->name, route('dashboard.restricted_areas.show', $restricted_area));
});

Breadcrumbs::for('dashboard.restricted_areas.edit', function ($breadcrumb, $restricted_area) {
    $breadcrumb->parent('dashboard.restricted_areas.show', $restricted_area);
    $breadcrumb->push(trans('restricted_areas::restricted_areas.actions.edit'), route('dashboard.restricted_areas.edit', $restricted_area));
});
