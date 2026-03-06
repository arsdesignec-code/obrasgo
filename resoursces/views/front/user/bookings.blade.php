@extends('front.layout.vendor_theme')
@section('page_title')
    {{ trans('labels.user') }} | {{ trans('labels.my_bookings') }}
@endsection
@section('front_content')
    <div class="col-12 col-md-12 col-lg-8 col-xl-9">
        <div class="card order-list">
            <div class="card-header border-bottom bg-transparent py-3 d-flex align-items-center justify-content-between">
                <h4 class="widget-title mb-0 color-changer">{{ trans('labels.my_bookings') }}</h4>
                <div class="col-auto">
                    <div class="sort-by">
                        <select class="form-select searchFilter fs-7" name="search_by" id="search_by"
                            url="{{ URL::to('/home/user/bookings') }}">
                            <option value="all" selected>{{ trans('labels.all') }}</option>
                            <option value="1">{{ trans('labels.pending') }}</option>
                            <option value="2">{{ trans('labels.inprogress') }}</option>
                            <option value="3">{{ trans('labels.completed') }}</option>
                            <option value="4">{{ trans('labels.cancelled') }}</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive bookings">
                    @include('front.user.booking_table')
                </div>
            </div>
        </div>
    </div>

    <!-- become provider -->
    @include('front.become_provider')
@endsection
