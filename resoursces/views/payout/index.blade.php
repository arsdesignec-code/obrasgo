@extends('layout.main')
@section('page_title', trans('labels.payout_request'))
@section('content')
    <section id="contenxtual">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title color-changer fs-4 fw-600">{{ trans('labels.payout_request') }}</h5>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                @include('payout.payout_table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('resources/views/payout/payout.js') }}" type="text/javascript"></script>
@endsection
