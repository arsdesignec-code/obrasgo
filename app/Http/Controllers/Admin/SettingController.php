<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\FooterFeatures;
use App\Models\Others;
use App\Models\PaymentMethods;
use App\Models\ServiceCardImage;
use App\Models\Setting;
use App\Models\SocialLinks;
use App\Models\TopDeals;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function show()
    {
        $settingdata = Setting::first();
        $topdealdata = TopDeals::first();
        $footer_fetures = FooterFeatures::get();
        $getsociallinks = SocialLinks::get();
        $otherdata = Others::first();
        $booking = Booking::get();
        $servicecardimage = ServiceCardImage::get();
        $getpayment = PaymentMethods::where('is_available', 1)->where('is_activate', '1')->orderBy('reorder_id')->get();
        return view('setting.show', compact('settingdata', 'topdealdata', 'getsociallinks', 'footer_fetures', 'otherdata', 'booking', 'servicecardimage', 'getpayment'));
    }
    public function footer_features_update(Request $request)
    {
        if (!empty($request->feature_icon)) {
            foreach ($request->feature_icon as $key => $icon) {
                if (!empty($icon) && !empty($request->feature_title[$key]) && !empty($request->feature_sub_title[$key])) {
                    $feature = new Footerfeatures;
                    $feature->icons = $icon;
                    $feature->title = $request->feature_title[$key];
                    $feature->sub_title = $request->feature_sub_title[$key];
                    $feature->save();
                }
            }
        }
        if (!empty($request->edit_icon_key)) {
            foreach ($request->edit_icon_key as $key => $id) {
                $feature = Footerfeatures::find($id);
                $feature->icons = $request->edi_feature_icon[$id];
                $feature->title = $request->edi_feature_title[$id];
                $feature->sub_title = $request->edi_feature_sub_title[$id];
                $feature->save();
            }
        }
        return redirect(route('settings'))->with('success', 'Success');
    }
    public function delete_feature(Request $request)
    {
        $success = Footerfeatures::where('id', $request->id)->first();
        $success->delete();
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }

    public function social_links_update(Request $request)
    {
        if (!empty($request->social_icon)) {
            foreach ($request->social_icon as $key => $icon) {
                if (!empty($icon) && !empty($request->social_link[$key])) {
                    $sociallink = new SocialLinks;
                    $sociallink->icon = $icon;
                    $sociallink->link = $request->social_link[$key];
                    $sociallink->save();
                }
            }
        }
        if (!empty($request->edit_icon_key)) {
            foreach ($request->edit_icon_key as $key => $id) {
                $sociallink = SocialLinks::find($id);
                $sociallink->icon = $request->edi_sociallink_icon[$id];
                $sociallink->link = $request->edi_sociallink_link[$id];
                $sociallink->save();
            }
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }

    public function delete_sociallinks(Request $request)
    {
        $success = SocialLinks::where('id', $request->id)->first();
        $success->delete();
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function service_card_update(Request $request)
    {
        $setting = Setting::first();
        if (empty($setting)) {
            $setting = new Setting();
        }
        $setting->service_card_view = $request->service_card_view;
        $setting->save();
        return redirect(route('settings'))->with('success', 'Success');
    }
    public function edit(Request $request)
    {
        $rec = Setting::first();
        if ($request->basic_info_update == 1) {
            if ($request->file('logo') != "") {
                if (file_exists(storage_path("app/public/images/" . $rec->logo))) {
                    unlink(storage_path("app/public/images/" . $rec->logo));
                }
                $file = $request->file('logo');
                $filename = 'logo-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/images/', $filename);

                Setting::where('id', 1)->update(['logo' => $filename]);
            }
            if ($request->file('dark_logo') != "") {
                if (file_exists(storage_path("app/public/images/" . $rec->dark_logo))) {
                    unlink(storage_path("app/public/images/" . $rec->dark_logo));
                }
                $file = $request->file('dark_logo');
                $filename = 'dark_logo-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/images/', $filename);

                Setting::where('id', 1)->update(['dark_logo' => $filename]);
            }
           
            if ($request->file('favicon') != "") {
                if (file_exists(storage_path("app/public/images/" . $rec->favicon))) {
                    unlink(storage_path("app/public/images/" . $rec->favicon));
                }
                $file = $request->file('favicon');
                $filename = 'favicon-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/images/', $filename);

                Setting::where('id', 1)->update(['favicon' => $filename]);
            }

            $booking = Booking::get();
            if ($booking->count() == 0 && $request->booking_number_start != null && $request->booking_number_start != "") {
                $booking_number = $request->booking_number_start;
            } else {
                $booking_number = $rec->booking_number_start;
            }
            Setting::where('id', 1)
                ->update([
                    'login_required' => $request->login_required == null ? 2 : 1,
                    'is_checkout_login_required' => $request->is_checkout_login_required == null ? 2 : 1,

                    'provider_registration' => $request->provider_registration == null ? 2 : 1,
                    'time_format' => $request->time_format,
                    'date_format' => $request->date_format,
                    // 'firebase_key' => $request->firebase_key,
                    'booking_prefix' => $request->booking_prefix,
                    'booking_number_start' => $booking_number,
                    'referral_amount' => $request->referral_amount,
                    'withdrawable_amount' => $request->withdrawable_amount,
                    'timezone' => $request->timezone,
                    'address' => $request->address,
                    'contact' => $request->contact,
                    'email' => $request->email,
                    'copyright' => $request->copyright,
                    'website_title' => $request->website_title,
                ]);
        }
        if ($request->seo_update == 1) {
            if ($request->file('og_image') != "") {
                if (file_exists(storage_path("app/public/images/" . $rec->og_image))) {
                    unlink(storage_path("app/public/images/" . $rec->og_image));
                }
                $file = $request->file('og_image');
                $filename = 'og-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/images/', $filename);

                Setting::where('id', 1)->update(['og_image' => $filename]);
            }
            Setting::where('id', 1)
                ->update([
                    'meta_title' => $request->meta_title,
                    'meta_description' => $request->meta_description,
                ]);
        }
        return redirect(route('settings'))->with('success', 'Success');
    }

    public function otherdata(Request $request)
    {
        Setting::where('id', 1)->update([
            'payment_process_options' => $request->payment_process_options,
            'booking_note_required' => $request->booking_note_required == null ? 2 : 1
        ]);
        $rec = Others::first();
        if ($request->file('authentication_image') != "") {
            if ($rec->authentication_image && file_exists(storage_path("app/public/images/" . $rec->authentication_image))) {
                unlink(storage_path("app/public/images/" . $rec->authentication_image));
            }
            $file = $request->file('authentication_image');
            $filename = 'authentication_image-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/images/', $filename);

            Others::where('id', 1)->update(['authentication_image' => $filename]);
        }
        if ($request->file('admin_authentication_image') != "") {
            if ($rec->admin_authentication_image && file_exists(storage_path("app/public/images/" . $rec->admin_authentication_image))) {
                unlink(storage_path("app/public/images/" . $rec->admin_authentication_image));
            }
            $file = $request->file('admin_authentication_image');
            $filename = 'authentication_image-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/images/', $filename);

            Others::where('id', 1)->update(['admin_authentication_image' => $filename]);
        }
        if ($request->file('no_data_image') != "") {
            if ($rec->no_data_image && file_exists(storage_path("app/public/images/" . $rec->no_data_image))) {
                unlink(storage_path("app/public/images/" . $rec->no_data_image));
            }
            $file = $request->file('no_data_image');
            $filename = 'no_data_image-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/images/', $filename);

            Others::where('id', 1)->update(['no_data_image' => $filename]);
        }
        if ($request->file('contact_us_image') != "") {
            if ($rec->contact_us_image && file_exists(storage_path("app/public/images/" . $rec->contact_us_image))) {
                unlink(storage_path("app/public/images/" . $rec->contact_us_image));
            }
            $file = $request->file('contact_us_image');
            $filename = 'contact_us_image-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/images/', $filename);

            Others::where('id', 1)->update(['contact_us_image' => $filename]);
        }
        if ($request->file('booking_success_image') != "") {
            if ($rec->booking_success_image && file_exists(storage_path("app/public/images/" . $rec->booking_success_image))) {
                unlink(storage_path("app/public/images/" . $rec->booking_success_image));
            }
            $file = $request->file('booking_success_image');
            $filename = 'booking_success_image-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/images/', $filename);

            Others::where('id', 1)->update(['booking_success_image' => $filename]);
        }
        if ($request->file('refer_earn_image') != "") {
            if ($rec->refer_earn_image && file_exists(storage_path("app/public/images/" . $rec->refer_earn_image))) {
                unlink(storage_path("app/public/images/" . $rec->refer_earn_image));
            }
            $file = $request->file('refer_earn_image');
            $filename = 'refer_earn_image-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/images/', $filename);

            Others::where('id', 1)->update(['refer_earn_image' => $filename]);
        }
        if ($request->file('become_provider_image') != "") {
            if ($rec->become_provider_image && file_exists(storage_path("app/public/images/" . $rec->become_provider_image))) {
                unlink(storage_path("app/public/images/" . $rec->become_provider_image));
            }
            $file = $request->file('become_provider_image');
            $filename = 'become_provider_image-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/images/', $filename);

            Others::where('id', 1)->update(['become_provider_image' => $filename]);
        }
        return redirect(route('settings'))->with('success', 'Success');
    }
    public function themesetting(Request $request)
    {
        if ($request->web_primary_color || $request->web_secondary_color) {
            Others::where('id', 1)->update([
                'web_primary_color' => $request->web_primary_color,
                'web_secondary_color' => $request->web_secondary_color
            ]);
        }
        if ($request->admin_primary_color || $request->admin_secondary_color) {
            Others::where('id', 1)->update([
                'admin_primary_color' => $request->admin_primary_color,
                'admin_secondary_color' => $request->admin_secondary_color,
            ]);
        }
        return redirect(route('settings'))->with('success', 'Success');
    }
    public function safe_secure_store(Request $request)
    {
        $settingsdata = Others::first();
        if (empty($settingsdata)) {
            $settingsdata = new Others();
        }
        if ($request->trusted_badges == 1) {
            // Handle image 1
            if ($request->hasFile('trusted_badge_image_1')) {
                if ($settingsdata->trusted_badge_image_1 != "trusted_badge_image_1.png" && file_exists(storage_path('app/public/images/trusted_badge/' . $settingsdata->trusted_badge_image_1))) {
                    @unlink(storage_path('app/public/images/trusted_badge/' . $settingsdata->trusted_badge_image_1));
                }
                $image1 = $request->file('trusted_badge_image_1');
                $imageName1 = 'trusted_badge-' . uniqid() . '.' . $image1->getClientOriginalExtension();
                $image1->move(storage_path('app/public/images/trusted_badge/'), $imageName1);
                $settingsdata->trusted_badge_image_1 = $imageName1;
            }

            // Handle image 2
            if ($request->hasFile('trusted_badge_image_2')) {
                if ($settingsdata->trusted_badge_image_2 != "trusted_badge_image_2.png" && file_exists(storage_path('app/public/images/trusted_badge/' . $settingsdata->trusted_badge_image_2))) {
                    @unlink(storage_path('app/public/images/trusted_badge/' . $settingsdata->trusted_badge_image_2));
                }
                $image2 = $request->file('trusted_badge_image_2');
                $imageName2 = 'trusted_badge-' . uniqid() . '.' . $image2->getClientOriginalExtension();
                $image2->move(storage_path('app/public/images/trusted_badge/'), $imageName2);
                $settingsdata->trusted_badge_image_2 = $imageName2;
            }

            // Handle image 3
            if ($request->hasFile('trusted_badge_image_3')) {
                if ($settingsdata->trusted_badge_image_3 != "trusted_badge_image_3.png" && file_exists(storage_path('app/public/images/trusted_badge/' . $settingsdata->trusted_badge_image_3))) {
                    @unlink(storage_path('app/public/images/trusted_badge/' . $settingsdata->trusted_badge_image_3));
                }
                $image3 = $request->file('trusted_badge_image_3');
                $imageName3 = 'trusted_badge-' . uniqid() . '.' . $image3->getClientOriginalExtension();
                $image3->move(storage_path('app/public/images/trusted_badge/'), $imageName3);
                $settingsdata->trusted_badge_image_3 = $imageName3;
            }

            // Handle image 4
            if ($request->hasFile('trusted_badge_image_4')) {
                if ($settingsdata->trusted_badge_image_4 != "trusted_badge_image_4.png" && file_exists(storage_path('app/public/images/trusted_badge/' . $settingsdata->trusted_badge_image_4))) {
                    @unlink(storage_path('app/public/images/trusted_badge/' . $settingsdata->trusted_badge_image_4));
                }
                $image4 = $request->file('trusted_badge_image_4');
                $imageName4 = 'trusted_badge-' . uniqid() . '.' . $image4->getClientOriginalExtension();
                $image4->move(storage_path('app/public/images/trusted_badge/'), $imageName4);
                $settingsdata->trusted_badge_image_4 = $imageName4;
            }
        }
        if ($request->safe_secure == 1) {
            $settingsdata->safe_secure_checkout_payment_selection = $request->safe_secure_checkout_payment_selection == null ? null : implode(',', $request->safe_secure_checkout_payment_selection);
            $settingsdata->safe_secure_checkout_text = $request->safe_secure_checkout_text;
            $settingsdata->safe_secure_checkout_text_color = $request->safe_secure_checkout_text_color;
        }
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function tips_update_settings(Request $request)
    {
        $settingsdata = Others::first();
        if (empty($settingsdata)) {
            $settingsdata = new Others();
        }
        $settingsdata->tips_settings = isset($request->tips_settings) ? 1 : 2;
        $settingsdata->save();
        return redirect(route('settings'))->with('success', 'Success');
    }

    public function recent_view_service_update(Request $request)
    {

        $settingsdata = Others::first();
        if (empty($settingsdata)) {
            $settingsdata = new Others();
        }
        $settingsdata->recent_view_service_on_off = isset($request->recent_view_service_on_off) ? 1 : 2;
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function maintenance_update(Request $request)
    {

        $settingsdata = Others::first();
        if (empty($settingsdata)) {
            $settingsdata = new Others();
        }
        $settingsdata->maintenance_title = $request->maintenance_title;
        $settingsdata->maintenance_description = $request->maintenance_description;
        $settingsdata->maintenance_on_off = isset($request->maintenance_on_off) ? 1 : 2;

        if ($request->hasFile('maintenance_image')) {
            if ($settingsdata->maintenance_image  && file_exists(storage_path('app/public/admin-assets/images/index/' . $settingsdata->maintenance_image))) {
                @unlink(storage_path('app/public/admin-assets/images/index/' . $settingsdata->maintenance_image));
            }
            $image3 = $request->file('maintenance_image');
            $imageName3 = 'maintenance_image-' . uniqid() . '.' . $image3->getClientOriginalExtension();
            $image3->move(storage_path('app/public/admin-assets/images/index/'), $imageName3);
            $settingsdata->maintenance_image = $imageName3;
        }
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function notice_update(Request $request)
    {

        $settingsdata = Others::first();
        if (empty($settingsdata)) {
            $settingsdata = new Others();
        }
        $settingsdata->notice_title = $request->notice_title;
        $settingsdata->notice_description = $request->notice_description;
        $settingsdata->notice_on_off = isset($request->notice_on_off) ? 1 : 2;

        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
}
