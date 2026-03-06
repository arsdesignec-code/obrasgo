@extends('front.layout.main')
@section('page_title', trans('labels.about_us'))
@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}"
                                    class="color-changer">{{ trans('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.about_us') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- about-us -->
    <section class="about-us extra-margin">
        <div class="pt-4">
            <div class="container">
                @if (!empty($aboutdata))
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="about-blk-content">
                                <h2 class="fw-600 truncate-2 sec-subtitle color-changer">{{ trans('labels.about_us') }}</h2>
                                <div class="cms-section fs-7 text-muted">
                                    <p class="fw-semibold">{!! $aboutdata->about_content !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="about-blk-image">
                                <img src="{{ helper::image_path($aboutdata->about_image) }}" class="img-fluid"
                                    alt="{{ trans('labels.aboutus_image') }}">
                            </div>
                        </div>
                    </div>
                @else
                    <div class="w-25 mx-auto">
                        <img src="{{ helper::image_path(helper::otherdata('')->no_data_image) }}" alt="nodata img">
                    </div>
                @endif
            </div>
        </div>
    </section>
    @include('front.become_provider')
@endsection
