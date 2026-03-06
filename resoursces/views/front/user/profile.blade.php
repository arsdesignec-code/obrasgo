@extends('front.layout.vendor_theme')
@section('page_title')
    {{ trans('labels.user') }} | {{ trans('labels.profile_settings') }}
@endsection
@section('front_content')
    <div class="col-12 col-md-12 col-lg-8 col-xl-9">
        <!-- profile details -->
        <div class="card mb-4">
            <div class="card-header border-bottom bg-transparent py-3">
                <h5 class="widget-title m-0 color-changer">{{ trans('labels.profile_settings') }}</h5>
            </div>
            <div class="card-body">
                <div class="tab-content pt-0">
                    <div class="tab-pane show active" id="user_profile_settings">
                        <div class="widget">
                            @if (!empty($citydata))
                                <form action="{{ URL::to('/home/user/profile/edit') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="border rounded p-2 mb-3">
                                        <div class="d-flex gap-3 align-items-center">
                                            <div>
                                                <img class="user-image" src="{{ helper::image_path(Auth::user()->image) }}"
                                                    alt="{{ trans('labels.user_image') }}">
                                            </div>
                                            <div class="w-100">
                                                <input type="file" class="form-control fs-7 p-2" name="image"
                                                    id="profile_image">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="form-group col-md-12 col-lg-4">
                                            <label class="form-label">{{ trans('labels.name') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input class="form-control fs-7 p-2" type="text" name="name"
                                                value="{{ Auth::user()->name }}" required>
                                        </div>
                                        <div class="form-group col-md-12 col-lg-4">
                                            <label class="form-label">{{ trans('labels.email') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input class="form-control fs-7 p-2" type="email" value="{{ Auth::user()->email }}"
                                                disabled>
                                        </div>
                                        <div class="form-group col-md-12 col-lg-4">
                                            <label class="form-label">{{ trans('labels.mobile') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input class="form-control fs-7 p-2" type="text" name="mobile"
                                                value="{{ Auth::user()->mobile }}" disabled>
                                        </div>
                                        <div class="form-group col-md-12 col-lg-8">
                                            <label class="form-label">{{ trans('labels.address') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control fs-7 p-2" name="address"
                                                value="{{ strip_tags(Auth::user()->address) }}">
                                        </div>
                                        <div class="form-group col-md-12 col-lg-4">
                                            <label class="form-label">{{ trans('labels.city') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="city" id="city" class="form-select fs-7 p-2" required>
                                                <option value="">{{ trans('labels.select') }}</option>
                                                @foreach ($citydata as $cdata)
                                                    <option value="{{ $cdata->id }}"
                                                        @if (Auth::user()->city_id == $cdata->id) selected @endif>
                                                        {{ $cdata->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-xl-12">
                                            <label class="form-label">{{ trans('labels.about') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control fs-7 p-2" name="about" id="" cols="30" rows="3">{{ strip_tags(Auth::user()->about) }}</textarea>
                                        </div>
                                        <div class="form-group col-xl-12 text-end mt-4">
                                            <input type="submit" class="btn btn-primary"
                                                value="{{ trans('labels.submit') }}">
                                        </div>
                                    </div>
                                </form>
                            @else
                                <p class="text-center">{{ trans('labels.no_data') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- chang password -->
        <div class="card mb-4">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="widget-title color-changer m-0">{{ trans('labels.change_password') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ URL::to('/home/user/changepass') }}" method="POST">
                    @csrf
                    <div class="row gx-2 gy-2 gy-lg-3">
                        <div class="form-group col-md-12 col-lg-4">
                            <label class="form-label">{{ trans('labels.old_pass') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input class="form-control fs-7 p-2 @error('old_pass') is-invalid @enderror" type="password"
                                name="old_pass" value="{{ old('old_pass') }}"
                                placeholder="{{ trans('labels.enter_old_pass') }}" required>
                        </div>
                        <div class="form-group col-md-12 col-lg-4">
                            <label class="form-label">{{ trans('labels.new_pass') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input class="form-control fs-7 p-2 @error('new_pass') is-invalid @enderror" type="password"
                                name="new_pass" value="{{ old('new_pass') }}"
                                placeholder="{{ trans('labels.enter_new_pass') }}" required>
                        </div>
                        <div class="form-group col-md-12 col-lg-4">
                            <label class="form-label">{{ trans('labels.confirm_pass') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input class="form-control fs-7 p-2 @error('confirm_pass') is-invalid @enderror" type="password"
                                name="confirm_pass" value="{{ old('confirm_pass') }}"
                                placeholder="{{ trans('labels.enter_confirm_pass') }}" required>
                        </div>
                        @if (isset($_COOKIE['city_id']))
                            <div class="form-group col-12 text-end">
                                <input type="submit" class="btn btn-primary" value="{{ trans('labels.submit') }}">
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- delete account -->
        <div class="card mb-4">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="widget-title color-changer m-0">{{ trans('labels.delete_account') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ URL::to('/home/user/delete') }}" method="POST" class="delete-account-form">
                    <h6 class="fw-semibold text-dark mb-2 color-changer">{{ trans('labels.Before_you_go') }}</h6>
                    <ol>
                        <li>
                            <i class="far fa-circle color-changer"></i>
                            <span class="text-muted fw-semibold">{{ trans('labels.Take_backup_of_your_data') }}</span>
                        </li>
                        <li>
                            <i class="far fa-circle color-changer"></i>
                            <span
                                class="text-muted fw-semibold color-changer">{{ trans('labels.If_you_delete_your_account') }},{{ trans('labels.you_will_lose_your_all_data') }}</span>
                        </li>
                    </ol>
                    <div class="form-check form-check-md my-4 text-muted">
                        <input class="form-check-input p-2" type="checkbox" name="terms" id="deleteaccountCheck"
                            required>
                        <label class="form-check-label text-dark px-2 fw-semibold"
                            for="deleteaccountCheck">{{ trans('labels.yes') }},{{ trans('labels.I_d_like_to_delete_my_account') }}</label>
                        <span class="" id="delete_account_error"></span>
                    </div>
                    <div class="d-md-flex align-items-center d-grid gap-3">
                        <a href="#" class="btn btn-success fs-15 fw-500">{{ trans('labels.Keep_my_account') }}</a>
                        <a class="btn btn-danger fs-15 fw-500" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Delete Account" type="submit"
                            onclick="deleteaccount('{{ Auth::user()->id }}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/home/user/delete') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}');">
                            {{ trans('labels.delete_account') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- become provider -->
    @include('front.become_provider')
@endsection
