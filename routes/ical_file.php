<?php

use App\Http\Controllers\addons\IcalFileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\QuestionAnswerController;

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

//ical_file

Route::group(['middleware' => 'FrontMiddleware'], function () {

    Route::get('/home/user/icalfile/{id}', [IcalFileController::class, 'icalfile']);
});

