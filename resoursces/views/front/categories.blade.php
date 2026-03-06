@extends('front.layout.main')
@section('page_title',trans('labels.categories'))
@section('content')

      <!-- breadcrumb -->
      <div class="breadcrumb-bar">
         <div class="container">
            <div class="row">       
               <div class="col-auto breadcrumb-menu">
                  <nav aria-label="breadcrumb" class="page-breadcrumb">
                     <ol class="breadcrumb {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                        <li class="breadcrumb-item"><a href="{{URL::to('/')}}" class="color-changer">{{trans('labels.home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{trans('labels.categories')}}</li>
                     </ol>
                  </nav>
               </div>
            </div>
         </div>
      </div>
      
      <!-- category section -->
      <section class="content">
         <div class="container">
            <h2 class="fw-600 truncate-2 mb-4 color-changer sec-subtitle">{{ trans('labels.categories') }}</h2>
            @include('front.category_section')
         </div>
      </section>

      <!-- become provider -->
      @include('front.become_provider')
      
@endsection