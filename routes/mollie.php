<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\MollieController;
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

Route::group(['namespace' => 'front', 'prefix' => 'home'], function () {
    Route::post('mollie', [MollieController::class, 'index']);
});
