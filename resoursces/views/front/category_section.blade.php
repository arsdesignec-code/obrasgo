@if (!empty($categorydata) && count($categorydata) > 0)
    <div class="catsec">
        <div class="row flex-wrap row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 g-sm-4 g-3 match-height">
            @foreach ($categorydata as $cdata)
                <div class="col">
                    <a href="{{ URL::to('/home/services/' . $cdata->slug) }}">
                        <div class="box w-100 rounded h-100">
                            <img src="{{ helper::image_path($cdata->image) }}">
                            <div class="box-content">
                                <div class="content">
                                    <h3 class="title truncate-2">{{ $cdata->name }}</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                    {{-- <div class="card text-center">
                        <div class="card-body m-0 p-0">
                            <a href="{{ URL::to('/home/services/' . $cdata->slug) }}">
                                <img class="" src="{{ helper::image_path($cdata->image) }}"
                                    alt="{{ trans('labels.image') }}">
                            </a>
                        </div>
                        <div class="card-footer bg-white">
                            <p class="truncate-1 cat-title">{{ $cdata->name }}</p>
                        </div>
                    </div> --}}
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="w-25 mx-auto">
        <img src="{{ helper::image_path(helper::otherdata('')->no_data_image) }}" alt="nodata img">
    </div>
@endif
