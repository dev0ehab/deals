<?php

Breadcrumbs::for('dashboard.vendors.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('vendors::vendorss.plural'), route('dashboard.vendors.index'));
});

Breadcrumbs::for('dashboard.vendors.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.vendors.index');
    $breadcrumb->push(trans('vendors::vendorss.actions.create'), route('dashboard.vendors.create'));
});

Breadcrumbs::for('dashboard.vendors.show', function ($breadcrumb, $vendor) {
    $breadcrumb->parent('dashboard.vendors.index');
    $breadcrumb->push($vendor->name, route('dashboard.vendors.show', $vendor));
});

Breadcrumbs::for('dashboard.vendors.edit', function ($breadcrumb, $vendor) {
    $breadcrumb->parent('dashboard.vendors.show', $vendor);
    $breadcrumb->push(trans('vendors::vendorss.actions.edit'), route('dashboard.vendors.edit', $vendor));
});

Breadcrumbs::for('dashboard.vendors.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.vendors.index');
    $breadcrumb->push(trans('vendors::vendorss.trashedPlural'), route('dashboard.vendors.trashed'));
});
