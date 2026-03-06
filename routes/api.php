<?php
use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\api\HandymanController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\FavoriteController;
use App\Http\Controllers\api\BookingAddressController;
use App\Http\Controllers\api\BookingController;
use App\Http\Controllers\api\NotificationController;
use App\Http\Controllers\api\ProviderController;
use App\Http\Controllers\api\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace'=>'api'],function (){
    
    // cms pages
    Route::get('cmspages',[HomeController::class,'cmspages']);
    Route::get('provider/cmspages',[HomeController::class,'cmspages']);
    Route::get('handyman/cmspages',[HomeController::class,'cmspages']);
    
    // Handyman Routes
    Route::post('handyman/login',[HandymanController::class,'login']);
    Route::post('handyman/dashboard',[HandymanController::class,'dashboard']);
    Route::post('handyman/getprofile',[HandymanController::class,'getprofile']);
    Route::post('handyman/bookingdetails',[HandymanController::class,'bookingdetails']);
    Route::post('handyman/bookingaction',[HandymanController::class,'bookingaction']);
    Route::post('handyman/bookinghistory',[HandymanController::class,'bookinghistory']);
    Route::post('handyman/editprofile',[UserController::class,'editprofile']);
    Route::post('handyman/forgotpassword',[ProviderController::class,'forgotpassword']);
    Route::post('handyman/changepassword',[UserController::class,'changepassword']);
    Route::post('handyman/notificationlist',[NotificationController::class,'notificationlist']);
    
    // Provider Routes
    Route::get('provider/registerinfo',[ProviderController::class,'registerinfo']);
    Route::post('provider/register',[ProviderController::class,'register']);
    Route::post('provider/verifyotp',[ProviderController::class,'verifyotp']);
    Route::post('provider/resendotp',[UserController::class,'resendotp']);
    Route::post('provider/login',[ProviderController::class,'login']);
    Route::post('provider/forgotpassword',[ProviderController::class,'forgotpassword']);
    Route::post('provider/bookingdetails',[ProviderController::class,'bookingdetails']);
    Route::post('provider/dashboard',[ProviderController::class,'dashboard']);
    Route::post('provider/datewisebookings',[ProviderController::class,'datewisebookings']);
    Route::post('provider/services',[ProviderController::class,'services']);
    Route::post('provider/bookingaction',[ProviderController::class,'bookingaction']);
    Route::post('provider/getprofile',[ProviderController::class,'getprofile']);
    Route::post('provider/bookinghistory',[ProviderController::class,'bookinghistory']);
    Route::post('provider/servicedetails',[ProviderController::class,'servicedetails']);
    Route::post('provider/changepassword',[UserController::class,'changepassword']);
    Route::post('provider/servicerattings',[HomeController::class,'servicerattings']);
    Route::post('provider/galleryimages',[HomeController::class,'galleryimages']);
    Route::post('provider/editprofile',[UserController::class,'editprofile']);
    Route::post('provider/notificationlist',[NotificationController::class,'notificationlist']);
    
    // address controller 
    Route::post('getaddresses',[BookingAddressController::class,'getaddresses']);
    Route::post('addaddress',[BookingAddressController::class,'addaddress']);
    Route::post('deleteaddress',[BookingAddressController::class,'deleteaddress']);
    Route::post('editaddress',[BookingAddressController::class,'editaddress']);
    
    // Favorite controller
    Route::post('favorite',[FavoriteController::class,'favorite']);
    Route::post('unfavorite',[FavoriteController::class,'unfavorite']);
    Route::post('favoritelist',[FavoriteController::class,'favoritelist']);
    
    // Notification Controller
    Route::post('notificationlist',[NotificationController::class,'notificationlist']);
    Route::post('unread',[NotificationController::class,'unread']);
    
    // Home Controller
    Route::get('cities',[HomeController::class,'cities']);
    Route::post('couponlist',[HomeController::class,'couponlist']);
    Route::post('home',[HomeController::class,'home']);
    Route::post('view_all',[HomeController::class,'view_all']);
    Route::post('providerdetails',[HomeController::class,'providerdetails']);
    Route::post('servicedetails',[HomeController::class,'servicedetails']);
    Route::post('servicerattings',[HomeController::class,'servicerattings']);
    Route::post('providerrattings',[HomeController::class,'providerrattings']);
    Route::post('galleryimages',[HomeController::class,'galleryimages']);
    Route::post('category_services',[HomeController::class,'category_services']);
    Route::post('search',[HomeController::class,'search']);
    Route::post('service_timings',[HomeController::class,'service_timings']);
    Route::post('wallet',[WalletController::class,'wallet']);
    Route::post('addwallet',[WalletController::class,'wallet_add']);
    
    // Booking 
    Route::post('paymentmethodlist',[BookingController::class,'paymentmethodlist']);
    Route::post('continuebooking',[BookingController::class,'continuebooking']);
    Route::post('booking',[BookingController::class,'booking']);
    Route::post('bookinglist',[BookingController::class,'bookinglist']);
    Route::post('cancelbooking',[BookingController::class,'cancelbooking']);
    Route::post('bookingdetails',[BookingController::class,'bookingdetails']);
    Route::post('checkcouponcode',[BookingController::class,'checkcouponcode']);
    
    // User Controller
    Route::post('changepassword',[UserController::class,'changepassword']);
    Route::post('editprofile',[UserController::class,'editprofile']);
    Route::post('resendotp',[UserController::class,'resendotp']);
    Route::post('verifyotp',[UserController::class,'verifyotp']);
    Route::post('addmobile',[UserController::class,'addmobile']);
    Route::post('getprofile',[UserController::class,'getprofile']);
    Route::post('addrattings',[UserController::class,'addrattings']);
    Route::post('forgotpassword',[UserController::class,'forgotpassword']);
    Route::post('register',[UserController::class,'register']);
    Route::post('login',[UserController::class,'login']);
    // Route::post('addhelp',[UserController::class,'addhelp']);
});