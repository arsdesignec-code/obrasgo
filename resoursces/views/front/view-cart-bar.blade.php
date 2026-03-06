<div class="view-cart-bar-2">
    <section class="view-cart-bar d-none">
        <div class="container">
            <div class="row g-2 align-items-center">
                <div class="col-xl-6 col-md-6">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="product-img">
                            <img src="{{ helper::image_path($gallery->gallery_image) }}" class="rounded">
                        </div>
                        <div>
                            <h6 class="text-dark color-changer line-2 fw-600 my-1">
                                {{ $servicedata->service_name }}
                            </h6>
                            <div class="d-flex gap-1 flex-wrap align-items-center">
                                <span class="fs-7 color-changer fw-600">
                                    {{ helper::currency_format($price) }}
                                </span>
                                @if ($original_price > $price)
                                    <del
                                        class="text-muted fw-600 fs-8 product-original-price">{{ helper::currency_format($original_price) }}</del>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-xl-4 col-lg-5 col-12">
                            <button
                                onclick="isopenclose('{{ URL::to('/home/service/isopenclose') }}','{{ $servicedata->service_id }}')"
                                class="btn btn-primary w-100 fs-15 d-flex gap-2 justify-content-center align-items-center book_service">
                                <i class="fa-solid fa-bookmark"></i>
                                {{ trans('labels.book_service') }}
                                <div class="loader d-none book_service_loader"></div>
                            </button>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-12">
                            <a href="{{ URL::to('/home/contact-us') }}"
                                class="btn btn-outline-primary fs-15 w-100 d-flex gap-2 justify-content-center align-items-center book_service">
                                <i class="fa-solid fa-eye"></i>
                                {{ trans('labels.send_inquiry') }}
                            </a>
                        </div>
                        <div class="col-md-1 col-12">
                            <button class="border bg-transparent m-0 h-100 rounded close-btn-view" id="close-btn2">
                                <i class="fa-regular fa-xmark color-changer fs-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
