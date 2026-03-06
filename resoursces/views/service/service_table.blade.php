<div class="table-responsive">
    <table class="table table-striped table-bordered py-3 zero-configuration">
        <thead>
            <tr class=" fw-500">
                @if (@helper::checkaddons('bulk_delete'))
                    @if($servicedata->count() > 0)
                        <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                    @endif
                @endif
                <th>{{ trans('labels.srno') }}</th>
                <th>{{ trans('labels.image') }}</th>
                <th>{{ trans('labels.service') }}</th>
                <th>{{ trans('labels.category') }}</th>
                <th>{{ trans('labels.price') }}</th>
                <th>{{ trans('labels.duration') }}</th>
                <th>{{ trans('labels.discount') }}</th>
                <th>{{ trans('labels.created_at') }}</th>
                <th>{{ trans('labels.update_at') }}</th>
                @if (Auth::user()->type == 2)
                    <th>{{ trans('labels.top_deals') }}</th>
                    <th>{{ trans('labels.featured') }}</th>
                    <th>{{ trans('labels.status') }}</th>
                @endif
                <th class="custom-width">{{ trans('labels.action') }}</th>
            </tr>
        </thead>
        <tbody @if (Auth::user()->type == 2) id="tabledetails" @endif data-url="{{ URL::to('/reorder-service') }}">
            <?php $i = 1; ?>
            @foreach ($servicedata as $sdata)
                <tr class="row1" id="dataid{{ $sdata->id }}" data-id="{{ $sdata->id }}">
                    @if (@helper::checkaddons('bulk_delete'))
                        <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $sdata->id }}"></td>
                    @endif
                    <td><?= $i++ ?></td>
                    <td><img src="{{ helper::image_path($sdata->image) }}" alt="{{ trans('labels.service') }}"
                            class="rounded table-image hw-50"></td>
                    <td>{{ $sdata->name }}</td>
                    <td>{{ $sdata['categoryname']->name }}</td>
                    <td>{{ helper::currency_format($sdata->price) }}</td>
                    <td>
                        @if ($sdata->price_type == 'Fixed')
                            @if ($sdata->duration_type == 1)
                                {{ $sdata->duration . trans('labels.minutes') }}
                            @elseif ($sdata->duration_type == 2)
                                {{ $sdata->duration . trans('labels.hours') }}
                            @elseif ($sdata->duration_type == 3)
                                {{ $sdata->duration . trans('labels.days') }}
                            @else
                                {{ $sdata->duration . trans('labels.minutes') }}
                            @endif
                        @else
                            {{ $sdata->price_type }}
                        @endif
                    </td>
                    <td>
                        @if ($sdata->discount > 0)
                            {{ $sdata->discount }}%
                        @endif
                    </td>
                    <td>{{ helper::date_format($sdata->created_at) }}<br>
                        {{ helper::time_format($sdata->created_at) }}
                    </td>
                    <td>{{ helper::date_format($sdata->updated_at) }}<br>
                        {{ helper::time_format($sdata->updated_at) }}
                    </td>
                    @if (Auth::user()->type == 2)
                        <td>
                            @if (env('Environment') == 'sendbox')
                                @if ($sdata->is_top_deals == 1)
                                    <a class="btn btn-outline-success btn-sm" onclick="myFunction()">
                                        <i class="ft-check"></i>
                                    </a>
                                @else
                                    <a class="btn btn-outline-danger btn-sm" onclick="myFunction()">
                                        <i class="ft-x"></i>
                                    </a>
                                @endif
                            @else
                                @if ($sdata->is_top_deals == 1)
                                    <a class="btn btn-outline-success btn-sm"
                                        onclick="updateserviceistop_deals('{{ $sdata->id }}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('services/edit/is_top_deals') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
                                        <i class="ft-check"></i>
                                    </a>
                                @else
                                    <a class="btn btn-outline-danger btn-sm"
                                        onclick="updateserviceistop_deals('{{ $sdata->id }}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('services/edit/is_top_deals') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
                                        <i class="ft-x"></i>
                                    </a>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if (env('Environment') == 'sendbox')
                                @if ($sdata->is_featured == 1)
                                    <a class="btn btn-outline-success btn-sm" onclick="myFunction()">
                                        <i class="ft-check"></i>
                                    </a>
                                @else
                                    <a class="btn btn-outline-danger btn-sm" onclick="myFunction()">
                                        <i class="ft-x"></i>
                                    </a>
                                @endif
                            @else
                                @if ($sdata->is_featured == 1)
                                    <a class="btn btn-outline-success btn-sm"
                                        onclick="updateserviceisfeatured('{{ $sdata->id }}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('services/edit/is_featured') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
                                        <i class="ft-check"></i>
                                    </a>
                                @else
                                    <a class="btn btn-outline-danger btn-sm"
                                        onclick="updateserviceisfeatured('{{ $sdata->id }}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('services/edit/is_featured') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
                                        <i class="ft-x"></i>
                                    </a>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if (env('Environment') == 'sendbox')
                                @if ($sdata->is_available == 1)
                                    <a class="btn btn-outline-success btn-sm" onclick="myFunction()">
                                        <i class="ft-check"></i>
                                    </a>
                                @else
                                    <a class="btn btn-outline-danger btn-sm" onclick="myFunction()">
                                        <i class="ft-x"></i>
                                    </a>
                                @endif
                            @else
                                @if ($sdata->is_available == 1)
                                    <a class="btn btn-outline-success btn-sm"
                                        onclick="updatestatus('{{ $sdata->id }}','2','{{ URL::to('services/edit/status') }}')">
                                        <i class="ft-check"></i>
                                    </a>
                                @else
                                    <a class="btn btn-outline-danger btn-sm"
                                        onclick="updatestatus('{{ $sdata->id }}','1','{{ URL::to('services/edit/status') }}')">
                                        <i class="ft-x"></i>
                                    </a>
                                @endif
                            @endif
                        </td>
                    @endif
                    <td>
                        <div class="d-flex gap-1">
                            @if (Auth::user()->type == 2)
                                <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Edit" href="{{ URL::to('/services/edit/' . $sdata->slug) }}">
                                    <i class="ft-edit"></i>
                                </a>
                                @if (env('Environment') == 'sendbox')
                                    <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Remove" onclick="myFunction()"><i class="ft-trash"></i>
                                    </a>
                                @else
                                    <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Remove"
                                        onclick="updatestatus('{{ $sdata->id }}','','{{ URL::to('/services-del') }}')">
                                        <i class="ft-trash"></i>
                                    </a>
                                @endif
                            @endif
                            <a class="btn btn-dark btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="View" href="{{ URL::to('/services/' . $sdata->slug) }}">
                                <i class="ft-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
