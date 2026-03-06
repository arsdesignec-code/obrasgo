@extends('front.layout.main')

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}" class="color-changer">{{ trans('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.booking') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <h2 class="fw-600 truncate-2 mb-4 sec-subtitle color-changer">{{ trans('labels.booking') }}</h2>
            <div class="row">
                @if (Auth::user() && Auth::user()->type == 4)
                    @include('front.layout.vendor_menu')
                @endif

                @yield('front_content')

            </div>
        </div>
    </div>
@endsection
