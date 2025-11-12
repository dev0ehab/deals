<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// get cards route
Route::get('dashboard/cards', 'SelectController@getCards')->name('dashboard.cards');
// filter cards route
Route::post('dashboard/filter-cards', 'SelectController@filterCards')->name('dashboard.filter');

// get charts route
Route::get('dashboard/charts', 'SelectController@getCharts')->name('dashboard.charts');

Route::get('dashboard/render-notifications/{user}', 'SelectController@getNotificationRealTime');

Route::delete('uploader/media/{media}', 'MediaController@destroy')->name('uploader.media.destroy');
