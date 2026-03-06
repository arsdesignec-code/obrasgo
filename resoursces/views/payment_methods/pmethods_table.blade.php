@if (count($paymentmethodsdata) > 0)
    <table class="table table-striped table-bordered py-3 zero-configuration w-100">
        <thead>
            <tr class="fw-500">
                <th class="fw-500">{{ trans('labels.srno') }}</th>
                <th class="fw-500">{{ trans('labels.image') }}</th>
                <th class="fw-500">{{ trans('labels.name') }}</th>
                <th class="fw-500">{{ trans('labels.created_at') }}</th>
                <th class="fw-500">{{ trans('labels.update_at') }}</th>
                <th class="fw-500">{{ trans('labels.status') }}</th>
                <th class="fw-500">{{ trans('labels.action') }}</th>
            </tr>
        </thead>
        <tbody id="tabledetails" data-url="{{ URL::to('/reorder-payment-methods') }}">
            <?php $i = 1; ?>
            @foreach ($paymentmethodsdata as $pmdata)
                @php
                    // Check if the current $pmdata is a system addon and activated
                    if ($pmdata->payment_type == '1' || $pmdata->payment_type == '2') {
                        $systemAddonActivated = true;
                    } else {
                        $systemAddonActivated = false;
                    }
                    if (helper::checkaddons($pmdata->unique_identifier)) {
                        $systemAddonActivated = true;
                    }
                @endphp
                @if ($systemAddonActivated)
                    <tr class="row1" id="dataid{{ $pmdata->id }}" data-id="{{ $pmdata->id }}">
                        <td><?= $i++ ?></td>
                        <td><img src="{{ helper::image_path($pmdata->image) }}" alt="{{ trans('labels.image') }}"
                                class="rounded hw-50"></td>
                        <td>{{ $pmdata->payment_name }}</td>
                        <td>{{ helper::date_format($pmdata->created_at) }}<br>
                            {{ helper::time_format($pmdata->created_at) }}
                        </td>
                        <td>{{ helper::date_format($pmdata->updated_at) }}<br>
                            {{ helper::time_format($pmdata->updated_at) }}
                        </td>
                        <td>
                            @if (env('Environment') == 'sendbox')
                                @if ($pmdata->is_available == 1)
                                    <a class="btn btn-outline-success btn-sm" onclick="myFunction()"><i
                                            class="ft-check"></i></a>
                                @else
                                    <a class="btn btn-outline-danger btn-sm" onclick="myFunction()"><i
                                            class="ft-x"></i></a>
                                @endif
                            @else
                                @if ($pmdata->is_available == 1)
                                    <a class="btn btn-outline-success btn-sm"
                                        onclick="updatestatus('{{ $pmdata->id }}','2','{{ URL::to('payment-methods/status') }}')"><i
                                            class="ft-check"></i></a>
                                @else
                                    <a class="btn btn-outline-danger btn-sm"
                                        onclick="updatestatus('{{ $pmdata->id }}','1','{{ URL::to('payment-methods/status') }}')"><i
                                            class="ft-x"></i></a>
                                @endif
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Edit" data-original-title="" title=""
                                href="{{ URL::to('/payment-methods/' . $pmdata->id) }}">
                                <i class="ft-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@else
    <p class="text-center text-muted">{{ trans('labels.payment_not_found') }}</p>
@endif
