@extends(getTemplate().'.layouts.egy_app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/css/css-stars.css">
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">

    <style>
    
    .instructor-discount-card {
    background-color: transparent;
}
.course-content-section .instructor-discount-card {
    margin-top: 4.5rem;
}
.instructor-discount-card__code {
    position: relative;
    width: 122px;
    height: auto;
}
.course-description span {
    color: #000;
    font-size: 14px !important;
    
}
.course-description span {
    color: #000;
 
    font-family: 'GE-Dinar-Two' !important;
    
}
.course-content-section .instructor-discount-card {
    margin-top: 120px !important;
    max-height: 80px;
}

.course-content-section:not(.has-progress-bar) .instructor-discount-card {
    margin-top: 120px !important;
}

.nav-tabs .nav-item a.active:after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 85%;
    height: 5px;
    background-color:  #faaa4b;
    border-radius: 5px;
    transform: translate(-50%, 17px);
}

     .nav-tabs {
            position: relative;
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }

        .nav-tabs::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }

        /* Container for scroll buttons */
        .tabs-container {
            position: relative;
        }

        /* Scroll buttons */
        .scroll-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: rgba(0, 0, 0, 0.5);
            border: none;
            color: white;
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            display: none;
        }

        .scroll-left {
            left: 0;
        }

        .scroll-right {
            right: 0;
        }

        /* Tab styles */
        .nav-tabs .nav-item {
            flex: 0 0 auto;
            white-space: nowrap;
            margin: 0 5px;
        }

        .nav-tabs .nav-item a {
            padding: 10px 15px;
            display: block;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-item a:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .nav-tabs .nav-item a.active {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .nav-tabs {
                padding: 10px !important;
            }
            
            .nav-tabs .nav-item a {
                padding: 8px 12px;
                font-size: 13px;
            }
        }

        /* Show scroll buttons when needed */
        @media (min-width: 768px) {
            .tabs-container:hover .scroll-button {
                display: block;
            }
        }

.approval-heading {
    color: #fff; 
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Text shadow for better visibility over images */
    margin-bottom: 10px; /* Space below the heading */
}

.approval-value {
    margin-left: 10px; /* Space between the label and the value */
}


.approval-container {
    background-color: transparent; /* Ensure the container background is transparent */
}

.approval-heading {
    color: #fff; /* White text color */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Text shadow for better visibility over images */
    margin-right: 15px; /* Space between the label and the image */
    padding-left: 1rem;
}

.approval-logo {
    display: flex;
    align-items: center; /* Center the image vertically */
    background-color: rgba(255, 255, 255, 0.3); /* Semi-transparent white background */
    padding: 5px; /* Add some padding around the logo */
    border-radius: 5px; /* Optional: Add rounded corners */
}

.approval-image {
    height: 60px; /* Set the height of the image to 60px */
    width: auto; /* Maintain aspect ratio */
    filter: brightness(1.2); /* Optional: Adjust brightness for better visibility */
}
.panel-collapse span {
    font-family: 'GE-Dinar-Two';
    line-height: 25px;
}
</style>
@endpush


@section('content')
    <section class="course-cover-container {{ empty($activeSpecialOffer) ? 'not-active-special-offer' : '' }}">
        <img src="{{ $course->getImageCover() }}" class="img-cover course-cover-img" alt="{{ $course->title }}"/>

        <div class="cover-content pt-40">
            <div class="container position-relative">
                @if(!empty($activeSpecialOffer))
                    @include('web.default.course.special_offer')
                @endif
            </div>
        </div>
    </section>

    @php
        $percent = $course->getProgress();
    @endphp

    <section class="container course-content-section {{ $course->type }} {{ ($course->type=='offline' or $hasBought or $percent) ? 'has-progress-bar' : '' }}">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="course-content-body user-select-none">
                    <div class="course-body-on-cover text-white">
                        <h1 class="font-30 course-title">
                            {{ $course->title }}
                        </h1>
                        


                        @if(!empty($course->category))
                           {{-- <span class="d-block font-16 mt-10">{{ trans('public.in') }} <a href="{{ $course->category->getUrl() }}" target="_blank" class="font-weight-500 text-decoration-underline text-white">{{ $course->category->title }}</a></span>--}}
                        @endif

                        <div class="d-flex align-items-center">
                            

                            @include('web.default.includes.webinar.rate',['rate' => $course->getRate()])
                            <span class="ml-10 mt-15 font-14">({{ $course->reviews->pluck('creator_id')->count() }} {{ trans('public.ratings') }})</span>
                        </div>
                        
                           <div class="d-flex align-items-center">
                            
<h4 class="ml-10 mt-15 font-14 approval-heading">
   <span class="approval-value">{{ $course->approval_name ?? "" }}</span>
</h4>                        </div>


<div class="d-flex align-items-center approval-container">
    <h4 class="ml-10 mt-15 font-14 approval-heading">
        {{!empty($course->approval_name)? trans('public.approval'):"" }}
    </h4>
 @if(!empty($course->approval_logo))
        <span class="approval-logo">
            <img src="{{ $course->approval_logo }}" alt="approval" class="approval-image">
        </span>
    @endif
</div>
                        {{--<div class="mt-15">
                            <span class="font-14">{{ trans('public.created_by') }}</span>
                            <a href="{{ $course->teacher->getProfileUrl() }}" target="_blank" class="text-decoration-underline text-white font-14 font-weight-500">{{ $course->teacher->full_name }}</a>
                        </div>--}}

                        @if($hasBought or $percent)
                          @if($course->type=='offline')
                            <div class="mt-30 d-flex align-items-center">
                                <div class="progress course-progress flex-grow-1 shadow-xs rounded-sm">
                                    <span class="progress-bar rounded-sm bg-warning" style="width: {{ $percent }}%"></span>
                                </div>

                                <span class="ml-15 font-14 font-weight-500">
                                    @if($hasBought and (!$course->isWebinar() or $course->isProgressing()))
                                        {{ trans('public.course_learning_passed',['percent' => $percent]) }}
                                    @elseif(!is_null($course->capacity))
                                        {{ $course->getSalesCount() }}/{{ $course->capacity }} {{ trans('quiz.students') }}
                                    @else
                                        {{ trans('public.course_learning_passed',['percent' => $percent]) }}
                                    @endif
                                </span>
                            </div>
                            @endif
                        @endif
                    </div>

                 {{--   @if(
                            !empty(getFeaturesSettings("frontend_coupons_display_type")) and
                            getFeaturesSettings("frontend_coupons_display_type") == "before_content" and
                            !empty($instructorDiscounts) and
                            count($instructorDiscounts)
                        )
                        @foreach($instructorDiscounts as $instructorDiscount)
                            @include('web.default.includes.discounts.instructor_discounts_card', ['discount' => $instructorDiscount, 'instructorDiscountClassName' => "mt-35"])
                        @endforeach
                    @endif
                    --}}

               
              
             
                 <div class="mt-35">
    <div class="tabs-container">
        <!-- Scroll buttons -->
        <button class="scroll-button scroll-left" onclick="scrollTabs('left')">←</button>
        <button class="scroll-button scroll-right" onclick="scrollTabs('right')">→</button>

        <ul class="nav nav-tabs bg-secondary rounded-sm p-15 d-flex align-items-center" id="tabs-tab" role="tablist">
            <!-- Your existing tab items here -->
            @if($course->description)
                <li class="nav-item">
                    <a class="position-relative font-14 text-white {{ (empty(request()->get('tab','')) or request()->get('tab','') == 'information') ? 'active' : '' }}" 
                       id="information-tab" 
                       data-toggle="tab" 
                       href="#information" 
                       role="tab" 
                       aria-controls="information" 
                       aria-selected="true">
                       {{ trans('public.information') }}
                    </a>
                </li>
            @endif
                 @if (isset($course->sections) && !empty($course->sections))
                                @foreach (json_decode($course->sections) as $key => $item)
                                    <li class="nav-item">
                                        <a class="position-relative font-14 text-white {{ (request()->get('tab','') == 'section-' . $key) ? 'active' : '' }}" 
                                           id="section-{{ $key }}-tab" 
                                           data-toggle="tab" 
                                           href="#section-{{ $key }}" 
                                           role="tab" 
                                           aria-controls="section-{{ $key }}" 
                                           aria-selected="false">
                                           {{ $item->title }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        
                       
                            <li class="nav-item">
                                <a class="position-relative font-14 text-white {{ (request()->get('tab','') == 'content') ? 'active' : '' }}" 
                                   id="content-tab" 
                                   data-toggle="tab" 
                                   href="#content" 
                                   role="tab" 
                                   aria-controls="content" 
                                   aria-selected="false">
                                   {{ trans('public.content') }} ({{ $webinarContentCount }})
                                </a>
                            </li>
                            
                              @if((auth()->user() && auth()->user()->isAdmin()) || $hasBought)
                                  <li class="nav-item">
                                <a class="position-relative font-14 text-white {{ (request()->get('tab','') == 'files') ? 'active' : '' }}" 
                                   id="files-tab" 
                                   data-toggle="tab" 
                                   href="#files" 
                                   role="tab" 
                                   aria-controls="files" 
                                   aria-selected="false">
                                   {{ trans('public.Links And Files') }} 
                                </a>
                            </li>
                            
                            @endif
                            
                            
                            <li class="nav-item">
                                <a class="position-relative font-14 text-white {{ (request()->get('tab','') == 'reviews') ? 'active' : '' }}" 
                                   id="reviews-tab" 
                                   data-toggle="tab" 
                                   href="#reviews" 
                                   role="tab" 
                                   aria-controls="reviews" 
                                   aria-selected="false">
                                   {{ trans('public.reviews') }} ({{ $course->reviews->count() > 0 ? $course->reviews->pluck('creator_id')->count() : 0 }})
                                </a>
                            </li>
                        </ul>
            
            <!-- Rest of your tabs... -->
        </ul>
    </div>

    <!-- Your existing tab content -->
 
        <div class="tab-content" id="nav-tabContent">
                            
                            <!-- Existing tab content -->
                            @if($course->description)
                            <div class="tab-pane fade {{ (empty(request()->get('tab','')) or request()->get('tab','') == 'information') ? 'show active' : '' }}" 
                                 id="information" 
                                 role="tabpanel" 
                                 aria-labelledby="information-tab">
                                 @include(getTemplate().'.course.tabs.information')
                            </div>
                            @endif
                            <!-- Dynamically add content for sections -->
                            @if (isset($course->sections) && !empty($course->sections))
                                @foreach (json_decode($course->sections) as $key => $item)
                                    <div class="tab-pane fade {{ (request()->get('tab','') == 'section-' . $key) ? 'show active' : '' }}" 
                                         id="section-{{ $key }}" 
                                         role="tabpanel" 
                                         aria-labelledby="section-{{ $key }}-tab">
                                        
                                         <div class="mt-20">
                                            <div class="mt-15 course-description">
                                                {!! $item->detail !!}
                                            </div>
                                        </div>


                                    </div>
                                @endforeach
                            @endif
                        
                            
                            <div class="tab-pane fade {{ (request()->get('tab','') == 'content') ? 'show active' : '' }}" 
                                 id="content" 
                                 role="tabpanel" 
                                 aria-labelledby="content-tab">
                                 @include(getTemplate().'.course.tabs.content')
                            </div>
                            
                            
                                 @if((auth()->user() && auth()->user()->isAdmin()) || $hasBought)

                              <div class="tab-pane fade {{ (request()->get('tab','') == 'files') ? 'show active' : '' }}" 
                                 id="files" 
                                 role="tabpanel" 
                                 aria-labelledby="files-tab">
                                @php
    $learningMaterialsExtraDescription = !empty($course->webinarExtraDescription) ? $course->webinarExtraDescription->where('type','learning_materials') : null;
@endphp

                                @if(!empty($learningMaterialsExtraDescription) and count($learningMaterialsExtraDescription))
    <div class="mt-20 rounded-sm border bg-info-light p-15">
        <h3 class="font-16 text-secondary font-weight-bold mb-15">{{ trans('public.Links And Files') }}</h3>

        @foreach($learningMaterialsExtraDescription as $learningMaterial)
            <p class="d-flex align-items-start font-14 text-gray mt-10">
                <i data-feather="check" width="18" height="18" class="mr-10 webinar-extra-description-check-icon"></i>
                @if($learningMaterial->link)
                <span class="">
                    <a href="{{$learningMaterial->link}}" target=_blank>{{ $learningMaterial->value }}</a>
                    </span>
                    @endif
                    
                  
            </p>
                @if($learningMaterial->attached)
                     <p>
                <span class="">
                   
                    
                    <a href="/{{$learningMaterial->attached}}" target=_blank>{{ $learningMaterial->value }}--{{ trans('public.download') }} </a>
                    </span>
                    </p>
                    @endif
                    
        @endforeach
    </div>
@endif
                                
                            </div>
                            
                             @endif
                            <div class="tab-pane fade {{ (request()->get('tab','') == 'reviews') ? 'show active' : '' }}" 
                                 id="reviews" 
                                 role="tabpanel" 
                                 aria-labelledby="reviews-tab">
                                 @include(getTemplate().'.course.tabs.reviews')
                            </div>
                        
    </div>
</div>

<script>
    // Function to handle tab scrolling
    function scrollTabs(direction) {
        const tabList = document.querySelector('.nav-tabs');
        const scrollAmount = 200; // Adjust this value as needed

        if (direction === 'left') {
            tabList.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        } else {
            tabList.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
    }

    // Check if scroll buttons should be visible
    function checkScroll() {
        const tabList = document.querySelector('.nav-tabs');
        const scrollButtons = document.querySelectorAll('.scroll-button');
        
        if (tabList.scrollWidth > tabList.clientWidth) {
            scrollButtons.forEach(button => button.style.display = 'block');
        } else {
            scrollButtons.forEach(button => button.style.display = 'none');
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        checkScroll();
        window.addEventListener('resize', checkScroll);
    });
</script>


                    @if(
                           !empty(getFeaturesSettings("frontend_coupons_display_type")) and
                           getFeaturesSettings("frontend_coupons_display_type") == "after_content" and
                           !empty($instructorDiscounts) and
                           count($instructorDiscounts)
                       )
                        @foreach($instructorDiscounts as $instructorDiscount)
                            @include('web.default.includes.discounts.instructor_discounts_card', ['discount' => $instructorDiscount, 'instructorDiscountClassName' => "mt-35"])
                        @endforeach
                    @endif

                </div>
            </div>

            <div class="course-content-sidebar col-12 col-lg-4 mt-25 mt-lg-0">
                <div class="rounded-lg shadow-sm">
                    <div class="course-img {{ $course->video_demo ? 'has-video' :'' }}">

                        <img src="{{ $course->getImage() }}" class="img-cover" alt="">

                        @if($course->video_demo)
                            <div id="webinarDemoVideoBtn"
                                 data-video-path="{{ $course->video_demo_source == 'upload' ?  url($course->video_demo) : $course->video_demo }}"
                                 data-video-source="{{ $course->video_demo_source }}"
                                 class="course-video-icon cursor-pointer d-flex align-items-center justify-content-center">
                                <i data-feather="play" width="25" height="25"></i>
                            </div>
                        @endif
                    </div>

                    <div class="px-20 pb-30">
                        <form action="/cart/store" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="item_id" value="{{ $course->id }}">
                            <input type="hidden" name="item_name" value="webinar_id">
                            @if(!empty($course->tickets))
                                @foreach($course->tickets as $ticket)
                                    <div class="form-check mt-20">
                                        <input class="form-check-input" @if(!$ticket->isValid()) disabled @endif type="radio"
                                               data-discount-price="{{ handleCoursePagePrice($ticket->getPriceWithDiscount($course->price, !empty($activeSpecialOffer) ? $activeSpecialOffer : null))['price'] }}"
                                               value="{{ ($ticket->isValid()) ? $ticket->id : '' }}"
                                               name="ticket_id"
                                               id="courseOff{{ $ticket->id }}">
                                        <label class="form-check-label d-flex flex-column cursor-pointer" for="courseOff{{ $ticket->id }}">
                                            <span class="font-16 font-weight-500 text-dark-blue">{{ $ticket->title }} @if(!empty($ticket->discount))
                                                    ({{ $ticket->discount }}% {{ trans('public.off') }})
                                                @endif</span>
                                            <span class="font-14 text-gray">{{ $ticket->getSubTitle() }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            @endif

                            @if($course->price > 0)
                                <div id="priceBox" class="d-flex align-items-center justify-content-center mt-20 {{ !empty($activeSpecialOffer) ? ' flex-column ' : '' }}">
                                    <div class="text-center">
                                       @php
                                            $realPrice = handleCoursePagePrice($course->price);
                                        
                                            $realPriceDisplay = preg_replace('/[^\d.,]/', '', $realPrice['price']) . getBranchCurrency(4);
                                        
                                        @endphp
                                        
                                        <span id="realPrice" data-value="{{ $course->price }}"
                                              data-special-offer="{{ !empty($activeSpecialOffer) ? $activeSpecialOffer->percent : ''}}"
                                              class="d-block @if(!empty($activeSpecialOffer)) font-16 text-gray text-decoration-line-through @else font-30 text-primary @endif">
                                            {{ $realPriceDisplay }}
                                        </span>


                                        @if(!empty($realPrice['tax']) and empty($activeSpecialOffer))
                                            <span class="d-block font-14 text-gray">+ {{ $realPrice['tax'] }} {{ trans('cart.tax') }}</span>
                                        @endif
                                    </div>

                                    @if(!empty($activeSpecialOffer))
                                        <div class="text-center">
                                            @php
                                                $priceWithDiscount = handleCoursePagePrice($course->getPrice());
                                            @endphp
                                            <span id="priceWithDiscount"
                                                  class="d-block font-30 text-primary">
                                                {{ $priceWithDiscount['price'] }}
                                            </span>

                                            @if(!empty($priceWithDiscount['tax']))
                                                <span class="d-block font-14 text-gray">+ {{ $priceWithDiscount['tax'] }} {{ trans('cart.tax') }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="d-flex align-items-center justify-content-center mt-20">
                                    
                                     @if(!in_array($course->type,['text_lesson','course','webinar']))
                                    <span class="font-36 text-primary">{{ trans('public.free') }}</span>
                                    @endif
                                </div>
                            @endif

                            @php
                                $canSale = ($course->canSale() and !$hasBought);
                                $authUserJoinedWaitlist = false;

                                if (!empty($authUser)) {
                                    $authUserWaitlist = $course->waitlists()->where('user_id', $authUser->id)->first();
                                    $authUserJoinedWaitlist = !empty($authUserWaitlist);
                                }
                            @endphp

                            <div class="mt-20 d-flex flex-column">
                                @if($course->type=='text_lesson' && !empty($course->details) && !$hasBought)
                                
                                  <a href="/ar/course/details/egy/{{ $course->slug }}"  type="button" class="btn btn-primary">
                                      {{ trans('public.Register') }}
                                       
                                    </a>
                                    
                                    
                                    
                                 @elseif($course->type=='course')
                                 
                                 @if(app()->getLocale()!='en')
  <a href="{{route('request_course',['slug'=>$course->slug])}}"  type="button" class="btn btn-primary">
                                      {{ trans('public.Request Course') }}
                                       
                                    </a>
                                    @else
                                      <a href="{{route('request_course_en',['slug'=>$course->slug])}}"  type="button" class="btn btn-primary">
                                      {{ trans('public.Request Course') }}
                                       
                                    </a>
                                    
                                    @endif
                                    
                                
                                
                                
                                @elseif(!$canSale and $course->canJoinToWaitlist())
                                    <button type="button" data-slug="{{ $course->slug }}" class="btn btn-primary {{ (!$authUserJoinedWaitlist) ? ((!empty($authUser)) ? 'js-join-waitlist-user' : 'js-join-waitlist-guest') : 'disabled' }}" {{ $authUserJoinedWaitlist ? 'disabled' : '' }}>
                                        @if($authUserJoinedWaitlist)
                                            {{ trans('update.already_joined') }}
                                        @else
                                            {{ trans('update.join_waitlist') }}
                                        @endif
                                    </button>
                                @elseif($hasBought or !empty($course->getInstallmentOrder()))
                                    <a href="{{ $course->getLearningPageUrl() }}" class="btn btn-primary">{{ trans('update.go_to_learning_page') }}</a>
                                @elseif(!empty($course->price) and $course->price > 0)
                                    <button type="button" class="btn btn-primary {{ $canSale ? 'js-course-add-to-cart-btn' : ($course->cantSaleStatus($hasBought) .' disabled ') }}">
                                        @if(!$canSale)
                                            @if($course->checkCapacityReached())
                                                {{ trans('update.capacity_reached') }}
                                            @else
                                                {{ trans('update.disabled_add_to_cart') }}
                                            @endif
                                        @else
                                            {{ trans('public.add_to_cart') }}
                                        @endif
                                    </button>

                                    @if($canSale and !empty($course->points))
                                        <a href="{{ !(auth()->check()) ? '/egy/login' : '#' }}" class="{{ (auth()->check()) ? 'js-buy-with-point' : '' }} btn btn-outline-warning mt-20 {{ (!$canSale) ? 'disabled' : '' }}" rel="nofollow">
                                            {!! trans('update.buy_with_n_points',['points' => $course->points]) !!}
                                        </a>
                                    @endif

                                    @if($canSale and !empty(getFeaturesSettings('direct_classes_payment_button_status')))
                                        <button type="button" class="btn btn-outline-danger mt-20 js-course-direct-payment">
                                            {{ trans('update.buy_now') }}
                                        </button>
                                    @endif

                                    @if(!empty($installments) and count($installments) and getInstallmentsSettings('display_installment_button'))
                                        <a href="/course/{{ $course->slug }}/installments" class="btn btn-outline-primary mt-20">
                                            {{ trans('update.pay_with_installments') }}
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ $canSale ? '/course/'. $course->slug .'/free' : '#' }}" class="btn btn-primary {{ (!$canSale) ? (' disabled ' . $course->cantSaleStatus($hasBought)) : '' }}">
                                        @if(!$canSale)
                                            @if($course->checkCapacityReached())
                                                {{ trans('update.capacity_reached') }}
                                            @else
                                                {{ trans('public.disabled') }}
                                            @endif
                                        @else
                                            {{ trans('public.enroll_on_webinar') }}
                                        @endif
                                    </a>
                                @endif

                                @if($canSale and $course->subscribe)
                                    <a href="/subscribes/apply/{{ $course->slug }}" class="btn btn-outline-primary btn-subscribe mt-20 @if(!$canSale) disabled @endif">{{ trans('public.subscribe') }}</a>
                                @endif

                            </div>

                        </form>

                        @if(!empty(getOthersPersonalizationSettings('show_guarantee_text')) and getOthersPersonalizationSettings('show_guarantee_text'))
                            <div class="mt-20 d-flex align-items-center justify-content-center text-gray">
                                <i data-feather="thumbs-up" width="20" height="20"></i>
                                <span class="ml-5 font-14">{{ trans('product.guarantee_text') }}</span>
                            </div>
                        @endif

                        <div class="mt-35">
                          {{--  <strong class="d-block text-secondary font-weight-bold">{{ trans('webinars.this_webinar_includes') }}</strong>--}}
                            @if($course->isDownloadable())
                                <div class="mt-20 d-flex align-items-center text-gray">
                                    <i data-feather="download-cloud" width="20" height="20"></i>
                                    <span class="ml-5 font-14 font-weight-500">{{ trans('webinars.downloadable_content') }}</span>
                                </div>
                            @endif

                            @if($course->certificate or ($course->quizzes->where('certificate', 1)->count() > 0))
                                <div class="mt-20 d-flex align-items-center text-gray">
                                    <i data-feather="award" width="20" height="20"></i>
                                    <span class="ml-5 font-14 font-weight-500">{{ trans('webinars.official_certificate') }}</span>
                                </div>
                            @endif

                            @if($course->quizzes->where('status', \App\models\Quiz::ACTIVE)->count() > 0)
                                <div class="mt-20 d-flex align-items-center text-gray">
                                    <i data-feather="file-text" width="20" height="20"></i>
                                    <span class="ml-5 font-14 font-weight-500">{{ trans('webinars.online_quizzes_count',['quiz_count' => $course->quizzes->where('status', \App\models\Quiz::ACTIVE)->count()]) }}</span>
                                </div>
                            @endif

                            @if($course->support)
                                <div class="mt-20 d-flex align-items-center text-gray">
                                    <i data-feather="headphones" width="20" height="20"></i>
                                    <span class="ml-5 font-14 font-weight-500">{{ trans('webinars.instructor_support') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-40 p-10 rounded-sm border row align-items-center favorites-share-box">
                            @if($course->isWebinar())
                                <div class="col">
                                    <a href="{{ $course->addToCalendarLink() }}" target="_blank" class="d-flex flex-column align-items-center text-center text-gray">
                                        <i data-feather="calendar" width="20" height="20"></i>
                                        <span class="font-12">{{ trans('public.reminder') }}</span>
                                    </a>
                                </div>
                            @endif

                            <div class="col">
                                <a href="/favorites/{{ $course->slug }}/toggle" id="favoriteToggle" class="d-flex flex-column align-items-center text-gray">
                                    <i data-feather="heart" class="{{ !empty($isFavorite) ? 'favorite-active' : '' }}" width="20" height="20"></i>
                                    <span class="font-12">{{ trans('panel.favorite') }}</span>
                                </a>
                            </div>

                            <div class="col">
                                <a href="#" class="js-share-course d-flex flex-column align-items-center text-gray">
                                    <i data-feather="share-2" width="20" height="20"></i>
                                    <span class="font-12">{{ trans('public.share') }}</span>
                                </a>
                            </div>
                        </div>

                        {{--<div class="mt-30 text-center">
                            <button type="button" id="webinarReportBtn" class="font-14 text-gray btn-transparent">{{ trans('webinars.report_this_webinar') }}</button>
                        </div>--}}
                    </div>
                </div>

                {{-- Cashback Alert --}}
                @include('web.default.includes.cashback_alert',['itemPrice' => $course->price])

                {{-- Gift Card --}}
             {{--   @if($course->canSale() and !empty(getGiftsGeneralSettings('status')) and !empty(getGiftsGeneralSettings('allow_sending_gift_for_courses')))
                    <a href="/gift/course/{{ $course->slug }}" class="d-flex align-items-center mt-30 rounded-lg border p-15">
                        <div class="size-40 d-flex-center rounded-circle bg-gray200">
                            <i data-feather="gift" class="text-gray" width="20" height="20"></i>
                        </div>
                        <div class="ml-5">
                            <h4 class="font-14 font-weight-bold text-gray">{{ trans('update.gift_this_course') }}</h4>
                            <p class="font-12 text-gray">{{ trans('update.gift_this_course_hint') }}</p>
                        </div>
                    </a>
                @endif
                --}}

                @if($course->teacher->offline)
                  {{--  <div class="rounded-lg shadow-sm mt-35 d-flex">
                        <div class="offline-icon offline-icon-left d-flex align-items-stretch">
                            <div class="d-flex align-items-center">
                                <img src="/assets/default/img/profile/time-icon.png" alt="offline">
                            </div>
                        </div>

                        <div class="p-15">
                            <h3 class="font-16 text-dark-blue">{{ trans('public.instructor_is_not_available') }}</h3>
                            <p class="font-14 font-weight-500 text-gray mt-15">{{ $course->teacher->offline_message }}</p>
                        </div>
                    </div>--}}
                @endif

 

                {{-- organization --}}
                @if($course->creator_id != $course->teacher_id)
                    @include('web.default.course.sidebar_instructor_profile', ['courseTeacher' => $course->creator])
                @endif
                {{-- teacher --}}
               {{-- @include('web.default.course.sidebar_instructor_profile', ['courseTeacher' => $course->teacher])--}}

                @if($course->webinarPartnerTeacher->count() > 0)
                  <!--  @foreach($course->webinarPartnerTeacher as $webinarPartnerTeacher)
                        @include('web.default.course.sidebar_instructor_profile', ['courseTeacher' => $webinarPartnerTeacher->teacher])
                    @endforeach-->
                @endif
                {{-- ./ teacher --}}

                {{-- tags --}}
                @if($course->tags->count() > 0)
                    <div class="rounded-lg tags-card shadow-sm mt-35 px-25 py-20">
                        <h3 class="sidebar-title font-16 text-secondary font-weight-bold">{{ trans('public.tags') }}</h3>

                        <div class="d-flex flex-wrap mt-10">
                            @foreach($course->tags as $tag)
                                <a href="/tags/courses/{{ urlencode($tag->title) }}" class="tag-item bg-gray200 p-5 font-14 text-gray font-weight-500 rounded">{{ $tag->title }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
                {{-- ads --}}
               <!-- @if(!empty($advertisingBannersSidebar) and count($advertisingBannersSidebar))
                    <div class="row">
                        @foreach($advertisingBannersSidebar as $sidebarBanner)
                            <div class="rounded-lg sidebar-ads mt-35 col-{{ $sidebarBanner->size }}">
                                <a href="{{ $sidebarBanner->link }}">
                                    <img src="{{ $sidebarBanner->image }}" class="img-cover rounded-lg" alt="{{ $sidebarBanner->title }}">
                                </a>
                            </div>
                        @endforeach
                    </div>

                @endif-->
            </div>
        </div>

        {{-- Ads Bannaer --}}
     <!--   @if(!empty($advertisingBanners) and count($advertisingBanners))
            <div class="mt-30 mt-md-50">
                <div class="row">
                    @foreach($advertisingBanners as $banner)
                        <div class="col-{{ $banner->size }}">
                            <a href="{{ $banner->link }}">
                                <img src="{{ $banner->image }}" class="img-cover rounded-sm" alt="{{ $banner->title }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif-->
        {{-- ./ Ads Bannaer --}}
    </section>
    
    {{-- @php
    
    $latestWebinars=\App\Models\Webinar::where('status', 'active')->where('add_to_more', 1)->where('id','!=',$course->id)->get();
    @endphp
       @if ($latestWebinars->isNotEmpty()) {

      <section class="home-sections home-sections-swiper container">
                <div class="d-flex justify-content-between ">
                    <div>
                        <h2 class="section-title">{{ trans('public.Courses that may interest you') }}</h2>
                    </div>

                </div>

                <div class="mt-10 position-relative">
                    <div class="swiper-container latest-webinars-swiper px-12">
                        <div class="swiper-wrapper py-20">
                           @foreach($latestWebinars as $latestWebinar)

                                <div class="swiper-slide">
                                    @include('web.default.includes.webinar.grid-card',['webinar' => $latestWebinar])
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination latest-webinars-swiper-pagination"></div>
                    </div>
                </div>
            </section>
    @endif --}}

    <div id="webinarReportModal" class="d-none">
        <h3 class="section-title after-line font-20 text-dark-blue">{{ trans('product.report_the_course') }}</h3>

        <form action="/course/{{ $course->id }}/report" method="post" class="mt-25">

            <div class="form-group">
                <label class="text-dark-blue font-14">{{ trans('product.reason') }}</label>
                <select id="reason" name="reason" class="form-control">
                    <option value="" selected disabled>{{ trans('product.select_reason') }}</option>

                    @foreach(getReportReasons() as $reason)
                        <option value="{{ $reason }}">{{ $reason }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label class="text-dark-blue font-14" for="message_to_reviewer">{{ trans('public.message_to_reviewer') }}</label>
                <textarea name="message" id="message_to_reviewer" class="form-control" rows="10"></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <p class="text-gray font-16">{{ trans('product.report_modal_hint') }}</p>

            <div class="mt-30 d-flex align-items-center justify-content-end">
                <button type="button" class="js-course-report-submit btn btn-sm btn-primary">{{ trans('panel.report') }}</button>
                <button type="button" class="btn btn-sm btn-danger ml-10 close-swl">{{ trans('public.close') }}</button>
            </div>
        </form>
    </div>

    @include('web.default.course.share_modal_egy')
    @include('web.default.course.buy_with_point_modal')
@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/time-counter-down.min.js"></script>
    <script src="/assets/default/vendors/barrating/jquery.barrating.min.js"></script>
    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/assets/default/vendors/video/youtube.min.js"></script>
    <script src="/assets/default/vendors/video/vimeo.js"></script>
  <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
    <script src="/assets/default/vendors/parallax/parallax.min.js"></script>
    <script src="/assets/default/js/parts/home.min.js"></script>
    <script>
        var webinarDemoLang = '{{ trans('webinars.webinar_demo') }}';
        var replyLang = '{{ trans('panel.reply') }}';
        var closeLang = '{{ trans('public.close') }}';
        var saveLang = '{{ trans('public.save') }}';
        var reportLang = '{{ trans('panel.report') }}';
        var reportSuccessLang = '{{ trans('panel.report_success') }}';
        var reportFailLang = '{{ trans('panel.report_fail') }}';
        var messageToReviewerLang = '{{ trans('public.message_to_reviewer') }}';
        var copyLang = '{{ trans('public.copy') }}';
        var copiedLang = '{{ trans('public.copied') }}';
        var learningToggleLangSuccess = '{{ trans('public.course_learning_change_status_success') }}';
        var learningToggleLangError = '{{ trans('public.course_learning_change_status_error') }}';
        var notLoginToastTitleLang = '{{ trans('public.not_login_toast_lang') }}';
        var notLoginToastMsgLang = '{{ trans('public.not_login_toast_msg_lang') }}';
        var notAccessToastTitleLang = '{{ trans('public.not_access_toast_lang') }}';
        var notAccessToastMsgLang = '{{ trans('public.not_access_toast_msg_lang') }}';
        var canNotTryAgainQuizToastTitleLang = '{{ trans('public.can_not_try_again_quiz_toast_lang') }}';
        var canNotTryAgainQuizToastMsgLang = '{{ trans('public.can_not_try_again_quiz_toast_msg_lang') }}';
        var canNotDownloadCertificateToastTitleLang = '{{ trans('public.can_not_download_certificate_toast_lang') }}';
        var canNotDownloadCertificateToastMsgLang = '{{ trans('public.can_not_download_certificate_toast_msg_lang') }}';
        var sessionFinishedToastTitleLang = '{{ trans('public.session_finished_toast_title_lang') }}';
        var sessionFinishedToastMsgLang = '{{ trans('public.session_finished_toast_msg_lang') }}';
        var sequenceContentErrorModalTitle = '{{ trans('update.sequence_content_error_modal_title') }}';
        var courseHasBoughtStatusToastTitleLang = '{{ trans('cart.fail_purchase') }}';
        var courseHasBoughtStatusToastMsgLang = '{{ trans('site.you_bought_webinar') }}';
        var courseNotCapacityStatusToastTitleLang = '{{ trans('public.request_failed') }}';
        var courseNotCapacityStatusToastMsgLang = '{{ trans('cart.course_not_capacity') }}';
        var courseHasStartedStatusToastTitleLang = '{{ trans('cart.fail_purchase') }}';
        var courseHasStartedStatusToastMsgLang = '{{ trans('update.class_has_started') }}';
        var joinCourseWaitlistLang = '{{ trans('update.join_course_waitlist') }}';
        var joinCourseWaitlistModalHintLang = "{{ trans('update.join_course_waitlist_modal_hint') }}";
        var joinLang = '{{ trans('footer.join') }}';
        var nameLang = '{{ trans('auth.name') }}';
        var emailLang = '{{ trans('auth.email') }}';
        var phoneLang = '{{ trans('public.phone') }}';
        var captchaLang = '{{ trans('site.captcha') }}';
    </script>

    <script src="/assets/default/js/parts/comment.min.js"></script>
    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
    <script src="/assets/default/js/parts/webinar_show.min.js"></script>


    @if(!empty($course->creator) and !empty($course->creator->getLiveChatJsCode()) and !empty(getFeaturesSettings('show_live_chat_widget')))
        <script>
            (function () {
                "use strict"

                {!! $course->creator->getLiveChatJsCode() !!}
            })(jQuery)
        </script>
    @endif
@endpush
