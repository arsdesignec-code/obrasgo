@extends('front.layout.main')

@section('page_title', trans('labels.become_user'))

@section('content')

    <!-- become user register form -->
    <section class="contact-us mt-4">
        <div class="content">
            <div class="container">
                <div class="d-flex justify-content-center">
                    <div class="card p-0 rounded">
                        <div class="card-body form_body p-md-0">
                            <div class="row g-0 justify-content-between">
                                <div class="col-12 col-md-12 col-lg-5 p-sm-4 p-0">
                                    <div class="h-100 border-0">
                                        <div class="p-3">
                                            <div class="row justify-content-center align-items-center h-100">
                                                <div class="col">
                                                    <div class="login-header">
                                                        <h2 class="color-changer">
                                                            {{ trans('labels.become_user') }}
                                                        </h2>
                                                        <p class="truncate-2 fs-7 text-muted">
                                                            {{ trans('labels.form_subtitle') }}
                                                        </p>
                                                    </div>
                                                    <form action="{{ URL::to('home/store-user') }}" method="post"
                                                        enctype="multipart/form-data"
                                                        class="row gx-lg-3 gx-2 gy-2 gy-lg-3 align-items-center justify-content-center">
                                                        @csrf
                                                        <div class="col-md-6 col-12">
                                                            <label class="form-label">{{ trans('labels.fullname') }}
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input
                                                                class="form-control p-3 fs-7 @error('name') is-invalid @enderror"
                                                                type="text" name="name"
                                                                placeholder="{{ trans('labels.enter_full_name') }}" required
                                                                @if (Session::get('default_name')) value="{{ Session::get('default_name') }}" @else value="{{ old('name') }}" @endif>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <label class="form-label">{{ trans('labels.mobile') }}
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input
                                                                class="form-control p-3 fs-7 @error('mobile') is-invalid @enderror"
                                                                type="number" name="mobile" id="mobile"
                                                                value="{{ old('mobile') }}"
                                                                placeholder="{{ trans('labels.enter_mobile') }}" required>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <label class="form-label">{{ trans('labels.email') }}
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input
                                                                class="form-control p-3 fs-7 @error('email') is-invalid @enderror"
                                                                type="email" name="email"
                                                                placeholder="{{ trans('labels.enter_email') }}" required
                                                                @if (Session::get('default_email')) value="{{ Session::get('default_email') }}" readonly @else value="{{ old('email') }}" @endif>
                                                        </div>
                                                        <div
                                                            class="col-md-6 col-12 @if (Session::get('google_id') || Session::get('facebook_id')) d-none @endif ">
                                                            <label class="form-label">{{ trans('labels.password') }}
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="position-relative">
                                                                <input
                                                                    class="form-control p-3 fs-7 @error('password') is-invalid @enderror"
                                                                    type="password" name="password"
                                                                    value="{{ old('password') }}" required
                                                                    placeholder="{{ trans('labels.enter_password') }}"
                                                                    id="password">
                                                                <span
                                                                    class="{{ session()->get('direction') == 2 ? 'eye-passwords-rtl' : 'eye-passwords-ltr' }}  position-absolute">
                                                                    <i class="fa-regular fa-eye-slash" id="eye"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <label class="form-label">{{ trans('labels.profile') }}
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input
                                                                class="form-control p-3 fs-7 @error('image') is-invalid @enderror"
                                                                type="file" name="image" value="{{ old('image') }}"
                                                                required>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <label class="form-label">{{ trans('labels.address') }}
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input
                                                                class="form-control p-3 fs-7 @error('address') is-invalid @enderror"
                                                                type="text" name="address" required
                                                                placeholder="{{ trans('labels.enter_address') }}"
                                                                value="{{ old('address') }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">{{ trans('labels.referral_code') }}
                                                            </label>
                                                            <input class="form-control p-3 fs-7" type="text"
                                                                name="referral_code"
                                                                @isset($_GET['referral']) value="{{ $_GET['referral'] }}" @endisset
                                                                placeholder="{{ trans('labels.enter_referral_code') }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <div
                                                                class="form-check p-0 m-0 gap-2 d-flex align-items-center gap-2">
                                                                <input class="form-check-input p-0 m-0" type="checkbox"
                                                                    value="1" id="formcheck" required>
                                                                <label
                                                                    class="form-check-label m-0 p-0 or-text text-muted cp"
                                                                    for="formcheck">{{ trans('labels.I_accept_the') }}
                                                                    <a href="{{ URL::to('/home/terms-condition') }}"
                                                                        class="text-primary text-decoration-underline fw-semibold text-dark">{{ trans('labels.terms_conditions') }}</a>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @if (@helper::checkaddons('recaptcha'))
                                                            @include('recaptcha.recaptcha')
                                                        @endif
                                                        <div class="col-xl-12">
                                                            @if (env('Environment') == 'sendbox')
                                                                <button class="btn btn-primary fs-15 w-100"
                                                                    onclick="myFunction()"
                                                                    type="button">{{ trans('labels.register') }}</button>
                                                            @else
                                                                <button class="btn btn-primary fs-15 w-100"
                                                                    type="submit">{{ trans('labels.register') }}</button>
                                                            @endif
                                                        </div>
                                                    </form>
                                                    <p class="text-center or-text text-muted mt-3 mb-0">
                                                        {{ trans('labels.already_account') }}
                                                        <span><a href="{{ URL::to('/home/login') }}"
                                                                class="text-decoration-underline">{{ trans('labels.login') }}</a></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-7 d-none col-lg-7 d-lg-block">
                                    <div class="h-100 border-0">
                                        <img src="{{ helper::image_path(helper::otherdata('')->authentication_image) }}"
                                            alt="" class="w-100 h-100 object-fit-cover rounded-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- become provider -->
    @include('front.become_provider')
@endsection
