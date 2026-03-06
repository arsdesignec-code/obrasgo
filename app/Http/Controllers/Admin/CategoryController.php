<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Str;

class CategoryController extends Controller
{
    public function categories(Request $request)
    {
        $categorydata = Category::where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('category.index', compact('categorydata'));
    }
    public function add()
    {
        return view('category.add');
    }
    public function store(Request $request)
    {
        $file = $request->file("image");
        $filename = 'category-' . time() . "." . $file->getClientOriginalExtension();
        $file->move(storage_path() . '/app/public/category/', $filename);

        $checkslug = Category::where('slug', Str::slug($request->name, '-'))->first();
        if ($checkslug != "") {
            $last = Category::select('id')->orderByDesc('id')->first();
            $create = $request->name . " " . ($last->id + 1);
            $slug =   Str::slug($create, '-');
        } else {
            $slug = Str::slug($request->name, '-');
        }

        $category = new Category;
        $category->name = $request->name;
        $category->image = $filename;
        $category->slug = $slug;
        $category->is_available = 1;
        $category->is_deleted = 2;
        $category->save();
        return redirect(route('categories'))->with('success', trans('messages.category_added'));
    }
    public function show($category)
    {
        $categorydata = Category::where('slug', $category)->first();
        return view('category.show', compact('categorydata'));
    }
    public function edit(Request $request, $category)
    {
        if ($request->file("image") != "") {
            $rec = Category::where('slug', $category)->first();
            if (file_exists(storage_path("app/public/category/" . $rec->image))) {
                unlink(storage_path("app/public/category/" . $rec->image));
            }

            $file = $request->file("image");
            $filename = 'category-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/category/', $filename);

            Category::where('slug', $category)->update(['image' => $filename]);
        }
        if ($request->is_available == 'is_available') {
            $available = 1;
        } else {
            $available = 2;
        }
        $cdata = Category::where('slug', $category)->first();
        $checkslug = Category::where('slug', Str::slug($request->name, '-'))->where('id', '!=', $cdata->id)->first();
        if ($checkslug != "") {
            $last = Category::select('id')->orderByDesc('id')->first();
            $create = $request->name . " " . ($last->id + 1);
            $slug =   Str::slug($create, '-');
        } else {
            $slug = Str::slug($request->name, '-');
        }
        Category::where('slug', $category)
            ->update([
                'name' => $request->name,
                'slug' => $slug,
                'is_available' => $available,
            ]);
        return redirect()->route('categories')->with('success', trans('messages.category_updated'));
    }
    public function status(Request $request)
    {
        $success = Category::where('id', $request->id)->update(['is_available' => $request->status]);
        Service::where('category_id', $request->id)->update(['is_available' => $request->status]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function destroy(Request $request)
    {
        $success = Category::where('id', $request->id)->update(['is_deleted' => 1]);
        Service::where('category_id', $request->id)->update(['is_available' => 2]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function bulk_delete(Request $request)
    {
        foreach ($request->id as $id) {
            $success = Category::where('id', $id)->update(['is_deleted' => 1]);
            Service::where('category_id', $id)->update(['is_available' => 2]);
        }
            return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
    public function reorder(Request $request)
    {
        $getcategory = Category::get();
        foreach ($getcategory as $category) {
            foreach ($request->order as $order) {
                $category = Category::where('id', $order['id'])->first();
                $category->reorder_id = $order['position'];
                $category->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
