<?php

Breadcrumbs::for('dashboard.reservations.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('orders::reservations.plural'), route('dashboard.reservations.index'));
});

Breadcrumbs::for('dashboard.reservations.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.reservations.index');
    $breadcrumb->push(trans('orders::reservations.actions.create'), route('dashboard.reservations.create'));
});

Breadcrumbs::for('dashboard.reservations.show', function ($breadcrumb, $reservation) {
    $breadcrumb->parent('dashboard.reservations.index');
    $breadcrumb->push('reservation', route('dashboard.reservations.show', $reservation));
});

Breadcrumbs::for('dashboard.reservations.edit', function ($breadcrumb, $reservation) {
    $breadcrumb->parent('dashboard.reservations.show', $reservation);
    $breadcrumb->push(trans('orders::reservations.actions.edit'), route('dashboard.reservations.edit', $reservation));
});
