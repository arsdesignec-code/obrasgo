<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index()
    {
        if (Auth::user()->type == 1) {
            $requests = Payout::join('bank', 'payout.provider_id', 'bank.provider_id')->orderByDesc('payout.status')->orderByDesc('payout.created_at')->get();
        } elseif (Auth::user()->type == 2) {
            $requests = Payout::join('bank', 'payout.provider_id', 'bank.provider_id')->where('payout.provider_id', Auth::user()->id)->orderByDesc('payout.status')->orderByDesc('payout.created_at')->get();
        }

        return view('payout.index', compact('requests'));
    }
    public function create_request(Request $request)
    {
        $get = User::join('provider_types', 'users.provider_type', 'provider_types.id')->select('provider_types.commission')->where('users.id', Auth::user()->id)->first();

        $commission = $get->commission;
        $balance = $request->balance;
        $commission_amt = $balance * $commission / 100;
        $payable_amt = $balance - $commission_amt;

        $request_id = substr(str_shuffle('ABCDFGHIJKLMNOPQRSTVWXYZ1234567890abcdeghijklmnopqrstuvwyz'), 0, 8);

        $pay = new Payout();
        $pay->request_id = $request_id;
        $pay->request_balance = $balance;
        $pay->request_date = Date('Y-m-d');
        $pay->commission = $commission;
        $pay->commission_amt = $commission_amt;
        $pay->payable_amt = $payable_amt;
        $pay->provider_id = Auth::user()->id;
        $pay->provider_name = Auth::user()->name;
        $pay->save();

        $tr = new Transaction();
        $tr->provider_id = Auth::user()->id;
        $tr->booking_id = $request_id;
        $tr->amount = $payable_amt;
        $tr->payment_type = 8; // 8=Withdraw Request
        $tr->save();

        return redirect()->back()->with('success', trans('messages.success'));
    }

    public function update_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_id' => 'required',
            'payment_method' => 'required',
        ], [
            'request_id.required' => trans('messages.enter_request_id'),
            'payment_method.required' => trans('messages.select_payment_type')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            Payout::where('request_id', $request->request_id)->update(['status' => 1, 'payout_date' => Date('Y-m-d'), 'payment_method' => $request->payment_method]);
            $payoutdata = Payout::where('request_id', $request->request_id)->first();

            $admindata = User::find(Auth::user()->id);
            $admindata->wallet = Auth::user()->wallet + $payoutdata->commission_amt;
            $admindata->save();

            $providerdata = User::find($payoutdata->provider_id);
            $providerdata->wallet = $providerdata->wallet - $payoutdata->request_balance;
            $providerdata->save();

            $tr = new Transaction();
            $tr->user_id = Auth::user()->id;    // user user_id as admin_id 
            $tr->provider_id = $payoutdata->provider_id;
            $tr->booking_id = $request->request_id;
            $tr->amount = $payoutdata->commission_amt;
            $tr->payment_type = 9;              // 9=Withdraw Request accept/paid
            $tr->save();

            $tra = new Transaction();
            $tra->provider_id = $payoutdata->provider_id;
            $tra->booking_id = $payoutdata->request_id;
            $tra->amount = $payoutdata->payable_amt;
            $tra->payment_type = 9;
            $tra->save();

            return redirect()->back()->with('success', trans('messages.success'));
        }
    }
}
