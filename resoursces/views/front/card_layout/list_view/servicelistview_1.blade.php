<div class="col">
    <div class="card list-view-1 rounded h-100">
        @php
            if ($sdata->is_top_deals == 1 && @helper::top_deals() != null) {
                if (@helper::top_deals()->offer_type == 1) {
                    $price = $sdata->price - @helper::top_deals()->offer_amount;
                } else {
                    $price = $sdata->price - $sdata->price * (@helper::top_deals()->offer_amount / 100);
                }
                $original_price = $sdata->price;
            } else {
                $price = $sdata->price;
                $original_price = 0;
            }
        @endphp
        <div class="d-flex align-items-center">
            <div class="service-img position-relative col-auto">
                <a href="{{ URL::to('/home/service-details/' . $sdata->slug) }}">
                    <img src="{{ helper::image_path($sdata->service_image) }}" alt="service img"
                        class="serv-img {{ session()->get('direction') == 2 ? 'rounded-end' : 'rounded-start' }}">
                </a>
                @if ($sdata->is_top_deals == 1 && @helper::top_deals() != null)
                    <div
                        class="position-absolute border rounded-5 top-0 start-0 m-2 bg-dark d-flex align-items-center gap-1 py-1 px-2">
                        <i class="fa-regular fa-fire fa-flip fw-600 text-danger fs-15"></i>
                        <span class="fw-500 text-white fs-13">{{ trans('labels.deals') }}</span>
                    </div>
                @endif
                <a href="{{ URL::to('/home/service-details/' . $sdata->slug) }}"
                    class="gap-3 rounded-0 book_now position-absolute bottom-0 {{ session()->get('direction') == 2 ? 'start-0' : 'end-0' }}">
                    <span>{{ trans('labels.book_now') }}</span>
                </a>
            </div>
            <div class="w-100 d-flex flex-column gap-1 p-2 justify-content-between h-100">
                <div class="d-flex flex-column gap-1 justify-content-center">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="fs-13 fw-500 text-capitalize truncate-1">
                            <span class="text-muted">{{ $sdata->category_name }}</span>
                        </div>
                        @if (@helper::checkaddons('product_review'))
                            @if (@helper::appdata()->review_approved_status == 1)
                                <p class="d-flex align-items-center gap-1 fs-8 m-0 fw-600">
                                    <i class="fa-solid fa-star text-warning"></i>
                                    <span class="color-changer">{{ helper::getaverageratting($sdata->id) }}</span>
                                </p>
                            @endif
                        @endif
                    </div>
                    <h6 class="fs-15 fw-semibold truncate-2 m-0 text-capitalize">
                        <a href="{{ URL::to('/home/service-details/' . $sdata->slug) }}"
                            class="text-dark color-changer">{{ $sdata->service_name }}</a>
                    </h6>
                    <div class="d-flex flex-wrap justify-content-between">
                        <div>
                            <p class="fs-15 text-primary fw-600 m-0">
                                {{ helper::currency_format($price) }}
                                @if ($sdata->price_type == 'Hourly')
                                    <span class="fs-7 fw-500">{{ '/' . trans('labels.hours') }}</span>
                                @endif
                            </p>
                            @if ($original_price > $price)
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <del class="price text-muted m-0 fw-600 fs-13">{{ helper::currency_format($original_price) }}
                                        @if ($sdata->price_type == 'Hourly')
                                            <span>{{ '/' . trans('labels.hours') }}</span>
                                        @endif
                                    </del>
                                </div>
                            @endif
                        </div>
                        @if ($sdata->price_type == 'Fixed')
                            <span class="time fs-13 color-changer fw-600 d-flex gap-1">
                                @if ($sdata->duration_type == 1)
                                    {{ $sdata->duration . trans('labels.minutes') }}
                                @elseif ($sdata->duration_type == 2)
                                    {{ $sdata->duration . trans('labels.hours') }}
                                @elseif ($sdata->duration_type == 3)
                                    {{ $sdata->duration . trans('labels.days') }}
                                @else
                                    {{ $sdata->duration . trans('labels.minutes') }}
                                @endif
                                <i class="fas fa-clock ml-1"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="provider-view d-flex align-items-center gap-2 m-0 p-0">
                        <img src="{{ helper::image_path($sdata->provider_image) }}" alt=""
                            class="provider-imgs">
                        <p class="m-0 fs-15 truncate-2 color-changer fw-600">{{ $sdata->provider_name }}</p>
                    </div>
                    @if (@helper::checkaddons('customer_login'))
                        @if (@helper::appdata()->login_required == 1)
                            @if (Auth::check())
                                @php $url = "javascript:void(0)"; @endphp
                            @else
                                @php $url = URL::to('home/login');  @endphp
                            @endif
                            <div class="set_fav_{{ $sdata->id }}">
                                @if ($sdata->is_favorite == 0)
                                    <a href="{{ $url }}"
                                        onclick="wishlist('{{ URL::to('home/wishlist') }}','{{ $sdata->id }}')"
                                        class="text-danger bg-body-secondary icon-wish">
                                        <i class="fa-regular fa-heart"></i>
                                    </a>
                                @else
                                    <a href="javascript:void(0)"
                                        onclick="wishlist('{{ URL::to('home/wishlist') }}','{{ $sdata->id }}')"
                                        class="text-danger bg-body-secondary icon-wish">
                                        <i class="fa-solid fa-heart"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
