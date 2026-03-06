@extends('layout.main')
@section('page_title')
    {{ trans('labels.provider') }} | {{ @$providerdata->name }}
@endsection
@section('content')
    <div class="container-fluid">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="mb-3">
                    <h5 class="card-title color-changer fs-4 fw-600">
                        {{ trans('labels.provider_details') }}
                    </h5>
                </div>
                <!-- Provider Personal Info -->
                <div class="col-12 col-md-12 col-lg-12">
                    <ul class="nav nav-pills gap-3 mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rgb-secondary-light fs-7 text-capitalize fw-500 text-secondary active"
                                id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview" type="button"
                                role="tab" aria-controls="overview" aria-selected="true">
                                {{ trans('labels.overview') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rgb-secondary-light fs-7 text-capitlze fw-500 text-secondary"
                                id="service-tab" data-bs-toggle="pill" data-bs-target="#service-tabs" type="button"
                                role="tab" aria-controls="service-tabs" aria-selected="false">
                                {{ trans('labels.service') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rgb-secondary-light fs-7 text-capitlze fw-500 text-secondary"
                                id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button"
                                role="tab" aria-controls="pills-contact" aria-selected="false">
                                {{ trans('labels.handyman') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rgb-secondary-light fs-7 text-capitlze fw-500 text-secondary"
                                id="reviews-tab" data-bs-toggle="pill" data-bs-target="#reviews" type="button"
                                role="tab" aria-controls="reviews" aria-selected="false">
                                {{ trans('labels.reviews') }}
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab"
                            tabindex="0">
                            <div class="col-12 col-md-12 col-lg-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-4">
                                            <div class="col-xl-6 col-12">
                                                <div class="row g-4 match-height">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                                        <div class="card h-100 rgb-secondary-light shadow-none">
                                                            <div class="card-body p-4">
                                                                <div class="dashboard-card flex-column">
                                                                    <div class="card-icon bg-secondary">
                                                                        <i class="icon-heart"></i>
                                                                    </div>
                                                                    <div class="media-body mt-3 text-center">
                                                                        <h4 class="mb-0 color-changer fw-600">
                                                                            {{ count($servicedata) }}
                                                                        </h4>
                                                                        <span class="fs-15 color-changer fw-medium d-block">
                                                                            {{ trans('labels.total_services') }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                                        <div class="card h-100 rgb-info-light shadow-none">
                                                            <div class="card-body p-4">
                                                                <div class="dashboard-card flex-column">
                                                                    <div class="card-icon bg-info">
                                                                        <i class="icon-users"></i>
                                                                    </div>
                                                                    <div class="media-body mt-3 text-center">
                                                                        <h4 class="mb-0 color-changer fw-600">
                                                                            {{ count($handymandata) }}
                                                                        </h4>
                                                                        <span class="fs-15 color-changer fw-medium d-block">
                                                                            {{ trans('labels.total_handyman') }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                                        <div class="card h-100 rgb-warning-light shadow-none">
                                                            <div class="card-body p-4">
                                                                <div class="dashboard-card flex-column">
                                                                    <div class="card-icon bg-warning">
                                                                        <i class="icon-wallet"></i>
                                                                    </div>
                                                                    <div class="media-body mt-3 text-center">
                                                                        <h4 class="mb-0 color-changer fw-600">
                                                                            {{ helper::currency_format($providerdata->wallet) }}
                                                                        </h4>
                                                                        <span class="fs-15 color-changer fw-medium d-block">
                                                                            {{ trans('labels.wallet') }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                                        <div class="card h-100 rgb-success-light shadow-none">
                                                            <div class="card-body p-4">
                                                                <div class="dashboard-card flex-column">
                                                                    <div class="card-icon bg-success">
                                                                        <i class="fa-light fa-money-bill-1-wave"></i>
                                                                    </div>
                                                                    <div class="media-body mt-3 text-center">
                                                                        <h4 class="mb-0 color-changer fw-600">
                                                                            {{ helper::currency_format($total_earning) }}
                                                                        </h4>
                                                                        <span class="fs-15 color-changer fw-medium d-block">
                                                                            {{ trans('labels.total_earnings') }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-body p-3">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <img src="{{ helper::image_path($providerdata->image) }}"
                                                                        class="rounded-circle zoom-in object-fit-cover"
                                                                        data-enlargeable width="65px" height="65px" />
                                                                    <div class="">
                                                                        <p class="fs-13 text-secondary mb-1 fw-500">
                                                                            {{ trans('labels.provider') }}</p>
                                                                        <h6 class="fw-600 color-changer fs-15 m-0 truncate-1">
                                                                            {{ $providerdata->name }}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                                <ul class="d-flex color-changer flex-column gap-1 mt-3">
                                                                    <li class="d-flex gap-2 fs-7 align-items-center">
                                                                        <i class="ft-phone"></i>
                                                                        {{ $providerdata->mobile }}
                                                                    </li>
                                                                    <li class="d-flex gap-2 fs-7 align-items-center">
                                                                        <i class="ft-mail"></i>
                                                                        {{ $providerdata->email }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-12">
                                                <div class="card h-100 box-shadow">
                                                    <div class="card-header border-bottom">
                                                        <div class="row">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between gap-2">
                                                                <h5 class="panel-title color-changer">
                                                                    {{ trans('labels.earnings') }}
                                                                </h5>
                                                                <div class="col-auto">
                                                                    <select name="earning_year" class="form-select"
                                                                        id="earning_year" data-show-subtext="true"
                                                                        data-live-search="true"
                                                                        url="{{ URL::to('/providers/' . $providerdata->slug) }}">
                                                                        @foreach ($years as $year)
                                                                            <option value="{{ $year->year }}">
                                                                                {{ $year->year }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <canvas id="doughnut" style="height: 450px;"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Provider Services List -->
                        <div class="tab-pane fade" id="service-tabs" role="tabpanel" aria-labelledby="service-tabs"
                            tabindex="0">
                            <div class="col-12 col-md-12 col-lg-12 mb-4">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h5 class="card-title color-changer">{{ trans('labels.services') }}</h5>
                                    </div>
                                    <div class="card-body collapse show">
                                        @include('service.service_table')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Provider Handyman List -->
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab" tabindex="0">
                            <div class="col-12 col-md-12 col-lg-12 mb-4">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h5 class="card-title color-changer">
                                            {{ trans('labels.handyman') }}
                                        </h5>
                                    </div>
                                    <div class="card-body collapse show">
                                        <div
                                            class="row row-cols-xxl-5 row-cols-xl-4 row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-1 g-3">
                                            @foreach ($handymandata as $hdata)
                                                <div class="col">
                                                    <div class="card shadow-none rounded-4 h-100">
                                                        <div class="border rounded-4 h-100">
                                                            <div class="p-3 border-0 rgb-secondary-light rounded-4">
                                                                <div class="d-flex gap-2 align-items-center">
                                                                    <div class="col-auto">
                                                                        <img src="{{ helper::image_path($hdata->image) }}"
                                                                            alt="{{ trans('labels.image') }}"
                                                                            class="rounded-circle object-fit-cover table-image hw-58">
                                                                    </div>
                                                                    <div class="w-100">
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center w-100 ">
                                                                            <h6 class="fw-600 text-secondary truncate-1">
                                                                                {{ $hdata->name }}
                                                                            </h6>
                                                                            <a href="{{ URL::to('/handymans/' . $hdata->slug) }}"
                                                                                class="text-black-50"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="top"
                                                                                data-bs-title="View">
                                                                                <div class="icon-view-han">
                                                                                    <i class="fa-solid fa-eye"></i>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <p class="fs-8 mt-1 color-changer">{{ $hdata->mobile }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-body p-3">
                                                                <p class="fs-7 color-changer mt-1">
                                                                    {{ trans('labels.email') }} :
                                                                    {{ $hdata->email }}
                                                                </p>
                                                                <p class="fs-7 color-changer mt-1">
                                                                    {{ trans('labels.city') }} :
                                                                    {{ $hdata['city']->name }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- rattings list -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab"
                            tabindex="0">
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h5 class="card-title color-changer">{{ trans('labels.rattings_reviews') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-block">
                                            @include('provider.rattings_table')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/js/chartist.js') }}"></script>
    <script type="text/javascript">
        var earning = null;
        var earninglabels = {{ \Illuminate\Support\Js::from($earninglabels) }};
        var earningdata = {{ \Illuminate\Support\Js::from($earningdata) }};

        createdoughnut(earninglabels, earningdata);
        $("#earning_year").on("change", function() {
            "use strict";
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: $("#earning_year").attr('url'),
                method: "GET",
                data: {
                    year: $("#earning_year").val()
                },
                dataType: "JSON",
                success: function(data) {
                    createdoughnut(data.earninglabels, data.earningdata);
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
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            };

            if (earning != null) {
                earning.destroy();
            }

            if (document.getElementById("doughnut")) {
                earning = new Chart(document.getElementById("doughnut"), config);
            }
        }
    </script>
@endsection
