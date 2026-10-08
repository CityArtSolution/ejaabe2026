<footer style="background:#0b2b4a; color:#fff; padding:70px 0 30px 0; font-family:inherit; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}; text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};">
    <div class="container">
        <div class="row" style="display:flex; flex-wrap:wrap; gap:40px; justify-content:space-between">

            <div style="flex:1; min-width:260px">
                <div style="display:flex; align-items:flex-start; gap:12px; margin-bottom:15px">
                    <div style="width:42px; height:42px; background:#0f3b63; border-radius:10px; display:flex; align-items:center; justify-content:center">
                        <i class="fas fa-layer-group" style="color:#9fc6e8"></i>
                    </div>
                    <h5 style="margin:0; font-weight:700">
                        {{ __('home.company_name') }}
                    </h5>
                </div>
                <p style="color:#a9bfd3; font-size:14px; line-height:1.8">
                    {{ __('home.about_desc') }} .
                </p>
            </div>

            <div style="flex:1; min-width:160px">
                <h5 style="margin-bottom:18px; font-weight:700">{{ __('home.policies') }}</h5>
                <ul style="list-style:none; padding:0; margin:0; line-height:2.2; color:#a9bfd3; font-size:14px">
                    <li><a class="text-white" href="/{{app()->getLocale()}}/pages/policy">{{ __('home.privacy_policy') }}</a></li>
                    <li><a class="text-white" href="/{{app()->getLocale()}}/pages/alaltzam-bhkok-almlky-alfkry">{{ __('home.intellectual_property') }}</a></li>
                    <li><a class="text-white" href="/{{app()->getLocale()}}/pages/support-policy">{{ __('home.tech_support') }}</a></li>
                    
                    <li><a class="text-white" href="/{{app()->getLocale()}}/pages/nazaha-policy">{{ __('Academic Integrity Policy') }}</a></li>
                    <li><a class="text-white" href="/{{app()->getLocale()}}/pages/syas-alhdor-alaftrady">{{ __('Virtual Attendance Policy') }}</a></li>
                    <li><a class="text-white" href="/{{app()->getLocale()}}/pages/elearning">{{ __('E-learning policies') }}</a></li>
                    <li><a class="text-white" href="/{{app()->getLocale()}}/pages/kht-tdryb-almdrbyn">{{ __('Train-the-Trainer Plan') }}</a></li>
                    <li><a class="text-white" href="/{{app()->getLocale()}}/pages/terms-and-conditions">{{ __('home.terms') }}</li>
                </ul>
            </div>

            <div style="flex:1; min-width:160px">
                <h5 style="margin-bottom:18px; font-weight:700">{{ __('home.site_sections') }}</h5>
                <ul style="list-style:none; padding:0; margin:0; line-height:2.2; color:#a9bfd3; font-size:14px">
                    <li><a class="text-white" href="/{{app()->getLocale()}}/classes">{{ __('home.courses') }}</a></li>
                    <li><a class="text-white" href="/{{app()->getLocale()}}/about">{{ __('home.about_us') }}</a></li>
                    <li><a class="text-white" href="/{{app()->getLocale()}}/contact">{{ __('home.contact_us') }}</a></li>
                    <li><a class="text-white" href="/become-instructor">{{ __('home.join_trainer') }}</a></li>
                    <li><a class="text-white" href="/{{app()->getLocale()}}/blog">{{ __('home.blog') }}</a></li>
                </ul>
            </div>

            <div style="flex:1; min-width:260px">
                <h5 style="margin-bottom:15px; font-weight:700">{{ __('home.join_us_today') }}</h5>
                <p style="color:#a9bfd3; font-size:14px; margin-bottom:12px">
                    {{ __('home.newsletter_desc') }}
                </p>
                <div style="background:#08233e; padding:20px; border-radius:14px">
                    <input type="email" placeholder="{{ __('home.email_placeholder') }}"
                           style="width:100%; padding:12px; border-radius:8px; border:1px solid #2e4f6f; background:transparent; color:#fff; margin-bottom:12px">
                    <button style="width:100%; background:#1f6fa6; border:none; padding:12px; border-radius:8px; color:#fff; font-weight:600">
                        {{ __('home.subscribe') }}
                    </button>
                </div>
            </div>
        </div>

        <div style="border-top:1px solid rgba(255,255,255,.15); margin:45px 0 20px 0"></div>

        <div style="display:flex; justify-content:space-between; flex-wrap:wrap; color:#9fb7cb; font-size:13px">
            <div>
                {{ __('home.rights_reserved') }}
            </div>
            <div style="display:flex; gap:25px">
                <div>info@ejaabi.com</div>
                <div style="direction: ltr;">+966-566111404</div>
            </div>
        </div>
    </div>
</footer>
