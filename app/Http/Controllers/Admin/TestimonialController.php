<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonials;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonials::where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('testimonal.index', compact('testimonials'));
    }
    public function add()
    {
        return view('testimonal.add');
    }
    public function store(Request $request)
    {
        // Upload Image
        $file = $request->file("image");
        $filename = 'testimonial-' . rand(111111, 999999) . "." . $file->getClientOriginalExtension();
        $file->move(storage_path() . '/app/public/testimonials/', $filename);

        $category = new Testimonials();
        $category->name = $request->name;
        $category->rating = $request->rating;
        $category->description = $request->description;
        $category->image = $filename;
        $category->is_deleted = 2;
        $category->save();

        return redirect(route('testimonials'))->with('success', trans('messages.testimonials_added'));
    }
    public function show(Testimonials $testimonial)
    {
        return view('testimonal.show', compact('testimonial'));
    }
    public function edit(Request $request, $id)
    {
        //upload image
        $testimonial =  Testimonials::where('id', $id)->first();
        if ($request->file('image')  != '') {
            if (file_exists(storage_path("app/public/testimonials/" . $testimonial->image))) {
                unlink(storage_path("app/public/testimonials/" . $testimonial->image));
            }
            $file = $request->file("image");
            $filename = 'testimonial-' . rand(111111, 999999) . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/testimonials/', $filename);
            Testimonials::where('id', $id)->update(['image' => $filename]);
        }
        Testimonials::where('id', $id)->update([
            'name' => $request->name,
            'rating' => $request->rating,
            'description' => $request->description,

        ]);
        return redirect(route('testimonials'))->with(['success' => trans('messages.testimonials_update')]);
    }
    public function  destroy(Request $request)
    {
        $success = Testimonials::where('id', $request->id)->update(['is_deleted' => 1]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function  bulk_delete(Request $request)
    {
        foreach ($request->id as $id) {
            $success = Testimonials::where('id', $id)->update(['is_deleted' => 1]);
        }
        if ($success) {
             return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } else {
             return response()->json(['status' => 1, 'msg' => trans('messages.wrong')], 200);
        }
    }
    
    public function reorder_testimonials(Request $request)
    {
        $gettestimonial = Testimonials::get();
        foreach ($gettestimonial as $testimonial) {
            foreach ($request->order as $order) {
                $testimonial = Testimonials::where('id', $order['id'])->first();
                $testimonial->reorder_id = $order['position'];
                $testimonial->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
