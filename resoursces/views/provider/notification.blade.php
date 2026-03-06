@extends('layout.main')
@section('page_title', trans('labels.notifications'))
@section('content')
    <section id="list">
        <div class="container-fluid">
            <div class="mb-3">
                <h5 class="card-title fs-4 fw-600 color-changer">{{ trans('labels.notifications') }}</h5>
            </div>
            <div class="row match-height">
                <div class="col-12">
                    <div class="simple-line-icons">
                        @if (!empty($notificationdata) && count($notificationdata) > 0)
                            <div class="row row-cols-xl-4 row-cols-lg-2 row-cols-md-2 pb-3 row-cols-sm-2 row-cols-1 g-3">
                                @foreach ($notificationdata as $noti)
                                    <div class="col">
                                        <div class="card fonticon-container h-100">
                                            <div class="card-body">
                                                <div class="d-flex gap-3 align-items-center">
                                                    <div class="fonticon-wrap">
                                                        @if ($noti->booking_status == 1)
                                                            <div class="notification-icon rounded-circle bg-info">
                                                                <i class="fa fa-tags text-white fs-4"></i>
                                                            </div>
                                                        @endif
                                                        @if ($noti->booking_status == 3)
                                                            <div class="notification-icon rounded-circle bg-success">
                                                                <i class="fa fa-check text-white fs-4"></i>
                                                            </div>
                                                        @endif
                                                        @if ($noti->booking_status == 4)
                                                            <div class="notification-icon rounded-circle bg-danger">
                                                                <i class="fa fa-times text-white fs-4"></i>
                                                            </div>
                                                        @endif
                                                        @if ($noti->booking_status == 2 && $noti->title == 'Booking Assigned')
                                                            <div class="notification-icon rounded-circle bg-info">
                                                                <i class="fa fa-tags text-white fs-4"></i>
                                                            </div>
                                                        @endif
                                                        @if ($noti->booking_status == 2 && $noti->title == 'Booking Rejected')
                                                            <div class="notification-icon rounded-circle bg-danger">
                                                                <i class="fa fa-times text-white fs-4"></i>
                                                            </div>
                                                        @endif
                                                        @if ($noti->booking_status == 2 && $noti->title == 'Booking Accepted')
                                                            <div class="notification-icon rounded-circle bg-success">
                                                                <i class="fa fa-check text-white fs-4"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="fonticon-classname fw-600" for="view_info">
                                                            @if ($noti->booking_status == 1)
                                                                <a href="{{ URL::to('/bookings/' . $noti->booking_id) }}"
                                                                    class="text-info">{{ $noti->title }}</a>
                                                            @endif
                                                            @if ($noti->booking_status == 3)
                                                                <a href="{{ URL::to('/bookings/' . $noti->booking_id) }}"
                                                                    class="text-success">{{ $noti->title }}</a>
                                                            @endif
                                                            @if ($noti->booking_status == 4)
                                                                <a href="{{ URL::to('/bookings/' . $noti->booking_id) }}"
                                                                    class="text-danger">{{ $noti->title }}</a>
                                                            @endif
                                                            @if ($noti->booking_status == 2 && $noti->title == 'Booking Assigned')
                                                                <a href="{{ URL::to('/bookings/' . $noti->booking_id) }}"
                                                                    class="text-info">{{ $noti->title }}</a>
                                                            @endif
                                                            @if ($noti->booking_status == 2 && $noti->title == 'Booking Rejected')
                                                                <a href="{{ URL::to('/bookings/' . $noti->booking_id) }}"
                                                                    class="text-danger">{{ $noti->title }}</a>
                                                            @endif
                                                            @if ($noti->booking_status == 2 && $noti->title == 'Booking Accepted')
                                                                <a href="{{ URL::to('/bookings/' . $noti->booking_id) }}"
                                                                    class="text-success">{{ $noti->title }}</a>
                                                            @endif
                                                        </h6>
                                                        <p class="text-muted mt-1 fs-8">
                                                            {{ helper::date_format($noti->date) }}</p>
                                                    </div>
                                                </div>
                                                <div class="mt-2">
                                                    <p class="fs-7 color-changer">{{ $noti->message }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-center mt-2">
                                {{ $notificationdata->links() }}
                            </div>
                        @else
                            <p class="text-center fs-5 fw-600 text-muted">{{ trans('labels.no_data') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
