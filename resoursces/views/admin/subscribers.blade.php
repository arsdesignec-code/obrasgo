@extends('layout.main')
@section('page_title', trans('labels.subscribers'))
@section('content')
    <div class="container-fluid">
        <div class="row match-height">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title fs-4 color-changer fw-600" id="basic-layout-form-center">
                    {{ trans('labels.subscribers') }}</h5>
            </div>
            {{-- <div class="row"> --}}
            <div class="col-12">
                <div class="card border-0 my-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered m-0 zero-configuration w-100">
                                <thead>
                                    <tr class="text-capitalize">
                                        <th class="fw-500">{{ trans('labels.srno') }}</th>
                                        <th class="fw-500">{{ trans('labels.email') }}</th>
                                        <th class="fw-500">{{ trans('labels.created_at') }}</th>
                                        <th class="fw-500">{{ trans('labels.update_at') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($subscribers) && count($subscribers) > 0)
                                        @foreach ($subscribers as $key => $cd)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $cd->email }}</td>
                                                <td>{{ helper::date_format($cd->created_at) }}<br>
                                                    {{ helper::time_format($cd->created_at) }}
                                                </td>
                                                <td>{{ helper::date_format($cd->updated_at) }}<br>
                                                    {{ helper::time_format($cd->updated_at) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" align="center">
                                                {{ trans('labels.no_data') }}
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
    </div>
@endsection
