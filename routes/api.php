<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('/v1/dashboard')->namespace('Api\V1\Dashboard')->group(function () {
    Route::get('/table', 'TableController')->name('table');
    Route::get('/chart-bar', 'ChartBarController')->name('chart-bar');
    Route::get('/chart-bar-stacked', 'ChartBarStackedController')->name('chart-bar-stacked');
});