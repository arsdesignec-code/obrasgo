<?php

namespace App\Http\Controllers;

use App\Helpers\helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\ProviderType;
use App\Models\Timing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;
use Str;

class LoginController extends Controller
{
    public function adminlogin()
    {
        if (!file_exists(storage_path() . "/installed")) {
            return redirect('install');
            exit;
        }
        return view("auth.index");
    }
    public function checkadminlogin(Request $request)
    {
        session()->put('admin_login', 1);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_deleted' => 2])) {
            if (!Auth::user()) {
                return Redirect::to('/verification')->with('error', Session::get('from_message'));
            }
            if (Auth::user()->type == 1 || Auth::user()->type == 2 || Auth::user()->type == 3) {
                Session::put('type', Auth::user()->type);
                if (Auth::user()->is_available == "2" || Auth::user()->is_deleted == "1") {
                    return redirect()->back()->with('error', trans('messages.blocked'));
                }
                return redirect()->route('dashboard');
            } else if (Auth::user()->type == 4) {
                Auth::logout();
                return redirect()->back()->with('error', trans('messages.email_pass_invalid'));
            } else {
                return redirect()->back()->with('error', trans('messages.email_pass_invalid'));
            }
        } else {
            return redirect()->back()->with('error', trans('messages.email_pass_invalid'));
        }
    }

    public function register_provider()
    {
        $providertypedata = ProviderType::where('is_available', 1)->where('is_deleted', 2)->orderBy('id', 'DESC')->get();
        $citydata = City::where('is_available', 1)->where('is_deleted', 2)->orderBy('id', 'DESC')->get();
        return view("auth.register", compact('providertypedata', 'citydata'));
    }
    public function store_provider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email,NULL,id,is_deleted,2',
            'mobile' => 'unique:users,mobile,NULL,id,is_deleted,2',
        ],  [
            'email.unique' => trans('messages.email_exist'),
            'mobile.unique' => trans('messages.mobile_exist'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            if ($request->file("image") != "") {
                $file = $request->file("image");
                $fname = 'provider-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/provider/', $fname);
                $filename = $fname;
            } else {
                $filename  = "default.png";
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
            $provider = new User();
            $provider->name = $request->name;
            $provider->email = $request->email;
            $provider->password = Hash::make($request->password);
            $provider->mobile = $request->mobile;
            $provider->provider_type = $request->provider_type;
            $provider->image = $filename;
            $provider->address = $address;
            $provider->city_id = $request->city;
            $provider->type = 2;
            $provider->login_type = "email";
            $provider->is_verified = 1;
            $provider->is_available = 1;
            $provider->slug = $slug;

            if ($provider->save()) {
                session(['otpemail' => $request->email]);
                $day = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $open_time = array('9:00am', '9:00am', '9:00am', '9:00am', '9:00am', '9:00am', '9:00am');
                $close_time = array('6:00pm', '6:00pm', '6:00pm', '6:00pm', '6:00pm', '6:00pm', '6:00pm');

                foreach ($day as $key => $no) {
                    $time = new Timing();
                    $time->provider_id = $provider->id;
                    $time->day = $no;
                    $time->open_time = $open_time[$key];
                    $time->close_time = $close_time[$key];
                    $time->is_always_close = 2;
                    $time->save();
                }
                return redirect(route('adminlogin'))->with('success', trans('messages.success'));
            } else {
                return redirect()->back()->with('error', trans('messages.wrong'));
            }
        }
    }
    public function adminforgotpassword()
    {
        return view("auth.forgot_password");
    }
    public function admin_send_pass(Request $request)
    {
        $check = User::where('email', $request->email)
            ->where('type', 1)
            ->where('is_available', 1)
            ->first();
        if (!empty($check)) {
            if ($check->is_available == 1) {
                $new_password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
                $helper = Helper::forgotpassword($request->email, $check->name, $new_password);
                if ($helper == 1) {
                    User::where('email', $request->email)->update(['password' => Hash::make($new_password)]);
                    return redirect(route('adminlogin'))->with('success', trans('messages.password_sent'));
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

    public function index(Request $request)
    {
        if (@helper::checkaddons('customer_login')) {
            if (@helper::appdata()->login_required == 1) {
                session()->put('previous_url', url()->previous());
                return view("front.login");
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }
    public function checklogin(Request $request)
    {
        session()->put('vendor_login', 1);
        if (Auth::attempt($request->only('email', 'password'))) {
            if (Auth::user()->type == 1 || Auth::user()->type == 2 || Auth::user()->type == 3) {
                Auth::logout();
                return redirect()->back()->with('error', trans('messages.email_pass_invalid'));
            } else if (Auth::user()->type == 4) {
                if (Auth::user()->is_available == "2") {
                    return redirect()->back()->with('error', trans('messages.blocked'));
                }
                session()->put('type', Auth::user()->type);
                session(['id' => Auth::user()->id]);
                if (session()->get('previous_url') != null) {
                    return redirect()->route('home');
                } else {
                    return redirect(session()->get('previous_url'));
                }
            } else {
                return redirect()->back()->with('error', trans('messages.email_pass_invalid'));
            }
        } else {
            return redirect()->back()->with('error', trans('messages.email_pass_invalid'));
        }
    }

    public function systemverification(Request $request)
    {
        $username = str_replace(' ', '', $request->username);

        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IkwxeWUxTEduU29hbXEyc05qSGtSNnc9PSIsInZhbHVlIjoiSTVJcWVFeUg2NzE3WnRGK2ZyLzc2dkNzWFMyWUt5VTlQR285M2NqRXJzR1lTZEtFc2VRWVlwTDcrR3R6TGZubCIsIm1hYyI6IjYzODgxNGY3MDk2OGRhMTgyMGI2NWIzZDhkNWNmY2Y3ZjdhZDQyZTYwZjdhZWVhMjdmZDEzYTQzZDBkN2M5ODYiLCJ0YWciOiIifQ=='), [
            'form_params' => [
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6ImJkS3crTk9COHRYL0tQK2kxRERNQXc9PSIsInZhbHVlIjoiU0NIcmkrT2xJdkppcnJ5cFY4OW5XWllud3c4Z3QyaGVHK0hYVVUyNnc3UT0iLCJtYWMiOiI0Njg1NTcwNTAxNTI0ODFmZDE0Y2FmMWU4M2M3ZGFkZThjNDgxZWZlNTY1ZmVkOTdiNGZjM2VkNDI5MmI2NTljIiwidGFnIjoiIn0=') => $username,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6ImU5NjI5NFRTQXRWeTRHQndWVHJsUXc9PSIsInZhbHVlIjoiNHpzaHFCVjc0ajVKMktNampzN0NvUT09IiwibWFjIjoiODU5M2M0Y2VhMDE5YjgyNzU5MWE4NzZjOGUxNjlkZWFhMWI0ZjJiYTU2YTQ1NTMwYzI4YjBhMjg5Y2VhNzNiYiIsInRhZyI6IiJ9') => $request->email,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IkxHVHdQNGo0Vzd1TktaS21kZEQwL1E9PSIsInZhbHVlIjoiRDEvUGZZa3MzbkkzQ0pxUFlrRFJOektiU1FLN3YvZ3ZHK25UcE95UHFzdz0iLCJtYWMiOiI5NWJlNDVmM2VkNWViZDYxNTIwNGI1MWI0ZTU0YWEzN2VkNjhhZDZlM2QwOWMyOGY5OTFkYTY5ODVkNWY2NDdiIiwidGFnIjoiIn0=') => $request->purchase_key,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IlRTOCtHbEI3Slh3Wm1sWHRCNWM2SWc9PSIsInZhbHVlIjoiNGxHU2puYjdnaCtUUVhJeFVNa014dz09IiwibWFjIjoiNzY4ZjI2MjZmZTVjMjI1NTZhNGZjMjNjYjE4M2MyODUxOTkwNWE2NjA1MjI3NTRiOTViMDY3Zjc3OTEzYWY2NSIsInRhZyI6IiJ9') => $request->domain,
                \Illuminate\Support\Facades\Crypt::decrypt('^ "eyJpdiI6IlZSSHhaNC8rOFVHRHNsdXVseDZRTGc9PSIsInZhbHVlIjoieGp2aEFLOU85OGdPeUNDck9TeUg2WW12Y3d4L3AyeHNwRXh5dXN2UTRJVT0iLCJtYWMiOiI2NzE3NmIxM2M3YzgzM2JjMDkyMjMyMGUwODFhZDA3NzVhZDI4YmJjMDk4NzJiYmI1M2NkZWRmZTZhNzZhZWM0IiwidGFnIjoiIn0=') => \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IlVJVTlCMXozN3BtY1RHTUZIS2N3ZXc9PSIsInZhbHVlIjoicXIreUdDeXNMb2lIZUg1QUphM1lCdz09IiwibWFjIjoiMWM2NzEyOTYzNjNmMzIwY2NjZWY2NGY2ZDIxMzNiNDIxMWUyMzc2MGQ1ODQyMmVkNzlkYjcxZDM5ZGRiYzI5YiIsInRhZyI6IiJ9'),
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6Ii9xbk0yamJvZTVRdXFUY1FPaE5DZ2c9PSIsInZhbHVlIjoidVJJUk5YZzMxc2VCOFVjUFJsZ2hCUT09IiwibWFjIjoiZjM5MzkxOWIxNmE5NWQxMzljMDZlNGVhZThlNWVmYmY2MzFkMmU5NDUxNmRiMTRkNWRjNGJmY2I5YzNhZDA3ZCIsInRhZyI6IiJ9') => \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IjJ2WmlxOHJBNzk2LzU0aENVMjJPemc9PSIsInZhbHVlIjoiUEF4Z1IrMjl1SkRGbzZFdXhSVG9wdz09IiwibWFjIjoiODM4YjgyMWYyZDY4NGMxODNjNmRiY2ExNWU4MzkzNWJlZGI1MjU3MjEwODFjMDA0NzY5YTZmNDJkNDZlY2Q5MiIsInRhZyI6IiJ9'),
            ]
        ]);

        $obj = json_decode($res->getBody());

        if ($obj->status == '1') {
            User::where('id', 1)->update(['license_type' => $obj->license_type]);
            return Redirect::to('/admin')->with('success', 'Success');
        } else {
            return Redirect::back()->with('error', $obj->message);
        }
    }

    public function logout()
    {
        if (session()->get('type') == 4) {
            Auth::logout();
            session()->flush();
            return redirect('/');
        } else {
            Auth::logout();
            session()->flush();
            return redirect(route('adminlogin'));
        }
    }
    public function log_in_provider($slug)
    {
        $data = User::where('slug', $slug)->first();
        Auth::loginUsingId($data->id, TRUE);
        if (Auth::user()->type == 2) {
            Session::put('back_admin', 1);
        } elseif (Auth::user()->type == 3) {
            Session::put('back_provider', $data->provider_id);
        }
        return redirect(route('dashboard'));
    }
    public function go_back()
    {
        if (Auth::user()->type == 2) {
            Auth::loginUsingId(Session::get('back_admin'), TRUE);
            Session::forget('back_admin');
            return redirect(route('providers'));
        } elseif (Auth::user()->type == 3) {
            Auth::loginUsingId(Session::get('back_provider'), TRUE);
            Session::forget('back_provider');
            return redirect(route('handymans'));
        }
    }
}
