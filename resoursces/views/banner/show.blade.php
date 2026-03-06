@extends('layout.main')
@section('page_title', trans('labels.edit_banner'))
@section('content')
    <div class="container-fluid">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title color-changer fs-4 fw-600" id="horz-layout-colored-controls">
                        {{ trans('labels.edit_banner') }}</h5>
                    <div class="card my-4">
                        <div class="card-body">
                            <form class="form form-horizontal" id="add_banner_form"
                                action="{{ URL::to('banners/edit/' . $bannerdata->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="type">{{ trans('labels.banner_section') }}
                                                    <span class="text-danger">*</span></label>
                                                <select id="banner_section" name="section" class="form-select" required
                                                    data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                    data-title="banner_type">
                                                    <option value="" hidden>{{ trans('labels.select') }}</option>
                                                    <option value="1"
                                                        @if ($bannerdata->section == '1') selected="selected" @endif>
                                                        {{ trans('labels.banner_section_1') }}</option>
                                                    <option value="2"
                                                        @if ($bannerdata->section == '2') selected="selected" @endif>
                                                        {{ trans('labels.banner_section_2') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="type">{{ trans('labels.banner_type') }}
                                                    <span class="text-danger">*</span></label>
                                                <select id="banner_type" name="type" class="form-select"
                                                    data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                    data-title="banner_type">
                                                    <option value="">{{ trans('labels.select') }}</option>
                                                    <option value="1"
                                                        @if ($bannerdata->type == '1') selected="selected" @endif>
                                                        {{ trans('labels.category') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.image') }}</label>
                                                <input type="file" class="form-control" id="banner_image" name="image"
                                                    value="{{ old('image') }}">
                                                <img src="{{ helper::image_path($bannerdata->image) }}"
                                                    alt="{{ trans('labels.image') }}"
                                                    class="rounded mt-2 edit-image hw-70">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group @if ($bannerdata->type == '1') d-block @else d-none @endif "
                                                id="category">
                                                <label class="form-label"
                                                    for="category">{{ trans('labels.category') }}</label>
                                                <select id="category_id" name="category_id" class="form-select" required>
                                                    @if ($bannerdata->type == '1')
                                                        <option value="{{ $bannerdata['categoryname']->id }}" selected>
                                                            {{ $bannerdata['categoryname']->name }}</option>
                                                    @endif
                                                    @foreach ($categorydata as $cdata)
                                                        <option value="{{ $cdata->id }}">{{ $cdata->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                    <a class="btn btn-danger px-sm-4"
                                        href="{{ URL::to('banners') }}">{{ trans('labels.cancel') }} </a>
                                    @if (env('Environment') == 'sendbox')
                                        <button type="button" onclick="myFunction()"
                                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }} </button>
                                    @else
                                        <button type="submit" id="btn_add_service"
                                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }} </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('resources/views/banner/banner.js') }}" type="text/javascript"></script>
@endsection
