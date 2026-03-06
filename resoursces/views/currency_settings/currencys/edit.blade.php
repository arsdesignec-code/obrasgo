@extends('layout.main')
@section('page_title', trans('labels.edit_currencys'))
@section('content')
    <section id="basic-form-layouts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title color-changer fs-4 fw-600" id="horz-layout-colored-controls">
                        {{ trans('labels.edit_currencys') }}</h5>
                    <div class="card my-3">
                        <div class="card-body">
                            <form action="{{ URL::to('admin/currencys/currency_update-' . $editcurrency->id) }}"
                                method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="hidden" name="code" id="code">
                                        <label class="form-label">{{ trans('labels.currency') }}<span class="text-danger"> *
                                            </span></label>
                                        <input type="text" class="form-control" name="currency" id="currency"
                                            value="{{ $editcurrency->currency }}"
                                            placeholder="{{ trans('labels.currency') }}" required>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">{{ trans('labels.currency') }}<span class="text-danger"> *
                                            </span></label>
                                        <input type="text" class="form-control" name="currency_symbol"
                                            value="{{ $editcurrency->currency_symbol }}"
                                            placeholder="{{ trans('labels.currency') }}" required>

                                    </div>

                                    <div
                                        class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0 mt-4">
                                        <a href="{{ URL::to('admin/currencys') }}"
                                            class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                                        <button
                                            class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_currency-settings', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}"
                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
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
