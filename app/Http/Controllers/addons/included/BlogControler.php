<?php

namespace App\Http\Controllers\addons\included;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blog = Blog::where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('included.blog.index', compact('blog'));
    }
    public function  add()
    {
        return view("included.blog.add");
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ], [
            'description.required' => trans('messages.enter_description'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $input = new Blog();
            $input->title = $request->title;
            $input->slug = Str::slug($request->title);
            $input->description = $request->description;
            $input->is_deleted = 2;
            if ($request->file('image') != "") {
                $file = $request->file('image');
                $filename = 'blog_image-' . rand(11111, 99999) . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/blogs/', $filename);
                $input['image'] = $filename;
            }
            $input->save();
            return redirect()->route('blog')->with('success', 'Added successfully!');
        }
    }
    public function show($id)
    {
        $blogdata = Blog::where('id', $id)->first();
        return view('included.blog.show', compact('blogdata'));
    }
    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required'
        ], [
            "description.required" => trans('messages.enter_description'),
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if ($request->file("image") != "") {
                $blog = Blog::find($id);
                if (file_exists(storage_path("app/public/blogs/" . $blog->image))) {
                    unlink(storage_path("app/public/blogs/" . $blog->image));
                }
                $file = $request->file("image");
                $filename = 'blog_image-' . rand(11111, 99999) . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/blogs/', $filename);

                Blog::where('id', $id)->update(['image' => $filename]);
            }
            Blog::where('id', $id)
                ->update([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title),
                    'description' => $request->description
                ]);
            return redirect(route('blog'))->with('success', trans('messages.blog_update'));
        }
    }
    public function destroy(Request $request)
    {
        $success = Blog::where('id', $request->id)->update(['is_deleted' => 1]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function bulk_delete(Request $request)
    {
        foreach ($request->id as $id) {
            $success = Blog::where('id', $id)->update(['is_deleted' => 1]);
        }
        if ($success) {
            return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } else {
            return response()->json(['status' => 1, 'msg' => trans('messages.wrong')], 200);
        }
    }
    public function reorder_blog(Request $request)
    {
        $getblog = Blog::get();
        foreach ($getblog as $blog) {
            foreach ($request->order as $order) {
                $blog = Blog::where('id', $order['id'])->first();
                $blog->reorder_id = $order['position'];
                $blog->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }


    /* ----------------------------------- front -----------------------------------*/
    public function blog_list()
    {
        $blog_data = Blog::where('is_deleted', 2)->orderBy('reorder_id')->paginate(12);
        return view('front.included.blog_list', compact('blog_data'));
    }
    public function blog_detail($slug)
    {
        $blog_data = Blog::where('slug', $slug)->first();
        $relatad_blog_data = Blog::where('id', '!=', $blog_data->id)->where('is_deleted', 2)->orderBy('reorder_id')->get();
        $recent_blog_data = Blog::where('id', '!=', $blog_data->id)->where('is_deleted', 2)->take(5)->get();
        return view('front.included.blog_detail', compact('blog_data', 'relatad_blog_data', 'recent_blog_data'));
    }
}
