@extends('front.layout.main')
@section('page_title')
    {{ @$providerdata->provider_name }} | {{ trans('labels.services') }}
@endsection
@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                            <li class="breadcrumb-item">
                                <a href="{{ URL::to('/') }}" class="color-changer">
                                    {{ trans('labels.home') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ URL::to('/home/providers') }}" class="color-changer">
                                    {{ trans('labels.providers') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ @$providerdata->provider_name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- providers -->
    <section class="pt-4">
        <div class="container">
            <h2 class="fw-600 truncate-2 mb-4 sec-subtitle color-changer">{{ trans('labels.providers') }}</h2>
            <div class="row">
                @include('front.layout.provider_menu')
                <div class="col-xl-9 col-md-8">
                    <div class="card mb-4">
                        <div class="card-header border-bottom bg-transparent py-3">
                            <h5 class="widget-title m-0 color-changer">{{ trans('labels.services') }}</h5>
                        </div>
                        <div class="card-body">
                            @if (!empty($servicedata) && count($servicedata) > 0)
                                <div class="row g-3 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1">
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
                                </div>
                            @else
                                @include('front.nodata')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('front.become_provider')
@endsection
