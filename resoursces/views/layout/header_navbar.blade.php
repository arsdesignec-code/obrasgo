<!-- Navbar (Header) Start -->
<nav class="navbar navbar-expand-lg navbar-light bg-faded header-navbar page-topbar">
    <div class="container-fluid">
        <div class="navbar-header {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
            <button type="button" data-toggle="collapse"
                class="btn border-0 navbar-toggle d-lg-none float-left p-1 px-sm-2 py-sm-1">
                <i class="fa fa-bars fs-4"></i>
            </button>
        </div>
        <div class="d-flex gap-2 align-items-center">
            @if (Session::get('back_admin') || Session::get('back_provider'))
                <a href="{{ URL::to('/go-back') }}" class="btn btn-primary btn-sm hw-36" data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-title="{{ Session::get('back_provider') ? trans('labels.back_to_provider') : trans('labels.back_to_admin') }}"
                    data-original-title="View" title="View" data-bs-toggle="tooltip">
                    <i class="fa fa-backward"></i>
                </a>
            @endif
            <div class="navbar-nav">
                <ul class="dropdown nav-item m-0 p-0 d-flex gap-2 align-items-center">
                    @if (@helper::checkaddons('language'))

                        <!-- admin notification -->
                        @if (Auth::user()->type != 1)
                            <li class="dropdown btn-primary btn text-white nav-item border-option">
                                <button id="dropdownBasic2" onclick="clearnotification('{{ Auth::user()->id }}')"
                                    data-toggle="dropdown" class="nav-link position-relative p-0">
                                    <i class="far fa-bell fs-5 animat text-white"></i>
                                    @if (helper::notification() > 0)
                                        <span class="badge-pill notification-dot"></span>
                                    @endif
                                    <p class="d-none">{{ trans('labels.notification') }}</p>
                                </button>
                            </li>
                        @endif

                        <!-- lang button -->
                        <li class="dropdown lag-btn">
                            <a class="border-option btn-primary btn text-white" href="#" role="button"
                                data-bs-toggle ="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-globe fs-6"></i>
                            </a>
                            <ul
                                class="dropdown-menu bg-body-secondary mt-2 border-0 p-0 overflow-hidden shadow {{ session()->get('direction') == 2 ? 'min-dropdown-rtl' : 'min-dropdowns-ltr' }}">
                                @foreach (helper::language() as $lang)
                                    <li>
                                        <a class="dropdown-item d-flex gap-2 p-2 align-items-center"
                                            href="{{ URL::to('/changelanguage-' . $lang->code) }}">
                                            <img src="{{ helper::image_path($lang->image) }}" alt=""
                                                class="img-fluid rounded-circle" width="25px">
                                            {{ $lang->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    <li class="mobile-option">
                        <div class="dropdown lag-btn">
                            <a class="border-option btn-primary btn text-white" type="button" id="dropdownMenuButton2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-circle-half-stroke fs-6"></i>
                            </a>
                            <ul class="dropdown-menu bg-body-secondary shadow border-0 mt-2 overflow-hidden p-0 {{ session()->get('direction') == 2 ? 'min-dropdown-rtl' : 'min-dropdowns-ltr' }}"
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
                                    <a class="border-option btn-primary btn text-white" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <p class="fs-5 m-0 ">
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
                  
                    <!-- admin dropdown -->
                    <li>
                        <div id="dropdownBasic3" class="dropdown lag-btn d-flex">
                            <a class="dropdown-toggle header-item {{ session()->get('direction') == 2 ? ' pe-0' : ' ps-0' }}"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ helper::image_path(Auth::user()->image) }}">
                                <span class="d-none d-xxl-inline-block d-xl-inline-block color-changer">
                                    {{ Auth::user()->name }}</span>
                                <i
                                    class="fa fa-angle-down color-changer d-none d-xxl-inline-block d-xl-inline-block"></i>
                            </a>
                            <ul
                                class="dropdown-menu p-0 border-0 bg-body-secondary shadow {{ session()->get('direction') == 2 ? 'drop-menu-rtl' : 'dropdown-menu ltr' }}">
                                <li>
                                    <a class="dropdown-item p-2 cp d-flex gap-1 align-items-center"
                                        href="{{ Auth::user()->type == 1 ? URL::to('/settings#admin_info') : URL::to('/profile-settings#profile_member') }}">
                                        <div class="icon">
                                            <i class="ft-edit fs-7"></i>
                                        </div>
                                        <span>{{ trans('labels.edit_profile') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item p-2 change_password_modal cp d-flex gap-1 align-items-center"
                                        href="{{ Auth::user()->type == 1 ? URL::to('/settings#change_password') : URL::to('/profile-settings#change_password') }}">
                                        <div class="icon">
                                            <i class="fa fa-key fs-7"></i>
                                        </div>
                                        <span>{{ trans('labels.change_password') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex p-2 gap-1 align-items-center cursor-pointer"
                                        onclick="logout('{{ URL::to('/logout') }}')">
                                        <div class="icon">
                                            <i class="ft-power fs-7"></i>
                                        </div>
                                        <span>{{ trans('labels.logout') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar (Header) Ends -->



<footer class="py-3 text-center bg-white fixed-bottom border-top">
    <span class="fs-15">{{ helper::appdata()->copyright }}</span>
</footer>
