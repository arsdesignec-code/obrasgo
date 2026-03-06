<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $citydata = City::where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('city.index', compact('citydata'));
    }
    public function add()
    {
        return view('city.add');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'unique:cities'
        ], [
            "name.unique" => trans('messages.city_exist'),
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $file = $request->file("image");
            $filename = 'city-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/city/', $filename);

            $c = new City();
            $c->name = $request->name;
            $c->image = $filename;
            $c->is_available = 1;
            $c->is_deleted = 2;
            $c->save();

            return redirect(route('cities'))->with('success', trans('messages.city_added'));
        }
    }
    public function destroy(Request $request)
    {
        $updatecity = City::where('id', $request->id)->update(['is_deleted' => 1]);

        $users = User::where('city_id', $request->id)->get();
        foreach ($users as $user) {
            $update = User::find($user->id);
            $update->is_available = $request->status;
            $update->save();
            Service::where('provider_id', $user->id)->update(['is_deleted' => 1]);
            User::where('provider_id', $user->id)->where('type', 3)->update(['is_available' => $request->status]);
        }

        if ($updatecity) {
            return 1;
        } else {
            return 0;
        }
    }
    public function bulk_delete(Request $request)
    {
        foreach ($request->id as $id) {
            $updatecity = City::where('id', $id)->update(['is_deleted' => 1]);

            $users = User::where('city_id', $id)->get();
            foreach ($users as $user) {
                $update = User::find($user->id);
                $update->is_available = $request->status;
                $update->save();
                Service::where('provider_id', $user->id)->update(['is_deleted' => 1]);
                User::where('provider_id', $user->id)->where('type', 3)->update(['is_available' => $request->status]);
            }

        }
        if ($updatecity) {
             return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } else {
             return response()->json(['status' => 0, 'msg' => trans('messages.wrong')], 200);
        }
    }
    public function status(Request $request)
    {
        $updatecity = City::where('id', $request->id)->update(['is_available' => $request->status]);

        $users = User::where('city_id', $request->id)->get();
        foreach ($users as $user) {
            $update = User::find($user->id);
            $update->is_available = $request->status;
            $update->save();
            Service::where('provider_id', $user->id)->update(['is_available' => $request->status]);
            User::where('provider_id', $user->id)->where('type', 3)->update(['is_available' => $request->status]);
        }

        if ($updatecity) {
            return 1;
        } else {
            return 0;
        }
    }
    public function show($id)
    {
        $updatecitydata = City::find($id);
        return view('city.show', compact('updatecitydata'));
    }
    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'unique:cities,name,' . $id
        ], [
            "name.unique" => trans('messages.city_exist')
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if ($request->file("image") != "") {
                $city = City::find($id);
                if (file_exists(storage_path("app/public/city/" . $city->image))) {
                    unlink(storage_path("app/public/city/" . $city->image));
                }

                $file = $request->file("image");
                $filename = 'city-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/city/', $filename);

                City::where('id', $id)->update(['image' => $filename]);
            }
            if ($request->is_available) {
                $availilable = 1;
            } else {
                $availilable = 2;
            }
            City::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'is_available' => $availilable
                ]);
            return redirect(route('cities'))->with('success', trans('messages.city_updated'));
        }
    }
    public function reorder(Request $request)
    {
        $getcity = City::get();
        foreach ($getcity as $city) {
            foreach ($request->order as $order) {
                $city = City::where('id', $order['id'])->first();
                $city->reorder_id = $order['position'];
                $city->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
