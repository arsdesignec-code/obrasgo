<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\ProvidercalendarController;

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
        Route::group(['middleware' => 'ProviderMiddleware'], function () {
              // calendar
              Route::get('/calendar', [ProvidercalendarController::class, 'index']);
              Route::get('/calendar/add', [ProvidercalendarController::class, 'add']);
              Route::post('/calendar/timeslot', [ProvidercalendarController::class, 'timeslot']);
              Route::post('/calendar/save', [ProvidercalendarController::class, 'save']);
              Route::post('/calendar/getcustomer', [ProvidercalendarController::class, 'getcustomer']);
              Route::post('/calendar/slotlimit', [ProvidercalendarController::class, 'slotlimit']);
            
        });
    });

