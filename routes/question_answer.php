<?php

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

//question_answer


Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function () {
    Route::group(['middleware' => 'AuthMiddleware'], function () {
        Route::get('/question_answer', [QuestionAnswerController::class, 'question_answer']);
        Route::post('/service_answer', [QuestionAnswerController::class, 'service_answer']);
        Route::get('/question_answer/delete-{id}', [QuestionAnswerController::class, 'delete']);
        Route::post('/question_answer/bulk_delete', [QuestionAnswerController::class, 'bulk_delete']);
       
    });
});


    Route::post('/service_question_answer', [QuestionAnswerController::class, 'service_question_answer']);

