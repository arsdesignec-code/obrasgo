<?php

namespace App\Helpers;

use App\Models\Booking;
use App\Models\WhatsappMessage;
use Illuminate\Support\Facades\URL;

class whatsapp_helper
{
    public static function whatsapp_message_config()
    {
        $whatsappp = WhatsappMessage::first();
        return $whatsappp;
    }

    public static function  whatsappmessage($booking_number)
    {
        $getbooking = Booking::where('booking_id', $booking_number)->first();
        if ($getbooking->payment_status == "1") {
            $payment_status = "UnPaid";
        }
        if ($getbooking->payment_status == "2") {
            $payment_status = "Paid";
        }

        $tax = explode("|", $getbooking->tax);
        $tax_name = explode("|", $getbooking->tax_name);

        $tax_data[] = "";
        if ($tax != "") {
            foreach ($tax as $key => $tax_value) {
                @$tax_data[] .=  '👉 ' . $tax_name[$key] . ' : ' . helper::currency_format((float)$tax[$key]);
            }
        }
        $tdata = implode("|", $tax_data);

        $tax_val = str_replace('|', '%0a', $tdata);

        $var = ["{service_name}", "{booking_no}", "{payment_status}", "{tips}", "{sub_total}", "{total_tax}", "{offer_code}", "{discount_amount}", "{grand_total}", "{message}", "{customer_name}", "{customer_mobile}", "{customer_email}", "{address}", "{booking_date}", "{booking_time}", "{payment_type}", "{track_booking_url}", "{website_url}"];
        $newvar   = [urlencode($getbooking->service_name), $getbooking->booking_id, $payment_status, helper::currency_format($getbooking->tips), helper::currency_format($getbooking->price), $tax_val, $getbooking->coupon_code, helper::currency_format($getbooking->discount), helper::currency_format($getbooking->total_amt), $getbooking->note, @$getbooking->name, @$getbooking->mobile, @$getbooking->email, $getbooking->address, helper::date_format($getbooking->date), $getbooking->time, @helper::getpayment($getbooking->payment_type), URL::to('/home/user/bookings/' . $booking_number), URL::to('/')];
        $whmessage = str_replace($var, $newvar, str_replace("\n", "%0a", whatsapp_helper::whatsapp_message_config()->whatsapp_message));
        if (whatsapp_helper::whatsapp_message_config()->message_type == 1) {
            $whmessage = str_replace($var, $newvar, str_replace("\n", "%0a", @whatsapp_helper::whatsapp_message_config()->whatsapp_message));
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v18.0/' . whatsapp_helper::whatsapp_message_config()->whatsapp_phone_number_id . '/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "messaging_product": "whatsapp",
                    "to": "' . $getbooking->mobile . '",
                    "text": {
                        "body" : "' . $whmessage . '"
                    }
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . whatsapp_helper::whatsapp_message_config()->whatsapp_access_token . ''
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
        }

        return $whmessage;
    }

    public static function orderupdatemessage($booking_number, $status)
    {
        try {
            $getbooking = Booking::where('booking_id', $booking_number)->first();

            $var = ["{booking_no}", "{customer_name}", "{track_booking_url}", "{status}"];
            $newvar = [$booking_number, $getbooking->name, URL::to("/home/user/bookings/" . $booking_number), $status];
            $whmessage = str_replace($var, $newvar, str_replace("\r\n", "\\r\\n", @whatsapp_helper::whatsapp_message_config()->status_message));
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v18.0/' . whatsapp_helper::whatsapp_message_config()->whatsapp_phone_number_id . '/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
              "messaging_product": "whatsapp",
              "to": "' . $getbooking->mobile . '",
              "text": {
                  "body" : "' . $whmessage . '"
              }
          }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . whatsapp_helper::whatsapp_message_config()->whatsapp_access_token . ''
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            return $whmessage;
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
