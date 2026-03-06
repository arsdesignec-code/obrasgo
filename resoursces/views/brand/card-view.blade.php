@if (count($branddata) > 0)
    <div class="row row-cols-xxl-6 row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-2 g-3">
        @foreach ($branddata as $brand)
            <div class="col">
                <div class="card h-100 border-0 text-center">
                    <div class="card-body border-0">
                        <img src="{{ helper::image_path($brand->image) }}" class="img-fluid gallery-img rounded"
                            alt="">
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <div>
                            <a class="btn btn-sm btn-info" href="{{ URL::to('brand/edit/' . $brand->id) }}"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                <i class="ft-edit"></i>
                            </a>
                            <a class="btn btn-sm btn-danger" href="javascript:void(0)" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-title="Remove"
                                @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="updatestatus('{{ $brand->id }}','','{{ URL::to('brand/delete') }}')" @endif>
                                <i class="ft-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="w-25 mx-auto">
        <img src="{{ helper::image_path(helper::otherdata('')->no_data_image) }}" alt="nodata img" class="w-100">
    </div>
@endif
