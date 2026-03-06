@extends('layout.main')
@section('page_title',trans('labels.users'))
@section('content')
   <div class="container-fluid">
      <section id="contenxtual">
         <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fs-4 color-changer fw-600">{{ trans('labels.customer') }}</h5>
         </div>
         <div class="row">
            <div class="col-12">
                  <div class="card border-0 my-3">
                     <div class="card-body">
                        <div class="table-responsive">
                           @include('users.users_table')
                        </div>
                     </div>
                  </div>
            </div>
         </div>
      </section>
   </div>
@endsection