@extends('layout.main')
@section('page_title', trans('labels.services'))
@section('content')
<div class="container-fluid">
    <section id="ordering">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fs-4 color-changer fw-600">{{ trans('labels.services') }} </h5>
            @if (Auth::user()->type == 2)
                <div class="d-flex align-items-center" style="gap: 10px;">
                        <!-- Bulk Delete Button -->
                        @if (@helper::checkaddons('bulk_delete'))
                            <button id="bulkDeleteBtn"
                                @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="deleteSelected('{{ URL::to('services/bulk_delete') }}')" @endif class="btn btn-danger hov btn-sm d-none d-flex" tooltip="{{ trans('labels.delete') }}">
                                <i class="fa-regular fa-trash"></i>
                            </button>
                        @endif
                    <a href="{{ URL::to('/services-add') }}" class="btn btn-secondary gap-2 px-sm-4">
                        <i class="fa fa-plus" height="16px"></i>
                        {{ trans('labels.add') }}
                    </a>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 my-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            @include('service.service_table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('resources/views/service/service.js') }}" type="text/javascript"></script>
@endsection
