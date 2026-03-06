<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class=" fw-500">
            @if (@helper::checkaddons('bulk_delete'))
                @if($providerdata->count() > 0)
                    <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                @endif
            @endif
            <th>{{ trans('labels.srno') }}</th>
            <th>{{ trans('labels.profile') }}</th>
            <th>{{ trans('labels.provider_type') }}</th>
            <th>{{ trans('labels.name') }}</th>
            <th>{{ trans('labels.email') }}</th>
            <th>{{ trans('labels.mobile') }}</th>
            <th>{{ trans('labels.created_at') }}</th>
            <th>{{ trans('labels.update_at') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @foreach ($providerdata as $pdata)
            <tr>
                @if (@helper::checkaddons('bulk_delete'))
                    <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $pdata->id }}"></td>
                @endif
                <td><?= $i++ ?></td>
                <td><img src="{{ helper::image_path($pdata->image) }}" alt="{{ trans('labels.provider') }}"
                        class="rounded table-image object-fit-cover hw-50"></td>
                <td>{{ $pdata['providertype']->name }}</td>
                <td>
                    {{ $pdata->name }}
                    <small class="d-block">({{ $pdata->city->name }})</small>
                </td>
                <td>{{ $pdata->email }}</td>
                <td>{{ $pdata->mobile }}</td>
                <td>{{ helper::date_format($pdata->created_at) }}<br>
                    {{ helper::time_format($pdata->created_at) }}
                </td>
                <td>{{ helper::date_format($pdata->updated_at) }}<br>
                    {{ helper::time_format($pdata->updated_at) }}
                </td>
                <td>
                    @if (env('Environment') == 'sendbox')
                        @if ($pdata->is_available == 1)
                            <a class="btn btn-outline-success btn-sm" onclick="myFunction()">
                                <i class="ft-check"></i></a>
                        @else
                            <a class="btn btn-outline-danger btn-sm" onclick="myFunction()">
                                <i class="ft-x"></i></a>
                        @endif
                    @else
                        @if ($pdata->is_available == 1)
                            <a class="btn btn-outline-success btn-sm"
                                onclick="updatestatus('{{ $pdata->id }}','2','{{ URL::to('providers/edit/status') }}')">
                                <i class="ft-check"></i></a>
                        @else
                            <a class="btn btn-outline-danger btn-sm"
                                onclick="updatestatus('{{ $pdata->id }}','1','{{ URL::to('providers/edit/status') }}')">
                                <i class="ft-x"></i></a>
                        @endif
                    @endif
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Login" href="{{ URL::to('/log-in-provider/' . $pdata->slug) }}">
                            <i class="ft-log-in"></i>
                        </a>
                        <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Edit" href="{{ URL::to('/providers/edit/' . $pdata->slug) }}">
                            <i class="ft-edit"></i>
                        </a>
                        <a class="btn btn-dark btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Details" href="{{ URL::to('/providers/' . $pdata->slug) }}">
                            <i class="ft-user"></i>
                        </a>
                        <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Delete"
                            onclick="logout('{{ URL::to('deleteaccount-' . $pdata->id) }}')">
                            <i class="ft-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
