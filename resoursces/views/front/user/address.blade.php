@extends('front.layout.vendor_theme')
@section('page_title')
    {{ trans('labels.user') }} | {{ trans('labels.my_address') }}
@endsection
@section('front_content')
    <div class="col-12 col-md-12 col-lg-8 col-xl-9">
        <div class="card h-100">
            <div class="card-header border-bottom bg-transparent p-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-600 mb-0 color-changer">{{ trans('labels.address') }}</h5>
                <a type="submit" onclick="addaddress()" class="btn btn-primary  d-flex align-items-center gap-2 px-4 py-3">
                    <i class="fa-regular fa-location-dot"></i>
                    {{ trans('labels.add_address') }}
                </a>

            </div>

            <div class="card-body">
                <div class="row g-3">
                    <!-- address -->
                    @if (!empty($addressdata))
                        @foreach ($addressdata as $address)
                            <div class="col-md-6 col-xl-4">
                                <div class="card h-100 border card-content-wrapper p-0">
                                    <div
                                        class="card-header border-bottom bg-transparent py-2 d-flex justify-content-between align-items-center">
                                        <div class="d-flex color-changer d-grid gap-2 align-items-center">
                                            @if ($address->address_type == 1)
                                                <i class="fa-regular fa-home fs-5"></i>
                                                <h5 class="fw-600 fs-6 mb-0">{{ trans('labels.home') }}</h5>
                                            @elseif($address->address_type == 2)
                                                <i class="fa-regular fa-building"></i>
                                                <h5 class="fw-600 fs-6 mb-0">{{ trans('labels.office') }}</h5>
                                            @else
                                                <i class="fa-regular fa-puzzle-piece"></i>
                                                <h5 class="fw-600 fs-6 mb-0">{{ trans('labels.other') }}</h5>
                                            @endif
                                        </div>

                                        <!-- remove & update address Btn -->
                                        <div class="d-flex align-items-center gap-2">
                                            <button class="btn btn-trash" type="button"
                                                onclick="deleteaddress('{{ $address->id }}')">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>

                                            <button class="btn btn-add" type="button"
                                                onclick="updateaddress('{{ $address->id }}','{{ $address->name }}','{{ $address->email }}','{{ $address->mobile }}','{{ $address->landmark }}','{{ $address->postcode }}','{{ preg_replace('/\s+/', ' ', $address->street) }}','{{ $address->address_type }}')">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- address content -->
                                    <div class="card-body pt-0">
                                        <ul class="list-group list-group-flush total_list">
                                            <li class="list-group-item px-0">
                                                <p class="fw-500 color-changer m-0">{{ trans('labels.name') }}</p>
                                                <p class="text-dark color-changer m-0">{{ $address->name }}</p>
                                            </li>
                                            <li class="list-group-item px-0">
                                                <p class="fw-500 color-changer m-0">{{ trans('labels.email') }}</p>
                                                <p class="text-dark color-changer m-0">{{ $address->email }}</p>
                                            </li>
                                            <li class="list-group-item py-3 border-bottom px-0">
                                                <p class="fw-500 color-changer m-0">{{ trans('labels.mobile') }}</p>
                                                <p class="text-dark color-changer m-0">{{ $address->mobile }}</p>
                                            </li>
                                        </ul>
                                        <div class="d-flex align-items-center d-grid gap-2 pt-2">
                                            <p class="fs-7 color-changer fw-500 m-0">{{ trans('labels.address') }}</p>
                                        </div>
                                        <p class="fs-7 pt-1 color-changer m-0">
                                            {{ $address->street }},{{ $address->landmark }} {{ $address->postcode }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="w-25 mx-auto">
                            <img src="{{ url('storage/app/public/others/no_data.png') }}" alt="nodata img">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- become provider -->
    @include('front.become_provider')

@endsection
