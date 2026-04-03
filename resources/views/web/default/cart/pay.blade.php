@extends(getTemplate().'.layouts.app')

@section('content')
    <section class="cart-banner position-relative text-center">
        <h1 class="font-30 text-white font-weight-bold">{{ trans('cart.checkout') }}</h1>
        <span class="payment-hint font-20 text-white d-block">
             {{ handlePrice($price) }}
        </span>
    </section>
        <!--<h2 class="section-title">{{ trans('financial.select_a_payment_gateway') }}</h2>-->

    @if(session()->has('checkout_id'))
        <div class="mt-30">
            {{-- سكربت بوابة هايبر باي --}}
            <script src="https://eu-prod.oppwa.com/v1/paymentWidgets.js?checkoutId={{ session('checkout_id') }}"></script>

            {{-- النموذج الخاص بالدفع --}}
            <form action="{{ route('payment_verfy') }}" class="paymentWidgets" data-brands="VISA MASTER"></form>
        </div>
    @endif

    <section class="container mt-45">

        @if(!empty($totalCashbackAmount))
            <div class="d-flex align-items-center mb-25 p-15 success-transparent-alert">
                <div class="success-transparent-alert__icon d-flex align-items-center justify-content-center">
                    <i data-feather="credit-card" width="18" height="18"></i>
                </div>
                <div class="ml-10">
                    <div class="font-14 font-weight-bold ">{{ trans('update.get_cashback') }}</div>
                    <div class="font-12 ">
                        {{ trans('update.by_purchasing_this_cart_you_will_get_amount_as_cashback',['amount' => handlePrice($totalCashbackAmount)]) }}
                    </div>
                </div>
            </div>
        @endif

      

        {{-- إذا في طرق دفع ثانية (مثلاً Razorpay) --}}
        @if(!empty($razorpay) and $razorpay)
            <form action="/payments/verify/Razorpay" method="get">
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <script src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key="{{ getRazorpayApiKey()['api_key'] }}"
                        data-amount="{{ (int)($order->total_amount * 100) }}"
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
@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/payment.min.js"></script>
@endpush
