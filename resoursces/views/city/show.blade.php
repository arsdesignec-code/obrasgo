@extends('layout.main')
@section('page_title', trans('labels.edit_city'))
@section('content')
    <div class="container-fluid">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title color-changer fs-4 fw-600" id="basic-layout-icons"> {{ trans('labels.edit_city') }}
                    </h5>
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <form class="form" id="edit_city_form"
                                action="{{ URL::to('/cities/edit/' . $updatecitydata->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row g-3">
                                        <div class="form-group col-md-6">
                                            <label for="edit_city_name" class="form-label">{{ trans('labels.city_name') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="edit_city_name"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ $updatecitydata->name }}"
                                                placeholder="{{ trans('labels.enter_city') }}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="add_city_image" class="form-label">{{ trans('labels.city_image') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" id="add_city_image"
                                                class="form-control @error('image') is-invalid @enderror" name="image">
                                            <img src="{{ helper::image_path($updatecitydata->image) }}"
                                                alt="{{ trans('labels.image') }}" class="rounded mt-2 hw-70">
                                        </div>
                                    </div>
                                    <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                        <a class="btn btn-danger px-sm-4"
                                            href="{{ URL::to('/cities') }}">{{ trans('labels.cancel') }}
                                        </a>
                                        @if (env('Environment') == 'sendbox')
                                            <button type="button" onclick="myFunction()"
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                        @else
                                            <button type="submit" id="btn_edit_city"
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
