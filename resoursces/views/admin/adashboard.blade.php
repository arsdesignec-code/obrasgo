@extends('layout.main')
@section('page_title', trans('labels.home'))
@section('content')
    <div class="container-fluid">
        @if (Auth::user()->type == 2)
        @if (helper::otherdata(1)->notice_on_off == 1)
            <div class="card mb-3 notice_card border-0 box-shadow">
                <div class="card-body">
                    <div class="d-flex flex-wrap flex-sm-nowrap gap-3">
                        <div class="d-flex justify-content-between">
                            <div class="alert-icons rgb-danger-light col-auto">
                                <i class="fa-regular fa-circle-exclamation text-danger"></i>
                            </div>
                            <div class="d-sm-none">
                                <div class="close-button cursor-pointer" id="close-btn3">
                                    <i class="fa-solid fa-xmark text-danger"></i>
                                </div>
                            </div>
                        </div>
                        <div class="w-100">
                            <div class="d-flex gap-2 align-items-center mb-2 justify-content-between">
                                <h6 class="line-2 color-changer fs-17">
                                    {{ helper::otherdata(1)->notice_title }}
                                </h6>
                                <div class="d-sm-block d-none">
                                    <div class="close-button cursor-pointer" id="close-btn2">
                                        <i class="fa-solid fa-xmark text-danger"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted fs-13 m-0">
                                {{ helper::otherdata(1)->notice_description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @endif
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title color-changer m-0 fs-4 fw-600">{{ trans('labels.dashboard_title') }}
            </h5>
        </div>
        <div class="row g-4 match-height mb-4">
            @php
                if (Auth::user()->type == 2) {
                    $col1 = 'col-xl-6';
                    $col2 = 'col-xxl-4 col-lg-4 col-md-4 col-sm-6';
                } else {
                    $col1 = 'col-xl-12';
                    $col2 = 'col-xxl-2 col-lg-4 col-md-4 col-sm-6';
                }
            @endphp
            <div class="{{ $col1 }} col-12">
                
                <div class="row g-4 match-height">
                    
                    @if (Auth::user()->type == 1)
                        <div class="{{ $col2 }}">
                            <div class="card border-0 h-100 rgb-secondary-light">
                                <div class="card-body p-4">
                                    <div class="dashboard-card flex-column">
                                        <a @if (Auth::user()->type == 1) href="{{ URL::to('/providers') }}" @endif>
                                            <span class="card-icon shadow-sm bg-secondary">
                                                <i class="ft-users"></i>
                                            </span>
                                        </a>
                                        <div class="mt-3 ">
                                            <h4 class="mb-0 fw-600 color-changer text-center">{{ $total_providers }}</h4>
                                            <p class="text-center color-changer fw-medium fs-15">
                                                {{ trans('labels.total_providers') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="{{ $col2 }}">
                            <div class="card border-0 h-100 rgb-dark-light">
                                <div class="card-body p-4">
                                    <div class="dashboard-card flex-column">
                                        <a @if (Auth::user()->type == 1) href="{{ URL::to('/categories') }}" @endif>
                                            <span class="card-icon shadow-sm bg-dark">
                                                <i class="fa fa-list-alt"></i>
                                            </span>
                                        </a>
                                        <div class="mt-3 ">
                                            <h4 class="fw-600 text-center color-changer mb-0">{{ $total_categories }}</h4>
                                            <p class="text-center color-changer fw-medium fs-15">
                                                {{ trans('labels.total_categories') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="{{ $col2 }}">
                            <div class="card border-0 h-100 rgb-danger-light">
                                <div class="card-body p-4">
                                    <div class="dashboard-card flex-column">
                                        <a @if (Auth::user()->type == 1) href="{{ URL::to('/cities') }}" @endif>
                                            <span class="card-icon shadow-sm bg-danger">
                                                <i class="icon-map font-large-2"></i>
                                            </span>
                                        </a>
                                        <div class="mt-3 ">
                                            <h4 class="fw-600 text-center color-changer mb-0">{{ $total_cities }}</h4>
                                            <p class="fs-15 fw-medium color-changer text-center">
                                                {{ trans('labels.total_cities') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (Auth::user()->type == 3)
                        <div class="{{ $col2 }}">
                            <div class="card border-0 h-100 rgb-info-light">
                                <div class="card-body p-4">
                                    <div class="dashboard-card flex-column">
                                        <a href="{{ URL::to('/bookings') }}">
                                            <span class="card-icon bg-info shadow-sm">
                                                <i class="fa fa-heart"></i>
                                            </span>
                                        </a>
                                        <div class="mt-3 ">
                                            <h4 class="fw-600 color-changer text-center mb-0">{{ $total_services }}</h4>
                                            <p class="fs-15 color-changer fw-medium text-center">
                                                {{ trans('labels.assign') . ' ' . trans('labels.booking') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="{{ $col2 }}">
                            <div class="card border-0 h-100 rgb-success-light">
                                <div class="card-body p-4">
                                    <div class="dashboard-card flex-column">
                                        <a href="{{ URL::to('/bookings') }}">
                                            <span class="card-icon bg-success shadow-sm">
                                                <i class="fa fa-users"></i>
                                            </span>
                                        </a>
                                        <div class="mt-3 ">
                                            <h4 class="fw-600 color-changer text-center mb-0">{{ $total_handymans }}</h4>
                                            <p class="fs-15 color-changer fw-medium text-center">
                                                {{ trans('labels.booking_completed') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else

                        <div class="{{ $col2 }}">
                            <div class="card border-0 h-100 rgb-info-light">
                                <div class="card-body p-4">
                                    <div class="dashboard-card flex-column">
                                        <a href="{{ URL::to('/services') }}">
                                            <span class="card-icon bg-info shadow-sm">
                                                <i class="fa fa-heart"></i>
                                            </span>
                                        </a>
                                        <div class="mt-3 ">
                                            <h4 class="fw-600 color-changer text-center mb-0">{{ $total_services }}</h4>
                                            <p class="fs-15 color-changer fw-medium text-center">
                                                {{ trans('labels.total_services') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="{{ $col2 }}">
                            <div class="card border-0 h-100 rgb-warning-light">
                                <div class="card-body p-4">
                                    <div class="dashboard-card flex-column">
                                        <a href="{{ URL::to('/handymans') }}">
                                            <span class="card-icon shadow-sm bg-warning">
                                                <i class="fa fa-users"></i>
                                            </span>
                                        </a>
                                        <div class="mt-3 ">
                                            <h4 class="fw-600 color-changer text-center mb-0">{{ $total_handymans }}</h4>
                                            <p class="fs-15 fw-medium color-changer text-center">
                                                {{ trans('labels.total_handyman') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="{{ $col2 }}">
                            @if (Auth::user()->type == 1 || Auth::user()->type == 2)
                                <div class="card border-0 h-100 rgb-success-light">
                                    <form method="POST" action="{{ URL::to('/payout-create') }}">
                                        @csrf
                                        <div class="card-body p-4">
                                            <div class="dashboard-card flex-column">
                                                <span class="card-icon shadow-sm bg-success">
                                                    <i class="fa-solid fa-circle-dollar-to-slot"></i>
                                                </span>
                                                <div class="mt-3 ">
                                                    <h4 class="fw-600 color-changer text-center mb-0">
                                                        {{ helper::currency_format(helper::wallet()) }}</h4>
                                                    <p class="fs-15 text-center color-changer fw-medium">
                                                        {{ trans('labels.earnings') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="balance" value="{{ helper::wallet() }}">
                                        @if (helper::wallet() >= helper::appdata()->withdrawable_amount &&
                                                helper::payout_request() <= 0 &&
                                                Auth::user()->type == 2)
                                            <button
                                                class="btn btn-success w-100 rounded-top-0 d-flex align-items-center justify-content-center gap-2 fw-500 fs-15"
                                                type="submit">
                                                <i class="fa-regular fa-plus"></i>
                                                {{ trans('labels.withdrawal_request') }}
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @if (Auth::user()->type == 2)
            
                <div class="col-xl-6 col-12">
                    <div class="card border-0 box-shadow h-auto">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2 justify-content-center align-items-start">
                                <h5 class="text-dark fw-600 d-flex gap-2 align-items-center">
                                    <img src="{{ helper::image_path(Auth::user()->image) }}"
                                        class="object border rounded-circle dasbord-img" alt="">
                                    <small class="text-dark color-changer">{{ Auth::user()->name }}</small>
                                </h5>
                                <p class="text-muted fs-7 m-0 truncate-3">
                                    {{ trans('labels.provider_dashboard_description') }}
                                </p>
                                <div class="dropdown lag-btn">
                                    <a class="btn btn-secondary fs-7 text-light fw-500 dropdown-toggle" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-regular fa-plus"></i> {{ trans('labels.quick_add') }}
                                    </a>
                                    <ul class="dropdown-menu border-0 p-0 bg-body-secondary fw-500 fs-7 text-dark"
                                        style="">
                                        <li>
                                            <a class="dropdown-item p-2" href="{{ URL::to('/handymans') }}">
                                                {{ trans('labels.handymans') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item p-2" href="{{ URL::to('/services') }}">
                                                {{ trans('labels.services') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item p-2" href="{{ URL::to('/profile-settings') }}">
                                                {{ trans('labels.general_settings') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="row g-4 match-height">
            <div class="col-xl-8">
                <div class="card border-0 box-shadow h-100">
                    <div class="card-body">
                        <div class="d-flex gap-3 align-items-center justify-content-between">
                            <h5 class="card-title color-changer">{{ trans('labels.booking') }}</h5>
                            <form class="input-group-append row g-sm-2 g-1" id="get-bookings"
                                url="{{ URL::to('/dashboard') }}">
                                @if (Auth::user()->type == 1)
                                    <div class="col-sm-7">
                                        <select name="provider" class="form-select" id="provider"
                                            data-show-subtext="true" data-live-search="true">
                                            <option value="">{{ trans('labels.select') }}</option>
                                            @foreach ($providers as $pdata)
                                                <option value="{{ $pdata->id }}">{{ $pdata->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="@if (Auth::user()->type == 1) col-sm-5 @else col-md-auto @endif">
                                    <select name="booking_year" class="form-select" id="booking_year"
                                        data-show-subtext="true" data-live-search="true"
                                        url="{{ URL::to('/dashboard') }}">
                                        @foreach ($booking_years as $byear)
                                            <option value="{{ $byear->year }}">{{ $byear->year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <canvas id="boookingchart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card border-0 box-shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="card-title color-changer truncate-1">
                                {{ Auth::user()->type == 1 ? trans('labels.users') : trans('labels.service_bookings') }}
                            </h5>
                            <form class="input-group-append d-flex gap-3 justify-content-end" id="get-service-orders"
                                url="{{ URL::to('/dashboard') }}">
                                @if (Auth::user()->type == 2 || Auth::user()->type == 3)
                                    <div class="col-lg-6">
                                        <select name="service" class="form-control fs-7" id="service"
                                            data-show-subtext="true" data-live-search="true">
                                            @foreach ($services as $sdata)
                                                <option value="{{ $sdata->id }}">{{ $sdata->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <select class="form-select form-select-sm w-auto" id="doughnutyear"
                                    data-url="{{ request()->url() }}">
                                    @if (count($doughnut_years) > 0 && !in_array(date('Y'), array_column($doughnut_years->toArray(), 'year')))
                                        <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                                    @endif
                                    @foreach ($doughnut_years as $useryear)
                                        <option value="{{ $useryear->year }}"
                                            {{ date('Y') == $useryear->year ? 'selected' : '' }}>{{ $useryear->year }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div class="row">
                            <canvas id="doughnut"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (Auth::user()->type == 1)
            <div class="row g-4 py-4">
                <div class="col-xl-4">
                    <div class="card h-100">
                        <div class="card-header border-bottom">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <h5 class="card-title color-changer">
                                    {{ trans('labels.recent_providers') }}
                                </h5>
                                <a href="{{ URL::to('/providers') }}" class="fs-7 fw-600 text-secondary">
                                    {{ trans('labels.view') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (count($recent_providers) > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach ($recent_providers as $provider)
                                        <li class="list-group-item bg-transparent p-2">
                                            <div class="d-flex gap-3">
                                                <div class="col-auto">
                                                    <img src="{{ helper::image_path($provider->image) }}"
                                                        alt="{{ trans('labels.provider') }}"
                                                        class="rounded table-image object-fit-cover hw-50">
                                                </div>
                                                <div class="w-100 d-flex flex-column justify-content-center">
                                                    <p class="fs-15 fw-600 color-changer truncate-2">{{ $provider->name }}</p>
                                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                                        <p class="text-secondary fw-500 fs-13">
                                                            {{ $provider->providertype->name }}
                                                        </p>
                                                        <div class="d-flex align-items-center gap-1 color-changer fs-13 fw-500">
                                                            <i class="fa-solid fa-star text-warning"></i>
                                                            {{ number_format(@$provider->avgrattings->avg_ratting, 1) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                @include('front.nodata')
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card h-100">
                        <div class="card-header border-bottom">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <h5 class="card-title color-changer">
                                    {{ trans('labels.recent_customers') }}
                                </h5>
                                <a href="{{ URL::to('/users') }}" class="fs-7 fw-600 text-secondary">
                                    {{ trans('labels.view') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (count($recent_customers) > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach ($recent_customers as $customer)
                                        <li class="list-group-item bg-transparent p-2">
                                            <div class="d-flex gap-3">
                                                <div class="col-auto">
                                                    <img src="{{ helper::image_path($customer->image) }}"
                                                        alt="{{ trans('labels.customer') }}"
                                                        class="rounded table-image object-fit-cover hw-50">
                                                </div>
                                                <div class="w-100 d-flex flex-column justify-content-center">
                                                    <p class="fs-15 fw-600 color-changer truncate-2">{{ $customer->name }}</p>
                                                    <p class="fw-500 fs-13 text-muted">{{ $customer->email }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                @include('front.nodata')
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card h-100">
                        <div class="card-header border-bottom">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <h5 class="card-title color-changer">
                                    {{ trans('labels.recent_booking') }}
                                </h5>
                                <a href="{{ URL::to('/bookings') }}" class="fs-7 fw-600 text-secondary">
                                    {{ trans('labels.view') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (count($recent_bookings) > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach ($recent_bookings as $booking)
                                        <li class="list-group-item bg-transparent p-2">
                                            <div class="d-flex gap-3">
                                                <div class="col-auto">
                                                    <img src="{{ helper::image_path($booking->service_image) }}"
                                                        alt="{{ trans('labels.service') }}"
                                                        class="rounded table-image object-fit-cover hw-50">
                                                </div>
                                                <div class="w-100 d-flex flex-column justify-content-center">
                                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                                        <div>
                                                            <p class="text-secondary fw-600 fs-7">
                                                                {{ $booking->booking_id }}
                                                            </p>
                                                            <p class="fs-7 text-muted fw-500 truncate-2">{{ $booking->service_name }}
                                                            </p>
                                                        </div>
                                                        <p class="fs-7">
                                                            @if ($booking->status == 1)
                                                                <span class="badge text-bg-warning">
                                                                    {{ trans('labels.pending') }}
                                                                </span>
                                                            @elseif($booking->status == 2)
                                                                <span class="badge text-bg-secondary">
                                                                    @if ($booking->handyman_id != '')
                                                                        {{ trans('labels.handyman_assigned') }}
                                                                    @else
                                                                        {{ trans('labels.accepted') }}
                                                                    @endif
                                                                </span>
                                                            @elseif($booking->status == 3)
                                                                <span class="badge text-bg-success">
                                                                    {{ trans('labels.completed') }} </span>
                                                            @elseif($booking->status == 4)
                                                                <span class="badge text-bg-danger">
                                                                    @if ($booking->canceled_by == 1)
                                                                        @if (Auth::user()->type == 1)
                                                                            {{ trans('labels.cancel_by_provider') }}
                                                                        @else
                                                                            {{ trans('labels.cancel_by_you') }}
                                                                        @endif
                                                                    @else
                                                                        {{ trans('labels.cancel_by_customer') }}
                                                                    @endif
                                                                </span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                @include('front.nodata')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row g-4 py-4">
            @if (Auth::user()->type == 2)
                <div class="col-xl-6">
                    <div class="card h-100">
                        <div class="card-header border-bottom">
                            <h5 class="card-title color-changer">
                                {{ trans('labels.top_service') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            @if (count($top_services) > 0)
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th class="fs-15 fw-500">{{ trans('labels.image') }}</th>
                                                <th class="fs-15 fw-500">{{ trans('labels.service_name') }}</th>
                                                <th class="fs-15 fw-500">{{ trans('labels.category') }}</th>
                                                <th class="fs-15 fw-500">{{ trans('labels.bookings') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($top_services as $service)
                                                <tr class="fs-7 fw-500 text-dark align-middle">
                                                    <td>
                                                        <img src="{{ helper::image_path($service->image) }}"
                                                            class="rounded hw-50 object" alt="">
                                                    </td>
                                                    <td>
                                                        {{ $service->name }}
                                                    </td>
                                                    <td>{{ $service->categoryname->name }}</td>
                                                    <td>
                                                        @php
                                                            $per =
                                                                ($service->service_booking_counter * 100) /
                                                                $total_bookings;
                                                        @endphp
                                                        {{ number_format($per, 2) }}%
                                                        <div class="progress h-10-px">
                                                            <div class="progress-bar gradient-color"
                                                                style="width: {{ $per }}%;"
                                                                role="progressbar fw-500">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                @include('front.nodata')
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card h-100">
                        <div class="card-header border-bottom">
                            <h5 class="card-title color-changer">
                                {{ trans('labels.top_customer') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($top_customers->count() > 0)
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th class="fs-15 fw-500">{{ trans('labels.image') }}</th>
                                                <th class="fs-15 fw-500">{{ trans('labels.customer_name') }}</th>
                                                <th class="fs-15 fw-500">{{ trans('labels.email') }}</th>
                                                <th class="fs-15 fw-500">{{ trans('labels.bookings') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($top_customers as $customer)
                                                <tr class="fs-7 text-dark align-middle fw-500">
                                                    <td>
                                                        <img src="{{ helper::image_path($customer->image) }}"
                                                            class="rounded hw-50 object" alt="">
                                                    </td>
                                                    <td>
                                                        <p>{{ $customer->name }}</p>
                                                        <p>{{ $customer->mobile }}</p>
                                                    </td>
                                                    <td>{{ $customer->email }}</td>
                                                    <td>
                                                        @php
                                                            $per =
                                                                ($customer->user_booking_counter * 100) /
                                                                $total_bookings;
                                                        @endphp
                                                        {{ number_format($per, 2) }}%
                                                        <div class="progress h-10-px">
                                                            <div class="progress-bar gradient-color"
                                                                style="width: {{ $per }}%;" role="progressbar">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                @include('front.nodata')
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            @if (Auth::user()->type != 1)
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h5 class="card-title color-changer">
                                @if (Auth::user()->type == 2)
                                    {{ trans('labels.today_booking') }}
                                @elseif (Auth::user()->type == 3)
                                    {{ trans('labels.recent_booking') }}
                                @endif
                            </h5>
                        </div>
                        <div class="card-body">
                            @include('admin.today_booking_table')
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/js/chartist.js') }}"></script>

    <!--- Admin -------- users-chart-script --->
    <!--- VendorAdmin -------- orders-count-chart-script --->
    <script type="text/javascript">
        var doughnut = null;
        var doughnutlabels = {{ \Illuminate\Support\Js::from($doughnutlabels) }};
        var doughnutdata = {{ \Illuminate\Support\Js::from($doughnutdata) }};

        var boookingchart = null;
        var labels = {{ \Illuminate\Support\Js::from($bookinglabels) }};
        var bookingdata = {{ \Illuminate\Support\Js::from($bookingdata) }};

        // Admin -------- users-chart-script
        // VendorAdmin -------- orders-count-chart-script
        createdoughnut(doughnutlabels, doughnutdata);
        $("#doughnutyear").on("change", function() {
            "use strict";
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: $("#doughnutyear").attr("data-url"),
                method: "GET",
                data: {
                    doughnutyear: $("#doughnutyear").val()
                },
                dataType: "JSON",
                success: function(data) {
                    createdoughnut(data.doughnutlabels, data.doughnutdata);
                },
                error: function(data) {
                    toastr.error(wrong);
                    return false;
                }
            });
        });

        function createdoughnut(doughnutlabels, doughnutdata) {
            "use strict";

            const chartdata = {
                labels: doughnutlabels,

                datasets: [{
                    label: "Total : ",
                    backgroundColor: [
                        "rgba(54, 162, 235, 0.4)",
                        "rgba(255, 150, 86, 0.4)",
                        "rgba(140, 162, 198, 0.4)",
                        "rgba(255, 206, 86, 0.4)",
                        "rgba(255, 99, 132, 0.4)",
                        "rgba(255, 159, 64, 0.4)",
                        "rgba(255, 205, 86, 0.4)",
                        "rgba(75, 192, 192, 0.4)",
                        "rgba(54, 170, 235, 0.4)",
                        "rgba(153, 102, 255, 0.4)",
                        "rgba(201, 203, 207, 0.4)",
                        "rgba(255, 159, 64, 0.4)"
                    ],
                    borderColor: [
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 150, 86, 1)",
                        "rgba(140, 162, 198, 1)",
                        "rgba(255, 206, 86, 1)",
                        "rgba(255, 99, 132, 1)",
                        "rgba(255, 159, 64, 1)",
                        "rgba(255, 205, 86, 1)",
                        "rgba(75, 192, 192, 1)",
                        "rgba(54, 170, 235, 1)",
                        "rgba(153, 102, 255, 1)",
                        "rgba(201, 203, 207, 1)",
                        "rgba(255, 159, 64, 1)"
                    ],
                    borderWidth: 2,
                    hoverOffset: 5,
                    data: doughnutdata
                }]
            };

            const config = {
                type: "pie",

                data: chartdata,

                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            };

            if (doughnut != null) {
                doughnut.destroy();
            }

            if (document.getElementById("doughnut")) {
                doughnut = new Chart(document.getElementById("doughnut"), config);
            }
        }
        // Admin ------ booking-by-plans-chart-script
        // vendorAdmin ------ booking-by-orders-script
        createboookingChart(labels, bookingdata);
        $("#bookingyear").on("change", function() {
            "use strict";
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: $("#bookingyear").attr("data-url"),
                method: "GET",
                data: {
                    bookingyear: $("#bookingyear").val()
                },
                dataType: "JSON",
                success: function(data) {
                    createboookingChart(data.bookinglabels, data.bookingdata);
                },
                error: function(data) {
                    toastr.error(wrong);
                    return false;
                }
            });
        });

        function createboookingChart(labels, bookingdata, year) {
            "use strict";
            const chartdata = {
                labels: labels,
                datasets: [{
                    label: "booking ",
                    fill: {
                        target: "origin",
                        above: "color-mix(in srgb, {{ helper::otherdata()->admin_secondary_color }}, transparent 65%)"
                    },
                    borderColor: "{{ helper::otherdata()->admin_secondary_color }}",
                    tension: 0.1,
                    pointBackgroundColor: "{{ helper::otherdata()->admin_secondary_color }}",
                    pointBorderColor: "{{ helper::otherdata()->admin_secondary_color }}",
                    data: bookingdata
                }]
            };

            let delayed;
            const config = {
                type: "line",
                data: chartdata,
                options: {
                    animation: {
                        onComplete: () => {
                            delayed = true;
                        },
                        delay: (context) => {
                            let delay = 0;
                            if (context.type === 'data' && context.mode === 'default' && !delayed) {
                                delay = context.dataIndex * 300 + context.datasetIndex * 100;
                            }
                            return delay;
                        },
                    },
                }
            };
            if (boookingchart != null) {
                boookingchart.destroy();
            }
            if (document.getElementById("boookingchart")) {
                boookingchart = new Chart(document.getElementById("boookingchart"), config);
            }
        }


        $('#get-bookings').change(function() {
            var provider = $("#provider").val();
            var booking_year = $("#booking_year").val();
            BookingsChartData(booking_year, provider, 'Month wise bookings for');
        });

        function BookingsChartData(booking_year, provider, title) {
            var myurl = $("#get-bookings").attr('url');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: myurl,
                method: "GET",
                data: {
                    booking_year: booking_year,
                    provider: provider
                },
                dataType: "JSON",
                success: function(data) {
                    createboookingChart(data.bookinglabels, data.bookingdata);
                }
            });
        }
        @if (Auth::user()->type == 2 || Auth::user()->type == 3)
            $('#get-service-orders').change(function() {
                var service = $("#service").val();
                var service_year = $("#doughnutyear").val();
                ItemOrdersChartData(service_year, service, 'Month wise orders for');
            });

            function ItemOrdersChartData(service_year, service, title) {
                var myurl = $("#get-service-orders").attr('url');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: myurl,
                    method: "GET",
                    data: {
                        booking_year: service_year,
                        service: service
                    },
                    dataType: "JSON",
                    success: function(data) {
                        createdoughnut(data.doughnutlabels, data.doughnutdata);
                    }
                });
            }
        @endif
    </script>
@endsection
