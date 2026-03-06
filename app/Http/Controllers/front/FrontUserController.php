<?php

namespace App\Http\Controllers\front;

use App\Helpers\helper;
use App\Helpers\whatsapp_helper;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\City;
use App\Models\Notification;
use App\Models\Rattings;
use App\Models\User;
use App\Models\BookingAddress;
use App\Models\PaymentMethods;
use App\Models\SystemAddons;
use App\Models\Transaction;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Purifier;
use Stripe;

class FrontUserController extends Controller
{
    public function add_address(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'street_address' => 'required',
            'landmark' => 'required',
            'postalcode' => 'required'
        ], [
            'fullname.required' => trans('messages.enter_full_name'),
            'email.required' => trans('messages.enter_email'),
            'email.email' => trans('messages.enter_valid_email'),
            'mobile.required' => trans('messages.enter_mobile'),
            'street_address.required' => trans('messages.enter_street_address'),
            'landmark.required' => trans('messages.enter_landmark'),
            'postalcode.required' => trans('messages.enter_postalcode'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if ($request->address_id != '') {
                $updateaddress = BookingAddress::where('id', $request->address_id)->first();
                $updateaddress->user_id = Auth::user()->id;
                $updateaddress->name = $request->fullname;
                $updateaddress->street = $request->street_address;
                $updateaddress->landmark = $request->landmark;
                $updateaddress->postcode = $request->postalcode;
                $updateaddress->email = $request->email;
                $updateaddress->mobile = $request->mobile;
                $updateaddress->address_type = $request->address_type;
                $updateaddress->save();
                return redirect()->back()->with('success', trans('messages.success'));
            } else {
                $address = new BookingAddress();
                $address->user_id = Auth::user()->id;
                $address->name = $request->fullname;
                $address->street = $request->street_address;
                $address->landmark = $request->landmark;
                $address->postcode = $request->postalcode;
                $address->email = $request->email;
                $address->mobile = $request->mobile;
                $address->address_type = $request->address_type;
                $address->save();
                return redirect()->back()->with('success', trans('messages.success'));
            }
        }
    }

    public function changepass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_pass' => 'different:old_pass',
            'confirm_pass' => 'same:new_pass'
        ], [
            'new_pass.different' => trans('messages.new_password_different'),
            'confirm_pass.same' => trans('messages.confirm_password_same'),
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if (Hash::check($request->old_pass, Auth::user()->password)) {
                User::where('id', Auth::user()->id)->update(['password' => Hash::make($request->new_pass)]);

                return redirect()->back()->with("success", trans('messages.password_changed'));
            } else {
                return redirect()->back()->with("error", trans('messages.old_pass_invalid'));
            }
        }
    }

    public function clearnotification()
    {
        $update = Notification::where('user_id', Auth::user()->id)->update(["is_read" => 1]);
        return json_encode($update);
    }

    public function notifications()
    {
        if (isset($_COOKIE["city_id"])) {
            $notifications = Notification::select('notification.id', 'notification.booking_id', 'notification.booking_status', 'notification.title', 'notification.message', 'notification.canceled_by', 'notification.is_read', DB::raw('DATE(notification.created_at) AS date'))
                ->where('notification.user_id', Auth::user()->id)
                ->orderByDesc('notification.id')
                ->paginate(10)->onEachSide(0);
        } else {
            $notifications = "";
        }
        return view('front.user.notifications', compact('notifications'));
    }

    public function referearn()
    {
        return view('front.user.referearn');
    }
    public function bookings(Request $request)
    {
        if (isset($_COOKIE["city_id"])) {
            $city = City::select('id')->where('id', $_COOKIE['city_id'])->first();
            $bookingdata = Booking::join('services', 'bookings.service_id', 'services.id')
                ->join('users', 'bookings.provider_id', 'users.id')
                ->select(
                    'bookings.booking_id',
                    'bookings.service_id',
                    'bookings.service_name',
                    'users.name as provider_name',
                    'users.slug as provider_slug',
                    'bookings.canceled_by',
                    'bookings.date',
                    'bookings.time',
                    'bookings.total_amt',
                    'bookings.address',
                    'bookings.status',
                    'bookings.provider_id',
                    'bookings.handyman_id',
                    'users.image as provider_image',
                    'bookings.service_image as service_image',
                )
                ->where('bookings.user_id', Auth::user()->id)
                ->where('users.city_id', @$city->id)
                ->orderByDesc('bookings.id')
                ->paginate(10)->onEachSide(0);
            $query1 = $request->get('search_by');
            if ($query1) {
                if ($query1 == 'all') {
                    $bookingdata = Booking::join('users as provider', 'bookings.provider_id', 'provider.id')
                        ->select('bookings.*', 'provider.name as provider_name', 'provider.slug as provider_slug', 'provider.image as provider_image', 'bookings.service_image as service_image')
                        ->where('user_id', Auth::user()->id)
                        ->where('provider.city_id', @$city->id)
                        ->orderByDesc('bookings.id')
                        ->paginate(10)->onEachSide(0);
                } else {
                    $bookingdata = Booking::join('users as provider', 'bookings.provider_id', 'provider.id')
                        ->select('bookings.*', 'provider.name as provider_name', 'provider.slug as provider_slug', 'bookings.service_image as service_image', 'provider.image as provider_image')
                        ->where('user_id', Auth::user()->id)
                        ->where('bookings.status', $query1)
                        ->where('provider.city_id', @$city->id)
                        ->orderByDesc('bookings.id')
                        ->paginate(10)->onEachSide(0);
                }
            }
        } else {
            $bookingdata = "";
        }
        if ($request->ajax()) {
            $output = view('front.user.booking_table', compact('bookingdata'))->render();
            return Response::json(['status' => 1, 'bookings_by' => $output], 200);
        } else {
            return view('front.user.bookings', compact('bookingdata'));
        }
    }
    public function booking_details($id)
    {
        if (isset($_COOKIE["city_id"])) {
            $city = City::select('id')->where('id', $_COOKIE['city_id'])->first();
            $bookingdata = Booking::join('services', 'bookings.service_id', 'services.id')
                ->join('categories', 'services.category_id', 'categories.id')
                ->join('users', 'bookings.provider_id', 'users.id')
                ->leftJoin('users as handyman', 'bookings.handyman_id', 'handyman.id')
                ->leftJoin('rattings', function ($query) {
                    $query->on('rattings.service_id', '=', 'bookings.service_id')
                        ->where('rattings.user_id', '=', @Auth::user()->id);
                })
                ->select(
                    'bookings.booking_id',
                    'bookings.service_id',
                    'bookings.service_name',
                    'bookings.provider_name',
                    'bookings.date',
                    'bookings.time',
                    'bookings.price',
                    'bookings.tax',
                    'bookings.tax_name',
                    'bookings.payment_type',
                    'bookings.total_amt',
                    'bookings.tips',
                    'bookings.discount',
                    'bookings.name',
                    'bookings.email',
                    'bookings.mobile',
                    'bookings.address',
                    'bookings.note',
                    'bookings.status',
                    'bookings.provider_id',
                    'bookings.screenshot',
                    'bookings.canceled_by',
                    'bookings.payment_status',
                    'bookings.coupon_code',
                    'users.name as provider_name',
                    'users.slug as provider_slug',
                    'categories.name as category_name',
                    'services.price_type',
                    'services.description',
                    'services.duration_type',
                    'services.duration',
                    'services.description',
                    'services.slug as service_slug',
                    'bookings.handyman_accept',
                    'handyman.id as handyman_id',
                    'handyman.name as handyman_name',
                    'handyman.email as handyman_email',
                    'handyman.mobile as handyman_mobile',
                    'users.email as provider_email',
                    'users.mobile as provider_mobile',
                    'handyman.image as handyman_image',
                    'users.image as provider_image',
                    'bookings.service_image as service_image',
                    DB::raw('(case when rattings.service_id is null then 0 else 1 end) as is_rated'),
                )
                ->where('bookings.booking_id', $id)
                ->where('users.city_id', @$city->id)
                ->first();
            Session::put('booking_id', $id);
            if (!empty($bookingdata)) {
                if (SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null && SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1) {
                    if (whatsapp_helper::whatsapp_message_config()->booking_created == 1) {
                        if (whatsapp_helper::whatsapp_message_config()->message_type == 2) {
                            $whmessage = whatsapp_helper::whatsappmessage($id);
                        } else {
                            whatsapp_helper::whatsappmessage($id);
                        }
                    }
                } else {
                    $whmessage = "";
                }
                $paymethods = PaymentMethods::where('is_available', 1)->where('is_activate', '1')->whereNotIn('payment_type', [1, 2])->orderBy('reorder_id')->get();
                $walletpaymethods = PaymentMethods::where('is_available', 1)->where('payment_type', 2)->where('is_activate', '1')->orderBy('id')->first();
            } else {
                $whmessage = "";
                $paymethods = "";
                $walletpaymethods = "";
            }
        } else {
            $bookingdata = "";
            $whmessage = "";
            $paymethods = "";
            $walletpaymethods = "";
        }
        return view('front.user.booking_details', compact('bookingdata', 'whmessage', 'paymethods', 'walletpaymethods'));
    }
    public function booking_payment(Request $request)
    {
        if ($request->modal_payment_type == 16) {
            $booking_id = $request->modal_booking_number;
            $user_id = $request->modal_user_id;
            $payment_type = $request->modal_payment_type;
        } else {
            if (in_array($request->payment_type, [2, 3, 4, 5, 6])) {
                $user_id = $request->user_id;
                $booking_id = $request->booking_id;
                $payment_type = $request->payment_type;
                $payment_id = $request->payment_id;
            } else {
                $userdata = Session::get('userdata');
                $user_id = @$userdata['user_id'];
                $booking_id = $userdata['booking_id'];
                $payment_type = $userdata['payment_type'];
                if ($request->paymentId == null) {
                    $payment_id = session()->get('payment_id');
                } else {
                    $payment_id = $request->paymentId;
                }
            }
        }
        if ($payment_type == 16) {
            if ($request->hasFile('screenshot')) {
                $filename = 'screenshot-' . uniqid() . "." . $request->file('screenshot')->getClientOriginalExtension();
                $request->file('screenshot')->move('storage/app/public/screenshot/', $filename);
            }
        }
        $bdata = Booking::where('booking_id', $booking_id)->first();
        if ($payment_type == 2) {

            $getuserdata = User::where('id', $request->user_id)->get()->first();
            if ($getuserdata->wallet < $bdata->total_amt) {
                return response()->json(["status" => 0, "message" => trans('messages.low_balance')], 200);
            } else {
                $wallet = $getuserdata->wallet - ($bdata->total_amt + $bdata->tips);

                User::where('id', $request->user_id)->update(['wallet' => $wallet]);

                $transaction = new Transaction();
                $transaction->user_id = $user_id;
                $transaction->service_id = $bdata->service_id;
                $transaction->provider_id = $bdata->provider_id;
                $transaction->booking_id = $booking_id;
                $transaction->amount = $bdata->total_amt;
                $transaction->tips = $bdata->tips;
                $transaction->payment_type = 2;
                $transaction->save();
            }
        }
        if ($payment_type == 4) {

            Stripe\Stripe::setApiKey(helper::stripe_key());
            $payment = Stripe\Charge::create([
                "amount" => $bdata->total_amt * 100,
                "currency" => "USD",
                "source" => $request->stripeToken,
                "description" => "Test payment description.",
            ]);
            $payment_id = $payment->id;
        }
        if ($payment_type != 1 && $payment_type != 2 && $payment_type != 16) {
            $bdata->transaction_id = $payment_id;
        }
        $bdata->payment_type = $payment_type;
        if ($payment_type == 16) {
            $bdata->payment_status = 1;
            $bdata->screenshot = $filename;
        } else {
            $bdata->payment_status = 2;
        }
        $bdata->save();

        session()->forget('payment_type');
        session()->forget('userdata');
        if ($payment_type == 7 || $payment_type == 8 || $payment_type == 9 || $payment_type == 10 || $payment_type == 11 || $payment_type == 12 || $payment_type == 13 || $payment_type == 14 || $payment_type == 15 || $payment_type == 16) {
            return redirect('/home/user/bookings/' . $bdata->booking_id)->with('success', trans('messages.success'));
        }
        return Response::json(['status' => 1, 'message' => trans('messages.success'), 'booking_id' => $request->booking_id], 200);
    }

    public function bookingpaymentsuccess(Request $request)
    {
        try {
            if ($request->has('paymentId')) {
                $paymentId = request('paymentId');
                $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
            }
            if ($request->has('payment_id')) {
                $paymentId = request('payment_id');
                $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
            }

            if ($request->has('transaction_id')) {
                $paymentId = request('transaction_id');
                $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
            }

            if (Session::get('payment_type') == "11") {
                $checkstatus = app('App\Http\Controllers\addons\PayTabController')->checkpaymentstatus(Session::get('tran_ref'));
                if ($checkstatus == "A") {
                    $paymentId = Session::get('tran_ref');
                    $response = ['status' => '1', 'msg' => 'paid', 'paymentId' => $paymentId];
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }

            if (Session::get('payment_type') == "12") {
                if ($request->code == "PAYMENT_SUCCESS") {
                    $paymentId = $request->transactionId;
                    $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
                } else {
                    return redirect('/home/user/bookings/' . Session::get('booking_id'))->with('error', trans('messages.unable_to_complete_payment'));
                }
            }

            if (Session::get('payment_type') == "13") {
                $checkstatus = app('App\Http\Controllers\addons\MollieController')->checkpaymentstatus(Session::get('tran_ref'));

                if ($checkstatus == "A") {
                    $paymentId = Session::get('tran_ref');
                    $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }

            if (Session::get('payment_type') == "14") {

                if ($request->status == "Completed") {
                    $paymentId = $request->transaction_id;
                    $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }

            if (Session::get('payment_type') == "15") {
                $checkstatus = app('App\Http\Controllers\addons\XenditController')->checkpaymentstatus(Session::get('tran_ref'));
                if ($checkstatus == "PAID") {
                    $paymentId = session()->get('payment_id');
                    $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }
        } catch (\Exception $e) {
            $response = ['status' => 0, 'msg' => $e->getMessage()];
        }

        $request = new Request($response);

        return $this->booking_payment($request);
    }

    public function bookingpaymentfail()
    {
        if (count(request()->all()) > 0) {
            return redirect('/home/user/bookings/' . Session::get('booking_id'))->with('error', trans('messages.unable_to_complete_payment'));
        } else {
            return redirect('/home/user/bookings/' . Session::get('booking_id'));
        }
    }
    public function reviews()
    {
        if (isset($_COOKIE["city_id"])) {
            $rattingsdata = Rattings::leftJoin('users', 'rattings.provider_id', '=', 'users.id')
                ->leftJoin('services', 'rattings.service_id', '=', 'services.id')
                ->select(
                    'rattings.id',
                    'rattings.ratting',
                    'rattings.comment',
                    'services.id as service_id',
                    'services.name as service_name',
                    'services.slug as service_slug',
                    'users.id as provider_id',
                    'users.name as provider_name',
                    'users.slug as provider_slug',
                    'services.image as service_image',
                    'users.image as provider_image',
                    DB::raw('DATE(rattings.created_at) AS date')
                )
                ->where('rattings.user_id', @Auth::user()->id)
                ->paginate(10)->onEachSide(0);
        } else {
            $rattingsdata = "";
        }
        return view('front.user.reviews', compact('rattingsdata'));
    }
    public function profile()
    {
        if (isset($_COOKIE["city_id"])) {
            $citydata = City::select('id', 'name')->where('is_available', 1)->where('is_deleted', 2)->orderBy('name')->get();
        } else {
            $citydata = "";
        }
        return view('front.user.profile', compact('citydata'));
    }
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
        ], [
            'name.required' => trans('messages.enter_fullname'),
            'address.required' => trans('messages.enter_address'),
            'city.required' => trans('messages.enter_city'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            if ($request->file('image') != "") {
                $validator = Validator::make(
                    $request->all(),
                    ['image' => 'image'],
                    [
                        'image.image' => trans('messages.enter_image_file')
                    ]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } else {
                    if (Auth::user()->image != "default.png") {
                        if (file_exists(storage_path("app/public/profile/" . Auth::user()->image))) {
                            unlink(storage_path("app/public/profile/" . Auth::user()->image));
                        }
                    }
                    $file = $request->file('image');
                    $filename = 'profile-' . time() . "." . $file->getClientOriginalExtension();
                    $file->move(storage_path() . '/app/public/profile/', $filename);

                    User::where('id', Auth::user()->id)->update(['image' => $filename]);
                }
            }
            $update = User::where('id', Auth::user()->id)->update([
                'name' => $request->name,
                'address' => $request->address,
                'city_id' => $request->city,
                'about' => strip_tags(Purifier::clean($request->about))
            ]);
            return redirect(route('user_profile'))->with('success', trans('messages.success'));
        }
    }

    public function wishlist()
    {
        $city = City::select('id')->where('id', $_COOKIE['city_id'])->first();
        $wishlistdata = Wishlist::with('rattings', 'service_multi_image')
            ->join('services', 'wishlists.service_id', '=', 'services.id')
            ->join('categories', 'services.category_id', '=', 'categories.id')
            ->join('users', 'services.provider_id', '=', 'users.id')
            ->select(
                'services.id',
                'services.name as service_name',
                'services.slug',
                'services.is_top_deals',
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
            ->where('wishlists.user_id', @Auth::user()->id)
            ->where('services.is_available', 1)
            ->where('services.is_deleted', 2)
            ->orderByDesc('wishlists.id')
            ->paginate(6)->onEachSide(0);
        return view('front.user.wishlist', compact('wishlistdata'));
    }

    public function delete_address(Request $request)
    {
        $address =  BookingAddress::where('id', $request->address_id)->where('user_id', Auth::user()->id)->first();
        $address->delete();
        return redirect()->back()->with('message', trans('messages.success'));
    }
    public function deleteuser(Request $request)
    {
        $user  = User::where('id', $request->id)->first();
        $user->is_available = 2;
        $user->update();
        Helper::send_mail_delete_account($user);
        Auth::logout();
        session()->flush();
        return redirect()->route('home')->with('message', trans('messages.success'));
    }
}
