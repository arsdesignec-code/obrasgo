@extends('layout.main')
@section('page_title')
    {{ trans('labels.service') }} | {{ @$servicedata->service_name }}
@endsection
@section('content')
    <div class="container-fluid">
        <section>
            <div class="col-12">
                <div class="mb-3">
                    <h5 class="card-title color-changer fs-4 fw-600">
                        {{ trans('labels.service_details') }}
                    </h5>
                </div>
                <div class="row g-4 pb-4 match-height">
                    <div class="col-xl-6">
                        <div class="row g-4 match-height">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                <div class="border-0 card gradient-green-tea rgb-secondary-light">
                                    <div class="card-body p-4">
                                        <div class="dashboard-card flex-column">
                                            <div class="card-icon bg-secondary">
                                                <i class="icon-check"></i>
                                            </div>
                                            <div class="mt-3 media-body text-center">
                                                <h4 class="mb-0 fw-600 color-changer text-center">{{ $total_completed }}
                                                </h4>
                                                <span class="fs-15 fw-medium d-block color-changer">
                                                    {{ trans('labels.total_completed') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                <div class="border-0 card gradient-blackberry rgb-warning-light">
                                    <div class="card-body p-4">
                                        <div class="dashboard-card flex-column">
                                            <div class="card-icon bg-warning">
                                                <i class="icon-graph"></i>
                                            </div>
                                            <div class="mt-3 media-body text-center">
                                                <h4 class="mb-0 fw-600 color-changer text-center">{{ $total_pending }}</h4>
                                                <span
                                                    class="fs-15 fw-medium color-changer d-block">{{ trans('labels.total_pending') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                <div class="border-0 card gradient-ibiza-sunset rgb-danger-light">
                                    <div class="card-body p-4">
                                        <div class="dashboard-card flex-column">
                                            <div class="card-icon bg-danger">
                                                <i class="icon-close"></i>
                                            </div>
                                            <div class="media-body text-center mt-3">
                                                <h4 class="mb-0 fw-600 color-changer text-center">{{ $total_canceled }}</h4>
                                                <span class="fs-15 color-changer fw-medium d-block">
                                                    {{ trans('labels.total_cancelled') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                <div class="border-0 card gradient-green-tea rgb-dark-light">
                                    <div class="card-body p-4">
                                        <div class="dashboard-card flex-column">
                                            <div class="card-icon bg-dark">
                                                <i class="icon-speedometer"></i>
                                            </div>
                                            <div class="media-body text-center mt-3">
                                                <h4 class="mb-0 fw-600 color-changer text-center">{{ $total_bookings }}</h4>
                                                <span class="fs-15 color-changer fw-medium d-block">
                                                    {{ trans('labels.total_bookings') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                <div class="border-0 card gradient-ibiza-sunset rgb-info-light">
                                    <div class="card-body p-4">
                                        <div class="dashboard-card flex-column">
                                            <div class="card-icon bg-info">
                                                <i class="icon-clock"></i>
                                            </div>
                                            <div class="media-body text-center mt-3">
                                                <h4 class="mb-0 fw-600 color-changer text-center">
                                                    {{ helper::currency_format($total_pending_earning) }}
                                                </h4>
                                                <span class="fs-15 fw-medium color-changer d-block">
                                                    {{ trans('labels.pending_earnings') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                <div class="border-0 card gradient-pomegranate rgb-success-light">
                                    <div class="card-body p-4">
                                        <div class="dashboard-card flex-column">
                                            <div class="card-icon bg-success">
                                                <i class="icon-bar-chart"></i>
                                            </div>
                                            <div class="mt-3 media-body text-center">
                                                <h4 class="mb-0 fw-600 color-changer text-center">
                                                    {{ helper::currency_format($total_earning) }}
                                                </h4>
                                                <span class="fs-15 fw-medium color-changer d-block">
                                                    {{ trans('labels.total_earnings') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- chart -->
                    <div class="col-xl-6">
                        <div class="card h-100 border-0">
                            <div class="card-header border-bottom">
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <h5 class="panel-title color-changer">{{ trans('labels.bookings') }}</h5>
                                    <div class="col-auto">
                                        <select name="year" class="form-select" id="year"
                                            data-show-subtext="true"data-live-search="true"
                                            url="{{ URL::to('/services/' . $servicedata->slug) }}">
                                            <option value="" selected disabled>{{ trans('labels.select') }}
                                            </option>
                                            @foreach ($years as $year)
                                                <option value="{{ $year->year }}"
                                                    @if ($year->year == $servicedata->year) selected @endif>
                                                    {{ $year->year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="piechart_3d" class="card-body card-block height-400 width-600 lineAreaDashboard">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div id="about">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h5 class="color-changer">{{ trans('labels.service') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex custom-wrap gap-3 mb-2">
                                        <div class="col-auto">
                                            <img src="{{ helper::image_path($servicedata->service_image) }}"
                                                class="rounded zoom-in object-fit-cover" width="130px" height="130px"
                                                data-enlargeable />
                                        </div>
                                        <div class="media-body w-100">
                                            <div class="col-md-12">
                                                <div
                                                    class="border-bottom mb-2 pb-2 d-flex justify-content-between align-items-center gap-2">
                                                    <h5 class="fw-500 color-changer fs-6 m-0 truncate-2">
                                                        {{ $servicedata->service_name }}
                                                    </h5>
                                                    <div class="vendor_ratting">
                                                        <i class="fa-solid fa-star fs-7 text-warning"></i>
                                                        <span class="fs-7 color-changer fw-500">
                                                            {{ number_format($serviceaverageratting->avg_ratting, 1) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <ul class="list-unstyled">
                                                        <li class="">
                                                            <p class="fs-7 color-changer mb-2">
                                                                {{ trans('labels.description') }}
                                                            </p>
                                                            <div class="truncate-2 text-muted fs-7">
                                                                {!! $servicedata->description !!}
                                                                {{-- {!! Str::limit($servicedata->description, 250) !!} --}}
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <div class="row g-3">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <ul class="list-unstyled">
                                                        <li class="">
                                                            <p class="fs-7 text-muted mb-2">
                                                                {{ trans('labels.status') }}
                                                            </p>
                                                            <p class="d-block overflow-hidden fs-7 fw-500">
                                                                @if ($servicedata->is_available == 1)
                                                                    <span class="text-success fs-7 fw-500">
                                                                        {{ trans('labels.active') }}</span>
                                                                @elseif($servicedata->is_available == 2)
                                                                    <span class="text-danger fs-7 fw-500">
                                                                        {{ trans('labels.not_active') }}</span>
                                                                @endif
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6">
                                                    <ul class="list-unstyled">
                                                        <li class="">
                                                            <p class="fs-7 text-muted mb-2">
                                                                {{ trans('labels.price') }}
                                                            </p>
                                                            <p class="d-block color-changer overflow-hidden fs-7 fw-500">
                                                                {{ helper::currency_format($servicedata->price) }}
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
                                                                @if ($servicedata->price_type == 'Fixed')
                                                                    @if ($servicedata->duration_type == 1)
                                                                        {{ $servicedata->duration . trans('labels.minutes') }}
                                                                    @elseif ($servicedata->duration_type == 2)
                                                                        {{ $servicedata->duration . trans('labels.hours') }}
                                                                    @elseif ($servicedata->duration_type == 3)
                                                                        {{ $servicedata->duration . trans('labels.days') }}
                                                                    @else
                                                                        {{ $servicedata->duration . trans('labels.minutes') }}
                                                                    @endif <i
                                                                        class="fas fa-clock ml-1"></i>
                                                                @else
                                                                    {{ $servicedata->price_type }} <i
                                                                        class="fas fa-clock ml-1"></i>
                                                                @endif
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <ul class="list-unstyled">
                                                        <li class="">
                                                            <p class="fs-7 text-muted mb-2">
                                                                {{ trans('labels.created_at') }}
                                                            </p>
                                                            <p class="d-block color-changer overflow-hidden fs-7 fw-500">
                                                                {{ helper::date_format($servicedata->date) }}
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6">
                                                    <ul class="list-unstyled">
                                                        <li class="">
                                                            <p class="fs-7 text-muted mb-2">
                                                                {{ trans('labels.discount') }}
                                                            </p>
                                                            <p class="d-block color-changer overflow-hidden fs-7 fw-500">
                                                                {{ number_format($servicedata->discount, 2) }} %
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
                                                                {{ $servicedata->category_name }}
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
                    </div>
                    <div class="col-xl-6">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ helper::image_path($servicedata->provider_image) }}"
                                            class="rounded-circle zoom-in object-fit-cover" data-enlargeable
                                            width="65px" height="65px" />
                                        <div class="">
                                            <p class="fs-13 text-secondary mb-1 fw-500">
                                                {{ trans('labels.provider') }}</p>
                                            <h6 class="fw-600 color-changer fs-15 m-0 truncate-1">
                                                {{ $servicedata->provider_name }}
                                            </h6>
                                        </div>
                                    </div>
                                    <ul class="d-flex flex-column gap-1 mt-3">
                                        <li class="d-flex gap-2 color-changer fs-7 align-items-center">
                                            <i class="ft-phone"></i>
                                            {{ $servicedata->provider_mobile }}
                                        </li>
                                        <li class="d-flex flex-wrap color-changer gap-2 fs-7 align-items-center">
                                            <i class="ft-mail"></i>
                                            {{ $servicedata->provider_email }}
                                        </li>
                                    </ul>
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
    <script src="{{ asset('storage/app/public/admin-assets/js/google-chart.js') }}" type="text/javascript"></script>
    <script src="{{ asset('resources/views/service/service.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var booking = <?php echo $booking; ?>;
        drawMonthwiseChart(booking, 'Month wise bookings');
        $('#year').change(function() {
            var year = $(this).val();
            load_monthwise_data(year, 'Month wise bookings For');
        });

        function load_monthwise_data(year, title) {
            var myurl = $("#year").attr('url');
            var temp_title = title + ' ' + year + '';
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: myurl,
                method: "GET",
                data: {
                    year: year
                },
                dataType: "JSON",
                success: function(data) {
                    drawMonthwiseChart(data, temp_title);
                }
            });
        }

        function drawMonthwiseChart(chart_data, chart_main_title) {
            google.charts.load("current", {
                packages: ["corechart"]
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable(chart_data);
                var options = {
                    title: chart_main_title,
                    is3D: true,
                    pieSliceText: 'value-and-percentage',
                };
                var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                chart.draw(data, options);
            }
        }
    </script>
@endsection
