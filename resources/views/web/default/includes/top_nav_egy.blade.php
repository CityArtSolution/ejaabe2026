@php
    $userLanguages = !empty($generalSettings['site_language']) ? [$generalSettings['site_language'] => getLanguages($generalSettings['site_language'])] : [];

    if (!empty($generalSettings['user_languages']) and is_array($generalSettings['user_languages'])) {
        $userLanguages = getLanguages($generalSettings['user_languages']);
    }

    $localLanguage = [];

    foreach($userLanguages as $key => $userLanguage) {
        $localLanguage[localeToCountryCode($key)] = $userLanguage;
    }

@endphp
<style>
    /* ===== Top Navbar Styles ===== */
.top-navbar {
    background-color: #f9f9fb; /* لون خلفية ناعم */
    font-family: 'Cairo', sans-serif; /* خط عربي فخم */
    font-size: 14px;
    color: #1a1a1a;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.top-navbar .top-contact-box {
    padding: 10px 0;
}

.top-navbar i {
    color: #136ba5; /* ألوان الأيقونات */
}

.top-navbar .border-left {
    border-left: 1px solid #ddd;
    height: 20px;
}

.top-navbar .d-flex.align-items-center > div {
    transition: all 0.3s ease;
}


.btn {
transition: all 0.3s ease; 
}

.btn:hover {
     transform: translateY(-2px);
    color: #3b82f6;   
}

/* ==== Responsive ===== */
@media (max-width: 991px) {
    .top-navbar .top-contact-box {
        flex-direction: column !important;
    }
    .top-navbar .navbar-nav li {
        margin-right: 0;
        margin-bottom: 10px;
    }
}

/* ==== Animation عند التحريك ==== */
@keyframes fadeSlideDown {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.top-navbar .top-contact-box {
    animation: fadeSlideDown 0.7s ease forwards;
}

</style>
<style>
.branch-dropdown {
  position: relative;
  font-family: 'Cairo', sans-serif;
}

.branch-dropdown .current-branch {
  color: black;
  padding: 8px 16px;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  transition: all 0.3s ease;
  gap: 4px;
}

.branch-dropdown .current-branch::after {
  content: "\25BC"; /* سهم ▼ */
  font-size: 12px;
  margin-left: 6px;
  transition: transform 0.3s;
}

/* القائمة */
.branch-dropdown ul {
  position: absolute;
  top: 110%;
  left: 0;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 6px 15px rgba(0,0,0,0.1);
  list-style: none;
  padding: 10px 0;
  margin: 0;
  min-width: 220px;
  opacity: 0;
  transform: translateY(-10px);
  pointer-events: none;
  transition: all 0.4s ease;
  z-index: 999;
}
.branch-dropdown ul li a {
  display: flex;
  align-items: center;
  padding: 10px 20px;
  font-size: 14px;
  color: #333;
  text-decoration: none;
  transition: all 0.3s ease;
}
.branch-dropdown ul li a img {
  width: 20px;
  height: 14px;
  object-fit: cover;
  margin-right: 10px;
  border-radius: 2px;
}
.branch-dropdown ul li a:hover {
  background: #f0f4f8;
  color: #136ba5;
}

/* التفعيل */
.branch-dropdown.active .current-branch::after {
  transform: rotate(180deg);
}
.branch-dropdown.active ul {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto;
}

</style>

<div class="top-navbar d-flex border-bottom">
    <div class="container d-flex justify-content-between flex-column flex-lg-row">
        <div class="top-contact-box border-bottom d-flex flex-column flex-md-row align-items-center justify-content-center">
            @if(getOthersPersonalizationSettings('platform_phone_and_email_position') == 'header')
                <div class="d-flex align-items-center justify-content-center mr-15 mr-md-30">
                    @if(!empty($generalSettings['site_phone']))
                        <div class="d-flex align-items-center py-10 py-lg-0 text-dark-blue font-14">
                            <i data-feather="phone" width="20" height="20" class="mr-10"></i>
                            {{ $generalSettings['site_phone'] }}
                        </div>
                    @endif

                    @if(!empty($generalSettings['site_email']))
                        <div class="border-left mx-5 mx-lg-15 h-100"></div>

                        <div class="d-flex align-items-center py-10 py-lg-0 text-dark-blue font-14">
                            <i data-feather="mail" width="20" height="20" class="mr-10"></i>
                            {{ $generalSettings['site_email'] }}
                        </div>
                    @endif
                </div>
            @endif
            <div class="d-flex align-items-center justify-content-between justify-content-md-center">
                @include('web.default.includes.top_nav.currency')
                <!-- إضافة الرقم والبريد الجديد هنا -->
                <ul class="navbar-nav mr-auto d-flex align-items-center flex-row">
                    <li class="d-flex align-items-center text-dark-blue font-14 mr-15">
                        <i class="fa fa-phone mr-5" aria-hidden="true"></i> 01032589460
                    </li>
                    <li class="d-flex align-items-center text-dark-blue font-14">
                        <i class="fa fa-envelope mr-5" aria-hidden="true"></i> info-Egypt@ejaabi.com
                    </li>
                </ul>
            </div>
        </div>
        <div class="xs-w-100 d-flex align-items-center justify-content-between ">
            <div class="branch-dropdown" id="branchDropdown">
  <div class="current-branch">
    <img style="width: 16px;margin: 6px;" src="/flags/eg.svg.webp" alt="EG"> {{ __('navbar.egypt') }}
  </div>
  <ul>
    <li>
      <a href="/">
        <img src="/flags/sa.svg.webp" alt="SA"> {{ __('navbar.saudi') }}
      </a>
    </li>
    <li>
      <a href="/uae">
        <img src="/flags/ae.png" alt="AE"> {{ __('navbar.uae') }}
      </a>
    </li>
    <li>
      <a href="/en/canada">
        <img src="/flags/ca.png" alt="CA"> {{ __('navbar.ca') }}
      </a>
    </li>
  </ul>
</div>
            <ul class="navbar-nav mr-auto d-flex align-items-center">
                    <li class="mr-lg-25">
                        <div class="menu-category">
                            <ul>
                                <li class="cursor-pointer user-select-none d-flex xs-categories-toggle">
                                    <i class="fa-solid fa-language" aria-hidden="true" style="   padding-right: 5px; padding-left: 5px;padding-top: 3px;"></i>
                                    {{ trans('app.lang') }}
                                    @php 
                                    $url=( Request::path()=='/' ||Request::path()=='en' || Request::path()=='ar')? url(trans('app.local')):  
                                    url(str_replace(app()->getLocale().'/',trans('app.local').'/', Request::path())) ;
                                    $queryParams = Request::query();
                                    $url= $queryParams ?$url.'?' . http_build_query($queryParams):$url;
                                    @endphp
                                    <ul class="cat-dropdown-menu" style="z-index:1000">
                                        <li>
                                            <a href="{{$url}}">{{ trans('app.arabic') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>

<script>
  const dropdown = document.getElementById("branchDropdown");
  dropdown.querySelector(".current-branch").addEventListener("click", () => {
    dropdown.classList.toggle("active");
  });
</script>

            <div class="d-flex">
                @include(getTemplate().'.includes.shopping-cart-dropdwon_egypt')
                <div class="border-left mx-5 mx-lg-15"></div>
                @include(getTemplate().'.includes.notification-dropdown')
            </div>
        </div>
    </div>
</div>
