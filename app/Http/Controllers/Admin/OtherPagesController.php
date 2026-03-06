<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class OtherPagesController extends Controller
{
    // brand
    public function brand_index(Request $request)
    {
        $branddata = Brand::orderBydesc('id')->get();
        return view('brand.index', compact('branddata'));
    }
    public function brand_add()
    {
        return view('brand.add');
    }
    public function brand_store(Request $request)
    {
        foreach ($request->image as $img) {
            $image = 'brand-' . uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move(storage_path()  . '/app/public/images/', $image);
            $team = new Brand();
            $team->image = $image;
            $team->save();
        }
        return redirect(route('brand'))->with('success', trans('messages.success'));
    }
    public function brand_show(Request $request)
    {
        $branddata = Brand::find($request->id);
        return view('brand.edit', compact('branddata'));
    }
    public function brand_update(Request $request)
    {
        $brand = Brand::find($request->id);
        if (file_exists(storage_path() . "/app/public/images/" . $brand->image)) {
            unlink(storage_path() . "/app/public/images/" . $brand->image);
        }
        $image = 'brand-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(storage_path() . '/app/public/images', $image);
        $brand->image = $image;
        $brand->save();
        return redirect(route('brand'))->with('success', trans('messages.success'));
    }
    public function brand_delete(Request $request)
    {
        $brand = Brand::find($request->id);
        if (file_exists(storage_path() . "/app/public/images/" . $brand->image)) {
            unlink(storage_path() . "/app/public/images/" . $brand->image);
        }
        if ($brand->delete()) {
            return 1;
        } else {
            return 0;
        }
    }
}
