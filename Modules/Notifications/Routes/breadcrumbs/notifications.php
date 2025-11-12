<?php

Breadcrumbs::for('dashboard.notifications.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('notifications::notifications.plural'), route('dashboard.notifications.index'));
});

Breadcrumbs::for('dashboard.notifications.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.notifications.index');
    $breadcrumb->push(trans('notifications::notifications.actions.create'), route('dashboard.notifications.create'));
});

Breadcrumbs::for('dashboard.notifications.show', function ($breadcrumb, $notification) {
    $breadcrumb->parent('dashboard.notifications.index');
    $breadcrumb->push($notification->id, route('dashboard.notifications.show', $notification));
});

Breadcrumbs::for('dashboard.notifications.edit', function ($breadcrumb, $notification) {
    $breadcrumb->parent('dashboard.notifications.show', $notification);
    $breadcrumb->push(trans('notifications::notifications.actions.edit'), route('dashboard.notifications.edit', $notification));
});
