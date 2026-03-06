@extends('layout.main')
@section('page_title')
    {{ trans('labels.handyman') }} | {{ @$handymandata->name }}
@endsection
@section('content')
    <div class="container-fluid">
        <section id="basic-form-layouts">
            <div class="mb-3">
                <h5 class="card-title color-changer fs-4 fw-600">
                    {{ trans('labels.handyman_details') }}
                </h5>
            </div>
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="row g-4">
                                    <div class="col-xl-6 col-12">
                                        <div class="row g-4 match-height">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                                <div class="card h-100 border-0 rgb-secondary-light shadow-none">
                                                    <div class="card-body p-4">
                                                        <div class="dashboard-card flex-column">
                                                            <div class="card-icon bg-secondary">
                                                                <i class="icon-heart font-large-2 float-right"></i>
                                                            </div>
                                                            <div class="media-body text-center mt-3">
                                                                <h4 class="mb-0 color-changer fw-600">{{ @$total_bookings }}
                                                                </h4>
                                                                <p class="mb-1 color-changer">
                                                                    {{ trans('labels.total_bookings') }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                                <div class="card h-100 border-0 rgb-warning-light shadow-none">
                                                    <div class="card-body p-4">
                                                        <div class="dashboard-card flex-column">
                                                            <div class="card-icon bg-warning">
                                                                <i class="icon-graph white font-large-2 float-right"></i>
                                                            </div>
                                                            <div class="media-body white text-center mt-3">
                                                                <h4 class="mb-0 color-changer fw-600">{{ @$total_pending }}
                                                                </h4>
                                                                <p class="mb-1 color-changer">
                                                                    {{ trans('labels.total_pending') }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                                <div class="card h-100 border-0 rgb-success-light shadow-none">
                                                    <div class="card-body p-4">
                                                        <div class="dashboard-card flex-column">
                                                            <div class="card-icon bg-success">
                                                                <i class="icon-check white font-large-2 float-left"></i>
                                                            </div>
                                                            <div class="media-body white text-center mt-3">
                                                                <h4 class="mb-0 color-changer fw-600">
                                                                    {{ @$total_completed }}</h4>
                                                                <p class="mb-1 color-changer">
                                                                    {{ trans('labels.total_completed') }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <img src="{{ helper::image_path($handymandata->image) }}"
                                                                class="rounded-circle zoom-in object-fit-cover"
                                                                data-enlargeable width="65px" height="65px" />
                                                            <div class="">
                                                                <p class="fs-13 text-secondary mb-1 fw-500">
                                                                    {{ trans('labels.handyman') }}</p>
                                                                <h6 class="fw-600 color-changer fs-15 m-0 truncate-1">
                                                                    {{ $handymandata->name }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                        <ul class="d-flex flex-column gap-1 mt-3">
                                                            <li class="d-flex gap-2 color-changer fs-7 align-items-center">
                                                                <i class="ft-phone"></i>
                                                                {{ $handymandata->mobile }}
                                                            </li>
                                                            <li class="d-flex gap-2 color-changer fs-7 align-items-center">
                                                                <i class="ft-mail"></i>
                                                                {{ $handymandata->email }}
                                                            </li>
                                                            <li class="d-flex gap-2 color-changer fs-7 align-items-center">
                                                                <i class="ft-map font-small-3"></i>
                                                                <div class="display-block overflow-hidden">
                                                                    {{ strip_tags($handymandata->address) . ' ,' . $handymandata['city']->name }}
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-12">
                                        <div class="card box-shadow border h-100 overflow-hidden">
                                            <div class="card-header border-bottom">
                                                <div class="d-flex justify-content-between gap-2 align-items-center">
                                                    <h5 class="panel-title color-changer m-0">
                                                        {{ trans('labels.bookings') }}</h5>
                                                    <div class="col-auto">
                                                        <select name="year" class="form-select" id="booking_year"
                                                            data-show-subtext="true"data-live-search="true"
                                                            url="{{ URL::to('/handymans/' . $handymandata->slug) }}">
                                                            @foreach ($years as $year)
                                                                <option value="{{ $year->year }}">
                                                                    {{ $year->year }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <canvas id="bookings_count"></canvas>
                                                </div>
                                            </div>
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
        var bookings_count = null;
        var bookings_countlabels = {{ \Illuminate\Support\Js::from($bookings_countlabels) }};
        var bookings_countdata = {{ \Illuminate\Support\Js::from($bookings_countdata) }};

        createboookingChart(bookings_countlabels, bookings_countdata);
        $("#booking_year").on("change", function() {
            "use strict";
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: $("#booking_year").attr('url'),
                method: "GET",
                data: {
                    booking_year: $("#booking_year").val()
                },
                dataType: "JSON",
                success: function(data) {
                    createboookingChart(data.bookings_countlabels, data.bookings_countdata);
                },
                error: function(data) {
                    toastr.error(wrong);
                    return false;
                }
            });
        });

        function createboookingChart(labels, bookingdata) {
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
                    maintainAspectRatio: false,
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

            if (bookings_count != null) {
                bookings_count.destroy();
            }

            if (document.getElementById("bookings_count")) {
                bookings_count = new Chart(document.getElementById("bookings_count"), config);
            }
        }
    </script>
@endsection
