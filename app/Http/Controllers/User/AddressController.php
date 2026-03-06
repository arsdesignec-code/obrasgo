<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BookingAddress;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {

        if (isset($_COOKIE['city_id'])) {
            $addressdata = BookingAddress::where('user_id', Auth::user()->id)->orderByDesc('id')->get();
            return view('front.user.address', compact('addressdata'));
        }
    }
}
