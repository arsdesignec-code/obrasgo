@extends('layout.main')
@section('page_title', trans('labels.cities'))
@section('content')
    <section id="basic-form-layouts">
        <div class="container-fluid">
            <div class="col-md-12">
                <h5 class="card-title color-changer fs-4 fw-600" id="horz-layout-colored-controls">{{ trans('labels.how_works') }}</h5>
                <div class="card my-3">
                    <div class="card-body">
                        <form class="form form-horizontal" id="add_how_it_works_form" action="{{ URL::to('how-it-works/update') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="name">{{ trans('labels.title') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="text" id="add_provider_name"
                                                class="form-control @error('title') is-invalid @enderror"
                                                name="how_it_works_title" placeholder="{{ trans('labels.enter_title') }}"
                                                value="{{ $howitwork->how_it_works_title }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="name">{{ trans('labels.sub_title') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="text" id="add_provider_name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                name="how_it_works_sub_title" value="{{ $howitwork->how_it_works_sub_title }}"
                                                placeholder="{{ trans('labels.enter_sub_title') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="how_it_works_description">{{ trans('labels.description') }}
                                                <span class="text-danger">*</span></label>
                                            <textarea id="how_it_works_description" rows="5" class="form-control @error('name') is-invalid @enderror"
                                                name="how_it_works_description" placeholder="{{ trans('labels.enter_description') }}" required>{{ $howitwork->how_it_works_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="image">{{ trans('labels.image') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="file" id="add_provider_image"
                                                class="form-control @error('how_it_works_image') is-invalid @enderror"
                                                name="how_it_works_image" value="{{ old('how_it_works_image') }}">
                                            <div class="mt-2">
                                                <img src="{{ helper::image_path($howitwork->how_it_works_image) }}"
                                                    class="rounded edit-image hw-150" alt="{{ trans('labels.image') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
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
            <div class="d-flex justify-content-between align-items-center mt-3">
                <h5 class="card-title"></h5>
                @if (Auth::user()->type == 1)
                    <div class="d-flex align-items-center" style="gap: 10px;">
                        <!-- Bulk Delete Button -->
                        @if (@helper::checkaddons('bulk_delete'))
                            <button id="bulkDeleteBtn"
                                @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="deleteSelected('{{ URL::to('how-it-works/bulk_delete') }}')" @endif class="btn btn-danger hov btn-sm d-none d-flex" tooltip="{{ trans('labels.delete') }}">
                                <i class="fa-regular fa-trash"></i>
                            </button>
                        @endif
                        <a href="{{ URL::to('/how-it-works/add') }}"
                            class="btn btn-secondary d-flex align-items-center px-sm-4 gap-2">
                            <i class="fa fa-plus" height="16px"></i>{{ trans('labels.add') }}
                        </a>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                @include('how_it_works.how_it_work_table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
