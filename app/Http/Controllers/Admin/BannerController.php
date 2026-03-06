<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $bannerdata = Banner::orderBy('reorder_id')->get();
        return view('banner.index', compact('bannerdata'));
    }
    public function add()
    {
        $categorydata = Category::where('is_available', 1)->where('is_deleted', 2)->orderBy('id', 'DESC')->get();
        return view('banner.add', compact('categorydata'));
    }
    public function store(Request $request)
    {
        $file = $request->file("image");
        $filename = 'banners-' . time() . "." . $file->getClientOriginalExtension();
        $file->move(storage_path() . '/app/public/banner/', $filename);

        $banner = new Banner();
        $banner->image = $filename;
        $banner->section = $request->section;
        $banner->type = $request->type;
        $banner->category_id = $request->category_id;
        $banner->save();
        return redirect(route('banners'))->with('success', trans('messages.banner_added'));
    }
    public function show(Request $request, $id)
    {
        $bannerdata = Banner::find($id);
        $categorydata = Category::where('id', '!=', $bannerdata->category_id)->where('is_available', 1)->where('is_deleted', 2)->orderBy('id', 'DESC')->get();
        return view('banner.show', compact('bannerdata', 'categorydata'));
    }
    public function edit(Request $request, $id)
    {
        if ($request->file('image') != "") {
            $rec = Banner::find($id);
            if (file_exists(storage_path("app/public/banner/" . $rec->image))) {
                unlink(storage_path("app/public/banner/" . $rec->image));
            }
            $file = $request->file("image");
            $filename = 'banners-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/banner/', $filename);
            Banner::where('id', $id)->update([
                "image" => $filename
            ]);
        }
        if ($request->type == 1) {
            Banner::where('id', $id)->update([
                "section" => $request->section,
                "type" => $request->type,
                "category_id" => $request->category_id,
                "service_id" => NULL
            ]);
        } else {
            Banner::where('id', $id)->update([
                "section" => $request->section,
                "type" => $request->type,
                "category_id" => NULL,
                "service_id" => NULL
            ]);
        }
        return redirect(route('banners'))->with('success', trans('messages.banner_updated'));
    }
    public function destroy(Request $request)
    {
        $rec = Banner::find($request->id);
        if (file_exists(storage_path("app/public/banner/" . $rec->image))) {
            unlink(storage_path("app/public/banner/" . $rec->image));
        }
        if ($rec->delete()) {
            return 1;
        } else {
            return 0;
        }
    }
    public function bulk_delete(Request $request)
    {
        foreach ($request->id as $id) {
            $rec = Banner::find($id);
            if (file_exists(storage_path("app/public/banner/" . $rec->image))) {
                unlink(storage_path("app/public/banner/" . $rec->image));
            }
            $rec->delete();
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        
    }
    public function reorder(Request $request)
    {
        $getbanner = Banner::get();
        foreach ($getbanner as $banner) {
            foreach ($request->order as $order) {
                $banner = Banner::where('id', $order['id'])->first();
                $banner->reorder_id = $order['position'];
                $banner->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
