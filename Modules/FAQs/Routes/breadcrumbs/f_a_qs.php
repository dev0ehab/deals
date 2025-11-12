<?php

Breadcrumbs::for('dashboard.f_a_qs.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('f_a_qs::f_a_qs.plural'), route('dashboard.f_a_qs.index'));
});

Breadcrumbs::for('dashboard.f_a_qs.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.f_a_qs.index');
    $breadcrumb->push(trans('f_a_qs::f_a_qs.actions.create'), route('dashboard.f_a_qs.create'));
});

Breadcrumbs::for('dashboard.f_a_qs.show', function ($breadcrumb, $f_a_q) {
    $breadcrumb->parent('dashboard.f_a_qs.index');
    $breadcrumb->push($f_a_q->id, route('dashboard.f_a_qs.show', $f_a_q));
});

Breadcrumbs::for('dashboard.f_a_qs.edit', function ($breadcrumb, $f_a_q) {
    $breadcrumb->parent('dashboard.f_a_qs.show', $f_a_q);
    $breadcrumb->push(trans('f_a_qs::f_a_qs.actions.edit'), route('dashboard.f_a_qs.edit', $f_a_q));
});
