@extends('layout.main')
@section('page_title', trans('labels.banners'))
@section('content')
    <div class="container-fluid">
        <section id="contenxtual">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title fs-4 color-changer fw-600">{{ trans('labels.banners') }}</h5>
                <div class="d-flex align-items-center" style="gap: 10px;">
                        <!-- Bulk Delete Button -->
                        @if (@helper::checkaddons('bulk_delete'))
                            <button id="bulkDeleteBtn"
                                @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="deleteSelected('{{ URL::to('banners/bulk_delete') }}')" @endif class="btn btn-danger hov btn-sm d-none d-flex" tooltip="{{ trans('labels.delete') }}">
                                <i class="fa-regular fa-trash"></i>
                            </button>
                        @endif
                    <a href="{{ URL::to('/banners/add') }}" class="btn btn-secondary px-sm-4 d-flex align-items-center gap-2">
                        <i class="fa fa-plus"></i>{{ trans('labels.add') }}
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                @include('banner.banner_table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('resources/views/banner/banner.js') }}" type="text/javascript"></script>
@endsection
