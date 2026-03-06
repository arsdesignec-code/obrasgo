<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use App\Models\Booking;
use App\Models\Coupons;
use App\Models\Transaction;
use App\Models\PaymentMethods;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Stripe;
use App\Helpers\helper;
use Purifier;

class BookingController extends Controller
{
   public function paymentmethodlist(Request $request)
   {
      if ($request->user_id == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
      }
      if ($request->type == "booking") {
         $pmdata = PaymentMethods::select('id', 'payment_name', 'payment_type', 'environment', 'public_key', 'secret_key', 'encryption_key', 'currency', 'is_available', DB::raw("CONCAT('" . asset('storage/app/public/images') . "/',image) AS payment_image_url"))->where('is_available', 1)->orderBy('id')->get();
      }
      if ($request->type == "wallet") {
         $pmdata = PaymentMethods::select('id', 'payment_name', 'payment_type', 'environment', 'public_key', 'secret_key', 'encryption_key', 'currency', 'is_available', DB::raw("CONCAT('" . asset('storage/app/public/images') . "/',image) AS payment_image_url"))->where('is_available', 1)->where('payment_type', '!=', '1')->where('payment_type', '!=', '2')->orderBy('id')->get();
      }
      if ($request->type != "booking" && $request->type != "wallet") {
         return response()->json(['status' => 1, 'message' => trans('messages.invalid_request')], 200);
      }
      $total = User::select('wallet')->where('id', $request->user_id)->first();
      if (!empty($pmdata)) {
         return response()->json(['status' => 1, 'message' => trans('messages.success'), 'total_wallet' => $total, 'pmdata' => $pmdata], 200);
      } else {
         return response()->json(['status' => 1, 'message' => trans('messages.not_available')], 200);
      }
   }

   public function checkcouponcode(Request $request)
   {
      if ($request->service_id == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_service_id')], 200);
      }
      $checkservice = Service::where('id', $request->service_id)->where('is_available', 1)->where('is_deleted', 2)->first();
      if (empty($checkservice)) {
         return response()->json(["status" => 0, "message" => trans('messages.invalid_service')], 200);
      }
      if ($request->coupon_code == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_coupon')], 200);
      }
      $checkcoupon = Coupons::where('service_id', $request->service_id)
         ->where('code', $request->coupon_code)
         ->where('is_available', 1)
         ->where('is_deleted', 2)
         ->first();

      if (!empty($checkcoupon)) {
         if ((date('Y-m-d') >= $checkcoupon->start_date) && (date('Y-m-d') <= $checkcoupon->expire_date)) {

            $coupondata = array(
               'coupon_code' => $checkcoupon->code,
               'discount' => $checkcoupon->discount,
               'discount_type' => $checkcoupon->discount_type,
            );
            return response()->json(["status" => 1, "message" => trans('messages.success'), 'coupondata' => $coupondata], 200);
         } else {

            return response()->json(["status" => 0, "message" => trans('messages.coupon_expired')], 200);
         }
      } else {

         return response()->json(["status" => 0, "message" => trans('messages.not_for_this_service')], 200);
      }
   }

   public function bookingdetails(Request $request)
   {
      if ($request->user_id == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
      }
      if ($request->booking_id == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_booking_id')], 200);
      }
      $user = $request->user_id;
      $checkbooking = Booking::where('booking_id', $request->booking_id)->first();
      if (!empty($checkbooking)) {

         $bookingdata = Booking::join('users as providers', function ($query) {
            $query->on('bookings.provider_id', '=', 'providers.id')
               ->where('providers.type', '=', 2);
         })
            ->leftJoin('users as handyman', function ($query) {
               $query->on('bookings.handyman_id', '=', 'handyman.id')
                  ->where('handyman.type', '=', 3);
            })
            ->leftJoin('rattings', function ($query) use ($user) {
               $query->on('rattings.service_id', '=', 'bookings.service_id')
                  ->where('rattings.user_id', '=', $user);
            })->join('payment_methods', 'payment_methods.payment_type', '=', 'bookings.payment_type')
            ->select(
               'bookings.booking_id',
               'bookings.service_id',
               'bookings.service_name',
               'bookings.address as booking_address',
               'bookings.duration as booking_duration',
               'bookings.duration_type',
               'payment_methods.payment_name',
               'bookings.price',
               'bookings.price_type',
               'bookings.coupon_code',
               'bookings.discount',
               'bookings.total_amt as total_amount',
               'bookings.status',
               'bookings.date',
               'bookings.time',
               'bookings.note',
               'bookings.handyman_accept',
               'providers.id as provider_id',
               'providers.name as provider_name',
               'providers.email as provider_email',
               'providers.mobile as provider_mobile',
               'providers.address as provider_address',
               'handyman.name as handyman_name',
               'handyman.email as handyman_email',
               'handyman.mobile as handyman_mobile',
               'handyman.address as handyman_address',
               DB::raw('(case when rattings.service_id is null then 0 else 1 end) as is_rated'),
               DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', bookings.service_image) AS service_image_url"),
               DB::raw("CONCAT('" . asset('storage/app/public/provider') . "/', providers.image) AS provider_image_url"),
               DB::raw("CONCAT('" . asset('storage/app/public/handyman') . "/', handyman.image) AS handyman_image_url")
            )
            ->where('booking_id', $request->booking_id)
            ->first();

         return response()->json(["status" => 1, "message" => trans('messages.success'), 'bookingdata' => $bookingdata], 200);
      } else {
         return response()->json(["status" => 0, "message" => trans('messages.booking_not_exist')], 200);
      }
   }

   public function bookinglist(Request $request)
   {
      if ($request->user_id == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
      }
      $checkuser = User::where('id', $request->user_id)
         ->where(function ($query) {
            $query->where('type', '=', 3)
               ->orWhere('type', '=', 4);
         })
         ->where('is_available', 1)
         ->first();
      if (!empty($checkuser)) {

         $bookingdata = Booking::select('booking_id', 'service_name', 'provider_name', 'payment_type', 'price', 'price_type', 'handyman_accept', 'status', 'canceled_by', 'total_amt as total_amount', 'date', 'time', DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', service_image) AS image_url"))->where('user_id', $request->user_id)->orderByDesc('id')->paginate(10);

         return response()->json(["status" => 1, "message" => trans('messages.success'), 'bookingdata' => $bookingdata], 200);
      } else {
         return response()->json(["status" => 0, "message" => trans('messages.invalid_user')], 200);
      }
   }

   public function cancelbooking(Request $request)
   {
      if ($request->booking_id == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_booking_id')], 200);
      }

      $checkbooking = Booking::where('booking_id', $request->booking_id)->first();

      if (!empty($checkbooking)) {
         if ($checkbooking->status == 4) {

            return response()->json(["status" => 0, "message" => trans('messages.already_canceled')], 200);
         } else {

            $booking_status = 4;
            $user_id = $checkbooking->provider_id;
            $booking_id = $checkbooking->booking_id;
            $cancelled_by = 2; // cancelled by user

            Booking::where('booking_id', $request->booking_id)->update(['status' => $booking_status, 'canceled_by' => $cancelled_by]);

            try {

               $bdata = Booking::where('booking_id', $request->booking_id)->first();

               if ($bdata->payment_type != 1 && $bdata->payment_type != 2) {
                  $userdata = User::where('id', $checkbooking->user_id)->first();
                  $wallet = $userdata->wallet + $bdata->total_amt;

                  $updateuserwallet = User::where('id', $userdata->id)->update(['wallet' => $wallet]);

                  $transaction = new Transaction;
                  $transaction->user_id = $userdata->id;
                  $transaction->service_id = $bdata->service_id;
                  $transaction->provider_id = $bdata->provider_id;
                  $transaction->booking_id = $bdata->booking_id;
                  $transaction->amount = $bdata->total_amt;
                  $transaction->payment_type = 1;
                  $transaction->save();
               }
            } catch (\Exception $e) {
               return response()->json(["status" => 0, "message" => trans('messages.wrong')], 200);
            }

            Helper::cancel_booking_noti($user_id, $booking_id, $cancelled_by);

            return response()->json(["status" => 1, "message" => trans('messages.success')], 200);
         }
      } else {
         return response()->json(["status" => 0, "message" => trans('messages.booking_not_found')], 200);
      }
   }
   public function booking(Request $request)
   {
      $booking_id = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);

      if ($request->user_id == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
      }

      $checkuser = User::where('id', $request->user_id)->where('type', '=', 4)->where('is_available', 1)->first();

      if (empty($checkuser)) {
         return response()->json(["status" => 0, "message" => trans('messages.invalid_user')], 200);
      }

      if ($request->service_id == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_service_id')], 200);
      }
      $checkservice = Service::where('id', $request->service_id)->where('is_available', 1)->where('is_deleted', 2)->first();
      if (empty($checkservice)) {
         return response()->json(["status" => 0, "message" => trans('messages.invalid_service')], 200);
      }
      $checkprovider = User::where('id', $checkservice->provider_id)->where('type', '=', 2)->where('is_available', 1)->first();
      if (empty($checkprovider)) {
         return response()->json(["status" => 0, "message" => trans('messages.invalid_provider')], 200);
      }
      if ($request->date == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_date')], 200);
      }
      if ($request->time == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_time')], 200);
      }
      if ($request->address == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_address')], 200);
      }
      if ($request->payment_type == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_payment_type')], 200);
      }
      if ($request->payment_type != "1" && $request->payment_type != "2" && $request->payment_type != "4") {
         if ($request->transaction_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_transaction_id')], 200);
         }
      }
      if ($request->coupon_code != "") {
         if ($request->discount == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_discount')], 200);
         }
      }
      if ($request->total_amt == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_total_amt')], 200);
      }

      $checkbooking = Booking::where('user_id', $request->user_id)->where('service_id', $request->service_id)->where('provider_id', $checkservice->provider_id)->where('date', $request->date)->first();
      if (!empty($checkbooking)) {
         return response()->json(["status" => 0, "message" => trans('messages.booking_exist')], 200);
      }
      if ($request->payment_type == 2) {
         if ($checkuser->wallet < $request->total_amt) {
            return response()->json(["status" => 0, "message" => trans('messages.low_balance')], 200);
         } else {
            try {
               $wallet = $checkuser->wallet - $request->total_amt;
               User::where('id', $request->user_id)->update(['wallet' => $wallet]);
               $transaction = new Transaction;
               $transaction->user_id = $request->user_id;
               $transaction->service_id = $request->service_id;
               $transaction->provider_id = $checkservice->provider_id;
               $transaction->booking_id = $booking_id;
               $transaction->amount = $request->total_amt;
               $transaction->payment_type = 2;
               $transaction->save();
            } catch (\Exception $e) {
               return response()->json(["status" => 0, "message" => trans('messages.wrong')], 200);
            }
         }
      }
      $transaction_id = $request->transaction_id;
      if ($request->payment_type == 4) {
         if ($request->card_number == "") {
            return response()->json(["status" => 0, "message" => trans('messages.card_number')], 200);
         }
         if ($request->card_exp_month == "") {
            return response()->json(["status" => 0, "message" => trans('messages.card_exp_month')], 200);
         }
         if ($request->card_exp_year == "") {
            return response()->json(["status" => 0, "message" => trans('messages.card_exp_year')], 200);
         }
         if ($request->card_cvc == "") {
            return response()->json(["status" => 0, "message" => trans('messages.card_cvc')], 200);
         }
         try {
            $stripe = new \Stripe\StripeClient(Helper::stripe_key());
            $data = $stripe->tokens->create([
               'card' => [
                  'number' => $request->card_number,
                  'exp_month' => $request->card_exp_month,
                  'exp_year' => $request->card_exp_year,
                  'cvc' => $request->card_cvc,
               ],
            ]);
            $token = $data->id;
            Stripe\Stripe::setApiKey(Helper::stripe_key());
            $payment = Stripe\Charge::create([
               "amount" => $request->total_amt * 100,
               "currency" => "USD",
               "source" => $token,
               "description" => "payment description.",
            ]);
            $transaction_id = $payment->id;
         } catch (Exception $e) {
            return response()->json(['status' => 0, 'message' => trans('messages.unable_to_complete_payment')], 200);
         }
      }

      $address = strip_tags(Purifier::clean($request->address));

      $booking = new Booking();
      $booking->booking_id = $booking_id;
      $booking->service_id = $request->service_id;
      $booking->service_name = $checkservice->name;
      $booking->service_image = $checkservice->image;
      $booking->price = $checkservice->price;
      $booking->price_type = $checkservice->price_type;
      $booking->duration = $checkservice->duration;
      $booking->duration_type = $checkservice->duration_type;
      $booking->provider_id = $checkservice->provider_id;
      $booking->provider_name = $checkprovider->name;
      $booking->date = $request->date;
      $booking->time = $request->time;
      if ($request->coupon_code != "") {
         $booking->coupon_code = $request->coupon_code;
         $booking->discount = $request->discount;
      }
      $booking->user_id = $request->user_id;
      $booking->address = $address;
      if ($request->note != "") {
         $booking->note = $request->note;
      }
      $booking->payment_type = $request->payment_type;
      if ($request->payment_type != "1" && $request->payment_type != "2") {
         $booking->transaction_id = $transaction_id;
      }
      $booking->total_amt = $request->total_amt;
      $booking->status = 1;
      if ($booking->save()) {

         Helper::create_booking_noti($booking->user_id, $booking->provider_id, $booking->booking_id);

         return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
      } else {
         return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
      }
   }
}
