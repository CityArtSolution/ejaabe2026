@php
    $piLocale = app()->getLocale();
    $piBase = '/' . $piLocale;
    $piLogo = !empty($generalSettings['logo']) ? $generalSettings['logo'] : null;
    $piSiteName = !empty($generalSettings['site_name']) ? $generalSettings['site_name'] : '';
    $piSiteEmail = !empty($generalSettings['site_email']) ? $generalSettings['site_email'] : 'info@ejaabi.com';
    $piSitePhone = !empty($generalSettings['site_phone']) ? $generalSettings['site_phone'] : '966-566111404';
    $piSitePhone = '+' . ltrim($piSitePhone, '+');

    $piSocials = [
        ['icon' => 'pi-i-x', 'label' => 'X', 'url' => 'https://twitter.com/ejaabi'],
        ['icon' => 'pi-i-in', 'label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/company/ejaabi'],
        ['icon' => 'pi-i-ig', 'label' => 'Instagram', 'url' => 'https://www.instagram.com/ejaabi_sa/?hl=en'],
        ['icon' => 'pi-i-fb', 'label' => 'Facebook', 'url' => 'https://www.facebook.com/EjabeeInteraction'],
        ['icon' => 'pi-i-snap', 'label' => 'Snapchat', 'url' => 'https://t.snapchat.com/6OG4LLJP'],
    ];

    $piPolicies = [
        ['title' => __('home.privacy_policy'), 'url' => $piBase . '/pages/policy'],
        ['title' => __('home.intellectual_property'), 'url' => $piBase . '/pages/alaltzam-bhkok-almlky-alfkry'],
        ['title' => __('home.tech_support'), 'url' => $piBase . '/pages/support-policy'],
        ['title' => __('footer.academic_integrity'), 'url' => $piBase . '/pages/nazaha-policy'],
        ['title' => __('footer.virtual_attendance'), 'url' => $piBase . '/pages/syas-alhdor-alaftrady'],
        ['title' => __('footer.elearning_policy'), 'url' => $piBase . '/pages/elearning'],
        ['title' => __('footer.trainers_plan'), 'url' => $piBase . '/pages/kht-tdryb-almdrbyn'],
        ['title' => __('home.terms'), 'url' => $piBase . '/pages/terms-and-conditions'],
    ];

    $piSections = [
        ['title' => __('home.courses'), 'url' => $piBase . '/classes'],
        ['title' => __('home.about_us'), 'url' => $piBase . '/about'],
        ['title' => __('home.contact_us'), 'url' => $piBase . '/contact'],
        ['title' => __('home.join_trainer'), 'url' => '/become-instructor'],
        ['title' => __('home.blog'), 'url' => $piBase . '/blog'],
    ];
@endphp

@include('web.default.includes.pi_shared')

<style>
    /* =========================================================
       الفوتر
       ========================================================= */
    .pi-footer {
        position: relative; overflow: hidden; background: var(--pi-c-navy); color: #c9d8e6; text-align: start;
        font-family: var(--pi-f-body); font-size: 1.0625rem; line-height: 1.75; -webkit-font-smoothing: antialiased;
    }
    .pi-footer *, .pi-footer *::before, .pi-footer *::after { box-sizing: border-box; }
    .pi-footer::before {
        content: ""; position: absolute; inset: 0; pointer-events: none; opacity: .5;
        background: radial-gradient(40% 60% at 10% 0%, rgba(0, 107, 163, .35), transparent 70%);
    }
    .pi-footer ul { margin: 0; padding: 0; list-style: none; }
    .pi-footer p { margin: 0; }
    .pi-footer p, .pi-footer span, .pi-footer li { font-family: inherit; }
    .pi-footer a, .pi-footer a:hover { text-decoration: none; }
    .pi-footer img { max-width: 100%; display: block; }

    .pi-footer .pi-footer-grid { position: relative; display: grid; grid-template-columns: 1.2fr 1fr 1fr 1.3fr; gap: 36px; padding-block: 56px 40px; }
    .pi-footer .pi-footer-brand { display: grid; gap: 14px; align-content: start; }
    .pi-footer .pi-logo-plate { display: block; background: #fff; border-radius: 12px; padding: 10px 14px; width: fit-content; }
    .pi-footer .pi-logo-plate img { height: 44px; width: auto; }
    .pi-footer .pi-footer-brand p { font-size: var(--pi-fs-sm); line-height: 1.8; color: #a9bfd3; max-width: 34ch; }
    .pi-footer .pi-socials { display: flex; flex-wrap: wrap; gap: 8px; }
    .pi-footer .pi-socials a {
        width: 38px; height: 38px; border-radius: 10px; display: grid; place-items: center;
        background: rgba(255, 255, 255, .07); color: #fff; transition: background-color .25s, transform .25s;
    }
    .pi-footer .pi-socials a:hover { background: var(--pi-c-orange); color: #fff; transform: translateY(-3px); }
    .pi-footer .pi-socials svg { width: 17px; height: 17px; }

    .pi-footer .pi-f-title {
        display: inline-block; margin: 0 0 16px; padding: 6px 22px; border-radius: 6px; background: var(--pi-c-blue); color: #fff;
        font-family: var(--pi-f-display); font-weight: 700; font-size: var(--pi-fs-sm); line-height: 1.75;
    }
    .pi-footer .pi-f-col ul { display: grid; gap: 7px; }
    .pi-footer .pi-f-col li a { font-size: var(--pi-fs-sm); color: #c9d8e6; transition: color .2s, padding .25s var(--pi-ease); }
    .pi-footer .pi-f-col li a:hover { color: var(--pi-c-orange); padding-inline-start: 6px; }

    .pi-footer .pi-newsletter p { font-size: var(--pi-fs-sm); margin-bottom: 4px; color: #fff; }
    .pi-footer .pi-newsletter small { display: block; color: #3d9bd8; font-size: var(--pi-fs-xs); margin-bottom: 12px; }
    .pi-footer .pi-nl-form { display: grid; gap: 10px; margin: 0; }
    .pi-footer .pi-nl-form input {
        width: 100%; height: 46px; border-radius: 8px; border: 1px solid rgba(255, 255, 255, .08);
        background: #0f3456; color: #fff; padding-inline: 14px; font: inherit; font-size: var(--pi-fs-sm);
    }
    .pi-footer .pi-nl-form input::placeholder { color: #6f8ea8; }
    .pi-footer .pi-nl-form input:focus { outline: 2px solid var(--pi-c-sky); outline-offset: 1px; }
    .pi-footer .pi-nl-form .pi-btn { width: 100%; }

    .pi-footer .pi-footer-bottom {
        position: relative; background: var(--pi-c-navy-900); color: #6d8aa6; font-size: var(--pi-fs-xs);
        padding-block: 16px calc(16px + env(safe-area-inset-bottom, 0px));
    }
    .pi-footer .pi-footer-bottom .pi-container { display: flex; justify-content: space-between; gap: 10px 24px; flex-wrap: wrap; }
    .pi-footer .pi-footer-contact { display: flex; flex-wrap: wrap; gap: 6px 20px; }
    .pi-footer .pi-footer-bottom a { color: inherit; transition: color .2s; }
    .pi-footer .pi-footer-bottom a:hover { color: #fff; }

    /* زر العودة للأعلى */
    .pi-to-top {
        position: fixed; left: 18px; bottom: calc(18px + env(safe-area-inset-bottom, 0px)); z-index: 40;
        width: 46px; height: 46px; padding: 0; border-radius: 12px; border: 0; background: var(--pi-c-orange); color: #fff; cursor: pointer;
        display: grid; place-items: center; box-shadow: var(--pi-shadow-md);
        opacity: 0; transform: translateY(16px); pointer-events: none; transition: opacity .3s, transform .3s var(--pi-ease);
    }
    .pi-to-top.is-shown { opacity: 1; transform: none; pointer-events: auto; }
    .pi-to-top svg { width: 20px; height: 20px; }

    @media (max-width: 1100px) {
        .pi-footer .pi-footer-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 520px) {
        .pi-footer .pi-footer-grid { grid-template-columns: 1fr; gap: 30px; }
    }
</style>

<footer class="pi-footer">
    <div class="pi-container pi-footer-grid">
        <div class="pi-footer-brand">
            @if(!empty($piLogo))
                <a class="pi-logo-plate" href="{{ $piBase }}" aria-label="{{ $piSiteName }}">
                    <img src="{{ $piLogo }}" alt="{{ $piSiteName }}" loading="lazy">
                </a>
            @endif

            <p>{{ trim(__('home.about_desc')) }}</p>

            <div class="pi-socials">
                @foreach($piSocials as $piSocial)
                    <a href="{{ $piSocial['url'] }}" target="_blank" rel="noopener" aria-label="{{ $piSocial['label'] }}">
                        <svg aria-hidden="true"><use href="#{{ $piSocial['icon'] }}"/></svg>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="pi-f-col">
            <h2 class="pi-f-title">{{ __('home.policies') }}</h2>
            <ul>
                @foreach($piPolicies as $piPolicy)
                    <li><a href="{{ $piPolicy['url'] }}">{{ $piPolicy['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="pi-f-col">
            <h2 class="pi-f-title">{{ __('home.site_sections') }}</h2>
            <ul>
                @foreach($piSections as $piSection)
                    <li><a href="{{ $piSection['url'] }}">{{ $piSection['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="pi-f-col pi-newsletter">
            <h2 class="pi-f-title">{{ __('footer.join_us') }}</h2>
            <p>{{ __('home.join_us_today') }}</p>
            <small>{{ __('home.newsletter_desc') }}</small>

            <form class="pi-nl-form" action="/newsletters" method="post">
                {{ csrf_field() }}

                <label for="piNlEmail" class="sr-only">{{ __('home.email_placeholder') }}</label>
                <input type="email" id="piNlEmail" name="newsletter_email" placeholder="{{ __('home.email_placeholder') }}" autocomplete="email" dir="auto" required>
                <button type="submit" class="pi-btn pi-btn--blue">{{ __('home.subscribe') }}</button>
            </form>
        </div>
    </div>

    <div class="pi-footer-bottom">
        <div class="pi-container">
            <span>{{ __('footer.rights_reserved', ['year' => date('Y')]) }}</span>
            <span>{{ __('footer.countries') }}</span>
            <span class="pi-footer-contact">
                <a href="mailto:{{ $piSiteEmail }}">{{ $piSiteEmail }}</a>
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $piSitePhone) }}" dir="ltr">{{ $piSitePhone }}</a>
            </span>
        </div>
    </div>
</footer>

<button type="button" class="pi-to-top" id="piToTop" aria-label="{{ __('footer.back_to_top') }}">
    <svg aria-hidden="true"><use href="#pi-i-up"/></svg>
</button>

@push('scripts_bottom')
    <script>
        (function () {
            'use strict';

            var toTop = document.getElementById('piToTop');
            if (!toTop) return;

            var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var onScroll = function () {
                toTop.classList.toggle('is-shown', (window.scrollY || window.pageYOffset) > 700);
            };
            window.addEventListener('scroll', onScroll, {passive: true});
            onScroll();

            toTop.addEventListener('click', function () {
                window.scrollTo({top: 0, behavior: reduceMotion ? 'auto' : 'smooth'});
            });
        })();
    </script>
@endpush
