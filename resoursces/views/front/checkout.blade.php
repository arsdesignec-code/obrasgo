@extends('front.layout.main')
@section('page_title')
    {{ trans('labels.booking') }} | {{ trans('labels.checkout') }}
@endsection
<script type="text/javascript">
    function preventBack() {
        "use strict";
        window.history.forward();
    }
    setTimeout("preventBack()", 0);
    window.onunload = function() {
        null
    };
</script>
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}"
                                    class="color-changer">{{ trans('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.service') }}</li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.booking_summery') }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- checkout -->
    <section class="content checkout-sec">
        <div class="container">
            <h2 class="fw-600 truncate-2 mb-4 sec-subtitle color-changer">{{ trans('labels.booking_summery') }}</h2>
            @if (!empty($servicedata))
                <div class="row g-3">
                    <div class="col-lg-8 col-md-12">
                        <!-- Service Detail -->
                        <div class="card">
                            <div class="card-header border-bottom bg-transparent py-3">
                                <h5 class="widget-title color-changer m-0">{{ trans('labels.service') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex custom-wrap gap-3 align-items-center">
                                    <div class="col-auto">
                                        <a href="{{ URL::to('/home/service-details/' . $servicedata->slug) }}">
                                            <img src="{{ helper::image_path($servicedata->service_image) }}"
                                                alt="{{ trans('labels.service_image') }}"
                                                class="booking-sevirce-img rounded">
                                        </a>
                                    </div>
                                    <div class="w-100">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                                            <div class="service-details">
                                                <div class="badge badge-primary fw-500 fs-8 text-capitalize ">
                                                    <span>{{ $servicedata->category_name }}</span>
                                                </div>
                                            </div>
                                            @if (@helper::checkaddons('product_review'))
                                                @if (@helper::appdata()->review_approved_status == 1)
                                                    <p class="d-flex align-items-center fs-7 gap-1 m-0">
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                        <span class="fw-600 color-changer">
                                                            {{ helper::getaverageratting($servicedata->service_id) }}
                                                        </span>
                                                    </p>
                                                @endif
                                            @endif
                                        </div>
                                        <h5 class="fw-600 fs-17 color-changer truncate-2 mb-2">
                                            {{ $servicedata->service_name }}
                                            @php Illuminate\Support\Facades\Storage::disk('local')->put('service', $servicedata->service_id); @endphp
                                        </h5>
                                        @php
                                            if ($servicedata->is_top_deals == 1 && @helper::top_deals() != null) {
                                                if (@helper::top_deals()->offer_type == 1) {
                                                    $price = $servicedata->price - @helper::top_deals()->offer_amount;
                                                } else {
                                                    $price =
                                                        $servicedata->price -
                                                        $servicedata->price *
                                                            (@helper::top_deals()->offer_amount / 100);
                                                }
                                            } else {
                                                $price = $servicedata->price;
                                            }
                                        @endphp
                                        <h5 class="fw-semibold color-changer fs-15 m-0 mt-1">
                                            {{ helper::currency_format($price) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- new addres -->
                        <div class="card mb-4 mt-3">
                            <div class="card-header border-bottom bg-transparent py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="widget-title color-changer m-0">{{ trans('labels.address') }}</h5>
                                    @if (Auth::user() && Auth::user()->type == 4)
                                        <a class="btn btn-primary"
                                            href="{{ URL::to('/home/user/address') }}">{{ trans('labels.add_address') }}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                @if (Auth::user() && Auth::user()->type == 4)
                                    @if ($addressdata->count() > 0)
                                        <div class="row g-3 recharge_payment_option">
                                            @foreach ($addressdata as $key => $address)
                                                <div class="col-md-6 col-lg-6 col-xl-4">
                                                    <label for="{{ $address->id }}" class="radio-card card cp h-100">
                                                        <input type="radio" id="{{ $address->id }}"
                                                            @if ($key == 0) checked @endif name="address"
                                                            data-fullname="{{ $address->name }}"
                                                            data-email="{{ $address->email }}"
                                                            data-mobile="{{ $address->mobile }}"
                                                            data-street_address="{{ $address->street }}"
                                                            data-landmark="{{ $address->landmark }}"
                                                            data-postcode="{{ $address->postcode }}">
                                                        <div class="card border card-content-wrapper p-0 h-100">
                                                            <div
                                                                class="card-header border-bottom bg-transparent py-3 d-flex justify-content-between align-items-center">
                                                                <div
                                                                    class="d-flex d-grid gap-2 color-changer align-items-center">
                                                                    @if ($address->address_type == 1)
                                                                        <i class="fa-regular fa-home fs-5"></i>
                                                                        <h5 class="fw-600 fs-6 mb-0">
                                                                            {{ trans('labels.home') }}
                                                                        </h5>
                                                                    @elseif($address->address_type == 2)
                                                                        <i class="fa-regular fa-building"></i>
                                                                        <h5 class="fw-600 fs-6 mb-0">
                                                                            {{ trans('labels.office') }}
                                                                        </h5>
                                                                    @else
                                                                        <i class="fa-regular fa-puzzle-piece"></i>
                                                                        <h5 class="fw-600 fs-6 mb-0">
                                                                            {{ trans('labels.other') }}
                                                                        </h5>
                                                                    @endif
                                                                </div>
                                                                <span class="check-icon"></span>
                                                            </div>
                                                            <div class="card-body pt-0">
                                                                <ul class="list-group list-group-flush total_list">
                                                                    <li class="list-group-item px-0">
                                                                        <p class="text-muted m-0">
                                                                            {{ trans('labels.name') }}</p>
                                                                        <p class="text-dark color-changer m-0">
                                                                            {{ $address->name }}
                                                                        </p>
                                                                    </li>
                                                                    <li class="list-group-item px-0">
                                                                        <p class="text-muted m-0">
                                                                            {{ trans('labels.email') }}</p>
                                                                        <p class="text-dark color-changer m-0">
                                                                            {{ $address->email }}
                                                                        </p>
                                                                    </li>
                                                                    <li class="list-group-item border-bottom px-0">
                                                                        <p class="text-muted m-0">
                                                                            {{ trans('labels.mobile') }}</p>
                                                                        <p class="text-dark color-changer m-0">
                                                                            {{ $address->mobile }}
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                                <div class="d-flex align-items-center d-grid gap-2 pt-2">
                                                                    <p class="fs-7 text-muted m-0">
                                                                        {{ trans('labels.address') }}</p>
                                                                </div>
                                                                <p class="fs-7 pt-1 color-changer m-0">
                                                                    {{ $address->landmark }},{{ $address->street }}
                                                                    {{ $address->postcode }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="w-25 mx-auto">
                                            <img src="{{ helper::image_path(helper::otherdata('')->no_data_image) }}"
                                                alt="nodata img">
                                        </div>
                                    @endif
                                @endif
                                <div class="row g-3 {{ Auth::user() && Auth::user()->type == 4 ? 'd-none' : '' }}">
                                    <div class="col-md-6">
                                        <label for="fullname" class="form-label">{{ trans('labels.fullname') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control fs-7" name="fullname" id="user_fullname"
                                            placeholder="{{ trans('labels.fullname') }}" value="" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">{{ trans('labels.email') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control fs-7" name="email" id="user_email"
                                            placeholder="{{ trans('labels.email') }}" value="" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mobile" class="form-label">{{ trans('labels.mobile') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control fs-7" name="mobile" id="user_mobile"
                                            placeholder="{{ trans('labels.mobile') }}" value="" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="street" class="form-label">{{ trans('labels.street_address') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="street" id="user_street_address" class="form-control fs-7" rows="3"
                                            placeholder="{{ trans('labels.street_address') }}" required>{{ old('street') }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="landmark" class="form-label">{{ trans('labels.landmark') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control fs-7" name="landmark"
                                            id="user_landmark" placeholder="{{ trans('labels.landmark') }}"
                                            value="{{ old('landmark') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="postcode" class="form-label">{{ trans('labels.postalcode') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control fs-7" name="postcode"
                                            id="user_postcode" placeholder="{{ trans('labels.postalcode') }}"
                                            value="{{ old('postcode') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (@helper::checkaddons('vendor_tip'))
                            @if (@helper::otherdata()->tips_settings == 1)
                                <div class="card mb-4 mt-3 Delivery-view">
                                    <div class="card-header border-bottom bg-transparent py-3">
                                        <h5 class="widget-title color-changer mb-0">{{ trans('labels.tips_pro') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group m-0">
                                                    <label for="add_amount" class="form-label">
                                                        {{ trans('labels.add_amount') }}
                                                    </label>
                                                    <input type="number" class="form-control" id="add_amount"
                                                        placeholder="{{ trans('labels.add_amount') }} . . . .">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <!-- mobile view Date And Time -->
                        <div class="card mt-3 d-lg-none">
                            <div class="card-header border-bottom bg-transparent py-3">
                                <h5 class="widget-title color-changer mb-0">{{ trans('labels.date_time') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="cart_detail_box row g-2">
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="position-relative">
                                            <input type="date" class="form-control form-control-sm" name="date"
                                                id="mobile_date" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>"
                                                required>
                                            <i class="fa-regular fa-calendar-days color-changer"></i>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="position-relative">
                                            <input type="time" class="form-control form-control-sm" name="time"
                                                id="mobile_time" required>
                                            <i class="fa-regular fa-clock color-changer"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- mobile view Available Offers -->
                        @if (@helper::checkaddons('coupons'))
                            <div class="card mt-3 d-lg-none">
                                <div class="card-header border-bottom bg-transparent py-3">
                                    <h5 class="widget-title color-changer mb-0">{{ trans('labels.apply_coupon_here') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-8 col-lg-12 col-xl-8">
                                            <input type="text" class="form-control padding-extra-code offer_code"
                                                value="{{ Illuminate\Support\Facades\Storage::disk('local')->get('coupon_code') }}"
                                                placeholder="Enter coupon code" readonly>
                                        </div>
                                        <div class="col-4 col-lg-12 col-xl-4">
                                            <button onclick="ApplyCoupon()"
                                                class="btn btn-primary w-100 m-0 d-flex gap-3 justify-content-center align-items-center apply_coupon d-block">{{ trans('labels.apply') }}
                                                <div class="loader d-none apply_coupon_loader"></div>
                                            </button>
                                            <button
                                                class="btn btn-danger w-100 m-0 px-0 d-flex gap-3 justify-content-center align-items-center remove_coupon d-none"
                                                onclick="RemoveCoupon()">
                                                {{ trans('labels.remove_coupon') }}
                                                <div class="loader d-none remove_coupon_loader"></div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Mobile booking summery -->
                        <div class="card mt-3 d-block d-lg-none">
                            <div class="card-header border-bottom bg-transparent py-3">
                                <h5 class="widget-title color-changer mb-0">{{ trans('labels.booking_summery') }}</h5>
                            </div>
                            <div class="card-body py-0">
                                <ul>
                                    <li class="list-group-item border-bottom">
                                        <span class="text-muted fs-6">{{ trans('labels.price') }}</span>
                                        <span class="fs-6 color-changer">
                                            {{ helper::currency_format($price) }}
                                        </span>
                                    </li>
                                    @php $discount = 0; @endphp
                                    <li class="list-group-item border-bottom discount_row d-none">
                                        <span class="text-muted fs-6">{{ trans('labels.discount') }}</span>
                                        <span class="fs-6 offer_amount">
                                                @if (Illuminate\Support\Facades\Storage::exists('service_id') &&
                                                        Illuminate\Support\Facades\Storage::disk('local')->get('service_id') == $servicedata->service_id)
                                                @if (Illuminate\Support\Facades\Storage::disk('local')->get('discount_type') == 2)
                                                    <?php $discount = (Illuminate\Support\Facades\Storage::disk('local')->get('discount') / 100) * $price;
                                                    Illuminate\Support\Facades\Storage::disk('local')->put('total_discount', $discount); ?>
                                                @elseif(Illuminate\Support\Facades\Storage::disk('local')->get('discount_type') == 1)
                                                    <?php $discount = Illuminate\Support\Facades\Storage::disk('local')->get('discount');
                                                    Illuminate\Support\Facades\Storage::disk('local')->put('total_discount', $discount); ?>
                                                @else
                                                    <?php
                                                    Illuminate\Support\Facades\Storage::disk('local')->put('total_discount', $discount); ?>
                                                @endif
                                            @endif
                                            {{ helper::currency_format($discount) }}
                                        </span>
                                    </li>
                                    @php
                                        $totalcarttax = 0;
                                    @endphp
                                    @if ($itemtaxArr['tax_name'] != '' && $itemtaxArr['tax'] != '')
                                        @foreach ($itemtaxArr['tax_name'] as $key => $taxes)
                                            @php
                                                $totalcarttax += (float) $itemtaxArr['tax'][$key];
                                            @endphp
                                            <li class="list-group-item border-bottom">
                                                <span class="text-muted fs-6">{{ $taxes }}</span>
                                                <span class="fs-6">
                                                    {{ helper::currency_format($itemtaxArr['tax'][$key]) }}
                                                </span>
                                            </li>
                                        @endforeach
                                    @endif
                                    <li class="list-group-item text-success">
                                        <span class="fw-600 fs-5">{{ trans('labels.total') }}</span>
                                        <span class="fw-600 fs-5 grand_total">
                                            <?php $total = $price - $discount + array_sum($itemtaxArr['tax']);
                                            Illuminate\Support\Facades\Storage::disk('local')->put('total_price', $total); ?>
                                            {{ helper::currency_format($total) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Mobile Notes -->
                        <div class="card mt-3 d-block d-lg-none">
                            <div class="card-header bg-transparent py-3">
                                <h5 class="widget-title mb-0">{{ trans('labels.notes') }}</h5>
                            </div>
                            <div class="card-body">
                                <textarea class="form-control form-control-sm mb-9 mb-md-0 font-size-xs" rows="3" name="booking_notes"
                                    id="mobile_booking_notes"
                                    placeholder="{{ helper::appdata()->booking_note_required == 1 ? trans('labels.enter_notes') : trans('labels.enter_notes_o') }}"></textarea>
                            </div>
                        </div>
                        @if (@helper::allpaymentcheckaddons())
                            <!-- payment option -->
                            @if (helper::appdata()->payment_process_options == 3)
                                <div class="card my-3">
                                    <div class="card-body">
                                        <div class="row recharge_payment_option g-3" id="paynow">
                                            <div class="col-12 col-sm-6">
                                                <label for="pay_now" class="radio-card card border h-100 cp">
                                                    <input class="custom-control-input" type="radio" value="1"
                                                        id="pay_now" name="payment_options">
                                                    <div class="card-content-wrapper d-flex gap-3 align-items-center">
                                                        <span class="check-icon"></span>
                                                        <div class="d-flex gap-3 color-changer align-items-center">
                                                            {{ trans('labels.pay_now') }}
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <label for="pay_later" class="radio-card card border h-100 cp">
                                                    <input class="custom-control-input" id="pay_later"
                                                        name="payment_options" type="radio" value="2">
                                                    <div class="card-content-wrapper d-flex gap-3 align-items-center">
                                                        <span class="check-icon"></span>
                                                        <div class="d-flex gap-3 color-changer align-items-center">
                                                            {{ trans('labels.pay_later') }}
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <!-- payment option -->

                        <!-- Payment type -->
                        <div class="card payment_methods d-none">
                            <div class="card-header bg-transparent border-bottom py-3">
                                <h5 class="widget-title color-changer m-0">{{ trans('labels.payment') }}</h5>
                            </div>
                            <div class="card-body">
                                <form class="row grid-wrapper grid-col-auto g-3 recharge_payment_option">
                                    @if (!empty($paymethods))
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
                                                <div class="col-12 col-xl-4 col-sm-6">
                                                    <label for="{{ $methods->payment_name }}"
                                                        class="radio-card card border h-100 cp">
                                                        <input class="custom-control-input"
                                                            id="{{ $methods->payment_name }}"
                                                            data-payment_type="{{ $methods->id }}" name="payment"
                                                            type="radio">
                                                        <div class="card-content-wrapper d-flex gap-3 align-items-center">
                                                            <span class="check-icon"></span>
                                                            <div class="d-flex gap-3 align-items-center">
                                                                <div class="rounded-3 payment_option_img">
                                                                    <img src="{{ helper::image_path($methods->image) }}"
                                                                        class="h-100" alt="payment-img" />
                                                                </div>
                                                                <p class="m-0 color-changer">{{ $methods->payment_name }}</p>
                                                                @if ($methods->payment_type == 3)
                                                                    <input type="hidden" name="razorpay" id="razorpay"
                                                                        value="{{ $methods->public_key }}">
                                                                @endif

                                                                @if ($methods->payment_type == 4)
                                                                    <input type="hidden" name="stripe" id="stripe"
                                                                        value="{{ $methods->public_key }}">
                                                                @endif

                                                                @if ($methods->payment_type == 5)
                                                                    <input type="hidden" name="flutterwave"
                                                                        id="flutterwave"
                                                                        value="{{ $methods->public_key }}">
                                                                @endif

                                                                @if ($methods->payment_type == 6)
                                                                    <input type="hidden" name="paystack" id="paystack"
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
                                    @else
                                        @include('front.nodata')
                                    @endif
                                    @if (Auth::user())
                                        @if ($walletpaymethods)
                                            <div class="col-12">
                                                <div class="card border bg-light">
                                                    <div class="card-body">
                                                        <div
                                                            class="d-flex flex-column flex-sm-row align-items-center justify-content-between">
                                                            <div>
                                                                <p
                                                                    class="text-center text-muted fw-semibold m-0 wallet-balance">
                                                                    {{ trans('labels.current_balance') }} :
                                                                    <span class="fw-600 text-success">
                                                                        {{ helper::currency_format(Auth::user()->wallet) }}
                                                                    </span>
                                                                </p>
                                                            </div>
                                                            <div class="d-flex justify-content-center">
                                                                <input type="hidden" id="wallet_payment" value="2">
                                                                <button
                                                                    class="btn btn-primary sm-w-100 d-flex gap-3 justify-content-center align-items-center wallet_service_checkout"
                                                                    onclick="walletisopenclose('{{ URL::to('/home/service/isopenclose') }}','{{ $servicedata->service_id }}')">{{ trans('labels.pay_with_wallet') }}
                                                                    <div
                                                                        class="loader d-none wallet_service_checkout_loader">
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
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="d-sm-flex justify-content-between align-items-center gap-2">
                                <a href="{{ URL::to('/') }}" class="btn btn-outline-primary sm-w-100 mb-3 mb-sm-0">
                                    <i class="fa-regular fa-arrow-left"></i>
                                    <span class="px-1">{{ trans('labels.return_to_shop') }}</span>
                                </a>
                                <button
                                    onclick="checkoutisopenclose('{{ URL::to('/home/service/isopenclose') }}','{{ $servicedata->service_id }}')"
                                    class="btn btn-primary sm-w-100 d-flex gap-3 justify-content-center align-items-center service_checkout">{{ trans('labels.book_service') }}
                                    <div class="loader d-none service_checkout_loader"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4">
                        <!-- date and time -->
                        <div class="card d-none d-lg-block">
                            <div class="card-header border-bottom bg-transparent py-3">
                                <h5 class="fw-600 color-changer mb-0">{{ trans('labels.date_time') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="cart_detail_box row g-3">
                                    <div class="col-12 col-md-12 col-xl-6">
                                        <div class="position-relative">
                                            <input type="date" class="form-control fs-7" name="date"
                                                id="date" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>"
                                                required>
                                            <i class="fa-regular fa-calendar-days color-changer"></i>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-xl-6">
                                        <div class="position-relative">
                                            <input type="time" class="form-control fs-7" name="time"
                                                id="time" required>
                                            <i class="fa-regular fa-clock color-changer"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- apply coupon here -->
                        @if (@helper::checkaddons('coupons'))
                            <div class="card mt-3 d-none d-lg-block">
                                <div class="card-header border-bottom bg-transparent py-3">
                                    <h5 class="widget-title color-changer mb-0">{{ trans('labels.apply_coupon_here') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-8 col-lg-12 col-xl-8">
                                            <input type="text" class="form-control fs-7 padding-extra-code offer_code"
                                                value="{{ Illuminate\Support\Facades\Storage::disk('local')->get('coupon_code') }}"
                                                placeholder="Enter coupon code" readonly>
                                        </div>
                                        <div class="col-4 col-lg-12 col-xl-4">
                                            <button onclick="ApplyCoupon()"
                                                class="btn btn-primary w-100 m-0 d-flex gap-3 justify-content-center align-items-center apply_coupon d-block">{{ trans('labels.apply') }}
                                                <div class="loader d-none apply_coupon_loader"></div>
                                            </button>
                                            <button
                                                class="btn btn-danger w-100 m-0 px-0 d-flex gap-3 justify-content-center align-items-center remove_coupon d-none"
                                                onclick="RemoveCoupon()">
                                                {{ trans('labels.remove_coupon') }}
                                                <div class="loader d-none remove_coupon_loader"></div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- booking summery -->
                        <div class="card mt-3 d-none d-lg-block">
                            <div class="card-header border-bottom bg-transparent py-3">
                                <h5 class="widget-title color-changer mb-0">{{ trans('labels.booking_summery') }}</h5>
                            </div>
                            <div class="card-body py-0">
                                <ul>
                                    <li class="list-group-item border-bottom">
                                        <span class="text-muted fs-6">{{ trans('labels.price') }}</span>
                                        <span class="fs-6 color-changer">
                                            {{ helper::currency_format($price) }}
                                        </span>
                                    </li>
                                    @php $discount = 0; @endphp
                                    <li class="list-group-item border-bottom discount_row d-none">
                                        <span class="text-muted fs-6">{{ trans('labels.discount') }}</span>
                                        <span class="fs-6 offer_amount color-changer">
                                            @if (Illuminate\Support\Facades\Storage::exists('service_id') &&
                                                    Illuminate\Support\Facades\Storage::disk('local')->get('service_id') == $servicedata->service_id)
                                                @if (Illuminate\Support\Facades\Storage::disk('local')->get('discount_type') == 2)
                                                    <?php $discount = (Illuminate\Support\Facades\Storage::disk('local')->get('discount') / 100) * $price;
                                                    Illuminate\Support\Facades\Storage::disk('local')->put('total_discount', $discount); ?>
                                                @elseif(Illuminate\Support\Facades\Storage::disk('local')->get('discount_type') == 1)
                                                    <?php $discount = Illuminate\Support\Facades\Storage::disk('local')->get('discount');
                                                    Illuminate\Support\Facades\Storage::disk('local')->put('total_discount', $discount); ?>
                                                @else
                                                    <?php
                                                    Illuminate\Support\Facades\Storage::disk('local')->put('total_discount', $discount); ?>
                                                @endif
                                            @endif
                                            {{ helper::currency_format($discount) }}
                                        </span>
                                    </li>
                                    @php
                                        $totalcarttax = 0;
                                    @endphp
                                    @if ($itemtaxArr['tax_name'] != '' && $itemtaxArr['tax'] != '')
                                        @foreach ($itemtaxArr['tax_name'] as $key => $taxes)
                                            @php
                                                $totalcarttax += (float) $itemtaxArr['tax'][$key];
                                            @endphp
                                            <li class="list-group-item border-bottom">
                                                <span class="text-muted fs-6">{{ $taxes }}</span>
                                                <span class="fs-6 color-changer">
                                                    {{ helper::currency_format($itemtaxArr['tax'][$key]) }}
                                                </span>
                                            </li>
                                        @endforeach
                                    @endif
                                    <li class="list-group-item text-success">
                                        <span class="fw-600 fs-5">{{ trans('labels.total') }}</span>
                                        <span class="fw-600 fs-5 grand_total">
                                            <?php $total = $price - $discount + array_sum($itemtaxArr['tax']);
                                            Illuminate\Support\Facades\Storage::disk('local')->put('total_price', $total); ?>
                                            {{ helper::currency_format($total) }}
                                        </span>
                                    </li>
                                    <input type="hidden" name="total_price" id="total_price"
                                        value="{{ Illuminate\Support\Facades\Storage::disk('local')->get('total_price') }}">
                                    <input type="hidden" name="discount" id="discount"
                                        value="{{ Illuminate\Support\Facades\Storage::disk('local')->get('total_discount') }}">
                                    <input type="hidden" name="service" id="service"
                                        value="{{ Illuminate\Support\Facades\Storage::disk('local')->get('service') }}">
                                    <input type="hidden" name="user_id" id="user_id"
                                        value="{{ @Auth::user()->id }}">
                                    <input type="hidden" name="service_price" id="service_price"
                                        value="{{ $price }}">
                                    <input type="hidden" name="tax" id="tax"
                                        value="{{ implode('|', $itemtaxArr['tax']) }}">
                                    <input type="hidden" name="tax_name" id="tax_name"
                                        value="{{ implode('|', $itemtaxArr['tax_name']) }}">

                                    <input type="hidden" name="select_ptype" id="select_ptype"
                                        value="{{ trans('messages.select_payment_type') }}">
                                    <input type="hidden" name="select_pay_option" id="select_pay_option"
                                        value="{{ trans('messages.select_payment_option') }}">
                                    <input type="hidden" name="date_time_err_text" id="date_time_err_text"
                                        value="{{ trans('messages.select_date_time') }}">

                                    <input type="hidden" name="user_fullname_err_text" id="user_fullname_err_text"
                                        value="{{ trans('messages.enter_full_name') }}">
                                    <input type="hidden" name="user_email_err_text" id="user_email_err_text"
                                        value="{{ trans('messages.enter_email') }}">
                                    <input type="hidden" name="user_mobile_err_text" id="user_mobile_err_text"
                                        value="{{ trans('messages.enter_mobile') }}">
                                    <input type="hidden" name="user_street_address_err_text"
                                        id="user_street_address_err_text"
                                        value="{{ trans('messages.enter_street_address') }}">
                                    <input type="hidden" name="user_landmark_err_text" id="user_landmark_err_text"
                                        value="{{ trans('messages.enter_landmark') }}">
                                    <input type="hidden" name="user_postcode_err_text" id="user_postcode_err_text"
                                        value="{{ trans('messages.enter_postalcode') }}">

                                    <input type="hidden" name="title" id="title"
                                        value="{{ trans('labels.app_name') }}">
                                    <input type="hidden" name="description" id="description"
                                        value="{{ trans('labels.add_description') }}">
                                    <input type="hidden" name="booking_notes_msg" id="booking_notes_msg"
                                        value="{{ trans('messages.enter_notes') }}">
                                    <input type="hidden" name="logo" id="logo"
                                        value="https://stripe.com/img/documentation/checkout/marketplace.png">
                                    <input type="hidden" name="booking_url" id="booking_url"
                                        value="{{ URL::to('/home/service/book') }}">
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
                                        value="{{ URL::to('home/service/paymentsuccess') }}">
                                    <input type="hidden" name="paymentfail" id="paymentfail"
                                        value="{{ URL::to('home/service/paymentfail') }}">

                                    <form action="{{ URL::to('home/paypal') }}" method="post" class="d-none">
                                        @csrf
                                        <input type="hidden" name="return" value="2">
                                        <input type="submit" class="callpaypal" name="submit">
                                    </form>

                                    <input type="hidden" name="coupon_code" id="coupon_code"
                                        value="{{ Illuminate\Support\Facades\Storage::disk('local')->get('coupon_code') }}">
                                    <input type="hidden" name="service_id" id="service_id"
                                        value="{{ Illuminate\Support\Facades\Storage::disk('local')->get('service_id') }}">
                                </ul>
                            </div>
                        </div>
                        <!-- Notes -->
                        <div class="card mt-3 d-none d-lg-block">
                            <div class="card-header bg-transparent border-bottom py-3">
                                <h5 class="widget-title color-changer mb-0">{{ trans('labels.notes') }}</h5>
                            </div>
                            <div class="card-body">
                                <textarea class="form-control form-control-sm mb-9 mb-md-0 font-size-xs" rows="3" name="booking_notes"
                                    id="booking_notes"
                                    placeholder="{{ helper::appdata()->booking_note_required == 1 ? trans('labels.enter_notes') : trans('labels.enter_notes_o') }}"></textarea>
                            </div>
                        </div>
                        @if (@helper::checkaddons('trusted_badges'))
                            @include('front.service-trusted')
                        @endif
                    </div>
                </div>
            @else
                @include('front.nodata')
            @endif
        </div>
    </section>
    @include('front.become_provider')
@endsection

@section('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://checkout.stripe.com/v2/checkout.js"></script>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        var showbutton = "{{ Illuminate\Support\Facades\Storage::disk('local')->has('coupon_code') }}";
        $(document).ready(function() {
            if (showbutton == true) {
                $('.remove_coupon').removeClass('d-none');
                $('.discount_row').removeClass('d-none');
                $('.apply_coupon').addClass('d-none');
            } else {
                $('.remove_coupon').addClass('d-none');
                $('.discount_row').addClass('d-none');
                $('.apply_coupon').removeClass('d-none');
            }
        });

        function ApplyCoupon() {
            $('.apply_coupon').prop("disabled", true);
            $('.apply_coupon_loader').removeClass('d-none');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ URL::to('/home/service/continue/check-coupon/' . $servicedata->slug) }}",
                method: 'POST',
                data: {
                    coupon: $('.offer_code').val(),
                },
                success: function(response) {
                    $('.apply_coupon').prop("disabled", false);
                    $('.apply_coupon_loader').addClass("d-none");
                    if (response.status == 1) {
                        var total = parseFloat($('#service_price').val());
                        var tax = "{{ @$totalcarttax }}";
                        var discount = "";
                        if (response.data.discount_type == 1) {
                            discount = response.data.discount;
                        }
                        if (response.data.discount_type == 2) {
                            discount = total * parseFloat(response.data.discount) / 100;
                        }
                        var grandtotal = parseFloat(total) + parseFloat(tax) - parseFloat(discount);
                        $('.offer_amount').text(currency_formate(parseFloat(discount)));
                        $('.grand_total').text(currency_formate(parseFloat(grandtotal)));
                        $('#total_price').val(grandtotal);
                        $('#discount').val(discount);
                        $('#coupon_code').val(response.data.coupon_code);
                        $('#service_id').val(response.data.service_id);
                        $('.discount_row').removeClass('d-none');
                        $('.remove_coupon').removeClass('d-none');
                        $('.apply_coupon').addClass('d-none');
                    } else {
                        toastr.error(response.message);

                    }
                }
            });
        }

        function RemoveCoupon() {
            $('.remove_coupon').prop("disabled", true);
            $('.remove_coupon_loader').removeClass('d-none');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ URL::to('/home/remove-coupon/' . $servicedata->service_id) }}",
                method: 'GET',
                success: function(response) {
                    $('.remove_coupon').prop("disabled", false);
                    $('.remove_coupon_loader').addClass("d-none");
                    if (response.status == 1) {
                        var total = $('#service_price').val();
                        var tax = "{{ @$totalcarttax }}";
                        var discount = 0;
                        var grandtotal = parseFloat(total) + parseFloat(tax) - parseFloat(discount);
                        $('.offer_amount').text('-' + currency_formate(parseFloat(0)));
                        $('.grand_total').text(currency_formate(parseFloat(grandtotal)));
                        $('#total_price').val(grandtotal);
                        $('#discount').val(discount);
                        $('#coupon_code').val('');
                        $('#service_id').val('');
                        $('.offer_code').val('');
                        $('.discount_row').addClass('d-none');
                        $('.remove_coupon').addClass('d-none');
                        $('.apply_coupon').removeClass('d-none');
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        }
    </script>
@endsection
