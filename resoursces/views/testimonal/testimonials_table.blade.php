<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class=" fw-500">
            @if (@helper::checkaddons('bulk_delete'))
                @if($testimonials->count() > 0)
                    <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                @endif
            @endif
            <th class="fw-500">{{ trans('labels.srno') }}</th>
            <th class="fw-500">{{ trans('labels.image') }}</th>
            <th class="fw-500">{{ trans('labels.name') }}</th>
            <th class="fw-500">{{ trans('labels.rating') }}</th>
            <th class="fw-500">{{ trans('labels.description') }}</th>
            <th class="fw-500">{{ trans('labels.created_at') }}</th>
            <th class="fw-500">{{ trans('labels.update_at') }}</th>
            <th class="fw-500">{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ URL::to('/reorder-testimonials') }}">
        @if (count($testimonials) > 0)
            <?php $i = 1; ?>
            @foreach ($testimonials as $t)
                <tr class="row1" id="dataid{{ $t->id }}" data-id="{{ $t->id }}">
                    @if (@helper::checkaddons('bulk_delete'))
                        <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $t->id }}"></td>
                    @endif
                    <td><?= $i++ ?></td>
                    <td><img src="{{ helper::image_path($t->image) }}" alt="{{ trans('labels.image') }}"
                            class="rounded table-image hw-50"></td>
                    <td>{{ $t->name }}</td>
                    <td>{{ $t->rating }}</td>
                    <td>{{ Str::limit($t->description, 80) }}</td>
                    <td>{{ helper::date_format($t->created_at) }}<br>
                        {{ helper::time_format($t->created_at) }}
                    </td>
                    <td>{{ helper::date_format($t->updated_at) }}<br>
                        {{ helper::time_format($t->updated_at) }}
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a class="btn btn-info btn-sm" data-original-title="" title=""
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"
                                href="{{ URL::to('/testimonials/edit/' . $t->id) }}">
                                <i class="ft-edit"></i>
                            </a>
                            @if (env('Environment') == 'sendbox')
                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Remove" onclick="myFunction()"><i class="ft-trash"></i></a>
                            @else
                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Remove"
                                    onclick="updatestatus('{{ $t->id }}','','{{ URL::to('/testimonials/del') }}')"><i
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
                    {{ trans('labels.testimonial_not_found') }}
                </td>
            </tr>
        @endif
    </tbody>
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
