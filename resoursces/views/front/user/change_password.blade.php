@extends('front.layout.vendor_theme')

@section('page_title')
    {{ trans('labels.user') }} | {{ trans('labels.change_password') }}
@endsection

@section('front_content')
    <div class="col-xl-9 col-md-8">
        <div class="tab-content pt-0">
            <div class="tab-pane show active">
                <div class="widget">
                    <h4 class="widget-title">{{ trans('labels.change_password') }}</h4>
                    <form action="{{ URL::to('/home/user/changepass') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-xl-12">
                                <label class="mr-sm-2">{{ trans('labels.old_pass') }}</label>
                                <input class="form-control @error('old_pass') is-invalid @enderror" type="password"
                                    name="old_pass" value="{{ old('old_pass') }}"
                                    placeholder="{{ trans('labels.enter_old_pass') }}">
                                @error('old_pass')
                                    <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-xl-12">
                                <label class="mr-sm-2">{{ trans('labels.new_pass') }}</label>
                                <input class="form-control @error('new_pass') is-invalid @enderror" type="password"
                                    name="new_pass" value="{{ old('new_pass') }}"
                                    placeholder="{{ trans('labels.enter_new_pass') }}">
                                @error('new_pass')
                                    <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-xl-12">
                                <label class="mr-sm-2">{{ trans('labels.confirm_pass') }}</label>
                                <input class="form-control @error('confirm_pass') is-invalid @enderror" type="password"
                                    name="confirm_pass" value="{{ old('confirm_pass') }}"
                                    placeholder="{{ trans('labels.enter_confirm_pass') }}">
                                @error('confirm_pass')
                                    <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                            @if (isset($_COOKIE['city_id']))
                                <div class="form-group col-xl-12">
                                    <input type="submit" class="btn btn-primary pl-5 pr-5"
                                        value="{{ trans('labels.update') }}">
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
