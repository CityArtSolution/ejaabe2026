{{-- أقسام المنصة الاختيارية (تُفعَّل وتُرتَّب من لوحة التحكم) — تبقى بتنسيق المنصة --}}
@foreach ($homeSections as $homeSection)

        {{-- Featured Classes --}}
        @if (
            $homeSection->name == \App\Models\HomeSection::$featured_classes &&
            !empty($featureWebinars) && !$featureWebinars->isEmpty()
        )
            <section class="home-sections home-sections-swiper container arabic-font">
                <div class="px-10 px-md-0">
                    <h2 class="section-title">{{ trans('home.featured_classes') }}</h2>
                    <p class="section-hint">{{ trans('home.featured_classes_hint') }}</p>
                </div>
                <div class="feature-slider-container position-relative d-flex justify-content-center mt-10 arabic-font">
                    <div class="swiper-container features-swiper-container pb-25 arabic-font">
                        <div class="swiper-wrapper py-10 arabic-font">
                            @foreach ($featureWebinars as $feature)
                                <div class="swiper-slide">
                                    <a href="{{ $feature->webinar->getUrl() }}">
                                        <div class="feature-slider d-flex h-100" style="background-image:url('{{ $feature->webinar->getImage() }}')">
                                            <div class="mask"></div>
                                            <div class="p-5 p-md-25 feature-slider-card">
                                                <div class="d-flex flex-column feature-slider-body position-relative h-100">
                                                    @if ($feature->webinar->bestTicket() < $feature->webinar->price)
                                                        <span class="badge badge-danger mb-2">{{ trans('public.offer', ['off' => $feature->webinar->bestTicket(true)['percent']]) }}</span>
                                                    @endif
                                                    <a href="{{ $feature->webinar->getUrl() }}"><h3 class="card-title mt-1">{{ $feature->webinar->title }}</h3></a>
                                                    <div class="user-inline-avatar mt-15 d-flex align-items-center">
                                                        <div class="avatar bg-gray200">
                                                            <img src="{{ $feature->webinar->teacher->getAvatar() }}" class="img-cover" alt="{{ $feature->webinar->teacher->full_name }}">
                                                        </div>
                                                        <a href="{{ $feature->webinar->teacher->getProfileUrl() }}" target="_blank" class="user-name font-14 ml-5">{{ $feature->webinar->teacher->full_name }}</a>
                                                    </div>
                                                    <p class="mt-25 feature-desc text-gray">{{ $feature->description }}</p>
                                                    @include('web.default.includes.webinar.rate', ['rate' => $feature->webinar->getRate()])
                                                    <div class="feature-footer mt-auto d-flex align-items-center justify-content-between">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <i data-feather="clock" width="20" height="20" class="webinar-icon"></i>
                                                                <span class="duration ml-5 text-dark-blue font-14">{{ convertMinutesToHourAndMinute($feature->webinar->duration) }} {{ trans('home.hours') }}</span>
                                                            </div>
                                                            <div class="vertical-line mx-10"></div>
                                                            <div class="d-flex align-items-center">
                                                                <i data-feather="calendar" width="20" height="20" class="webinar-icon"></i>
                                                                <span class="date-published ml-5 text-dark-blue font-14">{{ dateTimeFormat(!empty($feature->webinar->start_date) ? $feature->webinar->start_date : $feature->webinar->created_at, 'j M Y') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="feature-price-box">
                                                            @if (!empty($feature->webinar->price) && $feature->webinar->price > 0)
                                                                @if ($feature->webinar->bestTicket() < $feature->webinar->price)
                                                                    <span class="real">{{ handlePrice($feature->webinar->bestTicket(), true, true, false, null, true) }}</span>
                                                                @else
                                                                    {{ handlePrice($feature->webinar->price, true, true, false, null, true) }}
                                                                @endif
                                                            @else
                                                                @if ($feature->webinar->type != 'text_lesson') {{ trans('public.free') }} @endif
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

        {{-- Latest Bundles --}}
        @if ($homeSection->name == \App\Models\HomeSection::$latest_bundles && !empty($latestBundles) && !$latestBundles->isEmpty())
            <section class="home-sections home-sections-swiper container arabic-font">
                <div class="d-flex justify-content-between arabic-font">
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
                                <div class="swiper-slide">@include('web.default.includes.webinar.grid-card', ['webinar' => $latestBundle])</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination bundle-webinars-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Upcoming Courses --}}
        @if ($homeSection->name == \App\Models\HomeSection::$upcoming_courses && !empty($upcomingCourses) && !$upcomingCourses->isEmpty())
            <section class="home-sections home-sections-swiper container">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="section-title">{{ trans('update.upcoming_courses') }}</h2>
                        <p class="section-hint">{{ trans('update.upcoming_courses_home_section_hint') }}</p>
                    </div>
                    <a href="/{{ app()->getLocale() }}/upcoming_courses?sort=newest" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
                </div>
                <div class="mt-10 position-relative">
                    <div class="swiper-container upcoming-courses-swiper px-12">
                        <div class="swiper-wrapper py-20">
                            @foreach ($upcomingCourses as $upcomingCourse)
                                <div class="swiper-slide">@include('web.default.includes.webinar.upcoming_course_grid_card', ['upcomingCourse' => $upcomingCourse])</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination upcoming-courses-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Best Rates --}}
        @if ($homeSection->name == \App\Models\HomeSection::$best_rates && !empty($bestRateWebinars) && !$bestRateWebinars->isEmpty())
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
                                <div class="swiper-slide">@include('web.default.includes.webinar.grid-card', ['webinar' => $bestRateWebinar])</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination best-rates-webinars-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Full Ad Banner --}}
        @if ($homeSection->name == \App\Models\HomeSection::$full_advertising_banner && !empty($advertisingBanners1) && count($advertisingBanners1))
            <div class="home-sections container">
                <div class="row">
                    @foreach ($advertisingBanners1 as $banner1)
                        <div class="col-{{ $banner1->size }}">
                            <a href="{{ $banner1->link }}"><img src="{{ $banner1->image }}" class="img-cover rounded-sm" alt="{{ $banner1->title }}"></a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Best Sellers --}}
        @if ($homeSection->name == \App\Models\HomeSection::$best_sellers && !empty($bestSaleWebinars) && !$bestSaleWebinars->isEmpty())
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
                                <div class="swiper-slide">@include('web.default.includes.webinar.grid-card', ['webinar' => $bestSaleWebinar])</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination best-sales-webinars-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Discount Classes --}}
        @if ($homeSection->name == \App\Models\HomeSection::$discount_classes && !empty($hasDiscountWebinars) && !$hasDiscountWebinars->isEmpty())
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
                                <div class="swiper-slide">@include('web.default.includes.webinar.grid-card', ['webinar' => $hasDiscountWebinar])</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination has-discount-webinars-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Free Classes --}}
        @if ($homeSection->name == \App\Models\HomeSection::$free_classes && !empty($freeWebinars) && !$freeWebinars->isEmpty())
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
                                <div class="swiper-slide">@include('web.default.includes.webinar.grid-card', ['webinar' => $freeWebinar])</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination free-webinars-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Subscribes --}}
        @if ($homeSection->name == \App\Models\HomeSection::$subscribes && !empty($subscribes) && !$subscribes->isEmpty())
            <div class="home-sections position-relative subscribes-container pe-none user-select-none">
                <section class="container home-sections home-sections-swiper">
                    <div class="text-center">
                        <h2 class="section-title">{{ trans('home.subscribe_now') }}</h2>
                        <p class="section-hint">{{ trans('home.subscribe_now_hint') }}</p>
                    </div>
                    <div class="position-relative mt-30">
                        <div class="swiper-container subscribes-swiper px-12">
                            <div class="swiper-wrapper py-20">
                                @foreach ($subscribes as $subscribe)
                                    @php $subscribeSpecialOffer = $subscribe->activeSpecialOffer(); @endphp
                                    <div class="swiper-slide">
                                        <div class="subscribe-plan position-relative bg-white d-flex flex-column align-items-center rounded-sm shadow pt-50 pb-20 px-20">
                                            @if ($subscribe->is_popular)
                                                <span class="badge badge-primary badge-popular px-15 py-5">{{ trans('panel.popular') }}</span>
                                            @elseif(!empty($subscribeSpecialOffer))
                                                <span class="badge badge-danger badge-popular px-15 py-5">{{ trans('update.percent_off', ['percent' => $subscribeSpecialOffer->percent]) }}</span>
                                            @endif
                                            <div class="plan-icon"><img src="{{ $subscribe->icon }}" class="img-cover" alt=""></div>
                                            <h3 class="mt-20 font-30 text-secondary">{{ $subscribe->title }}</h3>
                                            <p class="font-weight-500 text-gray mt-10">{{ $subscribe->description }}</p>
                                            <div class="d-flex align-items-start mt-30">
                                                @if (!empty($subscribe->price) && $subscribe->price > 0)
                                                    @if (!empty($subscribeSpecialOffer))
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
                                                    @if ($subscribe->infinite_use) {{ trans('update.unlimited') }} @else {{ $subscribe->usable_count }} @endif
                                                    <span class="ml-5">{{ trans('update.subscribes') }}</span>
                                                </li>
                                            </ul>
                                            @if (auth()->check())
                                                <form action="/panel/financial/pay-subscribes" method="post" class="w-100">
                                                    {{ csrf_field() }}
                                                    <input name="amount" value="{{ $subscribe->price }}" type="hidden">
                                                    <input name="id" value="{{ $subscribe->id }}" type="hidden">
                                                    <div class="d-flex align-items-center mt-50 w-100">
                                                        <button type="submit" class="btn btn-primary {{ !empty($subscribe->has_installment) ? '' : 'btn-block' }}">{{ trans('update.purchase') }}</button>
                                                        @if (!empty($subscribe->has_installment))
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
            </div>
        @endif

        {{-- Find Instructors --}}
        @if ($homeSection->name == \App\Models\HomeSection::$find_instructors && !empty($findInstructorSection))
            <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <h2 class="font-36 font-weight-bold text-dark">{{ $findInstructorSection['title'] ?? '' }}</h2>
                        <p class="font-16 font-weight-normal text-gray mt-10">{{ $findInstructorSection['description'] ?? '' }}</p>
                        <div class="mt-35 d-flex align-items-center flex-wrap gap-10">
                            @if (!empty($findInstructorSection['button1']['title']) && !empty($findInstructorSection['button1']['link']))
                                <a href="{{ $findInstructorSection['button1']['link'] }}" class="btn btn-primary mr-15">{{ $findInstructorSection['button1']['title'] }}</a>
                            @endif
                            @if (!empty($findInstructorSection['button2']['title']) && !empty($findInstructorSection['button2']['link']))
                                <a href="{{ $findInstructorSection['button2']['link'] }}" class="btn btn-outline-primary">{{ $findInstructorSection['button2']['title'] }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                        <div class="position-relative">
                            <img src="{{ $findInstructorSection['image'] }}" class="find-instructor-section-hero" alt="{{ $findInstructorSection['title'] }}">
                            <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle">
                            <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots">
                            <div class="example-instructor-card bg-white rounded-sm shadow-lg p-5 p-md-15 d-flex align-items-center">
                                <div class="example-instructor-card-avatar">
                                    <img src="/assets/default/img/home/toutor_finder.svg" class="img-cover rounded-circle" alt="user">
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

        {{-- Reward Program --}}
        @if ($homeSection->name == \App\Models\HomeSection::$reward_program && !empty($rewardProgramSection))
            <section class="home-sections home-sections-swiper container reward-program-section position-relative">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <div class="position-relative reward-program-section-hero-card">
                            <img src="{{ $rewardProgramSection['image'] }}" class="reward-program-section-hero" alt="{{ $rewardProgramSection['title'] }}">
                            <div class="example-reward-card bg-white rounded-sm shadow-lg p-5 p-md-15 d-flex align-items-center">
                                <div class="example-reward-card-medal"><img src="/assets/default/img/rewards/medal.png" class="img-cover rounded-circle" alt="medal"></div>
                                <div class="flex-grow-1 ml-15">
                                    <span class="font-14 font-weight-bold text-secondary d-block">{{ trans('update.you_got_50_points') }}</span>
                                    <span class="text-gray font-12 font-weight-500">{{ trans('update.for_completing_the_course') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                        <h2 class="font-36 font-weight-bold text-dark">{{ $rewardProgramSection['title'] ?? '' }}</h2>
                        <p class="font-16 font-weight-normal text-gray mt-10">{{ $rewardProgramSection['description'] ?? '' }}</p>
                        <div class="mt-35 d-flex align-items-center flex-wrap gap-10">
                            @if (!empty($rewardProgramSection['button1']['title']) && !empty($rewardProgramSection['button1']['link']))
                                <a href="{{ $rewardProgramSection['button1']['link'] }}" class="btn btn-primary mr-15">{{ $rewardProgramSection['button1']['title'] }}</a>
                            @endif
                            @if (!empty($rewardProgramSection['button2']['title']) && !empty($rewardProgramSection['button2']['link']))
                                <a href="{{ $rewardProgramSection['button2']['link'] }}" class="btn btn-outline-primary">{{ $rewardProgramSection['button2']['title'] }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Become Instructor --}}
        @if ($homeSection->name == \App\Models\HomeSection::$become_instructor && !empty($becomeInstructorSection))
            <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <h2 class="font-36 font-weight-bold text-dark">{{ $becomeInstructorSection['title'] ?? '' }}</h2>
                        <p class="font-16 font-weight-normal text-gray mt-10">{{ $becomeInstructorSection['description'] ?? '' }}</p>
                        <div class="mt-35 d-flex align-items-center flex-wrap gap-10">
                            @if (!empty($becomeInstructorSection['button1']['title']) && !empty($becomeInstructorSection['button1']['link']))
                                <a href="{{ empty($authUser) ? '/login' : ($authUser->isUser() ? $becomeInstructorSection['button1']['link'] : '/panel/financial/registration-packages') }}" class="btn btn-primary mr-15">{{ $becomeInstructorSection['button1']['title'] }}</a>
                            @endif
                            @if (!empty($becomeInstructorSection['button2']['title']) && !empty($becomeInstructorSection['button2']['link']))
                                <a href="{{ empty($authUser) ? '/login' : ($authUser->isUser() ? $becomeInstructorSection['button2']['link'] : '/panel/financial/registration-packages') }}" class="btn btn-outline-primary">{{ $becomeInstructorSection['button2']['title'] }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                        <div class="position-relative">
                            <img src="{{ $becomeInstructorSection['image'] }}" class="find-instructor-section-hero" alt="{{ $becomeInstructorSection['title'] }}">
                            <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle">
                            <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots">
                            <div class="example-instructor-card bg-white rounded-sm shadow-lg border p-5 p-md-15 d-flex align-items-center">
                                <div class="example-instructor-card-avatar"><img src="/assets/default/img/home/become_instructor.svg" class="img-cover rounded-circle" alt="user"></div>
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

        {{-- Forum --}}
        @if ($homeSection->name == \App\Models\HomeSection::$forum_section && !empty($forumSection))
            <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                        <div class="position-relative">
                            <img src="{{ $forumSection['image'] }}" class="find-instructor-section-hero" alt="{{ $forumSection['title'] }}">
                            <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle">
                            <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <h2 class="font-36 font-weight-bold text-dark">{{ $forumSection['title'] ?? '' }}</h2>
                        <p class="font-16 font-weight-normal text-gray mt-10">{{ $forumSection['description'] ?? '' }}</p>
                        <div class="mt-35 d-flex align-items-center flex-wrap gap-10">
                            @if (!empty($forumSection['button1']['title']) && !empty($forumSection['button1']['link']))
                                <a href="{{ $forumSection['button1']['link'] }}" class="btn btn-primary mr-15">{{ $forumSection['button1']['title'] }}</a>
                            @endif
                            @if (!empty($forumSection['button2']['title']) && !empty($forumSection['button2']['link']))
                                <a href="{{ $forumSection['button2']['link'] }}" class="btn btn-outline-primary">{{ $forumSection['button2']['title'] }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Video or Image --}}
        @if ($homeSection->name == \App\Models\HomeSection::$video_or_image_section && !empty($boxVideoOrImage))
            <section class="home-sections home-sections-swiper position-relative">
                <div class="home-video-mask"></div>
                <div class="container home-video-container d-flex flex-column align-items-center justify-content-center position-relative" style="background-image:url('{{ $boxVideoOrImage['background'] ?? '' }}')">
                    <a href="{{ $boxVideoOrImage['link'] ?? '' }}" class="home-video-play-button d-flex align-items-center justify-content-center position-relative">
                        <i data-feather="play" width="36" height="36"></i>
                    </a>
                    <div class="mt-50 pt-10 text-center">
                        <h2 class="home-video-title">{{ $boxVideoOrImage['title'] ?? '' }}</h2>
                        <p class="home-video-hint mt-10">{{ $boxVideoOrImage['description'] ?? '' }}</p>
                    </div>
                </div>
            </section>
        @endif

        {{-- Half Ad Banner --}}
        @if ($homeSection->name == \App\Models\HomeSection::$half_advertising_banner && !empty($advertisingBanners2) && count($advertisingBanners2))
            <div class="home-sections container">
                <div class="row">
                    @foreach ($advertisingBanners2 as $banner2)
                        <div class="col-{{ $banner2->size }}">
                            <a href="{{ $banner2->link }}"><img src="{{ $banner2->image }}" class="img-cover rounded-sm" alt="{{ $banner2->title }}"></a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Organizations --}}
        @if ($homeSection->name == \App\Models\HomeSection::$organizations && !empty($organizations) && !$organizations->isEmpty())
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
