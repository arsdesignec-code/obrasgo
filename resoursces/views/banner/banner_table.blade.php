<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class="fw-500">
            @if (@helper::checkaddons('bulk_delete'))
                @if($bannerdata->count() > 0)
                    <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                @endif
            @endif
            <th class="fw-500">{{ trans('labels.srno') }}</th>
            <th class="fw-500">{{ trans('labels.image') }}</th>
            <th class="fw-500">{{ trans('labels.banner_section') }}</th>
            <th class="fw-500">{{ trans('labels.category_name') }}</th>
            <th class="fw-500">{{ trans('labels.created_at') }}</th>
            <th class="fw-500">{{ trans('labels.update_at') }}</th>
            <th class="fw-500">{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ URL::to('/reorder-banner') }}">
        @if (count($bannerdata) > 0)
            <?php $i = 1; ?>
            @foreach ($bannerdata as $bdata)
                <tr class="row1" id="dataid{{ $bdata->id }}" data-id="{{ $bdata->id }}">
                    @if (@helper::checkaddons('bulk_delete'))
                        <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $bdata->id }}"></td>
                    @endif
                    <td><?= $i++ ?></td>
                    <td>
                        <img src="{{ helper::image_path($bdata->image) }}" alt="{{ trans('labels.banner') }}"
                            class="rounded table-image h-60px">
                    </td>
                    @if ($bdata->section == 1)
                        <td>{{ trans('labels.banner_section_1') }}</td>
                    @endif
                    @if ($bdata->section == 2)
                        <td>{{ trans('labels.banner_section_2') }}</td>
                    @endif
                    @if ($bdata->type == 1)
                        <td>{{ $bdata['categoryname']->name }}</td>
                    @else
                        <td>-</td>
                    @endif
                    <td>{{ helper::date_format($bdata->created_at) }}<br>
                        {{ helper::time_format($bdata->created_at) }}
                    </td>
                    <td>{{ helper::date_format($bdata->updated_at) }}<br>
                        {{ helper::time_format($bdata->updated_at) }}
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Edit" href="{{ URL::to('/banners/edit/' . $bdata->id) }}">
                                <i class="ft-edit"></i>
                            </a>
                            @if (env('Environment') == 'sendbox')
                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Remove" onclick="myFunction()"><i class="ft-trash"></i>
                                @else
                                    <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Remove"
                                        onclick="updatestatus('{{ $bdata->id }}','','{{ URL::to('/banners/del') }}')"><i
                                            class="ft-trash"></i>
                                    </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" align="center">
                    {{ trans('labels.no_data') }}
                </td>
            </tr>
        @endif
    </tbody>
</table>
