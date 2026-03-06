<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\included\LanguageController;

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
Route::get('/changelanguage-{lang}', [LanguageController::class, 'change'])->name('language');

Route::group(['middleware' => 'AuthMiddleware'], function () {
    Route::group(['middleware' => 'AdminMiddleware'], function () {
        Route::group(['prefix' => 'language-settings/language'], function () {
            Route::get('/add', [LanguageController::class, 'add']);
            Route::post('/store', [LanguageController::class, 'store']);
            Route::get('/layout/status-{id}/{status}', [LanguageController::class, 'status']);
        });

        Route::group(['prefix' => 'language-settings'], function () {
            Route::get('/', [LanguageController::class, 'index']);
            Route::post('/update', [LanguageController::class, 'storeLanguageData']);
            Route::get('/language/edit-{id}', [LanguageController::class, 'edit']);
            Route::post('/update-{id}', [LanguageController::class, 'update']);
            Route::post('/layout/update', [LanguageController::class, 'layout']);
            Route::post('/language/delete', [LanguageController::class, 'delete']);
            Route::get('/{code}', [LanguageController::class, 'index']);
         });
    });
});
