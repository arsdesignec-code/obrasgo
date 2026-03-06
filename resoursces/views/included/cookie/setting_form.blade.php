<div id="cookie">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-header bg-secondary text-white">
                    <h5 class="form-section d-flex gap-2 align-items-center text-capitalize">
                        {{ trans('labels.cookie_settings') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ URL::to('admin/cookie') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.cookie_text') }}
                                        <span class="text-danger"> * </span> </label>
                                    <textarea row="5" class="form-control" name="cookie_text" required
                                        placeholder="{{ trans('labels.cookie_text') }}">{{ @$settingdata->cookie_text }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.cookie_button_text') }}
                                        <span class="text-danger"> * </span> </label>
                                    <input type="text" class="form-control" name="cookie_button_text" required
                                        value="{{ @$settingdata->cookie_button_text }}"
                                        placeholder="{{ trans('labels.cookie_button_text') }}">
                                    @error('cookie_button_text')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                <button class="btn btn-primary px-sm-4"
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
