@extends('layout.main')
@section('page_title', trans('labels.add_handyman'))
@section('content')
    <section id="basic-form-layouts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fs-4 color-changer fw-600" id="horz-layout-colored-controls">{{ trans('labels.add_handyman') }}</h5>
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <form class="form form-horizontal" id="add_handyman_form" action="{{ URL::to('handymans-store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">
                                                    {{ trans('labels.name') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" id="add_handyman_name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}"
                                                    placeholder="{{ trans('labels.enter_full_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="image">{{ trans('labels.profile') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="file" id="add_handyman_image"
                                                    class="form-control @error('image') is-invalid @enderror" name="image"
                                                    value="{{ old('image') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="email">{{ trans('labels.email') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="email" id="add_handyman_email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" placeholder="example1@yourmail.com" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="password">{{ trans('labels.password') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="password" id="add_handyman_password"
                                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                                    value="{{ old('password') }}"
                                                    placeholder="{{ trans('labels.enter_password') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="mobile">{{ trans('labels.mobile') }}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" id="add_handyman_mobile"
                                                    class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                                                    placeholder="Enter Mobile Number" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="userinput4">{{ trans('labels.city') }}
                                                    <span class="text-danger">*</span></label>
                                                <select id="add_handyman_city" name="city_id" required
                                                    class="form-control @error('city_id') is-invalid @enderror"
                                                    data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                                    data-title="City">
                                                    <option value="" selected>{{ trans('labels.select') }}
                                                    </option>
                                                    @foreach ($citydata as $cd)
                                                        <option value="{{ $cd->id }}">{{ $cd->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="address">{{ trans('labels.address') }}
                                                    <span class="text-danger">*</span></label>
                                                <textarea id="add_handyman_address" rows="3" class="form-control col-md-12 @error('address') is-invalid @enderror"
                                                    name="address" placeholder="{{ trans('labels.enter_address') }}" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                    <a class="btn btn-danger px-sm-4"
                                        href="{{ URL::to('handymans') }}">{{ trans('labels.cancel') }} </a>
                                    @if (env('Environment') == 'sendbox')
                                        <button type="button" onclick="myFunction()" class="btn btn-primary px-sm-4">
                                            {{ trans('labels.save') }} </button>
                                    @else
                                        <button type="submit" id="btn_add_handyman" class="btn btn-primary px-sm-4">
                                            {{ trans('labels.save') }} </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('resources/views/provider/handyman/handyman.js') }}" type="text/javascript"></script>
@endsection
