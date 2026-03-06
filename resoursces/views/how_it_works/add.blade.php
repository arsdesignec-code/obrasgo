@extends('layout.main')
@section('page_title', trans('labels.add_how_it_works'))
@section('content')
    <section id="basic-form-layouts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title color-changer fs-4 fw-600" id="horz-layout-colored-controls">
                        {{ trans('labels.add_how_it_works') }}
                    </h5>
                    <div class="card my-3">
                        <div class="card-body">
                            <form class="form form-horizontal" id="add_how_it_works_form"
                                action="{{ URL::to('how-it-works/store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">{{ trans('labels.title') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" id="add_provider_name"
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    name="how_it_works_title"
                                                    placeholder="{{ trans('labels.enter_title') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="image">{{ trans('labels.image') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="file" id="add_provider_image"
                                                    class="form-control @error('how_it_works_image') is-invalid @enderror"
                                                    name="how_it_works_image" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="address">{{ trans('labels.description') }}
                                                    <span class="text-danger">*</span></label>
                                                <textarea id="add_provider_address" rows="2"
                                                    class="form-control col-md-12 @error('how_it_works_description') is-invalid @enderror"
                                                    name="how_it_works_description" placeholder="{{ trans('labels.enter_description') }}" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                        <a class="btn btn-danger px-sm-4"
                                            href="{{ URL::to('how-it-works') }}">{{ trans('labels.cancel') }} </a>
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
