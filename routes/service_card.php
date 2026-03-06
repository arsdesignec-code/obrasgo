<?php

use App\Http\Controllers\addons\ServiceCardController;
use Illuminate\Support\Facades\Route;
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

Route::group(['middleware' => 'AuthMiddleware'], function () {
    Route::group(['middleware' => 'AdminMiddleware'], function () {
        Route::post('/service_card', [ServiceCardController::class, 'service_card']);
    });
});
