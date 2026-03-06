@extends('front.layout.vendor_theme')
@section('page_title')
    {{ trans('labels.user') }} | {{ trans('labels.my_address') }}
@endsection
@section('front_content')
    <div class="col-12 col-md-12 col-lg-8 col-xl-9">
        <div class="card">
            <div class="card-header border-bottom bg-transparent py-3">
                <h5 class="widget-title color-changer m-0">{{ trans('labels.wishlist') }}</h5>
            </div>
            <div class="card-body">
                @if (!empty($wishlistdata) && count($wishlistdata) > 0)
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 g-3">
                        @foreach ($wishlistdata as $sdata)
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
                    <div class="d-flex justify-content-center">
                        {{ $wishlistdata->links() }}
                    </div>
                @else
                    @include('front.nodata')
                @endif
            </div>
        </div>
    </div>

    <!-- become provider -->
    @include('front.become_provider')
@endsection
