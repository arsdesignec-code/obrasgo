@extends('front.layout.main')
@section('page_title', trans('labels.contact_us'))
@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}" class="color-changer">{{ trans('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.contact_us') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- contact-us -->
    <section class="contact-us">
        <div class="pt-5 pb-5">
            <div class="container">
                <div class="row g-4 justify-content-between">

                    <!-- left side -->
                    <div class="col-md-12 col-lg-7 col-xl-7">
                        <div class="heading-text-contact mb-3">
                            <div class="{{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                                <h6 class="color-changer">Get In Touch</h6>
                                <h2 class="fw-600 truncate-2 color-changer mb-0 sec-subtitle">{{ trans('labels.contact_us') }}</h2>
                            </div>
                        </div>
                        <div class="contact-queries">
                            <p class="subtitle fs-7 text-muted mb-3 mb-md-4 truncate-2">{{ trans('labels.contact_us_dec') }}</p>
                            <!-- contact form -->
                            <form action="{{ URL::to('home/add-inquiry') }}" method="post" class="row g-3">
                                @csrf
                                <div class="col-sm-6">
                                    <label class="form-label">{{ trans('labels.first_name') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control input_paddins fs-7 @error('fname') is-invalid @enderror"
                                        type="text" name="fname" placeholder="{{ trans('labels.enter_first_name') }}"
                                        required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">{{ trans('labels.last_name') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control input_paddins fs-7 @error('lname') is-invalid @enderror"
                                        type="text" name="lname" placeholder="{{ trans('labels.enter_last_name') }}"
                                        required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">{{ trans('labels.email') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control input_paddins fs-7 @error('email') is-invalid @enderror"
                                        type="email" name="email" placeholder="{{ trans('labels.enter_email') }}"
                                        required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">{{ trans('labels.mobile') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control input_paddins fs-7 @error('mobile') is-invalid @enderror"
                                        type="text" name="mobile" placeholder="{{ trans('labels.enter_mobile') }}"
                                        required>
                                </div>
                                <div class="col-xl-12">
                                    <label class="form-label">{{ trans('labels.message') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control input_paddins fs-7 @error('message') is-invalid @enderror" rows="3" name="message"
                                        placeholder="{{ trans('labels.drop_inquiry_here') }}" required></textarea>
                                </div>
                                @if (@helper::checkaddons('recaptcha'))
                                    @include('recaptcha.recaptcha')
                                @endif
                                @isset($_COOKIE['city_id'])
                                    <div class="col-xl-12 mt-4">
                                        <button class="btn btn-primary border-2 fw-500 fs-15"
                                            type="submit">{{ trans('labels.make_a_reservation') }}</button>
                                    </div>
                                @endisset
                            </form>
                        </div>
                    </div>

                    <!-- right side -->
                    <div class="col-md-12 col-lg-5 col-xl-4">
                        {{-- <img src="{{ helper::image_path(helper::otherdata('')->contact_us_image) }}" alt="contact img"
                            class="rounded mb-3"> --}}
                        <div class="card rounded-4 card-heading-info">
                            <div class="card-body p-4">
                                <h5 class="fw-600 truncate-2 sec-subtitle color-changer">Contact Info</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item py-3">
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="icon-contactus col-auto">
                                                <i class="fa-solid fa-location-dot text-primary"></i>
                                            </div>
                                            <p class="m-0 fs-15 text-muted">{{ strip_tags(helper::appdata()->address) }}
                                            </p>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-3">
                                        <a href="callto:{{ helper::appdata()->contact }}">
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="icon-contactus col-auto">
                                                    <i class="fa-solid fa-mobile text-primary"></i>
                                                </div>
                                                <p class="m-0 fs-15 text-muted">{{ helper::appdata()->contact }}</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item py-3">
                                        <a href="mailto:{{ helper::appdata()->email }}">
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="icon-contactus col-auto">
                                                    <i class="fa-solid fa-envelope text-primary"></i>
                                                </div>
                                                <p class="m-0 fs-15 text-muted">{{ helper::appdata()->email }}</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item py-3">
                                        <a href="mailto:{{ helper::appdata()->email }}">
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="icon-contactus col-auto">
                                                    <i class="far fa-comment-dots text-primary"></i>
                                                </div>
                                                <p class="m-0 fs-15 text-muted">{{ helper::appdata()->contact }}</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                @if (count(helper::getsociallinks()) > 0)
                                    <ul class="d-grid gap-3 mt-3 d-flex flex-wrap align-items-center social-media">
                                        @foreach (@helper::getsociallinks() as $links)
                                            <li>
                                                <a href="{{ $links->link }}" target="_blank"
                                                    class="text-primary border icon-social">
                                                    {!! $links->icon !!}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('front.become_provider')
@endsection
