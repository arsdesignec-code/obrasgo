@extends('layout.main')
@section('page_title', request()->is('reports') ? trans('labels.reports') : trans('labels.bookings'))
@section('content')
    <div class="container-fluid">
        <section id="contenxtual">
            <div class="d-flex justify-content-between align-items-center">
                @if (request()->is('reports'))
                    <h5 class="card-title color-changer fs-4 fw-600">{{ trans('labels.reports') }}</h5>
                @else
                    <h5 class="card-title color-changer fs-4 fw-600">{{ trans('labels.bookings') }}</h5>
                @endif
                @if (request()->is('reports'))
                    <form action="{{ URL::to('reports') }}">
                        <div class="input-group gap-2 col-md-12 ps-0 justify-content-end">
                            @if (Auth::user()->type == 1 || (Auth::user()->type == 2 && @helper::checkaddons('customer_login')))
                                @if ($getcustomerslist->count() > 0)
                                    <div class="input-group-append col-auto px-1">
                                        <select name="{{ Auth::user()->type == 2 ? 'customer_id' : 'provider_id' }}"
                                            class="form-select">
                                            <option value="">
                                                {{ trans(Auth::user()->type == 2 ? 'labels.select_customer' : 'labels.select_provider') }}
                                            </option>
                                            @foreach ($getcustomerslist as $getcustomer)
                                                <option value="{{ $getcustomer->id }}"
                                                    {{ $getcustomer->id == @$_GET[Auth::user()->type == 2 ? 'customer_id' : 'provider_id'] ? 'selected' : '' }}>
                                                    {{ $getcustomer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endif

                            <div class="input-group-append col-auto">
                                <input type="date" class="form-control" name="startdate"
                                    @isset($_GET['startdate']) value="{{ $_GET['startdate'] }}" @endisset required>
                            </div>
                            <div class="input-group-append col-auto">

                                <input type="date" class="form-control" name="enddate"
                                    @isset($_GET['enddate']) value="{{ $_GET['enddate'] }}" @endisset required>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="submit">{{ trans('labels.fetch') }}</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
            @include('booking.statistics')
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                @include('booking.booking_table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('resources/views/booking/booking.js') }}" type="text/javascript"></script>
@endsection
