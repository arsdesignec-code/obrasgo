@extends('layout.main')
@section('page_title', trans('labels.providers'))
@section('content')
    <div class="container-fluid">
        <section id="contenxtual">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title fs-4 color-changer fw-600">{{ trans('labels.providers') }}</h5>
                @if (Auth::user()->type == 1)
                <div class="d-flex align-items-center" style="gap: 10px;">
                        <!-- Bulk Delete Button -->
                        @if (@helper::checkaddons('bulk_delete'))
                            <button id="bulkDeleteBtn"
                                @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="deleteSelected('{{ URL::to('bulk_delete_account') }}')" @endif class="btn btn-danger hov btn-sm d-none d-flex" tooltip="{{ trans('labels.delete') }}">
                                <i class="fa-regular fa-trash"></i>
                            </button>
                        @endif
                        <a href="{{ URL::to('/providers/add') }}"
                            class="btn btn-secondary px-sm-4 d-flex align-items-center gap-2">
                            <i class="fa fa-plus"></i>{{ trans('labels.add') }}
                        </a>
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <input type="hidden" name="url" id="provider_url" url="{{ route('providers') }}">
                                @include('provider.provider_table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('resources/views/provider/provider.js') }}" type="text/javascript"></script>
@endsection
