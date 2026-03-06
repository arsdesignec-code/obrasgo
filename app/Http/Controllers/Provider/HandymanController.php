<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Purifier;
use Str;

class HandymanController extends Controller
{
    public function index()
    {
        if (Auth::user()->type == 1) {
            $handymandata = User::where('type', 3)->orderByDesc('id')->get();
        } elseif (Auth::user()->type == 2) {

            $handymandata = User::where('provider_id', Auth::user()->id)->where('type', 3)->orderBy('id', 'DESC')->get();
        }
        return view('provider.handyman.index', compact('handymandata'));
    }
    public function add()
    {
        $citydata = City::where('is_available', 1)->where('is_deleted', 2)->orderBy('id', 'DESC')->get();

        return view('provider.handyman.add', compact('citydata'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users',
        ],  [
            'email.unique' => trans('messages.email_exist'),
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $file = $request->file("image");
            $filename = 'handyman-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/handyman/', $filename);

            $checkslug = User::where('slug', Str::slug($request->name, '-'))->first();
            if ($checkslug != "") {
                $last = User::select('id')->orderByDesc('id')->first();
                $create = $request->name . " " . ($last->id + 1);
                $slug =   Str::slug($create, '-');
            } else {
                $slug = Str::slug($request->name, '-');
            }
            $address = strip_tags(Purifier::clean($request->address));
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->image = $filename;
            $user->password = Hash::make($request->password);
            $user->type = 3;
            $user->provider_id = Auth::user()->id;
            $user->address = $address;
            $user->city_id = $request->city_id;
            $user->login_type = "email";
            $user->is_verified = 1;
            $user->is_available = 1;
            $user->slug = $slug;
            $user->save();

            return redirect(route('handymans'))->with('success', trans('messages.handyman_added'));
        }
    }
    public function status(Request $request)
    {
        $success = User::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function show($handyman)
    {
        $handymandata = User::where('slug', $handyman)->first();

        $citydata = City::where('id', '!=', $handymandata['city']->id)->where('is_available', 1)->where('is_deleted', 2)->orderBy('id', 'DESC')->get();

        return view('provider.handyman.show', compact('handymandata', 'citydata'));
    }
    public function edit(Request $request, $handyman)
    {
        $hdata = User::where('slug', $handyman)->first();
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email,' . $hdata->id,
        ], [
            'email.unique' => trans('messages.email_exist'),
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if ($request->file("image") != "") {
                if (file_exists(storage_path() . '/app/public/handyman/' . $hdata->image) && $hdata->image != "default.png") {
                    unlink(storage_path() . '/app/public/handyman/' . $hdata->image);
                }

                $file = $request->file("image");
                $filename = 'handyman-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/handyman/', $filename);

                User::where('id', $hdata->id)->update(['image' => $filename]);
            }
            if ($request->is_available) {
                $status = 1;
            } else {
                $status = 2;
            }
            $checkslug = User::where('slug', Str::slug($request->name, '-'))->first();
            if ($checkslug != "") {
                $last = User::select('id')->orderByDesc('id')->first();
                $create = $request->name . " " . ($last->id + 1);
                $slug =   Str::slug($create, '-');
            } else {
                $slug = Str::slug($request->name, '-');
            }
            $address = strip_tags(Purifier::clean($request->address));
            User::where('id', $hdata->id)->update([
                'name' =>  $request->name,
                'email' =>  $request->email,
                'mobile' =>  $request->mobile,
                'address' =>  $address,
                'city_id' =>  $request->city_id,
                'is_available' =>  $status,
                'slug' =>  $slug,
            ]);

            return redirect(route('handymans'))->with('success', trans('messages.handyman_updated'));
        }
    }
    public function showhandyman(Request $request, $handyman)
    {
        $handymandata = User::where('slug', $handyman)->first();
        $total_bookings = Booking::where('handyman_id', $handymandata->id)->count();
        $total_completed = Booking::where('handyman_id', $handymandata->id)->where('status', 3)->count();
        $total_pending = Booking::where('handyman_id', $handymandata->id)->where('status', 2)->count();

        // bookings-chart-start 
        $years = Booking::select(DB::raw("YEAR(created_at) as year"))->orderByDesc('created_at')->where('handyman_id', $handymandata->id)->groupBy(DB::raw("YEAR(created_at)"))->get();

        $booking_year = $request->booking_year != "" ? $request->booking_year : date('Y');

        $bookings = Booking::select(DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("YEAR(created_at) as years"), DB::raw("COUNT(id) total"))
            ->whereYear('created_at', $booking_year)
            ->where('handyman_accept', 1)
            ->where('status', 3)
            ->where('handyman_id', $handymandata->id)
            ->orderBy('created_at')
            ->groupBy(DB::raw("YEAR(created_at)"), DB::raw("MONTHNAME(created_at)"))
            ->pluck('total', 'month_name');

        $bookings_countlabels = $bookings->keys();
        $bookings_countdata = $bookings->values();
        // bookings-chart-end

        if ($request->ajax()) {
            return response()->json([
                'bookings_countlabels' => $bookings_countlabels,
                'bookings_countdata' => $bookings_countdata
            ], 200);
        } else {
            return view('provider.handyman.showhandyman', compact('handymandata', 'total_bookings', 'total_completed', 'total_pending', 'years', 'bookings_countlabels', 'bookings_countdata'));
        }
    }

    public function fetch_handyman(Request $request)
    {
        if ($request->ajax()) {
            $query1 = $request->get('query');
            $query = User::query();

            $query = $query->join('users as provider', 'provider.id', 'users.provider_id')->select('users.*', 'provider.name as provider_name')->where('users.type', 3);

            if ($query1 != '') {
                if (Auth::user()->type == 2) {
                    $query = $query->where('users.provider_id', Auth::user()->id);
                } elseif ($request->get('provider') != "") {
                    $query = $query->where('users.provider_id', $request->get('provider'));
                }
                $query = $query->where('users.is_available', 1)
                    ->where(function ($queryy) use ($query1) {
                        $queryy->where('users.name', 'like', '%' . $query1 . '%')
                            ->orWhere('users.email', 'like', '%' . $query1 . '%')
                            ->orWhere('users.mobile', 'like', '%' . $query1 . '%')
                            ->orWhere('provider.name', 'like', '%' . $query1 . '%');
                    });
            } else {
                if (Auth::user()->type == 2) {
                    $query = $query->where('users.provider_id', Auth::user()->id);
                } elseif ($request->get('provider') != "") {
                    $query = $query->where('users.provider_id', $request->get('provider'));
                }
            }
            $handymandata = $query->paginate(10);
            return view('provider.handyman.handyman_table', compact('handymandata'))->render();
        }
    }
}
