<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BookingAddress;
use Illuminate\Http\Request;

class BookingAddressController extends Controller
{
    public function getaddresses(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
        }
        $checkuser = User::where('id', $request->user_id)
            ->where(function ($query) {
                $query->where('type', '=', 3)
                    ->orWhere('type', '=', 4);
            })
            ->where('is_available', 1)
            ->first();

        if (!empty($checkuser)) {

            $check = BookingAddress::where('user_id', $request->user_id)->first();
            if (!empty($check)) {
                $addressdata = BookingAddress::select('id', 'name', 'email', 'mobile', 'street', 'landmark', 'postcode','address_type')->where('user_id', $request->user_id)->orderByDesc('id')->paginate(10);
                return response()->json(["status" => 1, "message" => trans('messages.success'), 'addressdata' => $addressdata], 200);
            } else {
                return response()->json(["status" => 0, "message" => trans('messages.not_available')], 200);
            }
        } else {
            return response()->json(["status" => 0, "message" => trans('messages.invalid_user')], 200);
        }
    }
    public function addaddress(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
        }
        $checkuser = User::where('id', $request->user_id)
            ->where(function ($query) {
                $query->where('type', '=', 3)
                    ->orWhere('type', '=', 4);
            })
            ->where('is_available', 1)
            ->first();

        if (empty($checkuser)) {
            return response()->json(["status" => 0, "message" => trans('messages.invalid_user')], 200);
        }
        if ($request->name == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_fullname')], 200);
        }
        if ($request->street == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_street_address')], 200);
        }
        if ($request->landmark == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_landmark')], 200);
        }
        if ($request->postcode == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_postcode')], 200);
        }
        if ($request->mobile == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_mobile')], 200);
        }
        if ($request->email == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_email')], 200);
        }
        if ($request->address_type == "") {
            return response()->json(["status" => 0, "message" => trans('messages.select_address_type')], 200);
        }

        $checkaddress = BookingAddress::where(['user_id' => $request->user_id, 'name' => $request->name, 'street' => $request->street, 'landmark' => $request->landmark, 'postcode' => $request->postcode, 'mobile' => $request->mobile, 'email' => $request->email, 'address_type' => $request->address_type])->first();

        if (!empty($checkaddress)) {
            return response()->json(["status" => 0, "message" => trans('messages.address_exist')], 200);
        }
        $baddress = new BookingAddress();
        $baddress->user_id = $request->user_id;
        $baddress->name = $request->name;
        $baddress->street = $request->street;
        $baddress->landmark = $request->landmark;
        $baddress->postcode = $request->postcode;
        $baddress->mobile = $request->mobile;
        $baddress->email = $request->email;
        $baddress->address_type = $request->address_type;
        $baddress->save();

        $addressdata = BookingAddress::join('users', 'booking_addresses.user_id', 'users.id')
            ->select('booking_addresses.id', 'booking_addresses.name', 'booking_addresses.street', 'booking_addresses.landmark', 'booking_addresses.postcode', 'booking_addresses.mobile', 'booking_addresses.email', 'booking_addresses.address_type', 'users.name as user_name')
            ->where('booking_addresses.id', $baddress->id)
            ->first();
        return response()->json(["status" => 1, "message" => trans('messages.address_added'), 'addressdata' => $addressdata], 200);
    }
    public function deleteaddress(Request $request)
    {
        if ($request->address_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_address_id')], 200);
        }

        $checkaddress = BookingAddress::where('id', $request->address_id)->first();

        if (!empty($checkaddress)) {
            $checkaddress->delete();
            return response()->json(["status" => 1, "message" => trans('messages.address_deleted')], 200);
        } else {
            return response()->json(["status" => 0, "message" => trans('messages.invalid_address')], 200);
        }
    }
    public function editaddress(Request $request)
    {
        if ($request->address_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
        }
        $checkaddress = BookingAddress::where('id', $request->address_id)->first();

        if (empty($checkaddress)) {
            return response()->json(["status" => 0, "message" => trans('messages.invalid_address')], 200);
        }
        if ($request->name == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_fullname')], 200);
        }
        if ($request->street == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_street_address')], 200);
        }
        if ($request->landmark == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_landmark')], 200);
        }
        if ($request->postcode == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_postcode')], 200);
        }
        if ($request->mobile == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_mobile')], 200);
        }
        if ($request->email == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_email')], 200);
        }
        if ($request->address_type == "") {
            return response()->json(["status" => 0, "message" => trans('messages.select_address_type')], 200);
        }

        $addressexist = BookingAddress::where('id', '!=', $request->address_id)->where(['name' => $request->name, 'street' => $request->street, 'landmark' => $request->landmark, 'postcode' => $request->postcode, 'mobile' => $request->mobile, 'email' => $request->email, 'address_type' => $request->address_type])->first();

        if (!empty($addressexist)) {
            return response()->json(["status" => 0, "message" => trans('messages.address_exist')], 200);
        }
        $update = BookingAddress::where('id', $request->address_id)
            ->update([
                'name' => $request->name,
                'street' => $request->street,
                'landmark' => $request->landmark,
                'postcode' => $request->postcode,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'address_type' => $request->address_type
            ]);

        $addressdata = BookingAddress::join('users', 'booking_addresses.user_id', 'users.id')
            ->select('booking_addresses.id', 'booking_addresses.name', 'booking_addresses.street', 'booking_addresses.landmark', 'booking_addresses.postcode', 'booking_addresses.mobile', 'booking_addresses.email','booking_addresses.address_type', 'users.name as user_name')
            ->where('booking_addresses.id', $request->address_id)
            ->first();
        return response()->json(["status" => 1, "message" => trans('messages.address_updated'), 'addressdata' => $addressdata], 200);
    }
}
