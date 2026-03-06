<!DOCTYPE html>
<html lang="en" dir="{{ session('direction') == 2 ? 'rtl' : 'ltr' }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <script>
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.add('light');
        }
    </script>

    <!-- web title-->
    <title>{{ helper::appdata()->website_title }} | @yield('page_title')</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ helper::image_path(helper::appdata()->favicon) }}">
    <!-- google fonts -->
    <link href="{{ asset('storage/app/public/front-assets/css/font.css') }}" rel="stylesheet">
    <!-- bootstrap css -->
    <link rel="stylesheet"
        href="{{ asset('storage/app/public/front-assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- fontawesome css -->
    <link rel="stylesheet" href="{{ asset('storage/app/public/front-assets/css/font-awesome/font-awesome.min.css') }}">
    <!-- magnific-popup css -->
    <link rel="stylesheet" href="{{ asset('storage/app/public/front-assets/css/magnific-popup.min.css') }}">

    <!-- owl carousel css -->
    <link rel="stylesheet"
        href="{{ asset('storage/app/public/front-assets/plugins/owlcarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('storage/app/public/front-assets/plugins/owlcarousel/owl.theme.default.min.css') }}">
    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('storage/app/public/front-assets/css/style.css') }}">
    <!-- toastr css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('storage/app/public/front-assets/js/toaster/toastr.min.css') }}">
    <!-- sweetalert css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('storage/app/public/plugins/sweetalert/css/sweetalert.css') }}">
    <!-- Fancybox 4.0 CSS -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('storage/app/public/front-assets/css/fancybox/fancybox-v4-0-27.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!--PWA-->
    @if (@helper::checkaddons('pwa'))
        @if (helper::appdata()->pwa == 1)
            @include('front.pwa.pwa')
        @endif
    @endif
    @yield('styles')

    <!-- IF VERSION 2  -->
    @if (helper::appdata('')->recaptcha_version == 'v2')
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
    <!-- IF VERSION 3  -->
    @if (helper::appdata('')->recaptcha_version == 'v3')
        {!! RecaptchaV3::initJs() !!}
    @endif

    <style>
        :root {
            --bs-primary: {{ helper::otherdata()->web_primary_color }};
            --bs-secondary: {{ helper::otherdata()->web_secondary_color }};
        }
    </style>
</head>

<body>
    <main id="main-content" class="">
        <div class="wrapper">

            <!-- whatsapp chat -->
            @if (@helper::checkaddons('whatsapp_message'))
                @if (@whatsapp_helper::whatsapp_message_config()->whatsapp_chat_on_off == 1)
                    <div
                        class="{{ @whatsapp_helper::whatsapp_message_config()->whatsapp_mobile_view_on_off == 1 ? 'd-block' : 'd-lg-block d-none' }}">
                        @include('whatsapp_chat')
                    </div>
                @endif
            @endif
            <!-- whatsapp_message btn end -->

            <div class="main-wrapper">

                @include('front.layout.header_navbar')

                @yield('content')

                <!-- Quick call -->
                @if (@helper::checkaddons('quick_call'))
                    @if (@helper::appdata()->quick_call == 1)
                        <div
                            class="{{ helper::appdata()->quick_call_mobile_view_on_off == 1 ? 'd-block' : 'd-lg-block d-none' }}">
                            @include('quick_call.quick_call')
                        </div>
                    @endif
                @endif
                <!------ Quick call end ------>

                @if (@helper::checkaddons('sales_notification'))
                    @include('fake_sales_notification.sales_notification')
                @endif

                @include('cookie-consent::index')

                <!-- footer section start -->
                <footer class="footer bg-body-secondary bg-change-mode border-top d-lg-block d-none">
                    <div class="footer-top">
                        <div class="container">
                            <div class="row g-3 pb-0 pb-md-5 justify-content-between">
                                <!-- left side -->
                                <div class="col-12 col-md-12 col-lg-12 col-xl-3 col-sm-12 col-12">
                                    <!-- company info -->
                                    <div class="d-flex flex-lg-column flex-column gap-3">
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function(event) {
                                                if (localStorage.getItem('theme') === 'dark') {
                                                    var logo = "{{ helper::image_path(helper::appdata()->dark_logo) }}";
                                                } else {
                                                    var logo = "{{ helper::image_path(helper::appdata()->logo) }}";
                                                }
                                                $('#footerlogoimage').attr('src', logo);
                                            });
                                        </script>
                                        <a href="{{ route('home') }}" class="navbar-brand logo">
                                            <img src=""class="mb-3" alt="footer_logo" id="footerlogoimage">
                                        </a>

                                        <p class="color-changer truncate-6 fs-7 fw-medium mb-0">
                                            {{ trans('labels.footer_note') }}
                                        </p>
                                        <div class="footer-contact-info">
                                            <ul>
                                                @if (!empty(helper::appdata()->address))
                                                    <li>
                                                        <a href="https://www.google.com/maps/place/{{ helper::appdata()->address }}"
                                                            class="color-changer text-dark mb-2 d-flex gap-2">
                                                            <i class="far fa-building color-changer"></i>
                                                            <span class="fw-medium m-0">
                                                                {{ helper::appdata()->address }}
                                                            </span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (!empty(helper::appdata()->contact))
                                                    <li>
                                                        <a class="color-changer text-dark d-flex mb-2 gap-2 align-items-center"
                                                            href="callto:{{ helper::appdata()->contact }}">
                                                            <i class="far fa-headphones color-changer"></i>
                                                            <span
                                                                class="fw-medium">{{ helper::appdata()->contact }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (!empty(helper::appdata()->email))
                                                    <li>
                                                        <a class="color-changer text-dark d-flex mb-2 gap-2 align-items-center"
                                                            href="mailto:{{ helper::appdata()->email }}">
                                                            <i class="far fa-envelope color-changer"></i>
                                                            <span
                                                                class="fw-medium">{{ helper::appdata()->email }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- right side -->
                                <div class="col-md-12 col-lg-12 col-xl-8 col-sm-12 col-12">
                                    <div class="row justify-content-md-between align-items-start g-2 text-capitalize">
                                        <!-- categories -->
                                        @if (!empty(helper::categories()) && count(helper::categories()) > 0)
                                            <div class="col-6 col-sm-4 col-lg-2 col-xl-4">
                                                <div class="footer-widget footer-menu">
                                                    <h2 class="footer-title color-changer">
                                                        {{ trans('labels.categories') }}</h2>
                                                    <ul>
                                                        @foreach (helper::categories() as $categories)
                                                            <li><a href="{{ URL::to('/home/services/' . $categories->slug) }}"
                                                                    class="color-changer">{{ $categories->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                        <!-- quick links -->
                                        <div class="col-6 col-sm-4 col-lg-2 col-xl-4">
                                            <div class="footer-widget footer-menu">
                                                <h2 class="footer-title color-changer">
                                                    {{ trans('labels.quick_links') }}</h2>
                                                <ul>
                                                    <li>
                                                        <a class="color-changer"
                                                            href="{{ URL::to('/home/about-us') }}">{{ trans('labels.about_us') }}</a>
                                                    </li>
                                                    <li>
                                                        <a class="color-changer"
                                                            href="{{ URL::to('/home/contact-us') }}">{{ trans('labels.contact_us') }}</a>
                                                    </li>
                                                    <li>
                                                        <a class="color-changer"
                                                            href="{{ URL::to('/home/terms-condition') }}">{{ trans('labels.terms_conditions') }}</a>
                                                    </li>
                                                    <li>
                                                        <a class="color-changer"
                                                            href="{{ URL::to('/home/privacy-policy') }}">{{ trans('labels.privacy_policy') }}</a>
                                                    </li>
                                                    @if (@helper::checkaddons('blog'))
                                                        <li>
                                                            <a class="color-changer"
                                                                href="{{ URL::to('home/blog/list/') }}">{{ trans('labels.blog') }}</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- follow us -->
                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-12 mb-4 mb-md-0">
                                            <div class="footer-widget">
                                                @if (count(helper::getsociallinks()) > 0)
                                                    <h2 class="footer-title color-changer">
                                                        {{ trans('labels.follow_us') }}</h2>
                                                    <ul class="social-icon d-flex flex-wrap d-grid gap-2 mb-4">
                                                        @foreach (@helper::getsociallinks() as $links)
                                                            <li>
                                                                <a href="{{ $links->link }}" target="blank"
                                                                    class="d-flex justify-content-center align-items-center">
                                                                    {!! $links->icon !!}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                                <h2 class="footer-title color-changer">{{ trans('labels.subscribe') }}
                                                </h2>
                                                <div class="my-3">
                                                    <p class="text-muted truncate-2 fs-7 fw-medium">
                                                        {{ trans('labels.subscribe_title') }}</p>
                                                </div>
                                                <div class="subscribe-form">
                                                    <form action="{{ URL::to('/subscribe') }}" method="POST"
                                                        class="mt-3 footer-form">
                                                        @csrf
                                                        <div class="input-group gap-2">
                                                            <input type="text" name="sub_email"
                                                                class="form-control fs-7 p-2 rounded-0 fw-medium @error('sub_email') border-danger @enderror"
                                                                placeholder="{{ trans('labels.enter_email') }}"
                                                                required>
                                                            <button type="submit"
                                                                class="btn-primary rounded-0 py-sm-1 px-3"
                                                                id="basic-addon2 w-50">{{ trans('labels.subscribe') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- copyright section -->
                            <div class="footer-bottom border-top border-dark">
                                <div class="copyright pt-3">
                                    <div class="d-sm-flex justify-content-between">
                                        <div class="copyright-text text-center">
                                            <p class="mb-0 color-changer">{{ helper::appdata()->copyright }}</p>
                                        </div>
                                        <div class="copyright-menu">
                                            <div
                                                class="d-flex justify-content-center justify-content-md-end mt-2 mt-md-0">
                                                <ul
                                                    class="footer_acceped_card d-flex flex-wrap justify-content-end gap-2">
                                                    @foreach (helper::paymentmethods() as $method)
                                                        @php
                                                            // Check if the current $method is a system addon and activated
                                                            if (
                                                                $method->payment_type == 1 ||
                                                                $method->payment_type == 2
                                                            ) {
                                                                $systemAddonActivated = true;
                                                            } else {
                                                                $systemAddonActivated = false;
                                                            }

                                                            $addon = App\Models\SystemAddons::where(
                                                                'unique_identifier',
                                                                $method->unique_identifier,
                                                            )->first();
                                                            if ($addon != null && $addon->activated == 1) {
                                                                $systemAddonActivated = true;
                                                            }
                                                        @endphp
                                                        @if ($systemAddonActivated)
                                                            <li>
                                                                <img src="{{ helper::image_path($method->image) }}"
                                                                    alt="paymethod" class="border rounded">
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </main>
    @yield('model')
    <!-- citiesModal -->
    <div class="modal fade slow citiesModal" id="citiesModal" tabindex="-1" aria-labelledby="citiesModalLabel"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded-4">
                <div class="modal-header justify-content-between">
                    <h4 class="text-capitalize color-changer m-0">{{ trans('labels.search_your_city') }}</h4>
                    <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 d-flex gap-2 flex-column">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" name="city" id="ajax_city"
                                placeholder="{{ trans('labels.search_your_city') }}"
                                url="{{ URL::to('/home/find-cities') }}" spellcheck="false" autocomplete="off"
                                data-ms-editor="true" aria-describedby="basic-addon1">
                        </div>
                        @if (env('Environment') == 'sendbox')
                            <p class="text-danger m-0">Please select "Chicago" city for demo</p>
                        @endif
                    </div>
                    <div class="row g-3" id="city_suggestion">
                        @foreach (helper::cities() as $cdata)
                            <div class="col-md-6">
                                <a onclick="setCookie('city_id','{{ $cdata->id }}', 365)">
                                    <div
                                        class="card card-deck text-center h-100 cp {{ isset($_COOKIE['city_id']) && $_COOKIE['city_id'] == $cdata->id ? 'border border-primary border-1 bg-primary-rgb' : '' }}">
                                        <div class="d-flex gap-2 p-2 align-items-center">
                                            <div class="col-auto">
                                                <img class="city-modal-img"
                                                    src="{{ helper::image_path($cdata->image) }}"
                                                    alt="{{ trans('labels.city') }}">
                                            </div>
                                            <div class="text-dark color-changer fw-600 text-capitalize">
                                                {{ $cdata->name }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add rattings -->
    <div class="modal fade text-left add-rattings" id="add-rattings" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title color-changer fs-5" id="myModalLabel35">
                        {{ trans('labels.rattings_reviews') }}
                    </h3>
                    <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                    </button>
                </div>
                <form id="add_rattings_form" action="{{ URL::to('/home/user/add-rattings') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group col-lg-12">
                            <label class="form-label"> {{ trans('labels.service') }}
                            </label>
                            <div class="controls">
                                <input type="text" class="form-control" value="{{ @$bookingdata->service_name }}"
                                    disabled>
                                <input type="hidden" class="form-control" name="service"
                                    value="{{ @$bookingdata->service_id }}" readonly>
                                <input type="hidden" class="form-control" name="provider"
                                    value="{{ @$bookingdata->provider_id }}" readonly>
                            </div>
                        </div>

                        <div class="form-group col-lg-12 text-center">
                            <div class="star-rating">
                                <input id="five" type="radio" name="ratting" value="5">
                                <label class="form-label" for="five"><i class="active fa fa-star"
                                        aria-hidden="true"></i></label>
                                <input id="four" type="radio" name="ratting" value="4">
                                <label class="form-label" for="four"><i class="active fa fa-star"
                                        aria-hidden="true"></i></label>
                                <input id="three" type="radio" name="ratting" value="3">
                                <label class="form-label" for="three"><i class="active fa fa-star"
                                        aria-hidden="true"></i></label>
                                <input id="two" type="radio" name="ratting" value="2">
                                <label class="form-label" for="two"><i class="active fa fa-star"
                                        aria-hidden="true"></i></label>
                                <input id="one" type="radio" name="ratting" value="1">
                                <label class="form-label" for="one"><i class="active fa fa-star"
                                        aria-hidden="true"></i></label>
                                <span class="result"></span>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <textarea name="message" rows="4" class="form-control" placeholder="{{ trans('labels.message') }}">{{ old('message') }}</textarea>
                        </div>
                    </div>
                    <div class="row align-items-stretch p-3 g-2 justify-content-sm-end">
                        <div class="col-md-auto col-sm-3 col-6">
                            <button type="button" class="btn btn-danger rounded-3 w-100"
                                data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                        </div>
                        <div class="col-md-auto col-sm-3 col-6">
                            <input type="submit" id="btn_update_password" class="btn btn-primary w-100"
                                value="{{ trans('labels.add') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!----------------------------------------------------------- all Modal start ----------------------------------------------------------->

    <!----- userlogout Modal ----->
    <div class="modal" id="userlogout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center px-4 py-4">
                    <h5 class="fw-600 fs-3 color-changer truncate-3">Comeback Soon!</h5>
                    <p class="fw-semibold text-muted mb-3 truncate-2 or-text">Are You Sure You Want<br> to
                        Logout ?
                    </p>
                    <div class="row g-2">
                        <div class="col-6">
                            <button type="button" class="btn btn-danger w-100"
                                data-bs-dismiss="modal">{{ trans('labels.cancel') }}</button>
                        </div>
                        <div class="col-6">
                            <a href="{{ URL::to('/logout') }}"
                                class="btn btn-primary w-100">{{ trans('labels.logout') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!----- Remove address Modal ----->
    <div class="modal" id="removeaddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <form action="{{ URL::to('/home/user/delete_address') }}" method="POST">
                        @csrf
                        <input type="hidden" name="address_id" id="address_id" value="">
                        <div class="add-remove mx-auto">
                            <img src="{{ url('storage/app/public/others/remove.png') }}" alt="deleted address">
                        </div>
                        <h5 class="fw-600 color-changer fs-3 truncate-3 pb-2">Are you sure ?</h5>
                        <p class="fw-semibold text-muted mb-3 truncate-2"> Lorem ipsum dolor sit amet,
                            consectetur
                            adipisicing elit. Ex vel harum nesciunt sed quam rem dolorum voluptas, autem
                            cumque
                            dignissimos repellat dicta? Provident commodi aliquam incidunt esse quis
                            architecto
                            maxime!
                        </p>
                        <div class="row g-2 mt-4">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger h-100 w-100"
                                    data-bs-dismiss="modal">{{ trans('labels.cancel') }}</button>
                            </div>
                            <div class="col-6">
                                <button type="submit"
                                    class="btn btn-primary h-100 w-100">{{ trans('labels.confirm') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!----- add address Modal ----->
    <div class="modal" id="add_update_address" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h1 class="modal-title color-changer fs-5" id="exampleModalLabel"></h1>
                    <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- address add from -->
                    <form method="post" action="{{ URL::to('/home/user/add-address') }}" id="addressform"
                        class="row g-3">
                        @csrf
                        <input type="hidden" name="address_id" id="update_address_id">
                        <div class="col-12 col-md-4">
                            <label for="fullname" class="form-label">{{ trans('labels.fullname') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                class="form-control fs-7 p-2 text-capitalize @error('fullname') is-invalid @enderror"
                                name="fullname" id="fullname" type="text"
                                placeholder="{{ trans('labels.enter_full_name') }}" value="{{ old('fullname') }}"
                                required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="email" class="form-label">{{ trans('labels.email') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control fs-7 p-2 @error('email') is-invalid @enderror"
                                name="email" id="email" placeholder="{{ trans('labels.enter_email') }}"
                                value="{{ old('email') }}" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="mobile" class="form-label">{{ trans('labels.mobile') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input class="form-control fs-7 p-2 @error('mobile') is-invalid @enderror" name="mobile"
                                id="mobile" type="number" placeholder="{{ trans('labels.enter_mobile') }}"
                                value="{{ old('mobile') }}" maxlength="10" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="landmark" class="form-label">{{ trans('labels.landmark') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                class="form-control fs-7 p-2 form-control-sm @error('landmark') is-invalid @enderror"
                                name="landmark" id="landmark" type="text"
                                placeholder="{{ trans('labels.enter_landmark') }}" value="{{ old('landmark') }}"
                                required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="postalcode" class="form-label">{{ trans('labels.postalcode') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                class="form-control fs-7 p-2 form-control-sm @error('postalcode') is-invalid @enderror"
                                name="postalcode" id="postalcode" type="text"
                                placeholder="{{ trans('labels.enter_postalcode') }}" value="{{ old('postalcode') }}"
                                required>
                        </div>
                        <div class="col-12">
                            <label for="street_address" class="form-label">{{ trans('labels.street_address') }}
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control fs-7 p-2 form-control-sm @error('street_address') is-invalid @enderror"
                                name="street_address" id="street_address" placeholder="{{ trans('labels.enter_street_address') }}"
                                rows="2" required></textarea>
                        </div>

                        <!-- options -->
                        <div class="col-6 col-md-3 col-lg-3">
                            <div class="form-check">
                                <input class="form-check-input add_address_input" type="radio" name="address_type"
                                    value="1" id="homeselect" required>
                                <label class="form-check-label px-2 cp" for="homeselect">
                                    <div class="d-flex gap-1 px-1"></div>
                                    <i class="fa-regular fa-home"></i>
                                    <span class="fw-600 text-truncate">{{ trans('labels.home') }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 col-lg-3">
                            <div class="form-check">
                                <input class="form-check-input add_address_input" type="radio" name="address_type"
                                    value="2" id="Officeselect" required>
                                <label class="form-check-label px-2 cp" for="Officeselect">
                                    <div class="d-flex gap-1 px-1"></div>
                                    <i class="fa-regular fa-building"></i>
                                    <span class="fw-600 text-truncate">{{ trans('labels.office') }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 col-lg-3">
                            <div class="form-check">
                                <input class="form-check-input add_address_input" type="radio" name="address_type"
                                    value="3" id="otherselect" required>
                                <label class="form-check-label px-2 cp" for="otherselect">
                                    <div class="d-flex gap-1 px-1"></div>
                                    <i class="fa-regular fa-puzzle-piece"></i>
                                    <span class="fw-600 text-truncate">{{ trans('labels.other') }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- form submit buttons -->
                        <div class="d-flex justify-content-sm-end gap-2">
                            <div class="col-lg-2 col-md-3 col-6">
                                <button type="button" class="btn btn-danger fs-7 m-0 h-100 w-100"
                                    data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                            </div>
                            <div class="col-lg-2 col-md-3 col-6">
                                <button type="submit" id="saveAddress" class="btn btn-primary m-0 w-100"></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!---- Recharge Offcanvas ---->
    <div class="offcanvas {{ session()->get('direction') == 2 ? 'offcanvas-start' : 'offcanvas-end' }} px-0"
        tabindex="-1" id="rechargewallet" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header justify-content-between border-bottom py-3">
            <div class="d-flex d-grid gap-2 color-changer align-items-center">
                <i class="fa-regular fa-wallet fs-5"></i>
                <h5 class="fw-600 fs-5 m-0" id="offcanvasRightLabel">{{ trans('labels.add_wallet') }}
                </h5>
            </div>
            <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="offcanvas"
                aria-label="Close">
                <i class="fa-regular fa-xmark fs-4 color-changer"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            @if (!empty($walletdata))
                <div class="form-group mb-4">
                    <div class="input-group gap-1">
                        @if (helper::appdata()->currency_position == 'left')
                            <div class="input-group-prepend">
                                <label class="input-group-text fs-5">{{ helper::appdata()->currency }}</label>
                            </div>
                            <input type="text" maxlength="4" class="form-control rounded" name="wallet_amt"
                                id="wallet_amt" placeholder="{{ trans('labels.enter_amount') }}">
                        @else
                            <input type="text" maxlength="4" class="form-control rounded" name="wallet_amt"
                                id="wallet_amt" placeholder="{{ trans('labels.enter_amount') }}">
                            <div class="input-group-prepend">
                                <label
                                    class="input-group-text fs-5 h-100 fw-600 text-muted">{{ helper::appdata()->currency }}</label>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Option -->
                @if (@helper::checkaddons('trusted_badges'))
                    @include('front.service-trusted')
                @endif
                <div class="row grid-wrapper grid-col-auto g-3 recharge_payment_option">
                    <h5 class="fw-semibold color-changer fs-5">{{ trans('labels.payment_option') }}</h5>
                    @foreach ($paymethods as $methods)
                        @php
                            // Check if the current $pmdata is a system addon and activated
                            $systemAddonActivated = false;

                            $addon = App\Models\SystemAddons::where(
                                'unique_identifier',
                                $methods->unique_identifier,
                            )->first();
                            if ($addon != null && $addon->activated == 1) {
                                $systemAddonActivated = true;
                            }
                        @endphp
                        @if ($systemAddonActivated)
                            <div class="col-12">
                                <label for="{{ $methods->payment_name }}" class="radio-card card border h-100 cp">
                                    <input type="radio" id="{{ $methods->payment_name }}"
                                        data-payment_type="{{ $methods->id }}" name="payment">
                                    <div class="card-content-wrapper cp d-flex gap-3 align-items-center">
                                        <span class="check-icon"></span>
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="payment_option_img rounded-3">
                                                <img src="{{ helper::image_path($methods->image) }}" class="h-100"
                                                    alt="knjbhv" />
                                            </div>
                                            <p class="m-0 color-changer">{{ $methods->payment_name }}</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @if ($methods->payment_type == 3)
                                <input type="hidden" name="razorpay" id="razorpay"
                                    value="{{ $methods->public_key }}">
                            @endif

                            @if ($methods->payment_type == 4)
                                <input type="hidden" name="stripe" id="stripe"
                                    value="{{ $methods->public_key }}">
                            @endif

                            @if ($methods->payment_type == 5)
                                <input type="hidden" name="flutterwave" id="flutterwave"
                                    value="{{ $methods->public_key }}">
                            @endif

                            @if ($methods->payment_type == 6)
                                <input type="hidden" name="paystack" id="paystack"
                                    value="{{ $methods->public_key }}">
                            @endif
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-center">{{ trans('labels.no_data') }}</p>
            @endif
        </div>

        <!-- Payment button -->
        <div class="offcanvas-footer px-3 py-3 service-book">
            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="offcanvas"
                aria-label="Close">{{ trans('labels.close') }}</button>
            <button
                class="btn btn-primary btn-block withdraw-btn w-100 d-flex gap-3 justify-content-center align-items-center wallet_recharge"
                onclick="add_to_wallet()">
                {{ trans('labels.recharge') }}
                <div class="loader d-none wallet_recharge_loader"></div>
            </button>
        </div>
    </div>

    <!-- offer trigger-->
    @if (@helper::checkaddons('coupons'))
        @if (!empty(helper::offers()) && count(helper::offers()) > 0)
            <div class=" rounded gap-2 {{ session()->get('direction') == 2 ? 'offers-rtl' : 'offers' }}"
                data-bs-toggle="offcanvas" href="#offers" role="button" aria-controls="offers">
                <i class="fa-regular fa-badge-percent"></i>
                {{ trans('labels.offers') }}
            </div>
            <!-- offer sidebar -->
            <div class="offcanvas {{ session()->get('direction') == 2 ? 'offcanvas-start' : 'offcanvas-end' }}"
                tabindex="-1" id="offers" aria-labelledby="offersLabel">
                <div class="offcanvas-header justify-content-between border-bottom">
                    <h5 class="offcanvas-title color-changer fw-7F00" id="offcanvasExampleLabel">
                        {{ trans('labels.all_offer_Here') }}
                    </h5>
                    <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="offcanvas"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                    </button>
                </div>
                <div class="offcanvas-body">
                    @foreach (helper::offers() as $offer)
                        <!--- offer 1 --->
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="coupons_card fs-7 color-changer">{{ $offer->code }}</span>
                                    @if (request()->is('home/service/continue/checkout/*'))
                                        <p class="copy-text color-changer copy-couponcode"
                                            data-code="{{ $offer->code }}" data-bs-dismiss="offcanvas">
                                            {{ trans('labels.copy_code') }}</p>
                                    @endif
                                </div>
                                <h5 class="pt-3 fs-15 color-changer fw-600">{{ $offer->title }}</h5>
                                <p class="text-muted m-0 fs-13 description">
                                    {{ $offer->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif

    <!-- MODAL_USER_TYPE_SELECTION--START -->
    <div class="modal" id="useroption" tabindex="-1" aria-labelledby="useroptionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title color-changer fw-600" id="useroptionLabel">
                        {{ trans('labels.user_option') }}
                    </h5>
                    <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="fs-7 twoline color-changer">
                        {{ trans('labels.dont_have_account_guest') }}
                    </p>
                    <div class="g-3 row">
                        <div class="col-sm-6">
                            <a class="btn btn-secondary w-100 rounded-3" id="showlogin">
                                <i class="fa-solid fa-user-plus"></i>
                                <span class="px-2">{{ trans('labels.create_account') }}</span>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a class="btn btn-primary w-100 p-3 rounded-3" id="checkout">
                                <i class="fa-solid fa-address-card"></i>
                                <span class="px-2">{{ trans('labels.continue_as_guest') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL_USER_TYPE_SELECTION--END -->

    <!-- MODAL_Bank_Details--START -->
    <div class="modal" id="modalbankdetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalbankdetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title color-changer" id="modalbankdetailsLabel">
                        {{ trans('labels.bank_transfer') }}</h5>
                    <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                    </button>
                </div>
                <form enctype="multipart/form-data" action="" method="POST" id="bankdetailmodalurl">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="modal_booking_number" name="modal_booking_number" value="">
                        <input type="hidden" id="modal_payment_type" name="modal_payment_type" value="">
                        <input type="hidden" name="modal_service_id" id="modal_service_id" value="">
                        <input type="hidden" name="modal_user_id" id="modal_user_id" value="">
                        <input type="hidden" name="modal_booking_date" id="modal_booking_date" value="">
                        <input type="hidden" name="modal_booking_time" id="modal_booking_time" value="">
                        <input type="hidden" name="modal_name" id="modal_name" value="">
                        <input type="hidden" name="modal_email" id="modal_email" value="">
                        <input type="hidden" name="modal_mobile" id="modal_mobile" value="">
                        <input type="hidden" name="modal_address" id="modal_address" value="">
                        <input type="hidden" name="modal_landmark" id="modal_landmark" value="">
                        <input type="hidden" name="modal_postal_code" id="modal_postal_code" value="">
                        <input type="hidden" name="modal_grand_total" id="modal_grand_total" value="">
                        <input type="hidden" name="modal_tips" id="modal_tips" value="">
                        <input type="hidden" name="modal_sub_total" id="modal_sub_total" value="">
                        <input type="hidden" name="modal_tax" id="modal_tax" value="">
                        <input type="hidden" name="modal_tax_name" id="modal_tax_name" value="">
                        <input type="hidden" name="modal_coupon_code" id="modal_coupon_code" value="">
                        <input type="hidden" name="modal_discount" id="modal_discount" value="">
                        <input type="hidden" name="modal_message" id="modal_message" value="">
                        <div class="card">
                            <div class="card-body color-changer">
                                <p id="bank_description"></p>
                            </div>
                        </div>
                        <div class="form-group col-md-12 mt-2">
                            <label for="screenshot" class="form-label"> {{ trans('labels.screenshot') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="controls">
                                <input type="file" name="screenshot" id="screenshot"
                                    class="form-control  @error('screenshot') is-invalid @enderror" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger px-sm-4"
                            data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                        <button type="submit" class="btn btn-primary px-sm-4"> {{ trans('labels.save') }} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL_Bank_Details--END -->

  

    <!----------------------------------------------------------- all Modal end ------------------------------------------------------------>

    <!-- jquery js -->
    <script src="{{ asset('storage/app/public/front-assets/js/jquery-3.5.0.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('storage/app/public/front-assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- owl carousel js -->
    <script src="{{ asset('storage/app/public/front-assets/plugins/owlcarousel/owl.carousel.min.js') }}"></script>
    <!-- toastr js -->
    <script src="{{ asset('storage/app/public/front-assets/js/toaster/toastr.min.js') }}" type="text/javascript"></script>

    @if (@helper::checkaddons('age_verification'))
        @if (@helper::getagedetails($vendordata->id)->age_verification_on_off == 1)
            @include('age_modal')
            <script src="{{ url('resources/js/age.js') }}"></script>
        @else
            <script>
                $('#main-content').removeClass('blur');
            </script>
        @endif
    @else
        <script>
            $('#main-content').removeClass('blur');
        </script>
    @endif

    <!-- wizz chat -->
    @if (@helper::checkaddons('wizz_chat'))
        @if (@helper::appdata()->wizz_chat_on_off == 1)
            {!! @helper::appdata()->wizz_chat_settings !!}
        @endif
    @endif
    <!-- tawk chat -->
    @if (@helper::checkaddons('tawk_addons'))
        @if (@helper::appdata()->tawk_on_off == 1)
            {!! @helper::appdata()->tawk_widget_id !!}
        @endif
    @endif

    <!-- pwa -->
    @if (@helper::checkaddons('pwa'))
        <script src="{{ url('storage/app/public/sw.js') }}"></script>
        <script>
            if (!navigator.serviceWorker.controller) {
                navigator.serviceWorker.register("{{ url('storage/app/public/sw.js') }}").then(function(reg) {
                    console.log("Service worker has been registered for scope: " + reg.scope);
                });
            }
        </script>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif
    <script type="text/javascript">
        let wrong = "{{ trans('messages.wrong') }}";
        let okay = "{{ trans('messages.okay') }}";
        let service_closed = "{{ trans('messages.service_closed') }}";
        let payment_options = "{{ helper::appdata()->payment_process_options }}";
        let paymentaddonschecked = "{{ helper::allpaymentcheckaddons() }}";
        let booking_note_required = "{{ helper::appdata()->booking_note_required }}";
        // top deals parameter
        var start_date = "{{ @helper::top_deals()->start_date }}";
        var start_time = "{{ @helper::top_deals()->start_time }}";
        var end_date = "{{ @helper::top_deals()->end_date }}";
        var end_time = "{{ @helper::top_deals()->end_time }}";
        @if (@helper::checkaddons('top_deals'))
            var enddate = "{{ @App\Models\TopDeals::first()->end_date }}";
            var endtime = "{{ @App\Models\TopDeals::first()->end_time }}";
        @else
            var enddate = null;
            var endtime = null;
        @endif
        var topdeals = "{{ !empty(@$topdealsservicedata) && count(@$topdealsservicedata) > 0 ? 1 : 0 }}";
        var deal_type = "{{ @helper::top_deals()->deal_type }}";
        var time_zone = "{{ @helper::appdata()->timezone }}";
        var current_date = "{{ \Carbon\Carbon::now()->toDateString() }}";
        var siteurl = "{{ URL::to('/') }}";
        var direction = "{{ session()->get('direction') }}";

        @if (Session::has('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif
        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": 10000
            }
            toastr.error("{{ session('error') }}");
        @endif
        function myFunction() {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
            toastr.error("Permission disabled for demo mode");
        }

        function currency_format(price) {
            "use strict";
            var price = price * {{ @helper::currencyinfo($storeinfo->id)->exchange_rate }};
            if ("{{ @helper::currencyinfo()->currency_position }}" == 1) {
                return "{{ @helper::currencyinfo()->currency }}" + parseFloat(price).toFixed(2);
            } else {
                return parseFloat(price).toFixed(2) + "{{ @helper::currencyinfo()->currency }}";
            }
        }
    </script>
    @if (isset($_COOKIE['city_id']))
        @if (@helper::checkaddons('sales_notification'))
            @if (helper::appdata()->fake_sales_notification == 1)
                <script>
                    if ("{{ @helper::appdata()->fake_sales_notification }}" == "1") {
                        // Select the element with the ID 'sales-booster-popup'
                        const popup = document.getElementById('sales-booster-popup');

                        if (popup) {
                            // Define a function to add and remove the 'loaded' class
                            let isMouseOver = false;
                            const toggleLoadedClass = () => {
                                // Add the 'loaded' class
                                popup.classList.add('loaded');
                                // Remove the 'loaded' class after 5 seconds, unless the mouse is over the popup
                                setTimeout(() => {
                                        if (!isMouseOver) {
                                            popup.classList.remove('loaded');
                                        }
                                    },
                                    "{{ helper::appdata()->notification_display_time }}"
                                ); // 4000 milliseconds = 4 seconds for demo purposes
                            };

                            // Function to handle mouseover event
                            const handleMouseOver = () => {
                                isMouseOver = true;
                                // You can perform actions here when mouse is over the popup
                            };

                            // Function to handle mouseout event
                            const handleMouseOut = () => {
                                isMouseOver = false;
                            };

                            // Call the function initially
                            toggleLoadedClass();

                            setInterval(function() {
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: "{{ URL::to('get_notification_data') }}",

                                        method: 'POST',
                                        success: function(response) {
                                            toggleLoadedClass();
                                            $('#sales-booster-popup').show();
                                            $('#notification_body').html(response.output);
                                        },
                                    });
                                },
                                "{{ helper::appdata()->notification_display_time + helper::appdata()->next_time_popup }}"
                            ); // 8000 milliseconds = 8 seconds

                            // Add mouseover and mouseout event listeners to the popup
                            popup.addEventListener('mouseover', handleMouseOver);
                            popup.addEventListener('mouseout', handleMouseOut);

                            // Select the close button within the popup
                            const closeButton = popup.querySelector('.close'); // Close button selector

                            if (closeButton) {
                                // Add an event listener to the close button
                                closeButton.addEventListener('click', () => {
                                    // Remove the 'loaded' class immediately
                                    popup.classList.remove('loaded');
                                });
                            }
                        }
                    }
                </script>
            @endif
        @endif
    @endif

    <!-- script js -->
    <script src="{{ asset('storage/app/public/front-assets/js/script.js') }}"></script>
    <!-- sweetalert js -->
    <script src="{{ asset('storage/app/public/plugins/sweetalert/js/sweetalert.min.js') }}" type="text/javascript">
    </script>
    <!-- booking js -->
    <script src="{{ asset('storage/app/public/front-assets/booking.js') }}" type="text/javascript"></script>
    <!-- checkout js -->
    <script src="{{ asset('storage/app/public/front-assets/checkout.js') }}" type="text/javascript"></script>
    <!-- home js -->
    <script src="{{ asset('storage/app/public/front-assets/home.js') }}" type="text/javascript"></script>
    <!-- main js -->
    <script src="{{ asset('storage/app/public/front-assets/main.js') }}" type="text/javascript"></script>
    <!-- wallet js -->
    <script src="{{ asset('storage/app/public/front-assets/wallet.js') }}" type="text/javascript"></script>
    <!-- magnific-popup js -->
    <script src="{{ asset('storage/app/public/front-assets/magnific-popup.min.js') }}" type="text/javascript"></script>
    <!-- coman js -->
    <script src="{{ asset('storage/app/public/front-assets/js/owl-slider.js') }}" type="text/javascript"></script>
    <!-- Top Deals js -->
    <script src="{{ asset('storage/app/public/front-assets/top_deals.js') }}" type="text/javascript"></script>
    <!-- Fancybox 4.0 JS -->
    <script src="{{ asset('storage/app/public/front-assets/js/fancybox/fancybox-v4-0-27.js') }}" type="text/javascript">
    </script>
    <script>
        var darklogo = "{{ helper::image_path(helper::appdata('')->dark_logo) }}";
        var lightlogo = "{{ helper::image_path(helper::appdata('')->logo) }}";
    </script>
    @yield('scripts')
</body>

</html>
