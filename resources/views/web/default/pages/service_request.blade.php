@extends(getTemplate() . '.layouts.app')

@push('styles_top')
<style>
    .service-request-page {
        padding: 55px 0;
        background: #f5f8fb;
        text-align: start;
    }

    .service-request-page .request-box {
        max-width: 850px;
        margin: auto;
        padding: 35px;
        border: 1px solid #e4ebf2;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 12px 35px rgba(16, 57, 87, .06);
    }

    .service-request-page h1 {
        color: #103957;
        font-size: 28px;
        line-height: 1.6;
        margin-bottom: 12px;
    }

    .service-request-page .request-intro {
        color: #647687;
        line-height: 1.9;
        margin-bottom: 30px;
    }

    .service-request-page label {
        display: block;
        margin-bottom: 9px;
        font-size: 15px;
    }

    .service-request-page .form-control {
        min-height: 48px;
        border-radius: 10px;
    }

    .service-request-page textarea.form-control {
        height: auto;
        resize: vertical;
    }

    .service-request-page .request-submit {
        min-height: 48px;
        padding: 12px 28px;
        border: 0;
        border-radius: 10px;
        background: #136ba5;
        color: #fff;
    }

    @media (max-width: 575px) {
        .service-request-page { padding: 30px 0; }
        .service-request-page .request-box { padding: 22px 18px; }
        .service-request-page h1 { font-size: 23px; }
        .service-request-page .request-submit { width: 100%; }
    }
</style>
@endpush

@section('content')
    @php
        $ar = app()->getLocale() === 'ar';

        $fields = [
            'name' => [
                'label' => $ar ? 'الاسم' : 'Name',
                'type' => 'text',
                'autocomplete' => 'name',
                'max' => 255,
            ],
            'email' => [
                'label' => $ar ? 'البريد الإلكتروني' : 'Email',
                'type' => 'email',
                'autocomplete' => 'email',
                'max' => 255,
            ],
            'phone' => [
                'label' => $ar ? 'رقم الهاتف' : 'Phone',
                'type' => 'tel',
                'autocomplete' => 'tel',
                'max' => 30,
            ],
            'company' => [
                'label' => $ar
                    ? 'الجهة أو الشركة (اختياري)'
                    : 'Organization or company (optional)',
                'type' => 'text',
                'autocomplete' => 'organization',
                'max' => 255,
            ],
        ];
    @endphp

    <section class="service-request-page" dir="{{ $ar ? 'rtl' : 'ltr' }}">
        <div class="container">
            <div class="request-box">
                <h1>{{ $pageTitle }}</h1>

                <p class="request-intro">
                    {{ $ar
                        ? 'أدخل بيانات التواصل وتفاصيل طلبك. حقل الجهة أو الشركة اختياري.'
                        : 'Enter your contact information and request details. Organization or company is optional.' }}
                </p>

                @if (session('success'))
                    <div class="alert alert-success" role="status">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ $formAction }}" method="POST">
                    @csrf

                    <div class="row">
                        @foreach ($fields as $name => $field)
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="service-{{ $name }}">
                                        {{ $field['label'] }}
                                    </label>

                                    <input
                                        id="service-{{ $name }}"
                                        type="{{ $field['type'] }}"
                                        name="{{ $name }}"
                                        value="{{ old($name) }}"
                                        autocomplete="{{ $field['autocomplete'] }}"
                                        maxlength="{{ $field['max'] }}"
                                        class="form-control @error($name) is-invalid @enderror"
                                        @if ($name !== 'company') required @endif
                                        @if ($name === 'phone') minlength="10" @endif
                                        @if (in_array($name, ['email', 'phone'])) dir="ltr" @endif
                                        @error($name)
                                            aria-invalid="true"
                                            aria-describedby="service-{{ $name }}-error"
                                        @enderror
                                    >

                                    @error($name)
                                        <div id="service-{{ $name }}-error"
                                             class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <div class="col-12">
                            <div class="form-group">
                                <label for="service-description">
                                    {{ $ar ? 'تفاصيل الطلب (اختياري)' : 'Request details (optional)' }}
                                </label>

                                <textarea
                                    id="service-description"
                                    name="description"
                                    rows="6"
                                    maxlength="10000"
                                    class="form-control @error('description') is-invalid @enderror"
                                >{{ old('description') }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="request-submit">
                        {{ $pageTitle }}
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection