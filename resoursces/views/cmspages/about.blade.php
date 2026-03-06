@extends('layout.main')
@section('page_title', trans('labels.about'))
@section('content')
    <div class="container-fluid">
        <div class="match-height">
            <div class="col-md-12">
                <h5 class="card-title fs-4 color-changer fw-600" id="basic-layout-form-center">{{ trans('labels.about') }}</h5>
                <div class="card my-3">
                    <div class="card-body">
                        <form action="{{ URL::to('/about/update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="col-md-3 form-label" for="image">{{ trans('labels.image') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-12">
                                    <input type="file" id="edit_image"
                                        class="form-control @error('image') is-invalid @enderror" name="image">
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <img src="{{ helper::image_path($aboutdata->about_image) }}"
                                        class="rounded edit-image w-50" alt="{{ trans('labels.image') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <textarea class="form-control @error('about_content') is-invalid @enderror" rows="10" name="about_content"
                                        id="ckeditor" required>{{ $aboutdata->about_content }}</textarea>
                                </div>
                            </div>
                            <div class="text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                @if (env('Environment') == 'sendbox')
                                    <button type="button" onclick="myFunction()"
                                        class="btn btn-primary px-sm-4">{{ trans('labels.save') }} </button>
                                @else
                                    <button class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        CKEDITOR.replace('ckeditor');
    </script>
@endsection
