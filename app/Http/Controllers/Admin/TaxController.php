<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaxController extends Controller
{
    public function index()
    {
        $taxdata = Tax::where('provider_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('tax.index', compact('taxdata'));
    }
    public function add()
    {
        return view('tax.add');
    }
    public function store(Request $request)
    {
        $banner = new Tax();
        $banner->provider_id = Auth::user()->id;
        $banner->name = $request->name;
        $banner->type = $request->type;
        $banner->tax = $request->tax;
        $banner->save();
        return redirect(route('tax'))->with('success', trans('messages.tax_added'));
    }
    public function show(Request $request, $id)
    {
        $taxdata = Tax::find($id);
        return view('tax.show', compact('taxdata'));
    }
    public function edit(Request $request, $id)
    {
        Tax::where('id', $id)->update([
            "name" => $request->name,
            "type" => $request->type,
            "tax" => $request->tax
        ]);
        return redirect(route('tax'))->with('success', trans('messages.tax_updated'));
    }
    public function destroy(Request $request)
    {
        $rec = Tax::find($request->id);
        if ($rec->delete()) {
            return 1;
        } else {
            return 0;
        }
    }
    public function bulk_delete(Request $request)
    {
        foreach ($request->id as $id) {
             $rec = Tax::find($id);
             $rec->delete();
        }
        if ($rec) {
           return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } else {
            return response()->json(['status' => 0, 'msg' => trans('messages.wrong')], 200);
        }
    }
}
