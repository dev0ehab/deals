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

Route::get('/select/payments', 'SelectController@payments')->name('payments.select');


Route::middleware('auth:sanctum')->post('/payments/my-fatorah', 'Api\PaymentController@myFatorah');
Route::get('/payments/electronic-payments', 'Api\PaymentController@electronicPayments');
Route::apiResource('payments', 'Api\PaymentController')->only('index', 'show');

