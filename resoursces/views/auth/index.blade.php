<!DOCTYPE html>
<html lang="en" class="loading" dir="{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}" class="light">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <script>
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.add('light');
        }
    </script>

    <title>{{ trans('labels.login') }}</title>
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
    <!-- login page -->
    <section>
        <div class="row align-items-center g-0 w-100 h-100vh position-relative">
            <div class="col-md-6 col-lg-7 col-xl-8 d-md-block d-none">
                <div class="login-left-content">
                    <img src="{{ helper::image_path(helper::otherdata('')->admin_authentication_image) }}"
                        alt="">
                </div>
            </div>
            <div class="col-md-6 col-lg-5 col-xl-4 overflow-hidden">
                <div class="login-right-content login-forgot-padding row">
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
                                <h4 class="fw-600 text-color color-changer title-text mb-2">{{ trans('labels.login') }}
                                </h4>
                                <p class="text-color color-changer">{{ trans('labels.please_login') }}</p>
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
                        <form action="{{ URL::to('/checkadminlogin') }}" method="POST" class="mt-4" id="login-form">
                            @csrf
                            @if ($message = Session::get('AuthError'))
                                <span class="text-danger text-center" id="AuthError">{{ $message }}</span>
                            @endif
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="email" class="form-label text-color">{{ trans('labels.email') }}
                                        <span class="text-danger"> * </span>
                                    </label>
                                    <input type="email" class="form-control extra-paddings fs-7" name="email"
                                        id="email" placeholder="{{ trans('labels.enter_email') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="password" class="form-label text-color">{{ trans('labels.password') }}
                                        <span class="text-danger"> * </span>
                                    </label>
                                    <div class="form-control extra-paddings d-flex align-items-center gap-3">
                                        <input type="password" class="form-control fs-7 text-color border-0 p-0"
                                            name="password" id="password"
                                            placeholder="{{ trans('labels.enter_password') }}" required>
                                        <span>
                                            <a href="javascript:void(0)" class="text-dark color-changer">
                                                <i class="fa-regular fa-eye-slash" id="eye"></i></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="col-6">
                                    <input class="form-check-input" type="checkbox" id="check_terms" checked>
                                    <label class="form-check-label text-color fs-7" for="check_terms">
                                        {{ trans('labels.remember_me') }}</label>
                                </div>
                                <div class="col-6">
                                    <div
                                        class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end ' }} mb-2">
                                        <a href="{{ URL::to('/admin/forgot_password') }}"
                                            class="fs-15 fw-600 text-secondary">
                                            {{ trans('labels.forgot_password') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="submit" value="{{ trans('labels.login') }}"
                                    class="btn btn-secondary padding mt-3 mb-4 w-100">
                            </div>
                            @if (helper::appdata()->provider_registration == 1)
                                <p class="fs-6 text-center mt-1 color-changer text-color">
                                    {{ trans('labels.donot_have_account') }}
                                    <a href="{{ URL::to('admin/register') }}"
                                        class="text-secondary fw-semibold text-decoration">{{ trans('labels.create_account') }}</a>
                                </p>
                            @endif

                            @if (env('Environment') == 'sendbox')
                                <div class="border-bottom my-3"></div>
                                <p class="text-center text-danger">Explore with <b
                                        class="text-black color-changer">FREE</b> addons
                                </p>

                                <div class="d-flex">
                                    <button class="btn btn-secondary w-100 mt-2 mb-3 padding mx-2"
                                        id="admin_free_addon_login">Admin login</button>
                                </div>

                                <p class="text-center text-danger">Explore with <b
                                        class="text-black color-changer">ALL</b> addons
                                </p>

                                <div class="d-flex">
                                    <button class="btn btn-secondary w-100 mt-2 mb-3 padding mx-2"
                                        id="all-addon">Admin login</button>
                                </div>
                            @endif
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
        function AdminFill(email, password) {
            $('#email').val(email);
            $('#password').val(password);
        }

        $(document).on("click", "#admin_free_addon_login", function() {
            $("#admin_free_addon_login").attr("disabled", true);

            $("#email").val('admin@gmail.com');
            $("#password").val('123456');
            SessionSave('free-addon');
        });

        $(document).on("click", "#all-addon", function() {
            $("#all-addon").attr("disabled", true);

            $("#email").val('admin@gmail.com');
            $("#password").val('123456');
            SessionSave('all-addon');
        });

        function SessionSave(addon = null) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: "json",
                url: "{{ URL::to('add-on/session/save') }}",
                data: {
                    'demo_type': addon,
                },
                success: function(response) {
                    $('#login-form').submit();
                }
            });
        }
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
