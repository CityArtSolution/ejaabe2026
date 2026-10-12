@php
    if (empty($authUser) and auth()->check()) {
        $authUser = auth()->user();
    }

    $piLocale = app()->getLocale();
    $piBase = '/' . $piLocale;
    $piCurrentPath = trim(request()->path(), '/');
    $piCurrentQuery = request()->query();
    $piLogo = !empty($generalSettings['logo']) ? $generalSettings['logo'] : null;
    $piSiteName = !empty($generalSettings['site_name']) ? $generalSettings['site_name'] : '';
    $piQuoteUrl = $piBase . '/request-quotation';

    $piIsActive = function ($url) use ($piLocale, $piCurrentPath, $piCurrentQuery) {
        if (Illuminate\Support\Str::contains($url, 'https://')) {
            return false;
        }

        $path = trim((string) parse_url($url, PHP_URL_PATH), '/');

        if ($path === $piLocale) {
            return in_array($piCurrentPath, ['', $piLocale], true);
        }

        if ($path !== $piCurrentPath) {
            return false;
        }

        parse_str((string) parse_url($url, PHP_URL_QUERY), $query);

        foreach ($query as $key => $value) {
            if (!array_key_exists($key, $piCurrentQuery) or $piCurrentQuery[$key] != $value) {
                return false;
            }
        }

        return true;
    };

    // روابط القائمة تُدار من لوحة التحكم (الأقسام الرئيسية) وتُعرض في الهيدر وقائمة الجوال
    $piMenu = [];
    $piHiddenSlugs = ['/lang-training/training'];

    if (!empty($categories) and count($categories)) {
        foreach ($categories as $category) {
            if (in_array($category->slug, $piHiddenSlugs)) {
                continue;
            }

            $piItem = ['title' => $category->title, 'url' => null, 'active' => false, 'children' => []];

            if (count($category->subCategories)) {
                foreach ($category->subCategories as $subCategory) {
                    if (in_array($subCategory->slug, $piHiddenSlugs)) {
                        continue;
                    }

                    $piChildUrl = $subCategory->getUrl();
                    $piChildActive = $piIsActive($piChildUrl);

                    $piItem['children'][] = [
                        'title' => $subCategory->title,
                        'url' => $piChildUrl,
                        'icon' => $subCategory->icon,
                        'active' => $piChildActive,
                    ];

                    $piItem['active'] = ($piItem['active'] or $piChildActive);
                }

                if (!count($piItem['children'])) {
                    continue;
                }
            } else {
                if (Illuminate\Support\Str::contains($category->slug, 'https://')) {
                    $piItem['url'] = $category->slug;
                } elseif (Illuminate\Support\Str::contains($category->slug, '/')) {
                    $piItem['url'] = $piBase;
                } else {
                    $piItem['url'] = $piBase . '/' . $category->slug;
                }

                $piItem['active'] = $piIsActive($piItem['url']);
            }

            $piMenu[] = $piItem;
        }

        // لا تطابق تام: نعتمد المسار وحده إن كان يخص رابطًا فرعيًا واحدًا فقط (مثل ‎/classes‎ دون ‎?sort=newest‎)
        if (!collect($piMenu)->contains('active', true)) {
            $piPathMatches = [];

            foreach ($piMenu as $piIndex => $piItem) {
                foreach ($piItem['children'] as $piChildIndex => $piChild) {
                    if (trim((string) parse_url($piChild['url'], PHP_URL_PATH), '/') === $piCurrentPath) {
                        $piPathMatches[] = [$piIndex, $piChildIndex];
                    }
                }
            }

            if (count($piPathMatches) === 1) {
                [$piIndex, $piChildIndex] = $piPathMatches[0];
                $piMenu[$piIndex]['active'] = true;
                $piMenu[$piIndex]['children'][$piChildIndex]['active'] = true;
            }
        }
    }
@endphp

@include('web.default.includes.pi_shared')

<style>
    /* =========================================================
       الهيدر
       ========================================================= */
    .pi-header, .pi-drawer { font-family: var(--pi-f-body); -webkit-font-smoothing: antialiased; text-align: start; }
    .pi-header *, .pi-header *::before, .pi-header *::after,
    .pi-drawer *, .pi-drawer *::before, .pi-drawer *::after { box-sizing: border-box; }
    .pi-header ul, .pi-drawer ul { margin: 0; padding: 0; list-style: none; }
    .pi-header a, .pi-header a:hover, .pi-drawer a, .pi-drawer a:hover { text-decoration: none; }
    .pi-header span, .pi-drawer span { font-family: inherit; }
    .pi-header svg, .pi-drawer svg { flex: none; }

    /* app.css يجعل body حاوية تمرير (overflow: hidden) فلا يعمل position: sticky؛
       لذلك يُثبَّت الهيدر بـ fixed عند التمرير ويحجز #navbarVacuum مكانه */
    .pi-header {
        position: relative; z-index: 491;
        background-color: var(--pi-c-bg);
        transition: background-color .35s var(--pi-ease), box-shadow .35s var(--pi-ease);
    }
    .pi-header.is-scrolled {
        position: fixed; top: 0; left: 0; right: 0;
        background-color: rgba(255, 255, 255, .92);
        box-shadow: 0 6px 24px rgba(12, 43, 74, .08);
        backdrop-filter: saturate(1.4) blur(10px);
        -webkit-backdrop-filter: saturate(1.4) blur(10px);
    }
    /* القائمة بجوار الشعار مباشرة، وما بعدها (أيقونات اللوحة) يُدفع لنهاية السطر */
    .pi-header .pi-nav { height: var(--pi-header-h); display: flex; align-items: center; justify-content: flex-start; gap: clamp(24px, 3.5vw, 48px); }
    .pi-header .pi-brand { display: flex; align-items: center; flex: none; }
    .pi-header .pi-brand img { height: 46px; width: auto; max-width: 220px; object-fit: contain; transition: height .3s var(--pi-ease); }
    .pi-header.is-scrolled .pi-brand img { height: 40px; }

    .pi-header .pi-nav-main { align-self: stretch; margin-inline-end: auto; }
    .pi-header .pi-nav-links { height: 100%; display: flex; align-items: stretch; gap: clamp(10px, 2vw, 30px); }
    .pi-header .pi-nav-links > li { position: relative; display: flex; align-items: center; }
    .pi-header .pi-nav-links > li > a,
    .pi-header .pi-nav-toggle {
        position: relative; display: inline-flex; align-items: center; gap: 4px;
        padding: 6px 0; margin: 0; border: 0; background: none; cursor: pointer; white-space: nowrap;
        font-family: var(--pi-f-display); font-weight: 500; font-size: var(--pi-fs-sm); line-height: 1.75;
        color: var(--pi-c-blue-800); transition: color .2s;
    }
    .pi-header .pi-nav-links > li > a::after,
    .pi-header .pi-nav-toggle::after {
        content: ""; position: absolute; inset-inline: 0; bottom: 0; height: 2px; border-radius: 2px;
        background: var(--pi-c-orange); transform: scaleX(0); transform-origin: right; transition: transform .3s var(--pi-ease);
    }
    body:not(.rtl) .pi-header .pi-nav-links > li > a::after,
    body:not(.rtl) .pi-header .pi-nav-toggle::after { transform-origin: left; }
    .pi-header .pi-nav-links > li > a:hover,
    .pi-header .pi-nav-links > li > a.is-active,
    .pi-header .pi-has-sub:hover > .pi-nav-toggle,
    .pi-header .pi-has-sub.is-open > .pi-nav-toggle,
    .pi-header .pi-nav-toggle.is-active { color: var(--pi-c-orange-600); }
    .pi-header .pi-nav-links > li > a:hover::after,
    .pi-header .pi-nav-links > li > a.is-active::after,
    .pi-header .pi-has-sub:hover > .pi-nav-toggle::after,
    .pi-header .pi-has-sub.is-open > .pi-nav-toggle::after,
    .pi-header .pi-nav-toggle.is-active::after { transform: scaleX(1); }
    .pi-header .pi-nav-toggle svg { width: 14px; height: 14px; transition: transform .3s var(--pi-ease); }
    .pi-header .pi-has-sub:hover > .pi-nav-toggle svg,
    .pi-header .pi-has-sub.is-open > .pi-nav-toggle svg { transform: rotate(180deg); }

    /* القوائم الفرعية */
    .pi-header .pi-sub {
        position: absolute; top: 100%; inset-inline-start: -14px; z-index: 5; min-width: 250px;
        display: grid; gap: 2px; padding: 8px;
        background: #fff; border: 1px solid var(--pi-c-line); border-radius: var(--pi-r-md); box-shadow: var(--pi-shadow-lg);
        opacity: 0; visibility: hidden; transform: translateY(8px);
        transition: opacity .25s var(--pi-ease), transform .25s var(--pi-ease), visibility .25s;
    }
    .pi-header .pi-has-sub:hover > .pi-sub,
    .pi-header .pi-has-sub:focus-within > .pi-sub,
    .pi-header .pi-has-sub.is-open > .pi-sub { opacity: 1; visibility: visible; transform: none; }
    .pi-header .pi-sub a {
        display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: 8px; white-space: nowrap;
        font-size: var(--pi-fs-sm); font-weight: 500; line-height: 1.6; color: var(--pi-c-blue-800);
        transition: color .2s;
    }
    .pi-header .pi-sub-text { position: relative; padding-block: 3px; }
    .pi-header .pi-sub-text::after {
        content: ""; position: absolute; inset-inline: 0; bottom: 0; height: 2px; border-radius: 2px;
        background: var(--pi-c-orange); transform: scaleX(0); transform-origin: right; transition: transform .3s var(--pi-ease);
    }
    body:not(.rtl) .pi-header .pi-sub-text::after { transform-origin: left; }
    .pi-header .pi-sub a:hover, .pi-header .pi-sub a.is-active { color: var(--pi-c-orange-600); }
    .pi-header .pi-sub a:hover .pi-sub-text::after, .pi-header .pi-sub a.is-active .pi-sub-text::after { transform: scaleX(1); }
    .pi-header .pi-sub img, .pi-drawer .pi-drawer-sub img { width: 20px; height: 20px; object-fit: contain; flex: none; }

    .pi-header .pi-nav-cta { display: none; }
    .pi-header .pi-menu-btn {
        display: none; flex: none; width: 46px; height: 46px; padding: 0; border-radius: 12px; border: 1px solid var(--pi-c-line);
        background: #fff; color: var(--pi-c-blue); align-items: center; justify-content: center; cursor: pointer;
    }
    .pi-header .pi-menu-btn svg { width: 24px; height: 24px; }

    /* =========================================================
       القائمة الجانبية للجوال
       ========================================================= */
    .pi-drawer-backdrop {
        position: fixed; inset: 0; background: rgba(9, 35, 62, .5); z-index: 1040;
        opacity: 0; visibility: hidden; transition: opacity .3s, visibility .3s;
    }
    .pi-drawer {
        position: fixed; top: 0; bottom: 0; inset-inline-start: 0; z-index: 1050; width: min(320px, 86vw);
        background: #fff; box-shadow: var(--pi-shadow-lg);
        padding: calc(18px + env(safe-area-inset-top, 0px)) 22px calc(24px + env(safe-area-inset-bottom, 0px));
        transform: translateX(105%); visibility: hidden;
        transition: transform .4s var(--pi-ease), visibility .4s;
        display: flex; flex-direction: column; gap: 18px; overflow-y: auto;
    }
    body:not(.rtl) .pi-drawer { transform: translateX(-105%); }
    .pi-drawer .pi-drawer-top { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .pi-drawer .pi-drawer-top img { height: 40px; width: auto; max-width: 190px; object-fit: contain; }
    .pi-drawer .pi-drawer-close {
        flex: none; width: 42px; height: 42px; padding: 0; border-radius: 10px; border: 1px solid var(--pi-c-line);
        background: #fff; color: var(--pi-c-petrol); display: grid; place-items: center; cursor: pointer;
    }
    .pi-drawer .pi-drawer-close svg { width: 20px; height: 20px; }
    .pi-drawer nav > a,
    .pi-drawer summary {
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        padding: 13px 4px; border-bottom: 1px solid var(--pi-c-line); cursor: pointer;
        font-family: var(--pi-f-display); font-weight: 600; font-size: 1.0625rem; line-height: 1.75; color: var(--pi-c-petrol);
        transition: color .2s;
    }
    .pi-drawer summary { list-style: none; }
    .pi-drawer summary::-webkit-details-marker { display: none; }
    .pi-drawer nav > a:hover, .pi-drawer nav > a.is-active,
    .pi-drawer summary:hover, .pi-drawer summary.is-active,
    .pi-drawer details[open] > summary { color: var(--pi-c-orange-600); }
    .pi-drawer nav > a svg, .pi-drawer summary svg { width: 16px; height: 16px; opacity: .5; transition: transform .3s var(--pi-ease); }
    body:not(.rtl) .pi-drawer nav > a svg { transform: scaleX(-1); }
    .pi-drawer details[open] > summary svg { transform: rotate(180deg); }
    .pi-drawer .pi-drawer-sub { display: grid; gap: 2px; padding: 8px 12px 10px; border-bottom: 1px solid var(--pi-c-line); background: var(--pi-c-bg); }
    .pi-drawer .pi-drawer-sub a {
        display: flex; align-items: center; gap: 10px; padding: 9px 4px;
        font-size: var(--pi-fs-sm); font-weight: 500; line-height: 1.6; color: var(--pi-c-petrol); transition: color .2s;
    }
    .pi-drawer .pi-drawer-sub a:hover, .pi-drawer .pi-drawer-sub a.is-active { color: var(--pi-c-orange-600); }
    .pi-drawer .pi-btn { width: 100%; flex: none; }
    body.pi-drawer-open { overflow: hidden; }
    body.pi-drawer-open .pi-drawer { transform: translateX(0); visibility: visible; }
    body.pi-drawer-open .pi-drawer-backdrop { opacity: 1; visibility: visible; }

    @media (max-width: 1100px) {
        .pi-header .pi-nav-main { display: none; }
        .pi-header .pi-menu-btn { display: inline-flex; }
        .pi-header .pi-nav-cta { display: inline-flex; margin-inline-start: auto; }
    }
    @media (max-width: 760px) {
        .pi-header .pi-brand img { height: 38px; max-width: 170px; }
        .pi-header .pi-nav-cta { display: none; }
        .pi-header .pi-menu-btn { margin-inline-start: auto; }
    }
</style>

<div id="navbarVacuum"></div>
<header id="navbar" class="pi-header">
    <div class="pi-container pi-nav {{ (!empty($isPanel) and $isPanel) ? 'pi-container--fluid' : '' }}">
        <a class="pi-brand" href="{{ $piBase }}" aria-label="{{ $piSiteName }}">
            @if(!empty($piLogo))
                <img src="{{ $piLogo }}" alt="{{ $piSiteName }}">
            @endif
        </a>

        <nav class="pi-nav-main" aria-label="{{ trans('navbar.main_menu') }}">
            <ul class="pi-nav-links">
                @foreach($piMenu as $piItem)
                    @if(count($piItem['children']))
                        <li class="pi-has-sub">
                            <button type="button" class="pi-nav-toggle {{ $piItem['active'] ? 'is-active' : '' }}" aria-haspopup="true" aria-expanded="false">
                                {{ $piItem['title'] }}
                                <svg aria-hidden="true"><use href="#pi-i-down"/></svg>
                            </button>

                            <ul class="pi-sub">
                                @foreach($piItem['children'] as $piChild)
                                    <li>
                                        <a href="{{ $piChild['url'] }}" class="{{ $piChild['active'] ? 'is-active' : '' }}">
                                            @if(!empty($piChild['icon']))
                                                <img src="{{ $piChild['icon'] }}" alt="">
                                            @endif

                                            <span class="pi-sub-text">{{ $piChild['title'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li>
                            <a href="{{ $piItem['url'] }}" class="{{ $piItem['active'] ? 'is-active' : '' }}" @if($piItem['active']) aria-current="page" @endif>{{ $piItem['title'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>

        @if(!empty($isPanel))
            <div class="nav-icons-or-start-live navbar-order d-flex align-items-center justify-content-end">
                @if($authUser->checkAccessToAIContentFeature())
                    <div class="js-show-ai-content-drawer show-ai-content-drawer-btn d-flex-center mr-40">
                        <div class="d-flex-center size-32 rounded-circle bg-white">
                            <img src="/assets/default/img/ai/ai-chip.svg" alt="ai" class="" width="16px" height="16px">
                        </div>
                        <span class="ml-5 font-weight-500 text-secondary font-14 d-none d-lg-block">{{ trans('update.ai_content') }}</span>
                    </div>
                @endif

                <div class="d-none nav-notify-cart-dropdown top-navbar">
                    @include('web.default.includes.shopping-cart-dropdwon')

                    <div class="border-left mx-15"></div>

                    @include('web.default.includes.notification-dropdown')
                </div>
            </div>
        @endif

        <a href="{{ $piQuoteUrl }}" class="pi-btn pi-btn--orange pi-btn--sm pi-nav-cta">{{ trans('navbar.request_quote') }}</a>

        <button type="button" class="pi-menu-btn" id="piMenuBtn" aria-label="{{ trans('navbar.open_menu') }}" aria-expanded="false" aria-controls="piDrawer">
            <svg aria-hidden="true"><use href="#pi-i-menu"/></svg>
        </button>
    </div>
</header>

{{-- القائمة الجانبية للجوال --}}
<div class="pi-drawer-backdrop" id="piDrawerBackdrop"></div>
<aside class="pi-drawer" id="piDrawer" aria-label="{{ trans('navbar.main_menu') }}" aria-hidden="true">
    <div class="pi-drawer-top">
        @if(!empty($piLogo))
            <img src="{{ $piLogo }}" alt="{{ $piSiteName }}">
        @endif

        <button type="button" class="pi-drawer-close" id="piDrawerClose" aria-label="{{ trans('navbar.close_menu') }}">
            <svg aria-hidden="true"><use href="#pi-i-close"/></svg>
        </button>
    </div>

    <nav>
        @foreach($piMenu as $piItem)
            @if(count($piItem['children']))
                <details @if($piItem['active']) open @endif>
                    <summary class="{{ $piItem['active'] ? 'is-active' : '' }}">
                        {{ $piItem['title'] }}
                        <svg aria-hidden="true"><use href="#pi-i-down"/></svg>
                    </summary>

                    <div class="pi-drawer-sub">
                        @foreach($piItem['children'] as $piChild)
                            <a href="{{ $piChild['url'] }}" class="{{ $piChild['active'] ? 'is-active' : '' }}">
                                @if(!empty($piChild['icon']))
                                    <img src="{{ $piChild['icon'] }}" alt="">
                                @endif

                                {{ $piChild['title'] }}
                            </a>
                        @endforeach
                    </div>
                </details>
            @else
                <a href="{{ $piItem['url'] }}" class="{{ $piItem['active'] ? 'is-active' : '' }}">
                    {{ $piItem['title'] }}
                    <svg aria-hidden="true"><use href="#pi-i-arrow"/></svg>
                </a>
            @endif
        @endforeach
    </nav>

    <a href="{{ $piQuoteUrl }}" class="pi-btn pi-btn--orange">{{ trans('navbar.request_quote') }}</a>
</aside>

@push('scripts_bottom')
    <script src="/assets/default/js/parts/navbar.min.js"></script>

    <script>
        (function () {
            'use strict';

            var header = document.getElementById('navbar');
            var vacuum = document.getElementById('navbarVacuum');
            var menuBtn = document.getElementById('piMenuBtn');
            var drawer = document.getElementById('piDrawer');
            var drawerClose = document.getElementById('piDrawerClose');
            var backdrop = document.getElementById('piDrawerBackdrop');

            if (!header || !vacuum || !menuBtn || !drawer) return;

            /* ---------- تثبيت الهيدر عند التمرير ---------- */
            // navbar.min.js يستخدم window.onscroll، لذلك نضيف مستمعًا مستقلًا
            var onScroll = function () {
                var y = window.scrollY || window.pageYOffset;
                var stuck = y > 0 && vacuum.getBoundingClientRect().top <= 0;
                vacuum.style.height = stuck ? header.offsetHeight + 'px' : '0px';
                header.classList.toggle('is-scrolled', stuck);
            };
            window.addEventListener('scroll', onScroll, {passive: true});
            onScroll();

            /* ---------- القائمة الجانبية للجوال ---------- */
            var setDrawer = function (open) {
                document.body.classList.toggle('pi-drawer-open', open);
                menuBtn.setAttribute('aria-expanded', String(open));
                drawer.setAttribute('aria-hidden', String(!open));
                if (open) { drawerClose.focus(); } else { menuBtn.focus({preventScroll: true}); }
            };
            menuBtn.addEventListener('click', function () { setDrawer(true); });
            drawerClose.addEventListener('click', function () { setDrawer(false); });
            backdrop.addEventListener('click', function () { setDrawer(false); });

            /* ---------- القوائم الفرعية (النقر/اللمس؛ المرور بالفأرة عبر CSS) ---------- */
            var subs = Array.prototype.slice.call(header.querySelectorAll('.pi-has-sub'));
            var closeSubs = function (except) {
                subs.forEach(function (li) {
                    if (li === except) return;
                    li.classList.remove('is-open');
                    li.querySelector('.pi-nav-toggle').setAttribute('aria-expanded', 'false');
                });
            };
            subs.forEach(function (li) {
                var toggle = li.querySelector('.pi-nav-toggle');
                toggle.addEventListener('click', function () {
                    var open = !li.classList.contains('is-open');
                    closeSubs(li);
                    li.classList.toggle('is-open', open);
                    toggle.setAttribute('aria-expanded', String(open));
                });
            });
            document.addEventListener('click', function (e) {
                if (!e.target.closest || !e.target.closest('.pi-has-sub')) closeSubs();
            });

            document.addEventListener('keydown', function (e) {
                if (e.key !== 'Escape') return;
                if (document.body.classList.contains('pi-drawer-open')) setDrawer(false);
                closeSubs();
                if (document.activeElement && header.contains(document.activeElement)) document.activeElement.blur();
            });
        })();
    </script>
@endpush
