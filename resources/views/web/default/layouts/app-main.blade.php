<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@php
    $rtlLanguages = !empty($generalSettings['rtl_languages']) ? $generalSettings['rtl_languages'] : [];

    $isRtl = ((in_array(mb_strtoupper(app()->getLocale()), $rtlLanguages)) or (!empty($generalSettings['rtl_layout']) and $generalSettings['rtl_layout'] == 1));
@endphp

<head>
    @include('web.default.includes.metas_main')
    @php 
    if($pageTitle=='Growth Wave' && app()->getLocale()=='ar')
    {
      $pageTitle='الرئيسية';
    } 
    else if($pageTitle=='Growth Wave' && app()->getLocale()=='en'){
    $pageTitle='Home';
    }

    @endphp
    <title>{{ $pageTitle ?? '' }}{{ !empty($generalSettings['site_name']) ? (' - '.trans('app.title_page')) : '' }}</title>
    <script src="https://kit.fontawesome.com/ea345573be.js" crossorigin="anonymous"></script>
    <!-- General CSS File -->
    
    
 
    <!--<link rel="stylesheet" href="/assets/default/css/app.css">-->
    <link href="/assets/default/vendors/flagstrap/css/flags.css" rel="stylesheet">
    <link href="/assets/demo/assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="/assets/demo/assets/css/themify-icons.css" rel="stylesheet" />
    <link href="/assets/demo/assets/css/elegant-icons.css" rel="stylesheet" />
    <link href="/assets/demo/assets/css/flaticon-set.css" rel="stylesheet" />
    <link href="/assets/demo/assets/css/magnific-popup.css" rel="stylesheet" />
    <link href="/assets/demo/assets/css/owl.carousel.min.css" rel="stylesheet" />
    <link href="/assets/demo/assets/css/owl.theme.default.min.css" rel="stylesheet" />
    <link href="/assets/demo/assets/css/animate.css" rel="stylesheet" />
    
    
   @if($isRtl)
   <link href="/assets/demo/assets/css/bootsnav_rtl.css" rel="stylesheet" />
    <link 
    rel="stylesheet"
    href="https://cdn.rtlcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-cSfiDrYfMj9eYCidq//oGXEkMc0vuTxHXizrMOFAaPsLt1zoCUVnSsURN+nef1lj"
    crossorigin="anonymous">
    
      <link href="/assets/demo/assets/css/style-rtl.css" rel="stylesheet">
        <!--<link rel="stylesheet" href="/assets/default/css/rtl-app.css">-->
    @else
    <link href="/assets/demo/assets/css/bootsnav.css" rel="stylesheet" />
    <link href="/assets/demo/assets/css/bootstrap.min.css" rel="stylesheet">
     <link href="/assets/demo/assets/css/style.css" rel="stylesheet">
      <!-- ========== Google Fonts ========== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
   
    
    @endif
 <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&amp;display=swap" rel="stylesheet">
    <link href="/assets/demo/assets/css/responsive.css" rel="stylesheet" />

   
    @stack('styles_top')
    @stack('scripts_top')

    <style>
       
    </style>


    @if(!empty($generalSettings['preloading']) and $generalSettings['preloading'] == '1')
        @include('admin.includes.preloading')
    @endif
   <link rel="stylesheet" href="assets/css/chat.css">
<script src="/assets/demo/assets/js/bundle.js"></script>
<style>
    .sc-sbsi7l-0{
        opacity: 0 !important;
    }
     
</style>
<script type="text/javascript">
    (function () {
        var options = {
            
            whatsapp: "+966558045586", // WhatsApp number
            call_to_action: " راسلنا  ", // Call to action
            button_color: "#f04775", // Color of button
            position: "right", // Position may be 'right' or 'left'
            order: "whatsapp", // Order of buttons
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
</head>
@if($isRtl)
<body  dir="rtl" class="rtl">
@else
<body>
 @endif



    @if(!isset($appHeader))
       <!-- @include('web.default.includes.top_nav')-->
        @include('web.default.includes.navbar-main')
    @endif

    
    @yield('content')

    @if(!isset($appFooter))
        @include('web.default.includes.footer-main')
    @endif

   

<!-- Template JS File -->
 <!-- jQuery Frameworks
    ============================================= -->
   <script src="/assets/demo/assets/js/jquery-1.12.4.min.js"></script>
   @if($isRtl)
    <script
    src="https://cdn.rtlcss.com/bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha384-B4D+9otHJ5PJZQbqWyDHJc6z6st5fX3r680CYa0Em9AUG6jqu5t473Y+1CTZQWZv"
    crossorigin="anonymous"></script>
     @else
    <script src="/assets/demo/assets/js/bootstrap.min.js"></script>
    @endif
    <script src="/assets/demo/assets/js/equal-height.min.js"></script>
    <script src="/assets/demo/assets/js/jquery.appear.js"></script>
    <script src="/assets/demo/assets/js/jquery.easing.min.js"></script>
    <script src="/assets/demo/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="/assets/demo/assets/js/modernizr.custom.13711.js"></script>
    <script src="/assets/demo/assets/js/owl.carousel.min.js"></script>
    <script src="/assets/demo/assets/js/wow.min.js"></script>
    <script src="/assets/demo/assets/js/progress-bar.min.js"></script>
    <script src="/assets/demo/assets/js/isotope.pkgd.min.js"></script>
    <script src="/assets/demo/assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="/assets/demo/assets/js/count-to.js"></script>
    <script src="/assets/demo/assets/js/YTPlayer.min.js"></script>
    <script src="/assets/demo/assets/js/circle-progress.js"></script>
    <script src="/assets/demo/assets/js/bootsnav.js"></script>
   
    <script src="/assets/default/vendors/flagstrap/js/jquery.flagstrap.min.js"></script>
    <script src="/assets/default/js/parts/top_nav_flags.min.js"></script>
    @stack('styles_bottom')
@stack('scripts_bottom')
     @if($isRtl)
    <script src="/assets/demo/assets/js/main_ar.js"></script>
      @else
       <script src="/assets/demo/assets/js/main.js"></script>
  @endif

@if(empty($justMobileApp) and checkShowCookieSecurityDialog())
    @include('web.default.includes.cookie-security')
@endif





<!--<script src="/assets/default/js/parts/main.min.js"></script>-->


</body>
</html>
