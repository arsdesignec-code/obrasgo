<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\helper;
use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\SystemAddons;
use Illuminate\Http\Request;
use Purifier;
use Illuminate\Support\Facades\Validator;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class InquiryController extends Controller
{
    public function contactus()
    {
        return view('front.contactus');
    }

    public function contactdata()
    {
        $contactdata = Inquiry::orderBy('id', 'DESC')->get();
        return view('contactus.index', compact('contactdata'));
    }
    public function add(Request $request)
    {
        if (
            SystemAddons::where('unique_identifier', 'recaptcha')->first() != null &&
            SystemAddons::where('unique_identifier', 'recaptcha')->first()->activated == 1
        ) {

            if (helper::appdata('')->recaptcha_version == 'v2') {
                $request->validate([
                    'g-recaptcha-response' => 'required'
                ], [
                    'g-recaptcha-response.required' => 'The g-recaptcha-response field is required.'
                ]);
            }

            if (helper::appdata('')->recaptcha_version == 'v3') {
                $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'contact');
                if ($score <= helper::appdata('')->score_threshold) {
                    return redirect()->back()->with('error', 'You are most likely a bot');
                }
            }
        }
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'message' => 'required'
        ], [
            'fname.required' => trans('messages.enter_fname'),
            'lname.required' => trans('messages.enter_lname'),
            'email.required' => trans('messages.enter_email'),
            'email.email' => trans('messages.valid_email'),
            'mobile.required' => trans('messages.enter_mobile'),
            'message.required' => trans('messages.enter_message')
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $message = strip_tags(Purifier::clean($request->message));

            $inquiry = new Inquiry();
            $inquiry->fname = $request->fname;
            $inquiry->lname = $request->lname;
            $inquiry->email = $request->email;
            $inquiry->mobile = $request->mobile;
            $inquiry->message = $message;
            $inquiry->status = 1;

            if ($inquiry->save()) {
                return redirect()->back()->with('success', "Inquiry send successfully");
            } else {
                return redirect()->back()->with('success', trans('messages.wrong'));
            }
        }
    }
    public function status(Request $request)
    {
        $success = Inquiry::where('id', $request->id)->update(['status' => $request->status]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
}
