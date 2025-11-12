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

Route::middleware(['web', 'canInstall'])->prefix('installer')->as('installer.')->group(function () {
    Route::get('/', 'WelcomeController@index')->name('welcome');

    Route::get('requirements', 'RequirementsController@index')->name('requirements');

    Route::get('permissions', 'PermissionsController@index')->name('permissions');

    Route::get('environment', 'EnvironmentController@environmentMenu')->name('environment');
    Route::get('environment/wizard', ['as' => 'environmentWizard', 'uses' => 'EnvironmentController@environmentWizard']);
    Route::post('environment/saveWizard', ['as' => 'environmentSaveWizard', 'uses' => 'EnvironmentController@saveWizard']);
    Route::get('environment/classic', ['as' => 'environmentClassic', 'uses' => 'EnvironmentController@environmentClassic']);
    Route::post('environment/saveClassic', ['as' => 'environmentSaveClassic', 'uses' => 'EnvironmentController@saveClassic']);

    Route::get('database', 'DatabaseController@database')->name('database');
    Route::get('final', 'FinalController@finish')->name('final');
});
