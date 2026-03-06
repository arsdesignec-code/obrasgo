<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\helper;
use App\Helpers\whatsapp_helper;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\SystemAddons;
use App\Models\User;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->type == 1) {
            $bookingdata = Booking::query();

            if (!empty($request->type)) {
                if ($request->type == "processing") {
                    $bookingdata = $bookingdata->whereIn('status', [1, 2]);
                }
                if ($request->type == "completed") {
                    $bookingdata = $bookingdata->where('status', 3);
                }
                if ($request->type == "cancelled") {
                    $bookingdata = $bookingdata->where('status', 4);
                }
            }

            if (!empty($request->provider_id) && !empty($request->startdate) && !empty($request->enddate)) {
                $bookingdata = $bookingdata->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->where('provider_id', $request->provider_id);
                $totalbooking = Booking::whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->where('provider_id', $request->provider_id)->count();
                $totalprocessing = Booking::whereIn('status', [1, 2])->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->where('provider_id', $request->provider_id)->count();
                $totalcompleted = Booking::where('status', 3)->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->where('provider_id', $request->provider_id)->count();
                $totalcancelled = Booking::where('status', 4)->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->where('provider_id', $request->provider_id)->count();
            } else if (!empty($request->startdate) && !empty($request->enddate)) {
                $bookingdata = $bookingdata->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate);
                $totalbooking = Booking::whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->count();
                $totalprocessing = Booking::whereIn('status', [1, 2])->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->count();
                $totalcompleted = Booking::where('status', 3)->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->count();
                $totalcancelled = Booking::where('status', 4)->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->count();
            } else {
                $totalbooking = Booking::count();
                $totalprocessing = Booking::whereIn('status', [1, 2])->count();
                $totalcompleted = Booking::where('status', 3)->count();
                $totalcancelled = Booking::where('status', 4)->count();
            }
            $bookingdata = $bookingdata->orderByDesc('id')->get();
            $getcustomerslist = User::where('type', 2)->where('is_available', 1)->get();
        } elseif (Auth::user()->type == 2) {
            $bookingdata = Booking::where('provider_id', Auth::user()->id);

            if (!empty($request->type)) {
                if ($request->type == "processing") {
                    $bookingdata = $bookingdata->whereIn('status', [1, 2]);
                }
                if ($request->type == "completed") {
                    $bookingdata = $bookingdata->where('status', 3);
                }
                if ($request->type == "cancelled") {
                    $bookingdata = $bookingdata->where('status', 4);
                }
            }

            if (!empty($request->customer_id) && !empty($request->startdate) && !empty($request->enddate)) {
                $bookingdata = $bookingdata->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->where('user_id', $request->customer_id);
                $totalbooking = Booking::where('provider_id', Auth::user()->id)->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->where('user_id', $request->customer_id)->count();
                $totalprocessing = Booking::where('provider_id', Auth::user()->id)->whereIn('status', [1, 2])->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->where('user_id', $request->customer_id)->count();
                $totalcompleted = Booking::where('provider_id', Auth::user()->id)->where('status', 3)->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->where('user_id', $request->customer_id)->count();
                $totalcancelled = Booking::where('provider_id', Auth::user()->id)->where('status', 4)->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->where('user_id', $request->customer_id)->count();
            } else if (!empty($request->startdate) && !empty($request->enddate)) {
                $bookingdata = $bookingdata->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate);
                $totalbooking = Booking::where('provider_id', Auth::user()->id)->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->count();
                $totalprocessing = Booking::where('provider_id', Auth::user()->id)->whereIn('status', [1, 2])->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->count();
                $totalcompleted = Booking::where('provider_id', Auth::user()->id)->where('status', 3)->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->count();
                $totalcancelled = Booking::where('provider_id', Auth::user()->id)->where('status', 4)->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->count();
            } else {
                $totalbooking = Booking::where('provider_id', Auth::user()->id)->count();
                $totalprocessing = Booking::where('provider_id', Auth::user()->id)->whereIn('status', [1, 2])->count();
                $totalcompleted = Booking::where('provider_id', Auth::user()->id)->where('status', 3)->count();
                $totalcancelled = Booking::where('provider_id', Auth::user()->id)->where('status', 4)->count();
            }
            $bookingdata = $bookingdata->orderByDesc('id')->get();
            $getcustomerslist = User::where('type', 4)->where('is_available', 1)->get();
        } elseif (Auth::user()->type == 3) {
            $bookingdata = Booking::where('handyman_id', Auth::user()->id);
            if (!empty($request->type)) {
                if ($request->type == "processing") {
                    $bookingdata = $bookingdata->whereIn('status', [1, 2]);
                }
                if ($request->type == "completed") {
                    $bookingdata = $bookingdata->where('status', 3);
                }
                if ($request->type == "cancelled") {
                    $bookingdata = $bookingdata->where('status', 4);
                }
            }

            if (!empty($request->startdate) && !empty($request->enddate)) {
                $bookingdata = $bookingdata->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate);
                $totalbooking = Booking::where('handyman_id', Auth::user()->id)->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->count();
                $totalprocessing = Booking::where('handyman_id', Auth::user()->id)->whereIn('status', [1, 2])->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->count();
                $totalcompleted = Booking::where('handyman_id', Auth::user()->id)->where('status', 3)->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->count();
                $totalcancelled = Booking::where('handyman_id', Auth::user()->id)->where('status', 4)->whereDate('created_at', '>=', $request->startdate)->whereDate('created_at', '<=', $request->enddate)->count();
            } else {
                $totalbooking = Booking::where('handyman_id', Auth::user()->id)->count();
                $totalprocessing = Booking::where('handyman_id', Auth::user()->id)->whereIn('status', [1, 2])->count();
                $totalcompleted = Booking::where('handyman_id', Auth::user()->id)->where('status', 3)->count();
                $totalcancelled = Booking::where('handyman_id', Auth::user()->id)->where('status', 4)->count();
            }
            $bookingdata = $bookingdata->orderByDesc('id')->get();
            $getcustomerslist = User::where('type', 4)->where('is_available', 1)->get();
        }
        return view('booking.index', compact('bookingdata', 'totalbooking', 'totalprocessing', 'totalcompleted', 'totalcancelled', 'getcustomerslist'));
    }
    public function booking_details($booking)
    {
        $ahandymandata = User::where("provider_id", Auth::user()->id)->where('type', 3)->where('is_available', 1)->get();
        $bookingdata = Booking::join('services', 'bookings.service_id', 'services.id')
            ->join('categories', 'services.category_id', 'categories.id')
            ->join('users', 'bookings.provider_id', 'users.id')
            ->leftJoin('users as handyman', 'bookings.handyman_id', 'handyman.id')
            ->leftJoin('users as customer', 'bookings.user_id', 'customer.id')
            ->select(
                'bookings.id',
                'bookings.booking_id',
                'bookings.service_id',
                'bookings.service_name',
                'bookings.provider_name',
                'bookings.date',
                'bookings.time',
                'bookings.price',
                'bookings.tax',
                'bookings.tax_name',
                'bookings.total_amt',
                'bookings.tips',
                'bookings.discount',
                'bookings.name',
                'bookings.email',
                'bookings.mobile',
                'bookings.address',
                'bookings.note',
                'bookings.status',
                'bookings.screenshot',
                'bookings.canceled_by',
                'bookings.payment_type',
                'bookings.provider_id',
                'categories.name as category_name',
                'services.price_type',
                'services.duration_type',
                'services.duration',
                'services.description',
                'bookings.handyman_accept',
                'bookings.reason',
                'users.name as provider_name',
                'users.slug as provider_slug',
                'users.email as provider_email',
                'users.mobile as provider_mobile',
                'users.image as provider_image',
                'handyman.id as handyman_id',
                'handyman.name as handyman_name',
                'handyman.email as handyman_email',
                'handyman.mobile as handyman_mobile',
                'handyman.image as handyman_image',
                'customer.image as customer_image',
                'bookings.service_image as service_image',
            )
            ->where('bookings.booking_id', $booking)
            ->first();
        return view('booking.booking_details', compact('bookingdata', 'ahandymandata'));
    }
    public function assign_handyman(Request $request)
    {
        $assign = Booking::where('id', $request->id)->update(['handyman_id' => $request->handyman_id, 'handyman_accept' => 1, 'reason' => null, 'status' => 2]);
        if ($assign) {
            $helper = helper::assign_handyman($request->id);
            $title = trans('messages.assign_handyman');
            if ($helper == 1) {
                $checkbooking = Booking::where('id', $request->id)->first();
                if ($checkbooking->user_id != null) {
                    helper::assign_handyman_noti($request->handyman_id, $checkbooking->booking_id);
                }
                if (SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null && SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1) {
                    if (whatsapp_helper::whatsapp_message_config()->status_change == 1) {
                        whatsapp_helper::orderupdatemessage($checkbooking->booking_id, $title);
                    }
                }
            }

            return redirect()->back()->with('success', trans('messages.handyman_assigned'));
        } else {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function accept(Request $request)
    {
        $checkbooking = Booking::where('id', $request->id)->first();
        if ($checkbooking->status == 4) {
            return response()->json(['status' => 0, 'message' => trans('messages.cancelled_by_user')], 200);
        }
        $success = Booking::where('id', $request->id)->update(['status' => $request->status]);
        $title = trans('messages.accept_booking');
        $message_text = 'Your Booking ' . $checkbooking->booking_id . ' has been accepted by Admin';
        if ($success) {
            $helper = helper::booking_status_email($request->id, $title, $message_text);
            if ($helper == 1) {
                if ($checkbooking->user_id != null) {
                    helper::accept_booking_noti($checkbooking->user_id, "", $checkbooking->booking_id);
                }
                if (SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null && SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1) {
                    if (whatsapp_helper::whatsapp_message_config()->status_change == 1) {
                        whatsapp_helper::orderupdatemessage($checkbooking->booking_id, $title);
                    }
                }
                return 1;
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.wrong_while_email')], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
    public function complete(Request $request)
    {
        $otp = rand(100000, 999999);
        $helper = helper::complete_booking($request->id, $otp);
        if ($helper == 1) {
            $success = Booking::where('id', $request->id)->first();
            $success->otp = $otp;
            $success->save();
            if ($success) {
                return response()->json(['status' => 1, 'id' => $request->id, 'booking_status' => $request->status], 200);
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong_while_email')], 200);
        }
    }
    public function booking_verify_otp(Request $request)
    {
        $check = Booking::where('id', $request->cbooking_id)->first();
        $title = trans('messages.complete_booking');

        if (!empty($check)) {
            if ($check->otp == $request->otp) {
                $check->status = $request->cbooking_status;
                $check->payment_status = 2;
                $check->otp = null;
                $check->save();
                if ($check) {
                    $booking = Booking::find($request->cbooking_id);
                    if ($booking->user_id != null) {
                        helper::complete_booking_noti($booking->user_id, $booking->booking_id);
                    }
                    if (SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null && SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1) {
                        if (whatsapp_helper::whatsapp_message_config()->status_change == 1) {
                            whatsapp_helper::orderupdatemessage($check->booking_id, $title);
                        }
                    }
                    $providerdata = User::where('id', $booking->provider_id)->first();
                    $wallet = $providerdata->wallet + $booking->total_amt;
                    User::where('id', $booking->provider_id)->update(['wallet' => $wallet]);
                    return redirect()->back()->with('success', trans('messages.complete_booking_msg'));
                } else {
                    return redirect()->back()->with('error', trans('messages.wrong'));
                }
            } else {
                return redirect()->back()->with('error', trans('messages.invalid_otp'));
            }
        } else {
            return redirect()->back()->with('error', trans('messages.invalid_email'));
        }
    }
    public function cancel(Request $request)
    {
        $checkbooking = Booking::where('id', $request->id)->first();
        if ($checkbooking->status == 4) {
            return response()->json(['status' => 0, 'message' => trans('messages.cancelled_by_user')], 200);
        }
        $checkbooking->status = $request->status;
        $checkbooking->canceled_by = $request->canceled_by;

        if ($checkbooking->user_id != null) {
            if ($checkbooking->payment_type != 1) {
                $walletdata = User::select('wallet')->where('id', $checkbooking->user_id)->first();
                $wallet = $walletdata->wallet + $checkbooking->total_amt;
                User::where('id', $checkbooking->user_id)->update(['wallet' => $wallet]);

                $transaction = new Transaction;
                $transaction->user_id = $checkbooking->user_id;
                $transaction->service_id = $checkbooking->service_id;
                $transaction->provider_id = $checkbooking->provider_id;
                $transaction->booking_id = $checkbooking->booking_id;
                $transaction->transaction_id = $checkbooking->transaction_id;
                $transaction->amount = $checkbooking->total_amt;
                $transaction->payment_type = 1;
                $transaction->save();
            }
        }
        if ($checkbooking->save()) {
            $title = trans('messages.cancel_booking');
            $message_text = 'Your Booking ' . $checkbooking->booking_id . ' has been cancelled by Admin.';
            $helper = helper::booking_status_email($request->id, $title, $message_text);
            if ($helper == 1) {
                if ($checkbooking->user_id != null) {
                    $checkbooking = Booking::where('id', $request->id)->first();
                    helper::cancel_booking_noti($checkbooking->user_id, $checkbooking->booking_id, $request->canceled_by);
                }
                if (SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null && SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1) {
                    if (whatsapp_helper::whatsapp_message_config()->status_change == 1) {
                        whatsapp_helper::orderupdatemessage($checkbooking->booking_id, $title);
                    }
                }
                return 1;
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.wrong_while_email')], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
    public function cancel_by_handyman(Request $request)
    {
        $checkbooking = Booking::where('id', $request->id)->first();
        $checkbooking->handyman_accept = 2;
        $checkbooking->handyman_id = null;
        if ($checkbooking->save()) {
            $action = "reject";
            helper::handyman_booking_action_noti($checkbooking->provider_id, $checkbooking->booking_id, $action);
            return 1;
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }

    public function generatepdf($booking)
    {
        $bookingdata = Booking::join('services', 'bookings.service_id', 'services.id')
            ->join('users', 'bookings.provider_id', 'users.id')
            ->leftJoin('users as handyman', 'bookings.handyman_id', 'handyman.id')
            ->select(
                'bookings.id',
                'bookings.booking_id',
                'bookings.service_id',
                'bookings.service_name',
                'bookings.provider_name',
                'bookings.date',
                'bookings.time',
                'bookings.price',
                'bookings.tax',
                'bookings.tax_name',
                'bookings.total_amt',
                'bookings.tips',
                'bookings.discount',
                'bookings.name',
                'bookings.email',
                'bookings.mobile',
                'bookings.address',
                'bookings.note',
                'bookings.status',
                'bookings.screenshot',
                'bookings.canceled_by',
                'bookings.payment_type',
                'bookings.transaction_id',
                'bookings.provider_id',
                'bookings.created_at',
                'users.name as provider_name',
                'users.slug as provider_slug',
                'services.price_type',
                'services.duration_type',
                'services.duration',
                'services.description',
                'bookings.handyman_accept',
                'bookings.reason',
                'handyman.id as handyman_id',
                'handyman.name as handyman_name',
                'handyman.email as handyman_email',
                'handyman.mobile as handyman_mobile',
                'users.email as provider_email',
                'users.mobile as provider_mobile'
            )
            ->where('bookings.booking_id', $booking)
            ->first();
        // return view('booking.booking_pdf', compact('bookingdata'));
        $pdf = Pdf::loadView('booking.booking_pdf', ['bookingdata' => $bookingdata]);
        return $pdf->download('bookinginvoice.pdf');
    }
}
