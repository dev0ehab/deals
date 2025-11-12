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

Route::post('coupons/validate', 'Api\CouponController@validate')->name('coupons.validate');

Route::resource('coupons', 'Api\CouponController')->only('index' );


