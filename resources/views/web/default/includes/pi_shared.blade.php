{{-- هوية «التفاعل الإيجابي» المشتركة بين الهيدر والفوتر: الخطوط، الألوان، الأزرار، الأيقونات (تُحمَّل مرة واحدة) --}}
@once
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&family=Tajawal:wght@500;700;800&display=swap">

    <style>
        /* كل الأصناف تبدأ بـ pi- حتى لا تتعارض مع app.css (Bootstrap) */
        :root {
            --pi-c-bg: #eef6f9;
            --pi-c-blue: #006ba3;
            --pi-c-blue-600: #005a8a;
            --pi-c-blue-800: #0b4f86;
            --pi-c-sky: #1a8fd0;
            --pi-c-petrol: #2d4a5c;
            --pi-c-navy: #0c2b4a;
            --pi-c-navy-900: #09233e;
            --pi-c-orange: #f4a340;
            --pi-c-orange-600: #e58c22;
            --pi-c-line: #d4e4ec;

            --pi-f-display: "Tajawal", "IBM Plex Sans Arabic", "Segoe UI", Tahoma, sans-serif;
            --pi-f-body: "IBM Plex Sans Arabic", "Tajawal", "Segoe UI", Tahoma, sans-serif;

            --pi-fs-xs: .8125rem;
            --pi-fs-sm: .9375rem;

            --pi-r-md: 14px;
            --pi-shadow-md: 0 10px 30px rgba(12, 43, 74, .10);
            --pi-shadow-lg: 0 20px 50px rgba(12, 43, 74, .18);
            --pi-ease: cubic-bezier(.22, .8, .24, 1);
            --pi-container: 1200px;
            --pi-header-h: 78px;
        }

        .pi-container { width: 100%; max-width: var(--pi-container); margin-inline: auto; padding-inline: 20px; }
        .pi-container--fluid { max-width: none; }

        /* ---------- الأزرار ---------- */
        .pi-btn {
            --bg: var(--pi-c-orange); --fg: #fff; --bd: transparent;
            display: inline-flex; align-items: center; justify-content: center; gap: .5em;
            min-height: 46px; padding: .55em 1.5em;
            background: var(--bg); color: var(--fg); border: 1.5px solid var(--bd);
            border-radius: 10px; font-family: var(--pi-f-display); font-weight: 700; font-size: var(--pi-fs-sm); line-height: 1.75;
            letter-spacing: .01em; white-space: nowrap; text-decoration: none; cursor: pointer;
            transition: transform .25s var(--pi-ease), box-shadow .25s var(--pi-ease), background-color .25s, color .25s;
            position: relative; overflow: hidden; isolation: isolate;
        }
        .pi-btn::after { /* لمعة عند المرور */
            content: ""; position: absolute; inset: 0; z-index: -1;
            background: linear-gradient(110deg, transparent 30%, rgba(255, 255, 255, .35) 50%, transparent 70%);
            transform: translateX(120%); transition: transform .6s var(--pi-ease);
        }
        .pi-btn:hover { color: var(--fg); text-decoration: none; transform: translateY(-2px); box-shadow: 0 10px 22px rgba(12, 43, 74, .18); }
        .pi-btn:hover::after { transform: translateX(-120%); }
        .pi-btn--orange { --bg: var(--pi-c-orange); }
        .pi-btn--orange:hover { --bg: var(--pi-c-orange-600); }
        .pi-btn--blue { --bg: var(--pi-c-blue); }
        .pi-btn--blue:hover { --bg: var(--pi-c-blue-800); }
        .pi-btn--sm { min-height: 38px; padding: .35em 1.1em; font-size: var(--pi-fs-xs); border-radius: 8px; }

        .pi-header :focus-visible, .pi-drawer :focus-visible, .pi-footer :focus-visible, .pi-to-top:focus-visible {
            outline: 3px solid var(--pi-c-orange); outline-offset: 3px; border-radius: 6px;
        }

        @media (max-width: 760px) {
            :root { --pi-header-h: 66px; }
        }
        @media (prefers-reduced-motion: reduce) {
            .pi-header, .pi-header *, .pi-drawer, .pi-drawer *, .pi-drawer-backdrop, .pi-footer *, .pi-to-top, .pi-btn, .pi-btn::after {
                transition-duration: .01ms !important;
            }
        }
    </style>

    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
            <symbol id="pi-i-menu" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M4 7h16M4 12h16M10 17h10"/></symbol>
            <symbol id="pi-i-close" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></symbol>
            <symbol id="pi-i-arrow" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6"/></symbol>
            <symbol id="pi-i-down" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/></symbol>
            <symbol id="pi-i-up" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" d="M6 15l6-6 6 6"/></symbol>
            <symbol id="pi-i-x" viewBox="0 0 24 24"><path fill="currentColor" d="M17.8 3h3.1l-6.8 7.7L22 21h-6.2l-4.9-6.4L5.3 21H2.2l7.3-8.3L2 3h6.4l4.4 5.8zm-1.1 16.2h1.7L7.4 4.7H5.6z"/></symbol>
            <symbol id="pi-i-in" viewBox="0 0 24 24"><path fill="currentColor" d="M4.5 3a2 2 0 1 1 0 4 2 2 0 0 1 0-4zM3 9h3v12H3zM9 9h2.9v1.7c.5-.9 1.7-1.9 3.5-1.9 3.6 0 4.3 2.3 4.3 5.4V21h-3v-6c0-1.4 0-3.2-2-3.2s-2.3 1.5-2.3 3.1V21H9z"/></symbol>
            <symbol id="pi-i-ig" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/></g><circle cx="17.5" cy="6.5" r="1.2" fill="currentColor"/></symbol>
            <symbol id="pi-i-fb" viewBox="0 0 24 24"><path fill="currentColor" d="M13.6 21v-7.6h2.6l.4-3h-3V8.5c0-.9.3-1.5 1.6-1.5h1.6V4.3c-.3 0-1.3-.1-2.4-.1-2.3 0-3.9 1.4-3.9 4v2.2H7.9v3h2.6V21z"/></symbol>
            <symbol id="pi-i-snap" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2.6c-2.9 0-4.8 2.1-4.8 4.9v2.2c-.6.3-1.4-.3-1.9.2-.6.6.3 1.4 1.6 1.9-.5 1.5-1.7 2.7-3.4 3.3-.6.2-.5.9.1 1.2.8.4 1.7.4 2.1.7.3.3.1 1 .8 1.2.8.2 1.8-.2 2.8.4.9.5 1.5 1.4 2.7 1.4s1.8-.9 2.7-1.4c1-.6 2-.2 2.8-.4.7-.2.5-.9.8-1.2.4-.3 1.3-.3 2.1-.7.6-.3.7-1 .1-1.2-1.7-.6-2.9-1.8-3.4-3.3 1.3-.5 2.2-1.3 1.6-1.9-.5-.5-1.3.1-1.9-.2V7.5c0-2.8-1.9-4.9-4.8-4.9z"/></symbol>
        </defs>
    </svg>
@endonce
