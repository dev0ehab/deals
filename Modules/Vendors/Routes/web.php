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

    Route::get('vendors/trashed', 'Dashboard\VendorsController@trashed')->name('vendors.trashed');
    Route::get('vendors/restore/{vendor}', 'Dashboard\VendorsController@restore')->name('vendors.restore');
    Route::get('vendors/force-delete/{vendor}', 'Dashboard\VendorsController@forceDelete')->name('vendors.forceDelete');

    // block routes
    Route::patch('vendors/{vendor}/block', 'Dashboard\VendorsController@block')->name('vendors.block');
    Route::patch('vendors/{vendor}/unblock', 'Dashboard\VendorsController@unblock')->name('vendors.unblock');
    Route::post('vendors/bulk-block', 'Dashboard\VendorsController@bulkBlock')->name('vendors.bulk-block');
    Route::post('vendors/bulk-unblock', 'Dashboard\VendorsController@bulkUnblock')->name('vendors.bulk-unblock');
    Route::delete('vendors/bulk-delete', 'Dashboard\VendorsController@bulkDelete')->name('vendors.bulk-delete');

    Route::resource('vendors', 'Dashboard\VendorsController');
});
