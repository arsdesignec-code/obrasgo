@extends('layout.main')
@section('page_title', trans('labels.edit_provider'))
@section('content')
    <div class="container-fluid">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title color-changer fs-4 fw-600" id="horz-layout-colored-controls">{{ trans('labels.edit_provider') }}
                    </h5>
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <form class="form form-horizontal row" id="edit_provider_form"
                                action="{{ URL::to('/providers/edit/' . $providerdata->slug) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-12">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">{{ trans('labels.name') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="edit_provider_name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ $providerdata->name }}"
                                                    placeholder="{{ trans('labels.enter_full_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="email">{{ trans('labels.email') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="email" id="edit_provider_email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ $providerdata->email }}"
                                                    placeholder="{{ trans('labels.enter_email') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="mobile">{{ trans('labels.mobile') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="edit_provider_mobile"
                                                    class="form-control @error('mobile') is-invalid @enderror"
                                                    name="mobile" value="{{ $providerdata->mobile }}"
                                                    placeholder="{{ trans('labels.enter_mobile') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="provider_type">{{ trans('labels.provider_type') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select id="edit_provider_provider_type" name="provider_type" required
                                                    class="form-select @error('provider_type') is-invalid @enderror"
                                                    data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                    data-title="{{ trans('labels.provider_type') }}">
                                                    <option value="{{ $providerdata['providertype']->id }}" selected>
                                                        {{ $providerdata['providertype']->name }}</option>
                                                    @foreach ($providertypedata as $pt)
                                                        <option value="{{ $pt->id }}">{{ $pt->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="new_image">{{ trans('labels.profile') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="file" id="edit_provider_image"
                                                    class="form-control mb-1 @error('image') is-invalid @enderror"
                                                    name="image">
                                                <img src="{{ helper::image_path($providerdata->image) }}"
                                                    alt="{{ trans('labels.provider') }}" class="rounded hw-70">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="userinput4">{{ trans('labels.city') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select id="edit_provider_city_id" name="city_id" required
                                                    class="form-select @error('city_id') is-invalid @enderror"
                                                    data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                    data-title="City">
                                                    <option value="{{ $providerdata['city']->id }}" selected>
                                                        {{ $providerdata['city']->name }}</option>
                                                    @foreach ($citydata as $cd)
                                                        <option value="{{ $cd->id }}">{{ $cd->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="about">{{ trans('labels.about') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea id="edit_provider_about" rows="3" class="form-control @error('about') is-invalid @enderror"
                                                    name="about" placeholder="{{ trans('labels.enter_about_provider') }}" required>{{ $providerdata->about }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="address">{{ trans('labels.address') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea id="edit_provider_address" rows="3" required
                                                    class="form-control col-md-12 @error('address') is-invalid @enderror" name="address"
                                                    placeholder="{{ trans('labels.enter_address') }}">{{ $providerdata->address }}</textarea>
                                            </div>
                                        </div>

                                        {{-- <div class="form-group row">
                                        <label class="form-label"
                                            for="is_available">{{ trans('labels.status') }}</label>
    
                                        <div class="form-check form-switch">
                                            <input class="form-check-input " type="checkbox" id="is_available"
                                                name="is_available" value="is_available"
                                                @if ($providerdata->is_available == 1) checked="true" @endif>
                                            <label class="form-check-label "
                                                for="is_available">{{ trans('labels.active') }}</label>
                                        </div>
    
                                    </div> --}}
                                    </div>
                                </div>
                                <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                    <a class="btn btn-danger px-sm-4"
                                        href="{{ URL::to('providers') }}">{{ trans('labels.cancel') }} </a>
                                    @if (env('Environment') == 'sendbox')
                                        <button type="button" class="btn btn-primary px-sm-4"
                                            onclick="myFunction()">{{ trans('labels.save') }}
                                        </button>
                                    @else
                                        <button type="submit" id="btnAddProvider"
                                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }}
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('resources/views/provider/provider.js') }}" type="text/javascript"></script>
@endsection
