@extends('layout.main')
@section('page_title', trans('labels.contact_us'))
@section('content')
    <div class="container-fluid">
        <div class="match-height">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title fs-4 color-changer fw-600" id="basic-layout-form-center">{{ trans('labels.contact_us') }}</h5>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered py-3 zero-configuration w-100">
                                    <thead>
                                        <tr class=" fw-500">
                                            <th class="fw-500">{{ trans('labels.srno') }}</th>
                                            <th class="fw-500">{{ trans('labels.name') }}</th>
                                            <th class="fw-500">{{ trans('labels.email') }}</th>
                                            <th class="fw-500">{{ trans('labels.mobile') }}</th>
                                            <th class="fw-500">{{ trans('labels.message') }}</th>
                                            <th class="fw-500">{{ trans('labels.created_at') }}</th>
                                            <th class="fw-500">{{ trans('labels.update_at') }}</th>
                                            <th class="fw-500">{{ trans('labels.status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contactdata as $hdata)
                                            <tr>
                                                <td>{{ $hdata->id }}</td>
                                                <td>{{ $hdata->fname }} {{ $hdata->lname }}</td>
                                                <td>{{ $hdata->email }}</td>
                                                <td>{{ $hdata->mobile }}</td>
                                                <td>{!! $hdata->message !!}</td>
                                                <td>{{ helper::date_format($hdata->created_at) }}<br>
                                                    {{ helper::time_format($hdata->created_at) }}
                                                </td>
                                                <td>{{ helper::date_format($hdata->updated_at) }}<br>
                                                    {{ helper::time_format($hdata->updated_at) }}
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        @if ($hdata->status == 1)
                                                            <button
                                                                class="btn btn-info btn-sm d-flex align-items-center gap-1"
                                                                onclick="updatestatus('{{ $hdata->id }}','2','{{ URL::to('/contact-us/status') }}')">
                                                                <i
                                                                    class="ft-clock"></i>{{ trans('labels.pending') }}</button>
                                                        @else
                                                            <span class="badge text-bg-success"><i class="ft-check"></i>
                                                                {{ trans('labels.completed') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
