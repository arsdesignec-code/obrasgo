@extends('layout.main')
@section('page_title', trans('labels.add_coupon'))
@section('content')
    <section id="basic-form-layouts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fs-4 color-changer fw-600" id="horz-layout-colored-controls">
                        {{ trans('labels.add_coupon') }}</h5>
                    <div class="card my-3">
                        <div class="card-body">
                            <form class="form form-horizontal" id="add_coupon_form" action="{{ URL::to('coupons/store') }}"
                                method="POST">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="title">{{ trans('labels.title') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" id="add_coupon_title"
                                                    class="form-control @error('title') is-invalid @enderror" name="title"
                                                    value="{{ old('title') }}"
                                                    placeholder="{{ trans('labels.enter_title') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="code">{{ trans('labels.coupon_code') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" id="add_coupon_code"
                                                    class="form-control @error('code') is-invalid @enderror" name="code"
                                                    value="{{ old('code') }}"
                                                    placeholder="{{ trans('labels.enter_coupon') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="service_id">
                                                    {{ trans('labels.service') }}
                                                    <span class="text-danger">*</span></label>
                                                <select id="add_coupon_service_id" name="service_id" required
                                                    class="form-select @error('service_id') is-invalid @enderror"
                                                    data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                    data-title="service_id">
                                                    <option value="" selected disabled>
                                                        {{ trans('labels.select') }}</option>
                                                    @foreach ($servicedata as $sd)
                                                        <option value="{{ $sd->id }}">{{ $sd->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="discount">{{ trans('labels.discount') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" id="coupon_discount"
                                                    class="form-control @error('discount') is-invalid @enderror"
                                                    name="discount" value="{{ old('discount') }}"
                                                    placeholder="{{ trans('labels.enter_discount') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="start_date">{{ trans('labels.start_date') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="date" id="coupon_start_date"
                                                    class="form-control @error('start_date') is-invalid @enderror"
                                                    min="<?= date('Y-m-d') ?>" name="start_date"
                                                    value="{{ old('start_date') }}" required>
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
                                                    value="{{ old('expire_date') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="description">{{ trans('labels.description') }}
                                                    <span class="text-danger">*</span></label>
                                                <textarea id="coupon_description" rows="3" required
                                                    class="form-control col-md-12 @error('description') is-invalid @enderror" name="description"
                                                    placeholder="{{ trans('labels.coupon_description') }}"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="discount_type">{{ trans('labels.discount_type') }}
                                                    <span class="text-danger">*</span></label>
                                                <div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="discount_type" id="fixed" value="1" required>
                                                        <label class="form-check-label"
                                                            for="fixed">{{ trans('labels.fixed') }}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="discount_type" id="percentage" value="2" required>
                                                        <label class="form-check-label"
                                                            for="percentage">{{ trans('labels.percentage') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                    <a class="btn btn-danger px-sm-4"
                                        href="{{ URL::to('coupons') }}">{{ trans('labels.cancel') }}</a>
                                    @if (env('Environment') == 'sendbox')
                                        <button type="button" onclick="myFunction()"
                                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                    @else
                                        <button type="submit" id="btn_add_coupon"
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
