<?php

namespace App\Http\Controllers\User;

use App\Helpers\helper;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\ProviderType;
use App\Models\User;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\Timing;
use App\Models\Transaction;
use App\Models\SystemAddons;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use Mews\Purifier\Facades\Purifier;
use Str;

class UserController extends Controller
{
    public function register_user()
    {
        if (@helper::checkaddons('customer_login')) {
            if (@helper::appdata()->login_required == 1) {
                return view('front.user_form');
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }
    public function store_user(Request $request)
    {
        if (
            SystemAddons::where('unique_identifier', 'recaptcha')->first() != null &&
            SystemAddons::where('unique_identifier', 'recaptcha')->first()->activated == 1
        ) {

            if (Helper::appdata('')->recaptcha_version == 'v2') {
                $request->validate([
                    'g-recaptcha-response' => 'required'
                ], [
                    'g-recaptcha-response.required' => 'The g-recaptcha-response field is required.'
                ]);
            }

            if (Helper::appdata('')->recaptcha_version == 'v3') {
                $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'contact');
                if ($score <= Helper::appdata('')->score_threshold) {
                    return redirect()->back()->with('error', 'You are most likely a bot');
                }
            }
        }
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email',
            'mobile' => 'unique:users,mobile',
        ],  [
            'email.unique' => trans('messages.email_exist'),
            'mobile.unique' => trans('messages.mobile_exist'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if (Session::has('google_id') || Session::has('facebook_id')) {
                $password = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'), 0, 6);
            } else {
                $password = $request->password;
            }
            try {
                if (Session::get('google_id')) {
                    $login_type = "google";
                } elseif (Session::get('facebook_id')) {
                    $login_type = "facebook";
                } else {
                    $login_type = "email";
                }
                $referral_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);

                $file = $request->file("image");

                $filename = 'profile-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/profile/', $filename);

                $address = strip_tags(Purifier::clean($request->address));
                $user = new User();
                $user->name = $request->name;
                $user->slug = Str::slug($request->name, '-');
                $user->email = $request->email;
                $user->password = Hash::make($password);
                $user->mobile = $request->mobile;
                $user->image = $filename;
                $user->address = $address;
                $user->referral_code = $referral_code;
                $user->type = 4;
                $user->login_type = $login_type;
                if (Session::get('google_id')) {
                    $user->google_id = Session::get('google_id');
                }
                if (Session::get('facebook_id')) {
                    $user->facebook_id = Session::get('facebook_id');
                }
                $user->is_verified = 1;
                $user->is_available = 1;

                if ($user->save()) {
                    if (Session::get('google_id')) {
                        Session::forget('google_id');
                        Session::forget('default_email');
                        Session::forget('default_name');
                    }
                    if (Session::get('facebook_id')) {
                        Session::forget('facebook_id');
                        Session::forget('default_email');
                        Session::forget('default_name');
                    }
                    if ($request->referral_code != "") {
                        $appdata = Setting::first();
                        $checkreferral = User::select('id', 'name', 'email', 'referral_code', 'wallet')->where('referral_code', $request->referral_code)->where('is_available', 1)->first();
                        if ($checkreferral) {
                            $refwallet = $checkreferral->wallet + $appdata->referral_amount;
                            $updatewallet = User::where('id', $checkreferral->id)->update(['wallet' => $refwallet]);
                            $transaction = new Transaction();
                            $transaction->user_id = $checkreferral->id;
                            $transaction->amount = $appdata->referral_amount;
                            $transaction->payment_type = 7;
                            $transaction->username = $request->name;
                            $transaction->save();

                            $updatewallet = User::where('id', $user->id)->update(['wallet' => $appdata->referral_amount]);
                            $transaction = new Transaction();
                            $transaction->user_id = $user->id;
                            $transaction->amount = $appdata->referral_amount;
                            $transaction->payment_type = 7;
                            $transaction->username = $checkreferral->name;
                            $transaction->save();

                            $var = ["{referral_user}", "{new_user}", "{company_name}", "{referral_amount}"];
                            $newvar = [$checkreferral->name, $user->name, helper::appdata()->website_title, helper::currency_format(helper::appdata()->referral_amount)];
                            $referralmessage = str_replace($var, $newvar, nl2br(helper::appdata()->referral_earning_email_message));
                            helper::referral($checkreferral->email, $referralmessage);
                        } else {
                            return redirect()->back()->with('error', trans('messages.invalid_referral'));
                        }
                    }
                    return redirect(route('login'))->with('success', trans('messages.success'));
                } else {
                    return redirect()->back()->with('error', trans('messages.wrong'));
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', trans('messages.wrong'));
            }
        }
    }
    public function editprofile(Request $request, $id)
    {
        if ($request->file('image') != "") {
            $file = $request->file("image");
            if (Auth::user()->type == 2) {

                if (file_exists(storage_path("app/public/provider/" . Auth::user()->image))) {
                    unlink(storage_path("app/public/provider/" . Auth::user()->image));
                }

                $filename = 'provider-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/provider/', $filename);
            } else {

                if (file_exists(storage_path("app/public/profile/" . Auth::user()->image))) {
                    unlink(storage_path("app/public/profile/" . Auth::user()->image));
                }

                $filename = 'profile-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/profile/', $filename);
            }
            User::where('id', $id)->update(['image' => $filename]);
        }
        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile
        ]);
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function editPassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'different:old_password',
            'c_new_password' => 'same:new_password'
        ], [
            'new_password.different' => trans('messages.new_password_different'),
            'c_new_password.same' => trans('messages.confirm_password_same')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $user_old_data = User::find($id);
            if (Hash::check($request->old_password, $user_old_data->password)) {
                User::where('id', $id)->update(['password' => Hash::make($request->new_password)]);
                return redirect()->back()->with("success", trans('messages.success'));
            } else {
                return redirect()->back()->with("error", trans('messages.old_pass_invalid'));
            }
        }
    }
    public function forgot_pass()
    {
        if (@helper::checkaddons('customer_login')) {
            if (@helper::appdata()->login_required == 1) {
                if (isset($_COOKIE['city_id'])) {
                    return view('front.forgot_pass');
                }
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }
    public function send_pass(Request $request)
    {
        $check = User::where('email', $request->email)
            ->where(function ($query) {
                $query->where('type', 2)
                    ->orWhere('type', 4);
            })
            ->where('is_available', 1)
            ->first();
        if (!empty($check)) {
            if ($check->is_available == 1) {
                $new_password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
                $helper = Helper::forgotpassword($request->email, $check->name, $new_password);
                if ($helper == 1) {
                    User::where('email', $request->email)->update(['password' => Hash::make($new_password)]);
                    return redirect(route('login'))->with('success', trans('messages.password_sent'));
                } else {
                    return redirect()->back()->with('error', trans('messages.wrong_while_email'));
                }
            } else {
                return redirect()->back()->with('error', trans('messages.blocked'));
            }
        } else {
            return redirect()->back()->with('error', trans('messages.invalid_email'));
        }
    }
    public function clearnotification(Request $request)
    {
        $update = Notification::where('user_id', $request->user_id)->update(["is_read" => 1]);
        return json_encode($update);
    }
    public function noti(Request $request)
    {
        $notificationdata = Notification::select('notification.id', 'notification.title', 'notification.message', 'notification.booking_id', 'notification.booking_status', 'notification.canceled_by', 'notification.is_read', DB::raw('DATE(notification.created_at) AS date'))
            ->where('notification.user_id', Auth::user()->id)
            ->orderByDesc('notification.id')
            ->paginate(20);
        return view('provider.notification', compact('notificationdata'));
    }

    public function users(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            if ($query != "") {
                $usersdata = User::select('name', 'email', 'mobile', 'image')
                    ->where('name', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%')
                    ->orWhere('mobile', 'like', '%' . $query . '%')
                    ->where('type', 4)
                    ->where('is_available', 1)
                    ->orderByDesc('id')
                    ->get();
            } else {
                $usersdata = User::where('type', 4)->orderByDesc('id')->get();
            }
            return view('users.users_table', compact('usersdata'))->render();
        } else {
            $usersdata = User::where('type', 4)->orderByDesc('id')->get();
            return view('users.index', compact('usersdata'));
        }
    }

    public function usersstatus(Request $request)
    {
        $success = User::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
}
