@if (helper::appdata()->provider_registration == 1)
    <section class="become-provider">
        <div class="container">
            <div class="card py-lg-5 provider-add"
                style="background-image: url('{{ helper::image_path(helper::otherdata('')->become_provider_image) }}')">
                <div class="overlay"></div>
                <div class="content p-sm-5 p-4">
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <div class="col-xl-7 col-lg-8 col-12 text-center">
                            <p class="mb-2 fs-5 fw-600">
                                {{ trans('labels.Do_You_want_Become_provider') }}
                            </p>
                            <h2 class="fw-bold text-capitalize mb-3">
                                {{ trans('labels.your_business') }}
                            </h2>
                            <p class="truncate-2 mb-4 fs-15">
                                {{ trans('labels.become_provider_note') }}
                            </p>
                        </div>
                        <a href="{{ URL::to('/admin/register') }}" class="btn btn-primary">
                            <div class="d-flex gap-2">
                                {{ trans('labels.become_provider') }}
                                <i
                                    class="fa-regular fa-arrow-{{ session()->get('direction') == 2 ? 'left' : 'right' }}"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<div class="extra-margin"></div>
