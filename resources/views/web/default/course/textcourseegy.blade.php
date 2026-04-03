@extends(getTemplate().'.layouts.egy_app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/css/css-stars.css">
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
    <style>
.tax-infoo {
    background-color: #666a6e;
    color: yellow;
    font-size: 15px;
    line-height: 1.5;
    padding: 10px;
    max-width: 300px;
    text-align: inherit;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}
.accordion {
  --bs-accordion-color: var(--bs-body-color);
  --bs-accordion-bg: var(--bs-body-bg);
  --bs-accordion-transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, border-radius 0.15s ease;
  --bs-accordion-border-color: var(--bs-border-color);
  --bs-accordion-border-width: var(--bs-border-width);
  --bs-accordion-border-radius: var(--bs-border-radius);
  --bs-accordion-inner-border-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
  --bs-accordion-btn-padding-x: 1.25rem;
  --bs-accordion-btn-padding-y: 1rem;
  --bs-accordion-btn-color: var(--bs-body-color);
  --bs-accordion-btn-bg: var(--bs-accordion-bg);
  --bs-accordion-btn-icon: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none' stroke='%23212529' stroke-linecap='round' stroke-linejoin='round'%3e%3cpath d='M2 5L8 11L14 5'/%3e%3c/svg%3e");
  --bs-accordion-btn-icon-width: 1.25rem;
  --bs-accordion-btn-icon-transform: rotate(-180deg);
  --bs-accordion-btn-icon-transition: transform 0.2s ease-in-out;
  --bs-accordion-btn-active-icon: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none' stroke='%23052c65' stroke-linecap='round' stroke-linejoin='round'%3e%3cpath d='M2 5L8 11L14 5'/%3e%3c/svg%3e");
  --bs-accordion-btn-focus-box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
  --bs-accordion-body-padding-x: 1.25rem;
  --bs-accordion-body-padding-y: 1rem;
  --bs-accordion-active-color: var(--bs-primary-text-emphasis);
  --bs-accordion-active-bg: var(--bs-primary-bg-subtle);
}

.accordion-button {
  position: relative;
  display: flex;
  align-items: center;
  width: 100%;
  padding: var(--bs-accordion-btn-padding-y) var(--bs-accordion-btn-padding-x);
  font-size: 1rem;
  color: var(--bs-accordion-btn-color);
  text-align: left;
  background-color: var(--bs-accordion-btn-bg);
  border: 0;
  border-radius: 0;
  overflow-anchor: none;
  transition: var(--bs-accordion-transition);
}

@media (prefers-reduced-motion: reduce) {
  .accordion-button {
    transition: none;
  }
}

.accordion-button:not(.collapsed) {
  color: var(--bs-accordion-active-color);
  background-color: var(--bs-accordion-active-bg);
  box-shadow: inset 0 calc(-1 * var(--bs-accordion-border-width)) 0 var(--bs-accordion-border-color);
}

.accordion-button:not(.collapsed)::after {
  background-image: var(--bs-accordion-btn-active-icon);
  transform: var(--bs-accordion-btn-icon-transform);
}

.accordion-button::after {
  flex-shrink: 0;
  width: var(--bs-accordion-btn-icon-width);
  height: var(--bs-accordion-btn-icon-width);
  margin-left: auto;
  content: "";
  background-image: var(--bs-accordion-btn-icon);
  background-repeat: no-repeat;
  background-size: var(--bs-accordion-btn-icon-width);
  transition: var(--bs-accordion-btn-icon-transition);
}

@media (prefers-reduced-motion: reduce) {
  .accordion-button::after {
    transition: none;
  }
}

.accordion-button:hover {
  z-index: 2;
}

.accordion-button:focus {
  z-index: 3;
  outline: 0;
  box-shadow: var(--bs-accordion-btn-focus-box-shadow);
}

.accordion-header {
  margin-bottom: 0;
}

.accordion-item {
  color: var(--bs-accordion-color);
  background-color: var(--bs-accordion-bg);
  border: var(--bs-accordion-border-width) solid var(--bs-accordion-border-color);
}

.accordion-item:first-of-type {
  border-top-left-radius: var(--bs-accordion-border-radius);
  border-top-right-radius: var(--bs-accordion-border-radius);
}

.accordion-item:first-of-type > .accordion-header .accordion-button {
  border-top-left-radius: var(--bs-accordion-inner-border-radius);
  border-top-right-radius: var(--bs-accordion-inner-border-radius);
}

.accordion-item:not(:first-of-type) {
  border-top: 0;
}

.accordion-item:last-of-type {
  border-bottom-right-radius: var(--bs-accordion-border-radius);
  border-bottom-left-radius: var(--bs-accordion-border-radius);
}

.accordion-item:last-of-type > .accordion-header .accordion-button.collapsed {
  border-bottom-right-radius: var(--bs-accordion-inner-border-radius);
  border-bottom-left-radius: var(--bs-accordion-inner-border-radius);
}

.accordion-item:last-of-type > .accordion-collapse {
  border-bottom-right-radius: var(--bs-accordion-border-radius);
  border-bottom-left-radius: var(--bs-accordion-border-radius);
}

.accordion-body {
  padding: var(--bs-accordion-body-padding-y) var(--bs-accordion-body-padding-x);
}

.accordion-flush > .accordion-item {
  border-right: 0;
  border-left: 0;
  border-radius: 0;
}

.accordion-flush > .accordion-item:first-child {
  border-top: 0;
}

.accordion-flush > .accordion-item:last-child {
  border-bottom: 0;
}

.accordion-flush > .accordion-item > .accordion-header .accordion-button,
.accordion-flush > .accordion-item > .accordion-header .accordion-button.collapsed {
  border-radius: 0;
}

.accordion-flush > .accordion-item > .accordion-collapse {
  border-radius: 0;
}

[data-bs-theme=dark] .accordion-button::after {
  --bs-accordion-btn-icon: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%236ea8fe'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
  --bs-accordion-btn-active-icon: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%236ea8fe'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

.course-content-section {
    position: relative;
    top: auto;
    margin-bottom: -50px;
}
                            .mt-35, .my-35 {
    margin-top: 10rem !important;
}
[dir="rtl"] .accordion-button {
    text-align: right;
    padding-left: 2.25rem; /* Adjust padding for RTL */
}

[dir="rtl"] .accordion-button::after {
    margin-right: 0;
    margin-left: auto; /* Move arrow to the left */
    left: 1rem; /* Position arrow on the left */
    right: auto;
}

/* Accordion Arrow Styling */
.accordion-button::after {
    content: '';
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23212529'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-size: 1.25rem;
    transition: transform 0.2s ease-in-out;
    width: 1.25rem;
    height: 1.25rem;
    position: absolute;
}

.accordion-button:not(.collapsed)::after {
    transform: rotate(-180deg);
}
                            .accordion-button::after {
                                filter: brightness(0) invert(1);
                            }
                            
                            .accordion-button:not(.collapsed) {
                                background-color: #1363a1 !important;
                                color: #fff !important;
                            }
                            
                            .accordion-button:focus {
                                box-shadow: none;
                                border-color: #1363a1;
                            }
                            
                            .accordion-button:not(.collapsed)::after {
                                filter: brightness(0) invert(1);
                            }
                            
                            .accordion-button:hover {
                                background-color: #1363a1 !important;
                                color: #fff !important;
                            }
@media only screen and (min-width:1024px) {


.course-content-body.user-select-none {
    margin-top: -78px;
}


}

.original-price {
    text-decoration: line-through;
    color: red;
    font-family: sans-serif;
       
}

.discounted-price {
    color: green;
    font-family: sans-serif;
     padding: 3px;
}
.custom{
    
 font-family: sans-serif;
}
thead {
    background: #9cc0d9;
}
        </style>
@endpush


@section('content')
    <section class="course-cover-container not-active-special-offer">
        <img src="{{ $course->getImageCover() }}" class="img-cover course-cover-img" alt="{{ $course->title }}"/>     
    </section>

    @php
        $percent = $course->getProgress();
    @endphp

    <section class="container course-content-section">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="course-content-body user-select-none">
                    <div class="course-body-on-cover text-white">
                        <h1 class="font-30 course-title">
                            {{ $course->title }}
                        </h1>
                        {{--@if($course->approval_logo)
                            <div class="d-flex align-items-center">
       <span class="ml-10 mt-15 font-14" style="color:#000">اعتماد</span>
                           <img src="{{$course->approval_logo}}" height="120px">
                            
                        </div>
                        @endif--}}
                    </div>
                    <div class="course-content-sidebar">
                        <div class="accordion" id="courseAccordion" dir="rtl">
                            @if (isset($course->sections) && !empty($course->sections))
                                @foreach (json_decode($course->sections) as $key => $item)
                                    <div class="accordion-item  border border-[#1363a1]">
                                        <h2 class="accordion-header" id="heading{{ $key }}">
                                            <button class="accordion-button collapsed" 
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#collapse{{ $key }}" 
                                                    aria-expanded="false" 
                                                    aria-controls="collapse{{ $key }}"
                                                    style="background-color: #1363a1; color: #fff;">
                                                {{ $item->title }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $key }}" 
                                             class="accordion-collapse collapse" 
                                             aria-labelledby="heading{{ $key }}" 
                                             data-bs-parent="#courseAccordion">
                                            <div class="accordion-body">
                                                {!! $item->detail !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                             <!-- Additional Content Accordion Item -->
    <div class="accordion-item mb-2 border border-[#1363a1]">
        <h2 class="accordion-header" id="headingContent">
            <button class="accordion-button collapsed" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapseContent" 
                    aria-expanded="false" 
                    aria-controls="collapseContent"
                    style="background-color: #1363a1; color: #fff;">
                 {{ trans('public.content') }} 
            </button>
        </h2>
        <div id="collapseContent" 
             class="accordion-collapse collapse" 
             aria-labelledby="headingContent" 
             data-bs-parent="#courseAccordion">
            <div class="accordion-body">
                @include(getTemplate().'.course.tabs.content')
            </div>
        </div>
    </div>


                        </div>
                        
                      
                       

                    </div>
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
                </div>
            </div>
            <div class="col-md-12">
                <div class="px-20 pb-30">
                    <form action="/cart/store" method="post" id="courseForm">
                        {{ csrf_field() }}
                        <input type="hidden" name="item_id" value="{{ $course->id }}">
                        <input type="hidden" name="item_name" value="webinar_id">
                        <h3 class="_h3">{{trans('public.Course Information')}} </h3>
                        <br>
                            <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th> {{trans('public.Date')}}</th>
                                     <th> {{trans('public.Time')}}</th>
                                    <th style="width:11rem;text-align: center;">{{trans('public.Price')}}
                                    <br>
                                    {{trans('public.egy')}}
                                    
                                    </th>
                                    <th>{{trans('public.Location')}}</th>
                                    <th>{{trans('public.Language')}} </th>
         
                                    <th>{{trans('public.Duration')}}&nbsp;({{trans('public.Days')}})</th>
                                    <th>{{trans('public.Select')}} </th>
         
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($course->details))
                                    @foreach(json_decode($course->details, true) as $item)
                                        <tr>
                                        @php
                                            try {
                                                $formattedDate = \Carbon\Carbon::parse($item['date'])->translatedFormat('j F Y'); // مثال: 5 يونيو 2025
                                            } catch (\Exception $e) {
                                                $formattedDate = $item['date']; // fallback لو في خطأ
                                            }
                                        @endphp
                                            <td class="custom">{{ $formattedDate }}</td>
                                            @if(!empty($item['start_time']))
                                                <td class="custom">{{ $item['start_time'] ?? "" }}-{{ $item['end_time'] ?? "" }}</td>
                                            @else
                                                <td><p align="center"><strong>---</strong></p></td>
                                            @endif 
                                            <td>
                                            @php
                                                $discountedPrice=$item['price'];
                                            @endphp
                                            @if(!empty($course->discount_rate) && $course->discount_rate > 0)
                                                <!-- Display original price with strikethrough and red color -->
                                                <span class="original-price">
                                                    {{   number_format($discountedPrice) }}
                                                </span>
                                                <!-- Calculate and display the discounted price -->
                                                @php
                                                    $discountedPrice = $item['price'] - ($item['price'] * ($course->discount_rate / 100));
                                                @endphp
                                                <span class="discounted-price">
                                                    {{ number_format($discountedPrice, 2) }} <!-- Format to 2 decimal places -->
                                                </span>
                                            @else
                                              
                                                {{  number_format($discountedPrice) }}
                                            @endif
                                            </td>
                                            @if(!empty($item['location']))
                                                <td>{{ $item['location'] ?? "" }}</td>
                                            @else
                                                <td><p align="center"><strong>-</strong></p></td>
                                            @endif
                                            <td>
                                                @if ($item['lang'] === 'AR')
                                                    {{ trans('public.Arabic') }}
                                                @elseif ($item['lang'] === 'EN')
                                                    {{ trans('public.English') }}
                                                @else
                                                    {{ trans('public.Bilanguage') }}
                                                @endif
                                            </td>
                                            <td class="custom">{{ $item['ndays'] }}</td>
                                            <td>
                                                @php
                                                    $isExpired = \Carbon\Carbon::parse($item['date'])->isPast();
                                                @endphp
                                                <input type="radio" name="selectedCourse" required 
                                                    data-date="{{$item['date']}}"
                                                    data-time="{{$item['start_time']}}-{{$item['end_time']}}"
                                                    data-price="{{$discountedPrice}}"
                                                    data-location="{{$item['location']}}"
                                                    data-lang="{{$item['lang']}}"
                                                    data-days="{{$item['ndays']}}"
                                                    {{ $isExpired ? 'disabled' : '' }}>
                                            </td>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                            </div>

                            <input type="hidden" name="selectedCourseDate" id="selectedCourseDate">
                            <input type="hidden" name="selectedCourseTime" id="selectedCourseTime">
        
                       <input type="hidden" name="selectedCoursePrice" id="selectedCoursePrice">
                       <input type="hidden" name="selectedCourseLocation" id="selectedCourseLocation">
                       <input type="hidden" name="selectedCourseLangs" id="selectedCourseLangs">
                       <input type="hidden" name="selectedCourseDays" id="selectedCourseDays">
        
        
        <br>
                           
                       <div class="row">
                           <div class="col-md-6">
                           
                           <p class="tax-infoo">
                            {{__('public.VAT')}}<br> {{__('public.Tax Identification Number:')}} 310501241600003
                           </p>
                           
                         
                           <br>
        
                       
                       <script>
                      document.addEventListener('DOMContentLoaded', function() {
    var radios = document.querySelectorAll('input[name="selectedCourse"]');
    
    radios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.checked) {
                // Get values from data attributes
                var courseDate = this.getAttribute('data-date');
                var courseTime = this.getAttribute('data-time');
                var coursePrice = this.getAttribute('data-price');
                var courseLocation = this.getAttribute('data-location');
                var courseLang = this.getAttribute('data-lang');
                var courseDays = this.getAttribute('data-days');

                // Convert language code to full text
                var languageText = '';
                if (courseLang === 'AR') {
                    languageText = '{{ trans('public.Arabic') }}';
                } else if (courseLang === 'EN') {
                    languageText = '{{ trans('public.English') }}';
                } else {
                    languageText = '{{ trans('public.Bilanguage') }}';
                }

                // Remove any non-numeric characters and round the price
                var priceValue = coursePrice.replace(/[^0-9.]/g, "");
                var roundedPrice = Math.round(parseFloat(priceValue));

                // Set values to hidden inputs
                document.getElementById('selectedCourseDate').value = courseDate;
                document.getElementById('selectedCourseTime').value = courseTime;
                document.getElementById('selectedCoursePrice').value = roundedPrice;
                document.getElementById('selectedCourseLocation').value = courseLocation;
                document.getElementById('selectedCourseLangs').value = languageText;
                document.getElementById('selectedCourseDays').value = courseDays;
            }
        });
    });
});
        
           </script> 
                                                   
        
                           </div>
                       </div>
                         


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

                        @php
                            $canSale = ($course->canSale() and !$hasBought);
                            $authUserJoinedWaitlist = false;

                            if (!empty($authUser)) {
                                $authUserWaitlist = $course->waitlists()->where('user_id', $authUser->id)->first();
                                $authUserJoinedWaitlist = !empty($authUserWaitlist);
                            }
                        @endphp

                        <div class="mt-20 d-flex flex-column">
                            @if(!$canSale and $course->canJoinToWaitlist())
                                <button type="button" data-slug="{{ $course->slug }}" class="btn btn-primary {{ (!$authUserJoinedWaitlist) ? ((!empty($authUser)) ? 'js-join-waitlist-user' : 'js-join-waitlist-guest') : 'disabled' }}" {{ $authUserJoinedWaitlist ? 'disabled' : '' }}>
                                    @if($authUserJoinedWaitlist)
                                        {{ trans('update.already_joined') }}
                                    @else
                                        {{ trans('update.join_waitlist') }}
                                    @endif
                                </button>
                            @elseif($hasBought or !empty($course->getInstallmentOrder()))
                            @if($course->type!='text_lesson')
                                <a href="{{ $course->getLearningPageUrl() }}" class="btn btn-primary">{{ trans('update.go_to_learning_page') }}</a>
                               @endif
                                @elseif((!empty($course->price) && $course->price > 0) || (!empty($course->details) && collect(json_decode($course->details))->pluck('price')->filter()->isNotEmpty()))   
                                  <button type="button" id="registerButton" class="btn btn-primary">
                                    @if(!$canSale)
                                        @if($course->checkCapacityReached())
                                            {{ trans('update.capacity_reached') }}
                                        @else
                                            {{ trans('update.disabled_add_to_cart') }}
                                        @endif
                                    @else
                                        {{ trans('public.Register') }}
                                    @endif
                                </button>

                                @if($canSale and !empty($course->points))
                                    <a href="{{ !(auth()->check()) ? '/egy/login' : '#' }}" class="{{ (auth()->check()) ? 'js-buy-with-point' : '' }} btn btn-outline-warning mt-20 {{ (!$canSale) ? 'disabled' : '' }}" rel="nofollow">
                                        {!! trans('update.buy_with_n_points',['points' => $course->points]) !!}
                                    </a>
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
                        </div>
                    </form>
                </div>     
           </div>
        </div>

        {{-- ./ Ads Bannaer --}}
    </section>

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

    @include('web.default.course.share_modal')
    @include('web.default.course.buy_with_point_modal')
@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/time-counter-down.min.js"></script>
    <script src="/assets/default/vendors/barrating/jquery.barrating.min.js"></script>
    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/assets/default/vendors/video/youtube.min.js"></script>
    <script src="/assets/default/vendors/video/vimeo.js"></script>

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




    @if(!empty($course->creator) and !empty($course->creator->getLiveChatJsCode()) and !empty(getFeaturesSettings('show_live_chat_widget')))
        <script>
            (function () {
                "use strict"

                {!! $course->creator->getLiveChatJsCode() !!}
            })(jQuery)
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var registerButton = document.getElementById('registerButton');
    var radios = document.querySelectorAll('input[name="selectedCourse"]');

    registerButton.addEventListener('click', function(event) {
        var isChecked = false;
        radios.forEach(function(radio) {
            if (radio.checked) {
                isChecked = true;
            }
        });

        if (!isChecked) {
            alert('Please select a course option before registering.');
             return;
            
        } else {
            // If a course is selected, proceed with the button's action
            // For example, you can submit the form programmatically:
        @if(auth()->check())
            document.getElementById('courseForm').submit();
        @else
            window.location.href = '/egy/login';
        @endif
        }
    });
});
</script>
@endpush
