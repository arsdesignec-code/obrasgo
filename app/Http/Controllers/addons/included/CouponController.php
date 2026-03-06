<?php

namespace App\Http\Controllers\addons\included;

use App\Http\Controllers\Controller;
use App\Models\Coupons;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $couponsdata = Coupons::join('services', 'coupons.service_id', 'services.id')
            ->select('coupons.*', 'services.name as service_name')
            ->where('coupons.is_deleted', 2)
            ->orderByDesc('coupons.id')
            ->get();
        return view('included.coupon.index', compact('couponsdata'));
    }
    public function add()
    {
        $servicedata = Service::where('is_available', 1)->where('is_deleted', 2)->orderBy('id', 'DESC')->get();
        return view('included.coupon.add', compact('servicedata'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'expire_date' => 'date|after:start_date',
        ], [
            'expire_date.date' => trans('messages.valid_date'),
            'expire_date.after' => trans('messages.after_start_date'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $description = strip_tags(Purifier::clean($request->description));
            $Coupon = new Coupons();
            $Coupon->code = $request->code;
            $Coupon->service_id = $request->service_id;
            $Coupon->discount = $request->discount;
            $Coupon->discount_type = $request->discount_type;
            $Coupon->start_date = $request->start_date;
            $Coupon->expire_date = $request->expire_date;
            $Coupon->title = $request->title;
            $Coupon->description = $description;
            $Coupon->is_available = 1;
            $Coupon->is_deleted = 2;
            $Coupon->save();
            return redirect(route('coupons'))->with('success', trans('messages.coupon_added'));
        }
    }
    public function status(Request $request)
    {
        $success = Coupons::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function destroy(Request $request)
    {
        $rec = Coupons::where('id', $request->id)->update(['is_deleted' => 1]);
        if ($rec) {
            return 1;
        } else {
            return 0;
        }
    }
    public function bulk_delete(Request $request)
    {
        foreach ($request->id as $id) {
            $rec = Coupons::where('id', $id)->update(['is_deleted' => 1]);
        }
        if ($rec) {
            return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } else {
            return response()->json(['status' => 1, 'msg' => trans('messages.wrong')], 200);
        }
    }
    public function show($id)
    {
        $coupondata = Coupons::find($id);
        if (Auth::user()->type == 1) {
            $servicedata = Service::where('id', '!=', $coupondata['servicename']->id)->where('is_available', 1)->where('is_deleted', 2)->orderBy('id', 'DESC')->get();
        } elseif (Auth::user()->type == 2) {
            $servicedata = Service::where('provider_id', Auth::user()->id)->where('id', '!=', $coupondata['servicename']->id)->where('is_available', 1)->where('is_deleted', 2)->orderBy('id', 'DESC')->get();
        }
        return view('included.coupon.show', compact('coupondata', 'servicedata'));
    }
    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'expire_date' => 'date|after:start_date',
        ], [
            'expire_date.date' => trans('messages.valid_date'),
            'expire_date.after' => trans('messages.after_start_date'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if ($request->is_available) {
                $available = 1;
            } else {
                $available = 2;
            }
            $description = strip_tags(Purifier::clean($request->description));
            Coupons::where('id', $id)
                ->update([
                    "code" => $request->code,
                    "service_id" => $request->service_id,
                    "discount" => $request->discount,
                    "discount_type" => $request->discount_type,
                    "start_date" => $request->start_date,
                    "expire_date" => $request->expire_date,
                    "title" => $request->title,
                    "description" => $description,
                    "is_available" => $available
                ]);
            return redirect(route('coupons'))->with('success', trans('messages.coupon_updated'));
        }
    }

    /* ----------------------------------- front -----------------------------------*/
    public function remove_coupon()
    {
        if (Storage::exists('service_id')) {
            Storage::disk('local')->delete("service_id");
        }
        if (Storage::exists('coupon_code')) {
            Storage::disk('local')->delete("coupon_code");
        }
        if (Storage::exists('total_discount')) {
            Storage::disk('local')->delete("total_discount");
        }
        if (Storage::exists('discount_type')) {
            Storage::disk('local')->delete("discount_type");
        }
        if (Storage::exists('service')) {
            Storage::disk('local')->delete("service");
        }
        if (Storage::exists('total_price')) {
            Storage::disk('local')->delete("total_price");
        }
        return response()->json(["status" => 1, "message" => trans('messages.success')], 200);
    }
    public function check_coupon(Request $request, $service)
    {
        if ($request->coupon == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_coupon')], 200);
        }
        $sdata = Service::where('slug', $service)->first();
        $checkcoupon = Coupons::where('service_id', $sdata->id)
            ->where('code', $request->coupon)
            ->where('is_available', 1)
            ->where('is_deleted', 2)
            ->first();
        if (!empty($checkcoupon)) {
            if ((date('Y-m-d') >= $checkcoupon->start_date) && (date('Y-m-d') <= $checkcoupon->expire_date)) {
                Storage::disk('local')->put("service_id", $sdata->id);
                Storage::disk('local')->put("coupon_code", $checkcoupon->code);
                Storage::disk('local')->put("discount", $checkcoupon->discount);
                Storage::disk('local')->put("discount_type", $checkcoupon->discount_type);
                $arr = array(
                    "service_id" => Storage::disk('local')->get("service_id"),
                    "coupon_code" => Storage::disk('local')->get("coupon_code"),
                    "discount" => Storage::disk('local')->get("discount"),
                    "discount_type" => Storage::disk('local')->get("discount_type"),
                );
                return response()->json(["status" => 1, "message" => trans('messages.success'), 'data' => $arr], 200);
            } else {
                return response()->json(["status" => 0, "message" => trans('messages.coupon_expired')], 200);
            }
        } else {
            return response()->json(["status" => 0, "message" => trans('messages.not_for_this_service')], 200);
        }
    }
}
