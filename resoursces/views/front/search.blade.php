@extends('front.layout.main')
@section('page_title', trans('labels.search'))
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}" class="color-changer">{{ trans('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.search') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- search -->

    <div class="content">
        <div class="container">

            <!-- search_filter -->
            <h4 class="fw-600 truncate-2 mb-4 color-changer sec-subtitle">
                {{ trans('labels.search_filter') }}
            </h4>
            <div class="bg-gradients bg-change-mode bg-white mb-4 border-0 rounded p-4">
                <div class="col-11 mx-auto z-index-9">
                    <div class="rounded bg-white shadow filter-card">
                        <div class="card-body p-4">
                            <form id="search_form" action="{{ URL::to('/home/search') }}" method="GET">
                                <div class="filter-widget row g-3 justify-content-between">
                                    <!-- search by -->
                                    <div class="col-lg-5 col-md-6 col-sm-6">
                                        <select class="form-select input_paddins rounded fs-15 selectbox select"
                                            name="search_by" id="search_by" data-next-page="{{ URL::to('/home/search') }}"
                                            required>
                                            <option value="service" @isset($servicedata) selected @endisset>
                                                {{ trans('labels.service') }} </option>
                                            <option value="provider" @isset($providerdata) selected @endisset>
                                                {{ trans('labels.provider') }} </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-5 col-md-6 col-sm-6">
                                        <input type="text" class="form-control input_paddins fs-15 rounded"
                                            id="search_name" name="search_name"
                                            @isset($_GET['search_name']) value="{{ $_GET['search_name'] }}" @endisset
                                            placeholder="{{ trans('labels.enter_service') }}">
                                    </div>
                                    <div class="col-lg-2 d-flex align-items-end">
                                        <button
                                            class="btn btn-primary w-100 h-100 rounded pl-5 pr-5 fs-15 btn-block get_services input_paddins"
                                            type="submit" value="">{{ trans('labels.search') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex bg-primary-rgb p-3 mb-5 rounded-3 justify-content-between align-items-center">
                <span class="fs-15 color-changer fw-600">
                    @isset($servicedata)
                        {{ trans('labels.showing') }}
                        {{ $servicedata->firstItem() ? $servicedata->firstItem() : 0 }}–{{ $servicedata->lastItem() ? $servicedata->lastItem() : 0 }}
                        {{ trans('labels.of') }}
                        {{ $servicedata->total() }} {{ trans('labels.result') }}
                    @endisset
                    @isset($providerdata)
                        {{ trans('labels.showing') }}
                        {{ $providerdata->firstItem() ? $providerdata->firstItem() : 0 }}–{{ $providerdata->lastItem() ? $providerdata->lastItem() : 0 }}
                        {{ trans('labels.of') }}
                        {{ $providerdata->total() }} {{ trans('labels.result') }}
                    @endisset
                </span>
                <ul class="d-flex flex-nowrap justify-content-end gap-2 nav nav-pills nav-pills-dark" id="tour-pills-tab"
                    role="tablist">
                    <li class="nav-item">
                        <a class="nav-link view-list-grid cursor-pointer color-changer text-dark border border-dark service-active"
                            id="column" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Grid view">
                            <i class="fa-solid fa-grip fs-5"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link view-list-grid cursor-pointer color-changer text-dark border border-dark" id="grid"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="List view">
                            <i class="fa-solid fa-list-ul fs-15"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- search result -->


            <div class="search-deta">
                <div class="listing-view">
                    <div class="search-service row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-3" id="data">
                        <!-- service card -->
                        @isset($servicedata)
                            @if (!empty($servicedata) && count($servicedata) > 0)
                                @foreach ($servicedata as $sdata)
                                    @if (helper::appdata()->service_card_view == 1)
                                        <div class="col">
                                            @include('front.card_layout.grid_view.servicecommonview')
                                        </div>
                                    @elseif (helper::appdata()->service_card_view == 2)
                                        <div class="col">
                                            @include('front.card_layout.grid_view.servicecommonview_1')
                                        </div>
                                    @elseif (helper::appdata()->service_card_view == 3)
                                        <div class="col">
                                            @include('front.card_layout.grid_view.servicecommonview_2')
                                        </div>
                                    @elseif (helper::appdata()->service_card_view == 4)
                                        <div class="col">
                                            @include('front.card_layout.grid_view.servicecommonview_3')
                                        </div>
                                    @elseif (helper::appdata()->service_card_view == 5)
                                        <div class="col">
                                            @include('front.card_layout.grid_view.servicecommonview_4')
                                        </div>
                                    @elseif (helper::appdata()->service_card_view == 6)
                                        <div class="col">
                                            @include('front.card_layout.grid_view.servicecommonview_5')
                                        </div>
                                    @elseif (helper::appdata()->service_card_view == 7)
                                        <div class="col">
                                            @include('front.card_layout.grid_view.servicecommonview_6')
                                        </div>
                                    @elseif (helper::appdata()->service_card_view == 8)
                                        <div class="col">
                                            @include('front.card_layout.grid_view.servicecommonview_7')
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                @include('front.nodata')
                            @endif
                        @endisset
                    </div>
                </div>
                <div id="column-view" class="d-none">
                    <div class="search-service row row-cols-1 row-cols-sm-2 row-cols-lg-2 row-cols-xl-3 g-3" id="data">
                        <!-- service card -->
                        @isset($servicedata)
                            @if (!empty($servicedata) && count($servicedata) > 0)
                                @foreach ($servicedata as $sdata)
                                    @if (helper::appdata()->service_card_view == 1)
                                        @include('front.card_layout.list_view.servicelistview')
                                    @elseif (helper::appdata()->service_card_view == 2)
                                        @include('front.card_layout.list_view.servicelistview_1')
                                    @elseif (helper::appdata()->service_card_view == 3)
                                        @include('front.card_layout.list_view.servicelistview_2')
                                    @elseif (helper::appdata()->service_card_view == 4)
                                        @include('front.card_layout.list_view.servicelistview_3')
                                    @elseif (helper::appdata()->service_card_view == 5)
                                        @include('front.card_layout.list_view.servicelistview_4')
                                    @elseif (helper::appdata()->service_card_view == 6)
                                        @include('front.card_layout.list_view.servicelistview_5')
                                    @elseif (helper::appdata()->service_card_view == 7)
                                        @include('front.card_layout.list_view.servicelistview_6')
                                    @elseif (helper::appdata()->service_card_view == 8)
                                        @include('front.card_layout.list_view.servicelistview_7')
                                    @endif
                                @endforeach
                            @else
                                @include('front.nodata')
                            @endif
                        @endisset
                    </div>
                </div>
                <!-- provider card -->
                @isset($providerdata)
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3 g-md-4">
                        @foreach ($providerdata as $fpdata)
                            <div class="col">
                                <div class="card h-100 our-team">
                                    <div class="card-body">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <div class="pic shadow">
                                                <img src="{{ helper::image_path($fpdata->provider_image) }}" alt="">
                                            </div>
                                            <h6 class="truncate-2 text-primary mb-0 mt-3 fw-600">
                                                {{ $fpdata->provider_name }}
                                            </h6>
                                            <span class="text-muted truncate-2 fw-500 fs-15">
                                                {{ $fpdata->provider_type }}
                                            </span>
                                            <a href="{{ URL::to('/home/providers-services/' . $fpdata->slug) }}"
                                                class="text-primary">
                                                <div class="go_arrow border mt-2 fw-600">
                                                    <i
                                                        class="fa-regular fa-arrow-{{ session()->get('direction') == 2 ? 'left' : 'right' }}"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="card h-100 service-card">
                                    <div class="service-img">
                                        <a href="{{ URL::to('/home/providers-services/' . $fpdata->slug) }}">
                                            <img src="{{ helper::image_path($fpdata->provider_image) }}"
                                                alt="provider image" class="serv-img popular-services-img">
                                        </a>
                                    </div>
                                    <div class="card-body pt-3">
                                        <h5 class="fw-semibold truncate-2 text-center">{{ $fpdata->provider_name }}</h5>
                                        <p class="text-muted truncate-2 fs-6 fw-medium text-center m-0">
                                            {{ $fpdata->provider_type }}</p>
                                    </div>
                                </div> --}}
                            </div>
                        @endforeach
                    </div>
                @endisset

                <div class="d-flex justify-content-center">
                    @if (isset($servicedata) && !empty($servicedata))
                        {!! $servicedata->appends(\Request::except('page'))->render() !!}
                    @endif
                    @isset($providerdata)
                        {!! $providerdata->appends(\Request::except('page'))->render() !!}
                    @endisset
                </div>
            </div>
        </div>
    </div>

    @include('front.become_provider')
@endsection
