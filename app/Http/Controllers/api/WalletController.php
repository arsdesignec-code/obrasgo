<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\helper;
use Response;
use Stripe;

class WalletController extends Controller
{
    public function wallet_add(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
        }
        $checkuser = User::where('id', $request->user_id)->where('type', 4)->where('is_available', 1)->first();
        if (empty($checkuser)) {
            return response()->json(["status" => 0, "message" => trans('messages.invalid_user')], 200);
        }
        if ($request->amount == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_amount')], 200);
        }
        if ($request->payment_type == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_payment_type')], 200);
        }
        if ($request->amount == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_amount')], 200);
        }

        if ($request->payment_type == 4) {
            if ($request->card_number == "") {
                return response()->json(["status" => 0, "message" => trans('messages.card_number')], 200);
            }
            if ($request->card_exp_month == "") {
                return response()->json(["status" => 0, "message" => trans('messages.card_exp_month')], 200);
            }
            if ($request->card_exp_year == "") {
                return response()->json(["status" => 0, "message" => trans('messages.card_exp_year')], 200);
            }
            if ($request->card_cvc == "") {
                return response()->json(["status" => 0, "message" => trans('messages.card_cvc')], 200);
            }
            try {
                $stripe = new \Stripe\StripeClient(Helper::stripe_key());
                $data = $stripe->tokens->create([
                    'card' => [
                        'number' => $request->card_number,
                        'exp_month' => $request->card_exp_month,
                        'exp_year' => $request->card_exp_year,
                        'cvc' => $request->card_cvc,
                    ],
                ]);
                $token = $data->id;
                Stripe\Stripe::setApiKey(Helper::stripe_key());
                $payment = Stripe\Charge::create([
                    "amount" => $request->amount * 100,
                    "currency" => "USD",
                    "source" => $token,
                    "description" => "payment wallet description.",
                ]);
                $transaction_id = $payment->id;
            } catch (Exception $e) {
                return response()->json(['status' => 0, 'message' => trans('messages.unable_to_complete_payment')], 200);
            }
        } else {
            if ($request->transaction_id == "") {
                return response()->json(["status" => 0, "message" => trans('messages.enter_transaction_id')], 200);
            }
            $transaction_id = $request->transaction_id;
        }

        $wallet = $checkuser->wallet + $request->amount;
        $updatewallet = User::find($request->user_id);
        $updatewallet->wallet = $wallet;
        $updatewallet->save();

        $transaction = new Transaction();
        $transaction->user_id = $request->user_id;
        $transaction->transaction_id = $transaction_id;
        $transaction->amount = $request->amount;
        $transaction->payment_type = $request->payment_type;
        if ($transaction->save()) {
            $total = User::select('wallet')->where('id', $request->user_id)->first();
            return Response::json(['status' => 1, 'message' => trans('messages.success'), 'total_wallet' => $total,], 200);
        } else {
            return Response::json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
    public function wallet(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
        }
        $walletdata = Transaction::select(
            'id',
            'user_id',
            'service_id',
            'provider_id',
            'booking_id',
            'transaction_id',
            'amount',
            'payment_type',
            'username',
            DB::raw('DATE(created_at) AS date')
        )
            ->where('user_id', $request->user_id)
            ->orderByDesc('id')
            ->paginate(10);
        $total_debit = 0;
        $total_credit = 0;
        foreach ($walletdata as $wallet) {
            if ($wallet->payment_type == 2) {
                $total_debit += $wallet->amount;
            } else {
                $total_credit += $wallet->amount;
            }
        }
        return response()->json(["status" => 1, "message" => trans('messages.success'), 'total_credit' => $total_credit, 'total_debit' => $total_debit, 'walletdata' => $walletdata], 200);
    }
}
