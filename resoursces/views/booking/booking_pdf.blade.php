<html>

<head>
    <title>{{ helper::appdata($bookingdata->vendor_id)->web_title }}</title>
</head>
<style type="text/css">
    body {
        font-family: 'DejaVu Sans', sans-serif;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .mb-10 {
        margin-bottom: 10px;
    }

    .mt-20 {
        margin-top: 20px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-33 {
        width: 33.33%;
    }

    .w-85 {
        width: 85%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: 200px;
        height: 60px;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    table tr,
    th,
    td {
        border: 1px solid #d2d2d2;
        border-collapse: collapse;
        padding: 7px 8px;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 15px;
    }

    table tr td {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 10px;
    }

    .float-left {
        float: left;
    }

    .d-flex {
        display: flex;
    }

    .aling-items-center {
        align-items: center;
    }

    .justify-content-between {
        justify-content: space-between
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 20px;
    }
</style>

<body>
    <div class="head-title">
        <h1 class="text-center m-0 p-0">{{ trans('labels.booking') }}</h1>
    </div>
    <div class="add-detail mb-10">
        <div class="w-50 float-left mb-10">
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.booking_number') }} -
                <span class="gray-color">{{ $bookingdata->booking_id }}</span>
            </p>
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.booking_date') }} -
                <span class="gray-color">{{ helper::date_format($bookingdata->created_at) }}</span>
            </p>
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-20">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-33">{{ trans('labels.customer_info') }}</th>
                <th class="w-33">{{ trans('labels.provider') }}</th>
                @if ($bookingdata->handyman_id != '')
                    <th class="w-33">{{ trans('labels.handyman') }}</th>
                @endif
            </tr>
            <tr>
                <td class="w-33">
                    <div class="box-text">
                        <p>{{ $bookingdata->name }}</p>
                        <p>{{ $bookingdata->mobile }}</p>
                        <p>{{ $bookingdata->email }}</p>
                    </div>
                </td>
                <td class="w-33">
                    <div class="box-text">
                        <p>{{ $bookingdata->provider_name }}</p>
                        <p>{{ $bookingdata->provider_mobile }}</p>
                        <p>{{ $bookingdata->provider_email }}</p>
                    </div>
                </td>
                @if ($bookingdata->handyman_id != '')
                    <td class="w-33">
                        <div class="box-text">
                            <p>{{ $bookingdata->handyman_name }}</p>
                            <p>{{ $bookingdata->handyman_mobile }}</p>
                            <p>{{ $bookingdata->handyman_email }}</p>
                        </div>
                    </td>
                @endif
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-20">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">{{ trans('labels.address_info') }}</th>
                @if (@helper::checkaddons('vendor_tip'))
                    @if (@helper::otherdata()->tips_settings == 1)
                        <th class="w-50">{{ trans('labels.tips') }}</th>
                    @endif
                @endif
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p>
                            {{ $bookingdata->address }}
                        </p>
                    </div>
                </td>
                @if (@helper::checkaddons('vendor_tip'))
                    @if (@helper::otherdata()->tips_settings == 1)
                        <td>
                            <div class="box-text">
                                <p>
                                    {{ trans('labels.tips_pro') }} :
                                    {{ helper::currency_format($bookingdata->tips) }}
                                </p>
                            </div>
                        </td>
                    @endif
                @endif
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-20">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">{{ trans('labels.payment_details') }}</th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p>
                            {{ trans('labels.payment_method') }} :
                            {{ helper::getpayment($bookingdata->payment_type) }}
                            @if ($bookingdata->payment_type == 16)
                                <a href="{{ helper::image_path($bookingdata->screenshot) }}"
                                    class="text-danger">{{ trans('labels.click_here') }}</a>
                            @endif
                        </p>
                        @if (!empty($bookingdata->transaction_id))
                            <p>
                                {{ trans('labels.payment_id') }} :
                                {{ $bookingdata->transaction_id }}
                            </p>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-20">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-33">{{ trans('labels.service_name') }}</th>
                <th class="w-33">{{ trans('labels.date_time') }}</th>
                <th class="w-33">{{ trans('labels.sub_total') }}</th>
            </tr>
            <tr align="center">
                <td class="w-33">
                    {{ $bookingdata->service_name }}
                </td>
                <td class="w-33">
                    <p>{{ helper::date_format($bookingdata->date) }}
                        <span>{{ $bookingdata->time }}</span>
                    </p>

                </td>
                <td class="w-33">
                    {{ helper::currency_format($bookingdata->price) }}
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="total-part">
                        <div class="total-left w-85 float-left" align="left">
                            <p>{{ trans('labels.sub_total') }}</p>
                            @if ($bookingdata->discount != null)
                                <p>{{ trans('labels.discount') }}</p>
                            @endif
                            @if ($bookingdata->tax != null && $bookingdata->tax_name != null)
                                @php
                                    $tax = explode('|', $bookingdata->tax);
                                    $tax_name = explode('|', $bookingdata->tax_name);
                                @endphp
                                @foreach ($tax_name as $key => $taxes)
                                    <p>{{ $taxes }}</p>
                                @endforeach
                            @endif
                            <p>{{ trans('labels.total') }}</p>
                        </div>
                        <div class="total-right w-15 float-left text-bold" align="right">
                            <p>
                                {{ helper::currency_format($bookingdata->price) }}
                            </p>
                            @if ($bookingdata->discount != null)
                                <p>{{ helper::currency_format($bookingdata->discount) }}</p>
                            @endif
                            @if ($bookingdata->tax != null && $bookingdata->tax_name != null)
                                @php
                                    $tax = explode('|', $bookingdata->tax);
                                    $tax_name = explode('|', $bookingdata->tax_name);
                                @endphp
                                @foreach ($tax_name as $key => $taxes)
                                    <p>
                                        {{ helper::currency_format($tax[$key]) }}
                                    </p>
                                @endforeach
                            @endif
                            <p>
                                {{ helper::currency_format($bookingdata->total_amt) }}
                            </p>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
