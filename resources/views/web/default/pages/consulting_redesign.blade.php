@extends(
    str_contains(request()->url(), 'egy') 
        ? getTemplate().'.layouts.egy_app' 
        : (str_contains(request()->url(), 'uae') 
            ? getTemplate().'.layouts.uae_app' 
            : getTemplate().'.layouts.app')
)
@php
    $ar = app()->getLocale() === 'ar';
    $locale = $ar ? 'ar' : 'en';

    $educational = trim($page->link, '/') === 'edcuational-cunsulting';

    // الحفاظ على بادئة الرابط الحالي، سواء pages أو content أو فرع.
    $currentPath = trim(request()->path(), '/');
    $lastSlash = strrpos($currentPath, '/');
    $basePath = $lastSlash === false
        ? ''
        : substr($currentPath, 0, $lastSlash);

    $guideUrl = url(($basePath ? $basePath . '/' : '') . 'daleel-alistsharat');
    $educationUrl = url(($basePath ? $basePath . '/' : '') . 'edcuational-cunsulting');
    $requestUrl = url($locale . '/request-consulting');

    $intro = $educational
        ? ($ar
            ? 'رؤية أوضح للتحديات التعليمية والتربوية، وخطوة أقرب إلى التطوير.'
            : 'A clearer perspective on educational challenges and your next steps.')
        : ($ar
            ? 'تعرّف على خدماتنا الاستشارية، وحدّد المسار المناسب لاحتياجاتك.'
            : 'Explore our consulting services and find the right direction for your needs.');
@endphp

@push('styles_top')
<style>
    .consult-page {
        --consult-accent: #136ba5;
        --consult-dark: #103957;
        --consult-soft: #edf5fb;
        color: #263b4b;
        background: #f5f7fa;
        padding-bottom: 64px;
        text-align: start;
    }

    .consult-page.is-educational {
        --consult-accent: #087d79;
        --consult-dark: #124944;
        --consult-soft: #eaf7f3;
    }

    .consult-page *,
    .consult-page *::before,
    .consult-page *::after {
        box-sizing: border-box;
    }

    .consult-page .consult-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        padding: 56px 0 76px;
        background: var(--consult-dark);
    }

    .consult-page .consult-hero::after {
        content: "";
        position: absolute;
        z-index: -1;
        width: 400px;
        height: 400px;
        inset-inline-end: -100px;
        top: -180px;
        border: 65px solid rgba(255, 255, 255, .045);
        border-radius: 50%;
        pointer-events: none;
    }

    .consult-page .consult-breadcrumb {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin-bottom: 30px;
        color: #dce8ef;
        font-size: 13px;
        line-height: 1.8;
    }

    .consult-page .consult-breadcrumb a {
        color: #fff;
        text-decoration: underline;
        text-underline-offset: 4px;
    }

    .consult-page .consult-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 7px 13px;
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 30px;
        color: #fff;
        font-size: 13px;
        margin-bottom: 18px;
    }

    .consult-page .consult-eyebrow::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #8eddd5;
    }

    .consult-page .consult-title {
        max-width: 850px;
        color: #fff;
        font-size: clamp(28px, 4vw, 44px);
        font-weight: 700;
        line-height: 1.5;
        margin: 0 0 14px;
    }

    .consult-page .consult-intro {
        max-width: 680px;
        color: #deebf2;
        font-size: 17px;
        line-height: 1.9;
        margin: 0;
    }

    .consult-page .consult-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 290px;
        align-items: start;
        gap: 26px;
        position: relative;
        margin-top: -30px;
    }

    .consult-page .consult-article,
    .consult-page .consult-nav,
    .consult-page .consult-help {
        background: #fff;
        border: 1px solid #e3eaf0;
        border-radius: 20px;
        box-shadow: 0 10px 35px rgba(24, 53, 75, .045);
    }

    .consult-page .consult-article {
        min-width: 0;
        padding: 36px;
    }

    .consult-page .consult-article-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 22px;
        margin-bottom: 26px;
        border-bottom: 1px solid #e8edf2;
    }

    .consult-page .consult-mark {
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: var(--consult-soft);
        color: var(--consult-accent);
        font-size: 23px;
    }

    .consult-page .consult-section-title {
        color: var(--consult-dark);
        font-size: 20px;
        font-weight: 700;
        line-height: 1.6;
        margin: 0;
    }

    .consult-page .consult-body {
        font-size: 16px;
        line-height: 2;
        overflow-wrap: anywhere;
        overflow-x: auto;
    }

    .consult-page .consult-body h1,
    .consult-page .consult-body h2,
    .consult-page .consult-body h3,
    .consult-page .consult-body h4 {
        color: var(--consult-dark);
        font-weight: 700;
        line-height: 1.7;
        margin: 28px 0 14px;
    }

    .consult-page .consult-body h1 { font-size: 28px; }
    .consult-page .consult-body h2 { font-size: 24px; }
    .consult-page .consult-body h3 { font-size: 20px; }

    .consult-page .consult-body > :first-child {
        margin-top: 0;
    }

    .consult-page .consult-body p {
        margin-bottom: 18px;
        line-height: 2;
    }

    .consult-page .consult-body ul,
    .consult-page .consult-body ol {
        padding-inline-start: 25px;
        margin: 18px 0;
    }

    .consult-page .consult-body ul { list-style: disc; }
    .consult-page .consult-body ol { list-style: decimal; }

    .consult-page .consult-body li {
        display: list-item;
        margin-bottom: 12px;
        padding-inline-start: 6px;
    }

    .consult-page .consult-body li::marker {
        color: var(--consult-accent);
        font-weight: 700;
    }

    .consult-page .consult-body a {
        color: var(--consult-accent);
        text-decoration: underline;
        text-underline-offset: 4px;
    }

    .consult-page .consult-body img,
    .consult-page .consult-body video {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
    }

    .consult-page .consult-body iframe {
        max-width: 100%;
    }

    .consult-page .consult-body blockquote {
        margin: 24px 0;
        padding: 20px;
        background: var(--consult-soft);
        border-inline-start: 4px solid var(--consult-accent);
        border-radius: 10px;
    }

    .consult-page .consult-body table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    .consult-page .consult-body th,
    .consult-page .consult-body td {
        padding: 12px;
        border: 1px solid #e3eaf0;
        text-align: start;
    }

    .consult-page .consult-body th {
        background: var(--consult-soft);
    }

    .consult-page .consult-sidebar {
        display: grid;
        gap: 20px;
    }

    .consult-page .consult-nav,
    .consult-page .consult-help {
        padding: 24px;
    }

    .consult-page .consult-nav-title {
        margin: 0 0 18px;
        color: var(--consult-dark);
        font-size: 17px;
        font-weight: 700;
    }

    .consult-page .consult-nav-link {
        display: block;
        padding: 14px;
        border: 1px solid #e3eaf0;
        border-radius: 12px;
        color: #435969;
        line-height: 1.7;
        font-size: 14px;
        margin-top: 10px;
        transition: background .2s, border-color .2s;
    }

    .consult-page .consult-nav-link:hover,
    .consult-page .consult-nav-link[aria-current="page"] {
        background: var(--consult-soft);
        border-color: var(--consult-accent);
        color: var(--consult-dark);
    }

    .consult-page .consult-help {
        background: var(--consult-soft);
        box-shadow: none;
    }

    .consult-page .consult-help p {
        margin: 12px 0 22px;
        color: #465e6d;
        font-size: 14px;
        line-height: 1.9;
    }

    .consult-page .consult-button {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        padding: 12px 18px;
        border-radius: 12px;
        background: var(--consult-accent);
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        transition: filter .2s;
    }

    .consult-page .consult-button:hover {
        color: #fff;
        filter: brightness(.9);
    }

    .consult-page a:focus-visible {
        outline: 3px solid #d18c16;
        outline-offset: 4px;
    }

    @media (max-width: 991px) {
        .consult-page .consult-layout {
            grid-template-columns: minmax(0, 1fr);
        }

        .consult-page .consult-sidebar {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575px) {
        .consult-page { padding-bottom: 36px; }
        .consult-page .consult-hero { padding: 30px 0 58px; }
        .consult-page .consult-intro { font-size: 15px; }
        .consult-page .consult-article { padding: 22px 18px; }
        .consult-page .consult-sidebar { grid-template-columns: minmax(0, 1fr); }
        .consult-page .consult-body { font-size: 15px; }
        .consult-page .consult-body h2 { font-size: 21px; }
    }

    @media (prefers-reduced-motion: reduce) {
        .consult-page a { transition: none; }
    }
</style>
@endpush
@section('content')
<div class="consult-page {{ $educational ? 'is-educational' : '' }}"
     dir="{{ $ar ? 'rtl' : 'ltr' }}">

    <header class="consult-hero">
        <div class="container">
            <nav class="consult-breadcrumb"
                 aria-label="{{ $ar ? 'مسار الصفحة' : 'Breadcrumb' }}">
                <a href="{{ url($locale) }}">
                    {{ $ar ? 'الرئيسية' : 'Home' }}
                </a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">{{ $page->title }}</span>
            </nav>

            <span class="consult-eyebrow">
                {{ $ar ? 'خدماتنا الاستشارية' : 'Consulting services' }}
            </span>

            <h1 class="consult-title">{{ $page->title }}</h1>
            <p class="consult-intro">{{ $intro }}</p>
        </div>
    </header>

    <div class="container">
        <div class="consult-layout">
            <article class="consult-article">
                <div class="consult-article-header">
                    <span class="consult-mark" aria-hidden="true">
                        {{ $educational ? '◎' : '☷' }}
                    </span>

                    <h2 class="consult-section-title">
                        {{ $educational
                            ? ($ar ? 'عن الاستشارات التعليمية والتربوية' : 'About educational consulting')
                            : ($ar ? 'دليلك إلى خدماتنا الاستشارية' : 'Your guide to our consulting services') }}
                    </h2>
                </div>

                <div class="consult-body">
                    {!! $page->content !!}
                </div>
            </article>

            <aside class="consult-sidebar">
                <nav class="consult-nav"
                     aria-label="{{ $ar ? 'صفحات الاستشارات' : 'Consulting pages' }}">

                    <h2 class="consult-nav-title">
                        {{ $ar ? 'استكشف الاستشارات' : 'Explore consulting' }}
                    </h2>

                    <a href="{{ $guideUrl }}"
                       class="consult-nav-link"
                       @if (!$educational) aria-current="page" @endif>
                        {{ $ar ? 'دليل الاستشارات' : 'Consulting guide' }}
                    </a>

                    <a href="{{ $educationUrl }}"
                       class="consult-nav-link"
                       @if ($educational) aria-current="page" @endif>
                        {{ $ar ? 'الاستشارات التعليمية والتربوية' : 'Educational consulting' }}
                    </a>
                </nav>

                <section class="consult-help">
                    <h2 class="consult-nav-title">
                        {{ $ar ? 'ابدأ بطلب استشارة' : 'Request a consultation' }}
                    </h2>

                    <p>
                        {{ $ar
                            ? 'شاركنا احتياجاتك وتفاصيل طلبك من خلال نموذج الاستشارة.'
                            : 'Tell us about your needs using our consultation request form.' }}
                    </p>

                    <a href="{{ $requestUrl }}" class="consult-button">
                        {{ $ar ? 'اطلب استشارة' : 'Request consultation' }}
                    </a>
                </section>
            </aside>
        </div>
    </div>
</div>
@endsection