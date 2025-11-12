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
Route::get('app-settings', 'Api\SettingController@app')->name('settings.index');
Route::get('general', 'Api\SettingController@general')->name('settings.general');
Route::get('contact', 'Api\SettingController@contact')->name('settings.contact');
Route::get('privacy-policy', 'Api\SettingController@privacy')->name('settings.privacy');
Route::get('terms-conditions', 'Api\SettingController@terms')->name('settings.terms');
Route::get('privacy', 'Api\SettingController@privacy')->name('settings.privacy');
Route::get('about', 'Api\SettingController@about')->name('settings.about');
Route::get('terms', 'Api\SettingController@terms')->name('settings.terms');
Route::post('contact-us', 'Api\ContactUsController@save');
