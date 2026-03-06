<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\included\BlogController;

use App\Http\Controllers\front\HomeController;

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
   Route::get('blog/list/', [BlogController::class, 'blog_list']);
   Route::get('blog/details/{slug}', [BlogController::class, 'blog_detail']);
});

Route::group(['middleware' => 'AuthMiddleware'], function () {

   Route::group(['middleware' => 'AdminMiddleware'], function () {

      //Blog Routes
      Route::get('/blog', [BlogController::class, 'index'])->name('blog');
      Route::get('/blog/add', [BlogController::class, 'add']);
      Route::post('/blog/store', [BlogController::class, 'store']);
      Route::get('/blog/edit/{id}', [BlogController::class, 'show']);
      Route::post('/blog/edit/{id}', [BlogController::class, 'edit']);
      Route::post('/blog/del', [BlogController::class, 'destroy']);
      Route::post('/blog/bulk_delete', [BlogController::class, 'bulk_delete']);
      Route::post('/reorder-blog', [BlogController::class, 'reorder_blog']);
   });
});
