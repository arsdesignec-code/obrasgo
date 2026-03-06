<?php

namespace App\Http\Controllers\Provider;

use App\Helpers\helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProviderType;
use App\Models\City;
use App\Models\Timing;
use App\Models\Service;
use App\Models\User;
use App\Models\Rattings;
use App\Models\Bank;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;
use Str;

class ProviderController extends Controller
{
    public function providers(Request $request)
    {
        $providerdata = User::with('city')->where('type', 2)->where('is_deleted', 2)->orderByDesc('id')->get();
        return view('provider.index', compact('providerdata'));
    }
    public function addprovider()
    {

        $providertypedata = ProviderType::where('is_available', 1)->where('is_deleted', 2)->orderBy('reorder_id')->get();

        $citydata = City::where('is_available', 1)->where('is_deleted', 2)->orderBy('reorder_id')->get();

        return view('provider.add', compact('providertypedata', 'citydata'));
    }
    public function storeprovider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email,NULL,id,is_deleted,2',
            'mobile' => 'unique:users,mobile,NULL,id,is_deleted,2',
        ], [
            'email.unique' => trans('messages.email_exist'),
            'mobile.unique' => trans('messages.mobile_exist'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $file = $request->file("image");
            $filename = 'provider-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/provider/', $filename);

            $checkslug = User::where('slug', Str::slug($request->name, '-'))->first();
            if ($checkslug != "") {
                $last = User::select('id')->orderByDesc('id')->first();
                $create = $request->name . " " . ($last->id + 1);
                $slug =   Str::slug($create, '-');
            } else {
                $slug = Str::slug($request->name, '-');
            }
            $address = strip_tags(Purifier::clean($request->address));
            $about = strip_tags(Purifier::clean($request->about));
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->image = $filename;
            $user->password = Hash::make($request->password);
            $user->type = 2;
            $user->provider_type = $request->provider_type;
            $user->address = $address;
            $user->city_id = $request->city_id;
            $user->about = $about;
            $user->login_type = "email";
            $user->is_verified = 1;
            $user->is_available = 1;
            $user->slug = $slug;
            $user->save();

            $day = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
            $open_time = array('9:00am', '9:00am', '9:00am', '9:00am', '9:00am', '9:00am', '9:00am');
            $close_time = array('6:00pm', '6:00pm', '6:00pm', '6:00pm', '6:00pm', '6:00pm', '6:00pm');

            foreach ($day as $key => $no) {
                $time = new Timing();
                $time->provider_id = $user->id;
                $time->day = $no;
                $time->open_time = $open_time[$key];
                $time->close_time = $close_time[$key];
                $time->is_always_close = 2;
                $time->save();
            }
            return redirect(route('providers'))->with('success', trans('messages.provider_added'));
        }
    }
    public function showprovider($provider)
    {

        $providerdata = User::where('slug', $provider)->first();

        $providertypedata = ProviderType::where([['id', '!=', $providerdata['providertype']->id], ['is_deleted', 2]])->get();

        $citydata = City::where([['id', '!=', $providerdata['city']->id], ['is_deleted', 2]])->get();

        return view('provider.show', compact('providerdata', 'providertypedata', 'citydata'));
    }
    public function editprovider(Request $request, $provider)
    {
        $pdata = User::where('slug', $provider)->first();

        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email,' . $pdata->id,
            'mobile' => 'unique:users,mobile,' . $pdata->id,
        ], [
            'email.unique' => trans('messages.email_exist'),
            'mobile.unique' => trans('messages.mobile_exist'),
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if ($request->file("image") != "") {
                $rec = User::where('slug', $provider)->first();
                if (file_exists(storage_path() . '/app/public/provider/' . $rec->image)) {
                    unlink(storage_path() . '/app/public/provider/' . $rec->image);
                }
                $file = $request->file('image');
                $filename = 'provider-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/provider/', $filename);

                User::where('id', $pdata->id)->update(['image' => $filename]);
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
            $about = strip_tags(Purifier::clean($request->about));

            User::where('id', $pdata->id)->update([
                'name' =>  $request->name,
                'email' =>  $request->email,
                'mobile' =>  $request->mobile,
                'provider_type' =>  $request->provider_type,
                'address' =>  $address,
                'city_id' =>  $request->city_id,
                'about' => $about,
                'slug' =>  $slug,
                'is_available' =>  $status,
            ]);
            return redirect(route('providers'))->with('success', trans('messages.provider_updated'));
        }
    }
    public function providerstatus(Request $request)
    {
        $success = User::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function provider($provider, Request $request)
    {
        $providerdata = User::where('slug', $provider)->first();
        $handymandata = User::where('provider_id', $providerdata->id)->where('is_available', 1)->where('type', 3)->orderByDesc('id')->paginate(10);
        $servicedata = Service::where('provider_id', $providerdata->id)->where('is_deleted', 2)->orderBy('id', 'DESC')->paginate(10);
        $total_earning = DB::table('bookings')->where('provider_id', $providerdata->id)->where('status', 3)->sum('total_amt');
        $rattingsdata = Rattings::leftJoin('users', 'rattings.user_id', '=', 'users.id')
            ->select(
                'rattings.id',
                'rattings.ratting',
                'rattings.comment',
                'rattings.created_at',
                'rattings.updated_at',
                'users.id as user_id',
                'users.name as user_name',
                'users.image as user_image',
            )
            ->where('rattings.provider_id', $providerdata->id)
            ->orderByDesc('id')
            ->paginate(10);

        // bookings-chart-start 
        $years = Booking::select(DB::raw("YEAR(created_at) as year"))->orderByDesc('created_at')->where('provider_id', $providerdata->id)->groupBy(DB::raw("YEAR(created_at)"))->get();

        $booking_year = $request->year != "" ? $request->year : date('Y');

        $bookings = Booking::select(DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("YEAR(created_at) as years"), DB::raw("SUM(total_amt) total"))->whereYear('created_at', $booking_year)->where('provider_id', $providerdata->id)->orderBy('created_at')->groupBy(DB::raw("YEAR(created_at)"), DB::raw("MONTHNAME(created_at)"))->where('status', 3)->pluck('total', 'month_name');

        $earninglabels = $bookings->keys();
        $earningdata = $bookings->values();
        // bookings-chart-end

        if ($request->ajax()) {
            return response()->json([
                'earninglabels' => $earninglabels,
                'earningdata' => $earningdata
            ], 200);
        } else {
            return view('provider.showprovider', compact('providerdata', 'handymandata', 'servicedata', 'rattingsdata', 'years', 'total_earning', 'earninglabels', 'earningdata'));
        }
    }
    public function settings()
    {
        $providerdata = User::where('id', Auth::user()->id)->first();
        $bankdata = Bank::where('provider_id', Auth::user()->id)->first();
        return view('provider.settings', compact('providerdata', 'bankdata'));
    }
    public function profile_settings_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'unique:users,mobile,' . Auth::user()->id,
        ], [
            'mobile.unique' => trans('messages.mobile_exist'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if ($request->profile_data_update == 1) {
                if ($request->file("image") != "") {
                    $rec = User::where('id', Auth::user()->id)->first();
                    if (file_exists(storage_path() . '/app/public/provider/' . $rec->image)) {
                        unlink(storage_path() . '/app/public/provider/' . $rec->image);
                    }
                    $file = $request->file('image');
                    $filename = 'provider-' . time() . "." . $file->getClientOriginalExtension();
                    $file->move(storage_path() . '/app/public/provider/', $filename);

                    User::where('id', Auth::user()->id)->update(['image' => $filename]);
                }

                if ($request->file("notification_sound") != "") {
                    $rec = User::where('id', Auth::user()->id)->first();
                    if ($rec->notification_sound != "" && file_exists(storage_path() . '/app/public/notification/' . $rec->notification_sound)) {
                        unlink(storage_path() . '/app/public/notification/' . $rec->notification_sound);
                    }
                    $file = $request->file('notification_sound');
                    $notification_sound = 'notification-' . time() . "." . $file->getClientOriginalExtension();
                    $file->move(storage_path() . '/app/public/notification/', $notification_sound);

                    User::where('id', Auth::user()->id)->update(['notification_sound' => $notification_sound]);
                }

                $checkslug = User::where('slug', Str::slug($request->name, '-'))->first();
                if ($checkslug != Str::slug($request->name, '-')) {
                    $last = User::select('id')->orderByDesc('id')->first();
                    $create = $request->name . " " . ($last->id + 1);
                    $slug =   Str::slug($create, '-');
                }
                User::where('id', Auth::user()->id)->update([
                    'name' =>  $request->name,
                    'email' =>  $request->email,
                    'mobile' =>  $request->mobile,
                    'slug' =>  $slug
                ]);
            }
            if ($request->bank_info_update == 1) {
                $bank = Bank::where('provider_id', Auth::user()->id)->first();
                if (empty($bank)) {
                    $bank = new Bank();
                }
                $bank->provider_id = Auth::user()->id;
                $bank->bank_name = $request->bank_name;
                $bank->account_holder = $request->account_holder;
                $bank->account_type = $request->account_type;
                $bank->account_number = $request->account_number;
                $bank->routing_number = $request->routing_number;
                $bank->save();
            }
            return redirect()->back()->with('success', trans('messages.success'));
        }
    }
    public function add_bank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_number' => 'unique:bank',
            'routing_number' => 'unique:bank'
        ], [
            'account_number.unique' => trans('messages.account_number_exist'),
            'routing_number.unique' => trans('messages.routing_number_exist')
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $bank = new Bank();
            $bank->provider_id = Auth::user()->id;
            $bank->bank_name = $request->bank_name;
            $bank->account_holder = $request->account_holder;
            $bank->account_type = $request->account_type;
            $bank->account_number = $request->account_number;
            $bank->routing_number = $request->routing_number;
            $bank->save();
            return redirect()->back()->with('success', trans('messages.success'));
        }
    }

    public function deleteaccount(Request $request)
    {
        $user  = User::where('id', $request->id)->first();
        $user->is_available = 2;
        $user->is_deleted = 1;
        $user->update();
        helper::send_mail_delete_account($user);
        if (Auth::user()->id != 1) {
            Auth::logout();
            session()->flush();
            return redirect()->route('adminlogin')->with('message', trans('messages.success'));
        } else {
            return redirect()->back()->with('success', trans('messages.success'));
        }
    }
    public function bulkdeleteaccount(Request $request)
    {
        
        foreach ($request->id as $id) {
            $user  = User::where('id', $id)->first();
            $user->is_available = 2;
            $user->is_deleted = 1;
            $user->update();
            helper::send_mail_delete_account($user);
        }
        if (Auth::user()->id != 1) {
            Auth::logout();
            session()->flush();
            return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } else {
            return response()->json(['status' => 1, 'msg' => trans('messages.wrong')], 200);
        }
    }
}
