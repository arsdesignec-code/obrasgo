@extends('layout.main')
@section('page_title', trans('labels.language'))
@section('content')
    <div class="container-fluid">
        <div class="alert alert-warning">
            <i class="fa-regular fa-circle-exclamation"></i> This section is available only for website & admin panel.
        </div>

        <div class="alert rgb-secondary-light color-changer border-0" role="alert">
            <p>Dont Use Double Qoute (")</p>
        </div>

        <div class="row settings pb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-capitalize color-changer fs-4 fw-600">{{ trans('labels.language') }}</h5>
                @if (@helper::checkaddons('language'))
                    <div class="d-flex justify-content-end">
                        <a href="{{ URL::to('language-settings/language/add') }}"
                            class="btn btn-secondary px-sm-4 d-flex gap-2 align-items-center">
                            <i class="fa fa-plus"></i>
                            {{ trans('labels.add') }}
                        </a>
                    </div>
                @endif
            </div>
            <div class="col-xl-3 mb-3">
                <div class="card card-sticky-top border-0 h-auto">
                    <ul class="list-group list-options">
                        @foreach ($getlanguages as $data)
                            <a href="{{ URL::to('language-settings/' . $data->code) }}"
                                class="list-group-item basicinfo p-3 list-item-primary @if ($currantLang->code == $data->code) active @endif"
                                aria-current="true">
                                <div class="d-flex justify-content-between align-item-center">
                                    {{ $data->name }}
                                    <div class="d-flex gap-2 align-item-center">
                                        @if ($data->is_default == '1')
                                            <span>{{ trans('labels.default') }}</span>
                                        @endif
                                        <i
                                            class="{{ session()->get('direction') == 2 ? 'fa fa-angle-left' : 'fa fa-angle-right' }}"></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="d-flex align-items-center gap-2">
                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="language setting">
                        <div class="dropdown lag-btn">
                            @php
                                $title = $currantLang->layout == 1 ? trans('labels.ltr') : trans('labels.rtl');
                            @endphp

                            <button class="btn btn-secondary fiex-hw" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{-- {{ $title }} --}}
                                <i class="fa-solid fa-language"></i>
                            </button>
                            <ul class="dropdown-menu bg-body-secondary mt-2 border-0 shadow-sm"
                                aria-labelledby="dropdownMenuButton1">
                                {{-- @if ($currantLang->layout == 1) --}}
                                <a class="dropdown-item cursor-pointer text-{{ session()->get('direction') == 2 ? 'end' : 'start' }} p-2"
                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="updatestatus('{{ $currantLang->id }}','2','{{ URL::to('language-settings/layout/update') }}')" @endif>
                                    {{ trans('labels.rtl') }} </a>
                                {{-- @else --}}
                                <a class="dropdown-item cursor-pointer text-{{ session()->get('direction') == 2 ? 'end' : 'start' }} p-2"
                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="updatestatus('{{ $currantLang->id }}','1','{{ URL::to('language-settings/layout/update') }}')" @endif>
                                    {{ trans('labels.ltr') }} </a>
                                {{-- @endif --}}
                            </ul>
                        </div>
                    </div>
                    <a class="btn btn-info fiex-hw text-white" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Edit" href="{{ URL::to('/language-settings/language/edit-' . $currantLang->id) }}">
                        {{-- {{ trans('labels.edit') }}  --}}
                        <i class="ft-edit"></i>
                    </a>
                    @if (Strtolower($currantLang->name) != 'english')
                        <a class="btn btn-danger fiex-hw text-white" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Remove"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="updatestatus('{{ $currantLang->id }}','2','{{ URL::to('language-settings/language/delete') }}')" @endif>
                            {{-- {{ trans('labels.delete') }} --}}
                            <i class="ft-trash"></i>
                        </a>
                    @endif
                </div>
                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="labels-tab" data-bs-toggle="tab"
                            data-bs-target="#labels" type="button" role="tab" aria-controls="labels"
                            aria-selected="true">Labels</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="message-tab" data-bs-toggle="tab" data-bs-target="#message"
                            type="button" role="tab" aria-controls="message" aria-selected="false">Messages</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="labels" role="tabpanel" aria-labelledby="labels-tab">
                        <div class="card border-0 box-shadow">
                            <div class="card-body">
                                <form method="post" action="{{ URL::to('language-settings/update') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" name="currantLang"
                                        value="{{ $currantLang->code }}">
                                    <input type="hidden" class="form-control" name="file" value="label">
                                    <div class="row">
                                        @foreach ($arrLabel as $label => $value)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="example3cols1Input">{{ $label }}
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        name="label[{{ $label }}]" id="label{{ $label }}"
                                                        onkeyup="validation($(this).val(),this.getAttribute('id'))"
                                                        value="{{ $value }}">
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-lg-12">
                                            <div class="text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                                <div class="d-flex justify-content-end">
                                                    @if (env('Environment') == 'sendbox')
                                                        <button type="button" class="btn btn-raised btn-primary px-sm-4"
                                                            onclick="myFunction()"><i class="fa fa-check-square-o"></i>
                                                            {{ trans('labels.save') }} </button>
                                                    @else
                                                        <button type="submit" class="btn btn-raised btn-primary px-sm-4"><i
                                                                class="fa fa-check-square-o"></i>
                                                            {{ trans('labels.save') }}
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="message" role="tabpanel" aria-labelledby="message-tab">
                        <div class="card border-0 box-shadow">
                            <div class="card-body">
                                <form method="post" action="{{ URL::to('admin/language-settings/update') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" name="currantLang"
                                        value="{{ $currantLang->code }}">
                                    <input type="hidden" class="form-control" name="file" value="message">
                                    <div class="row">
                                        @foreach ($arrMessage as $label => $value)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="example3cols1Input">{{ $label }}
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        name="message[{{ $label }}]"
                                                        id="message{{ $label }}"
                                                        onkeyup="validation($(this).val(),this.getAttribute('id'))"
                                                        value="{{ $value }}">
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-lg-12">
                                            <div class="text-{{ session()->get('direction') == 2 ? 'start' : 'end' }}">
                                                <div class="d-flex justify-content-end">
                                                    @if (env('Environment') == 'sendbox')
                                                        <button type="button" class="btn btn-raised btn-primary px-sm-4"
                                                            onclick="myFunction()"><i class="fa fa-check-square-o"></i>
                                                            {{ trans('labels.save') }} </button>
                                                    @else
                                                        <button type="submit" class="btn btn-raised btn-primary px-sm-4"><i
                                                                class="fa fa-check-square-o"></i>
                                                            {{ trans('labels.save') }}
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function validation(value, id) {
            if (value.includes('"')) {
                newval = value.replaceAll('"', '');
                $('#' + id).val(newval);
            }
        }
    </script>
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/settings.js') }}"></script>
@endsection
