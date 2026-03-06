@extends('layout.main')
@section('page_title', trans('labels.edit_currency-settings'))
@section('content')
    <section id="basic-form-layouts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title color-changer fs-4 fw-600" id="horz-layout-colored-controls">
                        {{ trans('labels.edit_currency-settings') }}</h5>
                    <div class="card my-3">
                        <div class="card-body">
                            <form action="{{ URL::to('admin/currency-settings/update-' . $editcurrency->id) }}"
                                method="POST">
                                @csrf
                                <div class="row">
                                    
                                    <div class="form-group col-md-6">
                                        <label class="form-label">{{ trans('labels.currency') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" name="currency" required>
                                            <option value="">{{ trans('labels.select_currency_symbol') }}
                                            </option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->currency_symbol }}"
                                                    {{ $currency->currency_symbol == $editcurrency->currency ? 'selected' : '' }}>
                                                    {{ $currency->currency_symbol }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">{{ trans('labels.exchange_rate') }}<span
                                                class="text-danger"> *
                                            </span></label>
                                        <input type="text" class="form-control" name="exchange_rate"
                                            value="{{ $editcurrency->exchange_rate }}"
                                            placeholder="{{ trans('labels.exchange_rate') }}" required>

                                    </div>
                                    <div class="form-group col-sm-3">
                                        <p class="form-label">{{ trans('labels.currency_position') }}
                                        </p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input form-check-input-secondary" type="radio"
                                                name="currency_position" id="radio" value="1"
                                                {{ $editcurrency->currency_position == '1' ? 'checked' : '' }} />
                                            <label for="radio"
                                                class="form-check-label">{{ trans('labels.left') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input form-check-input-secondary" type="radio"
                                                name="currency_position" id="radio1" value="2"
                                                {{ $editcurrency->currency_position == '2' ? 'checked' : '' }} />
                                            <label for="radio1"
                                                class="form-check-label">{{ trans('labels.right') }}</label>
                                        </div>

                                    </div>
                                    <div class="col-md-3 form-group">
                                        <p class="form-label">
                                            {{ trans('labels.currency_space') }}
                                        </p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input form-check-input-secondary" type="radio"
                                                name="currency_space" id="currency_space" value="1"
                                                {{ $editcurrency->currency_space == '1' ? 'checked' : '' }} />
                                            <label for="currency_space"
                                                class="form-check-label">{{ trans('labels.yes') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input form-check-input-secondary" type="radio"
                                                name="currency_space" id="currency_space1" value="2"
                                                {{ $editcurrency->currency_space == '2' ? 'checked' : '' }} />
                                            <label for="currency_space1"
                                                class="form-check-label">{{ trans('labels.no') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">{{ trans('labels.decimal_number_format') }}<span
                                                class="text-danger">
                                                * </span></label>
                                        <input type="text" class="form-control" name="currency_formate"
                                            value="{{ $editcurrency->currency_formate }}"
                                            placeholder="{{ trans('labels.decimal_number_format') }}" required>
                                        @error('currency_formate')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">{{ trans('labels.decimal_separator') }}</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input form-check-input-secondary" type="radio"
                                                name="decimal_separator" id="dot" value="1"
                                                {{ $editcurrency->decimal_separator == '1' ? 'checked' : '' }} />
                                            <label for="dot" class="form-check-label">{{ trans('labels.dot') }}
                                                (.)</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input form-check-input-secondary" type="radio"
                                                name="decimal_separator" id="comma" value="2"
                                                {{ $editcurrency->decimal_separator == '2' ? 'checked' : '' }} />
                                            <label for="comma" class="form-check-label">{{ trans('labels.comma') }}
                                                (,)</label>
                                        </div>
                                    </div>
                                    <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                        <a href="{{ URL::to('admin/currency-settings') }}"
                                            class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                                        <button
                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
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
