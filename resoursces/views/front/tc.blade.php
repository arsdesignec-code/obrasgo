@extends('front.layout.main')

@section('page_title', trans('labels.terms_conditions'))

@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}" class="color-changer">{{ trans('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.terms_conditions') }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- terms & conditions -->
    <section class="about-us">
        <div class="pt-4">
            <div class="container">
                <h2 class="fw-600 truncate-2 color-changer sec-subtitle mb-4">{{ trans('labels.terms_conditions') }}</h2>
                @if (!empty($tcdata))
                    <div class="row">
                        <div class="col-12">
                            <div class="about-blk-content cms-section fs-7">
                                <p class="fw-500 or-text m-0">{!! $tcdata->tc_content !!}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="w-25 mx-auto">
                        <img src="{{ helper::image_path(helper::otherdata('')->no_data_image) }}" alt="">
                    </div>
                @endif
            </div>
        </div>
    </section>
    @include('front.become_provider')
@endsection
