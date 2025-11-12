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
    Route::middleware("isAdmin")->resource('services', 'ServicesController');

    Route::get('order/services', 'ServicesController@getOrder')->name('order.form.services');
    Route::post('order/services', 'ServicesController@order')->name('order.services');
});
