@extends('layout.main')
@section('page_title', trans('labels.privacy_policy'))
@section('content')
    <div class="container-fluid">
        <div class="match-height">
            <div class="col-md-12">
                <h5 class="card-title color-changer fs-4 fw-600" id="basic-layout-form-center">{{ trans('labels.privacy_policy') }}</h5>
                <div class="card my-3">
                    <div class="card-body">
                        <form action="{{ URL::to('/privacy-policy/update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div id="snow-container">
                                <textarea class="form-control @error('privacy_content') is-invalid @enderror" required rows="10"
                                    name="privacy_content" id="ckeditor">{{ $privacydata->privacy_content }}</textarea>
                            </div>
                            <div class="mt-3 text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                @if (env('Environment') == 'sendbox')
                                    <button type="button" onclick="myFunction()"
                                        class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
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
