<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\ProviderType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProviderTypeController extends Controller
{
    function index(Request $request)
    {
        $providertypedata = ProviderType::where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('provider.provider_types.index', compact('providertypedata'));
    }
    function add()
    {
        return view('provider.provider_types.add');
    }
    function store(Request $request)
    {

        $ptype = new ProviderType();
        $ptype->name = $request->name;
        $ptype->commission = $request->commission;
        $ptype->is_available = 1;
        $ptype->is_deleted = 2;
        $ptype->save();

        return redirect(route('provider_types'))->with('success', trans('messages.provider_type_added'));
    }
    public function destroy(Request $request)
    {
        $ptype = ProviderType::where('id', $request->id)->update(['is_deleted' => 1]);

        User::where('provider_type', $request->id)->update(['is_available' => 2]);

        if ($ptype) {
            return 1;
        } else {
            return 0;
        }
    }
    public function bulk_delete(Request $request)
    {
        foreach ($request->id as $id) {
            $ptype = ProviderType::where('id', $id)->update(['is_deleted' => 1]);

            User::where('provider_type', $id)->update(['is_available' => 2]);
        }

        if ($ptype) {
           return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } else {
           return response()->json(['status' => 1, 'msg' => trans('messages.wrong')], 200);
        }
    }
    public function status(Request $request)
    {
        $success = ProviderType::where('id', $request->id)->update(['is_available' => $request->status]);

        User::where('provider_type', $request->id)->update(['is_available' => $request->status]);

        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function show($id)
    {
        $updateprovidertypedata = ProviderType::find($id);
        return view('provider.provider_types.show', compact('updateprovidertypedata'));
    }
    public function edit(Request $request, $id)
    {
        if ($request->is_available) {
            $available = 1;
        } else {
            $available = 2;
        }
        ProviderType::where('id', $id)
            ->update([
                'name' => $request->name,
                'commission' => $request->commission,
                'is_available' => $available
            ]);
        return redirect()->route('provider_types')->with('success', trans('messages.provider_type_updated'));
    }
    public function reorder(Request $request)
    {
        $getptype = ProviderType::get();
        foreach ($getptype as $ptype) {
            foreach ($request->order as $order) {
                $ptype = ProviderType::where('id', $order['id'])->first();
                $ptype->reorder_id = $order['position'];
                $ptype->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
