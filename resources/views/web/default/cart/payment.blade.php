@extends(getTemplate().'.layouts.app')

@push('styles_top')
<style>
    /* توحيد ارتفاع بطاقات الدفع */
    .payment-card {
        min-height: 220px; /* يمكن تعديل الرقم حسب الطول الأنسب */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .payment-card img {
        max-width: 100px;
        height: auto;
    }

    .charge-account-radio input[type="radio"] {
        display: none;
    }

    .charge-account-radio label {
        width: 100%;
        cursor: pointer;
        background: #fff;
        border: 2px solid #e5e5e5;
        border-radius: 8px;
    }

    .charge-account-radio input[type="radio"]:checked + label {
        border-color: #43d477;
        box-shadow: 0 0 10px rgba(67, 212, 119, 0.3);
    }
</style>
@endpush

@section('content')
    <section class="cart-banner position-relative text-center">
        <h1 class="font-30 text-white font-weight-bold">{{ trans('cart.checkout') }}</h1>
        <span class="payment-hint font-20 text-white d-block">
            {{ handlePrice($total) }} -
            {{ trans('cart.for_items', ['count' => $count]) }}
        </span>
    </section>

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

        @php
            $isMultiCurrency = !empty(getFinancialCurrencySettings('multi_currency'));
            $userCurrency = currency();
            $invalidChannels = [];
        @endphp

        <h2 class="section-title">{{ trans('financial.select_a_payment_gateway') }}</h2>

        <form id="paymentForm" action="/payments/payment-request" method="post" class="mt-25">
            {{ csrf_field() }}
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="row d-flex flex-wrap justify-content-center">

                {{-- البوابات من قاعدة البيانات --}}
                @if(!empty($paymentChannels))
                    @foreach($paymentChannels as $paymentChannel)
                        @if(!$isMultiCurrency or (!empty($paymentChannel->currencies) and in_array($userCurrency, $paymentChannel->currencies)))
                            <div class="col-6 col-md-3 mb-40 charge-account-radio d-flex">
                                <input type="radio" name="gateway" id="{{ $paymentChannel->title }}" data-class="{{ $paymentChannel->class_name }}" value="{{ $paymentChannel->id }}">
                                <label for="{{ $paymentChannel->title }}" class="payment-card rounded-sm p-20 p-lg-45">
                                    <img src="{{ $paymentChannel->image }}" alt="">
                                    <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue text-center">
                                        {{ trans('financial.pay_via') }}
                                        <span class="font-weight-bold font-14 d-block mt-1">{{ $paymentChannel->title }}</span>
                                    </p>
                                </label>
                            </div>
                        @else
                            @php $invalidChannels[] = $paymentChannel; @endphp
                        @endif
                    @endforeach
                @endif

                {{-- Mada --}}
                <div class="col-6 col-md-3 mb-40 charge-account-radio d-flex">
                    <input type="radio" name="gateway" id="Mada" data-class="Mada" value="Mada">
                    <label for="Mada" class="payment-card rounded-sm p-20 p-lg-45">
                        <img src="/public/images/icons/mada.png" alt="Mada">
                        <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue text-center">
                            {{ trans('financial.pay_via') }} <span class="font-weight-bold font-14 d-block mt-1">Mada</span>
                        </p>
                    </label>
                </div>

                {{-- Bank --}}
                <div class="col-6 col-md-3 mb-40 charge-account-radio d-flex">
                    <input type="radio" name="gateway" id="Bank" data-class="Bank" value="Bank">
                    <label for="Bank" class="payment-card rounded-sm p-20 p-lg-45">
                        <img src="/public/images/icons/bank.png" alt="Bank">
                        <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue text-center">
                            {{ trans('financial.pay_via') }} <span class="font-weight-bold font-14 d-block mt-1">Bank Payment</span>
                        </p>
                    </label>
                </div>

                {{-- Visa --}}
                <div class="col-6 col-md-3 mb-40 charge-account-radio d-flex">
                    <input type="radio" name="gateway" id="visa" data-class="Visa" value="visa">
                    <label for="visa" class="payment-card rounded-sm p-20 p-lg-45">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa">
                        <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue text-center">
                            {{ trans('financial.pay_via') }} <span class="font-weight-bold font-14 d-block mt-1">Visa</span>
                        </p>
                    </label>
                </div>

                {{-- Tamara --}}
                <div class="col-6 col-md-3 mb-40 charge-account-radio d-flex">
    <input type="radio" name="gateway" id="Tamara" data-class="Tamara" value="Tamara">
    <label for="Tamara" class="payment-card rounded-sm p-20 p-lg-45">
        <img src="https://demo.ejaabi.com/image/tamar.png" alt="Tamara">
        <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue text-center">
            {{ trans('financial.pay_via') }}
            <span class="font-weight-bold font-14 d-block mt-1">Tamara</span>
        </p>
    </label>
</div>

<!-- Popup لاختيار خطة التقسيط -->
<div class="modal fade" id="tamaraInstallmentModal" tabindex="-1" role="dialog" aria-labelledby="tamaraModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content p-4 text-center" style="background-color: #f9fafb; color: #222;">
      <h5 class="mb-3" style="color:#0c3c60;">اختر خطة التقسيط</h5>
      <p class="text-muted mb-4" style="color:#555 !important;">اختر عدد الدفعات المناسبة لك</p>

      <div id="installmentOptions" class="d-flex justify-content-around mb-3 flex-wrap">
        <!-- الأزرار تنشأ تلقائيًا بالـ JS -->
      </div>

      <button type="button" class="btn btn-secondary mt-3" data-dismiss="modal">إلغاء</button>
    </div>
  </div>
</div>

<form id="paymentForm" method="POST" action="#">
    @csrf
    <input type="hidden" name="installments" id="installmentsCount" value="">
    <input type="hidden" id="totalAmount" value="{{ $order->total_amount ?? 800 }}"> <!-- المجموع الكلي -->
    <button type="submit" id="paymentSubmit" class="btn btn-primary" disabled>ادفع الآن</button>
</form>


                
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
                            <div class="disabled-payment-channel bg-white border rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center payment-card">
                                <img src="{{ $invalidChannel->image }}" width="120" height="60" alt="">
                                <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue text-center">
                                    {{ trans('financial.pay_via') }}
                                    <span class="font-weight-bold font-14 d-block mt-1">{{ $invalidChannel->title }}</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="d-flex align-items-center justify-content-between mt-45">
                <span class="font-16 font-weight-500 text-gray">
                    {{ trans('financial.total_amount') }} 
                    @if(app()->getLocale() == 'ar')
                        {{ number_format($total, 0) }}: ر.س
                    @else
                        SAR {{ number_format($total, 0) }}:
                    @endif
                </span>
                <!--<button type="submit" id="paymentSubmit" disabled class="btn btn-sm btn-primary">-->
                <!--    {{ trans('public.start_payment') }}-->
                <!--</button>-->
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
    let installmentsInput = document.getElementById("installmentsCount");
    let totalAmount = parseFloat(document.getElementById("totalAmount").value);
    let optionsContainer = document.getElementById("installmentOptions");

    radios.forEach(radio => {
        radio.addEventListener("change", function () {
            submitBtn.disabled = false;

            switch(this.value) {
                case "Tamara":
                    form.action = "{{ route('payment_tamara') }}";

                    // 🔹 تحقق من المبلغ
                    if (totalAmount < 200) {
                        // المبلغ أقل من 200 → دفعة واحدة فقط
                        installmentsInput.value = 1;
                        form.submit();
                    } else {
                        // المبلغ 200 أو أكثر → عرض خيارات التقسيط
                        generateInstallmentButtons();
                        $('#tamaraInstallmentModal').modal('show');
                    }
                    break;

                case "visa":
                    form.action = "{{ route('payment_visa') }}";
                    break;

                case "Mada":
                    form.action = "{{ route('payment_mada') }}";
                    break;

                case "Bank":
                    form.action = "{{ route('payment_bank') }}";
                    break;

                default:
                    form.action = "/payments/payment-request";
            }
        });
    });

    // إنشاء الأزرار بشكل ديناميكي مع الأسعار
    function generateInstallmentButtons() {
        optionsContainer.innerHTML = '';
        const plans = [2, 4, 8];
        plans.forEach(count => {
            const perPayment = (totalAmount / count).toFixed(2);
            const btn = document.createElement('button');
            btn.type = "button";
            btn.className = "btn btn-outline-success installment-btn m-2 p-3";
            btn.setAttribute('data-installments', count);
            btn.innerHTML = `
                <div>
                    <div style="font-weight:600; color:#0c3c60;">${count} دفعات</div>
                    <div style="font-size:14px; color:#333; margin-top:4px;">
                        ${perPayment} ر.س لكل دفعة
                    </div>
                </div>
            `;
            optionsContainer.appendChild(btn);
        });

        // المستمع عند الضغط على زر التقسيط
        document.querySelectorAll('.installment-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const count = this.getAttribute('data-installments');
                installmentsInput.value = count;
                $('#tamaraInstallmentModal').modal('hide');
            });
        });
    }
});
</script>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/payment.min.js"></script>
@endpush
