<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class=" fw-500">
            @if (@helper::checkaddons('bulk_delete'))
                @if($taxdata->count() > 0)
                    <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                @endif
            @endif
            <th class="fw-500">{{ trans('labels.srno') }}</th>
            <th class="fw-500">{{ trans('labels.name') }}</th>
            <th class="fw-500">{{ trans('labels.tax') }}</th>
            <th class="fw-500">{{ trans('labels.created_at') }}</th>
            <th class="fw-500">{{ trans('labels.update_at') }}</th>
            <th class="fw-500">{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @foreach ($taxdata as $tdata)
            <tr class="row1" id="dataid{{ $tdata->id }}" data-id="{{ $tdata->id }}">
                @if (@helper::checkaddons('bulk_delete'))
                    <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $tdata->id }}"></td>
                @endif
                <td><?= $i++ ?></td>
                <td>{{ $tdata->name }}</td>
                <td>
                    @if ($tdata->type == 1)
                        {{ helper::currency_format($tdata->tax) }}
                    @elseif ($tdata->type == 2)
                        {{ $tdata->tax }}%
                    @endif
                </td>
                <td>{{ helper::date_format($tdata->created_at) }}<br>
                    {{ helper::time_format($tdata->created_at) }}
                </td>
                <td>{{ helper::date_format($tdata->updated_at) }}<br>
                    {{ helper::time_format($tdata->updated_at) }}
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Edit" href="{{ URL::to('/tax/edit/' . $tdata->id) }}">
                            <i class="ft-edit"></i>
                        </a>
                        @if (env('Environment') == 'sendbox')
                            <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Remove" onclick="myFunction()">
                                <i class="ft-trash"></i>
                            </a>
                        @else
                            <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Remove"
                                onclick="updatestatus('{{ $tdata->id }}','','{{ URL::to('/tax/del') }}')">
                                <i class="ft-trash"></i>
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
