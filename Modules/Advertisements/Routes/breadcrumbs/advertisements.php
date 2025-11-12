<?php

Breadcrumbs::for('dashboard.advertisements.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('advertisements::advertisements.plural'), route('dashboard.advertisements.index'));
});

Breadcrumbs::for('dashboard.advertisements.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.advertisements.index');
    $breadcrumb->push(trans('advertisements::advertisements.actions.create'), route('dashboard.advertisements.create'));
});

Breadcrumbs::for('dashboard.advertisements.show', function ($breadcrumb, $advertisement) {
    $breadcrumb->parent('dashboard.advertisements.index');
    $breadcrumb->push($advertisement->title, route('dashboard.advertisements.show', $advertisement));
});

Breadcrumbs::for('dashboard.advertisements.edit', function ($breadcrumb, $advertisement) {
    $breadcrumb->parent('dashboard.advertisements.show', $advertisement);
    $breadcrumb->push(trans('advertisements::advertisements.actions.edit'), route('dashboard.advertisements.edit', $advertisement));
});
