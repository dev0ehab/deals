<?php

Breadcrumbs::for('dashboard.rates.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('orders::rates.plural'), route('dashboard.rates.index'));
});

Breadcrumbs::for('dashboard.rates.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.rates.index');
    $breadcrumb->push(trans('orders::rates.actions.create'), route('dashboard.rates.create'));
});

Breadcrumbs::for('dashboard.rates.show', function ($breadcrumb, $rate) {
    $breadcrumb->parent('dashboard.rates.index');
    $breadcrumb->push('rate', route('dashboard.rates.show', $rate));
});

Breadcrumbs::for('dashboard.rates.edit', function ($breadcrumb, $rate) {
    $breadcrumb->parent('dashboard.rates.show', $rate);
    $breadcrumb->push(trans('orders::rates.actions.edit'), route('dashboard.rates.edit', $rate));
});
