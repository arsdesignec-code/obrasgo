@extends('layout.main')
@section('page_title', trans('labels.edit_faq'))
@section('content')
    <section id="basic-form-layouts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fs-4 color-changer fw-600" id="horz-layout-colored-controls">{{ trans('labels.edit_faq') }}</h5>
                    <div class="card my-3">
                        <div class="card-body">
                            <form class="form form-horizontal" id="add_how_it_works_form"
                                action="{{ URL::to('/faq/edit/' . $faqdata->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label">{{ trans('labels.question') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="category_name"
                                                    class="form-control @error('question') is-invalid @enderror" name="question"
                                                    value="{{ $faqdata->question }}" placeholder="{{ trans('labels.enter_question') }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label">{{ trans('labels.answers') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control @error('answer') is-invalid @enderror" name="answer" cols="30" rows="2"
                                                    placeholder="{{ trans('labels.enter_answer') }}" required>{{ $faqdata->answer }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                        <a class="btn btn-danger px-sm-4" href="{{ URL::to('faq') }}">{{ trans('labels.cancel') }} </a>
                                        @if (env('Environment') == 'sendbox')
                                            <button type="button" class="btn btn-primary px-sm-4"
                                                onclick="myFunction()">{{ trans('labels.save') }} </button>
                                        @else
                                            <button type="submit" id="btn_add_provider"
                                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }} </button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
