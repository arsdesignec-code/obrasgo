@extends('front.layout.vendor_theme')
@section('page_title')
    {{ trans('labels.user') }} | {{ trans('labels.notifications') }}
@endsection
@section('front_content')
    <div class="col-12 col-md-12 col-lg-8 col-xl-9">
        <div class="card">
            <div class="card-header border-bottom bg-transparent py-3">
                <h5 class="widget-title mb-0 color-changer">{{ trans('labels.notifications') }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!----- more notification ----->
                    @if (!empty($notifications) && count($notifications) > 0)
                        @foreach ($notifications as $noti)
                            <div class="col-md-6 col-12">
                                <div class="card border notification-card">
                                    <div class="card-body p-2">
                                        <div class="d-flex align-items-center gap-sm-3 gap-2">
                                            <div>
                                                <div class="wallet_icon_box border_sm_none rounded-2">
                                                    <img class="rounded img-fluid w-40"
                                                        src="{{ url('storage/app/public/images/booking-noti.png') }}"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="w-100">
                                                @if ($noti->booking_status == 1)
                                                    <h6 class="truncate-2 wallet-title mb-0">
                                                        <a class="text-warning"
                                                            href="{{ URL::to('/home/user/bookings/' . $noti->booking_id) }}">{{ $noti->title }}</a>
                                                    </h6>
                                                @elseif($noti->booking_status == 2)
                                                    <h6 class="truncate-2 wallet-title mb-0">
                                                        <a class="text-success"
                                                            href="{{ URL::to('/home/user/bookings/' . $noti->booking_id) }}">{{ $noti->title }}</a>
                                                    </h6>
                                                @elseif($noti->booking_status == 3)
                                                    <h6 class="truncate-2 wallet-title mb-0">
                                                        <a class="text-success"
                                                            href="{{ URL::to('/home/user/bookings/' . $noti->booking_id) }}">{{ $noti->title }}</a>
                                                    </h6>
                                                @elseif($noti->booking_status == 4)
                                                    <h6 class="truncate-2 wallet-title mb-0">
                                                        <a class="text-danger"
                                                            href="{{ URL::to('/home/user/bookings/' . $noti->booking_id) }}">{{ $noti->title }}</a>
                                                    </h6>
                                                @endif

                                                @if ($noti->booking_status == 1)
                                                    <h5 class="text-dark color-changer fw-semibold fs-14 my-2">{{ $noti->message }}</h5>
                                                @elseif($noti->booking_status == 2)
                                                    <h5 class="text-dark color-changer fw-semibold fs-14 my-2">{{ $noti->message }}</h5>
                                                @elseif($noti->booking_status == 3)
                                                    <h5 class="text-dark color-changer fw-semibold fs-14 my-2">{{ $noti->message }}</h5>
                                                @elseif($noti->booking_status == 4)
                                                    <h5 class="text-dark color-changer fw-semibold fs-14 my-2">{{ $noti->message }}</h5>
                                                @endif

                                                <p
                                                    class="text-muted fw-600 mb-0 text-center d-flex justify-content-between text-md-start">
                                                    <span class="not-date">{{ helper::date_format($noti->date) }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="w-25 mx-auto">
                            <img src="{{ helper::image_path(helper::otherdata('')->no_data_image) }}" alt="nodata img">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- become provider -->
    @include('front.become_provider')

@endsection
