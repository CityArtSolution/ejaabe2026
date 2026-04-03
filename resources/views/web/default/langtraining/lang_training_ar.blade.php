@extends(getTemplate() . '.layouts.app')


@push('styles_top')
    <link rel="shortcut icon" href="/contents/files/8JG4xYcXxW3j8ptNE1xD.png" type="image/x-icon">


    <link rel="stylesheet" href="/contents/files/meanmenu.css">
    <link rel="stylesheet" href="/contents/files/magnific-popup.css">
    <link rel="stylesheet" href="/contents/files/animate.css">
    <link rel="stylesheet" href="/contents/files/style.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@160..700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">

    <style>
        .testimonials-container #parallax2 {
            transform: translate3d(0px, 0px, 0px) rotate(144deg) !important;
            display: none;
        }
    </style>

    <style>
        :root {
            --primary-color: #0b73b0;
            --secondary-color: #0f0d1d;
            --gradient-bg: linear-gradient(90deg, #0b73b0 -10.59%, #00060c 300.59%);
        }
    </style>

    <style>
        .about-area,
        .about-two-area {
            overflow: hidden;
            position: relative;
            padding-bottom: 10px;
        }

        .navbar {
            font-family: "GE-Dinar-Two", sans-serif !important;
        }

        .process__item .process-arry {

            display: none;
        }

        .toggleContainer {
            position: relative;
            display: flex;
            /* Flexbox for equal spacing */
            justify-content: space-between;
            /* Distribute space evenly */
            align-items: center;
            /* Center text vertically */
            width: 200px;
            /* Keep the original width */
            height: 30px;
            /* Set height */
            border: 3px solid #3c72fc;
            border-radius: 15px;
            /* Rounded corners */
            background: linear-gradient(180deg, #3c72fc -1.09%, #00060c 175.27%);
            font-weight: bold;
            color: #343434;
            cursor: pointer;
            font-size: 0.75rem;
            /* Slightly smaller font size for a compact layout */
        }

        .toggleContainer::before {
            content: '';
            position: absolute;
            width: 50%;
            height: 100%;
            left: 0;
            border-radius: 15px;
            /* Match rounded corners */
            background: white;
            transition: all 0.3s;
        }

        .toggleCheckbox:checked+.toggleContainer::before {
            left: 50%;
            /* Move the toggle on check */
        }

        .process__image img {
            width: 100%;
            border-radius: 50%;
        }

        .toggleContainer div {
            flex: 1;
            /* Divs take equal space */
            text-align: center;
            /* Center text */
            z-index: 1;
            padding: 5px 0;
            /* Adjust padding for better fit */
            white-space: nowrap;
            /* Prevent text from wrapping */
        }

        .toggleCheckbox {
            display: none;
            /* Hide checkbox */
        }

        .toggleCheckbox:checked+.toggleContainer div:first-child {
            color: white;
            /* Selected state color */
            transition: color 0.3s;
        }

        .toggleCheckbox:checked+.toggleContainer div:last-child {
            color: #343434;
            /* Unselected state color */
            transition: color 0.3s;
        }

        .toggleCheckbox+.toggleContainer div:first-child {
            color: #343434;
            /* Default first child color */
            transition: color 0.3s;
        }

        .toggleCheckbox+.toggleContainer div:last-child {
            color: white;
            /* Default second child color */
            transition: color 0.3s;
        }

        .main h1,
        .main h2,
        .main h3,
        .main h4,
        .main h5,
        .main h6,
        .main p,
        .main span,
        .main a {

            font-family: "Readex Pro", serif;
        }

        .timeline {
            position: relative;
            padding: 0;
            list-style: none;
        }

        .timeline:before {
            display: none;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 40px;
            width: 2px;
            margin-left: -1.5px;
            content: '';
            background-color: #173ed0;
        }

        .timeline>li {
            position: relative;
            /* min-height: 50px;*/
            margin-bottom: 50px;
        }

        .timeline>li:after,
        .timeline>li:before {
            display: table;
            content: ' ';
        }

        .timeline>li:after {
            clear: both;
        }

        .timeline>li .timeline-panel {
            position: relative;
            float: right;
            width: 100%;
            padding: 0 20px 0 100px;
            text-align: right;
        }

        .timeline>li .timeline-panel:before {
            right: auto;
            left: -15px;
            border-right-width: 15px;
            border-left-width: 0;
        }

        .timeline>li .timeline-panel:after {
            right: auto;
            left: -14px;
            border-right-width: 14px;
            border-left-width: 0;
        }

        .timeline>li .timeline-image {
            position: absolute;
            z-index: 10;
            left: 0;
            width: 80px;
            height: 80px;
            margin-left: 0;
            text-align: center;
            color: white;
            border: 7px solid #e5e9ec;
            border-radius: 100%;
            background-color: #282d4f;
        }

        .timeline>li .timeline-image h4 {
            font-size: 10px;
            line-height: 14px;
            margin-top: 12px;
        }

        .timeline>li.timeline-inverted>.timeline-panel {
            float: right;
            padding: 0 20px 0 100px;
            text-align: left;
        }

        .timeline>li.timeline-inverted>.timeline-panel:before {
            right: auto;
            left: -15px;
            border-right-width: 15px;
            border-left-width: 0;
        }

        .timeline>li.timeline-inverted>.timeline-panel:after {
            right: auto;
            left: -14px;
            border-right-width: 14px;
            border-left-width: 0;
        }

        .timeline>li:last-child {
            margin-bottom: 0;
        }

        .timeline .timeline-heading h4 {
            margin-top: 0;
            color: #282d4f;
            font-size: 30px;
        }

        .timeline .timeline-heading h4.subheading {
            text-transform: none;
            font-size: 22px;
        }

        .timeline .timeline-body>ul,
        .timeline .timeline-body>p {
            margin-bottom: 30px;
            color: #3f4c7d;
        }

        .timeline .timeline-body a {
            position: relative;
            z-index: 2;
            background-color: #ffa339;
            width: 150px;
            height: 40px;
            line-height: 40px;
            border-radius: 40px;
            display: block;
            text-align: center;
            font-size: 18px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            float: left;
            cursor: pointer;
        }

        .timeline .timeline-body a:hover {
            -webkit-transform: scale(1.1);
            -moz-transform: scale(1.1);
            -o-transform: scale(1.1);
            transform: scale(1.1);
        }

        @media (min-width: 768px) {
            .timeline:before {
                left: 50%;
            }

            .timeline>li {
                min-height: 100px;
                margin-bottom: 100px;
            }

            .timeline>li .timeline-panel {
                float: left;
                width: 41%;
                padding: 0 20px 20px 30px;
                text-align: right;
            }

            .timeline>li .timeline-image {
                left: 50%;
                width: 100px;
                height: 100px;
                margin-left: -50px;
            }

            .timeline>li .timeline-image h4 {
                font-size: 13px;
                line-height: 18px;
                margin-top: 16px;
            }

            .timeline>li.timeline-inverted>.timeline-panel {
                float: right;
                padding: 0 30px 20px 20px;
                text-align: right;
            }
        }

        .timeline>li.timeline-inverted>.timeline-panel {
            float: right;
            padding: 0 30px 20px 20px;
            text-align: right;
        }

        @media (min-width: 992px) {
            .timeline>li {
                /*  min-height: 150px;*/
            }

            .timeline>li .timeline-panel {
                padding: 0 20px 20px;
            }

            .timeline>li .timeline-image {
                width: 150px;
                height: 150px;
                margin-left: -75px;
            }

            .timeline>li .timeline-image h4 {
                font-size: 18px;
                line-height: 26px;
                margin-top: 30px;
            }

            .timeline>li.timeline-inverted>.timeline-panel {
                padding: 0 20px 20px;
            }
        }

        @media (min-width: 1200px) {
            .timeline>li {
                /* min-height: 170px;*/
            }

            .timeline>li .timeline-panel {
                padding: 0 20px 20px 100px;
            }

            .timeline>li .timeline-image {
                width: 170px;
                height: 170px;
                margin-left: -85px;
            }

            .timeline>li .timeline-image h4 {
                margin-top: 40px;
            }

            .timeline>li.timeline-inverted>.timeline-panel {
                padding: 0 100px 20px 20px;
            }
        }

        .arrow-heading {
            background-color: #0c4c78;
            color: white;
            padding: 15px 25px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: fit-content;
            min-width: 200px;
            /* clip-path: polygon(10% 0, 100% 0, 100% 100%, 10% 100%, 0 50%);*/
        }

        .arrow-heading img {
            width: 24px;
            height: auto;
            margin-left: 10px;
            filter: brightness(0) invert(1);
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .card {
            border: none;
            border-radius: 15px;
            height: 100%;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-1 .card-title {
            background-color: #f0f0f0;
            border-radius: 8px;
            padding: 5px;
            font-size: 15px
        }

        .card-2 .card-title {
            background-color: #ffd4bc;
            border-radius: 8px;
            padding: 5px;
            font-size: 15px
        }

        .card-3 .card-title {
            background-color: #48a9a6;
            border-radius: 8px;
            padding: 5px;
            font-size: 15px
        }

        .card-4 .card-title {
            background-color: #4b6584;
            border-radius: 8px;
            padding: 5px;
            font-size: 15px
        }

        .card-5 .card-title {
            background-color: #2d3436;
            border-radius: 8px;
            padding: 5px;
            font-size: 15px
        }

        .card-text {
            color: #000;
        }

        .number-1 {
            background-color: #808080;
        }

        .number-2 {
            background-color: #ff9f76;
        }

        .number-3 {
            background-color: #2d7a77;
        }

        .number-4 {
            background-color: #2d3f52;
        }

        .number-5 {
            background-color: #1a1d1e;
        }

        .main .about-two__right-item ul li {
            font-family: 'Readex Pro';
        }

        .about-two__right-item ul li i {

            margin-left: 5px;
        }
    </style>
    <style>
        .timeline-container {
            width: 100%;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .timeline {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 20px;
            position: relative;
        }

        .stage {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            max-width: 200px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
            position: relative;
        }

        .stage.fade-in {
            opacity: 1;
            transform: translateY(0);
        }

        /* Arrow styling */


        .stage:not(:last-child)::before {
            content: '';
            position: absolute;
            right: 60%;
            top: 39px;
            width: 70%;
            height: 3px;
            background: #d4d9dd;
        }

        .stage-content {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            padding: 15px 10px;
            width: 100%;
            text-align: center;
            position: relative;
            transition: transform 0.3s ease;
        }

        .stage-number {
            width: 40px;
            height: 40px;
            background: #2196F3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin: -35px auto 10px;
            box-shadow: 0 3px 10px rgba(33, 150, 243, 0.3);
        }

        .stage-title {
            color: #0c4c78;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .stage-description {
            color: #666;
            font-size: 0.9rem;
        }

        /* Hover effects */
        .stage-content:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .timeline {
                flex-direction: column;
                gap: 40px;
            }

            .stage {
                width: 100%;
                max-width: 250px;
            }

            .stage:not(:last-child)::after,
            .stage:not(:last-child)::before {
                display: none;
            }

            /* Vertical arrows for mobile */
            .stage:not(:last-child)::after {
                content: '';
                display: block;
                position: absolute;
                top: 100%;
                right: 50%;
                width: 20px;
                height: 20px;
                border-top: 3px solid #2196F3;
                border-right: 3px solid #2196F3;
                transform: translateX(50%) rotate(135deg);
                margin-top: 10px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .stage-title {
                font-size: 0.9rem;
            }

            .stage-description {
                font-size: 0.8rem;
            }

            .stage:not(:last-child)::before {
                width: 60%;
            }
        }

        .bg-secondary {
            background-color: var(--secondary) !important;
        }

        .footer * {

            font-family: "GE-Dinar-Two", sans-serif !important
        }

        .menu-category>ul>li {
            align-content: center !important
        }
    </style>
@endpush

@section('content')
    <div class="mouse-cursor cursor-outer" style="visibility: visible; transform: translate(584px, 2px);"></div>
    <div class="mouse-cursor cursor-inner" style="visibility: visible; transform: translate(584px, 2px);"></div>



    <div id="targetElement" class="sidebar-area sidebar__hide light-area">
        <div class="sidebar__overlay"></div>


        <a href="https://nelc.gov.sa/" class="logo mb-40">
            <img src="/contents/files/logo.webp" alt="logo">
        </a>

        <div class="mobile-menu overflow-hidden"></div>



        <div class="social-icon mt-20">
            <a href="/#" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="/#" target="_blank"><i class="fa-regular fa-x"></i></a>
            <a href="/#" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
            <a href="/#" target="_blank"><i class="fa-brands fa-youtube"></i></a>
        </div>
        <button id="closeButton" class="text-white"><i class="fa-solid fa-xmark"></i></button>
    </div>


    <main class="main">
        <div class="banner-three-area">
            <div class="banner-three__bg">
                <img class="sway_Y__animation" src="/contents/files/eYXIYYvGq4j0T5lsKJee.png" alt="bg-image">
            </div>


            <div class="banner-three__container">
                <div class="row align-items-center">
                    <div class="col-lg-7 order-2 order-lg-1">
                        <div class="banner-three__content pt-0 pb-0">

                            <h2 class="wow fadeInUp text-white" data-wow-delay="200ms" data-wow-duration="1500ms"
                                style="visibility: visible; animation-duration: 1500ms; animation-delay: 200ms; animation-name: fadeInUp;">
                            مركز اللغة الانجليزية
 </h2>
                            <p class="wow fadeInUp mt-20" data-wow-delay="400ms" data-wow-duration="1500ms"
                                style="visibility: visible; animation-duration: 1500ms; animation-delay: 400ms; animation-name: fadeInUp;">
                                يعمل  مركز اللغة الانجليزية لدينا على تحسين مهارات التواصل والفهم الثقافي, مما يساعد المشاركين 
                                على الاستعداد للفرص العالمية
                            </p>

                        </div>
                    </div>
                    <div class="col-lg-5 order-1 order-lg-2 wow fadeInLeft" data-wow-delay="200ms"
                        data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 200ms; animation-name: fadeInLeft;">
                        <div class="image">
                            <img src="/training/hero.webp" class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>


        </div>


        <section class="process-area pt-120 pb-120 bg-light">
            <div class="container">
                <div class="section-header text-center mb-60">
                    <h3 class="wow fadeInUp arrow-heading" data-wow-delay="10ms" data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 10ms; animation-name: fadeInUp;">
                        <img class="me-1" src="/contents/files/2w2YVw3fQ3oiAXA1JE1u.png" alt="icon">
                        الخدمات المقدمة في  مركز اللغة الانجليزية 

                    </h3>

                </div>
                <div class="row g-5 justify-content-center">
                    <!-- Section 1: IELTS Preparatory Courses -->
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="5ms" data-wow-duration="1500ms">
                        <div class="process__item card border-0 shadow-hover h-100">
                            <div class="card-body text-left">
                                <div class="mb-4 text-center">
                                    <img src="/training/Ielts.svg" alt="image" class="img-fluid"
                                        style="width: 250px; height:200px; object-fit:cover">
                                </div>
                                <h4 class="mt-3 mb-3 text-primary">الدورات التحضيرية لاختبار IELTS</h4>
                                <p class="text-muted">تدريب شامل في الاستماع، القراءة، الكتابة، والتحدث.</p>
                                <ul class="list-unstyled text-start">
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>القراءة: فهم
                                        أنواع الأسئلة واستراتيجيات الإجابة.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>الاستماع:
                                        التعرف على أنماط الأسئلة وتحديد المعلومات الأساسية.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>الكتابة: تنظيم
                                        الأفكار وكتابة مقالات واضحة ومتناسقة.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>التحدث: التدرب
                                        على الإجابة بطلاقة وبنطق سليم.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Business Language and Conversation Courses -->
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="10ms" data-wow-duration="1500ms">
                        <div class="process__item card border-0 shadow-hover h-100">
                            <div class="card-body p-4 text-left">
                                <div class="mb-4 text-center">
                                    <img src="/training/conversation.svg" alt="image" class="img-fluid"
                                        style="width: 300px; height:200px; object-fit:cover">

                                </div>
                                <h4 class="mt-3 mb-3 text-primary">دورات لغة الأعمال والمحادثة</h4>
                                <p class="text-muted">برامج مخصصة تلبي الاحتياجات المهنية والشخصية.</p>
                                <ul class="list-unstyled text-start">
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>تطوير مهارات
                                        المحادثة والتواصل في بيئة الأعمال.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>تعلم مصطلحات
                                        الأعمال وإعداد التقارير والمراسلات الرسمية.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>تحسين مهارات
                                        التفاوض ومهارات الاجتماعات والعروض التقديمية.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>التدريب على
                                        التواصل الفعّال عبر الهاتف والبريد الإلكتروني.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Official IELTS Test -->
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="15ms" data-wow-duration="1500ms">
                        <div class="process__item card border-0 shadow-hover h-100">
                            <div class="card-body p-4 text-left">
                                <div class="mb-4 text-center">
                                    <img src="/training/test.svg" alt="image" class="img-fluid"
                                        style="width: 250px; height:200px; object-fit:cover">

                                </div>
                                <h4 class="mt-3 mb-3 text-primary">اختبار IELTS الرسمي</h4>
                                <p class="text-muted">معتمد من المجلس الثقافي البريطاني لكل من الاختبار الأكاديمي والتدريب
                                    العام.</p>
                                <ul class="list-unstyled text-start">
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>الجهة المنظمة:
                                        المجلس الثقافي البريطاني.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>الاختبار
                                        الأكاديمي: للدراسة الجامعية وغيرها.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>الاختبار
                                        العام: للهجرة والعمل أو السياحة.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>مدة الاختبار:
                                        2 ساعة و45 دقيقة.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>التسجيل عبر
                                        الإنترنت.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-green m-2"></i>أنواع الأسئلة:
                                        اختيار من متعدد، إكمال الجمل، كتابة مقالية، أسئلة مفتوحة.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>




    </main>



    </div>



    </div>


    <div class="scroll-up active-scroll">
        <svg class="scroll-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 269.424;">
            </path>
        </svg>
    </div>
@endsection

@push('scripts_bottom')
    {{-- <script src="/contents/files/jquery-3.7.1.min.js"></script> --}}
    <script src="/contents/files/bootstrap.min.js"></script>
    <script src="/contents/files/meanmenu.js"></script>
    <script src="/contents/files/swiper-bundle.min.js"></script>
    <script src="/contents/files/jquery.counterup.min.js"></script>
    <script src="/contents/files/wow.min.js"></script>
    <script src="/contents/files/pace.min.js"></script>
    <script src="/contents/files/magnific-popup.min.js"></script>
    <script src="/contents/files/nice-select.min.js"></script>
    <script src="/contents/files/isotope.pkgd.min.js"></script>
    <script src="/contents/files/jquery.waypoints.js"></script>
    <script>
        'use strict';
        $('img').on('error', function() {
            // Hide the image
            $(this).hide();
        });
    </script>
    <script>
        'use strict';
        // WOW Animatin area start here ***
        new WOW().init();
        // WOW Animatin area start here ***
    </script>


    <script async="" src="/contents/files/script.js"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-XXXXXXXXXX');
    </script>
@endpush
