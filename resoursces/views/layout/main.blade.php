<!DOCTYPE html>
<html lang="en" dir="{{ session('direction') == 2 ? 'rtl' : 'ltr' }}" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script>
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.add('light');
        }
    </script>

    <title>{{ helper::appdata()->website_title }} | @yield('page_title')</title>
    <link rel="shortcut icon" type="image/png" href="{{ helper::image_path(helper::appdata()->favicon) }}">
    <!-- style.min css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('storage/app/public/admin-assets/fonts/feather/style.min.css') }}">
    <!-- font-awesome css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('storage/app/public/admin-assets/css/font-awesome/font-awesome.min.css') }}">
    <!-- style css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('storage/app/public/admin-assets/fonts/simple-line-icons/style.css') }}">

    <!-- sweetalert css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('storage/app/public/plugins/sweetalert/css/sweetalert2.min.css') }}">
    <!-- toastr css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.css') }}">
    <!-- bootstrap css -->
    <link rel="stylesheet"
        href="{{ asset('storage/app/public/admin-assets/css/plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- custom css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/css/app.css') }}">
    <!-- responsive css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/css/responsive.css') }}">

    <link rel="stylesheet"
        href="{{ asset('storage/app/public/admin-assets/css/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('storage/app/public/admin-assets/css/datatables/buttons.dataTables.min.css') }}">

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/fullcalendar.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('styles')
</head>
<!-- IF VERSION 2  -->
@if (helper::appdata('')->recaptcha_version == 'v2')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endif
<!-- IF VERSION 3  -->
@if (helper::appdata('')->recaptcha_version == 'v3')
    {!! RecaptchaV3::initJs() !!}
@endif

<style>
    :root {
        --bs-primary: {{ helper::otherdata()->admin_primary_color }};
        --bs-secondary: {{ helper::otherdata()->admin_secondary_color }};
    }
</style>

<body data-col="2-columns" class=" 2-columns">

    <div class="wrapper">

        @include('layout.main_menu')
        @include('layout.header_navbar')

        <div class="main-panel">
            <div class="{{ session()->get('direction') == 2 ? 'main-content-rtl' : 'main-content' }}">
                <div class="content-wrapper page-content">
                    <div class="container-fluid">
                        @if (Auth::user()->type == 2 && helper::check_bank() < 1)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        <div class="fi_bt text-center fw-600 fs-5">
                                            <a
                                                href="{{ URL::to('/profile-settings') }}">{{ trans('labels.click_to_complete_profile') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @yield('content')

                    </div>

                </div>
            </div>
        </div>

        <!--Modal: order-modal-->
        <div class="modal fade" id="order-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-notify modal-info" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header d-flex justify-content-center">
                        <p class="heading color-changer">{{ trans('messages.be_up_to_date') }}</p>
                    </div>
                    <div class="modal-body color-changer"><i class="fa fa-bell fa-4x animated rotateIn mb-4"></i>
                        <p>{{ trans('messages.new_order_arrive') }}</p>
                    </div>
                    <div class="modal-footer flex-center">
                        <a role="button" class="btn btn-primary waves-effect" onClick="window.location.reload();"
                            data-bs-dismiss="modal">{{ trans('labels.okay') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Service Gallery Image -->
        <div class="modal fade" id="edit_service_gallery" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabeledit" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" name="edit_gallery_form" class="form" id="edit_gallery_form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header justify-content-between">
                            <h5 class="modal-title color-changer" id="exampleModalLabeledit">
                                {{ trans('labels.images') }}</h5>
                            <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                            </button>
                        </div>
                        <span id="emsg"></span>
                        <span class="text-danger" id="gallery_error"></span>
                        <div class="modal-body">
                            <input type="hidden" id="gimage_id" name="gimage_id">
                            <input type="hidden" id="gallery_edit_url" url="{{ URL::to('gallery/edit') }}">
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.image') }}</label>
                                <input type="file" class="form-control" name="image" id="image">
                                <span class="text-danger" id="gallery_image_error"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.image') }}</label>
                                <img id="oldGalleryImg" alt="{{ trans('labels.image') }}"
                                    class="rounded edit-image w-100">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger px-sm-4"
                                data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                            @if (env('Environment') == 'sendbox')
                                <button type="button" onclick="myFunction()"
                                    class="btn btn-primary px-sm-4">{{ trans('labels.submit') }} </button>
                            @else
                                <button type="submit"
                                    class="btn btn-primary px-sm-4">{{ trans('labels.submit') }}</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Gallery Image -->
        <div class="modal fade" id="add_gallery_image" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabeledit" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" name="add_gallery" class="form" id="add_gallery"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header justify-content-between">
                            <h5 class="modal-title color-changer" id="exampleModalLabeledit">
                                {{ trans('labels.image') }}</h5>
                            <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                            </button>
                        </div>
                        <span class="text-danger text-center" id="other_error"></span>
                        <div class="modal-body">
                            <input type="hidden" name="service_id" id="gallery_service_id">
                            <input type="hidden" name="add_gallery_url" id="add_gallery_url"
                                url="{{ URL::to('gallery/add') }}">
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.image') }}</label>
                                <input type="file" class="form-control" name="image[]" multiple>
                                <span class="text-danger" id="add_gallery_image_error"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger px-sm-4"
                                data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                            @if (env('Environment') == 'sendbox')
                                <button type="button" onclick="myFunction()"
                                    class="btn btn-primary px-sm-4">{{ trans('labels.submit') }} </button>
                            @else
                                <button type="submit"
                                    class="btn btn-primary px-sm-4">{{ trans('labels.submit') }}</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Select handyman -->
        <div class="modal fade" id="select_handyman" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabeledit" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ URl::to('/bookings/assign_handyman') }}" method="post" name="select_handyman"
                    class="form" id="select_handyman_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header justify-content-between">
                            <h5 class="modal-title color-changer" id="exampleModalLabeledit">
                                {{ trans('labels.handyman') }}</h5>
                            <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="hidden" id="booking_id" name="id">
                                    <label class="form-label">{{ trans('labels.select_handyman') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="select_hanyman_option" name="handyman_id" class="form-select"
                                        data-toggle="tooltip" data-trigger="hover" data-placement="top"
                                        data-title="handyman_id" required>
                                        <option value="" selected disabled>{{ trans('labels.select') }}</option>
                                        @if (Auth::user()->type == 2)
                                            @isset($ahandymandata)
                                                @foreach ($ahandymandata as $hdata)
                                                    <option value="{{ $hdata->id }}">{{ $hdata->name }}</option>
                                                @endforeach
                                            @endisset
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger px-sm-4"
                                data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                            @if (env('Environment') == 'sendbox')
                                <button type="button" onclick="myFunction()"
                                    class="btn btn-primary px-sm-4">{{ trans('labels.assign') }} </button>
                            @else
                                <button type="submit"
                                    class="btn btn-primary px-sm-4">{{ trans('labels.assign') }}</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- complete booking otp -->
        <div class="modal fade" id="complete_booking" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabeledit" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ URl::to('/bookings/booking_verify_otp') }}" method="post" name="complete_booking"
                    class="form" id="complete_booking_form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header justify-content-between">
                            <h5 class="modal-title color-changer" id="exampleModalLabeledit">
                                {{ trans('labels.verify_otp') }}</h5>
                            <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="hidden" id="cbooking_id" name="cbooking_id">
                                    <input type="hidden" id="cbooking_status" name="cbooking_status">
                                    <label for="otp" class="form-label">{{ trans('labels.otp') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="otp" id="otp"
                                        placeholder="{{ trans('labels.otp') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger px-sm-4"
                                data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                            @if (env('Environment') == 'sendbox')
                                <button type="button" onclick="myFunction()"
                                    class="btn btn btn-primary px-sm-4">{{ trans('labels.submit') }} </button>
                            @else
                                <button type="submit"
                                    class="btn btn btn-primary px-sm-4">{{ trans('labels.submit') }}</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- payout modal -->
        <div class="modal fade text-left" id="payout_modal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-between">
                        <h5 class="modal-title color-changer" id="exampleModalScrollableTitle">
                            {{ trans('labels.payout_request') }}
                        </h5>
                        <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                        </button>
                    </div>
                    <form action="{{ URL::to('/payout/update') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <h6 class="form-section color-changer mb-3"><i class="fa fa-university"></i>
                                {{ trans('labels.bank_info') }}
                            </h6>
                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label">{{ trans('labels.bank_name') }}</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="bank_name" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label">{{ trans('labels.account_holder') }}</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="account_holder" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label">{{ trans('labels.account_type') }}</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="account_type" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label">{{ trans('labels.account_number') }}</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="account_number" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label">{{ trans('labels.routing_number') }}</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="routing_number" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6 class="form-section color-changer mb-3"><i class="fa fa-user"></i>
                                {{ trans('labels.basic_info') }}</h6>
                            <label class="form-label">{{ trans('labels.request_id') }}</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="request_id" id="request_id"
                                    readonly>
                                @error('request_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="form-label">{{ trans('labels.provider_name') }}</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="provider_name" id="provider_name"
                                    disabled>
                                <input type="hidden" class="form-control" name="provider_id" id="provider_id"
                                    disabled>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <label class="form-label">{{ trans('labels.commission') }} </label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="commission" id="commission"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <label class="form-label">{{ trans('labels.commission_amt') }}</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="commission_amt"
                                            id="commission_amt" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <label class="form-label">{{ trans('labels.payable_amt') }}</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="payable_amt"
                                            id="payable_amt" disabled>
                                    </div>
                                </div>
                            </div>

                            <label class="form-label">{{ trans('labels.payment_methods') }}</label>
                            <div class="form-group">
                                <select class="form-control" name="payment_method" required="">
                                    <option value="" selected disabled>{{ trans('labels.select') }}</option>
                                    <option value="cash">{{ trans('labels.cash') }}</option>
                                    <option value="bank">{{ trans('labels.bank') }}</option>
                                </select>
                                @error('payment_method')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger px-sm-4"
                                data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                            <input type="submit" class="btn btn-primary px-sm-4" value="{{ trans('labels.pay') }}">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- jquery js -->
    <script src="{{ asset('storage/app/public/admin-assets/vendors/js/core/jquery-3.2.1.min.js') }}"
        type="text/javascript"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('storage/app/public/admin-assets/css/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- toastr js -->
    <script src="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.js') }}" type="text/javascript"></script>
    <!-- sweetalert js -->
    <script src="{{ asset('storage/app/public/plugins/sweetalert/js/sweetalert2.min.js') }}" type="text/javascript">
    </script>
    <!-- datatables js -->
    <script src="{{ asset('storage/app/public/admin-assets/vendors/js/datatable/datatables.min.js') }}"
        type="text/javascript"></script>
    <!-- popper js -->
    <script src="{{ asset('storage/app/public/admin-assets/vendors/js/core/popper.min.js') }}" type="text/javascript">
    </script>
    <!-- perfect-scrollbar js -->
    <script src="{{ asset('storage/app/public/admin-assets/vendors/js/perfect-scrollbar.jquery.min.js') }}"
        type="text/javascript"></script>
    <!-- matchHeight js -->
    <script src="{{ asset('storage/app/public/admin-assets/vendors/js/jquery.matchHeight-min.js') }}"
        type="text/javascript"></script>
    <!-- screenfull js -->
    <script src="{{ asset('storage/app/public/admin-assets/vendors/js/screenfull.min.js') }}" type="text/javascript">
    </script>
    <!-- pacemin js -->
    <script src="{{ asset('storage/app/public/admin-assets/vendors/js/pace/pace.min.js') }}" type="text/javascript">
    </script>
    <!-- notification-sidebar js -->
    <script src="{{ asset('storage/app/public/admin-assets/js/notification-sidebar.js') }}" type="text/javascript">
    </script>
    <!-- customizer js -->
    <script src="{{ asset('storage/app/public/admin-assets/js/customizer.js') }}" type="text/javascript"></script>
    <!-- validate js -->
    <script src="{{ asset('storage/app/public/admin-assets/js/jquery.validate.js') }}" type="text/javascript"></script>
    <!-- app-sidebar js -->
    <script src="{{ asset('storage/app/public/admin-assets/js/app-sidebar.js') }}" type="text/javascript"></script>
    <!-- Datatables JS -->
    <script src="{{ asset('storage/app/public/admin-assets/js/datatables/jquery.dataTables.min.js') }}"></script>
    <!-- Datatables Bootstrap5 JS -->
    <script src="{{ asset('storage/app/public/admin-assets/js/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <!-- Datatables Buttons JS -->
    <script src="{{ asset('storage/app/public/admin-assets/js/datatables/dataTables.buttons.min.js') }}"></script>
    <!-- Datatables Excel Buttons JS -->
    <script src="{{ asset('storage/app/public/admin-assets/js/datatables/jszip.min.js') }}"></script>
    <!-- Datatables Make PDF Buttons JS -->
    <script src="{{ asset('storage/app/public/admin-assets/js/datatables/pdfmake.min.js') }}"></script>
    <!-- Datatables Export PDF Buttons JS -->
    <script src="{{ asset('storage/app/public/admin-assets/js/datatables/vfs_fonts.js') }}"></script>
    <!-- Datatables Buttons HTML5 JS -->
    <script src="{{ asset('storage/app/public/admin-assets/js/datatables/buttons.html5.min.js') }}"></script>
    <!-- coman JS -->
    <script src="{{ asset('storage/app/public/admin-assets/js/common.js') }}"></script>
    <script src="{{ asset('storage/app/public/admin-assets/js/jquery-ui.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script>
        var darklogo = "{{ helper::image_path(helper::appdata('')->dark_logo) }}";
        var lightlogo = "{{ helper::image_path(helper::appdata('')->logo) }}";
    </script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif
    <script>
        @if (Auth::user()->type == 2)
            // New Notification
            var noticount = 0;
            var notificationurl = "{{ URl::to('/getorder') }}";
            var vendoraudio =
                "{{ url(env('ASSETSPATHURL') . 'notification/' . helper::providerdata(Auth::user()->id)->notification_sound) }}";
        @endif

        var are_you_sure = "{{ trans('messages.are_you_sure') }}";
        var yes = "{{ trans('messages.yes') }}";
        var no = "{{ trans('messages.no') }}";
        var record_safe = "{{ trans('messages.record_safe') }}";
        var wrong = "{{ trans('messages.wrong') }}";
        @if (Session::has('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif
        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        function clearnotification(user_id) {
            "use strict";
            var CSRF_TOKEN = $('input[name="_token"]').val();
            $.ajax({
                headers: {
                    'X-CSRF-Token': CSRF_TOKEN
                },
                url: "{{ URL::to('/clearnotification') }}",
                data: {
                    user_id: user_id
                },
                dataType: "json",
                success: function(response) {
                    window.location.href = "{{ URL::to('/notifications') }}";
                }
            });
        }

        function clearhelp() {
            "use strict";
            var CSRF_TOKEN = $('input[name="_token"]').val();
            $.ajax({
                headers: {
                    'X-CSRF-Token': CSRF_TOKEN
                },
                url: "{{ URL::to('/clearhelp') }}",
                dataType: "json",
                success: function(response) {
                    window.location.href = "{{ URL::to('/help') }}";
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        $('img[data-enlargeable]').addClass('img-enlargeable').click(function() {
            var src = $(this).attr('src');
            var modal;

            function removeModal() {
                modal.remove();
                $('body').off('keyup.modal-close');
            }
            modal = $('<div>').css({
                background: 'RGBA(0,0,0,.6) url(' + src + ') no-repeat center',
                backgroundSize: 'contain',
                width: '100%',
                height: '100%',
                position: 'fixed',
                zIndex: '10000',
                top: '0',
                left: '0',
                cursor: 'zoom-out'
            }).click(function() {
                removeModal();
            }).appendTo('body');
            $('body').on('keyup.modal-close', function(e) {
                if (e.key === 'Escape') {
                    removeModal();
                }
            });
        });

        function myFunction() {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
            toastr.error("Permission disabled for demo mode");
        }

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-1',
                cancelButton: 'btn btn-danger mx-1'
            },
            buttonsStyling: false
        })
    </script>
    @if (@helper::checkaddons('notification'))
        @if (Auth::user()->type == 2)
            <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/js/sound.js') }}"></script>
        @endif
    @endif
    @yield('scripts')

</body>

</html>
