@extends('layout.main')
@section('page_title', trans('labels.edit_language'))
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">

            <h5 class="text-capitalize fs-4 color-changer fw-600">{{ trans('labels.languages') }}</h5>

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb m-0">

                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('language-settings') }}" class="color-changer">
                            {{ trans('labels.language') }}
                        </a>
                    </li>

                    <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}"
                        aria-current="page">{{ trans('labels.edit') }}</li>

                </ol>

            </nav>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 my-3">
                    <div class="card-body">
                        <form action="{{ URL::to('/language-settings/update-' . $getlanguage->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- <div class="col-sm-3 col-md-12"> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="layout" class="form-label">{{ trans('labels.layout') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="layout" class="form-select layout-dropdown" id="layout" required>
                                            <option value="" selected>{{ trans('labels.select') }}</option>
                                            <option value="1"{{ $getlanguage->layout == '1' ? 'selected' : '' }}>
                                                {{ trans('labels.ltr') }}</option>
                                            <option value="2"{{ $getlanguage->layout == '2' ? 'selected' : '' }}>
                                                {{ trans('labels.rtl') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="layout" class="form-label">{{ trans('labels.image') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" class="form-control" name="image">
                                        <img src="{{ helper::image_path($getlanguage->image) }}"
                                            class="img-fluid rounded hw-50 mt-1" alt="">
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="">{{ trans('labels.default') }} </label>
                                    <input id="default-switch" type="checkbox" class="checkbox-switch" name="default"
                                        value="1" {{ $getlanguage->is_default == 1 ? 'checked' : '' }}>
                                    <label for="default-switch" class="switch me-3">
                                        <span
                                            class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                class="switch__circle-inner"></span></span>
                                        <span
                                            class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                        <span
                                            class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                    </label>
                                </div>
                                {{-- </div> --}}
                            </div>

                            <div class="text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                <a href="{{ URL::to('language-settings') }}"
                                    class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                                <button
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                    class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
