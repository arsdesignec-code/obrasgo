@extends('layout.main')
@section('page_title',trans('labels.all_methods'))
@section('content')
   <section id="contenxtual">
      <div class="container-fluid">
         <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fs-4 color-changer fw-600">{{trans('labels.all_methods')}}</h5>
         </div>
         <div class="row">
            <div class="col-12">
               <div class="card border-0 my-3">
                  <div class="card-body">
                     <div class="table-responsive">
                        @include('payment_methods.pmethods_table')
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
@section('scripts')
   <script src="{{ asset('resources/views/payment_methods/pmethods.js') }}" type="text/javascript"></script>
@endsection