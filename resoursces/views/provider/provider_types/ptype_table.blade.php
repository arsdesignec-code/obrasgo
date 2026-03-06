<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class=" fw-500">
            @if (@helper::checkaddons('bulk_delete'))
                @if($providertypedata->count() > 0)
                    <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                @endif
            @endif
            <th class="fw-500">{{ trans('labels.srno') }}</th>
            <th class="fw-500">{{ trans('labels.type_name') }}</th>
            <th class="fw-500">{{ trans('labels.commission') }}</th>
            <th class="fw-500">{{ trans('labels.created_at') }}</th>
            <th class="fw-500">{{ trans('labels.update_at') }}</th>
            <th class="fw-500">{{ trans('labels.status') }}</th>
            <th class="fw-500">{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ URL::to('/reorder-provider-types') }}">
        @if (count($providertypedata) > 0)
            <?php $i = 1; ?>
            @foreach ($providertypedata as $ptd)
                <tr class="row1" id="dataid{{ $ptd->id }}" data-id="{{ $ptd->id }}">
                    @if (@helper::checkaddons('bulk_delete'))
                        <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $ptd->id }}"></td>
                    @endif
                    <td><?= $i++ ?></td>
                    <td>{{ $ptd->name }}</td>
                    <td>{{ $ptd->commission }}%</td>
                    <td>{{ helper::date_format($ptd->created_at) }}<br>
                        {{ helper::time_format($ptd->created_at) }}
                    </td>
                    <td>{{ helper::date_format($ptd->updated_at) }}<br>
                        {{ helper::time_format($ptd->updated_at) }}
                    </td>
                    <td>
                        @if (env('Environment') == 'sendbox')
                            @if ($ptd->is_available == 1)
                                <a class="btn btn-outline-success btn-sm" onclick="myFunction()"><i
                                        class="ft-check"></i></a>
                            @else
                                <a class="btn btn-outline-danger btn-sm" onclick="myFunction()"><i
                                        class="ft-x"></i></a>
                            @endif
                        @else
                            @if ($ptd->is_available == 1)
                                <a class="btn btn-outline-success btn-sm"
                                    onclick="updatestatus('{{ $ptd->id }}','2','{{ URL::to('provider_types/status') }}')"><i
                                        class="ft-check"></i></a>
                            @else
                                <a class="btn btn-outline-danger btn-sm"
                                    onclick="updatestatus('{{ $ptd->id }}','1','{{ URL::to('provider_types/status') }}')"><i
                                        class="ft-x"></i></a>
                            @endif
                        @endif

                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Edit" href="{{ URL::to('/provider_types/edit/' . $ptd->id) }}"><i
                                    class="ft-edit"></i></a>
                            @if (env('Environment') == 'sendbox')
                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Remove" onclick="myFunction()"><i class="ft-trash"></i></a>
                            @else
                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Remove"
                                    onclick="updatestatus('{{ $ptd->id }}','','{{ URL::to('/provider_types/del') }}')">
                                    <i class="ft-trash"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" align="center">
                    {{ trans('labels.ptype_not_found') }}
                </td>
            </tr>
        @endif

    </tbody>
</table>
