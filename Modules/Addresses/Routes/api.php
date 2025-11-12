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

//Route::get('/get/userAddress/{customer}', 'SelectController@getUserAddress')->name('user.address');
Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        Route::apiResource('addresses', 'Api\AddressController');
        Route::post('addresses/{address}/default', 'Api\AddressController@default')->name('addresses.default');
    }
);

