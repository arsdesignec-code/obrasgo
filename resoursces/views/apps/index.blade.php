@extends('layout.main')
@section('page_title', trans('labels.addons'))
@section('content')
    <div class="container-fluid">
        <div class="card mb-3 border-0 rgb-success-light shadow">
            <div class="card-body rounded py-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h5 class="card-title color-changer mb-1 fw-600">Visit our store to purchase addons</h5>
                        <p class="text-muted fw-medium">Install our addons to unlock premium features</p>
                    </div>
                    <a href="https://store.paponapps.co.in/products?category=servicego" target="_blank"
                        class="btn btn-dark fiexd-color col-sm-auto col-12">Visit Our Store</a>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-capitalize color-changer fs-4 fw-600">{{ trans('labels.addons_manager') }}</h5>
            <div class="d-inline-flex">
                <a href="{{ URL::to('createsystem-addons') }}"
                    class="btn btn-secondary px-sm-4 d-flex align-items-center gap-2">
                    <i class="fa-regular fa-plus"></i>{{ trans('labels.add') }}</a>
            </div>
        </div>
        <div class="search_row">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-link active bg-white" id="installed-tab" data-bs-toggle="tab" href="#installed"
                                role="tab" aria-controls="installed"
                                aria-selected="true">{{ trans('labels.installed_addons') }} ({{ count($addons) }})</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="installed" role="tabpanel"
                            aria-labelledby="installed-tab">
                            <div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3 pt-3">
                                @if (count($addons) > 0)
                                    @foreach ($addons as $addon)
                                        <div class="col">
                                            <div class="card h-100 w-100">
                                                <img class="img-fluid rounded-top" src='{!! asset('storage/app/public/addons/' . $addon->image) !!}'
                                                    alt="">
                                                <div class="card-body">
                                                    <h5 class="fs-6 color-changer">
                                                        {{ $addon->name }}
                                                    </h5>
                                                    @if (env('Environment') == 'sendbox')
                                                        @if ($addon->type == '1')
                                                            <span class="badge bg-primary mt-2 fw-400 fs-8">FREE
                                                                ADDON</span>
                                                        @else
                                                            <span class="badge bg-danger mt-2 fw-400 fs-8">PREMIUM</span>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div
                                                    class="card-footer border-top bg-transparent p-3 d-flex align-items-center justify-content-between flex-wrap">
                                                    <p class="card-text d-inline">
                                                        <small
                                                            class="text-muted fs-7">{{ date('d M Y', strtotime($addon->created_at)) }}</small>
                                                    </p>
                                                    @if ($addon->activated == 1)
                                                        <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="updatestatus('{{ $addon->id }}','2','{{ URL::to('systemaddons/edit/status') }}')" @endif
                                                            class="btn btn-sm btn-success {{ session()->get('direction') == 2 ? 'float-start' : 'float-end' }}">{{ trans('labels.activated') }}</a>
                                                    @else
                                                        <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="updatestatus('{{ $addon->id }}','1','{{ URL::to('systemaddons/edit/status') }}')" @endif
                                                            class="btn btn-sm btn-danger {{ session()->get('direction') == 2 ? 'float-start' : 'float-end' }}">{{ trans('labels.deactivated') }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Col -->
                                    @endforeach
                                @else
                                    <div class="col col-md-12 text-center text-muted mt-4">
                                        <h4>{{ trans('labels.no_addon_installed') }}</h4>
                                        <a href="https://store.paponapps.co.in/products?category=servicego" target="_blank"
                                            class="btn btn-success mt-4">Visit Our
                                            Store</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
