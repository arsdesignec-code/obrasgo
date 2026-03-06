<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Booking;
use App\Models\User;
use App\Models\City;
use App\Models\GalleryImages;
use App\Models\ProviderType;
use App\Models\Rattings;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;

class ProviderController extends Controller
{
   public function registerinfo(Request $request)
   {
      $citydata = City::select('id', 'name', DB::raw("CONCAT('" . asset('storage/app/public/city') . "/', image) AS image_url"))
         ->orderBy('name')->where('is_available', 1)->where('is_deleted', 2)->get();
      $providertypedata = ProviderType::select('id', 'name', 'commission')->where('is_available', 1)->where('is_deleted', 2)->orderByDesc('id')->get();
      return response()->json(['status' => 1, 'message' => trans('messages.success'), 'citydata' => $citydata, 'providertypedata' => $providertypedata], 200);
   }
   public function register(Request $request)
   {
      if ($request->name == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_full_name')], 200);
      }
      if ($request->email == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_email')], 200);
      }
      if ($request->mobile == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_mobile')], 200);
      }
      if ($request->password == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_password')], 200);
      }
      if ($request->provider_type == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.select_provider_type')], 200);
      }
      if ($request->city == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_city')], 200);
      }
      if ($request->token == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_token')], 200);
      }
      $checkemail = User::where('email', $request->email)->first();
      $checkmobile = User::where('mobile', $request->mobile)->first();
      if (!empty($checkemail)) {
         return response()->json(['status' => 0, 'message' => trans('messages.email_exist')], 200);
      }
      if (!empty($checkmobile)) {
         return response()->json(['status' => 0, 'message' => trans('messages.mobile_exist')], 200);
      }
      try {
         $otp = rand(100000, 999999);
         $helper = Helper::verificationemail($request->email, $otp);
         if ($helper == 1) {
            $checkslug = User::where('slug', Str::slug($request->name, '-'))->first();
            if ($checkslug != "") {
               $last = User::select('id')->orderByDesc('id')->first();
               $create = $request->name . " " . ($last->id + 1);
               $slug =   Str::slug($create, '-');
            } else {
               $slug = Str::slug($request->name, '-');
            }
            $provider = new User();
            $provider->name = $request->name;
            $provider->email = $request->email;
            $provider->mobile = $request->mobile;
            $provider->password = HASH::make($request->password);
            $provider->image = "default.png";
            $provider->type = 2;
            $provider->login_type = "email";
            $provider->otp = $otp;
            $provider->token = $request->token;
            $provider->city_id = $request->city;
            $provider->provider_type = $request->provider_type;
            $provider->is_verified = 2;
            $provider->is_available = 1;
            $provider->slug = $slug;
            if ($provider->save()) {
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
            $data = User::leftJoin('cities', 'cities.id', 'users.city_id')
               ->select('cities.name as city_name', 'users.*')
               ->where('users.email', $request->email)->first();
            $providerdata = array(
               'id' => $data->id,
               'name' => $data->name,
               'mobile' => $data->mobile,
               'email' => $data->email,
               'login_type' => $data->login_type,
               'about' => strip_tags($data->about),
               'city_name' => $data->city_name,
               'user_type' => $data->type,
               'token' => $data->token,
               'image_url' => Helper::image_path($data->image)
            );
            return response()->json(['status' => 1, 'message' => trans('messages.success'), 'providerdata' => $providerdata], 200);
         } else {
            return response()->json(["status" => 0, "message" => trans('messages.invalid_otp')], 200);
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
      $checkprovider = User::where('email', $request->email)->where('type', '=', 2)->where('is_available', 1)->first();
      if (!empty($checkprovider)) {
         if ($checkprovider->is_available == 1) {
            if ($checkprovider->is_verified == 1) {
               if (Hash::check($request->password, $checkprovider->password)) {
                  $update = User::where('email', $request->email)->update(['token' => $request->token]);
                  $data = User::leftJoin('cities', 'cities.id', 'users.city_id')
                     ->select('cities.name as city_name', 'users.*')
                     ->where('users.email', $request->email)->first();
                  $providerdata = array(
                     'id' => $data->id,
                     'name' => $data->name,
                     'mobile' => $data->mobile,
                     'email' => $data->email,
                     'login_type' => $data->login_type,
                     'about' => strip_tags($data->about),
                     'city_name' => $data->city_name,
                     'user_type' => $data->type,
                     'token' => $data->token,
                     'image_url' => Helper::image_path($data->image)
                  );
                  return response()->json(['status' => 1, 'message' => trans('messages.success'), 'providerdata' => $providerdata], 200);
               } else {
                  return response()->json(['status' => 0, 'message' => trans('messages.email_pass_invalid')], 200);
               }
            } else {
               $otp = rand(100000, 999999);

               $helper = Helper::verificationemail($request->email, $otp);
               if ($helper == 1) {

                  User::where('email', $request->email)->update(['otp' => $otp]);
                  return response()->json(['status' => 2, 'message' => trans('messages.verify_email'), 'otp' => $otp], 200);
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
      $checklogin = User::where('email', $request->email)
         ->where(function ($query) {
            $query->Where('type', '=', 2)
               ->orWhere('type', '=', 3);
         })
         ->where('is_available', 1)
         ->first();
      if (!empty($checklogin)) {
         if ($checklogin->is_available == 1) {
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
            return response()->json(['status' => 0, 'message' => trans('messages.blobk')], 200);
         }
      } else {
         return response()->json(['status' => 0, 'message' => trans('messages.invalid_email')], 200);
      }
   }
   public function dashboard(Request $request)
   {
      if ($request->provider_id == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_provider_id')], 200);
      }
      $appsettings = Setting::select('currency', 'currency_position')->first();
      $total_bookings = Booking::where('provider_id', $request->provider_id)->count();
      $cancel_bookings = Booking::where('provider_id', $request->provider_id)->where('status', 4)->count();
      $total_services = Service::where('provider_id', $request->provider_id)->count();
      $total_handyman = User::where('type', 3)->where('provider_id', $request->provider_id)->count();
      $bookings = Booking::join('services', 'bookings.service_id', 'services.id')
         ->join('categories', 'services.category_id', 'categories.id')
         ->select(
            'bookings.booking_id',
            'bookings.service_id',
            'bookings.service_name',
            'bookings.duration as booking_duration',
            'bookings.duration_type as duration_type',
            'bookings.price',
            'bookings.price_type',
            'categories.name as category_name',
            DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', bookings.service_image) AS image_url")
         )
         ->where('bookings.provider_id', $request->provider_id)->where('bookings.status', 1)
         ->orderByDesc('bookings.created_at')->orderBy('bookings.status')->get();
      return response()->json(["status" => 1, "message" => trans('messages.success'), 'appsettings' => $appsettings, 'total_bookings' => $total_bookings, 'cancel_bookings' => $cancel_bookings, 'total_services' => $total_services, "total_handyman" => $total_handyman, "bookings" => $bookings], 200);
   }
   public function datewisebookings(Request $request)
   {
      if ($request->provider_id == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_provider_id')], 200);
      }
      if ($request->date == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_date')], 200);
      }
      if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $request->date)) {
         $bookings = Booking::join('services', 'bookings.service_id', 'services.id')
            ->join('categories', 'services.category_id', 'categories.id')
            ->select(
               'bookings.booking_id',
               'bookings.service_id',
               'bookings.service_name',
               'bookings.duration as booking_duration',
               'bookings.duration_type as duration_type',
               'bookings.price',
               'bookings.price_type',
               'categories.name as category_name',
               'bookings.status',
               DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', bookings.service_image) AS image_url")
            )
            ->where('bookings.provider_id', $request->provider_id)
            ->where('bookings.date', $request->date)
            ->orderByDesc('bookings.created_at')->orderBy('bookings.status')
            ->get();
         return response()->json(["status" => 1, "message" => trans('messages.success'), "bookings" => $bookings], 200);
      } else {
         return response()->json(["status" => 0, "message" => trans('messages.invalid_date')], 200);
      }
   }
   public function bookingdetails(Request $request)
   {
      if ($request->booking_id == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_booking_id')], 200);
      }
      $checkbooking = Booking::where('booking_id', $request->booking_id)->first();
      if (!empty($checkbooking)) {
         $bookingdata = Booking::join('users as providers', function ($query) {
            $query->on('bookings.provider_id', '=', 'providers.id')
               ->where('providers.type', '=', 2);
         })
            ->leftJoin('users as handyman', function ($query) {
               $query->on('bookings.handyman_id', '=', 'handyman.id')
                  ->where('handyman.type', '=', 3);
            })->join('payment_methods', 'payment_methods.payment_type', '=', 'bookings.payment_type')
            ->select(
               'bookings.*',
               'bookings.booking_id',
               'bookings.service_id',
               'bookings.service_name',
               'bookings.address as booking_address',
               'bookings.duration as booking_duration',
               'bookings.duration_type',
               'bookings.price',
               'bookings.price_type',
               'payment_methods.payment_name',
               'bookings.coupon_code',
               'bookings.discount',
               'bookings.total_amt as total_amount',
               'bookings.status',
               'bookings.date',
               'bookings.time',
               'bookings.note',
               'providers.name as provider_name',
               'providers.email as provider_email',
               'providers.mobile as provider_mobile',
               'providers.address as provider_address',
               'handyman.name as handyman_name',
               'handyman.email as handyman_email',
               'handyman.mobile as handyman_mobile',
               'handyman.address as handyman_address',
               DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', bookings.service_image) AS service_image_url"),
               DB::raw("CONCAT('" . asset('storage/app/public/provider') . "/', providers.image) AS provider_image_url"),
               DB::raw("CONCAT('" . asset('storage/app/public/handyman') . "/', handyman.image) AS handyman_image_url")
            )
            ->where('booking_id', $request->booking_id)
            ->first();

         $handymandata = User::select(
            'id',
            'name',
            'email',
            'mobile',
            DB::raw("CONCAT('" . asset('storage/app/public/handyman') . "/', image) AS image_url")
         )
            ->where('type', 3)
            ->where('provider_id', $bookingdata->provider_id)
            ->where('is_available', 1)
            ->get();

         return response()->json(["status" => 1, "message" => trans('messages.success'), 'bookingdata' => $bookingdata, "handymandata" => $handymandata], 200);
      } else {
         return response()->json(["status" => 0, "message" => trans('messages.booking_not_found')], 200);
      }
   }
   public function bookingaction(Request $request)
   {
      if ($request->booking_id == "") {
         return response()->json(["status" => 0, "message" => trans('messages.enter_booking_id')], 200);
      }
      $checkbooking = Booking::where('booking_id', $request->booking_id)->first();
      if (!empty($checkbooking)) {
         if ($checkbooking->status == 4) {
            return response()->json(["status" => 0, "message" => trans('messages.already_canceled')], 200);
         } else {
            if ($request->type != "accept" && $request->type != "cancel" && $request->type != "complete") {
               return response()->json(["status" => 0, "message" => trans('messages.invalid_request')], 200);
            }
            if ($request->type == "accept") {
               $booking_status = 2;
               if ($request->handyman_id != "") {
                  Booking::where('booking_id', $request->booking_id)->update(['handyman_id' => $request->handyman_id, 'handyman_accept' => 1, 'reason' => null, 'status' => $booking_status]);
               } else {
                  Booking::where('booking_id', $request->booking_id)->update(['status' => $booking_status]);
               }
               Helper::accept_booking_noti($checkbooking->user_id, $request->handyman_id, $checkbooking->booking_id);
            }
            if ($request->type == "complete") {
               Booking::where('booking_id', $request->booking_id)->update(['status' => 3]);
               Helper::complete_booking_noti($checkbooking->user_id, $checkbooking->booking_id, "");
            }
            if ($request->type == "cancel") {
               $status = 4;
               Booking::where('booking_id', $request->booking_id)->update(['status' => 4, 'canceled_by' => 1]);
               try {
                  $bdata = Booking::where('booking_id', $request->booking_id)->first();

                  if ($bdata->payment_type != 1 && $bdata->payment_type != 2) {
                     $userdata = User::where('id', $checkbooking->user_id)->first();
                     $wallet = $userdata->wallet + $bdata->total_amt;
                     User::where('id', $userdata->id)->update(['wallet' => $wallet]);

                     $transaction = new Transaction;
                     $transaction->user_id = $userdata->id;
                     $transaction->service_id = $bdata->service_id;
                     $transaction->provider_id = $bdata->provider_id;
                     $transaction->booking_id = $bdata->booking_id;
                     $transaction->transaction_id = $bdata->transaction_id;
                     $transaction->amount = $bdata->total_amt;
                     $transaction->payment_type = 1;
                     $transaction->save();
                  }
               } catch (\Exception $e) {
                  return response()->json(["status" => 0, "message" => trans('messages.wrong')], 200);
               }
               $cancelled_by = 1; // cancelled by provider
               Helper::cancel_booking_noti($checkbooking->user_id, $checkbooking->booking_id, $cancelled_by);
            }
            return response()->json(["status" => 1, "message" => trans('messages.success')], 200);
         }
      } else {
         return response()->json(["status" => 0, "message" => trans('messages.booking_not_exist')], 200);
      }
   }
   public function services(Request $request)
   {
      if ($request->provider_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_provider_id')], 200);
      }
      $servicedata =  Service::with('api_rattings')
         ->join('categories', 'services.category_id', '=', 'categories.id')
         ->join('users', 'services.provider_id', '=', 'users.id')
         ->select(
            'services.id',
            'services.name as service_name',
            'services.price',
            'services.price_type',
            'services.duration',
            'services.duration_type',
            'categories.name as category_name',
            'services.is_available',
            DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', services.image) AS image_url")
         )
         ->where('services.provider_id', $request->provider_id)
         ->where('users.is_available', 1)
         ->where('services.is_available', 1)
         ->where('services.is_deleted', 2)
         ->paginate(10);
      return response()->json(['status' => 1, 'message' => trans('messages.success'), 'servicedata' => $servicedata], 200);
   }
   public function getprofile(Request $request)
   {
      if ($request->provider_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_provider_id')], 200);
      }
      $checkprovider = User::where('id', $request->provider_id)->where('type', '=', 2)->first();

      if (!empty($checkprovider)) {
         $data = array(
            'id' => $checkprovider->id,
            'name' => $checkprovider->name,
            'mobile' => $checkprovider->mobile,
            'email' => $checkprovider->email,
            'login_type' => $checkprovider->login_type,
            'image_url' => Helper::image_path($checkprovider->image)
         );
         return response()->json(['status' => 1, 'message' => trans('messages.success'), 'providerdata' => $data], 200);
      } else {
         return response()->json(['status' => 0, 'message' => trans('messages.invalid_user')], 200);
      }
   }
   public function bookinghistory(Request $request)
   {
      if ($request->provider_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_provider_id')], 200);
      }
      $checkprovider = User::where('id', $request->provider_id)->where('type', 2)->first();

      if (!empty($checkprovider)) {
         $bookings = Booking::join('services', 'bookings.service_id', 'services.id')
            ->join('categories', 'services.category_id', 'categories.id')
            ->select(
               'bookings.id',
               'bookings.booking_id',
               'bookings.service_id',
               'bookings.service_name',
               'bookings.duration as booking_duration',
               'bookings.duration_type as duration_type',
               'bookings.date',
               'bookings.time',
               'bookings.price',
               'bookings.price_type',
               'bookings.status as booking_status',
               'categories.name as category_name',
               'bookings.payment_type',
               'bookings.handyman_id',
               'bookings.handyman_accept',
               'bookings.reason',
               DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', bookings.service_image) AS image_url")
            )
            ->where('bookings.provider_id', $request->provider_id)
            ->where('bookings.status', '!=', 1)
            ->orderByDesc('bookings.updated_at')
            ->paginate(10);

         return response()->json(["status" => 1, "message" => trans('messages.success'), "bookings" => $bookings], 200);
      } else {
         return response()->json(['status' => 0, 'message' => trans('messages.invalid_user')], 200);
      }
   }
   public function servicedetails(Request $request)
   {
      if ($request->service_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_service_id')], 200);
      }
      if ($request->provider_id == "") {
         return response()->json(['status' => 0, 'message' => trans('messages.enter_provider_id')], 200);
      }
      $checkprovider = User::where('id', $request->provider_id)->where('type', '=', 2)->first();

      $checkservice = Service::where('id', $request->service_id)->where('provider_id', $request->provider_id)->first();
      if (empty($checkservice)) {
         return response()->json(['status' => 0, 'message' => trans('messages.invalid_service')], 200);
      }
      $servicedata = Service::with('api_rattings')
         ->join('categories', 'services.category_id', '=', 'categories.id')
         ->join('users', 'services.provider_id', '=', 'users.id')
         ->select(
            'services.id',
            'services.name as service_name',
            'services.price',
            'services.price_type',
            'services.duration',
            'services.duration_type',
            'services.description',
            'categories.name as category_name',
            'users.name as provider_name',
            'services.provider_id',
            'services.category_id',
            DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', services.image) AS image_url")
         )
         ->where('services.id', $request->service_id)
         ->first();
      if (!empty($servicedata)) {
         $rattingsdata = Rattings::join('users', 'rattings.user_id', '=', 'users.id')
            ->select(
               'rattings.id',
               'rattings.ratting',
               'rattings.comment',
               'users.name as user_name',
               DB::raw("CONCAT('" . asset('storage/app/public/profile') . "/', users.image) AS user_image_url"),
               DB::raw('DATE(rattings.created_at) AS date')
            )
            ->where('rattings.service_id', $request->service_id)
            ->orderByDesc('rattings.id')
            ->get();
         $galleryimages = GalleryImages::select(
            'gallery_images.id',
            DB::raw("CONCAT('" . asset('storage/app/public/service') . "/', gallery_images.image) AS image_url")
         )
            ->where('gallery_images.service_id', $request->service_id)
            ->orderByDesc('gallery_images.id')
            ->get();
      }
      return response()->json(['status' => 1, 'message' => trans('messages.success'), 'servicedata' => $servicedata, 'rattingsdata' => $rattingsdata, 'galleryimages' => $galleryimages], 200);
   }
}
