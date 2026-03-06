@extends('layout.main')
@section('page_title', trans('labels.timing'))
@section('content')
    <section id="basic-form-layouts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="panel-title color-changer fs-4 fw-600 mb-3 m-sm-0" id="horz-layout-colored-controls">{{ trans('labels.timing') }}</h5>
                    <div class="card my-3">
                        <div class="card-body">
                            <form action="{{ URL::to('timings/edit') }}" method="post">
                                @csrf
                                <div class="row">
                                    <label class="col-sm-2 form-label"></label>
                                    <div class="form-group col-sm-3 col-4 text-center"><label
                                            class="fw-600">{{ trans('labels.opening_time') }}</label></div>
                                    <div class="form-group col-sm-3 col-4 text-center"><label
                                            class="fw-600">{{ trans('labels.closing_time') }}</label></div>
                                    <div class="form-group col-sm-3 col-4 text-center"><label
                                            class="fw-600">{{ trans('labels.always_closed') }}</label></div>
                                </div>
                                @foreach ($timingdata as $time)
                                    <div class="row">
                                        <label class="col-sm-2 form-label text-center fw-600">
                                            @if ($time->day == 'Monday')
                                                {{ trans('labels.Monday') }}
                                            @endif
                                            @if ($time->day == 'Tuesday')
                                                {{ trans('labels.Tuesday') }}
                                            @endif
                                            @if ($time->day == 'Wednesday')
                                                {{ trans('labels.Wednesday') }}
                                            @endif
                                            @if ($time->day == 'Thursday')
                                                {{ trans('labels.Thursday') }}
                                            @endif
                                            @if ($time->day == 'Friday')
                                                {{ trans('labels.Friday') }}
                                            @endif
                                            @if ($time->day == 'Saturday')
                                                {{ trans('labels.Saturday') }}
                                            @endif
                                            @if ($time->day == 'Sunday')
                                                {{ trans('labels.Sunday') }}
                                            @endif
                                        </label>
                                        <input type="hidden" name="day[]" value="{{ $time->day }}">
                                        <div class="form-group col-sm-3 col-4">
                                            <input type="text" class="form-control pickatime" placeholder="Opening time"
                                                id="open{{ $time->day }}" name="open_time[]"
                                                @if ($time->is_always_close == '2') value="{{ $time->open_time }}" @else value="{{ trans('labels.closed') }}" readonly="" @endif>
                                        </div>
                                        <div class="form-group col-sm-3 col-4">
                                            <input type="text" class="form-control pickatime" placeholder="Closing Time"
                                                id="close{{ $time->day }}" name="close_time[]"
                                                @if ($time->is_always_close == '2') value="{{ $time->close_time }}" @else value="{{ trans('labels.closed') }}" readonly="" @endif>
                                        </div>
                                        <div class="form-group col-sm-3 col-4">
                                            <select class="form-control" name="is_always_close[]"
                                                id="is_always_close{{ $time->day }}">
                                                <option value="" disabled>{{ trans('labels.select') }}</option>
                                                <option value="1" @if ($time->is_always_close == '1') selected @endif>
                                                    {{ trans('labels.yes') }}</option>
                                                <option value="2" @if ($time->is_always_close == '2') selected @endif>
                                                    {{ trans('labels.no') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                    @if (env('Environment') == 'sendbox')
                                        <button type="button" onclick="myFunction()"
                                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                    @else
                                        <button type="submit" class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
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
    <script src="{{ asset('storage/app/public/admin-assets/js/jquery.timepicker.js') }}" defer></script>
    <script src="{{ asset('resources/views/timing/timing.js') }}"></script>
@endsection
