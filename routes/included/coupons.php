<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\included\CouponController;

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


Route::post('/home/service/continue/check-coupon/{service}', [CouponController::class, 'check_coupon']);
Route::get('/home/remove-coupon/{service}', [CouponController::class, 'remove_coupon']);

Route::group(['middleware' => 'AuthMiddleware'], function () {
   Route::group(['middleware' => 'AdminMiddleware'], function () {

      //Coupons Routes
      Route::get('/coupons', [CouponController::class, 'index'])->name('coupons');
      Route::get('/coupons/add', [CouponController::class, 'add']);
      Route::post('/coupons/store', [CouponController::class, 'store']);
      Route::post('/coupons/del', [CouponController::class, 'destroy']);
      Route::post('/coupons/bulk_delete', [CouponController::class, 'bulk_delete']);
      Route::post('/coupons/edit/status', [CouponController::class, 'status']);
      Route::get('/coupons/edit/{id}', [CouponController::class, 'show']);
      Route::post('/coupons/edit/{id}', [CouponController::class, 'edit']);
   });
});
