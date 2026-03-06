@extends('layout.main')
@section('page_title', trans('labels.edit_coupon'))
@section('content')
    <section id="basic-form-layouts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <h5 class="card-title fs-4 color-changer fw-600" id="horz-layout-colored-controls">
                            {{ trans('labels.edit_coupon') }}
                        </h5>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="form form-horizontal row" id="edit_coupon_form"
                                action="{{ URL::to('coupons/edit/' . $coupondata->id) }}" method="POST">
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="title">{{ trans('labels.title') }}
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" id="edit_coupon_title"
                                            class="form-control @error('title') is-invalid @enderror" name="title"
                                            value="{{ $coupondata->title }}" Placeholder="{{ trans('labels.enter_title') }}"
                                            required>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="code">{{ trans('labels.coupon_code') }}
                                            <span class="text-danger">*</span></label>

                                        <input type="text" id="edit_coupon_code"
                                            class="form-control @error('code') is-invalid @enderror" name="code"
                                            value="{{ $coupondata->code }}" placeholder="{{ trans('labels.enter_coupon') }}"
                                            required>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="service_id">
                                            {{ trans('labels.service') }}
                                            <span class="text-danger">*</span></label>

                                        <select id="edit_coupon_service_id" name="service_id" required
                                            class="form-select @error('service_id') is-invalid @enderror"
                                            data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                            data-title="service_id" data-show-subtext="true" data-live-search="true">
                                            <option value="{{ $coupondata['servicename']->id }}" selected>
                                                {{ $coupondata['servicename']->name }}</option>
                                            @foreach ($servicedata as $sdata)
                                                <option value="{{ $sdata->id }}">{{ $sdata->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="discount">{{ trans('labels.discount') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" id="coupon_discount"
                                            class="form-control @error('discount') is-invalid @enderror" name="discount"
                                            value="{{ $coupondata->discount }}"
                                            Placeholder="{{ trans('labels.enter_discount') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="start_date">{{ trans('labels.start_date') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="date" id="coupon_start_date"
                                            class="form-control @error('start_date') is-invalid @enderror" name="start_date"
                                            value="{{ $coupondata->start_date }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="expire_date">
                                            {{ trans('labels.expire_date') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="date" id="coupon_expire_date"
                                            class="form-control @error('expire_date') is-invalid @enderror"
                                            min="<?= date('Y-m-d') ?>" name="expire_date"
                                            value="{{ $coupondata->expire_date }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="description">{{ trans('labels.description') }}
                                            <span class="text-danger">*</span></label>
                                        <textarea id="coupon_description" rows="3" required
                                            class="form-control col-md-12 @error('description') is-invalid @enderror" name="description"
                                            placeholder="{{ trans('labels.coupon_description') }}">{{ strip_tags($coupondata->description) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="discount_type">{{ trans('labels.discount_type') }}
                                            <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="discount_type"
                                                    id="fixed" value="1" required
                                                    @if ($coupondata->discount_type == 1) checked="checked" @endif>
                                                <label class="form-check-label"
                                                    for="fixed">{{ trans('labels.fixed') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="discount_type"
                                                    id="percentage" value="2" required
                                                    @if ($coupondata->discount_type == 2) checked="checked" @endif>
                                                <label class="form-check-label"
                                                    for="percentage">{{ trans('labels.percentage') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-xl-6 col-12">
                                    <div class="form-group">
                                        <label class="form-label"
                                            for="description">{{ trans('labels.status') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input " type="checkbox" id="is_available"
                                                name="is_available" value="is_available"
                                                @if ($coupondata->is_available == 1) checked="checked" @endif>
                                            <label class="form-check-label "
                                                for="is_available">{{ trans('labels.active') }}</label>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                    <a class="btn btn-danger px-sm-4"
                                        href="{{ URL::to('coupons') }}">{{ trans('labels.cancel') }}</a>
                                    @if (env('Environment') == 'sendbox')
                                        <button type="button" onclick="myFunction()"
                                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                    @else
                                        <button type="submit" id="btn_edit_coupon"
                                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }} </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('resources/views/service/coupon/coupon.js') }}" type="text/javascript"></script>
@endsection
