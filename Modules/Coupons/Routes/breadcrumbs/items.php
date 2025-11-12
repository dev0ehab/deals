<?php

Breadcrumbs::for('dashboard.coupons.items.edit', function ($breadcrumb, $coupon, $couponItem) {
    $breadcrumb->parent('dashboard.coupons.show', $coupon);
    $breadcrumb->push(
        trans('coupons::items.actions.edit'),
        route('dashboard.coupons.items.edit', [$coupon, $couponItem])
    );
});
