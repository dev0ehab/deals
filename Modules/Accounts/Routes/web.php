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

Route::middleware('dashboard')
    ->prefix('dashboard')
    ->as('dashboard.')
    ->group(
        function () {

            Route::get('admins/profile', 'Dashboard\AdminController@profile')->name('admins.profile');
            Route::put('update-profile/{admin}', 'Dashboard\AdminController@updateProfile')->name('admins.updateProfile');

            Route::prefix('accounts')
                ->group(
                    function () {
                        Route::get('users/trashed', 'Dashboard\UserController@trashed')->name('users.trashed');
                        Route::get('users/restore/{user}', 'Dashboard\UserController@restore')->name('users.restore');
                        Route::get('users/force-delete/{user}', 'Dashboard\UserController@forceDelete')->name('users.forceDelete');

                        // block routes
                        Route::patch('users/{user}/block', 'Dashboard\UserController@block')->name('users.block');
                        Route::patch('users/{user}/unblock', 'Dashboard\UserController@unblock')->name('users.unblock');

                        Route::resource('admins', 'Dashboard\AdminController');
                        Route::resource('users', 'Dashboard\UserController');

                        // block routes
                        Route::patch('admins/{admin}/block', 'Dashboard\AdminController@block')->name('admins.block');
                        Route::patch('admins/{admin}/unblock', 'Dashboard\AdminController@unblock')->name('admins.unblock');
                    }
                );
        }
    );
