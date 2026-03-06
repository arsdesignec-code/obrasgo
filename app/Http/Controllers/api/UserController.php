<?php

namespace App\Http\Controllers\api;

use App\Helpers\helper;
use App\Http\Controllers\Controller;
use App\Models\Rattings;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Str;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $checkemail = User::where('email', $request->email)->first();
        $checkmobile = User::where('mobile', $request->mobile)->first();

        $otp = rand(100000, 999999);

        if ($request->register_type == "email") {

            $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
            $referral_code = substr(str_shuffle($str_result), 0, 10);

            if ($request->name == "") {
                return response()->json(['status' => 0, 'message' => trans('messages.enter_full_name')], 200);
            }
            if ($request->email == "") {
                return response()->json(['status' => 0, 'message' => trans('messages.enter_email')], 200);
            }
            if ($request->token == "") {
                return response()->json(['status' => 0, 'message' => trans('messages.enter_token')], 200);
            }
            if ($request->google_id || $request->facebook_id) {

                $password = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'), 0, 6);
            } else {

                if ($request->password == "") {
                    return response()->json(['status' => 0, 'message' => trans('messages.enter_password')], 200);
                }

                $password = $request->password;
            }

            try {

                $helper = Helper::verificationemail($request->email, $otp);

                if ($helper == 1) {

                    if ($request->google_id) {
                        $login_type = "google";
                    } elseif ($request->facebook_id) {
                        $login_type = "facebook";
                    } else {

                        if (!empty($checkemail)) {
                            return response()->json(['status' => 0, 'message' => trans('messages.email_exist')], 200);
                        }
                        if (!empty($checkmobile)) {
                            return response()->json(['status' => 0, 'message' => trans('messages.mobile_exist')], 200);
                        }
                        $login_type = "email";
                    }

                    $checkslug = User::where('slug', Str::slug($request->name, '-'))->first();
                    if ($checkslug != "") {
                        $last = User::select('id')->orderByDesc('id')->first();
                        $create = $request->name . " " . ($last->id + 1);
                        $slug =   Str::slug($create, '-');
                    } else {
                        $slug = Str::slug($request->name, '-');
                    }

                    $user = new User();
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->mobile = $request->mobile;
                    $user->referral_code = $referral_code;
                    $user->password = HASH::make($password);
                    $user->image = "default.png";
                    $user->type = 4;
                    $user->login_type = $login_type;
                    if ($request->google_id) {
                        $user->google_id = $request->google_id;
                    }
                    if ($request->facebook_id) {
                        $user->facebook_id = $request->facebook_id;
                    }
                    $user->otp = $otp;
                    $user->token = $request->token;
                    $user->is_verified = 1;
                    $user->is_available = 1;
                    $user->slug = $slug;

                    if ($request->referral_code != "") {

                        $appdata = Setting::first();

                        $checkreferral = User::select('id', 'name', 'referral_code', 'wallet')->where('referral_code', $request->referral_code)->where('is_available', 1)->first();

                        if ($checkreferral) {

                            $refwallet = $checkreferral->wallet + $appdata->referral_amount;
                            $updatewallet = User::where('id', $checkreferral->id)->update(['wallet' => $refwallet]);
                            $transaction = new Transaction();
                            $transaction->user_id = $checkreferral->id;
                            $transaction->amount = $appdata->referral_amount;
                            $transaction->payment_type = 7;
                            $transaction->username = $request->name;
                            $transaction->save();

                            $new_transaction = new Transaction();
                            $new_transaction->user_id = 0;
                            $new_transaction->amount = $appdata->referral_amount;
                            $new_transaction->payment_type = 7;
                            $new_transaction->username = $checkreferral->name;
                            $new_transaction->save();
                        } else {

                            return response()->json(['status' => 0, 'message' => trans('messages.invalid_referral')], 200);
                        }
                    }

                    if ($user->save()) {
                        if ($request->referral_code != "" && !empty($checkreferral)) {
                            $updatewallet = User::where('id', $user->id)->update(['wallet' => $appdata->referral_amount]);
                            $t = Transaction::find($new_transaction->id);
                            $t->user_id = $user->id;
                            $t->save();
                        }
                        return response()->json(["status" => 1, "message" => trans('messages.verification_code_sent')], 200);
                    } else {
                        return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
                    }

                    return response()->json(["status" => 1, "message" => trans('messages.verification_code_sent')], 200);
                } else {
                    return response()->json(['status' => 0, 'message' => trans('messages.wrong_while_email')], 200);
                }
            } catch (\Swift_TransportException $e) {
                $response = $e->getMessage();
                return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
            }
        }

        if ($request->login_type == "google") {

            $usergoogle = User::where('google_id', $request->google_id)->first();
            if ($usergoogle != "" or @$usergoogle->email == $request->email and $request->email != "") {
                if ($usergoogle->mobile == "") {
                    $data = array(
                        'id' => $usergoogle->id
                    );
                    return response()->json(['status' => 2, 'message' => trans('messages.mobile_required'), 'data' => $data], 200);
                } else {
                    if ($usergoogle->is_verified == '1') {
                        if ($usergoogle->is_available == '1') {
                            $data = array(
                                'id' => $usergoogle->id,
                                'name' => $usergoogle->name,
                                'mobile' => $usergoogle->mobile,
                                'email' => $usergoogle->email,
                                'login_type' => $usergoogle->login_type,
                                'referral_code' => $usergoogle->referral_code,
                                'image_url' => asset('storage/app/public/profile/' . $usergoogle->image),
                            );

                            $update = User::where('email', $usergoogle['email'])->update(['token' => $request->token]);
                            return response()->json(['status' => 1, 'message' => 'Login Successful', 'data' => $data], 200);
                        } else {
                            return response()->json(['status' => 0, 'message' => trans('messages.blocked')], 200);
                        }
                    } else {

                        Helper::verificationemail($usergoogle->email, $otp);

                        $otp_data['otp'] = $otp;
                        $update = User::where('email', $usergoogle->email)->update($otp_data);

                        return response()->json(['status' => 3, 'message' => trans('messages.verify_email')], 422);
                    }
                }
            } else {

                if (!empty($checkemail)) {
                    return response()->json(['status' => 0, 'message' => trans('messages.email_exist')], 400);
                }

                return response()->json(['status' => 2, 'message' => 'Successful'], 200);
            }
        } elseif ($request->login_type == "facebook") {
            $userfacebook = User::where('google_id', $request->google_id)->first();
            if ($userfacebook != "" or @$userfacebook->email == $request->email and $request->email != "") {
                if ($userfacebook->mobile == "") {
                    $data = array(
                        'id' => $userfacebook->id
                    );
                    return response()->json(['status' => 2, 'message' => trans('messages.mobile_required'), 'data' => $data], 200);
                } else {
                    if ($userfacebook->is_verified == '1') {
                        if ($userfacebook->is_available == '1') {
                            $data = array(
                                'id' => $userfacebook->id,
                                'name' => $userfacebook->name,
                                'mobile' => $userfacebook->mobile,
                                'email' => $userfacebook->email,
                                'login_type' => $userfacebook->login_type,
                                'referral_code' => $userfacebook->referral_code,
                                'image_url' => asset('storage/app/public/profile/' . $userfacebook->image),
                            );

                            $update = User::where('email', $userfacebook['email'])->update(['token' => $request->token]);
                            return response()->json(['status' => 1, 'message' => 'Login Successful', 'data' => $data], 200);
                        } else {
                            return response()->json(['status' => 0, 'message' => trans('messages.blocked')], 200);
                        }
                    } else {

                        Helper::verificationemail($userfacebook->email, $otp);

                        $otp_data['otp'] = $otp;
                        $update = User::where('email', $userfacebook->email)->update($otp_data);

                        return response()->json(['status' => 3, 'message' => trans('messages.verify_email')], 422);
                    }
                }
            } else {

                if (!empty($checkemail)) {
                    return response()->json(['status' => 0, 'message' => trans('messages.email_exist')], 400);
                }

                return response()->json(['status' => 2, 'message' => 'Successful'], 200);
            }
        }
    }
    public function verifyotp(Request $request)
    {
        if ($request->email == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_email')], 200);
        }
        if ($request->otp == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_otp')], 200);
        }

        $checkuser = User::where('email', $request->email)->first();

        if (!empty($checkuser)) {

            if ($checkuser->otp == $request->otp) {

                User::where('email', $request['email'])->update(['otp' => null, 'is_verified' => '1']);

                $data = array(
                    'id' => $checkuser->id,
                    'name' => $checkuser->name,
                    'mobile' => $checkuser->mobile,
                    'email' => $checkuser->email,
                    'login_type' => $checkuser->login_type,
                    'referral_code' => $checkuser->referral_code,
                    'image_url' => asset('storage/app/public/profile/' . $checkuser->image),
                );
                return response()->json(['status' => 1, 'message' => trans('messages.verification_successful'), 'data' => $data], 200);
            } else {
                return response()->json(["status" => 0, "message" => trans('messages.invalid_otp')], 200);
            }
        } else {
            return response()->json(["status" => 0, "message" => trans('messages.invalid_email')], 200);
        }
    }
    public function resendotp(Request $request)
    {
        if ($request->email == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_email')], 200);
        }

        $checkuser = User::where('email', $request->email)->where('is_verified', 2)->first();

        if (!empty($checkuser)) {
            try {
                $otp = rand(100000, 999999);

                User::where('email', $request->email)->update(['otp' => $otp]);

                $helper = Helper::resendotp($request->email, $otp);

                if ($helper == 1) {
                    return response()->json(["status" => 1, "message" => trans('messages.otp_sent')], 200);
                } else {
                    return response()->json(['status' => 0, 'message' => trans('messages.wrong_while_email')], 200);
                }
            } catch (\Swift_TransportException $e) {
                $error = $e->getMessage();
                return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
            }
        } else {
            return response()->json(["status" => 0, "message" => trans('messages.invalid_email')], 200);
        }
    }
    public function login(Request $request)
    {
        if ($request->email == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_email')], 200);
        }
        if ($request->password == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_password')], 200);
        }
        if ($request->token == "") {
            return response()->json(['status' => 0, 'message' => trans('messages.enter_token')], 200);
        }

        $u = User::where('email', $request->email)->where('type', '=', 4)->first();

        if (!empty($u)) {
            if ($u->is_available == 1) {
                if ($u->is_verified == 1) {
                    if (Hash::check($request->password, $u->password)) {
                        $update = User::where('email', $request->email)->update(['token' => $request->token]);
                        $data = User::leftJoin('cities', 'cities.id', 'users.city_id')
                            ->select('cities.name as city_name', 'users.*')
                            ->where('users.email', $request->email)->first();

                        $userdata = array(
                            'id' => $data->id,
                            'name' => $data->name,
                            'mobile' => $data->mobile,
                            'email' => $data->email,
                            'login_type' => $data->login_type,
                            'about' => strip_tags($data->about),
                            'city_name' => $data->city_name,
                            'wallet' => $data->wallet,
                            'user_type' => $data->type,
                            'referral_code' => $data->referral_code,
                            'image_url' => asset('storage/app/public/profile/' . $data->image)
                        );

                        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'userdata' => $userdata], 200);
                    } else {
                        return response()->json(['status' => 0, 'message' => trans('messages.email_pass_invalid')], 200);
                    }
                } else {

                    $otp = rand(100000, 999999);

                    $helper = Helper::verificationemail($request->email, $otp);

                    if ($helper == 1) {

                        User::where('email', $request->email)->update(['otp' => $otp]);

                        return response()->json(['status' => 2, 'message' => trans('messages.verify_email')], 200);
                    } else {
                        return response()->json(['status' => 0, 'message' => trans('messages.wrong_while_email')], 200);
                    }
                }
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.blocked')], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.email_pass_invalid')], 200);
        }
    }
    public function forgotpassword(Request $request)
    {
        if ($request->email == "") {
            return response()->json(["status" => 0, "message" => "Please enter email"], 200);
        }

        $checklogin = User::where('email', $request->email)->where('is_available', 1)->first();

        if (!empty($checklogin)) {

            try {
                $new_password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);

                User::where('email', $request->email)->update(['password' => Hash::make($new_password)]);

                $helper = Helper::forgotpassword($request->email, $checklogin->name, $new_password);

                if ($helper == 1) {
                    return response()->json(['status' => 1, 'message' => trans('messages.password_sent')], 200);
                } else {
                    return response()->json(['status' => 0, 'message' => trans('messages.wrong_while_email')], 200);
                }
            } catch (\Swift_TransportException $e) {
                $response = $e->getMessage();
                return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.invalid_email')], 200);
        }
    }

    public function changepassword(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
        }
        if ($request->old_password == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_old_password')], 200);
        }
        if ($request->new_password == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_new_password')], 200);
        }
        if ($request->confirm_new_password == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_confirm_password')], 200);
        }
        if ($request->old_password == $request->new_password) {
            return response()->json(["status" => 0, "message" => trans('messages.new_password_different')], 200);
        }
        if ($request->new_password != $request->confirm_new_password) {
            return response()->json(["status" => 0, "message" => trans('messages.confirm_password_same')], 200);
        }

        $checkuser = User::where('id', $request->user_id)
            ->where(function ($query) {
                $query->Where('type', '=', 2)
                    ->orWhere('type', '=', 3)
                    ->orWhere('type', '=', 4);
            })
            ->where('is_available', 1)
            ->first();

        if (!empty($checkuser)) {
            if (Hash::check($request->old_password, $checkuser->password)) {

                User::where('id', $request->user_id)->update(['password' => Hash::make($request->new_password)]);

                return response()->json(['status' => 1, 'message' => trans('messages.password_changed')], 200);
            } else {
                return response()->json(["status" => 0, "message" => trans('messages.old_pass_invalid')], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.invalid_user')], 200);
        }
    }
    public function editprofile(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
        }
        if ($request->name == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_fullname')], 200);
        }
        $email_exist = User::where('email', $request->email)->first();
        if ((!empty($email_exist)) && ($email_exist->id != $request->user_id)) {
            return response()->json(['status' => 0, 'message' => trans('messages.email_exist')], 200);
        }
        $mobile_exist = User::where('mobile', $request->mobile)->first();
        if ((!empty($mobile_exist)) && ($mobile_exist->id != $request->user_id)) {
            return response()->json(['status' => 0, 'message' => trans('messages.mobile_exist')], 200);
        }

        if ($request->file("image") != "") {
            $file = $request->file("image");
            $checkuser = User::where('id', $request->user_id)->first();
            if ($checkuser->type == 1) {
                $filename = 'profile-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/profile/', $filename);
            }
            if ($checkuser->type == 2) {
                $filename = 'provider-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/provider/', $filename);
            }
            if ($checkuser->type == 3) {
                $filename = 'handyman-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/handyman/', $filename);
            }
            if ($checkuser->type == 4) {
                $filename = 'profile-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/profile/', $filename);
            }
            User::where('id', $request->user_id)->update(['image' => $filename]);
        }
        $checkslug = User::where('slug', Str::slug($request->name, '-'))->where('id', '!=', $request->user_id)->first();
        if ($checkslug != "") {
            $last = User::select('id')->orderByDesc('id')->first();
            $create = $request->name . " " . ($last->id + 1);
            $slug =   Str::slug($create, '-');
        } else {
            $slug = Str::slug($request->name, '-');
        }
        $update = User::where('id', $request->user_id)
            ->update([
                'name' => $request->name,
                'slug' => $slug,
            ]);

        $data = User::where('id', $request->user_id)->first();
        if ($data->type == 1) {
            $image_url = asset('storage/app/public/provider/' . $data->image);
        }
        if ($data->type == 2) {
            $image_url = asset('storage/app/public/provider/' . $data->image);
        }
        if ($data->type == 3) {
            $image_url = asset('storage/app/public/handyman/' . $data->image);
        }
        if ($data->type == 4) {
            $image_url = asset('storage/app/public/profile/' . $data->image);
        }

        $userdata = array(
            'id' => $data->id,
            'name' => $data->name,
            'mobile' => $data->mobile,
            'email' => $data->email,
            'login_type' => $data->login_type,
            'image_url' => $image_url
        );
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'userdata' => $userdata], 200);
    }
    public function addmobile(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
        }
        if ($request->mobile == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_mobile')], 200);
        }

        $checkuser = User::where('id', $request->user_id)->where('type', 4)->first();

        if (!empty($checkuser)) {
            $checkmobile = User::where('mobile', $request->mobile)->first();

            if (!empty($checkmobile)) {
                return response()->json(['status' => 0, 'message' => trans('messages.mobile_exist')], 200);
            } else {

                User::where('id', $request->user_id)->update(['mobile' => $request->mobile]);

                return response()->json(["status" => 1, "message" => trans('messages.mobile_added')], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.invalid_user')], 200);
        }
    }
    public function getprofile(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
        }

        $checkuser = User::with('city')->where('id', $request->user_id)->first();

        if (!empty($checkuser)) {
            $data = array(
                'id' => $checkuser->id,
                'name' => $checkuser->name,
                'mobile' => $checkuser->mobile,
                'email' => $checkuser->email,
                'login_type' => $checkuser->login_type,
                'referral_code' => $checkuser->referral_code,
                'image_url' => asset('storage/app/public/profile/' . $checkuser->image)
            );
            return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $data], 200);
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.invalid_user')], 200);
        }
    }
    public function addrattings(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(['status' => 0, 'message' => trans('messages.enter_user_id')], 200);
        }
        $checkuser = User::where('id', $request->user_id)->where('is_available', 1)->where('type', 4)->first();
        if (empty($checkuser)) {
            return response()->json(['status' => 0, 'message' => trans('messages.invalid_user')], 200);
        }

        if ($request->service_id == "") {
            return response()->json(['status' => 0, 'message' => trans('messages.enter_service_id')], 200);
        }
        $checkservice = Service::where('id', $request->service_id)->where('is_available', 1)->where('is_deleted', 2)->first();
        if (empty($checkservice)) {
            return response()->json(['status' => 0, 'message' => trans('messages.invalid_service')], 200);
        }
        $checkratting = Rattings::where([['user_id', $request->user_id], ['service_id', $request->service_id]])->first();
        if (!empty($checkratting)) {
            return response()->json(['status' => 0, 'message' => trans('messages.ratting_exist')], 200);
        }
        if ($request->provider_id == "") {
            return response()->json(['status' => 0, 'message' => trans('messages.enter_provider_id')], 200);
        }
        $checkprovider = User::where('id', $request->provider_id)->where('is_available', 1)->where('type', 2)->first();
        if (empty($checkprovider)) {
            return response()->json(['status' => 0, 'message' => trans('messages.invalid_provider')], 200);
        }

        if ($request->ratting == "") {
            return response()->json(['status' => 0, 'message' => trans('messages.ratting_required')], 200);
        }
        if ($request->comment == "") {
            return response()->json(['status' => 0, 'message' => trans('messages.comment_required')], 200);
        }

        $rattings = new Rattings();
        $rattings->user_id = $request->user_id;
        $rattings->service_id = $request->service_id;
        $rattings->provider_id = $request->provider_id;
        $rattings->ratting = $request->ratting;
        $rattings->comment = $request->comment;
        $rattings->save();

        $data = array(
            'id' => $rattings->id,
            'user_id' => $rattings->user_id,
            'service_id' => $rattings->service_id,
            'provider_id' => $rattings->provider_id,
            'ratting' => $rattings->ratting,
            'commnet' => $rattings->comment
        );
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $data,], 200);
    }
}
