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
    Route::get('main_settings', 'Dashboard\SettingController@main')->name('settings.main');
    Route::get('settings', 'Dashboard\SettingController@index')->name('settings.index');
    Route::put('settings', 'Dashboard\SettingController@update')->name('settings.update');

    Route::get('pages', 'Dashboard\SettingController@pages')->name('pages');

    // contact us route
    Route::resource('contact-us', 'Dashboard\ContactUsController')->except('create', 'store', 'edit', 'update');

});

Route::post('ckeditor/image_upload', 'Dashboard\SettingController@upload')->name('image.upload');
