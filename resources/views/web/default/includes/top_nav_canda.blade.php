@php
    // تثبيت اللغة الإنجليزية فقط
    $userLanguages = ['en' => 'English'];
    $localLanguage = ['US' => 'English'];
@endphp


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

                {{-- Currency --}}
                @include('web.default.includes.top_nav.currency')
                
                <!-- تم إزالة زر تغيير اللغة -->

                <!-- إضافة الرقم والبريد الجديد هنا -->
               <ul class="navbar-nav mr-auto d-flex align-items-center flex-row">
    <li class="d-flex align-items-center text-dark-blue font-14 mr-15">
        <i class="fa fa-phone mr-5" aria-hidden="true"></i> +1 (226) 700-3361
    </li>
    <li class="d-flex align-items-center text-dark-blue font-14">
        <i class="fa fa-envelope mr-5" aria-hidden="true"></i> info-canada@ejaabi.com
    </li>
</ul>


                <!-- تم إزالة فورم البحث -->
            </div>
        </div>

        <div class="xs-w-100 d-flex align-items-center justify-content-between ">
            <div class="d-flex">
            <style>
.branch-dropdown {
  position: relative;
  font-family: 'Cairo', sans-serif;
}

.branch-dropdown .current-branch {
  margin: 5px;
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

<div class="branch-dropdown" id="branchDropdown">
  <div class="current-branch">
      <img style="width: 16px;margin: 6px;" src="/flags/ca.png" alt="CA"> {{ __('navbar.ca') }}
  </div>
  <ul>
    <li>
      <a href="/">
        <img src="/flags/sa.svg.webp"  alt="SA"> {{ __('navbar.saudi') }}
      </a>
    </li>
    <li>
      <a href="/egy">
        <img  src="/flags/eg.svg.webp" alt="EG"> {{ __('navbar.egypt') }}
      </a>
    </li>
    <li>
      <a href="/uae">
        <img src="/flags/ae.png" alt="AE"> {{ __('navbar.uae') }}
      </a>
    </li>
  </ul>
</div>

<script>
  const dropdown = document.getElementById("branchDropdown");
  dropdown.querySelector(".current-branch").addEventListener("click", () => {
    dropdown.classList.toggle("active");
  });
</script>

                @include(getTemplate().'.includes.shopping-cart-dropdwon_canada')

                <div class="border-left mx-5 mx-lg-15"></div>

                @include(getTemplate().'.includes.notification-dropdown')
            </div>


        </div>
    </div>
</div>
