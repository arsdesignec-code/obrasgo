<!-- main menu-->
<div data-active-color="white" data-background-color="black"
    data-image="{{ asset('storage/app/public/admin-assets/img/sidebar-bg/04.jpg') }}" class="app-sidebar">
    <!-- main menu content-->
    <div class="sidebar sidebar-lg">
        <div
            class="d-flex justify-content-between justify-content-lg-center align-items-center mb-3 border-bottom border-white">
            <div class="navbar-header-logoc pb-2">
                <a href="{{ URL::to('/dashboard') }}" class="text-white fs-4">
                    @if (Auth::user()->type == 1)
                        {{ trans('labels.admin') }}
                    @elseif(Auth::user()->type == 2)
                        {{ trans('labels.provider') }}
                    @elseif(Auth::user()->type == 3)
                        {{ trans('labels.handyman') }}
                    @endif
                </a>
            </div>
            <a id="sidebarClose" href="javascript:;" class="nav-close d-lg-none"></a>
        </div>
        <ul id="main-menu-navigation" data-menu="menu-navigation"
            class="navbar-nav navigation {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
            <li class="nav-item mb-2 fs-7 d-block">
                <a href="{{ URL::to('/dashboard') }}"
                    class="nav-link d-flex {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="ft-home"></i>
                    <span data-i18n="" class="menu-title">{{ trans('labels.dashboard') }}</span>
                </a>
            </li>
            @if (Auth::user()->type == 1)
                <li class="nav-item mb-2 fs-7">
                    <a class="nav-link d-flex {{ request()->is('apps*') ? 'active' : '' }}" aria-current="page"
                        href="{{ URL::to('/apps') }}">
                        <i class="fa-solid fa-rocket"></i>
                        <p class="d-flex m-0 w-100 align-items-center justify-content-between">
                            <span>{{ trans('labels.addons_manager') }}</span>
                            <span class="rainbowText float-right">Premium</span>
                        </p>
                    </a>
                </li>



                <li class="nav-item my-2">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.product_management') }}</h6>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/categories') }}"
                        class="nav-link d-flex {{ request()->is('categories*') ? 'active' : '' }}">
                        <i class="ft-briefcase"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.category') }}</span>
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/services') }}"
                        class="nav-link d-flex {{ request()->is('services*') ? 'active' : '' }}">
                        <i class="ft-heart"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.service') }}</span>
                    </a>
                </li>
                @if (@helper::checkaddons('product_review'))
                    <li class="nav-item mb-2 fs-7 d-block">
                        <a href="{{ URL::to('/reviews') }}"
                            class="nav-link d-flex {{ request()->is('reviews*') ? 'active' : '' }}">
                            <i class="ft-star"></i>
                            <div class="w-100 d-flex justify-content-between">
                                <span data-i18n="" class="menu-title">{{ trans('labels.reviews') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endif
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/cities') }}"
                        class="nav-link d-flex {{ request()->is('cities*') ? 'active' : '' }}">
                        <i class="ft-map"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.city') }}</span>
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/provider_types') }}"
                        class="nav-link d-flex {{ request()->is('provider_types*') ? 'active' : '' }}">
                        <i class="ft-list"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.provider_type') }}</span>
                    </a>
                </li>
                <li class="nav-item my-2 ">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.booking_management') }}</h6>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/bookings') }}"
                        class="nav-link d-flex {{ request()->is('bookings*') ? 'active' : '' }}">
                        <i class="ft-calendar"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.booking') }}</span>
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('reports') }}"
                        class="nav-link d-flex {{ request()->is('reports*') ? 'active' : '' }}">
                        <i class="ft-bar-chart-2"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.reports') }}</span>
                    </a>
                </li>
                <li class="nav-item my-2">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.employee_management') }}</h6>
                </li>
                @if (@helper::checkaddons('customer_login'))
                    <li class="nav-item mb-2 fs-7 d-block">
                        <a href="{{ URL::to('/users') }}"
                            class="nav-link d-flex {{ request()->is('users*') ? 'active' : '' }}">
                            <i class="fa-light fa-user-tie"></i>
                            <div class="w-100 d-flex justify-content-between">
                                <span data-i18n="" class="menu-title">{{ trans('labels.customer') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endif
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/providers') }}"
                        class="nav-link d-flex {{ request()->is('providers*') ? 'active' : '' }}">
                        <i class="ft-users"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.provider') }}</span>
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/handymans') }}"
                        class="nav-link d-flex {{ request()->is('handymans*') ? 'active' : '' }}">
                        <i class="fa fa-users"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.handyman') }}</span>
                    </a>
                </li>
                <li class="nav-item my-2 ">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.promotions') }}</h6>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/banners') }}"
                        class="nav-link d-flex {{ request()->is('banners*') ? 'active' : '' }}">
                        <i class="ft-image"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.banner') }}</span>
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/brand') }}"
                        class="nav-link d-flex {{ request()->is('brand*') ? 'active' : '' }}">
                        <i class="fa-light fa-images"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.brands') }}</span>
                    </a>
                </li>
                @if (@helper::checkaddons('coupons'))
                    <li class="nav-item mb-2 fs-7 d-block">
                        <a href="{{ URL::to('/coupons') }}"
                            class="nav-link d-flex {{ request()->is('coupons*') ? 'active' : '' }}">
                            <i class="fa fa-gift"></i>
                            <div class="w-100 d-flex justify-content-between">
                                <span data-i18n="" class="menu-title">{{ trans('labels.coupon') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endif
                <li class="nav-item my-2 ">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.business_management') }}</h6>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/payment-methods') }}"
                        class="nav-link d-flex {{ request()->is('payment-methods*') ? 'active' : '' }}">
                        <i class="fa-solid fa-money-check"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.payment_method') }}</span>
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/subscribers') }}"
                        class="nav-link d-flex {{ request()->is('subscribers*') ? 'active' : '' }}">
                        <i class="ft-check"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.subscribers') }}</span>
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/payout') }}"
                        class="nav-link d-flex {{ request()->is('payout*') ? 'active' : '' }}">
                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                        <span class="menu-title">{{ trans('labels.payout_request') }}</span>
                        @if (helper::payout_request() > 0)
                            <span
                                class="tag badge badge-pill badge-danger float-end {{ session()->get('direction') == 2 ? 'me-auto' : 'ms-auto' }}">{!! helper::payout_request() !!}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item my-2 ">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.website_settings') }}</h6>
                </li>
                <li class="nav-item mb-2 fs-7 d-block dropdown">
                    <a class="nav-link d-flex align-items-center justify-content-between dropdown-toggle"
                        href="#pages" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="pages">
                        <div class="d-flex">
                            <i class="fa fa-list"></i>
                            <span class="menu-title">{{ trans('labels.cms_pages') }}</span>
                        </div>
                    </a>
                    <ul class="menu-content mt-2 collapse" id="pages">
                        <li class="nav-item ps-4 mb-1">
                            <a href="{{ URL::to('/about') }}"
                                class="nav-link {{ request()->is('about*') ? 'active' : '' }}">
                                <span class="d-flex align-items-center multimenu-menu-indicator">
                                    <i class="fa fa-circle"></i> {{ trans('labels.about') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item ps-4 mb-1">
                            <a href="{{ URL::to('/privacy-policy') }}"
                                class="nav-link {{ request()->is('privacy*') ? 'active' : '' }}">
                                <span class="d-flex align-items-center multimenu-menu-indicator">
                                    <i class="fa fa-circle"></i> {{ trans('labels.privacy_policy') }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item ps-4 mb-1">
                            <a href="{{ URL::to('/terms-conditions') }}"
                                class="nav-link {{ request()->is('terms*') ? 'active' : '' }}">
                                <span class="d-flex align-items-center multimenu-menu-indicator">
                                    <i class="fa fa-circle"></i> {{ trans('labels.terms_conditions') }}
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                @if (@helper::checkaddons('store_review'))
                    <li class="nav-item mb-2 fs-7 d-block">
                        <a href="{{ URL::to('/testimonials') }}"
                            class="nav-link d-flex {{ request()->is('testimonials*') ? 'active' : '' }}">
                            <i class="fa-light fa-message"></i>
                            <div class="w-100 d-flex justify-content-between">
                                <span data-i18n="" class="menu-title">
                                    {{ trans('labels.testimonials') }}
                                </span>
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endif
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/faq') }}"
                        class="nav-link d-flex {{ request()->is('faq*') ? 'active' : '' }}">
                        <i class="fa fa-question"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.faq') }}</span>
                    </a>
                </li>
                @if (@helper::checkaddons('blog'))
                    <li class="nav-item mb-2 fs-7 d-block">
                        <a href="{{ URL::to('/blog') }}"
                            class="nav-link d-flex {{ request()->is('blog*') ? 'active' : '' }}">
                            <i class="fa fa-blog"></i>
                            <div class="w-100 d-flex justify-content-between">
                                <span data-i18n="" class="menu-title">{{ trans('labels.blog') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endif
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/how-it-works') }}"
                        class="nav-link d-flex {{ request()->is('how-it-works*') ? 'active' : '' }}">
                        <i class="fa-light fa-tag"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.how_works') }}</span>
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/contact-us') }}"
                        class="nav-link d-flex {{ request()->is('contact-us*') ? 'active' : '' }}">
                        <i class="fa fa-phone"></i>
                        <span data-i18n="" class="menu-title">
                            {{ trans('labels.contact_us') }}
                        </span>
                    </a>
                </li>
                <li class="nav-item my-2 ">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.other') }}</h6>
                </li>
                @if (@helper::checkaddons('whatsapp_message'))
                    <li class="nav-item mb-2 fs-7 d-block">
                        <a href="{{ URL::to('/whatsapp_settings') }}"
                            class="nav-link d-flex align-items-center {{ request()->is('whatsapp_settings*') ? 'active' : '' }}">
                            <i class="fa-brands fa-whatsapp fs-5"></i>
                            <div class="w-100 d-flex justify-content-between">
                                <span data-i18n=""
                                    class="menu-title">{{ trans('labels.whatsapp_settings') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endif
                @if (@helper::checkaddons('telegram_message'))
                    <li class="nav-item mb-2 fs-7 d-block">
                        <a href="{{ URL::to('/telegram_settings') }}"
                            class="nav-link d-flex align-items-center {{ request()->is('telegram_settings*') ? 'active' : '' }}">
                            <i class="fa-brands fa-telegram fs-5"></i>
                            <div class="w-100 d-flex justify-content-between">
                                <span data-i18n=""
                                    class="menu-title">{{ trans('labels.telegram_settings') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endif
                @if (@helper::checkaddons('language'))
                    <li class="nav-item mb-2 fs-7
                        {{ Auth::user()->type != 1 ? (in_array('27', $modules) == true ? '' : 'd-none') : '' }}"
                        id="27">
                        <a class="nav-link rounded d-flex {{ request()->is('language-settings*') ? 'active' : '' }}"
                            href="{{ URL::to('/language-settings') }}" aria-expanded="false">
                            <i class="fa-solid fa-language"></i>
                            <div class="w-100 d-flex justify-content-between">
                                <span class="nav-text ">{{ trans('labels.language') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endif
                <li class="nav-item mb-2 fs-7">
                    <a class="nav-link collapsed
                    rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                        href="#currency_setting" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="currency_setting">
                        <span class="d-flex"><i class="fa-solid  fa-dollar-sign"></i><span
                                class="multimenu-title">{{ trans('labels.currency-settings') }}</span></span>
                    </a>
                    <ul class="collapse" id="currency_setting">
                        @if (@helper::checkaddons('currency_settigns'))
                            <li class="nav-item ps-4 mb-1">
                                <a class="nav-link rounded {{ request()->is('admin/currencys*') ? 'active' : '' }}"
                                    aria-current="page" href="{{ URL::to('/admin/currencys') }}">
                                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                            class="fa-solid fa-circle-small"></i>{{ trans('labels.currencys') }}</span>
                                    @if (env('Environment') == 'sendbox')
                                        <span
                                            class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                        <li class="nav-item ps-4 mb-1">
                            <a class="nav-link rounded {{ request()->is('admin/currency-settings*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/currency-settings') }}">
                                <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                        class="fa-solid fa-circle-small"></i>{{ trans('labels.currency-settings') }}</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/settings') }}"
                        class="nav-link d-flex {{ request()->is('settings*') ? 'active' : '' }}">
                        <i class="fa fa-cog"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.general_settings') }}</span>
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/clear-cache') }}"
                        class="nav-link d-flex {{ request()->is('clear-cache*') ? 'active' : '' }}">
                        <i class="fa-regular fa-arrows-rotate"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.clear_cache') }}</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->type == 2)
                <li class="nav-item my-2">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.employee_management') }}</h6>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/handymans') }}"
                        class="nav-link d-flex {{ request()->is('handymans*') ? 'active' : '' }}">
                        <i class="fa fa-users"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.handyman') }}</span>
                    </a>
                </li>
                <li class="nav-item my-2">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.product_management') }}</h6>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/services') }}"
                        class="nav-link d-flex {{ request()->is('services*') ? 'active' : '' }}">
                        <i class="ft-heart"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.services') }}</span>
                    </a>
                </li>
                @if (@helper::checkaddons('question_answer'))
                    <li class="nav-item mb-2 fs-7 d-block">
                        <a href="{{ URL::to('/admin/question_answer') }}"
                            class="nav-link d-flex {{ request()->is('admin/question_answer*') ? 'active' : '' }}">
                            <i class="fa-regular fa-question"></i>
                            <span data-i18n=""
                                class="menu-title">{{ trans('labels.service_question_answer') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                            @endif
                        </a>
                    </li>
                @endif
                <li class="nav-item my-2 ">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.booking_management') }}</h6>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/bookings') }}"
                        class="nav-link d-flex {{ request()->is('bookings*') ? 'active' : '' }}">
                        <i class="ft-calendar"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.bookings') }}</span>
                        @if (helper::booking() > 0)
                            <span
                                class="tag badge badge-pill badge-danger float-end {{ session()->get('direction') == 2 ? 'me-auto' : 'ms-auto' }}">{!! helper::booking() !!}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/reports') }}"
                        class="nav-link d-flex {{ request()->is('reports*') ? 'active' : '' }}">
                        <i class="ft-bar-chart-2"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.reports') }}</span>
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/tax') }}"
                        class="nav-link d-flex {{ request()->is('tax*') ? 'active' : '' }}">
                        <i class="fa-light fa-receipt"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.tax') }}</span>
                    </a>
                </li>
                <li class="nav-item my-2 ">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.business_management') }}</h6>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/payout') }}"
                        class="nav-link d-flex {{ request()->is('payout*') ? 'active' : '' }}">
                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                        <span class="menu-title">{{ trans('labels.payout_request') }}</span>
                        @if (helper::payout_request() > 0 && Auth::user()->type == 1)
                            <span
                                class="tag badge badge-pill badge-danger float-end  {{ session()->get('direction') == 2 ? 'me-auto' : 'ms-auto' }}">{!! helper::payout_request() !!}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/timings') }}"
                        class="nav-link d-flex {{ request()->is('timings*') ? 'active' : '' }}">
                        <i class="ft-clock"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.timing') }}</span>
                    </a>
                </li>
                @if (@helper::checkaddons('product_review'))
                    <li class="nav-item mb-2 fs-7 d-block">
                        <a href="{{ URL::to('/reviews') }}"
                            class="nav-link d-flex {{ request()->is('reviews*') ? 'active' : '' }}">
                            <i class="ft-star"></i>
                            <div class="w-100 d-flex justify-content-between">
                                <span data-i18n="" class="menu-title">{{ trans('labels.reviews') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endif
                @if (@helper::checkaddons('provider_calendar'))
                    <li class="nav-item mb-2 fs-7 d-block">
                        <a href="{{ URL::to('/calendar') }}"
                            class="nav-link d-flex {{ request()->is('calendar*') ? 'active' : '' }}">
                            <i class="ft-calendar"></i>
                            <div class="w-100 d-flex justify-content-between">
                                <span data-i18n="" class="menu-title">{{ trans('labels.calendar') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endif
                <li class="nav-item my-2 ">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.other') }}</h6>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="javascript:void(0);" onclick="clearnotification('{{ Auth::user()->id }}')"
                        class="nav-link d-flex {{ request()->is('notification*') ? 'active' : '' }}">
                        <i class="ft-bell"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.notifications') }}</span>
                        @if (helper::notification() > 0)
                            <span
                                class="tag notification badge badge-pill badge-danger float-end ms-auto">{!! helper::notification() !!}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/profile-settings') }}"
                        class="nav-link d-flex {{ request()->is('profile*') ? 'active' : '' }}">
                        <i class="fa fa-cog"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.general_settings') }}</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->type == 3)
                <li class="nav-item my-2 ">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.booking_management') }}</h6>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/bookings') }}"
                        class="nav-link d-flex {{ request()->is('bookings*') ? 'active' : '' }}">
                        <i class="ft-calendar"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.bookings') }}</span>
                        @if (helper::booking() > 0)
                            <span
                                class="tag badge badge-pill badge-danger float-end {{ session()->get('direction') == 2 ? 'me-auto' : 'ms-auto' }}">{!! helper::booking() !!}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/reports') }}"
                        class="nav-link d-flex {{ request()->is('reports*') ? 'active' : '' }}">
                        <i class="ft-bar-chart-2"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.reports') }}</span>
                    </a>
                </li>
                <li class="nav-item my-2 ">
                    <h6 class="text-muted fs-7 ">{{ trans('labels.other') }}</h6>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="javascript:void(0);" onclick="clearnotification('{{ Auth::user()->id }}')"
                        class="nav-link d-flex {{ request()->is('notification*') ? 'active' : '' }}">
                        <i class="ft-bell"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.notifications') }}</span>
                        @if (helper::notification() > 0)
                            <span
                                class="tag notification badge badge-pill badge-danger float-end ms-auto">{!! helper::notification() !!}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item mb-2 fs-7 d-block">
                    <a href="{{ URL::to('/profile-settings') }}"
                        class="nav-link d-flex {{ request()->is('profile*') ? 'active' : '' }}">
                        <i class="fa fa-cog"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.general_settings') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
<!-- / main menu-->
