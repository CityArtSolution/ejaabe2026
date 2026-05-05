@extends(getTemplate().'.layouts.canada_app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
    <link href="/assets/demo/assets/css/flaticon-set.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1363a1;
            --primary-light: #1a7fc4;
            --primary-dark: #0d4f80;
            --accent: #f0a500;
            --surface: #f8fafc;
            --surface-2: #eef3f8;
            --text-main: #1a2332;
            --text-muted: #5a6a7e;
            --white: #ffffff;
            --border: rgba(19, 99, 161, 0.12);
            --shadow-sm: 0 2px 12px rgba(19, 99, 161, 0.08);
            --shadow-md: 0 8px 32px rgba(19, 99, 161, 0.14);
            --shadow-lg: 0 20px 60px rgba(19, 99, 161, 0.18);
        }

        .home-sections {
            margin-top: 80px !important;
        }

        /* ─── HERO BANNER ─────────────────────────────────────────── */
        .cart-banner {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%);
            min-height: 220px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .cart-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 80% at 80% 50%, rgba(255,255,255,0.06) 0%, transparent 70%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .cart-banner h1 {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            position: relative;
            text-shadow: 0 2px 16px rgba(0,0,0,0.18);
        }
        .cart-banner h1::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: var(--accent);
            margin: 12px auto 0;
            border-radius: 2px;
        }

        /* ─── CEO MESSAGE ─────────────────────────────────────────── */
        .ceo-section {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        .ceo-section::before {
            content: '"';
            position: absolute;
            top: -10px;
            left: 30px;
            font-size: 12rem;
            color: var(--primary);
            opacity: 0.05;
            font-family: Georgia, serif;
            line-height: 1;
            pointer-events: none;
        }
        .ceo-section h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--primary);
            border-right: 4px solid var(--accent);
            padding-right: 16px;
            margin-bottom: 1.5rem;
        }
        [dir="ltr"] .ceo-section h2,
        .ltr-mode .ceo-section h2 {
            border-right: none;
            border-left: 4px solid var(--accent);
            padding-right: 0;
            padding-left: 16px;
        }
        .ceo-section p {
            color: var(--text-muted);
            font-size: 1.05rem;
            line-height: 1.9;
        }
        .author-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 14px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: var(--shadow-md);
            margin-top: 1.5rem;
        }
        .author-badge::before {
            content: '';
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            flex-shrink: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z'/%3E%3C/svg%3E");
            background-size: 20px;
            background-repeat: no-repeat;
            background-position: center;
        }

        /* ─── DIVIDER ─────────────────────────────────────────────── */
        .fancy-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 3rem 0;
        }
        .fancy-divider::before,
        .fancy-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
        }
        .fancy-divider-dot {
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
        }

        /* ─── ABOUT CONTENT BLOCK ─────────────────────────────────── */
        .about-content-block {
            background: var(--surface);
            border-radius: 20px;
            padding: 2.5rem;
            border: 1px solid var(--border);
            position: relative;
        }
        .about-content-block h2 {
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }
        .about-content-block h2::after {
            content: '';
            position: absolute;
            bottom: -6px;
            right: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 2px;
        }
        .about-content-block p {
            color: var(--text-muted);
            font-size: 1rem;
            line-height: 1.9;
            margin-bottom: 1rem;
        }
        .about-img-wrapper {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            position: relative;
        }
        .about-img-wrapper img {
            width: 100%;
            display: block;
            max-height: 340px;
            object-fit: cover;
        }
        .about-img-wrapper::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            border: 2px solid rgba(19, 99, 161, 0.15);
            pointer-events: none;
        }

        /* ─── SECTION TITLE ───────────────────────────────────────── */
        .section-title-wrapper {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .section-title-wrapper .eyebrow {
            display: inline-block;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--primary);
            background: rgba(19, 99, 161, 0.08);
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 12px;
        }
        .section-title-wrapper h2.section-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
        }
        .section-title-wrapper h2.section-title::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            margin: 12px auto 0;
            border-radius: 2px;
        }

        /* ─── VISION / VALUES / MISSION CARDS ────────────────────── */
        .vvm-card {
            background: var(--white);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            text-align: center;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .vvm-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 0 0 4px 4px;
            transition: width 0.35s ease;
        }
        .vvm-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(19, 99, 161, 0.2);
        }
        .vvm-card:hover::before {
            width: 120px;
        }
        .vvm-card .icon-wrap {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, rgba(19, 99, 161, 0.08), rgba(19, 99, 161, 0.14));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            transition: all 0.3s ease;
        }
        .vvm-card:hover .icon-wrap {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            transform: rotate(5deg) scale(1.05);
        }
        .vvm-card .icon-wrap i {
            font-size: 2rem;
            color: var(--primary);
            transition: color 0.3s ease;
        }
        .vvm-card:hover .icon-wrap i {
            color: var(--white);
        }
        .vvm-card h4 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.75rem;
        }
        .vvm-card p, .vvm-card p p {
            color: var(--text-muted);
            font-size: 0.93rem;
            line-height: 1.75;
            margin: 0;
        }

        /* ─── TEAM / CLIENTS CAROUSEL ─────────────────────────────── */
        .carousel-section-bg {
            background: linear-gradient(160deg, var(--surface) 0%, var(--surface-2) 100%);
            border-radius: 24px;
            padding: 3rem 2rem;
            border: 1px solid var(--border);
        }
        .instructors-card {
            background: var(--white);
            border-radius: 16px;
            padding: 1.5rem 1rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            min-height: 160px;
        }
        .instructors-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
        }
        .instructors-card-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid rgba(19, 99, 161, 0.15);
            box-shadow: 0 4px 16px rgba(19, 99, 161, 0.15);
            transition: border-color 0.3s ease;
        }
        .instructors-card:hover .instructors-card-avatar {
            border-color: var(--primary);
        }
        .instructors-card-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        /* Client logos — rectangular */
        .client-logo-card .instructors-card-avatar {
            width: 120px;
            height: 80px;
            border-radius: 10px;
        }

        /* ─── TESTIMONIALS BG ─────────────────────────────────────── */
        .testimonials-container {
            background: linear-gradient(180deg, transparent, var(--surface-2) 30%, var(--surface-2) 70%, transparent);
        }

        /* ─── RESPONSIVE ──────────────────────────────────────────── */
        @media (max-width: 768px) {
            .ceo-section { padding: 2rem 1.5rem; }
            .about-content-block { padding: 1.75rem 1.25rem; }
            .cart-banner h1 { font-size: 1.6rem; }
            .vvm-card { padding: 2rem 1.25rem; }
        }
    </style>
@endpush

@section('content')

    {{-- ── HERO BANNER ── --}}
    <section class="cart-banner position-relative text-center">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-12 col-md-9 col-lg-7">
                    <h1 class="font-weight-bold text-white">{{ trans('app.about') }}</h1>
                </div>
            </div>
        </div>
    </section>

    @if(App::getLocale() == 'ar')
        {{-- ══════════════════ ARABIC VERSION ══════════════════ --}}

        {{-- CEO Message --}}
        <section class="home-sections">
            <div class="container">
                <div class="ceo-section" dir="rtl">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h2>رسالة رئيس مجلس المديرين</h2>
                            <p>
                                شكلت السنوات الماضية نقطة تحول رئيسية لمجتمعنا. جنبًا إلى جنب مع رؤية المملكة العربية
                                السعودية الطموحة 2030. من خلال طرح هذه التغييرات، فقد اختبرنا القوة الهائلة والقيمة
                                الهائلة لمنظمات التمكين الإيجابي والأشخاص ذوي المعرفة والمهارات القوية ليكونوا متوافقين
                                مع المتطلبات الأساسية والتغييرات الديناميكية.
                            </p>
                            <div class="author-badge">Jawaher Basoodan</div>
                        </div>
                        <div class="col-lg-4 mt-4 mt-lg-0 text-center">
                            <div style="background: linear-gradient(135deg, rgba(19,99,161,0.06), rgba(19,99,161,0.12)); border-radius: 16px; padding: 2rem; border: 1px solid var(--border);">
                                <div style="width:80px;height:80px;background:linear-gradient(135deg,var(--primary),var(--primary-light));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                                    <svg width="36" height="36" fill="white" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                                </div>
                                <div style="color: var(--primary); font-weight: 700; font-size: 1rem;">Jawaher Basoodan</div>
                                <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 4px;">رئيس مجلس المديرين</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- About Us --}}
        <section class="home-sections">
            <div class="container">
                <div class="fancy-divider"><div class="fancy-divider-dot"></div></div>
                <div class="row align-items-center g-4" dir="rtl">
                    <div class="col-lg-5">
                        <div class="about-img-wrapper">
                            <img src="https://ejaabi.com/public/uploads/main/images/09-12-2023/65740261a4699.png" alt="Positive Interaction">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="about-content-block">
                            <h2>نبذة عن التفاعل الإيجابي</h2>
                            <p>
                                تُعدّ شركة <strong>Positive Interaction for Training and Consulting Inc.</strong> مؤسسة تدريب واستشارات مهنية مسجلة في كندا، وتعمل وفق أحكام قانون الشركات الكندية (CBCA)، حيث تتخذ من مدينة ميسيساغا – أونتاريو مقرًا لها، وتقدم خدماتها بمعايير عالمية تجمع بين الخبرة الدولية والفهم العميق لاحتياجات الأسواق المحلية والإقليمية والدولية.
                            </p>
                            <p>
                                نؤمن في "التفاعل الإيجابي" بأن التدريب لم يعد مجرد نقل معرفة، بل هو أداة استراتيجية لتمكين الأفراد والمؤسسات من تحقيق أداء مستدام وقابل للقياس. ومن هذا المنطلق، نعمل على تصميم وتقديم برامج تدريبية واستشارية متخصصة ترتكز على أفضل الممارسات العالمية، مع مواءمتها لبيئات العمل الواقعية.
                            </p>
                            <p>
                                نعتمد في منهجيتنا على الدمج بين الخبرة العملية، والتطبيقات التفاعلية، والتقنيات الحديثة، بما في ذلك توظيف البيانات والذكاء الاصطناعي لتعزيز فعالية التعلم وتحقيق أثر ملموس في الأداء المؤسسي.
                            </p>
                            <p>
                                بقيادة فريق من الخبراء والمدربين الدوليين، تلتزم الشركة بتقديم حلول تدريبية واستشارية مبتكرة تدعم تطوير القدرات، وترتقي بكفاءة الكوادر، وتسهم في تحقيق الأهداف الاستراتيجية للمؤسسات.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Vision / Values / Mission --}}
        <section class="home-sections">
            <div class="container">
                <div class="section-title-wrapper" dir="rtl">
                    <span class="eyebrow">هويتنا</span>
                    <h2 class="section-title">من نحن</h2>
                </div>
                <div class="row g-4" dir="rtl">
                    <div class="col-md-4">
                        <div class="vvm-card">
                            <div class="icon-wrap"><i class="flaticon-hr"></i></div>
                            <h4>رؤيتنا</h4>
                            <p>أن نكون مرجعاً موثوقاً في مجال التدريب والاستشارات محلياً وإقليمياً.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="vvm-card">
                            <div class="icon-wrap"><i class="flaticon-value"></i></div>
                            <h4>قيمنا</h4>
                            <p>المسؤولية &nbsp;·&nbsp; الابتكار &nbsp;·&nbsp; الالتزام</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="vvm-card">
                            <div class="icon-wrap"><i class="flaticon-start"></i></div>
                            <h4>رسالتنا</h4>
                            <p>نعمل مع محترفين ذوي خبرة استثنائية لتوفير رأس مال فكري يواكب المتغيرات المحلية والدولية، ونعتمد أفضل الممارسات المهنية في التدريب والاستشارات الإدارية والتعليمية.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @else
        {{-- ══════════════════ ENGLISH / FRENCH VERSION ══════════════════ --}}

        {{-- CEO Message --}}
        <section class="home-sections">
            <div class="container">
                <div class="ceo-section">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h2 style="border-right:none;border-left:4px solid var(--accent);padding-left:16px;padding-right:0;">Message from CEO</h2>
                            <p>
                                The past years marked a major turning point for our society. Along with the
                                ambitious 2030 Vision of the Kingdom of Saudi Arabia. In throwing these changes
                                in, we have experienced the great power and value of empowering organizations
                                and individuals positively with a solid knowledge and skills to be compatible
                                with the basic requirements and dynamic changes.
                            </p>
                            <div class="author-badge" style="border-radius:50px;">Dr. / Jawaher Basoodan</div>
                        </div>
                        <div class="col-lg-4 mt-4 mt-lg-0 text-center">
                            <div style="background: linear-gradient(135deg, rgba(19,99,161,0.06), rgba(19,99,161,0.12)); border-radius: 16px; padding: 2rem; border: 1px solid var(--border);">
                                <div style="width:80px;height:80px;background:linear-gradient(135deg,var(--primary),var(--primary-light));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                                    <svg width="36" height="36" fill="white" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                                </div>
                                <div style="color: var(--primary); font-weight: 700; font-size: 1rem;">Dr. Jawaher Basoodan</div>
                                <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 4px;">CEO & Board Chair</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- About Us — EN + FR side by side --}}
        <section class="home-sections">
            <div class="container">
                <div class="fancy-divider"><div class="fancy-divider-dot"></div></div>
                <div class="row g-4">

                    {{-- English --}}
                    <div class="col-lg-6">
                        <div class="about-content-block h-100">
                            <div class="lang-badge lang-badge-en">🇬🇧 English</div>
                            <h2 style="display:block;">About Us</h2>
                            <p>
                                Positive Interaction for Training and Consulting Inc. is a professional training and consulting firm registered in Canada, operating under the Canada Business Corporations Act (CBCA). Headquartered in Mississauga, Ontario, the company delivers its services in line with global standards, combining international expertise with a deep understanding of local, regional, and international market needs.
                            </p>
                            <p>
                                At Positive Interaction, we believe that training is no longer just about transferring knowledge—it is a strategic tool for empowering individuals and organizations to achieve sustainable and measurable performance. From this perspective, we design and deliver specialized training and consulting solutions grounded in global best practices and tailored to real-world business environments.
                            </p>
                            <p>
                                Our methodology integrates practical experience, interactive learning approaches, and advanced technologies, including data-driven insights and artificial intelligence, to enhance learning effectiveness and deliver tangible impact on organizational performance.
                            </p>
                            <p>
                                Led by a team of international experts and trainers, the company is dedicated to delivering innovative training and consulting solutions that strengthen capabilities, elevate workforce performance, and support the achievement of strategic objectives.
                            </p>
                        </div>
                    </div>

                    {{-- French --}}
                    <div class="col-lg-6">
                        <div class="about-content-block h-100">
                            <div class="lang-badge lang-badge-fr">🇫🇷 Français</div>
                            <h2 style="display:block;">À propos de nous</h2>
                            <p>
                                Positive Interaction for Training and Consulting Inc. est un cabinet professionnel de formation et de conseil, enregistré au Canada et opérant conformément à la Loi canadienne sur les sociétés par actions (CBCA). Basée à Mississauga, en Ontario, l'entreprise fournit ses services selon des standards internationaux, en combinant une expertise globale avec une compréhension approfondie des besoins des marchés locaux, régionaux et internationaux.
                            </p>
                            <p>
                                Chez Positive Interaction, nous croyons que la formation ne se limite plus à un simple transfert de connaissances, mais constitue un levier stratégique pour permettre aux individus et aux organisations d'atteindre une performance durable et mesurable. Dans cette optique, nous concevons et proposons des solutions de formation et de conseil spécialisées, fondées sur les meilleures pratiques internationales et adaptées aux environnements professionnels réels.
                            </p>
                            <p>
                                Notre méthodologie repose sur l'intégration de l'expérience pratique, des approches d'apprentissage interactives et des technologies avancées, notamment l'exploitation des données et de l'intelligence artificielle, afin d'améliorer l'efficacité de l'apprentissage et de générer un impact concret sur la performance organisationnelle. Nous nous engageons à bâtir des partenariats durables avec nos clients, fondés sur la confiance, la flexibilité et la création de valeur.
                            </p>
                            <p>
                                Dirigée par une équipe d'experts et de formateurs internationaux, l'entreprise s'engage à fournir des solutions innovantes en formation et en conseil, visant à renforcer les compétences, améliorer la performance des équipes et soutenir la réalisation des objectifs stratégiques.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- Vision / Values / Mission --}}
        <section class="home-sections">
            <div class="container">
                <div class="section-title-wrapper">
                    <span class="eyebrow">Who We Are</span>
                    <h2 class="section-title">About Us</h2>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="vvm-card">
                            <div class="icon-wrap"><i class="flaticon-creativity"></i></div>
                            <h4>Our Vision</h4>
                            <p>To be a reliable reference in the field of consulting and training locally and regionally.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="vvm-card">
                            <div class="icon-wrap"><i class="flaticon-result"></i></div>
                            <h4>Our Values</h4>
                            <p>Responsibility &nbsp;·&nbsp; Empowerment &nbsp;·&nbsp; Commitment &nbsp;·&nbsp; Innovation</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="vvm-card">
                            <div class="icon-wrap"><i class="flaticon-meeting"></i></div>
                            <h4>Our Mission</h4>
                            <p>Working with exceptional experienced professionals to provide intellectual capital that keeps pace with local and international changes — in Training and Administrative &amp; Educational Consulting.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ── TEAM CAROUSEL ── --}}
    <section class="home-sections" style="margin-top: 100px !important">
        <div class="container">
            <div class="section-title-wrapper">
                <span class="eyebrow">{{ App::getLocale() == 'ar' ? 'فريقنا' : 'Our Team' }}</span>
                <h2 class="section-title">{{ trans('app.comapny') }}</h2>
            </div>
            <div class="carousel-section-bg">
                <div class="position-relative ltr">
                    <div class="owl-carousel customers-testimonials instructors-swiper-container">
                        @foreach([
                            'https://ejaabi.com/public/uploads/main/images/02-12-2023/656ae01bdedbe.jpeg',
                            'https://ejaabi.com/public/uploads/main/images/02-12-2023/656ae4cda1168.png',
                            'https://ejaabi.com/public/uploads/main/images/27-12-2023/658c10b1e31d2.png',
                            'https://ejaabi.com/public/uploads/main/images/04-12-2023/656e2faf5e7a3.jpeg',
                            'https://ejaabi.com/public/uploads/main/images/19-05-2024/6649ba3691866.jpg',
                            'https://ejaabi.com/public/uploads/main/images/19-05-2024/6649bdb36f0cd.png',
                        ] as $img)
                            <div class="item">
                                <div class="shadow-effect">
                                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                                        <div class="instructors-card-avatar">
                                            <img src="{{ $img }}" alt="" class="img-cover">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CLIENTS CAROUSEL ── --}}
    <div class="position-relative home-sections testimonials-container">
        <section class="home-sections container">
            <div class="section-title-wrapper">
                <span class="eyebrow">{{ App::getLocale() == 'ar' ? 'شركاؤنا' : 'Our Partners' }}</span>
                <h2 class="section-title">{{ trans('app.clients') }}</h2>
            </div>

            <div class="carousel-section-bg">
                <div class="position-relative ltr">
                    <div class="owl-carousel customers-testimonials instructors-swiper-container">
                        @foreach([
                            'https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeaca39a58.jpeg',
                            'https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfefa364dfb.jpeg',
                            'https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfea64e8494.jpeg',
                            'https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeac220c6e.jpeg',
                            'https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeb708b082.png',
                        ] as $img)
                            <div class="item">
                                <div class="shadow-effect">
                                    <div class="instructors-card client-logo-card d-flex flex-column align-items-center justify-content-center">
                                        <div class="instructors-card-avatar">
                                            <img src="{{ $img }}" alt="" class="img-cover">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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

@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
    <script src="/assets/default/js/parts/home.min.js"></script>
@endpush
