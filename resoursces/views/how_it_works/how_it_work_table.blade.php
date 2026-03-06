<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class=" fw-500">
            @if (@helper::checkaddons('bulk_delete'))
                @if($howitworkdata->count() > 0)
                    <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                @endif
            @endif
            <th class="fw-500">{{ trans('labels.srno') }}</th>
            <th class="fw-500">{{ trans('labels.image') }}</th>
            <th class="fw-500">{{ trans('labels.title') }}</th>
            <th class="fw-500">{{ trans('labels.description') }}</th>
            <th class="fw-500">{{ trans('labels.created_at') }}</th>
            <th class="fw-500">{{ trans('labels.update_at') }}</th>
            <th class="fw-500">{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ URL::to('/reorder-howitwork') }}">
        @if (count($howitworkdata) > 0)
            <?php $i = 1; ?>
            @foreach ($howitworkdata as $hitd)
                <tr class="row1" id="dataid{{ $hitd->id }}" data-id="{{ $hitd->id }}">
                    @if (@helper::checkaddons('bulk_delete'))
                        <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $hitd->id }}"></td>
                    @endif
                    <td><?= $i++ ?></td>
                    <td><img src="{{ helper::image_path($hitd->how_it_works_image) }}"
                            alt="{{ trans('labels.image') }}" class="rounded table-image hw-50"></td>
                    <td>{{ $hitd->how_it_works_title }}</td>
                    <td>{{ Str::limit($hitd->how_it_works_description, 80) }}</td>
                    <td>{{ helper::date_format($hitd->created_at) }}<br>
                        {{ helper::time_format($hitd->created_at) }}
                    </td>
                    <td>{{ helper::date_format($hitd->updated_at) }}<br>
                        {{ helper::time_format($hitd->updated_at) }}
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a class="btn btn-info btn-sm" data-original-title="" title=""
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"
                                href="{{ URL::to('/how-it-works/edit/' . $hitd->id) }}">
                                <i class="ft-edit"></i>
                            </a>
                            @if (env('Environment') == 'sendbox')
                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Remove" onclick="myFunction()"><i class="ft-trash"></i></a>
                            @else
                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Remove"
                                    onclick="updatestatus('{{ $hitd->id }}','','{{ URL::to('/how-it-works/del') }}')"><i
                                        class="ft-trash"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" align="center">
                    {{ trans('labels.how_it_work_not_found') }}
                </td>
            </tr>
        @endif
    </tbody>
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
