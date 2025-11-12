<?php

Breadcrumbs::for('dashboard.attributes.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('attributes::attributes.plural'), route('dashboard.attributes.index'));
});

Breadcrumbs::for('dashboard.attributes.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.attributes.index');
    $breadcrumb->push(trans('attributes::attributes.actions.create'), route('dashboard.attributes.create'));
});

Breadcrumbs::for('dashboard.attributes.show', function ($breadcrumb, $attribute) {
    $breadcrumb->parent('dashboard.attributes.index');
    $breadcrumb->push($attribute->title, route('dashboard.attributes.show', $attribute));
});

Breadcrumbs::for('dashboard.attributes.edit', function ($breadcrumb, $attribute) {
    $breadcrumb->parent('dashboard.attributes.show', $attribute);
    $breadcrumb->push(trans('attributes::attributes.actions.edit'), route('dashboard.attributes.edit', $attribute));
});

Breadcrumbs::for('dashboard.attributes.pricing.matrix', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.attributes.index');
    $breadcrumb->push(trans('attributes::attributes.pricing_matrix'), route('dashboard.attributes.pricing.matrix'));
});

Breadcrumbs::for('dashboard.attributes.bulk.discount', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.attributes.index');
    $breadcrumb->push(trans('attributes::attributes.bulk_discount_percent'), route('dashboard.attributes.bulk.discount'));
});
