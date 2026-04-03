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

    <style>
        :root {
            --primary-color: #0b73b0;
            --secondary-color: #0f0d1d;
            --gradient-bg: linear-gradient(90deg, #0b73b0 -10.59%, #00060c 300.59%);
        }
    </style>

    <style>
        .header-two-area {
            position: sticky !important;
            height: 90px;
            width: 100%;
            padding-top: 10px;
            z-index: 0 !important;
        }

        .header-two-area.menu-fixed,
        .header-area {
            background: linear-gradient(90deg, #ffffff -76.72%, #e7e7e8 191.51%);
            border-bottom: none;
        }

        .banner-three-area {
            overflow: hidden;
            position: relative;
            z-index: 1;
            background: linear-gradient(90deg, #0f0d1d -76.72%, #0b73b0 191.51%);
            padding-top: 100px;
            padding-bottom: 50px;
        }

        .about-area,
        .about-two-area {
            overflow: hidden;
            position: relative;
            padding-bottom: 10px;
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
    </style>
@endpush

@section('content')
    <div class="mouse-cursor cursor-outer" style="visibility: visible; transform: translate(584px, 2px);"></div>
    <div class="mouse-cursor cursor-inner" style="visibility: visible; transform: translate(584px, 2px);"></div>


    <div class="header-area header-two-area animated menu-fixed fadeInDown">
        <div class="container header__container">
            <div class="header__main">
                <a href="https://nelc.gov.sa/" class="logo">
                    <img src="/contents/en/files/logo.webp" alt="logo">
                </a>
                <br>
                <span style="font-weight:800">ترخيص تطويرمحتوى :QCD22110019
                </span>

            </div>
        </div>
    </div>






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
                                تطوير المحتوى
                            </h2>
                            <p class="wow fadeInUp mt-20" data-wow-delay="400ms" data-wow-duration="1500ms"
                                style="visibility: visible; animation-duration: 1500ms; animation-delay: 400ms; animation-name: fadeInUp;">

                                في إطار ما يشهده العالم من تطورات متسارعة في تكنولوجيا التعليم. يلتزم التفاعل الإيجابي
                                للتدريب والاستشارات الحاصل على رخصة تطوير المحتوى من المركز الوطني للتعليم الالكتروني في
                                إنتاج وتطوير حلول عملية وملائمة لإنتاج المحتوى التعليمي الرقمي التفاعلي للمقررات الدراسية
                                والتدريبية بصورة رقمية مبتكره تتوافق مع المعايير العالمية للتعليم الإلكتروني، وتتميز
                                المقررات التي يتم اعدادها وتطويرها من قبل فريق التفاعل الإيجابي بتوافقها مع جميع اجهزة
                                الحاسب والأجهزة الذكية ونظم التشغيل المختلفة (iOS/Android)، مع ضمان توافقية المحتوى الرقمي
                                مع معايير XAPI & SCORM File وتقديم الدعم الفني للنشر على أنظمة إدارة التعلم LMS .
                            </p>

                        </div>
                    </div>
                    <div class="col-lg-5 order-1 order-lg-2 wow fadeInLeft" data-wow-delay="200ms"
                        data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 200ms; animation-name: fadeInLeft;">
                        <div class="image">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" width="1000" height="1000"
                                preserveAspectRatio="xMidYMid meet"
                                style="width: 100%; height: 100%; transform: translate3d(0px, 0px, 0px);">
                                <defs>
                                    <clipPath id="__lottie_element_2">
                                        <rect width="1000" height="1000" x="0" y="0"></rect>
                                    </clipPath>
                                </defs>
                                <g clip-path="url(#__lottie_element_2)">
                                    <g style="display: block;"
                                        transform="matrix(1,0,0,1,246.37899780273438,424.2560119628906)" opacity="1">
                                        <g opacity="1" transform="matrix(1,0,0,1,276.5450134277344,185.2550048828125)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M-263.0039978027344,-185.0050048828125 C-263.0039978027344,-185.0050048828125 263.0039978027344,-185.0050048828125 263.0039978027344,-185.0050048828125 C270.343994140625,-185.0050048828125 276.2950134277344,-179.05299377441406 276.2950134277344,-171.71200561523438 C276.2950134277344,-171.71200561523438 276.2950134277344,171.71299743652344 276.2950134277344,171.71299743652344 C276.2950134277344,179.05299377441406 270.343994140625,185.0050048828125 263.0039978027344,185.0050048828125 C263.0039978027344,185.0050048828125 -263.0039978027344,185.0050048828125 -263.0039978027344,185.0050048828125 C-270.343994140625,185.0050048828125 -276.2950134277344,179.05299377441406 -276.2950134277344,171.71299743652344 C-276.2950134277344,171.71299743652344 -276.2950134277344,-171.71200561523438 -276.2950134277344,-171.71200561523438 C-276.2950134277344,-179.05299377441406 -270.343994140625,-185.0050048828125 -263.0039978027344,-185.0050048828125z">
                                            </path>
                                        </g>
                                        <g opacity="1" transform="matrix(1,0,0,1,276.5450134277344,185.26300048828125)">
                                            <path fill="rgb(232,235,251)" fill-opacity="1"
                                                d=" M-256.9020080566406,-169.4669952392578 C-256.9020080566406,-169.4669952392578 256.90301513671875,-169.4669952392578 256.90301513671875,-169.4669952392578 C256.90301513671875,-169.4669952392578 256.90301513671875,169.4669952392578 256.90301513671875,169.4669952392578 C256.90301513671875,169.4669952392578 -256.9020080566406,169.4669952392578 -256.9020080566406,169.4669952392578 C-256.9020080566406,169.4669952392578 -256.9020080566406,-169.4669952392578 -256.9020080566406,-169.4669952392578z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,152.375,758.7449951171875)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,370.77899169921875,43.957000732421875)">
                                            <path fill="rgb(196,204,246)" fill-opacity="1"
                                                d=" M358.5559997558594,7.9710001945495605 C358.5559997558594,7.9710001945495605 -358.5559997558594,7.9710001945495605 -358.5559997558594,7.9710001945495605 C-365.1789855957031,7.9710001945495605 -370.5299987792969,4.39900016784668 -370.5299987792969,-0.0010000000474974513 C-370.5299987792969,-4.401000022888184 -365.1789855957031,-7.9710001945495605 -358.5559997558594,-7.9710001945495605 C-358.5559997558594,-7.9710001945495605 358.5559997558594,-7.9710001945495605 358.5559997558594,-7.9710001945495605 C365.1629943847656,-7.9710001945495605 370.52899169921875,-4.401000022888184 370.52899169921875,-0.0010000000474974513 C370.52899169921875,4.39900016784668 365.14801025390625,7.9710001945495605 358.5559997558594,7.9710001945495605z">
                                            </path>
                                        </g>
                                        <g opacity="1" transform="matrix(1,0,0,1,370.5419921875,18.01099967956543)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M-319.79400634765625,-17.760000228881836 C-319.79400634765625,-17.760000228881836 319.79400634765625,-17.760000228881836 319.79400634765625,-17.760000228881836 C319.79400634765625,-17.760000228881836 319.79400634765625,-0.12999999523162842 319.79400634765625,-0.12999999523162842 C319.79400634765625,9.75100040435791 311.7850036621094,17.760000228881836 301.9049987792969,17.760000228881836 C301.9049987792969,17.760000228881836 -301.90399169921875,17.760000228881836 -301.90399169921875,17.760000228881836 C-311.78399658203125,17.760000228881836 -319.79400634765625,9.75100040435791 -319.79400634765625,-0.12999999523162842 C-319.79400634765625,-0.12999999523162842 -319.79400634765625,-17.760000228881836 -319.79400634765625,-17.760000228881836z">
                                            </path>
                                        </g>
                                        <g opacity="1" transform="matrix(1,0,0,1,370.5419921875,10.246000289916992)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M-104.02300262451172,-9.994999885559082 C-104.02300262451172,-9.994999885559082 104.03800201416016,-9.994999885559082 104.03800201416016,-9.994999885559082 C104.03800201416016,-9.994999885559082 104.03800201416016,-0.07599999755620956 104.03800201416016,-0.07599999755620956 C104.03800201416016,5.486000061035156 99.52799987792969,9.994999885559082 93.96600341796875,9.994999885559082 C93.96600341796875,9.994999885559082 -93.96600341796875,9.994999885559082 -93.96600341796875,9.994999885559082 C-99.52899932861328,9.994999885559082 -104.03800201416016,5.486000061035156 -104.03800201416016,-0.07599999755620956 C-104.03800201416016,-0.07599999755620956 -104.03800201416016,-9.994999885559082 -104.03800201416016,-9.994999885559082 C-104.03800201416016,-9.994999885559082 -104.02300262451172,-9.994999885559082 -104.02300262451172,-9.994999885559082z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,549.4730224609375,473.7929992675781)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,103.19499969482422,138.44700622558594)">
                                            <path fill="rgb(255,251,235)" fill-opacity="0.3"
                                                d=" M-103.19499969482422,-138.4459991455078 C-103.19499969482422,-138.4459991455078 103.19499969482422,-138.4459991455078 103.19499969482422,-138.4459991455078 C103.19499969482422,-138.4459991455078 103.19499969482422,138.44700622558594 103.19499969482422,138.44700622558594 C103.19499969482422,138.44700622558594 -103.19499969482422,138.44700622558594 -103.19499969482422,138.44700622558594 C-103.19499969482422,138.44700622558594 -103.19499969482422,-138.4459991455078 -103.19499969482422,-138.4459991455078z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1.0924184322357178,0.1289261281490326,-0.1289261281490326,1.0924184322357178,440.49481201171875,158.9658203125)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,84.77300262451172,109.10900115966797)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M84.52300262451172,-33.68000030517578 C84.52300262451172,-33.68000030517578 11.289999961853027,92.11900329589844 11.289999961853027,92.11900329589844 C11.289999961853027,92.11900329589844 -84.52300262451172,35.54999923706055 -84.52300262451172,35.54999923706055 C-84.52300262451172,35.54999923706055 -12.993000030517578,-92.11900329589844 -12.993000030517578,-92.11900329589844 C-12.993000030517578,-92.11900329589844 84.52300262451172,-33.68000030517578 84.52300262451172,-33.68000030517578z">
                                            </path>
                                        </g>
                                        <g opacity="1" transform="matrix(1,0,0,1,85.89900207519531,102.625)">
                                            <path fill="rgb(255,251,235)" fill-opacity="1"
                                                d=" M82.53800201416016,-33.097999572753906 C82.53800201416016,-33.097999572753906 9.305000305175781,92.70099639892578 9.305000305175781,92.70099639892578 C9.305000305175781,92.70099639892578 -82.53800201416016,38.479000091552734 -82.53800201416016,38.479000091552734 C-82.53800201416016,38.479000091552734 -10.104000091552734,-92.70099639892578 -10.104000091552734,-92.70099639892578 C-10.104000091552734,-92.70099639892578 82.53800201416016,-33.097999572753906 82.53800201416016,-33.097999572753906z">
                                            </path>
                                        </g>
                                        <g opacity="1" transform="matrix(1,0,0,1,98.3010025024414,97.41300201416016)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M84.53099822998047,-33.665000915527344 C84.53099822998047,-33.665000915527344 11.298999786376953,92.11900329589844 11.298999786376953,92.11900329589844 C11.298999786376953,92.11900329589844 -84.53099822998047,35.54999923706055 -84.53099822998047,35.54999923706055 C-84.53099822998047,35.54999923706055 -12.984999656677246,-92.11900329589844 -12.984999656677246,-92.11900329589844 C-12.984999656677246,-92.11900329589844 84.53099822998047,-33.665000915527344 84.53099822998047,-33.665000915527344z">
                                            </path>
                                        </g>
                                        <g opacity="1" transform="matrix(1,0,0,1,42.78300094604492,72.45500183105469)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M-29.011999130249023,60.507999420166016 C-29.011999130249023,60.507999420166016 -39.9739990234375,70.0739974975586 -42.534000396728516,72.20500183105469 C-10.555000305175781,9.197999954223633 -2.674999952316284,-5.809999942779541 32.125,-65.41400146484375 C32.125,-65.41400146484375 34.132999420166016,-72.20500183105469 42.534000396728516,-67.16100311279297 C42.534000396728516,-67.16100311279297 -29.011999130249023,60.507999420166016 -29.011999130249023,60.507999420166016z">
                                            </path>
                                        </g>
                                    </g>
                                    <g style="display: block;"
                                        transform="matrix(1.2016602754592896,0.14181874692440033,-0.14181874692440033,1.2016602754592896,506.90484619140625,223.49240112304688)"
                                        opacity="1">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,36.93000030517578,22.968000411987305)">
                                            <path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0"
                                                stroke-miterlimit="10" stroke="rgb(255,251,235)" stroke-opacity="1"
                                                stroke-width="3.618"
                                                d=" M-35.12099838256836,-21.159000396728516 C-35.12099838256836,-21.159000396728516 3.7750000953674316,2.2739999294281006 23.679000854492188,14.265999794006348">
                                            </path>
                                        </g>
                                    </g>
                                    <g style="display: block;"
                                        transform="matrix(1.2016602754592896,0.14181874692440033,-0.14181874692440033,1.2016602754592896,519.3084716796875,209.78323364257812)"
                                        opacity="1">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,26.034000396728516,16.40399932861328)">
                                            <path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0"
                                                stroke-miterlimit="10" stroke="rgb(255,251,235)" stroke-opacity="1"
                                                stroke-width="3.618"
                                                d=" M-24.225000381469727,-14.595000267028809 C-24.225000381469727,-14.595000267028809 -1.0160000324249268,-0.6119999885559082 13.276000022888184,7.998000144958496">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(0.982201099395752,0.18783235549926758,-0.18783235549926758,0.982201099395752,190.09999084472656,486.2063293457031)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,18.31100082397461,18.21500015258789)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                stroke="rgb(196,204,246)" stroke-opacity="1" stroke-width="8"
                                                d=" M-14.310999870300293,-14.21500015258789 C-14.310999870300293,-14.21500015258789 14.310999870300293,14.21500015258789 14.310999870300293,14.21500015258789">
                                            </path>
                                        </g>
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,37.685001373291016,38.047000885009766)">
                                            <path fill="rgb(196,204,246)" fill-opacity="1"
                                                d=" M-14.005000114440918,-6.840000152587891 C-14.005000114440918,-6.840000152587891 -6.841000080108643,-14.005999565124512 -6.841000080108643,-14.005999565124512 C-5.709000110626221,-15.13700008392334 -3.875,-15.13700008392334 -2.743000030517578,-14.005999565124512 C-2.743000030517578,-14.005999565124512 14.005999565124512,2.742000102996826 14.005999565124512,2.742000102996826 C15.13700008392334,3.874000072479248 15.13700008392334,5.708000183105469 14.005999565124512,6.840000152587891 C14.005999565124512,6.840000152587891 6.840000152587891,14.005000114440918 6.840000152587891,14.005000114440918 C5.709000110626221,15.13700008392334 3.874000072479248,15.13700008392334 2.743000030517578,14.005000114440918 C2.743000030517578,14.005000114440918 -14.005000114440918,-2.743000030517578 -14.005000114440918,-2.743000030517578 C-15.13599967956543,-3.874000072479248 -15.13599967956543,-5.709000110626221 -14.005000114440918,-6.840000152587891z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,337.76300048828125,496.8909912109375)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,56.02799987792969,35.869998931884766)">
                                            <path fill="rgb(255,251,235)" fill-opacity="1"
                                                d=" M-46.058998107910156,-35.619998931884766 C-46.058998107910156,-35.619998931884766 46.060001373291016,-35.619998931884766 46.060001373291016,-35.619998931884766 C51.428001403808594,-35.619998931884766 55.77899932861328,-31.267000198364258 55.77899932861328,-25.899999618530273 C55.77899932861328,-25.899999618530273 55.77899932861328,25.900999069213867 55.77899932861328,25.900999069213867 C55.77899932861328,31.268999099731445 51.428001403808594,35.619998931884766 46.060001373291016,35.619998931884766 C46.060001373291016,35.619998931884766 -46.058998107910156,35.619998931884766 -46.058998107910156,35.619998931884766 C-51.426998138427734,35.619998931884766 -55.77899932861328,31.268999099731445 -55.77899932861328,25.900999069213867 C-55.77899932861328,25.900999069213867 -55.77899932861328,-25.899999618530273 -55.77899932861328,-25.899999618530273 C-55.77899932861328,-31.267000198364258 -51.426998138427734,-35.619998931884766 -46.058998107910156,-35.619998931884766z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,375.81298828125,508.3160095214844)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,23,23.540000915527344)">
                                            <path fill="rgb(196,204,246)" fill-opacity="1"
                                                d=" M21.767000198364258,-1.1890000104904175 C21.767000198364258,-1.1890000104904175 -20.650999069213867,-22.926000595092773 -20.650999069213867,-22.926000595092773 C-21.350000381469727,-23.290000915527344 -22.211000442504883,-23.020000457763672 -22.575000762939453,-22.32200050354004 C-22.68199920654297,-22.115999221801758 -22.738000869750977,-21.88599967956543 -22.736000061035156,-21.65399932861328 C-22.736000061035156,-21.65399932861328 -22.736000061035156,21.836999893188477 -22.736000061035156,21.836999893188477 C-22.75,22.624000549316406 -22.121999740600586,23.27400016784668 -21.334999084472656,23.288000106811523 C-21.097000122070312,23.291000366210938 -20.86199951171875,23.236000061035156 -20.650999069213867,23.125 C-20.650999069213867,23.125 21.767000198364258,1.371999979019165 21.767000198364258,1.371999979019165 C22.474000930786133,1.00600004196167 22.75,0.13699999451637268 22.385000228881836,-0.5699999928474426 C22.24799919128418,-0.8339999914169312 22.031999588012695,-1.0509999990463257 21.767000198364258,-1.1890000104904175z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,575.3179931640625,502.0270080566406)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,30.236000061035156,19.39699935913086)">
                                            <path fill="rgb(255,251,235)" fill-opacity="1"
                                                d=" M-20.267000198364258,-19.14699935913086 C-20.267000198364258,-19.14699935913086 20.266000747680664,-19.14699935913086 20.266000747680664,-19.14699935913086 C25.634000778198242,-19.14699935913086 29.986000061035156,-14.795999526977539 29.986000061035156,-9.428000450134277 C29.986000061035156,-9.428000450134277 29.986000061035156,9.428000450134277 29.986000061035156,9.428000450134277 C29.986000061035156,14.795000076293945 25.634000778198242,19.14699935913086 20.266000747680664,19.14699935913086 C20.266000747680664,19.14699935913086 -20.267000198364258,19.14699935913086 -20.267000198364258,19.14699935913086 C-25.634000778198242,19.14699935913086 -29.986000061035156,14.795000076293945 -29.986000061035156,9.428000450134277 C-29.986000061035156,9.428000450134277 -29.986000061035156,-9.428000450134277 -29.986000061035156,-9.428000450134277 C-29.986000061035156,-14.795999526977539 -25.634000778198242,-19.14699935913086 -20.267000198364258,-19.14699935913086z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,595.7650146484375,508.4830017089844)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,12.133000373840332,12.401000022888184)">
                                            <path fill="rgb(196,204,246)" fill-opacity="1"
                                                d=" M10.899999618530273,-1.1779999732971191 C10.899999618530273,-1.1779999732971191 -9.781000137329102,-11.78600025177002 -9.781000137329102,-11.78600025177002 C-10.48900032043457,-12.151000022888184 -11.357000350952148,-11.871000289916992 -11.720999717712402,-11.163999557495117 C-11.82699966430664,-10.958000183105469 -11.880999565124512,-10.729999542236328 -11.880000114440918,-10.498000144958496 C-11.880000114440918,-10.498000144958496 -11.880000114440918,10.70300006866455 -11.880000114440918,10.70300006866455 C-11.883000373840332,11.49899959564209 -11.241999626159668,12.147000312805176 -10.446000099182129,12.149999618530273 C-10.21399974822998,12.151000022888184 -9.987000465393066,12.095999717712402 -9.781000137329102,11.991000175476074 C-9.781000137329102,11.991000175476074 10.899999618530273,1.3830000162124634 10.899999618530273,1.3830000162124634 C11.607000350952148,1.0160000324249268 11.883999824523926,0.1469999998807907 11.517999649047852,-0.5600000023841858 C11.380999565124512,-0.8240000009536743 11.166000366210938,-1.0399999618530273 10.899999618530273,-1.1779999732971191z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,574.2149658203125,580.6090087890625)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,30.235000610351562,19.39699935913086)">
                                            <path fill="rgb(255,251,235)" fill-opacity="1"
                                                d=" M-20.266000747680664,-19.148000717163086 C-20.266000747680664,-19.148000717163086 20.266000747680664,-19.148000717163086 20.266000747680664,-19.148000717163086 C25.632999420166016,-19.148000717163086 29.985000610351562,-14.795000076293945 29.985000610351562,-9.428000450134277 C29.985000610351562,-9.428000450134277 29.985000610351562,9.428000450134277 29.985000610351562,9.428000450134277 C29.985000610351562,14.795999526977539 25.632999420166016,19.148000717163086 20.266000747680664,19.148000717163086 C20.266000747680664,19.148000717163086 -20.266000747680664,19.148000717163086 -20.266000747680664,19.148000717163086 C-25.634000778198242,19.148000717163086 -29.985000610351562,14.795999526977539 -29.985000610351562,9.428000450134277 C-29.985000610351562,9.428000450134277 -29.985000610351562,-9.428000450134277 -29.985000610351562,-9.428000450134277 C-29.985000610351562,-14.795000076293945 -25.634000778198242,-19.148000717163086 -20.266000747680664,-19.148000717163086z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1.006430983543396,0,0,1.006430983543396,594.5978393554688,587.0473022460938)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,12.152000427246094,12.394000053405762)">
                                            <path fill="rgb(196,204,246)" fill-opacity="1"
                                                d=" M10.866999626159668,-1.2319999933242798 C10.866999626159668,-1.2319999933242798 -9.79800033569336,-11.779000282287598 -9.79800033569336,-11.779000282287598 C-10.505999565124512,-12.142999649047852 -11.37399959564209,-11.864999771118164 -11.73799991607666,-11.157999992370605 C-11.842000007629395,-10.956999778747559 -11.897000312805176,-10.734000205993652 -11.89900016784668,-10.506999969482422 C-11.89900016784668,-10.506999969482422 -11.89900016784668,10.694999694824219 -11.89900016784668,10.694999694824219 C-11.902000427246094,11.491000175476074 -11.258999824523926,12.138999938964844 -10.463000297546387,12.142999649047852 C-10.232000350952148,12.144000053405762 -10.003999710083008,12.088000297546387 -9.79800033569336,11.982000350952148 C-9.79800033569336,11.982000350952148 10.883000373840332,1.3739999532699585 10.883000373840332,1.3739999532699585 C11.600000381469727,1.031000018119812 11.902999877929688,0.1679999977350235 11.557999610900879,-0.5479999780654907 C11.414999961853027,-0.8500000238418579 11.170000076293945,-1.090999960899353 10.866999626159668,-1.2319999933242798z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1.006430983543396,0,0,1.006430983543396,575.12353515625,659.0662841796875)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,30.236000061035156,19.39699935913086)">
                                            <path fill="rgb(255,251,235)" fill-opacity="1"
                                                d=" M-20.267000198364258,-19.148000717163086 C-20.267000198364258,-19.148000717163086 20.266000747680664,-19.148000717163086 20.266000747680664,-19.148000717163086 C25.634000778198242,-19.148000717163086 29.986000061035156,-14.795999526977539 29.986000061035156,-9.428000450134277 C29.986000061035156,-9.428000450134277 29.986000061035156,9.428000450134277 29.986000061035156,9.428000450134277 C29.986000061035156,14.795999526977539 25.634000778198242,19.148000717163086 20.266000747680664,19.148000717163086 C20.266000747680664,19.148000717163086 -20.267000198364258,19.148000717163086 -20.267000198364258,19.148000717163086 C-25.634000778198242,19.148000717163086 -29.986000061035156,14.795999526977539 -29.986000061035156,9.428000450134277 C-29.986000061035156,9.428000450134277 -29.986000061035156,-9.428000450134277 -29.986000061035156,-9.428000450134277 C-29.986000061035156,-14.795999526977539 -25.634000778198242,-19.148000717163086 -20.267000198364258,-19.148000717163086z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1.0973870754241943,0,0,1.0973870754241943,594.583251953125,664.4570922851562)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,12.133000373840332,12.392999649047852)">
                                            <path fill="rgb(196,204,246)" fill-opacity="1"
                                                d=" M10.899999618530273,-1.1859999895095825 C10.899999618530273,-1.1859999895095825 -9.781000137329102,-11.779999732971191 -9.781000137329102,-11.779999732971191 C-10.48900032043457,-12.142999649047852 -11.357000350952148,-11.864999771118164 -11.720999717712402,-11.156999588012695 C-11.824000358581543,-10.956000328063965 -11.878000259399414,-10.732999801635742 -11.880000114440918,-10.506999969482422 C-11.880000114440918,-10.506999969482422 -11.880000114440918,10.694999694824219 -11.880000114440918,10.694999694824219 C-11.883000373840332,11.491000175476074 -11.241999626159668,12.137999534606934 -10.446000099182129,12.142000198364258 C-10.21399974822998,12.142999649047852 -9.987000465393066,12.088000297546387 -9.781000137329102,11.982000350952148 C-9.781000137329102,11.982000350952148 10.899999618530273,1.3739999532699585 10.899999618530273,1.3739999532699585 C11.607000350952148,1.0080000162124634 11.883999824523926,0.13899999856948853 11.517999649047852,-0.5680000185966492 C11.380999565124512,-0.8330000042915344 11.166000366210938,-1.0490000247955322 10.899999618530273,-1.1859999895095825z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,652.0140380859375,510.1700134277344)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                stroke="rgb(255,251,235)" stroke-opacity="1" stroke-width="3"
                                                d=" M1.5,1.5 C1.5,1.5 86.64800262451172,1.5 86.64800262451172,1.5"></path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,652.0140380859375,521.531982421875)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                stroke="rgb(255,251,235)" stroke-opacity="1" stroke-width="3"
                                                d=" M1.5,1.5 C1.5,1.5 86.64800262451172,1.5 86.64800262451172,1.5"></path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,652.0140380859375,533.6589965820312)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                stroke="rgb(255,251,235)" stroke-opacity="1" stroke-width="3"
                                                d=" M1.5,1.5 C1.5,1.5 86.64800262451172,1.5 86.64800262451172,1.5"></path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,650.4819946289062,585.489013671875)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                stroke="rgb(255,251,235)" stroke-opacity="1" stroke-width="3"
                                                d=" M1.5,1.5 C1.5,1.5 86.64800262451172,1.5 86.64800262451172,1.5"></path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1.0869073867797852,0,0,1.0869073867797852,650.3516235351562,596.7206420898438)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                stroke="rgb(255,251,235)" stroke-opacity="1" stroke-width="3"
                                                d=" M1.5,1.5 C1.5,1.5 86.64800262451172,1.5 86.64800262451172,1.5"></path>
                                        </g>
                                    </g>
                                    <g transform="matrix(0.8739027380943298,0,0,0.8739027380943298,650.671142578125,609.1681518554688)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                stroke="rgb(255,251,235)" stroke-opacity="1" stroke-width="3"
                                                d=" M1.5,1.5 C1.5,1.5 86.64800262451172,1.5 86.64800262451172,1.5"></path>
                                        </g>
                                    </g>
                                    <g transform="matrix(0.2238926887512207,0,0,0.2238926887512207,651.901123046875,666.0581665039062)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                stroke="rgb(255,251,235)" stroke-opacity="1" stroke-width="3"
                                                d=" M1.5,1.5 C1.5,1.5 86.64900207519531,1.5 86.64900207519531,1.5"></path>
                                        </g>
                                    </g>
                                    <g transform="matrix(0,0,0,0,652.2369995117188,677.7550048828125)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                stroke="rgb(255,251,235)" stroke-opacity="1" stroke-width="3"
                                                d=" M1.5,1.5 C1.5,1.5 86.64900207519531,1.5 86.64900207519531,1.5"></path>
                                        </g>
                                    </g>
                                    <g transform="matrix(0,0,0,0,652.2369995117188,689.883056640625)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                stroke="rgb(255,251,235)" stroke-opacity="1" stroke-width="3"
                                                d=" M1.5,1.5 C1.5,1.5 86.64900207519531,1.5 86.64900207519531,1.5"></path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,248.34400939941406,698.4450073242188)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,154.1540069580078,29.52199935913086)">
                                            <path fill="rgb(255,251,235)" fill-opacity="1"
                                                d=" M124.427001953125,-21.46299934387207 C124.427001953125,-21.46299934387207 -145.88900756835938,-21.46299934387207 -145.88900756835938,-21.46299934387207 C-142.44500732421875,-14.833000183105469 -140.64700317382812,-7.4720001220703125 -140.64700317382812,-0.0010000000474974513 C-140.64700317382812,7.4710001945495605 -142.44500732421875,14.833000183105469 -145.88900756835938,21.46299934387207 C-145.88900756835938,21.46299934387207 124.427001953125,21.46299934387207 124.427001953125,21.46299934387207 C136.281005859375,21.46299934387207 145.88900756835938,11.85200023651123 145.88900756835938,-0.0010000000474974513 C145.88900756835938,-11.854000091552734 136.281005859375,-21.46299934387207 124.427001953125,-21.46299934387207z">
                                            </path>
                                        </g>
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,156.7469940185547,29.944000244140625)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M-151.27099609375,21.131999969482422 C-151.27099609375,21.131999969482422 121.83399963378906,21.131999969482422 121.83399963378906,21.131999969482422 C133.68800354003906,21.131999969482422 143.29600524902344,11.52400016784668 143.29600524902344,-0.32899999618530273 C143.29600524902344,-12.182000160217285 133.68800354003906,-21.79199981689453 121.83399963378906,-21.79199981689453 C121.83399963378906,-21.79199981689453 -151.45599365234375,-21.79199981689453 -151.45599365234375,-21.79199981689453 C-151.9720001220703,-21.785999298095703 -152.45399475097656,-22.040000915527344 -152.7429962158203,-22.466999053955078 C-152.7429962158203,-22.466999053955078 -155.97900390625,-27.202999114990234 -155.97900390625,-27.202999114990234 C-156.4969940185547,-27.87299919128418 -156.37399291992188,-28.836999893188477 -155.70399475097656,-29.354000091552734 C-155.41099548339844,-29.58099937438965 -155.0449981689453,-29.69300079345703 -154.6750030517578,-29.67099952697754 C-154.6750030517578,-29.67099952697754 126.83300018310547,-29.67099952697754 126.83300018310547,-29.67099952697754 C143.21499633789062,-29.67099952697754 156.4969940185547,-16.389999389648438 156.4969940185547,-0.00800000037997961 C156.4969940185547,16.375 143.21499633789062,29.6560001373291 126.83300018310547,29.6560001373291 C126.83300018310547,29.6560001373291 -154.76800537109375,29.6560001373291 -154.76800537109375,29.6560001373291 C-155.61300659179688,29.694000244140625 -156.32899475097656,29.035999298095703 -156.36500549316406,28.19099998474121 C-156.3800048828125,27.841999053955078 -156.2760009765625,27.5 -156.07000732421875,27.2189998626709 C-156.07000732421875,27.2189998626709 -152.58999633789062,21.882999420166016 -152.58999633789062,21.882999420166016 C-152.31399536132812,21.41699981689453 -151.81300354003906,21.131999969482422 -151.27099609375,21.131999969482422z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,232.52099609375,638.6649780273438)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,159.33900451660156,30.43400001525879)">
                                            <path fill="rgb(255,251,235)" fill-opacity="1"
                                                d=" M-124.427001953125,21.461999893188477 C-124.427001953125,21.461999893188477 145.88900756835938,21.461999893188477 145.88900756835938,21.461999893188477 C142.44900512695312,14.831000328063965 140.65499877929688,7.46999979019165 140.66099548339844,0 C140.65499877929688,-7.46999979019165 142.44900512695312,-14.831000328063965 145.88900756835938,-21.461999893188477 C145.88900756835938,-21.461999893188477 -124.427001953125,-21.461999893188477 -124.427001953125,-21.461999893188477 C-136.27999877929688,-21.461999893188477 -145.88900756835938,-11.852999687194824 -145.88900756835938,0 C-145.88900756835938,11.854000091552734 -136.27999877929688,21.461999893188477 -124.427001953125,21.461999893188477z">
                                            </path>
                                        </g>
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,156.74200439453125,29.94499969482422)">
                                            <path fill="rgb(255,171,0)" fill-opacity="1"
                                                d=" M151.27699279785156,-21.08099937438965 C151.27699279785156,-21.08099937438965 -121.83000183105469,-21.08099937438965 -121.83000183105469,-21.08099937438965 C-133.68299865722656,-21.08099937438965 -143.29200744628906,-11.472000122070312 -143.29200744628906,0.38199999928474426 C-143.29200744628906,12.234999656677246 -133.68299865722656,21.8439998626709 -121.83000183105469,21.8439998626709 C-121.83000183105469,21.8439998626709 151.4600067138672,21.8439998626709 151.4600067138672,21.8439998626709 C151.97500610351562,21.83799934387207 152.45899963378906,22.090999603271484 152.7480010986328,22.51799964904785 C152.7480010986328,22.51799964904785 155.98199462890625,27.225000381469727 155.98199462890625,27.225000381469727 C156.49099731445312,27.900999069213867 156.35499572753906,28.86199951171875 155.6790008544922,29.371999740600586 C155.39199829101562,29.58799934387207 155.03799438476562,29.695999145507812 154.6790008544922,29.67799949645996 C154.6790008544922,29.67799949645996 -126.8270034790039,29.67799949645996 -126.8270034790039,29.67799949645996 C-143.2100067138672,29.67799949645996 -156.49200439453125,16.39699935913086 -156.49200439453125,0.014000000432133675 C-156.49200439453125,-16.368999481201172 -143.2100067138672,-29.649999618530273 -126.8270034790039,-29.649999618530273 C-126.8270034790039,-29.649999618530273 154.77099609375,-29.649999618530273 154.77099609375,-29.649999618530273 C155.61700439453125,-29.69499969482422 156.33799743652344,-29.047000885009766 156.38400268554688,-28.201000213623047 C156.4029998779297,-27.847999572753906 156.29800415039062,-27.499000549316406 156.08900451660156,-27.214000701904297 C156.08900451660156,-27.214000701904297 152.57899475097656,-21.770000457763672 152.57899475097656,-21.770000457763672 C152.29100036621094,-21.33300018310547 151.8000030517578,-21.072999954223633 151.27699279785156,-21.08099937438965z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,235.07801818847656,586.3580322265625)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,158.73599243164062,26.065000534057617)">
                                            <path fill="rgb(255,251,235)" fill-opacity="1"
                                                d=" M136.43800354003906,-18.917999267578125 C136.43800354003906,-18.917999267578125 -152.4429931640625,-18.917999267578125 -152.4429931640625,-18.917999267578125 C-149.85299682617188,-12.949000358581543 -148.52699279785156,-6.507999897003174 -148.5489959716797,-0.0010000000474974513 C-148.5260009765625,6.50600004196167 -149.8520050048828,12.947999954223633 -152.4429931640625,18.917999267578125 C-152.4429931640625,18.917999267578125 136.43800354003906,18.917999267578125 136.43800354003906,18.917999267578125 C145.26800537109375,18.917999267578125 152.4429931640625,10.454000473022461 152.4429931640625,-0.0010000000474974513 C152.4429931640625,-10.4399995803833 145.26800537109375,-18.917999267578125 136.43800354003906,-18.917999267578125z">
                                            </path>
                                        </g>
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,160.60499572753906,26.31100082397461)">
                                            <path fill="rgb(196,204,246)" fill-opacity="1"
                                                d=" M-156.42799377441406,18.672000885009766 C-156.42799377441406,18.672000885009766 134.57000732421875,18.672000885009766 134.57000732421875,18.672000885009766 C143.39999389648438,18.672000885009766 150.57400512695312,10.208999633789062 150.57400512695312,-0.2460000067949295 C150.57400512695312,-10.6850004196167 143.39999389648438,-19.163000106811523 134.57000732421875,-19.163000106811523 C134.57000732421875,-19.163000106811523 -156.55099487304688,-19.163000106811523 -156.55099487304688,-19.163000106811523 C-156.95899963378906,-19.166000366210938 -157.33200073242188,-19.395999908447266 -157.51600646972656,-19.761999130249023 C-157.51600646972656,-19.761999130249023 -159.92300415039062,-23.885000228881836 -159.92300415039062,-23.885000228881836 C-160.35499572753906,-24.533000946044922 -160.1790008544922,-25.409000396728516 -159.53199768066406,-25.840999603271484 C-159.35899353027344,-25.95599937438965 -159.16200256347656,-26.0310001373291 -158.95700073242188,-26.06100082397461 C-158.95700073242188,-26.06100082397461 138.2790069580078,-26.06100082397461 138.2790069580078,-26.06100082397461 C150.54299926757812,-26.06100082397461 160.35499572753906,-14.364999771118164 160.35499572753906,-0.0010000000474974513 C160.35499572753906,14.409000396728516 150.48199462890625,26.06100082397461 138.2790069580078,26.06100082397461 C138.2790069580078,26.06100082397461 -159.0189971923828,26.06100082397461 -159.0189971923828,26.06100082397461 C-159.78900146484375,25.94300079345703 -160.3179931640625,25.225000381469727 -160.2010040283203,24.45400047302246 C-160.1719970703125,24.26300048828125 -160.10299682617188,24.077999114990234 -160,23.913999557495117 C-160,23.913999557495117 -157.3939971923828,19.224000930786133 -157.3939971923828,19.224000930786133 C-157.18800354003906,18.88599967956543 -156.82400512695312,18.677000045776367 -156.42799377441406,18.672000885009766z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(0.9999966621398926,0.0025778154376894236,-0.0025778154376894236,0.9999966621398926,87.87776184082031,161.33648681640625)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,56.49599838256836,68.7750015258789)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M-54.775001525878906,-38.29499816894531 C-54.775001525878906,-38.29499816894531 -43.61399841308594,-27.655000686645508 -43.61399841308594,-27.655000686645508 C-17.253999710083008,-2.503999948501587 4.245999813079834,27.288000106811523 19.80699920654297,60.231998443603516 C19.80699920654297,60.231998443603516 21.507999420166016,63.83399963378906 21.507999420166016,63.83399963378906 C21.507999420166016,63.83399963378906 50.63600158691406,66.4260025024414 54.775001525878906,40.02799987792969 C29.43600082397461,11.5600004196167 7.894999980926514,-20.073999404907227 -9.305999755859375,-54.08399963378906 C-9.305999755859375,-54.08399963378906 -14.593999862670898,-66.42500305175781 -14.593999862670898,-66.42500305175781 C-14.593999862670898,-66.42500305175781 -54.775001525878906,-38.29499816894531 -54.775001525878906,-38.29499816894531z">
                                            </path>
                                        </g>
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,21.781999588012695,16.36199951171875)">
                                            <path fill="rgb(64,212,113)" fill-opacity="1"
                                                d=" M20.104999542236328,-14.057999610900879 C21.5310001373291,-12.003999710083008 13.713000297546387,-4.063000202178955 2.614000082015991,3.678999900817871 C-8.484000205993652,11.420999526977539 -18.679000854492188,16.11199951171875 -20.104999542236328,14.057999610900879 C-21.5310001373291,12.003000259399414 -13.666999816894531,3.9700000286102295 -2.568000078201294,-3.7709999084472656 C8.531000137329102,-11.512999534606934 18.663999557495117,-16.11199951171875 20.104999542236328,-14.057999610900879z">
                                            </path>
                                        </g>
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,26.84000015258789,14.668000221252441)">
                                            <path fill="rgb(64,212,113)" fill-opacity="1"
                                                d=" M15.093000411987305,-12.286999702453613 C15.093000411987305,-12.286999702453613 15.093000411987305,-12.286999702453613 15.093000411987305,-12.286999702453613 C15.093000411987305,-12.286999702453613 -7.136000156402588,6.507999897003174 -16.288000106811523,8.4399995803833 C-16.288000106811523,8.4399995803833 -13.467000007629395,12.286999702453613 -13.467000007629395,12.286999702453613 C-9.657999992370605,10.199000358581543 -5.9679999351501465,7.901000022888184 -2.4140000343322754,5.4039998054504395 C8.515999794006348,-2.2760000228881836 16.288000106811523,-10.125 15.093000411987305,-12.286999702453613z">
                                            </path>
                                        </g>
                                        <g opacity="1" transform="matrix(1,0,0,1,62.26100158691406,71.64199829101562)">
                                            <path fill="rgb(64,212,113)" fill-opacity="1"
                                                d=" M9.35099983215332,-14.656000137329102 C9.35099983215332,-11.406000137329102 8.156000137329102,2.5759999752044678 -15.177000045776367,8.34000015258789 C-13.644000053405762,10.425000190734863 -12.111000061035156,12.541000366210938 -10.57800006866455,14.656000137329102 C4.1539998054504395,10.303000450134277 10.777000427246094,2.744999885559082 13.765999794006348,-3.0190000534057617 C14.22599983215332,-3.938999891281128 14.793000221252441,-5.151000022888184 15.177000045776367,-6.086999893188477 C13.194000244140625,-8.897000312805176 11.251999855041504,-11.753999710083008 9.35099983215332,-14.656000137329102z">
                                            </path>
                                        </g>
                                        <g opacity="1" transform="matrix(1,0,0,1,32.80400085449219,82.55000305175781)">
                                            <path fill="rgb(64,212,113)" fill-opacity="1"
                                                d=" M16.410999298095703,-6.63100004196167 C16.410999298095703,-6.63100004196167 -17.851999282836914,-7.8420000076293945 -17.851999282836914,-7.8420000076293945 C-17.851999282836914,-7.8420000076293945 -9.72700023651123,-0.9580000042915344 -9.72700023651123,-0.9580000042915344 C-9.72700023651123,-0.9580000042915344 -14.571000099182129,7.8420000076293945 -14.571000099182129,7.8420000076293945 C-14.571000099182129,7.8420000076293945 17.851999282836914,-0.42100000381469727 17.851999282836914,-0.42100000381469727 C17.851999282836914,-0.42100000381469727 16.410999298095703,-6.63100004196167 16.410999298095703,-6.63100004196167z">
                                            </path>
                                        </g>
                                        <g opacity="1" transform="matrix(1,0,0,1,48.96200180053711,96.23200225830078)">
                                            <path fill="rgb(64,212,113)" fill-opacity="1"
                                                d=" M3.380000114440918,-12.340999603271484 C3.380000114440918,-12.340999603271484 -8.791999816894531,8.87600040435791 -8.791999816894531,8.87600040435791 C-8.791999816894531,8.87600040435791 -0.23800000548362732,5.611000061035156 -0.23800000548362732,5.611000061035156 C-0.23800000548362732,5.611000061035156 3.0739998817443848,12.340999603271484 3.0739998817443848,12.340999603271484 C3.0739998817443848,12.340999603271484 8.791999816894531,-9.96500015258789 8.791999816894531,-9.96500015258789 C8.791999816894531,-9.96500015258789 3.380000114440918,-12.340999603271484 3.380000114440918,-12.340999603271484z">
                                            </path>
                                        </g>
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,55.861000061035156,78.38200378417969)">
                                            <path fill="rgb(64,212,113)" fill-opacity="1"
                                                d=" M1.156999945640564,11.196000099182129 C-5.0269999504089355,11.815999984741211 -10.541000366210938,7.304999828338623 -11.16100025177002,1.121999979019165 C-11.781000137329102,-5.061999797821045 -7.270999908447266,-10.57699966430664 -1.0880000591278076,-11.196999549865723 C5.0960001945495605,-11.815999984741211 10.612000465393066,-7.304999828338623 11.232000350952148,-1.121999979019165 C11.241999626159668,-1.0119999647140503 11.251999855041504,-0.9020000100135803 11.260000228881836,-0.7919999957084656 C11.781999588012695,5.307000160217285 7.260000228881836,10.673999786376953 1.1610000133514404,11.196000099182129 C1.1610000133514404,11.196000099182129 1.156999945640564,11.196000099182129 1.156999945640564,11.196000099182129z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,673.1400146484375,358.2760009765625)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,8.467000007629395,8.467000007629395)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M0,-8.217000007629395 C4.538000106811523,-8.217000007629395 8.217000007629395,-4.538000106811523 8.217000007629395,0 C8.217000007629395,4.538000106811523 4.538000106811523,8.217000007629395 0,8.217000007629395 C-4.538000106811523,8.217000007629395 -8.217000007629395,4.538000106811523 -8.217000007629395,0 C-8.217000007629395,-4.538000106811523 -4.538000106811523,-8.217000007629395 0,-8.217000007629395z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1.100000023841858,0,0,1.100000023841858,295.868896484375,234.61988830566406)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,16.01099967956543,16.01099967956543)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M0.0010000000474974513,-15.76200008392334 C0.0010000000474974513,-15.76200008392334 15.76200008392334,0.0010000000474974513 15.76200008392334,0.0010000000474974513 C15.76200008392334,0.0010000000474974513 0.0010000000474974513,15.76200008392334 0.0010000000474974513,15.76200008392334 C0.0010000000474974513,15.76200008392334 -15.76200008392334,0.0010000000474974513 -15.76200008392334,0.0010000000474974513 C-15.76200008392334,0.0010000000474974513 0.0010000000474974513,-15.76200008392334 0.0010000000474974513,-15.76200008392334z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(0.9988024830818176,-0.04892473295331001,0.04892473295331001,0.9988024830818176,869.3712158203125,533.5250244140625)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,15.142999649047852,13.446999549865723)">
                                            <path fill="rgb(196,204,246)" fill-opacity="1"
                                                d=" M12.807000160217285,-5.629000186920166 C12.807000160217285,-5.629000186920166 12.807000160217285,-5.629000186920166 12.807000160217285,-5.629000186920166 C10.711000442504883,-9.01099967956543 6.270999908447266,-10.053000450134277 2.8889999389648438,-7.958000183105469 C2.8889999389648438,-7.958000183105469 0.7730000019073486,-6.65500020980835 0.7730000019073486,-6.65500020980835 C0.7730000019073486,-6.65500020980835 -0.5460000038146973,-8.770999908447266 -0.5460000038146973,-8.770999908447266 C-2.6410000324249268,-12.152000427246094 -7.081999778747559,-13.196999549865723 -10.46399974822998,-11.10200023651123 C-13.843999862670898,-9.005999565124512 -14.892999649047852,-4.571000099182129 -12.809000015258789,-1.184000015258789 C-12.809000015258789,-1.184000015258789 -11.491000175476074,0.9340000152587891 -11.491000175476074,0.9340000152587891 C-11.491000175476074,0.9340000152587891 -3.9030001163482666,13.196999549865723 -3.9030001163482666,13.196999549865723 C-3.9030001163482666,13.196999549865723 8.362000465393066,5.609000205993652 8.362000465393066,5.609000205993652 C8.362000465393066,5.609000205993652 10.47700023651123,4.289999961853027 10.47700023651123,4.289999961853027 C13.85200023651123,2.187999963760376 14.892999649047852,-2.244999885559082 12.807000160217285,-5.629000186920166z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(0.9988024830818176,0.04892473295331001,-0.04892473295331001,0.9988024830818176,692.2575073242188,238.60830688476562)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,14.652000427246094,13.489999771118164)">
                                            <path fill="rgb(255,171,0)" fill-opacity="1"
                                                d=" M8.84000015258789,-11.826000213623047 C8.84000015258789,-11.826000213623047 8.84000015258789,-11.826000213623047 8.84000015258789,-11.826000213623047 C5.123000144958496,-13.239999771118164 0.9629999995231628,-11.380999565124512 -0.4659999907016754,-7.671000003814697 C-0.4659999907016754,-7.671000003814697 -1.3389999866485596,-5.38700008392334 -1.3389999866485596,-5.38700008392334 C-1.3389999866485596,-5.38700008392334 -3.6689999103546143,-6.2769999504089355 -3.6689999103546143,-6.2769999504089355 C-7.386000156402588,-7.698999881744385 -11.552000045776367,-5.840000152587891 -12.973999977111816,-2.122999906539917 C-12.973999977111816,-2.122999906539917 -12.973999977111816,-2.121000051498413 -12.973999977111816,-2.121000051498413 C-14.402000427246094,1.5839999914169312 -12.555999755859375,5.744999885559082 -8.850000381469727,7.172999858856201 C-8.84000015258789,7.177000045776367 -8.829999923706055,7.179999828338623 -8.819999694824219,7.184000015258789 C-8.819999694824219,7.184000015258789 -6.50600004196167,8.071999549865723 -6.50600004196167,8.071999549865723 C-6.50600004196167,8.071999549865723 6.96999979019165,13.23900032043457 6.96999979019165,13.23900032043457 C6.96999979019165,13.23900032043457 12.121000289916992,-0.23600000143051147 12.121000289916992,-0.23600000143051147 C12.121000289916992,-0.23600000143051147 13.010000228881836,-2.5510001182556152 13.010000228881836,-2.5510001182556152 C14.402000427246094,-6.263999938964844 12.539999961853027,-10.402999877929688 8.84000015258789,-11.826000213623047z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1.100000023841858,0,0,1.100000023841858,110.19190216064453,476.7690124511719)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,6.059999942779541,6.059999942779541)">
                                            <path fill="rgb(255,171,0)" fill-opacity="1"
                                                d=" M0.0010000000474974513,-5.809999942779541 C3.2090001106262207,-5.809999942779541 5.810999870300293,-3.2079999446868896 5.810999870300293,0.0010000000474974513 C5.810999870300293,3.2090001106262207 3.2090001106262207,5.809999942779541 0.0010000000474974513,5.809999942779541 C-3.2079999446868896,5.809999942779541 -5.810999870300293,3.2090001106262207 -5.810999870300293,0.0010000000474974513 C-5.810999870300293,-3.2079999446868896 -3.2079999446868896,-5.809999942779541 0.0010000000474974513,-5.809999942779541z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1.095967173576355,-0.09410569071769714,0.09410569071769714,1.095967173576355,754.9273071289062,283.6407775878906)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,26.009000778198242,73.06300354003906)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M-2.2179999351501465,-25.121999740600586 C-2.2179999351501465,-25.121999740600586 18.798999786376953,-27.95800018310547 18.798999786376953,-27.95800018310547 C18.798999786376953,-27.95800018310547 25.759000778198242,23.39900016784668 25.759000778198242,23.39900016784668 C25.759000778198242,23.39900016784668 4.741000175476074,26.250999450683594 4.741000175476074,26.250999450683594 C-9.473999977111816,27.95800018310547 -22.381000518798828,17.81800079345703 -24.089000701904297,3.6040000915527344 C-25.760000228881836,-10.307999610900879 -16.07200050354004,-23.0310001373291 -2.2179999351501465,-25.121999740600586z">
                                            </path>
                                        </g>
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,110.46700286865234,62.52199935913086)">
                                            <path fill="rgb(64,212,113)" fill-opacity="1"
                                                d=" M-8.414999961853027,-23.104000091552734 C-8.414999961853027,-23.104000091552734 -3.9839999675750732,-23.716999053955078 -3.9839999675750732,-23.716999053955078 C-0.4230000078678131,-24.18899917602539 2.8519999980926514,-21.695999145507812 3.3429999351501465,-18.136999130249023 C3.3429999351501465,-18.136999130249023 7.941999912261963,16.263999938964844 7.941999912261963,16.263999938964844 C8.414999961853027,19.826000213623047 5.921000003814697,23.100000381469727 2.361999988555908,23.591999053955078 C2.361999988555908,23.591999053955078 -2.068000078201294,24.18899917602539 -2.068000078201294,24.18899917602539 C-2.068000078201294,24.18899917602539 -8.414999961853027,-23.104000091552734 -8.414999961853027,-23.104000091552734z">
                                            </path>
                                        </g>
                                        <g opacity="1" transform="matrix(1,0,0,1,52.79800033569336,70.12100219726562)">
                                            <path fill="rgb(64,212,113)" fill-opacity="1" d="M0 0"></path>
                                        </g>
                                        <g opacity="1" transform="matrix(1,0,0,1,82.84300231933594,63.60200119018555)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M-30.676000595092773,-32.04800033569336 C-30.676000595092773,-32.04800033569336 5.2729997634887695,-59.84000015258789 5.2729997634887695,-59.84000015258789 C9.795999526977539,-63.35100173950195 14.135000228881836,-61.573001861572266 14.901000022888184,-55.9010009765625 C14.901000022888184,-55.9010009765625 29.909000396728516,54.8120002746582 29.909000396728516,54.8120002746582 C30.676000595092773,60.48500061035156 26.965999603271484,63.35100173950195 21.677000045776367,61.189998626708984 C21.677000045776367,61.189998626708984 -20.374000549316406,43.95899963378906 -20.374000549316406,43.95899963378906 C-20.374000549316406,43.95899963378906 -30.676000595092773,-32.04800033569336 -30.676000595092773,-32.04800033569336z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1.100000023841858,0,0,1.100000023841858,129.60951232910156,613.2940673828125)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,15.204999923706055,13.119000434875488)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M13.449000358581543,-10.855999946594238 C13.449000358581543,-10.855999946594238 -13.394000053405762,-12.803000450134277 -13.394000053405762,-12.803000450134277 C-14.178999900817871,-12.869999885559082 -14.868000030517578,-12.288000106811523 -14.9350004196167,-11.501999855041504 C-14.954999923706055,-11.265999794006348 -14.914999961853027,-11.027999877929688 -14.819999694824219,-10.8100004196167 C-14.819999694824219,-10.8100004196167 -5.23799991607666,11.788000106811523 -5.23799991607666,11.788000106811523 C-4.932000160217285,12.522000312805176 -4.089000225067139,12.869000434875488 -3.3540000915527344,12.562000274658203 C-3.1389999389648438,12.472999572753906 -2.950000047683716,12.333000183105469 -2.8010001182556152,12.154999732971191 C-2.8010001182556152,12.154999732971191 14.444999694824219,-8.51099967956543 14.444999694824219,-8.51099967956543 C14.954999923706055,-9.111000061035156 14.880999565124512,-10.01099967956543 14.281000137329102,-10.520000457763672 C14.04699993133545,-10.718999862670898 13.755000114440918,-10.836000442504883 13.449000358581543,-10.855999946594238z">
                                            </path>
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0.000008897558473108802,-0.000008897558473108802,1,171.83575439453125,346.7482604980469)"
                                        opacity="1" style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,94.0770034790039,88.5)">
                                            <path fill="rgb(196,204,246)" fill-opacity="1"
                                                d=" M70.7979965209961,-24.968000411987305 C74.38999938964844,-21.391000747680664 75.55899810791016,-16.04400062561035 73.78700256347656,-11.293999671936035 C59.11399841308594,28.065000534057617 28.06599998474121,59.108001708984375 -11.295000076293945,73.77400207519531 C-16.041000366210938,75.55699920654297 -21.39299964904785,74.39399719238281 -24.969999313354492,70.79900360107422 C-24.969999313354492,70.79900360107422 -75.55899810791016,20.209999084472656 -75.55899810791016,20.209999084472656 C-75.55899810791016,20.209999084472656 20.224000930786133,-75.55699920654297 20.224000930786133,-75.55699920654297 C20.224000930786133,-75.55699920654297 70.7979965209961,-24.968000411987305 70.7979965209961,-24.968000411987305z">
                                            </path>
                                            <g opacity="1" transform="matrix(1,0,0,1,0,0)"></g>
                                        </g>
                                        <g opacity="1" transform="matrix(1,0,0,1,75.08000183105469,74.62200164794922)">
                                            <path fill="rgb(0,85,223)" fill-opacity="1"
                                                d=" M68.36299896240234,-73.94400024414062 C68.36299896240234,-73.94400024414062 -31.69700050354004,-34.08599853515625 -31.69700050354004,-34.08599853515625 C-32.79100036621094,-33.645999908447266 -33.65599822998047,-32.7760009765625 -34.0890007019043,-31.679000854492188 C-34.0890007019043,-31.679000854492188 -73.9469985961914,68.36599731445312 -73.9469985961914,68.36599731445312 C-74.83000183105469,70.55599975585938 -73.77100372314453,73.04900360107422 -71.58000183105469,73.93199920654297 C-70.48999786376953,74.37200164794922 -69.26699829101562,74.34400177001953 -68.197998046875,73.85299682617188 C-68.197998046875,73.85299682617188 28.18199920654297,30.224000930786133 28.18199920654297,30.224000930786133 C29.134000778198242,29.798999786376953 29.89699935913086,29.041000366210938 30.32900047302246,28.093000411987305 C30.32900047302246,28.093000411987305 73.85099792480469,-68.18000030517578 73.85099792480469,-68.18000030517578 C74.83000183105469,-70.33899688720703 73.87300109863281,-72.88300323486328 71.71399688720703,-73.86199951171875 C70.65499877929688,-74.34200286865234 69.44499969482422,-74.37200164794922 68.36299896240234,-73.94400024414062z">
                                            </path>
                                        </g>
                                        <g opacity="1"
                                            transform="matrix(1,0,0,1,36.13199996948242,103.03600311279297)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                stroke="rgb(196,204,246)" stroke-opacity="1" stroke-width="8"
                                                d=" M-16.042999267578125,39.459999084472656 C-16.042999267578125,39.459999084472656 16.042999267578125,-39.459999084472656 16.042999267578125,-39.459999084472656">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>


        </div>



        <!--
                                    <section class="about-area about-three-area sub-bg pt-120">



                                     <div class="container">
                                      <div class="row g-4 align-items-center">
                                       <div class="col-lg-7 order-2 order-lg-1">
                                        <div class="about-three__left-item">
                                         <div class="section-header mb-40">
                                          <h3 class="wow fadeInUp arrow-heading" data-wow-delay="00ms" data-wow-duration="1500ms">
                                           <img class="me-1" src="/contents/files/2w2YVw3fQ3oiAXA1JE1u.png" alt="icon">
                                           المقدمة
                                          </h3>
                                               <p class="wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 400ms; animation-name: fadeInUp;">
                                           في إطار ما يشهده العالم من تطورات متسارعة في تكنولوجيا التعليم. يلتزم التفاعل الإيجابي للتدريب والاستشارات

                                     الحاصل على رخصة تطوير المحتوى من المركز الوطني للتعليم الالكتروني في إنتاج وتطوير حلول عملية وملائمة
                                    لإنتاج المحتوى التعليمي الرقمي التفاعلي للمقررات الدراسية والتدريبية بصورة رقمية مبتكره تتوافق مع المعايير العالمية للتعليم
                                     الإلكتروني، وتتميز المقررات التي
                                    يتم اعدادها وتطويرها من قبل فريق التفاعل الإيجابي
                                    بتوافقها مع جميع اجهزة الحاسب والأجهزة الذكية ونظم التشغيل المختلفة (iOS/Android)،
                                    مع ضمان توافقية المحتوى الرقمي مع معايير XAPI & SCORM File  وتقديم الدعم الفني للنشر على أنظمة إدارة التعلم LMS

                                           .</p>
                                         </div>
                                         <div class="about-three__info bor-bottom pb-30">
                                          <div class="row g-4 wow fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 200ms; animation-name: fadeInDown;">


                                          </div>
                                         </div>

                                        </div>
                                       </div>
                                       <div class="col-lg-5 order-1 order-lg-2">
                                        <div class="faq__image about-three__image image wow fadeInRight" data-wow-delay="200ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 200ms; animation-name: fadeInRight;">
                                         <div class="about-three-dot">
                                          <img class="sway__animationX" src="/contents/files/jlk9SbvrzRdSnaROyQgl.png" alt="shape">
                                         </div>

                                         <div class="faq__line sway__animation">
                                          <img src="/contents/files/AR4qBRWmgCOWHac7I0BQ.png" alt="image">
                                         </div>
                                         <img src="/contents/files/elearning-1.png" alt="image">
                                        </div>
                                       </div>
                                      </div>
                                     </div>
                                    </section>	-->
        <!---end  about  section-->



        <section class="process-area pt-120 pb-120">
            <div class="container">
                <div class="section-header text-center mb-60">
                    <h3 class="wow fadeInUp arrow-heading" data-wow-delay="10ms" data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 10ms; animation-name: fadeInUp;">
                        <img class="me-1" src="/contents/files/2w2YVw3fQ3oiAXA1JE1u.png" alt="icon">
                        الخدمات المقدمة في تطوير المحتوى

                    </h3>

                </div>
                <div class="row g-4">
                    <div class="col-lg-3 wow fadeInUp" data-wow-delay="3ms" data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 5ms; animation-name: fadeInUp;">
                        <div class="process__item mb-100">
                            <div class="process-arry bobble__animation">
                                <img src="/contents/files/WrStCRmXhumtuglrWmRZ.png" alt="arry-icon">
                            </div>
                            <div class="process__image">
                                <img src="/contents/files/2gpOZdFMiwfrgPmuYChB.png" alt="image">
                                <span class="process-number">1</span>
                            </div>
                            <div class="process__content">
                                <h4 class="mt-25 mb-10">
                                    انشاء المحتوى

                                </h4>
                                <p>تتضمن خدمة انشاء المحتوى لدينا تعاونًا وثيقًا مع خبراء الموضوع لإنشاء محتوى تعليمي عالي
                                    الجودة. نحن نعمل بدقة لتطوير المواد التي تتوافق مع أهداف التعلم المستلمة، وضمان دقة
                                    المحتوى وشموله وتكييفه مع الأهداف المحددة للمنهج أو برنامج التدريب.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 wow fadeInUp" data-wow-delay="6ms" data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 10ms; animation-name: fadeInUp;">
                        <div class="process__item mb-100">
                            <div class="process-arry bobble__animation">
                                <img src="/contents/files/WrStCRmXhumtuglrWmRZ.png" alt="arry-icon">
                            </div>
                            <div class="process__image">
                                <img src="/contents/files/p2V9aBo2Yv5EG9WGL2Rq.png" alt="image">
                                <span class="process-number">2</span>
                            </div>
                            <div class="process__content">
                                <h4 class="mt-25 mb-10">
                                    تطوير المحتوى الرقمي

                                </h4>
                                <p>إنشاء محتوى رقمي جذاب وتفاعلي منظمة وفعالة: يتماشى مع احدث المعايير التعليمية المحلية
                                    والعالمية. كما يتخصص فريقنا في تطوير المحتوى العربي للمدارس والجامعات والتدريب المؤسسي.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 wow fadeInUp" data-wow-delay="8ms" data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 15ms; animation-name: fadeInUp;">
                        <div class="process__item mb-100">
                            <div class="process-arry bobble__animation">
                                <img src="/contents/files/WrStCRmXhumtuglrWmRZ.png" alt="arry-icon">
                            </div>
                            <div class="process__image">
                                <img src="/contents/files/lJ3iiIyqCvgZ3ccwF8Sl.png" alt="image">
                                <span class="process-number">3</span>
                            </div>
                            <div class="process__content">
                                <h4 class="mt-25 mb-10">
                                    إنتاج الرسوم المتحركة ثلاثية الأبعاد

                                </h4>
                                <p>تحقيق تجربة تعليمية حية من خلال الرسوم المتحركة ثلاثية الأبعاد، مما يجعل التعليم أكثر
                                    تفاعلاً وفعالية. يعد هذا الخيار مثاليًا للوحدات التعليمية الإلكترونية، وبرامج التدريب
                                    المؤسسي، والتجارب التعليمية الغامرة
                                </p>
                            </div>
                        </div>
                    </div>




                    <div class="col-lg-3 wow fadeInUp" data-wow-delay="8ms" data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 20ms; animation-name: fadeInUp;">
                        <div class="process__item mb-100">
                            <div class="process-arry bobble__animation">
                                <img src="/contents/files/WrStCRmXhumtuglrWmRZ.png" alt="arry-icon">
                            </div>
                            <div class="process__image">
                                <img src="/contents/files/e-learning-courses.png" alt="image">
                                <span class="process-number">4</span>
                            </div>
                            <div class="process__content">
                                <h4 class="mt-25 mb-10">
                                    تطوير المناهج الدراسية


                                </h4>
                                <p>نصمم مناهج دراسية مبتكرة تلبي احتياجات المتعلمين اليوم، ونعمل بشكل وثيق مع المعلمين
                                    لإنشاء محتوى تفاعلي وجذاب وفعال يعزز من تجربة التعلم ويساهم في تحقيق أهدافهم التعليمية.
                                </p>
                            </div>
                        </div>
                    </div>






                </div>
            </div>
        </section>


        <section id="our-services">
            <div class="container">
                <div class="section-header text-center mb-60">
                    <h3 class="wow fadeInUp arrow-heading" data-wow-delay="10ms" data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 10ms; animation-name: fadeInUp;">
                        <img class="me-1" src="/contents/files/2w2YVw3fQ3oiAXA1JE1u.png" alt="icon">
                        منهجية تصميم البرامج الالكترونية وفقا لنموذج ADDIE

                    </h3>

                </div>
                <!--	<div class="row">
                                       <div class="col-lg-12">
                                        <ul class="timeline">
                                                      <li class="timeline-inverted">
                                                   <div class="timeline-image">
                                                    <img class="rounded-circle img-fluid" src="/contents/files/Picture2.png" alt="Service image">
                                           </div>
                                           <div class="timeline-panel wow rotateInDownLeft animated animated" data-wow-duration="0.5s" style="visibility: visible;-webkit-animation-duration: 0.5s; -moz-animation-duration: 0.5s; animation-duration: 0.5s;">
                                            <div class="timeline-heading">
                                             <h4 class="subheading">المرحلة الاولى
                                             </h4>
                                            </div>
                                            <div class="timeline-body">
                                             <p>
                                              التحليل
                                             </p>
                                            </div>
                                           </div>
                                          </li>
                                                <li>
                                                   <div class="timeline-image">
                                                    <img class="rounded-circle img-fluid" src="/contents/files/Picture2.png" alt="Service image">
                                           </div>
                                           <div class="timeline-panel wow rotateInDownLeft animated animated" data-wow-duration="0.5s" style="visibility: visible;-webkit-animation-duration: 0.5s; -moz-animation-duration: 0.5s; animation-duration: 0.5s;">
                                            <div class="timeline-heading">
                                             <h4 class="subheading">المرحلة الثانية </h4>
                                            </div>
                                            <div class="timeline-body">
                                             <p>
                                              التصميم									</p>


                                            </div>
                                           </div>
                                          </li>
                                                <li class="timeline-inverted">
                                                   <div class="timeline-image">
                                            <img class="rounded-circle img-fluid" src="/contents/files/Picture2.png" alt="Service image">
                                           </div>
                                           <div class="timeline-panel wow rotateInDownLeft animated animated" data-wow-duration="0.5s" style="visibility: visible;-webkit-animation-duration: 0.5s; -moz-animation-duration: 0.5s; animation-duration: 0.5s;">
                                            <div class="timeline-heading">
                                             <h4 class="subheading">المرحلة الثالثة</h4>
                                            </div>
                                            <div class="timeline-body">
                                             <p>
                                              التطوير
                                             </p>
                                            </div>
                                           </div>
                                          </li>
                                                <li style="direction: rtl">
                                                   <div class="timeline-image">
                                                    <img class="rounded-circle img-fluid" src="/contents/files/Picture2.png" alt="Service image">
                                           </div>
                                           <div class="timeline-panel wow rotateInDownLeft animated animated" data-wow-duration="0.5s" style="visibility: visible;-webkit-animation-duration: 0.5s; -moz-animation-duration: 0.5s; animation-duration: 0.5s;">
                                            <div class="timeline-heading">
                                             <h4 class="subheading"> المرحلة الرابعة </h4>
                                            </div>
                                            <div class="timeline-body">
                                             <p>
                                              التنفيذ
                                              </p>

                                            </div>
                                           </div>
                                          </li>
                                                <li class="timeline-inverted" style="direction: rtl">
                                                   <div class="timeline-image">
                                                    <img class="rounded-circle img-fluid" src="/contents/files/Picture2.png" alt="Service image">
                                           </div>
                                           <div class="timeline-panel wow rotateInDownLeft animated animated" data-wow-duration="0.5s" style="visibility: visible;-webkit-animation-duration: 0.5s; -moz-animation-duration: 0.5s; animation-duration: 0.5s;">
                                            <div class="timeline-heading">
                                             <h4 class="subheading">المرحلة الخامسة</h4>
                                            </div>
                                            <div class="timeline-body">
                                             <p>
                                              التقييم
                                             </p>
                                            </p>
                                            </div>
                                           </div>
                                          </li>




                                        </ul>
                                       </div>
                                      </div>-->

                <div class="timeline-container">
                    <div class="timeline">
                        <div class="stage">
                            <div class="stage-content">
                                <div class="stage-number" style="background-color:#50238f">1</div>
                                <h3 class="stage-title">المرحلة الأولى</h3>
                                <p class="stage-description">التحليل</p>
                            </div>
                        </div>

                        <div class="stage">
                            <div class="stage-content">
                                <div class="stage-number" style="background-color:#198754">2</div>
                                <h3 class="stage-title">المرحلة الثانية</h3>
                                <p class="stage-description">التصميم</p>
                            </div>
                        </div>

                        <div class="stage">
                            <div class="stage-content">
                                <div class="stage-number" style="background-color:#1ba7da">3</div>
                                <h3 class="stage-title">المرحلة الثالثة</h3>
                                <p class="stage-description">التطوير</p>
                            </div>
                        </div>

                        <div class="stage">
                            <div class="stage-content">
                                <div class="stage-number" style="background-color:#d9a407">4</div>
                                <h3 class="stage-title">المرحلة الرابعة</h3>
                                <p class="stage-description">التنفيذ</p>
                            </div>
                        </div>

                        <div class="stage">
                            <div class="stage-content">
                                <div class="stage-number" style="background-color:#9f105c">5</div>
                                <h3 class="stage-title">المرحلة الخامسة</h3>
                                <p class="stage-description">التقييم</p>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function handleIntersection(entries, observer) {
                        entries.forEach((entry, index) => {
                            if (entry.isIntersecting) {
                                setTimeout(() => {
                                    entry.target.classList.add('fade-in');
                                }, index * 200);
                            }
                        });
                    }

                    const observer = new IntersectionObserver(handleIntersection, {
                        threshold: 0.1,
                        root: null
                    });

                    document.querySelectorAll('.stage').forEach(stage => {
                        observer.observe(stage);
                    });
                </script>
            </div>
        </section>
        <section class="service-three-area pt-120 pb-120 light-area">

            <div class="container">
                <div class="section-header text-center mb-60">
                    <h3 class="wow fadeInUp arrow-heading" data-wow-delay="00ms" data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
                        <img class="me-1" src="/contents/files/ceExPRVyCQvC5bMf6Qcc.png" alt="icon">
                        فريق العمل

                    </h3>

                </div>

                <div class="row g-4">
                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
                        <div class="service-three__item">
                            <div class="service-three__image image">
                                <img class="component-service-cover" src="/contents/files/J4yUHPfUIZqCEtkDzHqu.jpg"
                                    alt="image">
                            </div>
                            <div class="service-three__content">
                                <div class="icon">
                                    <img src="/contents/files/dVv1mnNVsvbsGeYuNNMb.png" alt="icon">
                                </div>
                                <h4>خبراء محتوى
                                </h4>
                            </div>
                            <div class="service-three__up-content text-center">
                                <div class="icon">
                                    <img src="/contents/files/M2HVz79GkCeRn6OprjXj.png" alt="icon">
                                </div>

                                <p class="text-white">مراجعة وتطوير وتقديم المحتوى العلمي والمواد التعليمية اللازمة -حال
                                    توفرها- بالإضافة إلى إنشاء محتوى بناء على طلب مركز التعلم.
                                    .</p>


                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
                        <div class="service-three__item">
                            <div class="service-three__image image">
                                <img class="component-service-cover" src="/contents/files/Z9sDx8bUcSl5gPy2SLwt.jpg"
                                    alt="image">
                            </div>
                            <div class="service-three__content">
                                <div class="icon">
                                    <img src="/contents/files/Jkj7MP3vEDmcWlm7wayO.png" alt="icon">
                                </div>
                                <h4>خبراء تقنيين
                                </h4>
                            </div>
                            <div class="service-three__up-content text-center">
                                <div class="icon">
                                    <img src="/contents/files/7PcBBBTRtqoelANe30cp.png" alt="icon">
                                </div>

                                <p class="text-white">مسؤول عن الجانب التقني، بما في ذلك البرمجة والدمج مع المنصة
                                    الإلكترونية.
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
                        <div class="service-three__item">
                            <div class="service-three__image image">
                                <img class="component-service-cover" src="/contents/files/jUNS23DkyVa2JtgsQpE5.jpg"
                                    alt="image">
                            </div>
                            <div class="service-three__content">
                                <div class="icon">
                                    <img src="/contents/files/ZJBdpAnZAspkWn0Mmw12.png" alt="icon">
                                </div>
                                <h4>خبراء تصميم تعليمي
                                </h4>
                            </div>
                            <div class="service-three__up-content text-center">
                                <div class="icon">
                                    <img src="/contents/files/BHXCvBiGAI8DcqJyh3XF.png" alt="icon">
                                </div>

                                <p class="text-white">مسؤول عن التصميم التعليمي، والتأكد من أن البرامج تتماشى مع أفضل
                                    منهجيات التعلم التفاعلية.
                                    .</p>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>





        <section class="blog-area pt-10 pb-5">
            <div class="container">
                <div class="section-header text-center mb-10">

                    <h2 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 200ms; animation-name: fadeInUp;">
                        التكامل بين الخبراء
                    </h2>
                </div>
                <div class="row g-4">


                    <div class="col-xl-12 col-lg-12 col-md-12 wow fadeInUp" data-wow-delay="300ms"
                        data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 300ms; animation-name: fadeInUp;">
                        <div class="blog__item">

                            <div class="blog__content">
                                <p>
                                    كل خبير يعمل بشكل متكامل لضمان تحقيق أهداف المشروع. خبير المحتوى يوفر المواد اللازمة،
                                    خبير التصميم التعليمي يقوم بتصميم تجربة التعلم، وخبير التقني يضمن أن يتم عرض المحتوى على
                                    المنصة بشكل فعال وآمن.
                                    التعاون بين هؤلاء الخبراء لضمان تقديم برامج تعليمية ذات جودة عالية.

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <section class="service-three-area pt-50 pb-50">
            <div class="container">
                <div class="section-header text-center mb-10">

                    <h3 class="wow fadeInUp arrow-heading" data-wow-delay="00ms" data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
                        <img class="me-1" src="/contents/files/ceExPRVyCQvC5bMf6Qcc.png" alt="icon">
                        الوظائف والميزات المقدمة


                    </h3>
                </div>
                <div class="row g-4" style="padding-right: 0;
    padding-left: 0;">

                    <!-- Card 1 -->
                    <div class="col-lg wow fadeInUp">
                        <div class="card card-1 h-100 p-4">
                            <div class="card-number number-1" data-wow-delay="00ms" data-wow-duration="1500ms"
                                style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
                                1</div>
                            <h5 class="card-title">جودة الأداء</h5>
                            <p class="card-text">التأكيد على تقديم خدمات بجودة عالية تتماشى مع المعايير المحددة في العقد
                                وضمان تقديم تجربة تعليمية متميزة.</p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-lg wow fadeInUp">
                        <div class="card card-2 h-100 p-4">
                            <div class="card-number number-2" data-wow-delay="00ms" data-wow-duration="1500ms"
                                style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
                                2</div>
                            <h5 class="card-title">طريقة التصميم المتقدمة</h5>
                            <p class="card-text">مستويات متنوعة من المحتوى حيث يتم تصميم البرامج التدريسية باستخدام مجموعة
                                متنوعة من الوسائط لضمان تجربة تعليمية شاملة.</p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-lg wow fadeInUp">
                        <div class="card card-3 h-100 p-4 text-white">
                            <div class="card-number number-3">3</div>
                            <h5 class="card-title">الدعم المستمر</h5>
                            <p class="card-text">توفير دعم فني وتعليمي مستمر طوال مدة تنفيذ المشروع لضمان استمرارية وكفاءة
                                العمليات.</p>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="col-lg wow fadeInUp">
                        <div class="card card-4 h-100 p-4 text-white">
                            <div class="card-number number-4">4</div>
                            <h5 class="card-title">إدارة المشاريع الفعالة</h5>
                            <p class="card-text">استخدام منهجيات إدارة المشاريع مع الالتزام بالجدول الزمني والمعايير المتفق
                                عليها، مع تقديم تقارير دورية لمدير إدارة الشراكات التعليمية بمركز التعلم.</p>
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="col-lg wow fadeInUp">
                        <div class="card card-5 h-100 p-4 text-white">
                            <div class="card-number number-5">5</div>
                            <h5 class="card-title">تصميم تفاعلي متكامل</h5>
                            <p class="card-text">توفير تجربة تعليمية غنية من خلال منصة التعلم الحديثة التي تتضمن الرسوم
                                والصور، والأصوات والفيديوهات لتعزيز فهم المتعلمين ورفع مستوى التفاعل مع المحتوى.</p>
                        </div>
                    </div>


                </div>


            </div>
        </section>


        <section class="about-two-area">

            <div class="container">
                <div class="row g-4">
                    <div class="col-xl-12">
                        <div class="section-header mb-40">

                            <h4 class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms"
                                style="visibility: visible; animation-duration: 1500ms; animation-delay: 200ms; animation-name: fadeInUp;color:#0c4b77">
                                معلومات أكثر عن طريقة التصميم المتقدمة. </h4>

                        </div>
                        <div class="about-two__right-item wow fadeInDown" data-wow-delay="200ms"
                            data-wow-duration="1500ms"
                            style="visibility: visible; animation-duration: 1500ms; animation-delay: 200ms; animation-name: fadeInDown;max-width:100%">
                            <ul>
                                <li class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms"
                                    style="visibility: visible; animation-duration: 1500ms; animation-delay: 200ms; animation-name: fadeInUp;">
                                    <i class="fa-solid fa-check"></i>الفيديوهات التعليمية: إنتاج فيديوهات تعليمية مهنية
                                    تغطي المحتوى بشكل واضح وجذاب.
                                </li>
                                <li class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms"
                                    style="visibility: visible; animation-duration: 1600ms; animation-delay: 230ms; animation-name: fadeInUp;">
                                    <i class="fa-solid fa-check"></i>الإنفوجرافيك: استخدام التصاميم البيانية لتبسيط وتوضيح
                                    المعلومات الهامة بطريقة بصرية سهلة الفهم.
                                </li>
                            </ul>
                            <ul>
                                <li class="wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1700ms"
                                    style="visibility: visible; animation-duration: 1700ms; animation-delay: 240ms; animation-name: fadeInUp;">
                                    <i class="fa-solid fa-check"></i>الدورات التفاعلية: تطوير دورات تدريبية تفاعلية تعتمد
                                    على المشاركة الفعالة للمشاركين من خلال أنشطة تعليمية تفاعلية، مثل المحاكاة والاختبارات
                                    الفورية.
                                </li>

                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </section>



        <section class="offer-area secondary-bg pt-120 pb-200">
            <div class="offer__shadow wow fadeIn" data-wow-delay="200ms" data-wow-duration="1500ms"
                style="visibility: visible; animation-duration: 1500ms; animation-delay: 200ms; animation-name: fadeIn;">
                <img src="/contents/files/9XOjHQrBVZpehzZP1Dqx.png" alt="shadow">
            </div>
            <div class="offer__shape-left">
                <img class="wow fadeInUpBig" data-wow-delay="400ms" data-wow-duration="1500ms"
                    src="/contents/files/frcJyZBV6mi916YfgDSS.png" alt="shape"
                    style="visibility: visible; animation-duration: 1500ms; animation-delay: 400ms; animation-name: fadeInUpBig;">
            </div>
            <div class="offer__shape-right">
                <img class="wow fadeInDownBig" data-wow-delay="400ms" data-wow-duration="1500ms"
                    src="/contents/files/WRBtw8ujtjk4WjxLlKDn.png" alt="shape"
                    style="visibility: visible; animation-duration: 1500ms; animation-delay: 400ms; animation-name: fadeInDownBig;">
            </div>
            <div class="container">
                <div class="d-flex gap-4 flex-wrap align-items-center justify-content-between mb-95">
                    <div class="section-header">
                        <h5 class="wow fadeInLeft" data-wow-delay="00ms" data-wow-duration="1500ms"
                            style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInLeft; color:#fff">
                            <img class="me-1" src="/contents/files/2w2YVw3fQ3oiAXA1JE1u.png" alt="icon">
                            نماذج من اعمالنا السابقة

                        </h5>

                    </div>

                </div>
                <div class="row g-4">
                    <div class="col-lg-2 col-md-4 col-sm-6 wow bounceInUp" data-wow-delay="100ms"
                        data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 100ms; animation-name: bounceInUp;">
                        <div class="offer__item">
                            <div class="shape-top">
                                <img src="/contents/files/MlVijCQNiCKS2NGGEbeC.png" alt="shape">
                            </div>
                            <div class="shape-bottom">
                                <img src="/contents/files/n07PzEIPOgnpJYoJIv1c.png" alt="shape">
                            </div>
                            <div class="offer__icon">
                                <img src="/contents/files/d1ZH2JKTVSJwEzbierK7.svg" alt="icon">
                            </div>
                            <a href="https://www.ejaabi.com/ar/pages/model2" target=_blank>
                                <h4 class="text-white mt-20">مُقدم فيديو ورسوم متحركة
                                </h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 wow bounceInUp" data-wow-delay="200ms"
                        data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 200ms; animation-name: bounceInUp;">
                        <div class="offer__item">
                            <div class="shape-top">
                                <img src="/contents/files/MlVijCQNiCKS2NGGEbeC.png" alt="shape">
                            </div>
                            <div class="shape-bottom">
                                <img src="/contents/files/n07PzEIPOgnpJYoJIv1c.png" alt="shape">
                            </div>
                            <div class="offer__icon">
                                <img src="/contents/files/d1ZH2JKTVSJwEzbierK7.svg" alt="icon">
                            </div>
                            <a href="https://www.ejaabi.com/ar/pages/model1" target=_blank>
                                <h4 class="text-white mt-20">مُقدم فيديو ورسوم متحركة
                                </h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 wow bounceInUp" data-wow-delay="300ms"
                        data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 300ms; animation-name: bounceInUp;">
                        <div class="offer__item">
                            <div class="shape-top">
                                <img src="/contents/files/VS1MMf2b4SmC5al0R50j.png" alt="shape">
                            </div>
                            <div class="shape-bottom">
                                <img src="/contents/files/kq4tbOciNJOpIPvIEP8V.png" alt="shape">
                            </div>
                            <div class="offer__icon">
                                <img src="/contents/files/d1ZH2JKTVSJwEzbierK7.svg" alt="icon">
                            </div>
                            <a href="https://www.ejaabi.com/ar/pages/model4" target=_blank>
                                <h4 class="text-white mt-20">تعلّم الإلكتروني التفاعلي
                                </h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 wow bounceInUp" data-wow-delay="400ms"
                        data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 400ms; animation-name: bounceInUp;">
                        <div class="offer__item">
                            <div class="shape-top">
                                <img src="/contents/files/MlVijCQNiCKS2NGGEbeC.png" alt="shape">
                            </div>
                            <div class="shape-bottom">
                                <img src="/contents/files/8EuV0x9GotNJLGKna1n4.png" alt="shape">
                            </div>
                            <div class="offer__icon">
                                <img src="/contents/files/d1ZH2JKTVSJwEzbierK7.svg" alt="icon">
                            </div>
                            <a
                                href="https://app.cloud.scorm.com/sc/InvitationConfirmEmail?publicInvitationId=b6434a12-c0e5-4588-86bb-39b0814a5975"target=_blank>
                                <h4 class="text-white mt-20">تعلّم الإلكتروني التفاعلي
                                </h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 wow bounceInUp" data-wow-delay="500ms"
                        data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 500ms; animation-name: bounceInUp;">
                        <div class="offer__item">
                            <div class="shape-top">
                                <img src="/contents/files/MlVijCQNiCKS2NGGEbeC.png" alt="shape">
                            </div>
                            <div class="shape-bottom">
                                <img src="/contents/files/8EuV0x9GotNJLGKna1n4.png" alt="shape">
                            </div>
                            <div class="offer__icon">
                                <img src="/contents/files/d1ZH2JKTVSJwEzbierK7.svg" alt="icon">
                            </div>
                            <a
                                href="https://app.cloud.scorm.com/sc/InvitationConfirmEmail?publicInvitationId=1cea7173-3114-462e-9cd7-041a939bf338"target=_blank>
                                <h4 class="text-white mt-20">تعلّم الإلكتروني التفاعلي
                                </h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 wow bounceInUp" data-wow-delay="600ms"
                        data-wow-duration="1500ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 600ms; animation-name: bounceInUp;">
                        <div class="offer__item">
                            <div class="shape-top">
                                <img src="/contents/files/MlVijCQNiCKS2NGGEbeC.png" alt="shape">
                            </div>
                            <div class="shape-bottom">
                                <img src="/contents/files/8EuV0x9GotNJLGKna1n4.png" alt="shape">
                            </div>
                            <div class="offer__icon">
                                <img src="/contents/files/d1ZH2JKTVSJwEzbierK7.svg" alt="icon">
                            </div>
                            <a href="https://app.cloud.scorm.com/sc/InvitationConfirmEmail?publicInvitationId=93047be8-b385-4a4d-9034-3cca039f8b94"
                                target=_blank>
                                <h4 class="text-white mt-20">تعلّم الإلكتروني التفاعلي
                                </h4>
                            </a>
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
