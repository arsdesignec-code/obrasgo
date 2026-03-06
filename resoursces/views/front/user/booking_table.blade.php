@if (!empty($bookingdata) && count($bookingdata) > 0)
    <table class="table border mb-0">
        <thead>
            <tr class="booking-text-center">
                <th class="d-none d-xl-block">{{ trans('labels.image') }}</th>
                <th>{{ trans('labels.booking') }}</th>
                <th>{{ trans('labels.booking_date_and_time') }}</th>
                <th>{{ trans('labels.amount') }}</th>
                <th>{{ trans('labels.status') }}</th>
                <th>{{ trans('labels.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookingdata as $bdata)
                <tr class="booking-text-center">
                    <td class="d-none d-xl-block">
                        <img src="{{ helper::image_path($bdata->service_image) }}"
                            alt="{{ trans('labels.service_image') }}" class="booking-img">
                    </td>
                    <td>
                        <a href="{{ URL::to('/home/user/bookings/' . $bdata->booking_id) }}"
                            class="fw-semibold text-dark color-changer">{{ $bdata->booking_id }}</a>
                    </td>
                    <td class="fw-500 fs-7">
                        {{ helper::date_format($bdata->date) . '/' . $bdata->time }}
                    </td>
                    <td class="fw-500 fs-7">{{ helper::currency_format($bdata->total_amt) }}</td>
                    <td class="status">
                        @if ($bdata->status == 1)
                            <span
                                class="fw-500 badge bg-warning text-capitalize text-dark">{{ trans('labels.pending') }}</span>
                        @elseif ($bdata->status == 2)
                            <span class="fw-500 badge bg-info text-capitalize text-white">
                                @if ($bdata->handyman_id != '')
                                    {{ trans('labels.handyman_assigned') }}
                                @else
                                    {{ trans('labels.accepted') }}
                                @endif
                            </span>
                        @elseif ($bdata->status == 3)
                            <span
                                class="fw-500 badge bg-success text-capitalize text-white">{{ trans('labels.completed') }}</span>
                        @elseif ($bdata->status == 4)
                            @if ($bdata->canceled_by == 1)
                                <span
                                    class="fw-500 badge bg-danger text-capitalize text-white">{{ trans('labels.cancel_by_provider') }}</span>
                            @else
                                <span
                                    class="fw-500 badge bg-danger text-capitalize text-white">{{ trans('labels.cancel_by_you') }}</span>
                            @endif
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ URL::to('/home/user/bookings/' . $bdata->booking_id) }}"
                                class="btn btn-sm btn-primary view-btn" tooltip="View Booking">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $bookingdata->links() }}
    </div>
@else
    @include('front.nodata')
@endif
