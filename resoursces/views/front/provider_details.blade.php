@extends('front.layout.main')
@section('page_title', $providerdata->provider_name)
@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}" class="color-changer">{{ trans('labels.home') }}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ URL::to('/home/providers') }}" class="color-changer">{{ trans('labels.providers') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $providerdata->provider_name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- provider details -->
    <section class="py-4">
        <div class="container">
            <h2 class="fw-600 truncate-2 mb-4 color-changer sec-subtitle">{{ trans('labels.providers') }}</h2>
            <div class="row">
                @include('front.layout.provider_menu')
                <div class="col-xl-9 col-md-8">
                    <!-- provider profile -->
                    <div class="card mb-4">
                        <div class="card-header border-bottom bg-transparent py-3">
                            <h5 class="widget-title color-changer m-0">{{ trans('labels.profile') }}</h5>
                        </div>
                        <div class="card-body">
                            @if (!empty($providerdata))
                                <div class="row g-3">
                                    <div class="col-xl-6 col-lg-6 col-12">
                                        <label class="form-label">{{ trans('labels.name') }}</label>
                                        <input class="form-control fs-7 p-2" type="text"
                                            value="{{ $providerdata->provider_name }}" disabled>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12">
                                        <label class="form-label">{{ trans('labels.email') }}</label>
                                        <input class="form-control fs-7 p-2" type="email"
                                            value="{{ $providerdata->email }}" disabled>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12">
                                        <label class="form-label">{{ trans('labels.mobile') }}</label>
                                        <input class="form-control fs-7 p-2 no_only" type="text"
                                            value="{{ $providerdata->mobile }}" disabled>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-12">
                                        <label class="form-label">{{ trans('labels.address') }}</label>
                                        <input class="form-control fs-7 p-2" type="text"
                                            value='{{ strip_tags($providerdata->address) }}' disabled>
                                    </div>
                                    <div class="col-xl-12">
                                        <label class="form-label">{{ trans('labels.about') }}</label>
                                        <textarea class="form-control fs-7 p-2" rows="3" disabled>{{ strip_tags($providerdata->about) }}</textarea>
                                    </div>
                                </div>
                            @else
                                @include('front.nodata')
                            @endif
                        </div>
                    </div>

                    <!-- provider Service Availability -->
                    <div class="card">
                        <div class="card-header border-bottom bg-transparent py-3">
                            <h5 class="widget-title mb-0 color-changer">{{ trans('labels.service_availability') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                @if (!empty($timingdata))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table availability-table">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>{{ trans('labels.days') }}</th>
                                                            <th>{{ trans('labels.from_time') }}</th>
                                                            <th>{{ trans('labels.to_time') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($timingdata as $tdata)
                                                            <tr>
                                                                <td>{{ $tdata->day }}</td>
                                                                @if ($tdata->is_always_close == 1)
                                                                    <td colspan="2"> <i>
                                                                            {{ trans('labels.not_available') }} </i></td>
                                                                @else
                                                                    <td>{{ $tdata->open_time }}</td>
                                                                    <td>{{ $tdata->close_time }}</td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    @include('front.nodata')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('front.become_provider')
@endsection
