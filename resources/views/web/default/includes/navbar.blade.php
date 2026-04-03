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

<div id="navbarVacuum"></div>
<nav id="navbar" class="navbar navbar-expand-lg navbar-light">
    <div class="{{ (!empty($isPanel) and $isPanel) ? 'container-fluid' : 'container'}}">
        <div class="d-flex align-items-center justify-content-between w-100">

            <a class=" navbar-order d-flex align-items-center justify-content-center mr-0 {{ (empty($navBtnUrl) and empty($navBtnText)) ? 'ml-auto' : '' }}"  href="/">
                @if(!empty($generalSettings['logo']))
                    <img src="{{ $generalSettings['logo'] }}" class=" logo"  alt="site logo">
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
                    @if(!empty($categories) and count($categories))
                    @foreach($categories as $category)
                    @if(count($category->subCategories))
                   
                    
                        <li class="mr-lg-25">
                            <div class="menu-category">
                                <ul>
                                    <li class="cursor-pointer user-select-none d-flex xs-categories-toggle">
                                        
                                       {{ $category->title }}
                                   <i data-feather="chevron-{{trans('app.left')}}" width="20" height="20" class="mr-10 d-none d-lg-block"></i>
                                        <ul class="cat-dropdown-menu">
                                            
                                              <!--  <li>
                                                    <a href="{{ $category->getUrl() }}" class="{{ (!empty($category->subCategories) and count($category->subCategories)) ? 'js-has-subcategory' : '' }}">
                                                        <div class="d-flex align-items-center">
                                                            @if(!empty($category->icon))
                                                                <img src="{{ $category->icon }}" class="cat-dropdown-menu-icon mr-10" alt="{{ $category->title }} icon">
                                                            @endif

                                                            {{ $category->title }}
                                                        </div>

                                                        @if(!empty($category->subCategories) and count($category->subCategories))
                                                            <i data-feather="chevron-right" width="20" height="20" class="d-none d-lg-inline-block ml-10"></i>
                                                            <i data-feather="chevron-down" width="20" height="20" class="d-inline-block d-lg-none"></i>
                                                        @endif
                                                    </a>-->

                                                    @if(!empty($category->subCategories) and count($category->subCategories))
                                                      <!--  <ul class="sub-menu" data-simplebar @if((!empty($isRtl) and $isRtl)) data-simplebar-direction="rtl" @endif>-->
                                                            @foreach($category->subCategories as $subCategory)
                                                                <li>
                                                                    <a href="{{ $subCategory->getUrl() }}">
                                                                        @if(!empty($subCategory->icon))
                                                                            <img src="{{ $subCategory->icon }}" class="cat-dropdown-menu-icon mr-10" alt="{{ $subCategory->title }} icon">
                                                                        @endif

                                                                        {{ $subCategory->title }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                       <!-- </ul>-->
                                                    @endif
                                             <!--   </li>-->
                                          
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @else
                         
                              
                     
                         <li class="nav-item">
                            
                             @if(Illuminate\Support\Str::contains($category->slug, 'https://')) 
                                <a class="nav-link" href="{{ $category->slug }}">{{ $category->title }}</a>
                            @elseif(Illuminate\Support\Str::contains($category->slug, '/'))
                             <a class="nav-link" href="/{{ app()->getLocale()}}">{{ $category->title }}</a>
                            @else 
                                 <a class="nav-link" href="/{{ app()->getLocale().'/'.$category->slug }}">{{ $category->title }}</a>
                            @endif
                            </li>
                      
                        @endif   
                         @endforeach
                          
                    @endif

                  <!--  @if(!empty($navbarPages) and count($navbarPages))
                        @foreach($navbarPages as $navbarPage)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ $navbarPage['link'] }}">{{ $navbarPage['title'] }}</a>
                            </li>
                        @endforeach
                    @endif-->
                </ul>
            </div>
<style>
 #navbarContent .navbar-nav {
    flex-wrap: nowrap;
    white-space: nowrap;
    gap: 10px;
    overflow: visible; /* <-- بدل hidden */
}


</style>
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
                    @include('web.default.includes.shopping-cart-dropdwon')

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
