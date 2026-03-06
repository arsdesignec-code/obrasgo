@extends('layout.main')
@section('page_title', trans('labels.currency-settings'))
@section('content')
    <section id="contenxtual">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title fs-4 color-changer fw-600">{{ trans('labels.currency-settings') }}</h5>
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <!-- Bulk Delete Button -->
                    @if (@helper::checkaddons('bulk_delete'))
                        <button id="bulkDeleteBtn"
                            @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="deleteSelected('{{ URL::to('admin/currency-settings/bulk_delete') }}')" @endif class="btn btn-danger hov btn-sm d-none d-flex" tooltip="{{ trans('labels.delete') }}">
                            <i class="fa-regular fa-trash"></i>
                        </button>
                    @endif
                    @if (@helper::checkaddons('currency_settigns'))
                        <a href="{{ URL::to('admin/currency-settings/add') }}"
                            class="btn btn-secondary px-sm-4 d-flex align-items-center gap-2">
                            <i class="fa fa-plus"></i> {{ trans('labels.add') }}
                        </a>
                    @endif
                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 my-3">
                        <div class="card-body">
                            <div class="">
                                <table class="table table-striped table-bordered zero-configuration">

                                    <thead>
                                        <tr class="text-capitalize fw-500 fs-15">
                                            @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                                @if (@helper::checkaddons('bulk_delete'))
                                                    @if($getcurrency->count() > 0)
                                                        <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                                                    @endif
                                                @endif
                                            @endif
                                            <th class="fw-500"></th>
                                            <th class="fw-500">#</th>
                                            <th class="fw-500">{{ trans('labels.name') }}</th>
                                            <th class="fw-500">{{ trans('labels.currency') }}</th>
                                            <th class="fw-500">{{ trans('labels.exchange_rate') }}</th>
                                            <th class="fw-500">{{ trans('labels.status') }}</th>
                                            <th class="fw-500">{{ trans('labels.default') }}</th>
                                            <th class="fw-500">{{ trans('labels.created_at') }}</th>
                                            <th class="fw-500">{{ trans('labels.update_at') }}</th>
                                            <th class="fw-500">{{ trans('labels.action') }}</th>


                                        </tr>
                                    </thead>
                                    <tbody id="tabledetails" data-url="">
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($getcurrency as $currency)
                                            <tr class="fs-7 row1 align-middle" id="dataid{{ $currency->id }}"
                                                data-id="{{ $currency->id }}">
                                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                                    @if (@helper::checkaddons('bulk_delete'))
                                                        @if (Strtoupper($currency->name) != 'USD')
                                                            <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $currency->id }}"></td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                    @endif
                                                @endif
                                                <td><a tooltip="{{ trans('labels.move') }}">
                                                        <i class="fa-light fa-up-down-left-right mx-2"></i>
                                                    </a>
                                                </td>
                                                <td>@php
                                                    echo $i++;
                                                @endphp </td>
                                                <td>{{ $currency->name }}</td>

                                                <td>
                                                    {{ $currency->currency }}
                                                </td>
                                                <td>
                                                    {{ $currency->exchange_rate }}
                                                </td>

                                                <td>
                                                    @if (env('Environment') == 'sendbox')
                                                        @if ($currency->is_available == 1)
                                                            <a class="btn btn-outline-success btn-sm"
                                                                onclick="myFunction()">
                                                                <i class="ft-check"></i>
                                                            </a>
                                                        @else
                                                            <a class="btn btn-outline-danger btn-sm" onclick="myFunction()">
                                                                <i class="ft-x"></i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        @if ($currency->is_available == 1)
                                                            <a class="btn btn-outline-success btn-sm"
                                                                onclick="statusupdate('{{ URL::to('admin/currency-settings/changestatus-' . $currency->code . '/2') }}')">
                                                                <i class="ft-check"></i>
                                                            </a>
                                                        @else
                                                            <a class="btn btn-outline-danger btn-sm"
                                                                onclick="statusupdate('{{ URL::to('admin/currency-settings/changestatus-' . $currency->code . '/1') }}')">
                                                                <i class="ft-x"></i>
                                                            </a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (env('Environment') == 'sendbox')
                                                        @if (helper::appdata()->default_currency == $currency->code)
                                                            <a class="btn btn-outline-success btn-sm"
                                                                onclick="myFunction()">
                                                                <i class="ft-check"></i>
                                                            </a>
                                                        @else
                                                            <a class="btn btn-outline-danger btn-sm" onclick="myFunction()">
                                                                <i class="ft-x"></i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        @if (helper::appdata()->default_currency == $currency->code)
                                                            <a class="btn btn-outline-success btn-sm"
                                                                onclick="statusupdate('{{ URL::to('admin/currency-settings/setdefault-' . $currency->code . '/2') }}')">
                                                                <i class="ft-check"></i>
                                                            </a>
                                                        @else
                                                            <a class="btn btn-outline-danger btn-sm"
                                                                onclick="statusupdate('{{ URL::to('admin/currency-settings/setdefault-' . $currency->code . '/1') }}')">
                                                                <i class="ft-x"></i>
                                                            </a>
                                                        @endif
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ helper::date_format($currency->created_at) }} <br>
                                                    {{ helper::time_format($currency->created_at) }}
                                                </td>
                                                <td>
                                                    {{ helper::date_format($currency->updated_at) }} <br>
                                                    {{ helper::time_format($currency->updated_at) }}
                                                </td>


                                                <td>
                                                    <div class="d-flex flex-wrap gap-2">

                                                        <a class="btn btn-sm btn-info square hov"
                                                            tooltip="{{ trans('labels.edit') }}"
                                                            href="{{ URL::to('admin/currency-settings/currency/edit-' . $currency->id) }}"><i
                                                                class="fa-solid fa-pen-to-square"></i></a>
                                                        @if (Strtoupper($currency->name) != 'USD')
                                                            <a class="btn btn-sm btn-danger square hov"
                                                                tooltip="{{ trans('labels.delete') }}"
                                                                @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/currency-settings/delete-' . $currency->id . '/1') }}')" @endif><i
                                                                    class="fa fa-trash"></i></a>
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
    </section>
@endsection
