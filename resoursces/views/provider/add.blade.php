@extends('layout.main')
@section('page_title', trans('labels.add_provider'))
@section('content')
    <div class="container-fluid">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title color-changer fs-4 fw-600" id="horz-layout-colored-controls">{{ trans('labels.add_provider') }}
                    </h5>
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <form class="form form-horizontal" id="add_provider_form"
                                action="{{ URL::to('providers/store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">{{ trans('labels.name') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="add_provider_name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}"
                                                    placeholder="{{ trans('labels.enter_full_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="image">{{ trans('labels.profile') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="file" id="add_provider_image"
                                                    class="form-control @error('image') is-invalid @enderror" name="image"
                                                    value="{{ old('image') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="email">{{ trans('labels.email') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="email" id="add_provider_email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}"
                                                    placeholder="{{ trans('labels.enter_email') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="password">{{ trans('labels.password') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="password" id="add_provider_password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" value="{{ old('password') }}"
                                                    placeholder="{{ trans('labels.enter_password') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="provider_type">{{ trans('labels.provider_type') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select id="add_provider_providertype" name="provider_type" required
                                                    class="form-select @error('provider_type') is-invalid @enderror"
                                                    data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                    data-title="provider_type">
                                                    <option value="" selected disabled>{{ trans('labels.select') }}
                                                    </option>
                                                    @foreach ($providertypedata as $pt)
                                                        <option value="{{ $pt->id }}">{{ $pt->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="mobile">{{ trans('labels.mobile') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" id="add_provider_mobile"
                                                    class="form-control @error('mobile') is-invalid @enderror"
                                                    value="{{ old('mobile') }}" name="mobile"
                                                    placeholder="{{ trans('labels.enter_mobile') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="about">{{ trans('labels.about') }}
                                                    <span class="text-danger">*</span></label>
                                                <textarea id="add_provider_about" rows="2" class="form-control col-md-12 @error('about') is-invalid @enderror"
                                                    name="about" placeholder="{{ trans('labels.enter_about_provider') }}" required>{{ old('about') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="address">{{ trans('labels.address') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea id="add_provider_address" rows="2"
                                                    class="form-control col-md-12 @error('address') is-invalid @enderror" name="address"
                                                    placeholder="{{ trans('labels.enter_address') }}" required>{{ old('address') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="city">{{ trans('labels.city') }}
                                                    <span class="text-danger">*</span></label>
                                                <select id="add_provider_city" name="city_id" required
                                                    class="form-select @error('city_id') is-invalid @enderror"
                                                    data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                    data-title="City">
                                                    <option value="" selected disabled>{{ trans('labels.select') }}
                                                    </option>
                                                    @foreach ($citydata as $cd)
                                                        <option value="{{ $cd->id }}">{{ $cd->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                    <a class="btn btn-danger px-sm-4"
                                        href="{{ URL::to('providers') }}">{{ trans('labels.cancel') }}
                                    </a>
                                    @if (env('Environment') == 'sendbox')
                                        <button type="button" class="btn btn-primary px-sm-4"
                                            onclick="myFunction()">{{ trans('labels.save') }} </button>
                                    @else
                                        <button type="submit" id="btn_add_provider"
                                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }} </button>
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
