<?php


use App\Http\Controllers\addons\WhatsappmessageController;
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
        Route::get('/whatsapp_settings', [WhatsappmessageController::class, 'index']);
        Route::post('settings/booking_message_update', [WhatsappmessageController::class, 'booking_message_update']);
        Route::post('settings/status_message', [WhatsappmessageController::class, 'status_message']);
        Route::post('settings/business_api', [WhatsappmessageController::class, 'business_api']);
    });
});

Route::group(['namespace' => 'front', 'middleware' => 'MaintenanceMiddleware'], function () {
    Route::post('/orders/sendonwhatsapp', [WhatsappmessageController::class, 'sendonwhatsapp']);
});
