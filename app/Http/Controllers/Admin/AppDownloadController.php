<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppDownloadController extends Controller
{
    public function index()
    {
        $app_download_data = AppDownload::select('title', 'description', 'image', 'android_url', 'ios_url')->first();
        return view('app_dowload.index', compact('app_download_data'));
    }

    public function update(Request $request)
    {
        if ($request->file('image') != "") {
            $validator = Validator::make($request->all(), [
                'image' => 'required',
            ], [
                'image.required' => trans('messages.enter_image'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $rec = AppDownload::first();
                if ($rec->image && file_exists(storage_path("app/public/images/" . $rec->image))) {
                    unlink(storage_path("app/public/images/" . $rec->image));
                }
                $file = $request->file('image');
                $filename = 'app_download-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/images/', $filename);

                AppDownload::where('id', 1)->update(['image' => $filename]);
            }
        }
        AppDownload::where('id', 1)
            ->update([
                'title' => $request->title,
                'description' => $request->description,
                'android_url' => $request->android_url,
                'ios_url' => $request->ios_url,
            ]);
        return redirect(route('app_download'))->with('success', trans('messages.success'));
    }
}
