<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteFeatureProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('dashboard')->prefix('dashboard')->as('dashboard.')->group(function () {
    Route::resource('features', 'FeaturesController');
    Route::resource('{feature}/sub_features', 'SubFeaturesController');
    Route::resource('{feature}/options', 'FeatureOptionController');

    Route::get('order/features', 'FeaturesController@getOrder')->name('order.form.features');
    Route::post('order/features', 'FeaturesController@order')->name('order.features');
});
