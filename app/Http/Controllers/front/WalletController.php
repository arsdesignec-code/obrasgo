<?php

namespace App\Http\Controllers\front;

use App\Helpers\helper;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\PaymentMethods;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Response;
use Stripe;

class WalletController extends Controller
{
    public function wallet_add(Request $request)
    {
        if (!empty(Session::get('userdata'))) {
            $userdata = Session::get('userdata');
            $user_id = $userdata['user_id'];
            $payment_type = $userdata['payment_type'];
            $amount = $userdata['total_price'];
            if ($request->paymentId == null) {
                $transaction_id = session()->get('payment_id');
            } else {
                $transaction_id = $request->paymentId;
            }
        } else {
            $user_id = $request->user_id;
            $payment_type = $request->payment_type;
            $amount = $request->total_price;
            $transaction_id = $request->transaction_id;
        }
        if ($payment_type == 4) {

            Stripe\Stripe::setApiKey(helper::stripe_key());
            $payment = Stripe\Charge::create([
                "amount" => $amount * 100,
                "currency" => "USD",
                "source" => $request->stripeToken,
                "description" => "Test payment description.",
            ]);
            $transaction_id = $payment->id;
        }

        $wallet = Auth::user()->wallet + $amount;

        User::where('id', Auth::user()->id)->update(['wallet' => $wallet]);

        $transaction = new Transaction;
        $transaction->user_id = $user_id;
        $transaction->transaction_id = $transaction_id;
        $transaction->amount = $amount;
        $transaction->payment_type = $payment_type;
        $transaction->save();

        session()->forget('payment_type');
        session()->forget('userdata');
        if ($payment_type == 7 || $payment_type == 8 || $payment_type == 9 || $payment_type == 10 || $payment_type == 11 || $payment_type == 12 || $payment_type == 13 || $payment_type == 14 || $payment_type == 15) {
            return redirect('/home/user/wallet/')->with('success', trans('messages.success'));
        }

        return Response::json(['status' => 1, 'message' => $request->input()], 200);
    }
    public function wallet()
    {
        if (isset($_COOKIE["city_id"])) {
            $walletdata = Transaction::select('transactions.*', DB::raw('DATE(transactions.created_at) AS date'))->where('user_id', Auth::user()->id)->orderByDesc('id')->paginate(10)->onEachSide(0);
            $wallettotal = Transaction::select('transactions.*', DB::raw('DATE(transactions.created_at) AS date'))->where('user_id', Auth::user()->id)->orderByDesc('id')->get();
            $paymethods = PaymentMethods::where('is_available', 1)->whereNotIn('payment_type', [1, 2, 16])->where('is_activate', '1')->orderBy('reorder_id')->get();
        } else {
            $walletdata = "";
            $wallettotal = "";
            $paymethods = "";
        }
        return view('front.user.wallet', compact('walletdata', 'paymethods', 'wallettotal'));
    }

    public function addpaymentsuccess(Request $request)
    {
        try {
            if ($request->has('paymentId')) {
                $paymentId = request('paymentId');
                $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
            }
            if ($request->has('payment_id')) {
                $paymentId = request('payment_id');
                $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
            }

            if ($request->has('transaction_id')) {
                $paymentId = request('transaction_id');
                $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
            }

            if (Session::get('payment_type') == "11") {
                $checkstatus = app('App\Http\Controllers\addons\PayTabController')->checkpaymentstatus(Session::get('tran_ref'));
                if ($checkstatus == "A") {
                    $paymentId = Session::get('tran_ref');
                    $response = ['status' => '1', 'msg' => 'paid', 'paymentId' => $paymentId];
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }

            if (Session::get('payment_type') == "12") {
                if ($request->code == "PAYMENT_SUCCESS") {
                    $paymentId = $request->transactionId;
                    $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
                } else {
                    return redirect('/home/user/wallet/')->with('error', trans('messages.unable_to_complete_payment'));
                }
            }

            if (Session::get('payment_type') == "13") {
                $checkstatus = app('App\Http\Controllers\addons\MollieController')->checkpaymentstatus(Session::get('tran_ref'));

                if ($checkstatus == "A") {
                    $paymentId = Session::get('tran_ref');
                    $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }

            if (Session::get('payment_type') == "14") {

                if ($request->status == "Completed") {
                    $paymentId = $request->transaction_id;
                    $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }

            if (Session::get('payment_type') == "15") {
                $checkstatus = app('App\Http\Controllers\addons\XenditController')->checkpaymentstatus(Session::get('tran_ref'));
                if ($checkstatus == "PAID") {
                    $paymentId = session()->get('payment_id');
                    $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }
        } catch (\Exception $e) {
            $response = ['status' => 0, 'msg' => $e->getMessage()];
        }

        $request = new Request($response);

        return $this->wallet_add($request);
    }

    public function addpaymentfail()
    {
        if (count(request()->all()) > 0) {
            return redirect('/home/user/wallet/')->with('error', trans('messages.unable_to_complete_payment'));
        } else {
            return redirect('/home/user/wallet/');
        }
    }
}
