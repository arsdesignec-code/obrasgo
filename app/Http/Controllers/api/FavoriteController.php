<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function favorite(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
        }
        $checkuser = User::where('id', $request->user_id)->first();
        if (empty($checkuser)) {
            return response()->json(["status" => 0, "message" => trans('messages.invalid_user')], 200);
        }
        if ($request->type == "provider") {

            if ($request->provider_id == "") {
                return response()->json(['status' => 0, 'message' => trans('messages.enter_provider_id')], 200);
            }
            $checkprovider = User::where('id', $request->provider_id)->where('type', 2)->where('is_available', 1)->first();
            if (empty($checkprovider)) {
                return response()->json(["status" => 0, "message" => trans('messages.invalid_provider')], 200);
            }
            $checkfavorite = Favorite::where('user_id', $request->user_id)->where('provider_id', $request->provider_id)->first();
            if (!empty($checkfavorite)) {
                return response()->json(['status' => 0, 'message' => trans('messages.favorite_exist')], 200);
            } else {
                $favorite = new Favorite();
                $favorite->user_id = $request->user_id;
                $favorite->provider_id = $request->provider_id;
                $favorite->save();
                return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
            }
        }
        if ($request->type == "service") {

            if ($request->service_id == "") {
                return response()->json(['status' => 0, 'message' => trans('messages.enter_service_id')], 200);
            }
            $checkservice = Service::where('id', $request->service_id)->where('is_available', 1)->where('is_deleted', 2)->first();
            if (empty($checkservice)) {
                return response()->json(["status" => 0, "message" => trans('messages.invalid_service')], 200);
            }
            $checkfavorite = Favorite::where('user_id', $request->user_id)->where('service_id', $request->service_id)->first();
            if (!empty($checkfavorite)) {
                return response()->json(['status' => 0, 'message' => trans('messages.favorite_exist')], 200);
            } else {
                $favorite = new Favorite();
                $favorite->user_id = $request->user_id;
                $favorite->service_id = $request->service_id;
                $favorite->save();
                return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
            }
        }
        if ($request->type != "provider" || $request->type != "service") {
            return response()->json(["status" => 0, "message" => trans('messages.invalid_request')], 200);
        }
    }

    public function unfavorite(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
        }
        $checkuser = User::where('id', $request->user_id)->first();
        if (empty($checkuser)) {
            return response()->json(["status" => 0, "message" => trans('messages.invalid_user')], 200);
        }
        if ($request->type == "provider") {

            if ($request->provider_id == "") {
                return response()->json(['status' => 0, 'message' => trans('messages.enter_provider_id')], 200);
            }
            $checkprovider = User::where('id', $request->provider_id)->where('type', 2)->where('is_available', 1)->first();
            if (empty($checkprovider)) {
                return response()->json(["status" => 0, "message" => trans('messages.invalid_provider')], 200);
            }
            $checkfavorite = Favorite::where('user_id', $request->user_id)->where('provider_id', $request->provider_id)->first();
            if (!empty($checkfavorite)) {
                $checkfavorite->delete();
                return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.favorite_not_found')], 200);
            }
        }
        if ($request->type == "service") {

            if ($request->service_id == "") {
                return response()->json(['status' => 0, 'message' => trans('messages.enter_service_id')], 200);
            }
            $checkservice = Service::where('id', $request->service_id)->where('is_available', 1)->where('is_deleted', 2)->first();
            if (empty($checkservice)) {
                return response()->json(["status" => 0, "message" => trans('messages.invalid_service')], 200);
            }
            $checkfavorite = Favorite::where('user_id', $request->user_id)->where('service_id', $request->service_id)->first();
            if (!empty($checkfavorite)) {
                $checkfavorite->delete();
                return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.favorite_not_found')], 200);
            }
        }
        if ($request->type != "provider" || $request->type != "service") {
            return response()->json(["status" => 0, "message" => trans('messages.invalid_request')], 200);
        }
    }
    public function favoritelist(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_user_id')], 200);
        }
        if ($request->city_id == "") {
            return response()->json(['status' => 0, 'message' => trans('messages.enter_city')], 200);
        }
        $user_id = $request->user_id;

        $checkuser = User::where('id', $request->user_id)->first();

        if (empty($checkuser)) {
            return response()->json(["status" => 0, "message" => trans('messages.invalid_user')], 200);
        }

        if ($request->type == "providers") {

            $favoriteproviders = User::with('api_rattings')
                ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
                ->join('cities', 'users.city_id', '=', 'cities.id')
                ->leftJoin('favorites', function ($query) use ($user_id) {
                    $query->on('favorites.provider_id', '=', 'users.id')
                        ->where('favorites.user_id', '=', $user_id);
                })
                ->select(
                    'users.id',
                    'users.name as provider_name',
                    'provider_types.name as provider_type',
                    'users.email',
                    'users.mobile',
                    'users.address',
                    'cities.name as city_name',
                    'users.about',
                    'users.login_type',
                    DB::raw('(case when favorites.provider_id is null then 0 else 1 end) as is_favorite'),
                    DB::raw("CONCAT('" . asset('storage/app/public/provider/') . "/', users.image) AS image_url")
                )
                ->where('users.city_id', $request->city_id)
                ->where('favorites.user_id', $user_id)
                ->where('users.type', 2)
                ->where('users.is_available', 1)
                ->orderByDesc('favorites.id')
                ->paginate(10);

            return response()->json(['status' => 1, 'message' => trans('messages.success'), 'favoriteproviders' => $favoriteproviders], 200);
        }
        if ($request->type == "services") {
            $favoriteservices = Service::with('api_rattings')
                ->join('categories', 'services.category_id', '=', 'categories.id')
                ->join('users', 'services.provider_id', '=', 'users.id')
                ->leftJoin('favorites', function ($query) use ($user_id) {
                    $query->on('favorites.service_id', '=', 'services.id')
                        ->where('favorites.user_id', '=', $user_id);
                })
                ->select(
                    'services.id',
                    'services.name as service_name',
                    'services.price',
                    'services.price_type',
                    'services.duration',
                    'services.duration_type',
                    'categories.name as category_name',
                    'users.name as provider_name',
                    DB::raw('(case when favorites.service_id is null then 0 else 1 end) as is_favorite'),
                    DB::raw("CONCAT('" . asset('storage/app/public/service/') . "/', services.image) AS image_url"),
                    DB::raw("CONCAT('" . asset('storage/app/public/provider/') . "/', users.image) AS provider_image_url")
                )
                ->where('favorites.user_id', $request->user_id)
                ->where('users.city_id', $request->city_id)
                ->where('services.is_available', 1)
                ->where('services.is_deleted', 2)
                ->orderByDesc('services.id')
                ->paginate(10);
            return response()->json(['status' => 1, 'message' => trans('messages.success'), 'favoriteservices' => $favoriteservices], 200);
        }
        if ($request->type != "services" && $request->type != "providers") {
            return response()->json(['status' => 0, 'message' => trans('messages.invalid_request')], 200);
        }
    }
}
