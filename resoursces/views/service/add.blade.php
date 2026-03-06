@extends('layout.main')
@section('page_title', trans('labels.add_service'))
@section('styles')
    <link rel="stylesheet"
        href="{{ asset('storage/app/public/admin-assets/vendors/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css') }}">
@endsection
@section('content')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <h5 class="card-title fs-4 fw-600" id="horz-layout-colored-controls">{{ trans('labels.add_service') }}</h5>
                <div class="card my-3">
                    <div class="card-body">
                        <form class="form form-horizontal" id="add_service_form" action="{{ URL::to('services-store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="name">{{ trans('labels.service') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="text" id="add_service_name"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}"
                                                placeholder="{{ trans('labels.enter_service') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="category_id">
                                                {{ trans('labels.category') }}
                                                <span class="text-danger">*</span></label>
                                            <select id="add_service_category_id" name="category_id" required
                                                class="form-select @error('category_id') is-invalid @enderror"
                                                data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                data-title="category_id">
                                                <option value="" selected disabled>
                                                    {{ trans('labels.select') }}</option>
                                                @foreach ($categorydata as $cd)
                                                    <option value="{{ $cd->id }}">{{ $cd->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="image">{{ trans('labels.image') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                                id="service_image" name="image" value="{{ old('image') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="gallery_image">{{ trans('labels.gallery') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="file" id="add_service_gallery_image"
                                                class="form-control @if ($errors->has('gallery_image.*')) is-invalid @endif"
                                                name="gallery_image[]" accept="image/*" multiple required>
                                            @if ($errors->has('gallery_image.*'))
                                                <span class="text-danger">{{ $errors->first('gallery_image.*') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="price">{{ trans('labels.price') }}</label>
                                            <input type="text" id="service_price"
                                                class="form-control @error('price') is-invalid @enderror" name="price"
                                                value="{{ old('price') }}"
                                                placeholder="{{ trans('labels.enter_price') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="discount">{{ trans('labels.discount') }}</label>
                                            <input type="text" id="service_discount"
                                                class="form-control @error('discount') is-invalid @enderror" name="discount"
                                                value="{{ old('discount') }}"
                                                placeholder="{{ trans('labels.enter_discount') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ trans('labels.tax') }}
                                            </label>
                                            <select id="add_service_category_id" name="tax[]"
                                                class="form-control selectpicker" multiple data-live-search="true">
                                                @foreach ($taxdata as $td)
                                                    <option value="{{ $td->id }}"
                                                        {{ !empty(old('tax')) && in_array($td->id, old('tax')) ? 'selected' : '' }}>
                                                        {{ $td->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="price_type">{{ trans('labels.price_type') }}
                                                <span class="text-danger">*</span></label>
                                            <div class="d-flex gap-2">
                                                <div class="form-check form-check-inline m-0">
                                                    <input class="form-check-input" type="radio" name="price_type"
                                                        onchange="getduration(this)" id="fixed" value="Fixed"
                                                        checked="checked" required>
                                                    <label class="form-check-label"
                                                        for="fixed">{{ trans('labels.fixed') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline m-0">
                                                    <input class="form-check-input" type="radio" name="price_type"
                                                        onchange="getduration(this)" id="hourly" value="Hourly"
                                                        @if (old('price_type') == 'Hourly') checked @endif required>
                                                    <label class="form-check-label"
                                                        for="hourly">{{ trans('labels.hourly') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group @if (old('price_type') == 'Hourly') d-none @endif"
                                            id="duration_type">
                                            <label class="form-label" for="duration_type">{{ trans('labels.type') }}
                                                <span class="text-danger">*</span></label>
                                            <select class="form-select selectbox select" name="duration_type"
                                                id="select_duration_type" required>
                                                <option @if (old('duration_type') == '1') selected @endif value="1">
                                                    {{ trans('labels.minutes') }} </option>
                                                <option @if (old('duration_type') == '2') selected @endif value="2">
                                                    {{ trans('labels.hours') }} </option>
                                                <option @if (old('duration_type') == '3') selected @endif value="3">
                                                    {{ trans('labels.days') }} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group @if (old('price_type') == 'Hourly') d-none @endif"
                                            id="duration">
                                            <label class="form-label" for="duration">{{ trans('labels.duration') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="text" id="service_duration"
                                                class="form-control @error('duration') is-invalid @enderror"
                                                name="duration" value="{{ old('duration') }}"
                                                placeholder="{{ trans('labels.enter_duration') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="featured">{{ trans('labels.featured') }}
                                                    </label>
                                                    <div class="text-center">
                                                        <input id="is_featured-switch" type="checkbox" class="checkbox-switch"
                                                            name="is_featured" value="is_featured">
                                                        <label for="is_featured-switch" class="switch">
                                                            <span
                                                                class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                    class="switch__circle-inner"></span></span>
                                                            <span
                                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                            <span
                                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                        </label>
                                                    </div>
                                                    {{-- <div class="form-check form-switch">
                                                        <input class="form-check-input " type="checkbox" id="is_featured"
                                                            name="is_featured" value="is_featured">
                                                        <label class="form-check-label "
                                                            for="is_featured">{{ trans('labels.set_as_featured') }}</label>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="is_top_deals">{{ trans('labels.top_deals') }}
                                                    </label>
                                                    <div class="text-center">
                                                        <input id="is_top_deals-switch" type="checkbox" class="checkbox-switch"
                                                            name="is_top_deals" value="is_top_deals">
                                                        <label for="is_top_deals-switch" class="switch">
                                                            <span
                                                                class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                    class="switch__circle-inner"></span></span>
                                                            <span
                                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                            <span
                                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                        </label>
                                                    </div>
                                                    {{-- <div class="form-check form-switch">
                                                        <input class="form-check-input " type="checkbox" id="is_top_deals"
                                                            name="is_top_deals" value="is_top_deals">
                                                        <label class="form-check-label "
                                                            for="is_top_deals">{{ trans('labels.set_as_top_deals') }}</label>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="description">{{ trans('labels.description') }}
                                            <span class="text-danger">*</span></label>
                                        <textarea id="ckeditor" rows="2" class="form-control @error('description') is-invalid @enderror"
                                            name="description" placeholder="{{ trans('labels.service_description') }}" required>{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                <a class="btn btn-danger px-sm-4"
                                    href="{{ URL::to('services') }}">{{ trans('labels.cancel') }}</a>
                                @if (env('Environment') == 'sendbox')
                                    <button type="button" onclick="myFunction()"
                                        class="btn btn-dark px-sm-4">{{ trans('labels.save') }}</button>
                                @else
                                    <button type="submit" id="btn_add_service" class="btn btn-dark px-sm-4">
                                        {{ trans('labels.save') }} </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script
        src="{{ asset('storage/app/public/admin-assets/vendors/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js') }}">
    </script>
    <script src="{{ asset('resources/views/service/service.js') }}" type="text/javascript"></script>
    <script>
        CKEDITOR.replace('ckeditor');
    </script>
@endsection
