<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\Setting;
use App\Models\User;
use App\Models\Payout;
use App\Models\Category;
use App\Models\City;
use App\Models\Help;
use App\Models\PaymentMethods;
use App\Models\Booking;
use App\Models\Bank;
use App\Models\Languages;
use App\Models\CurrencySettings;
use Illuminate\Support\Facades\Cookie;
use App\Models\Coupons;
use App\Models\Others;
use App\Models\Rattings;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Str;
use App;
use App\Models\SystemAddons;
use App\Models\TopDeals;
use App\Models\AgeVerification;
use App\Models\SocialLinks;
use App\Models\TelegramMessage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class helper
{
    public static function push_notification($title, $token, $body)
    {
        $google_api_key = Helper::appdata()->firebase_key;
        $msg = array(
            'body'  => $body,
            'title' => $title,
            'sound' => 1/*Default sound*/
        );
        $fields = array(
            'to'            => $token,
            'notification'  => $msg
        );
        $headers = array(
            'Authorization: key=' . $google_api_key,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /*========================= All Mail Start =========================*/

    public static function forgotpassword($email, $name, $password)
    {
        $var = ["{user}", "{email}", "{password}"];
        $newvar = [$name, $email, $password];
        $forpasswordmessage = str_replace($var, $newvar, nl2br(helper::appdata()->forget_password_email_message));
        $data = [
            'title' => trans('messages.password_reset'),
            'email' => $email,
            'forpasswordmessage' => $forpasswordmessage,
        ];
        try {
            $emaildata = Helper::emailconfigration(1);
            Config::set('mail', $emaildata);

            Mail::send('Email.email', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 1;
        }
    }
    public static function send_mail_delete_account($user)
    {
        $var = ["{username}"];
        $newvar = [$user->name];
        $userdeletemessage = str_replace($var, $newvar, nl2br(helper::appdata()->delete_account_email_message));
        $data = ['title' => trans('labels.account_deleted'), 'userdeletemessage' => $userdeletemessage, 'email' => $user->email];
        try {
            $emaildata = Helper::emailconfigration(1);
            Config::set('mail', $emaildata);

            Mail::send('Email.accountdeleted', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function referral($email, $referralmessage)
    {
        $data = [
            'title' => trans('labels.referral_earning'),
            'email' => $email,
            'referralmessage' => $referralmessage
        ];
        try {
            $emaildata = Helper::emailconfigration(1);
            Config::set('mail', $emaildata);

            Mail::send('Email.referral', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            dd($th);
            return 0;
        }
    }
    public static function create_booking($bid)
    {
        $bookingdata = Booking::where('booking_id', $bid)->first();
        $userdata = User::where('id', 1)->first();
        $title = trans('messages.create_booking');
        $app_name = trans('labels.app_name');

        $trackurl = URL::to('/home/user/bookings/' . $bookingdata->booking_id);

        $bookinginvoicevar = ["{customername}", "{booking_id}", "{booking_date}", "{booking_time}", "{grandtotal}", "{track_order_url}", "{adminname}"];
        $bookinginvoicenewvar = [$bookingdata->name, $bookingdata->booking_id, helper::date_format($bookingdata->date), $bookingdata->time, helper::currency_format($bookingdata->total_amt), $trackurl, $userdata->name];
        $newbookinginvoicemessage = str_replace($bookinginvoicevar, $bookinginvoicenewvar, nl2br(helper::appdata()->new_booking_invoice_email_message));
        $data = [
            'title' => $title,
            'app_name' => $app_name,
            'email' => $bookingdata->email,
            'newbookinginvoicemessage' => $newbookinginvoicemessage,
        ];
        try {

            $emaildata = Helper::emailconfigration(1);
            Config::set('mail', $emaildata);

            Mail::send('Email.create_booking', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 1;
        }
    }
    public static function booking_status_email($bid, $title, $message_text)
    {
        $bookingdata = Booking::where('id', $bid)->first();
        $app_name = trans('labels.app_name');

        $var = ["{customername}", "{status_message}"];
        $newvar = [$bookingdata->name, $message_text];
        $bookingstatusmessage = str_replace($var, $newvar, nl2br(helper::appdata()->booking_status_email_message));
        $data = [
            'title' => $title,
            'app_name' => $app_name,
            'email' => $bookingdata->email,
            'bookingstatusmessage' => $bookingstatusmessage,
        ];
        try {
            $emaildata = Helper::emailconfigration(1);
            Config::set('mail', $emaildata);

            Mail::send('Email.booking_status', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 1;
        }
    }
    public static function assign_handyman($bid)
    {
        $bookingdata = Booking::where('id', $bid)->first();
        $handymandata = User::where('id', $bookingdata->handyman_id)->first();
        $title = trans('messages.assign_handyman');
        $app_name = trans('labels.app_name');
        $handymanassignvar = ["{customername}", "{booking_id}", "{booking_date}", "{booking_time}", "{handyman_name}", "{handyman_email}", "{handyman_mobile}"];
        $handymanassignnewvar = [$bookingdata->name, $bookingdata->booking_id, helper::date_format($bookingdata->date), $bookingdata->time, $handymandata->name, $handymandata->email, $handymandata->mobile];
        $newhandymanassignmessage = str_replace($handymanassignvar, $handymanassignnewvar, nl2br(helper::appdata()->assign_handyman_email_message));
        $data = [
            'title' => $title,
            'app_name' => $app_name,
            'email' => $bookingdata->email,
            'newhandymanassignmessage' => $newhandymanassignmessage,
        ];
        try {
            $emaildata = Helper::emailconfigration(1);
            Config::set('mail', $emaildata);

            Mail::send('Email.assign_handyman', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 1;
        }
    }
    public static function complete_booking($bid, $otp)
    {
        $bookingdata = Booking::where('id', $bid)->first();
        $title = trans('messages.complete_booking');
        $app_name = trans('labels.app_name');

        $var = ["{customername}", "{booking_id}", "{otp}"];
        $newvar = [$bookingdata->name, $bookingdata->booking_id, $otp];
        $bookingstatusmessage = str_replace($var, $newvar, nl2br(helper::appdata()->booking_completed_email_message));
        $data = [
            'otp' => $otp,
            'title' => $title,
            'app_name' => $app_name,
            'email' => $bookingdata->email,
            'bookingstatusmessage' => $bookingstatusmessage,
        ];
        try {
            $emaildata = Helper::emailconfigration(1);
            Config::set('mail', $emaildata);

            Mail::send('Email.complete_booking', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 1;
        }
    }
    /*========================= All Mail End =========================*/

    // Booking notification
    public static function create_booking_noti($user_id, $provider_id, $booking_id)
    {
        $title = "Booking Created";
        $message = "Booking " . $booking_id . " has been created";

        // for user
        $user_noti = new Notification();
        $user_noti->user_id = $user_id;
        $user_noti->title = $title;
        $user_noti->message = $message;
        $user_noti->booking_id = $booking_id;
        $user_noti->booking_status = 1;
        $user_noti->is_read = 2;
        $user_noti->save();

        // for provider
        $noti = new Notification();
        $noti->user_id = $provider_id;
        $noti->title = $title;
        $noti->message = $message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 1;
        $noti->is_read = 2;
        $noti->save();

        $checkuser = User::find($user_id);
        Helper::push_notification($title, $checkuser->token, $message);
        $checkprovider = User::find($provider_id);
        Helper::push_notification($title, $checkprovider->token, $message);
    }
    public static function accept_booking_noti($user_id, $handyman_id, $booking_id)
    {
        $user_title = "Booking Accepted";
        $user_message = "Booking " . $booking_id . " has been accepted.";
        $checkuser = User::find($user_id);
        Helper::push_notification($user_title, $checkuser->token, $user_message);

        $noti = new Notification();
        $noti->user_id = $user_id;
        $noti->title = $user_title;
        $noti->message = $user_message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 2;
        $noti->is_read = 2;
        $noti->save();
        if ($handyman_id != "") {
            // common created for API side-accept booking by provider from ServiceProvider:providerApp

            $checkhandyman = User::find($handyman_id);
            $title = "Booking Assigned";

            // for user
            $user_message = "Booking " . $booking_id . " has been assigned to handyman.";
            Helper::push_notification($title, $checkuser->token, $user_message);

            // for handyman
            $handyman_message = "Booking " . $booking_id . " has been assigned to you.";
            Helper::push_notification($title, $checkhandyman->token, $handyman_message);

            $noti = new Notification();
            $noti->user_id = $handyman_id;
            $noti->title = $title;
            $noti->message = $handyman_message;
            $noti->booking_id = $booking_id;
            $noti->booking_status = 2;
            $noti->is_read = 2;
            $noti->save();
        }
    }
    public static function assign_handyman_noti($handyman_id, $booking_id)
    {
        $checkbooking = Booking::where('booking_id', $booking_id)->first();

        $checkuser = User::find($checkbooking->user_id);
        $checkhandyman = User::find($handyman_id);
        $title = "Booking Assigned";

        // for user
        $user_message = "Booking " . $booking_id . " has been assigned to handyman.";
        Helper::push_notification($title, $checkuser->token, $user_message);

        // for handyman
        $handyman_message = "Booking " . $booking_id . " has been assigned to you.";
        Helper::push_notification($title, $checkhandyman->token, $handyman_message);

        $noti = new Notification();
        $noti->user_id = $handyman_id;
        $noti->title = $title;
        $noti->message = $handyman_message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 2;
        $noti->is_read = 2;
        $noti->save();
    }
    public static function complete_booking_noti($user_id, $booking_id)
    {
        $checkbooking = Booking::where('booking_id', $booking_id)->first();
        $checkprovider = User::find($checkbooking->provider_id);

        $checkuser = User::find($user_id);
        $title = "Booking Competed";
        $message = "Booking " . $booking_id . " has been completed";

        if ($checkbooking->handyman_id != "") {
            $checkhandyman = User::find($checkbooking->handyman_id);
            Helper::push_notification($title, $checkhandyman->token, $message);
        }
        Helper::push_notification($title, $checkuser->token, $message);
        Helper::push_notification($title, $checkprovider->token, $message);

        $noti = new Notification();
        $noti->user_id = $user_id;
        $noti->title = $title;
        $noti->message = $message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 3;
        $noti->is_read = 2;
        $noti->save();
    }
    public static function cancel_booking_noti($user_id, $booking_id, $cancelled_by)
    {
        $title = "Booking Canceled";
        $message = "Booking " . $booking_id . " has been cancelled";

        $noti = new Notification();
        $noti->user_id = $user_id;
        $noti->title = $title;
        $noti->message = $message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 4;
        $noti->canceled_by = $cancelled_by;
        $noti->is_read = 2;
        $noti->save();

        $checkuser = User::find($user_id);
        Helper::push_notification($title, $checkuser->token, $message);

        $checkbooking = Booking::where('booking_id', $booking_id)->first();
        $checkprovider = User::find($checkbooking->provider_id);
        Helper::push_notification($title, $checkprovider->token, $message);
    }
    public static function handyman_booking_action_noti($provider_id, $booking_id, $action)
    {
        $title = "";
        $message = "";
        if ($action == "accept") {
            $title = "Booking Accepted";
            $message = "Booking " . $booking_id . " has been accepted by handyman";
        }
        if ($action == "reject") {
            $title = "Booking Rejected";
            $message = "Booking " . $booking_id . " has been rejected by handyman";
        }
        $noti = new Notification();
        $noti->user_id = $provider_id;
        $noti->title = $title;
        $noti->message = $message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 2;
        $noti->is_read = 2;
        $noti->save();

        $checkprovider = User::find($provider_id);
        Helper::push_notification($title, $checkprovider->token, $message);
    }

    // Other
    public static function date_format($date)
    {
        $date = date(helper::appdata()->date_format, strtotime($date));
        return $date;
    }

    public static function time_format($time)
    {
        if (helper::appdata()->time_format == 1) {
            return $time->format('H:i');
        } else {
            return $time->format('h:i A');
        }
    }

    public static function currency_format($price)
    {
        $price = floatval($price) * helper::currencyinfo()->exchange_rate;
        if (@helper::currencyinfo()->currency_position == "1") {
            if (@helper::currencyinfo()->decimal_separator == "1") {
                if (@helper::currencyinfo()->currency_space == "1") {
                    return @helper::currencyinfo()->currency . ' ' . number_format($price, @helper::currencyinfo()->currency_formate, '.', ',');
                } else {
                    return @helper::currencyinfo()->currency . number_format($price, @helper::currencyinfo()->currency_formate, '.', ',');
                }
            } else {
                if (@helper::currencyinfo()->currency_space == "1") {
                    return @helper::currencyinfo()->currency . ' ' . number_format($price, @helper::currencyinfo()->currency_formate, ',', '.');
                } else {
                    return @helper::currencyinfo()->currency . number_format($price, @helper::currencyinfo()->currency_formate, ',', '.');
                }
            }
        }
        if (@helper::currencyinfo()->currency_position == "2") {
            if (@helper::currencyinfo()->decimal_separator == "1") {
                if (@helper::currencyinfo()->currency_space == "1") {
                    return number_format($price, @helper::currencyinfo()->currency_formate, '.', ',') . ' ' . @helper::currencyinfo()->currency;
                } else {
                    return number_format($price, @helper::currencyinfo()->currency_formate, '.', ',') . @helper::currencyinfo()->currency;
                }
            } else {
                if (@helper::currencyinfo()->currency_space == "1") {
                    return number_format($price, @helper::currencyinfo()->currency_formate, ',', '.') . ' ' . @helper::currencyinfo()->currency;
                } else {
                    return number_format($price, @helper::currencyinfo()->currency_formate, ',', '.') . @helper::currencyinfo()->currency;
                }
            }
        }
    }
    public static function offers()
    {
        $offers = Coupons::where('is_available', 1)->where('is_deleted', 2)->where('start_date', '<=', Carbon::now()->format('Y-m-d'))->where('expire_date', '>=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->get();
        return $offers;
    }
    public static function stripe_key()
    {
        $pmdata = PaymentMethods::select('public_key', 'secret_key', 'currency')->where('payment_type', '=', '4')->where('is_available', 1)->where('is_activate', '1')->first();
        return $pmdata->secret_key;
    }
    public static function wallet()
    {
        $walletdata = User::select('wallet')->where('id', @Auth::user()->id)->first();
        return @$walletdata->wallet;
    }
    public static function providerdata($provider_id)
    {
        $providerdata = User::where('id', $provider_id)->first();
        return $providerdata;
    }
    public static function payout_request()
    {
        $payout = Payout::where('provider_id', Auth::user()->id)->where('status', 2)->count();
        return $payout;
    }
    public static function appdata()
    {
        $appdata = Setting::first();
        return $appdata;
    }
    public static function otherdata()
    {
        $otherdata = Others::first();
        return $otherdata;
    }
    public static function categories()
    {
        $categories = Category::select('id', 'name', 'slug')->where('is_available', 1)->where('is_deleted', 2)->orderBy('reorder_id')->take(5)->get();
        return $categories;
    }
    public static function cities()
    {
        $citydata = City::select('cities.id', 'cities.name', 'cities.image')
            ->where('is_available', 1)
            ->where('is_deleted', 2)
            ->orderBy('reorder_id')
            ->get();
        return $citydata;
    }
    public static function getcityname()
    {
        if (isset($_COOKIE["city_id"])) {
            $citydata = City::select('cities.id', 'cities.name', 'cities.image')
                ->where('id', $_COOKIE['city_id'])
                ->first();
            return $citydata->name;
        }
    }
    public static function paymentmethods()
    {
        $paymethods = PaymentMethods::where('is_available', 1)->where('is_activate', '1')->orderBy('reorder_id')->get();
        return $paymethods;
    }
    public static function check_bank()
    {
        if (Auth::user()->type == 2) {
            $check_bank = Bank::where('provider_id', Auth::user()->id)->count();
            return $check_bank;
        } else {
            return 1;
        }
    }
    public static function booking()
    {
        if (Auth::user()->type == 3) {
            $booking = Booking::where('status', 2)->where('handyman_id', Auth::user()->id)->count();
        } else {
            $booking = Booking::where('status', 1)
                ->where(function ($query) {
                    $query->Where('provider_id', '=', Auth::user()->id)
                        ->orWhere('user_id', '=', Auth::user()->id);
                })->count();
        }
        return $booking;
    }
    public static function notification()
    {
        $notification = Notification::where('user_id', @Auth::user()->id)->where('is_read', 2)->count();
        return $notification;
    }
    public static function help()
    {
        $help = Help::where('status', 2)->count();
        return $help;
    }
    public static function getaverageratting($service_id)
    {
        $serviceaverageratting = Rattings::where('service_id', $service_id)
            ->selectRaw('SUM(ratting)/COUNT(user_id) AS avg_ratting')->where('status', 1)->first();
        return number_format($serviceaverageratting->avg_ratting, 1);
    }
    public static function image_path($image)
    {
        $path = asset('storage/app/public/images/item-placeholder.png');

        if (Str::contains($image, 'category')) {
            if (file_exists(storage_path('app/public/category/' . $image))) {
                $path = asset('storage/app/public/category/' . $image);
            }
        }
        if (Str::contains($image, 'city')) {
            if (file_exists(storage_path('app/public/city/' . $image))) {
                $path = asset('storage/app/public/city/' . $image);
            }
        }
        if (Str::contains($image, 'provider')) {
            if (file_exists(storage_path('app/public/provider/' . $image))) {
                $path = asset('storage/app/public/provider/' . $image);
            }
        }
        if (Str::contains($image, 'handyman')) {
            if (file_exists(storage_path('app/public/handyman/' . $image))) {
                $path = asset('storage/app/public/handyman/' . $image);
            }
        }
        if (Str::contains($image, 'service') || Str::contains($image, 'gallery')) {
            if (file_exists(storage_path('app/public/service/' . $image))) {
                $path = asset('storage/app/public/service/' . $image);
            }
        }
        if (Str::contains($image, 'profile')) {
            if (file_exists(storage_path('app/public/profile/' . $image))) {
                $path = asset('storage/app/public/profile/' . $image);
            }
        }
        if (Str::contains($image, 'banners')) {
            if (file_exists(storage_path('app/public/banner/' . $image))) {
                $path = asset('storage/app/public/banner/' . $image);
            }
        }
        if (Str::contains($image, 'testimonial')) {
            if (file_exists(storage_path('app/public/testimonials/' . $image))) {
                $path = asset('storage/app/public/testimonials/' . $image);
            }
        }
        if (Str::contains($image, 'blog_image')) {
            if (file_exists(storage_path('app/public/blogs/' . $image))) {
                $path = asset('storage/app/public/blogs/' . $image);
            }
        }
        if (Str::contains($image, 'flag')) {
            if (file_exists(storage_path('app/public/language/' . $image))) {
                $path = asset('storage/app/public/language/' . $image);
            }
        }
        if (Str::contains($image, 'quick')) {
            if (file_exists(storage_path('app/public/about/' . $image))) {
                $path = asset('storage/app/public/about/' . $image);
            }
        }
        if (Str::contains($image, 'screenshot')) {
            if (file_exists(storage_path('app/public/screenshot/' . $image))) {
                $path = asset('storage/app/public/screenshot/' . $image);
            }
        }
        if (Str::contains($image, 'cancel') || Str::contains($image, 'confirmed') || Str::contains($image, 'pending') || Str::contains($image, 'wallet1') || Str::contains($image, 'creditcard') || Str::contains($image, 'COD') || Str::contains($image, 'default') || Str::contains($image, 'icon') || Str::contains($image, 'about-') || Str::contains($image, 'logo') || Str::contains($image, 'dark_logo') || Str::contains($image, 'banner-') || Str::contains($image, 'favicon') || Str::contains($image, 'og') || Str::contains($image, 'authentication_image') || Str::contains($image, 'no_data_image') || Str::contains($image, 'contact_us_image') || Str::contains($image, 'booking_success_image') || Str::contains($image, 'refer_earn_image') || Str::contains($image, 'become_provider_image') || Str::contains($image, 'how_it_works_image') || Str::contains($image, 'faq_image') || Str::contains($image, 'app_download') || Str::contains($image, 'paymentmethod') || Str::contains($image, 'brand')) {
            if (file_exists(storage_path('app/public/images/' . $image))) {
                $path = asset('storage/app/public/images/' . $image);
            }
        }
        if (Str::contains($image, 'trusted_badge')) {
            if (file_exists(storage_path('app/public/images/trusted_badge/' . $image))) {
                $path = asset('storage/app/public/images/trusted_badge/' . $image);
            }
        }
        if (Str::contains($image, 'card-image')) {
            if (file_exists(storage_path('app/public/card_image/' . $image))) {
                $path = asset('storage/app/public/card_image/' . $image);
            }
        }
        if (Str::contains($image, 'maintenance')) {
            if (file_exists(storage_path('app/public/admin-assets/images/index/' . $image))) {
                $path = url(env('ASSETSPATHURL') . 'admin-assets/images/index/' . $image);
            }
        }
        return $path;
    }

    public static function getpayment($payment_type)
    {
        $payment = PaymentMethods::select('payment_name')->where('payment_type', $payment_type)->first();
        return $payment->payment_name;
    }
    public static function allpaymentcheckaddons()
    {
        if (request()->is('home/service/continue/checkout/*') || request()->is('home/user/bookings/*')) {
            $getpaymentmethods = PaymentMethods::where('is_available', '1')->where('is_activate', 1)->get();
        } else {
            $getpaymentmethods = PaymentMethods::where('is_available', '1')->where('is_activate', 1)->whereNotIn('payment_type', [16])->get();
        }
        foreach ($getpaymentmethods as $pmdata) {
            $systemAddonActivated = false;
            if (helper::checkaddons($pmdata->unique_identifier)) {
                $systemAddonActivated = true;
                break;
            }
        }
        return $systemAddonActivated;
    }

    public static function language()
    {
        $lang = Languages::where('is_available', '1')->get();
        if (session()->get('locale') == null) {
            $layout = Languages::select('name', 'layout', 'image', 'is_default', 'code')->where('is_default', 1)->first();
            App::setLocale($layout->code);
            session()->put('locale', $layout->code);
            session()->put('language', $layout->name);
            session()->put('flag', $layout->image);
            session()->put('direction', $layout->layout);
        } else {
            $layout = Languages::select('name', 'layout', 'image', 'is_default', 'code')->where('code', session()->get('locale'))->first();
            App::setLocale(session()->get('locale'));
            session()->put('locale', @$layout->code);
            session()->put('language', @$layout->name);
            session()->put('flag', @$layout->image);
            session()->put('direction', @$layout->layout);
        }
        return $lang;
    }

    // dynamic email configration
    public static function emailconfigration($vendor_id)
    {
        $mailsettings = Setting::where('id', $vendor_id)->first();
        $emaildata = [];
        if ($mailsettings) {
            $emaildata = [
                'driver' => $mailsettings->mail_driver,
                'host' => $mailsettings->mail_host,
                'port' => $mailsettings->mail_port,
                'encryption' => $mailsettings->mail_encryption,
                'username' => $mailsettings->mail_username,
                'password' => $mailsettings->mail_password,
                'from'     => [
                    'address' => $mailsettings->mail_fromaddress,
                    'name' => $mailsettings->mail_fromname
                ]
            ];
        }
        return $emaildata;
    }

    public static function top_deals()
    {
        date_default_timezone_set(helper::appdata()->timezone);
        $current_date  = Carbon::now()->format('Y-m-d');
        $current_time  = Carbon::now()->format('H:i:s');
        $topdeal = TopDeals::first();
        $topdeals = null;
        if (SystemAddons::where('unique_identifier', 'top_deals')->first() != null && SystemAddons::where('unique_identifier', 'top_deals')->first()->activated == 1) {
            if (isset($topdeal) && $topdeal->deal_status == 1) {
                $startDate = $topdeal['start_date'];
                $starttime = $topdeal['start_time'];
                $endDate = $topdeal['end_date'];
                $endtime = $topdeal['end_time'];
                // Checking validity of top deal offer
                if ($topdeal->deal_type == 1) {
                    if ($current_date > $startDate) {
                        if ($current_date < $endDate) {
                            $topdeals = TopDeals::first();
                        } elseif ($current_date == $endDate) {
                            if ($current_time < $endtime) {
                                $topdeals = TopDeals::first();
                            }
                        }
                    } elseif ($current_date == $startDate) {
                        if ($current_date < $endDate && $current_time >= $starttime) {
                            $topdeals = TopDeals::first();
                        } elseif ($current_date == $endDate) {
                            if ($current_time >= $starttime && $current_time <= $endtime) {
                                $topdeals = TopDeals::first();
                            }
                        }
                    }
                } else if ($topdeal->deal_type == 2) {
                    if ($current_time >= $starttime && $current_time <= $endtime) {
                        $topdeals = TopDeals::first();
                    }
                }
            }
        }
        return $topdeals;
    }

    public static function checkaddons($addons)
    {
        if (session()->get('demo') == "free-addon") {
            $check = SystemAddons::where('unique_identifier', $addons)->where('activated', 1)->where('type', 1)->first();
        } elseif (session()->get('demo') == "all-addon") {
            $check = SystemAddons::where('unique_identifier', $addons)->where('activated', 1)->whereIn('type', ['1', '2'])->first();
        } else {
            $check = SystemAddons::where('unique_identifier', $addons)->where('activated', 1)->first();
        }

        return $check;
    }

    public static function getagedetails()
    {
        $agedetails = AgeVerification::first();
        return $agedetails;
    }

    public static function getsociallinks()
    {
        $links = SocialLinks::get();
        return $links;
    }
    public static function telegramdata()
    {
        $data = TelegramMessage::first();
        return $data;
    }

    // get currency list vendor side.
    public static function available_currency()
    {
        $listofcurrency = CurrencySettings::where('is_available', '1')->get();
        return $listofcurrency;
    }
    // get language list in athu pages.
    public static function currencyinfo()
    {
        if (Cookie::get('code') == null) {
            $currency = CurrencySettings::where('code', helper::appdata()->default_currency)->first();
            session()->put('currency', $currency->currency);
        } else {
            $currency = CurrencySettings::where('code', Cookie::get('code'))->first();
            if (empty($currency)) {
                $currency = CurrencySettings::where('code', helper::appdata()->default_currency)->first();
            }
            session()->put('currency', $currency->currency);
        }
        return $currency;
    }
}
