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
    <!-- forgot password page -->
    <section>
        <div class="row align-items-center g-0 w-100 h-100vh position-relative">
            <div class="col-md-5 d-md-block d-none">
                <div class="login-left-content">
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
            </div>
            <div class="col-md-7 overflow-hidden">
                <div class="login-right-content login-forgot-padding row">
                    <div class="pb-0 px-0">
                        <div class="text-primary d-flex justify-content-between">
                            <div>
                                <h2 class="fw-600 text-color title-text mb-2">Verification</h2>
                            </div>
                            <!-- lang button -->
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
                        </div>
                        <form method="POST" class="mt-5 mb-5 login-input"
                            action="{{ route('admin.systemverification') }}">
                            @csrf
                            <div class="form-group">
                                <input id="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" required autocomplete="username" autofocus
                                    placeholder="Enter Envato username">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="{{ trans('labels.email') }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="purchase_key" type="text"
                                    class="form-control @error('purchase_key') is-invalid @enderror" name="purchase_key"
                                    required autocomplete="current-purchase_key" placeholder="Envato purchase key">
                                @error('purchase_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <?php
                            $text = str_replace('verification', '', url()->current());
                            ?>
                            <div class="form-group">
                                <input id="domain" type="hidden"
                                    class="form-control @error('domain') is-invalid @enderror" name="domain" required
                                    autocomplete="current-domain" value="{{ $text }}" readonly="">
                            </div>
                            <div class="col-md-12">
                                <input type="submit" value="{{ trans('labels.login') }}"
                                    class="btn btn-secondary padding mt-3 mb-4 w-100">
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
