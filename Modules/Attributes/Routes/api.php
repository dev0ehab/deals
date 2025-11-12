<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('attributes', 'SelectController')->only('index');

Route::get('attributes/pricing-matrix', 'SelectController@getPricingMatrix')->name('attributes.pricing.matrix');
Route::get('attributes/bulk-discount-percent', 'SelectController@getBulkDiscountPercent')->name('attributes.bulk.discount.percent');
