{{-- سكربت الصفحة الرئيسية: البانر المتحرك، شرائط الشعارات، الظهور عند التمرير (JavaScript خالص) --}}
<script>
(function () {
  'use strict';
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isRtl = document.body.classList.contains('rtl');
  var $ = function (s, r) { return (r || document).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };

  /* ---------- البانر الرئيسي (شرائح) ---------- */
  (function initSlider() {
    var root = $('#piHeroSlider'); if (!root) return;
    var slides = $$('.pi-slide', root);
    var dotsWrap = $('.pi-slider-dots', root);
    var progress = $('.pi-slider-progress', root);
    var toggle = $('[data-pi-toggle]', root);
    var quickLinks = $$('[data-pi-slide]');
    var DURATION = 6500, current = 0, elapsed = 0, last = 0, hoverPaused = false;
    var userPaused = reduceMotion || slides.length < 2; // لا حركة تلقائية لمن يفضّل تقليل الحركة

    var dots = slides.map(function (_, i) {
      var b = document.createElement('button');
      b.type = 'button'; b.setAttribute('role', 'tab');
      b.setAttribute('aria-label', (i + 1) + ' / ' + slides.length);
      b.addEventListener('click', function () { go(i); });
      dotsWrap.appendChild(b); return b;
    });

    function go(i) {
      slides[current].classList.remove('is-first');
      current = (i + slides.length) % slides.length;
      slides.forEach(function (s, k) {
        var on = k === current;
        s.classList.toggle('is-active', on);
        s.setAttribute('aria-hidden', String(!on));
        $$('a,button', s).forEach(function (el) { el.tabIndex = on ? 0 : -1; });
      });
      dots.forEach(function (d, k) {
        d.classList.toggle('is-active', k === current);
        d.setAttribute('aria-selected', String(k === current));
      });
      quickLinks.forEach(function (q) {
        var on = Number(q.getAttribute('data-pi-slide')) === current;
        q.classList.toggle('is-active', on);
        q.setAttribute('aria-pressed', String(on));
      });
      elapsed = 0;
    }
    function paused() { return userPaused || hoverPaused || document.hidden; }
    function updateToggle() {
      root.classList.toggle('is-paused', paused());
      toggle.setAttribute('aria-label', toggle.getAttribute(userPaused ? 'data-label-play' : 'data-label-pause'));
      toggle.querySelector('use').setAttribute('href', userPaused ? '#pi-i-play' : '#pi-i-pause');
    }
    function tick(t) {
      var dt = last ? t - last : 0; last = t;
      if (!paused()) {
        elapsed += dt;
        if (elapsed >= DURATION) go(current + 1);
      }
      progress.style.width = (userPaused ? 0 : Math.min(elapsed / DURATION, 1) * 100) + '%';
      requestAnimationFrame(tick);
    }

    $('[data-pi-dir="next"]', root).addEventListener('click', function () { go(current + 1); });
    $('[data-pi-dir="prev"]', root).addEventListener('click', function () { go(current - 1); });
    toggle.addEventListener('click', function () { userPaused = !userPaused; updateToggle(); });
    quickLinks.forEach(function (q) {
      q.addEventListener('click', function () { go(Number(q.getAttribute('data-pi-slide'))); });
    });
    // إيقاف الحركة عند التفاعل
    root.addEventListener('mouseenter', function () { hoverPaused = true; updateToggle(); });
    root.addEventListener('mouseleave', function () { hoverPaused = false; updateToggle(); });
    root.addEventListener('focusin', function () { hoverPaused = true; updateToggle(); });
    root.addEventListener('focusout', function () { hoverPaused = false; updateToggle(); });
    root.addEventListener('keydown', function (e) {
      // في RTL: اليسار = التالي
      if (e.key === 'ArrowLeft') go(current + (isRtl ? 1 : -1));
      if (e.key === 'ArrowRight') go(current + (isRtl ? -1 : 1));
    });
    // السحب باللمس
    var sx = null;
    root.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; hoverPaused = true; }, { passive: true });
    root.addEventListener('touchend', function (e) {
      if (sx !== null) {
        var dx = e.changedTouches[0].clientX - sx;
        if (Math.abs(dx) > 40) go(current + ((dx > 0) === isRtl ? 1 : -1));
      }
      sx = null; hoverPaused = false;
    });

    go(0); slides[0].classList.add('is-first');
    updateToggle();
    requestAnimationFrame(tick);
  })();

  /* ---------- شرائط الشعارات (الشركاء والعملاء) ---------- */
  $$('[data-pi-carousel]').forEach(function (car) {
    var track = $('.pi-carousel-track', car);
    var dotsWrap = car.parentNode.querySelector('.pi-carousel-dots');
    var originals = $$('.pi-carousel-item', track);
    var n = originals.length, index = 0, timer = null;
    if (!n) return;
    var dir = isRtl ? 1 : -1; // RTL: الإزاحة موجبة
    // نسخ العناصر لحلقة لا نهائية
    originals.forEach(function (it) {
      var c = it.cloneNode(true); c.setAttribute('aria-hidden', 'true');
      $$('img', c).forEach(function (img) { img.alt = ''; });
      $$('a', c).forEach(function (a) { a.tabIndex = -1; });
      track.appendChild(c);
    });
    var dots = originals.map(function (_, i) {
      var b = document.createElement('button');
      b.type = 'button'; b.setAttribute('aria-label', String(i + 1));
      b.addEventListener('click', function () { move(i); restart(); });
      dotsWrap.appendChild(b); return b;
    });
    function step() { return originals[0].getBoundingClientRect().width; }
    function render(animate) {
      track.style.transition = animate ? '' : 'none';
      track.style.transform = 'translateX(' + (dir * index * step()) + 'px)';
      dots.forEach(function (d, k) { d.classList.toggle('is-active', k === index % n); });
    }
    function move(i) { index = i; render(true); }
    track.addEventListener('transitionend', function () {
      if (index >= n) { index = index % n; render(false); }
    });
    function next() {
      if (document.hidden) return;
      // transitionend قد لا يصل (تبويب في الخلفية)؛ نعيد الفهرس قبل التقدّم حتى لا يخرج الشريط عن العناصر
      if (index >= n) { index = index % n; render(false); void track.offsetWidth; }
      move(index + 1);
    }
    function restart() {
      clearInterval(timer);
      if (!reduceMotion) timer = setInterval(next, 3200);
    }
    car.addEventListener('mouseenter', function () { clearInterval(timer); });
    car.addEventListener('mouseleave', restart);
    window.addEventListener('resize', function () { render(false); });
    render(false); restart();
  });

  /* ---------- الصور التي يتعذّر تحميلها ---------- */
  // صورة بديلة إن وُجدت (data-pi-fallback)، وإلا تُخفى حتى لا تظهر أيقونة الصورة المكسورة
  var imgFailed = function (img) {
    var fallback = img.getAttribute('data-pi-fallback');
    if (fallback) { img.removeAttribute('data-pi-fallback'); img.src = fallback; return; }
    img.classList.add('pi-img-failed');
  };
  // حدث error لا يصعد؛ نلتقطه في مرحلة capture ليشمل الصور المنسوخة في شرائط الشعارات
  document.addEventListener('error', function (e) {
    var el = e.target;
    if (el && el.tagName === 'IMG' && el.closest && el.closest('.pi-home')) imgFailed(el);
  }, true);
  $$('.pi-home img').forEach(function (img) {
    // صور فشلت قبل تشغيل السكربت (SVG قد يعطي naturalWidth = 0 وهو سليم)
    var src = img.getAttribute('src') || '';
    if (src && img.complete && img.naturalWidth === 0 && !/\.svg(\?|$)/i.test(src)) imgFailed(img);
  });

  /* ---------- الظهور عند التمرير ---------- */
  if ('IntersectionObserver' in window && !reduceMotion) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) {
          en.target.classList.remove('pi-reveal-pending');
          en.target.classList.add('pi-reveal-in');
          io.unobserve(en.target);
        }
      });
    }, { threshold: .12, rootMargin: '0px 0px -40px 0px' });
    var vh = window.innerHeight;
    $$('.pi-reveal').forEach(function (el) {
      // العناصر الظاهرة عند التحميل تبقى كما هي؛ نخفي فقط ما هو أسفل الشاشة
      if (el.getBoundingClientRect().top > vh) { el.classList.add('pi-reveal-pending'); io.observe(el); }
    });
  }
})();
</script>
