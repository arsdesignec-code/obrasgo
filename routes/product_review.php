<?php

use App\Http\Controllers\addons\RattingController;
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
    Route::post('review-settings/update', [RattingController::class, 'settings_update']);
    Route::get('reviews', [RattingController::class, 'index']);
    Route::post('services/serviceRatingdestroy', [RattingController::class, 'destroy']);
    Route::post('reviews/status', [RattingController::class, 'status']);
});

Route::group(['namespace' => 'front', 'middleware' => 'UserMiddleware'], function () {
    Route::post('/home/user/add-rattings', [RattingController::class, 'addreview']);
});
