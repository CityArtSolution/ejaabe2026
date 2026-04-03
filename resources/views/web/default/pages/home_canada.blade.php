@extends(getTemplate().'.layouts.canada_app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
<style>
    .hero-slider .flickity-page-dots .dot {
    width: 30px;
    height: 4px;
    opacity: 1;
    background: rgba(255, 255, 255, 0.5);
    border: 0 solid white;
    border-radius: 0;
}
.hero-slider .flickity-page-dots {
    bottom: 30px;
}
.flickity-page-dots {
    position: absolute;
    width: 100%;
    bottom: -25px;
    padding: 0;
    margin: 0;
    list-style: none;
    text-align: center;
    line-height: 1;
}
.flickity-page-dots .dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    margin: 0 8px;
    background: #333;
    border-radius: 50%;
    opacity: .25;
    cursor: pointer;
}
.hero-slider .flickity-page-dots .dot.is-selected {
    background: #ff0000;
    border: 0 solid #ff0000;
}
.hero-btn-primary {
    background: #ff0000;
}
.hero-content::before {
        background: #ff0000;
}
.progress-bar {
   
    background: #ff0000;
}
.modern-services-area .item::before {
        background: #ff0000;
}
.modern-services-area .item .icon i {
    color:#ff0000;
}
.home-sections .section-title {
    color:#ff0000;
}
#whatsapp_chat_widget
Specificity: (1,0,0)
 {
    display: block;
}
#wa-widget-send-button-no-text {
    margin: 0 0 20px 0 !important;
    padding-left: 0px;
    padding-right: 0px;
    position: fixed !important;
    z-index: 16000160 !important;
    bottom: 0 !important;
    text-align: center !important;
    height: 68px;
    min-width: 68px;
    border-radius: 34px;
    visibility: visible;
    transition: none !important;
    background-color: #13C656;
    box-shadow: rgb(0 0 0 / 10%) 0px 12px 24px 0px;
    right: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
.wa-messenger-svg-whatsapp {
    fill: white;
    width: 41px;
    height: 50px;
}
.wa-chat-box-no-text {
    background-color: white;
    z-index: 16000160 !important;
    margin-bottom: 80px;
    width: 335px;
    position: fixed !important;
    bottom: 20px !important;
    right: 20px;
    border-radius: 10px;
    box-shadow: rgb(0 0 0 / 10%) 0px 12px 24px 0px;
    font: 400 normal 15px / 1.3 -apple-system, BlinkMacSystemFont, Roboto, Open Sans, Helvetica Neue, sans-serif;
}
.wa-chat-box-header {
    height: 100px;
    max-height: 100px;
    min-height: 100px;
    background-color: #3eb069;
        color: white;
    border-radius: 10px 10px 0px 0px;
    display: flex;
    align-items: center;
}
.wa-chat-box-brand-container {
    margin-bottom: -14px;
}
.wa-chat-box-brand {
    margin: 0 16px;
    width: 53px;
    height: auto;
    border-radius: 50%;
    box-shadow: rgb(0 0 0 / 10%) 0px 12px 24px 0px;
}
.wa-chat-box-brand-indicator
Specificity: (0,1,0)
 {
    bottom: 15px;
    left: 65px;
    width: 12px;
    height: 12px;
    box-sizing: border-box;
    background-color: rgb(74, 213, 4);
    display: block;
    position: relative;
    z-index: 1;
    border-radius: 50%;
    border: 2px solid #085E54;
}
.wa-chat-box-brand-text {
    margin-left: 20px;
}
.wa-chat-box-brand-name {
    font-size: 16px;
    font-weight: 700;
    padding-right: 10px;
    line-height: 20px;
}
.wa-chat-box-brand-subtitle
Specificity: (0,1,0)
 {
    font-size: 13px;
    line-height: 18px;
    margin-top: 4px;
    opacity: 0.8;
}
.wa-chat-bubble-close-btn
Specificity: (0,1,0)
 {
    cursor: pointer;
    position: absolute;
    right: 20px;
    top: 20px;
}
.wa-chat-box-content {
    background: url(https://widget.bot.space/images/whatsapp-background.png);
    background-color: rgb(230, 221, 212);
}
.wa-chat-box-content-chat {
    background-color: white;
    display: inline-block;
    margin: 20px;
    padding: 10px;
    border-radius: 10px;
}
.wa-chat-box-send {
    background-color: white;
}
.wa-chat-box-content-send-btn {
    text-decoration: none;
    color: rgb(255, 255, 255);
    font-size: 15px;
    font-weight: 700;
    line-height: 25px;
    cursor: pointer;
    position: relative;
    display: flex;
    gap:6px;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
    -webkit-appearance: none;
    padding: 8px 12px;
    border-radius: 25px;
    border-width: initial;
    border-style: none;
    border-color: initial;
    border-image: initial;
    background-color: #13C656;
    margin: 20px;
    overflow: hidden;
}
.wa-chat-box-poweredby {
    display: none !important;
}
.wa-chat-box-poweredby
Specificity: (0,1,0)
 {
    text-align: center;
    font: 400 normal 15px / 1.3 -apple-system, BlinkMacSystemFont, Roboto, Open Sans, Helvetica Neue, sans-serif;
    margin-bottom: 15px;
    margin-top: -10px;
    font-style: italic;
    font-size: 12px;
    color: lightgray;
}
.wa-chat-box-poweredby {
    display: none !important;
}
.wa-chat-box-content-send-btn-icon{
    fill: white;
}
a:hover {
    color: #343434 !important;
    text-decoration: underline !important;
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
        @php
$sliders_ = $sliders->slice(0, $sliders->count() );
        @endphp

           <div class="swiper-wrapper" style="padding-bottom:50px">
  @foreach ($sliders_ as $slider)
    <div class="swiper-slide">
        <div class="hero-slide" style="background-image: url('{{ asset($slider->image) }}')">
            <div class="hero-content">
                <h1 class="hero-title">{{ $slider->title }}</h1>
                <p class="hero-description">{{ $slider->description }}</p>

                <div class="hero-buttons">
                    @if(!empty($slider->button1_title) && !empty($slider->button1_link))
                        <a href="{{ $slider->button1_link }}" class="hero-btn hero-btn-primary" target="_blank">
                            <span>{{ $slider->button1_title }}</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endif

                    @if(!empty($slider->button2_title) && !empty($slider->button2_link))
                        <a href="{{ $slider->button2_link }}" class="hero-btn hero-btn-secondary" target="_blank">
                            <span>{{ $slider->button2_title }}</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 16v-4M12 8h.01" />
                            </svg>
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endforeach

</div>


    <!-- Navigation -->
    <div class="customised-slider-nav-wrapper">
        <div class="customised-pagination">
           <ol class="flickity-page-dots"> 
            @foreach ($sliders as $index => $slider)
            <li class="dot"   data-slide-index="{{ $index }}" title="{{ $slider->title }}">
            </li>
           
            @endforeach
            </ol>
        </div>
    </div>
</section>
@endif



<section class="home-sections home-sections-swiper container">
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-2 my-40">
                    <div class="site-heading text-center">
                        <h4>{{ __('messages.why_learn') }}</h4>
                        <h2>{{ __('messages.many_courses') }}</h2>
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
                                    <h4>01</h4>
                                    <p>{{ __('messages.point_1') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="single-item col-6 col-md-4">
                            <div class="item noground">
                                <div class="icon">
                                    <i class="flaticon-result"></i>
                                </div>
                                <div class="content">
                                    <h4>02</h4>
                                    <p>{{ __('messages.point_2') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="single-item col-6 col-md-4">
                            <div class="item noground">
                                <div class="icon">
                                    <i class="flaticon-meeting"></i>
                                </div>
                                <div class="content">
                                    <h4>03</h4>
                                    <p>{{ __('messages.point_3') }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@foreach($homeSections as $homeSection)

@if($homeSection->name == \App\Models\HomeSection::$trend_categories and !empty($trendCategories) and !$trendCategories->isEmpty())
<!--<section class="home-sections home-sections-swiper container">
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
</section>-->
@endif

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
                                            <span class="real">{{ handlePrice($feature->webinar->bestTicket(), true, true, false, null, true, null) }} {{getBranchCurrency(3)}}</span>
                                            @else
                                            {{ handlePrice($feature->webinar->price, true, true, false, null, true, null) }} {{ getBranchCurrency(3) }}
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

        <a href="/en/canada/classes?sort=newest" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="latest-webinars-swiper px-12">
           <div class="row mt-20">
                    
                @foreach($latestWebinars->slice(0, 6) as $latestWebinar)
                
                <div class="col-12 col-lg-6">
                    @include('web.default.includes.webinar.list-card',['webinar' => $latestWebinar])
                </div>
                @endforeach

            </div>
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



@if($homeSection->name == \App\Models\HomeSection::$testimonials and !empty($testimonials) and !$testimonials->isEmpty())
<div class="position-relative home-sections testimonials-container">

    <div id="parallax1" class="ltr">
        <div data-depth="0.2" class="gradient-box left-gradient-box"></div>
    </div>

    <section class="container home-sections home-sections-swiper">
        <div class="text-center my-40">
            <h2 class="section-title">{{trans('app.clients')}} </h2>
            <p class="section-hint"></p>
        </div>

        <div class="position-relative mt-20">
            <div class="swiper-container organization-swiper-container px-12">
                <div class="swiper-wrapper py-20">



                    <div class="swiper-slide">

                        <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                            <div class="home-organizations-avatar">
                                <img src="https://canada.ejaabi.com/public/uploads/main/images/10-09-2024/66dfec472cf2d.png" class="img-cover " alt="">
                            </div>



                            <div class="bottom-gradient"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">

                        <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                            <div class="home-organizations-avatar">
                                <img src="https://canada.ejaabi.com/public/uploads/main/images/09-09-2024/66df29d33d845.jpeg" class="img-cover" alt=""      style="object-fit: contain; width: 100%; height: 100%;" />
                            </div>



                            <div class="bottom-gradient"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">

                        <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                            <div class="home-organizations-avatar">
                                <img src="https://canada.ejaabi.com/public/uploads/main/images/10-09-2024/66dfec5251fe1.png" class="img-cover"      style="object-fit: contain; width: 100%; height: 100%;" alt="">
                            </div>



                            <div class="bottom-gradient"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">

                        <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                            <div class="home-organizations-avatar">
                                <img src="https://canada.ejaabi.com/public/uploads/main/images/10-09-2024/66dfec66afcda.png" class="img-cover"     style="object-fit: contain; width: 100%; height: 100%;"  alt="">
                            </div>



                            <div class="bottom-gradient"></div>
                        </div>
                    </div>
                    <!--<div class="swiper-slide">-->

                    <!--    <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">-->
                    <!--        <div class="home-organizations-avatar">-->
                    <!--            <img src="https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeb708b082.png" class="img-cover" alt="">-->
                    <!--        </div>-->



                    <!--        <div class="bottom-gradient"></div>-->
                    <!--    </div>-->
                    <!--</div>-->
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
<section class="home-sections container" >
    <div class="text-center my-40">
        <div>
            <h2 class="section-title">{{trans('app.comapny')}} </h2>
            <p class="section-hint"></p>
        </div>


    </div>

    <div class="position-relative mt-20 ltr">
        <div class="owl-carousel customers-testimonials instructors-swiper-container">


            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://canada.ejaabi.com/public/uploads/main/images/22-05-2024/664d96b0442a6.jpeg" alt="" class="img-cover">
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
                            <img src="https://canada.ejaabi.com/public/uploads/main/images/22-05-2024/664d96d1d67c1.png" alt=""      style="object-fit: contain; width: 100%; height: 100%;" />
>
                            
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
                            <img src="https://canada.ejaabi.com/public/uploads/main/images/22-05-2024/664d96deb01c4.png" alt=""      style="object-fit: contain; width: 100%; height: 100%;" />
>
                            
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
                            <img src="https://canada.ejaabi.com/public/uploads/main/images/02-12-2023/656ae1e67060d.jpeg" alt="" class=" img-cover">
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
<img src="https://canada.ejaabi.com/public/uploads/main/images/27-12-2023/658c10b1e31d2.png" 
     alt="" 
     style="object-fit: contain; width: 100%; height: 100%;" />
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
@endforeach
<div id="whatsapp_chat_widget">
                <div id="wa-widget-send-button-no-text">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" class="wa-messenger-svg-whatsapp wh-svg-icon"><path d=" M19.11 17.205c-.372 0-1.088 1.39-1.518 1.39a.63.63 0 0 1-.315-.1c-.802-.402-1.504-.817-2.163-1.447-.545-.516-1.146-1.29-1.46-1.963a.426.426 0 0 1-.073-.215c0-.33.99-.945.99-1.49 0-.143-.73-2.09-.832-2.335-.143-.372-.214-.487-.6-.487-.187 0-.36-.043-.53-.043-.302 0-.53.115-.746.315-.688.645-1.032 1.318-1.06 2.264v.114c-.015.99.472 1.977 1.017 2.78 1.23 1.82 2.506 3.41 4.554 4.34.616.287 2.035.888 2.722.888.817 0 2.15-.515 2.478-1.318.13-.33.244-.73.244-1.088 0-.058 0-.144-.03-.215-.1-.172-2.434-1.39-2.678-1.39zm-2.908 7.593c-1.747 0-3.48-.53-4.942-1.49L7.793 24.41l1.132-3.337a8.955 8.955 0 0 1-1.72-5.272c0-4.955 4.04-8.995 8.997-8.995S25.2 10.845 25.2 15.8c0 4.958-4.04 8.998-8.998 8.998zm0-19.798c-5.96 0-10.8 4.842-10.8 10.8 0 1.964.53 3.898 1.546 5.574L5 27.176l5.974-1.92a10.807 10.807 0 0 0 16.03-9.455c0-5.958-4.842-10.8-10.802-10.8z" fill-rule="evenodd"></path></svg>
                </div>
            
            <div class="wa-chat-box-no-text" id="wa-chat-box-no-text" style="display: none;">
                <div class="wa-chat-box-header">
                    <div class="wa-chat-box-brand-container">
                        <img class="wa-chat-box-brand" onerror="this.src= &quot;https://widget.bot.space/images/BotSpaceLogoLight.png&quot;;" src="public/uploads/main/images/09-12-2023/657400958cf84.png">
                        <div class="wa-chat-box-brand-indicator"></div>
                    </div>
                    <div class="wa-chat-box-brand-text">
                        <div class="wa-chat-box-brand-name">Positive Interacgion For Training</div>
                        <div class="wa-chat-box-brand-subtitle"></div>
                    </div>
                    <div class="wa-chat-bubble-close-btn" id="wa-chat-bubble-close-btn" style="position: absolute;top: 15px;right: 13px;cursor:pointer"><img style="display: table-row" src="https://widget.bot.space/images/close-icon.png"></div>
                </div>
                
                <div class="wa-chat-box-content">
                    <div class="wa-chat-box-content-chat">                            
                        <div class="wa-chat-box-content-chat-brand">Positive Interacgion For Training</div>
                        <div class="wa-chat-box-content-chat-welcome">hi there<br>How can i help you ?</div>
                    </div>
                </div>
                
                <div class="wa-chat-box-send">
                    <a role="button" target="_blank" href="https://wa.me/+12267003361" title="WhatsApp" class="wa-chat-box-content-send-btn"><svg width="20" height="20" viewBox="0 0 90 90" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" class="wa-chat-box-content-send-btn-icon"><path d="M90,43.841c0,24.213-19.779,43.841-44.182,43.841c-7.747,0-15.025-1.98-21.357-5.455L0,90l7.975-23.522   c-4.023-6.606-6.34-14.354-6.34-22.637C1.635,19.628,21.416,0,45.818,0C70.223,0,90,19.628,90,43.841z M45.818,6.982   c-20.484,0-37.146,16.535-37.146,36.859c0,8.065,2.629,15.534,7.076,21.61L11.107,79.14l14.275-4.537   c5.865,3.851,12.891,6.097,20.437,6.097c20.481,0,37.146-16.533,37.146-36.857S66.301,6.982,45.818,6.982z M68.129,53.938   c-0.273-0.447-0.994-0.717-2.076-1.254c-1.084-0.537-6.41-3.138-7.4-3.495c-0.993-0.358-1.717-0.538-2.438,0.537   c-0.721,1.076-2.797,3.495-3.43,4.212c-0.632,0.719-1.263,0.809-2.347,0.271c-1.082-0.537-4.571-1.673-8.708-5.333   c-3.219-2.848-5.393-6.364-6.025-7.441c-0.631-1.075-0.066-1.656,0.475-2.191c0.488-0.482,1.084-1.255,1.625-1.882   c0.543-0.628,0.723-1.075,1.082-1.793c0.363-0.717,0.182-1.344-0.09-1.883c-0.27-0.537-2.438-5.825-3.34-7.977   c-0.902-2.15-1.803-1.792-2.436-1.792c-0.631,0-1.354-0.09-2.076-0.09c-0.722,0-1.896,0.269-2.889,1.344   c-0.992,1.076-3.789,3.676-3.789,8.963c0,5.288,3.879,10.397,4.422,11.113c0.541,0.716,7.49,11.92,18.5,16.223   C58.2,65.771,58.2,64.336,60.186,64.156c1.984-0.179,6.406-2.599,7.312-5.107C68.398,56.537,68.398,54.386,68.129,53.938z"></path></svg>
                        <span class="wa-chat-box-content-send-btn-text">Contact Us</span>
                    </a>
                    <div class="wa-chat-box-poweredby">⚡️ by <a href="https://bot.space/?ref=whatsappChatWidget" target="_blank" style="color: #006eff6e;">bot.space</a></div>
                </div>
            </div>
        </div>
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
        document.querySelectorAll('.dot').forEach((bullet, index) => {
            bullet.addEventListener('click', () => {
                heroSlider.slideTo(index);
            });
        });
    
        // Update active state for custom buttons
        heroSlider.on('slideChange', function() {
            document.querySelectorAll('.dot').forEach((bullet, index) => {
                if (index === heroSlider.activeIndex) {
                    bullet.classList.add('is-selected');
                } else {
                    bullet.classList.remove('is-selected');
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
    
    window.onload = function () {
        let whatsappBtn = document.getElementById('wa-widget-send-button-no-text');
        whatsappBtn.onclick = function () {
        let chat = document.getElementById('wa-chat-box-no-text');
            if (chat.style.display === "none" || chat.style.display === "") {
                chat.style.display = "block"; 
            } else {
                chat.style.display = "none"; 
            }
        }
    };
        let whatsappBtnClose = document.getElementById('wa-chat-bubble-close-btn');
        whatsappBtnClose.onclick = function () {
        let chat = document.getElementById('wa-chat-box-no-text');
            chat.style.display = "none"; 
        }
    
</script>

@endpush
