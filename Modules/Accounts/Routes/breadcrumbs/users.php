<?php

Breadcrumbs::for('dashboard.users.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('accounts::user.plural'), route('dashboard.users.index'));
});

Breadcrumbs::for('dashboard.users.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.users.index');
    $breadcrumb->push(trans('accounts::user.actions.create'), route('dashboard.users.create'));
});

Breadcrumbs::for('dashboard.users.show', function ($breadcrumb, $user) {
    $breadcrumb->parent('dashboard.users.index');
    $breadcrumb->push($user->name, route('dashboard.users.show', $user));
});

Breadcrumbs::for('dashboard.users.edit', function ($breadcrumb, $user) {
    $breadcrumb->parent('dashboard.users.show', $user);
    $breadcrumb->push(trans('accounts::user.actions.edit'), route('dashboard.users.edit', $user));
});

Breadcrumbs::for('dashboard.users.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.users.index');
    $breadcrumb->push(trans('accounts::user.trashedPlural'), route('dashboard.users.trashed'));
});
