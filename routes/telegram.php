<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\TelegramController;
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
        Route::get('/telegram_settings', [TelegramController::class, 'index']);
        Route::post('telegram/business_api', [TelegramController::class, 'business_api']);
        Route::post('telegram/booking_message_update', [TelegramController::class, 'booking_message_update']);
    });
});

Route::group(['namespace' => "front"], function () {
    Route::get('/telegram/{booking_number}', [TelegramController::class, 'telegrammessage']);
});
