@extends('layout.main')
@section('page_title', trans('labels.edit_testimonial'))
@section('content')
    <section id="basic-form-layouts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title color-changer fs-4 fw-600" id="horz-layout-colored-controls">
                        {{ trans('labels.edit_testimonial') }}</h5>
                    <div class="card my-3">
                        <div class="card-body">
                            <form class="form form-horizontal" id="edit_testimonials_form"
                                action="{{ URL::to('/testimonials/edit/' . $testimonial->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">{{ trans('labels.name') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" id="add_provider_name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ $testimonial->name }}"
                                                    placeholder="{{ trans('labels.enter_full_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">{{ trans('labels.rating') }}
                                                    <span class="text-danger">*</span></label>
                                                <select id="banner_section" name="rating" class="form-select" required
                                                    data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                    data-title="banner_type">
                                                    <option value="" hidden>{{ trans('labels.select') }}</option>
                                                    <option value="1"
                                                        @if ($testimonial->rating == '1') selected @endif>1
                                                    </option>
                                                    <option value="2"
                                                        @if ($testimonial->rating == '2') selected @endif>2
                                                    </option>
                                                    <option value="3"
                                                        @if ($testimonial->rating == '3') selected @endif>3
                                                    </option>
                                                    <option value="4"
                                                        @if ($testimonial->rating == '4') selected @endif>4
                                                    </option>
                                                    <option value="5"
                                                        @if ($testimonial->rating == '5') selected @endif>5
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="address">{{ trans('labels.description') }}
                                                    <span class="text-danger">*</span></label>
                                                <textarea id="" rows="5"
                                                    class="form-control col-md-12 @error('how_it_works_description') is-invalid @enderror" name="description"
                                                    placeholder="{{ trans('labels.enter_description') }}" required>{{ $testimonial->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="image">{{ trans('labels.image') }}</label>
                                                <input type="file" id=""
                                                    class="form-control @error('image') is-invalid @enderror"
                                                    name="image">
                                                <div class=" mt-2">
                                                    <img src="{{ helper::image_path($testimonial->image) }}"
                                                        alt="{{ trans('labels.image') }}" class="rounded hw-70">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                        <a class="btn btn-danger px-sm-4"
                                            href="{{ URL::to('testimonials') }}">{{ trans('labels.cancel') }} </a>
                                        @if (env('Environment') == 'sendbox')
                                            <button type="button" class="btn btn-primary px-sm-4"
                                                onclick="myFunction()">{{ trans('labels.save') }} </button>
                                        @else
                                            <button type="submit" id="btn_add_provider"
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }} </button>
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
