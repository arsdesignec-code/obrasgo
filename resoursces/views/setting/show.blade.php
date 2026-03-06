@extends('layout.main')
@section('page_title', trans('labels.settings'))
@section('content')
    <h5 class="content-header mb-3 fs-4 fw-600">
        {{ trans('labels.general_settings') }}</h5>
    <div class="row settings g-3">
        <div class="col-xl-3">
            <div class="card card-sticky-top border-0">
                <div class="card-body p-0">
                    <ul class="list-group list-options">
                        <a href="#basicinfo" data-tab="basicinfo"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center active"
                            aria-current="true">{{ trans('labels.basic_info') }}<i
                                class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                        </a>
                        <a href="#admin_info" data-tab="admin_info"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.admin_info') }}<i
                                class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                        </a>
                        <a href="#change_password" data-tab="change_password"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.change_password') }} <i
                                class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                        </a>
                        <a href="#seo" data-tab="seo"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.seo') }} <i
                                class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                        </a>
                        <a href="#socialaccounts" data-tab="socialaccounts"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.social_accounts') }} <i
                                class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                        </a>
                        <a href="#footer_features" data-tab="footer_features"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.footer_feature') }} <i
                                class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                        </a>
                        @if (@helper::checkaddons('top_deals'))
                            <a href="#top_deals" data-tab="top_deals"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.top_deals') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('pwa'))
                            <a href="#pwa" data-tab="pwa"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.pwa') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('email_settings'))
                            <a href="#email_settings" data-tab="email_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.email_settings') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                            <a href="#email_template" data-tab="email_template"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.email_template') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('cookie'))
                            <a href="#cookie" data-tab="cookie"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.cookie') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('tawk_addons'))
                            <a href="#tawk_settings" data-tab="tawk_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.tawk_settings') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('wizz_chat'))
                            <a href="#wizz_chat_settings" data-tab="wizz_chat_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.wizz_chat_settings') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('google_calendar'))
                            <a href="#google_calendar" data-tab="google_calendar"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.google_calendar') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('recaptcha'))
                            <a href="#recaptcha_settings" data-tab="recaptcha_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.google_recaptcha') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('google_login'))
                            <a href="#google_login_settings" data-tab="google_login_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.google_login') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('facebook_login'))
                            <a href="#facebook_login_settings" data-tab="facebook_login_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.facebook_login') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('trusted_badges'))
                            <a href="#trusted_badges" data-tab="trusted_badges"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.trusted_badges') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('safe_secure_checkout'))
                            <a href="#safe_secure" data-tab="safe_secure"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.safe_secure') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        <a href="#admin_color_setting" data-tab="admin_color_setting"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.admin_color_setting') }} <i
                                class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                        </a>
                        @if (@helper::checkaddons('product_review'))
                            <a href="#review_settings" data-tab="review_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.review_settings') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('quick_call'))
                            <a href="#quick_call" data-tab="quick_call"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.quick_call') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        <a href="#web_color_setting" data-tab="web_color_setting"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.web_color_setting') }} <i
                                class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                        </a>
                        @if (@helper::checkaddons('service_card_layout'))
                            <a href="#service_card_view" data-tab="service_card_view"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.service_card_view') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('vendor_tip'))
                            <a href="#tips_settings" data-tab="tips_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                {{ trans('labels.tips_settings') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('sales_notification'))
                            <a href="#sales_notification" data-tab="sales_notification"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.fake_sales_notification') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('fake_view'))
                            <a href="#product_fake_view" data-tab="product_fake_view"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.product_fake_view') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                        @if (@helper::checkaddons('age_verification'))
                            <a href="#age_verification" data-tab="age_verification"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.age_verification') }}
                                <div class="d-flex gap-2">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </div>
                            </a>
                        @endif
                         @if (@helper::checkaddons('recent_view_service'))
                         <a href="#recent_view_service" data-tab="recent_view_service"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.recent_view_service') }}
                            <div class="d-flex align-items-center gap-1">
                                <i
                                    class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                            </div>
                        </a>
                         @endif
                        <a href="#maintenance_modes" data-tab="maintenance_modes"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.maintenance_mode') }}
                            <div class="d-flex align-items-center gap-1">
                                <i
                                    class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                            </div>
                        </a>
                        <a href="#notice_mode" data-tab="notice_mode"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.notice') }}
                            <div class="d-flex align-items-center gap-1">
                                <i
                                    class="fa-regular fa-angle-{{ session()->get('direction') == '2' ? 'left' : 'right' }}"></i>
                            </div>
                        </a>
                        <a href="#others" data-tab="others"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.other') }} <i
                                class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div id="settingmenuContent">
                <div id="basicinfo">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="form-section d-flex gap-2 align-items-center text-capitalize">
                                        {{ trans('labels.basic_info') }}
                                    </h5>
                                </div>
                                <form action="{{ URL::to('settings/edit') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="booking_prefix_number">{{ trans('labels.booking_prefix') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" id="booking_prefix_number"
                                                            class="form-control" name="booking_prefix"
                                                            value="{{ $settingdata->booking_prefix }}"
                                                            placeholder="{{ trans('labels.enter_booking_prefix') }}"
                                                            required>
                                                    </div>
                                                </div>
                                                @if (count($booking) == 0)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="booking_number_start">{{ trans('labels.booking_number_start') }}
                                                                <span class="text-danger">*</span></label>
                                                            <input type="text" id="booking_number_start"
                                                                class="form-control" name="booking_number_start"
                                                                value="{{ $settingdata->booking_number_start }}"
                                                                placeholder="{{ trans('labels.enter_booking_number_start') }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="referral_amount">{{ trans('labels.referral_amount') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" id="edit_referral_amount"
                                                            class="form-control" name="referral_amount"
                                                            value="{{ $settingdata->referral_amount }}"
                                                            placeholder="{{ trans('labels.enter_referral_amount') }}"
                                                            required>
                                                    </div>
                                                </div>
                                                @if (@helper::checkaddons('customer_login'))
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="checkbox-switch-login_required">{{ trans('labels.customer_login_required') }}
                                                                        <span class="text-danger">*</span></label>
                                                                    <input id="checkbox-switch-login_required"
                                                                        type="checkbox" class="checkbox-switch"
                                                                        name="login_required" value="1"
                                                                        {{ @$settingdata->login_required == 1 ? 'checked' : '' }}>
                                                                    <label for="checkbox-switch-login_required"
                                                                        class="switch">
                                                                        <span
                                                                            class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}">
                                                                            <span
                                                                                class="switch__circle-inner"></span></span>
                                                                        <span
                                                                            class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                                        <span
                                                                            class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group {{ $settingdata->login_required == 1 ? '' : 'd-none' }}"
                                                                    id="is_checkout_login_required">
                                                                    <label class="form-label"
                                                                        for="checkbox-switch-is_checkout_login_required">{{ trans('labels.is_checkout_login_required') }}
                                                                        <span class="text-danger">*</span></label>
                                                                    <input id="checkbox-switch-is_checkout_login_required"
                                                                        type="checkbox" class="checkbox-switch"
                                                                        name="is_checkout_login_required" value="1"
                                                                        {{ @$settingdata->is_checkout_login_required == 1 ? 'checked' : '' }}>
                                                                    <label for="checkbox-switch-is_checkout_login_required"
                                                                        class="switch">
                                                                        <span
                                                                            class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}">
                                                                            <span
                                                                                class="switch__circle-inner"></span></span>
                                                                        <span
                                                                            class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                                        <span
                                                                            class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-6">
                                                    <div class="row">
                                                       
                                                        <div class="col-md-6">
                                                            <div class="form-group" id="provider_registration">
                                                                <label class="form-label"
                                                                    for="checkbox-switch-provider_registration">{{ trans('labels.provider_registration') }}
                                                                    <span class="text-danger">*</span></label>
                                                                <input id="checkbox-switch-provider_registration"
                                                                    type="checkbox" class="checkbox-switch"
                                                                    name="provider_registration" value="1"
                                                                    {{ @$settingdata->provider_registration == 1 ? 'checked' : '' }}>
                                                                <label for="checkbox-switch-provider_registration"
                                                                    class="switch">
                                                                    <span
                                                                        class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}">
                                                                        <span class="switch__circle-inner"></span></span>
                                                                    <span
                                                                        class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                                    <span
                                                                        class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="form-label"
                                                        for="">{{ trans('labels.time_format') }}
                                                    </label>
                                                    <select class="form-select" name="time_format">
                                                        <option value="2"
                                                            {{ $settingdata->time_format == 2 ? 'selected' : '' }}>12
                                                            {{ trans('labels.hour') }}
                                                        </option>
                                                        <option value="1"
                                                            {{ $settingdata->time_format == 1 ? 'selected' : '' }}>24
                                                            {{ trans('labels.hour') }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="form-label"
                                                        for="">{{ trans('labels.date_format') }}
                                                    </label>

                                                    <select class="form-select" name="date_format">
                                                        <option value="d M, Y"
                                                            {{ $settingdata->date_format == 'd M, Y' ? 'selected' : '' }}>
                                                            dd
                                                            MMM, yyyy</option>
                                                        <option value="M d, Y"
                                                            {{ $settingdata->date_format == 'M d, Y' ? 'selected' : '' }}>
                                                            MMM
                                                            dd, yyyy</option>
                                                        <option value="d-m-Y"
                                                            {{ $settingdata->date_format == 'd-m-Y' ? 'selected' : '' }}>
                                                            dd-MM-yyyy</option>
                                                        <option value="m-d-Y"
                                                            {{ $settingdata->date_format == 'm-d-Y' ? 'selected' : '' }}>
                                                            MM-dd-yyyy</option>
                                                        <option value="d/m/Y"
                                                            {{ $settingdata->date_format == 'd/m/Y' ? 'selected' : '' }}>
                                                            dd/MM/yyyy</option>
                                                        <option value="m/d/Y"
                                                            {{ $settingdata->date_format == 'm/d/Y' ? 'selected' : '' }}>
                                                            MM/dd/yyyy</option>
                                                        <option value="Y/m/d"
                                                            {{ $settingdata->date_format == 'Y/m/d' ? 'selected' : '' }}>
                                                            yyyy/MM/dd</option>
                                                        <option value="Y-m-d"
                                                            {{ $settingdata->date_format == 'Y-m-d' ? 'selected' : '' }}>
                                                            yyyy-MM-dd</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="withdrawable_amount">{{ trans('labels.withdrawable_amount') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" id="edit_withdrawable_amount"
                                                            class="form-control" name="withdrawable_amount"
                                                            value="{{ $settingdata->withdrawable_amount }}"
                                                            placeholder="{{ trans('labels.enter_withdrawable_amount') }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="timezone">{{ trans('labels.timezone') }}
                                                            <span class="text-danger">*</span></label>
                                                        <select class="form-control selectpicker" name="timezone" required
                                                            id="timezone" data-live-search="true">
                                                            <option value="Pacific/Midway"
                                                                {{ $settingdata->timezone == 'Pacific/Midway' ? 'selected' : '' }}>
                                                                (GMT-11:00) Midway Island, Samoa</option>
                                                            <option value="America/Adak"
                                                                {{ $settingdata->timezone == 'America/Adak' ? 'selected' : '' }}>
                                                                (GMT-10:00) Hawaii-Aleutian</option>
                                                            <option value="Etc/GMT+10"
                                                                {{ $settingdata->timezone == 'Etc/GMT+10' ? 'selected' : '' }}>
                                                                (GMT-10:00) Hawaii</option>
                                                            <option value="Pacific/Marquesas"
                                                                {{ $settingdata->timezone == 'Pacific/Marquesas' ? 'selected' : '' }}>
                                                                (GMT-09:30) Marquesas Islands</option>
                                                            <option value="Pacific/Gambier"
                                                                {{ $settingdata->timezone == 'Pacific/Gambier' ? 'selected' : '' }}>
                                                                (GMT-09:00) Gambier Islands</option>
                                                            <option value="America/Anchorage"
                                                                {{ $settingdata->timezone == 'America/Anchorage' ? 'selected' : '' }}>
                                                                (GMT-09:00) Alaska</option>
                                                            <option value="America/Ensenada"
                                                                {{ $settingdata->timezone == 'America/Ensenada' ? 'selected' : '' }}>
                                                                (GMT-08:00) Tijuana, Baja California</option>
                                                            <option value="Etc/GMT+8"
                                                                {{ $settingdata->timezone == 'Etc/GMT+8' ? 'selected' : '' }}>
                                                                (GMT-08:00) Pitcairn Islands</option>
                                                            <option value="America/Los_Angeles"
                                                                {{ $settingdata->timezone == 'America/Los_Angeles' ? 'selected' : '' }}>
                                                                (GMT-08:00) Pacific Time (US & Canada)</option>
                                                            <option value="America/Denver"
                                                                {{ $settingdata->timezone == 'America/Denver' ? 'selected' : '' }}>
                                                                (GMT-07:00) Mountain Time (US & Canada)</option>
                                                            <option value="America/Chihuahua"
                                                                {{ $settingdata->timezone == 'America/Chihuahua' ? 'selected' : '' }}>
                                                                (GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                                            <option value="America/Dawson_Creek"
                                                                {{ $settingdata->timezone == 'America/Dawson_Creek' ? 'selected' : '' }}>
                                                                (GMT-07:00) Arizona</option>
                                                            <option value="America/Belize"
                                                                {{ $settingdata->timezone == 'America/Belize' ? 'selected' : '' }}>
                                                                (GMT-06:00) Saskatchewan, Central America</option>
                                                            <option value="America/Cancun"
                                                                {{ $settingdata->timezone == 'America/Cancun' ? 'selected' : '' }}>
                                                                (GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                                            <option value="Chile/EasterIsland"
                                                                {{ $settingdata->timezone == 'Chile/EasterIsland' ? 'selected' : '' }}>
                                                                (GMT-06:00) Easter Island</option>
                                                            <option value="America/Chicago"
                                                                {{ $settingdata->timezone == 'America/Chicago' ? 'selected' : '' }}>
                                                                (GMT-06:00) Central Time (US & Canada)</option>
                                                            <option value="America/New_York"
                                                                {{ $settingdata->timezone == 'America/New_York' ? 'selected' : '' }}>
                                                                (GMT-05:00) Eastern Time (US & Canada)</option>
                                                            <option value="America/Havana"
                                                                {{ $settingdata->timezone == 'America/Havana' ? 'selected' : '' }}>
                                                                (GMT-05:00) Cuba</option>
                                                            <option value="America/Bogota"
                                                                {{ $settingdata->timezone == 'America/Bogota' ? 'selected' : '' }}>
                                                                (GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                                            <option value="America/Caracas"
                                                                {{ $settingdata->timezone == 'America/Caracas' ? 'selected' : '' }}>
                                                                (GMT-04:30) Caracas</option>
                                                            <option value="America/Santiago"
                                                                {{ $settingdata->timezone == 'America/Santiago' ? 'selected' : '' }}>
                                                                (GMT-04:00) Santiago</option>
                                                            <option value="America/La_Paz"
                                                                {{ $settingdata->timezone == 'America/La_Paz' ? 'selected' : '' }}>
                                                                (GMT-04:00) La Paz</option>
                                                            <option value="Atlantic/Stanley"
                                                                {{ $settingdata->timezone == 'Atlantic/Stanley' ? 'selected' : '' }}>
                                                                (GMT-04:00) Faukland Islands</option>
                                                            <option value="America/Campo_Grande"
                                                                {{ $settingdata->timezone == 'America/Campo_Grande' ? 'selected' : '' }}>
                                                                (GMT-04:00) Brazil</option>
                                                            <option value="America/Goose_Bay"
                                                                {{ $settingdata->timezone == 'America/Goose_Bay' ? 'selected' : '' }}>
                                                                (GMT-04:00) Atlantic Time (Goose Bay)</option>
                                                            <option value="America/Glace_Bay"
                                                                {{ $settingdata->timezone == 'America/Glace_Bay' ? 'selected' : '' }}>
                                                                (GMT-04:00) Atlantic Time (Canada)</option>
                                                            <option value="America/St_Johns"
                                                                {{ $settingdata->timezone == 'America/St_Johns' ? 'selected' : '' }}>
                                                                (GMT-03:30) Newfoundland</option>
                                                            <option value="America/Araguaina"
                                                                {{ $settingdata->timezone == 'America/Araguaina' ? 'selected' : '' }}>
                                                                (GMT-03:00) UTC-3</option>
                                                            <option value="America/Montevideo"
                                                                {{ $settingdata->timezone == 'America/Montevideo' ? 'selected' : '' }}>
                                                                (GMT-03:00) Montevideo</option>
                                                            <option value="America/Miquelon"
                                                                {{ $settingdata->timezone == 'America/Miquelon' ? 'selected' : '' }}>
                                                                (GMT-03:00) Miquelon, St. Pierre</option>
                                                            <option value="America/Godthab"
                                                                {{ $settingdata->timezone == 'America/Godthab' ? 'selected' : '' }}>
                                                                (GMT-03:00) Greenland</option>
                                                            <option value="America/Argentina/Buenos_Aires"
                                                                {{ $settingdata->timezone == 'America/Argentina/Buenos_Aires' ? 'selected' : '' }}>
                                                                (GMT-03:00) Buenos Aires</option>
                                                            <option value="America/Sao_Paulo"
                                                                {{ $settingdata->timezone == 'America/Sao_Paulo' ? 'selected' : '' }}>
                                                                (GMT-03:00) Brasilia</option>
                                                            <option value="America/Noronha"
                                                                {{ $settingdata->timezone == 'America/Noronha' ? 'selected' : '' }}>
                                                                (GMT-02:00) Mid-Atlantic</option>
                                                            <option value="Atlantic/Cape_Verde"
                                                                {{ $settingdata->timezone == 'Atlantic/Cape_Verde' ? 'selected' : '' }}>
                                                                (GMT-01:00) Cape Verde Is.</option>
                                                            <option value="Atlantic/Azores"
                                                                {{ $settingdata->timezone == 'Atlantic/Azores' ? 'selected' : '' }}>
                                                                (GMT-01:00) Azores</option>
                                                            <option value="Europe/Belfast"
                                                                {{ $settingdata->timezone == 'Europe/Belfast' ? 'selected' : '' }}>
                                                                (GMT) Greenwich Mean Time : Belfast</option>
                                                            <option value="Europe/Dublin"
                                                                {{ $settingdata->timezone == 'Europe/Dublin' ? 'selected' : '' }}>
                                                                (GMT) Greenwich Mean Time : Dublin</option>
                                                            <option value="Europe/Lisbon"
                                                                {{ $settingdata->timezone == 'Europe/Lisbon' ? 'selected' : '' }}>
                                                                (GMT) Greenwich Mean Time : Lisbon</option>
                                                            <option value="Europe/London"
                                                                {{ $settingdata->timezone == 'Europe/London' ? 'selected' : '' }}>
                                                                (GMT) Greenwich Mean Time : London</option>
                                                            <option value="Africa/Abidjan"
                                                                {{ $settingdata->timezone == 'Africa/Abidjan' ? 'selected' : '' }}>
                                                                (GMT) Monrovia, Reykjavik</option>
                                                            <option value="Europe/Amsterdam"
                                                                {{ $settingdata->timezone == 'Europe/Amsterdam' ? 'selected' : '' }}>
                                                                (GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna
                                                            </option>
                                                            <option value="Europe/Belgrade"
                                                                {{ $settingdata->timezone == 'Europe/Belgrade' ? 'selected' : '' }}>
                                                                (GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana,
                                                                Prague
                                                            </option>
                                                            <option value="Europe/Brussels"
                                                                {{ $settingdata->timezone == 'Europe/Brussels' ? 'selected' : '' }}>
                                                                (GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                                            <option value="Africa/Algiers"
                                                                {{ $settingdata->timezone == 'Africa/Algiers' ? 'selected' : '' }}>
                                                                (GMT+01:00) West Central Africa</option>
                                                            <option value="Africa/Windhoek"
                                                                {{ $settingdata->timezone == 'Africa/Windhoek' ? 'selected' : '' }}>
                                                                (GMT+01:00) Windhoek</option>
                                                            <option value="Asia/Beirut"
                                                                {{ $settingdata->timezone == 'Asia/Beirut' ? 'selected' : '' }}>
                                                                (GMT+02:00) Beirut</option>
                                                            <option value="Africa/Cairo"
                                                                {{ $settingdata->timezone == 'Africa/Cairo' ? 'selected' : '' }}>
                                                                (GMT+02:00) Cairo</option>
                                                            <option value="Asia/Gaza"
                                                                {{ $settingdata->timezone == 'Asia/Gaza' ? 'selected' : '' }}>
                                                                (GMT+02:00) Gaza</option>
                                                            <option value="Africa/Blantyre"
                                                                {{ $settingdata->timezone == 'Africa/Blantyre' ? 'selected' : '' }}>
                                                                (GMT+02:00) Harare, Pretoria</option>
                                                            <option value="Asia/Jerusalem"
                                                                {{ $settingdata->timezone == 'Asia/Jerusalem' ? 'selected' : '' }}>
                                                                (GMT+02:00) Jerusalem</option>
                                                            <option value="Europe/Minsk"
                                                                {{ $settingdata->timezone == 'Europe/Minsk' ? 'selected' : '' }}>
                                                                (GMT+02:00) Minsk</option>
                                                            <option value="Asia/Damascus"
                                                                {{ $settingdata->timezone == 'Asia/Damascus' ? 'selected' : '' }}>
                                                                (GMT+02:00) Syria</option>
                                                            <option value="Europe/Moscow"
                                                                {{ $settingdata->timezone == 'Europe/Moscow' ? 'selected' : '' }}>
                                                                (GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                                            <option value="Africa/Addis_Ababa"
                                                                {{ $settingdata->timezone == 'Africa/Addis_Ababa' ? 'selected' : '' }}>
                                                                (GMT+03:00) Nairobi</option>
                                                            <option value="Asia/Tehran"
                                                                {{ $settingdata->timezone == 'Asia/Tehran' ? 'selected' : '' }}>
                                                                (GMT+03:30) Tehran</option>
                                                            <option value="Asia/Dubai"
                                                                {{ $settingdata->timezone == 'Asia/Dubai' ? 'selected' : '' }}>
                                                                (GMT+04:00) Abu Dhabi, Muscat</option>
                                                            <option value="Asia/Yerevan"
                                                                {{ $settingdata->timezone == 'Asia/Yerevan' ? 'selected' : '' }}>
                                                                (GMT+04:00) Yerevan</option>
                                                            <option value="Asia/Kabul"
                                                                {{ $settingdata->timezone == 'Asia/Kabul' ? 'selected' : '' }}>
                                                                (GMT+04:30) Kabul</option>
                                                            <option value="Asia/Yekaterinburg"
                                                                {{ $settingdata->timezone == 'Asia/Yekaterinburg' ? 'selected' : '' }}>
                                                                (GMT+05:00) Ekaterinburg</option>
                                                            <option value="Asia/Tashkent"
                                                                {{ $settingdata->timezone == 'Asia/Tashkent' ? 'selected' : '' }}>
                                                                (GMT+05:00) Tashkent</option>
                                                            <option value="Asia/Kolkata"
                                                                {{ $settingdata->timezone == 'Asia/Kolkata' ? 'selected' : '' }}>
                                                                (GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                                            <option value="Asia/Katmandu"
                                                                {{ $settingdata->timezone == 'Asia/Katmandu' ? 'selected' : '' }}>
                                                                (GMT+05:45) Kathmandu</option>
                                                            <option value="Asia/Dhaka"
                                                                {{ $settingdata->timezone == 'Asia/Dhaka' ? 'selected' : '' }}>
                                                                (GMT+06:00) Astana, Dhaka</option>
                                                            <option value="Asia/Novosibirsk"
                                                                {{ $settingdata->timezone == 'Asia/Novosibirsk' ? 'selected' : '' }}>
                                                                (GMT+06:00) Novosibirsk</option>
                                                            <option value="Asia/Rangoon"
                                                                {{ $settingdata->timezone == 'Asia/Rangoon' ? 'selected' : '' }}>
                                                                (GMT+06:30) Yangon (Rangoon)</option>
                                                            <option value="Asia/Bangkok"
                                                                {{ $settingdata->timezone == 'Asia/Bangkok' ? 'selected' : '' }}>
                                                                (GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                                            <option value="Asia/Kuala_Lumpur"
                                                                {{ $settingdata->timezone == 'Asia/Kuala_Lumpur' ? 'selected' : '' }}>
                                                                (GMT+08:00) Kuala Lumpur</option>
                                                            <option value="Asia/Krasnoyarsk"
                                                                {{ $settingdata->timezone == 'Asia/Krasnoyarsk' ? 'selected' : '' }}>
                                                                (GMT+07:00) Krasnoyarsk</option>
                                                            <option value="Asia/Hong_Kong"
                                                                {{ $settingdata->timezone == 'Asia/Hong_Kong' ? 'selected' : '' }}>
                                                                (GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                                            <option value="Asia/Irkutsk"
                                                                {{ $settingdata->timezone == 'Asia/Irkutsk' ? 'selected' : '' }}>
                                                                (GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                                            <option value="Australia/Perth"
                                                                {{ $settingdata->timezone == 'Australia/Perth' ? 'selected' : '' }}>
                                                                (GMT+08:00) Perth</option>
                                                            <option value="Australia/Eucla"
                                                                {{ $settingdata->timezone == 'Australia/Eucla' ? 'selected' : '' }}>
                                                                (GMT+08:45) Eucla</option>
                                                            <option value="Asia/Tokyo"
                                                                {{ $settingdata->timezone == 'Asia/Tokyo' ? 'selected' : '' }}>
                                                                (GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                                            <option value="Asia/Seoul"
                                                                {{ $settingdata->timezone == 'Asia/Seoul' ? 'selected' : '' }}>
                                                                (GMT+09:00) Seoul</option>
                                                            <option value="Asia/Yakutsk"
                                                                {{ $settingdata->timezone == 'Asia/Yakutsk' ? 'selected' : '' }}>
                                                                (GMT+09:00) Yakutsk</option>
                                                            <option value="Australia/Adelaide"
                                                                {{ $settingdata->timezone == 'Australia/Adelaide' ? 'selected' : '' }}>
                                                                (GMT+09:30) Adelaide</option>
                                                            <option value="Australia/Darwin"
                                                                {{ $settingdata->timezone == 'Australia/Darwin' ? 'selected' : '' }}>
                                                                (GMT+09:30) Darwin</option>
                                                            <option value="Australia/Brisbane"
                                                                {{ $settingdata->timezone == 'Australia/Brisbane' ? 'selected' : '' }}>
                                                                (GMT+10:00) Brisbane</option>
                                                            <option value="Australia/Hobart"
                                                                {{ $settingdata->timezone == 'Australia/Hobart' ? 'selected' : '' }}>
                                                                (GMT+10:00) Hobart</option>
                                                            <option value="Asia/Vladivostok"
                                                                {{ $settingdata->timezone == 'Asia/Vladivostok' ? 'selected' : '' }}>
                                                                (GMT+10:00) Vladivostok</option>
                                                            <option value="Australia/Lord_Howe"
                                                                {{ $settingdata->timezone == 'Australia/Lord_Howe' ? 'selected' : '' }}>
                                                                (GMT+10:30) Lord Howe Island</option>
                                                            <option value="Etc/GMT-11"
                                                                {{ $settingdata->timezone == 'Etc/GMT-11' ? 'selected' : '' }}>
                                                                (GMT+11:00) Solomon Is., New Caledonia</option>
                                                            <option value="Asia/Magadan"
                                                                {{ $settingdata->timezone == 'Asia/Magadan' ? 'selected' : '' }}>
                                                                (GMT+11:00) Magadan</option>
                                                            <option value="Pacific/Norfolk"
                                                                {{ $settingdata->timezone == 'Pacific/Norfolk' ? 'selected' : '' }}>
                                                                (GMT+11:30) Norfolk Island</option>
                                                            <option value="Asia/Anadyr"
                                                                {{ $settingdata->timezone == 'Asia/Anadyr' ? 'selected' : '' }}>
                                                                (GMT+12:00) Anadyr, Kamchatka</option>
                                                            <option value="Pacific/Auckland"
                                                                {{ $settingdata->timezone == 'Pacific/Auckland' ? 'selected' : '' }}>
                                                                (GMT+12:00) Auckland, Wellington</option>
                                                            <option value="Etc/GMT-12"
                                                                {{ $settingdata->timezone == 'Etc/GMT-12' ? 'selected' : '' }}>
                                                                (GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                                            <option value="Pacific/Chatham"
                                                                {{ $settingdata->timezone == 'Pacific/Chatham' ? 'selected' : '' }}>
                                                                (GMT+12:45) Chatham Islands</option>
                                                            <option value="Pacific/Tongatapu"
                                                                {{ $settingdata->timezone == 'Pacific/Tongatapu' ? 'selected' : '' }}>
                                                                (GMT+13:00) Nuku'alofa</option>
                                                            <option value="Pacific/Kiritimati"
                                                                {{ $settingdata->timezone == 'Pacific/Kiritimati' ? 'selected' : '' }}>
                                                                (GMT+14:00) Kiritimati</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="address">{{ trans('labels.address') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" name="address" class="form-control"
                                                            placeholder="{{ trans('labels.address') }}"
                                                            value="{{ $settingdata->address }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="contact">{{ trans('labels.contact') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" name="contact" class="form-control"
                                                            placeholder="{{ trans('labels.contact') }}"
                                                            value="{{ $settingdata->contact }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="email">{{ trans('labels.email') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="email" name="email" class="form-control"
                                                            placeholder="{{ trans('labels.enter_email') }}"
                                                            value="{{ $settingdata->email }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="website_title">{{ trans('labels.website_title') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" name="website_title" class="form-control"
                                                            placeholder="{{ trans('labels.enter_website_title') }}"
                                                            value="{{ $settingdata->website_title }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="logo">{{ trans('labels.logo') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="file" id="edit_logo" class="form-control"
                                                            name="logo" value="{{ old('logo') }}">
                                                        <img src="{{ helper::image_path($settingdata->logo) }}"
                                                            alt="{{ trans('labels.logo') }}"
                                                            class="rounded media-object round-media setting-profile mt-2"
                                                            height="50px">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="dark_logo">{{ trans('labels.dark_logo') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="file" id="edit_logo" class="form-control"
                                                            name="dark_logo" value="{{ old('dark_logo') }}">
                                                        <img src="{{ helper::image_path($settingdata->dark_logo) }}"
                                                            alt="{{ trans('labels.dark_logo') }}"
                                                            class="rounded media-object round-media setting-profile mt-2"
                                                            height="50px">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="favicon">{{ trans('labels.favicon') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="file" id="edit_favicon" class="form-control"
                                                            name="favicon" value="{{ old('favicon') }}">
                                                        <img src="{{ helper::image_path($settingdata->favicon) }}"
                                                            alt="{{ trans('labels.favicon') }}"
                                                            class="rounded media-object round-media border setting-profile mt-2 hw-50">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="copyright">{{ trans('labels.copyright') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" name="copyright" class="form-control"
                                                            placeholder="{{ trans('labels.enter_copyright') }}"
                                                            value="{{ $settingdata->copyright }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                                @if (env('Environment') == 'sendbox')
                                                    <button type="button"
                                                        class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                                    </button>
                                                @else
                                                    <button type="submit" name="basic_info_update" value="1"
                                                        class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="admin_info">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-header rounded-top bg-secondary text-white">
                                    <h5 class="form-section">
                                        {{ trans('labels.admin_info') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form class="form" action="{{ URL::to('/profile/edit/' . Auth::user()->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="name">{{ trans('labels.fullname') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" id="name"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            placeholder="{{ trans('labels.enter_full_name') }}"
                                                            name="name" value="{{ Auth::user()->name }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="email">{{ trans('labels.email') }}</label>
                                                        <input type="text" id="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            placeholder="{{ trans('labels.enter_email') }}"
                                                            name="email" value="{{ Auth::user()->email }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="mobile">{{ trans('labels.mobile') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="{{ trans('labels.enter_mobile') }}"
                                                            name="mobile" id="mobile"
                                                            value="{{ Auth::user()->mobile }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="form-label">{{ trans('labels.profileimage') }}</label>
                                                        <input class="form-control @error('image') is-invalid @enderror"
                                                            type="file" name="image" id="image">
                                                        <div class="mt-2">
                                                            <img src="{{ helper::image_path(Auth::user()->image) }}"
                                                                alt="profile-image"
                                                                class='rounded media-object border round-media setting-profile hw-50'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                            @if (env('Environment') == 'sendbox')
                                                <button type="button" onclick="myFunction()"
                                                    class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                            @else
                                                <button type="submit" name="profile_data_update" value="1"
                                                    class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="change_password">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-header rounded-top bg-secondary text-white">
                                    <h5 class="form-section">
                                        {{ trans('labels.change_password') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form class="form" id="change_password_form"
                                        action="{{ URL::to('/profile/edit/password/' . Auth::user()->id) }}"
                                        method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="old_password">
                                                    {{ trans('labels.old_password') }}
                                                    <span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="password" name="old_password" id="old_password"
                                                        class="form-control"
                                                        placeholder="{{ trans('labels.enter_old_pass') }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="new_password">
                                                    {{ trans('labels.new_password') }}
                                                    <span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="password" name="new_password" id="new_password"
                                                        class="form-control"
                                                        placeholder="{{ trans('labels.enter_new_pass') }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="c_new_password">
                                                    {{ trans('labels.confirm_password') }}
                                                    <span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input type="password" name="c_new_password" id="c_new_password"
                                                        class="form-control"
                                                        placeholder="{{ trans('labels.enter_confirm_pass') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                            @if (env('Environment') == 'sendbox')
                                                <button type="button" onclick="myFunction()"
                                                    class="btn btn-primary px-sm-4">
                                                    {{ trans('labels.save') }} </button>
                                            @else
                                                <input type="submit" id="btn_update_password"
                                                    class="btn btn-primary px-sm-4" value="{{ trans('labels.save') }}">
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="seo">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="form-section d-flex gap-2 align-items-center text-capitalize">
                                        {{ trans('labels.seo') }}
                                    </h5>
                                </div>
                                <form action="{{ URL::to('settings/edit') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="meta_title">{{ trans('labels.meta_title') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="meta_title" class="form-control"
                                                        placeholder="{{ trans('labels.enter_meta_title') }}"
                                                        value="{{ $settingdata->meta_title }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="meta_description">{{ trans('labels.meta_description') }}
                                                        <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="meta_description" placeholder="{{ trans('labels.enter_meta_description') }}">{{ $settingdata->meta_description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="og_image">{{ trans('labels.og_image') }}</label>
                                                    <input type="file" id="og_image" class="form-control"
                                                        name="og_image" value="{{ old('og_image') }}">
                                                    <img src="{{ helper::image_path($settingdata->og_image) }}"
                                                        alt="{{ trans('labels.og_image') }}"
                                                        class="rounded media-object round-media setting-profile mt-2 hw-70">
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                            @if (env('Environment') == 'sendbox')
                                                <button type="button"
                                                    class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                                </button>
                                            @else
                                                <button type="submit" name="seo_update" value="1"
                                                    class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="socialaccounts">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-header p-3 bg-secondary text-white">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="form-section d-flex gap-2 align-items-center">
                                            {{ trans('labels.social_links') }}
                                            <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                                aria-label="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info"
                                                data-bs-original-title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </span>
                                        </h5>
                                        @if (!empty($getsociallinks) && count($getsociallinks) > 0)
                                            <button class="btn btn-primary " type="button"
                                                onclick="add_social_links('{{ trans('labels.icon') }}','{{ trans('labels.link') }}')">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ URL::to('settings/social_links') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @forelse ($getsociallinks as $key => $links)
                                            <div class="row">
                                                <input type="hidden" name="edit_icon_key[]"
                                                    value="{{ $links->id }}">
                                                <div class="col-md-6 form-group">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control soaciallink_required  {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                                            onkeyup="show_feature_icon(this)"
                                                            name="edi_sociallink_icon[{{ $links->id }}]"
                                                            placeholder="{{ trans('labels.icon') }}"
                                                            value="{{ $links->icon }}" required>
                                                        <p
                                                            class="input-group-text {{ session()->get('direction') == 2 ? 'input-group-icon-rtl' : '' }}">
                                                            {!! $links->icon !!}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 d-flex align-items-center gap-sm-4 gap-2 form-group">
                                                    <input type="text" class="form-control"
                                                        name="edi_sociallink_link[{{ $links->id }}]"
                                                        placeholder="{{ trans('labels.link') }}"
                                                        value="{{ $links->link }}" required>
                                                    <button class="btn btn-danger" type="button"
                                                        data-bs-toggle="tooltip" data-bs-title="Remove"
                                                        data-bs-placement="top"
                                                        @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="updatestatus('{{ $links->id }}','','{{ URL::to('settings/social_links/del/') }}')" @endif>
                                                        <i class="ft-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control soaciallink_required  {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                                            onkeyup="show_feature_icon(this)" name="social_icon[]"
                                                            placeholder="{{ trans('labels.icon') }}" required>
                                                        <p
                                                            class="input-group-text {{ session()->get('direction') == 2 ? 'input-group-icon-rtl' : '' }}">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 d-flex align-items-center gap-sm-4 gap-2 form-group">
                                                    <input type="text" class="form-control" name="social_link[]"
                                                        placeholder="{{ trans('labels.link') }}" required>
                                                    <button class="btn btn-primary" type="button"
                                                        onclick="add_social_links('{{ trans('labels.icon') }}','{{ trans('labels.link') }}')">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforelse
                                        <span class="extra_social_links"></span>
                                        <div
                                            class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                            @if (env('Environment') == 'sendbox')
                                                <button type="button" onclick="myFunction()"
                                                    class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                                </button>
                                            @else
                                                <button type="submit"
                                                    class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                                </button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="footer_features">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-3">
                                <form action="{{ URL::to('settings/footer-features/') }}" method="post">
                                    @csrf
                                    <div class="card-header rounded-top bg-secondary text-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="form-section">
                                                {{ trans('labels.fun_fact_section') }}
                                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    aria-label="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info"
                                                    data-bs-original-title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </span>
                                            </h5>
                                            @if (!empty($footer_fetures) && count($footer_fetures) > 0)
                                                <button class="btn btn-primary" type="button"
                                                    onclick="add_features('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.sub_title') }}')">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @forelse ($footer_fetures as $key => $features)
                                            <div class="row">
                                                <input type="hidden" name="edit_icon_key[]"
                                                    value="{{ $features->id }}">
                                                <div class="col-md-4 form-group">
                                                    <div class="input-group h-100">
                                                        <input type="text"
                                                            class="form-control feature_required  {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                                            onkeyup="show_feature_icon(this)"
                                                            name="edi_feature_icon[{{ $features->id }}]"
                                                            placeholder="{{ trans('labels.icon') }}"
                                                            value="{{ $features->icons }}" required>
                                                        <p
                                                            class="input-group-text {{ session()->get('direction') == 2 ? 'input-group-icon-rtl' : '' }}">
                                                            {!! $features->icons !!}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <input type="text" class="form-control h-100"
                                                        name="edi_feature_title[{{ $features->id }}]"
                                                        placeholder="{{ trans('labels.title') }}"
                                                        value="{{ $features->title }}" required>
                                                </div>
                                                <div class="col-md-4 form-group d-flex gap-3">
                                                    <input type="text" class="form-control"
                                                        name="edi_feature_sub_title[{{ $features->id }}]"
                                                        placeholder="{{ trans('labels.sub_title') }}"
                                                        value="{{ $features->sub_title }}" required>
                                                    <button class="btn btn-danger" type="button"
                                                        data-bs-toggle="tooltip" data-bs-title="Remove"
                                                        data-bs-placement="top"
                                                        onclick="updatestatus('{{ $features->id }}','','{{ URL::to('settings/footer-features/del/') }}')">
                                                        <i class="ft-trash"></i> </button>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <div class="input-group h-100">
                                                        <input type="text" class="form-control feature_required"
                                                            onkeyup="show_feature_icon(this)" name="feature_icon[]"
                                                            placeholder="{{ trans('labels.icon') }}" required>
                                                        <p class="input-group-text"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <input type="text" class="form-control h-100 feature_required"
                                                        name="feature_title[]" placeholder="{{ trans('labels.title') }}"
                                                        required>
                                                </div>
                                                <div class="col-md-4 form-group gap-3 d-flex">
                                                    <input type="text" class="form-control feature_required"
                                                        name="feature_sub_title[]"
                                                        placeholder="{{ trans('labels.sub_title') }}" required>
                                                    <button class="btn btn-info" type="button"
                                                        tooltip="{{ trans('labels.add') }}"
                                                        onclick="add_features('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.description') }}')">
                                                        <i class="fa fa-plus"></i> </button>
                                                </div>
                                            </div>
                                        @endforelse
                                        <span class="extra_footer_features"></span>
                                        <div
                                            class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                            @if (env('Environment') == 'sendbox')
                                                <button type="button" onclick="myFunction()"
                                                    class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                                </button>
                                            @else
                                                <button type="submit" id="btn_setting"
                                                    class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                                </button>
                                            @endif
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (@helper::checkaddons('top_deals'))
                @include('top_deals.top_deals')
            @endif
            @if (@helper::checkaddons('pwa'))
                @include('pwa.pwa_settings')
            @endif
            @if (@helper::checkaddons('email_settings'))
                @include('emailsettings.email_setting')
                @include('email_template.setting_form')
            @endif
            @if (@helper::checkaddons('cookie'))
                @include('included.cookie.setting_form')
            @endif
            @if (@helper::checkaddons('tawk_addons'))
                @include('tawk_settings.index')
            @endif
            @if (@helper::checkaddons('wizz_chat'))
                @include('wizz_chat_settings.index')
            @endif
            @if (@helper::checkaddons('google_calendar'))
                @include('google_calendar.setting_form')
            @endif
            @if (@helper::checkaddons('recaptcha'))
                @include('recaptcha.setting_form')
            @endif
            @if (@helper::checkaddons('google_login'))
                @include('google_login.setting_form')
            @endif
            @if (@helper::checkaddons('facebook_login'))
                @include('facebook_login.setting_form')
            @endif
            @if (@helper::checkaddons('trusted_badges'))
                <div id="trusted_badges">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-header p-3 bg-secondary">
                                    <h5 class="text-white">
                                        {{ trans('labels.trusted_badges') }}
                                    </h5>
                                </div>
                                <form action="{{ URL::to('settings/safe-secure-store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div
                                                    class="row row-cols-xxl-4 row-cols-xl-2 row-cols-lg-2 row-cols-md-2 row-cols-1">
                                                    <div class="form-group col">
                                                        <label
                                                            class="form-label">{{ trans('labels.trusted_badge_image_1') }}
                                                        </label>
                                                        <input type="file" class="form-control"
                                                            name="trusted_badge_image_1">
                                                        <img class="img-fluid rounded h-40 mt-1"
                                                            src="{{ @helper::image_Path($otherdata->trusted_badge_image_1) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="form-group col">
                                                        <label
                                                            class="form-label">{{ trans('labels.trusted_badge_image_2') }}
                                                        </label>
                                                        <input type="file" class="form-control"
                                                            name="trusted_badge_image_2">
                                                        <img class="img-fluid rounded h-40 mt-1"
                                                            src="{{ @helper::image_Path($otherdata->trusted_badge_image_2) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="form-group col">
                                                        <label
                                                            class="form-label">{{ trans('labels.trusted_badge_image_3') }}
                                                        </label>
                                                        <input type="file" class="form-control"
                                                            name="trusted_badge_image_3">
                                                        <img class="img-fluid rounded h-40 mt-1"
                                                            src="{{ @helper::image_Path($otherdata->trusted_badge_image_3) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="form-group col">
                                                        <label
                                                            class="form-label">{{ trans('labels.trusted_badge_image_4') }}
                                                        </label>
                                                        <input type="file" class="form-control"
                                                            name="trusted_badge_image_4">
                                                        <img class="img-fluid rounded h-40 mt-1"
                                                            src="{{ @helper::image_Path($otherdata->trusted_badge_image_4) }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="{{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }} mt-3">
                                            <button
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="trusted_badges" value="1" @endif
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (@helper::checkaddons('safe_secure_checkout'))
                <div id="safe_secure">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-header p-3 bg-secondary">
                                    <h5 class="text-white">
                                        {{ trans('labels.safe_secure') }}
                                    </h5>
                                </div>
                                <form action="{{ URL::to('settings/safe-secure-store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label
                                                    class="form-label">{{ trans('labels.safe_secure_checkout_payment_selection') }}
                                                </label>
                                                <div class="row">
                                                    @foreach ($getpayment as $payment)
                                                        @php
                                                            // Check if the current $payment is a system addon and activated
                                                            if (
                                                                $payment->payment_type == '1' ||
                                                                $payment->payment_type == '2'
                                                            ) {
                                                                $systemAddonActivated = true;
                                                            } else {
                                                                $systemAddonActivated = false;
                                                            }
                                                            $addon = App\Models\SystemAddons::where(
                                                                'unique_identifier',
                                                                $payment->unique_identifier,
                                                            )->first();
                                                            if ($addon != null && $addon->activated == 1) {
                                                                $systemAddonActivated = true;
                                                            }
                                                        @endphp
                                                        @if ($systemAddonActivated)
                                                            <div class="form-group col-auto">
                                                                <div class="form-check">
                                                                    <input class="form-check-input payment-checkbox"
                                                                        type="checkbox"
                                                                        name="safe_secure_checkout_payment_selection[]"
                                                                        {{ @in_array($payment->payment_type, explode(',', $otherdata->safe_secure_checkout_payment_selection)) ? 'checked' : '' }}
                                                                        id="{{ $payment->payment_type }}"
                                                                        value="{{ $payment->payment_type }}">
                                                                    <label class="form-check-label fw-bolder"
                                                                        for="{{ $payment->payment_type }}">
                                                                        {{ $payment->payment_name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label
                                                    class="form-label">{{ trans('labels.safe_secure_checkout_text') }}
                                                </label>
                                                <input type="text" class="form-control"
                                                    name="safe_secure_checkout_text"
                                                    value="{{ @$otherdata->safe_secure_checkout_text }}">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label
                                                    class="form-label">{{ trans('labels.safe_secure_checkout_text_color') }}
                                                </label>
                                                <input type="color"
                                                    class="form-control form-control-color w-100 border-0"
                                                    name="safe_secure_checkout_text_color"
                                                    value="{{ @$otherdata->safe_secure_checkout_text_color }}">
                                            </div>
                                        </div>
                                        <div
                                            class="{{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }} mt-3">
                                            <button
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="safe_secure" value="1" @endif
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div id="admin_color_setting">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="form-section d-flex gap-2 align-items-center text-capitalize">
                                    {{ trans('labels.admin_color_setting') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ URL::to('settings/theme') }}" method="post">
                                    @csrf

                                    <div class="form-group row last mb-4">
                                        {{-- primary_color --}}
                                        <div class="col-6">
                                            <label class="form-label"
                                                for="admin_primary_color">{{ trans('labels.primary_color') }}</label>
                                            <input type="color" id="admin_primary_color"
                                                class="form-control form-control-color w-100 border-0"
                                                name="admin_primary_color"
                                                value="{{ $otherdata->admin_primary_color }}">
                                        </div>
                                        {{-- no-data-image --}}
                                        <div class="col-6">
                                            <label class="form-label"
                                                for="admin_secondary_color">{{ trans('labels.secondary_color') }}</label>
                                            <input type="color" id="admin_secondary_color"
                                                class="form-control form-control-color w-100 border-0"
                                                name="admin_secondary_color"
                                                value="{{ $otherdata->admin_secondary_color }}">
                                        </div>
                                    </div>
                                    <div
                                        class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                        @if (env('Environment') == 'sendbox')
                                            <button type="button" onclick="myFunction()"
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                            </button>
                                        @else
                                            <button type="submit" id="btn_setting"
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                            </button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (@helper::checkaddons('product_review'))
                @include('review_setting.review_setting')
            @endif
            @if (@helper::checkaddons('quick_call'))
                @include('quick_call.index')
            @endif
            <div id="web_color_setting">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="form-section d-flex gap-2 align-items-center text-capitalize">
                                    {{ trans('labels.web_color_setting') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ URL::to('settings/theme') }}" method="post">
                                    @csrf
                                    <div class="form-group row last mb-4">
                                        {{-- primary_color --}}
                                        <div class="col-6">
                                            <label class="form-label"
                                                for="web_primary_color">{{ trans('labels.primary_color') }}</label>
                                            <input type="color" id="web_primary_color"
                                                class="form-control form-control-color w-100 border-0"
                                                name="web_primary_color" value="{{ $otherdata->web_primary_color }}">
                                        </div>
                                        {{-- no-data-image --}}
                                        <div class="col-6">
                                            <label class="form-label"
                                                for="web_secondary_color">{{ trans('labels.secondary_color') }}</label>
                                            <input type="color" id="web_secondary_color"
                                                class="form-control form-control-color w-100 border-0"
                                                name="web_secondary_color"
                                                value="{{ $otherdata->web_secondary_color }}">
                                        </div>
                                    </div>
                                    <div
                                        class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                        @if (env('Environment') == 'sendbox')
                                            <button type="button" onclick="myFunction()"
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                            </button>
                                        @else
                                            <button type="submit" id="btn_setting"
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                            </button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (@helper::checkaddons('service_card_layout'))
                @include('service-card-view.service-card-view')
            @endif

            @if (@helper::checkaddons('vendor_tip'))
                @include('tip_settings.tip_settings')
            @endif

            @if (@helper::checkaddons('sales_notification'))
                @include('fake_sales_notification.index')
            @endif

            @if (@helper::checkaddons('fake_view'))
                @include('product_fake_view.index')
            @endif

            @if (@helper::checkaddons('age_verification'))
                @include('age_verification.index')
            @endif
            @if (@helper::checkaddons('recent_view_service'))
                @include('recent_view_settings.recent_view_settings')
            @endif
            <div id="maintenance_modes">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="form-section d-flex gap-2 align-items-center text-capitalize">
                                    {{ trans('labels.maintenance_mode') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ URL::to('settings/maintenance_update') }}" method="POST"
                                    enctype="multipart/form-data">
                                            @csrf
                                            <div class="row g-3">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="">{{ trans('labels.maintenance_mode') }}
                                                    </label>
                                                    <input id="maintenance_on_off" type="checkbox"
                                                        class="checkbox-switch" name="maintenance_on_off"
                                                        value="1"
                                                        {{ $otherdata->maintenance_on_off == 1 ? 'checked' : '' }}>
                                                    <label for="maintenance_on_off" class="switch">
                                                        <span
                                                            class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                class="switch__circle-inner"></span></span>
                                                        <span
                                                            class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                        <span
                                                            class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                    </label>
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <label for="maintenance_title" class="form-label">
                                                        {{ trans('labels.title') }}
                                                        <span class="text-danger"> * </span>
                                                    </label>
                                                    <input type="text" class="form-control" id="maintenance_title"
                                                        name="maintenance_title"
                                                        placeholder="{{ trans('labels.title') }}"
                                                        value="{{ @$otherdata->maintenance_title }}">
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <label for="maintenance_description" class="form-label">
                                                        {{ trans('labels.description') }}
                                                        <span class="text-danger"> * </span>
                                                    </label>
                                                    <textarea name="maintenance_description" class="form-control" rows="4"
                                                        placeholder="{{ trans('labels.description') }}" required="">{{ @$otherdata->maintenance_description }}</textarea>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">
                                                        {{ trans('labels.image') }}<span class="text-danger">
                                                            *
                                                        </span>
                                                    </label>
                                                        <input type="file" class="form-control"
                                                            name="maintenance_image">
                                                        <img class="img-fluid rounded hw-70 mt-1"
                                                            src="{{ helper::image_path(@$otherdata->maintenance_image) }}"
                                                            alt="">
                                                </div>
                                                    
                                                <div
                                                    class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                                    <button
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                        class="btn btn-primary px-sm-4">
                                                        {{ trans('labels.save') }}
                                                    </button>
                                                </div>
                                            </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ URL::to('settings/notice_update') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div id="notice_mode">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-header bg-secondary text-white">
                                    <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="text-capitalize">{{ trans('labels.notice') }}</h5>
                                        <div>
                                            <div class="text-center">
                                                <input id="notice_on_off" type="checkbox" class="checkbox-switch"
                                                    name="notice_on_off" value="1"
                                                    {{ @$otherdata->notice_on_off == 1 ? 'checked' : '' }}>
                                                <label for="notice_on_off" class="switch">
                                                    <span class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}">
                                                        <span class="switch__circle-inner"></span>
                                                    </span>
                                                    <span class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">
                                                         {{ trans('labels.off') }}
                                                    </span>
                                                    <span class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">
                                                        {{ trans('labels.on') }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="notice_title" class="form-label">
                                                {{ trans('labels.title') }}
                                                <span class="text-danger"> * </span>
                                            </label>
                                            <input type="text" class="form-control" id="notice_title"
                                                    name="notice_title" placeholder=" {{ trans('labels.title') }}"
                                                    required="" value="{{ @$otherdata->notice_title }}">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="notice_description" class="form-label">
                                                {{ trans('labels.description') }}
                                                <span class="text-danger"> * </span>
                                            </label>
                                            <textarea name="notice_description" class="form-control" rows="4"
                                                placeholder=" {{ trans('labels.description') }}" required="">{{ @$otherdata->notice_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                        <button @if (env('Environment')=='sendbox' ) type="button" onclick="myFunction()" @else type="submit" @endif class="btn btn-primary px-sm-4  {{ Auth::user()->type == 4 ? (helper::check_access('role_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            <div id="others">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="form-section d-flex gap-2 align-items-center text-capitalize">
                                    {{ trans('labels.other') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ URL::to('settings/others') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row last">
                                        <div class="col-sm-6 form-group">
                                            <label class="form-label">{{ trans('labels.payment_process_options') }}
                                                <span class="text-danger"> * </span></label>
                                            <select name="payment_process_options" class="form-select"
                                                id="payment_process_options" required>
                                                <option value="">{{ trans('labels.select') }}</option>
                                                <option value="1"
                                                    {{ @$settingdata->payment_process_options == 1 ? 'selected' : '' }}>
                                                    {{ trans('labels.pay_now') }}</option>
                                                <option value="2"
                                                    {{ @$settingdata->payment_process_options == 2 ? 'selected' : '' }}>
                                                    {{ trans('labels.pay_later') }}</option>
                                                <option value="3"
                                                    {{ @$settingdata->payment_process_options == 3 ? 'selected' : '' }}>
                                                    {{ trans('labels.both') }}</option>
                                            </select>
                                        </div>
                                        {{-- booking_note_required --}}
                                        <div class="col-md-6 form-group">
                                            <label class="form-label"
                                                for="">{{ trans('labels.booking_note_required') }}
                                                <span class="text-danger"> * </span>
                                            </label>
                                            <input id="checkbox-switch-booking_note_required" type="checkbox"
                                                class="checkbox-switch" name="booking_note_required" value="1"
                                                {{ @$settingdata->booking_note_required == 1 ? 'checked' : '' }}>
                                            <label for="checkbox-switch-booking_note_required" class="switch">
                                                <span
                                                    class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}">
                                                    <span class="switch__circle-inner"></span></span>
                                                <span
                                                    class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                <span
                                                    class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                            </label>
                                        </div>
                                        {{-- wensite-authentication_image --}}
                                        <div class="col-6 mb-2">
                                            <label class="form-label"
                                                for="auth_image">{{ trans('labels.web_authentication_image') }}</label>
                                            <input type="file" id="auth_image" class="form-control"
                                                name="authentication_image" value="{{ old('authentication_image') }}">
                                            <img src="{{ helper::image_path($otherdata->authentication_image) }}"
                                                alt="{{ trans('labels.authentication_image') }}"
                                                class="rounded media-object round-media setting-profile mt-2 hw-70">
                                        </div>
                                        {{-- admin-authentication_image --}}
                                        <div class="col-6 mb-2">
                                            <label class="form-label"
                                                for="auth_image">{{ trans('labels.admin_authentication_image') }}</label>
                                            <input type="file" id="auth_image" class="form-control"
                                                name="admin_authentication_image"
                                                value="{{ old('admin_authentication_image') }}">
                                            <img src="{{ helper::image_path($otherdata->admin_authentication_image) }}"
                                                alt="{{ trans('labels.admin_authentication_image') }}"
                                                class="rounded media-object round-media setting-profile mt-2 hw-70">
                                        </div>
                                        {{-- no-data-image --}}
                                        <div class="col-6 mb-2">
                                            <label class="form-label"
                                                for="no_data_image">{{ trans('labels.no_data_image') }}</label>
                                            <input type="file" id="no_data_image" class="form-control"
                                                name="no_data_image" value="{{ old('no_data_image') }}">
                                            <img src="{{ helper::image_path($otherdata->no_data_image) }}"
                                                alt="{{ trans('labels.no_data_image') }}"
                                                class="rounded media-object round-media setting-profile mt-2 hw-70">
                                        </div>
                                        
                                        {{-- success image --}}
                                        <div class="col-6 mb-2">
                                            <label class="form-label"
                                                for="booking_success_image">{{ trans('labels.booking_success_image') }}</label>
                                            <input type="file" class="form-control" name="booking_success_image"
                                                value="{{ old('booking_success_image') }}">
                                            <img src="{{ helper::image_path($otherdata->booking_success_image) }}"
                                                alt="{{ trans('labels.booking_success_image') }}"
                                                class="rounded media-object round-media setting-profile mt-2 hw-70">
                                        </div>
                                        {{-- refer & earn image --}}
                                        <div class="col-6 mb-2">
                                            <label class="form-label"
                                                for="refer_earn_bg_image">{{ trans('labels.refer_earn_image') }}</label>
                                            <input type="file" class="form-control" name="refer_earn_image"
                                                value="{{ old('refer_earn_image') }}">
                                            <img src="{{ helper::image_path($otherdata->refer_earn_image) }}"
                                                alt="{{ trans('labels.refer_earn_image') }}"
                                                class="rounded media-object round-media setting-profile mt-2 hw-70">
                                        </div>
                                        {{-- Become a Provider image --}}
                                        <div class="col-6 mb-2">
                                            <label class="form-label"
                                                for="become_provider_image">{{ trans('labels.become_provider_image') }}</label>
                                            <input type="file" class="form-control" name="become_provider_image"
                                                value="{{ old('become_provider_image') }}">
                                            <img src="{{ helper::image_path($otherdata->become_provider_image) }}"
                                                alt="{{ trans('labels.become_provider_image') }}"
                                                class="rounded media-object round-media setting-profile mt-2 hw-70">
                                        </div>
                                    </div>
                                    <div
                                        class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                        @if (env('Environment') == 'sendbox')
                                            <button type="button" onclick="myFunction()"
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                            </button>
                                        @else
                                            <button type="submit" id="btn_setting"
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                            </button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function editcardimage(id) {
            "use strict";
            $("#card_id").val(id);
            $("#editcardModal").modal("show");
        }

        $("#checkbox-switch-login_required").on("change", function(e) {
            if (this.checked) {
                $("#is_checkout_login_required").removeClass("d-none");
            } else {
                $("#is_checkout_login_required").addClass("d-none");
            }
        });

        //Email Templates
        $(document).ready(function() {
            $('#templatemenuContent').find('.hidechild').addClass('d-none');

            $('#templatemenuContent :first-child').removeClass('d-none');
        });

        $('#template_type').on('change', function() {
            $('#templatemenuContent').find('.hidechild').addClass('d-none');
            $('#templatemenuContent').find('textarea').prop('required', false);
            $('#' + $(this).find(':selected').data('attribute')).removeClass('d-none');
            $('#' + $(this).find(':selected').data('attribute')).find('textarea').prop('required', true);
        }).change();

        //Safe & Secure Checkout
        $('.payment-checkbox').on('change', function() {
            var checkedCount = $('.payment-checkbox:checked').length;

            // If 4 checkboxes are already selected, disable others
            if (checkedCount >= 6) {
                $('.payment-checkbox').each(function() {
                    if (!$(this).is(':checked')) {
                        $(this).prop('disabled', true); // Disable unchecked checkboxes
                    }
                });
            } else {
                $('.payment-checkbox').prop('disabled', false); // Enable all checkboxes
            }
        }).change();

        $('#deal_type').on('change', function() {
            if ($('#deal_type').val() == 1) {
                $('#deal_start_date').removeClass('d-none');
                $('#start_time').removeClass('d-none');
                $('#deal_end_date').removeClass('d-none');
                $('#end_time').removeClass('d-none');
                $('#start_date').prop('required', true);
                $('#start_time').prop('required', true);
                $('#end_date').prop('required', true);
                $('#end_time').prop('required', true);
            } else {
                $('#deal_start_date').addClass('d-none');
                $('#start_time').removeClass('d-none');
                $('#deal_end_date').addClass('d-none');
                $('#end_time').removeClass('d-none');
                $('#start_date').prop('required', false);
                $('#start_time').prop('required', true);
                $('#end_date').prop('required', false);
                $('#end_time').prop('required', true);
            }
        }).change();

        $('.checkbox-switch').on('change', function() {
            if ($(this).is(':checked')) {
                $(this).val(1);
                document.querySelector('#start_date').readOnly = false;
                document.querySelector('#start_time').readOnly = false;
                document.querySelector('#end_date').readOnly = false;
                document.querySelector('#end_time').readOnly = false;
                document.querySelector('#offer_type').disabled = false;
                document.querySelector('#deal_type').disabled = false;
                document.querySelector('#amount').readOnly = false;
                document.querySelector('#top_deal_save_btn').disabled = false;
            } else {
                $(this).val(2);
                document.querySelector('#start_date').readOnly = true;
                document.querySelector('#start_time').readOnly = true;
                document.querySelector('#end_date').readOnly = true;
                document.querySelector('#end_time').readOnly = true;
                document.querySelector('#offer_type').disabled = true;
                document.querySelector('#deal_type').disabled = true;
                document.querySelector('#amount').readOnly = true;
            }
        });

        $('#review_approved_status-switch').on('change', function() {
            if ($(this).is(':checked')) {
                $(this).val(1);
                document.querySelector('#checkbox5').disabled = false;
                document.querySelector('#checkbox4').disabled = false;
                document.querySelector('#checkbox3').disabled = false;
                document.querySelector('#checkbox2').disabled = false;
                document.querySelector('#checkbox1').disabled = false;
                document.querySelector('#review_setting_update_btn').disabled = false;
            } else {
                $(this).val(2);
                document.querySelector('#checkbox5').disabled = true;
                document.querySelector('#checkbox4').disabled = true;
                document.querySelector('#checkbox3').disabled = true;
                document.querySelector('#checkbox2').disabled = true;
                document.querySelector('#checkbox1').disabled = true;
            }
        });

        $(document).ready(function() {
            $('#recaptcha_version').on('change', function() {
                var recaptcha_version = $(this).val();
                if (recaptcha_version == 'v3') {
                    $("#score_threshold").show();
                } else {
                    $("#score_threshold").hide();
                }
            });
        });
    </script>
@endsection
