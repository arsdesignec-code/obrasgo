<div class="col-12 col-lg-4 col-xl-3">
    <div class="card d-none d-lg-block">
        <div class="card-body p-3 p-md-4">

            <!-- vendor profile -->
            <div class="text-center border-bottom pb-3 mb-3">
                <div class="d-flex justify-content-center">
                    <div class="user-image">
                        <img class="user-image" src="{{ helper::image_path(Auth::user()->image) }}" alt="profile image" />
                    </div>
                </div>
                <div class="user-details mt-3">
                    <h5 class="mb-0 color-changer fw-600">{{ Auth::user()->name }}</h5>
                    <p class="text-muted m-0">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- vendor menu -->
            <div class="settings-menu">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="{{ URL::to('/home/user/profile') }}"
                            class="{{ request()->is('home/user/profile*') ? 'active' : '' }}">
                            <div class="content-text">
                                <i class="far fa-user me-2"></i>
                                <span class="px-1">{{ trans('labels.profile_settings') }}</span>
                            </div>
                            <i class="fa-regular fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL::to('/home/user/bookings') }}"
                            class="{{ request()->is('home/user/bookings*') ? 'active' : '' }}">
                            <div class="content-text">
                                <i class="far fa-calendar-check me-2"></i>
                                <span class="px-1">{{ trans('labels.my_bookings') }}</span>
                                @if (helper::booking() > 0)
                                    <span class="badge badge-pill">{!! helper::booking() !!}</span>
                                @endif
                            </div>
                            <i class="fa-regular fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL::to('/home/user/address') }}"
                            class="{{ request()->is('home/user/address*') ? 'active' : '' }}">
                            <div class="content-text">
                                <i class="far fa-location-dot me-2"></i>
                                <span class="px-1">{{ trans('labels.address') }}</span>
                            </div>
                            <i class="fa-regular fa-angle-right"></i>
                        </a>
                    </li>
                    @if (@helper::checkaddons('product_review'))
                        <li class="nav-item">
                            <a href="{{ URL::to('/home/user/reviews') }}"
                                class="{{ request()->is('home/user/reviews*') ? 'active' : '' }}">
                                <div class="content-text">
                                    <i class="far fa-star me-2"></i>
                                    <span class="px-1">{{ trans('labels.reviews') }}</span>
                                </div>
                                <i class="fa-regular fa-angle-right"></i>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ URL::to('/home/user/wishlist') }}"
                            class="{{ request()->is('home/user/wishlist*') ? 'active' : '' }}">
                            <div class="content-text">
                                <i class="far fa-heart me-2"></i>
                                <span class="px-1">{{ trans('labels.wishlist') }}</span>
                            </div>
                            <i class="fa-regular fa-angle-right"></i>
                        </a>
                    </li>
                    @if (@helper::allpaymentcheckaddons())
                        <li class="nav-item">
                            <a href="{{ URL::to('/home/user/wallet') }}"
                                class="{{ request()->is('home/user/wallet*') ? 'active' : '' }}">
                                <div class="content-text">
                                    <i class="far fa-wallet me-2"></i>
                                    <span class="px-1">{{ trans('labels.wallet') }}</span>
                                </div>
                                <i class="fa-regular fa-angle-right"></i>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ URL::to('/home/user/notifications') }}"
                            onclick="clearnotification('{{ URL::to('/home/user/clearnotification') }}','{{ URL::to('/home/user/notifications') }}')"
                            class="{{ request()->is('home/user/notifications*') ? 'active' : '' }}">
                            <div class="content-text">
                                <i class="far fa-bell me-2"></i>
                                <span class="px-1">{{ trans('labels.notifications') }}</span>
                                @if (helper::notification() > 0)
                                    <span class="badge badge-pill bg-yellow white">{!! helper::notification() !!}</span>
                                @endif
                            </div>
                            <i class="fa-regular fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL::to('/home/user/refer-earn') }}"
                            class="{{ request()->is('home/user/refer-earn*') ? 'active' : '' }}">
                            <div class="content-text">
                                <i class="far fa-share-nodes me-2"></i>
                                <span class="px-1">{{ trans('labels.refer_earn') }}</span>
                            </div>
                            <i class="fa-regular fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-bs-toggle="modal" data-bs-target="#userlogout" class="cp">
                            <div class="content-text">
                                <i class="fa-regular fa-right-from-bracket me-2"></i>
                                <span class="px-1">{{ trans('labels.logout') }}</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <!-- mobile settings menu -->
    <div class="accordion accordion-flush d-lg-none" id="accountSetting">
        <div class="accordion-item border rounded-4 overflow-hidden mb-3">
            <h2 class="accordion-header">
                <button
                    class="accordion-button collapsed fw-medium bg-regular accordion_button d-flex gap-2 m-0 align-items-center"
                    type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                    aria-controls="flush-collapseOne">
                    <div class="d-flex gap-2">
                        <i class="fa-regular fa-bars-staggered"></i>
                        <p class="fw-semibold m-0">{{ trans('labels.dashboard_navigation') }}</p>
                    </div>
                </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accountSetting">
                <div class="accordion-body p-3 pt-0 bg-change-mode settings-menu">
                    <ul role="tablist" class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="{{ URL::to('/home/user/profile') }}"
                                class="{{ request()->is('home/user/profile*') ? 'active' : '' }}">
                                <div class="content-text">
                                    <i class="far fa-user me-2"></i>
                                    <span class="px-1">{{ trans('labels.profile_settings') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/home/user/bookings') }}"
                                class="{{ request()->is('home/user/bookings*') ? 'active' : '' }}">
                                <div class="content-text">
                                    <i class="far fa-calendar-check me-2"></i> <span
                                        class="px-1">{{ trans('labels.my_bookings') }}</span>
                                    @if (helper::booking() > 0)
                                        <span class="badge badge-pill bg-yellow white">{!! helper::booking() !!}</span>
                                    @endif
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/home/user/address') }}"
                                class="{{ request()->is('home/user/address*') ? 'active' : '' }}">
                                <div class="content-text">
                                    <i class="far fa-location-dot me-2"></i>
                                    <span class="px-1">{{ trans('labels.address') }}</span>
                                </div>
                            </a>
                        </li>
                        @if (@helper::checkaddons('product_review'))
                            <li class="nav-item">
                                <a href="{{ URL::to('/home/user/reviews') }}"
                                    class="{{ request()->is('home/user/reviews*') ? 'active' : '' }}">
                                    <div class="content-text">
                                        <i class="far fa-star me-2"></i>
                                        <span class="px-1">{{ trans('labels.reviews') }}</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ URL::to('/home/user/wishlist') }}"
                                class="{{ request()->is('home/user/wishlist*') ? 'active' : '' }}">
                                <div class="content-text">
                                    <i class="far fa-heart me-2"></i>
                                    <span class="px-1">{{ trans('labels.wishlist') }}</span>
                                </div>
                            </a>
                        </li>
                        @if (@helper::allpaymentcheckaddons())
                            <li class="nav-item">
                                <a href="{{ URL::to('/home/user/wallet') }}"
                                    class="{{ request()->is('home/user/wallet*') ? 'active' : '' }}">
                                    <div class="content-text">
                                        <i class="far fa-wallet me-2"></i>
                                        <span class="px-1">{{ trans('labels.wallet') }}</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ URL::to('/home/user/notifications') }}"
                                onclick="clearnotification('{{ URL::to('/home/user/clearnotification') }}','{{ URL::to('/home/user/notifications') }}')"
                                class="{{ request()->is('home/user/notifications*') ? 'active' : '' }}">
                                <div class="content-text">
                                    <i class="far fa-bell me-2"></i>
                                    <span class="px-1">{{ trans('labels.notifications') }}</span>
                                    @if (helper::notification() > 0)
                                        <span class="badge badge-pill bg-yellow white">{!! helper::notification() !!}</span>
                                    @endif
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/home/user/refer-earn') }}"
                                class="{{ request()->is('home/user/refer-earn*') ? 'active' : '' }}">
                                <div class="content-text">
                                    <i class="far fa-share-nodes me-2"></i>
                                    <span class="px-1">{{ trans('labels.refer_earn') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="" data-bs-toggle="modal" data-bs-target="#userlogout">
                                <div class="content-text">
                                    <i class="fa-regular fa-right-from-bracket me-2"></i>
                                    <span class="px-1">{{ trans('labels.logout') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
