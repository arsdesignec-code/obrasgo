@extends('front.layout.vendor_theme')
@section('page_title')
    {{ trans('labels.user') }} | {{ trans('labels.booking_details') }}
@endsection

@section('front_content')
    <div class="col-12 {{ Auth::user() && Auth::user()->type == 4 ? 'col-lg-8 col-xl-9' : '' }}">
        <div class="row g-4 match-height justify-content-between">
            @if (!empty($bookingdata))
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom bg-transparent py-3">
                            <h5 class="widget-title color-changer text-capitalize m-0">
                                {{ trans('labels.booking_id') }} : {{ strtoupper($bookingdata->booking_id) }}
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                    <div class="card card-bg border-0 h-100">
                                        <div class="card-body">
                                            <p class="text-muted mb-2 fs-7">{{ trans('labels.name') }}</p>
                                            <p class="fs-7 color-changer m-0">{{ $bookingdata->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                    <div class="card card-bg border-0 h-100">
                                        <div class="card-body">
                                            <p class="text-muted mb-2 fs-7">{{ trans('labels.email') }}</p>
                                            <p class="fs-7 color-changer m-0">{{ $bookingdata->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                    <div class="card card-bg border-0 h-100">
                                        <div class="card-body">
                                            <p class="text-muted mb-2 fs-7">{{ trans('labels.mobile') }}</p>
                                            <p class="fs-7 color-changer m-0">{{ $bookingdata->mobile }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                    <div class="card card-bg border-0 h-100">
                                        <div class="card-body">
                                            <p class="text-muted mb-2 fs-7">{{ trans('labels.booking_status') }}</p>
                                            <div class="d-flex gap-2">
                                                @if ($bookingdata->status == 1)
                                                    <p class="fs-7 text-warning fw-500 gap-1 m-0">
                                                        {{ trans('labels.pending') }}
                                                    </p>
                                                @elseif ($bookingdata->status == 2)
                                                    <p class="fs-7 text-info fw-500 gap-1 m-0">
                                                        {{ trans('labels.accepted') }}</p>
                                                @elseif ($bookingdata->status == 3)
                                                    <p class="fs-7 text-success fw-500 gap-1 m-0">
                                                        {{ trans('labels.completed') }}</p>
                                                @elseif ($bookingdata->status == 4)
                                                    <p class="fs-7 text-danger fw-500 gap-1 m-0">
                                                        @if ($bookingdata->canceled_by == 1)
                                                            {{ trans('labels.canceled_by_provider') }}
                                                        @else
                                                            {{ trans('labels.canceled_by_you') }}
                                                        @endif
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                    <div class="card card-bg border-0 h-100">
                                        <div class="card-body">
                                            <p class="text-muted mb-2 fs-7">{{ trans('labels.date') }}</p>
                                            <p class="fs-7 color-changer m-0">{{ helper::date_format($bookingdata->date) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                    <div class="card card-bg border-0 h-100">
                                        <div class="card-body">
                                            <p class="text-muted mb-2 fs-7">{{ trans('labels.time') }}</p>
                                            <p class="fs-7 color-changer m-0">{{ $bookingdata->time }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                    <div class="card card-bg border-0 h-100">
                                        <div class="card-body">
                                            <p class="text-muted mb-2 fs-7">{{ trans('labels.total_amount') }}</p>
                                            <p class="fs-7 color-changer m-0">
                                                {{ helper::currency_format($bookingdata->total_amt) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                    <div class="card card-bg border-0 h-100">
                                        <div class="card-body">
                                            <p class="text-muted mb-2 fs-7">{{ trans('labels.payment_methods') }}</p>
                                            <p class="fs-7 color-changer m-0">
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
                                @if (@helper::checkaddons('vendor_tip'))
                                    @if (@helper::otherdata()->tips_settings == 1)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                            <div class="card card-bg border-0 h-100">
                                                <div class="card-body">
                                                    <p class="text-muted mb-2 fs-7">{{ trans('labels.tips_pro') }}</p>
                                                    <p class="fs-7 color-changer m-0">
                                                        {{ helper::currency_format($bookingdata->tips) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card card-bg border-0 h-100">
                                        <div class="card-body">
                                            <p class="text-muted mb-2 fs-7">{{ trans('labels.address') }}</p>
                                            <p class="fs-7 color-changer truncate-2 m-0">{{ strip_tags($bookingdata->address) }}</p>
                                        </div>
                                    </div>
                                </div>
                                @if ($bookingdata->note != '' || $bookingdata->note != null)
                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="card card-bg border-0 h-100">
                                            <div class="card-body">
                                                <p class="text-muted mb-2 fs-7">{{ trans('labels.notes') }}</p>
                                                <p class="fs-7 color-changer truncate-2 m-0">
                                                    {{ strip_tags($bookingdata->note) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- servive details -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom bg-transparent py-3">
                            <div class="d-flex gap-3 flex-wrap align-items-center justify-content-between">
                                <h5 class="widget-title color-changer m-0">{{ trans('labels.service') }}</h5>
                                <div class="row align-items-center g-2">
                                    @if (@helper::checkaddons('whatsapp_message'))
                                        @if (whatsapp_helper::whatsapp_message_config()->booking_created == 1)
                                            @if (whatsapp_helper::whatsapp_message_config()->message_type == 2)
                                                <div class="col-sm-auto col-12">
                                                    <a href="https://api.whatsapp.com/send?phone={{ whatsapp_helper::whatsapp_message_config()->whatsapp_number }}&text={{ @$whmessage }}"
                                                        class="btn bg-success text-white btn-md py-2 d-flex justify-content-center align-items-center gap-2 rounded w-100 fs-7 float-right fw-500"
                                                        target="_blank">
                                                        <i class="fab fa-whatsapp"></i>
                                                        {{ trans('labels.send_booking_on_whatsapp') }}
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                    @if (@helper::checkaddons('telegram_message'))
                                        @if (helper::telegramdata()->booking_created == 1)
                                            <div class="col-sm-auto col-12">
                                                <a href="{{ URL::to('telegram/' . $bookingdata->booking_id) }}"
                                                    class="btn bg-info text-white btn-md py-2 d-flex justify-content-center align-items-center gap-2 rounded w-100 fs-7 float-right fw-500">
                                                    <i class="fab fa-telegram"></i>
                                                    {{ trans('labels.send_booking_on_telegram') }}
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                    @if (@helper::checkaddons('ical_export'))
                                        <div class="col-sm-auto col-12">
                                            <a  href="{{ URL::to('/home/user/icalfile/' . $bookingdata->booking_id) }}"
                                                class="btn bg-warning text-white btn-md py-2 d-flex justify-content-center align-items-center gap-2 rounded w-100 fs-7 float-right fw-500"">
                                               <i class="fa-solid fa-download"></i> {{ trans('labels.download_ical_file') }}
                                            </a>
                                        </div>
                                    @endif  
                                   
                                    @if ($bookingdata->status == 1)
                                        <div class="col-sm-auto col-12">
                                            <a class="btn btn-md py-2 d-flex align-items-center gap-2 justify-content-center rounded w-100 fs-7 bg-danger text-white float-right fw-500"
                                                onclick="cancelbooking('{{ $bookingdata->booking_id }}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/home/user/bookings/cancel') }}','{{ trans('messages.wrong') }} :(','{{ trans('messages.record_safe') }}')">
                                                <i class="fas fa-close"></i>
                                                {{ trans('labels.cancel_booking') }}
                                            </a>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('product_review'))
                                        @if (@helper::appdata()->review_approved_status == 1)
                                            @if ($bookingdata->is_rated == 0 && $bookingdata->status == 3 && Auth::user() && Auth::user()->type == 4)
                                                <div class="col-sm-auto col-12">
                                                    <a class="btn btn-md py-2 d-flex align-items-center gap-2 rounded w-100 fs-7 bg-warning text-white float-right fw-500"
                                                        data-bs-toggle="modal" data-bs-target="#add-rattings">
                                                        <i class="fas fa-star"></i>
                                                        {{ trans('labels.add_rattings') }}
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex custom-wrap gap-3 mb-2">
                                <div class="col-auto">
                                    <img src="{{ helper::image_path($bookingdata->service_image) }}"
                                        class="rounded booking-sevirce-img" data-enlargeable="">
                                </div>
                                <div class="media-body w-100">
                                    <div class="col-md-12">
                                        <div class="d-flex flex-wrap justify-content-between border-bottom mb-2 pb-2">
                                            <a class="text-dark color-changer"
                                                href="{{ URL::to('/home/service-details/' . $bookingdata->service_slug) }}">
                                                <h5 class="fw-500 fs-6 m-0 truncate-2">
                                                    {{ $bookingdata->service_name }}
                                                </h5>
                                            </a>
                                            @if (@helper::checkaddons('product_review'))
                                                @if (@helper::appdata()->review_approved_status == 1)
                                                    <p class="d-flex align-items-center gap-1 m-0">
                                                        <i class="fa-solid fa-star text-warning fs-7"></i>
                                                        <span class="fs-7 color-changer fw-500">
                                                            {{ helper::getaverageratting($bookingdata->service_id) }}
                                                        </span>
                                                    </p>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-12">
                                            <ul class="list-unstyled">
                                                <li class="">
                                                    <p class="fs-7 text-dark color-changer mb-2">
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
                                                    <p class="d-block overflow-hidden color-changer fs-7 fw-500 mb-0">
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
                                                    <p class="d-block overflow-hidden color-changer fs-7 fw-500 mb-0">
                                                        @if ($bookingdata->price_type == 'Fixed')
                                                            @if ($bookingdata->duration_type == 1)
                                                                {{ $bookingdata->duration . trans('labels.minutes') }}
                                                            @elseif ($bookingdata->duration_type == 2)
                                                                {{ $bookingdata->duration . trans('labels.hours') }}
                                                            @elseif ($bookingdata->duration_type == 3)
                                                                {{ $bookingdata->duration . trans('labels.days') }}
                                                            @else
                                                                {{ $bookingdata->duration . trans('labels.minutes') }}
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
                                                    <p class="d-block overflow-hidden color-changer fs-7 fw-500 mb-0">
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
                </div>

                <!-- Date & Time -->


                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center gap-3">
                                <a href="{{ URL::to('/home/providers-services/' . $bookingdata->provider_slug) }}">
                                    <img src="{{ helper::image_path($bookingdata->provider_image) }}"
                                        class="rounded-circle profile_sevirce_img object-fit-cover" width="65px"
                                        height="65px" alt="{{ trans('labels.provider_image') }}">
                                </a>
                                <div class="">
                                    <p class="fs-13 text-primary mb-1 fw-500">
                                        {{ trans('labels.provider') }}
                                    </p>
                                    <h6 class="fw-600 fs-15 color-changer m-0 truncate-1">
                                        {{ $bookingdata->provider_name }}
                                    </h6>
                                </div>
                            </div>
                            <ul class="d-flex flex-column gap-2 mt-3">
                                <li class="d-flex color-changer gap-2 align-items-center">
                                    <span class="fs-7">
                                        <i class="fa-regular fa-phone-flip"></i>
                                    </span>
                                    <span class="fs-7">
                                        {{ $bookingdata->provider_mobile }}
                                    </span>
                                </li>
                                <li class="d-flex color-changer gap-2 align-items-center">
                                    <span class="fs-7">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>
                                    <span class="fs-7">
                                        {{ $bookingdata->provider_email }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                @if ($bookingdata->handyman_id != '' && $bookingdata->handyman_accept == 1)
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ helper::image_path($bookingdata->handyman_image) }}"
                                        class="rounded-circle profile_sevirce_img object-fit-cover" width="65px"
                                        height="65px" alt="{{ trans('labels.handyman_image') }}">
                                    <div class="">
                                        <p class="fs-13 text-primary mb-1 fw-500">
                                            {{ trans('labels.handyman') }}
                                        </p>
                                        <h6 class="fw-600 fs-15 color-changer m-0 truncate-1">
                                            {{ $bookingdata->handyman_name }}
                                        </h6>
                                    </div>
                                </div>
                                <ul class="d-flex flex-column gap-2 mt-3">
                                    <li class="d-flex gap-2 color-changer align-items-center">
                                        <span class="fs-7">
                                            <i class="fa-regular fa-phone-flip"></i>
                                        </span>
                                        <span class="fs-7">
                                            {{ $bookingdata->handyman_mobile }}
                                        </span>
                                    </li>
                                    <li class="d-flex gap-2 color-changer align-items-center">
                                        <span class="fs-7">
                                            <i class="fa-regular fa-envelope"></i>
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

                <!-- Payment Details -->
                <div class="col-xl-4 col-12">
                    <div class="card">
                        <div class="card-header border-bottom bg-transparent py-3">
                            <h5 class="widget-title m-0">
                                <span class="text-dark color-changer">{{ trans('labels.payment_details') }}</span>
                            </h5>
                        </div>
                        <div class="card-body pt-0">
                            <div class="plan-det">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item py-3 px-0">
                                        <p class="text-muted m-0">{{ trans('labels.sub_total') }}</p>
                                        <span class="color-changer">{{ helper::currency_format($bookingdata->price) }}</span>
                                    </li>
                                    @if ($bookingdata->discount != null)
                                        <li class="list-group-item py-3 px-0">
                                            <p class="text-muted m-0">
                                                {{ trans('labels.discount') }}({{ $bookingdata->coupon_code }})</p>
                                            <span class="color-changer">{{ helper::currency_format($bookingdata->discount) }}</span>
                                        </li>
                                    @endif
                                    @if ($bookingdata->tax != null && $bookingdata->tax_name != null)
                                        @php
                                            $tax = explode('|', $bookingdata->tax);
                                            $tax_name = explode('|', $bookingdata->tax_name);
                                        @endphp
                                        @foreach ($tax_name as $key => $taxes)
                                            <li class="list-group-item py-3 px-0">
                                                <p class="text-muted m-0">{{ $taxes }}</p>
                                                <span class="color-changer">{{ helper::currency_format($tax[$key]) }}</span>
                                            </li>
                                        @endforeach
                                    @endif
                                    <li class="list-group-item pt-3 pb-0 px-0 totle text-success">
                                        <p class="m-0">{{ trans('labels.total') }}</p>
                                        <span class="color-changer">{{ helper::currency_format($bookingdata->total_amt) }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Booking Payment Method-->
                @if (helper::allpaymentcheckaddons())
                    @if (count($paymethods) > 0 || $walletpaymethods)
                        @if ($bookingdata->payment_status == 1 && $bookingdata->payment_type == 1)
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header border-bottom bg-transparent py-3">
                                        <h5 class="widget-title color-changer m-0">{{ trans('labels.payment') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <form class="row grid-wrapper grid-col-auto g-3 recharge_payment_option">
                                            <!-- new payment -->
                                            @foreach ($paymethods as $methods)
                                                @php
                                                    // Check if the current $pmdata is a system addon and activated
                                                    $systemAddonActivated = false;

                                                    $addon = App\Models\SystemAddons::where(
                                                        'unique_identifier',
                                                        $methods->unique_identifier,
                                                    )->first();
                                                    if ($addon != null && $addon->activated == 1) {
                                                        $systemAddonActivated = true;
                                                    }
                                                @endphp
                                                @if ($systemAddonActivated)
                                                    <div class="col-12 col-sm-6 col-xl-4 col-lg-6">
                                                        <label for="{{ $methods->payment_name }}"
                                                            class="radio-card card h-100 cp">
                                                            <input class="custom-control-input"
                                                                id="{{ $methods->payment_name }}"
                                                                data-payment_type="{{ $methods->id }}" name="payment"
                                                                type="radio">
                                                            <div
                                                                class="card-content-wrapper p-3 m-0 border-0 d-flex gap-3 align-items-center">
                                                                <span class="check-icon"></span>
                                                                <div class="d-flex gap-2 align-items-center">

                                                                    <div class="rounded-3 payment_option_img">
                                                                        <img src="{{ helper::image_path($methods->image) }}"
                                                                            class="h-100" alt="knjbhv" />
                                                                    </div>
                                                                    <p class="m-0 text-capitalize fs-7 color-changer     fw-500">
                                                                        {{ $methods->payment_name }}</p>
                                                                    @if ($methods->payment_type == 3)
                                                                        <input type="hidden" name="razorpay"
                                                                            id="razorpay"
                                                                            value="{{ $methods->public_key }}">
                                                                    @endif

                                                                    @if ($methods->payment_type == 4)
                                                                        <input type="hidden" name="stripe"
                                                                            id="stripe"
                                                                            value="{{ $methods->public_key }}">
                                                                    @endif

                                                                    @if ($methods->payment_type == 5)
                                                                        <input type="hidden" name="flutterwave"
                                                                            id="flutterwave"
                                                                            value="{{ $methods->public_key }}">
                                                                    @endif

                                                                    @if ($methods->payment_type == 6)
                                                                        <input type="hidden" name="paystack"
                                                                            id="paystack"
                                                                            value="{{ $methods->public_key }}">
                                                                    @endif

                                                                    @if ($methods->payment_type == 16)
                                                                        <input type="hidden" name="bankdescription"
                                                                            id="bankdescription"
                                                                            value="{{ $methods->payment_description }}">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endif
                                            @endforeach
                                            @if (Auth::user() && Auth::user()->type == 4)
                                                @if ($walletpaymethods)
                                                    <div class="col-12">
                                                        <div class="card bg-light">
                                                            <div class="card-body">
                                                                <div
                                                                    class="d-flex flex-column flex-sm-row align-items-center justify-content-between">
                                                                    <div class="d-flex flex-column gap-1">
                                                                        <p
                                                                            class="text-center text-muted fw-semibold m-0 wallet-balance">
                                                                            {{ trans('labels.current_balance') }} :
                                                                            <span
                                                                                class="fw-600 text-dark color-changer">{{ helper::currency_format(Auth::user()->wallet) }}</span>
                                                                        </p>
                                                                    </div>
                                                                    <div class="d-flex justify-content-center">
                                                                        <input type="hidden" id="wallet_payment"
                                                                            value="2">
                                                                        <button
                                                                            class="btn btn-primary sm-w-100 d-flex gap-3 justify-content-center align-items-center wallet_booking_payment text-capitalize"
                                                                            onclick="wallet_booking_payment()">{{ trans('labels.pay_with_wallet') }}
                                                                            <div
                                                                                class="loader d-none wallet_booking_payment_loader">
                                                                            </div>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                        </form>
                                        <div class="d-sm-flex justify-content-end align-items-center pt-3">
                                            <button onclick="booking_payment()"
                                                class="btn btn-primary text-capitalize sm-w-100 d-flex gap-3 justify-content-center align-items-center booking_payment">{{ trans('labels.pay_now') }}
                                                <div class="loader d-none booking_payment_loader"></div>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="select_ptype" id="select_ptype"
                                        value="{{ trans('messages.select_payment_type') }}">
                                    <input type="hidden" name="title" id="title"
                                        value="{{ trans('labels.app_name') }}">
                                    <input type="hidden" name="description" id="description"
                                        value="{{ trans('labels.add_wallet_description') }}">
                                    <input type="hidden" name="logo" id="logo"
                                        value="https://stripe.com/img/documentation/checkout/marketplace.png">
                                    <input type="hidden" name="user_id" id="user_id"
                                        value="{{ @Auth::user()->id }}">
                                    <input type="hidden" name="user_fullname" id="user_fullname"
                                        value="{{ $bookingdata->name }}">
                                    <input type="hidden" name="user_email" id="user_email"
                                        value="{{ $bookingdata->email }}">
                                    <input type="hidden" name="user_mobile" id="user_mobile"
                                        value="{{ $bookingdata->mobile }}">
                                    <input type="hidden" name="total_price" id="total_price"
                                        value="{{ $bookingdata->total_amt }}">
                                    <input type="hidden" name="tips" id="tips"
                                        value="{{ @$bookingdata->tips }}">
                                    <input type="hidden" name="booking_id" id="booking_id"
                                        value="{{ $bookingdata->booking_id }}">
                                    <input type="hidden" name="booking_url" id="booking_url"
                                        value="{{ URL::to('/home/user/bookings/payment') }}">
                                    <input type="hidden" name="continueurl" id="continueurl"
                                        value="{{ URL::to('/') }}">

                                    <input type="hidden" name="mercadopagourl" id="mercadopagourl"
                                        value="{{ URL::to('/home/mercadorequest') }}">
                                    <input type="hidden" name="myfatoorahurl" id="myfatoorahurl"
                                        value="{{ URL::to('/home/myfatoorah') }}">
                                    <input type="hidden" name="paypalurl" id="paypalurl"
                                        value="{{ URL::to('/home/paypal') }}">
                                    <input type="hidden" name="toyyibpayurl" id="toyyibpayurl"
                                        value="{{ URL::to('/home/toyyibpay') }}">
                                    <input type="hidden" name="paytaburl" id="paytaburl"
                                        value="{{ URL::to('/home/paytab') }}">
                                    <input type="hidden" name="phonepeurl" id="phonepeurl"
                                        value="{{ URL::to('/home/phonepe') }}">
                                    <input type="hidden" name="mollieurl" id="mollieurl"
                                        value="{{ URL::to('/home/mollie') }}">
                                    <input type="hidden" name="khaltiurl" id="khaltiurl"
                                        value="{{ URL::to('/home/khalti') }}">
                                    <input type="hidden" name="xenditurl" id="xenditurl"
                                        value="{{ URL::to('/home/xendit') }}">
                                    <input type="hidden" name="paymentsuccess" id="paymentsuccess"
                                        value="{{ URL::to('home/service/bookingpaymentsuccess') }}">
                                    <input type="hidden" name="paymentfail" id="paymentfail"
                                        value="{{ URL::to('home/service/bookingpaymentfail') }}">

                                    <form action="{{ URL::to('home/paypal') }}" method="post" class="d-none">
                                        @csrf
                                        <input type="hidden" name="return" value="2">
                                        <input type="submit" class="callpaypal" name="submit">
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
            @else
                @include('front.nodata')
            @endif
        </div>
    </div>
    @include('front.become_provider')
@endsection
@section('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://checkout.stripe.com/v2/checkout.js"></script>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
@endsection
