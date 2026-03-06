<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class="fw-500">
            @if (@helper::checkaddons('bulk_delete'))
                @if($categorydata->count() > 0)
                    <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                @endif
            @endif
            <th class="fw-500">{{ trans('labels.srno') }}</th>
            <th class="fw-500">{{ trans('labels.image') }}</th>
            <th class="fw-500">{{ trans('labels.name') }}</th>
            <th class="fw-500">{{ trans('labels.created_at') }}</th>
            <th class="fw-500">{{ trans('labels.update_at') }}</th>
            <th class="fw-500">{{ trans('labels.status') }}</th>
            <th class="fw-500">{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ URL::to('/reorder-category') }}">
        <?php $i = 1; ?>
        @foreach ($categorydata as $cdata)
            <tr class="row1" id="dataid{{ $cdata->id }}" data-id="{{ $cdata->id }}">
                @if (@helper::checkaddons('bulk_delete'))
                    <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $cdata->id }}"></td>
                @endif
                <td><?= $i++ ?></td>
                <td><img src="{{ helper::image_path($cdata->image) }}" alt="{{ trans('labels.image') }}"
                        class="rounded table-image hw-50"></td>
                <td>{{ $cdata->name }}</td>
                <td>{{ helper::date_format($cdata->created_at) }}<br>
                    {{ helper::time_format($cdata->created_at) }}
                </td>
                <td>{{ helper::date_format($cdata->updated_at) }}<br>
                    {{ helper::time_format($cdata->updated_at) }}
                </td>
                <td>
                    @if (env('Environment') == 'sendbox')
                        @if ($cdata->is_available == 1)
                            <a class="btn btn-outline-success btn-sm" onclick="myFunction()">
                                <i class="ft-check"></i>
                            </a>
                        @else
                            <a class="btn btn-outline-danger btn-sm" onclick="myFunction()">
                                <i class="ft-x"></i>
                            </a>
                        @endif
                    @else
                        @if ($cdata->is_available == 1)
                            <a class="btn btn-outline-success btn-sm"
                                onclick="updatestatus('{{ $cdata->id }}','2','{{ URL::to('categories/edit/status') }}')">
                                <i class="ft-check"></i>
                            </a>
                        @else
                            <a class="btn btn-outline-danger btn-sm"
                                onclick="updatestatus('{{ $cdata->id }}','1','{{ URL::to('categories/edit/status') }}')">
                                <i class="ft-x"></i>
                            </a>
                        @endif
                    @endif
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a class="btn btn-info btn-sm" data-original-title="" title="" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Edit"
                            href="{{ URL::to('/categories/edit/' . $cdata->slug) }}">
                            <i class="ft-edit"></i>
                        </a>
                        @if (env('Environment') == 'sendbox')
                            <a class="btn btn-danger btn-sm " data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Remove" onclick="myFunction()"><i class="ft-trash"></i></a>
                        @else
                            <a class="btn btn-danger btn-sm " data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Remove"
                                onclick="updatestatus('{{ $cdata->id }}','','{{ URL::to('/categories/del') }}')">
                                <i class="ft-trash"></i>
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
