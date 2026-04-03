@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    {{-- تحميل خط GE Dinar One من ملفك داخل السيرفر --}}
    <style>
        /* تعريف الخط من ملف السيرفر */
        @font-face {
            font-family: 'GE Dinar One Custom';
            src: url('/fonts/arfonts-ge-dinar-one-medium.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* تعطيل تأثير البارالاكس */
        .testimonials-container #parallax2 {
            transform: translate3d(0px, 0px, 0px) rotate(144deg) !important;
            display: none;
        }

        /* نطبق خط GE Dinar One على عناصر مخصصة */
        .arabic-font {
            font-family: 'GE Dinar One Custom', sans-serif;
        }

        /* نطبق الخط على كل الموقع */
        body {
            font-family: 'GE Dinar One Custom', sans-serif;
            font-size: 1rem;
            font-weight: normal;
            line-height: 1.5;
        }
        .footer{
            display
        }
    </style>
@endpush

@section('content')
    <div class="container py-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>
        <section style="padding: 50px 15px; background-color: #fff;">
          <div class="container" style="max-width: 900px;">
            <h2 style="color: #1363a1; font-weight: 600; margin-bottom: 20px;">Content Development</h2>
            <p style="font-size: 1rem; line-height: 1.7; color: #212529;">
              As part of the world's accelerated developments in education technology.
            </p>
            <p style="font-size: 1rem; line-height: 1.7; color: #212529;">
              The positive interaction of training and consulting licensed content development from the National Center for E-Education is committed to producing and developing practical and appropriate solutions for the production of interactive digital educational content for the courses and training in an interactive digital manner that conforms to the global standards of e-education. And the decisions prepared and developed by the positive interaction team are characterized by their compatibility with all computers, smart devices and different operating systems (iOS/Android) while ensuring digital content is compatible with XAPI & SCORM File standards and providing technical support for deployment on LMS learning management systems.
            </p>
          </div>
        </section>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
    <script src="/assets/default/js/parts/home.min.js"></script>
@endpush
