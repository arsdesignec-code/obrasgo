<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMS;
use Illuminate\Support\Facades\Validator;

class CMSController extends Controller
{
    public function tc_form()
    {
        $tcdata = CMS::select('tc_content')->first();
        return view('cmspages.tc', compact('tcdata'));
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ], [
            'content.required' => trans('messages.enter_terms')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $tc_content = $request->content;
            CMS::where('id', 1)->update(['tc_content' => $tc_content]);
            return redirect(route('tc'))->with('success', trans('messages.success'));
        }
    }
    public function privacy_form()
    {
        $privacydata = CMS::select('privacy_content')->first();
        return view('cmspages.privacy_policy', compact('privacydata'));
    }
    public function update_privacy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'privacy_content' => 'required',
        ], [
            'privacy_content.required' => trans('messages.enter_privacy')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $privacy_content = $request->privacy_content;
            CMS::where('id', 1)->update(['privacy_content' => $privacy_content]);
            return redirect(route('privacy_policy'))->with('success', trans('messages.success'));
        }
    }
    public function about_form()
    {
        $aboutdata = CMS::select('about_image', 'about_content')->first();
        return view('cmspages.about', compact('aboutdata'));
    }
    public function update_about(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'about_content' => 'required',
        ], [
            'about_content.required' => trans('messages.enter_about')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if ($request->file('image') != "") {
                $rec = CMS::first();
                if (file_exists(storage_path("app/public/images/" . $rec->about_image))) {
                    unlink(storage_path("app/public/images/" . $rec->about_image));
                }
                $file = $request->file('image');
                $filename = 'about-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/images/', $filename);

                CMS::where('id', 1)->update(['about_image' => $filename]);
            }
            $about_content = $request->about_content;
            CMS::where('id', 1)->update(['about_content' => $about_content]);
            return redirect(route('about'))->with('success', trans('messages.success'));
        }
    }
}
