@extends('layout.main')
@section('page_title')
    {{ trans('labels.bookings') }} | {{ $bookingdata->booking_id }}
@endsection
@section('content')
<div class="container-fluid">
    <section id="list">
        <!-- Status track bar -->
        <div class="row match-height">
            <div class="col-sm-12 col-md-12">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="card-title m-0 fs-4 color-changer fw-600">{{ trans('labels.booking_details') }}
                    </h5>
                    <div class="d-flex gap-2">
                        @if (Auth::user()->type == 2)
                            <div class="dropdown lag-btn">
                                <button class="btn btn-secondary fs-15 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    @if ($bookingdata->status == 1)
                                        {{ trans('labels.pending') }}
                                    @elseif ($bookingdata->status == 2)
                                        @if ($bookingdata->handyman_id != '' && $bookingdata->handyman_accept == 1)
                                            {{ trans('labels.handyman_assigned') }}
                                        @else
                                            {{ trans('labels.accepted') }}
                                        @endif
                                    @elseif ($bookingdata->status == 3)
                                        @if ($bookingdata->handyman_id != '' && $bookingdata->handyman_accept == 1)
                                            {{ trans('labels.completed_by_handyman') }}
                                        @else
                                            {{ trans('labels.completed') }}
                                        @endif
                                    @elseif ($bookingdata->status == 4)
                                        @if ($bookingdata->canceled_by == 1)
                                            {{ trans('labels.cancel_by_you') }}
                                        @elseif($bookingdata->canceled_by == 2)
                                            {{ trans('labels.cancel_by_customer') }}
                                        @endif
                                    @endif
                                </button>
                                @if ($bookingdata->status == 1 || $bookingdata->status == 2)
                                    <ul class="dropdown-menu bg-body-secondary shadow border-0 p-0">
                                        <li>
                                            <a class="dropdown-item p-2 cursor-pointer booking_status"
                                                onclick="acceptbooking('{{ $bookingdata->id }}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/bookings/accept') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
                                                {{ trans('labels.accept') }}
                                            </a>
                                        </li>
                                        @if (!empty($ahandymandata) && ($bookingdata->handyman_accept == 2 || $bookingdata->handyman_id == ''))
                                            <li>
                                                <a class="dropdown-item p-2 cursor-pointer select_handyman booking_status"
                                                    data-bookingid="{{ $bookingdata->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#select_handyman">
                                                    {{ trans('labels.assign_handyman') }}
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item p-2 cursor-pointer booking_status"
                                                onclick="completebooking('{{ $bookingdata->id }}','3','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/bookings/complete') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
                                                {{ trans('labels.complete') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item p-2 cursor-pointer booking_status"
                                                onclick="cancelbooking('{{ $bookingdata->id }}','4','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/bookings/cancel') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
                                                {{ trans('labels.cancel') }}
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        @endif
                        @if (Auth::user()->type == 3)
                            <div class="dropdown lag-btn">
                                <button class="btn btn-secondary fs-15 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    @if ($bookingdata->status == 2)
                                        {{ trans('labels.pending') }}
                                    @elseif ($bookingdata->status == 3)
                                        {{ trans('labels.completed') }}
                                    @elseif ($bookingdata->handyman_accept == 2)
                                        {{ trans('labels.cancel_by_you') }}
                                    @endif
                                </button>
                                @if ($bookingdata->status == 2)
                                    <ul class="dropdown-menu bg-body-secondary shadow border-0 p-0">
                                        <li>
                                            <a class="dropdown-item p-2 cursor-pointer booking_status"
                                                onclick="completebooking('{{ $bookingdata->id }}','3','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/bookings/complete') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
                                                {{ trans('labels.complete') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item p-2 cursor-pointer booking_status"
                                                onclick="cancelbooking('{{ $bookingdata->id }}','','','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/bookings/cancel_by_handyman') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
                                                {{ trans('labels.cancel') }}
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        @endif
                        @if (@helper::checkaddons('google_calendar'))
                        
                            <td class="text-center">
                                @if ($bookingdata->status == 3 || $bookingdata->status == 4)
                                @else
                                    @if (Auth::user()->type == 2 || Auth::user()->type == 4)
                                        <a href="{{ URL::to('/bookings/googlesync-' . $bookingdata->booking_id . '/' . $bookingdata->provider_id . '/1') }}"
                                            class="btn btn-secondary header-btn-icon"
                                            tooltip="{{ trans('labels.google_calendar') }}">
                                            <i class="fa-solid fa-calendar"></i></a>
                    
                                    @endif

                                @endif
                                
                            </td>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Service info -->
        <div class="row g-4 pb-4">
            <div class="col-xl-8">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h5 class="text-capitalize color-changer">
                                    {{ trans('labels.service_booking') }}
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                        <div class="card card-bg shadow-none h-100">
                                            <div class="card-body">
                                                <p class="text-muted mb-2 fs-7">{{ trans('labels.name') }}</p>
                                                <p class="fs-7 color-changer">{{ $bookingdata->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                        <div class="card card-bg shadow-none h-100">
                                            <div class="card-body">
                                                <p class="text-muted mb-2 fs-7">{{ trans('labels.email') }}</p>
                                                <p class="fs-7 color-changer">{{ $bookingdata->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                        <div class="card card-bg shadow-none h-100">
                                            <div class="card-body">
                                                <p class="text-muted mb-2 fs-7">{{ trans('labels.mobile') }}</p>
                                                <p class="fs-7 color-changer">{{ $bookingdata->mobile }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                        <div class="card card-bg shadow-none h-100">
                                            <div class="card-body">
                                                <p class="text-muted mb-2 fs-7">{{ trans('labels.booking_status') }}</p>
                                                <p class="fs-7 color-changer">
                                                    @if ($bookingdata->status == 1)
                                                        <span
                                                            class="fs-7 text-warning fw-500 d-flex align-items-center gap-1">{{ trans('labels.pending') }}
                                                        </span>
                                                    @endif
                                                    @if ($bookingdata->status == 2)
                                                        <span
                                                            class="fs-7 text-secondary fw-500 d-flex align-items-center gap-1">
                                                            @if ($bookingdata->handyman_id != '')
                                                                {{ trans('labels.handyman_assigned') }}
                                                            @else
                                                                {{ trans('labels.accepted') }}
                                                            @endif
                                                        </span>
                                                    @endif
                                                    @if ($bookingdata->status == 3)
                                                        <span
                                                            class="text-success fs-7 fw-500 d-flex align-items-center gap-1">
                                                            {{ trans('labels.completed') }} </span>
                                                    @endif
                                                    @if ($bookingdata->status == 4)
                                                        <div class="d-flex gap-2">
                                                            <span
                                                                class="fs-7 text-danger fw-500 d-flex align-items-center gap-1">
                                                                @if ($bookingdata->canceled_by == 1)
                                                                    @if (Auth::user()->type == 2)
                                                                        {{ trans('labels.cancel_by_you') }}
                                                                    @else
                                                                        {{ trans('labels.cancel_by_provider') }}
                                                                    @endif
                                                                @elseif($bookingdata->canceled_by == 2)
                                                                    {{ trans('labels.cancel_by_customer') }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                        <div class="card card-bg shadow-none h-100">
                                            <div class="card-body">
                                                <p class="text-muted mb-2 fs-7">{{ trans('labels.date') }}</p>
                                                <p class="fs-7 color-changer">{{ helper::date_format($bookingdata->date) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                        <div class="card card-bg shadow-none h-100">
                                            <div class="card-body">
                                                <p class="text-muted mb-2 fs-7">{{ trans('labels.time') }}</p>
                                                <p class="fs-7 color-changer">{{ $bookingdata->time }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                        <div class="card card-bg shadow-none h-100">
                                            <div class="card-body">
                                                <p class="text-muted mb-2 fs-7">{{ trans('labels.total_amount') }}</p>
                                                <p class="fs-7 color-changer">{{ helper::currency_format($bookingdata->total_amt) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($bookingdata->transaction_id != '' && $invoice->transaction_id != null)
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                        <div class="card card-bg shadow-none h-100">
                                            <div class="card-body">
                                                <p class="text-muted mb-2 fs-7">{{ trans('labels.payment_methods') }}</p>
                                                <p class="fs-7 color-changer">
                                                    {{ helper::getpayment($bookingdata->payment_type) }}
                                                    @if ($bookingdata->payment_type == 16)
                                                        <a href="{{ helper::image_path($bookingdata->screenshot) }}"
                                                            target="_blank"
                                                            class="text-danger">{{ trans('labels.click_here') }}</a>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if (@helper::checkaddons('vendor_tip'))
                                        @if (@helper::otherdata()->tips_settings == 1)
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                                <div class="card card-bg shadow-none h-100">
                                                    <div class="card-body">
                                                        <p class="text-muted mb-2 fs-7">{{ trans('labels.tips_pro') }}</p>
                                                        <p class="fs-7 color-changer">
                                                            {{ helper::currency_format($bookingdata->tips) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="card card-bg shadow-none h-100">
                                            <div class="card-body">
                                                <p class="text-muted mb-2 fs-7">{{ trans('labels.address') }}</p>
                                                <p class="fs-7 color-changer truncate-2">{{ strip_tags($bookingdata->address) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($bookingdata->note != '' || $bookingdata->note != null)
                                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="card card-bg shadow-none h-100">
                                                <div class="card-body">
                                                    <p class="text-muted mb-2 fs-7">{{ trans('labels.notes') }}</p>
                                                    <p class="fs-7 color-changer truncate-2">{{ strip_tags($bookingdata->note) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-4">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ helper::image_path($bookingdata->customer_image) }}"
                                                class="rounded-circle object-fit-cover" width="65px" height="65px" />
                                            <div class="">
                                                <p class="fs-13 text-secondary mb-1 fw-500">{{ trans('labels.customer') }}
                                                </p>
                                                <h6 class="fw-600 color-changer fs-15 m-0 truncate-1">{{ $bookingdata->name }}
                                                </h6>
                                            </div>
                                        </div>
                                        <ul class="d-flex flex-column gap-2 mt-3">
                                            <li class="d-flex color-changer gap-2 align-items-center">
                                                <span class="fs-7">
                                                    <i class="ft-phone"></i>
                                                </span>
                                                <span class="fs-7">
                                                    {{ $bookingdata->mobile }}
                                                </span>
                                            </li>
                                            <li class="d-flex color-changer gap-2 align-items-center">
                                                <span class="fs-7">
                                                    <i class="ft-mail"></i>
                                                </span>
                                                <span class="fs-7">
                                                    {{ $bookingdata->email }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if (Auth::user()->type == 1)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <a href="{{ URL::to('/providers/' . $bookingdata->provider_slug) }}">
                                                    <img src="{{ helper::image_path($bookingdata->provider_image) }}"
                                                        class="rounded-circle object-fit-cover" width="65px"
                                                        height="65px" />
                                                </a>
                                                <div class="">
                                                    <p class="fs-13 text-secondary mb-1 fw-500">
                                                        {{ trans('labels.provider') }}</p>
                                                    <h6 class="fw-600 color-changer fs-15 m-0 truncate-1">
                                                        {{ $bookingdata->provider_name }}</h6>
                                                </div>
                                            </div>
                                            <ul class="d-flex flex-column gap-2 mt-3">
                                                <li class="d-flex color-changer gap-2 align-items-center">
                                                    <span class="fs-7">
                                                        <i class="ft-phone"></i>
                                                    </span>
                                                    <span class="fs-7">
                                                        {{ $bookingdata->provider_mobile }}
                                                    </span>
                                                </li>
                                                <li class="d-flex color-changer gap-2 align-items-center">
                                                    <span class="fs-7">
                                                        <i class="ft-mail"></i>
                                                    </span>
                                                    <span class="fs-7">
                                                        {{ $bookingdata->provider_email }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($bookingdata->handyman_id != '')
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ helper::image_path($bookingdata->handyman_image) }}"
                                                    class="rounded-circle object-fit-cover" width="65px" height="65px"
                                                    data-enlargeable />
                                                <div class="">
                                                    <p class="fs-13 text-secondary mb-1 fw-500">
                                                        {{ trans('labels.handyman') }}</p>
                                                    <h6 class="fw-600 color-changer fs-15 m-0 truncate-1">
                                                        {{ $bookingdata->handyman_name }}</h6>
                                                </div>
                                            </div>
                                            <ul class="d-flex flex-column gap-2 mt-3">
                                                <li class="d-flex gap-2 color-changer align-items-center">
                                                    <span class="fs-7">
                                                        <i class="ft-phone"></i>
                                                    </span>
                                                    <span class="fs-7">
                                                        {{ $bookingdata->handyman_mobile }}
                                                    </span>
                                                </li>
                                                <li class="d-flex gap-2 color-changer align-items-center">
                                                    <span class="fs-7">
                                                        <i class="ft-mail"></i>
                                                    </span>
                                                    <span class="fs-7">
                                                        {{ $bookingdata->handyman_email }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <h5 class="color-changer">{{ trans('labels.service') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex custom-wrap gap-3 mb-2">
                            <div class="col-auto">
                                <img src="{{ helper::image_path($bookingdata->service_image) }}"
                                    class="rounded zoom-in object-fit-cover" width="130px" height="130px"
                                    data-enlargeable />
                            </div>
                            <div class="media-body w-100">
                                <div class="col-md-12">
                                    <div class="border-bottom mb-2 pb-2">
                                        <h5 class="fw-500 color-changer fs-6 m-0 truncate-2">
                                            {{ $bookingdata->service_name }}
                                        </h5>
                                    </div>
                                    <div class="col-12">
                                        <ul class="list-unstyled">
                                            <li class="">
                                                <p class="fs-7 color-changer mb-2">
                                                    {{ trans('labels.description') }}
                                                </p>
                                                <p class="truncate-2 fs-7 text-muted">
                                                    {{ Str::limit(strip_tags($bookingdata->description), 350) }}
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="row g-3">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6">
                                        <ul class="list-unstyled">
                                            <li class="">
                                                <p class="fs-7 text-muted mb-2">
                                                    {{ trans('labels.price') }}
                                                </p>
                                                <p class="d-block overflow-hidden color-changer fs-7 fw-500">
                                                    {{ helper::currency_format($bookingdata->price) }}
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6">
                                        <ul class="list-unstyled">
                                            <li class="">
                                                <p class="fs-7 text-muted mb-2">
                                                    {{ trans('labels.duration') }}
                                                </p>
                                                <p class="d-block color-changer overflow-hidden fs-7 fw-500">
                                                    @if ($bookingdata->price_type == 'Fixed')
                                                        @if ($bookingdata->duration_type == 1)
                                                            {{ $bookingdata->duration . trans('labels.minutes') }}
                                                        @elseif ($bookingdata->duration_type == 2)
                                                            {{ $bookingdata->duration . trans('labels.hours') }}
                                                        @elseif ($bookingdata->duration_type == 3)
                                                            {{ $bookingdata->duration . trans('labels.days') }}
                                                        @else
                                                            {{ $bookingdata->duration }}
                                                        @endif
                                                    @else
                                                        {{ $bookingdata->price_type }}
                                                    @endif
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <ul class="list-unstyled">
                                            <li class="">
                                                <p class="fs-7 text-muted mb-2">
                                                    {{ trans('labels.category') }}
                                                </p>
                                                <p class="d-block color-changer overflow-hidden fs-7 fw-500">
                                                    {{ $bookingdata->category_name }}
                                                </p>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-header border-bottom mb-2">
                        <h5 class="card-title color-changer m-0">{{ trans('labels.payment_details') }}</h5>
                    </div>
                    <div class="card-body p-3 py-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-3 bg-transparent">
                                <div class="d-flex color-changer justify-content-between">
                                    <p class="fs-7">{{ trans('labels.sub_total') }}</p>
                                    <p class="fs-7">{{ helper::currency_format($bookingdata->price) }}</p>
                                </div>
                            </li>
                            @if ($bookingdata->discount != null)
                                <li class="list-group-item p-3 bg-transparent">
                                    <div class="d-flex color-changer justify-content-between">
                                        <p class="fs-7">{{ trans('labels.discount') }}</p>
                                        <p class="fs-7">{{ helper::currency_format($bookingdata->discount) }}</p>
                                    </div>
                                </li>
                            @endif
                            @if ($bookingdata->tax != null && $bookingdata->tax_name != null)
                                @php
                                    $tax = explode('|', $bookingdata->tax);
                                    $tax_name = explode('|', $bookingdata->tax_name);
                                @endphp
                                @foreach ($tax_name as $key => $taxes)
                                    <li class="list-group-item p-3 bg-transparent">
                                        <div class="d-flex color-changer justify-content-between">
                                            <p class="fs-7">{{ $taxes }}</p>
                                            <p class="fs-7">{{ helper::currency_format($tax[$key]) }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                            <li class="list-group-item p-3 bg-transparent">
                                <div class="d-flex justify-content-between">
                                    <p class="fw-600 fs-6 text-success">{{ trans('labels.total') }}</p>
                                    <p class="fw-600 fs-6 text-success">
                                        {{ helper::currency_format($bookingdata->total_amt) }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('resources/views/booking/booking.js') }}" type="text/javascript"></script>
@endsection
