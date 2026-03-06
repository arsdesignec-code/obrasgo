<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use App\Models\Booking;
use App\Models\BookingAddress;
use App\Models\Transaction;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\helper;
use App\Helpers\whatsapp_helper;
use App\Models\SystemAddons;
use App\Models\Tax;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Mews\Purifier\Facades\Purifier;
use Stripe;

class ServiceBookController extends Controller
{
        public function book(Request $request)
        {
                try {
                        if ($request->modal_payment_type == 16) {
                                $service = $request->modal_service_id;
                                $user_id = $request->modal_user_id;
                                $street = $request->modal_address;
                                $landmark = $request->modal_landmark;
                                $postcode = $request->modal_postal_code;
                                $fullname = $request->modal_name;
                                $email = $request->modal_email;
                                $mobile = $request->modal_mobile;
                                $payment_type = $request->modal_payment_type;
                                $service_price = $request->modal_sub_total;
                                $total_price = $request->modal_grand_total - $request->modal_tips;
                                $tax_name = $request->modal_tax_name;
                                $tax = $request->modal_tax;
                                $booking_notes = $request->modal_message;
                                $coupon_code = $request->modal_coupon_code;
                                $discount = $request->modal_discount;
                                $date = $request->modal_booking_date;
                                $time = $request->modal_booking_time;
                                $tips = $request->modal_tips;
                        } else {
                                if (!empty(Session::get('userdata'))) {
                                        $userdata = Session::get('userdata');
                                        $service = $userdata['service'];
                                        $user_id = $userdata['user_id'];
                                        $street = $userdata['street'];
                                        $landmark = $userdata['landmark'];
                                        $postcode = $userdata['postcode'];
                                        $fullname = $userdata['fullname'];
                                        $email = $userdata['email'];
                                        $mobile = $userdata['mobile'];
                                        $payment_type = $userdata['payment_type'];
                                        $service_price = $userdata['service_price'];
                                        $total_price = $userdata['total_price'] - $userdata['tips'];
                                        $tax_name = $userdata['tax_name'];
                                        $tax = $userdata['tax'];
                                        $booking_notes = $userdata['booking_notes'];
                                        $coupon_code = $userdata['coupon_code'];
                                        $discount = $userdata['discount'];
                                        if ($request->paymentId == null) {
                                                $payment_id = session()->get('payment_id');
                                        } else {
                                                $payment_id = $request->paymentId;
                                        }
                                        $date = $userdata['date'];
                                        $time = $userdata['time'];
                                        $tips = $userdata['tips'];
                                } else {
                                        $service = $request->service;
                                        $user_id = $request->user_id;
                                        $street = $request->street;
                                        $landmark = $request->landmark;
                                        $postcode = $request->postcode;
                                        $fullname = $request->fullname;
                                        $email = $request->email;
                                        $mobile = $request->mobile;
                                        $payment_type = $request->payment_type;
                                        $service_price = $request->service_price;
                                        $total_price = $request->total_price - $request->tips;
                                        $tax_name = $request->tax_name;
                                        $tax = $request->tax;
                                        $booking_notes = $request->booking_notes;
                                        $coupon_code = $request->coupon_code;
                                        $discount = $request->discount;
                                        $payment_id = $request->payment_id;
                                        $date = $request->date;
                                        $time = $request->time;
                                        $tips = $request->tips;
                                }
                        }
                        $getbookingId = Booking::select('booking_id', 'booking_number_digit', 'booking_number_start')->orderBy('id', 'DESC')->first();

                        if (empty($getbookingId->booking_number_digit)) {
                                $n = helper::appdata()->booking_number_start;
                                $newbooking_number = str_pad($n, 0, STR_PAD_LEFT);
                        } else {
                                if ($getbookingId->booking_number_start == helper::appdata()->booking_number_start) {
                                        $n = (int)($getbookingId->booking_number_digit);
                                        $newbooking_number = str_pad($n + 1, 0, STR_PAD_LEFT);
                                } else {
                                        $n = helper::appdata()->booking_number_start;
                                        $newbooking_number = str_pad($n, 0, STR_PAD_LEFT);
                                }
                        }
                        $booking__number = helper::appdata()->booking_prefix . $newbooking_number;

                        $checkservice = Service::where('id', $service)->where('is_available', 1)->where('is_deleted', 2)->first();

                        $checkprovider = User::where('id', $checkservice->provider_id)->first();

                        if ($payment_type == 2) {

                                $getuserdata = User::where('id', $user_id)->get()->first();
                                if ($getuserdata->wallet < $request->total_price) {
                                        return response()->json(["status" => 0, "message" => trans('messages.low_balance')], 200);
                                } else {
                                        $wallet = $getuserdata->wallet - ($total_price + $tips);

                                        User::where('id', $user_id)->update(['wallet' => $wallet]);

                                        $transaction = new Transaction;
                                        $transaction->user_id = $user_id;
                                        $transaction->service_id = $service;
                                        $transaction->provider_id = $checkservice->provider_id;
                                        $transaction->booking_id = $booking__number;
                                        $transaction->amount = $total_price;
                                        $transaction->tips = $tips;
                                        $transaction->payment_type = 2;
                                        $transaction->save();
                                }
                        }
                        if ($payment_type == 4) {

                                Stripe\Stripe::setApiKey(helper::stripe_key());
                                $payment = Stripe\Charge::create([
                                        "amount" => $request->total_price * 100,
                                        "currency" => "USD",
                                        "source" => $request->stripeToken,
                                        "description" => "Test payment description.",
                                ]);
                                $payment_id = $payment->id;
                        }
                        if ($payment_type == 16) {
                                if ($request->hasFile('screenshot')) {
                                        $filename = 'screenshot-' . uniqid() . "." . $request->file('screenshot')->getClientOriginalExtension();
                                        $request->file('screenshot')->move('storage/app/public/screenshot/', $filename);
                                }
                        }
                        $note = strip_tags(Purifier::clean($booking_notes));
                        $booking = new Booking();
                        $booking->booking_id = $booking__number;
                        $booking->booking_number_digit = $newbooking_number;
                        $booking->booking_number_start = helper::appdata()->booking_number_start;
                        $booking->service_id = $service;
                        $booking->service_name = $checkservice->name;
                        $booking->service_image = $checkservice->image;
                        $booking->price = $service_price;
                        $booking->price_type = $checkservice->price_type;
                        $booking->duration = $checkservice->duration;
                        $booking->duration_type = $checkservice->duration_type;
                        $booking->provider_id = $checkservice->provider_id;
                        $booking->provider_name = $checkprovider->name;
                        $booking->date = $date;
                        $booking->time = $time;
                        if (Storage::exists('service_id')) {
                                $booking->coupon_code = $coupon_code;
                                $booking->discount = $discount;
                        }
                        $booking->user_id = $user_id;
                        $booking->tax = $tax;
                        $booking->tax_name = $tax_name;
                        $booking->name = $fullname;
                        $booking->email = $email;
                        $booking->mobile = $mobile;
                        $booking->address = $street . ", " . $landmark . ", " . $postcode;
                        $booking->payment_type = $payment_type;
                        if ($payment_type != "1" && $payment_type != "2" && $payment_type != "16" && $payment_type != null) {
                                $booking->transaction_id = $payment_id;
                        }
                        if ($payment_type == "16" && $payment_type != null) {
                                $booking->screenshot = $filename;
                        }
                        $booking->note = $note;
                        $booking->total_amt = $total_price;
                        $booking->tips = $tips;
                        if ($payment_type  == 1 || $payment_type == 16) {
                                $booking->payment_status = 1;
                        } else {
                                $booking->payment_status = 2;
                        }
                        if ($booking->save()) {

                                if (Storage::exists('service_id')) {
                                        Storage::disk('local')->delete("service_id");
                                }
                                if (Storage::exists('service_slug')) {
                                        Storage::disk('local')->delete("service_slug");
                                }
                                if (Storage::exists('coupon_code')) {
                                        Storage::disk('local')->delete("coupon_code");
                                }
                                if (Storage::exists('total_discount')) {
                                        Storage::disk('local')->delete("total_discount");
                                }
                                if (Storage::exists('discount_type')) {
                                        Storage::disk('local')->delete("discount_type");
                                }
                                if (Storage::exists('service')) {
                                        Storage::disk('local')->delete("service");
                                }
                                if (Storage::exists('total_price')) {
                                        Storage::disk('local')->delete("total_price");
                                }
                                session()->forget('userdata');
                                if ($payment_type == 7 || $payment_type == 8 || $payment_type == 9 || $payment_type == 10 || $payment_type == 11 || $payment_type == 12 || $payment_type == 13 || $payment_type == 14 || $payment_type == 15 || $payment_type == 16) {
                                        return redirect('/home/success-' . $booking__number)->with('success', trans('messages.complete_booking_msg'));
                                }

                                $helper = Helper::create_booking($booking->booking_id);
                                if ($helper == 1) {
                                        if ($request->user_id != null) {
                                                Helper::create_booking_noti($booking->user_id, $booking->provider_id, $booking->booking_id);
                                                if (SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null && SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1) {
                                                        if (whatsapp_helper::whatsapp_message_config()->booking_created == 1) {
                                                                whatsapp_helper::whatsappmessage($booking->booking_id);
                                                        }
                                                }
                                                return Response::json(['status' => 1, 'message' => $request->input(), 'booking_id' => $booking->booking_id], 200);
                                        } else {
                                                return Response::json(['status' => 1, 'message' => $request->input(), 'booking_id' => $booking->booking_id], 200);
                                        }
                                } else {
                                        return Response::json(['status' => 1, 'message' => $request->input(), 'booking_id' => $booking->booking_id], 200);
                                }
                        } else {
                                return Response::json(['status' => 0, 'message' => trans('messages.wrong')], 200);
                        }
                } catch (\Throwable $th) {
                        dd($th);
                }
        }

        public function cancel(Request $request)
        {
                if ($request->booking_id != "") {

                        $bdata = Booking::where('booking_id', $request->booking_id)->first();

                        if (!empty($bdata)) {

                                if ($bdata->status == 2) {
                                        return response()->json(['status' => 0, 'message' => trans('messages.accepted_by_provider')], 200);
                                } elseif ($bdata->status == 4) {
                                        return response()->json(['status' => 0, 'message' => trans('messages.cancelled_by_provider')], 200);
                                } else {
                                        $title = trans('messages.cancel_booking');
                                        $message_text = "Your Booking " . $request->booking_id . " has been cancelled by You.";
                                        $helper = Helper::booking_status_email($bdata->id, $title, $message_text);
                                        if ($helper == 1) {
                                                if ($bdata->user_id != null) {
                                                        if ($bdata->payment_type != 1) {
                                                                $wallet = Auth::user()->wallet + $bdata->total_amt;

                                                                User::where('id', Auth::user()->id)->update(['wallet' => $wallet]);

                                                                $transaction = new Transaction;
                                                                $transaction->user_id = $bdata->user_id;
                                                                $transaction->service_id = $bdata->service_id;
                                                                $transaction->provider_id = $bdata->provider_id;
                                                                $transaction->booking_id = $bdata->booking_id;
                                                                $transaction->transaction_id = $bdata->transaction_id;
                                                                $transaction->amount = $bdata->total_amt;
                                                                $transaction->payment_type = 1;
                                                                $transaction->save();
                                                        }
                                                        Helper::cancel_booking_noti(Auth::user()->id, $request->booking_id, $request->canceled_by);
                                                }
                                                $success = Booking::where('booking_id', $request->booking_id)->update(['status' => 4, 'canceled_by' => 2]);
                                                return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
                                        } else {
                                                return response()->json(['status' => 1, 'message' => trans('messages.wrong_while_email')], 200);
                                        }
                                }
                        } else {
                                return 0;
                        }
                } else {
                        return 0;
                }
        }
        public function checkout($service)
        {
                if (isset($_COOKIE["city_id"])) {
                        $servicedata = Service::with('rattings')
                                ->join('categories', 'services.category_id', '=', 'categories.id')
                                ->join('users', 'services.provider_id', '=', 'users.id')
                                ->select(
                                        'services.id as service_id',
                                        'services.name as service_name',
                                        'services.price',
                                        'services.tax',
                                        'services.price_type',
                                        'services.description',
                                        'services.discount',
                                        'services.duration',
                                        'services.slug',
                                        'services.is_top_deals',
                                        'services.image as service_image',
                                        'categories.name as category_name',
                                        'users.name as provider_name',
                                        'users.image as provider_image',
                                )
                                ->where('services.slug', $service)
                                ->where('services.is_available', 1)
                                ->where('services.is_deleted', 2)
                                ->first();
                        Storage::disk('local')->put('service_slug', $service);
                        if ($servicedata->is_top_deals == 1 && @helper::top_deals() != null) {
                                if (@helper::top_deals()->offer_type == 1) {
                                        $sprice = $servicedata->price - @helper::top_deals()->offer_amount;
                                } else {
                                        $sprice = $servicedata->price - $servicedata->price * (@helper::top_deals()->offer_amount / 100);
                                }
                        } else {
                                $sprice = $servicedata->price;
                        }
                        $tax_name = [];
                        $tax_price = [];
                        $taxArr = explode("|", $servicedata->tax);
                        $taxes = [];
                        foreach ($taxArr as $tax) {
                                $taxes[] = Tax::where('id', $tax)->first();
                        }
                        foreach ($taxes as $tax) {
                                if (!empty($tax)) {
                                        if (!in_array($tax->name, $tax_name)) {
                                                $tax_name[] = $tax->name;

                                                if ($tax->type == 1) {
                                                        $price = $tax->tax;
                                                }

                                                if ($tax->type == 2) {
                                                        $price = ($tax->tax / 100) * $sprice;
                                                }
                                                $tax_price[] = $price;
                                        } else {
                                                if ($tax->type == 1) {
                                                        $price = $tax->tax;
                                                }

                                                if ($tax->type == 2) {
                                                        $price = ($tax->tax / 100) * $sprice;
                                                }
                                                $tax_price[array_search($tax->name, $tax_name)] += $price;
                                        }
                                }
                        }

                        $itemtaxArr['tax_name'] = $tax_name;
                        $itemtaxArr['tax'] = $tax_price;
                        $addressdata = BookingAddress::where('user_id', @Auth::user()->id)->orderByDesc('id')->get();
                        $paymethods = PaymentMethods::where('is_available', 1)->where('is_activate', '1')->whereNotIn('payment_type', [1, 2])->orderBy('reorder_id')->get();
                        $walletpaymethods = PaymentMethods::where('is_available', 1)->where('payment_type', 2)->where('is_activate', '1')->orderBy('id')->first();
                } else {
                        $servicedata = "";
                        $itemtaxArr['tax_name'] = "";
                        $itemtaxArr['tax'] = "";
                        $addressdata = "";
                        $paymethods = "";
                        $walletpaymethods = "";
                }
                return view("front.checkout", compact('addressdata', 'servicedata', 'paymethods', 'walletpaymethods', 'itemtaxArr'));
        }

        public function paymentsuccess(Request $request)
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
                                        return redirect('/home/service/continue/checkout/' . Storage::disk('local')->get('service_slug'))->with('error', trans('messages.unable_to_complete_payment'));
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

                return $this->book($request);
        }

        public function paymentfail()
        {
                if (count(request()->all()) > 0) {
                        return redirect('/home/service/continue/checkout/' . Storage::disk('local')->get('service_slug'))->with('error', trans('messages.unable_to_complete_payment'));
                } else {
                        return redirect('/home/service/continue/checkout/' . Storage::disk('local')->get('service_slug'));
                }
        }

        public function success(Request $request)
        {
                $bookingdata = Booking::select('booking_id')->where('booking_id', $request->booking_id)->first();

                if (!empty($bookingdata)) {
                        $whmessage = "";
                        if (SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null && SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1) {
                                if (whatsapp_helper::whatsapp_message_config()->booking_created == 1) {
                                        if (whatsapp_helper::whatsapp_message_config()->message_type == 2) {
                                                $whmessage = whatsapp_helper::whatsappmessage($request->booking_id);
                                        } else {
                                                whatsapp_helper::whatsappmessage($request->booking_id);
                                        }
                                }
                        }
                }
                return view('front.booking_success', compact('whmessage', 'bookingdata'));
        }
}
