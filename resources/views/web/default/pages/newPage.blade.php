@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">

    @include('web.default.pages.includes.home_pi_styles')
@endpush

@php
    $piLocale = app()->getLocale();
    $piBase = '/' . $piLocale;
    // خارج ‎/public/assets‎ لأن ‎.gitignore‎ يتجاهل الملفات الجديدة هناك فلا تصل للسيرفر
    $piImg = '/home-pi';
    $piEnabledSections = $homeSections->pluck('name')->toArray();

    $piContactUrl = $piBase . '/contact';
    $piPlanUrl = $piBase . '/cet-course/plan';

    $piSteps = [
        ['icon' => 'pi-i-target', 'title' => __('home.plan_step_1')],
        ['icon' => 'pi-i-doc', 'title' => __('home.plan_step_2')],
        ['icon' => 'pi-i-group', 'title' => __('home.plan_step_3')],
        ['icon' => 'pi-i-chart', 'title' => __('home.plan_step_4')],
    ];

    $piOrgFeatures = [
        ['icon' => 'pi-i-search', 'tag' => __('home.Needs_analysis'), 'text' => __('home.Skills_gap')],
        ['icon' => 'pi-i-layers', 'tag' => __('home.Building_paths'), 'text' => __('home.Designing_customized')],
        ['icon' => 'pi-i-chart', 'tag' => __('home.Impact_measurement'), 'text' => __('home.Detailed_reports')],
    ];

    $piShowTrends = (in_array(\App\Models\HomeSection::$trend_categories, $piEnabledSections) and !empty($trendCategories) and count($trendCategories));
    // تظهر مع فلتر التصنيفات حتى لو لم يُرجع التصنيف المختار أي برنامج، وتختفي إن لم توجد برامج ولا تصنيفات
    $piShowTracks = (in_array(\App\Models\HomeSection::$latest_classes, $piEnabledSections)
        and ((!empty($latestWebinars) and count($latestWebinars)) or (!empty($trackCategories) and count($trackCategories))));
    $piShowPartners = (in_array(\App\Models\HomeSection::$instructors, $piEnabledSections) and !empty($showcasePartners) and count($showcasePartners));
    $piShowClients = (in_array(\App\Models\HomeSection::$testimonials, $piEnabledSections) and !empty($showcaseClients) and count($showcaseClients));

    // الفعاليات القادمة أولًا ثم المنتهية
    $piEvents = collect($events)->merge($oldEvents);
    $piShowEvents = (in_array(\App\Models\HomeSection::$store_products, $piEnabledSections) and $piEvents->isNotEmpty());
    $piToday = \Carbon\Carbon::now()->format('Y-m-d');
@endphp

@section('content')

    {{-- أيقونات SVG الخاصة بالصفحة الرئيسية --}}
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
            <symbol id="pi-i-arrow-r" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/></symbol>
            <symbol id="pi-i-pause" viewBox="0 0 24 24"><path fill="currentColor" d="M7 5h3.5v14H7zM13.5 5H17v14h-3.5z"/></symbol>
            <symbol id="pi-i-play" viewBox="0 0 24 24"><path fill="currentColor" d="M8 5.5v13l11-6.5z"/></symbol>
            <symbol id="pi-i-train" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4M7 9l3 2-3 2M12 13h4"/></g></symbol>
            <symbol id="pi-i-cert" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="5"/><path d="M9 13.5L7.5 21l4.5-2.5 4.5 2.5-1.5-7.5"/><path d="M10 9l1.5 1.5L14.5 7.5"/></g></symbol>
            <symbol id="pi-i-book" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5z"/><path d="M4 20.5A2.5 2.5 0 0 0 6.5 23H20v-5M9 8h7M9 12h5"/></g></symbol>
            <symbol id="pi-i-target" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="4"/><path d="M12 12l7-7M16 5h3v3"/></g></symbol>
            <symbol id="pi-i-doc" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="13" height="18" rx="2"/><path d="M8 8h5M8 12h5M8 16h3"/><path d="M15 17l5-5 1.5 1.5-5 5H15z"/></g></symbol>
            <symbol id="pi-i-group" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="11" rx="1.5"/><circle cx="8" cy="18" r="1.6"/><circle cx="12" cy="18" r="1.6"/><circle cx="16" cy="18" r="1.6"/><path d="M7 7h6M7 10h10"/></g></symbol>
            <symbol id="pi-i-chart" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h16"/><path d="M6 16v-3M10 16v-6M14 16v-4M18 16V7"/><path d="M5 10l5-4 4 3 5-5"/></g></symbol>
            <symbol id="pi-i-search" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><circle cx="11" cy="11" r="6"/><path d="M20 20l-4.5-4.5"/></g></symbol>
            <symbol id="pi-i-layers" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><path d="M12 3l9 5-9 5-9-5z"/><path d="M3 13l9 5 9-5"/></g></symbol>
            <symbol id="pi-i-chat" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><path d="M4 5h16v11H9l-5 4z"/></g></symbol>
            <symbol id="pi-i-quote" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h9l4 4v14H6z"/><path d="M14 3v5h5M9 13h7M9 17h5"/></g></symbol>
            <symbol id="pi-i-clock" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></g></symbol>
            <symbol id="pi-i-calendar" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3.5" y="5" width="17" height="15.5" rx="2.5"/><path d="M3.5 10h17M8 3v4M16 3v4"/></g></symbol>
            <symbol id="pi-i-globe" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M3.5 12h17M12 3.5c2.6 2.7 2.6 14.3 0 17M12 3.5c-2.6 2.7-2.6 14.3 0 17"/></g></symbol>
            <symbol id="pi-i-timer" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 3.5h10M7 20.5h10M8 3.5v3.2c0 1.5 4 3.3 4 5.3s-4 3.8-4 5.3v3.2M16 3.5v3.2c0 1.5-4 3.3-4 5.3s4 3.8 4 5.3v3.2"/></g></symbol>
            <symbol id="pi-i-pin" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-6.5-5.6-6.5-10.5a6.5 6.5 0 0 1 13 0C18.5 15.4 12 21 12 21z"/><circle cx="12" cy="10.5" r="2.3"/></g></symbol>
        </defs>
    </svg>

    {{-- ============ 1) البانر الرئيسي ============ --}}
    @if (!empty($sliders) && count($sliders))
        <section class="pi-home pi-hero" aria-label="{{ __('home.slider_label') }}">
            <div class="pi-container">
                <div class="pi-slider {{ count($sliders) < 2 ? 'is-single' : '' }}" id="piHeroSlider" aria-roledescription="carousel">
                    @foreach ($sliders as $index => $slider)
                        @php
                            $piSlideTr = $slider->translate($piLocale) ?? $slider->translations->first();
                            // صورة اللغة خالية من النصوص ومهيّأة لوضع العنوان فوقها، ثم الصورة العامة، ثم صورة افتراضية
                            $piSlideImage = !empty($piSlideTr->image_locale) ? $piSlideTr->image_locale : (!empty($slider->image) ? $slider->image : $piImg . '/hero-1.jpg');
                            $piSlideHint = !empty($piSlideTr->sub_title) ? trim($piSlideTr->sub_title) : null;
                            $piSlideLong = mb_strlen((string) $slider->description) > 55;
                        @endphp

                        <article class="pi-slide {{ $index == 0 ? 'is-active is-first' : '' }} {{ $piSlideLong ? 'pi-slide--long' : '' }}" aria-roledescription="slide" aria-label="{{ $index + 1 }} / {{ count($sliders) }}" @if($index > 0) aria-hidden="true" @endif>
                            <div class="pi-slide-media">
                                <img src="{{ asset($piSlideImage) }}" data-pi-fallback="{{ $piImg }}/hero-1.jpg" alt="" @if($index == 0) fetchpriority="high" @else loading="lazy" @endif>
                            </div>

                            <div class="pi-slide-content">
                                <span class="pi-slide-eyebrow pi-anim">{{ $slider->title }}</span>

                                @if($index == 0)
                                    <h1 class="pi-anim">{{ $slider->description }}</h1>
                                @else
                                    <h2 class="pi-anim">{{ $slider->description }}</h2>
                                @endif

                                @if(!empty($piSlideHint))
                                    <p class="pi-anim">{{ $piSlideHint }}</p>
                                @endif

                                @if(!empty($slider->button1_title) or !empty($slider->button2_title))
                                    <div class="pi-slide-actions pi-anim">
                                        @if(!empty($slider->button1_title))
                                            <a href="{{ !empty($slider->button1_link) ? $slider->button1_link : $piContactUrl }}" class="pi-btn pi-btn--orange">{{ $slider->button1_title }}</a>
                                        @endif

                                        @if(!empty($slider->button2_title))
                                            <a href="{{ !empty($slider->button2_link) ? $slider->button2_link : $piContactUrl }}" class="pi-btn pi-btn--white">{{ $slider->button2_title }}</a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach

                    <div class="pi-slider-ui">
                        <button type="button" class="pi-slider-arrow" data-pi-dir="prev" aria-label="{{ __('home.slide_prev') }}"><svg><use href="#pi-i-arrow-r"/></svg></button>
                        <div class="pi-slider-dots" role="tablist"></div>
                        <button type="button" class="pi-slider-arrow" data-pi-dir="next" aria-label="{{ __('home.slide_next') }}"><svg><use href="#pi-i-arrow"/></svg></button>
                        <button type="button" class="pi-slider-arrow" data-pi-toggle data-label-pause="{{ __('home.slider_pause') }}" data-label-play="{{ __('home.slider_play') }}" aria-label="{{ __('home.slider_pause') }}"><svg><use href="#pi-i-pause"/></svg></button>
                    </div>
                    <div class="pi-slider-progress" aria-hidden="true"></div>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ 2) الاعتمادات (مجالات التدريب) ============ --}}
    @if ($piShowTrends)
        <section class="pi-home pi-section pi-acc-section" aria-labelledby="piAccTitle">
            <div class="pi-container">
                <div class="pi-sec-head pi-reveal"><h2 id="piAccTitle">{{ trans('home.training_fields') }}</h2></div>

                <div class="pi-acc-grid">
                    @foreach ($trendCategories as $trend)
                        @if(!empty($trend->category))
                            <a href="{{ $piBase . $trend->category->getUrl() }}" class="pi-acc-card pi-reveal pi-reveal--zoom" style="--d:{{ $loop->index * .06 }}s">
                                <span class="pi-acc-icon"><img src="{{ $trend->getIcon() }}" alt="" loading="lazy"></span>
                                <span class="pi-acc-label">{{ $trend->category->title }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>

                <div class="pi-events-more pi-reveal" style="margin-top:46px">
                    <a href="{{ $piBase }}/classes" class="pi-btn pi-btn--blue">{{ __('home.browse_all') }}</a>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ 4) خطة البرامج التدريبية ============ --}}
    <section class="pi-home pi-section pi-plan" aria-labelledby="piPlanTitle">
        <div class="pi-container">
            <div class="pi-sec-head pi-sec-head--light pi-reveal">
                <h2 id="piPlanTitle">{{ __('home.training_plan_title') }}</h2>
                <p>{{ __('home.Choose_path') }}</p>
            </div>

            <div class="pi-plan-banner pi-reveal pi-reveal--zoom">
                <div class="pi-pb-img pi-pb-img--man"><img src="{{ $piImg }}/plan-man.jpg" alt="" loading="lazy"></div>

                <div class="pi-pb-body">
                    <ol class="pi-steps">
                        @foreach ($piSteps as $piStep)
                            <li class="pi-step">
                                <span class="pi-step-ico"><svg aria-hidden="true"><use href="#{{ $piStep['icon'] }}"/></svg><span class="pi-step-num">{{ $loop->iteration }}</span></span>
                                <h3>{{ $piStep['title'] }}</h3>
                            </li>
                        @endforeach
                    </ol>

                    <div class="pi-pb-actions">
                        <a href="{{ $piPlanUrl }}" class="pi-btn pi-btn--orange">{{ __('home.browse_training_plan') }}</a>
                        <a href="{{ $piPlanUrl }}" class="pi-btn pi-btn--outline">{{ __('home.book_seat') }}</a>
                    </div>
                </div>

                <div class="pi-pb-img pi-pb-img--screen"><img src="{{ $piImg }}/plan-screen.jpg" alt="" loading="lazy"></div>
            </div>

            {{-- برامج الخطة التدريبية مع فلتر التصنيفات --}}
            @if ($piShowTracks)
                <div class="pi-tracks" id="specialized-tracks">
                    @if (!empty($trackCategories) and count($trackCategories))
                        <form action="{{ url()->current() }}#specialized-tracks" method="GET" class="pi-tracks-filter pi-reveal">
                            <button type="submit" name="track_category" value="" class="pi-filter-btn {{ empty($selectedTrackCategory) ? 'is-active' : '' }}">{{ __('home.all') }}</button>

                            @foreach ($trackCategories as $trackCategory)
                                <button type="submit" name="track_category" value="{{ $trackCategory->id }}" class="pi-filter-btn {{ (string) $trackCategory->id === (string) ($selectedTrackCategory ?? '') ? 'is-active' : '' }}">{{ $trackCategory->title }}</button>
                            @endforeach
                        </form>
                    @endif

                    @if (!empty($latestWebinars) and count($latestWebinars))
                        <div class="pi-tracks-grid">
                            @foreach ($latestWebinars as $latestWebinar)
                                @php
                                    $piDetails = json_decode((string) $latestWebinar->details, true);
                                    $piDetail = is_array($piDetails) ? ($piDetails[0] ?? []) : [];
                                @endphp

                                <article class="pi-track-card pi-reveal" style="--d:{{ ($loop->index % 4) * .08 }}s">
                                    <div class="pi-track-top">
                                        <a href="{{ $latestWebinar->getUrl() }}" class="pi-track-media" tabindex="-1" aria-hidden="true">
                                            <img src="{{ $latestWebinar->getImage() }}" alt="" loading="lazy">
                                        </a>

                                        @if (isset($piDetail['price']) and is_numeric($piDetail['price']))
                                            <span class="pi-track-price">{{ number_format($piDetail['price'], 2) }} {{ trans('public.SAR') }}</span>
                                        @endif
                                    </div>

                                    <div class="pi-track-body">
                                        <h3><a href="{{ $latestWebinar->getUrl() }}">{{ $latestWebinar->title }}</a></h3>

                                        <ul class="pi-track-meta">
                                            @if (!empty($piDetail['date']))
                                                <li class="pi-meta-item"><svg aria-hidden="true"><use href="#pi-i-calendar"/></svg><span><small>{{ trans('public.Date') }}</small><b>{{ $piDetail['date'] }}</b></span></li>
                                            @endif

                                            @if (!empty($piDetail['start_time']) || !empty($piDetail['end_time']))
                                                <li class="pi-meta-item"><svg aria-hidden="true"><use href="#pi-i-clock"/></svg><span><small>{{ trans('public.Time') }}</small><b>{{ $piDetail['start_time'] ?? '---' }} - {{ $piDetail['end_time'] ?? '---' }}</b></span></li>
                                            @endif

                                            <li class="pi-meta-item"><svg aria-hidden="true"><use href="#pi-i-pin"/></svg><span><small>{{ trans('public.Location') }}</small><b>{{ $piDetail['location'] ?? '—' }}</b></span></li>

                                            <li class="pi-meta-item">
                                                <svg aria-hidden="true"><use href="#pi-i-globe"/></svg>
                                                <span>
                                                    <small>{{ trans('public.Language') }}</small>
                                                    <b>
                                                        @switch($piDetail['lang'] ?? '')
                                                            @case('AR') {{ trans('public.Arabic') }} @break
                                                            @case('EN') {{ trans('public.English') }} @break
                                                            @default {{ trans('public.Bilanguage') }}
                                                        @endswitch
                                                    </b>
                                                </span>
                                            </li>

                                            <li class="pi-meta-item"><svg aria-hidden="true"><use href="#pi-i-timer"/></svg><span><small>{{ trans('public.Duration') }}</small><b>{{ $piDetail['ndays'] ?? '—' }} {{ trans('public.Days') }}</b></span></li>
                                        </ul>

                                        <a href="{{ $latestWebinar->getUrl() }}" class="pi-btn pi-btn--blue pi-btn--sm">{{ trans('public.details') }}</a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <p class="pi-tracks-empty">{{ __('home.no_programs') }}</p>
                    @endif

                    <div class="pi-events-more pi-reveal">
                        <a href="{{ $piPlanUrl }}" class="pi-btn pi-btn--white">{{ __('home.Browse_programs') }}</a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @include('web.default.pages.includes.home_platform_sections')

    {{-- ============ 5) حلول المنظمات ============ --}}
    <section class="pi-home pi-section" aria-labelledby="piOrgTitle">
        <div class="pi-container">
            <div class="pi-org-card pi-reveal pi-reveal--start">
                <div class="pi-org-text">
                    <span class="pi-chip">{{ __('home.Solutions_organizations') }}</span>
                    <h2 id="piOrgTitle">{{ __('home.Programs_organization') }}</h2>
                    <p>{{ __('home.design_customized_training') }}</p>
                    <a href="{{ $piBase }}/request-consulting" class="pi-btn pi-btn--white">{{ __('home.Request_consultation') }}</a>
                </div>

                <div class="pi-org-features">
                    @foreach ($piOrgFeatures as $piFeature)
                        <div class="pi-org-feature pi-reveal pi-reveal--zoom" style="--d:{{ .3 + $loop->iteration * .12 }}s">
                            <span class="pi-tag">{{ $piFeature['tag'] }}</span>
                            <svg aria-hidden="true"><use href="#{{ $piFeature['icon'] }}"/></svg>
                            <p>{{ $piFeature['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============ 6) خدمات تطوير المحتوى ============ --}}
    <section class="pi-home pi-section pi-content-dev" aria-labelledby="piCdTitle">
        <div class="pi-container">
            <div class="pi-cd-card pi-reveal pi-reveal--end">
                <div class="pi-cd-text">
                    <h2 id="piCdTitle">{{ __('home.Content_development') }}</h2>
                    <p>{{ __('home.Integrated_solutions') }}</p>
                    <ul class="pi-cd-points">
                        <li>{{ __('home.training_packages') }}</li>
                        <li>{{ __('home.elearning_content') }}</li>
                        <li>{{ __('home.review_accreditation') }}</li>
                    </ul>
                    <div class="pi-cd-actions">
                        <a href="{{ $piBase }}/request-content-development" class="pi-btn pi-btn--white">{{ __('home.Request_now') }}</a>
                        <a href="{{ $piBase }}/content/content_development" class="pi-btn pi-btn--ghost">{{ __('home.view_service') }}</a>
                    </div>
                </div>

                <div class="pi-cd-media"><img src="{{ $piImg }}/content-dev.jpg" alt="" loading="lazy"></div>
            </div>
        </div>
    </section>

    {{-- ============ 7) طلب برنامج خاص ============ --}}
    <section class="pi-home pi-cta-strip" aria-labelledby="piCtaTitle">
        <div class="pi-container">
            <div class="pi-cta-box pi-reveal pi-reveal--zoom">
                <div>
                    <h2 id="piCtaTitle">{{ __('home.have_specific_training') }}</h2>
                    <p>{{ __('home.team_is_ready') }}</p>
                </div>

                <div class="pi-cta-actions">
                    <a href="{{ $piBase }}/request-quotation" class="pi-btn pi-btn--blue"><svg aria-hidden="true"><use href="#pi-i-quote"/></svg>{{ __('home.Request_quotation') }}</a>
                    <a href="{{ $piContactUrl }}" class="pi-btn pi-btn--outline"><svg aria-hidden="true"><use href="#pi-i-chat"/></svg>{{ __('home.Contact_us') }}</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ 8) شركاء النجاح ============ --}}
    @if ($piShowPartners)
        <section class="pi-home pi-logos-section" aria-labelledby="piPartnersTitle">
            <div class="pi-container">
                <div class="pi-logos-head pi-reveal"><h2 class="pi-kicker" id="piPartnersTitle">{{ trans('app.comapny') }}</h2></div>

                <div class="pi-logos-panel pi-reveal" style="--d:.12s">
                    <div class="pi-carousel" data-pi-carousel style="--per:{{ min(5, count($showcasePartners)) }};--per-m:{{ min(2, count($showcasePartners)) }}">
                        <ul class="pi-carousel-track">
                            @foreach ($showcasePartners as $showcaseItem)
                                <li class="pi-carousel-item">
                                    @if(!empty($showcaseItem->link))
                                        <a href="{{ $showcaseItem->link }}" target="_blank" rel="noopener" class="pi-logo-card"><img src="{{ $showcaseItem->image }}" alt="{{ $showcaseItem->title ?? '' }}" loading="lazy"></a>
                                    @else
                                        <div class="pi-logo-card"><img src="{{ $showcaseItem->image }}" alt="{{ $showcaseItem->title ?? '' }}" loading="lazy"></div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="pi-carousel-dots"></div>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ 9) نخبة من العملاء ============ --}}
    @if ($piShowClients)
        <section class="pi-home pi-logos-section" aria-labelledby="piClientsTitle">
            <div class="pi-container">
                <div class="pi-logos-head pi-reveal"><h2 class="pi-kicker pi-kicker--orange" id="piClientsTitle">{{ trans('app.clients') }}</h2></div>

                <div class="pi-logos-panel pi-logos-panel--gray pi-reveal" style="--d:.12s">
                    <div class="pi-carousel" data-pi-carousel style="--per:{{ min(5, count($showcaseClients)) }};--per-m:{{ min(2, count($showcaseClients)) }}">
                        <ul class="pi-carousel-track">
                            @foreach ($showcaseClients as $showcaseItem)
                                <li class="pi-carousel-item">
                                    @if(!empty($showcaseItem->link))
                                        <a href="{{ $showcaseItem->link }}" target="_blank" rel="noopener" class="pi-logo-card"><img src="{{ $showcaseItem->image }}" alt="{{ $showcaseItem->title ?? '' }}" loading="lazy"></a>
                                    @else
                                        <div class="pi-logo-card"><img src="{{ $showcaseItem->image }}" alt="{{ $showcaseItem->title ?? '' }}" loading="lazy"></div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="pi-carousel-dots"></div>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ 10) الفعاليات ============ --}}
    @if ($piShowEvents)
        <section class="pi-home pi-section pi-events" aria-labelledby="piEventsTitle">
            <div class="pi-container">
                <div class="pi-sec-head pi-reveal"><h2 id="piEventsTitle">{{ trans('events.events') }}</h2></div>

                <div class="pi-events-grid">
                    @foreach ($piEvents as $event)
                        @php
                            $piEventDate = \Carbon\Carbon::parse($event->start_date);
                            $piEventDay = $piEventDate->format('Y-m-d');
                            $piEventStatus = $piEventDay == $piToday ? 'current' : ($piEventDay > $piToday ? 'upcoming' : 'ended');
                            $piEventUrl = $piBase . '/event/' . $event->slug;
                        @endphp

                        <article class="pi-event-card pi-reveal" style="--d:{{ ($loop->index % 3) * .1 }}s">
                            <div class="pi-event-media">
                                <img src="{{ $event->image }}" alt="" loading="lazy">
                                <span class="pi-event-date"><b>{{ $piEventDate->format('d') }}</b><span>{{ $piEventDate->format('M Y') }}</span></span>
                                <span class="pi-event-status pi-event-status--{{ $piEventStatus }}">{{ __('home.event_' . $piEventStatus) }}</span>
                            </div>

                            <div class="pi-event-body">
                                <h3><a href="{{ $piEventUrl }}">{{ $event->title }}</a></h3>
                                <p>{{ truncate(trim(html_entity_decode(strip_tags($event->details))), 120) }}</p>

                                <div class="pi-event-meta">
                                    @if(!empty($event->time))
                                        <span><svg aria-hidden="true"><use href="#pi-i-clock"/></svg>{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</span>
                                    @endif

                                    @if(!empty($event->location))
                                        <span><svg aria-hidden="true"><use href="#pi-i-pin"/></svg>{{ $event->location }}</span>
                                    @endif
                                </div>

                                <a href="{{ $piEventUrl }}" class="pi-btn pi-btn--blue pi-btn--sm">{{ __('home.more_details') }}</a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="pi-events-more pi-reveal">
                    <a href="{{ route($piLocale === 'en' ? 'web.events.en' : 'web.events.ar') }}" class="pi-btn pi-btn--white">{{ __('home.view_all_events') }}</a>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
    <script src="/assets/default/js/parts/home.min.js"></script>

    @include('web.default.pages.includes.home_pi_scripts')
@endpush
