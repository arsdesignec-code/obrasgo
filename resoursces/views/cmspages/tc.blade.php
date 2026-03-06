@extends('layout.main')
@section('page_title', trans('labels.terms_conditions'))
@section('content')
    <div class="container-fluid">
        <div class="match-height">
            <div class="col-md-12">
                <h5 class="card-title color-changer fs-4 fw-600" id="basic-layout-form-center">{{ trans('labels.terms_conditions') }}</h5>
                <div class="card my-3">
                    <div class="card-body">
                        <form action="{{ URL::to('/terms-conditions/update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div id="snow-container">
                                <textarea class="form-control @error('content') is-invalid @enderror" rows="10" name="content" id="ckeditor">{{ $tcdata->tc_content }}</textarea>
                            </div>
                            <div class="mt-3 text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                @if (env('Environment') == 'sendbox')
                                    <button type="button" onclick="myFunction()"
                                        class="btn btn-primary px-sm-4">{{ trans('labels.save') }} </button>
                                @else
                                    <button class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        CKEDITOR.replace('ckeditor');
    </script>
@endsection
