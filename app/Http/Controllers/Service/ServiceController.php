<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\GalleryImages;
use App\Models\Service;
use App\Models\Rattings;
use App\Models\Booking;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Str;

class ServiceController extends Controller
{
    public function index()
    {
        if (Auth::user()->type == 1) {
            $servicedata = Service::where('is_deleted', 2)->orderBy('id', 'DESC')->get();
        } elseif (Auth::user()->type == 2) {

            $servicedata = Service::where('provider_id', Auth::user()->id)->where('is_deleted', 2)->orderBy('reorder_id')->get();
        }
        return view('service.index', compact('servicedata'));
    }
    public function add()
    {
        $categorydata = Category::where('is_deleted', 2)->where('is_available', 1)->orderBy('id', 'DESC')->get();
        $taxdata = Tax::where('provider_id', Auth::user()->id)->where('status', 1)->get();
        return view('service.add', compact('categorydata', 'taxdata'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ],  [
            'description.required' => trans('messages.enter_description'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $file = $request->file("image");
            $filename = 'service-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/service/', $filename);

            $checkslug = Service::where('slug', Str::slug($request->name, '-'))->first();
            if ($checkslug != "") {
                $last = Service::select('id')->orderByDesc('id')->first();
                $create = $request->name . " " . ($last->id + 1);
                $slug =   Str::slug($create, '-');
            } else {
                $slug = Str::slug($request->name, '-');
            }
            $description = $request->description;
            $service = new Service();
            $service->name = $request->name;
            $service->image = $filename;
            $service->category_id = $request->category_id;
            $service->provider_id = Auth::user()->id;
            $service->price = $request->price;
            $service->discount = $request->discount;
            $service->price_type = $request->price_type;
            $service->description = $description;
            $service->tax = $request->tax == null ? null : @implode('|', $request->tax);
            if ($request->price_type == "Fixed") {
                $service->duration = $request->duration;
                $service->duration_type = $request->duration_type;
            }
            if ($request->is_featured) {
                $service->is_featured = 1;
            } else {
                $service->is_featured = 2;
            }
            if ($request->is_top_deals) {
                $service->is_top_deals = 1;
            } else {
                $service->is_top_deals = 2;
            }
            $service->slug = $slug;
            $service->is_available = 1;
            $service->is_deleted = 2;
            $service->save();

            foreach ($request->file('gallery_image') as $img) {
                $filename = 'gallery-' . rand(0, 99999) . "." . $img->getClientOriginalExtension();
                $img->move(storage_path() . '/app/public/service/', $filename);

                $g = new GalleryImages();
                $g->service_id = $service->id;
                $g->image = $filename;
                $g->save();
            }


            return redirect(route('services'))->with('success', trans('messages.service_added'));
        }
    }
    public function is_featured(Request $request)
    {
        $success = Service::where('id', $request->id)->update(['is_featured' => $request->is_featured]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function is_top_deals(Request $request)
    {
        $success = Service::where('id', $request->id)->update(['is_top_deals' => $request->is_top_deals]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function status(Request $request)
    {
        $success = Service::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function destroy(Request $request)
    {
        $success = Service::where('id', $request->id)->update(['is_deleted' => 1]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function bulk_delete(Request $request)
    {
        foreach ($request->id as $id) {
            $success = Service::where('id', $id)->update(['is_deleted' => 1]);
        }
        if ($success) {
            return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } else {
            return response()->json(['status' => 0, 'msg' => trans('messages.wrong')], 200);
        }
    }

    public function show($service)
    {
        $servicedata = Service::where('slug', $service)->first();

        if ($servicedata->provider_id == Auth::user()->id) {
            $categorydata = Category::where('id', '!=', $servicedata['categoryname']->id)->where('is_available', 1)->where('is_deleted', 2)->get();

            $gimages = GalleryImages::where('service_id', $servicedata->id)->get();
            $taxdata = Tax::where('provider_id', Auth::user()->id)->where('status', 1)->get();
            return view('service.show', compact('servicedata', 'categorydata', 'gimages', 'taxdata'));
        } else {
            return redirect()->back()->with('error', trans('messages.invalid_access'));
        }
    }
    public function edit(Request $request, $service)
    {
        $sdata = Service::select('id')->where('slug', $service)->first();
        if ($request->price_type == "Fixed") {
            Service::where('slug', $service)->update([
                'duration' => $request->duration,
                'duration_type' =>  $request->duration_type,
            ]);
        } else {
            Service::where('slug', $service)->update([
                'duration' => null,
                'duration_type' =>  null,
            ]);
        }
        if ($request->file("image") != "") {
            $validator = Validator::make(
                $request->all(),
                ['image' => 'required'],
                [
                    'image.required' => trans('messages.enter_image'),
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $rec = Service::where('slug', $service)->first();
                if (file_exists(storage_path("app/public/service/" . $rec->image))) {
                    unlink(storage_path("app/public/service/" . $rec->image));
                }
                $file = $request->file("image");
                $filename = 'service-' . time() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path() . '/app/public/service/', $filename);

                Service::where('slug', $service)->update(['image' => $filename]);
            }
        }
        if ($request->is_available) {
            $status = 1;
        } else {
            $status = 2;
        }
        if ($request->is_featured) {
            $featured = 1;
        } else {
            $featured = 2;
        }
        if ($request->is_top_deals) {
            $top_deals = 1;
        } else {
            $top_deals = 2;
        }
        $checkslug = Service::where('slug', Str::slug($request->name, '-'))->where('id', '!=', $sdata->id)->first();
        if ($checkslug != "") {
            $last = Service::select('id')->orderByDesc('id')->first();
            $create = $request->name . " " . ($last->id + 1);
            $slug =   Str::slug($create, '-');
        } else {
            $slug = Str::slug($request->name, '-');
        }
        $description = $request->description;
        Service::where('slug', $service)->update([
            'name' =>  $request->name,
            'category_id' =>  $request->category_id,
            'price' =>  $request->price,
            'discount' =>  $request->discount,
            'price_type' =>  $request->price_type,
            'description' =>  $description,
            'slug' => $slug,
            'is_featured' =>  $featured,
            'is_top_deals' =>  $top_deals,
            // 'is_available' =>  $status,
            'tax' => $request->tax == null ? null : @implode('|', $request->tax)

        ]);

        return redirect(route('services'))->with('success', trans('messages.service_updated'));
    }
    public function fetch_service(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query1 = $request->get('query');

            $query = Service::query();

            $query = $query->join('categories', 'services.category_id', 'categories.id')->select('services.*', 'categories.name as category_name')->where('services.is_deleted', 2);

            if ($query1 != '') {
                if (Auth::user()->type == 2) {
                    $query = $query->where('services.provider_id', Auth::user()->id);
                } elseif ($request->get('provider') != "") {
                    $query = $query->where('services.provider_id', $request->get('provider'));
                }
                $query = $query->where(function ($query) use ($query1) {
                    $query->where('services.name', 'like', '%' . $query1 . '%')
                        ->orWhere('categories.name', 'like', '%' . $query1 . '%')
                        ->orWhere('services.price', 'like', '%' . $query1 . '%')
                        ->orWhere('services.duration', 'like', '%' . $query1 . '%')
                        ->orWhere('services.discount', 'like', '%' . $query1 . '%');
                });
            } else {
                if (Auth::user()->type == 2) {
                    $query = $query->where('services.provider_id', Auth::user()->id);
                } elseif ($request->get('provider') != "") {
                    $query = $query->where('services.provider_id', $request->get('provider'));
                }
            }
            $servicedata = $query->paginate(10);
            return view('service.service_table', compact('servicedata'))->render();
        }
    }
    public function service($service, Request $request)
    {
        $servicedata = Service::with('rattings')
            ->join('categories', 'services.category_id', '=', 'categories.id')
            ->join('users', 'services.provider_id', '=', 'users.id')
            ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
            ->select(
                'services.id as service_id',
                'services.name as service_name',
                'services.price',
                'services.price_type',
                'services.duration',
                'services.duration_type',
                'services.provider_id as porvider_id',
                'services.description',
                'services.discount',
                'services.slug',
                'services.is_available',
                'categories.id as category_id',
                'categories.name as category_name',
                'users.name as provider_name',
                'users.slug as provider_slug',
                'users.email as provider_email',
                'users.mobile as provider_mobile',
                'users.about as provider_about',
                'users.is_available as provider_status',
                'provider_types.name as provider_type',
                'categories.name as category_name',
                'services.image as service_image',
                'users.image as provider_image',
                DB::raw('YEAR(services.created_at) AS year'),
                DB::raw('DATE(services.created_at) AS date')
            )
            ->where('services.slug', $service)
            ->where('services.is_deleted', 2)
            ->first();
        $serviceaverageratting = Rattings::select(DB::raw('ROUND(avg(rattings.ratting),2) as avg_ratting'))
            ->where('service_id', $servicedata->service_id)
            ->first();

        $total_bookings = Booking::where('service_id', $servicedata->service_id)->count();
        $total_pending = Booking::where('service_id', $servicedata->service_id)->where('status', 1)->count();
        $total_completed = Booking::where('service_id', $servicedata->service_id)->where('status', 3)->count();
        $total_canceled = Booking::where('service_id', $servicedata->service_id)->where('status', 4)->count();
        $total_earning = DB::table('bookings')->where('service_id', $servicedata->service_id)->where('status', 3)->sum('total_amt');
        $total_pending_earning = DB::table('bookings')->where('service_id', $servicedata->service_id)->where('status', 2)->sum('total_amt');


        // bookings-chart-start 
        $years = Booking::select(DB::raw("YEAR(created_at) as year"))->orderByDesc('created_at')->where('service_id', $servicedata->service_id)->groupBy(DB::raw("YEAR(created_at)"))->get();
        $bookings = Booking::select(DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("YEAR(created_at) as years"), DB::raw("COUNT(*) data"))
            ->groupBy(DB::raw("YEAR(created_at)"), DB::raw("MONTHNAME(created_at)"))
            ->orderBy('created_at')
            ->where('status', 3)
            ->where('service_id', $servicedata->service_id);
        if ($request->has('year') && $request->year != "") {
            $bookings = $bookings->where(DB::raw("YEAR(created_at)"), '=', $request->year);
        } else {
            $bookings = $bookings->where(DB::raw("YEAR(created_at)"), '=', date('Y'));
        }
        $bookings = $bookings->get();
        $result[] = ['Month', 'Total'];
        foreach ($bookings as $key => $value) {
            $result[++$key] = [$value->month_name, (int)$value->data];
        }
        // bookings-chart-end

        if ($request->ajax()) {
            echo json_encode($result);
        } else {
            $booking = json_encode($result);
            return view("service.service_details", compact('years', 'servicedata', 'serviceaverageratting', 'total_bookings', 'total_canceled', 'total_pending', 'total_completed', 'total_earning', 'total_pending_earning', 'booking'));
        }
    }
    public function reorder(Request $request)
    {
        $getservice = Service::get();
        foreach ($getservice as $service) {
            foreach ($request->order as $order) {
                $service = Service::where('id', $order['id'])->first();
                $service->reorder_id = $order['position'];
                $service->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
