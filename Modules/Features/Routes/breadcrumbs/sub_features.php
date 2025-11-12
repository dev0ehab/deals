<?php

Breadcrumbs::for('dashboard.sub_features.show', function ($breadcrumb, $sub_feature) {
    $breadcrumb->parent('dashboard.features.show', $sub_feature->parent);
    $breadcrumb->push($sub_feature->name, route('dashboard.sub_features.show', [$sub_feature->parent, $sub_feature]));
});

Breadcrumbs::for('dashboard.sub_features.edit', function ($breadcrumb, $sub_feature) {
    $breadcrumb->parent('dashboard.sub_features.show', $sub_feature);
    $breadcrumb->push(trans('features::sub_features.actions.edit'), route('dashboard.sub_features.edit', [$sub_feature->parent, $sub_feature]));
});
