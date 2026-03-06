<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Rattings;
use App\Models\Service;
use App\Models\Setting;
use App\Helpers\helper;
use App\Models\Coupons;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\User;
use App\Models\City;
use App\Models\CMS;
use App\Models\Notification;
use App\Models\GalleryImages;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
   public function couponlist(Request $request)
   {
      if ($request->city_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_city')], 200);
      }
      $coupondata = Coupons::with('servicename')
         ->leftJoin('services', 'coupons.service_id', 'services.id')
         ->leftJoin('users', 'services.provider_id', 'users.id')
         ->select('coupons.*')->where('coupons.is_available', 1)->where('coupons.is_deleted', 2)
         ->where('users.city_id', $request->city_id)->orderByDesc('coupons.id')->paginate(10);

      if (!empty($coupondata)) {
         return response()->json(['status' => 1, 'message' => trans('messages.success'), 'coupondata' => $coupondata], 200);
      } else {
         return response()->json(['status' => 1, 'message' => trans('messages.not_available')], 200);
      }
   }
   public function category_services(Request $request)
   {
      if ($request->category_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.select_category')], 200);
      }
      if ($request->city_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_city')], 200);
      }
      $user_id = $request->user_id;
      $servicedata = Service::with('api_rattings')
         ->join('categories', 'services.category_id', '=', 'categories.id')
         ->join('users', 'services.provider_id', '=', 'users.id')
         ->leftJoin('favorites', function ($query) use ($user_id) {
            $query->on('favorites.service_id', '=', 'services.id')
               ->where('favorites.user_id', '=', $user_id);
         })
         ->select(
            'services.id',
            'services.name as service_name',
            'services.price',
            'services.price_type',
            'services.duration',
            'services.duration_type',
            'categories.name as category_name',
            'users.name as provider_name',
            DB::raw('(case when favorites.service_id is null then 0 else 1 end) as is_favorite'),
            DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', services.image) AS image_url"),
            DB::raw("CONCAT('" . asset('storage/app/public/provider') . "/', users.image) AS provider_image_url")
         )
         ->where('services.is_available', 1)
         ->where('services.is_deleted', 2)
         ->where('services.category_id', $request->category_id)
         ->where('users.city_id', $request->city_id)
         ->orderByDesc('services.id')
         ->paginate(10);

      return response()->json(['status' => 1, 'message' => trans('messages.success'), 'servicedata' => $servicedata], 200);
   }
   public function search(Request $request)
   {
      if ($request->city_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_city')], 200);
      }
      $user_id = $request->user_id;

      $providerdata = User::with('api_rattings')
         ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
         ->join('cities', 'users.city_id', '=', 'cities.id')
         ->leftJoin('favorites', function ($query) use ($user_id) {
            $query->on('favorites.provider_id', '=', 'users.id')
               ->where('favorites.user_id', '=', $user_id);
         })
         ->select(
            'users.*',
            'cities.name as city_name',
            'provider_types.name as provider_type',
            DB::raw('(case when favorites.provider_id is null then 0 else 1 end) as is_favorite'),
            DB::raw("CONCAT('" . asset('storage/app/public/provider') . "/', users.image) AS image_url")
         )
         ->where('users.city_id', $request->city_id)
         ->where('users.type', 2)
         ->where('users.is_available', 1)
         ->orderByDesc('users.id')
         ->get();


      $servicedata = Service::with('api_rattings')
         ->join('categories', 'services.category_id', '=', 'categories.id')
         ->join('users', 'services.provider_id', '=', 'users.id')
         ->leftJoin('favorites', function ($query) use ($user_id) {
            $query->on('favorites.service_id', '=', 'services.id')
               ->where('favorites.user_id', '=', $user_id);
         })
         ->select(
            'services.id',
            'services.name as service_name',
            'services.price',
            'services.price_type',
            'services.duration',
            'services.duration_type',
            'categories.name as category_name',
            'users.name as provider_name',
            DB::raw('(case when favorites.service_id is null then 0 else 1 end) as is_favorite'),
            DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', services.image) AS image_url")
         )
         ->where('services.is_available', 1)
         ->where('services.is_deleted', 2)
         ->where('users.city_id', $request->city_id)
         ->orderByDesc('services.id')
         ->get();

      return response()->json(['status' => 1, 'message' => trans('messages.success'), 'servicedata' => $servicedata, 'providerdata' => $providerdata], 200);
   }
   public function cities()
   {
      $citydata = City::select('id', 'name', DB::raw("CONCAT('" . asset('storage/app/public/city') . "/', image) AS image_url"))
         ->orderBy('name')->where('is_available', 1)->where('is_deleted', 2)->paginate(10);
      return response()->json(['status' => 1, 'message' => trans('messages.success'), 'citydata' => $citydata], 200);
   }

   public function home(Request $request)
   {
      if ($request->city_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_city')], 200);
      }
      $user_id = $request->user_id;
      $appsettings = Setting::select('currency', 'currency_position', 'referral_amount')->first();
      $notification = Notification::select(DB::raw("(CASE WHEN count(user_id) > 0 THEN 1 ELSE 0 END) as is_notification"))->where('user_id', $user_id)->where('is_read', 2)->first();
      $bannerdata = Banner::with('categoryname', 'servicename')
         ->leftJoin('services', 'banners.service_id', 'services.id')
         ->leftJoin('users', 'services.provider_id', 'users.id')
         ->select('banners.id', 'banners.service_id', 'banners.section', 'banners.type',  'banners.category_id', 'users.city_id', 'banners.image')
         ->orderByDesc('id')
         ->get();
      $banners_1 = array();
      $banners_2 = array();
      foreach ($bannerdata as $bdata) {
         if ($bdata->section == 1) {
            $banners_1[] = array(
               'id' => $bdata->id,
               'category_id' => $bdata->category_id,
               'service_id' => $bdata->service_id,
               'image_url' => Helper::image_path($bdata->image),
               'categoryname' => $bdata->categoryname,
               'servicename' => $bdata->servicename,
               'type' => $bdata->type,
            );
         }
         if ($bdata->section == 2) {
            $banners_2[] = array(
               'id' => $bdata->id,
               'category_id' => $bdata->category_id,
               'service_id' => $bdata->service_id,
               'image_url' => Helper::image_path($bdata->image),
               'categoryname' => $bdata->categoryname,
               'servicename' => $bdata->servicename,
               'type' => $bdata->type,
            );
         }
      }
      $categorydata = Category::join('services', 'services.category_id', '=', 'categories.id')
         ->select(
            'categories.id',
            'categories.name',
            DB::raw("CONCAT('" . asset('storage/app/public/category') . "/', categories.image) AS image_url"),
            DB::raw('categories.id, count(*) as service_count')
         )
         ->where('categories.is_available', 1)
         ->where('categories.is_deleted', 2)
         ->groupBy("categories.id")
         ->orderByDesc('id')
         ->take(10)->get();

      $providerdata = User::with('api_rattings')
         ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
         ->join('cities', 'users.city_id', '=', 'cities.id')
         ->leftJoin('favorites', function ($query) use ($user_id) {
            $query->on('favorites.provider_id', '=', 'users.id')
               ->where('favorites.user_id', '=', $user_id);
         })
         ->select(
            'users.id',
            'users.name as provider_name',
            'cities.name as city_name',
            'provider_types.name as provider_type',
            DB::raw('(case when favorites.provider_id is null then 0 else 1 end) as is_favorite'),
            DB::raw("CONCAT('" . asset('storage/app/public/provider') . "/', users.image) AS image_url")
         )
         ->where('users.city_id', $request->city_id)
         ->where('users.type', 2)
         ->where('users.is_available', 1)
         ->orderByDesc('users.id')
         ->take(10)->get();

      $servicedata = Service::with('api_rattings')
         ->join('categories', 'services.category_id', '=', 'categories.id')
         ->join('users', 'services.provider_id', '=', 'users.id')
         ->leftJoin('favorites', function ($query) use ($user_id) {
            $query->on('favorites.service_id', '=', 'services.id')
               ->where('favorites.user_id', '=', $user_id);
         })
         ->select(
            'services.id',
            'services.name as service_name',
            'services.price',
            'services.price_type',
            'services.duration',
            'services.duration_type',
            'categories.name as category_name',
            'users.name as provider_name',
            DB::raw('(case when favorites.service_id is null then 0 else 1 end) as is_favorite'),
            DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', services.image) AS image_url"),
            DB::raw("CONCAT('" . asset('storage/app/public/provider') . "/', users.image) AS provider_image_url"),
         )
         ->where('services.is_available', 1)
         ->where('services.is_deleted', 2)
         ->where('users.city_id', $request->city_id)
         ->orderByDesc('services.id')
         ->take(10)->get();

      $blog_data = Blog::select('id', 'title', 'description', DB::raw("CONCAT('" . asset('storage/app/public/blogs') . "/', image) AS image_url"))->where('is_deleted', 2)->orderBy('id', 'DESC')->get();

      $testimonials = Testimonials::select('id', 'name', 'rating', 'description', DB::raw("CONCAT('" . asset('storage/app/public/testimonials') . "/', image) AS image_url"))->where('is_deleted', 2)->orderBy('id', 'DESC')->get();

      return response()->json(['status' => 1, 'message' => trans('messages.success'), 'is_notification' => $notification->is_notification, 'appdata' => $appsettings, 'banner_1' => $banners_1, 'banner_2' => $banners_2, 'categorydata' => $categorydata, 'servicedata' => $servicedata, 'providerdata' => $providerdata, 'blogdata' => $blog_data, 'testimonials' => $testimonials], 200);
   }

   public function view_all(Request $request)
   {
      if ($request->type != "blogs" && $request->type != "reviews" && $request->type != "services" && $request->type != "providers") {
         return response()->json(['status' => 0, 'message' => trans('messages.invalid_request')], 200);
      }
      $user_id = $request->user_id;

      if ($request->type == "reviews") {
         $reviewdata = Testimonials::select('id', 'name', 'rating', 'description', DB::raw("CONCAT('" . asset('storage/app/public/testimonials') . "/', image) AS image_url"))
            ->where('is_deleted', 2)
            ->orderBy('id', 'DESC')
            ->paginate(12);
         return response()->json(['status' => 1, 'message' => trans('messages.success'), 'reviewdata' => $reviewdata], 200);
      }

      if ($request->type == "blogs") {
         $blogdata = Blog::select('id', 'title', 'description', DB::raw("CONCAT('" . asset('storage/app/public/blogs/') . "/', image) AS image_url"))
            ->where('is_deleted', 2)
            ->orderByDesc('id')
            ->paginate(12);
         return response()->json(['status' => 1, 'message' => trans('messages.success'), 'blogdata' => $blogdata], 200);
      }

      if ($request->type == "services") {
         if ($request->city_id == "") {
            return response()->json(['status' => 0, 'message' => trans('messages.enter_city')], 200);
         }
         $servicedata = Service::with('api_rattings')
            ->join('categories', 'services.category_id', '=', 'categories.id')
            ->join('users', 'services.provider_id', '=', 'users.id')
            ->leftJoin('favorites', function ($query) use ($user_id) {
               $query->on('favorites.service_id', '=', 'services.id')
                  ->where('favorites.user_id', '=', $user_id);
            })
            ->select(
               'services.id',
               'services.name as service_name',
               'services.price',
               'services.price_type',
               'services.duration',
               'services.duration_type',
               'categories.name as category_name',
               'users.name as provider_name',
               DB::raw('(case when favorites.service_id is null then 0 else 1 end) as is_favorite'),
               DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', services.image) AS image_url"),
               DB::raw("CONCAT('" . asset('storage/app/public/provider') . "/', users.image) AS provider_image_url")
            )
            ->where('users.city_id', $request->city_id);

         if ($request->has('provider_id') && $request->provider_id != "") {

            $checkprovider = User::where('id', $request->provider_id)->where('is_available', 1)->where('type', 2)->first();
            if (!empty($checkprovider)) {
               $servicedata = $servicedata->where('services.provider_id', $request->provider_id);
            } else {
               return response()->json(['status' => 0, 'message' => trans('messages.invalid_provider')], 200);
            }
         }
         $servicedata = $servicedata->where('users.is_available', 1)
            ->where('services.is_available', 1)
            ->where('services.is_deleted', 2)
            ->orderByDesc('services.id')
            ->paginate(10);

         return response()->json(['status' => 1, 'message' => trans('messages.success'), 'servicedata' => $servicedata], 200);
      }

      if ($request->type == "providers") {
         if ($request->city_id == "") {
            return response()->json(['status' => 0, 'message' => trans('messages.enter_city')], 200);
         }
         $providerdata = User::with('api_rattings')
            ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
            ->join('cities', 'users.city_id', '=', 'cities.id')
            ->leftJoin('favorites', function ($query) use ($user_id) {
               $query->on('favorites.provider_id', '=', 'users.id')
                  ->where('favorites.user_id', '=', $user_id);
            })
            ->select(
               'users.id',
               'users.name as provider_name',
               'cities.name as city_name',
               'provider_types.name as provider_type',
               DB::raw('(case when favorites.provider_id is null then 0 else 1 end) as is_favorite'),
               DB::raw("CONCAT('" . asset('storage/app/public/provider') . "/', users.image) AS image_url")
            )
            ->where('users.city_id', $request->city_id)
            ->where('users.type', 2)
            ->where('users.is_available', 1)
            ->orderByDesc('users.id')
            ->paginate(10);

         return response()->json(['status' => 1, 'message' => trans('messages.success'), 'providerdata' => $providerdata], 200);
      }
   }

   public function servicedetails(Request $request)
   {
      if ($request->service_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_service_id')], 200);
      }
      if ($request->city_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_city')], 200);
      }

      $user_id = $request->user_id;
      $servicedata = Service::with('api_rattings')
         ->join('categories', 'services.category_id', '=', 'categories.id')
         ->join('users', 'services.provider_id', '=', 'users.id')
         ->leftJoin('favorites', function ($query) use ($user_id) {
            $query->on('favorites.service_id', '=', 'services.id')
               ->where('favorites.user_id', '=', $user_id);
         })
         ->select(
            'services.id',
            'services.name as service_name',
            'services.price',
            'services.price_type',
            'services.duration',
            'services.duration_type',
            'services.description',
            'categories.name as category_name',
            'users.name as provider_name',
            'services.provider_id',
            'services.category_id',
            DB::raw('(case when favorites.service_id is null then 0 else 1 end) as is_favorite'),
            DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', services.image) AS image_url"),
            DB::raw("CONCAT('" . asset('storage/app/public/provider') . "/', users.image) AS provider_image_url")
         )
         ->where('services.id', $request->service_id)
         ->first();

      if (!empty($servicedata)) {
         $galleryimages = GalleryImages::select(
            'gallery_images.id',
            DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', gallery_images.image) AS image_url")
         )
            ->where('gallery_images.service_id', $request->service_id)
            ->orderByDesc('gallery_images.id')
            ->get();
         $providerdata = User::with('api_rattings')
            ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
            ->join('cities', 'users.city_id', '=', 'cities.id')
            ->leftJoin('favorites', function ($query) use ($user_id) {
               $query->on('favorites.provider_id', '=', 'users.id')
                  ->where('favorites.user_id', '=', $user_id);
            })
            ->select(
               'users.id',
               'users.name as provider_name',
               'cities.name as city_name',
               'provider_types.name as provider_type',
               DB::raw('(case when favorites.provider_id is null then 0 else 1 end) as is_favorite'),
               DB::raw("CONCAT('" . asset('storage/app/public/provider') . "/', users.image) AS image_url")
            )->where('users.id', $servicedata->provider_id)
            ->where('users.type', 2)
            ->where('users.is_available', 1)
            ->first();

         $reletedservices = Service::with('api_rattings')
            ->join('categories', 'services.category_id', '=', 'categories.id')
            ->join('users', 'services.provider_id', '=', 'users.id')
            ->leftJoin('favorites', function ($query) use ($user_id) {
               $query->on('favorites.service_id', '=', 'services.id')
                  ->where('favorites.user_id', '=', $user_id);
            })
            ->select(
               'services.id',
               'services.name as service_name',
               'services.price',
               'services.price_type',
               'services.duration',
               'services.duration_type',
               'categories.name as category_name',
               'users.name as provider_name',
               DB::raw('(case when favorites.service_id is null then 0 else 1 end) as is_favorite'),
               DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', services.image) AS image_url"),
               DB::raw("CONCAT('" . asset('storage/app/public/provider') . "/', users.image) AS provider_image_url")
            )
            ->where('users.city_id', $request->city_id)
            ->where('services.category_id', $servicedata->category_id)
            ->where('services.id', '!=', $servicedata->id)
            ->where('users.is_available', 1)
            ->where('services.is_available', 1)
            ->where('services.is_deleted', 2)
            ->orderByDesc('services.id')
            ->take(10)->get();
         $servicerattingsdata = Rattings::join('users', 'rattings.user_id', '=', 'users.id')
            ->select(
               'rattings.id',
               'rattings.service_id',
               'rattings.ratting',
               'rattings.comment',
               'users.name as user_name',
               DB::raw('DATE(rattings.created_at) AS date'),
               DB::raw("CONCAT('" . asset('storage/app/public/profile') . "/', users.image) AS user_image_url")
            )
            ->where('rattings.service_id', $request->service_id)
            ->orderBy('rattings.id', 'desc')
            ->get();

         $totalreview = Rattings::where(["service_id" => $request->service_id])->count();

         $serviceavg_ratting = Rattings::where('service_id', $request->service_id)
            ->selectRaw('SUM(ratting)/COUNT(user_id) AS avg_ratting')->first();
         $serviceaverageratting = number_format($serviceavg_ratting->avg_ratting, 1);

         $fivestaraverage = Rattings::where('service_id', $request->service_id)
            ->where('ratting', 5)->count();
         if ($totalreview != 0) {
            $five = ($fivestaraverage / $totalreview);
         } else {
            $five = 0;
         }
         $fourstaraverage = Rattings::where('service_id', $request->service_id)
            ->where('ratting', 4)->count();
         if ($totalreview != 0) {
            $four = ($fourstaraverage / $totalreview);
         } else {
            $four = 0;
         }
         $threestaraverage = Rattings::where('service_id', $request->service_id)
            ->where('ratting', 3)->count();
         if ($totalreview != 0) {
            $three = ($threestaraverage / $totalreview);
         } else {
            $three = 0;
         }
         $twostaraverage = Rattings::where('service_id', $request->service_id)
            ->where('ratting', 2)->count();
         if ($totalreview != 0) {
            $two = ($twostaraverage / $totalreview);
         } else {
            $two = 0;
         }
         $onestaraverage = Rattings::where('service_id', $request->service_id)
            ->where('ratting', 1)->count();
         if ($totalreview != 0) {
            $one = ($onestaraverage / $totalreview);
         } else {
            $one = 0;
         }

         return response()->json(['status' => 1, 'message' => trans('messages.success'), 'servicedata' => $servicedata, 'galleryimages' => $galleryimages, 'providerdata' => $providerdata, 'reletedservices' => $reletedservices, 'servicerattingsdata' => $servicerattingsdata, 'totalreview' => $totalreview, 'serviceaverageratting' => $serviceaverageratting, 'five' => $five, 'four' => $four, 'three' => $three, 'two' => $two, 'one' => $one], 200);
      } else {
         return response()->json(['status' => 0, 'message' => trans('messages.not_found')], 200);
      }
   }
   public function servicerattings(Request $request)
   {
      if ($request->service_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_service_id')], 200);
      }

      $checkservice = Service::where('id', $request->service_id)->first();

      if (!empty($checkservice)) {

         $rattingsdata = Rattings::join('services', 'rattings.service_id', '=', 'services.id')
            ->join('users', 'rattings.user_id', '=', 'users.id')
            ->select(
               'rattings.id',
               'rattings.ratting',
               'rattings.comment',
               'users.name as user_name',
               'services.name as service_name',
               DB::raw('DATE(rattings.created_at) AS date'),
               DB::raw("CONCAT('" . asset('storage/app/public/profile') . "/', users.image) AS image_url")
            )
            ->where('rattings.service_id', $request->service_id)
            ->orderByDesc('rattings.id')
            ->paginate(10);

         $averageratting = Rattings::where('service_id', $request->service_id)
            ->select(DB::raw('ROUND(avg(rattings.ratting),2) as avg_ratting'))
            ->get();

         return response()->json(['status' => 1, 'message' => trans('messages.success'), 'averageratting' => $averageratting, 'rattingsdata' => $rattingsdata], 200);
      } else {
         return response()->json(['status' => 0, 'message' => trans('messages.invalid_service')], 200);
      }
   }

   public function galleryimages(Request $request)
   {
      if ($request->service_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_service_id')], 200);
      }

      $checkservice = Service::where('id', $request->service_id)->where('is_available', 1)->where('is_deleted', 2)->first();

      if (!empty($checkservice)) {

         $galleryimages = GalleryImages::select(
            'gallery_images.id',
            DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', gallery_images.image) AS image_url")
         )
            ->where('gallery_images.service_id', $request->service_id)
            ->orderByDesc('gallery_images.id')
            ->paginate(10);

         return response()->json(['status' => 1, 'message' => trans('messages.success'), 'galleryimages' => $galleryimages], 200);
      } else {
         return response()->json(['status' => 0, 'message' => trans('messages.invalid_service')], 200);
      }
   }

   public function providerdetails(Request $request)
   {
      if ($request->provider_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_provider_id')], 200);
      }
      if ($request->city_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_city')], 200);
      }
      $user_id = $request->user_id;
      $providerdata = User::with('api_rattings')
         ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
         ->join('cities', 'users.city_id', '=', 'cities.id')
         ->leftJoin('favorites', function ($query) use ($user_id) {
            $query->on('favorites.provider_id', '=', 'users.id')
               ->where('favorites.user_id', '=', $user_id);
         })
         ->select(
            'users.id',
            'users.name as provider_name',
            'users.email',
            'users.mobile',
            'users.address',
            'cities.name as city_name',
            'users.about',
            'provider_types.name as provider_type',
            DB::raw('(case when favorites.provider_id is null then 0 else 1 end) as is_favorite'),
            DB::raw("CONCAT('" . asset('storage/app/public/provider') . "/', users.image) AS image_url")
         )
         ->where('users.id', $request->provider_id)
         ->where('users.city_id', $request->city_id)
         ->where('users.type', 2)
         ->where('users.is_available', 1)
         ->first();

      if (!empty($providerdata)) {
         $servicedata =  Service::with('api_rattings')
            ->join('categories', 'services.category_id', '=', 'categories.id')
            ->join('users', 'services.provider_id', '=', 'users.id')
            ->leftJoin('favorites', function ($query) use ($user_id) {
               $query->on('favorites.service_id', '=', 'services.id')
                  ->where('favorites.user_id', '=', $user_id);
            })
            ->select(
               'services.id',
               'services.name as service_name',
               'services.price',
               'services.price_type',
               'services.duration',
               'services.duration_type',
               'categories.name as category_name',
               'users.name as provider_name',
               DB::raw('(case when favorites.service_id is null then 0 else 1 end) as is_favorite'),
               DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', services.image) AS image_url"),
               DB::raw("CONCAT('" . asset('storage/app/public/provider') . "/', users.image) AS provider_image_url")
            )
            ->where('services.provider_id', $providerdata->id)
            ->where('users.is_available', 1)
            ->where('services.is_available', 1)
            ->where('services.is_deleted', 2)
            ->orderByDesc('services.id')
            ->get();
         $providerrattingsdata = Rattings::join('users', 'rattings.user_id', '=', 'users.id')
            ->select(
               'rattings.id',
               'rattings.ratting',
               'rattings.comment',
               'users.name as user_name',
               DB::raw("CONCAT('" . asset('storage/app/public/profile') . "/', users.image) AS user_image_url"),
               DB::raw('DATE(rattings.created_at) AS date')
            )
            ->where('rattings.provider_id', $providerdata->id)
            ->get();

         return response()->json(['status' => 1, 'message' => trans('messages.success'), 'providerdata' => $providerdata, 'servicedata' => $servicedata, 'providerrattingsdata' => $providerrattingsdata], 200);
      } else {
         return response()->json(['status' => 0, 'message' => trans('messages.not_found')], 200);
      }
   }

   public function providerrattings(Request $request)
   {
      if ($request->provider_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_provider_id')], 200);
      }

      $checkprovider = User::where('id', $request->provider_id)->where('is_available', 1)->where('type', 2)->first();

      if (!empty($checkprovider)) {
         $rattingsdata = Rattings::join('users', 'rattings.user_id', '=', 'users.id')
            ->join('services', 'rattings.service_id', '=', 'services.id')
            ->select(
               'rattings.id',
               'rattings.ratting',
               'rattings.comment',
               'users.name as user_name',
               'services.name as service_name',
               DB::raw('DATE(rattings.created_at) AS date'),
               DB::raw("CONCAT('" . asset('storage/app/public/profile') . "/', users.image) AS image_url"),
               DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', services.image) AS service_image_url")
            )
            ->where('rattings.provider_id', $request->provider_id)
            ->orderByDesc('rattings.id')
            ->paginate(10);

         $averageratting = Rattings::where('provider_id', $request->provider_id)
            ->select(DB::raw('ROUND(avg(rattings.ratting),2) as avg_rattings'))
            ->get();

         return response()->json(['status' => 1, 'message' => trans('messages.success'), 'averageratting' => $averageratting, 'rattingsdata' => $rattingsdata], 200);
      } else {
         return response()->json(['status' => 0, 'message' => trans('messages.invalid_provider')], 200);
      }
   }
   public function cmspages()
   {
      $termsconditions = CMS::select('tc_content')->first();
      $privacypolicy = CMS::select('privacy_content')->first();
      $about = CMS::select('about_content')->first();
      return response()->json(['status' => 1, 'message' => trans('messages.success'), 'termsconditions' => $termsconditions->tc_content, "privacypolicy" => $privacypolicy->privacy_content, "about" => $about->about_content], 200);
   }
}
