@extends('layout.main')
@section('page_title', trans('labels.brands'))
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title fs-4 fw-600 color-changer">{{ trans('labels.brands') }}</h5>
        <a href="{{ URL::to('/brand/add') }}" class="btn btn-secondary gap-2 px-sm-4 d-flex align-items-center">
            <i class="fa fa-plus" height="16px"></i>{{ trans('labels.add') }}
        </a>
    </div>
    <div class="my-3">
        <section class="">
            @include('brand.card-view')
        </section>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/gallery.js') }}"></script>
@endsection
