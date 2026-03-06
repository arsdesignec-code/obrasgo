@extends('layout.main')
@section('content')
<div class="d-flex justify-content-between align-items-center">
    @if (request()->is('/calendar/add'))
        <h5 class="card-title fs-4 color-changer fw-600">{{ trans('labels.calendar') }}</h5>
    @else
        <h5 class="card-title fs-4 color-changer fw-600"></h5>
    @endif
    @if (Auth::user()->type == 2)
        <a href="{{ URL::to('/calendar/add') }}" class="btn btn-secondary gap-2 px-sm-4">
            <i class="fa fa-plus" height="16px"></i>{{ trans('labels.add') }}
        </a>
    @endif
</div>
 
    <div class="row mt-3">
        <div class="container">
            <div id='calendar'></div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/calendar/moment.min.js') }}"></script>
<script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/calendar/fullcalendar.js') }}"></script> 
<script>
$(document).ready(function() {
    var bookings = @json($events);
    console.log(bookings);
    $('#calendar').fullCalendar({
       
        events: bookings,
        selectable:true,
        selcetHelper:true,
        displayEventTime: false,
        editable:true,
        eventDrop:function(event)
        {
            console.log(event);
        },
        select:function(start,end,allDays)
        {
            console.log('dgdfgdfg');
        },
        eventClick : function(event)
        {   
            var booking_id = event.booking_id;
            var provider_id = {{Auth::user()->id }};
            if({{Auth::user()->type }}== 2 || ({{Auth::user()->type }}== 3 ))
            {
                location.href = "{{URL::to('/bookings')}}"+ '/' +booking_id;
            }
        }
    })
});
</script>

@endsection
