@php
    if (empty($authUser) and auth()->check()) {
        $authUser = auth()->user();
    }

    $navBtnUrl = null;
    $navBtnText = null;

    if(request()->is('forums*')) {
        $navBtnUrl = '/forums/create-topic';
        $navBtnText = trans('update.create_new_topic');
    } else {
        $navbarButton = getNavbarButton(!empty($authUser) ? $authUser->role_id : null, empty($authUser));

        if (!empty($navbarButton)) {
            $navBtnUrl = $navbarButton->url;
            $navBtnText = $navbarButton->title;
        }
    }
    
@endphp
<style>
 #navbarContent .navbar-nav {
    flex-wrap: nowrap;
    white-space: nowrap;
    gap: 10px;
    overflow: visible; /* <-- بدل hidden */
}

  .navbar-nav .nav-link {
    position: relative;
    font-weight: bold;
    color: #0d3b66;
    padding: 8px 15px;
    text-decoration: none;
    transition: color 0.3s ease;
}

.navbar-nav .nav-link::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background-color: #0d3b66;
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.navbar-nav .nav-link:hover {
    color: #0d3b66;
}

.navbar-nav .nav-link:hover::after {
    width: 100%;
    background-color: #faaa4b !important; 
}

</style>
<style>
    .nav-item {
        position: relative;
    }

    .nav-item > label {
        cursor: pointer;
        padding: 8px 12px;
        display: inline-block;
        font-weight: bold;
        color: #333;
        transition: color 0.3s ease;
    }

    .nav-item > label:hover {
        color: #007bff; /* لون أزرق عند الهوفر */
    }

    .nav-item div {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        opacity: 0;
        transform: translateY(20px) scale(0.95);
        pointer-events: none;
        transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        min-width: 200px;
        padding: 10px;
        z-index: 99;
    }

    .nav-item:hover div {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }

    .nav-item div a {
        display: block;
        padding: 8px 12px;
        color: #333;
        text-decoration: none !important;
        border-radius: 8px;
        transition: background 0.3s, transform 0.2s;
    }

    .nav-item div a:hover {
        background: #136ba5;
        color: #fff;
        transform: translateX(5px);
    }
</style>

<div id="navbarVacuum"></div>
<nav id="navbar" class="navbar navbar-expand-lg navbar-light">
    <div class="{{ (!empty($isPanel) and $isPanel) ? 'container-fluid' : 'container'}}">
        <div class="d-flex align-items-center justify-content-between w-100">
        <a class="navbar-order d-flex align-items-center justify-content-center mr-0 {{ (empty($navBtnUrl) and empty($navBtnText)) ? 'ml-auto' : '' }}" href="/canada" style="padding-top:20px; padding-bottom:20px;">
            @if(!empty($generalSettings['logo']))
                <img src="{{ $generalSettings['logo'] }}"  class="logo" alt="site logo" style="width:225px; height:64px !important; object-fit:contain;">
            @endif
        </a>
        <button class="navbar-toggler navbar-order" type="button" id="navbarToggle">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="mx-lg-30 d-none d-lg-flex flex-grow-1 navbar-toggle-content" id="navbarContent">
            <div class="navbar-toggle-header text-right d-lg-none">
                <button class="btn-transparent" id="navbarClose">
                    <i data-feather="x" width="32" height="32"></i>
                </button>
            </div>

                <ul class="navbar-nav mr-auto d-flex align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" style="text-decoration-line: none !important;"href="/canada">{{ trans('navigation.home') }}</a>
                    </li>
                      <li class="nav-item">
                        <a class="nav-link" style="text-decoration-line: none !important;"href="{{ url('/en/aboutUs/canada') }}">{{ trans('navigation.about_us') }}</a>
                    </li>
                    
                    <li class="nav-item">
                        <lable class="nav-link">{{ __('navigation.servicse') }}</lable>
                        <div>
                        <a class="nav-link" style="text-decoration-line: none !important;"href="{{ url('/en/canada/classes?sort=newest') }}">{{ trans('navigation.training') }}</a>
                        <a class="nav-link" style="text-decoration-line: none !important;"href="{{ route('cet_courses_canada') }}">{{ trans('navigation.TrainingProgramsPlan2025') }}</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="text-decoration-line: none !important;"href="{{ url('/en/canada') }}">{{ trans('navigation.international_certificates') }}</a>
                    </li>
                  <li class="nav-item">
                        <a class="nav-link" style="text-decoration-line: none !important;"href="{{ url('/en/contactus') }}">{{ trans('navigation.contact_us') }}</a>
                    </li>
                </ul>
{{-- User Menu --}}
            @include('web.default.includes.top_nav.user_menu_canada')
        </div>

            <div class="nav-icons-or-start-live navbar-order d-flex align-items-center justify-content-end">

              <!-- @if(!empty($navBtnUrl))
                    <a href="{{ $navBtnUrl }}" class="d-none d-lg-flex btn btn-sm btn-primary nav-start-a-live-btn">
                        {{ $navBtnText }}
                    </a>

                   <a href="{{ $navBtnUrl }}" class="d-flex d-lg-none text-primary nav-start-a-live-btn font-14">
                        {{ $navBtnText }}
                    </a>
                @endif-->

                @if(!empty($isPanel))
                    @if($authUser->checkAccessToAIContentFeature())
                        <div class="js-show-ai-content-drawer show-ai-content-drawer-btn d-flex-center mr-40">
                            <div class="d-flex-center size-32 rounded-circle bg-white">
                                <img src="/assets/default/img/ai/ai-chip.svg" alt="ai" class="" width="16px" height="16px">
                            </div>
                            <span class="ml-5 font-weight-500 text-secondary font-14 d-none d-lg-block">{{ trans('update.ai_content') }}</span>
                        </div>
                    @endif
                @endif

                <div class="d-none nav-notify-cart-dropdown top-navbar">
                    @include('web.default.includes.shopping-cart-dropdwon_canada')

                    <div class="border-left mx-15"></div>

                    @include('web.default.includes.notification-dropdown')
                </div>

            </div>
        </div>
    </div>
</nav>

@push('scripts_bottom')
    <script src="/assets/default/js/parts/navbar.min.js"></script>
@endpush
