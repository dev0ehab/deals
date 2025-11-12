<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::delete('uploader/media/{media}', 'MediaController@destroy')->name('uploader.media.destroy');

// Test route for page count extraction
Route::post('/test/page-count', [\App\Http\Controllers\Api\TestUploadController::class, 'testPageCount']);

// Route::post('/test', [\App\Http\Controllers\TestController::class, 'test']);
