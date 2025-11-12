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

Route::prefix("user")->group(function () {

    Route::post('/register', 'Api\RegisterController@register')->name('user.register');
    Route::post('/social-register', 'Api\RegisterController@socialRegister')->name('user.social-register');
    Route::post('/login', 'Api\LoginController@login')->name('user.login');
    Route::post('/social-login', 'Api\LoginController@SocialLogin')->name('user.social-login');
    Route::post('/update-fcm/{user}', 'SelectController@updateFcm')->name('admin.fcm');

    Route::get('unauthenticated', 'Api\LoginController@unauthenticated')->name('unauthenticated');

    Route::post('/password/forget', 'Api\ResetPasswordController@forget')->name('user.password.forget');
    Route::post('/password/code', 'Api\ResetPasswordController@code')->name('user.password.code');
    Route::post('/password/reset', 'Api\ResetPasswordController@reset')->name('user.password.reset');
    Route::get('/select/users', 'SelectController@index')->name('users.select');

    Route::post('verification/send', 'Api\VerificationController@send')->name('verification.send');
    Route::post('verification/resend', 'Api\VerificationController@send')->name('verification.resend');
    Route::post('verification/verify', 'Api\VerificationController@verify')->name('verification.verify');


    Route::middleware('auth:sanctum')->group(
        function () {

            Route::get('profile', 'Api\ProfileController@show')->name('user.profile.show');
            Route::post('profile', 'Api\ProfileController@update')->name('user.profile.update');
            Route::post('password/update', 'Api\ProfileController@updatePassword')->name('user.password.update');

            Route::post('authenticable/update', 'Api\ProfileController@updateAuthenticable')->name('user.authenticable.update');
            Route::post('authenticable/verify', 'Api\ProfileController@verifyAuthenticable')->name('user.authenticable.verify');

            Route::get('exist', 'Api\ProfileController@exist')->name('user.exist');
            Route::post('preferred-locale', 'Api\ProfileController@preferredLocale')->name('user.preferred.locale');
            Route::post('fcm', 'Api\ProfileController@updateFcm');

            Route::post('logout', 'Api\ProfileController@logout')->name('user.logout');

            Route::get('check', 'Api\ProfileController@check')->name('user.check');

            Route::post('delete', 'Api\ProfileController@delete')->name('user.delete');

            // user's Addresses
            Route::get('addresses/check', 'Api\AddressesController@check')->name('user.addresses.check');
            Route::apiResource('addresses', 'Api\AddressesController');

            // rate vendor
            Route::apiResource('rates', 'Api\RateController')->only('index', 'store');
        }
    );
});
