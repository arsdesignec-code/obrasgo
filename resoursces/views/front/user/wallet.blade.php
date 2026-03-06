@extends('front.layout.vendor_theme')
@section('page_title')
    {{ trans('labels.user') }} | {{ trans('labels.wallet') }}
@endsection
@section('front_content')
    <!-- wallet -->
    <div class="col-12 col-md-12 col-lg-8 col-xl-9 wallet-sec">
        @if (!empty($walletdata))
            <?php $total_credit = 0;
            $total_debit = 0; ?>
            @foreach ($wallettotal as $wallet)
                @if ($wallet->payment_type == 2)
                    <?php $total_debit += $wallet->amount; ?>
                @else
                    <?php $total_credit += $wallet->amount; ?>
                @endif
            @endforeach

            <div class="card">
                <div class="card-header border-bottom bg-transparent py-3">
                    <h5 class="widget-title color-changer mb-0">{{ trans('labels.wallet') }}</h5>
                </div>
                <!-- all payment status -->
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Current balance & Recharge Wallet -->
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card border h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="wallet_img bg-light rounded-2 overflow-hidden">
                                            <img src="{{ url('storage/app/public/wallet/wallet.png') }}" alt="wallet img">
                                        </div>
                                        <div class="wallet-content">
                                            <h5 class="fw-600 fs-17 mb-1 color-changer text-capitalize">
                                                {{ trans('labels.current_balance') }}</h5>
                                            <span
                                                class="fw-600 fs-15 text-muted m-0">{{ helper::currency_format(Auth::user()->wallet) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card border cp h-100" data-bs-toggle="offcanvas" data-bs-target="#rechargewallet"
                                aria-controls="offcanvasRight">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-xl-3 gap-2">
                                            <div class="wallet_img bg-light rounded-2 overflow-hidden">
                                                <img src="{{ url('storage/app/public/wallet/add-money.png') }}"
                                                    alt="recharge img">
                                            </div>
                                            <div class="wallet-content d-flex align-items-center gap-2">
                                                <h5 class="fw-600 fs-17 color-changer text-capitalize">{{ trans('labels.add_money') }}
                                                </h5>
                                                <i class="far fa-angle-right color-changer fs-5"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- total payment -->
                        <div class="col-sm-6 col-12">
                            <div class="card border">
                                <div class="card-header border-bottom bg-transparent py-3">
                                    <h5 class="widget-title color-changer mb-0">{{ trans('labels.total_credit') }}</h5>
                                </div>
                                <div class="card-body">
                                    <h6 class="mb-0 color-changer">+ {{ helper::currency_format($total_credit) }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="card border">
                                <div class="card-header border-bottom bg-transparent py-3">
                                    <h5 class="widget-title color-changer mb-0">{{ trans('labels.total_debit') }}</h5>
                                </div>
                                <div class="card-body">
                                    <h6 class="mb-0 color-changer">- {{ helper::currency_format($total_debit) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- transactions list -->
                    @if (!empty($walletdata) && count($walletdata) > 0)
                        <h4 class="widget-title color-changer fs-5 mt-3 mb-3">{{ trans('labels.transactions') }} </h4>

                        <div class="row g-3">
                            @foreach ($walletdata as $wallet)
                                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="card border transaction-card">
                                        <div class="card-body">
                                            <div class="row justify-content-between align-items-center g-0">
                                                <div class="d-md-flex align-items-center gap-3">
                                                    <div class="mb-3 mb-sm-0">
                                                        @if ($wallet->payment_type == 2)
                                                            <div
                                                                class="wallet_icon_box border border-danger bg-danger-subtle rounded-2">
                                                                <i class="fa-regular fa-circle-xmark text-danger"></i>
                                                            </div>
                                                        @elseif(in_array($wallet->payment_type, ['1', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15']))
                                                            <div
                                                                class="wallet_icon_box border border-success bg-success-subtle rounded-2">
                                                                <i class="fa-regular fa-circle-check text-success"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="w-100">
                                                        <h5
                                                            class="text-truncate fw-600 color-changer fs-6 wallet-title text-center text-md-start m-0">
                                                            @if ($wallet->payment_type == 1)
                                                                {{ trans('labels.booking_canceled') }}
                                                                <strong>
                                                                    <a href="{{ URL::to('/home/user/bookings/' . $wallet->booking_id) }}"
                                                                        class="fw-semibold text-dark color-changer">{{ $wallet->booking_id }}</a>
                                                                </strong>
                                                            @elseif($wallet->payment_type == 2)
                                                                {{ trans('labels.service_booked') }}
                                                                <strong>
                                                                    <a href="{{ URL::to('/home/user/bookings/' . $wallet->booking_id) }}"
                                                                        class="fw-semibold text-dark color-changer">{{ $wallet->booking_id }}</a>
                                                                </strong>
                                                            @elseif(in_array($wallet->payment_type, ['3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15']))
                                                                {{ trans('labels.added_with_card') }}
                                                            @elseif($wallet->payment_type == 7)
                                                                {{ trans('labels.from_reference') }}
                                                                <strong>{{ $wallet->username }}</strong>
                                                            @endif
                                                        </h5>
                                                        <div class="d-flex justify-content-between align-items-center pt-1">
                                                            @if ($wallet->payment_type == 2)
                                                                <h6 class="text-danger fw-semibold fs-15 m-0">
                                                                    @if ($wallet->tips > 0)
                                                                        -({{ helper::currency_format($wallet->amount) }}
                                                                        +
                                                                        {{ trans('labels.tips') . ' : ' . helper::currency_format($wallet->tips) }})
                                                                    @else
                                                                        -{{ helper::currency_format($wallet->amount) }}
                                                                    @endif
                                                                </h6>
                                                            @elseif(in_array($wallet->payment_type, ['1', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15']))
                                                                <h6 class="text-success fw-semibold fs-15 m-0">
                                                                    +{{ helper::currency_format($wallet->amount) }}</h6>
                                                            @endif
                                                            <p class="text-muted fw-500 fs-7 m-0">
                                                                {{ helper::date_format($wallet->date) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- more data -->
                        <div class="d-flex justify-content-center">
                            {{ $walletdata->links() }}
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="w-25 mx-auto">
                <img src="{{ url('storage/app/public/others/no_data.png') }}" alt="nodata img">
            </div>
            <p class="text-center">{{ trans('labels.no_data') }}</p>
        @endif
    </div>

    <!-- become provider -->
    @include('front.become_provider')

    <input type="hidden" name="name" id="name" value="{{ Auth::user()->name }}">
    <input type="hidden" name="email" id="email" value="{{ Auth::user()->email }}">
    <input type="hidden" name="mobile" id="mobile" value="{{ Auth::user()->mobile }}">
    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
    <input type="hidden" name="amt_err_text" id="amt_err_text" value="{{ trans('messages.enter_amount') }}">
    <input type="hidden" name="select_ptype" id="select_ptype" value="{{ trans('messages.select_payment_type') }}">
    <input type="hidden" name="title" id="title" value="{{ trans('labels.app_name') }}">
    <input type="hidden" name="description" id="description" value="{{ trans('labels.add_wallet_description') }}">
    <input type="hidden" name="logo" id="logo"
        value="https://stripe.com/img/documentation/checkout/marketplace.png">
    <input type="hidden" name="add_wallet_url" id="add_wallet_url" value="{{ URL::to('/home/user/wallet/add') }}">
    <input type="hidden" name="wallet_url" id="wallet_url" value="{{ URL::to('/home/user/wallet') }}">

    <input type="hidden" name="mercadopagourl" id="mercadopagourl" value="{{ URL::to('/home/mercadorequest') }}">
    <input type="hidden" name="myfatoorahurl" id="myfatoorahurl" value="{{ URL::to('/home/myfatoorah') }}">
    <input type="hidden" name="paypalurl" id="paypalurl" value="{{ URL::to('/home/paypal') }}">
    <input type="hidden" name="toyyibpayurl" id="toyyibpayurl" value="{{ URL::to('/home/toyyibpay') }}">
    <input type="hidden" name="paytaburl" id="paytaburl" value="{{ URL::to('/home/paytab') }}">
    <input type="hidden" name="phonepeurl" id="phonepeurl" value="{{ URL::to('/home/phonepe') }}">
    <input type="hidden" name="mollieurl" id="mollieurl" value="{{ URL::to('/home/mollie') }}">
    <input type="hidden" name="khaltiurl" id="khaltiurl" value="{{ URL::to('/home/khalti') }}">
    <input type="hidden" name="xenditurl" id="xenditurl" value="{{ URL::to('/home/xendit') }}">
    <input type="hidden" name="paymentsuccess" id="paymentsuccess"
        value="{{ URL::to('home/user/addpaymentsuccess') }}">
    <input type="hidden" name="paymentfail" id="paymentfail" value="{{ URL::to('home/user/addpaymentfail') }}">

    <form action="{{ URL::to('home/paypal') }}" method="post" class="d-none">
        @csrf
        <input type="hidden" name="return" value="2">
        <input type="submit" class="callpaypal" name="submit">
    </form>

@endsection

@section('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://checkout.stripe.com/v2/checkout.js"></script>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
@endsection
