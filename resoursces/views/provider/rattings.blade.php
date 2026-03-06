@extends('layout.main')
@section('page_title', trans('labels.reviews'))
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title fs-4 fw-600 color-changer">{{ trans('labels.rattings_reviews') }}</h5>
            </div>
            <div class="card border-0 my-3">
                @if (Auth::user()->type == 2)
                    <div class="card-header border-bottom">
                        <h5 class="card-title color-changer m-0">
                            {{ trans('labels.average_ratting') }}
                            <span class="badge fs-15 bg-dark text-right">
                                <i class="fa fa-star text-warning"></i>
                                {{ number_format($averageratting->avg_ratting, 1) }}
                            </span>
                        </h5>
                    </div>
                @endif
                <div class="card-body">
                    <div class="col-12">
                        <div class="row g-3">
                            @if (Auth::user()->type == 1)
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="col-form-label"
                                            for="provider_name">{{ trans('labels.provider_name') }}</label>
                                        <select name="provider_name" class="form-select" id="provider_name">
                                            <option value="" selected>{{ trans('labels.select') }}</option>
                                            @foreach ($getprovider as $provider)
                                                <option value="{{ $provider->id }}"
                                                    {{ $psorter == $provider->id ? 'selected' : '' }}>
                                                    {{ $provider->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="{{ Auth::user()->type == 1 ? 'col-6' : 'col-12' }}">
                                <div class="form-group">
                                    <label class="col-form-label"
                                        for="service_name">{{ trans('labels.service_name') }}</label>
                                    <select name="service_name" class="form-select" id="service_name">
                                        <option value="" selected>{{ trans('labels.select') }}</option>
                                        @foreach ($getservice as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $sorter == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('provider.rattings_table')
                </div>
            </div>
        </div>
        @if (Auth::user()->type == 1)
            <form id="service_filter_review">
                <input type="hidden" name="provider_id" id="sorter_provider_name" value="{{ @$psorter }}">
                <input type="hidden" name="service_id" id="sorter_service_name" value="">
            </form>
        @endif
        @if (Auth::user()->type == 2)
            <form id="service_filter_review">
                <input type="hidden" name="service_id" id="sorter_service_name" value="{{ @$sorter }}">
            </form>
        @endif
    </div>
@endsection
@section('scripts')
    <script>
        $('#service_name').change(function() {
            var selectedValue = $(this).val();
            $('#sorter_service_name').val(selectedValue);
            $("#service_filter_review").submit();
        });
        $('#provider_name').change(function() {
            var selectedValue = $(this).val();
            $('#sorter_provider_name').val(selectedValue);
            $("#service_filter_review").submit();
        });
    </script>
    <script src="{{ asset('resources/views/provider/provider.js') }}" type="text/javascript"></script>
@endsection
