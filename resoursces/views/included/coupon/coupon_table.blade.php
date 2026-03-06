<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class=" fw-500">
            @if (@helper::checkaddons('bulk_delete'))
                @if($couponsdata->count() > 0)
                    <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                @endif
            @endif
            <th class="fw-500">{{ trans('labels.srno') }}</th>
            <th class="fw-500">{{ trans('labels.coupon_code') }}</th>
            <th class="fw-500">{{ trans('labels.title') }}</th>
            <th class="fw-500">{{ trans('labels.service_name') }}</th>
            <th class="fw-500">{{ trans('labels.discount') }}</th>
            <th class="fw-500">{{ trans('labels.start') }}-{{ trans('labels.expire') }}</th>
            <th class="fw-500">{{ trans('labels.description') }}</th>
            <th class="fw-500">{{ trans('labels.created_at') }}</th>
            <th class="fw-500">{{ trans('labels.update_at') }}</th>
            <th class="fw-500">{{ trans('labels.status') }}</th>
            <th class="fw-500">{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (count($couponsdata) > 0)
            <?php $i = 1; ?>
            @foreach ($couponsdata as $cdata)
                <tr>
                    @if (@helper::checkaddons('bulk_delete'))
                        <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $cdata->id }}"></td>
                    @endif
                    <td><?= $i++ ?></td>
                    <td>{{ $cdata->code }}</td>
                    <td>{{ $cdata->title }}</td>
                    <td>{{ $cdata->service_name }}</td>
                    <td>
                        @if ($cdata->discount_type == 1)
                            {{ helper::currency_format($cdata->discount) }}
                        @else
                            {{ $cdata->discount }}%
                        @endif
                    </td>
                    <td width="20%">
                        <div class="d-flex gap-2 flex-wrap">
                            <span class='badge text-bg-secondary'>{{ helper::date_format($cdata->start_date) }}</span>
                            <span class='badge text-bg-danger'>{{ helper::date_format($cdata->expire_date) }}</span>
                        </div>
                    </td>
                    <td>{{ Str::limit(strip_tags($cdata->description), 50) }}</td>
                    <td>{{ helper::date_format($cdata->created_at) }}<br>
                        {{ helper::time_format($cdata->created_at) }}
                    </td>
                    <td>{{ helper::date_format($cdata->updated_at) }}<br>
                        {{ helper::time_format($cdata->updated_at) }}
                    </td>
                    <td>
                        @if (env('Environment') == 'sendbox')
                            @if ($cdata->is_available == 1)
                                <a class="btn btn-outline-success btn-sm" onclick="myFunction()"><i
                                        class="ft-check"></i></a>
                            @else
                                <a class="btn btn-outline-danger btn-sm" onclick="myFunction()"><i
                                        class="ft-x"></i></a>
                            @endif
                        @else
                            @if ($cdata->is_available == 1)
                                <a class="btn btn-outline-success btn-sm"
                                    onclick="updatestatus('{{ $cdata->id }}','2','{{ URL::to('coupons/edit/status') }}')"><i
                                        class="ft-check"></i></a>
                            @else
                                <a class="btn btn-outline-danger btn-sm"
                                    onclick="updatestatus('{{ $cdata->id }}','1','{{ URL::to('coupons/edit/status') }}')"><i
                                        class="ft-x"></i></a>
                            @endif
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Edit" data-original-title="" title=""
                                href="{{ URL::to('/coupons/edit/' . $cdata->id) }}">
                                <i class="ft-edit"></i>
                            </a>

                            @if (env('Environment') == 'sendbox')
                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Remove" onclick="myFunction()"><i class="ft-trash"></i></a>
                            @else
                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Remove" data-original-title="" title=""
                                    onclick="deletecoupon('{{ $cdata->id }}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/coupons/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i
                                        class="ft-trash"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8" align="center">
                    {{ trans('labels.coupon_not_found') }}
                </td>
            </tr>

        @endif

    </tbody>
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
