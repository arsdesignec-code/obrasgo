<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\User;
use App\Models\Subscribe;
use App\Models\Service;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function home(Request $request)
    {
        $total_categories = Category::where('is_deleted', 2)->count();
        $total_providers = User::where('type', 2)->count();
        $total_services = Service::where('is_deleted', 2)->count();
        $total_handymans = User::where('type', 3)->count();
        $total_cities = City::where('is_deleted', 2)->count();

        $recent_providers = User::with('providertype', 'avgrattings')->where('type', 2)->take(6)->orderByDesc('id')->get();
        $recent_customers = User::where('type', 4)->take(6)->orderByDesc('id')->get();
        $recent_bookings = Booking::take(6)->orderByDesc('id')->get();
        $top_services = "";
        $total_bookings = "";
        $top_customers = "";
        if (Auth::user()->type == 2) {
            $recent_bookings = Booking::where('provider_id', Auth::user()->id)->whereDate('created_at', Carbon::today())->orderByDesc('id')->get();
            $top_services = Service::with('categoryname')->join('bookings', 'bookings.service_id', '=', 'services.id')->select('services.id', 'services.name', 'services.category_id', 'services.image', DB::raw('count(bookings.service_id) as service_booking_counter'))->groupBy('bookings.service_id')->where('services.is_available', 1)->where('services.is_deleted', 2)->where('services.provider_id', Auth::user()->id)->orderByDesc('service_booking_counter')->get()->take(5);
            $total_bookings = Booking::where('provider_id', Auth::user()->id)->count();
            $total_services = Service::where('provider_id', Auth::user()->id)->where('is_deleted', 2)->count();
            $total_handymans = User::where('provider_id', Auth::user()->id)->where('type', 3)->count();
            $top_customers = User::join('bookings', 'bookings.user_id', '=', 'users.id')->select('users.id', 'users.name', 'users.mobile', 'users.email', 'users.image', DB::raw('count(bookings.user_id) as user_booking_counter'))->where('users.is_available', 1)->where('bookings.provider_id', Auth::user()->id)->where('users.type', 4)->orderByDesc('user_booking_counter')->groupBy('bookings.user_id')->get()->take(5);
        } else if (Auth::user()->type == 3) {
            $recent_bookings = Booking::where('handyman_id', Auth::user()->id)->orderByDesc('id')->get();
            $total_services = Booking::where('handyman_id', Auth::user()->id)->count();
            $total_handymans = Booking::where('handyman_id', Auth::user()->id)->where('status', 3)->count();
        }

        $providers = User::select('id', 'name')->where('type', 2)->where('is_available', 1)->orderByDesc('id')->get();
        $provider_id = "";
        if (Auth::user()->type == 2) {
            $provider_id = Auth::user()->id;
        } elseif (Auth::user()->type == 3) {
            $provider_id = Auth::user()->provider_id;
        }

        $services = Service::select('id', 'name')->where('provider_id', $provider_id)->where('is_available', 1)->where('is_deleted', 2)->orderByDesc('id')->get();
        if ($request->has('service') && $request->service != "") {
            $service_id = $request->service;
        } else {
            $service_id = 1;
            if (count($services) > 0) {
                $service_id = $services[0]->id;
            }
        }

        // Charts......
        $doughnutyear = $request->doughnutyear != "" ? $request->doughnutyear : date('Y');
        $booking_year = $request->booking_year != "" ? $request->booking_year : date('Y');

        // Users&Service wise booking-CHART-START
        if (Auth::user()->type == 1) {
            $doughnut_years = User::select(DB::raw("YEAR(created_at) as year"))->where('type', 2)->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->get();
            $vendorlist = User::select(DB::raw("YEAR(created_at) as year"), DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("COUNT(id) as total_user"))->whereYear('created_at', $doughnutyear)->where('type', 2)->orderBy('created_at')->groupBy(DB::raw("MONTHNAME(created_at)"))->pluck('total_user', 'month_name');
        } else {
            $doughnut_years = Booking::select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->get();
            $vendorlist = Booking::select(DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("YEAR(created_at) as years"), DB::raw("COUNT(id) as total_booking"))->whereYear('created_at', $booking_year)->where('service_id', $service_id)->orderBy('created_at')->groupBy(DB::raw("MONTHNAME(created_at)"))->pluck('total_booking', 'month_name');
        }

        $doughnutlabels = $vendorlist->keys();
        $doughnutdata = $vendorlist->values();
        // Users&Service wise booking-CHART-END

        // Booking-CHART-START
        $booking_years = Booking::select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->get();
        if (Auth::user()->type == 1) {
            if ($request->has('provider') && $request->provider != "") {
                $bookings = Booking::select(DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("YEAR(created_at) as years"), DB::raw("COUNT(id) as total_booking"))->whereYear('created_at', $booking_year)->where('provider_id', $request->provider)->orderBy('created_at')->groupBy(DB::raw("MONTHNAME(created_at)"))->pluck('total_booking', 'month_name');
            } else {
                $bookings = Booking::select(DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("YEAR(created_at) as years"), DB::raw("COUNT(id) as total_booking"))->whereYear('created_at', $booking_year)->orderBy('created_at')->groupBy(DB::raw("MONTHNAME(created_at)"))->pluck('total_booking', 'month_name');
            }
        } elseif (Auth::user()->type == 2) {
            $bookings = Booking::select(DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("YEAR(created_at) as years"), DB::raw("COUNT(id) as total_booking"))->whereYear('created_at', $booking_year)->where('provider_id', Auth::user()->id)->orderBy('created_at')->groupBy(DB::raw("MONTHNAME(created_at)"))->pluck('total_booking', 'month_name');
        } else {
            $bookings = Booking::select(DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("YEAR(created_at) as years"), DB::raw("COUNT(id) as total_booking"))->whereYear('created_at', $booking_year)->where('handyman_id', Auth::user()->id)->orderBy('created_at')->groupBy(DB::raw("MONTHNAME(created_at)"))->pluck('total_booking', 'month_name');
        }

        $bookinglabels = $bookings->keys();
        $bookingdata = $bookings->values();
        // Booking-CHART-END

        if (env('Environment') == 'sendbox') {
            $doughnutlabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
            $doughnutdata = [636, 1269, 2810, 2843, 3637, 467, 902, 1296, 402, 1173, 1509, 413];
            $bookinglabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
            $bookingdata = [636, 1269, 2810, 2843, 3637, 467, 902, 1296, 402, 1173, 1509, 413];
        }

        // Charts End......
        if ($request->ajax()) {
            return response()->json([
                'doughnut_years' => $doughnut_years,
                'doughnutlabels' => $doughnutlabels,
                'doughnutdata' => $doughnutdata,
                'booking_years' => $booking_years,
                'bookinglabels' => $bookinglabels,
                'bookingdata' => $bookingdata
            ], 200);
        } else {
            return view('admin.adashboard', compact(
                'total_categories',
                'total_services',
                'total_providers',
                'recent_providers',
                'recent_customers',
                'recent_bookings',
                'top_services',
                'total_bookings',
                'top_customers',
                'total_handymans',
                'providers',
                'services',
                'total_cities',
                'doughnut_years',
                'doughnutlabels',
                'doughnutdata',
                'booking_years',
                'bookinglabels',
                'bookingdata'
            ));
        }
    }
    public function subscribers()
    {
        $subscribers = Subscribe::orderByDesc('id')->get();
        return view('admin.subscribers', compact('subscribers'));
    }
    public function subscribe(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['sub_email' => 'required'],
            [
                'sub_email.required' => trans('messages.enter_email')
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $sub = new Subscribe();
            $sub->email = $request->sub_email;
            $sub->save();
            return redirect()->back()->with('success', trans('messages.success'));
        }
    }

    public function sessionsave(Request $request)
    {
        session()->put('demo', $request->demo_type);

        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
