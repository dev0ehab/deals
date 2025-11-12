<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteFeatureProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/select/features', 'SelectController@features')->name('features.select');
Route::get('/select/options-by-feature-id', 'SelectController@optionsByFeatureId')->name('options.by.feature.id.select');

Route::get('/features', 'SelectController@allFeatures');
Route::get("feature-by-name/{name}", "SelectController@getByName");
Route::get('/features/{featureId}/options', 'SelectController@featureOptions')->name('api.features.options');
