<?php

use App\Http\Controllers\addons\GoogleCalendarController;
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

Route::group(['middleware' => 'AdminMiddleware'], function () {
    Route::group(['middleware' => 'AuthMiddleware'], function () {
        Route::get('/bookings/event', [GoogleCalendarController::class, 'event']);
        Route::get('/bookings/googlesync-{booking_number}/{provider_id}/{type}', [GoogleCalendarController::class, 'googlesync']);
    });
});
Route::group(['namespace' => 'admin', 'prefix' => 'admin'], function () {
    Route::group(['middleware' => 'AuthMiddleware'], function () {
        Route::post('/google_calendar', [GoogleCalendarController::class, 'google_calendar']);
    });
});