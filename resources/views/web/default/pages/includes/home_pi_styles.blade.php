{{-- تنسيقات الصفحة الرئيسية بهوية «التفاعل الإيجابي» — كل الأصناف تبدأ بـ pi- حتى لا تتعارض مع app.css --}}
<style>
:root {
  /* الألوان */
  --pi-c-bg: #eef6f9;
  --pi-c-bg-soft: #dfeef5;
  --pi-c-bg-gray: #ececec;
  --pi-c-blue: #006ba3;
  --pi-c-blue-600: #005a8a;
  --pi-c-blue-800: #0b4f86;
  --pi-c-sky: #1a8fd0;
  --pi-c-petrol: #2d4a5c;
  --pi-c-petrol-700: #233b4a;
  --pi-c-navy: #0c2b4a;
  --pi-c-navy-900: #09233e;
  --pi-c-orange: #f4a340;
  --pi-c-orange-600: #e58c22;
  --pi-c-gold-soft: #ffd59a;
  --pi-c-ink: #17324a;
  --pi-c-muted: #5a7183;
  --pi-c-line: #d4e4ec;

  /* الخطوط */
  --pi-f-display: "GE-Dinar-Two", "main-font-family", "Tajawal", "IBM Plex Sans Arabic", "Segoe UI", Tahoma, sans-serif;
  --pi-f-body: "GE-Dinar-Two", "main-font-family", "IBM Plex Sans Arabic", "Tajawal", "Segoe UI", Tahoma, sans-serif;

  /* سلّم المقاسات */
  --pi-fs-xs: .8125rem;
  --pi-fs-sm: .9375rem;
  --pi-fs-md: 1.0625rem;
  --pi-fs-lg: 1.25rem;
  --pi-fs-xl: clamp(1.5rem, 1.1rem + 1.4vw, 2rem);
  --pi-fs-2xl: clamp(1.75rem, 1.2rem + 2vw, 2.6rem);
  --pi-fs-hero: clamp(1.9rem, 1.1rem + 3vw, 3.2rem);

  --pi-r-sm: 8px;
  --pi-r-md: 14px;
  --pi-r-lg: 22px;
  --pi-shadow-sm: 0 2px 8px rgba(12, 43, 74, .06);
  --pi-shadow-md: 0 10px 30px rgba(12, 43, 74, .10);
  --pi-shadow-lg: 0 20px 50px rgba(12, 43, 74, .18);
  --pi-ease: cubic-bezier(.22, .8, .24, 1);
  --pi-container: 1200px;
  --pi-header-h: 78px;
}

body {
  background: var(--pi-c-bg);
  font-family: var(--pi-f-body);
  overflow-x: hidden;
}

/* ---------- أساس الأقسام الجديدة ---------- */
.pi-home {
  color: var(--pi-c-ink);
  font-family: var(--pi-f-body);
  font-size: var(--pi-fs-md);
  line-height: 1.75;
  -webkit-font-smoothing: antialiased;
}
.pi-home *, .pi-home *::before, .pi-home *::after { box-sizing: border-box; }
.pi-home img { max-width: 100%; display: block; }
.pi-home a, .pi-home a:hover { color: inherit; text-decoration: none; }
.pi-home button { font: inherit; cursor: pointer; }
.pi-home h1, .pi-home h2, .pi-home h3, .pi-home h4 {
  font-family: var(--pi-f-display); line-height: 1.3; margin: 0; text-wrap: balance; font-weight: 800; color: inherit;
}
.pi-home p { margin: 0; }
.pi-home p, .pi-home span, .pi-home li { font-family: inherit; }
.pi-home ul, .pi-home ol { margin: 0; padding: 0; list-style: none; }
.pi-home :focus-visible, .pi-to-top:focus-visible { outline: 3px solid var(--pi-c-orange); outline-offset: 3px; border-radius: 6px; }
.pi-home .pi-sr-only { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; }

.pi-home .pi-container { width: 100%; max-width: var(--pi-container); margin-inline: auto; padding-inline: 20px; }
.pi-home.pi-section { padding-block: clamp(56px, 7vw, 96px); }

/* ---------- الأزرار ---------- */
.pi-home .pi-btn {
  --bg: var(--pi-c-orange); --fg: #fff; --bd: transparent;
  display: inline-flex; align-items: center; justify-content: center; gap: .5em;
  min-height: 46px; padding: .55em 1.5em;
  background: var(--bg); color: var(--fg); border: 1.5px solid var(--bd);
  border-radius: 10px; font-family: var(--pi-f-display); font-weight: 700; font-size: var(--pi-fs-sm);
  letter-spacing: .01em; white-space: nowrap;
  transition: transform .25s var(--pi-ease), box-shadow .25s var(--pi-ease), background-color .25s, color .25s;
  position: relative; overflow: hidden; isolation: isolate;
}
.pi-home .pi-btn::after { /* لمعة عند المرور */
  content: ""; position: absolute; inset: 0; z-index: -1;
  background: linear-gradient(110deg, transparent 30%, rgba(255,255,255,.35) 50%, transparent 70%);
  transform: translateX(120%); transition: transform .6s var(--pi-ease);
}
.pi-home .pi-btn:hover { color: var(--fg); transform: translateY(-2px); box-shadow: 0 10px 22px rgba(12,43,74,.18); }
.pi-home .pi-btn:hover::after { transform: translateX(-120%); }
.pi-home .pi-btn svg { width: 18px; height: 18px; flex: none; }
.pi-home .pi-btn--orange { --bg: var(--pi-c-orange); }
.pi-home .pi-btn--orange:hover { --bg: var(--pi-c-orange-600); }
.pi-home .pi-btn--white { --bg: #fff; --fg: var(--pi-c-blue); }
.pi-home .pi-btn--blue { --bg: var(--pi-c-blue); }
.pi-home .pi-btn--blue:hover { --bg: var(--pi-c-blue-800); }
.pi-home .pi-btn--outline { --bg: #fff; --fg: var(--pi-c-petrol); --bd: var(--pi-c-line); }
.pi-home .pi-btn--outline:hover { --bd: var(--pi-c-petrol); }
.pi-home .pi-btn--sm { min-height: 38px; padding: .35em 1.1em; font-size: var(--pi-fs-xs); border-radius: 8px; }

/* ---------- عناوين الأقسام ---------- */
.pi-home .pi-sec-head { text-align: center; display: grid; gap: 10px; justify-items: center; margin-bottom: clamp(28px, 4vw, 44px); }
.pi-home .pi-sec-head h2 { font-size: var(--pi-fs-2xl); }
.pi-home .pi-sec-head p { color: var(--pi-c-muted); max-width: 60ch; }
.pi-home .pi-sec-head--light h2 { color: #fff; }
.pi-home .pi-sec-head--light p { color: var(--pi-c-gold-soft); }
.pi-home .pi-kicker {
  display: inline-block; font-family: var(--pi-f-display); font-weight: 700; font-size: var(--pi-fs-sm); line-height: 1.75;
  padding: .35em 1.4em; border-radius: 8px 8px 0 0; color: #fff; background: var(--pi-c-blue);
  letter-spacing: .02em;
}
.pi-home .pi-kicker--orange { background: var(--pi-c-orange); }

/* =========================================================
   2) البانر الرئيسي
   ========================================================= */
.pi-home.pi-hero { padding-top: 8px; }
.pi-home .pi-slider {
  position: relative; border-radius: var(--pi-r-lg); overflow: hidden;
  border: 4px solid #fff; box-shadow: var(--pi-shadow-md);
  background: var(--pi-c-blue-800);
  display: grid; max-width: 100%;
}
/* الشرائح متراكبة في خلية واحدة: ارتفاع البانر يتبع أطول شريحة فلا يُقصّ النص الطويل */
.pi-home .pi-slide {
  grid-area: 1 / 1; position: relative; min-width: 0; min-height: clamp(360px, 36.6vw, 430px); padding-block: 36px;
  display: flex; align-items: center;
  opacity: 0; visibility: hidden; transition: opacity .9s var(--pi-ease), visibility .9s;
}
.pi-home .pi-slide.is-active { opacity: 1; visibility: visible; }
.pi-home .pi-slide-media { position: absolute; inset: 0; overflow: hidden; }
/* الصورة يسار الشريحة والنص يمينها في اللغتين (صور البانر مرسومة على هذا الأساس) */
.pi-home .pi-slide-media img {
  position: absolute; left: 0; top: 0; height: 100%; width: 66%; max-width: none; object-fit: cover; object-position: left top;
  transform: scale(1.08); transform-origin: left top; transition: transform 7s linear;
}
.pi-home .pi-slide.is-active .pi-slide-media img { transform: scale(1); }
.pi-home .pi-slide-media::after { /* التدرج الأزرق لوضوح النص */
  content: ""; position: absolute; inset: 0;
  background:
    linear-gradient(0deg, rgba(11, 79, 134, .96) 0%, rgba(11, 79, 134, .7) 9%, rgba(11, 79, 134, 0) 27%), /* تباين لأزرار التحكم */
    linear-gradient(270deg, #0d5aa0 0%, #0f5fa6 34%, rgba(18, 98, 170, .82) 46%, rgba(20, 98, 170, .25) 66%, rgba(20, 98, 170, .08) 100%),
    radial-gradient(60% 80% at 85% 50%, rgba(46, 140, 220, .45), transparent 70%);
}
.pi-home .pi-slide-content {
  position: relative; z-index: 2; width: min(520px, 52%);
  margin-left: auto; margin-right: clamp(28px, 5vw, 64px);
  color: #fff; display: grid; gap: 22px;
}
.pi-home .pi-slide-eyebrow {
  display: inline-flex; align-items: center; gap: 8px; width: fit-content;
  font-family: var(--pi-f-display); font-weight: 700; font-size: var(--pi-fs-xs); letter-spacing: .04em;
  padding: 5px 14px; border-radius: 999px; background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.25);
  color: var(--pi-c-gold-soft);
}
.pi-home .pi-slide-eyebrow::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: var(--pi-c-orange); box-shadow: 0 0 0 4px rgba(244,163,64,.25); }
.pi-home .pi-slide h1, .pi-home .pi-slide h2 { font-size: var(--pi-fs-hero); font-weight: 800; line-height: 1.35; color: #fff; }
.pi-home .pi-slide--long h1, .pi-home .pi-slide--long h2 { font-size: clamp(1.5rem, 1rem + 1.9vw, 2.35rem); }
.pi-home .pi-slide p { color: rgba(255,255,255,.86); font-size: var(--pi-fs-md); max-width: 44ch; }
.pi-home .pi-slide-actions { display: flex; flex-wrap: wrap; gap: 12px; }
/* حركة دخول النص */
.pi-home .pi-slide .pi-anim { opacity: 0; transform: translateY(18px); transition: opacity .7s var(--pi-ease), transform .7s var(--pi-ease); }
.pi-home .pi-slide.is-active .pi-anim { opacity: 1; transform: none; }
.pi-home .pi-slide.is-active .pi-anim:nth-child(2) { transition-delay: .12s; }
.pi-home .pi-slide.is-active .pi-anim:nth-child(3) { transition-delay: .24s; }
.pi-home .pi-slide.is-active .pi-anim:nth-child(4) { transition-delay: .36s; }
.pi-home .pi-slide.is-first .pi-anim { opacity: 1; transform: none; transition: none; }

.pi-home .pi-slider-ui {
  position: absolute; z-index: 5; bottom: 18px; left: 22px; direction: rtl;
  display: flex; align-items: center; gap: 14px;
}
.pi-home .pi-slider.is-single .pi-slider-ui, .pi-home .pi-slider.is-single .pi-slider-progress { display: none; }
.pi-home .pi-slider-dots { display: flex; gap: 8px; }
.pi-home .pi-slider-dots button {
  width: 10px; height: 10px; border-radius: 999px; border: 0; padding: 0; background: rgba(255,255,255,.45);
  transition: width .35s var(--pi-ease), background-color .3s;
}
.pi-home .pi-slider-dots button.is-active { width: 32px; background: var(--pi-c-orange); }
.pi-home .pi-slider-arrow {
  width: 40px; height: 40px; border-radius: 50%; border: 1px solid rgba(255,255,255,.4); padding: 0;
  background: rgba(255,255,255,.12); color: #fff; display: grid; place-items: center;
  backdrop-filter: blur(6px); transition: background-color .25s, transform .25s;
}
.pi-home .pi-slider-arrow:hover { background: rgba(255,255,255,.28); transform: scale(1.06); }
.pi-home .pi-slider-arrow svg { width: 18px; height: 18px; }
.pi-home .pi-slider-progress { position: absolute; bottom: 0; right: 0; height: 3px; width: 0; background: var(--pi-c-orange); z-index: 6; }
.pi-home .pi-slider.is-paused .pi-slider-progress { opacity: .4; }

/* =========================================================
   4) الاعتمادات (مجالات التدريب)
   ========================================================= */
.pi-home.pi-acc-section { padding-top: clamp(36px, 5vw, 60px); padding-bottom: clamp(70px, 8vw, 110px); }
.pi-home .pi-acc-grid { --gap: clamp(12px, 2vw, 22px); display: flex; flex-wrap: wrap; justify-content: center; gap: 34px var(--gap); }
.pi-home .pi-acc-card {
  position: relative; display: flex; flex-direction: column; align-items: stretch;
  flex: 0 1 calc((100% - 4 * var(--gap)) / 5); min-width: 170px;
  background: var(--pi-c-blue); border-radius: 20px 20px 16px 16px; color: #fff;
  padding: 18px 10px 0; min-height: 210px;
  box-shadow: 0 12px 26px rgba(0, 107, 163, .22);
  transition: transform .35s var(--pi-ease), box-shadow .35s var(--pi-ease), background-color .35s;
}
.pi-home .pi-acc-card::before { /* إطار داخلي خفيف */
  content: ""; position: absolute; inset: 0; border-radius: inherit;
  background: linear-gradient(160deg, rgba(255,255,255,.14), transparent 45%); pointer-events: none;
}
.pi-home .pi-acc-icon { flex: 1; display: grid; place-items: center; padding: 8px 10px 18px; }
.pi-home .pi-acc-icon img { max-height: 104px; width: auto; max-width: 80%; border-radius: 18px; transition: transform .45s var(--pi-ease); }
.pi-home .pi-acc-label {
  margin-inline: 4px; margin-bottom: -12px; position: relative; z-index: 1;
  background: var(--pi-c-orange); color: #fff; text-align: center; border-radius: 10px;
  font-family: var(--pi-f-display); font-weight: 700; font-size: var(--pi-fs-xs); line-height: 1.35;
  padding: 9px 8px; box-shadow: 0 8px 16px rgba(229, 140, 34, .3);
}
.pi-home .pi-acc-card:hover { color: #fff; transform: translateY(-8px); background: var(--pi-c-blue-600); box-shadow: 0 20px 36px rgba(0, 107, 163, .3); }
.pi-home .pi-acc-card:hover .pi-acc-icon img { transform: scale(1.08) rotate(-2deg); }

/* =========================================================
   5) خطة البرامج التدريبية
   ========================================================= */
.pi-home.pi-plan { background: var(--pi-c-blue); position: relative; overflow: hidden; }
.pi-home.pi-plan::before { /* نمط شبكي خفيف */
  content: ""; position: absolute; opacity: .08; pointer-events: none;
  background-image: radial-gradient(#fff 1px, transparent 1.2px); background-size: 22px 22px;
}
.pi-home.pi-plan .pi-container { position: relative; }
.pi-home .pi-plan-banner {
  position: relative; border: 4px solid #fff; border-radius: var(--pi-r-md); overflow: hidden;
  background: linear-gradient(180deg, #e6f2fb 0%, #d4e8f8 100%);
  display: grid; grid-template-columns: 1.05fr 2.6fr .9fr; align-items: stretch; min-height: 300px;
  box-shadow: var(--pi-shadow-lg);
}
.pi-home .pi-pb-img { position: relative; overflow: hidden; }
.pi-home .pi-pb-img img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
.pi-home .pi-pb-img::after { content: ""; position: absolute; inset: 0; }
.pi-home .pi-pb-img--man img { object-position: left center; }
.pi-home .pi-pb-img--screen img { object-position: right center; }
/* تذويب حافة الصورة باتجاه منتصف البطاقة */
.pi-home .pi-pb-img--man::after { background: linear-gradient(90deg, rgba(222,237,249,1) 0%, rgba(222,237,249,0) 40%); }
.pi-home .pi-pb-img--screen::after { background: linear-gradient(270deg, rgba(222,237,249,1) 0%, rgba(222,237,249,0) 45%); }
body:not(.rtl) .pi-home .pi-pb-img--man::after { background: linear-gradient(270deg, rgba(222,237,249,1) 0%, rgba(222,237,249,0) 40%); }
body:not(.rtl) .pi-home .pi-pb-img--screen::after { background: linear-gradient(90deg, rgba(222,237,249,1) 0%, rgba(222,237,249,0) 45%); }
.pi-home .pi-pb-body { padding: 30px 12px 26px; display: flex; flex-direction: column; justify-content: center; gap: 28px; }
.pi-home .pi-steps { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 6px; position: relative; }
.pi-home .pi-step { display: grid; justify-items: center; align-content: start; text-align: center; gap: 10px; position: relative; }
.pi-home .pi-step:not(:last-child)::after { /* سهم بين المراحل */
  content: ""; position: absolute; top: 30px; inset-inline-end: -8px; width: 10px; height: 10px;
  border-left: 2px solid var(--pi-c-blue); border-bottom: 2px solid var(--pi-c-blue); transform: rotate(45deg);
  opacity: .6;
}
body:not(.rtl) .pi-home .pi-step:not(:last-child)::after { transform: rotate(-135deg); }
.pi-home .pi-step-ico {
  position: relative; width: 64px; height: 64px; border-radius: 50%; display: grid; place-items: center;
  background: radial-gradient(circle at 30% 30%, #2aa0e6, var(--pi-c-blue) 70%); color: #fff;
  box-shadow: 0 0 0 6px rgba(0, 107, 163, .12), 0 10px 20px rgba(0, 107, 163, .3);
  transition: transform .4s var(--pi-ease);
}
.pi-home .pi-step-ico svg { width: 30px; height: 30px; }
.pi-home .pi-step-num {
  position: absolute; bottom: -8px; left: 50%; translate: -50% 0; width: 22px; height: 22px; border-radius: 50%;
  background: var(--pi-c-blue-800); color: #fff; border: 2px solid #fff; font-size: 11px; font-weight: 700; line-height: 1;
  display: grid; place-items: center; font-family: var(--pi-f-display); font-variant-numeric: tabular-nums;
}
.pi-home .pi-step h3 { font-size: var(--pi-fs-sm); font-weight: 700; color: var(--pi-c-navy); line-height: 1.45; }
.pi-home .pi-step:hover .pi-step-ico { transform: translateY(-6px) scale(1.05); }
.pi-home .pi-pb-actions { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; }

/* بطاقات البرامج تحت البانر */
.pi-home .pi-tracks { margin-top: clamp(28px, 4vw, 44px); scroll-margin-top: calc(var(--pi-header-h) + 12px); }
.pi-home .pi-tracks-filter { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-bottom: 26px; }
.pi-home .pi-filter-btn {
  border: 1px solid rgba(255,255,255,.28); background: rgba(255,255,255,.1); color: #fff;
  font-family: var(--pi-f-display); font-weight: 700; font-size: var(--pi-fs-xs); line-height: 1.6;
  padding: 6px 16px; border-radius: 999px; transition: background-color .25s, color .25s, border-color .25s;
}
.pi-home .pi-filter-btn:hover { background: rgba(255,255,255,.22); }
.pi-home .pi-filter-btn.is-active { background: var(--pi-c-orange); border-color: var(--pi-c-orange); }
.pi-home .pi-tracks-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: clamp(14px, 2vw, 22px); }
.pi-home .pi-track-card {
  background: #fff; border: 4px solid #fff; border-radius: 18px; overflow: hidden; display: flex; flex-direction: column;
  box-shadow: 0 12px 28px rgba(0, 30, 60, .25); transition: transform .35s var(--pi-ease), box-shadow .35s;
}
.pi-home .pi-track-card:hover { transform: translateY(-8px); box-shadow: 0 22px 40px rgba(0, 30, 60, .35); }
.pi-home .pi-track-media { display: block; aspect-ratio: 16 / 9; overflow: hidden; border-radius: 14px 14px 0 0; background: var(--pi-c-bg-soft); }
.pi-home .pi-track-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .8s var(--pi-ease); }
.pi-home .pi-track-card:hover .pi-track-media img { transform: scale(1.07); }
.pi-home .pi-track-body { padding: 14px 16px 18px; display: flex; flex-direction: column; gap: 10px; flex: 1; }
.pi-home .pi-track-body h3 { color: var(--pi-c-blue); font-size: var(--pi-fs-md); line-height: 1.5; }
.pi-home .pi-track-top { position: relative; }
.pi-home .pi-track-price {
  position: absolute; inset-inline-start: 10px; bottom: 10px; padding: 4px 12px; border-radius: 999px;
  background: var(--pi-c-orange); color: #fff; box-shadow: 0 6px 14px rgba(229, 140, 34, .4);
  font-family: var(--pi-f-display); font-weight: 700; font-size: var(--pi-fs-xs); line-height: 1.6;
}
/* تفاصيل البرنامج: خانات صغيرة بأيقونة وعنوان وقيمة */
.pi-home .pi-track-meta { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
.pi-home .pi-meta-item {
  display: flex; align-items: flex-start; gap: 8px; min-width: 0; padding: 8px 10px; border-radius: 10px;
  background: var(--pi-c-bg); color: var(--pi-c-petrol); font-size: 12.5px; line-height: 1.5;
}
.pi-home .pi-meta-item:last-child:nth-child(odd) { grid-column: 1 / -1; }
.pi-home .pi-meta-item svg { width: 16px; height: 16px; flex: none; margin-top: 2px; color: var(--pi-c-blue); }
.pi-home .pi-meta-item > span { display: grid; min-width: 0; }
.pi-home .pi-meta-item small { font-size: 11px; color: var(--pi-c-muted); }
.pi-home .pi-meta-item b { font-weight: 600; overflow-wrap: anywhere; }
.pi-home .pi-track-body .pi-btn { width: 100%; margin-top: auto; }
.pi-home .pi-tracks-empty { text-align: center; color: var(--pi-c-gold-soft); }

/* =========================================================
   6) حلول المنظمات
   ========================================================= */
.pi-home .pi-org-card {
  max-width: 1000px; margin-inline: auto; background: var(--pi-c-petrol); color: #fff;
  border-radius: var(--pi-r-lg); padding: clamp(26px, 4vw, 44px);
  display: grid; grid-template-columns: 1.1fr 1fr; gap: clamp(24px, 4vw, 44px); align-items: center;
  box-shadow: var(--pi-shadow-lg); position: relative; overflow: hidden;
}
.pi-home .pi-org-card::after {
  content: ""; position: absolute; width: 420px; height: 420px; border-radius: 50%;
  left: -160px; top: -200px; background: radial-gradient(circle, rgba(255,255,255,.07), transparent 65%); pointer-events: none;
}
.pi-home .pi-org-text { display: grid; gap: 16px; align-content: start; position: relative; z-index: 1; }
.pi-home .pi-chip {
  width: fit-content; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.16);
  padding: 6px 18px; border-radius: 8px; font-family: var(--pi-f-display); font-weight: 700; font-size: var(--pi-fs-sm);
}
.pi-home .pi-org-text h2 { font-size: var(--pi-fs-2xl); letter-spacing: .01em; }
.pi-home .pi-org-text p { color: var(--pi-c-orange); font-weight: 600; font-size: var(--pi-fs-md); max-width: 46ch; }
.pi-home .pi-org-text .pi-btn { width: fit-content; }
.pi-home .pi-org-features { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; position: relative; z-index: 1; }
.pi-home .pi-org-feature {
  background: linear-gradient(180deg, #3a5a6e 0%, #2b4657 100%); border: 1px solid rgba(255,255,255,.08);
  border-radius: 14px; padding: 16px 12px 20px; display: grid; gap: 12px; align-content: start; text-align: center;
  box-shadow: 0 10px 20px rgba(0,0,0,.18); transition: transform .35s var(--pi-ease), border-color .35s;
}
.pi-home .pi-org-feature:hover { transform: translateY(-6px); border-color: rgba(244,163,64,.6); }
.pi-home .pi-org-feature .pi-tag {
  background: var(--pi-c-orange); color: #fff; border-radius: 6px; padding: 4px 6px;
  font-family: var(--pi-f-display); font-weight: 700; font-size: var(--pi-fs-xs);
}
.pi-home .pi-org-feature svg { width: 30px; height: 30px; margin-inline: auto; color: var(--pi-c-gold-soft); }
.pi-home .pi-org-feature p { font-size: var(--pi-fs-xs); line-height: 1.6; color: rgba(255,255,255,.9); }

/* =========================================================
   7) خدمات تطوير المحتوى
   ========================================================= */
.pi-home.pi-content-dev { padding-top: 0; }
.pi-home .pi-cd-card {
  max-width: 1000px; margin-inline: auto; border-radius: var(--pi-r-lg); overflow: hidden;
  display: grid; grid-template-columns: 1fr 1fr; background: var(--pi-c-blue); color: #fff; box-shadow: var(--pi-shadow-lg);
}
.pi-home .pi-cd-text { padding: clamp(28px, 4.5vw, 52px); display: grid; gap: 18px; align-content: center; }
.pi-home .pi-cd-text h2 { font-size: var(--pi-fs-2xl); }
.pi-home .pi-cd-text p { color: var(--pi-c-gold-soft); font-weight: 600; max-width: 46ch; }
.pi-home .pi-cd-points { display: flex; flex-wrap: wrap; gap: 8px; }
.pi-home .pi-cd-points li {
  font-size: var(--pi-fs-xs); font-weight: 600; padding: 4px 12px; border-radius: 999px;
  background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2);
}
.pi-home .pi-cd-actions { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; }
.pi-home .pi-cd-actions .pi-btn--ghost { --bg: transparent; --fg: #fff; --bd: rgba(255,255,255,.65); }
.pi-home .pi-cd-actions .pi-btn--ghost:hover { --bg: rgba(255,255,255,.14); --bd: #fff; }
.pi-home .pi-cd-media { position: relative; min-height: 300px; overflow: hidden; background: #0b1520; }
.pi-home .pi-cd-media img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 1.2s var(--pi-ease); }
.pi-home .pi-cd-card:hover .pi-cd-media img { transform: scale(1.05); }
.pi-home .pi-cd-media::after { content: ""; position: absolute; inset: 0; background: linear-gradient(270deg, rgba(0,107,163,.35), transparent 30%); }
body:not(.rtl) .pi-home .pi-cd-media::after { background: linear-gradient(90deg, rgba(0,107,163,.35), transparent 30%); }

/* =========================================================
   8) طلب برنامج خاص
   ========================================================= */
.pi-home.pi-cta-strip { padding-block: 0 clamp(56px, 7vw, 90px); }
.pi-home .pi-cta-box {
  max-width: 1000px; margin-inline: auto; background: #fff; border-radius: var(--pi-r-md);
  padding: clamp(22px, 3.5vw, 36px) clamp(22px, 4vw, 48px);
  display: flex; align-items: center; justify-content: space-between; gap: 20px 32px; flex-wrap: wrap;
  box-shadow: var(--pi-shadow-sm); border: 1px solid var(--pi-c-line); position: relative; overflow: hidden;
}
.pi-home .pi-cta-box::before { content: ""; position: absolute; inset-inline-start: 0; top: 0; bottom: 0; width: 5px; background: linear-gradient(var(--pi-c-blue), var(--pi-c-orange)); }
.pi-home .pi-cta-box h2 { font-size: var(--pi-fs-xl); color: var(--pi-c-blue); }
.pi-home .pi-cta-box p { color: var(--pi-c-muted); font-size: var(--pi-fs-sm); margin-top: 4px; }
.pi-home .pi-cta-actions { display: flex; flex-wrap: wrap; gap: 12px; }

/* =========================================================
   9) الشركاء والعملاء
   ========================================================= */
.pi-home.pi-logos-section { padding-block: 0 clamp(48px, 6vw, 72px); }
.pi-home .pi-logos-head { display: flex; justify-content: center; }
.pi-home .pi-logos-head h2 { font-weight: 700; }
.pi-home .pi-logos-panel { background: var(--pi-c-bg-soft); border-radius: var(--pi-r-lg); padding: clamp(22px, 3vw, 34px) clamp(16px, 3vw, 34px) 18px; }
.pi-home .pi-logos-panel--gray { background: var(--pi-c-bg-gray); }
.pi-home .pi-carousel { overflow: hidden; }
.pi-home .pi-carousel-track { display: flex; transition: transform .7s var(--pi-ease); }
.pi-home .pi-carousel-item { flex: 0 0 calc(100% / var(--per, 5)); padding-inline: 8px; }
.pi-home .pi-logo-card {
  height: 92px; background: #fff; border-radius: 12px; display: grid; place-items: center; padding: 10px 14px;
  box-shadow: var(--pi-shadow-sm); transition: transform .3s var(--pi-ease), box-shadow .3s;
}
.pi-home .pi-logo-card img { max-height: 70px; width: auto; max-width: 100%; object-fit: contain; filter: grayscale(.15); transition: filter .3s; }
.pi-home .pi-logo-card:hover { transform: translateY(-4px); box-shadow: var(--pi-shadow-md); }
.pi-home .pi-logo-card:hover img { filter: none; }
.pi-home .pi-carousel-dots { display: flex; justify-content: center; gap: 6px; margin-top: 16px; }
.pi-home .pi-carousel-dots button { width: 9px; height: 9px; padding: 0; border-radius: 50%; border: 1.5px solid var(--pi-c-blue); background: transparent; transition: background-color .25s, transform .25s; }
.pi-home .pi-carousel-dots button.is-active { background: var(--pi-c-blue); transform: scale(1.15); }
.pi-home .pi-logos-panel--gray .pi-carousel-dots button { border-color: var(--pi-c-orange); }
.pi-home .pi-logos-panel--gray .pi-carousel-dots button.is-active { background: var(--pi-c-orange); }

/* =========================================================
   10) الفعاليات
   ========================================================= */
.pi-home.pi-events { background: var(--pi-c-blue); }
.pi-home.pi-events .pi-sec-head h2 { color: #fff; }
.pi-home .pi-events-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: clamp(14px, 2vw, 22px); }
.pi-home .pi-event-card {
  background: #fff; border-radius: 18px; overflow: hidden; display: flex; flex-direction: column;
  box-shadow: 0 12px 28px rgba(0, 30, 60, .25); transition: transform .35s var(--pi-ease), box-shadow .35s;
  border: 4px solid #fff;
}
.pi-home .pi-event-card:hover { transform: translateY(-8px); box-shadow: 0 22px 40px rgba(0, 30, 60, .35); }
.pi-home .pi-event-media { position: relative; aspect-ratio: 16 / 7; overflow: hidden; border-radius: 14px 14px 0 0; max-width: 100%; background: var(--pi-c-bg-soft); }
.pi-home .pi-event-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .8s var(--pi-ease); }
.pi-home .pi-event-card:hover .pi-event-media img { transform: scale(1.07); }
.pi-home .pi-event-date {
  position: absolute; top: 10px; inset-inline-start: 10px; background: #fff; color: var(--pi-c-blue); border-radius: 10px;
  padding: 4px 10px; text-align: center; font-family: var(--pi-f-display); line-height: 1.15; box-shadow: var(--pi-shadow-sm);
}
.pi-home .pi-event-date b { display: block; font-size: 1.25rem; font-variant-numeric: tabular-nums; }
.pi-home .pi-event-date span { font-size: 11px; font-weight: 700; }
.pi-home .pi-event-status {
  position: absolute; top: 10px; inset-inline-end: 10px; border-radius: 999px; padding: 3px 12px;
  font-family: var(--pi-f-display); font-weight: 700; font-size: 12px; line-height: 1.6; color: #fff; background: var(--pi-c-petrol);
}
.pi-home .pi-event-status--upcoming { background: var(--pi-c-orange-600); }
.pi-home .pi-event-status--current { background: #1f8a4c; }
.pi-home .pi-event-body { padding: 14px 16px 18px; display: flex; flex-direction: column; gap: 10px; flex: 1; }
.pi-home .pi-event-body h3 {
  color: var(--pi-c-blue); font-size: var(--pi-fs-md); font-weight: 800; line-height: 1.5;
  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.pi-home .pi-event-body p {
  color: var(--pi-c-muted); font-size: var(--pi-fs-xs); line-height: 1.7;
  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.pi-home .pi-event-meta { display: flex; flex-wrap: wrap; gap: 6px; font-size: 12px; color: var(--pi-c-petrol); font-weight: 600; }
.pi-home .pi-event-meta:empty { display: none; }
.pi-home .pi-event-meta span { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 999px; background: var(--pi-c-bg); line-height: 1.6; }
.pi-home .pi-event-meta svg { width: 14px; height: 14px; color: var(--pi-c-orange); flex: none; }
.pi-home .pi-event-body .pi-btn { width: fit-content; margin-top: auto; align-self: flex-end; }
.pi-home .pi-events-more { display: flex; justify-content: center; margin-top: 30px; }

/* =========================================================
   الحركة عند التمرير
   (العناصر تظهر طبيعيًا؛ لا تُخفى إلا إن كانت أسفل الشاشة لحظة التحميل)
   ========================================================= */
.pi-home .pi-reveal-pending { opacity: 0; }
/* fill-mode: backwards — العنصر مخفي أثناء التأخير، وبعد انتهاء الحركة يعود لتنسيقه الطبيعي فتعمل حركات hover كما هي */
.pi-home .pi-reveal-in { animation: pi-kf-up .85s var(--pi-ease) var(--d, 0s) backwards; }
.pi-home .pi-reveal-in.pi-reveal--zoom { animation-name: pi-kf-zoom; }
/* start/end: جهة بداية ونهاية السطر (تنعكس تلقائيًا بين العربية والإنجليزية) */
.pi-home .pi-reveal-in.pi-reveal--start { animation-name: pi-kf-from-right; }
.pi-home .pi-reveal-in.pi-reveal--end { animation-name: pi-kf-from-left; }
body:not(.rtl) .pi-home .pi-reveal-in.pi-reveal--start { animation-name: pi-kf-from-left; }
body:not(.rtl) .pi-home .pi-reveal-in.pi-reveal--end { animation-name: pi-kf-from-right; }

@keyframes pi-kf-up { from { opacity: 0; transform: translateY(36px); } }
@keyframes pi-kf-zoom { from { opacity: 0; transform: scale(.88); } }
@keyframes pi-kf-from-right { from { opacity: 0; transform: translateX(56px); } }
@keyframes pi-kf-from-left { from { opacity: 0; transform: translateX(-56px); } }
@keyframes pi-kf-pop { 0% { opacity: 0; transform: scale(.5); } 70% { opacity: 1; transform: scale(1.08); } }
@keyframes pi-kf-grow { from { transform: scaleX(0); } }
@keyframes pi-kf-kenburns { from { transform: scale(1.16); } }
@keyframes pi-kf-float { 50% { transform: translateY(-7px); } }
@keyframes pi-kf-ring { 0% { transform: scale(1); opacity: .6; } 70%, 100% { transform: scale(1.6); opacity: 0; } }
@keyframes pi-kf-drift { to { transform: translate(22px, 22px); } }
@keyframes pi-kf-glow { to { transform: translate(90px, 60px); } }
@keyframes pi-kf-wiggle { 30% { transform: rotate(-12deg) scale(1.15); } 60% { transform: rotate(8deg) scale(1.1); } }

/* ---------- عناوين الأقسام: خط برتقالي يتمدد تحت العنوان ---------- */
.pi-home .pi-sec-head h2::after {
  content: ""; display: block; width: 64px; height: 4px; border-radius: 4px; margin: 12px auto 0;
  background: linear-gradient(90deg, var(--pi-c-orange), var(--pi-c-gold-soft));
}
.pi-home .pi-sec-head.pi-reveal-in h2::after { animation: pi-kf-grow .7s var(--pi-ease) .35s backwards; }

/* ---------- الاعتمادات ---------- */
.pi-home .pi-acc-icon { animation: pi-kf-float 5s ease-in-out infinite; }
.pi-home .pi-acc-card:nth-child(even) .pi-acc-icon { animation-delay: -2.5s; }

/* ---------- خطة البرامج: الخلفية المنقطة تنساب، والمراحل تظهر بالتتابع مع نبضة حول كل أيقونة ---------- */
.pi-home.pi-plan::before { inset: -22px; animation: pi-kf-drift 7s linear infinite; }
.pi-home .pi-plan-banner.pi-reveal-in .pi-pb-img img { animation: pi-kf-kenburns 1.6s var(--pi-ease) backwards; }
.pi-home .pi-plan-banner.pi-reveal-in .pi-step { animation: pi-kf-pop .7s var(--pi-ease) backwards; }
.pi-home .pi-plan-banner.pi-reveal-in .pi-step:nth-child(1) { animation-delay: .3s; }
.pi-home .pi-plan-banner.pi-reveal-in .pi-step:nth-child(2) { animation-delay: .5s; }
.pi-home .pi-plan-banner.pi-reveal-in .pi-step:nth-child(3) { animation-delay: .7s; }
.pi-home .pi-plan-banner.pi-reveal-in .pi-step:nth-child(4) { animation-delay: .9s; }
.pi-home .pi-plan-banner.pi-reveal-in .pi-pb-actions { animation: pi-kf-up .7s var(--pi-ease) 1.1s backwards; }
.pi-home .pi-step-ico::before {
  content: ""; position: absolute; inset: 0; border-radius: 50%; border: 2px solid var(--pi-c-sky); pointer-events: none;
  animation: pi-kf-ring 3.2s ease-out infinite;
}
.pi-home .pi-step:nth-child(2) .pi-step-ico::before { animation-delay: .8s; }
.pi-home .pi-step:nth-child(3) .pi-step-ico::before { animation-delay: 1.6s; }
.pi-home .pi-step:nth-child(4) .pi-step-ico::before { animation-delay: 2.4s; }

/* ---------- حلول المنظمات وتطوير المحتوى ---------- */
.pi-home .pi-org-card::after { animation: pi-kf-glow 12s ease-in-out infinite alternate; }
.pi-home .pi-org-card.pi-reveal-in .pi-org-text > * { animation: pi-kf-up .7s var(--pi-ease) backwards; }
.pi-home .pi-org-card.pi-reveal-in .pi-org-text > :nth-child(1) { animation-delay: .25s; }
.pi-home .pi-org-card.pi-reveal-in .pi-org-text > :nth-child(2) { animation-delay: .38s; }
.pi-home .pi-org-card.pi-reveal-in .pi-org-text > :nth-child(3) { animation-delay: .51s; }
.pi-home .pi-org-card.pi-reveal-in .pi-org-text > :nth-child(4) { animation-delay: .64s; }
.pi-home .pi-cd-card.pi-reveal-in .pi-cd-media img { animation: pi-kf-kenburns 1.8s var(--pi-ease) backwards; }
.pi-home .pi-cd-card.pi-reveal-in .pi-cd-text > * { animation: pi-kf-up .7s var(--pi-ease) backwards; }
.pi-home .pi-cd-card.pi-reveal-in .pi-cd-text > :nth-child(1) { animation-delay: .3s; }
.pi-home .pi-cd-card.pi-reveal-in .pi-cd-text > :nth-child(2) { animation-delay: .43s; }
.pi-home .pi-cd-card.pi-reveal-in .pi-cd-text > :nth-child(3) { animation-delay: .56s; }
.pi-home .pi-cd-card.pi-reveal-in .pi-cd-text > :nth-child(4) { animation-delay: .69s; }

/* صورة تعذّر تحميلها: نخفي أيقونة «الصورة المكسورة» وتبقى خلفية الحاوية */
.pi-home img.pi-img-failed { visibility: hidden; }

/* =========================================================
   أقسام المنصة الاختيارية (دورات مميزة، باقات، اشتراكات…)
   تبقى بتنسيق app.css مع مسافات وعناوين موحّدة
   ========================================================= */
section.home-sections, div.home-sections { margin-top: 0 !important; padding-block: clamp(40px, 5vw, 64px); }
.home-sections .section-title { font-family: var(--pi-f-display) !important; font-size: var(--pi-fs-xl); font-weight: 800; color: var(--pi-c-navy); }
.home-sections .section-hint { font-family: var(--pi-f-body) !important; color: var(--pi-c-muted); }
.home-sections-swiper .swiper-wrapper { align-items: stretch !important; }
.home-sections-swiper .swiper-slide { height: auto !important; display: flex !important; flex-direction: column; }
.home-sections-swiper .swiper-slide > a,
.home-sections-swiper .swiper-slide > div { flex: 1; display: flex; flex-direction: column; height: 100%; }
.home-sections-swiper .swiper-slide .webinar-card,
.home-sections-swiper .swiper-slide .subscribe-plan { height: 100%; display: flex; flex-direction: column; }

/* =========================================================
   التجاوب
   ========================================================= */
@media (max-width: 960px) {
  .pi-home .pi-acc-card { flex-basis: calc((100% - 2 * var(--gap)) / 3); }
  .pi-home .pi-plan-banner { grid-template-columns: 1fr; }
  .pi-home .pi-pb-img--screen { display: none; }
  .pi-home .pi-pb-img--man { height: 220px; }
  .pi-home .pi-pb-img--man img { object-position: center 30%; }
  .pi-home .pi-pb-img--man::after,
  body:not(.rtl) .pi-home .pi-pb-img--man::after { background: linear-gradient(0deg, rgba(222,237,249,1) 0%, rgba(222,237,249,0) 45%); }
  .pi-home .pi-org-card { grid-template-columns: 1fr; }
  .pi-home .pi-events-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 760px) {
  .pi-home .pi-slide { min-height: 520px; padding-block: 210px 0; align-items: flex-end; }
  .pi-home .pi-slide-media img { width: 100%; height: 78%; object-position: center top; transform-origin: center top; }
  .pi-home .pi-slide-media::after { background: linear-gradient(0deg, #0d5aa0 0%, #0f5fa6 42%, rgba(18,98,170,.55) 60%, rgba(18,98,170,.05) 85%); }
  .pi-home .pi-slide-content { width: auto; margin: 0; padding: 0 22px 78px; gap: 14px; }
  .pi-home .pi-slider-ui { left: auto; inset-inline-start: 22px; bottom: 20px; }
  .pi-home .pi-steps { grid-template-columns: repeat(2, minmax(0, 1fr)); row-gap: 26px; }
  .pi-home .pi-step:nth-child(2)::after { display: none; }
  .pi-home .pi-cd-card { grid-template-columns: 1fr; }
  .pi-home .pi-cd-media { min-height: 220px; order: -1; }
  .pi-home .pi-cta-box { flex-direction: column; align-items: flex-start; }
  .pi-home .pi-carousel-item { flex-basis: calc(100% / var(--per-m, 2)); }
  .pi-home .pi-events-grid { grid-template-columns: 1fr; }
}
@media (max-width: 520px) {
  .pi-home .pi-acc-card { flex-basis: calc((100% - var(--gap)) / 2); min-width: 0; min-height: 180px; }
  .pi-home .pi-org-features { grid-template-columns: 1fr; }
  /* صف: أيقونة في مربع ثم العنوان والوصف بجانبها */
  .pi-home .pi-org-feature { grid-template-columns: 48px 1fr; column-gap: 12px; row-gap: 4px; padding: 14px; text-align: start; align-items: center; }
  .pi-home .pi-org-feature .pi-tag { grid-column: 2; grid-row: 1; width: fit-content; }
  .pi-home .pi-org-feature svg { grid-column: 1; grid-row: 1 / span 2; width: 48px; height: 48px; padding: 11px; margin: 0; border-radius: 12px; background: rgba(255, 255, 255, .08); }
  .pi-home .pi-org-feature p { grid-column: 2; grid-row: 2; }
  .pi-home .pi-slide-actions .pi-btn { flex: 1; }
}

/* ---------- الجوال: بطاقات البرامج والفعاليات شريط أفقي يُسحب بالإصبع بدل قائمة طويلة ---------- */
@media (max-width: 760px) {
  .pi-home .pi-tracks-grid, .pi-home .pi-events-grid {
    display: flex; gap: 14px; overflow-x: auto; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;
    margin-inline: -20px; padding: 8px 20px 30px; margin-bottom: -12px; scroll-padding-inline: 20px; scrollbar-width: none;
  }
  .pi-home .pi-tracks-grid::-webkit-scrollbar, .pi-home .pi-events-grid::-webkit-scrollbar { display: none; }
  .pi-home .pi-track-card, .pi-home .pi-event-card { flex: 0 0 84%; max-width: 340px; scroll-snap-align: start; }
  .pi-home .pi-track-card:only-child, .pi-home .pi-event-card:only-child { flex-basis: 100%; max-width: none; }
  .pi-home .pi-track-card:hover, .pi-home .pi-event-card:hover { transform: none; }
  .pi-home .pi-event-body .pi-btn { width: 100%; }
  .pi-home .pi-tracks-filter { flex-wrap: nowrap; justify-content: flex-start; overflow-x: auto; margin-inline: -20px; padding-inline: 20px; scrollbar-width: none; }
  .pi-home .pi-tracks-filter::-webkit-scrollbar { display: none; }
  .pi-home .pi-filter-btn { flex: none; }
  .pi-home .pi-cta-actions { width: 100%; }
  .pi-home .pi-cta-actions .pi-btn { flex: 1; }
  .pi-home .pi-pb-actions .pi-btn { flex: 1; }
  .pi-home .pi-logo-card { height: 84px; }
}

@media (prefers-reduced-motion: reduce) {
  .pi-home *, .pi-home *::before, .pi-home *::after, .pi-to-top {
    animation: none !important; transition-duration: .01ms !important; transition-delay: 0s !important;
  }
  .pi-home .pi-reveal-pending { opacity: 1; }
}
</style>
