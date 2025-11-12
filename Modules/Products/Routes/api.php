<?php

use Illuminate\Http\Request;

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

Route::post('/select/get-service-products/{service}', 'SelectController@getServiceProducts');

Route::post('/select/get-washer-service-products/{service}', 'SelectController@getWasherServiceProducts');

Route::get('/products/{product}/rates', 'SelectController@rates');
Route::apiResource('products', 'SelectController')->only('index', 'show');

