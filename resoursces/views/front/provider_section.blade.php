@foreach ($providerdata as $fpdata)
    <div class="col">
        <div class="card h-100 our-team">
            <div class="card-body">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <div class="pic shadow">
                        <img src="{{ helper::image_path($fpdata->provider_image) }}"
                            alt="">
                    </div>
                    <h6 class="truncate-2 text-primary mb-0 mt-3 fw-600">
                        {{ $fpdata->provider_name }}
                    </h6>
                    <span class="text-muted truncate-2 fw-500 fs-15">
                        {{ $fpdata->provider_type }}
                    </span>
                    <a href="{{ URL::to('/home/providers-services/' . $fpdata->slug) }}"
                        class="text-primary">
                        <div class="go_arrow border mt-2 fw-600">
                            <i
                                class="fa-regular fa-arrow-{{ session()->get('direction') == 2 ? 'left' : 'right' }} color-changer"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
