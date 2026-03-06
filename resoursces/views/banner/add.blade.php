@extends('layout.main')
@section('page_title', trans('labels.add_banner'))
@section('content')
    <div class="container-fluid">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title color-changer fs-4 fw-600" id="horz-layout-colored-controls">{{ trans('labels.add_banner') }}</h5>
                    <div class="card my-3">
                        <div class="card-body">
                            <form class="form form-horizontal" id="add_banner_form" action="{{ URL::to('banners/store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="banner_section">{{ trans('labels.banner_section') }}
                                                    <span class="text-danger">*</span></label>

                                                <select id="banner_section" name="section" class="form-select" required
                                                    data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                    data-title="banner_type">
                                                    <option value="" hidden>{{ trans('labels.select') }}</option>
                                                    <option value="1">{{ trans('labels.banner_section_1') }}
                                                    </option>
                                                    <option value="2">{{ trans('labels.banner_section_2') }}
                                                    </option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="image">{{ trans('labels.image') }}
                                                    <span class="text-danger">*</span></label>

                                                <input type="file" class="form-control " id="banner_image" name="image"
                                                    value="{{ old('image') }}" required>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="type">{{ trans('labels.banner_type') }}
                                                </label>
                                                <select id="banner_type" name="type" class="form-select"
                                                    data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                    data-title="banner_type">
                                                    <option value="" selected>
                                                        {{ trans('labels.select') }}
                                                    </option>
                                                    <option value="1"
                                                        @if (old('type') == '1') selected @endif>
                                                        {{ trans('labels.category') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group d-none" id="category">
                                                <label class="form-label" for="category_id">{{ trans('labels.category') }}
                                                    <span class="text-danger">*</span></label>

                                                <select id="category_id" name="category_id" class="form-select "
                                                    data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                    data-title="category_id">
                                                    <option value="" selected>
                                                        {{ trans('labels.select_category') }}</option>
                                                    @foreach ($categorydata as $cdata)
                                                        <option value="{{ $cdata->id }}">
                                                            {{ $cdata->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                    <a class="btn btn-danger px-sm-4"
                                        href="{{ URL::to('banners') }}">{{ trans('labels.cancel') }}
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
        </section>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('resources/views/banner/banner.js') }}" type="text/javascript"></script>
@endsection
