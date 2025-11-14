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

Route::prefix("vendor")->group(function () {

    Route::post('/register', 'Api\RegisterController@register')->name('vendor.register');
    Route::post('/social-register', 'Api\RegisterController@socialRegister')->name('vendor.social-register');
    Route::post('/login', 'Api\LoginController@login')->name('vendor.login');
    Route::post('/social-login', 'Api\LoginController@SocialLogin')->name('vendor.social-login');
    Route::post('/update-fcm/{vendor}', 'SelectController@updateFcm')->name('admin.fcm');

    Route::get('unauthenticated', 'Api\LoginController@unauthenticated')->name('unauthenticated');

    Route::post('/password/forget', 'Api\ResetPasswordController@forget')->name('vendor.password.forget');
    Route::post('/password/code', 'Api\ResetPasswordController@code')->name('vendor.password.code');
    Route::post('/password/reset', 'Api\ResetPasswordController@reset')->name('vendor.password.reset');
    Route::get('/select/vendors', 'SelectController@index')->name('vendors.select');

    Route::post('verification/send', 'Api\VerificationController@send')->name('verification.send');
    Route::post('verification/resend', 'Api\VerificationController@send')->name('verification.resend');
    Route::post('verification/verify', 'Api\VerificationController@verify')->name('verification.verify');


    Route::middleware('auth:sanctum')->group(
        function () {

            Route::get('profile', 'Api\ProfileController@show')->name('vendor.profile.show');
            Route::post('profile', 'Api\ProfileController@update')->name('vendor.profile.update');
            Route::post('password/update', 'Api\ProfileController@updatePassword')->name('vendor.password.update');

            Route::post('authenticable/update', 'Api\ProfileController@updateAuthenticable')->name('vendor.authenticable.update');
            Route::post('authenticable/verify', 'Api\ProfileController@verifyAuthenticable')->name('vendor.authenticable.verify');

            Route::get('exist', 'Api\ProfileController@exist')->name('vendor.exist');
            Route::post('preferred-locale', 'Api\ProfileController@preferredLocale')->name('vendor.preferred.locale');
            Route::post('fcm', 'Api\ProfileController@updateFcm');

            Route::post('logout', 'Api\ProfileController@logout')->name('vendor.logout');

            Route::get('check', 'Api\ProfileController@check')->name('vendor.check');

            Route::post('delete', 'Api\ProfileController@delete')->name('vendor.delete');

            // vendor's Addresses
            Route::get('addresses/check', 'Api\AddressesController@check')->name('vendor.addresses.check');
            Route::apiResource('addresses', 'Api\AddressesController');
        }
    );
});
