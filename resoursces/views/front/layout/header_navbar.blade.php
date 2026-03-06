<!-- PWA -->


<!-- top bar -->
<div class="top-bar d-none d-lg-block py-2">
    <div class="container">
        <div class="d-flex justify-content-between">
            <!-- contact details -->
            <ul class="contact w-100 justify-content-between d-grid gap-4">
                <li>
                    <a href="mailto:{{ helper::appdata()->email }}"
                        class="d-flex align-items-center gap-2 text-white fs-7">
                        {{-- {{ trans('labels.email') }} : --}}
                        <i class="fa-solid fa-envelope"></i>
                        <span>{{ helper::appdata()->email }}</span>
                    </a>
                </li>
                <li>
                    <a href="callto:{{ helper::appdata()->contact }}"
                        class="d-flex align-items-center fs-7 gap-2 text-white">
                        <i class="fa-solid {{ session()->get('direction') == 2 ? 'fa-phone' : 'fa-phone-flip' }}"></i>
                        <span>{{ helper::appdata()->contact }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- main header -->
<header class="main-header border-bottom">
    <div class="container">
        <nav class="navbar navbar-expand-lg header-nav">
            <!-- logo -->
            <div class="d-flex align-items-center gap-sm-3 gap-2">
                <div class="d-lg-none">
                    <a class="text-dark color-changer" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#footersiderbar" aria-controls="footersiderbar">
                        <i class="fa-solid fa-bars fs-3"></i>
                    </a>
                </div>
                <div class="navbar-header">
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

                    <a class="navbar-brand logo m-0 " href="{{ route('home') }}">
                        <img src="" alt="logo" id="logoimage">
                    </a>
                </div>
            </div>
            <div class="d-flex align-items-center gap-5">
                <!-- main menu -->
                <div class="main-menu-wrapper">
                    <div class="menu-header">
                        <a class="navbar-brand logo m-0 " href="{{ route('home') }}">
                            <img src="" alt="logo" id="logoimage">
                        </a>
                        <a id="menu_close" class="menu-close shadow" href="javascript:void(0);"><i
                                class="far fa-times"></i></a>
                    </div>
                    <ul class="main-nav gap-5">
                        <li class="m-0 {{ request()->is('/') ? 'active' : '' }}">
                            <a href="{{ URL::to('/') }}">{{ trans('labels.home') }}</a>
                        </li>
                        <li class="m-0 {{ request()->is('home/categories*') ? 'active' : '' }}">
                            <a href="{{ URL::to('/home/categories') }}">{{ trans('labels.categories') }}</a>
                        </li>
                        <li class="m-0 {{ request()->is('home/services*') ? 'active' : '' }}">
                            <a href="{{ URL::to('/home/services') }}">{{ trans('labels.services') }}</a>
                        </li>
                        <li class="m-0 {{ request()->is('home/providers*') ? 'active' : '' }}">
                            <a href="{{ URL::to('/home/providers') }}">{{ trans('labels.providers') }}</a>
                        </li>
                        <li class="m-0 {{ request()->is('home/search*') ? 'active' : '' }}">
                            <a href="{{ URL::to('/home/search') }}">{{ trans('labels.search') }}</a>
                        </li>
                        @if (!Session::get('id'))
                            {{-- <li class="{{ request()->is('home/register-provider*') ? 'active' : '' }}">
                                <a href="{{ URL::to('/home/register-provider') }}">{{ trans('labels.become_provider') }}</a>
                            </li> --}}
                            {{-- <li class="{{ request()->is('home/login*') ? 'active' : '' }} "><a
                                    href="{{ URL::to('/home/login') }}">{{ trans('labels.login') }}</a></li> --}}
                        @endif
                    </ul>
                </div>

                <!-- right side -->
                <ul class="d-flex align-items-center gap-sm-3 gap-2">
                    <!-- notification -->
                    @if (Session::get('id'))
                        <li class="mobile-option">
                            <a onclick="clearnotification('{{ URL::to('/home/user/clearnotification') }}','{{ URL::to('/home/user/notifications') }}')"
                                class="text-dark position-relative cp">
                                <i
                                    class="far fa-bell fs-5 color-changer {{ helper::notification() > 0 ? 'animat' : '' }}"></i>
                                @if (helper::notification() > 0)
                                    <span class="badge-pill notification-dot color-changer"></span>
                                @endif
                            </a>
                        </li>
                    @endif

                    <!-- location Button -->
                    <li class="d-md-block d-none">
                        <a class="location mobile-option" href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#citiesModal">
                            <i class="fa-solid fa-location-dot fs-5 color-changer"></i>
                        </a>
                    </li>
                    {{-- for small device --}}
                    <li class="d-md-none mobile-option">
                        <a class="text-dark" href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#citiesModal">
                            <i class="fa-solid fa-location-dot color-changer"></i>
                        </a>
                    </li>

                    <!-- Mobile Language Button -->
                    @if (@helper::checkaddons('language'))
                        <li class="mobile-option">
                            <div class="dropdown lag-btn lag_select">
                                <button class="btn border-0 language-dropdown mb-0 p-0" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-globe fs-5 text-dark color-changer"></i>
                                </button>
                                <ul
                                    class="dropdown-menu shadow p-0 border-0 mt-2 bg-body-secondary  {{ session()->get('direction') == 2 ? 'min-dropdowns-rtl' : 'min-dropdowns-ltr' }}">
                                    @foreach (helper::language() as $lang)
                                        <li>
                                            <a class="dropdown-item p-2 d-flex align-items-center gap-2"
                                                href="{{ URL::to('/changelanguage-' . $lang->code) }}">
                                                <img src="{{ helper::image_path($lang->image) }}" alt="usa img"
                                                    class="img-fluid">
                                                <span>{{ $lang->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                    <li class="mobile-option">
                        <div class="dropdown lag-btn">
                            <a class="btn border-0 language-dropdown mb-0 p-0" type="button" id="dropdownMenuButton2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-circle-half-stroke fs-6 color-changer"></i>
                            </a>
                            <ul class="dropdown-menu bg-body-secondary shadow border-0 mt-2 overflow-hidden p-0 {{ session()->get('direction') == 2 ? 'min-dropdowns-rtl' : 'min-dropdowns-ltr' }}"
                                aria-labelledby="dropdownMenuButton2">
                                <li>
                                    <a class="dropdown-item d-flex cursor-pointer align-items-center p-2 gap-2"
                                        onclick="setLightMode()">
                                        <i class="fa-light fa-lightbulb fs-6"></i>
                                        <span>Light</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex cursor-pointer align-items-center p-2 gap-2"
                                        onclick="setDarkMode()">
                                        <i class="fa-solid fa-moon fs-6"></i>
                                        <span>Dark</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @if (@helper::checkaddons('currency_settigns'))
                        @if (helper::available_currency('')->count() > 1)
                            <li class="mobile-option">
                                <div class="dropdown lag-btn">
                                    <a class="btn border-0 language-dropdown mb-0 p-0" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <p class="fs-5 m-0 color-changer">
                                            {{ session()->get('currency') }}
                                        </p>
                                    </a>
                                    <ul
                                        class="dropdown-menu bg-body-secondary mt-2 shadow border-0 overflow-hidden p-0 {{ session()->get('direction') == 2 ? 'min-dropdowns-rtl' : 'min-dropdowns-ltr' }}">
                                        @foreach (helper::available_currency() as $currencylist)
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2 p-2 fs-13"
                                                    href="{{ URL::to('/currency/change?currency=' . $currencylist['code']) }}">
                                                    <span>
                                                        {{ $currencylist['currency'] . '  ' . $currencylist['name'] }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endif
                    @endif

                    @if (@helper::checkaddons('customer_login'))
                        @if (@helper::appdata()->login_required == 1)
                            <!-- user login Button -->
                            <li class="user-img border-0 d-none d-lg-block">
                                @if (!Session::get('id'))
                                    <a href="{{ URL::to('/home/login') }}">
                                        <div class="btn-user">
                                            <i class="fa-regular fa-user"></i>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ URL::to('/home/user/profile') }}" class="nav-link user-img">
                                        <img class="rounded h-100"
                                            src="{{ helper::image_path(@Auth::user()->image) }}" alt="user img" />
                                    </a>
                                @endif
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>

@if (env('Environment') == 'sendbox')
    <div class="d-none d-lg-block">
        <div class="pwa-icons-theme {{ session()->get('direction') == '2' ? 'rtl' : '' }}">
            <a href="{{ URL::to('pwa') }}" type="button"
                class="pwa_theme border-0 {{ session()->get('direction') == '2' ? 'rtl' : '' }}">
                <i class="fa-light fa-mobile fs-4"></i>
            </a>
            <p class="m-0 fs-7 mt-2 fw-500 text-dark color-changer">PWA Demo</p>
        </div>
    </div>
@endif

<!-- MOBILE MENU FOOTER START -->
<div class="mobile-menu-footer d-lg-none">
    <div class="container">
        <ul class="d-flex justify-content-between align-items-center gap-2">
            <li class="d-flex align-items-center">
                <a href="{{ URL::to('/') }}"
                    class="{{ request()->is('/') ? 'active1' : '' }} text-center text-dark">
                    <i class="fs-7 fa-regular fa-home"></i>
                    <p>{{ trans('labels.home') }}</p>
                </a>
            </li>
            <li class="d-flex align-items-center">
                <a href="{{ URL::to('/home/categories') }}"
                    class="{{ request()->is('home/categories*') ? 'active1' : '' }} text-center text-dark">
                    <i class="fs-7 fa-light fa-box-archive"></i>
                    <p>{{ trans('labels.category') }}</p>
                </a>
            </li>
            <li class="d-flex align-items-center">
                <a href="{{ URL::to('/home/search') }}"
                    class="{{ request()->is('home/search*') ? 'active1' : '' }} text-center text-dark">
                    <i class="fs-7 fa-regular fa-magnifying-glass position-relative"></i>
                    <p>{{ trans('labels.search') }}</p>
                </a>
            </li>
            <li class="d-flex align-items-center">
                <a href="{{ URL::to('/home/providers') }}"
                    class="{{ request()->is('home/providers*') ? 'active1' : '' }} text-center text-dark">
                    <i class="fs-7 fa-regular fa-users"></i>
                    <p>{{ trans('labels.providers') }}</p>
                </a>
            </li>
            @if (@helper::checkaddons('customer_login'))
                @if (@helper::appdata()->login_required == 1)
                    <li class="d-flex align-items-center">
                        @if (!Session::get('id'))
                            <a href="{{ URL::to('/home/login') }}"
                                class="{{ request()->is('home/login*') ? 'active1' : '' }} text-center text-dark">
                                <i class="fs-7 fa-regular fa-user"></i>
                                <p>{{ trans('labels.account') }}</p>
                            </a>
                        @else
                            <a href="{{ URL::to('/home/user/profile') }}"
                                class="{{ request()->is('home/login*') ? 'active1' : '' }} text-center text-dark">
                                <img class="user-img" src="{{ helper::image_path(@Auth::user()->image) }}"
                                    alt="user img" />
                                <p>{{ trans('labels.account') }}</p>
                            </a>
                        @endif
                    </li>
                @endif
            @endif
        </ul>
    </div>
</div>


{{-- footer offcanvas start --}}
<div class="offcanvas {{ session()->get('direction') == '2' ? 'offcanvas-end' : 'offcanvas-start' }}" tabindex="-1"
    id="footersiderbar" aria-labelledby="footersiderbar">
    <div class="offcanvas-header justify-content-between border-bottom">
        <img src="{{ helper::image_path(helper::appdata()->logo) }}" alt="footer_logo">
        <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa-regular fa-xmark fs-4 color-changer"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <h5 class="text-dark color-changer text-capitalize border-bottom pb-3 m-0 fw-600">
            {{ trans('labels.categories') }}
        </h5>
        <ul class="list-group list-add list-group-flush border-bottom">
            @foreach (helper::categories() as $categories)
                <li class="list-group-item px-0 py-3 {{ session()->get('direction') == '2' ? 'pe-3' : 'ps-3' }}">
                    <a class="fs-7 fw-500 d-flex gap-2 align-items-center color-changer text-dark"
                        href="{{ URL::to('/home/services/' . $categories->slug) }}">
                        <i class="fa-solid fa-circle-dot fs-7"></i>
                        {{ $categories->name }}
                    </a>
                </li>
            @endforeach
        </ul>
        <h5 class="text-dark color-changer text-capitalize color-changer border-bottom py-3 m-0 fw-600">
            {{ trans('labels.quick_links') }}
        </h5>
        <ul class="list-group list-add list-group-flush border-bottom">
            <li class="list-group-item px-0 py-3 {{ session()->get('direction') == '2' ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 text-dark d-flex gap-2 align-items-center color-changer"
                    href="{{ URL::to('/home/about-us') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('labels.about_us') }}
                </a>
            </li>
            <li class="list-group-item px-0 py-3 {{ session()->get('direction') == '2' ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 text-dark d-flex gap-2 align-items-center color-changer"
                    href="{{ URL::to('/home/contact-us') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('labels.contact_us') }}
                </a>
            </li>
            <li class="list-group-item px-0 py-3 {{ session()->get('direction') == '2' ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 text-dark d-flex gap-2 align-items-center color-changer"
                    href="{{ URL::to('/home/terms-condition') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('labels.terms_conditions') }}
                </a>
            </li>
            <li class="list-group-item px-0 py-3 {{ session()->get('direction') == '2' ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 text-dark d-flex gap-2 align-items-center color-changer"
                    href="{{ URL::to('/home/privacy-policy') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('labels.privacy_policy') }}
                </a>
            </li>
            @if (@helper::checkaddons('blog'))
                <li class="list-group-item px-0 py-3 {{ session()->get('direction') == '2' ? 'pe-3' : 'ps-3' }}">
                    <a class="fs-7 fw-500 text-dark d-flex gap-2 align-items-center color-changer"
                        href="{{ URL::to('home/blog/list/') }}">
                        <i class="fa-solid fa-circle-dot fs-7"></i>
                        {{ trans('labels.blog') }}
                    </a>
                </li>
            @endif
        </ul>
        <h5 class="text-dark color-changer text-capitalize py-3 m-0 fw-600">{{ trans('labels.contact_us') }}</h5>
        <ul class="mb-2">
            @if (!empty(helper::appdata()->address))
                <li class="py-2">
                    <a class="fs-7 fw-500 text-dark d-flex gap-2 align-items-center color-changer"
                        href="https://www.google.com/maps/place/{{ helper::appdata()->address }}">
                        <i class="far fa-building fs-7"></i>
                        {{ helper::appdata()->address }}
                    </a>
                </li>
            @endif
            @if (!empty(helper::appdata()->contact))
                <li class="py-2">
                    <a class="fs-7 fw-500 text-dark d-flex gap-2 align-items-center color-changer"
                        href="callto:{{ helper::appdata()->contact }}">
                        <i class="fa-solid fa-headset fs-7"></i>
                        {{ helper::appdata()->contact }}
                    </a>
                </li>
            @endif
            @if (!empty(helper::appdata()->email))
                <li class="py-2">
                    <a class="fs-7 fw-500 text-dark d-flex gap-2 align-items-center color-changer"
                        href="mailto:{{ helper::appdata()->email }}">
                        <i class="fa-solid fa-envelope fs-7"></i>
                        {{ helper::appdata()->email }}
                    </a>
                </li>
            @endif
        </ul>
        @if (count(helper::getsociallinks()) > 0)
            <h5 class="text-dark color-changer text-capitalize py-3 border-top m-0 fw-600">
                {{ trans('labels.follow_us') }}</h5>
            <ul class="social-icon d-flex flex-wrap d-grid gap-3 mb-3">
                @foreach (@helper::getsociallinks() as $links)
                    <li>
                        <a href="{{ $links->link }}" target="blank"
                            class="d-flex justify-content-center align-items-center fs-15">
                            {!! $links->icon !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
        <h5 class="text-dark color-changer text-capitalize pt-3 pb-2 border-top fw-600">
            {{ trans('labels.subscribe') }}</h5>
        <div class="mb-3">
            <p class="text-muted truncate-2 fs-7 fw-medium">{{ trans('labels.subscribe_title') }}</p>
        </div>

        <div class="subscribe-form">
            <form action="{{ URL::to('/subscribe') }}" method="POST" class="footer-form">
                @csrf
                <div class="input-group gap-2">
                    <input type="text" name="sub_email"
                        class="form-control fs-7 p-2 rounded-0 fw-medium @error('sub_email') border-danger @enderror"
                        placeholder="{{ trans('labels.enter_email') }}" required>
                    <button type="submit" class="btn-primary rounded-0 py-sm-1 px-3"
                        id="basic-addon2 w-50">{{ trans('labels.subscribe') }}</button>
                </div>
                @error('sub_email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </form>
        </div>
        <hr class="mt-4 text-white mb-0">
    </div>
    <div class="offcanvas-footer bg-dark border-top">
        <p class="m-0 fs-13 text-center text-light fw-500 px-2 py-2">
            {{ helper::appdata()->copyright }}
        </p>
    </div>
</div>
{{-- footer offcanvas start --}}
