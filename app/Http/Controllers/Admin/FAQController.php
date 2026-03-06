<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FAQ;
use App\Models\Setting;

class FAQController extends Controller
{
    public function index(Request $request)
    {
        $faq = Setting::select('faq_title', 'faq_sub_title','faq_description', 'faq_image')->first();
        $faqdata = FAQ::where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('faq.index', compact('faq', 'faqdata'));
    }
    public function add()
    {
        return view('faq.add');
    }
    public function store(Request $request)
    {
        if ($request->file('faq_image') != "") {
            $rec = Setting::first();
            if ($rec->faq_image && file_exists(storage_path("app/public/images/" . $rec->faq_image))) {
                unlink(storage_path("app/public/images/" . $rec->faq_image));
            }
            $file = $request->file('faq_image');
            $filename = 'faq_image-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/images/', $filename);

            Setting::where('id', 1)->update(['faq_image' => $filename]);
        }
        Setting::where('id', 1)
            ->update([
                'faq_title' => $request->faq_title,
                'faq_sub_title' => $request->faq_sub_title,
                'faq_description' => $request->faq_description,
            ]);
        return redirect(route('faq'))->with('success', trans('messages.success'));
    }
    public function faq_store(Request $request)
    {
        $faq_id = Setting::first();
        $input = new FAQ();
        $input->question = $request->question;
        $input->answer = $request->answer;
        $input->faq_id = $faq_id->id;
        $input->is_deleted = 2;
        $input->save();
        return redirect()->route('faq')->with('success', 'Added successfully!');
    }
    public function show($id)
    {
        $faqdata = FAQ::where('id', $id)->first();
        return  view("faq.show", compact('faqdata'));
    }
    public function edit(Request $request, $id)
    {
        FAQ::where('id', $id)
            ->update([
                'question' => $request->question,
                'answer' => $request->answer
            ]);
        return redirect(route('faq'))->with('success', trans('messages.faq_update'));
    }
    public function destroy(Request $request)
    {
        $success = FAQ::where('id', $request->id)->delete();
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function bulk_delete(Request $request)
    {
        foreach ($request->id as $id) {
            $success = FAQ::where('id', $id)->delete();
        }
        if ($success) {
            return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } else {
             return response()->json(['status' => 1, 'msg' => trans('messages.wrong')], 200);
        }
    }
    public function reorder_faq(Request $request)
    {
        $getfaq = FAQ::get();
        foreach ($getfaq as $faq) {
            foreach ($request->order as $order) {
                $faq = FAQ::where('id', $order['id'])->first();
                $faq->reorder_id = $order['position'];
                $faq->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
