@extends('layout.main')
@section('page_title', trans('labels.tax'))
@section('content')
    <section id="contenxtual">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title fs-4 color-changer fw-600">{{ trans('labels.tax') }}</h5>
                <div class="d-flex align-items-center" style="gap: 10px;">
                        <!-- Bulk Delete Button -->
                        @if (@helper::checkaddons('bulk_delete'))
                            <button id="bulkDeleteBtn"
                                @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="deleteSelected('{{ URL::to('tax/bulk_delete') }}')" @endif class="btn btn-danger hov btn-sm d-none d-flex" tooltip="{{ trans('labels.delete') }}">
                                <i class="fa-regular fa-trash"></i>
                            </button>
                        @endif
                        <a href="{{ URL::to('/tax/add') }}" class="btn btn-secondary px-sm-4 d-flex align-items-center gap-2">
                            <i class="fa fa-plus"></i> {{ trans('labels.add') }}
                        </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                @include('tax.tax_table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
