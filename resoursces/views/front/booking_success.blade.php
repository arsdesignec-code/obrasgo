@extends('front.layout.main')

@section('page_title', trans('labels.success'))

<script type="text/javascript">
    function preventBack() {
        "use strict";
        window.history.forward();
    }
    setTimeout("preventBack()", 0);
    window.onunload = function() {
        null
    };
</script>

@section('content')
    <section class="success my-sm-5 py-sm-5">
        <div class="container">
            <div class="success-box">
                <div class="col-lg-8 col-sm-10 col-12">
                    <div class="py-sm-5 py-4 px-4 px-md-0">
                        <img src="{{ helper::image_path(helper::otherdata()->booking_success_image) }}" alt=""
                            class="order-img">
                        <h2 class="success-title">{{ trans('labels.thanks_for_booking') }}</h2>
                        <h3 class="success-subtitle">{{ trans('labels.booking_placed_processed') }}</h3>
                    </div>
                    <div class="row g-lg-1 g-2 justify-content-center mb-2"> 
                        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-12">
                            <a href="{{ URL::to('/') }}" class="btn btn-secondary w-100">{{ trans('labels.home') }}</a>
                        </div>
                        
                        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-12">
                            <a href="{{ URL::to('/home/user/bookings/' . $bookingdata->booking_id) }}"
                                class="btn btn-primary px-0 w-100">{{ trans('labels.track_booking') }}</a>
                        </div>
                    </div>
                    <div class="row g-lg-1 g-2 justify-content-center">
                        
                        @if (@helper::checkaddons('whatsapp_message'))
                            @if (whatsapp_helper::whatsapp_message_config()->booking_created == 1)
                                @if (whatsapp_helper::whatsapp_message_config()->message_type == 2)
                                    <div class="col-sm-auto col-12">
                                        <a href="https://api.whatsapp.com/send?phone={{ whatsapp_helper::whatsapp_message_config()->whatsapp_number }}&text={{ @$whmessage }}"
                                            target="_blank"
                                            class="btn w-100 btn-success px-0">{{ trans('labels.send_booking_on_whatsapp') }}</a>
                                    </div>
                                @endif
                            @endif
                        @endif
                        @if (@helper::checkaddons('telegram_message'))
                            @if (helper::telegramdata()->booking_created == 1)
                                <div class="col-sm-auto col-12">
                                    <a href="{{ URL::to('telegram/' . $bookingdata->booking_id) }}"
                                        class="btn w-100 btn-info px-0">{{ trans('labels.send_booking_on_telegram') }}</a>
                                </div>
                            @endif
                        @endif
                        @if (@helper::checkaddons('ical_export'))
                            <div class="col-sm-auto col-12">
                                <a  href="{{ URL::to('/home/user/icalfile/' . $bookingdata->booking_id) }}"
                                    class="btn w-100 btn-warning px-0">
                                    {{ trans('labels.download_ical_file') }}
                                </a>
                            </div>
                        @endif  
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="extra-paddings"></div>
@endsection
