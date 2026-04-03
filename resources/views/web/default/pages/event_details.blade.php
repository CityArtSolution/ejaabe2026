@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/css/css-stars.css">
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.8.0/build/css/intlTelInput.css">

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.8.0/build/js/intlTelInput.min.js"></script>
    <style>
        .course-description p {
    color: #000;
    font-family: 'GE-Dinar-Two' !important;
}
.fa-map-marker-alt {
    padding-left: 5px;
}
.far fa-calendar-alt {
    padding-right: 5px;
}
i.far.fa-calendar-alt.text-white.mr-8 {
    padding-left: 5px;
}
i.fas.fa-map-marker-alt.text-white.mr-8 {
    padding-right: 5px;
}
.x-gap-50>* {
    padding-right: 25px;
    padding-left: 25px;
}
div#seconds {
    color: #faaa4b;
    font-size:30px;
}
div#days {
   
    font-size:30px;
}
div#hours {
   
    font-size:30px;
}
div#minutes {
   
    font-size:30px;
}
.upcoming-course-body-on-cover {
    height: auto;
}

  .iti {
        position: relative;
        display: initial !important;
    }
    .iti--allow-dropdown .iti__country-container {
    right: auto !important;
    left: 0 !important;
    direction: inherit;
}
.iti__country-container {
    position: absolute;
    top: 20px;
}
input#phone {
    padding-right: 2px !important;
    text-align: right;
}
.course-img {
    visibility: hidden;
}
    .location-title {
        font-size: 18px;
        color: #0066cc;
        margin-bottom: 10px;
    }

    .location-text {
        font-size: 16px;
        color: #333;
    }

    .fas.fa-map-marker-alt {
        color: #0066cc;
    }
     .event-info {
        background-color: #f8f9fa;
        border-left: 4px solid #0066cc;
        padding: 20px;
        border-radius: 4px;
        margin-top: 30px;
    }

    .date-time-info, .location-info {
        margin-bottom: 15px;
    }

    .info-title {
        font-size: 14px;
        color: #0066cc;
        margin-bottom: 5px;
    }

    .info-text {
        font-size: 16px;
        color: #333;
    }

    .far.fa-calendar-alt, .far.fa-clock, .fas.fa-map-marker-alt {
        color: #0066cc;
    }
    .course-description {
    color: #000;
    line-height: 28px;
}
  .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%;
        color: #dc3545;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    /* Modal overlay */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 999;
    }
    </style>
@endpush
@php
    use Carbon\Carbon;

    // Assuming $event->start_date contains the target date in a valid format (e.g., 'Y-m-d')
    // and $event->time contains the time in a format like 'h:i A'
    $now = Carbon::now();

    // Combine date and time to create a full datetime
    $targetDateTime = Carbon::parse($event->start_date . ' ' . $event->time);
    $targetTimestamp = $targetDateTime->timestamp; // Get the timestamp

    // Remaining time calculations for initial load
    $diff = $now->diff($targetDateTime);
    $remainingDays = $diff->days;
    $remainingHours = $diff->h;
    $remainingMinutes = $diff->i;
    $remainingSeconds = $diff->s;
@endphp

@section('content')
    <section class="course-cover-container bg-gray200">
        <img src="{{ !empty($event) ? $event->image: '' }}" class="img-cover course-cover-img" alt="{{ $event->title ?? '' }}"/>
    </section>

    <section class="container course-content-section">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="course-content-body user-select-none">
                    <div class="upcoming-course-body-on-cover d-flex flex-column text-white pb-15">
                      <h1 class="font-30" style="color: #fff; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
    {{ clean($event->title, 't') ?? "" }}
</h1>

<div class="mt-30 d-flex align-items-center">
                                <div class="flex-grow-1 shadow-xs rounded-sm">
                                   <div class="d-flex align-items-center text-14 mb-10">
    <i class="far fa-calendar-alt text-white mr-8"></i>
    <div class="text-white-p">{{ $event->start_date }}</div>
    
     <i class="fas fa-map-marker-alt text-white mr-8"></i>
    <div class="text-white-p">{{ $event->location }}</div>
</div>
                                </div>
                                
                        
                             
                            </div>
                       


                       <div class="mt-auto">
                          
                                <div class="d-flex align-items-center mt-40">
                                   
                                       
                           
                                          
    <div data-anim="slide-up delay-2">
    <div class="d-flex x-gap-50 pt-12 pb-12 px-20" 
         style="background-color: rgba(0, 0, 0, 0.7); 
                border-radius: 10px; 
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5); 
                margin: 2px; 
                padding: 20px;">
        
        <!-- Days -->
        <div class="text-white text-center">
            <div id="days" class="text-50 lh-12 fw-700">{{ $remainingDays }}</div>
            <div class="text-16 mt-5">{{ trans('events.days') }}</div>
        </div>

        <!-- Hours -->
        <div class="text-white text-center">
            <div id="hours" class="text-50 lh-12 fw-700">{{ $remainingHours }}</div>
            <div class="text-16 mt-5">{{ trans('events.hours') }}</div>
        </div>

        <!-- Minutes -->
        <div class="text-white text-center">
            <div id="minutes" class="text-50 lh-12 fw-700">{{ $remainingMinutes }}</div>
            <div class="text-16 mt-5">{{ trans('events.minutes') }}</div>
        </div>

        <!-- Seconds -->
        <div class="text-white text-center">
            <div id="seconds" class="text-50 lh-12 fw-700">{{ $remainingSeconds }}</div>
            <div class="text-16 mt-5">{{ trans('events.seconds') }}</div>
        </div>
    </div>
</div>
                                       

                               
                                    
                                </div>
                           
                        </div>
                    </div>
                    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
                     <div class="mt-20">
        <h2 class="section-title after-line">{{ trans('events.About Event') }}</h2>
        <div class="mt-15 course-description">
           {!! $event->details !!}
        </div>
    </div>
    
    
        <div class="event-info mt-20">
    <div class="date-time-info">
        <h5 class="info-title">
            <i class="far fa-calendar-alt mr-2"></i> {{__('events.Date')}}
        </h5>
        <p class="info-text">
            @if($event->start_date == $event->end_date)
                {{ $event->start_date}}
            @else
                {{ $event->start_date}} - 
                {{$event->end_date }}
            @endif
        </p>
    </div>

    <div class="date-time-info mt-10">
        <h5 class="info-title">
            <i class="far fa-clock mr-2"></i> {{__('events.Time')}}
        </h5>
        <p class="info-text">
            {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
        </p>
    </div>

    <div class="location-info mt-10">
        <h5 class="info-title">
            <i class="fas fa-map-marker-alt mr-2"></i> {{__('events.Location')}}
        </h5>
        <p class="info-text">
            @if(is_array($event->location))
                {{ app()->getLocale() == 'ar' ? $event->location['ar'] : $event->location['en'] }}
            @else
                {{ $event->location }}
            @endif
        </p>
    </div>
</div>
        
     <div class="mt-20">
                    @if(!empty($event->what_you_will_learn))
                        <h4 class="tsection-title">{{__('events.What you will learn')}}</h4>
                        <div class="row x-gap-100 justfiy-between">
                            
                        @foreach(json_decode($event->what_you_will_learn) as $learn)
                            <div class="col-md-12">
                                <div class="y-gap-20">

                                    <div class="d-flex items-center">
                                    
                                        <div class="d-flex justify-center items-center border-light rounded-full size-20 mr-10">
                                            <i class="ti-check text-6"></i>
                                        </div>
                                        <p>{!! $learn  !!}</p>
                                        
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                     @else
                       
                     @endif
                    </div>
                    
                    
                      <div class="mt-20">
                    @if(!empty($event->event_content))
                        <h4 class="text-20">{{__('events.Event Content')}}</h4>
                        <ul>
                        @foreach(json_decode($event->event_content) as $content)
                     </br>
                        <li>{{ $content }}</li>
                        @endforeach
                        </ul>
                    @else
                        
                    @endif
                    </div>

                    
                </div>
            </div>
 <form action="/cart/store" method="post" id="eventForm">
                        {{ csrf_field() }}
                        <input type="hidden" name="item_id" value="{{ $event->id }}">
                        <input type="hidden" name="item_name" value="event_id">
</form>
            <div class="course-content-sidebar col-12 col-lg-4 mt-25 mt-lg-0">
              
                  <div class="course-img">

                        <img src="{{ $event->image }}" class="img-cover" alt="event">

                       
                    </div>
                    
                   <div class="px-20 pb-30">
    @if($event->start_date >= now())
    @if(!empty($event->price) and $event->price > 0)
     <button type="button" class="btn btn-primary  btn-block mt-20" id="registerButton">
                                        
                                            {{ trans('public.add_to_cart') }}
                                
    </button>
    @else
        <button type="button" id="webinarReportBtn" class="js-follow-upcoming-course btn btn-primary btn-block mt-20">
            {{ trans('public.register') }}
        </button>
    @endif
     @endif
</div>

                <div class="rounded-lg shadow-sm mt-35 px-25" style="height:160px">

                    <div class="mt-30">
                    

                      <div class="mt-40 p-10 rounded-sm border row align-items-center favorites-share-box">
                            @if(!empty($event->start_date))
                                <div class="col">
                                    <a href="{{ $event->addToCalendarLink() }}" target="_blank" class="d-flex flex-column align-items-center text-center text-gray">
                                        <i data-feather="calendar" width="20" height="20"></i>
                                        <span class="font-12">{{ trans('public.reminder') }}</span>
                                    </a>
                                </div>
                            @endif


                           
                        </div>

                   
                      

                        @if(!empty($event->number_of_places))
                            <div class="mt-20 d-flex align-items-center justify-content-between text-gray">
                                <div class="d-flex align-items-center">
                                    <i data-feather="users" width="20" height="20"></i>
                                    <span class="ml-5 font-14 font-weight-500">{{ trans('events.number_of_places') }}:</span>
                                </div>
                                <span class="font-14">{{ $event->number_of_places }}</span>
                            </div>
                        @endif

                          

                        <div class="mt-20 d-flex align-items-center justify-content-between text-gray">
                            <div class="d-flex align-items-center">
                                <i data-feather="tag" width="20" height="20"></i>
                                <span class="ml-5 font-14 font-weight-500">{{ trans('public.price') }}:</span>
                            </div>
                            <span class="font-14">{{ (!empty($event->price) and $event->price > 0) ? handlePrice($event->price) : trans('public.free') }}</span>
                            
                      
                        </div>
                     


                    </div>
                </div>

             

               

              
            </div>
        </div>

       
    </section>

    <div id="webinarReportModal" class="d-none">
        <h3 class="section-title after-line font-20 text-dark-blue">{{ trans('public.Register') }}-{{$event->title ?? ""}}</h3>

    <form action="{{ route('event.register') }}" method="POST" class="mt-25">
             @csrf
            <div class="form-group">

                <div class="invalid-feedback"></div>
            </div>

         <input type="hidden" name="event_id" value="{{ $event->id }}">
            <div class="form-group">
                <label for="name"  class="text-dark-blue font-14">{{__('public.name')}}</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="phone">{{__('public.phone')}}</label>
                <input type="tel" class="form-control"  id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="email" class="text-dark-blue font-14">{{__('public.email')}}</label>
                <input type="email" class="form-control"  id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="company"  class="text-dark-blue font-14">{{__('events.Company')}}</label>
                <input type="text"  class="form-control" id="company" name="company">
            </div>
            <div class="form-group">
                <label for="notes"  class="text-dark-blue font-14">{{__('events.Notes')}}</label>
                <textarea id="notes" name="notes" class="form-control"></textarea>
            <div class="mt-30 d-flex align-items-center justify-content-end">
            <button type="submit" class="btn btn-sm btn-primary">{{ trans('public.Register') }}</button>
                <button type="button" class="btn btn-sm btn-danger ml-10 close-swl">{{ trans('public.close') }}</button>
            </div>
        </form>
    </div>
    </div>

@endsection

@push('scripts_bottom')
   
 <script src="/assets/default/js/parts/comment.min.js"></script>
    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
    <script src="/assets/default/js/parts/upcoming_course_show.min.js"></script>

    <script src="/assets/default/js/parts/comment.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
var input = document.querySelector("#phone");

var iti = window.intlTelInput(input, {
   separateDialCode: true,
   initialCountry: "auto",
   //onlyCountries: ["sa","qa","ae","kw","bh","om"],
   geoIpLookup: function(callback) {
       fetch('https://ipapi.co/json/')
           .then(res => res.json())
           .then(data => callback(data.country_code))
           .catch(() => callback("sa")); // Default to Saudi Arabia if detection fails
   },
   utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.3/build/js/utils.js"
});

// Function to update the input with the full phone number
function updatePhoneNumber() {
   var countryData = iti.getSelectedCountryData();
   var countryCode = countryData.dialCode;
   var phoneNumber = input.value.replace(/[^\d]/g, ''); // Remove non-digit characters
   
   // Only add country code if it's not already there
   if (!phoneNumber.startsWith(countryCode)) {
       phoneNumber = countryCode + phoneNumber;
   }
   
   // Update the input value
   input.value = phoneNumber;
}

// Update phone number on blur
input.addEventListener('blur', updatePhoneNumber);

// Update phone number when country changes
input.addEventListener('countrychange', function() {
   // Clear the input when country changes to avoid confusion
   input.value = '';
});
});

                   </script>
          <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Set the target timestamp from PHP
        const targetTimestamp = {{ $targetTimestamp }};

        function updateCountdown() {
            const now = Math.floor(Date.now() / 1000); // Current time in seconds
            const remainingTime = targetTimestamp - now;

            if (remainingTime < 0) {
                // Event has started
                document.getElementById('days').textContent = '0';
                document.getElementById('hours').textContent = '0';
                document.getElementById('minutes').textContent = '0';
                document.getElementById('seconds').textContent = '0';
                clearInterval(countdownInterval);
                return;
            }

            const days = Math.floor(remainingTime / (60 * 60 * 24));
            const hours = Math.floor((remainingTime % (60 * 60 * 24)) / (60 * 60));
            const minutes = Math.floor((remainingTime % (60 * 60)) / 60);
            const seconds = remainingTime % 60;

            // Update the HTML elements
            document.getElementById('days').textContent = days;
            document.getElementById('hours').textContent = hours;
            document.getElementById('minutes').textContent = minutes;
            document.getElementById('seconds').textContent = seconds;
        }

        // Update the countdown every second
        const countdownInterval = setInterval(updateCountdown, 1000);
        // Initial call to display countdown immediately
        updateCountdown();
    });
</script>
<script>
<script>
document.getElementById('openWebinarModal').addEventListener('click', function() {
    document.getElementById('webinarReportModal').classList.remove('d-none');
});

document.querySelector('.close-swl').addEventListener('click', function() {
    document.getElementById('webinarReportModal').classList.add('d-none');
});


</script>
<script>
    $(document).ready(function () {
        $('body').on('click', '.close-swl', function () {
            // Remove the 'loadingbar' and 'primary' classes from the #webinarReportBtn button
            $('#webinarReportBtn').removeClass('loadingbar primary');

            // Re-enable the #webinarReportBtn button
            $('#webinarReportBtn').prop('disabled', false);
        });
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var registerButton = document.getElementById('registerButton');
    registerButton.addEventListener('click', function(event) {
            // If a course is selected, proceed with the button's action
            // For example, you can submit the form programmatically:
            document.getElementById('eventForm').submit();
    });
        
    });

</script>

@endpush
