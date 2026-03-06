@extends('layout.main')
@section('page_title', trans('labels.add_tax'))
@section('content')
    <section id="basic-form-layouts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fs-4 color-changer fw-600" id="horz-layout-colored-controls">{{ trans('labels.add_tax') }}</h5>
                    <div class="card my-3">
                        <div class="card-body">
                            <form class="form form-horizontal" id="add_banner_form" action="{{ URL::to('tax/store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">{{ trans('labels.name') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control " id="name" name="name"
                                                    value="{{ old('name') }}" placeholder="{{ trans('labels.name') }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="type">{{ trans('labels.type') }}
                                                    <span class="text-danger">*</span></label>
                                                <select name="type" class="form-select" required>
                                                    <option value="" hidden="">{{ trans('labels.select') }}
                                                    </option>
                                                    <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>
                                                        {{ trans('labels.fixed') }}
                                                        ({{ helper::appdata()->currency }})</option>
                                                    <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>
                                                        {{ trans('labels.percentage') }} (%)
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="tax">{{ trans('labels.tax') }}</label>
                                                <input type="text" class="form-control " id="tax" name="tax"
                                                    value="{{ old('tax') }}" placeholder="{{ trans('labels.tax') }}"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                    <a class="btn btn-danger px-sm-4" href="{{ URL::to('tax') }}">{{ trans('labels.cancel') }}
                                    </a>
                                    @if (env('Environment') == 'sendbox')
                                        <button type="button" onclick="myFunction()"
                                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                    @else
                                        <button type="submit" id="btn_add_service"
                                            class="btn btn-primary px-sm-4"></i>{{ trans('labels.save') }}</button>
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
