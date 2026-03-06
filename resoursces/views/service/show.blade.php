@extends('layout.main')
@section('page_title', trans('labels.edit_service'))
@section('styles')
    <link rel="stylesheet"
        href="{{ asset('storage/app/public/admin-assets/vendors/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css') }}">
@endsection
@section('content')
    <section id="basic-form-layouts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fs-4 color-changer fw-600" id="horz-layout-colored-controls">{{ trans('labels.edit_service') }}</h5>
                    <div class="card my-3">
                        <div class="card-body">
                            <form class="form form-horizontal" id="edit_service_form"
                                action="{{ URL::to('services/edit/' . $servicedata->slug) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">{{ trans('labels.service') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" id="edit_service_name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ $servicedata->name }}"
                                                    placeholder="{{ trans('labels.enter_service') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="category_id">
                                                    {{ trans('labels.category') }}
                                                    <span class="text-danger">*</span></label>
                                                <select id="edit_service_category_id" name="category_id" required
                                                    class="form-select @error('category_id') is-invalid @enderror"
                                                    data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                    data-title="category_id">
                                                    <option value="{{ $servicedata['categoryname']->id }}" selected>
                                                        {{ $servicedata['categoryname']->name }}</option>
                                                    @foreach ($categorydata as $cd)
                                                        <option value="{{ $cd->id }}">{{ $cd->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="price">{{ trans('labels.price') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" id="service_price"
                                                    class="form-control @error('price') is-invalid @enderror" name="price"
                                                    value="{{ $servicedata->price }}"
                                                    placeholder="{{ trans('labels.enter_price') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="discount">{{ trans('labels.discount') }}</label>
                                                <input type="text" id="service_discount"
                                                    class="form-control @error('discount') is-invalid @enderror" name="discount"
                                                    value="{{ $servicedata->discount }}"
                                                    placeholder="{{ trans('labels.enter_discount') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.tax') }}
                                                </label>
                                                <select id="add_service_category_id" name="tax[]"
                                                    class="form-control selectpicker" multiple data-live-search="true">
                                                    @php $tax = explode("|",$servicedata->tax) @endphp
                                                    @foreach ($taxdata as $td)
                                                        <option value="{{ $td->id }}"
                                                            {{ in_array($td->id, $tax) ? 'selected' : '' }}>
                                                            {{ $td->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="price_type">{{ trans('labels.price_type') }}
                                                    <span class="text-danger">*</span></label>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <div class="form-check form-check-inline m-0">
                                                        <input class="form-check-input" type="radio" name="price_type"
                                                            id="fixed" onchange="getduration(this)" value="Fixed" required
                                                            @if ($servicedata->price_type == 'Fixed') checked @endif>
                                                        <label class="fform-label"
                                                            for="fixed">{{ trans('labels.fixed') }}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline m-0">
                                                        <input class="form-check-input" type="radio" name="price_type"
                                                            id="hourly" onchange="getduration(this)" value="Hourly" required
                                                            @if ($servicedata->price_type == 'Hourly') checked @endif>
                                                        <label class="form-check-label"
                                                            for="hourly">{{ trans('labels.hourly') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group @if ($servicedata->price_type == 'Hourly') d-none @endif"
                                                id="duration_type">
                                                <label class="form-label" for="duration_type">{{ trans('labels.type') }}
                                                    <span class="text-danger">*</span></label>
                                                <select class="form-select selectbox select" name="duration_type"
                                                    id="select_duration_type">
                                                    <option @if ($servicedata->duration_type == '1') selected @endif value="1">
                                                        {{ trans('labels.minutes') }} </option>
                                                    <option @if ($servicedata->duration_type == '2') selected @endif value="2">
                                                        {{ trans('labels.hours') }} </option>
                                                    <option @if ($servicedata->duration_type == '3') selected @endif value="3">
                                                        {{ trans('labels.days') }} </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group @if ($servicedata->price_type == 'Hourly') d-none @endif"
                                                id="duration">
                                                <label class=" form-label" for="duration">{{ trans('labels.duration') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" id="service_duration"
                                                    class="form-control @error('duration') is-invalid @enderror"
                                                    name="duration" value="{{ $servicedata->duration }}"
                                                    placeholder="{{ trans('labels.enter_duration') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="featured">{{ trans('labels.featured') }}</label>
                                                        <div>
                                                            <div class="text-center">
                                                                <input id="is_featured-switch" type="checkbox" class="checkbox-switch"
                                                                    name="is_featured" value="is_featured"
                                                                    {{ $servicedata->is_featured == 1 ? 'checked' : '' }}>
                                                                <label for="is_featured-switch" class="switch">
                                                                    <span
                                                                        class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                            class="switch__circle-inner"></span></span>
                                                                    <span
                                                                        class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                                    <span
                                                                        class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="is_top_deals">{{ trans('labels.top_deals') }}</label>
                                                        <div>
                                                            <div class="text-center">
                                                                <input id="is_top_deals-switch" type="checkbox" class="checkbox-switch"
                                                                    name="is_top_deals" value="is_top_deals"
                                                                    {{ $servicedata->is_top_deals == 1 ? 'checked' : '' }}>
                                                                <label for="is_top_deals-switch" class="switch">
                                                                    <span
                                                                        class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                            class="switch__circle-inner"></span></span>
                                                                    <span
                                                                        class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                                    <span
                                                                        class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="image">{{ trans('labels.image') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="file" id="edit_service_image"
                                                    class="form-control mb-1 @error('image') is-invalid @enderror"
                                                    name="image">
                                                <img src="{{ helper::image_path($servicedata->image) }}"
                                                    alt="{{ trans('labels.service') }}"
                                                    class="rounded edit-image hw-70 object-fit-cover">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="description">{{ trans('labels.description') }}
                                                </label>
                                                <textarea id="ckeditor" rows="3" class="form-control col-md-12 @error('description') is-invalid @enderror"
                                                    required name="description" placeholder="{{ trans('labels.service_description') }}">{!! $servicedata->description !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                    <a class="btn btn-danger px-sm-4"
                                        href="{{ URL::to('services') }}">{{ trans('labels.cancel') }}</a>
                                    @if (env('Environment') == 'sendbox')
                                        <button type="button" onclick="myFunction()"
                                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                    @else
                                        <button type="submit" id="btn_edit_service"
                                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                    @endif
                                </div>
                            </form>
                            <div class="add-new-imges">
                                <label class="form-label mt-3"><a class="btn btn-info btn-xs float-right add_gallery_image"
                                        data-id="{{ $servicedata->id }}" data-bs-toggle="modal"
                                        data-bs-target="#add_gallery_image">
                                        <i class="fa fa-plus me-1"></i>
                                        {{ trans('labels.add_gallery_image') }}</a>
                                </label>
                                @if (count($gimages) > 0)
                                    <div class="row g-4 mt-1">
                                        @foreach ($gimages as $si)
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
                                                <img src='{{ helper::image_path($si->image) }}' id="edit_gallery_image"
                                                    alt="{{ trans('labels.gallery') }}" height="200"
                                                    class="rounded w-100">
                                                <div class="col-sm-0 py-1">
                                                    <div class="d-flex justify-content-center gap-2" role="group"
                                                        aria-label="Basic example">
    
                                                        @if (env('Environment') == 'sendbox')
                                                            <a class="btn btn-danger" onclick="myFunction()"><i
                                                                    class="ft-trash"></i></a>
                                                        @else
                                                            <a class="btn btn-danger"
                                                                onclick="deletegallery('{{ $si->id }}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/del/gallery') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i
                                                                    class="ft-trash"></i></a>
                                                        @endif
                                                        <a class="btn btn-info edit_service_gallery"
                                                            data-id="{{ $si->id }}" data-userid="{{ $si->image }}"
                                                            data-image-url="{{ helper::image_path($si->image) }}"
                                                            data-bs-toggle="modal" data-bs-target="#edit_service_gallery">
                                                            <i class="ft-edit"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted text-center">{{ trans('labels.gallery_not_found') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script
        src="{{ asset('storage/app/public/admin-assets/vendors/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js') }}">
    </script>
    <script src="{{ asset('resources/views/service/service.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        // Edit gallery Image modal
        $(document).on('click', '.edit_service_gallery', function() {
            var imageid = $(this).attr('data-id');
            var imagename = $(this).attr('data-userid');
            var imageurl = $(this).attr('data-image-url');

            document.getElementById("gimage_id").value = imageid;
            document.getElementById("oldGalleryImg").src = imageurl;
        });

        CKEDITOR.replace('ckeditor');
    </script>
@endsection
