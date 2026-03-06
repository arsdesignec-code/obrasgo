@extends('layout.main')
@section('page_title', trans('labels.edit_category'))
@section('content')
<div class="container-fluid">
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <h5 class="card-title fs-4 color-changer fw-600" id="basic-layout-icons">{{ trans('labels.edit_category') }}</h5>
                <div class="card border-0 my-3">
                    <div class="card-body">
                        <form class="form" id="edit_category_form"
                            action="{{ URL::to('/categories/edit/' . $categorydata->slug) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group m-0">
                                            <label for="name" class="form-label">{{ trans('labels.category_name') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="edit_category_name"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ $categorydata->name }}"
                                                placeholder="{{ trans('labels.enter_category') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group m-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-label">{{ trans('labels.category_image') }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="file"
                                                        class="form-control @error('image') is-invalid @enderror"
                                                        id="edit_category_image" name="image">
                                                    @error('image')
                                                        <span class="text-danger" id="image_error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mt-2" width="70px" height="70px">
                                                    <img src="{{ helper::image_path($categorydata->image) }}"
                                                        alt="{{ trans('labels.image') }}" class="rounded" width="70px" height="70px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions mt-3 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                    <a class="btn btn-danger px-sm-4"
                                        href="{{ URL::to('/categories') }}">{{ trans('labels.cancel') }}</a>
                                    @if (env('Environment') == 'sendbox')
                                        <button type="button" onclick="myFunction()"
                                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                    @else
                                        <button type="submit" id="btnAddPrd"
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
