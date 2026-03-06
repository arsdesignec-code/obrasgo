<?php

use App\Http\Controllers\addons\IcalFileController;
use App\Http\Controllers\addons\included\CurrencyController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SystemAddonsController;
use App\Http\Controllers\Admin\AppDownloadController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PaymentMethodsController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\PayoutController;
use App\Http\Controllers\Admin\CMSController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Provider\ProviderTypeController;
use App\Http\Controllers\Provider\ProviderController;
use App\Http\Controllers\Provider\TimingController;
use App\Http\Controllers\Provider\HandymanController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Service\GalleryImagesController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\FrontUserController;
use App\Http\Controllers\front\ServiceBookController;
use App\Http\Controllers\front\WalletController;
use App\Http\Controllers\Admin\How_IT_WortksController;
use App\Http\Controllers\Admin\OtherPagesController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\front\WishlistController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\AddressController;
use Illuminate\Support\Facades\Artisan;

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

Route::post('add-on/session/save', [AdminController::class, 'sessionsave']);
Route::get('/clear-cache', function () {
   Artisan::call('cache:clear');
   Artisan::call('route:clear');
   Artisan::call('config:clear');
   Artisan::call('view:clear');
   return redirect()->back()->with('success', trans('messages.success'));
});

Route::group(['middleware' => 'FrontMiddleware'], function () {
   Route::get('/', [HomeController::class, 'index'])->name('home');
   Route::get('/pwa', [HomeController::class, 'index']);
   Route::group(['namespace' => 'front', 'prefix' => 'home'], function () {
      //Front Side Routes
      Route::get('find-service', [HomeController::class, 'find_service']);
      Route::get('find-cities', [HomeController::class, 'find_cities']);
      Route::get('terms-condition', [HomeController::class, 'tc']);
      Route::get('privacy-policy', [HomeController::class, 'policy']);
      Route::get('categories', [HomeController::class, 'categories']);
      Route::get('services', [HomeController::class, 'services']);
      Route::get('services/{category}', [HomeController::class, 'category_services']);
      Route::get('service-details/{service}', [HomeController::class, 'service_details']);
      Route::get('providers', [HomeController::class, 'providers']);
      Route::get('providers-details/{provider}', [HomeController::class, 'provider_details']);
      Route::get('providers-services/{provider}', [HomeController::class, 'provider_services']);
      Route::get('providers-rattings/{provider}', [HomeController::class, 'provider_rattings']);
      Route::get('search', [HomeController::class, 'search']);
      Route::get('about-us', [HomeController::class, 'aboutus']);
      Route::get('register-user', [UserController::class, 'register_user'])->name('register_user');
      Route::post('store-user', [UserController::class, 'store_user']);
      Route::post('service/isopenclose', [HomeController::class, 'isopenclose']);


      Route::post('wishlist', [WishlistController::class, 'storewishlist']);

      Route::get('forgot-password', [UserController::class, 'forgot_pass']);
      Route::post('send-pass', [UserController::class, 'send_pass']);
      Route::get('contact-us', [InquiryController::class, 'contactus']);
      Route::post('add-inquiry', [InquiryController::class, 'add']);
      Route::get('login', [LoginController::class, 'index'])->name('login');
      Route::post('checklogin', [LoginController::class, 'checklogin']);
   });

   Route::get('/home/user/bookings/{id}', [FrontUserController::class, 'booking_details']);
   Route::post('/home/user/bookings/payment', [FrontUserController::class, 'booking_payment']);
   Route::get('/home/service/continue/checkout/{service}', [ServiceBookController::class, 'checkout']);
   Route::post('/home/service/book', [ServiceBookController::class, 'book']);
   Route::get('/home/success-{booking_id}', [ServiceBookController::class, 'success'])->name('booking_success');
   Route::post('/home/user/bookings/cancel', [ServiceBookController::class, 'cancel']);

   //Payment SUCCESS/FAIL

   Route::any('home/service/paymentsuccess', [ServiceBookController::class, 'paymentsuccess']);
   Route::any('home/service/paymentfail', [ServiceBookController::class, 'paymentfail']);
   Route::any('home/service/bookingpaymentsuccess', [FrontUserController::class, 'bookingpaymentsuccess']);
   Route::any('home/service/bookingpaymentfail', [FrontUserController::class, 'bookingpaymentfail']);


   Route::group(['middleware' => 'UserMiddleware'], function () {
      Route::get('/home/user/reviews', [FrontUserController::class, 'reviews']);
      Route::get('/home/user/profile', [FrontUserController::class, 'profile'])->name('user_profile');
      Route::post('/home/user/profile/edit', [FrontUserController::class, 'edit']);
      Route::get('/home/user/notifications', [FrontUserController::class, 'notifications']);
      Route::get('/home/user/refer-earn', [FrontUserController::class, 'referearn']);
      Route::get('/home/user/clearnotification', [FrontUserController::class, 'clearnotification']);
      Route::post('/home/user/changepass', [FrontUserController::class, 'changepass']);
      Route::get('/home/user/bookings', [FrontUserController::class, 'bookings']);
      Route::post('/home/user/delete', [FrontUserController::class, 'deleteuser']);
      Route::get('/home/user/address', [AddressController::class, 'index']);

      Route::get('/home/user/wallet', [WalletController::class, 'wallet']);
      Route::post('/home/user/wallet/add', [WalletController::class, 'wallet_add']);
      Route::any('home/user/addpaymentsuccess', [WalletController::class, 'addpaymentsuccess']);
      Route::any('home/user/addpaymentfail', [WalletController::class, 'addpaymentfail']);

      Route::post('/home/user/add-address', [FrontUserController::class, 'add_address']);
      Route::post('/home/user/delete_address', [FrontUserController::class, 'delete_address']);

      Route::get('/home/user/wishlist', [FrontUserController::class, 'wishlist']);
   });
});

Route::get('/admin', [LoginController::class, 'adminlogin'])->name('adminlogin');
Route::get('/admin/register', [LoginController::class, 'register_provider']);
Route::post('/admin/store-provider', [LoginController::class, 'store_provider']);
Route::get('/admin/forgot_password', [LoginController::class, 'adminforgotpassword']);
Route::post('/admin-send-pass', [LoginController::class, 'admin_send_pass']);
Route::post('/checkadminlogin', [LoginController::class, 'checkadminlogin']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/subscribe', [AdminController::class, 'subscribe']);

Route::get('/verification', function () {
   return view('auth.verification');
});
Route::post('systemverification', 'LoginController@systemverification')->name('admin.systemverification');

Route::group(['middleware' => 'AuthMiddleware'], function () {

   Route::get('/dashboard', [AdminController::class, 'home'])->name('dashboard');
   Route::post('/profile/edit/{id}', [UserController::class, 'editprofile']);
   Route::post('/profile/edit/password/{id}', [UserController::class, 'editPassword']);
   Route::post('/payout/update', [PayoutController::class, 'update_request']);
   Route::get('/bookings', [BookingController::class, 'index'])->name('bookings');
   Route::get('/reports', [BookingController::class, 'index'])->name('reports');
   Route::get('/bookings/{booking}', [BookingController::class, 'booking_details']);
   Route::get('/generatepdf/{booking}', [BookingController::class, 'generatepdf']);
   Route::get('/payout', [PayoutController::class, 'index']);

   Route::get('/handymans', [HandymanController::class, 'index'])->name('handymans');
   Route::get('/handymans/fetch_handyman', [HandymanController::class, 'fetch_handyman'])->name('ajax_handyman');
   Route::get('/handymans/{handyman}', [HandymanController::class, 'showhandyman']);

   Route::get('/deleteaccount-{id}', [ProviderController::class, 'deleteaccount']);
   Route::post('/bulk_delete_account', [ProviderController::class, 'bulkdeleteaccount']);


   Route::get('/services', [ServiceController::class, 'index'])->name('services');
   Route::get('/services/{service}', [ServiceController::class, 'service']);
   Route::post('/services/fetch_chart/{service}', [ServiceController::class, 'fetch_chart']);
   Route::get('/services/fetch_service', [ServiceController::class, 'fetch_service'])->name('ajax_service');

   Route::group(['middleware' => 'AdminMiddleware'], function () {

      Route::get('apps', [SystemAddonsController::class, 'index'])->name('systemaddons');
      Route::get('createsystem-addons', [SystemAddonsController::class, 'createsystemaddons']);
      Route::post('systemaddons/store', [SystemAddonsController::class, 'store']);
      Route::post('systemaddons/edit/status', [SystemAddonsController::class, 'change_status']);


      Route::get('/log-in-provider/{slug}', [LoginController::class, 'log_in_provider']);

      Route::post('/home-settings/home/update', [SettingController::class, 'home_page_setting']);
      Route::get('/subscribers', [AdminController::class, 'subscribers'])->name('subscribers');
      Route::get('/smtp-configuration', [AdminController::class, 'smtp_configuration']);
      Route::post('/env_key_update', 'AdminController@env_key_update')->name('env_key_update.update');
      Route::get('/settings', [SettingController::class, 'show'])->name('settings');
      Route::post('/settings/footer-features/', [SettingController::class, 'footer_features_update']);
      Route::post('/settings/footer-features/del/', [SettingController::class, 'delete_feature']);
      Route::post('/settings/social_links', [SettingController::class, 'social_links_update']);
      Route::post('/settings/social_links/del/', [SettingController::class, 'delete_sociallinks']);
      Route::post('/settings/edit', [SettingController::class, 'edit']);
      Route::post('/settings/service_card_update', [SettingController::class, 'service_card_update']);
      Route::post('/settings/others', [SettingController::class, 'otherdata']);
      Route::post('/settings/safe-secure-store', [SettingController::class, 'safe_secure_store']);
      Route::post('settings/notice_update', [SettingController::class, 'notice_update']);
      Route::post('settings/maintenance_update', [SettingController::class, 'maintenance_update']);
      Route::post('settings/recent_view_service_update', [SettingController::class, 'recent_view_service_update']);
      Route::post('/settings/tips-update-settings', [SettingController::class, 'tips_update_settings']);
      Route::post('/settings/theme', [SettingController::class, 'themesetting']);
      Route::post('/settings/pwa', [SettingController::class, 'pwasettings']);

      //CMS Routes
      Route::get('/terms-conditions', [CMSController::class, 'tc_form'])->name('tc');
      Route::post('/terms-conditions/update', [CMSController::class, 'update']);
      Route::get('/privacy-policy', [CMSController::class, 'privacy_form'])->name('privacy_policy');
      Route::post('/privacy-policy/update', [CMSController::class, 'update_privacy']);
      Route::get('/about', [CMSController::class, 'about_form'])->name('about');
      Route::post('/about/update', [CMSController::class, 'update_about']);
      // Provider Routes
      Route::get('/providers', [ProviderController::class, 'providers'])->name('providers');
      Route::get('/providers/add', [ProviderController::class, 'addprovider']);
      Route::post('/providers/store', [ProviderController::class, 'storeprovider']);
      Route::post('/providers/edit/status', [ProviderController::class, 'providerstatus']);
      Route::post('/providers/del', [ProviderController::class, 'destroyprovider']);
      Route::get('/providers/edit/{provider}', [ProviderController::class, 'showprovider']);
      Route::post('/providers/edit/{provider}', [ProviderController::class, 'editprovider']);
      Route::get('/providers/{provider}', [ProviderController::class, 'provider']);

      //Proider Types Routes
      Route::get('/provider_types', [ProviderTypeController::class, 'index'])->name('provider_types');
      Route::get('/provider_types/add', [ProviderTypeController::class, 'add']);
      Route::post('/provider_types/store', [ProviderTypeController::class, 'store']);
      Route::post('/provider_types/del', [ProviderTypeController::class, 'destroy']);
      Route::post('/provider_types/bulk_delete', [ProviderTypeController::class, 'bulk_delete']);
      Route::post('/provider_types/status', [ProviderTypeController::class, 'status']);
      Route::get('/provider_types/edit/{id}', [ProviderTypeController::class, 'show']);
      Route::post('/provider_types/edit/{id}', [ProviderTypeController::class, 'edit']);
      Route::post('/reorder-provider-types', [ProviderTypeController::class, 'reorder']);

      Route::get('/users', [UserController::class, 'users'])->name('users');
      Route::post('/users/edit/status', [UserController::class, 'usersstatus']);

      Route::get('/payment-methods', [PaymentMethodsController::class, 'index'])->name('payment-methods');
      Route::get('/payment-methods/{id}', [PaymentMethodsController::class, 'show']);
      Route::post('/payment-methods/edit/{id}', [PaymentMethodsController::class, 'edit']);
      Route::post('/payment-methods/status', [PaymentMethodsController::class, 'status']);
      Route::post('/reorder-payment-methods', [PaymentMethodsController::class, 'reorder']);

      //Banners Routes
      Route::get('/banners', [BannerController::class, 'index'])->name('banners');
      Route::get('/banners/add', [BannerController::class, 'add']);
      Route::post('/banners/store', [BannerController::class, 'store']);
      Route::post('/banners/del', [BannerController::class, 'destroy']);
      Route::post('/banners/bulk_delete', [BannerController::class, 'bulk_delete']);
      Route::get('/banners/edit/{id}', [BannerController::class, 'show']);
      Route::post('/banners/edit/{id}', [BannerController::class, 'edit']);
      Route::post('/reorder-banner', [BannerController::class, 'reorder']);

      //Cities Routes
      Route::get('/cities', [CityController::class, 'index'])->name('cities');
      Route::get('/cities/add', [CityController::class, 'add']);
      Route::post('/city/store', [CityController::class, 'store']);
      Route::post('/cities/del', [CityController::class, 'destroy']);
      Route::post('/cities/bulk_delete', [CityController::class, 'bulk_delete']);
      Route::post('/cities/edit/status', [CityController::class, 'status']);
      Route::get('/cities/edit/{id}', [CityController::class, 'show']);
      Route::post('/cities/edit/{id}', [CityController::class, 'edit']);
      Route::post('/reorder-city', [CityController::class, 'reorder']);

      //Categories Routes
      Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');
      Route::get('/categories/add', [CategoryController::class, 'add']);
      Route::post('/categories/store', [CategoryController::class, 'store']);
      Route::post('/categories/del', [CategoryController::class, 'destroy']);
      Route::post('/categories/bulk_delete', [CategoryController::class, 'bulk_delete']);
      Route::post('/categories/edit/status', [CategoryController::class, 'status']);
      Route::get('/categories/edit/{category}', [CategoryController::class, 'show']);
      Route::post('/categories/edit/{category}', [CategoryController::class, 'edit']);
      Route::post('/reorder-category', [CategoryController::class, 'reorder']);

      //Contact US Routes
      Route::get('contact-us', [InquiryController::class, 'contactdata']);
      Route::post('contact-us/status', [InquiryController::class, 'status']);

      //How IT Work Routes
      Route::get('/how-it-works', [How_IT_WortksController::class, 'index'])->name('how_it_works');
      Route::get('/how-it-works/add', [How_IT_WortksController::class, 'add']);
      Route::post('/how-it-works/update', [How_IT_WortksController::class, 'store']);
      Route::post('/how-it-works/store', [How_IT_WortksController::class, 'how_it_works_store']);
      Route::get('/how-it-works/edit/{id}', [How_IT_WortksController::class, 'show']);
      Route::post('/how-it-works/edit/{id}', [How_IT_WortksController::class, 'edit']);
      Route::post('/how-it-works/del', [How_IT_WortksController::class, 'destroy']);
      Route::post('/how-it-works/del', [How_IT_WortksController::class, 'destroy']);
      Route::post('/reorder-howitwork', [How_IT_WortksController::class, 'reorder_howitwork']);

      //Testimonials Routes
      Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials');
      Route::get('/testimonials/add', [TestimonialController::class, 'add']);
      Route::post('/testimonials/store', [TestimonialController::class, 'store']);
      Route::get('/testimonials/edit/{testimonial}', [TestimonialController::class, 'show']);
      Route::post('/testimonials/edit/{id}', [TestimonialController::class, 'edit']);
      Route::post('/testimonials/del', [TestimonialController::class, 'destroy']);
      Route::post('/testimonials/bulk_delete', [TestimonialController::class, 'bulk_delete']);
      Route::post('/reorder-testimonials', [TestimonialController::class, 'reorder_testimonials']);

      //FAQ Routes
      Route::get('/faq', [FAQController::class, 'index'])->name('faq');
      Route::get('/faq/add', [FAQController::class, 'add']);
      Route::post('/faq/update', [FAQController::class, 'store']);
      Route::post('/faq/store', [FAQController::class, 'faq_store']);
      Route::get('/faq/edit/{id}', [FAQController::class, 'show']);
      Route::post('/faq/edit/{id}', [FAQController::class, 'edit']);
      Route::post('/faq/del', [FAQController::class, 'destroy']);
      Route::post('/faq/bulk_delete', [FAQController::class, 'bulk_delete']);
      Route::post('/reorder-faq', [FAQController::class, 'reorder_faq']);

      //App Download Routes
      Route::get('/app_download', [AppDownloadController::class, 'index'])->name('app_download');
      Route::post('/app_download/update', [AppDownloadController::class, 'update']);

      //Brand Routes
      Route::get('brand', [OtherPagesController::class, 'brand_index'])->name('brand');
      Route::get('brand/add', [OtherPagesController::class, 'brand_add']);
      Route::post('brand/store', [OtherPagesController::class, 'brand_store']);
      Route::get('brand/edit/{id}', [OtherPagesController::class, 'brand_show']);
      Route::post('brand/update/{id}', [OtherPagesController::class, 'brand_update']);
      Route::post('brand/delete', [OtherPagesController::class, 'brand_delete']);

      // currency-setting

      Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function () {
         Route::group(['prefix' => 'currency-settings'], function () {
            Route::get('/', [CurrencyController::class, 'index']);
            Route::get('/currency/edit-{id}', [CurrencyController::class, 'edit']);
            Route::post('/update-{id}', [CurrencyController::class, 'update']);
         });
      });
   });

   Route::group(['middleware' => 'ProviderMiddleware'], function () {

      Route::get('/go-back', [LoginController::class, 'go_back']);

      Route::get('/clearnotification', [UserController::class, 'clearnotification']);
      Route::get('/notifications', [UserController::class, 'noti'])->name('notifications');
      Route::get('/timings', [TimingController::class, 'show'])->name('timings');
      Route::get('/profile-settings', [ProviderController::class, 'settings']);
      Route::post('/profile-settings/update', [ProviderController::class, 'profile_settings_update']);
      Route::post('/profile-settings/add-bank', [ProviderController::class, 'add_bank']);
      Route::post('/timings/edit', [TimingController::class, 'edit']);

      Route::post('/payout-create', [PayoutController::class, 'create_request']);

      Route::post('/bookings/accept', [BookingController::class, 'accept']);
      Route::post('/bookings/cancel', [BookingController::class, 'cancel']);
      Route::post('/bookings/complete', [BookingController::class, 'complete']);
      Route::post('/bookings/booking_verify_otp', [BookingController::class, 'booking_verify_otp']);
      Route::post('/bookings/assign_handyman', [BookingController::class, 'assign_handyman']);
      Route::post('/bookings/cancel_by_handyman', [BookingController::class, 'cancel_by_handyman']);

      //Handyman Routes
      Route::get('/handymans-add', [HandymanController::class, 'add']);
      Route::post('/handymans-store', [HandymanController::class, 'store']);
      Route::post('/handymans-status', [HandymanController::class, 'status']);
      Route::post('/handymans-del', [HandymanController::class, 'destroy']);
      Route::get('/handymans/edit/{handyman}', [HandymanController::class, 'show']);
      Route::post('/handymans/edit/{handyman}', [HandymanController::class, 'edit']);

      Route::get('/services-add', [ServiceController::class, 'add']);
      Route::post('/services-store', [ServiceController::class, 'store']);
      Route::post('/services/edit/is_featured', [ServiceController::class, 'is_featured']);
      Route::post('/services/edit/is_top_deals', [ServiceController::class, 'is_top_deals']);
      Route::post('/services/edit/status', [ServiceController::class, 'status']);
      Route::post('/services-del', [ServiceController::class, 'destroy']);
      Route::post('/services/bulk_delete', [ServiceController::class, 'bulk_delete']);
      Route::get('/services/edit/{service}', [ServiceController::class, 'show']);
      Route::post('/services/edit/{service}', [ServiceController::class, 'edit']);
      Route::post('/reorder-service', [ServiceController::class, 'reorder']);
      Route::post('/del/gallery', [GalleryImagesController::class, 'destroy']);
      Route::post('/gallery/edit', [GalleryImagesController::class, 'edit']);
      Route::post('/gallery/add', [GalleryImagesController::class, 'add']);

      //Tax Routes
      Route::get('/tax', [TaxController::class, 'index'])->name('tax');
      Route::get('/tax/add', [TaxController::class, 'add']);
      Route::post('/tax/store', [TaxController::class, 'store']);
      Route::post('/tax/del', [TaxController::class, 'destroy']);
      Route::post('/tax/bulk_delete', [TaxController::class, 'bulk_delete']);
      Route::get('/tax/edit/{id}', [TaxController::class, 'show']);
      Route::post('/tax/edit/{id}', [TaxController::class, 'edit']);
   });
});
