<!DOCTYPE html>
<html lang="en" class="loading" dir="{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}" class="light">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <script>
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.add('light');
        }
    </script>

    <title>{{ trans('labels.register') }}</title>
    <link rel="shortcut icon" type="image/png"
        href="{{ asset('storage/app/public/images/' . helper::appdata()->favicon) }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.css') }}">
    <!-- fontawesome css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('storage/app/public/admin-assets/css/font-awesome/font-awesome.min.css') }}">
    <!-- bootstrap css -->
    <link rel="stylesheet"
        href="{{ asset('storage/app/public/admin-assets/css/plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- custom css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/css/app.css') }}">
    <!-- responsive css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/css/responsive.css') }}">
</head>
<style>
    :root {
        --bs-primary: {{ helper::otherdata()->admin_primary_color }};
        --bs-secondary: {{ helper::otherdata()->admin_secondary_color }};
    }
</style>

<body data-col="1-column" class=" 1-column blank-page blank-page">
    <section>
        <div class="row align-items-center g-0 w-100 h-100vh position-relative">
            <div class="col-md-6 col-lg-6 col-xl-8 d-md-block d-none">
                <div class="login-left-content">
                    <img src="{{ helper::image_path(helper::otherdata('')->admin_authentication_image) }}"
                        alt="">
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-4 overflow-hidden">
                <div class="login-right-content register-padding row">
                    <div class="pb-0 px-0">
                        <div class="mb-3">
                            <script>
                                document.addEventListener("DOMContentLoaded", function(event) {
                                    if (localStorage.getItem('theme') === 'dark') {
                                        var logo = "{{ helper::image_path(@helper::appdata()->dark_logo) }}";
                                    } else {
                                        var logo = "{{ helper::image_path(helper::appdata()->logo) }}";
                                    }
                                    $('#logoimage').attr('src', logo);
                                });
                            </script>
                            <a class="navbar-brand logo m-0 " href="{{ URL::to('/admin') }}">
                                <img src="" alt="logo" id="logoimage" class="logo-img">
                            </a>
                        </div>
                        <div class="text-primary d-flex align-items-center justify-content-between">
                            <div>
                                <h2 class="fw-600 text-color color-changer title-text mb-2">
                                    {{ trans('labels.register') }}</h2>
                                <p class="text-color color-changer">{{ trans('labels.create_account_text') }}</p>
                            </div>
                            <!-- lang button -->
                            @if (@helper::checkaddons('language'))
                                <div class="dropdown lag-btn">
                                    <button class="btn p-1 border-0 language-dropdown" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ helper::image_path(session()->get('flag')) }}" alt=""
                                            class="rounded-circle" width="25px" height="25px">
                                    </button>
                                    <ul class="dropdown-menu bg-body-secondary shadow border-0 overflow-hidden p-0">
                                        @foreach (helper::language() as $lang)
                                            <li>
                                                <a class="dropdown-item text-dark d-flex align-items-center p-2 gap-2"
                                                    href="{{ URL::to('/changelanguage-' . $lang->code) }}">
                                                    <img src="{{ helper::image_path($lang->image) }}" alt=""
                                                        class="img-fluid lag-img w-25">
                                                    {{ $lang->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <form action="{{ URL::to('/admin/store-provider') }}" method="POST"
                            enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <div class="row g-md-3 g-2">
                                @if ($message = Session::get('AuthError'))
                                    <span class="text-danger text-center" id="AuthError">{{ $message }}</span>
                                @endif
                                <div class="form-group col-12 mb-lg-2 mb-0">
                                    <label for="name"
                                        class="form-label fs-7 text-color">{{ trans('labels.fullname') }}
                                        <span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control extra-paddings" name="name"
                                        value="{{ old('name') }}" id="name"
                                        placeholder="{{ trans('labels.fullname') }}" required>
                                </div>
                                <div class="form-group col-6 mb-lg-2 mb-0">
                                    <label for="provider_type"
                                        class="form-label fs-7 text-color">{{ trans('labels.provider_type') }}
                                        <span class="text-danger"> * </span></label>
                                    <select name="provider_type" class="form-select extra-paddings" id="provider_type"
                                        required>
                                        <option value="" selected disabled>{{ trans('labels.select') }}</option>
                                        @foreach ($providertypedata as $pdata)
                                            <option value="{{ $pdata->id }}">{{ $pdata->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6 mb-lg-2 mb-0">
                                    <label for="email"
                                        class="form-label fs-7 text-color">{{ trans('labels.email') }}
                                        <span class="text-danger"> * </span></label>
                                    <input type="email" class="form-control extra-paddings" name="email"
                                        value="{{ old('email') }}" id="email"
                                        placeholder="{{ trans('labels.enter_email') }}" required>
                                </div>
                                <div class="form-group col-6 mb-lg-2 mb-0">
                                    <label for="password"
                                        class="form-label fs-7 text-color">{{ trans('labels.password') }}
                                        <span class="text-danger"> * </span></label>
                                    <div class="form-control extra-paddings d-flex align-items-center gap-3">
                                        <input type="password" class="form-control border-0 p-0" name="password"
                                            value="{{ old('password') }}" id="password"
                                            placeholder="{{ trans('labels.password') }}" required>
                                        <span>
                                            <a href="javascript:void(0)" class="text-dark color-changer">
                                                <i class="fa-regular fa-eye-slash" id="eye"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-6 mb-lg-2 mb-0">
                                    <label for="mobile"
                                        class="form-label fs-7 text-color">{{ trans('labels.mobile') }}
                                        <span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control extra-paddings" name="mobile"
                                        value="{{ old('mobile') }}" id="mobile"
                                        placeholder="{{ trans('labels.mobile') }}" required>
                                </div>
                                <div class="form-group col-6 mb-lg-2 mb-0">
                                    <label class="form-label">{{ trans('labels.profile') }}</label>
                                    <input class="form-control extra-paddings" type="file" name="image"
                                        value="{{ old('image') }}">
                                </div>
                                <div class="form-group col-6 mb-lg-2 mb-0">
                                    <label for="city"
                                        class="form-label fs-7 text-color">{{ trans('labels.city') }}
                                        <span class="text-danger"> * </span></label>
                                    <select name="city" class="form-select extra-paddings" required
                                        id="city">
                                        <option value="" selected disabled>{{ trans('labels.select') }}</option>
                                        @foreach ($citydata as $cdata)
                                            <option value="{{ $cdata->id }}">{{ $cdata->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label class="form-label">{{ trans('labels.address') }}</label>
                                    <textarea class="form-control" rows="3" name="address" placeholder="{{ trans('labels.enter_address') }}">{{ old('address') }}</textarea>
                                </div>
                                <div class="form-group m-0">
                                    <input class="form-check-input" type="checkbox" value=""
                                        name="check_terms" id="check_terms" checked required>
                                    <label class="form-check-label" for="check_terms">
                                        {{ trans('labels.I_accept_the') }}
                                        <a href="{{ URL::to('home/terms-condition') }}" target="_blank"
                                            class="fw-600 text-secondary">{{ trans('labels.terms_conditions') }}</a>
                                    </label>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="{{ URL::to('/admin') }}"
                                        class="btn btn-primary padding w-100">{{ trans('labels.login') }}</a>
                                    <button class="btn btn-secondary padding w-100"
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.register') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('storage/app/public/admin-assets/js/jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.js') }}" type="text/javascript"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('storage/app/public/admin-assets/css/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif
    <script>
        @if (Session::has('success'))
            toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                },
                toastr.success("{{ session('success') }}");
        @endif
        @if (Session::has('error'))
            toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": 10000
                },
                toastr.error("{{ session('error') }}");
        @endif
        function myFunction() {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
            toastr.error("Permission disabled for demo mode");
        }
        // password eye hide
        $(function() {
            $('#eye').click(function() {
                if ($(this).hasClass('fa-eye-slash')) {
                    $(this).removeClass('fa-eye-slash');
                    $(this).addClass('fa-eye');
                    $('#password').attr('type', 'text');
                } else {
                    $(this).removeClass('fa-eye');
                    $(this).addClass('fa-eye-slash');
                    $('#password').attr('type', 'password');
                }
            });
        });
    </script>
    <script>
        var darklogo = "{{ helper::image_path(helper::appdata('')->dark_logo) }}";
        var lightlogo = "{{ helper::image_path(helper::appdata('')->logo) }}";

        function setLightMode() {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
            localStorage.setItem('theme', 'light');
            $('#logoimage').attr('src', lightlogo);
            $('#footerlogoimage').attr('src', lightlogo);
        }

        function setDarkMode() {
            document.documentElement.classList.remove('light');
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            $('#logoimage').attr('src', darklogo);
            $('#footerlogoimage').attr('src', darklogo);
        }
    </script>
</body>

</html>
