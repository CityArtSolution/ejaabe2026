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



    <!-- Header 
    ============================================= -->
    <header id="home">


   
        <!-- Start Navigation -->
        <nav class="navbar navbar-default attr-border active-border small-pad navbar-sticky bootsnav">

            <!-- Start Top Search -->
            <div class="top-search">
                <div class="container">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="{{ trans('navbar.search_anything') }}">
                        <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
                    </div>
                </div>
            </div>
            <!-- End Top Search -->

            <div class="container">

                 <div class="row">
                <div class="col-md-2 text-right">

                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="/{{ app()->getLocale() }}">
                        <img src="/store/1/logoGR.png" class="logo" alt="Logo">
                    </a>
                </div>
                <!-- End Header Navigation -->
               </div>
               @php 
                 function isMobile() {
                // List of mobile user agent strings
                $mobile_agents = [
                    'iphone', 'ipod', 'android', 'blackberry', 'webos', 'windows phone', 'opera mini', 'ucbrowser', 'mobile'
                ];
            
                // Get the User-Agent string
                $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
            
                // Check if any of the mobile user agents are present in the User-Agent string
                foreach ($mobile_agents as $device) {
                    if (strpos($userAgent, $device) !== false) {
                        return true; // It's a mobile device
                    }
                }
                return false; // It's a desktop browser
            }
            
               @endphp
             <div class="col-md-3 text-right">
               @php 
                              
                               if(Request::path()=='/' &&app()->getLocale()=='ar') {
                               $url=url('ar');
                               }else {
                               $url=url(str_replace(app()->getLocale(),'ar', Request::path())) ;
                               }
                               
                                if(Request::path()=='/' &&app()->getLocale()=='ar') {
                               $urlen=url('en');
                               }else {
                               $urlen=url(str_replace(app()->getLocale(),'en', Request::path())) ;
                               }
                               @endphp
                <!-- Collect the nav links, forms, and other content for toggling -->
                @php if (isMobile()) { @endphp
                 <div class="collapse navbar-collapse" id="navbar-menu" >
                      <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                         <li>
                            <a href="/{{ app()->getLocale() }}" class="active"> {{trans('app.menu_1')}}</a>
                            
                        </li>
                        <li>
                            <a href="/{{ app()->getLocale() }}/about">  {{trans('app.menu_2')}}</a>
                            
                        </li>
                        <li>
                            <a href="/{{ app()->getLocale() }}/solution"> {{trans('app.menu_3')}}</a>
                            
                        </li>
                        <li>
                            <a href="/{{ app()->getLocale() }}/tranning">     {{trans('app.menu_4')}}  </a>
                            
                        </li>
                        <li><a href="/{{ app()->getLocale() }}/resource"> {{trans('app.menu_5')}}</a></li>
                        
                        <li>
                            <a href="/{{ app()->getLocale() }}/contactus">   {{trans('app.menu_6')}}</a>
                        </li>
                        <li><a class="color">  <i class="fa-solid fa-language"></i> {{trans('app.langs')}} </a></li>
                         
                          <li>
                            <a href="{{$url}}" class="active en_nuber"> Arabic</a>
                            
                        </li>
                        <li>
                            <a href="{{$urlen}}" class="en_nuber">  english</a>
                            
                        </li>
                        
                        
                      </ul>
                </div>
                @php } else{ @endphp
                <div class="collapse navbar-collapse" id="navbar-menu">
                    
                    <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#">
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" >
                                 <i class="fa fa-bars"></i></a>
                                 
                            <ul class="dropdown-menu">
                                 <li>
                            <a href="/{{ app()->getLocale() }}" class="active"> {{trans('app.menu_1')}}</a>
                            
                        </li>
                        <li>
                            <a href="/{{ app()->getLocale() }}/about">  {{trans('app.menu_2')}}</a>
                            
                        </li>
                        <li>
                            <a href="/{{ app()->getLocale() }}/solution"> {{trans('app.menu_3')}}</a>
                            
                        </li>
                        <li>
                            <a href="/{{ app()->getLocale() }}/tranning">     {{trans('app.menu_4')}}  </a>
                            
                        </li>
                        <li><a href="/{{ app()->getLocale() }}/resource"> {{trans('app.menu_5')}}</a></li>
                        
                        <li>
                            <a href="/{{ app()->getLocale() }}/contactus">   {{trans('app.menu_6')}}</a>
                        </li>
                        
                            </ul>
                        </li>
                       <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                                <i class="fa-solid fa-language"></i></a>
                                 
                            <ul class="dropdown-menu">
                                 
                                 <li>
                                     
                               
                               
                            <a href="{{$url }}" class="active en_nuber"> Arabic</a>
                            
                        </li>
                        <li>
                            <a href="{{ $urlen }}" class="en_nuber">  english</a>
                            
                        </li>
                       
                        </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
                @php } @endphp
            </div>
                
            <div class="col-md-4 address-info text-right">
                 <!-- Start Atribute Navigation -->
                <div class="attr-nav">
                    <ul>
                        <li class="search"><a href="#"><i class="fas fa-search"></i></a></li>
                        
                    </ul>
                    <ul class="social">
                        <li><a href="#"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-snapchat" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a></li>
                    </ul>
                </div>  
                </div>
            
            <div class="col-md-3 address-info text-right">
                    <div class="info box">
                       
                   <!-- {{-- User Menu --}}-->
                    @include('web.default.includes.top_nav.user_menu_main')
                    </div>
                   
                </div>
                <!-- End Atribute Navigation -->
                 </div>
            </div>

           

        </nav>
        <!-- End Navigation -->

    </header>
    <!-- End Header -->
    
