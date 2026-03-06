@extends('front.layout.vendor_theme')
@section('page_title')
    {{ trans('labels.user') }} | {{ trans('labels.refer_earn') }}
@endsection
@section('front_content')
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'front-assets/social-sharing/css/socialsharing.css') }}">
    <div class="col-12 col-md-12 col-lg-8 col-xl-9">
        <div class="card">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="widget-title color-changer mb-0">{{ trans('labels.refer_earn') }}</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column align-items-center">
                    <div class="col-sm-6 col-10">
                        <img class="mb-4 w-100 h-100" src="{{ helper::image_path(helper::otherdata()->refer_earn_image) }}">
                    </div>
                    <h5 class="text-uppercase color-changer">{{ trans('labels.refer_earn') }}</h5>
                    <p class="fs-7 text-center text-muted">{{ trans('labels.refer_note_1') }}
                        {{ helper::currency_format(@helper::appdata()->referral_amount) }}
                        {{ trans('labels.refer_note_2') }}</p>
                    <input type="url" class="form-control mb-3" id="data"
                        value="{{ URL::to('home/register-user?referral=' . Auth::user()->referral_code) }}" readonly>
                </div>
                <div class="sharing-section d-flex align-items-center justify-content-center"></div>
            </div>
        </div>
    </div>
    <!-- become provider -->
    @include('front.become_provider')
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETSPATHURL') . 'front-assets/social-sharing/js/socialsharing.js') }}"></script>
    <script src="{{ url(env('ASSETSPATHURL') . 'front-assets/referearn.js') }}"></script>
@endsection
