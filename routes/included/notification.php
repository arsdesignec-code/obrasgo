<?php

use App\Http\Controllers\addons\included\NotificationController;
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
   Route::group(['middleware' => 'ProviderMiddleware'], function () {
      Route::get('/getorder', [NotificationController::class, 'getorder']);
   });
});
