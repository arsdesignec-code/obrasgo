<div class="table-responsive">
    <table class="table table-striped table-bordered py-3 zero-configuration w-100">
        <thead>
            <tr class=" fw-500">
                <th class="fw-500">{{ trans('labels.srno') }}</th>
                <th class="fw-500">{{ trans('labels.profile') }}</th>
                <th class="fw-500">{{ trans('labels.name') }}</th>
                <th class="fw-500">{{ trans('labels.city') }}</th>
                @if (Auth::user()->type == 1)
                    <th class="fw-500">
                        {{ trans('labels.provider') }}
                    </th>
                @endif
                <th class="fw-500">{{ trans('labels.email') }}</th>
                <th class="fw-500">{{ trans('labels.mobile') }}</th>
                <th class="fw-500">{{ trans('labels.created_at') }}</th>
                <th class="fw-500">{{ trans('labels.update_at') }}</th>
                @if (Auth::user()->type == 2)
                    <th class="fw-500">{{ trans('labels.status') }}</th>
                @endif
                <th class="fw-500">{{ trans('labels.action') }}</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($handymandata as $hdata)
                <tr>
                    <td><?= $i++ ?></td>
                    <td>
                        <img src="{{ helper::image_path($hdata->image) }}" alt="{{ trans('labels.image') }}"
                            class="rounded table-image object-fit-cover hw-50">
                    </td>
                    <td>{{ $hdata->name }}</td>
                    <td>{{ $hdata['city']->name }}</td>
                    @if (Auth::user()->type == 1)
                        <td>
                            {{ $hdata['providername']->name }}
                        </td>
                    @endif
                    <td>{{ $hdata->email }}</td>
                    <td>{{ $hdata->mobile }}</td>
                    <td>{{ helper::date_format($hdata->created_at) }}<br>
                        {{ helper::time_format($hdata->created_at) }}
                    </td>
                    <td>{{ helper::date_format($hdata->updated_at) }}<br>
                        {{ helper::time_format($hdata->updated_at) }}
                    </td>
                    @if (Auth::user()->type == 2)
                        <td>
                            @if (env('Environment') == 'sendbox')
                                @if ($hdata->is_available == 1)
                                    <a class="btn btn-outline-success btn-sm" onclick="myFunction()"><i
                                            class="ft-check"></i></a>
                                @else
                                    <a class="btn btn-outline-danger btn-sm" onclick="myFunction()"><i
                                            class="ft-x"></i></a>
                                @endif
                            @else
                                @if ($hdata->is_available == 1)
                                    <a class="btn btn-outline-success btn-sm"
                                        onclick="updatestatus('{{ $hdata->id }}','2','{{ URL::to('handymans-status') }}')"><i
                                            class="ft-check"></i></a>
                                @else
                                    <a class="btn btn-outline-danger btn-sm"
                                        onclick="updatestatus('{{ $hdata->id }}','1','{{ URL::to('handymans-status') }}')"><i
                                            class="ft-x"></i></a>
                                @endif
                            @endif
                        </td>
                    @endif
                    <td>
                        <div class="d-flex gap-1">
                            @if (Auth::user()->type == 2)
                                <a class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Login" href="{{ URL::to('/log-in-provider/' . $hdata->slug) }}"><i
                                        class="ft-log-in"></i>
                                </a>
                                <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Edit" href="{{ URL::to('/handymans/edit/' . $hdata->slug) }}">
                                    <i class="ft-edit"></i>
                                </a>
                            @endif
                            <a class="btn btn-dark btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="View" href="{{ URL::to('/handymans/' . $hdata->slug) }}">
                                <i class="ft-user"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
