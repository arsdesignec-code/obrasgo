<?php

namespace App\Http\Controllers\addons;

use App\Helpers\helper;
use App\Http\Controllers\Controller;
use App\Models\Currencies;
use App\Models\CurrencySettings;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CurrencyController extends Controller
{
    public function add(Request $request)
    {

        $currencys = Currencies::where('is_available', 1)->get();
        return view('currency_settings.add', compact('currencys'));
    }
    public function store(Request $request)
    {

        $validator = Validator::make(['name' => $request->name], [
            'name' => 'required|unique:currency_settings',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', trans('messages.unique_currency'));
        }
        $currency = new CurrencySettings();
        $currency->code = $request->code;
        $currency->name = $request->name;
        $currency->currency = $request->currency_symbol;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->currency_position = $request->currency_position;
        $currency->currency_space = $request->currency_space;
        $currency->currency_formate = $request->currency_formate;
        $currency->decimal_separator = $request->decimal_separator;
        $currency->is_available = 1;
        $currency->save();
        return redirect('admin/currency-settings/')->with('success', trans('messages.success'));
    }
    public function delete(Request $request)
    {
        try {
            $currency = CurrencySettings::find($request->id);
            $getdefault = Setting::get();

            $setactive = CurrencySettings::where('code', 'usd')->first();
            $setactive->is_available = 1;
            $setactive->update();
            foreach ($getdefault as $default) {
                if ($currency->code == $default->default_currency) {
                    Setting::where('default_currency', $currency->code)->update(array('default_currency' => "usd"));
                }
            }
            $currency->delete();
            return redirect('admin/currency-settings')->with('success', trans('messages.success'))->withCookie(cookie()->forget('code'));
        } catch (\Throwable $th) {
            return redirect('admin/currency-settings')->with('error', trans('messages.wrong'));
        }
    }
    public function bulk_delete(Request $request)
    {
        try {
            foreach ($request->id as $id) {
                $currency = CurrencySettings::find($id);
                $getdefault = Setting::get();

                $setactive = CurrencySettings::where('code', 'usd')->first();
                $setactive->is_available = 1;
                $setactive->update();
                foreach ($getdefault as $default) {
                    if ($currency->code == $default->default_currency) {
                        Setting::where('default_currency', $currency->code)->update(array('default_currency' => "usd"));
                    }
                }
                $currency->delete();
            }
            return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'msg' => trans('messages.wrong')], 200);
        }
    }

    public function changestatus(Request $request)
    {

        if ($request->code == helper::appdata()->default_currency) {
            return redirect()->back()->with('error', trans('messages.remove_default_currency'));
        }
        CurrencySettings::where('code', $request->code)->update(['is_available' => $request->status]);
        return redirect('admin/currency-settings')->with('success', trans('messages.success'));
    }

    public function setdefault(Request $request)
    {

        $settingdata = Setting::first();
        $currency = CurrencySettings::where('code', $request->code)->first();
        if ($currency->is_available == 2) {
            return redirect()->back()->with('error', trans('messages.not_available_currency'));
        } else {
            $settingdata->default_currency = $request->code;
            $settingdata->update();
            session()->put('currency', $currency->currency);
            return redirect()->back()->with('success', trans('messages.success'));
        }
    }



    //-------------------------------------------- Currencies Add Edit Delete Start -----------------------------------------------//

    public function currency_data(Request $request)
    {
        $getcurrency = Currencies::get();
        return view('currency_settings.currencys.index', compact('getcurrency'));
    }
    public function currency_add(Request $request)
    {
        return view('currency_settings.currencys.add');
    }
    public function currency_store(Request $request)
    {
        $validator = Validator::make(['currency' => $request->currency], [
            'currency' => 'required|unique:currencies',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', trans('messages.unique_currency'));
        }

        $currency = new Currencies();
        $currency->currency = $request->currency;
        $slug = Str::slug($request->currency);
        $currency->code = $slug;
        $currency->currency_symbol = $request->currency_symbol;
        $currency->save();
        return redirect('admin/currencys/')->with('success', trans('messages.success'));
    }

    public function currency_edit(Request $request)
    {

        $editcurrency = Currencies::where('id', $request->id)->first();
        return view('currency_settings.currencys.edit', compact("editcurrency"));
    }

    public function currency_update(Request $request, $id)
    {
        try {
            $currency = Currencies::where('id', $id)->first();
            $currency->currency = $request->currency;
            $slug = Str::slug($request->currency);
            $currency->code = $slug;
            $currency->currency_symbol = $request->currency_symbol;
            $currency->update();
            return redirect('admin/currencys')->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect('admin/currencys')->with('error', trans('messages.wrong'));
        }
    }
    public function currency_delete(Request $request)
    {
        try {
            $currency = Currencies::find($request->id);
            $currency->delete();
            return redirect('admin/currencys')->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect('admin/currencys')->with('error', trans('messages.wrong'));
        }
    }
    public function currency_bulk_delete(Request $request)
    {
        try {
            foreach ($request->id as $id) {
                $currency = Currencies::find($id);
                $currency->delete();
            }
           return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'msg' => trans('messages.wrong')], 200);
        }
    }
    public function currencystatus(Request $request)
    {
        $currency = Currencies::where('code', $request->code)->first();
        if ($request->status == 2) {
            if ($request->code == 'usd') {
                $currency->is_available = 1;
            } else {
                $currency->is_available = $request->status;
            }
        }
        if ($request->status == 1) {
            $currency->is_available = $request->status;
        }
        $currency->update();


        return redirect('admin/currencys')->with('success', trans('messages.success'));
    }
    //-------------------------------------------- Currencies Add Edit Delete End -----------------------------------------------//

    public function change(Request $request)
    {
        $currency = CurrencySettings::where('code', $request->currency)->first();
        session()->put('currency', $currency->currency);
        return redirect()->back()->withCookie(cookie('code', $currency->code, 60 * 24 * 365));
    }
}
