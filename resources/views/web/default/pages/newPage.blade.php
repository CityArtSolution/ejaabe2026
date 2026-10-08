@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        /* ============================================================
           FONT
        ============================================================ */
        @font-face {
            font-family: 'GE Dinar One Custom';
            src: url('/fonts/arfonts-ge-dinar-one-medium.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body, .arabic-font {
            font-family: 'GE Dinar One Custom', sans-serif;
            font-size: 1rem;
            font-weight: normal;
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* ============================================================
           GLOBAL / UTILITY
        ============================================================ */
        .testimonials-container #parallax2 { display: none; }

        img { max-width: 100%; height: auto; }

        .container { max-width: 95%; margin-left: auto; margin-right: auto; }

        section.home-sections {
            background: #eef6fa;
            /*padding: 60px  70px;*/
            padding: 4rem 1.5rem;
            margin-top: 0 !important;
        }

        /* ============================================================
           EQUAL-HEIGHT SWIPER CARDS
        ============================================================ */
        .home-sections-swiper .swiper-wrapper {
            align-items: stretch !important;
        }

        .home-sections-swiper .swiper-slide {
            height: auto !important;
            display: flex !important;
            flex-direction: column;
        }

        .home-sections-swiper .swiper-slide > a,
        .home-sections-swiper .swiper-slide > div {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Webinar grid cards equal height */
        .home-sections-swiper .swiper-slide .webinar-card,
        .home-sections-swiper .swiper-slide .webinar-list-card,
        .home-sections-swiper .swiper-slide .subscribe-plan {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .home-sections-swiper .swiper-slide .webinar-card .card-footer,
        .home-sections-swiper .swiper-slide .webinar-card .webinar-price-box {
            margin-top: auto;
        }

        /* Trending cards equal height */
        .trend-categories-swiper .swiper-wrapper {
            align-items: stretch !important;
        }
        .trend-categories-swiper .swiper-slide {
            height: auto !important;
            display: flex !important;
        }
        .trend-categories-swiper .swiper-slide > a {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .trend-categories-swiper .trending-card {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* ============================================================
           OWL CAROUSEL — BIGGER ITEMS (Partners & Clients)
        ============================================================ */
        /* ============================================================
           OWL CAROUSEL — LOGO CARDS (Partners & Clients)
           Large rounded-square cards, logo fully visible
        ============================================================ */

        /* Each owl item centers its card */
        .customers-testimonials.owl-carousel .owl-item {
            display: flex !important;
            justify-content: center;
            align-items: center;
            padding: 16px 10px;
        }

        /* .item wrapper — just a flex container */
        .customers-testimonials .item {
            display: flex !important;
            justify-content: center;
            align-items: center;
        }

        /* THE CARD: large rounded square, white, elevated */
        

        .shadow-effect:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 20px 44px rgba(0, 0, 0, 0.15);
        }

        /* Strip inner card of all decoration — just a pass-through */
        .instructors-card {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Avatar fills entire card area */
        .instructors-card-avatar {
            width: 100% !important;
            height: 100% !important;
            border-radius: 0 !important;
            background: transparent !important;
            overflow: hidden;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Logo image — contain so nothing is cropped, full area */
        .instructors-card-avatar img {
            width: 100% !important;
            height: 100% !important;
            object-fit: contain !important;
            display: block;
        }

        /* Hide empty info div */
        .instructors-card-info { display: none !important; }

        /* ============================================================
           EVENT CARDS — MOBILE SPACING FIX
        ============================================================ */
        @media (max-width: 767px) {
            .events-wrapper .row > [class*="col-"] {
                margin-bottom: 20px;
            }
            .events-wrapper .row > [class*="col-"]:last-child {
                margin-bottom: 0;
            }
            .event-card {
                height: auto !important;
                margin-bottom: 0 !important;
            }

            /* Slightly smaller logo cards on mobile */
            /*.shadow-effect {
                width: 130px !important;
                height: 130px !important;
                border-radius: 20px !important;
                padding: 14px !important;
            }*/
        }

        /*@media (max-width: 480px) {
            .shadow-effect {
                width: 110px !important;
                height: 110px !important;
                border-radius: 16px !important;
                padding: 12px !important;
            }
        }*/

        .section-title {
            font-size: 36px;
            font-weight: 700;
            color: #0d3b66;
            margin-bottom: 10px;
        }

        .section-hint {
            font-size: 18px;
            color: #8fa3b8;
        }

        /* ============================================================
           HERO SECTION
        ============================================================ */
        .modern-hero-section {
            background: #dfe8ef;
            padding: 40px 0 10px;
            overflow: visible;
        }

        .modern-hero-card {
            background: #fff;
            border-radius: 35px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.06);
            overflow: visible;
        }

        .modern-hero-card h1 {
            font-size: 36px;
            font-weight: 700;
            margin-top: 15px;
        }

        /* hero images */
        .hero-main-img {
            width: 100%;
            border-radius: 20px;
            object-fit: cover;
            /*height: 300px;*/
            max-height:600px;
            display: block;
        }

        .hero-thumbs {
            display: flex;
            gap: 10px;
            margin-top: 12px;
        }

        .hero-thumbs > div { flex: 1; }

        .hero-thumbs img {
            width: 100%;
            border-radius: 12px;
            height: 90px;
            object-fit: cover;
            display: block;
        }

        /* hero content */
        .hero-content-col {
            padding-left: 20px;
            padding-right: 0;
        }

        .hero-badge {
            background: #eef4ff;
            color: #0d6efd;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            display: inline-block;
        }

        .hero-description {
            color: #666;
            font-size: 15px;
            line-height: 1.8;
        }

        .hero-buttons {
            margin-top: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .hero-buttons a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-hero-primary {
            background: #0d6efd;
            color: #fff;
        }

        .btn-hero-outline {
            border: 1px solid #0d6efd;
            color: #0d6efd;
        }

        .hero-info-row {
            display: flex;
            gap: 30px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .hero-info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #444;
        }

        .hero-info-item i {
            color: #0d6efd;
            font-size: 18px;
        }

        /* ============================================================
           TABS SECTION
        ============================================================ */
        .hero-tabs-section {
            background: #dfe8ef;
            margin-top: -60px;
            padding-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .hero-tabs-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f3f5f7;
            border-radius: 50px;
            padding: 6px;
            max-width: 1000px;
            margin: auto;
        }

        .tab-item {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 20px;
            border-radius: 40px;
            border: none;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all .25s ease;
            white-space: nowrap;
        }

        /* ============================================================
           TREND CATEGORIES
        ============================================================ */
        .trending-card {
            background: #fff;
            border-radius: 20px;
            padding: 28px 16px 24px;
            text-align: center;
            box-shadow: 0 12px 35px rgba(0,0,0,0.07);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
            height: 100%;
        }
        .trending-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 45px rgba(0,0,0,0.12);
        }
        .trending-image {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .trending-image img { width: 46px; height: 46px; object-fit: contain; }
        .item-count {
            background: #eef4fb;
            border-radius: 20px;
            font-size: 13px;
            color: #4a6fa5;
            font-weight: 600;
            display: inline-block;
            order: -1;
        }
        .trending-card h3 {
            font-size: 16px;
            font-weight: 700;
            color: #0d3b66;
            margin: 0;
            line-height: 1.4;
        }
        .trend-section .trend-categories-swiper { overflow: hidden; padding-bottom: 0 !important; }
        .trend-categories-swiper-pagination { display: none !important; }
        .trend-categories-swiper { margin-top: 0; }
        .trend-categories-swiper .swiper-slide { height: auto; }
        .trend-section .swiper-wrapper { padding-right: 0 !important; padding-bottom: 0 !important; }

        /* ============================================================
           LATEST CLASSES (TRACKS GRID)
        ============================================================ */
        .tracks-filter {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .filter-btn {
            border: none;
            padding: 8px 18px;
            background: #eef2f7;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            color: #4b5563;
        }

        .filter-btn.active { background: #e5e7eb; font-weight: 600; }

        .tracks-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .track-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            border: 1px solid #e5e7eb;
            transition: .25s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 220px;
        }

        .track-card:hover { box-shadow: 0 10px 25px rgba(0,0,0,0.08); }

        .track-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .track-icon {
            width: 36px; height: 36px;
            background: #f1f5f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #475569;
        }

        .track-badge {
            background: #eef2f7;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: #475569;
        }

        .track-title { font-size: 18px; font-weight: 700; margin-bottom: 10px; color: #1f2937; }
        .track-desc { font-size: 14px; color: #6b7280; line-height: 1.7; margin-bottom: 20px; }
        .track-divider { border-top: 1px solid #e5e7eb; margin-bottom: 12px; }

        .track-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }

        .track-details { color: #2563eb; font-weight: 600; text-decoration: none; }
        .track-details:hover { text-decoration: underline; }
        .track-date { color: #9ca3af; }

        .discover-card {
            border: 2px dashed #d1d5db;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .discover-icon { font-size: 30px; margin-bottom: 10px; color: #6b7280; }
        .discover-title { font-size: 18px; font-weight: 700; margin-bottom: 5px; }
        .discover-text { font-size: 14px; color: #6b7280; }

        /* ============================================================
           SOLUTIONS SECTION (BLUE BOX)
        ============================================================ */
        .solutions-section { width: 100%; padding: 80px 0; background: #f4fbff; }

        .solutions-box {
            max-width: 1200px;
            margin: 0 auto;
            background: linear-gradient(135deg, #0b6aa2, #0a4f78);
            border-radius: 60px;
            padding: 60px 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #ffffff;
        }

        .solutions-items { display: flex; gap: 20px; }

        .solution-item {
            background: rgba(255,255,255,0.12);
            border-radius: 14px;
            padding: 22px;
            width: 200px;
        }

        .solution-item h4 { font-size: 15px; font-weight: 700; margin-bottom: 8px; }
        .solution-item p { font-size: 13px; opacity: 0.9; }

        .solutions-content { max-width: 380px; text-align: right; }

        .solutions-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .solutions-content h2 { font-size: 26px; font-weight: 700; margin-bottom: 14px; }
        .solutions-content p { font-size: 14px; line-height: 1.7; opacity: 0.95; margin-bottom: 22px; }

        .solutions-content a {
            display: inline-block;
            background: #ffffff;
            color: #0a4f78;
            padding: 12px 26px;
            border-radius: 10px;
            font-size: 14px;
            text-decoration: none;
            font-weight: 600;
        }

        /* ============================================================
           SERVICES BIG SECTION
        ============================================================ */
        .services-big-section { width: 100%; background: #f4fbff; padding: 60px 0; }

        .services-big-card {
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 22px;
            overflow: hidden;
            display: flex;
            box-shadow: 0 15px 40px rgba(0,0,0,0.06);
        }

        .services-big-image { width: 50%; }
        .services-big-image img { width: 100%; height: 100%; object-fit: cover; display: block; }

        .services-big-content {
            width: 50%;
            background: #1f57c3;
            color: #ffffff;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .services-big-content h2 { font-size: 28px; font-weight: 700; margin-bottom: 16px; }
        .services-big-content p { font-size: 15px; line-height: 1.8; opacity: 0.9; margin-bottom: 30px; }

        .services-big-content .btn-outline {
            display: inline-block;
            padding: 12px 26px;
            border-radius: 30px;
            border: 1px solid #ffffff;
            color: #ffffff;
            font-size: 14px;
            text-decoration: none;
            width: fit-content;
            transition: all 0.3s ease;
        }

        .services-big-content .btn-outline:hover { background: #ffffff; color: #1f57c3; }

        /* ============================================================
           CTA SECTION
        ============================================================ */
        .services-cta-section { width: 100%; background: #f4fbff; padding: 40px 0 80px; }

        .services-cta-box {
            max-width: 1000px;
            margin: 0 auto;
            background: #f8fcff;
            border-radius: 16px;
            padding: 30px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        }

        .services-cta-text h3 { font-size: 20px; font-weight: 700; color: #0d3b66; margin-bottom: 8px; }
        .services-cta-text p { font-size: 14px; color: #7a8fa6; }

        .services-cta-actions { display: flex; gap: 12px; }

        .services-cta-actions a {
            padding: 10px 22px;
            border-radius: 10px;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-primary-custom { background: #1f57c3; color: #ffffff; }
        .btn-outline-custom { border: 1px solid #1f57c3; color: #1f57c3; }

        /* ============================================================
           PARTNERS / CLIENTS (OWL) — base helpers only, sizing above
        ============================================================ */
        .ltr { direction: ltr; }

        .owl-carousel .owl-stage { display: flex; align-items: center; }
        .owl-carousel .owl-item { display: flex; justify-content: center; }
        .customers-testimonials .item { display: flex; justify-content: center; }

        /* ============================================================
           EVENTS
        ============================================================ */
        .event-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            transition: .3s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .event-card:hover { transform: translateY(-8px); }

        .event-image { position: relative; height: 220px; overflow: hidden; }
        .event-image img { width: 100%; height: 100%; object-fit: cover; }

        .event-badges {
            position: absolute;
            bottom: 15px;
            left: 15px;
            right: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
        }

        .event-date {
            background: rgba(255,255,255,0.95);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .event-status {
            background: #2e7d32;
            color: #fff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .event-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
        .event-body h3 { font-size: 18px; font-weight: 700; margin-bottom: 12px; color: #0d3b66; }
        .event-body p { font-size: 14px; color: #666; flex: 1; }

        .event-footer {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 600;
            color: #1976b6;
            margin-top: 15px;
        }

        .events-wrapper {
            background: linear-gradient(135deg, #0d3b66, #1976b6);
            padding: 60px 0;
            width: 100%;
        }

        .events-title { color: #fff; font-weight: 700; font-size: 28px; }

        /* ============================================================
           RESPONSIVE BREAKPOINTS
        ============================================================ */

        /* ── Large desktop ≥ 1200px ── */
        @media (min-width: 1200px) {
            .tracks-grid { grid-template-columns: repeat(4, 1fr); }
        }

        /* ── Laptop 993–1199px ── */
        @media (min-width: 993px) and (max-width: 1199px) {
            .tracks-grid { grid-template-columns: repeat(3, 1fr); }
            .solution-item { width: 170px; }
            .solutions-box { padding: 50px; }
        }

        /* ── Tablet landscape 769–992px ── */
        @media (min-width: 769px) and (max-width: 992px) {
            /* Hero */
            .modern-hero-card { padding: 35px; }
            .modern-hero-card h1 { font-size: 28px; }
            .hero-main-img { height: 220px; }
            .hero-thumbs img { height: 70px; }
            .hero-content-col { padding-left: 10px; }

            /* Tabs */
            .hero-tabs-section { margin-top: 30px; }
            .tab-item { padding: 10px 12px; font-size: 13px; gap: 6px; }

            /* Sections */
            .section-title { font-size: 28px; }
            .section-hint { font-size: 15px; }
            .home-sections { padding: 45px 0 55px; }

            /* Tracks */
            .tracks-grid { grid-template-columns: repeat(2, 1fr); gap: 18px; }

            /* Solutions */
            .solutions-box {
                flex-direction: column;
                padding: 45px 40px;
                border-radius: 40px;
                gap: 30px;
                text-align: center;
            }
            .solutions-items { flex-wrap: wrap; justify-content: center; }
            .solution-item { width: calc(50% - 10px); }
            .solutions-content { max-width: 100%; text-align: center; }

            /* Services big */
            .services-big-card { flex-direction: column; }
            .services-big-image, .services-big-content { width: 100%; }
            .services-big-content { padding: 40px 35px; }

            /* CTA */
            .services-cta-box { padding: 25px 30px; }

            /* Events */
            .event-image { height: 190px; }
        }

        /* ── Tablet portrait 577–768px ── */
        @media (min-width: 577px) and (max-width: 768px) {
            /* Hero */
            .modern-hero-card { padding: 25px; border-radius: 25px; }
            .modern-hero-card h1 { font-size: 26px; }
            .hero-main-img { height: 200px; }
            .hero-thumbs img { height: 65px; }
            .hero-content-col { padding-left: 0; margin-top: 20px; }
            .hero-buttons { flex-wrap: wrap; }
            .hero-buttons a { flex: 1; justify-content: center; min-width: 140px; }

            /* Tabs */
            .hero-tabs-section { margin-top: 120px; }
            .hero-tabs-wrapper { border-radius: 20px; padding: 8px; gap: 6px; }
            .tab-item { padding: 10px 10px; font-size: 13px; border-radius: 14px; }

            /* Sections */
            .section-title { font-size: 24px; }
            .section-hint { font-size: 14px; }
            .home-sections { padding: 35px 0 45px; }

            /* Tracks */
            .tracks-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
            .track-title { font-size: 16px; }
            .track-desc { font-size: 13px; }

            /* Solutions */
            .solutions-box {
                flex-direction: column;
                padding: 35px 25px;
                border-radius: 30px;
                gap: 25px;
            }
            .solutions-items { flex-direction: column; }
            .solution-item { width: 100%; }
            .solutions-content { max-width: 100%; text-align: center; }

            /* Services big */
            .services-big-card { flex-direction: column; }
            .services-big-image, .services-big-content { width: 100%; }
            .services-big-content { padding: 30px 25px; }
            .services-big-content h2 { font-size: 22px; }

            /* CTA */
            .services-cta-box { flex-direction: column; padding: 25px 20px; gap: 18px; text-align: center; }
            .services-cta-actions { width: 100%; justify-content: center; }

            /* Events */
            .event-image { height: 180px; }
            .event-badges { flex-direction: row; }
        }

        /* ── Mobile ≤ 576px ── */
        @media (max-width: 576px) {
            body { font-size: 14px; }

            .container { padding-left: 14px; padding-right: 14px; }

            /* Hero */
            .modern-hero-section { padding: 15px 0 10px; }
            .modern-hero-card { padding: 18px; border-radius: 20px; }
            .modern-hero-card .row { flex-direction: column; gap: 16px; }
            .modern-hero-card h1 { font-size: 22px; line-height: 1.3; }
            .hero-main-img { height: 190px; border-radius: 14px; }
            .hero-thumbs { gap: 6px; }
            .hero-thumbs img { height: 60px; border-radius: 8px; }
            .hero-content-col { padding-left: 0; }
            .hero-description { font-size: 13px; }
            .hero-buttons { flex-direction: column; gap: 10px; }
            .hero-buttons a { width: 100%; justify-content: center; }
            .hero-info-row { flex-direction: column; gap: 10px; }
            .hero-info-item { font-size: 13px; }

            /* Tabs — horizontal scroll on mobile, NOT stacked */
            .hero-tabs-section .container{
                padding-left: 0px;
                padding-right: 0px;
                max-width: 100%;
            }
            .hero-tabs-section {
                margin-top: 120px;
                padding-bottom: 16px; }
            .hero-tabs-wrapper {
                flex-direction: row;
                flex-wrap: nowrap;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                border-radius: 18px;
                padding: 8px;
                gap: 6px;
                scrollbar-width: none;
            }
            .hero-tabs-wrapper::-webkit-scrollbar { display: none; }
            .tab-item {
                flex-shrink: 0;
                white-space: nowrap;
                padding: 10px 2px;
                font-size: 12px;
                border-radius: 12px;
            }

            /* Sections */
            .section-title { font-size: 22px; }
            .section-hint { font-size: 13px; }
            .home-sections { padding: 30px 0 40px; }

            /* Trend categories */
            .trend-categories-swiper { margin-top: 20px; }
            .trending-card { padding: 20px 10px 18px; gap: 10px; }
            .trending-image { width: 68px; height: 68px; }
            .trending-image img { width: 34px; height: 34px; }
            .item-count { font-size: 11px; }
            .trending-card h3 { font-size: 13px; }

            /* Tracks */
            .tracks-grid { grid-template-columns: 1fr; gap: 14px; }
            .track-title { font-size: 16px; }
            .track-desc { font-size: 13px; }
            .filter-btn { padding: 6px 12px; font-size: 12px; }
            .tracks-filter { gap: 6px; margin-bottom: 25px; }

            /* Solutions */
            .solutions-section { padding: 40px 0; }
            .solutions-box {
                flex-direction: column;
                padding: 28px 18px;
                border-radius: 24px;
                gap: 24px;
            }
            .solutions-items { flex-direction: column; gap: 10px; }
            .solution-item { width: 100%; padding: 16px; }
            .solution-item h4 { font-size: 14px; }
            .solutions-content { max-width: 100%; text-align: center; }
            .solutions-content h2 { font-size: 20px; }
            .solutions-content p { font-size: 13px; }

            /* Services big */
            .services-big-section { padding: 30px 0; }
            .services-big-card { flex-direction: column; border-radius: 16px; }
            .services-big-image, .services-big-content { width: 100%; }
            .services-big-image img { height: 200px; }
            .services-big-content { padding: 24px 20px; }
            .services-big-content h2 { font-size: 20px; }
            .services-big-content p { font-size: 13px; }

            /* CTA */
            .services-cta-section { padding: 24px 0 40px; }
            .services-cta-box {
                flex-direction: column;
                padding: 22px 18px;
                gap: 16px;
                text-align: center;
                border-radius: 14px;
            }
            .services-cta-text h3 { font-size: 17px; }
            .services-cta-text p { font-size: 13px; }
            .services-cta-actions { flex-direction: column; width: 100%; gap: 10px; }
            .services-cta-actions a { width: 100%; text-align: center; display: block; }

            /* Events */
            .events-wrapper { padding: 35px 0; }
            .events-title { font-size: 22px; }
            .event-image { height: 175px; }
            .event-badges { gap: 6px; }
            .event-date, .event-status { font-size: 11px; padding: 4px 10px; }
            .event-body { padding: 14px; }
            .event-body h3 { font-size: 15px; }
            .event-body p { font-size: 13px; }
            .event-footer { flex-direction: column; gap: 6px; align-items: flex-start; }
            .event-card { margin-bottom: 16px; }

            /* Partners/Clients owl carousel — smaller cards on mobile */
            /*.shadow-effect {
                width: 120px !important;
                height: 120px !important;
                border-radius: 18px !important;
                padding: 14px !important;
            }*/
        }

        /* ── Extra small ≤ 400px ── */
        @media (max-width: 400px) {
            .modern-hero-card h1 { font-size: 19px; }
            .hero-thumbs { display: none; }
            .hero-main-img { height: 170px; }
            .solutions-box { border-radius: 18px; }
            .tab-item { font-size: 12px; padding: 8px 10px; }
            .tab-item i { display: none; }
            /*.shadow-effect {
                width: 100px !important;
                height: 100px !important;
                border-radius: 14px !important;
                padding: 10px !important;
            }*/
        }
        
        /*.shadow-effect {
    width: auto;
    height: 100%;
    border-radius: 28px !important;
    background: #ffffff;
    box-shadow: 0 10px 32px rgba(0, 0, 0, 0.10);
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    overflow: hidden;
    padding: 20px !important;
    transition: transform .25s ease, box-shadow .25s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}*/

.shadow-effect {
    width: 100%;
    height: 200px;
    box-sizing: border-box;
    border-radius: 28px !important;
    background: #ffffff;
    box-shadow: 0 10px 32px rgba(0, 0, 0, 0.10);
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    overflow: hidden;
    padding: 20px !important;
    transition: transform .25s ease, box-shadow .25s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.shadow-effect .instructors-card-avatar img {
    width: 100% !important;
    height: 100% !important;
    object-fit: contain !important;
    object-position: center;
}
    </style>
    <style>
        .modern-hero-section {
    background: #e6eef7;
    padding: 24px 0 10px;
}

.modern-hero-section .modern-hero-card {
    background: linear-gradient(135deg, #ffffff 0%, #f3f8fd 100%);
    border-radius: 28px;
    padding: 0;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(13, 59, 102, .08);
}

.modern-hero-section .hero-main {
    display: flex;
    align-items: stretch;
    min-height: 600px;
}

/* ---------- Content ---------- */
.modern-hero-section .hero-content-col {
    flex: 0 0 42%;
    max-width: 42%;
    padding: 38px 50px 55px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.modern-hero-section .hero-badge-row {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 26px;
}

.modern-hero-section .hero-badge {
    background: #f6e9dc;
    color: #0b1d51;
    padding: 10px 26px;
    border-radius: 30px;
    font-size: 17px;
    font-weight: 600;
}

.modern-hero-section .hero-badge-line {
    width: 50px;
    height: 2px;
    background: #d98e1f;
}

.modern-hero-section .hero-title {
    font-size: 42px;
    line-height: 1.3;
    font-weight: 800;
    margin: 0;
}

.modern-hero-section .hero-title .t-dark { color: #0b1d51; display: block; }
.modern-hero-section .hero-title .t-blue { color: #0d5cff; display: block; }

.modern-hero-section .hero-title-underline {
    display: block;
    width: 75%;
    height: 10px;
    margin: 4px 0 26px;
    border-bottom: 3px solid #d98e1f;
    border-radius: 0 0 50% 50% / 0 0 100% 100%;
}

.modern-hero-section .hero-description {
    color: #2f3b4e;
    font-size: 22px;
    line-height: 1.9;
    margin-bottom: 30px;
}

.modern-hero-section .hero-tagline {
    display: flex;
    align-items: center;
    gap: 18px;
    color: #2f3b4e;
    font-size: 17px;
}

.modern-hero-section .hero-tagline-line {
    flex: 0 0 140px;
    height: 2px;
    background: linear-gradient(90deg, transparent, #9db8f5);
}

/* ---------- Image ---------- */


/*.modern-hero-section .hero-main-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0;
}*/

.modern-hero-section .hero-float-card {
    position: absolute;
    bottom: 70px;
    inset-inline-start: -30px;
    background: #fff;
    border-radius: 16px;
    padding: 16px 26px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 15px 40px rgba(13, 59, 102, .15);
    z-index: 2;
}

.modern-hero-section .hero-float-card i {
    font-size: 34px;
    color: #0d5cff;
    padding-bottom: 6px;
    border-bottom: 3px solid #d98e1f;
    line-height: 1;
}

.modern-hero-section .float-divider {
    width: 1px;
    height: 44px;
    background: #e3e8ef;
}

.modern-hero-section .hero-float-card strong {
    display: block;
    font-size: 18px;
    color: #0b1d51;
}

.modern-hero-section .hero-float-card span:not(.float-divider) {
    font-size: 16px;
    color: #3d4a5c;
}

/* ---------- Features strip ---------- */
.hero-features {
    display: flex;
    justify-content: space-around;
    align-items: center;
    background: #e9f1fb;
    padding: 28px 30px;
    margin-top:60px;
}

.hero-feature {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 18px;
    position: relative;
}

.hero-feature:not(:last-child)::after {
    content: "";
    position: absolute;
    inset-inline-end: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 2px;
    height: 44px;
    background: #d98e1f;
}

.hero-feature-icon i {
    font-size: 40px;
    color: #0d5cff;
    display: inline-block;
    padding-bottom: 6px;
    border-bottom: 3px solid #d98e1f;
    line-height: 1;
}

.hero-feature-text strong {
    display: block;
    font-size: 20px;
    color: #0b1d51;
}

.hero-feature-text span {
    font-size: 15px;
    color: #6b7a90;
}

/* ---------- Tabs: تحت الكارت بدل ما تتداخل معاه ---------- */
.hero-tabs-section { margin-top: 0 !important; padding-top: 24px; background: #e6eef7; }

.hero-tabs-wrapper { background: #f3f6fa; }

/* ---------- Responsive ---------- */
@media (max-width: 992px) {
    .modern-hero-section .hero-main { flex-direction: column; min-height: 0; }
    .modern-hero-section .hero-content-col { flex: none; max-width: 100%; padding: 35px 28px 20px; }
    .modern-hero-section .hero-title { font-size: 22px; }
    .modern-hero-section .hero-description { font-size: 18px; }
    .modern-hero-section .hero-image-col { min-height: 320px; }
    .modern-hero-section .hero-float-card { inset-inline-start: 20px; bottom: 20px; }
    .modern-hero-section .hero-features { flex-direction: column; align-items: stretch; gap: 18px; }
    .modern-hero-section .hero-feature { justify-content: flex-start; }
    .modern-hero-section .hero-feature:not(:last-child)::after { display: none; }
}

@media (max-width: 576px) {
    .modern-hero-section { padding: 12px 0 6px; }
    .modern-hero-section .modern-hero-card { border-radius: 20px; }
    .modern-hero-section .hero-content-col { padding: 24px 18px 16px; }
    .modern-hero-section .hero-badge { font-size: 14px; padding: 8px 18px; }
    .modern-hero-section .hero-title { font-size: 10px; }
    .modern-hero-section .hero-description { font-size: 15px; }
    .modern-hero-section .hero-tagline-line { flex-basis: 60px; }
    .modern-hero-section .hero-image-col { min-height: 240px; }
    .modern-hero-section .hero-float-card { padding: 10px 16px; }
    .modern-hero-section .hero-features { padding: 20px 18px; }
    .hero-tabs-section { margin-top: 0 !important; }
}

.modern-hero-section .swiper-wrapper { align-items: stretch; }

.modern-hero-section .swiper-slide {
    height: auto !important;
    display: flex !important;
}

.modern-hero-section .hero-container {
    width: 100%;
    display: flex;
}

.modern-hero-section .modern-hero-card {
    width: 100%;
    display: flex;
    flex-direction: column;
}

.modern-hero-section .hero-main {
    flex: 1 1 auto;
    /*height: 580px;*/              /* ارتفاع ثابت لكل السلايدات، غيّره براحتك */
    min-height: 0;
}




/* ---------- شريط المميزات: كارت مستقل بمسافة عن السلايدر ---------- */
.hero-features-section {
    background: #e6eef7;
    padding: 0 0 10px;
}

.hero-features-section .hero-features {
    margin-top: 28px;           /* المسافة بينه وبين بوكس السلايدر */
    display: flex;
    justify-content: space-around;
    align-items: center;
    background: #f3f8fd;
    border-radius: 22px;
    padding: 28px 30px;
    box-shadow: 0 12px 35px rgba(13, 59, 102, .07);
}

.hero-features-section .hero-feature {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 18px;
    position: relative;
}

.hero-features-section .hero-feature:not(:last-child)::after {
    content: "";
    position: absolute;
    inset-inline-end: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 2px;
    height: 44px;
    background: #d98e1f;
}

.hero-features-section .hero-feature-icon i {
    font-size: 40px;
    color: #0d5cff;
    display: inline-block;
    padding-bottom: 6px;
    border-bottom: 3px solid #d98e1f;
    line-height: 1;
}

.hero-features-section .hero-feature-text strong {
    display: block;
    font-size: 20px;
    color: #0b1d51;
}

.hero-features-section .hero-feature-text span {
    font-size: 15px;
    color: #6b7a90;
}

/* التابات تحت المميزات بمسافة */
.hero-tabs-section { padding-top: 14px; }

@media (max-width: 992px) {
    .modern-hero-section .hero-main { height: auto; flex-direction: column; }
  

    .hero-features-section .hero-features { flex-direction: column; align-items: stretch; gap: 18px; }
    .hero-features-section .hero-feature { justify-content: flex-start; }
    .hero-features-section .hero-feature:not(:last-child)::after { display: none; }
}

@media (max-width: 576px) {
    
    .hero-features-section .hero-features { margin-top: 16px; padding: 20px 18px; border-radius: 16px; }
}

.modern-hero-section .hero-main {
    display: flex;
    align-items: stretch;      /* النص يتمدد على ارتفاع الصورة */
    height: auto;
    min-height: 0;
}

.modern-hero-section .hero-image-col {
    position: relative;
    flex: 1 1 58%;
    min-height: 0;
    display: block;
    overflow: hidden;
}

.modern-hero-section .hero-main-img {
    position: static !important;   /* ترجع في مكانها الطبيعي */
    display: block;
    width: 100% !important;
    height: auto !important;       /* الارتفاع تابع لنسبة الصورة */
    max-height: none !important;
    object-fit: contain;
    border-radius: 0;
}

/* كل السلايدات بنفس الارتفاع (أطول واحدة) والكارت يملا الارتفاع */
.modern-hero-section .swiper-wrapper { align-items: stretch; }
.modern-hero-section .swiper-slide { height: auto !important; display: flex !important; }
.modern-hero-section .hero-container { display: flex; width: 100%; }
.modern-hero-section .modern-hero-card { display: flex; flex-direction: column; width: 100%; }
.modern-hero-section .hero-main { flex: 1 1 auto; }



@media (max-width: 992px) {
    .modern-hero-section .hero-main { flex-direction: column; }
    .modern-hero-section .hero-image-col { flex: none; width: 100%; height: auto; }
}

.hero-slider-wrap { position: relative; background: #e6eef7; }

.hero-slider-wrap > .container {
    position: absolute;
    left: 0; right: 0;
    bottom: 24px;          /* المسافة من أسفل الكارت */
    z-index: 5;
    display: flex;
    justify-content: center;
    pointer-events: none;  /* عشان الـ container ميمنعش السحب */
}

.hero-slider-wrap .hero-tabs-wrapper { pointer-events: auto; width: 100%; }

.modern-hero-section .hero-main {
    display: flex;
    align-items: stretch;      /* النص والصورة بنفس الارتفاع */
    height: auto;
    min-height: 0;
}

.modern-hero-section .hero-image-col {
    position: relative;
    flex: 1 1 58%;
    min-height: 0;
    align-self: stretch;
    aspect-ratio: 16 / 10;     /* يحدد ارتفاع البوكس من عرض الصورة */
    overflow: hidden;
    display: block;
}

.modern-hero-section .hero-main-img {
    position: absolute !important;
    inset: 0;
    width: 100% !important;
    height: 100% !important;
    max-height: none !important;
    object-fit: contain;         /* تملا المساحة بالكامل */
    object-position: center;
    border-radius: 0 !important;
    display: block;
}

    </style>
@endpush

@section('content')

    {{--@if (!empty($sliders) && count($sliders))
        <section class="modern-hero-section hero-slider swiper" style="overflow:visible;">
            <div class="swiper-wrapper">
                @foreach ($sliders as $index => $slider)
                    <div class="swiper-slide" style="display:flex; justify-content:center;">
                        <div class="container hero-container" style="max-width:1800px;">
                            <div class="modern-hero-card">
                                <div class="row align-items-center">

                                    
                                    <div class="col-lg-6 col-md-12">
                                        <div>
                                            <img src="{{ asset($slider->image_locale ?? 'images/default/main.jpg') }}"
                                                 class="hero-main-img" loading="lazy"
                                                 alt="{{ $slider->title }}">

                                            <div class="hero-thumbs">
                                                <div>
                                                    <img src="{{ asset($slider->image_1 ?? 'images/default/1.jpg') }}" loading="lazy">
                                                </div>
                                                <div>
                                                    <img src="{{ asset($slider->image_2 ?? 'images/default/2.jpg') }}" loading="lazy">
                                                </div>
                                                <div>
                                                    <img src="{{ asset($slider->image_3 ?? 'images/default/3.jpg') }}" loading="lazy">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="col-lg-6 col-md-12">
                                        <div class="hero-content-col">
                                            <span class="hero-badge">{{ $slider->sub_title }}</span>

                                            <h1>{{ $slider->title }}</h1>

                                            @if($index == 1)
                                                <div style="height:4px;width:60px;background:#0d6efd;margin:10px 0;"></div>
                                                <div style="color:#0d6efd;font-weight:600;margin-bottom:10px;">

                                                    {{__('home.Developing_professional')}}
                                                </div>
                                            @endif

                                            <p class="hero-description">{{ $slider->description }}</p>

                                            <div class="hero-buttons">
                                                <a href="{{ $slider->button1_link }}" class="btn-hero-primary">
                                                    <i class="bi bi-folder"></i>
                                                    {{ $slider->button1_title }}
                                                </a>
                                                <a href="{{ $slider->button2_link }}" class="btn-hero-outline">
                                                    <i class="bi bi-book"></i>
                                                    {{ $slider->button2_title }}
                                                </a>
                                            </div>

                                            <div class="hero-info-row">
                                                <div class="hero-info-item">
                                                    <i class="bi bi-book"></i>
                                                    {{__('home.Specialized_programs')}}
                                                </div>
                                                <div class="hero-info-item">
                                                    <i class="bi bi-people"></i>

                                                    {{__('home.various_fields')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif --}}
    
    @php
        $isAr = app()->getLocale() == 'ar';
        $heroFeatures = [
            ['icon' => 'bi-bar-chart',
             'title' => $isAr ? 'إدارة المشاريع' : 'Project Management',
             'desc'  => $isAr ? 'طور مهارات القيادة والتنفيذ' : 'Develop leadership and execution skills'],
            ['icon' => 'bi-briefcase',
             'title' => $isAr ? 'الأعمال والاحترافية' : 'Business & Professionalism',
             'desc'  => $isAr ? 'ارتقِ بخبراتك العملية' : 'Elevate your practical experience'],
            ['icon' => 'bi-gear',
             'title' => $isAr ? 'نظم الإدارة' : 'Management Systems',
             'desc'  => $isAr ? 'عزز الجودة وكفاءة الأداء' : 'Boost quality and performance efficiency'],
        ];
    @endphp

    
    @if (!empty($sliders) && count($sliders))
    <div class="hero-slider-wrap">
    <section class="modern-hero-section hero-slider swiper" style="overflow:hidden;">
        <div class="swiper-wrapper">
            @foreach ($sliders as $index => $slider)
                @php
                    // تقسيم العنوان: النص الأول كحلي والنص التاني أزرق
                    $words = preg_split('/\s+/u', trim($slider->description ?? ''));
                    $half  = (int) ceil(count($words) / 2);
                    $t1 = implode(' ', array_slice($words, 0, $half));
                    $t2 = implode(' ', array_slice($words, $half));
                @endphp

                <div class="swiper-slide" style="display:flex; justify-content:center;">
                    <div class="container hero-container" style="max-width:1800px;">
                        <div class="modern-hero-card">

                            <div class="hero-main">

                                {{-- النص (يمين في العربي) --}}
                                <div class="hero-content-col">
                                    <div class="hero-badge-row">
                                        @if($isAr)
                                        <span class="hero-badge-line"></span>
                                        <span class="hero-badge">{{ $slider->title }}</span>
                                        
                                        @else
                                        <span class="hero-badge">{{ $slider->title }}</span>
                                        <span class="hero-badge-line"></span>
                                        @endif
                                        
                                    </div>

                                    <h1 class="hero-title">
                                        <span class="t-dark">{{ $t1 }}</span>
                                        <span class="t-blue">{{ $t2 }}</span>
                                    </h1>
                                    <span class="hero-title-underline"></span>
                                    
                                    <div class="hero-buttons">
                                                <a href="{{ $slider->button1_link }}" class="btn-hero-primary">
                                                    <i class="bi bi-folder"></i>
                                                    {{ $slider->button1_title }}
                                                </a>
                                                <a href="{{ $slider->button2_link }}" class="btn-hero-outline">
                                                    <i class="bi bi-book"></i>
                                                    {{ $slider->button2_title }}
                                                </a>
                                            </div>

                                    {{--<p class="hero-description">{{ $slider->description }}</p>

                                    <div class="hero-tagline">
                                        <span class="hero-tagline-line"></span>
                                        <span>{{ $isAr ? 'معرفة تتطور. فرص تتسع.' : 'Knowledge evolves. Opportunities expand.' }}</span>
                                    </div>--}}
                                </div>

                                {{-- الصورة (شمال في العربي) --}}
                                <div class="hero-image-col">
                                    <img src="{{ asset($slider->image_locale ?? 'images/default/main.jpg') }}"
                                         class="hero-main-img" loading="lazy" alt="{{ $slider->title }}">

                                    {{--<div class="hero-float-card">
                                        <i class="bi bi-mortarboard-fill"></i>
                                        <span class="float-divider"></span>
                                        <div>
                                            <strong>{{ $isAr ? 'استثمر' : 'Invest' }}</strong>
                                            <span>{{ $isAr ? 'في مستقبلك' : 'in your future' }}</span>
                                        </div>
                                    </div>--}}
                                </div>
                            </div>

                            

                        </div>
                    </div>
                </div>
            @endforeach
            {{-- شريط المميزات --}}
                            
        </div>
      
    </section>
   {{--<section class="hero-features-section">
          <div class="container hero-container" style="max-width:1800px;">
        <div class="hero-features">
            @foreach ($heroFeatures as $f)
                <div class="hero-feature">
                    <div class="hero-feature-icon"><i class="bi {{ $f['icon'] }}"></i></div>
                    <div class="hero-feature-text">
                        <strong>{{ $f['title'] }}</strong>
                        <span>{{ $f['desc'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </section>--}}   
    
      
    
    </div>
      <div class="container">
            <div class="hero-tabs-wrapper">
                @foreach ($sliders as $index => $slider)
                    <button
                       class="tab-item {{ $index == 0 ? 'active' : '' }}"
    data-slide-index="{{ $index }}"
    style="background:{{ $index == 0 ? '#1f6ea5' : 'transparent' }};color:{{ $index == 0 ? '#ffffff' : '#6c7a89' }};">

                        @if($index == 0)<i class="bi bi-bullseye" style="font-size:18px;"></i>@endif
                        @if($index == 1)<i class="bi bi-pen" style="font-size:18px;"></i>@endif
                        @if($index == 2)<i class="bi bi-easel2" style="font-size:18px;"></i>@endif

                        {{ $slider->title }}
                    </button>
                @endforeach
            </div>
        </div>
@endif

    

    {{-- Tab/slider JS --}}
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            const heroSwiper = new Swiper('.hero-slider', {
                loop: false, speed: 600, slidesPerView: 1, spaceBetween: 0,
                centeredSlides: false, autoplay: false,
            });
            heroSwiper.slideTo(0, 0);
            const tabs = document.querySelectorAll('.tab-item');
            tabs.forEach((tab, index) => {
                tab.addEventListener('click', function(){
                    heroSwiper.slideTo(index, 0);
                    tabs.forEach(t => { t.style.background='transparent'; t.style.color='#6c7a89'; });
                    this.style.background='#1f6ea5'; this.style.color='#ffffff';
                });
            });
            heroSwiper.on('slideChange', function(){
                tabs.forEach((tab, i) => {
                    tab.style.background = i === heroSwiper.activeIndex ? '#1f6ea5' : 'transparent';
                    tab.style.color      = i === heroSwiper.activeIndex ? '#ffffff'  : '#6c7a89';
                });
            });
        });

        /* Trend Categories — fill the row, no pagination */
        if (document.querySelector('.trend-categories-swiper')) {
            new Swiper('.trend-categories-swiper', {
                slidesPerView: 2,
                spaceBetween: 16,
                loop: false,
                pagination: false,
                breakpoints: {
                    480:  { slidesPerView: 3, spaceBetween: 16 },
                    768:  { slidesPerView: 4, spaceBetween: 18 },
                    992:  { slidesPerView: 5, spaceBetween: 20 },
                    1200: { slidesPerView: 6, spaceBetween: 22 },
                }
            });
        }
    </script>

    {{-- ============================================================
         HOME SECTIONS LOOP
    ============================================================ --}}
    @foreach ($homeSections as $homeSection)

        {{-- Trend Categories --}}
        @if (
            $homeSection->name == \App\Models\HomeSection::$trend_categories &&
            !empty($trendCategories) && !$trendCategories->isEmpty()
        )
            <section class="home-sections home-sections-swiper trend-section">
                <div class="container arabic-font">
                    <div class="text-center mb-40">
                        <h2 class="section-title">{{ trans('home.trending_categories') }}</h2>
                        <p class="section-hint">{{ trans('home.trending_categories_hint') }}</p>
                    </div>
                    <div class="swiper-container trend-categories-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($trendCategories as $trend)
                                <div class="swiper-slide">
                                    <a href="{{ '/' . app()->getLocale() . $trend->category->getUrl() }}" class="text-decoration-none">
                                        <div class="trending-card">
                                            <div class="item-count px-3 py-1">{{ $trend->category->webinars_count }} {{ trans('product.course') }}</div>
                                            <div class="trending-image d-flex align-items-center justify-content-center" style="background-color:{{ $trend->color }}">
                                                <img src="{{ $trend->getIcon() }}" alt="{{ $trend->category->title }}">
                                            </div>
                                            <h3>{{ $trend->category->title }}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <a href="/{{app()->getLocale()}}/classes" class="btn-primary-custom px-3 py-2 mt-3" style="    border-radius: 20px;">{{__('all courses')}}</a>
                    </div>
                </div>
            </section>
        @endif

        {{-- Featured Classes --}}
        @if (
            $homeSection->name == \App\Models\HomeSection::$featured_classes &&
            !empty($featureWebinars) && !$featureWebinars->isEmpty()
        )
            <section class="home-sections home-sections-swiper container arabic-font">
                <div class="px-10 px-md-0">
                    <h2 class="section-title">{{ trans('home.featured_classes') }} 111</h2>
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


        {{-- Latest Classes (Tracks Grid) --}}
        {{--@if ($homeSection->name == \App\Models\HomeSection::$latest_classes && !empty($latestWebinars) && !$latestWebinars->isEmpty())
            <section class="home-sections container-fluid py-60">
                <div class="text-center mb-40">
                    <h2 class="section-title mb-10">{{__('home.Specialized_educational')}}</h2>
                    <p class="section-hint">{{__('home.Choose_path')}}</p>
                    <div class="tracks-filter">
                        <button class="filter-btn active">{{__("home.all")}}</button>
                        <button class="filter-btn">{{__("home.Leadership_Management")}}</button>
                        <button class="filter-btn">{{__("home.Technology_Data")}}</button>
                        <button class="filter-btn">{{__("home.Instructional_design")}}</button>
                    </div>
                </div>
                <div class="tracks-grid">
                    @foreach ($latestWebinars as $latestWebinar)
                        <div class="track-card">
                            <div class="track-top">
                                <div class="track-icon"><i class="bi bi-book"></i></div>
                                <span class="track-badge">{{__('home.remote')}}</span>
                            </div>
                            <h3 class="track-title">{{ $latestWebinar->title }}</h3>
                            <p class="track-desc">{{ Str::limit(strip_tags($latestWebinar->description), 120) }}</p>
                            <div class="track-divider"></div>
                            <div class="track-footer">
                                <a href="{{ $latestWebinar->getUrl() }}" class="track-details">{{__('home.details')}}</a>
                                <span class="track-date">{{ date('Y d M', $latestWebinar->created_at) }}</span>
                            </div>
                        </div>
                    @endforeach
                    <div class="track-card discover-card">
                        <div class="discover-icon">+</div>
                        <h3 class="discover-title">{{__("home.Discover_more")}}</h3>
                        <p class="discover-text">{{__("home.Browse_programs")}}</p>
                    </div>
                </div>
            </section>
        @endif--}}
        
        {{-- Latest Classes (Tracks Grid) --}}
{{--@if (
    $homeSection->name == \App\Models\HomeSection::$latest_classes
    && !empty($latestWebinars)
    && !$latestWebinars->isEmpty()
)
    <section id="specialized-tracks"
             class="home-sections container-fluid py-60">

        <div class="text-center mb-40">
            <h2 class="section-title mb-10">
                {{ __('home.Specialized_educational') }}
            </h2>

            <p class="section-hint">
                {{ __('home.Choose_path') }}
            </p>

            <form action="{{ url()->current() }}#specialized-tracks"
                  method="GET"
                  class="tracks-filter"
                  aria-label="{{ app()->getLocale() === 'ar' ? 'تصفية المسارات' : 'Filter tracks' }}">

                <button type="submit"
                        name="track_category"
                        value=""
                        class="filter-btn {{ $selectedTrackCategory === '' ? 'active' : '' }}"
                        aria-pressed="{{ $selectedTrackCategory === '' ? 'true' : 'false' }}">
                    {{ __('home.all') }}
                </button>

                @foreach ($trackCategories as $trackCategory)
                    @php
                        $isSelected = (string) $trackCategory->id === $selectedTrackCategory;
                    @endphp

                    <button type="submit"
                            name="track_category"
                            value="{{ $trackCategory->id }}"
                            class="filter-btn {{ $isSelected ? 'active' : '' }}"
                            aria-pressed="{{ $isSelected ? 'true' : 'false' }}">
                        {{ $trackCategory->title }}
                    </button>
                @endforeach
            </form>
        </div>

        <div class="tracks-grid">
            @foreach ($latestWebinars as $latestWebinar)
                <div class="track-card">
                    <div class="track-top">
                        <div class="track-icon">
                            <i class="bi bi-book" aria-hidden="true"></i>
                        </div>

                        <span class="track-badge">
                            {{ __('home.remote') }}
                        </span>
                    </div>
                    
                     

                    <h3 class="track-title">
                        {{ $latestWebinar->title }}
                    </h3>

                    <p class="track-desc">
                        {{ \Illuminate\Support\Str::limit(
                            strip_tags($latestWebinar->description ?? ''),
                            120
                        ) }}
                    </p>

                    <div class="track-divider"></div>

                    <div class="track-footer">
                        <a href="{{ $latestWebinar->getUrl() }}"
                           class="track-details">
                            {{ __('home.details') }}
                        </a>

                        <span class="track-date">
                            {{ date('Y d M', $latestWebinar->created_at) }}
                        </span>
                    </div>
                </div>
            @endforeach

            <a href="{{ url(app()->getLocale() . '/classes') }}"
               class="track-card discover-card">
                <div class="discover-icon" aria-hidden="true">+</div>

                <h3 class="discover-title">
                    {{ __('home.Discover_more') }}
                </h3>

                <p class="discover-text">
                    {{ __('home.Browse_programs') }}
                </p>
            </a>
        </div>
    </section>
@endif--}}

{{-- CET Courses --}}
@if (
    $homeSection->name == \App\Models\HomeSection::$latest_classes
    && !empty($latestWebinars)
    /*&& !$latestWebinars->isEmpty()*/
)
    <section id="specialized-tracks"
             class="home-sections container-fluid py-60">

        <div class="text-center mb-40">
            <h2 class="section-title mb-10">
                @if(app()->getLocale()=='ar')
                خطة البرامج التدريبة
                @else
                training program plans
                @endif
                
            </h2>

            <p class="section-hint">
                {{ __('home.Choose_path') }}
            </p>

            <form action="{{ url()->current() }}#specialized-tracks"
                  method="GET"
                  class="tracks-filter">

                <button type="submit"
                        name="track_category"
                        value=""
                        class="filter-btn {{ empty($selectedTrackCategory) ? 'active' : '' }}">
                    {{ __('home.all') }}
                </button>

                @foreach ($trackCategories as $trackCategory)
                    <button type="submit"
                            name="track_category"
                            value="{{ $trackCategory->id }}"
                            class="filter-btn {{ (string) $trackCategory->id === (string) $selectedTrackCategory ? 'active' : '' }}">
                        {{ $trackCategory->title }}
                    </button>
                @endforeach
            </form>
        </div>

        <div class="tracks-grid">
            @foreach ($latestWebinars as $latestWebinar)
                @php
                    $details = json_decode($latestWebinar->details, true);
                    $detail = is_array($details) ? ($details[0] ?? []) : [];
                @endphp

                <div class="track-card">
                    {{--<div class="track-top">
                        <div class="track-icon">
                            <i class="bi bi-book" aria-hidden="true"></i>
                        </div>

                        <span class="track-badge">
                            {{ __('home.remote') }}
                        </span>
                    </div>--}}
                    
                    <img src="{{ $latestWebinar->getImage() }}" alt="{{ $latestWebinar->title ?? '' }}" class="img-cover mb-3">

                    <h3 class="track-title">
                        {{ $latestWebinar->title }}
                    </h3>

                    <div class="track-desc">
                        @if (!empty($detail['date']))
                            <div>
                                <strong>{{ trans('public.Date') }}:</strong>
                                {{ $detail['date'] }}
                            </div>
                        @endif

                        @if (!empty($detail['start_time']) || !empty($detail['end_time']))
                            <div>
                                <strong>{{ trans('public.Time') }}:</strong>
                                {{ $detail['start_time'] ?? '---' }}
                                -
                                {{ $detail['end_time'] ?? '---' }}
                            </div>
                        @endif

                        @if (isset($detail['price']))
                            <div>
                                <strong>{{ trans('public.Price') }}:</strong>
                                {{ number_format($detail['price'], 2) }}
                                {{ trans('public.SAR') }}
                            </div>
                        @endif

                        <div>
                            <strong>{{ trans('public.Location') }}:</strong>
                            {{ $detail['location'] ?? '—' }}
                        </div>

                        <div>
                            <strong>{{ trans('public.Language') }}:</strong>
                            @switch($detail['lang'] ?? '')
                                @case('AR') {{ trans('public.Arabic') }} @break
                                @case('EN') {{ trans('public.English') }} @break
                                @default {{ trans('public.Bilanguage') }}
                            @endswitch
                        </div>

                        <div>
                            <strong>{{ trans('public.Duration') }}:</strong>
                            {{ $detail['ndays'] ?? '—' }}
                            {{ trans('public.Days') }}
                        </div>
                    </div>

                    <div class="track-divider"></div>

                    <div class="track-footer">
                        <a href="{{ $latestWebinar->getUrl() }}"
                           class="track-details">
                            {{ trans('public.details') }}
                        </a>
                    </div>
                </div>
            @endforeach

            <a href="{{ url(app()->getLocale() . '/cet-course/plan') }}"
               class="track-card discover-card">
                <div class="discover-icon" aria-hidden="true">+</div>

                <h3 class="discover-title">
                    {{ __('home.Discover_more') }}
                </h3>

                <p class="discover-text">
                    {{ __('home.Browse_programs') }}
                </p>
            </a>
        </div>
    </section>
@endif

    @endforeach

    {{-- ============================================================
         SECOND LOOP (statistics placeholder removed, keeping @once sections)
    ============================================================ --}}
    @foreach ($homeSections as $homeSection)

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

        {{-- @once: Solutions + Services Big + CTA --}}
        @once
            {{-- Solutions (Blue Box) --}}
            <section class="solutions-section">
                <div class="container">
                    <div class="solutions-box">
                        <div class="solutions-items">
                            <div class="solution-item">
                                <h4>{{__("home.Needs_analysis")}}</h4>
                                <p>{{__("home.Skills_gap")}}</p>
                            </div>
                            <div class="solution-item">
                                <h4>{{__('home.Building_paths')}}</h4>
                                <p>{{__("home.Designing_customized")}}</p>
                            </div>
                            <div class="solution-item">
                                <h4>{{__("home.Impact_measurement")}}</h4>
                                <p>{{__("home.Detailed_reports")}}</p>
                            </div>
                        </div>
                        <div class="solutions-content">
                            <span class="solutions-badge">{{__("home.Solutions_organizations")}}</span>
                            <h2>{{__("home.Programs_organization")}}</h2>
                            <p>{{__("home.design_customized_training")}}</p>
                            <a href="/{{app()->getLocale()}}/request-consulting">{{__("home.Request_consultation")}}</a>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Services Big --}}
            <section class="services-big-section">
                <div class="services-big-card" style="max-width:1200px;margin:0 auto;">
                    <div class="services-big-image">
                        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d" alt="services">
                    </div>
                    <div class="services-big-content">
                        <h2>{{__('home.Content_development')}}</h2>
                        <p>{{__("home.Integrated_solutions")}}</p>
                        <a href="{{ url(app()->getLocale() . '/request-content-development') }}" class="btn-outline">{{__("home.Request_now")}}</a>
                    </div>
                </div>
            </section>

            {{-- CTA --}}
            <section class="services-cta-section">
                <div class="services-cta-box">
                    <div class="services-cta-text">
                        <h3>{{__('home.have_specific_training')}}</h3>
                        <p>{{__('home.team_is_ready')}}</p>
                    </div>
                    <div class="services-cta-actions">
                        <a href="{{ url(app()->getLocale() . '/request-quotation') }}" class="btn-outline-custom">{{__("home.Request_quotation")}}</a>
                        <a href="{{ url(app()->getLocale() . '/contact') }}" class="btn-primary-custom">{{__("home.Contact_us")}}</a>
                    </div>
                </div>
            </section>
        @endonce

        {{-- Testimonials (Clients) --}}
        @if ($homeSection->name == \App\Models\HomeSection::$testimonials && !empty($showcaseClients) && !$showcaseClients->isEmpty())
            <section class="home-sections">
                <div class="container">
                    <div class="text-center my-40">
                        <h2 class="section-title">{{ trans('app.clients') }}</h2>
                        <p class="section-hint"></p>
                    </div>
                    <div class="position-relative mt-20 ltr">
                        @include('web.default.includes.branch_showcase_carousel', ['items' => $showcaseClients])
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

        {{-- Instructors (Partners) --}}
        @if ($homeSection->name == \App\Models\HomeSection::$instructors && !empty($showcasePartners) && !$showcasePartners->isEmpty())
            <section class="home-sections">
                <div class="container">
                    <div class="text-center my-40">
                        <h2 class="section-title">{{ trans('app.comapny') }}</h2>
                        <p class="section-hint"></p>
                    </div>
                    <div class="position-relative mt-20 ltr">
                        @include('web.default.includes.branch_showcase_carousel', ['items' => $showcasePartners])
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

        {{-- Events --}}
        @if ($homeSection->name == \App\Models\HomeSection::$store_products)
            @if (!$oldEvents->isEmpty() || !$events->isEmpty())
                <section class="" style="padding-bottom:0;">
                    <div class="events-wrapper">
                        <div class="container">
                            <div class="text-center mb-5">
                                <h2 class="events-title">{{ trans('events.events') }}</h2>
                            </div>
                            <div class="row gy-4 gx-3">
                                @foreach ($oldEvents->merge($events) as $event)
                                    @php
                                        $eventDate = \Carbon\Carbon::parse($event->start_date)->format('Y-m-d');
                                        $today = \Carbon\Carbon::now()->format('Y-m-d');
                                        $label = $eventDate == $today ? 'فعالية حالية' : ($eventDate > $today ? 'فعالية قادمة' : 'فعالية منتهية');
                                    @endphp
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="event-card">
                                            <div class="event-image">
                                                <img src="{{ $event->image }}" alt="{{ $event->title }}">
                                                <div class="event-badges">
                                                        <span class="event-date">
                                                            <i class="far fa-calendar-alt"></i>
                                                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                                        </span>
                                                    <span class="event-status">{{ $label }}</span>
                                                </div>
                                            </div>
                                            <div class="event-body">
                                                <a href="{{ app()->getLocale() }}/event/{{ $event->slug }}">
                                                    <h3>{{ $event->title }}</h3>
                                                </a>
                                                <p>{!! truncate(strip_tags($event->details), 120) !!}</p>
                                                <div class="event-footer">
                                                    <div><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</div>
                                                    <div><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                             
                            <div class="d-flex justify-content-center">
                              
                                 <a href="{{ route(app()->getLocale() === 'en' ? 'web.events.en' : 'web.events.ar') }}"
       class="btn btn-light btn-sm mt-15">
        {{ app()->getLocale() === 'en' ? 'View all events' : 'عرض كل الفعاليات' }}
    </a>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
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
                effect: 'slide', speed: 1000,
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: { el: '.swiper-pagination', clickable: true },
                on: {
                    init: function() { updateProgress(this); },
                    slideChange: function() { updateProgress(this); },
                }
            });

            document.querySelectorAll('.customised-pagination-bullet').forEach((bullet, index) => {
                bullet.addEventListener('click', () => { heroSlider.slideTo(index); });
            });

            heroSlider.on('slideChange', function() {
                document.querySelectorAll('.customised-pagination-bullet').forEach((bullet, index) => {
                    bullet.classList.toggle('customised-pagination-bullet-active', index === heroSlider.activeIndex);
                });
            });

            function updateProgress(swiper) {
                const progress = document.querySelector('.progress-bar');
                if (progress) { progress.style.width = '0%'; setTimeout(() => { progress.style.width = '100%'; }, 100); }
            }
        });
    </script>
@endpush
