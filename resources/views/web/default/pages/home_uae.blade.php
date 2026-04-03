@extends(getTemplate() . '.layouts.uae_app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/default/css/home-uae.css">
    <style>
body {
    font-family: 'Cairo', sans-serif !important;
}
.home-sections {
    margin-top:80px !important;
}
.about-decor {
    position: relative;
    text-align: center;
    display: inline-block;
    padding: 0 20px;
}

.about-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: #1e293b; /* أزرق غامق أنيق */
    margin-bottom: 0.6rem;
    font-family: "Tajawal", sans-serif; /* خط عربي جميل */
    position: relative;
}

.about-line {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .8rem;
    margin: 1rem;
}

.about-line span {
    display: block;
    width: 60px;
    height: 2px;
    background: linear-gradient(to right, #2563eb, #38bdf8);
    border-radius: 2px;
    animation: expand 2s infinite alternate;
}

.about-line i {
    font-size: 1rem;
    color: #2563eb;
    animation: pulse 1.5s infinite;
}

.about-hint {
    font-size: 1rem;
    color: #475569;
    max-width: 600px;
    margin: 0 auto;
}

/* أنيميشن */
@keyframes expand {
    from { width: 30px; }
    to { width: 80px; }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}
.section_our_solution .row {
  align-items: center;
}

.our_solution_category {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
}

.our_solution_category .solution_cards_box {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.solution_cards_box .solution_card {
  flex: 0 50%;
  background: #fff;
  box-shadow: 0 2px 4px 0 rgba(136, 144, 195, 0.2),
    0 5px 15px 0 rgba(37, 44, 97, 0.15);
  border-radius: 15px;
  margin: 8px;
  padding: 10px 15px;
  position: relative;
  z-index: 1;
  overflow: hidden;
  min-height: 350px;
  transition: 0.7s;
}

.solution_cards_box .solution_card:hover {
  background: #309df0;
  color: #fff;
  transform: scale(1.1);
  z-index: 9;
}

.solution_cards_box .solution_card:hover::before {
  background: rgb(85 108 214 / 10%);
}

.solution_cards_box .solution_card:hover .solu_title h3,
.solution_cards_box .solution_card:hover .solu_description p {
  color: #fff;
}

.solution_cards_box .solution_card:before {
  content: "";
  position: absolute;
  background: rgb(85 108 214 / 5%);
  width: 170px;
  height: 400px;
  z-index: -1;
  transform: rotate(42deg);
  right: -56px;
  top: -23px;
  border-radius: 35px;
}

.solution_cards_box .solution_card:hover .solu_description button {
  background: #fff !important;
  color: #309df0;
}

.solution_card .so_top_icon {
}

.solution_card .solu_title div {
  color: #212121;
  font-size: 1.3rem;
  margin-top: 13px;
  margin-bottom: 13px;
}

.solution_card .solu_description p {
    font-size: 22px;
    text-align: center;
    margin-bottom: 15px;
}

.solution_card .solu_description button {
  border: 0;
  border-radius: 15px;
  background: linear-gradient(
    140deg,
    #42c3ca 0%,
    #42c3ca 50%,
    #42c3cac7 75%
  ) !important;
  color: #fff;
  font-weight: 500;
  font-size: 1rem;
  padding: 5px 16px;
}

.our_solution_content div {
  text-transform: capitalize;
  margin-bottom: 1rem;
  font-size: 2.5rem;
}

.our_solution_content p {
}

.hover_color_bubble {
  position: absolute;
  background: rgb(54 81 207 / 15%);
  width: 100rem;
  height: 100rem;
  left: 0;
  right: 0;
  z-index: -1;
  top: 16rem;
  border-radius: 50%;
  transform: rotate(-36deg);
  left: -18rem;
  transition: 0.7s;
}

.solution_cards_box .solution_card:hover .hover_color_bubble {
  top: 0rem;
}

.solution_cards_box .solution_card .so_top_icon {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: #fff;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}

.solution_cards_box .solution_card .so_top_icon img {
  width: 40px;
  height: 50px;
  object-fit: contain;
}

/*start media query*/
@media screen and (min-width: 320px) {
  .sol_card_top_3 {
    position: relative;
    top: 0;
  }

  .our_solution_category {
    width: 100%;
    margin: 0 auto;
  }

  .our_solution_category .solution_cards_box {
    flex: auto;
  }
}
.flaticon-hr:before{
    color: #348dea !important;
}
.flaticon-value:before {
    color: #348dea !important;
}
.flaticon-start:before {
    color: #348dea !important;
}


</style>
@endpush

@section('content')
    @if (!empty($heroSectionData))
        <section class="hero-slider swiper">
            <!-- Progress Bar -->
            <div class="slider-progress">
                <div class="progress-bar"></div>
            </div>

            <!-- Animated Background Overlay -->
            <div class="animated-bg-overlay"></div>

            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                    @include('web.default.includes.slider', [
                        'slider' => $slider,
                    ])
                @endforeach
            </div>

            <!-- Custom Navigation -->
            <div class="customised-slider-nav-wrapper">
                <div class="customised-pagination">
                    <ol class="flickity-page-dots">
                        @foreach ($sliders as $index => $slider)
                            <li class="dot" data-slide-index="{{ $index }}" title="{{ $slider->title }}"></li>
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
                <div class="col-md-12 col-md-offset-2 my-5">
                    <div class="site-heading text-center">
                        <h4 class="text-uppercase text-primary mb-3">{{ __('home.why_learn_title') }}</h4>
                        <p class="lead text-muted mb-4">{{ __('home.why_learn_subtitle') }}</p>
                    </div>
                </div>
            </div>
            <div class="modern-services-area">
                <div class="container">
                    <div class="row text-center">

                        <!-- Card 1 -->
                        <div class="single-item col-12 col-md-4 mb-4">
                            <div class="item card border-0 rounded-lg overflow-hidden h-100 hover-glow">
                                <div class="card-body p-5 position-relative">
                                    <div class="icon mb-4">
                                        <i class="fas fa-calendar" style="font-size: 35px"></i>
                                    </div>
                                    <div class="content">
                                        <h4 class="h5 font-weight-bold mb-3 text-white">{{ __('home.flexible_plans_title') }}</h4>
                                        <p class="text-light">
                                            {{ __('home.flexible_plans_desc') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="card-overlay bg-gradient-primary"></div>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="single-item col-12 col-md-4 mb-4">
                            <div class="item card border-0 rounded-lg overflow-hidden h-100 hover-glow">
                                <div class="card-body p-5 position-relative">
                                    <div class="icon mb-4">
                                        <i class="fas fa-video" style="font-size: 35px"></i>
                                    </div>
                                    <div class="content">
                                        <h4 class="h5 font-weight-bold mb-3 text-white">{{ __('home.ondemand_title') }}</h4>
                                        <p class="text-light">
                                            {{ __('home.ondemand_desc') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="card-overlay bg-gradient-success"></div>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="single-item col-12 col-md-4 mb-4">
                            <div class="item card border-0 rounded-lg overflow-hidden h-100 hover-glow">
                                <div class="card-body p-5 position-relative">
                                    <div class="icon mb-4">
                                        <i class="fas fa-trophy" style="font-size: 35px"></i>
                                    </div>
                                    <div class="content">
                                        <h4 class="h5 font-weight-bold mb-3 text-white">{{ __('home.quality_title') }}</h4>
                                        <p class="text-light">
                                            {{ __('home.quality_desc') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="card-overlay bg-gradient-warning"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



    @foreach ($homeSections as $homeSection)
        @if (
            $homeSection->name == \App\Models\HomeSection::$featured_classes and
                !empty($featureWebinars) and
                !$featureWebinars->isEmpty())
            <section class="home-sections home-sections-swiper container">
                <div class="px-10 px-md-0">
                    <h2 class="section-title">{{ trans('home.featured_classes') }}</h2>
                    <p class="section-hint">{{ trans('home.featured_classes_hint') }}</p>
                </div>

                <div class="feature-slider-container position-relative d-flex justify-content-center mt-10">
                    <div class="swiper-container features-swiper-container pb-25">
                        <div class="swiper-wrapper py-10">
                            @foreach ($featureWebinars as $feature)
                                <div class="swiper-slide">

                                    <a href="{{ $feature->webinar->getUrl() }}">
                                        <div class="feature-slider d-flex h-100"
                                            style="background-image: url('{{ $feature->webinar->getImage() }}')">
                                            <div class="mask"></div>
                                            <div class="p-5 p-md-25 feature-slider-card">
                                                <div class="d-flex flex-column feature-slider-body position-relative h-100">
                                                    @if ($feature->webinar->bestTicket() < $feature->webinar->price)
                                                        <span
                                                            class="badge badge-danger mb-2 ">{{ trans('public.offer', ['off' => $feature->webinar->bestTicket(true)['percent']]) }}</span>
                                                    @endif
                                                    <a href="{{ $feature->webinar->getUrl() }}">
                                                        <h3 class="card-title mt-1">{{ $feature->webinar->title }}</h3>
                                                    </a>

                                                    <div class="user-inline-avatar mt-15 d-flex align-items-center">
                                                        <div class="avatar bg-gray200">
                                                            <img src="{{ $feature->webinar->teacher->getAvatar() }}"
                                                                class="img-cover"
                                                                alt="{{ $feature->webinar->teacher->full_naem }}">
                                                        </div>
                                                        <a href="{{ $feature->webinar->teacher->getProfileUrl() }}"
                                                            target="_blank"
                                                            class="user-name font-14 ml-5">{{ $feature->webinar->teacher->full_name }}</a>
                                                    </div>

                                                    <p class="mt-25 feature-desc text-gray">{{ $feature->description }}
                                                    </p>

                                                    @include('web.default.includes.webinar.rate', [
                                                        'rate' => $feature->webinar->getRate(),
                                                    ])

                                                    <div
                                                        class="feature-footer mt-auto d-flex align-items-center justify-content-between">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <i data-feather="clock" width="20" height="20"
                                                                    class="webinar-icon"></i>
                                                                <span
                                                                    class="duration ml-5 text-dark-blue font-14">{{ convertMinutesToHourAndMinute($feature->webinar->duration) }}
                                                                    {{ trans('home.hours') }}</span>
                                                            </div>

                                                            <div class="vertical-line mx-10"></div>

                                                            <div class="d-flex align-items-center">
                                                                <i data-feather="calendar" width="20" height="20"
                                                                    class="webinar-icon"></i>
                                                                <span
                                                                    class="date-published ml-5 text-dark-blue font-14">{{ dateTimeFormat(!empty($feature->webinar->start_date) ? $feature->webinar->start_date : $feature->webinar->created_at, 'j M Y') }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="feature-price-box">
                                                            @if (!empty($feature->webinar->price) and $feature->webinar->price > 0)
                                                                @if ($feature->webinar->bestTicket() < $feature->webinar->price)
                                                                    <span
                                                                        class="real">{{ handlePrice($feature->webinar->bestTicket(), true, true, false, null, true) }}</span>
                                                                @else
                                                                    {{ handlePrice($feature->webinar->price, true, true, false, null, true) }}
                                                                @endif
                                                            @else
                                                                @if ($feature->webinar->type != 'text_lesson')
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

        @if (
            $homeSection->name == \App\Models\HomeSection::$latest_bundles and
                !empty($latestBundles) and
                !$latestBundles->isEmpty())
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
                            @foreach ($latestBundles as $latestBundle)
                                <div class="swiper-slide">
                                    @include('web.default.includes.webinar.grid-card', [
                                        'webinar' => $latestBundle,
                                    ])
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
        @if (
            $homeSection->name == \App\Models\HomeSection::$upcoming_courses and
                !empty($upcomingCourses) and
                !$upcomingCourses->isEmpty())
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
                            @foreach ($upcomingCourses as $upcomingCourse)
                                <div class="swiper-slide">
                                    @include('web.default.includes.webinar.upcoming_course_grid_card', [
                                        'upcomingCourse' => $upcomingCourse,
                                    ])
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

        @if (
            $homeSection->name == \App\Models\HomeSection::$latest_classes and
                !empty($latestWebinars) and
                !$latestWebinars->isEmpty())
            <section class="home-sections home-sections-swiper container">
                <div class="d-flex justify-content-between ">
                    <div>
                        <h2 class="section-title">{{ trans('home.latest_classes') }}</h2>
                        <p class="section-hint">{{ trans('home.latest_webinars_hint') }}</p>
                    </div>

                    <a href="/{{app()->getLocale()}}/uae/classes?sort=newest" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
                </div>

                <div class="mt-10 position-relative">
                    <div class="latest-webinars-swiper px-12">
                        <div class="row mt-20 align-items-stretsh">
                            @foreach ($latestWebinars->slice(0, 6) as $latestWebinar)
                                <div class="col-12 col-lg-4 mb-4">
                                    @include('web.default.includes.webinar.normal-card', [
                                        'webinar' => $latestWebinar,
                                    ])
                                </div>
                            @endforeach

                        </div>
                    </div>


                </div>
            </section>
        @endif

        @if (
            $homeSection->name == \App\Models\HomeSection::$best_rates and
                !empty($bestRateWebinars) and
                !$bestRateWebinars->isEmpty())
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
                            @foreach ($bestRateWebinars as $bestRateWebinar)
                                <div class="swiper-slide">
                                    @include('web.default.includes.webinar.grid-card', [
                                        'webinar' => $bestRateWebinar,
                                    ])
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
        @if (
            $homeSection->name == \App\Models\HomeSection::$full_advertising_banner and
                !empty($advertisingBanners1) and
                count($advertisingBanners1))
            <div class="home-sections container">
                <div class="row">
                    @foreach ($advertisingBanners1 as $banner1)
                        <div class="col-{{ $banner1->size }}">
                            <a href="{{ $banner1->link }}">
                                <img src="{{ $banner1->image }}" class="img-cover rounded-sm"
                                    alt="{{ $banner1->title }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        {{-- ./ Ads Bannaer --}}

        @if (
            $homeSection->name == \App\Models\HomeSection::$best_sellers and
                !empty($bestSaleWebinars) and
                !$bestSaleWebinars->isEmpty())
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
                            @foreach ($bestSaleWebinars as $bestSaleWebinar)
                                <div class="swiper-slide">
                                    @include('web.default.includes.webinar.grid-card', [
                                        'webinar' => $bestSaleWebinar,
                                    ])
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

        @if (
            $homeSection->name == \App\Models\HomeSection::$discount_classes and
                !empty($hasDiscountWebinars) and
                !$hasDiscountWebinars->isEmpty())
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
                            @foreach ($hasDiscountWebinars as $hasDiscountWebinar)
                                <div class="swiper-slide">
                                    @include('web.default.includes.webinar.grid-card', [
                                        'webinar' => $hasDiscountWebinar,
                                    ])
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

        @if (
            $homeSection->name == \App\Models\HomeSection::$free_classes and
                !empty($freeWebinars) and
                !$freeWebinars->isEmpty())
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

                            @foreach ($freeWebinars as $freeWebinar)
                                <div class="swiper-slide">
                                    @include('web.default.includes.webinar.grid-card', [
                                        'webinar' => $freeWebinar,
                                    ])
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

        {{-- @if ($homeSection->name == \App\Models\HomeSection::$store_products and !empty($newProducts) and !$newProducts->isEmpty())
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

                            @foreach ($newProducts as $newProduct)
                                <div class="swiper-slide">
                                    @include('web.default.products.includes.card', [
                                        'product' => $newProduct,
                                    ])
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination new-products-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        @endif --}}


@if($homeSection->name == \App\Models\HomeSection::$testimonials and !empty($testimonials) and !$testimonials->isEmpty())
<div class="position-relative home-sections testimonials-container">

    <div id="parallax1" class="ltr">
        <div data-depth="0.2" class="gradient-box left-gradient-box"></div>
    </div>

    <section class="container home-sections home-sections-swiper">
        <div class="text-center my-40">
            <h2 class="section-title">{{trans('app.clients')}} </h2>
            <div class="about-line">
                <span></span>
                <i class="fas fa-star-of-life"></i> 
                <span></span>
            </div>
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


        @if ($homeSection->name == \App\Models\HomeSection::$subscribes and !empty($subscribes) and !$subscribes->isEmpty())
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

                                @foreach ($subscribes as $subscribe)
                                    @php
                                        $subscribeSpecialOffer = $subscribe->activeSpecialOffer();
                                    @endphp

                                    <div class="swiper-slide">
                                        <div
                                            class="subscribe-plan position-relative bg-white d-flex flex-column align-items-center rounded-sm shadow pt-50 pb-20 px-20">
                                            @if ($subscribe->is_popular)
                                                <span
                                                    class="badge badge-primary badge-popular px-15 py-5">{{ trans('panel.popular') }}</span>
                                            @elseif(!empty($subscribeSpecialOffer))
                                                <span
                                                    class="badge badge-danger badge-popular px-15 py-5">{{ trans('update.percent_off', ['percent' => $subscribeSpecialOffer->percent]) }}</span>
                                            @endif

                                            <div class="plan-icon">
                                                <img src="{{ $subscribe->icon }}" class="img-cover" alt="">
                                            </div>

                                            <h3 class="mt-20 font-30 text-secondary">{{ $subscribe->title }}</h3>
                                            <p class="font-weight-500 text-gray mt-10">{{ $subscribe->description }}</p>

                                            <div class="d-flex align-items-start mt-30">
                                                @if (!empty($subscribe->price) and $subscribe->price > 0)
                                                    @if (!empty($subscribeSpecialOffer))
                                                        <div class="d-flex align-items-end line-height-1">
                                                            <span
                                                                class="font-36 text-primary">{{ handlePrice($subscribe->getPrice(), true, true, false, null, true) }}</span>
                                                            <span
                                                                class="font-14 text-gray ml-5 text-decoration-line-through">{{ handlePrice($subscribe->price, true, true, false, null, true) }}</span>
                                                        </div>
                                                    @else
                                                        <span
                                                            class="font-36 text-primary line-height-1">{{ handlePrice($subscribe->price, true, true, false, null, true) }}</span>
                                                    @endif
                                                @else
                                                    <span
                                                        class="font-36 text-primary line-height-1">{{ trans('public.free') }}</span>
                                                @endif
                                            </div>

                                            <ul class="mt-20 plan-feature">
                                                <li class="mt-10">{{ $subscribe->days }}
                                                    {{ trans('financial.days_of_subscription') }}
                                                </li>
                                                <li class="mt-10">
                                                    @if ($subscribe->infinite_use)
                                                        {{ trans('update.unlimited') }}
                                                    @else
                                                        {{ $subscribe->usable_count }}
                                                    @endif
                                                    <span class="ml-5">{{ trans('update.subscribes') }}</span>
                                                </li>
                                            </ul>

                                            @if (auth()->check())
                                                <form action="/panel/financial/pay-subscribes" method="post"
                                                    class="w-100">
                                                    {{ csrf_field() }}
                                                    <input name="amount" value="{{ $subscribe->price }}"
                                                        type="hidden">
                                                    <input name="id" value="{{ $subscribe->id }}" type="hidden">

                                                    <div class="d-flex align-items-center mt-50 w-100">
                                                        <button type="submit"
                                                            class="btn btn-primary {{ !empty($subscribe->has_installment) ? '' : 'btn-block' }}">{{ trans('update.purchase') }}</button>

                                                        @if (!empty($subscribe->has_installment))
                                                            <a href="/panel/financial/subscribes/{{ $subscribe->id }}/installments"
                                                                class="btn btn-outline-primary flex-grow-1 ml-10">{{ trans('update.installments') }}</a>
                                                        @endif
                                                    </div>
                                                </form>
                                            @else
                                                <a href="/login"
                                                    class="btn btn-primary btn-block mt-50">{{ trans('update.purchase') }}</a>
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

        @if ($homeSection->name == \App\Models\HomeSection::$find_instructors and !empty($findInstructorSection))
            <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <div class="">
                            <h2 class="font-36 font-weight-bold text-dark">{{ $findInstructorSection['title'] ?? '' }}
                            </h2>
                            <p class="font-16 font-weight-normal text-gray mt-10">
                                {{ $findInstructorSection['description'] ?? '' }}
                            </p>

                            <div class="mt-35 d-flex align-items-center">
                                @if (
                                    !empty($findInstructorSection['button1']) and
                                        !empty($findInstructorSection['button1']['title']) and
                                        !empty($findInstructorSection['button1']['link']))
                                    <a href="{{ $findInstructorSection['button1']['link'] }}"
                                        class="btn btn-primary mr-15">{{ $findInstructorSection['button1']['title'] }}</a>
                                @endif

                                @if (
                                    !empty($findInstructorSection['button2']) and
                                        !empty($findInstructorSection['button2']['title']) and
                                        !empty($findInstructorSection['button2']['link']))
                                    <a href="{{ $findInstructorSection['button2']['link'] }}"
                                        class="btn btn-outline-primary">{{ $findInstructorSection['button2']['title'] }}</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                        <div class="position-relative ">
                            <img src="{{ $findInstructorSection['image'] }}" class="find-instructor-section-hero"
                                alt="{{ $findInstructorSection['title'] }}">
                            <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle"
                                alt="circle">
                            <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots"
                                alt="dots">

                            <div
                                class="example-instructor-card bg-white rounded-sm shadow-lg  p-5 p-md-15 d-flex align-items-center">
                                <div class="example-instructor-card-avatar">
                                    <img src="/assets/default/img/home/toutor_finder.svg" class="img-cover rounded-circle"
                                        alt="user name">
                                </div>

                                <div class="flex-grow-1 ml-15">
                                    <span
                                        class="font-14 font-weight-bold text-secondary d-block">{{ trans('update.looking_for_an_instructor') }}</span>
                                    <span
                                        class="text-gray font-12 font-weight-500">{{ trans('update.find_the_best_instructor_now') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if ($homeSection->name == \App\Models\HomeSection::$reward_program and !empty($rewardProgramSection))
            <section class="home-sections home-sections-swiper container reward-program-section position-relative">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <div class="position-relative reward-program-section-hero-card">
                            <img src="{{ $rewardProgramSection['image'] }}" class="reward-program-section-hero"
                                alt="{{ $rewardProgramSection['title'] }}">

                            <div
                                class="example-reward-card bg-white rounded-sm shadow-lg p-5 p-md-15 d-flex align-items-center">
                                <div class="example-reward-card-medal">
                                    <img src="/assets/default/img/rewards/medal.png" class="img-cover rounded-circle"
                                        alt="medal">
                                </div>

                                <div class="flex-grow-1 ml-15">
                                    <span
                                        class="font-14 font-weight-bold text-secondary d-block">{{ trans('update.you_got_50_points') }}</span>
                                    <span
                                        class="text-gray font-12 font-weight-500">{{ trans('update.for_completing_the_course') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                        <div class="">
                            <h2 class="font-36 font-weight-bold text-dark">{{ $rewardProgramSection['title'] ?? '' }}
                            </h2>
                            <p class="font-16 font-weight-normal text-gray mt-10">
                                {{ $rewardProgramSection['description'] ?? '' }}
                            </p>

                            <div class="mt-35 d-flex align-items-center">
                                @if (
                                    !empty($rewardProgramSection['button1']) and
                                        !empty($rewardProgramSection['button1']['title']) and
                                        !empty($rewardProgramSection['button1']['link']))
                                    <a href="{{ $rewardProgramSection['button1']['link'] }}"
                                        class="btn btn-primary mr-15">{{ $rewardProgramSection['button1']['title'] }}</a>
                                @endif

                                @if (
                                    !empty($rewardProgramSection['button2']) and
                                        !empty($rewardProgramSection['button2']['title']) and
                                        !empty($rewardProgramSection['button2']['link']))
                                    <a href="{{ $rewardProgramSection['button2']['link'] }}"
                                        class="btn btn-outline-primary">{{ $rewardProgramSection['button2']['title'] }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if ($homeSection->name == \App\Models\HomeSection::$become_instructor and !empty($becomeInstructorSection))
            <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <div class="">
                            <h2 class="font-36 font-weight-bold text-dark">{{ $becomeInstructorSection['title'] ?? '' }}
                            </h2>
                            <p class="font-16 font-weight-normal text-gray mt-10">
                                {{ $becomeInstructorSection['description'] ?? '' }}
                            </p>

                            <div class="mt-35 d-flex align-items-center">
                                @if (
                                    !empty($becomeInstructorSection['button1']) and
                                        !empty($becomeInstructorSection['button1']['title']) and
                                        !empty($becomeInstructorSection['button1']['link']))
                                    <a href="{{ empty($authUser) ? '/login' : ($authUser->isUser() ? $becomeInstructorSection['button1']['link'] : '/panel/financial/registration-packages') }}"
                                        class="btn btn-primary mr-15">{{ $becomeInstructorSection['button1']['title'] }}</a>
                                @endif

                                @if (
                                    !empty($becomeInstructorSection['button2']) and
                                        !empty($becomeInstructorSection['button2']['title']) and
                                        !empty($becomeInstructorSection['button2']['link']))
                                    <a href="{{ empty($authUser) ? '/login' : ($authUser->isUser() ? $becomeInstructorSection['button2']['link'] : '/panel/financial/registration-packages') }}"
                                        class="btn btn-outline-primary">{{ $becomeInstructorSection['button2']['title'] }}</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                        <div class="position-relative ">
                            <img src="{{ $becomeInstructorSection['image'] }}" class="find-instructor-section-hero"
                                alt="{{ $becomeInstructorSection['title'] }}">
                            <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle"
                                alt="circle">
                            <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots"
                                alt="dots">

                            <div
                                class="example-instructor-card bg-white rounded-sm shadow-lg border p-5 p-md-15 d-flex align-items-center">
                                <div class="example-instructor-card-avatar">
                                    <img src="/assets/default/img/home/become_instructor.svg"
                                        class="img-cover rounded-circle" alt="user name">
                                </div>

                                <div class="flex-grow-1 ml-15">
                                    <span
                                        class="font-14 font-weight-bold text-secondary d-block">{{ trans('update.become_an_instructor') }}</span>
                                    <span
                                        class="text-gray font-12 font-weight-500">{{ trans('update.become_instructor_tagline') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if ($homeSection->name == \App\Models\HomeSection::$forum_section and !empty($forumSection))
            <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                        <div class="position-relative ">
                            <img src="{{ $forumSection['image'] }}" class="find-instructor-section-hero"
                                alt="{{ $forumSection['title'] }}">
                            <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle"
                                alt="circle">
                            <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots"
                                alt="dots">
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="">
                            <h2 class="font-36 font-weight-bold text-dark">{{ $forumSection['title'] ?? '' }}</h2>
                            <p class="font-16 font-weight-normal text-gray mt-10">
                                {{ $forumSection['description'] ?? '' }}
                            </p>

                            <div class="mt-35 d-flex align-items-center">
                                @if (
                                    !empty($forumSection['button1']) and
                                        !empty($forumSection['button1']['title']) and
                                        !empty($forumSection['button1']['link']))
                                    <a href="{{ $forumSection['button1']['link'] }}"
                                        class="btn btn-primary mr-15">{{ $forumSection['button1']['title'] }}</a>
                                @endif

                                @if (
                                    !empty($forumSection['button2']) and
                                        !empty($forumSection['button2']['title']) and
                                        !empty($forumSection['button2']['link']))
                                    <a href="{{ $forumSection['button2']['link'] }}"
                                        class="btn btn-outline-primary">{{ $forumSection['button2']['title'] }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if ($homeSection->name == \App\Models\HomeSection::$video_or_image_section and !empty($boxVideoOrImage))
            <section class="home-sections home-sections-swiper position-relative">
                <div class="home-video-mask"></div>
                <div class="container home-video-container d-flex flex-column align-items-center justify-content-center position-relative"
                    style="background-image: url('{{ $boxVideoOrImage['background'] ?? '' }}')">
                    <a href="{{ $boxVideoOrImage['link'] ?? '' }}"
                        class="home-video-play-button d-flex align-items-center justify-content-center position-relative">
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
            <div class="about-line">
                <span></span>
                <i class="fas fa-star-of-life"></i> 
                <span></span>
            </div>
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
        @if (
            $homeSection->name == \App\Models\HomeSection::$half_advertising_banner and
                !empty($advertisingBanners2) and
                count($advertisingBanners2))
            <div class="home-sections container">
                <div class="row">
                    @foreach ($advertisingBanners2 as $banner2)
                        <div class="col-{{ $banner2->size }}">
                            <a href="{{ $banner2->link }}">
                                <img src="{{ $banner2->image }}" class="img-cover rounded-sm"
                                    alt="{{ $banner2->title }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        {{-- ./ Ads Bannaer --}}

        @if (
            $homeSection->name == \App\Models\HomeSection::$organizations and
                !empty($organizations) and
                !$organizations->isEmpty())
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

                            @foreach ($organizations as $organization)
                                <div class="swiper-slide">
                                    <div class=" d-flex flex-column align-items-center justify-content-center">
                                        <div class="home-organizations-avatar">
                                            <img src="{{ $organization->getAvatar(120) }}"
                                                class="img-cover rounded-circle" alt="{{ $organization->full_name }}">
                                        </div>
                                        <a href="{{ $organization->getProfileUrl() }}"
                                            class="mt-25 d-flex flex-column align-items-center justify-content-center">
                                            <h3 class="home-organizations-title">{{ $organization->full_name }}</h3>
                                            <p class="home-organizations-desc mt-10">{{ $organization->bio }}</p>
                                            <span
                                                class="home-organizations-badge badge mt-15">{{ $organization->webinars_count }}
                                                {{ trans('panel.classes') }}</span>
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
    </script>
@endpush
