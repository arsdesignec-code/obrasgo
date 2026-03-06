<div class="table-responsive">
    <table class="table bg-transparent m-0 table-bordered table-striped zero-configuration">
        <thead>
            <tr class="fw-500">
                <th class="fw-500">{{ trans('labels.srno') }}</th>
                <th class="fw-500">{{ trans('labels.image') }}</th>
                <th class="fw-500">{{ trans('labels.service_name') }}</th>
                <th class="fw-500">{{ trans('labels.booking_id') }}</th>
                <th class="fw-500">{{ trans('labels.date_time') }}</th>
                <th class="fw-500">{{ trans('labels.status') }}</th>
                <th class="fw-500">{{ trans('labels.action') }}</th>
            </tr>
        </thead>
        <tbody>
            {{-- @if (count($recent_bookings) > 0) --}}
            @foreach ($recent_bookings as $key => $bdata)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td><img src="{{ helper::image_path($bdata->service_image) }}" alt="{{ trans('labels.image') }}"
                            class="rounded table-image hw-50"></td>
                    <td>{{ $bdata->service_name }}</td>
                    <td>{{ $bdata->booking_id }}</td>
                    <td>{{ helper::date_format($bdata->date) }}<br>{{ $bdata->time }}</td>
                    <td>
                        @if ($bdata->status == 1)
                            <span class="badge text-bg-warning"> {{ trans('labels.pending') }}
                            </span>
                        @elseif($bdata->status == 2)
                            <span class="badge text-bg-secondary">
                                @if ($bdata->handyman_id != '')
                                    {{ trans('labels.handyman_assigned') }}
                                @else
                                    {{ trans('labels.accepted') }}
                                @endif
                            </span>
                        @elseif($bdata->status == 3)
                            <span class="badge text-bg-success">
                                {{ trans('labels.completed') }} </span>
                        @elseif($bdata->status == 4)
                            <span class="badge text-bg-danger">
                                @if ($bdata->canceled_by == 1)
                                    @if (Auth::user()->type == 1)
                                        {{ trans('labels.cancel_by_provider') }}
                                    @else
                                        {{ trans('labels.cancel_by_you') }}
                                    @endif
                                @else
                                    {{ trans('labels.cancel_by_customer') }}
                                @endif
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            <a class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="View" data-original-title="View" title="View"
                                href="{{ URL::to('/bookings/' . $bdata->booking_id) }}">
                                <i class="ft-eye"></i>
                            </a>
                            <a class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="PDF" data-original-title="PDF" title="PDF"
                                href="{{ URL::to('/generatepdf/' . $bdata->booking_id) }}">
                                <i class="fa-solid fa-file-pdf"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            {{-- @else
                <tr>
                    <td colspan="7" align="center">
                        {{ trans('labels.booking_not_found') }}
                    </td>
                </tr>
            @endif --}}
        </tbody>
    </table>
</div>
