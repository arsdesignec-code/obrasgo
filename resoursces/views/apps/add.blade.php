@extends('layout.main')
@section('page_title', trans('labels.addons'))
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">

            <h5 class="text-capitalize color-changer">{{ trans('labels.add_new') }}</h5>

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb m-0">

                    <li class="breadcrumb-item"><a href="{{ URL::to('apps') }}" class="color-changer">{{ trans('labels.addons_manager') }}</a></li>

                    <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}"
                        aria-current="page">{{ trans('labels.add') }}</li>

                </ol>

            </nav>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 my-3">
                    <div class="card-body">
                        <form method="post" action="{{ URL::to('systemaddons/store') }}" name="about" id="about"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-sm-3 col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="addon_zip" class="col-form-label">{{ trans('labels.zip_file') }}<span
                                                class="text-danger"> * </span></label>
                                        <input type="file" class="form-control" name="addon_zip" id="addon_zip"
                                            required="">
                                    </div>
                                </div>
                            </div>

                            <div class="text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                @if (env('Environment') == 'sendbox')
                                    <button type="button" class="btn btn-secondary"
                                        onclick="myFunction()">{{ trans('labels.install') }}</button>
                                @else
                                    <button type="submit" class="btn btn-secondary">{{ trans('labels.install') }}</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
