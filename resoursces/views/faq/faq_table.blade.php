<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class=" fw-500">
            @if (@helper::checkaddons('bulk_delete'))
                @if($faqdata->count() > 0)
                    <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                @endif
            @endif
            <th class="fw-500">{{ trans('labels.srno') }}</th>
            <th class="fw-500">{{ trans('labels.question') }}</th>
            <th class="fw-500">{{ trans('labels.answers') }}</th>
            <th class="fw-500">{{ trans('labels.created_at') }}</th>
            <th class="fw-500">{{ trans('labels.update_at') }}</th>
            <th class="fw-500">{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ URL::to('/reorder-faq') }}">
        @if (count($faqdata) > 0)
            <?php $i = 1; ?>
            @foreach ($faqdata as $fd)
                <tr class="row1" id="dataid{{ $fd->id }}" data-id="{{ $fd->id }}">
                    @if (@helper::checkaddons('bulk_delete'))
                        <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $fd->id }}"></td>
                    @endif
                    <td><?= $i++ ?></td>
                    <td>{{ $fd->question }}</td>
                    <td>{{ Str::limit($fd->answer, 100) }}</td>
                    <td>{{ helper::date_format($fd->created_at) }}<br>
                        {{ helper::time_format($fd->created_at) }}
                    </td>
                    <td>{{ helper::date_format($fd->updated_at) }}<br>
                        {{ helper::time_format($fd->updated_at) }}
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a class="btn btn-info btn-sm" data-original-title="" title=""
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"
                                href="{{ URL::to('/faq/edit/' . $fd->id) }}">
                                <i class="ft-edit"></i>
                            </a>
                            @if (env('Environment') == 'sendbox')
                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Remove" onclick="myFunction()"><i class="ft-trash"></i></a>
                            @else
                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Remove"
                                    onclick="updatestatus('{{ $fd->id }}','','{{ URL::to('/faq/del') }}')"><i
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
                    {{ trans('labels.faq_not_found') }}
                </td>
            </tr>
        @endif
    </tbody>
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
