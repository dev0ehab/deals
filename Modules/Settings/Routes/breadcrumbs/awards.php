<?php

Breadcrumbs::for('dashboard.awards.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('settings::awards.plural'), route('dashboard.awards.index'));
});

Breadcrumbs::for('dashboard.awards.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.awards.index');
    $breadcrumb->push(trans('settings::awards.actions.create'), route('dashboard.awards.create'));
});

Breadcrumbs::for('dashboard.awards.show', function ($breadcrumb, $award) {
    $breadcrumb->parent('dashboard.awards.index');
    $breadcrumb->push($award->name, route('dashboard.awards.show', $award));
});

Breadcrumbs::for('dashboard.awards.edit', function ($breadcrumb, $award) {
    $breadcrumb->parent('dashboard.awards.show', $award);
    $breadcrumb->push(trans('settings::awards.actions.edit'), route('dashboard.awards.edit', $award));
});
