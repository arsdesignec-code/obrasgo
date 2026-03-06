<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;

class PaymentMethodsController extends Controller
{
    public function index()
    {
        $paymentmethodsdata = PaymentMethods::where('is_activate', '1')->orderBy('reorder_id')->get();
        return view('payment_methods.index', compact('paymentmethodsdata'));
    }
    public function show($id)
    {
        $paymentmethodsdata = PaymentMethods::where('is_activate', '1')->find($id);
        return view('payment_methods.show', compact('paymentmethodsdata'));
    }
    public function edit(Request $request, $id)
    {
        $pdata = PaymentMethods::find($id);
        if ($pdata->payment_type != 1 && $pdata->payment_type != 2 && $pdata->payment_type != 16) {
            if ($pdata->payment_type == 5) {
                $encryption_key = $request->encryption_key;
            } else {
                $encryption_key = NULL;
            }
            if ($request->image != "") {
                if ($pdata->image && file_exists(storage_path("app/public/images/" . $pdata->image))) {
                    unlink(storage_path("app/public/images/" . $pdata->image));
                }
                $file = $request->image;
                $filename = 'paymentmethod-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/images/', $filename);

                PaymentMethods::where('id', $id)->update(['image' => $filename]);
            }
            PaymentMethods::where('id', $id)->update([
                'environment' => $request->environment,
                'payment_name' => $request->payment_name,
                'currency' => $request->currency,
                'public_key' => $request->public_key,
                'secret_key' => $request->secret_key,
                'encryption_key' => $encryption_key,
            ]);
        } else {
            if ($request->image != "") {
                if ($pdata->image && file_exists(storage_path("app/public/images/" . $pdata->image))) {
                    unlink(storage_path("app/public/images/" . $pdata->image));
                }
                $file = $request->image;
                $filename = 'paymentmethod-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/images/', $filename);

                PaymentMethods::where('id', $id)->update(['image' => $filename]);
            }
            PaymentMethods::where('id', $id)->update([
                'payment_name' => $request->payment_name,
                'payment_description' => $request->payment_description,
            ]);
        }
        return redirect(route('payment-methods'))->with('success', trans('messages.method_updated'));
    }
    public function status(Request $request)
    {
        $success = PaymentMethods::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function reorder(Request $request)
    {
        $getpdata = PaymentMethods::get();
        foreach ($getpdata as $pdata) {
            foreach ($request->order as $order) {
                $pdata = PaymentMethods::where('id', $order['id'])->first();
                $pdata->reorder_id = $order['position'];
                $pdata->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
