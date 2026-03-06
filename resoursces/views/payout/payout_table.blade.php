<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class=" fw-500">
            <th class="fw-500">{{ trans('labels.request_id') }}</th>
            <th class="fw-500">{{ trans('labels.provider_name') }}</th>
            <th class="fw-500">{{ trans('labels.amount') }}</th>
            <th class="fw-500">{{ trans('labels.request_date') }}</th>
            <th class="fw-500">{{ trans('labels.payout_date') }}</th>
            <th class="fw-500">{{ trans('labels.status') }}</th>
            <th class="fw-500">{{ trans('labels.payment_type') }}</th>
            @if (Auth::user()->type == 1)
                <th class="fw-500">{{ trans('labels.action') }}</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if (!empty($requests) && count($requests) > 0)
            @foreach ($requests as $prdata)
                <tr>
                    <td>{{ $prdata->request_id }}</td>
                    <td>{{ $prdata->provider_name }}</td>
                    <td>
                        <small>
                            {{ trans('labels.requested_amt') }} :
                            <b>{{ helper::currency_format($prdata->request_balance) }}</b> <br>
                            {{ trans('labels.admin_commission') }} ({{ $prdata->commission }}%) : -
                            <b>{{ helper::currency_format($prdata->commission_amt) }}</b>
                            <div class="dropdown-divider"></div>
                            {{ trans('labels.payable_amt') }} :
                            <b>{{ helper::currency_format($prdata->payable_amt) }}</b>
                        </small>
                    </td>
                    <td>{{ helper::date_format($prdata->request_date) }}</td>
                    <td>
                        @if ($prdata->payout_date != '')
                            {{ helper::date_format($prdata->payout_date) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($prdata->status == 1)
                            <span class="badge text-bg-success">{{ trans('labels.paid') }}</span>
                        @endif
                        @if ($prdata->status == 2)
                            <span class="badge text-bg-warning">{{ trans('labels.pending') }}</span>
                        @endif
                    </td>
                    <td>
                        @if ($prdata->payment_method == 'cash')
                            {{ trans('labels.cash') }}
                        @elseif($prdata->payment_method == 'bank')
                            {{ trans('labels.bank') }}
                        @else
                            -
                        @endif
                    </td>
                    @if (Auth::user()->type == 1)
                        <td>
                            @if ($prdata->status == 2)
                                <a class="badge text-bg-info pay_now" href="javascrip:void(0)"
                                    data-request-id="{{ $prdata->request_id }}"
                                    data-request-amount="{{ $prdata->request_balance }}"
                                    data-commission="{{ $prdata->commission }}"
                                    data-commission-amt="{{ $prdata->commission_amt }}"
                                    data-payable-amt="{{ $prdata->payable_amt }}"
                                    data-provider-name="{{ $prdata->provider_name }}"
                                    data-provider-id="{{ $prdata->provider_id }}"
                                    data-bank-name="{{ $prdata->bank_name }}"
                                    data-account-holder="{{ $prdata->account_holder }}"
                                    data-account-type="{{ $prdata->account_type }}"
                                    data-account-number="{{ $prdata->account_number }}"
                                    data-routing-number="{{ $prdata->routing_number }}">{{ trans('labels.pay') }}</a>
                            @else
                                -
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="@if (Auth::user()->type == 1) 8 @else 7 @endif" align="center">
                    {{ trans('labels.payout_not_found') }}
                </td>
            </tr>
        @endif
    </tbody>
</table>
