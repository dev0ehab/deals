<?php

Breadcrumbs::for('dashboard.payments.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('payments::payments.plural'), route('dashboard.payments.index'));
});

Breadcrumbs::for('dashboard.payments.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.payments.index');
    $breadcrumb->push(trans('payments::payments.actions.create'), route('dashboard.payments.create'));
});

Breadcrumbs::for('dashboard.payments.show', function ($breadcrumb, $payment) {
    $breadcrumb->parent('dashboard.payments.index');
    $breadcrumb->push($payment->name, route('dashboard.payments.show', $payment));
});

Breadcrumbs::for('dashboard.payments.edit', function ($breadcrumb, $payment) {
    $breadcrumb->parent('dashboard.payments.show', $payment);
    $breadcrumb->push(trans('payments::payments.actions.edit'), route('dashboard.payments.edit', $payment));
});
