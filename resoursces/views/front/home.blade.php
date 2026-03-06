@extends('front.layout.main')
@section('page_title', trans('labels.home'))
@section('content')

    <!-- BANNER SECTION START -->
    <section class="hero-section">
        <div class="home_main">
            <div class="row g-0">
                <div class="owl-carousel home_banner_owl owl-theme">
                    @if (!empty($bannerdata) && count($bannerdata) > 0)
                        @foreach ($bannerdata as $key => $banner)
                            @if ($banner['section'] == 1)
                                @if ($banner['type'] == 1)
                                    <a class="cursor-pointer"
                                        href="{{ URL::to('/home/services/' . $banner['category_slug']) }}">
                                    @else
                                        <a class="cursor-pointer" href="javascript:void(0)">
                                @endif
                                <div class="item">
                                    <img src="{{ helper::image_path($banner['image']) }}" alt="">
                                </div>
                                </a>
                            @endif
                        @endforeach
                    @else
                        <img src="{{ helper::image_path('') }}" alt="">
                    @endif
                </div>
                <div class="homebanne">
                    <div class="container">
                        <div class="row justify-content-center align-items-center">
                            <h5 class="fw-600 text-white text-center truncate-1 mb-2">{{ trans('labels.welcome_title') }}
                            </h5>
                            <h1 class="fw-600 text-white text-center truncate-2 mb-0">{{ trans('labels.search_note') }}</h1>
                            <div class="d-flex justify-content-center align-items-center my-1 animation-down">
                                <div class="heading-line bg-white"></div>
                                <i class="fa-solid fa-location-crosshairs fs-3 text-white text-shadow"></i>
                                <div class="heading-line bg-white"></div>
                            </div>
                            <div class="col-xl-8 col-lg-9 mb-4">
                                <p class="truncate-2 text-center text-white fs-13">{{ trans('labels.welcome_description') }}
                                </p>
                            </div>
                            <div class="col-xl-8 col-md-10 position-relative">
                                <div class="card w-100 rounded-5 p-3 pick_services">
                                    <form class="d-flex gap-3 align-items-stretch" action="{{ URL::to('/home/search') }}"
                                        method="GET">
                                        <input type="hidden" name="search_by" value="service">
                                        <input type="text" class="form-control rounded-5 fs-7" id="search_name"
                                            name="search_name"
                                            @isset($_GET['search_name']) value="{{ $_GET['search_name'] }}" @endisset
                                            placeholder="{{ trans('labels.enter_service') }}">
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary rounded-5 w-100 h-100 m-0">
                                                {{ trans('labels.search') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- BANNER SECTION END -->

    <!-- How IT Work SECTION Start -->
    @if (!empty($howitwork) && (!empty($howitworkdata) && count($howitworkdata) > 0))
        <section class="about-sec bg-body-secondary bg-change-mode">
            <div class="aboutus_main">
                <div class="container">
                    <div class="row justify-content-between align-items-center g-3 g-lg-5">
                        <!-- left side -->
                        <div class="col-12 col-xl-6">
                            <div class="card h-100 border-0 bg-transparent">
                                <img src="{{ helper::image_path($howitwork->how_it_works_image) }}" alt="aboutus img"
                                    class="rounded aboutus_leftimg">
                            </div>
                        </div>
                        <!-- right side -->
                        <div class="col-12 col-xl-6">
                            <p class="mb-2 sec-title">{{ $howitwork->how_it_works_title }}</p>
                            <h2 class="truncate-2 color-changer sec-subtitle mb-2 text-capitalize">
                                {{ $howitwork->how_it_works_sub_title }}</h2>
                            <p class="truncate-2 text-muted fs-13 mb-4">
                                {{ $howitwork->how_it_works_description }}
                            </p>
                            <div class="row g-4">
                                @foreach ($howitworkdata as $hiwd)
                                    <div class="col-md-6">
                                        <div class="card card-bg bg-transparent border-0 h-100 serviceBox">
                                            <div class="service-icon">
                                                <img src="{{ helper::image_path($hiwd->how_it_works_image) }}"
                                                    alt="aboutus img" class="object-fit-cover">
                                            </div>
                                            <h3 class="title truncate-1">{{ $hiwd->how_it_works_title }}</h3>
                                            <p class="text-muted truncate-3 description">
                                                {!! Str::limit($hiwd->how_it_works_description, 200) !!}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- How IT Work SECTION End -->

    <!-- Top Deals Services SECTION START -->
    @if (!empty($topdealsservicedata) && count($topdealsservicedata) > 0 && helper::top_deals() != null)
        <section class="my-5">
            <div class="container">
                <div class="col-12">
                    <div class="rounded overflow-hidden row g-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="deals-heading mb-md-0">
                                <p class="sec-title mb-2">{{ trans('labels.exclusive_deals') }}</p>
                                <h2 class="truncate-2 color-changer mb-2 sec-subtitle">
                                    {{ trans('labels.top_deals') }}
                                </h2>
                                <p class="truncate-2 text-muted fs-13 mb-0">
                                    {{ trans('labels.deals_subtitle') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 col-md-6 h-100">
                            <div class="d-flex justify-content-center gap-2" id="countdown"></div>
                        </div>
                    </div>
                </div>
                <div
                    class="row row-cols-1 pt-sm-5 pt-4 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 gx-md-3 gx-lg-3 gx-xl-4 gy-4">
                    @foreach ($topdealsservicedata as $sdata)
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
                <div class="d-flex justify-content-center mt-sm-5 mt-4">
                    <a href="{{ URL::to('/home/services?type=1') }}"
                        class="d-flex align-items-center gap-2 btn btn-secondary">
                        <span>{{ trans('labels.view_all') }}</span>
                        <i class="fa-regular fa-arrow-{{ session()->get('direction') == 2 ? 'left' : 'right' }}"></i>
                    </a>
                </div>
            </div>
        </section>
    @endif
    <!-- Top Deals Services SECTION END -->

    <!-- Category section Start-->
    @if (!empty($categorydata) && count($categorydata) > 0)
        <section class="category-section img-hover">
            <div class="container py-5">
                <!-- TITLE -->
                <div class="main_title">
                    <div class="mb-lg-5 mb-4">
                        <div class="col-sm-10 col-md-8">
                            <p class="mb-2 sec-title">{{ trans('labels.featured_categories') }}</p>
                            <h2 class="truncate-2 mb-2 color-changer sec-subtitle text-capitalize">{{ trans('labels.what_looking_for') }}
                            </h2>
                            <p class="truncate-2 text-muted fs-13 mb-0">
                                {{ trans('labels.what_looking_for_description') }}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- CATEGORIES -->
                @include('front.category_section')
            </div>
        </section>
    @endif
    <!-- Category section End-->

    <!-- Services section Start-->
    @if (!empty($servicedata) && count($servicedata) > 0)
        <section class="service-sec">
            <div class="service_main img-hover">
                <div class="container">
                    <div class="row justify-content-between g-3 align-items-center mb-lg-5 mb-4">
                        <div class="col-sm-10 col-md-8 col-lg-6">
                            <p class="mb-2 sec-title">{{ trans('labels.popular_services') }}</p>
                            <h2 class="truncate-2 mb-2 color-changer sec-subtitle">{{ trans('labels.popular_services_sub') }}</h2>
                            <p class="truncate-2 text-muted fs-13 mb-0">
                                {{ trans('labels.popular_services_description') }}
                            </p>
                        </div>
                        <div class="col-auto d-flex justify-content-center">
                            <a href="{{ URL::to('/home/services') }}"
                                class="d-flex align-items-center gap-2 btn btn-secondary">
                                <span>{{ trans('labels.view_all') }}</span>
                                <i
                                    class="fa-regular fa-arrow-{{ session()->get('direction') == 2 ? 'left' : 'right' }}"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 gx-md-3 gx-lg-3 gx-xl-4 gy-4">
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
                </div>
            </div>
        </section>
    @endif
    <!-- Services section End-->

    <!-- Banner SECTION Start-->
    @if (!empty($bannerdata) && count($bannerdata) > 0)
        <section class="banner-sec">
            <div class="container">
                <div class="banner_main">
                    <div class="owl-carousel banner01 owl-theme position-relative">
                        @foreach ($bannerdata as $key => $banner)
                            @if ($banner['section'] == 2)
                                @if ($banner['type'] == 1)
                                    <a href="{{ URL::to('/home/services/' . $banner['category_slug']) }}">
                                    @else
                                        <a href="javascript:void(0)">
                                @endif
                                <div class="item position-relative">
                                    <img src="{{ helper::image_path($banner['image']) }}" alt=""
                                        class="rounded single_banner_images">
                                </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Banner SECTION End-->

    <!-- Providers section Start-->
    @if (!empty($providerdata) && count($providerdata) > 0)
        <section class="top-providers-sec bg-body-secondary bg-change-mode">
            <div class="top_providers_main py-5">
                <!-- providers main content -->
                <div class="container">
                    <div class="main_title">
                        <div class="row justify-content-between g-3 align-items-center pb-lg-5 pb-4">
                            <div class="col-sm-10 col-md-8 col-lg-6">
                                <p class="sec-title mb-2">{{ trans('labels.top_providers') }}</p>
                                <h2 class="truncate-2 sec-subtitle color-changer mb-2">{{ trans('labels.trust_providers') }}</h2>
                                <p class="truncate-2 text-muted fs-13 mb-0">
                                    {{ trans('labels.trust_providers_description') }}
                                </p>
                            </div>
                            <div class="col-auto d-flex justify-content-center">
                                <a href="{{ URL::to('/home/providers') }}"
                                    class="d-flex align-items-center gap-2 btn btn-secondary">
                                    <span>{{ trans('labels.view_all') }}</span>
                                    <i
                                        class="fa-regular fa-arrow-{{ session()->get('direction') == 2 ? 'left' : 'right' }}"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="owl-carousel top-providers owl-theme position-relative">
                        @foreach ($providerdata as $fpdata)
                            <div class="item h-100">
                                <div class="card h-100 our-team">
                                    <div class="card-body">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <div class="pic shadow">
                                                <img src="{{ helper::image_path($fpdata->provider_image) }}"
                                                    alt="">
                                            </div>
                                            <h6 class="truncate-2 text-primary mb-0 mt-3 fw-600">
                                                {{ $fpdata->provider_name }}
                                            </h6>
                                            <span class="text-muted truncate-2 fw-500 fs-15">
                                                {{ $fpdata->provider_type }}
                                            </span>
                                            <a href="{{ URL::to('/home/providers-services/' . $fpdata->slug) }}"
                                                class="text-primary">
                                                <div class="go_arrow border mt-2 fw-600 color-changer">
                                                    <i
                                                        class="fa-regular fa-arrow-{{ session()->get('direction') == 2 ? 'left' : 'right' }}"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Providers section End-->

    <!-- REVIEWS SECTION START -->
    @if (@helper::checkaddons('store_review'))
        @if (!empty($testimonials) && count($testimonials) > 0)
            <section class="reviews-sec">
                <div class="container">
                    <div class="reviews_main"
                        style="background-image:url(https://booking.webestica.com/assets/images/element/map.svg); background-position: center left; background-size: cover;">
                        <div class="main_title">
                            <div class="mb-lg-5 mb-4">
                                <div class="col-sm-10 col-md-8 col-lg-7">
                                    <p class="mb-2 sec-title">{{ trans('labels.customers_say') }}</p>
                                    <h2 class="truncate-2 mb-2 color-changer sec-subtitle">{{ trans('labels.customers_say_sub') }}</h2>
                                    <p class="truncate-2 text-muted fs-13 mb-0">
                                        {{ trans('labels.customers_say_description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="owl-carousel reviews-owl position-relative owl-theme">
                            @foreach ($testimonials as $t)
                                <div class="item h-100">
                                    <div class="testimonial-12 d-flex justify-content-center flex-column">
                                        <p class="description {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                                            {{ $t->description }}
                                        </p>
                                        <div class="pic p-1 mx-auto">
                                            <img src="{{ helper::image_path($t->image) }}" alt="avatar"
                                                class="rounded-circle">
                                        </div>
                                        <div class="testimonial-prof text-center">
                                            <h4 class="text-dark color-changer">{{ $t->name }}</h4>
                                            <ul class="list-inline small mb-3">
                                                @if ($t->rating == 1)
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i class="fa-solid fa-star color-changer"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i class="fa-solid fa-star color-changer"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i class="fa-solid fa-star color-changer"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i class="fa-solid fa-star color-changer"></i>
                                                    </li>
                                                @elseif ($t->rating == 2)
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i class="fa-solid fa-star color-changer"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i class="fa-solid fa-star color-changer"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i class="fa-solid fa-star color-changer"></i>
                                                    </li>
                                                @elseif ($t->rating == 3)
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i class="fa-solid fa-star color-changer"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i class="fa-solid fa-star color-changer"></i>
                                                    </li>
                                                @elseif ($t->rating == 4)
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i class="fa-solid fa-star color-changer"></i>
                                                    </li>
                                                @elseif ($t->rating == 5)
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item me-0"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- REVIEWS SECTION END -->

    <!-- FAQS SECTION START -->
    @if (!empty($faq) && (!empty($faqdata) && count($faqdata) > 0))
        <section class="faq-sec bg-primary-rgb">
            <div class="container py-5">
                @if (!empty($faq) || (!empty($faqdata) && count($faqdata) > 0))
                    <div class="row justify-content-between g-4">
                        <div class="col-md-12 col-lg-6">
                            <p class="mb-2 sec-title">{{ $faq->faq_title }}</p>
                            <h2 class="truncate-2 mb-2 color-changer sec-subtitle">{{ $faq->faq_sub_title }}</h2>
                            <p class="truncate-2 text-muted fs-13 mb-4">
                                {{ $faq->faq_description }}
                            </p>
                            <div class="accordion" id="faqAccordion">
                                @foreach ($faqdata as $key => $fd)
                                    <ul class="list-group list-group-flush accordion-item border-0 bg-transparent">
                                        <li class="list-group-item rounded-0 bg-transparent accordion-button border-dark py-3 fw-semibold {{ session()->get('direction') == 2 ? 'text-end' : 'text-start' }} {{ $key == 0 ? '' : 'collapsed' }}"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $fd->id }}"
                                            aria-expanded="false" aria-controls="collapse{{ $fd->id }}">
                                            {{ $fd->question }}
                                        </li>
                                        <div id="collapse{{ $fd->id }}"
                                            class="accordion-collapse collapse rounded-0 border-bottom border-dark {{ $key == 0 ? 'collapse show' : '' }}"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body bg-change-mode">
                                                <p class="truncate-2 fs-13 m-0">{{ $fd->answer }}</p>
                                            </div>
                                        </div>
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 position-relative">
                            <img src="{{ helper::image_path($faq->faq_image) }}" alt="faq image"
                                class="mt-3 rounded faq_left_img d-none d-lg-block">
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif
    <!-- FAQS SECTION END -->

    <!-- MOBILE APP SECTION START -->
    @if (@helper::checkaddons('owner_app'))
        @if (!empty($appdownload))
            <section class="mobile-app-sec">
                <div class="container position-relative">
                    <div class="card border-0 bg-light position-relative overflow-hidden p-4 p-sm-5">
                        @if (!empty($appdownload))
                            <div class="row g-3 align-items-center">
                                <!-- Content START -->
                                <div class="col-xl-7 col-lg-6 z-9 position-relative">
                                    <!-- Title -->
                                    <h3 class="mb-4">{{ isset($appdownload->title) ? $appdownload->title : '' }}</h3>
                                    <p class="text-muted mb-5 truncate-2">
                                        {{ isset($appdownload->description) ? $appdownload->description : '' }}</p>
                                    <!-- Button -->
                                    <div class="hstack gap-3">
                                        <!-- Google play store button -->
                                        <a href="{{ isset($appdownload->android_url) ? $appdownload->android_url : '' }}"
                                            target="_blank"> <img
                                                src="{{ url('storage/app/public/app-downloaded/goolge-play.png') }}"
                                                class="h-50px" alt=""> </a>
                                        <!-- App store button -->
                                        <a href="{{ isset($appdownload->ios_url) ? $appdownload->ios_url : '' }}"
                                            target="_blank">
                                            <img src="{{ url('storage/app/public/app-downloaded/app-store.png') }}"
                                                class="h-50px" alt=""> </a>
                                    </div>
                                </div>
                                <!-- Content START -->
                                <div class="col-xl-5 col-lg-6 d-none d-lg-block">
                                    <div class="">
                                        <img src="{{ helper::image_path($appdownload->image) }}"
                                            class="z-index-99 w-100 h-400px" alt="mobile img">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- MOBILE APP SECTION END -->

    <!-- BLOGS SECTION START -->
    @if (@helper::checkaddons('blog'))
        @if (!empty($blogdata) && count($blogdata) > 0)
            <section class="blog-sec mt-5">
                <div class="img-hover">
                    <!-- blogs -->
                    <div class="container">
                        <div class="main_title">
                            <div class="row justify-content-between g-3 align-items-center pb-lg-5 pb-4">
                                <div class="col-sm-10 col-md-8 col-lg-6 ">
                                    <p class="mb-2 sec-title">{{ trans('labels.updated_blogs') }}</p>
                                    <h2 class="truncate-2 mb-2 color-changer sec-subtitle">{{ trans('labels.technical_news_blogs') }}
                                    </h2>
                                    <p class="truncate-2 text-muted fs-13 mb-0">
                                        {{ trans('labels.technical_news_description') }}
                                    </p>
                                </div>
                                <div class="col-auto d-flex justify-content-center">
                                    <a href="{{ URL::to('home/blog/list/') }}"
                                        class="d-flex align-items-center gap-2 btn btn-secondary">
                                        <span>{{ trans('labels.view_all') }}</span>
                                        <i class="fa-regular fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="owl-carousel blogs_owl owl-theme position-relative">
                            @foreach ($blogdata as $bd)
                                <div class="item h-100 m-1">
                                    <div class="card h-100 post-slide">
                                        <div class="post-img">
                                            <span class="over-layer"></span>
                                            <img src="{{ helper::image_path($bd->image) }}" alt="blog img"
                                                class="blog-img rounded-top">
                                        </div>
                                        <div class="card-body p-3">
                                            <h6 class="post-title text-capitalize truncate-2 mb-2">
                                                <a href="{{ URL::to('home/blog/details/' . $bd->slug) }}"
                                                    class="text-dark color-changer">
                                                    {{ $bd->title }}
                                                </a>
                                            </h6>
                                            <div class="cms-section fs-13 text-muted">
                                                <p class="fs-13 mb-2 truncate-2">
                                                    {!! Str::limit($bd->description, 70) !!}
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class="card-footer border-top d-flex justify-content-between align-items-center gap-2 p-3">
                                            <span class="post-date fw-500 fs-7 color-changer d-flex gap-2 align-items-center">
                                                <i class="fa-regular fa-calendar-days text-primary fw-700"></i>
                                                {{ date('d  M , y', strtotime($bd->created_at)) }}
                                            </span>
                                            <a href="{{ URL::to('home/blog/details/' . $bd->slug) }}"
                                                class="fw-semibold m-0">
                                                <span class="px-1">{{ trans('labels.read_more') }}</span>
                                                <i
                                                    class="fa-regular fa-arrow-{{ session()->get('direction') == 2 ? 'left' : 'right' }}"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- BLOGS SECTION END -->

    <!-- brands-sliders start Here -->
    @if (!empty($getbrands) && count($getbrands) > 0)
        <section class="py-5 position-relative">
            <div class="container">
                <div class="col-sm-10 col-md-8 col-lg-7 mb-4">
                    <p class="mb-2 sec-title">{{ trans('labels.our_brands') }}</p>
                    <h2 class="truncate-2 mb-2 color-changer sec-subtitle">{{ trans('labels.our_brands_sub') }}</h2>
                    <p class="truncate-2 text-muted fs-13 mb-0">
                        {{ trans('labels.our_brands_description') }}
                    </p>
                </div>
            </div>
            <div class="container-fluid mt-5">
                <div class="brands-slider owl-carousel owl-theme">
                    @foreach ($getbrands as $image)
                        <div class="item" data-src="{{ $image->image_url }}" data-fancybox="brands"
                            data-thumb="{{ $image->image_url }}">
                            <img src="{{ helper::image_path($image->image) }}" class="rounded" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- brands-sliders end Here -->

    <!-- become provider -->
    @if (helper::appdata()->provider_registration == 1)
        <section class="become-provider pt-4">
            <div class="container">
                <div class="card py-lg-5 provider-add"
                    style="background-image: url('{{ helper::image_path(helper::otherdata('')->become_provider_image) }}')">
                    <div class="overlay"></div>
                    <div class="content p-sm-5 p-4">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <div class="col-xl-7 col-lg-8 col-12 text-center">
                                <p class="mb-2 fs-5 fw-600">{{ trans('labels.Do_You_want_Become_provider') }}</p>
                                <h2 class="fw-bold text-capitalize mb-3">{{ trans('labels.your_business') }}
                                </h2>
                                <p class="truncate-2 mb-4 fs-15">{{ trans('labels.become_provider_note') }}</p>
                            </div>
                            <a href="{{ URL::to('/admin/register') }}" class="btn btn-primary">
                                <div class="d-flex gap-2">
                                    {{ trans('labels.become_provider') }}
                                    <i
                                        class="fa-regular fa-arrow-{{ session()->get('direction') == 2 ? 'left' : 'right' }}"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- FOOTER FISHER SECTION START -->
    @if (!empty($getfooterfeature) && count($getfooterfeature) > 0)
        <section class="pb-5 extra-margin">
            <div class="footer_fisher_main">
                <div class="container">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-4 g-4">
                        @if (!empty($getfooterfeature) && count($getfooterfeature) > 0)
                            @foreach ($getfooterfeature as $footerfeature)
                                <div class="col">
                                    <div class="card card-bg h-100 border-0 bg-transparent serviceBox_footer">
                                        <div class="service-icon">
                                            <span>{!! $footerfeature->icons !!}</span>
                                        </div>
                                        <div class="card-body bg-change-mode service-content">
                                            <h3 class="title truncate-2 color-changer">{{ $footerfeature->title }}</h3>
                                            <p class="description truncate-3 text-muted">{{ $footerfeature->sub_title }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- FOOTER FISHER SECTION END -->

@endsection
@section('scripts')
    <script>
        $('.brands-slider').owlCarousel({
            rtl: @if (session()->get('direction') == '2')
                true
            @else
                false
            @endif ,
            loop: true,
            margin: 20,
            responsiveClass: true,
            nav: false,
            dots: false,
            center: true,
            autoplay: true,
            slideTransition: 'linear',
            autoplaySpeed: 3000,
            smartSpeed: 3000,
            autoplayTimeout: 3000,
            responsive: {
                0: {
                    items: 1,
                },
                425: {
                    items: 2,
                },
                600: {
                    items: 3,
                },
                1000: {
                    items: 5,
                },
                1200: {
                    items: 6,
                }
            }
        });
    </script>
@endsection
