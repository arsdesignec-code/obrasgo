@extends('layout.main')
@section('page_title', trans('labels.handymans'))
@section('content')
    <section id="ordering">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title color-changer fs-4 fw-600">{{ trans('labels.handyman') }}</h5>
                @if (Auth::user()->type == 2)
                    <a href="{{ URL::to('/handymans-add') }}" class="btn btn-secondary gap-2 px-sm-4">
                        <i class="fa fa-plus" height="16px"></i>
                        {{ trans('labels.add') }}
                    </a>
                @endif
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                @include('provider.handyman.handyman_table')
                            </div>
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
