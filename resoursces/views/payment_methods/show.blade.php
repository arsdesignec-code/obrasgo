@extends('layout.main')
@section('page_title', trans('labels.edit_payment_method'))
@section('content')
    <section id="basic-form-layouts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title text-capitalize color-changer fs-4 fw-600" id="horz-layout-colored-controls">
                        {{ $paymentmethodsdata->payment_name }}
                    </h5>
                    <div class="card my-3">
                        <div class="card-body">
                            <form class="form form-horizontal" id="edit_payment_method_form"
                                action="{{ URL::to('payment-methods/edit/' . $paymentmethodsdata->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.payment_name') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="payment_name"
                                                    name="payment_name" value="{{ $paymentmethodsdata->payment_name }}"
                                                    required>
                                            </div>
                                        </div>
                                        @if (
                                            $paymentmethodsdata->payment_type != 1 &&
                                                $paymentmethodsdata->payment_type != 2 &&
                                                $paymentmethodsdata->payment_type != 16)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="name">{{ trans('labels.environment') }}
                                                        <span class="text-danger">*</span></label>
                                                    <select id="edit_environment" name="environment" class="form-select"
                                                        data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                        data-title="payment_name" required>
                                                        <option value="">{{ trans('labels.select') }}</option>
                                                        <option value="1"
                                                            @if ($paymentmethodsdata->environment == '1') selected @endif>
                                                            {{ trans('labels.sandbox') }}</option>
                                                        <option value="2"
                                                            @if ($paymentmethodsdata->environment == '2') selected @endif>
                                                            {{ trans('labels.production') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                        @if (
                                            $paymentmethodsdata->payment_type != 1 &&
                                                $paymentmethodsdata->payment_type != 2 &&
                                                $paymentmethodsdata->payment_type != 16)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans('labels.currency') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="currency"
                                                        name="currency" value="{{ $paymentmethodsdata->currency }}"
                                                        required>
                                                </div>
                                            </div>
                                            @if (in_array($paymentmethodsdata->payment_type, ['3', '4', '5', '6', '9', '10', '11', '12', '15']))
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">
                                                            @if ($paymentmethodsdata->payment_type == 9)
                                                                {{ trans('labels.client_id') }}
                                                            @elseif ($paymentmethodsdata->payment_type == 11)
                                                                {{ trans('labels.profile_key') }}
                                                            @else
                                                                {{ trans('labels.public_key') }}
                                                            @endif
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" id="public_key"
                                                            name="public_key" value="{{ $paymentmethodsdata->public_key }}"
                                                            required>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans('labels.secret_key') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="secret_key"
                                                        name="secret_key" value="{{ $paymentmethodsdata->secret_key }}"
                                                        required>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($paymentmethodsdata->payment_type == 5)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="encryption_key">{{ trans('labels.encryption_key') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="encryption_key"
                                                        name="encryption_key"
                                                        value="{{ $paymentmethodsdata->encryption_key }}" required>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($paymentmethodsdata->payment_type == 11)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="base_url_by_region">{{ trans('labels.base_url_by_region') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="base_url_by_region"
                                                        name="base_url_by_region"
                                                        value="{{ $paymentmethodsdata->base_url_by_region }}" required>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.image') }}
                                                </label>
                                                <input type="file" class="form-control" id="image" name="image">
                                            </div>
                                            <img src="{{ helper::image_path($paymentmethodsdata->image) }}" alt=""
                                                class="rounded hw-50 border">
                                        </div>
                                        @if ($paymentmethodsdata->payment_type == '16')
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        {{ trans('labels.payment_description') }}
                                                        <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="ckeditor" name="payment_description">{{ $paymentmethodsdata->payment_description }}</textarea>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                    <div
                                        class="form-actions mt-3 text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                        <a class="btn btn-danger px-sm-4"
                                            href="{{ URL::to('payment-methods') }}">{{ trans('labels.cancel') }} </a>
                                        @if (env('Environment') == 'sendbox')
                                            <button type="button" onclick="myFunction()"
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                        @else
                                            <button type="submit" id="btn_edit_paymrnt_method"
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                        @endif
                                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('ckeditor');
    </script>
@endsection
