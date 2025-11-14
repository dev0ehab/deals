<?php

Breadcrumbs::for('dashboard.vendors.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('vendors::vendorsplural'), route('dashboard.vendors.index'));
});

Breadcrumbs::for('dashboard.vendors.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.vendors.index');
    $breadcrumb->push(trans('vendors::vendorsactions.create'), route('dashboard.vendors.create'));
});

Breadcrumbs::for('dashboard.vendors.show', function ($breadcrumb, $vendor) {
    $breadcrumb->parent('dashboard.vendors.index');
    $breadcrumb->push($vendor->name, route('dashboard.vendors.show', $vendor));
});

Breadcrumbs::for('dashboard.vendors.edit', function ($breadcrumb, $vendor) {
    $breadcrumb->parent('dashboard.vendors.show', $vendor);
    $breadcrumb->push(trans('vendors::vendorsactions.edit'), route('dashboard.vendors.edit', $vendor));
});

Breadcrumbs::for('dashboard.vendors.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.vendors.index');
    $breadcrumb->push(trans('vendors::vendorstrashedPlural'), route('dashboard.vendors.trashed'));
});
