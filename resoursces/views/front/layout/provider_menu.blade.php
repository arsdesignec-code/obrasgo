<div class="col-xl-3 col-md-4">
    <div class="mb-4">
        <div class="card">
            <div class="card-body p-3 p-md-4">

                <!-- provider profile -->
                <div class="text-center border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-center">
                        <div class="user-image">
                            <img class="user-image" src="{{ helper::image_path(@$providerdata->provider_image) }}"
                                alt="profile image" />
                        </div>
                    </div>
                    <div class="user-details mt-3">
                        <h5 class="mb-0 fw-600 color-changer mb-0">{{ @$providerdata->provider_name }}</h5>
                    </div>
                </div>

                <!-- provider menu -->
                <div class="widget settings-menu">
                    <ul>
                        <li class="nav-item">
                            <a href="{{ URL::to('/home/providers-services/' . @$providerdata->slug) }}"
                                class="color-changer {{ request()->is('home/providers-services*') ? 'active' : '' }}">
                                <div class="content-text">
                                    <i class="far fa-address-book fs-15"></i>
                                    <span class="px-2">{{ trans('labels.services') }}</span>
                                </div>
                                <i class="fa-regular fa-angle-right"></i>
                            </a>
                        </li>
                        @if (@helper::checkaddons('product_review'))
                            @if (@helper::appdata()->review_approved_status == 1)
                                <li class="nav-item">
                                    <a href="{{ URL::to('/home/providers-rattings/' . @$providerdata->slug) }}"
                                        class="color-changer {{ request()->is('home/providers-rattings*') ? 'active' : '' }}">
                                        <div class="content-text">
                                            <i class="far fa-star fs-7"></i>
                                            <span class="px-2">{{ trans('labels.reviews') }}</span>
                                        </div>
                                        <i class="fa-regular fa-angle-right"></i>
                                    </a>
                                </li>
                            @endif
                        @endif
                        <li class="nav-item">
                            <a href="{{ URL::to('/home/providers-details/' . @$providerdata->slug) }}"
                                class="color-changer {{ request()->is('home/providers-details*') ? 'active' : '' }}">
                                <div class="content-text">
                                    <i class="far fa-user fs-7"></i>
                                    <span class="px-2">{{ trans('labels.profile') }}</span>
                                </div>
                                <i class="fa-regular fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
