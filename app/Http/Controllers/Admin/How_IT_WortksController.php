<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HowITWorkes;
use App\Models\Setting;
use Illuminate\Http\Request;

class How_IT_WortksController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            if ($query != "") {
                $howitworkdata = HowITWorkes::where('how_it_works_title', 'like', '%' . $query . '%')->where('is_deleted', 2)->orderBy('reorder_id')->get();
            } else {
                $howitworkdata = HowITWorkes::where('is_deleted', 2)->orderBy('reorder_id')->get();
            }
            return view('how_it_works.how_it_work_table', compact('howitworkdata'))->render();
        } else {
            $howitwork = Setting::select('how_it_works_title', 'how_it_works_sub_title', 'how_it_works_image', 'how_it_works_description')->first();
            $howitworkdata = HowITWorkes::where('is_deleted', 2)->orderBy('reorder_id')->get();
            return view('how_it_works.index', compact('howitworkdata', 'howitwork'));
        }
    }
    public function add()
    {
        return view('how_it_works.add');
    }
    public function store(Request $request)
    {
        if ($request->file('how_it_works_image') != "") {
            $rec = Setting::first();
            if (file_exists(storage_path("app/public/images/" . $rec->how_it_works_image))) {
                unlink(storage_path("app/public/images/" . $rec->how_it_works_image));
            }
            $file = $request->file('how_it_works_image');
            $filename = 'how_it_works_image-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/images/', $filename);

            Setting::where('id', 1)->update(['how_it_works_image' => $filename]);
        }
        Setting::where('id', 1)
            ->update([
                'how_it_works_title' => $request->how_it_works_title,
                'how_it_works_sub_title' => $request->how_it_works_sub_title,
                'how_it_works_description' => $request->how_it_works_description,
            ]);
        return redirect(route('how_it_works'))->with('success', trans('messages.success'));
    }
    public function how_it_works_store(Request $request)
    {
        $how_it_works_id = Setting::first();
        $input = new HowITWorkes();
        $input->how_it_works_title = $request->how_it_works_title;
        $input->how_it_works_description = $request->how_it_works_description;
        $input->how_it_works_id = $how_it_works_id->id;
        $input->is_deleted = 2;
        if ($request->file('how_it_works_image') != "") {
            $file = $request->file('how_it_works_image');
            $filename = 'how_it_works_image-' . rand(11111, 99999) . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/images/', $filename);
            $input['how_it_works_image'] = $filename;
        }
        $input->save();
        return redirect()->route('how_it_works')->with('success', 'Added successfully!');
    }
    public function show($id)
    {
        $howitworkdata = HowITWorkes::where('id', $id)->first();
        return  view("how_it_works.show", compact('howitworkdata'));
    }
    public function edit(Request $request, $id)
    {
        if ($request->file("how_it_works_image") != "") {
            $howitwork = HowITWorkes::find($id);
            if (file_exists(storage_path("app/public/images/" . $howitwork->how_it_works_image))) {
                unlink(storage_path("app/public/images/" . $howitwork->how_it_works_image));
            }

            $file = $request->file("how_it_works_image");
            $filename = 'how_it_works_image-' . rand(11111, 99999) . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/images/', $filename);

            HowITWorkes::where('id', $id)->update(['how_it_works_image' => $filename]);
        }
        HowITWorkes::where('id', $id)
            ->update([
                'how_it_works_title' => $request->how_it_works_title,
                'how_it_works_description' => $request->how_it_works_description
            ]);
        return redirect(route('how_it_works'))->with('success', trans('messages.how_it_works_update'));
    }
    public function destroy(Request $request)
    {
        $success = HowITWorkes::where('id', $request->id)->update(['is_deleted' => 1]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function bulk_delete(Request $request)
    {
        foreach ($request->id as $id) {
            $success = HowITWorkes::where('id', $id)->update(['is_deleted' => 1]);
        }
        if ($success) {
            return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } else {
            return response()->json(['status' => 1, 'msg' => trans('messages.wrong')], 200);
        }
    }
    public function reorder_howitwork(Request $request)
    {
        $gethowitwork = HowITWorkes::get();
        foreach ($gethowitwork as $howitwork) {
            foreach ($request->order as $order) {
                $howitwork = HowITWorkes::where('id', $order['id'])->first();
                $howitwork->reorder_id = $order['position'];
                $howitwork->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
