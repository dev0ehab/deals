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
    Route::post('rate/active/{rate}', 'Dashboard\RateController@activate')->name('rates.activate');
    Route::resource('orders', 'Dashboard\OrderController');
    Route::resource('rates', 'Dashboard\RateController');

    // change the order status
    Route::post('orders/{order}/status', 'Dashboard\OrderController@status')->name('orders.status');

    // change the rate status
    Route::post('rates/{rate}/status', 'Dashboard\RateController@status')->name('rates.status');
});

