<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class WishlistController extends Controller
{
    public function storewishlist(Request $request)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $check = Wishlist::where('user_id', $user_id)->where('service_id', $request->service_id)->first();
            $service_id = $request->service_id;
            if ($check) {
                $removewishlist = Wishlist::where("service_id", $service_id)->first();
                $removewishlist->delete();
                $data = '<a href="javascript:void(0)" onclick="wishlist(' . chr(0x27) . URL::to('home/wishlist') . chr(0x27) . ',' . chr(0x27) . $request->service_id . chr(0x27) . ')" class="wishlist"><i class="fa-regular fa-heart"></i></a>';
                return response()->json([
                    "status" => true,
                    "message" => "Service removed from your wishlist",
                    "data" => $data
                ], 200);
            } else {
                $wishlist = new Wishlist();
                $wishlist->user_id = $user_id;
                $wishlist->service_id = $service_id;
                $wishlist->save();
                $data = '<a href="javascript:void(0)" onclick="wishlist(' . chr(0x27) . URL::to('home/wishlist') . chr(0x27) . ',' . chr(0x27) . $request->service_id . chr(0x27) . ')" class="wishlist"><i class="fa-solid fa-heart"></i></a>';
                return response()->json([
                    "status" => true,
                    "message" => "Service added to your wishlist",
                    "data" => $data
                ], 200);
            }
        }
    }
}
