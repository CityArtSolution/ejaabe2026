@php
    app()->setLocale('en');
@endphp

@extends(getTemplate().'.layouts.canada_app')

@push('styles_top')
    <!-- يمكنك إضافة أي ملفات CSS إضافية هنا إذا لزم -->
@endpush

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card shadow p-4" style="border-radius: 12px; border: 1px solid #ddd;">
                    <h2 class="text-center mb-4">ادفع الآن</h2>

                    <p class="text-center" style="font-size: 18px;">
                        المبلغ المطلوب دفعه:
                        <strong>{{ $order->amount }} SAR</strong>
                    </p>

                    <!-- تحميل مكتبة الدفع -->
                    <script src="https://eu-prod.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $checkoutId }}"></script>

                    <!-- نموذج الدفع -->
                    <form action="{{ route('payment.callback') }}" class="paymentWidgets" data-brands="VISA MADA MASTER"></form>
                </div>
            </div>
        </div>
    </div>
@endsection
