<?php

namespace App\Http\Controllers\addons\included;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class CookieController extends Controller
{
    public function cookie(Request $request)
    {
        $settingsdata = Setting::first();
        $settingsdata->cookie_text = $request->cookie_text;
        $settingsdata->cookie_button_text = $request->cookie_button_text;
        $settingsdata->save();

        return redirect()->back()->with('success', trans('messages.success'));
    }
}
