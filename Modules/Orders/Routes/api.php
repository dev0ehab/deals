<?php



Route::middleware('auth:sanctum')->apiResource("user/orders", 'Api\OrderController')->except('destroy');

Route::middleware('auth:sanctum')->post("user/orders/{order}/cancel", 'Api\OrderController@cancel');
Route::middleware('auth:sanctum')->post("user/orders/{order}/rate", 'Api\OrderController@rate');

Route::post("orders/upload-media", 'Api\OrderController@uploadMedia');
