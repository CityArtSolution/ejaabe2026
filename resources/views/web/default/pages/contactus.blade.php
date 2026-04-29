@extends(getTemplate().'.layouts.canada_app')

@push('styles_top')
<link rel="stylesheet" href="/assets/vendors/leaflet/leaflet.css">
<style>
    /* أيقونات التواصل */
    .contact-info-icons {
        display: flex;
        justify-content: center;
        gap: 40px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }
    .contact-info-icons .item {
        background: #fff;
        border-radius: 12px;
        padding: 20px 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        text-align: center;
        flex: 1 1 200px;
        transition: all 0.3s ease;
    }
    .contact-info-icons .item:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }
    .contact-info-icons .icon {
        font-size: 36px;
        margin-bottom: 12px;
        color: #0d6efd;
    }
    .contact-info-icons h4 {
        font-size: 18px;
        margin-bottom: 4px;
        font-weight: bold;
    }
    .contact-info-icons span {
        font-size: 14px;
        color: #555;
    }

    /* الخريطة */
    #map {
        width: 100%;
        height: 350px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* الفورم */
    .contact-form {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .contact-form .form-control {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    .contact-form .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
    }
    .contact-form button {
        border-radius: 8px;
        padding: 10px 20px;
        background-color: #0d6efd;
        color: #fff;
        font-weight: 500;
        border: none;
        transition: background-color 0.3s ease;
    }
    .contact-form button:hover {
        background-color: #084298;
    }
</style>
<style>
    .cards-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 16px;
    }
    .info-card {
        background: #fff;
        border: 0.5px solid rgba(0,0,0,0.12);
        border-radius: 12px;
        padding: 1.25rem;
    }
    .card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 0.5px solid rgba(0,0,0,0.1);
    }
    .card-header-icon {
        width: 36px; height: 36px;
        border-radius: 8px;
        background: #E6F1FB;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .card-title { font-size: 13px; font-weight: 500; margin: 0; }
    .card-subtitle { font-size: 11px; color: #6b7280; margin: 0; margin-top: 2px; }
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 0.5px solid rgba(0,0,0,0.08);
    }
    .info-item:last-child { border-bottom: none; padding-bottom: 0; }
    .item-icon {
        width: 28px; height: 28px;
        border-radius: 6px;
        background: #f5f5f5;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .item-label { font-size: 11px; color: #6b7280; margin: 0; }
    .item-value { font-size: 13px; font-weight: 500; margin: 0; margin-top: 2px; }
</style>
@endpush
@php
    app()->setLocale('en');
@endphp

@section('content')
                            <br> <br> <br>

<div class="contact-area default-padding-top bottom-half">
    <div class="container">



        <div class="cards-row mb-3">

            <!-- Card 1: Contact Info -->
            <div class="info-card">
                <div class="card-header">
                    <div class="card-header-icon">
                        <!-- your icon here -->
                    </div>
                    <div>
                        <p class="card-title">Contact Information</p>
                        <p class="card-subtitle">Positive Interaction for training and consulting inc.</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="item-icon"><i class="flaticon-location"></i></div>
                    <div>
                        <p class="item-label">Registered Office Address</p>
                        <p class="item-value">Mississauga – Canada</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="item-icon"><i class="flaticon-call-center"></i></div>
                    <div>
                        <p class="item-label">Phone</p>
                        <p class="item-value">+1 647 821 969</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="item-icon"><i class="flaticon-email"></i></div>
                    <div>
                        <p class="item-label">Email</p>
                        <p class="item-value">Jawaher@ejaabi.com</p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Federal Info -->
            <div class="info-card">
                <div class="card-header">
                    <div class="card-header-icon">
                        <!-- your icon here -->
                    </div>
                    <div>
                        <p class="card-title">Federal Corporation Information</p>
                        <p class="card-subtitle">Canada Business Corporations Act</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="item-icon"><i class="flaticon-location"></i></div>
                    <div>
                        <p class="item-label">Federal Corporation Information</p>
                        <p class="item-value">1492753-2</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="item-icon"><i class="flaticon-call-center"></i></div>
                    <div>
                        <p class="item-label">Corporation Number</p>
                        <p class="item-value">1492753-2</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="item-icon"><i class="flaticon-email"></i></div>
                    <div>
                        <p class="item-label">Business Number (BN)</p>
                        <p class="item-value">721509347RC0001</p>
                    </div>
                </div>
            </div>

        </div>

{{--        <!-- أيقونات التواصل -->--}}
{{--        <div class="contact-info-icons">--}}
{{--            <div class="item">--}}
{{--                <div class="icon"><i class="flaticon-location"></i></div>--}}
{{--                <h4>Registered Office Address </h4>--}}
{{--                <span> Mississauga –Canada </span>--}}
{{--            </div>--}}
{{--            <div class="item">--}}
{{--                <div class="icon"><i class="flaticon-call-center"></i></div>--}}
{{--                <h4>{{ trans('app.contact_3') }}</h4>--}}
{{--                <span>+ 1 647 821 969</span>--}}
{{--            </div>--}}
{{--            <div class="item">--}}
{{--                <div class="icon"><i class="flaticon-email"></i></div>--}}
{{--                <h4>{{ trans('app.contact_4') }}</h4>--}}
{{--                <span>Jawaher@ejaabi.com</span>--}}
{{--            </div>--}}

{{--        </div>--}}

{{--        <div class="contact-info-icons">--}}
{{--            <div class="item">--}}
{{--                <div class="icon"><i class="flaticon-location"></i></div>--}}
{{--                <h4>Federal Corporation Information  </h4>--}}
{{--                <span> 1492753-2 </span>--}}
{{--            </div>--}}
{{--            <div class="item">--}}
{{--                <div class="icon"><i class="flaticon-call-center"></i></div>--}}
{{--                <h4>Corporation Number </h4>--}}
{{--                <span>1492753-2</span>--}}
{{--            </div>--}}
{{--            <div class="item">--}}
{{--                <div class="icon"><i class="flaticon-email"></i></div>--}}
{{--                <h4>Business Number (BN)</h4>--}}
{{--                <span>721509347RC0001</span>--}}
{{--            </div>--}}

{{--        </div>--}}

        <!-- الخريطة والفورم -->
        <div class="row g-4">
            <div class="col-lg-6 col-md-7">
        <div class="google-maps shadow-lg rounded-4 overflow-hidden" style="height: 600px;">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2891.7212878034243!2d-79.7195929!3d43.5498514!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b438c771704d3%3A0x6d2b4ea2e4d20c7!2zMzEzNSBCb3hmb3JkIENyZXMsIE1pc3Npc3NhdWdhLCBPTiBMNU0gMFgx2Iwg2YPZhtiv2Kc!5e0!3m2!1sar!2ssa!4v1716409918814!5m2!1sar!2ssa"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

         <div class="col-md-6">
    <div class="contact-form">
<h4 class="mb-3 text-center text-primary">{{ trans('app.menu_6') }}</h4>
        <p class="mb-4">{{ trans('app.cont_23') }}</p>

      @if(session()->has('msg'))
    <div class="alert alert-success my-25 d-flex align-items-center">
        <i data-feather="check-square" class="me-2"></i>
        {{ session('msg') }}
    </div>
@endif


        <form action="/contact/store" method="post">
            {{ csrf_field() }}
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label text-primary">{{ trans('app.contact_7') }}</label>
                    <input name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" type="text">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label text-primary">{{ trans('app.contact_4') }}*</label>
                    <input name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" type="email">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
 <br> <br>  <br> <br>

                <div class="col-md-6">
                    <label class="form-label text-primary">{{ trans('site.subject') }}*</label>
                    <input name="subject" value="{{ old('subject') }}" class="form-control @error('subject') is-invalid @enderror" type="text">
                    @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
 <br> <br>  <br> <br>

                <div class="col-md-6">
                    <label class="form-label text-primary">{{ trans('app.contact_3') }}</label>
                    <input name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" type="text">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
 <br> <br> <br> <br>

                <div class="col-12">
                    <label class="form-label text-primary">{{ trans('app.contact_8') }}*</label>
                    <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="4"></textarea>
                    @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
 <br> <br> <br> <br>

                <div class="col-12">
                    {{-- reCAPTCHA هنا إذا موجود --}}
                </div>
                <br> <br>
                <div class="col-12">
                    <button type="submit">
                        {{ trans('app.contact_9') }} <i class="fa fa-paper-plane ms-1"></i>
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>


    </div>
</div>

@endsection

@push('scripts_bottom')
<script src="/assets/vendors/leaflet/leaflet.min.js"></script>
<script>
    var map = L.map('map').setView([43.5890, -79.6441], 15); // Mississauga مثال

    L.tileLayer('{{ getLeafletApiPath() }}', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([43.5890, -79.6441]).addTo(map)
        .bindPopup("3135 Boxford Cres, Mississauga, ON")
        .openPopup();
</script>
@endpush
