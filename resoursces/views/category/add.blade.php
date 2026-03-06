@extends('layout.main')
@section('page_title', trans('labels.add_category'))
@section('content')
    <div class="container-fluid">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fs-4 color-changer fw-600">{{ trans('labels.add_category') }}</h5>
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <form class="form" id="add_categpry_form" action="{{ URL::to('/categories/store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group m-0">
                                                <label for="name" class="form-label">{{ trans('labels.category_name') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="category_name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}"
                                                    placeholder="{{ trans('labels.enter_category') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group m-0">
                                                <label class="form-label">{{ trans('labels.category_image') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="file"
                                                    class="form-control @error('image') is-invalid @enderror"
                                                    id="category_image" name="image" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="form-actions mt-3 text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                        <a class="btn btn-danger px-sm-4"
                                            href="{{ URL::to('/categories') }}">{{ trans('labels.cancel') }}</a>
                                        @if (env('Environment') == 'sendbox')
                                            <button type="button" class="btn btn-primary px-sm-4"
                                                onclick="myFunction()">{{ trans('labels.save') }}</button>
                                        @else
                                            <button type="submit" id="btn_add_category"
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
