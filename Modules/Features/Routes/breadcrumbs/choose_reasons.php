<?php

Breadcrumbs::for('dashboard.options.show', function ($breadcrumb, $option) {
    $breadcrumb->parent('dashboard.features.show', $option->feature);
    $breadcrumb->push($option->name, route('dashboard.options.show',[$option->feature,  $option]));
});

Breadcrumbs::for('dashboard.options.edit', function ($breadcrumb, $data) {
    $option = $data['option'];
    $breadcrumb->parent('dashboard.options.show', $option);
    $breadcrumb->push(trans('features::options.actions.edit'), route('dashboard.options.edit', [$option->feature, $option]));
});
