@extends('layout.main')
@section('page_title', trans('labels.edit_rovider_type'))
@section('content')
    <div class="container-fluid">
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title color-changer fs-4 fw-600" id="basic-layout-icons">
                        {{ trans('labels.edit_rovider_type') }} </h5>
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <form class="form" id="edit_provider_type_form"
                                action="{{ URL::to('/provider_types/edit/' . $updateprovidertypedata->id) }}"
                                method="POST">
                                @csrf
                                <div class="form-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group m-0">
                                                <label for="name" class="form-label"> {{ trans('labels.name') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="edit_provider_type_name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ $updateprovidertypedata->name }}"
                                                    placeholder="{{ trans('labels.enter_ptype_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group m-0">
                                                <label for="commission" class="form-label">{{ trans('labels.commission') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="edit_provider_type_commission"
                                                    class="form-control @error('commission') is-invalid @enderror"
                                                    name="commission" value="{{ $updateprovidertypedata->commission }}"
                                                    placeholder="{{ trans('labels.enter_commission') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="form-actions mt-3 text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                        <a class="btn btn-danger px-sm-4"
                                            href="{{ URL::to('/provider_types') }}">{{ trans('labels.cancel') }}</a>
                                        @if (env('Environment') == 'sendbox')
                                            <button type="button" class="btn btn-primary px-sm-4"
                                                onclick="myFunction()">{{ trans('labels.save') }}</button>
                                        @else
                                            <button type="submit" id="btn_edit_provider_type"
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
@section('scripts')
    <script src="{{ asset('resources/views/provider/provider_types/ptype.js') }}" type="text/javascript"></script>
@endsection
