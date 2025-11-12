<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('dashboard')->prefix('dashboard')->as('dashboard.')->group(function () {
    Route::get('attributes/pricing-matrix', 'Dashboard\AttributesController@getPricingMatrix')->name('attributes.pricing.matrix');
    Route::post('attributes/pricing-matrix', 'Dashboard\AttributesController@updatePricingMatrix')->name('attributes.pricing.matrix.update');

    Route::get('attributes/bulk-discount', 'Dashboard\AttributesController@getBulkDiscountPercent')->name('attributes.bulk.discount');
    Route::post('attributes/bulk-discount', 'Dashboard\AttributesController@updateBulkDiscountPercent')->name('attributes.bulk.discount.update');

    Route::resource('attributes', 'Dashboard\AttributesController');
    Route::post('attributes/active/{attribute}', 'Dashboard\AttributesController@activate')->name('attributes.activate');

    Route::get('order/attributes', 'Dashboard\AttributesController@getOrder')->name('order.form.attributes');
    Route::post('order/attributes', 'Dashboard\AttributesController@order')->name('order.attributes');

    Route::resource('categories', 'Dashboard\CategoriesController');
    Route::post('categories/active/{category}', 'Dashboard\CategoriesController@activate')->name('categories.activate');

    Route::get('order/categories', 'Dashboard\CategoriesController@getOrder')->name('order.form.categories');
    Route::post('order/categories', 'Dashboard\CategoriesController@order')->name('order.categories');
});
