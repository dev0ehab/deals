<?php

Breadcrumbs::for('dashboard.settings.update', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('settings::settings.plural'), route('dashboard.settings.index'));
});

Breadcrumbs::for('dashboard.settings.main', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('settings::settings.main'), route('dashboard.settings.index'));
});
