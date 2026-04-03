@extends(getTemplate().'.layouts.uae_app')

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
@endpush 
@section('content')
                            <br> <br> <br> 

<div class="contact-area default-padding-top bottom-half">
    <div class="container">

        <!-- أيقونات التواصل -->
        <div class="contact-info-icons">
            <div class="item">
                <div class="icon"><i class="flaticon-location"></i></div>
                <h4>{{ trans('app.contact_1') }}</h4>
                <span>الامارات / ابوظبي</span>
            </div>
            <div class="item">
                <div class="icon"><i class="flaticon-call-center"></i></div>
                <h4>{{ trans('app.contact_3') }}</h4>
                <span>050 123 4567</span>
            </div>
            <div class="item">
                <div class="icon"><i class="flaticon-email"></i></div>
                <h4>{{ trans('app.contact_4') }}</h4>
                <span>info-UAE@ejaabi.com</span>
            </div>
        </div>

        <!-- الخريطة والفورم -->
        <div class="row g-4">
            <div class="col-lg-6 col-md-7">
        <div class="google-maps shadow-lg rounded-4 overflow-hidden" style="height: 600px;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d465132.9733051786!2d54.88828017475293!3d24.386473908627888!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5e440f723ef2b9%3A0xc7cc2e9341971108!2z2KPYqNmIINi42KjZiiAtINin2YTYpdmF2KfYsdin2Kog2KfZhNi52LHYqNmK2Kkg2KfZhNmF2KrYrdiv2Kk!5e0!3m2!1sar!2seg!4v1757772563397!5m2!1sar!2seg" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
