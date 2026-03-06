<div class="row pt-3 g-3">
    <div class="col-xxl-3 col-md-6">
        <div class="{{ request()->get('type') == '' ? 'border border-primary rounded-2' : 'border-0' }}">
            <div class="card box-shadow rgb-secondary-light h-100">
                @if (request()->is('reports'))
                    @if (Auth::user()->type == 1)
                        <a
                            href="{{ URL::to(request()->url() . '?provider_id=' . request()->get('provider_id') . '&type=&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                        @elseif (Auth::user()->type == 2)
                            <a
                                href="{{ URL::to(request()->url() . '?customer_id=' . request()->get('customer_id') . '&type=&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                            @elseif (Auth::user()->type == 3)
                                <a
                                    href="{{ URL::to(request()->url() . '?type=&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                    @endif
                @elseif(request()->is('bookings'))
                    <a href="{{ URL::to('bookings?type=') }}">
                @endif
                <div class="card-body">
                    <div class="dashboard-cards">
                        <span class="card-icon bg-secondary">
                            <i class="fa fa-book-user"></i>
                        </span>
                        <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                            <p class="text-dark color-changer fw-500 fs-15 mb-1">{{ trans('labels.total_bookings') }}
                            </p>
                            <h5 class="text-dark color-changer fw-600">{{ $totalbooking }}</h5>
                        </span>
                    </div>
                </div>
                </a>
            </div>
        </div>

    </div>
    <div class="col-xxl-3 col-md-6">
        <div class="{{ request()->get('type') == 'processing' ? 'border border-primary rounded-2' : 'border-0' }}">
            <div class="card box-shadow rgb-warning-light h-100">
                @if (request()->is('reports'))
                    @if (Auth::user()->type == 1)
                        <a
                            href="{{ URL::to(request()->url() . '?provider_id=' . request()->get('provider_id') . '&type=processing&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                        @elseif (Auth::user()->type == 2)
                            <a
                                href="{{ URL::to(request()->url() . '?customer_id=' . request()->get('customer_id') . '&type=processing&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                            @elseif (Auth::user()->type == 3)
                                <a
                                    href="{{ URL::to(request()->url() . '?type=processing&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                    @endif
                @elseif(request()->is('bookings'))
                    <a href="{{ URL::to('bookings?type=processing') }}">
                @endif
                <div class="card-body">
                    <div class="dashboard-cards">
                        <span class="card-icon bg-warning">
                            <i class="fa fa-hourglass"></i>
                        </span>
                        <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                            <p class="text-dark color-changer fw-500 fs-15 mb-1">{{ trans('labels.processing') }}</p>
                            <h5 class="text-dark color-changer fw-600">{{ $totalprocessing }}</h5>
                        </span>
                    </div>
                </div>
                </a>
            </div>
        </div>

    </div>
    <div class="col-xxl-3 col-md-6">
        <div class="{{ request()->get('type') == 'completed' ? 'border border-primary rounded-2' : 'border-0' }}">
            <div class="card rgb-success-light box-shadow h-100">
                @if (request()->is('reports'))

                    @if (Auth::user()->type == 1)
                        <a
                            href="{{ URL::to(request()->url() . '?provider_id=' . request()->get('provider_id') . '&type=completed&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                        @elseif (Auth::user()->type == 2)
                            <a
                                href="{{ URL::to(request()->url() . '?customer_id=' . request()->get('customer_id') . '&type=completed&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                            @elseif (Auth::user()->type == 3)
                                <a
                                    href="{{ URL::to(request()->url() . '?type=completed&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                    @endif
                @elseif(request()->is('bookings'))
                    <a href="{{ URL::to('bookings?type=completed') }}">
                @endif
                <div class="card-body">
                    <div class="dashboard-cards">
                        <span class="card-icon bg-success">
                            <i class="fa fa-check"></i>
                        </span>
                        <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                            <p class="text-dark color-changer fw-500 fs-15 mb-1">{{ trans('labels.completed') }}</p>
                            <h5 class="text-dark color-changer fw-600">{{ $totalcompleted }}</h5>
                        </span>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
    @if (Auth::user()->type != 3)
        <div class="col-xxl-3 col-md-6">
            <div class="{{ request()->get('type') == 'cancelled' ? 'border border-primary rounded-2' : 'border-0' }}">
                <div class="card rgb-danger-light box-shadow h-100">
                    @if (request()->is('reports'))
                        @if (Auth::user()->type == 1)
                            <a
                                href="{{ URL::to(request()->url() . '?provider_id=' . request()->get('provider_id') . '&type=cancelled&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                            @elseif (Auth::user()->type == 2)
                                <a
                                    href="{{ URL::to(request()->url() . '?customer_id=' . request()->get('customer_id') . '&type=cancelled&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                                @elseif (Auth::user()->type == 3)
                                    <a
                                        href="{{ URL::to(request()->url() . '?type=cancelled&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                        @endif
                    @elseif(request()->is('bookings'))
                        <a href="{{ URL::to('bookings?type=cancelled') }}">
                    @endif
                    <div class="card-body">
                        <div class="dashboard-cards">
                            <span class="card-icon bg-danger">
                                <i class="fa fa-close"></i>
                            </span>
                            <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                <p class="text-dark color-changer fw-500 fs-15 mb-1">{{ trans('labels.cancelled') }}
                                </p>
                                <h5 class="text-dark color-changer fw-600">{{ $totalcancelled }}</h5>
                            </span>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
