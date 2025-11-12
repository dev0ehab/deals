<?php

Breadcrumbs::for('dashboard.subscribers.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('settings::subscribers.plural'), route('dashboard.subscribers.index'));
});

Breadcrumbs::for('dashboard.subscribers.show', function ($breadcrumb, $subscriber) {
    $breadcrumb->parent('dashboard.subscribers.index');
    $breadcrumb->push($subscriber->name, route('dashboard.subscribers.show', $subscriber));
});
