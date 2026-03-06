<?php

namespace App\Http\Controllers\front;

use App\Helpers\helper;
use App\Http\Controllers\Controller;
use App\Models\AppDownload;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use App\Models\Timing;
use App\Models\Rattings;
use App\Models\CMS;
use App\Models\City;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Brand;
use App\Models\FAQ;
use App\Models\FooterFeatures;
use App\Models\GalleryImages;
use App\Models\HowITWorkes;
use App\Models\QuestionAnswer;
use App\Models\Setting;
use App\Models\SystemAddons;
use App\Models\Testimonials;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (!file_exists(storage_path() . "/installed")) {
            return redirect('install');
            exit;
        }
        if (isset($_COOKIE["city_id"])) {
            if (Auth::check()) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = '';
            }
            $city = City::select('id')->where('id', $_COOKIE['city_id'])->first();
            $categorydata = Category::select('id', 'name', 'slug', 'image')
                ->where('is_available', 1)
                ->where('is_deleted', 2)
                ->orderBy('reorder_id')->take(10)->get();
            $servicedata = Service::join('categories', 'services.category_id', '=', 'categories.id')
                ->join('users', 'services.provider_id', '=', 'users.id')
                ->leftJoin('wishlists', function ($query) use ($user_id) {
                    $query->on('wishlists.service_id', '=', 'services.id')
                        ->where('wishlists.user_id', '=', $user_id);
                })
                ->select(
                    'services.id',
                    'services.name as service_name',
                    'services.is_top_deals',
                    'services.slug',
                    'services.price',
                    'services.price_type',
                    'services.duration',
                    'services.duration_type',
                    'categories.name as category_name',
                    'users.mobile',
                    'users.image as provider_image',
                    'users.name as provider_name',
                    'services.image as service_image',
                    DB::raw('(case when wishlists.service_id is null then 0 else 1 end) as is_favorite')
                )
                ->where('users.city_id', @$city->id)
                ->where('services.is_available', 1)
                ->where('services.is_deleted', 2)
                ->where('services.is_featured', 1)
                ->orderBy('services.reorder_id')->take(8)->get();

            $topdealsservicedata = Service::join('categories', 'services.category_id', '=', 'categories.id')
                ->join('users', 'services.provider_id', '=', 'users.id')
                ->leftJoin('wishlists', function ($query) use ($user_id) {
                    $query->on('wishlists.service_id', '=', 'services.id')
                        ->where('wishlists.user_id', '=', $user_id);
                })
                ->select(
                    'services.id',
                    'services.name as service_name',
                    'services.slug',
                    'services.price',
                    'services.is_top_deals',
                    'services.price_type',
                    'services.duration',
                    'services.duration_type',
                    'categories.name as category_name',
                    'users.mobile',
                    'users.image as provider_image',
                    'users.name as provider_name',
                    'services.image as service_image',
                    DB::raw('(case when wishlists.service_id is null then 0 else 1 end) as is_favorite')
                )
                ->where('users.city_id', @$city->id)
                ->where('services.is_available', 1)
                ->where('services.is_deleted', 2)
                ->where('services.is_top_deals', 1)
                ->orderBy('services.reorder_id')->take(8)->get();
            $providerdata = User::with('rattings')
                ->join('cities', 'users.city_id', '=', 'cities.id')
                ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
                ->select(
                    'users.id',
                    'users.name as provider_name',
                    'users.email',
                    'users.mobile',
                    'users.about',
                    'users.slug',
                    'users.address',
                    'cities.name as city_name',
                    'provider_types.name as provider_type',
                    'users.image as provider_image'
                )
                ->where('users.city_id', @$city->id)
                ->where('users.type', 2)->where('users.is_available', 1)
                ->orderByDesc('users.id')->take(10)->get();

            $banners = Banner::with('categoryname', 'servicename')
                ->leftJoin('services', 'banners.service_id', 'services.id')
                ->leftJoin('users', 'services.provider_id', 'users.id')
                ->leftJoin('categories', 'categories.id', 'banners.category_id')
                ->select('banners.id', 'banners.section', 'banners.type', 'banners.service_id', 'banners.category_id', 'users.city_id', 'banners.image', 'categories.slug as category_slug', 'services.slug as service_slug', 'services.name as sname')
                ->orderBy('banners.reorder_id')
                ->get();
            $bannerdata = array();
            foreach ($banners as $bdata) {
                $bannerdata[] = array(
                    'id' => $bdata->id,
                    'section' => $bdata->section,
                    'category_id' => $bdata->category_id,
                    'service_id' => $bdata->service_id,
                    'image' => $bdata->image,
                    'category_slug' => $bdata->category_slug,
                    'service_slug' => $bdata->service_slug,
                    'type' => $bdata->type,
                );
            }
            $howitwork = Setting::select('how_it_works_title', 'how_it_works_sub_title', 'how_it_works_image', 'how_it_works_description')->first();
            $howitworkdata = HowITWorkes::where('is_deleted', 2)->orderBy('reorder_id')->take(5)->get();

            $testimonials = Testimonials::where('is_deleted', 2)->orderBy('reorder_id')->get();

            $faq = Setting::select('faq_title', 'faq_sub_title', 'faq_description', 'faq_image')->first();
            $faqdata = FAQ::where('is_deleted', 2)->orderBy('reorder_id')->get();

            $blogdata = Blog::where('is_deleted', 2)->orderBy('reorder_id')->get();

            $appdownload = AppDownload::select('title', 'description', 'image', 'android_url', 'ios_url')->first();

            $getfooterfeature = FooterFeatures::orderByDesc('id')->get();
            $getbrands = Brand::select('image', DB::raw("CONCAT('" . url(env('ASSETSPATHURL') . '/images') . "/', image) AS image_url"))->orderByDesc('id')->get();
        } else {
            $categorydata = "";
            $servicedata = "";
            $topdealsservicedata = "";
            $providerdata = "";
            $howitwork = "";
            $howitworkdata = "";
            $testimonials = "";
            $faq = "";
            $faqdata = "";
            $blogdata = "";
            $appdownload = "";
            $getfooterfeature = "";
            $bannerdata = array();
            $getbrands = '';
        }
        if ($request->is('pwa')) {
            return view('front.themepwa', compact('categorydata', 'servicedata', 'topdealsservicedata', 'providerdata', 'bannerdata', 'howitwork', 'howitworkdata', 'testimonials', 'faq', 'faqdata', 'blogdata', 'appdownload', 'getfooterfeature', 'getbrands'));
        } else {
            return view("front.home", compact('categorydata', 'servicedata', 'topdealsservicedata', 'providerdata', 'bannerdata', 'howitwork', 'howitworkdata', 'testimonials', 'faq', 'faqdata', 'blogdata', 'appdownload', 'getfooterfeature', 'getbrands'));
        }
    }

    public function categories()
    {
        if (isset($_COOKIE["city_id"])) {
            $categorydata = Category::select('id', 'name', 'slug', 'image')->where('is_available', 1)->where('is_deleted', 2)->orderBy('reorder_id')->get();
        } else {
            $categorydata = "";
        }
        return view("front.categories", compact('categorydata'));
    }

    public function providers()
    {
        if (isset($_COOKIE["city_id"])) {
            $city = City::select('id')->where('id', $_COOKIE['city_id'])->first();

            $providerdata = User::with('rattings')
                ->join('cities', 'users.city_id', '=', 'cities.id')
                ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
                ->select(
                    'users.id',
                    'users.name as provider_name',
                    'users.email',
                    'users.mobile',
                    'users.about',
                    'users.slug',
                    'users.address',
                    'cities.name as city_name',
                    'provider_types.name as provider_type',
                    'users.image as provider_image'
                )
                ->where('users.city_id', @$city->id)
                ->where('users.type', 2)->where('users.is_available', 1)
                ->orderByDesc('users.id')
                ->paginate(10)->onEachSide(0);
        } else {
            $providerdata = "";
        }
        return view("front.providers", compact('providerdata'));
    }

    public function provider_details($provider)
    {
        if (isset($_COOKIE["city_id"])) {

            $city = City::select('id')->where('id', $_COOKIE['city_id'])->first();

            $providerdata = User::select('users.id', 'users.name as provider_name', 'users.address', 'users.email', 'users.mobile', 'users.about', 'users.slug', 'users.image as provider_image')
                ->where('users.city_id', @$city->id)->where('users.type', 2)->where('users.is_available', 1)->where('users.slug', $provider)
                ->first();
            if (empty($providerdata)) {
                return redirect(route('home'));
            } else {
                $timingdata = Timing::select('day', 'open_time', 'close_time', 'is_always_close')->where('provider_id', $providerdata->id)->get();
            }
        } else {
            $providerdata = "";
            $timingdata = "";
        }
        return view("front.provider_details", compact('providerdata', 'timingdata'));
    }

    public function provider_rattings($provider)
    {
        if (isset($_COOKIE["city_id"])) {

            $city = City::select('id')->where('id', $_COOKIE['city_id'])->first();

            $providerdata = User::select('users.id', 'users.name as provider_name', 'users.slug', 'users.image as provider_image')
                ->where('users.city_id', @$city->id)->where('users.type', 2)->where('users.is_available', 1)->where('users.slug', $provider)
                ->first();
            if (empty($providerdata)) {
                return redirect(route('home'));
            } else {
                $providerrattingsdata = Rattings::join('users', 'rattings.user_id', '=', 'users.id')
                    ->select(
                        'rattings.id',
                        'rattings.ratting',
                        'rattings.comment',
                        'rattings.created_at',
                        'users.name as user_name',
                        'users.image as user_image',
                    )
                    ->where('rattings.provider_id', $providerdata->id)
                    ->paginate(10)->onEachSide(0);
            }
        } else {
            $providerdata = "";
            $providerrattingsdata = "";
        }
        return view("front.provider_rattings", compact('providerdata', 'providerrattingsdata'));
    }

    public function provider_services($provider)
    {
        if (isset($_COOKIE["city_id"])) {
            if (Auth::check()) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = '';
            }
            $city = City::select('id')->where('id', $_COOKIE['city_id'])->first();

            $providerdata = User::select('users.id', 'users.name as provider_name', 'users.slug', 'users.image as provider_image')
                ->where('users.city_id', @$city->id)->where('users.type', 2)->where('users.is_available', 1)->where('users.slug', $provider)
                ->first();

            if (empty($providerdata)) {
                return redirect(route('home'));
            } else {
                $servicedata = Service::join('categories', 'services.category_id', '=', 'categories.id')
                    ->join('users', 'services.provider_id', '=', 'users.id')
                    ->leftJoin('wishlists', function ($query) use ($user_id) {
                        $query->on('wishlists.service_id', '=', 'services.id')
                            ->where('wishlists.user_id', '=', $user_id);
                    })
                    ->select(
                        'services.id',
                        'services.name as service_name',
                        'services.price',
                        'users.city_id',
                        'services.price_type',
                        'services.duration',
                        'services.is_top_deals',
                        'services.duration_type',
                        'categories.name as category_name',
                        'services.slug',
                        'services.image as service_image',
                        'users.mobile as provider_mobile',
                        'users.image as provider_image',
                        'users.name as provider_name',
                        DB::raw('(case when wishlists.service_id is null then 0 else 1 end) as is_favorite')
                    )
                    ->where('services.provider_id', $providerdata->id)
                    ->where('services.is_available', 1)
                    ->where('services.is_deleted', 2)
                    ->orderBy('services.reorder_id')
                    ->paginate(9)->onEachSide(0);
            }
        } else {
            $providerdata = "";
            $servicedata = "";
        }
        return view("front.provider_services", compact('servicedata', 'providerdata'));
    }

    public function category_services(Request $request, $category)
    {
        if (isset($_COOKIE["city_id"])) {
            if (Auth::check()) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = '';
            }
            $city = City::select('id')->where('id', $_COOKIE['city_id'])->first();
            $categorydata = Category::where('is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get();
            $citydata = City::select('id', 'name', 'image')->where('is_available', 1)->where('is_deleted', 2)->orderBy('reorder_id')->get();
            $servicedata = Service::join('users', 'services.provider_id', '=', 'users.id')
                ->join('categories', 'services.category_id', '=', 'categories.id')
                ->leftJoin('wishlists', function ($query) use ($user_id) {
                    $query->on('wishlists.service_id', '=', 'services.id')
                        ->where('wishlists.user_id', '=', $user_id);
                })
                ->select(
                    'services.id',
                    'services.name as service_name',
                    'services.slug',
                    'services.price',
                    'services.price_type',
                    'services.duration',
                    'services.duration_type',
                    'services.is_top_deals',
                    'services.avg_ratting',
                    'categories.name as category_name',
                    'users.mobile',
                    'users.image as provider_image',
                    'users.name as provider_name',
                    'services.image as service_image',
                    DB::raw('(case when wishlists.service_id is null then 0 else 1 end) as is_favorite')
                )
                ->where('categories.slug', $category)
                ->where('users.city_id', @$city->id)
                ->where('services.is_available', 1)
                ->where('services.is_deleted', 2);
            //Price range filter
            $maxprice = $servicedata->max('price');
            $filter_price_start = $request->get('filter_price_start') != null  ? $request->get('filter_price_start') : 0;
            $filter_price_end = $request->get('filter_price_end') != null  ? $request->get('filter_price_end') : $maxprice;
            if ($request->get('filter_price_start') >= 0 && $request->get('filter_price_end') > 0) {
                $servicedata->whereBetween('services.price', [$filter_price_start, $filter_price_end])->orderByRaw('CAST(services.price AS UNSIGNED) DESC');
            }
            //Ratting filter
            if ($request->get('rattings') != null && $request->get('rattings') == 1) {
                $servicedata->where('services.avg_ratting', '<=', 1)->where('services.avg_ratting', '>', 0);
            } elseif ($request->get('rattings') != null && $request->get('rattings') == 2) {
                $servicedata->where('services.avg_ratting', '<=', 2)->where('services.avg_ratting', '>', 1);
            } elseif ($request->get('rattings') != null && $request->get('rattings') == 3) {
                $servicedata->where('services.avg_ratting', '<=', 3)->where('services.avg_ratting', '>', 2);
            } elseif ($request->get('rattings') != null && $request->get('rattings') == 4) {
                $servicedata->where('services.avg_ratting', '<=', 4)->where('services.avg_ratting', '>', 3);
            } elseif ($request->get('rattings') != null && $request->get('rattings') == 5) {
                $servicedata->where('services.avg_ratting', '<=', 5)->where('services.avg_ratting', '>', 4);
            }

            if ($request->get('sort') == 'newest') {
                $servicedata->orderBy('services.created_at', 'desc');
            } elseif ($request->get('sort') == 'oldest') {
                $servicedata->orderBy('services.created_at', 'asc');
            } elseif ($request->get('sort') == 'price_asc') {
                $servicedata->orderByRaw('CAST(services.price AS UNSIGNED) ASC');
            } elseif ($request->get('sort') == 'price_desc') {
                $servicedata->orderByRaw('CAST(services.price AS UNSIGNED) DESC');
            }
            $servicedata = $servicedata->orderByDesc('services.id')->paginate(12)->onEachSide(0);
        } else {
            $servicedata = "";
            $categorydata = "";
            $citydata = "";
            $maxprice = "";
            $filter_price_start = "";
            $filter_price_end = "";
        }

        return view("front.services", compact('servicedata', 'categorydata', 'citydata', 'maxprice', 'filter_price_start', 'filter_price_end'));
    }

    public function services(Request $request)
    {
        if (isset($_COOKIE["city_id"])) {
            if (Auth::check()) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = '';
            }
            $city = City::select('id')->where('id', $_COOKIE['city_id'])->first();
            $categorydata = Category::where('is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get();
            $citydata = City::select('id', 'name', 'image')->where('is_available', 1)->where('is_deleted', 2)->orderBy('reorder_id')->get();
            $servicedata = Service::with('service_multi_image')->join('users', 'services.provider_id', '=', 'users.id')
                ->join('categories', 'services.category_id', '=', 'categories.id')
                ->leftJoin('wishlists', function ($query) use ($user_id) {
                    $query->on('wishlists.service_id', '=', 'services.id')
                        ->where('wishlists.user_id', '=', $user_id);
                })
                ->select(
                    'services.id',
                    'services.name as service_name',
                    'services.slug',
                    'services.is_top_deals',
                    'services.price',
                    'services.price_type',
                    'services.duration',
                    'services.duration_type',
                    'services.avg_ratting',
                    'categories.name as category_name',
                    'users.mobile',
                    'users.image as provider_image',
                    'users.name as provider_name',
                    'services.image as service_image',
                    DB::raw('(case when wishlists.service_id is null then 0 else 1 end) as is_favorite')
                )
                ->where('users.city_id', @$city->id)
                ->where('services.is_available', 1)
                ->where('services.is_deleted', 2);

            //Price range filter
            $maxprice = $servicedata->max('price');
            $filter_price_start = $request->get('filter_price_start') != null  ? $request->get('filter_price_start') : 0;
            $filter_price_end = $request->get('filter_price_end') != null  ? $request->get('filter_price_end') : $maxprice;
            if ($request->get('filter_price_start') >= 0 && $request->get('filter_price_end') > 0) {
                $servicedata->whereBetween('services.price', [$filter_price_start, $filter_price_end]);
            }
            //Ratting filter
            if ($request->get('rattings') != null && $request->get('rattings') == 1) {
                $servicedata->where('services.avg_ratting', '<=', 1)->where('services.avg_ratting', '>', 0);
            } elseif ($request->get('rattings') != null && $request->get('rattings') == 2) {
                $servicedata->where('services.avg_ratting', '<=', 2)->where('services.avg_ratting', '>', 1);
            } elseif ($request->get('rattings') != null && $request->get('rattings') == 3) {
                $servicedata->where('services.avg_ratting', '<=', 3)->where('services.avg_ratting', '>', 2);
            } elseif ($request->get('rattings') != null && $request->get('rattings') == 4) {
                $servicedata->where('services.avg_ratting', '<=', 4)->where('services.avg_ratting', '>', 3);
            } elseif ($request->get('rattings') != null && $request->get('rattings') == 5) {
                $servicedata->where('services.avg_ratting', '<=', 5)->where('services.avg_ratting', '>', 4);
            }

            //Sorting Filter
            if ($request->get('type') == '1') {
                $servicedata->where('services.is_top_deals', 1);
            } elseif ($request->get('sorter') == 'newest') {
                $servicedata->orderBy('services.created_at', 'desc');
            } elseif ($request->get('sorter') == 'oldest') {
                $servicedata->orderBy('services.created_at', 'asc');
            } elseif ($request->get('sorter') == 'price_asc') {
                $servicedata->orderBy('services.price', 'ASC');
            } elseif ($request->get('sorter') == 'price_desc') {
                $servicedata->orderBy('services.price', 'DESC');
            }
            $servicedata = $servicedata->orderBy('services.reorder_id')->paginate(12)->onEachSide(0);
        } else {
            $servicedata = "";
            $categorydata = "";
            $citydata = "";
            $maxprice = "";
            $filter_price_start = "";
            $filter_price_end = "";
        }
        return view("front.services", compact('servicedata', 'categorydata', 'citydata', 'maxprice', 'filter_price_start', 'filter_price_end'));
    }

    public function service_details($service)
    {
        if (isset($_COOKIE["city_id"])) {
            if (Auth::check()) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = '';
            }
            
            $city = City::select('id')->where('id', $_COOKIE['city_id'])->first();
            $servicedata = Service::join('categories', 'services.category_id', 'categories.id')
                ->join('users', 'services.provider_id', 'users.id')
                ->leftJoin('wishlists', function ($query) use ($user_id) {
                    $query->on('wishlists.service_id', '=', 'services.id')
                        ->where('wishlists.user_id', '=', $user_id);
                })
                ->leftJoin('rattings', function ($query) use ($user_id) {
                    $query->on('rattings.service_id', '=', 'services.id')
                        ->where('rattings.user_id', '=', @$user_id);
                })
                ->select(
                    'services.id as service_id',
                    'services.name as service_name',
                    'services.price',
                    'services.tax',
                    'services.price_type',
                    'services.duration',
                    'services.duration_type',
                    'services.description',
                    'services.discount',
                    'services.slug',
                    'services.is_top_deals',
                    'categories.id as category_id',
                    'categories.name as category_name',
                    'categories.slug as category_slug',
                    'services.provider_id as provider_id',
                    'services.image as service_image',
                    DB::raw('(case when wishlists.service_id is null then 0 else 1 end) as is_favorite'),
                    DB::raw('(case when rattings.service_id is null then 0 else 1 end) as is_rated')
                )
                ->where('services.slug', $service)
                ->where('services.is_available', 1)
                ->where('services.is_deleted', 2)
                ->where('users.city_id', @$city->id)
                ->first();
            if (!empty($servicedata)) {
                $servicerattingsdata = Rattings::join('users', 'rattings.user_id', '=', 'users.id')
                    ->select(
                        'rattings.id',
                        'rattings.ratting',
                        'rattings.comment',
                        'rattings.created_at',
                        'users.name as user_name',
                        'users.image as user_image',
                    )
                    ->where('rattings.service_id', $servicedata->service_id)
                    ->where('rattings.status', 1)
                    ->orderBy('rattings.id', 'desc')
                    ->get();

                $totalreview = Rattings::where("service_id", $servicedata->service_id)->where('status', 1)->count();

                $fivestaraverage = Rattings::where('service_id', $servicedata->service_id)->where('ratting', 5)->where('status', 1)->count();
                $fourstaraverage = Rattings::where('service_id', $servicedata->service_id)->where('ratting', 4)->where('status', 1)->count();
                $threestaraverage = Rattings::where('service_id', $servicedata->service_id)->where('ratting', 3)->where('status', 1)->count();
                $twostaraverage = Rattings::where('service_id', $servicedata->service_id)->where('ratting', 2)->where('status', 1)->count();
                $onestaraverage = Rattings::where('service_id', $servicedata->service_id)->where('ratting', 1)->where('status', 1)->count();
                $data['fivestaraverage'] = $fivestaraverage;
                $data['fourstaraverage'] = $fourstaraverage;
                $data['threestaraverage'] = $threestaraverage;
                $data['twostaraverage'] = $twostaraverage;
                $data['onestaraverage'] = $onestaraverage;

                $galleryimages = GalleryImages::select('image as gallery_image')->where('service_id', $servicedata->service_id)->get();

                $checkbooking = Booking::where('user_id', $user_id)->where('service_id', $servicedata->service_id)->where('status', 3)->first();

                $providerdata = User::with('rattings')
                    ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
                    ->join('cities', 'users.city_id', '=', 'cities.id')
                    ->leftJoin('timings', 'timings.provider_id', '=', 'users.id')
                    ->select(
                        'users.id as provider_id',
                        'users.name as provider_name',
                        'users.email',
                        'users.slug',
                        'users.mobile',
                        'cities.name as city_name',
                        'users.about',
                        'provider_types.name as provider_type',
                        'users.image as provider_image',
                        'users.address as provider_address'
                    )
                    ->where('users.id', $servicedata->provider_id)
                    ->first();

                $timingdata = Timing::select('day', 'open_time', 'close_time', 'is_always_close')->where('provider_id', $providerdata->provider_id)->get();

                $reletedservices = Service::join('categories', 'services.category_id', '=', 'categories.id')
                    ->join('users', 'services.provider_id', '=', 'users.id')
                    ->leftJoin('wishlists', function ($query) use ($user_id) {
                        $query->on('wishlists.service_id', '=', 'services.id')
                            ->where('wishlists.user_id', '=', $user_id);
                    })
                    ->select(
                        'services.id',
                        'services.name as service_name',
                        'services.slug',
                        'services.price',
                        'services.price',
                        'services.price_type',
                        'services.duration',
                        'services.duration_type',
                        'services.is_top_deals',
                        'categories.id as category_id',
                        'categories.name as category_name',
                        'users.mobile as provider_mobile',
                        'users.image as provider_image',
                        'users.name as provider_name',
                        'services.image as service_image',
                        DB::raw('(case when wishlists.service_id is null then 0 else 1 end) as is_favorite')
                    )
                    ->where('services.category_id', $servicedata->category_id)
                    ->where('users.city_id', @$city->id)
                    ->where('services.id', '!=', $servicedata->service_id)
                    ->where('services.is_available', 1)->where('services.is_deleted', 2)
                    ->where('users.is_available', 1)->orderByDesc('services.id')
                    ->get();
            } else {
                $data = [];
                $totalreview = "";
                $servicedata = "";
                $serviceaverageratting = "";
                $servicerattingsdata = "";
                $galleryimages = "";
                $checkbooking = "";
                $providerdata = "";
                $timingdata = "";
                $reletedservices = "";
            }
        } else {
            $data = [];
            $totalreview = "";
            $servicedata = "";
            $serviceaverageratting = "";
            $servicerattingsdata = "";
            $galleryimages = "";
            $checkbooking = "";
            $providerdata = "";
            $timingdata = "";
            $reletedservices = "";
        }
       
        $question_answer = QuestionAnswer::where('service_id',@$servicedata->service_id)->where('provider_id', @$servicedata->provider_id)->whereNot('answer', '')->get();
      // recent view product module start
        $service = Service::with('service_multi_image', 'categoryname', 'providername', 'rattings')
            ->where('id', @$servicedata->service_id)
            ->first();

        $recent = session()->get('recently_viewed', []);

        // Remove duplicate if exists
        $recent = array_filter($recent, function ($id) use ($service) {
            return $service && $id != $service->id;
        });

        // Add current service to start
        if ($service) {
            array_unshift($recent, $service->id);
        }

        // Keep only 6 latest
        $recent = array_slice($recent, 0, 6);
        session(['recently_viewed' => $recent]);

        // ✅ If session has no recent IDs (e.g., after clearing data)
        if (!empty($recent) && $service) {
            $recentservice = Service::join('categories', 'services.category_id', '=', 'categories.id')
                ->join('users', 'services.provider_id', '=', 'users.id')
                ->leftJoin('wishlists', function ($query) use ($user_id) {
                    $query->on('wishlists.service_id', '=', 'services.id')
                        ->where('wishlists.user_id', '=', $user_id);
                })
                ->select(
                    'services.id as service_id',
                    'services.name as service_name',
                    'services.slug',
                    'services.price',
                    'services.tax',
                    'services.price_type',
                    'services.duration',
                    'services.duration_type',
                    'services.description',
                    'services.discount',
                    'services.is_top_deals',
                    'categories.id as category_id',
                    'categories.name as category_name',
                    'users.name as provider_name',
                    'users.image as provider_image',
                    'services.image as service_image',
                    DB::raw('(CASE WHEN wishlists.service_id IS NULL THEN 0 ELSE 1 END) AS is_favorite'),
                    DB::raw('(
                        SELECT COALESCE(AVG(rattings.ratting), 0)
                        FROM rattings
                        WHERE rattings.service_id = services.id
                        AND rattings.status = 1
                    ) as avg_ratting')
                )
                ->whereIn('services.id', $recent)
                ->where('services.id', '!=', $service->id)
                ->where('services.is_available', 1)
                ->where('services.is_deleted', 2)
                ->orderByDesc('services.id')
                ->get();

            $recentservice = collect($recent)
                ->map(fn($id) => $recentservice->firstWhere('service_id', $id))
                ->filter()
                ->values();
        } else {
            // ✅ Safe fallback if no recent services found
            $recentservice = collect();
        }
        // recent view product module end



       
        // dd($recentservice);
        return view("front.service_details", $data, compact('servicedata',  'servicerattingsdata', 'totalreview', 'galleryimages', 'checkbooking', 'providerdata', 'timingdata', 'reletedservices', 'question_answer','recentservice'));
    }

    public function search(Request $request)
    {
        if (isset($_COOKIE["city_id"])) {
            if (Auth::check()) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = '';
            }
            $city = City::select('id')->where('id', $_COOKIE['city_id'])->first();
            $search_by = $request->search_by;
            if ($search_by != "") {
                if ($search_by == "service") {
                    $servicedata = Service::join('users', 'services.provider_id', '=', 'users.id')
                        ->join('categories as cat', 'services.category_id', '=', 'cat.id')
                        ->leftJoin('wishlists', function ($query) use ($user_id) {
                            $query->on('wishlists.service_id', '=', 'services.id')
                                ->where('wishlists.user_id', '=', $user_id);
                        })
                        ->select(
                            'services.id',
                            'services.name as service_name',
                            'services.price',
                            'services.slug',
                            'services.image as service_image',
                            'services.price_type',
                            'services.duration',
                            'services.duration_type',
                            'services.is_top_deals',
                            'users.mobile',
                            'cat.name as category_name',
                            'users.image as provider_image',
                            'users.name as provider_name',
                            DB::raw('(case when wishlists.service_id is null then 0 else 1 end) as is_favorite')
                        )
                        ->where('users.city_id', @$city->id)
                        ->where('services.is_available', 1)
                        ->where('services.is_deleted', 2);

                    if ($request->has('search_name') && $request->search_name != "") {
                        $servicedata = $servicedata->where('services.name', 'LIKE', '%' . $request->search_name . '%');
                    }
                    $servicedata = $servicedata->orderByDesc('services.id')->paginate(12)->onEachSide(0);
                }
                if ($search_by == "provider") {
                    $providerdata = User::join('cities', 'users.city_id', 'cities.id')
                        ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
                        ->select('users.id as provider_id', 'provider_types.name as provider_type', 'users.name as provider_name', 'users.slug', 'users.mobile', 'users.about', 'users.image as provider_image')
                        ->where('users.type', 2)
                        ->where('users.is_available', 1)
                        ->where('users.city_id', @$city->id);
                    if ($request->has('search_name') && $request->search_name != "") {
                        $providerdata = $providerdata->where('users.name', 'LIKE', '%' . $request->search_name . '%');
                    }
                    $providerdata = $providerdata->orderByDesc('users.id')->paginate(12)->onEachSide(0);

                    return view("front.search", compact('providerdata'));
                }
            } else {
                $servicedata = Service::join('categories', 'services.category_id', '=', 'categories.id')
                    ->join('users', 'services.provider_id', '=', 'users.id')
                    ->leftJoin('wishlists', function ($query) use ($user_id) {
                        $query->on('wishlists.service_id', '=', 'services.id')
                            ->where('wishlists.user_id', '=', $user_id);
                    })
                    ->select(
                        'services.id',
                        'services.name as service_name',
                        'services.price',
                        'services.slug',
                        'services.image as service_image',
                        'services.price_type',
                        'services.duration',
                        'services.duration_type',
                        'services.is_top_deals',
                        'categories.id as category_id',
                        'categories.name as category_name',
                        'users.mobile',
                        'users.image as provider_image',
                        'users.name as provider_name',
                        DB::raw('(case when wishlists.service_id is null then 0 else 1 end) as is_favorite')
                    )
                    ->where('users.city_id', @$city->id)
                    ->where('services.is_available', 1)
                    ->where('services.is_deleted', 2)->orderBy('services.id')
                    ->paginate(12)->onEachSide(0);
            }
        } else {
            $servicedata = "";
        }
        return view("front.search", compact('servicedata'));
    }

    public function aboutus()
    {
        if (isset($_COOKIE["city_id"])) {
            $aboutdata = CMS::select('about_image', 'about_content')->first();
        } else {
            $aboutdata = "";
        }
        return view('front.aboutus', compact('aboutdata'));
    }
    public function tc()
    {
        if (isset($_COOKIE["city_id"])) {
            $tcdata = CMS::select('tc_content')->first();
        } else {
            $tcdata = "";
        }
        return view('front.tc', compact('tcdata'));
    }
    public function policy()
    {
        if (isset($_COOKIE["city_id"])) {
            $policydata = CMS::select('privacy_content')->first();
        } else {
            $policydata = "";
        }
        return view('front.policy', compact('policydata'));
    }
    public function find_service(Request $request)
    {
        if (isset($_COOKIE["city_id"])) {
            $city = City::select('id')->where('id', $_COOKIE['city_id'])->first();
            if ($request->ajax()) {
                $query = $request->get('query');
                if ($query != "") {
                    $servicedata = Service::join('users', 'services.provider_id', 'users.id')
                        ->select('services.name as service_name', 'services.slug as service_slug')
                        ->where('services.name', 'like', '%' . $query . '%')
                        ->where('users.city_id', @$city->id)
                        ->where('services.is_available', 1)
                        ->where('services.is_deleted', 2)
                        ->orderByDesc('services.id')
                        ->get();
                } else {
                    $servicedata = "";
                }
            }
        } else {
            $servicedata = "";
        }
        return view('front.suggest', compact('servicedata'))->render();
    }
    public function find_cities(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            if ($query != "") {
                $citydata = City::select('cities.name', 'cities.id', 'cities.image')
                    ->where('cities.name', 'like', '%' . $query . '%')
                    ->where('cities.is_available', 1)
                    ->where('cities.is_deleted', 2)
                    ->orderBy('reorder_id')
                    ->get();
            } else {
                $citydata = City::select('cities.name', 'cities.id', 'cities.image')
                    ->where('cities.is_available', 1)
                    ->where('cities.is_deleted', 2)
                    ->orderBy('reorder_id')
                    ->get();
            }
            return view('front.suggest', compact('citydata'))->render();
        }
    }

    public function isopenclose(Request $request)
    {
        if (@helper::appdata()->timezone != "") {
            date_default_timezone_set(helper::appdata()->timezone);
        }
        $checkservice = Service::where('id', $request->service_id)->where('is_available', 1)->where('is_deleted', 2)->first();
        $date = date('Y/m/d h:i:sa');
        $isopenclose = Timing::where('provider_id', $checkservice->provider_id)->where('day', '=', date('l', strtotime($date)))->first();
        $current_time = DateTime::createFromFormat('H:i a', date("h:i a"));
        $open_time = DateTime::createFromFormat('H:i a', $isopenclose->open_time);
        $close_time = DateTime::createFromFormat('H:i a', $isopenclose->close_time);
        if ($isopenclose->is_always_close == "2" &&  ($current_time > $open_time && $current_time < $close_time)) {
            if (SystemAddons::where('unique_identifier', 'customer_login')->first() != null && SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1) {
                if (Auth::user() && Auth::user()->type == 4) {
                    $checkouturl = URL::to("/home/service/continue/checkout/" . $checkservice->slug);
                    return response()->json(['status' => 1, 'message' => trans('messages.success'), 'checkouturl' => $checkouturl], 200);
                } else {
                    if (helper::appdata()->login_required == 1) {
                        if (helper::appdata()->is_checkout_login_required == 1) {
                            $loginurl = URL::to('/home/login');
                            return response()->json(['status' => 2, 'message' => trans('messages.success'), 'loginurl' => $loginurl], 200);
                        } else {
                            $loginurl = URL::to('/home/login');
                            $checkouturl = URL::to("/home/service/continue/checkout/" . $checkservice->slug);
                            return response()->json(['status' => 3, 'message' => trans('messages.success'), 'loginurl' => $loginurl, 'checkouturl' => $checkouturl], 200);
                        }
                    } else {
                        $checkouturl = URL::to("/home/service/continue/checkout/" . $checkservice->slug);
                        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'checkouturl' => $checkouturl], 200);
                    }
                }
            } else {
                $checkouturl = URL::to("/home/service/continue/checkout/" . $checkservice->slug);
                return response()->json(['status' => 1, 'message' => trans('messages.success'), 'checkouturl' => $checkouturl], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.service_closed')], 200);
        }
    }
}
