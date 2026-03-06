@extends('front.layout.main')

@section('page_title', trans('labels.services'))

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}" class="color-changer">{{ trans('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.services') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- popular-services -->
    <section class="popular-services">
        <div class="content">
            <div class="container">
                <div class="d-sm-flex align-items-center justify-content-between mb-3 mb-sm-4">
                    <h2 class="truncate-2 color-changer sec-subtitle m-sm-0">{{ trans('labels.services_list') }}</h2>
                    <!-- filter -->
                    @if (request()->get('type') != 1)
                        <div class="col-sm-6 col-lg-4">
                            <!--Sorting Filter-->
                            <div class="toolbar">
                                <div
                                    class="d-flex justify-content-lg-end align-items-center gap-2 w-100 {{ session()->get('direction') == '2' ? 'rtl' : '' }}">
                                    <div class="sorter-label color-changer fw-500 m-0 d-sm-block d-none col-auto" for="sorter">
                                        {{ trans('labels.sort_by') }}</div>
                                    <select class="sorter-options rounded w-100">
                                        <option value="newest"
                                            @if (request()->get('sorter') == 'newest') selected @elseif (request()->get('sorter') == '') selected @endif>
                                            {{ trans('labels.newest') }}</option>
                                        <option value="oldest" @if (request()->get('sorter') == 'oldest') selected @endif>
                                            {{ trans('labels.oldest') }}</option>
                                        <option value="price_desc" @if (request()->get('sorter') == 'price_desc') selected @endif>
                                            {{ trans('labels.high_to_low') }}</option>
                                        <option value="price_asc" @if (request()->get('sorter') == 'price_asc') selected @endif>
                                            {{ trans('labels.low_to_high') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="catsec clearfix">
                    @if (request()->get('type') == 1)
                        <div class="countdown d-flex justify-content-center gap-2 my-4" id="countdown"></div>
                    @endif
                    <div
                        class="d-flex bg-primary-rgb p-3 mb-sm-4 mb-3 rounded-3 justify-content-between align-items-center">
                        <span class="fs-15 fw-600 color-changer">
                            {{ trans('labels.showing') }}
                            {{ $servicedata->firstItem() ? $servicedata->firstItem() : 0 }}–{{ $servicedata->lastItem() ? $servicedata->lastItem() : 0 }}
                            {{ trans('labels.of') }}
                            {{ $servicedata->total() }} {{ trans('labels.result') }}
                        </span>
                        <ul class="d-flex flex-nowrap justify-content-end gap-2 nav nav-pills nav-pills-dark"
                            id="tour-pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link view-list-grid cursor-pointer text-dark color-changer border border-dark service-active"
                                    id="column" tooltip="Grid view">
                                    <i class="fa-solid fa-grip fs-5"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link view-list-grid cursor-pointer text-dark color-changer border border-dark"
                                    id="grid" tooltip="List view">
                                    <i class="fa-solid fa-list-ul fs-15"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        @if (request()->get('type') != 1)
                            <div class="col-md-3 col-lg-4 col-xl-3 d-none d-lg-block left_side fillter_sidebar">
                                <div class="left_sidbar_main">
                                    <div class="liftsidebody">
                                        <div class="card rounded overflow-hidden">
                                            <div class="card-header color-changer border-bottom d-flex d-grid gap-2 align-items-center py-3">
                                                <i class="fa-light fa-filter fs-5"></i>
                                                <h5 class="fw-600 fs-5">{{ trans('labels.filter') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <!-- categories -->
                                                @if (!empty($categorydata))
                                                    <div class="py-3 border-bottom">
                                                        @php
                                                            $slugs = request()->segments();
                                                            $currentCategorySlug = isset($slugs[2]) ? $slugs[2] : '';
                                                        @endphp
                                                        <h5 class="fw-600 fs-5 pb-3 color-changer">{{ trans('labels.categories') }}</h5>
                                                        <div class="border-bottom-0 shop_categorieslist filter-scroll">
                                                            <div class="accordion accordion-flush"
                                                                id="accordionFlushExample">
                                                                @foreach ($categorydata as $category)
                                                                    <div
                                                                        class="accordion-item border rounded-2 overflow-hidden mb-2">
                                                                        <div class="d-flex">
                                                                            <a class="fw-500 col-12 text-dark bg-light bg-change-mode accordion_button fs-7 {{ request()->is('home/services/' . $category->slug) ? 'fw-600' : '' }}"
                                                                                href="{{ URL::to('home/services/' . $category->slug) }}">
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-center">
                                                                                    {{ $category->name }}
                                                                                    @if (request()->is('home/services/' . $category->slug))
                                                                                        <i class="fa fa-circle fs-8"></i>
                                                                                    @endif
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <!-- city -->
                                                @if (!empty($citydata))
                                                    <div class="py-3 border-bottom">
                                                        <h5 class="fw-600 fs-5 pb-3 color-changer">{{ trans('labels.city') }}</h5>
                                                        <div class="border-bottom-0 shop_categorieslist filter-scroll">
                                                            <div class="accordion accordion-flush"
                                                                id="accordionFlushExample">
                                                                @foreach ($citydata as $cdata)
                                                                    <div
                                                                        class="accordion-item border rounded-2 overflow-hidden mb-2">
                                                                        <div class="d-flex">
                                                                            <a class="fw-500 col-12 text-dark bg-change-mode bg-light accordion_button fs-7 cursor-pointer {{ isset($_COOKIE['city_id']) && $_COOKIE['city_id'] == $cdata->id ? 'fw-600' : '' }}"
                                                                                onclick="setCookie('city_id','{{ $cdata->id }}', 365)">
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-center">
                                                                                    {{ $cdata->name }}
                                                                                    @if (isset($_COOKIE['city_id']) && $_COOKIE['city_id'] == $cdata->id)
                                                                                        <i class="fa fa-circle fs-8"></i>
                                                                                    @endif
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <!-- Price Range -->
                                                @if (!empty($servicedata) && count($servicedata) > 0)
                                                    <div class="price_range pt-3 pb-4 border-bottom">
                                                        <h5 class="fw-600 fs-5 pb-4 color-changer">{{ trans('labels.price_range') }}</h5>
                                                        <div class="price-input">
                                                            <div class="field">
                                                                <span
                                                                    class="text-muted fw-500 d-flex align-items-center gap-2">
                                                                    {{ trans('labels.min') }}
                                                                </span>
                                                                <input type="text" class="input-min form-control" id="input_left"
                                                                    value="{{ $filter_price_start }}" maxlength="6"
                                                                    onkeyup="brandandrattingpricechek()">
                                                            </div>
                                                            <div class="separator">-</div>
                                                            <div class="field">
                                                                <span
                                                                    class="text-muted fw-500 d-flex align-items-center gap-2">
                                                                    {{ trans('labels.max') }}
                                                                </span>
                                                                <input type="text" class="input-max form-control" id="input_right"
                                                                    value="{{ $filter_price_end }}" maxlength="6"
                                                                    onkeyup="brandandrattingpricechek()">
                                                            </div>
                                                        </div>
                                                        @php
                                                            if ($filter_price_end > 0) {
                                                                $leftpercentage =
                                                                    ($filter_price_start / $maxprice) * 100;
                                                                $rightpercentage =
                                                                    100 - ($filter_price_end / $maxprice) * 100;
                                                            } else {
                                                                $leftpercentage = 0;
                                                                $rightpercentage = 0;
                                                            }
                                                        @endphp
                                                        <div class="slider">
                                                            <div class="progress progress_slider p-0"
                                                                style="left: {{ number_format($leftpercentage >= 0 ? $leftpercentage : 0, 1) }}%; right: {{ number_format($rightpercentage >= 0 ? $rightpercentage : 0, 1) }}%;">
                                                            </div>
                                                        </div>
                                                        <div class="range-input">
                                                            <input type="range" class="range-min" min="0"
                                                                max="{{ $maxprice }}"
                                                                value="{{ $filter_price_start }}"
                                                                onmouseup="brandandrattingpricechek()">
                                                            <input type="range" class="range-max" min="0"
                                                                max="{{ $maxprice }}"
                                                                value="{{ $filter_price_end }}"
                                                                onmouseup="brandandrattingpricechek()">
                                                        </div>
                                                    </div>
                                                @endif
                                                <!-- ratting -->
                                                @if (@helper::checkaddons('product_review'))
                                                    <div class="py-3 border-bottom">
                                                        <h5 class="fw-600 fs-5 pb-3 color-changer">{{ trans('labels.rating') }}</h5>
                                                        <ul class="shop_ratinglist">
                                                            <li>
                                                                <label
                                                                    class="active border py-2 px-2 rounded-2 d-flex justify-content-between align-items-center">
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <input
                                                                            class="form-check-input mt-0 border star_rating"
                                                                            type="radio" name="ratting_filter"
                                                                            value="5"
                                                                            @if (request()->get('rattings') == 5) checked @endif
                                                                            aria-label="Check"
                                                                            onclick="brandandrattingpricechek()">
                                                                        <div
                                                                            class="d-flex d-grid gap-1 align-items-center">
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                        </div>
                                                                    </div>
                                                                    <p class="fw-500 text-secondary m-0 color-changer">(5 Star)</p>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label
                                                                    class="border py-2 px-2 rounded-2 d-flex justify-content-between align-items-center">
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <input
                                                                            class="form-check-input mt-0 border star_rating"
                                                                            type="radio" name="ratting_filter"
                                                                            value="4"
                                                                            @if (request()->get('rattings') == 4) checked @endif
                                                                            aria-label="Check"
                                                                            onclick="brandandrattingpricechek()">
                                                                        <div
                                                                            class="d-flex d-grid gap-1 align-items-center">
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-regular fa-star text-warning fs-7"></i>
                                                                        </div>
                                                                    </div>
                                                                    <p class="fw-500 text-secondary m-0 color-changer">(4 Star)</p>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label
                                                                    class="border py-2 px-2 rounded-2 d-flex justify-content-between align-items-center">
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <input
                                                                            class="form-check-input mt-0 border star_rating"
                                                                            type="radio" name="ratting_filter"
                                                                            value="3"
                                                                            @if (request()->get('rattings') == 3) checked @endif
                                                                            aria-label="Check"
                                                                            onclick="brandandrattingpricechek()">
                                                                        <div
                                                                            class="d-flex d-grid gap-1 align-items-center">
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-regular fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-regular fa-star text-warning fs-7"></i>
                                                                        </div>
                                                                    </div>
                                                                    <p class="fw-500 text-secondary m-0 color-changer">(3 Star)</p>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label
                                                                    class="border py-2 px-2 rounded-2 d-flex justify-content-between align-items-center">
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <input
                                                                            class="form-check-input mt-0 border star_rating"
                                                                            type="radio" name="ratting_filter"
                                                                            value="2"
                                                                            @if (request()->get('rattings') == 2) checked @endif
                                                                            aria-label="Check"
                                                                            onclick="brandandrattingpricechek()">
                                                                        <div
                                                                            class="d-flex d-grid gap-1 align-items-center">
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-regular fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-regular fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-regular fa-star text-warning fs-7"></i>
                                                                        </div>
                                                                    </div>
                                                                    <p class="fw-500 text-secondary m-0 color-changer">(2 Star)</p>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label
                                                                    class="border py-2 px-2 rounded-2 d-flex justify-content-between align-items-center">
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <input
                                                                            class="form-check-input mt-0 border star_rating"
                                                                            type="radio" name="ratting_filter"
                                                                            value="1"
                                                                            @if (request()->get('rattings') == 1) checked @endif
                                                                            aria-label="Check"
                                                                            onclick="brandandrattingpricechek()">
                                                                        <div
                                                                            class="d-flex d-grid gap-1 align-items-center">
                                                                            <i
                                                                                class="fa-solid fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-regular fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-regular fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-regular fa-star text-warning fs-7"></i>
                                                                            <i
                                                                                class="fa-regular fa-star text-warning fs-7"></i>
                                                                        </div>
                                                                    </div>
                                                                    <p class="fw-500 text-secondary m-0 color-changer">(1 Star)</p>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row gx-3 justify-content-between mt-3">
                                            @if (
                                                (request()->get('filter_price_start') != '' && request()->get('filter_price_end') != '') ||
                                                    request()->get('rattings') != '' ||
                                                    request()->get('sorter') != '')
                                                <div class="col-6">
                                                    <a href="{{ URL::current() }}"
                                                        class="btn fw-500 filter_btn_border w-100">{{ trans('labels.clear_all') }}</a>
                                                </div>
                                            @endif
                                            <div class="col-6">
                                                <button type="button" onclick="product_filter()"
                                                    class="btn fw-500 btn-secondary text-white btn_enable w-100"
                                                    disabled>{{ trans('labels.apply') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg_layer"></div>
                                </div>
                            </div>
                        @endif
                        <div class="{{ request()->get('type') != 1 ? 'col-xl-9 col-lg-8' : '' }}">
                            @if (!empty($servicedata) && count($servicedata) > 0)
                                <div class="listing-view">
                                    <div
                                        class="row row-cols-1 row-cols-sm-2 {{ request()->get('type') != 1 ? 'row-cols-md-2 row-cols-lg-2 row-cols-xl-3' : 'row-cols-md-3 row-cols-lg-4' }} g-3">
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
                                    <div class="d-flex justify-content-center">
                                        {!! $servicedata->appends(\Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                <div id="column-view" class="d-none">
                                    <div
                                        class="row row-cols-1 row-cols-sm-2 {{ request()->get('type') != 1 ? 'row-cols-lg-1 row-cols-xl-2' : 'row-cols-lg-2 row-cols-xl-3' }} g-3">
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
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        {!! $servicedata->appends(\Request::except('page'))->render() !!}
                                    </div>
                                </div>
                            @else
                                <div class="w-25 mx-auto">
                                    <img src="{{ helper::image_path(helper::otherdata('')->no_data_image) }}"
                                        alt="nodata img">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <form id="filter_price_range">
        <input type="hidden" name="filter_price_start" id="filter_input_left" value="{{ @$filter_price_start }}">
        <input type="hidden" name="filter_price_end" id="filter_input_right" value="{{ @$filter_price_end }}">
        @if (@helper::checkaddons('product_review'))
            <input type="hidden" name="rattings" id="ratting_filters" value="{{ request()->get('rattings') }}">
        @endif
        <input type="hidden" name="sorter" id="sorter" value="{{ request()->get('sorter') }}">
    </form>
    <!-- become provider -->
    @include('front.become_provider')
@endsection
@section('scripts')
    <script>
        //Sorter filter
        $('.sorter-options').change(function() {
            var selectedValue = $(this).val();
            $('#sorter').val(selectedValue);
            $("#filter_price_range").submit();
        });
        //Price range filter
        function product_filter() {
            var minPrice = $("#input_left").val();
            var maxPrice = $("#input_right").val();
            var starcheckedValues = $('.star_rating:checked').val();
            $("#filter_input_left").val(minPrice);
            $("#filter_input_right").val(maxPrice);
            $("#ratting_filters").val(starcheckedValues);
            $("#filter_price_range").submit();
        }

        //Apply button enable-diable
        function brandandrattingpricechek() {
            var minPrice = $("#input_left").val();
            var maxPrice = $("#input_right").val();
            if (parseInt(minPrice) < parseInt(maxPrice)) {
                document.querySelector('.btn_enable').disabled = false;
            } else if ($('.star_rating').is(":checked")) {
                document.querySelector('.btn_enable').disabled = false;
            } else {
                document.querySelector('.btn_enable').disabled = true;
            }
        }
        @if (request()->get('type') == 1)
            var topdeals = "{{ !empty(@$servicedata) ? 1 : 0 }}";
        @endif
    </script>
@endsection
