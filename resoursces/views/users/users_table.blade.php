<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class="fw-500">
            <th class="fw-500">{{ trans('labels.srno') }}</th>
            <th class="fw-500">{{ trans('labels.profile') }}</th>
            <th class="fw-500">{{ trans('labels.name') }}</th>
            <th class="fw-500">{{ trans('labels.email') }}</th>
            <th class="fw-500">{{ trans('labels.mobile') }}</th>
            <th class="fw-500">{{ trans('labels.created_at') }}</th>
            <th class="fw-500">{{ trans('labels.update_at') }}</th>
            <th class="fw-500">{{ trans('labels.status') }}</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @foreach ($usersdata as $udata)
            <tr>
                <td><?= $i++ ?></td>
                <td> <img src="{{ helper::image_path($udata->image) }}" alt="{{ trans('labels.users') }}"
                        class="rounded table-image hw-50"> </td>
                <td>{{ $udata->name }}</td>
                <td>{{ $udata->email }}</td>
                <td>{{ $udata->mobile }}</td>
                <td>{{ helper::date_format($udata->created_at) }}<br>
                    {{ helper::time_format($udata->created_at) }}
                </td>
                <td>{{ helper::date_format($udata->updated_at) }}<br>
                    {{ helper::time_format($udata->updated_at) }}
                </td>
                <td>
                    @if (env('Environment') == 'sendbox')
                        @if ($udata->is_available == 1)
                            <a class="btn btn-success btn-sm" onclick="myFunction()"><i class="ft-check"></i></a>
                        @else
                            <a class="btn btn-danger btn-sm" onclick="myFunction()"><i class="ft-x"></i></a>
                        @endif
                    @else
                        @if ($udata->is_available == 1)
                            <a class="btn btn-success btn-sm"
                                onclick="updatestatus('{{ $udata->id }}','2','{{ URL::to('users/edit/status') }}')"><i
                                    class="ft-check"></i></a>
                        @else
                            <a class="btn btn-danger btn-sm"
                                onclick="updatestatus('{{ $udata->id }}','1','{{ URL::to('users/edit/status') }}')"><i
                                    class="ft-x"></i></a>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
