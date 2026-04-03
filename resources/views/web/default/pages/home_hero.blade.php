@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">

<style>
    .home-sections {
        margin-top:80px !important;
    }
    /* Hero Slider Styles */
    .hero-slider {
        position: relative;
        height: 80vh;
        min-height: 600px;
        background: #f5f5f5;
        overflow: hidden;
    }

    /* Animated Background */
    .animated-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .animated-bg::before,
    .animated-bg::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(19, 99, 161, 0.1);
        animation: float 15s infinite;
    }

    .animated-bg::before {
        top: -150px;
        right: -150px;
    }

    .animated-bg::after {
        bottom: -150px;
        left: -150px;
        animation-delay: -7.5s;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        25% { transform: translate(50px, 50px) rotate(90deg); }
        50% { transform: translate(0, 100px) rotate(180deg); }
        75% { transform: translate(-50px, 50px) rotate(270deg); }
    }

    .hero-slide {
        position: relative;
        height: 100%;
        display: flex;
        align-items: center;
        background-size: cover;
        background-position: center;
        transform: scale(1.1);
        transition: transform 1.5s ease;
    }

    .swiper-slide-active .hero-slide {
        transform: scale(1);
    }

    .hero-slide::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 100%);
        opacity: 0;
        transition: opacity 0.8s ease;
    }

    .swiper-slide-active .hero-slide::before {
        opacity: 1;
    }

    /* Hero Content Styles */
    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 750px;
        padding: 0 60px;
        margin: 0 auto; /* Center the content horizontally */
        text-align: center; /* Center the text */
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center; /* Center children horizontally */
        justify-content: center; /* Center children vertically */
    }

    .hero-content::before {
        content: '';
        position: absolute;
        top: -20px;
        right: 0;
        width: 3px;
        height: 0;
        background: #1363a1;
        transition: height 0.8s ease 0.5s;
    }

    .swiper-slide-active .hero-content::before {
        height: 100px;
    }

    /* Hero Title */
    .hero-title {
        font-size: 48px;
        font-weight: bold;
        margin-bottom: 20px;
        opacity: 0;
        transform: translateX(50px);
        transition: all 0.8s ease 0.3s;
    }

    /* Hero Description */
    .hero-description {
        font-size: 18px;
        line-height: 1.8;
        margin-bottom: 30px;
        opacity: 0;
        transform: translateX(30px);
        transition: all 0.8s ease 0.5s;
    }

    /* Hero Buttons */
    .hero-buttons {
        display: flex;
        gap: 15px;
        justify-content: center; /* Center buttons horizontally */
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.8s ease 0.7s;
    }

    .hero-btn {
        padding: 14px 32px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .hero-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(-100%) rotate(45deg);
        transition: transform 0.4s ease;
    }

    .hero-btn:hover::before {
        transform: translateX(100%) rotate(45deg);
    }

    .hero-btn-primary {
        background: #1363a1;
        color: #fff;
        box-shadow: 0 4px 15px rgba(19, 99, 161, 0.3);
    }

    .hero-btn-secondary {
        background: rgba(255,255,255,0.15);
        color: #fff;
        backdrop-filter: blur(10px);
    }

    .hero-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    /* Active Slide Animations */
    .swiper-slide-active .hero-title,
    .swiper-slide-active .hero-description,
    .swiper-slide-active .hero-buttons {
        opacity: 1;
        transform: translateX(0);
    }

    /* Navigation */
    .slider-nav-wrapper {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .hero-slider .swiper-button-next,
    .hero-slider .swiper-button-prev {
        position: relative;
        top: auto;
        left: auto;
        right: auto;
        margin: 0;
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        color: #fff;
        transition: all 0.3s ease;
    }

    .hero-slider .swiper-button-next:after,
    .hero-slider .swiper-button-prev:after {
        font-size: 20px;
    }

    .hero-slider .swiper-button-next:hover,
    .hero-slider .swiper-button-prev:hover {
        background: #1363a1;
        transform: scale(1.1);
    }

    .hero-slider .swiper-pagination {
        position: relative;
        width: auto;
        display: flex;
        gap: 8px;
    }

    .hero-slider .swiper-pagination-bullet {
        width: 30px;
        height: 4px;
        border-radius: 2px;
        background: rgba(255,255,255,0.3);
        transition: all 0.3s ease;
        margin: 0;
    }

    .hero-slider .swiper-pagination-bullet-active {
        width: 50px;
        background: #1363a1;
    }

    /* Progress Bar */
    .slider-progress {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: rgba(255,255,255,0.1);
        z-index: 10;
    }

    .progress-bar {
        height: 100%;
        background: #1363a1;
        width: 0;
        transition: width 0.3s linear;
    }

    @media (max-width: 768px) {
        .hero-slider {
            height: 70vh;
            min-height: 450px;
        }

        .hero-content {
            padding: 0 20px; /* Reduce padding on smaller screens */
            padding-bottom:110px;
        }
    
        .hero-title {
            font-size: 25px; /* Smaller font size for tablets */
        }
    
        .hero-description {
            font-size: 16px; /* Smaller font size for tablets */
        }
    
        .hero-buttons {
            flex-direction: column; /* Stack buttons vertically on smaller screens */
            align-items: center; /* Center buttons vertically */
        }

        .hero-btn {
            padding: 12px 24px;
            width: 100%;
            justify-content: center;
        }

        .slider-nav-wrapper {
            bottom: 20px;
        }
    }

    .services-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        margin-top: 19rem;
        text-align: center;
        z-index:99;

    }

    .service-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1rem;
    }

    .service-logo {
        width: 64px;
        height: 64px;
        margin-bottom: 1rem;
    }

    .service-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #fff;
        margin: 0;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .services-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            display: none;
        }
    }

    @media (max-width: 480px) {
        .services-container {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .services-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            padding: 1rem;
        }
    }

    @media (max-width: 480px) {
        .services-container {
            grid-template-columns: 1fr;
        }
    }
    
    /* Customised Navigation Wrapper */
    .customised-slider-nav-wrapper {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 10;
        background: rgba(0, 0, 0, 0.1); /* Transparent dark background */
        padding: 10px 0; /* Add some padding */
    }
    
    /* Customised Pagination Container */
    .customised-pagination {
        display: flex;
        justify-content: center;
        gap: 10px; /* Space between buttons */
        max-width: 100%; /* Ensure it doesn't overflow */
        overflow-x: auto; /* Allow horizontal scrolling if needed */
        padding: 0 20px; /* Add padding to the sides */
    }
    
    /* Customised Pagination Bullets (Buttons) */
    .customised-pagination-bullet {
        width: 180px; /* Default size for larger screens */
        height: 100px; /* Default size for larger screens */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: transparent; /* Transparent background */
        color: #fff;
        font-size: 16px; /* Adjusted font size */
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.3); /* Border for better visibility */
        outline: none;
        border-radius: 10px; /* Slightly rounded corners */
        text-align: center;
        flex-shrink: 0; /* Prevent buttons from shrinking */
    }
    
    /* Hover and Active States */
    .customised-pagination-bullet:hover {
        background: rgba(1, 99, 159, 0.9); /* Solid color on hover */
        border-color: rgba(1, 99, 159, 0.9); /* Match border color with background */
    }
    
    .customised-pagination-bullet-active {
        background: rgba(1, 99, 159, 0.9); /* Active state */
        border-color: rgba(1, 99, 159, 0.9); /* Match border color with background */
    }
    
    /* Icon and Text inside Bullets */
    .customised-pagination-bullet .icon img {
        width: 30px; /* Adjusted icon size */
        height: 30px; /* Adjusted icon size */
        margin-bottom: 8px; /* Space between icon and text */
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .customised-pagination-bullet span {
        font-size: 14px; /* Adjusted text size */
        line-height: 1.2;
      /*  white-space: nowrap; /* Prevent text from wrapping */
        overflow: hidden;
        text-overflow: ellipsis; /* Add ellipsis if text overflows */
        max-width: 90%; /* Ensure text doesn't overflow the box */
    }
    
    /* Responsive adjustments for custom navigation buttons */
    @media (max-width: 1024px) {
        .customised-pagination-bullet {
            width: 120px; /* Smaller width for tablets */
            height: 80px; /* Smaller height for tablets */
            font-size: 14px; /* Smaller font size for tablets */
        }
    
        .customised-pagination-bullet .icon img {
            width: 25px; /* Smaller icon size for tablets */
            height: 25px; /* Smaller icon size for tablets */
        }
    
        .customised-pagination-bullet span {
            font-size: 12px; /* Smaller text size for tablets */
        }
    }
    
    @media (max-width: 768px) {
        .customised-pagination-bullet {
            width: 100px; /* Smaller width for smaller tablets */
            height: 60px; /* Smaller height for smaller tablets */
            font-size: 12px; /* Smaller font size for smaller tablets */
        }
    
        .customised-pagination-bullet .icon img {
            width: 20px; /* Smaller icon size for smaller tablets */
            height: 20px; /* Smaller icon size for smaller tablets */
        }
    
        .customised-pagination-bullet span {
            font-size: 10px; /* Smaller text size for smaller tablets */
        }
    }
    
    @media (max-width: 480px) {
        .customised-pagination-bullet {
            width: 170px; /* Smaller width for mobile */
            height: 60px; /* Smaller height for mobile */
            font-size: 14px; /* Smaller font size for mobile */
        }
    
        .customised-pagination-bullet .icon img {
            width: 25px; /* Smaller icon size for mobile */
            height: 25px; /* Smaller icon size for mobile */
        }
    
        .customised-pagination-bullet span {
            font-size: 8px; /* Smaller text size for mobile */
        }
        .padding-10{
            padding-top:7px;
        }
    }
</style>
@endpush

@section('content')
@if(!empty($heroSectionData))
<section class="hero-slider swiper">
    <!-- Progress Bar -->
    <div class="slider-progress">
        <div class="progress-bar"></div>
    </div>

    <!-- Animated Background -->
    <div class="animated-bg"></div>

    <div class="swiper-wrapper" style="padding-bottom:50px">
        @foreach ($sliders as $slider)
        <div class="swiper-slide" >
            <div class="hero-slide" style="background-image: url({{ $slider->image }})">
                <div class="hero-content">
                    <h1 class="hero-title">{{ $slider->title }}</h1>
                    <p class="hero-description">{{ $slider->description }}</p>
                    <div class="hero-buttons">
                        <a href="{{ $slider->button1_link }}" class="hero-btn hero-btn-primary" target="_blank">
                            <span>{{ $slider->button1_title }}</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <a href="{{ $slider->button2_link }}" class="hero-btn hero-btn-secondary" target="_blank">
                            <span>{{ $slider->button2_title }}</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 16v-4M12 8h.01"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Navigation -->
    <div class="customised-slider-nav-wrapper">
        <div class="customised-pagination">
             <div class="row">
            @foreach ($sliders as $index => $slider)
            <div class="col-6 col-md-3 padding-10">
                <button class="customised-pagination-bullet" data-slide-index="{{ $index }}" title="{{ $slider->title }}">
                    <div class="icon">
                        <img src="/store/services/icon-{{ $index + 1 }}.png" alt="Service 1" class="service-logo">
                    </div>
                    <span>{{ $slider->title }}</span>
                </button>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</section>
@endif


{{-- Statistics --}}
@include('web.default.pages.includes.home_statistics')
<!--<section class="home-sections home-sections-swiper container">
<div class="d-flex justify-content-between">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2 my-40">
                <div class="site-heading text-center">
                    <h4> من نحن</h4>
                    <h2>دورات عديدة وطرق تدريب مختلفة.


</h2>

                </div>
            </div>
        </div>
         <div class="modern-services-area bottom-less">
    <div class="container">
        <div class="row text-center">


                <div class="single-item col-6 col-md-4">
                    <div class="item noground">
                        <div class="icon">
                            <i class="flaticon-creativity"></i>
                        </div>
                        <div class="content">
                            <h4>  	 .01 </h4>
                            <p>
                              خطط تدريية وخيارات مرنة للإلتحاق بالدورات في جميع التخصصات
                            </p>

                        </div>
                    </div>
                </div>

                <div class="single-item col-6 col-md-4">
                    <div class="item noground">
                        <div class="icon">
                            <i class="flaticon-result"></i>
                        </div>
                        <div class="content">
                            <h4>  .02 	</h4>
                            <p>
                              دورات تدريبية مسجلة وافتراضية وحضورية حسب الطلب
                            </p>

                        </div>
                    </div>
                </div>

                <div class="single-item col-6 col-md-4">
                    <div class="item noground">
                        <div class="icon">

                            <i class="flaticon-meeting"></i>
                        </div>
                        <div class="content">
                            <h4>   	.03   </h4>
                            <p>
                            رسوم تنافسية وجودة في تقديم الخدمات التدريبية الإفتراضية
                            </p>

                        </div>
                    </div>
                </div>



        </div>
    </div>
</div>
    </div>
</div>
</section>-->
@foreach($homeSections as $homeSection)

@if($homeSection->name == \App\Models\HomeSection::$featured_classes and !empty($featureWebinars) and !$featureWebinars->isEmpty())
<section class="home-sections home-sections-swiper container">
    <div class="px-10 px-md-0">
        <h2 class="section-title">{{ trans('home.featured_classes') }}</h2>
        <p class="section-hint">{{ trans('home.featured_classes_hint') }}</p>
    </div>

    <div class="feature-slider-container position-relative d-flex justify-content-center mt-10">
        <div class="swiper-container features-swiper-container pb-25">
            <div class="swiper-wrapper py-10">
                @foreach($featureWebinars as $feature)
                <div class="swiper-slide">

                    <a href="{{ $feature->webinar->getUrl() }}">
                        <div class="feature-slider d-flex h-100" style="background-image: url('{{ $feature->webinar->getImage() }}')">
                            <div class="mask"></div>
                            <div class="p-5 p-md-25 feature-slider-card">
                                <div class="d-flex flex-column feature-slider-body position-relative h-100">
                                    @if($feature->webinar->bestTicket() < $feature->webinar->price)
                                    <span class="badge badge-danger mb-2 ">{{ trans('public.offer',['off' => $feature->webinar->bestTicket(true)['percent']]) }}</span>
                                    @endif
                                    <a href="{{ $feature->webinar->getUrl() }}">
                                        <h3 class="card-title mt-1">{{ $feature->webinar->title }}</h3>
                                    </a>

                                    <div class="user-inline-avatar mt-15 d-flex align-items-center">
                                        <div class="avatar bg-gray200">
                                            <img src="{{ $feature->webinar->teacher->getAvatar() }}" class="img-cover" alt="{{ $feature->webinar->teacher->full_naem }}">
                                        </div>
                                        <a href="{{ $feature->webinar->teacher->getProfileUrl() }}" target="_blank" class="user-name font-14 ml-5">{{ $feature->webinar->teacher->full_name }}</a>
                                    </div>

                                    <p class="mt-25 feature-desc text-gray">{{ $feature->description }}</p>

                                    @include('web.default.includes.webinar.rate',['rate' => $feature->webinar->getRate()])

                                    <div class="feature-footer mt-auto d-flex align-items-center justify-content-between">
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <i data-feather="clock" width="20" height="20" class="webinar-icon"></i>
                                                <span class="duration ml-5 text-dark-blue font-14">{{ convertMinutesToHourAndMinute($feature->webinar->duration) }} {{ trans('home.hours') }}</span>
                                            </div>

                                            <div class="vertical-line mx-10"></div>

                                            <div class="d-flex align-items-center">
                                                <i data-feather="calendar" width="20" height="20" class="webinar-icon"></i>
                                                <span class="date-published ml-5 text-dark-blue font-14">{{ dateTimeFormat(!empty($feature->webinar->start_date) ? $feature->webinar->start_date : $feature->webinar->created_at,'j M Y') }}</span>
                                            </div>
                                        </div>

                                        <div class="feature-price-box">
                                            @if(!empty($feature->webinar->price ) and $feature->webinar->price > 0)
                                            @if($feature->webinar->bestTicket() < $feature->webinar->price)
                                            <span class="real">{{ handlePrice($feature->webinar->bestTicket(), true, true, false, null, true) }}</span>
                                            @else
                                            {{ handlePrice($feature->webinar->price, true, true, false, null, true) }}
                                            @endif
                                            @else
                                            @if($feature->webinar->type!='text_lesson')
                                            {{ trans('public.free') }}
                                            @endif
                                            @endif


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <div class="swiper-pagination features-swiper-pagination"></div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$latest_bundles and !empty($latestBundles) and !$latestBundles->isEmpty())
<section class="home-sections home-sections-swiper container">
    <div class="d-flex justify-content-between ">
        <div>
            <h2 class="section-title">{{ trans('update.latest_bundles') }}</h2>
            <p class="section-hint">{{ trans('update.latest_bundles_hint') }}</p>
        </div>

        <a href="/classes?type[]=bundle" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container latest-bundle-swiper px-12">
            <div class="swiper-wrapper py-10">
                @foreach($latestBundles as $latestBundle)
                <div class="swiper-slide">
                    @include('web.default.includes.webinar.grid-card',['webinar' => $latestBundle])
                </div>
                @endforeach

            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination bundle-webinars-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

{{-- Upcoming Course --}}
@if($homeSection->name == \App\Models\HomeSection::$upcoming_courses and !empty($upcomingCourses) and !$upcomingCourses->isEmpty())
<section class="home-sections home-sections-swiper container">
    <div class="d-flex justify-content-between ">
        <div>
            <h2 class="section-title">{{ trans('update.upcoming_courses') }}</h2>
            <p class="section-hint">{{ trans('update.upcoming_courses_home_section_hint') }}</p>
        </div>

        <a href="/upcoming_courses?sort=newest" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container upcoming-courses-swiper px-12">
            <div class="swiper-wrapper py-20">
                @foreach($upcomingCourses as $upcomingCourse)
                <div class="swiper-slide">
                    @include('web.default.includes.webinar.upcoming_course_grid_card',['upcomingCourse' => $upcomingCourse])
                </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination upcoming-courses-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$latest_classes and !empty($latestWebinars) and !$latestWebinars->isEmpty())
<section class="home-sections home-sections-swiper container">
    <div class="d-flex justify-content-between ">
        <div>
            <h2 class="section-title">{{ trans('home.latest_classes') }}</h2>
            <p class="section-hint">{{ trans('home.latest_webinars_hint') }}</p>
        </div>

        <a href="/classes?sort=newest" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container latest-webinars-swiper px-12">
            <div class="swiper-wrapper py-20">
                @foreach($latestWebinars as $latestWebinar)
                <div class="swiper-slide">
                    @include('web.default.includes.webinar.grid-card',['webinar' => $latestWebinar])
                </div>
                @endforeach

            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination latest-webinars-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$best_rates and !empty($bestRateWebinars) and !$bestRateWebinars->isEmpty())
<section class="home-sections home-sections-swiper container">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="section-title">{{ trans('home.best_rates') }}</h2>
            <p class="section-hint">{{ trans('home.best_rates_hint') }}</p>
        </div>

        <a href="/classes?sort=best_rates" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container best-rates-webinars-swiper px-12">
            <div class="swiper-wrapper py-20">
                @foreach($bestRateWebinars as $bestRateWebinar)
                <div class="swiper-slide">
                    @include('web.default.includes.webinar.grid-card',['webinar' => $bestRateWebinar])
                </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination best-rates-webinars-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$trend_categories and !empty($trendCategories) and !$trendCategories->isEmpty())
<section class="home-sections home-sections-swiper container">
    <h2 class="section-title">{{ trans('home.trending_categories') }}</h2>
    <p class="section-hint">{{ trans('home.trending_categories_hint') }}</p>


    <div class="swiper-container trend-categories-swiper px-12 mt-40">
        <div class="swiper-wrapper py-20">
            @foreach($trendCategories as $trend)
            <div class="swiper-slide">
                <a href="{{ $trend->category->getUrl() }}">
                    <div class="trending-card d-flex flex-column align-items-center w-100">
                        <div class="trending-image d-flex align-items-center justify-content-center w-100" style="background-color: {{ $trend->color }}">
                            <div class="icon mb-3">
                                <img src="{{ $trend->getIcon() }}" width="10" class="img-cover" alt="{{ $trend->category->title }}">
                            </div>
                        </div>

                        <div class="item-count px-10 px-lg-20 py-5 py-lg-10">{{ $trend->category->webinars_count }} {{ trans('product.course') }}</div>

                        <h3>{{ $trend->category->title }}</h3>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="swiper-pagination trend-categories-swiper-pagination"></div>
    </div>
</section>
@endif

{{-- Ads Bannaer --}}
@if($homeSection->name == \App\Models\HomeSection::$full_advertising_banner and !empty($advertisingBanners1) and count($advertisingBanners1))
<div class="home-sections container">
    <div class="row">
        @foreach($advertisingBanners1 as $banner1)
        <div class="col-{{ $banner1->size }}">
            <a href="{{ $banner1->link }}">
                <img src="{{ $banner1->image }}" class="img-cover rounded-sm" alt="{{ $banner1->title }}">
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif
{{-- ./ Ads Bannaer --}}

@if($homeSection->name == \App\Models\HomeSection::$best_sellers and !empty($bestSaleWebinars) and !$bestSaleWebinars->isEmpty())
<section class="home-sections container">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="section-title">{{ trans('home.best_sellers') }}</h2>
            <p class="section-hint">{{ trans('home.best_sellers_hint') }}</p>
        </div>

        <a href="/classes?sort=bestsellers" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container best-sales-webinars-swiper px-12">
            <div class="swiper-wrapper py-20">
                @foreach($bestSaleWebinars as $bestSaleWebinar)
                <div class="swiper-slide">
                    @include('web.default.includes.webinar.grid-card',['webinar' => $bestSaleWebinar])
                </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination best-sales-webinars-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$discount_classes and !empty($hasDiscountWebinars) and !$hasDiscountWebinars->isEmpty())
<section class="home-sections container">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="section-title">{{ trans('home.discount_classes') }}</h2>
            <p class="section-hint">{{ trans('home.discount_classes_hint') }}</p>
        </div>

        <a href="/classes?discount=on" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container has-discount-webinars-swiper px-12">
            <div class="swiper-wrapper py-20">
                @foreach($hasDiscountWebinars as $hasDiscountWebinar)
                <div class="swiper-slide">
                    @include('web.default.includes.webinar.grid-card',['webinar' => $hasDiscountWebinar])
                </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination has-discount-webinars-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$free_classes and !empty($freeWebinars) and !$freeWebinars->isEmpty())
<section class="home-sections home-sections-swiper container">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="section-title">{{ trans('home.free_classes') }}</h2>
            <p class="section-hint">{{ trans('home.free_classes_hint') }}</p>
        </div>

        <a href="/classes?free=on" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container free-webinars-swiper px-12">
            <div class="swiper-wrapper py-20">

                @foreach($freeWebinars as $freeWebinar)
                <div class="swiper-slide">
                    @include('web.default.includes.webinar.grid-card',['webinar' => $freeWebinar])
                </div>
                @endforeach

            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination free-webinars-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$store_products and !empty($newProducts) and !$newProducts->isEmpty())
<section class="home-sections home-sections-swiper container">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="section-title">{{ trans('update.store_products') }}</h2>
            <p class="section-hint">{{ trans('update.store_products_hint') }}</p>
        </div>

        <a href="/products" class="btn btn-border-white">{{ trans('update.all_products') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container new-products-swiper px-12">
            <div class="swiper-wrapper py-20">

                @foreach($newProducts as $newProduct)
                <div class="swiper-slide">
                    @include('web.default.products.includes.card',['product' => $newProduct])
                </div>
                @endforeach

            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination new-products-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif


@if($homeSection->name == \App\Models\HomeSection::$testimonials and !empty($testimonials) and !$testimonials->isEmpty())
<div class="position-relative home-sections testimonials-container">

    <div id="parallax1" class="ltr">
        <div data-depth="0.2" class="gradient-box left-gradient-box"></div>
    </div>

    <section class="container home-sections home-sections-swiper">
        <div class="text-center my-40">
            <h2 class="section-title">عملائنا</h2>
            <p class="section-hint"></p>
        </div>

        <div class="position-relative mt-20">
            <div class="swiper-container organization-swiper-container px-12">
                <div class="swiper-wrapper py-20">



                    <div class="swiper-slide">

                        <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                            <div class="home-organizations-avatar">
                                <img src="https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeaca39a58.jpeg" class="img-cover " alt="">
                            </div>



                            <div class="bottom-gradient"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">

                        <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                            <div class="home-organizations-avatar">
                                <img src="https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfefa364dfb.jpeg" class="img-cover" alt="">
                            </div>



                            <div class="bottom-gradient"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">

                        <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                            <div class="home-organizations-avatar">
                                <img src="https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfea64e8494.jpeg" class="img-cover" alt="">
                            </div>



                            <div class="bottom-gradient"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">

                        <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                            <div class="home-organizations-avatar">
                                <img src="https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeac220c6e.jpeg" class="img-cover" alt="">
                            </div>



                            <div class="bottom-gradient"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">

                        <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                            <div class="home-organizations-avatar">
                                <img src="https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeb708b082.png" class="img-cover" alt="">
                            </div>



                            <div class="bottom-gradient"></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-center">
                <div class="swiper-pagination organization-swiper-pagination"></div>
            </div>
        </div>
    </section>

    <div id="parallax2" class="ltr">
        <div data-depth="0.4" class="gradient-box right-gradient-box"></div>
    </div>

    <div id="parallax3" class="ltr">
        <div data-depth="0.8" class="gradient-box bottom-gradient-box"></div>
    </div>
</div>
@endif


@if($homeSection->name == \App\Models\HomeSection::$subscribes and !empty($subscribes) and !$subscribes->isEmpty())
<div class="home-sections position-relative subscribes-container pe-none user-select-none">
    <div id="parallax4" class="ltr d-none d-md-block">
        <div data-depth="0.2" class="gradient-box left-gradient-box"></div>
    </div>

    <section class="container home-sections home-sections-swiper">
        <div class="text-center">
            <h2 class="section-title">{{ trans('home.subscribe_now') }}</h2>
            <p class="section-hint">{{ trans('home.subscribe_now_hint') }}</p>
        </div>

        <div class="position-relative mt-30">
            <div class="swiper-container subscribes-swiper px-12">
                <div class="swiper-wrapper py-20">

                    @foreach($subscribes as $subscribe)
                    @php
                    $subscribeSpecialOffer = $subscribe->activeSpecialOffer();
                    @endphp

                    <div class="swiper-slide">
                        <div class="subscribe-plan position-relative bg-white d-flex flex-column align-items-center rounded-sm shadow pt-50 pb-20 px-20">
                            @if($subscribe->is_popular)
                            <span class="badge badge-primary badge-popular px-15 py-5">{{ trans('panel.popular') }}</span>
                            @elseif(!empty($subscribeSpecialOffer))
                            <span class="badge badge-danger badge-popular px-15 py-5">{{ trans('update.percent_off', ['percent' => $subscribeSpecialOffer->percent]) }}</span>
                            @endif

                            <div class="plan-icon">
                                <img src="{{ $subscribe->icon }}" class="img-cover" alt="">
                            </div>

                            <h3 class="mt-20 font-30 text-secondary">{{ $subscribe->title }}</h3>
                            <p class="font-weight-500 text-gray mt-10">{{ $subscribe->description }}</p>

                            <div class="d-flex align-items-start mt-30">
                                @if(!empty($subscribe->price) and $subscribe->price > 0)
                                @if(!empty($subscribeSpecialOffer))
                                <div class="d-flex align-items-end line-height-1">
                                    <span class="font-36 text-primary">{{ handlePrice($subscribe->getPrice(), true, true, false, null, true) }}</span>
                                    <span class="font-14 text-gray ml-5 text-decoration-line-through">{{ handlePrice($subscribe->price, true, true, false, null, true) }}</span>
                                </div>
                                @else
                                <span class="font-36 text-primary line-height-1">{{ handlePrice($subscribe->price, true, true, false, null, true) }}</span>
                                @endif
                                @else
                                <span class="font-36 text-primary line-height-1">{{ trans('public.free') }}</span>
                                @endif
                            </div>

                            <ul class="mt-20 plan-feature">
                                <li class="mt-10">{{ $subscribe->days }} {{ trans('financial.days_of_subscription') }}</li>
                                <li class="mt-10">
                                    @if($subscribe->infinite_use)
                                    {{ trans('update.unlimited') }}
                                    @else
                                    {{ $subscribe->usable_count }}
                                    @endif
                                    <span class="ml-5">{{ trans('update.subscribes') }}</span>
                                </li>
                            </ul>

                            @if(auth()->check())
                            <form action="/panel/financial/pay-subscribes" method="post" class="w-100">
                                {{ csrf_field() }}
                                <input name="amount" value="{{ $subscribe->price }}" type="hidden">
                                <input name="id" value="{{ $subscribe->id }}" type="hidden">

                                <div class="d-flex align-items-center mt-50 w-100">
                                    <button type="submit" class="btn btn-primary {{ !empty($subscribe->has_installment) ? '' : 'btn-block' }}">{{ trans('update.purchase') }}</button>

                                    @if(!empty($subscribe->has_installment))
                                    <a href="/panel/financial/subscribes/{{ $subscribe->id }}/installments" class="btn btn-outline-primary flex-grow-1 ml-10">{{ trans('update.installments') }}</a>
                                    @endif
                                </div>
                            </form>
                            @else
                            <a href="/login" class="btn btn-primary btn-block mt-50">{{ trans('update.purchase') }}</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
            <div class="d-flex justify-content-center">
                <div class="swiper-pagination subscribes-swiper-pagination"></div>
            </div>

        </div>
    </section>

    <div id="parallax5" class="ltr d-none d-md-block">
        <div data-depth="0.4" class="gradient-box right-gradient-box"></div>
    </div>

    <div id="parallax6" class="ltr d-none d-md-block">
        <div data-depth="0.6" class="gradient-box bottom-gradient-box"></div>
    </div>
</div>
@endif

@if($homeSection->name == \App\Models\HomeSection::$find_instructors and !empty($findInstructorSection))
<section class="home-sections home-sections-swiper container find-instructor-section position-relative">
    <div class="row align-items-center">
        <div class="col-12 col-lg-6">
            <div class="">
                <h2 class="font-36 font-weight-bold text-dark">{{ $findInstructorSection['title'] ?? '' }}</h2>
                <p class="font-16 font-weight-normal text-gray mt-10">{{ $findInstructorSection['description'] ?? '' }}</p>

                <div class="mt-35 d-flex align-items-center">
                    @if(!empty($findInstructorSection['button1']) and !empty($findInstructorSection['button1']['title']) and !empty($findInstructorSection['button1']['link']))
                    <a href="{{ $findInstructorSection['button1']['link'] }}" class="btn btn-primary mr-15">{{ $findInstructorSection['button1']['title'] }}</a>
                    @endif

                    @if(!empty($findInstructorSection['button2']) and !empty($findInstructorSection['button2']['title']) and !empty($findInstructorSection['button2']['link']))
                    <a href="{{ $findInstructorSection['button2']['link'] }}" class="btn btn-outline-primary">{{ $findInstructorSection['button2']['title'] }}</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mt-20 mt-lg-0">
            <div class="position-relative ">
                <img src="{{ $findInstructorSection['image'] }}" class="find-instructor-section-hero" alt="{{ $findInstructorSection['title'] }}">
                <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle">
                <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots">

                <div class="example-instructor-card bg-white rounded-sm shadow-lg  p-5 p-md-15 d-flex align-items-center">
                    <div class="example-instructor-card-avatar">
                        <img src="/assets/default/img/home/toutor_finder.svg" class="img-cover rounded-circle" alt="user name">
                    </div>

                    <div class="flex-grow-1 ml-15">
                        <span class="font-14 font-weight-bold text-secondary d-block">{{ trans('update.looking_for_an_instructor') }}</span>
                        <span class="text-gray font-12 font-weight-500">{{ trans('update.find_the_best_instructor_now') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$reward_program and !empty($rewardProgramSection))
<section class="home-sections home-sections-swiper container reward-program-section position-relative">
    <div class="row align-items-center">
        <div class="col-12 col-lg-6">
            <div class="position-relative reward-program-section-hero-card">
                <img src="{{ $rewardProgramSection['image'] }}" class="reward-program-section-hero" alt="{{ $rewardProgramSection['title'] }}">

                <div class="example-reward-card bg-white rounded-sm shadow-lg p-5 p-md-15 d-flex align-items-center">
                    <div class="example-reward-card-medal">
                        <img src="/assets/default/img/rewards/medal.png" class="img-cover rounded-circle" alt="medal">
                    </div>

                    <div class="flex-grow-1 ml-15">
                        <span class="font-14 font-weight-bold text-secondary d-block">{{ trans('update.you_got_50_points') }}</span>
                        <span class="text-gray font-12 font-weight-500">{{ trans('update.for_completing_the_course') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mt-20 mt-lg-0">
            <div class="">
                <h2 class="font-36 font-weight-bold text-dark">{{ $rewardProgramSection['title'] ?? '' }}</h2>
                <p class="font-16 font-weight-normal text-gray mt-10">{{ $rewardProgramSection['description'] ?? '' }}</p>

                <div class="mt-35 d-flex align-items-center">
                    @if(!empty($rewardProgramSection['button1']) and !empty($rewardProgramSection['button1']['title']) and !empty($rewardProgramSection['button1']['link']))
                    <a href="{{ $rewardProgramSection['button1']['link'] }}" class="btn btn-primary mr-15">{{ $rewardProgramSection['button1']['title'] }}</a>
                    @endif

                    @if(!empty($rewardProgramSection['button2']) and !empty($rewardProgramSection['button2']['title']) and !empty($rewardProgramSection['button2']['link']))
                    <a href="{{ $rewardProgramSection['button2']['link'] }}" class="btn btn-outline-primary">{{ $rewardProgramSection['button2']['title'] }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$become_instructor and !empty($becomeInstructorSection))
<section class="home-sections home-sections-swiper container find-instructor-section position-relative">
    <div class="row align-items-center">
        <div class="col-12 col-lg-6">
            <div class="">
                <h2 class="font-36 font-weight-bold text-dark">{{ $becomeInstructorSection['title'] ?? '' }}</h2>
                <p class="font-16 font-weight-normal text-gray mt-10">{{ $becomeInstructorSection['description'] ?? '' }}</p>

                <div class="mt-35 d-flex align-items-center">
                    @if(!empty($becomeInstructorSection['button1']) and !empty($becomeInstructorSection['button1']['title']) and !empty($becomeInstructorSection['button1']['link']))
                    <a href="{{ empty($authUser) ? '/login' : (($authUser->isUser()) ? $becomeInstructorSection['button1']['link'] : '/panel/financial/registration-packages') }}" class="btn btn-primary mr-15">{{ $becomeInstructorSection['button1']['title'] }}</a>
                    @endif

                    @if(!empty($becomeInstructorSection['button2']) and !empty($becomeInstructorSection['button2']['title']) and !empty($becomeInstructorSection['button2']['link']))
                    <a href="{{ empty($authUser) ? '/login' : (($authUser->isUser()) ? $becomeInstructorSection['button2']['link'] : '/panel/financial/registration-packages') }}" class="btn btn-outline-primary">{{ $becomeInstructorSection['button2']['title'] }}</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mt-20 mt-lg-0">
            <div class="position-relative ">
                <img src="{{ $becomeInstructorSection['image'] }}" class="find-instructor-section-hero" alt="{{ $becomeInstructorSection['title'] }}">
                <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle">
                <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots">

                <div class="example-instructor-card bg-white rounded-sm shadow-lg border p-5 p-md-15 d-flex align-items-center">
                    <div class="example-instructor-card-avatar">
                        <img src="/assets/default/img/home/become_instructor.svg" class="img-cover rounded-circle" alt="user name">
                    </div>

                    <div class="flex-grow-1 ml-15">
                        <span class="font-14 font-weight-bold text-secondary d-block">{{ trans('update.become_an_instructor') }}</span>
                        <span class="text-gray font-12 font-weight-500">{{ trans('update.become_instructor_tagline') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$forum_section and !empty($forumSection))
<section class="home-sections home-sections-swiper container find-instructor-section position-relative">
    <div class="row align-items-center">
        <div class="col-12 col-lg-6 mt-20 mt-lg-0">
            <div class="position-relative ">
                <img src="{{ $forumSection['image'] }}" class="find-instructor-section-hero" alt="{{ $forumSection['title'] }}">
                <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle">
                <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots">
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="">
                <h2 class="font-36 font-weight-bold text-dark">{{ $forumSection['title'] ?? '' }}</h2>
                <p class="font-16 font-weight-normal text-gray mt-10">{{ $forumSection['description'] ?? '' }}</p>

                <div class="mt-35 d-flex align-items-center">
                    @if(!empty($forumSection['button1']) and !empty($forumSection['button1']['title']) and !empty($forumSection['button1']['link']))
                    <a href="{{ $forumSection['button1']['link'] }}" class="btn btn-primary mr-15">{{ $forumSection['button1']['title'] }}</a>
                    @endif

                    @if(!empty($forumSection['button2']) and !empty($forumSection['button2']['title']) and !empty($forumSection['button2']['link']))
                    <a href="{{ $forumSection['button2']['link'] }}" class="btn btn-outline-primary">{{ $forumSection['button2']['title'] }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$video_or_image_section and !empty($boxVideoOrImage))
<section class="home-sections home-sections-swiper position-relative">
    <div class="home-video-mask"></div>
    <div class="container home-video-container d-flex flex-column align-items-center justify-content-center position-relative" style="background-image: url('{{ $boxVideoOrImage['background'] ?? '' }}')">
        <a href="{{ $boxVideoOrImage['link'] ?? '' }}" class="home-video-play-button d-flex align-items-center justify-content-center position-relative">
            <i data-feather="play" width="36" height="36" class=""></i>
        </a>

        <div class="mt-50 pt-10 text-center">
            <h2 class="home-video-title">{{ $boxVideoOrImage['title'] ?? '' }}</h2>
            <p class="home-video-hint mt-10">{{ $boxVideoOrImage['description'] ?? '' }}</p>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$instructors and !empty($instructors) and !$instructors->isEmpty())
<section class="home-sections container">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="section-title">شركائنا</h2>
            <p class="section-hint"></p>
        </div>


    </div>

    <div class="position-relative mt-20 ltr">
        <div class="owl-carousel customers-testimonials instructors-swiper-container">


            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://ejaabi.com/public/uploads/main/images/02-12-2023/656ae01bdedbe.jpeg" alt="" class="img-cover">
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://ejaabi.com/public/uploads/main/images/02-12-2023/656ae4cda1168.png" alt="" class="img-cover">
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://ejaabi.com/public/uploads/main/images/27-12-2023/658c10b1e31d2.png" alt="" class=" img-cover">
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://ejaabi.com/public/uploads/main/images/04-12-2023/656e2faf5e7a3.jpeg" alt="" class=" img-cover">
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://ejaabi.com/public/uploads/main/images/19-05-2024/6649ba3691866.jpg" alt="" class=" img-cover">
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://ejaabi.com/public/uploads/main/images/19-05-2024/6649bdb36f0cd.png" alt="" class=" img-cover">
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
@endif

{{-- Ads Bannaer --}}
@if($homeSection->name == \App\Models\HomeSection::$half_advertising_banner and !empty($advertisingBanners2) and count($advertisingBanners2))
<div class="home-sections container">
    <div class="row">
        @foreach($advertisingBanners2 as $banner2)
        <div class="col-{{ $banner2->size }}">
            <a href="{{ $banner2->link }}">
                <img src="{{ $banner2->image }}" class="img-cover rounded-sm" alt="{{ $banner2->title }}">
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif
{{-- ./ Ads Bannaer --}}

@if($homeSection->name == \App\Models\HomeSection::$organizations and !empty($organizations) and !$organizations->isEmpty())
<section class="home-sections home-sections-swiper container">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="section-title">{{ trans('home.organizations') }}</h2>
            <p class="section-hint">{{ trans('home.organizations_hint') }}</p>
        </div>

        <a href="/organizations" class="btn btn-border-white">{{ trans('home.all_organizations') }}</a>
    </div>

    <div class="position-relative mt-20">
        <div class="swiper-container organization-swiper-container px-12">
            <div class="swiper-wrapper py-20">

                @foreach($organizations as $organization)
                <div class="swiper-slide">
                    <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                        <div class="home-organizations-avatar">
                            <img src="{{ $organization->getAvatar(120) }}" class="img-cover rounded-circle" alt="{{ $organization->full_name }}">
                        </div>
                        <a href="{{ $organization->getProfileUrl() }}" class="mt-25 d-flex flex-column align-items-center justify-content-center">
                            <h3 class="home-organizations-title">{{ $organization->full_name }}</h3>
                            <p class="home-organizations-desc mt-10">{{ $organization->bio }}</p>
                            <span class="home-organizations-badge badge mt-15">{{ $organization->webinars_count }} {{ trans('panel.classes') }}</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination organization-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$blog and !empty($blog) and !$blog->isEmpty())
<section class="home-sections container">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="section-title">{{ trans('home.blog') }}</h2>
            <p class="section-hint">{{ trans('home.blog_hint') }}</p>
        </div>

        <a href="/blog" class="btn btn-border-white">{{ trans('home.all_blog') }}</a>
    </div>

    <div class="row mt-35">

        @foreach($blog as $post)
        <div class="col-12 col-md-4 col-lg-4 mt-20 mt-lg-0">
            @include('web.default.blog.grid-list',['post' =>$post])
        </div>
        @endforeach

    </div>
</section>
@endif

@endforeach
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
<script src="/assets/default/js/parts/home.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const heroSlider = new Swiper('.hero-slider', {
            effect: 'fade',
            speed: 1000,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination', // Keep this for default pagination (dots)
                clickable: true,
            },
            on: {
                init: function() {
                    updateProgress(this);
                },
                slideChange: function() {
                    updateProgress(this);
                },
            }
        });
    
        // Add event listeners to custom navigation buttons
        document.querySelectorAll('.customised-pagination-bullet').forEach((bullet, index) => {
            bullet.addEventListener('click', () => {
                heroSlider.slideTo(index);
            });
        });
    
        // Update active state for custom buttons
        heroSlider.on('slideChange', function() {
            document.querySelectorAll('.customised-pagination-bullet').forEach((bullet, index) => {
                if (index === heroSlider.activeIndex) {
                    bullet.classList.add('customised-pagination-bullet-active');
                } else {
                    bullet.classList.remove('customised-pagination-bullet-active');
                }
            });
        });
    
        function updateProgress(swiper) {
            const progress = document.querySelector('.progress-bar');
            progress.style.width = '0%';
    
            setTimeout(() => {
                progress.style.width = '100%';
            }, 100);
        }
    });
</script>
@endpush
