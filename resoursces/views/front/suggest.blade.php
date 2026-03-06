@isset($servicedata)
    <div class="text-left mt-1">
        <ul class="list-group suggestion_scroll col-sm-12 col-md-12 col-lg-12 ">
            @if (!empty($servicedata))
                @if (count($servicedata) > 0)
                    @foreach ($servicedata as $service)
                        <li class="list-group-item"><a href="{{ URL::to('/home/service-details/' . $service->service_slug) }}"
                                class="text-dark" style="font-weight: bolder;">{{ $service->service_name }}</a></li>
                    @endforeach
                @else
                    <p class="list-group-item">{{ trans('labels.no_result') }}</p>
                @endif
            @endif
        </ul>
    </div>
@endisset


@isset($citydata)
    @if (!empty($citydata) && count($citydata) > 0)
        @foreach ($citydata as $city)
            <div class="col-md-6">
                <a onclick="setCookie('city_id','{{ $city->id }}', 365)">
                    <div
                        class="card card-deck text-center h-100 cp {{ isset($_COOKIE['city_id']) && $_COOKIE['city_id'] == $city->id ? 'border border-primary border-1 bg-primary-rgb' : '' }}">
                        <div class="d-flex gap-2 p-2 align-items-center">
                            <div class="col-auto">
                                <img class="city-modal-img" src="{{ helper::image_path($city->image) }}"
                                    alt="{{ trans('labels.city') }}">
                            </div>
                            <div class="text-dark fw-600 text-capitalize">
                                {{ $city->name }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    @else
        <div class="text-center">
            {{ trans('labels.no_result') }}
        </div>
    @endif
@endisset
