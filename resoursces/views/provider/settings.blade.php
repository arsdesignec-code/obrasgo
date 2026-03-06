@extends('layout.main')
@section('page_title', trans('labels.profile_settings'))
@section('content')
    <section id="configuration">
        <h5 class="content-header mb-3 fs-4 fw-600">
            {{ trans('labels.general_settings') }}</h5>
        <div class="row pb-4 settings g-3">
            <div class="col-xl-3">
                <div class="card card-sticky-top h-auto border-0">
                    <div class="card-body p-0">
                        <ul class="list-group list-options">
                            <a href="#profile_member" data-tab="profile_member"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center active"
                                aria-current="true">{{ trans('labels.basic_info') }}<i
                                    class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                            </a>
                            @if (Auth::user()->type == 2)
                                <a href="#bank_info" data-tab="bank_info"
                                    class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                    aria-current="true">{{ trans('labels.bank_info') }} <i
                                        class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                </a>
                            @endif
                            <a href="#change_password" data-tab="change_password"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.change_password') }} <i
                                    class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                            </a>
                            <a href="#delete_profile" data-tab="delete_profile"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.delete_profile') }} <i
                                    class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                            </a>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div id="settingmenuContent">
                    <div id="profile_member">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-3">
                                    <div class="card-header rounded-top bg-secondary text-white">
                                        <h5 class="form-section">
                                            {{ trans('labels.basic_info') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-horizontal striped-rows form-bordered"
                                            action="{{ URL::to('/profile-settings/update') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="email">{{ trans('labels.email') }}</label>
                                                            <input type="text" id="email"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                placeholder="{{ trans('labels.enter_email') }}"
                                                                name="email" value="{{ $providerdata->email }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="name">{{ trans('labels.fullname') }}
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" id="name"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                placeholder="{{ trans('labels.enter_full_name') }}"
                                                                name="name" value="{{ $providerdata->name }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="mobile">{{ trans('labels.mobile') }}
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                placeholder="{{ trans('labels.enter_mobile') }}"
                                                                name="mobile" id="mobile"
                                                                value="{{ $providerdata->mobile }}" required>
                                                        </div>
                                                    </div>
                                                    @if (Auth::user()->type == 2)
                                                        @if (@helper::checkaddons('notification'))
                                                            @include('included.notification_sound.index')
                                                        @endif
                                                    @endif
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label">{{ trans('labels.profileimage') }}</label>
                                                            <input class="form-control @error('image') is-invalid @enderror"
                                                                type="file" name="image" id="image">
                                                            <div class="mt-2">
                                                                <img src="{{ helper::image_path($providerdata->image) }}"
                                                                    alt="profile-image"
                                                                    class='rounded media-object round-media setting-profile hw-70'>
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
                    @if (Auth::user()->type == 2)
                        <div id="bank_info">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mb-3">
                                        <div class="card-header rounded-top bg-secondary text-white">
                                            <h5 class="form-section">
                                                {{ trans('labels.bank_info') }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <form class="form form-horizontal striped-rows form-bordered"
                                                action="{{ URL::to('/profile-settings/update') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    for="bank_name">{{ trans('labels.bank_name') }}
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input type="text" id="bank_name"
                                                                    class="form-control @error('bank_name') is-invalid @enderror"
                                                                    placeholder="{{ trans('labels.enter_bank_name') }}"
                                                                    name="bank_name" value="{{ @$bankdata->bank_name }}"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    for="account_holder">{{ trans('labels.account_holder') }}
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input type="text" id="account_holder"
                                                                    class="form-control @error('account_holder') is-invalid @enderror"
                                                                    placeholder="{{ trans('labels.enter_account_holder') }}"
                                                                    name="account_holder"
                                                                    value="{{ @$bankdata->account_holder }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    for="account_type">{{ trans('labels.account_type') }}
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input type="text" id="account_type"
                                                                    class="form-control @error('account_type') is-invalid @enderror"
                                                                    placeholder="{{ trans('labels.enter_account_type') }}"
                                                                    name="account_type"
                                                                    value="{{ @$bankdata->account_type }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    for="account_number">{{ trans('labels.account_number') }}
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input type="text" id="account_number"
                                                                    class="form-control @error('account_number') is-invalid @enderror"
                                                                    placeholder="{{ trans('labels.enter_account_number') }}"
                                                                    name="account_number"
                                                                    value="{{ @$bankdata->account_number }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    for="routing_number">{{ trans('labels.routing_number') }}
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input type="text" id="routing_number"
                                                                    class="form-control @error('routing_number') is-invalid @enderror"
                                                                    placeholder="{{ trans('labels.enter_routing_number') }}"
                                                                    name="routing_number"
                                                                    value="{{ @$bankdata->routing_number }}" required>
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
                                                        <button type="submit" class="btn btn-primary px-sm-4"
                                                            name="bank_info_update"
                                                            value="1">{{ trans('labels.save') }}</button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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
                                                            placeholder="{{ trans('labels.enter_confirm_pass') }}"
                                                            required>
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
                    <div id="delete_profile">
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary text-white">
                                        <h5 class="text-capitalize">
                                            {{ trans('labels.delete_profile') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <p class="form-group color-changer">
                                                {{ trans('labels.before_delete_msg') }}
                                            </p>
                                            <div class="form-group col-sm-6">
                                                <div class="form-check m-0 p-0 gap-2 d-flex align-items-center">
                                                    <input class="form-check-input p-0 m-0" type="checkbox"
                                                        value="" name="delete_account" id="delete_account"
                                                        required>
                                                    <label class="form-check-label p-0 m-0 fw-bolder"
                                                        for="delete_account">
                                                        {{ trans('labels.are_you_sure_delete_account') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                            @if (env('Environment') == 'sendbox')
                                                <button type="button"
                                                    class="btn btn-primary px-sm-4">{{ trans('labels.save') }} </button>
                                            @else
                                                <button type="submit"
                                                    onclick="deleteaccount('{{ URL::to('deleteaccount-' . @Auth::user()->id) }}')"
                                                    class="btn btn-primary px-sm-4">{{ trans('labels.save') }} </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        var checkbox_delete_account = "{{ trans('messages.checkbox_delete_account') }}";
    </script>
    <script src="{{ asset('resources/views/provider/provider.js') }}" type="text/javascript"></script>
@endsection
