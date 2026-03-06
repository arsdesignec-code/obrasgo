@extends('layout.main')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <h5 class="card-title color-changer fs-4 fw-600" id="horz-layout-colored-controls">{{ trans('labels.edit_brands') }}</h5>
                <div class="card my-3 border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('brand/update/' . $branddata->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.image') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="file" class="form-control" name="image" accept="image/*"
                                                required>
                                            <img src="{{ helper::image_path($branddata->image) }}" alt=""
                                                class="img-fluid rounded hw-50 mt-1">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                    <a href="{{ URL::to('brand') }}"
                                        class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary px-sm-4"
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
