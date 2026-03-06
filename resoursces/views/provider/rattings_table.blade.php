<div class="table-responsive">
    <table class="table table-striped table-bordered py-3 zero-configuration w-100">
        <thead>
            <tr class=" fw-500">
                <th class="fw-500">{{ trans('labels.srno') }}</th>
                <th class="fw-500">{{ trans('labels.image') }}</th>
                <th class="fw-500">{{ trans('labels.name') }}</th>
                <th class="fw-500">{{ trans('labels.rating') }}</th>
                <th class="fw-500">{{ trans('labels.description') }}</th>
                <th class="fw-500">{{ trans('labels.created_at') }}</th>
                <th class="fw-500">{{ trans('labels.update_at') }}</th>
                <th class="fw-500">{{ trans('labels.status') }}</th>
                @if (Auth::user()->type == 1)
                    <th class="fw-500">{{ trans('labels.action') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($rattingsdata as $rdata)
                <tr>
                    <td><?= $i++ ?></td>
                    <td><img src="{{ helper::image_path($rdata->user_image) }}" alt="{{ trans('labels.image') }}"
                            class="rounded table-image hw-50">
                    </td>
                    <td>{{ $rdata->user_name }}</td>
                    <td>
                        <i class="fa-solid fa-star text-warning"></i>
                        <span class="d-inline-block average-rating">{{ number_format($rdata->ratting, 1) }}</span>
                    </td>
                    <td>{{ Str::limit($rdata->comment, 80) }}</td>
                    <td>{{ helper::date_format($rdata->created_at) }}<br>
                        {{ helper::time_format($rdata->created_at) }}
                    </td>
                    <td>{{ helper::date_format($rdata->updated_at) }}<br>
                        {{ helper::time_format($rdata->updated_at) }}
                    </td>
                    <td>
                        @if (env('Environment') == 'sendbox')
                            @if ($rdata->status == 1)
                                <a class="btn btn-outline-success btn-sm" onclick="myFunction()"><i
                                        class="ft-check"></i></a>
                            @else
                                <a class="btn btn-outline-danger btn-sm" onclick="myFunction()"><i
                                        class="ft-x"></i></a>
                            @endif
                        @else
                            @if ($rdata->status == 1)
                                <a class="btn btn-outline-success btn-sm"
                                    onclick="updatestatus('{{ $rdata->id }}','2','{{ URL::to('reviews/status') }}')">
                                    <i class="ft-check"></i></a>
                            @else
                                <a class="btn btn-outline-danger btn-sm"
                                    onclick="updatestatus('{{ $rdata->id }}','1','{{ URL::to('reviews/status') }}')">
                                    <i class="ft-x"></i></a>
                            @endif
                        @endif
                    </td>
                    @if (Auth::user()->type == 1)
                        <td>
                            @if (env('Environment') == 'sendbox')
                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Remove" onclick="myFunction()"><i class="ft-trash"></i></a>
                            @else
                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Remove"
                                    onclick="deleteservicerating( '{{ $rdata->id }}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/services/serviceRatingdestroy') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i
                                        class="ft-trash"></i>
                                </a>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
