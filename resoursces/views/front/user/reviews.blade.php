@extends('front.layout.vendor_theme')
@section('page_title')
    {{ trans('labels.user') }} | {{ trans('labels.reviews') }}
@endsection
@section('front_content')
    <div class="col-12 col-md-12 col-lg-8 col-xl-9">
        <!-- review list -->
        <div class="card review-card">
            <div class="card-header border-bottom bg-transparent py-3">
                <h4 class="widget-title color-changer m-0">{{ trans('labels.reviews') }}</h4>
            </div>
            @if (!empty($rattingsdata) && count($rattingsdata) > 0)
                <div class="card-body">
                    @foreach ($rattingsdata as $rdata)
                        <div class="review-list gap-3">
                            <div class="review-img">
                                <img class="rounded"
                                    @if ($rdata->service_image != '') src="{{ helper::image_path($rdata->service_image) }}"
                        @else
                        src="{{ helper::image_path($rdata->provider_image) }}" @endif
                                    alt="{{ trans('labels.image') }}">
                            </div>
                            <div class="review-info col d-flex flex-column justify-content-center">
                                <h5 class="truncate-2 fs-15 wallet-title m-0">
                                    @if ($rdata->service_name != '')
                                        <a class="fw-600"
                                            href="{{ URL::to('/home/service-details/' . $rdata->service_slug) }}">{{ $rdata->service_name }}</a>
                                    @else
                                        <a class="fw-600"
                                            href="{{ URL::to('/home/providers-services/' . $rdata->provider_slug) }}">{{ $rdata->provider_name }}</a>
                                    @endif
                                </h5>
                                <p class="mb-0 fw-medium text-muted fs-13">{{ Str::limit($rdata->comment, 100) }}</p>
                            </div>
                            <div class="col-auto d-flex flex-column justify-content-center">
                                <div class="rating text-end">
                                    <i class="fas fa-star fs-7 text-warning"></i>
                                    <span class="d-inline-block color-changer fs-7 fw-600">
                                        {{ number_format($rdata->ratting, 1) }}
                                    </span>
                                </div>
                                <div class="review-date m-0 text-muted fw-500 fs-13">
                                    {{ helper::date_format($rdata->date) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if ($rattingsdata->count() > 10)
                        <div class="d-flex justify-content-center">
                            {{ $rattingsdata->links() }}
                        </div>
                    @endif
                </div>
            @else
                <div class="w-25 mx-auto">
                    <img src="{{ helper::image_path(helper::otherdata('')->no_data_image) }}" alt="nodata img">
                </div>
            @endif
        </div>
    </div>

    <!-- become provider -->
    @include('front.become_provider')

@endsection
