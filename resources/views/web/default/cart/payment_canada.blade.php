@php
    app()->setLocale('en');
@endphp

@extends(getTemplate().'.layouts.canada_app')

@push('styles_top')

@endpush

@section('content')
    <section class="cart-banner position-relative text-center">
        <h1 class="font-30 text-white font-weight-bold">{{ trans('cart.checkout') }}</h1>
        <span class="payment-hint font-20 text-white d-block"></span>
    </section>

    <section class="container mt-45">

        @if(!empty($totalCashbackAmount))
            <div class="d-flex align-items-center mb-25 p-15 success-transparent-alert">
                <div class="success-transparent-alert__icon d-flex align-items-center justify-content-center">
                    <i data-feather="credit-card" width="18" height="18" class=""></i>
                </div>

                <div class="ml-10">
                    <div class="font-14 font-weight-bold ">{{ trans('update.get_cashback') }}</div>
                    <div class="font-12 ">{{ trans('update.by_purchasing_this_cart_you_will_get_amount_as_cashback',['amount' => handlePrice($totalCashbackAmount , false)]) }}</div>
                </div>
            </div>
        @endif

        @php
            $isMultiCurrency = !empty(getFinancialCurrencySettings('multi_currency'));
            $userCurrency = currency();
            $invalidChannels = [];
        @endphp

        <h2 class="section-title">{{ trans('financial.select_a_payment_gateway') }}</h2>

        <form id="paymentForm" action="/payments/payment-request" method="post" class="mt-25">
            {{ csrf_field() }}
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="row">
                @if(!empty($paymentChannels))
                    @foreach($paymentChannels as $paymentChannel)
                        @if(!$isMultiCurrency or (!empty($paymentChannel->currencies) and in_array($userCurrency, $paymentChannel->currencies)))
                            <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                                <input type="radio" name="gateway" id="{{ $paymentChannel->title }}" data-class="{{ $paymentChannel->class_name }}" value="{{ $paymentChannel->id }}">
                                <label for="{{ $paymentChannel->title }}" class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ $paymentChannel->image }}" width="120" height="60" alt="">

                                    <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                                        {{ trans('financial.pay_via') }}
                                        <span class="font-weight-bold font-14">{{ $paymentChannel->title }}</span>
                                    </p>
                                </label>
                            </div>
                        @else
                            @php
                                $invalidChannels[] = $paymentChannel;
                            @endphp
                        @endif
                    @endforeach
                @endif

                {{-- Canada ET --}}
                <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                    <input type="radio" name="gateway" id="CanadaET" data-class="CanadaET" value="CanadaET">
                    <label for="CanadaET" class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                        <img src="https://canada.ejaabi.com/public/images/icons/canada_et.jpeg" height="80">

                        <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                            {{ trans('financial.pay_via') }}
                            <span class="font-weight-bold font-14">Canada ET</span>
                        </p>
                    </label>
                </div>

                {{-- Visa ثابتة --}}
                <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                    <input type="radio" name="gateway" id="visa" data-class="Visa" value="visa">
                    <label for="visa" class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" width="100" alt="Visa">

                        <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                            {{ trans('financial.pay_via') }}
                            <span class="font-weight-bold font-14">Visa</span>
                        </p>
                    </label>
                </div>
{{-- Tamara ثابتة --}}
<div class="col-6 col-lg-4 mb-40 charge-account-radio">
    <input type="radio" name="gateway" id="Tamara" data-class="Tamara" value="Tamara">
    <label for="Tamara" class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
        <img src="https://demo.ejaabi.com/image/tamara.png" width="100" alt="Tamara">

        <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
            {{ trans('financial.pay_via') }}
            <span class="font-weight-bold font-14">Tamara</span>
        </p>
    </label>
</div>

            </div>

            @if(!empty($invalidChannels) and empty(getFinancialSettings("hide_disabled_payment_gateways")))
                <div class="d-flex align-items-center mt-30 rounded-lg border p-15">
                    <div class="size-40 d-flex-center rounded-circle bg-gray200">
                        <i data-feather="info" class="text-gray" width="20" height="20"></i>
                    </div>
                    <div class="ml-5">
                        <h4 class="font-14 font-weight-bold text-gray">{{ trans('update.disabled_payment_gateways') }}</h4>
                        <p class="font-12 text-gray">{{ trans('update.disabled_payment_gateways_hint') }}</p>
                    </div>
                </div>

                <div class="row mt-20">
                    @foreach($invalidChannels as $invalidChannel)
                        <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                            <div class="disabled-payment-channel bg-white border rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                                <img src="{{ $invalidChannel->image }}" width="120" height="60" alt="">

                                <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                                    {{ trans('financial.pay_via') }}
                                    <span class="font-weight-bold font-14">{{ $invalidChannel->title }}</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="d-flex align-items-center justify-content-between mt-45">
                <span class="font-16 font-weight-500 text-gray">{{ trans('financial.total_amount') }} {{ handlePrice($total , false) }} {{ getBranchCurrency(3) }}</span>
                <button type="submit" id="paymentSubmit" disabled class="btn btn-sm btn-primary">{{ trans('public.start_payment') }}</button>
            </div>
        </form>

        @if(!empty($razorpay) and $razorpay)
            <form action="/payments/verify/Razorpay" method="get">
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <script src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key="{{ getRazorpayApiKey()['api_key'] }}"
                        data-amount="{{ (int)($order->total_amount * 100) }}"
                        data-buttontext="product_price"
                        data-description="Rozerpay"
                        data-currency="{{ currency() }}"
                        data-image="{{ $generalSettings['logo'] }}"
                        data-prefill.name="{{ $order->user->full_name }}"
                        data-prefill.email="{{ $order->user->email }}"
                        data-theme.color="#43d477">
                </script>
            </form>
        @endif
    </section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let form = document.getElementById("paymentForm");
    let radios = document.querySelectorAll("input[name='gateway']");
    let submitBtn = document.getElementById("paymentSubmit");

    radios.forEach(radio => {
        radio.addEventListener("change", function () {
            submitBtn.disabled = false;

            if (this.value === "Tamara") {
    form.action = "{{ route('payment_tamara') }}"; // بوابة Tamara
} else if (this.value === "CanadaET") {
    form.action = "{{ route('payment_canada') }}";
} else if (this.value === "visa") {
    form.action = "{{ route('payment_visa') }}";
} else {
    form.action = "/payments/payment-request";
}

        });
    });
});
</script>

@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/payment.min.js"></script>
@endpush
