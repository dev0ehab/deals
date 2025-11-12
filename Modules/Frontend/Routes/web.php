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
Route::get('locale/{locale}', 'LocaleController@update')->name('frontend.locale');

Route::middleware(['frontend.locales'])->group(function () {

    Route::get('/', 'FrontendController@index')->name('home');

    Route::get('/privacy', 'FrontendController@privacy')->name('privacy');

    Route::post('/send/contact/message', 'FrontendController@contactPost')->name('contact.post');
});
