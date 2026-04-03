@php
    // Force English for branch_id = 3
    if (Auth::check() && Auth::user()->branch_id == 3) {
        App::setLocale('en');
    }
@endphp

@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')

@endpush

@section('content')
<style>


.title-section {
    margin-bottom: 10px;
}

.quizzfile-section {
   width: 450px;
    text-align: right;
    display: block;
    position: relative;
    left: 15rem;
    top: 1rem;
}

.file-link {
    display: inline-flex;
    align-items: center;
    color: #0056b3;
    text-decoration: none;
    word-break: break-word;
}

.file-link:hover {
    text-decoration: underline;
}


a.file-link {
    font-size: 14px;
    font-weight: 600;
    font-family: sans-serif;
    color: #1c971c;
}

@media (max-width: 768px) {
   
    a.file-link {
        font-size: 13px;
            min-width: 200px;
    }
    
    .quizzfile-section {
min-width: 300px;
    /* text-align: right; */
    /* display: block; */
    position: relative;
   
    
}
.file-item.mb-2 {
    min-width: 350px;
}
.webinar-card .webinar-card-body .webinar-title {
    height: 48px;
    min-width: 250px;
    text-overflow: ellipsis;
    overflow: hidden;
    margin-bottom:10px;
}
.file-item {
  
}
}
</style>
 @if(!$authUser->hasExams())
    <section>
        <h2 class="section-title">{{ trans('panel.my_activity') }}</h2>

        <div class="activities-container mt-25 p-20 p-lg-35">
            <div class="row">
                <div class="col-4 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/webinars.svg" width="64" height="64" alt="">
                        <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ $purchasedCount }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('panel.purchased') }}</span>
                    </div>
                </div>

                <div class="col-4 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/hours.svg" width="64" height="64" alt="">
                       
                        <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ $hours }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('public.days') }}</span>
                        
                        
                      
                    </div>
                </div>

                <div class="col-4 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/upcoming.svg" width="64" height="64" alt="">
                        <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ $upComing }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('panel.upcoming') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endif

    <section class="mt-25">
        <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row">
            <h2 class="section-title">
                 @if(!$authUser->hasExams())
                {{ trans('panel.my_purchases') }}
                @else
                 {{ trans('/admin/main.exams') }}
                @endif
                </h2>
        </div>

        @if(!empty($sales) and !$sales->isEmpty())
            @foreach($sales as $sale)
                @php
                    $item = !empty($sale->webinar) ? $sale->webinar : $sale->bundle;

                    $lastSession = !empty($sale->webinar) ? $sale->webinar->lastSession() : null;
                    $nextSession = !empty($sale->webinar) ? $sale->webinar->nextSession() : null;
                    $isProgressing = false;

                    if(!empty($sale->webinar) and $sale->webinar->start_date <= time() and !empty($lastSession) and $lastSession->date > time()) {
                        $isProgressing = true;
                    }
                @endphp

                @if(!empty($item))
                    <div class="row mt-30">
                        <div class="col-12">
                            <div class="webinar-card webinar-list d-flex">
                                <div class="image-box">
                                    <img src="{{ $item->getImage() }}" class="img-cover" alt="">

                                    @if(!empty($sale->webinar))
                                        <div class="badges-lists">
                                            @if($item->type == 'webinar')
                                                @if($item->start_date > time())
                                                    <span class="badge badge-primary">{{  trans('panel.not_conducted') }}</span>
                                                @elseif($item->isProgressing())
                                                    <span class="badge badge-secondary">{{ trans('webinars.in_progress') }}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ trans('public.finished') }}</span>
                                                @endif
                                            @elseif(!empty($item->downloadable))
                                                <span class="badge badge-secondary">{{ trans('home.downloadable') }}</span>
                                                
                                                    @elseif($item->type=='exam')
                                                    
                                          <span class="badge badge-secondary">  {{ trans('/admin/main.exam') }}</span>
                                          
                                           @elseif($item->type=='text_lesson')
                                                    
                                          <span class="badge badge-secondary">  {{ trans('/admin/main.text_courses') }}</span>
                                          

                                            @else 
                                                <span class="badge badge-secondary">{{ trans('webinars.'.$item->type) }}</span>
                                            @endif
                                        </div>

                                        @php
                                            $percent = $item->getProgress();

                                            if($item->isWebinar()){
                                                if($item->isProgressing()) {
                                                    $progressTitle = trans('public.course_learning_passed',['percent' => $percent]);
                                                } else {
                                                    $progressTitle = $item->sales_count .'/'. $item->capacity .' '. trans('quiz.students');
                                                }
                                            } else {
                                                   $progressTitle = trans('public.course_learning_passed',['percent' => $percent]);
                                            }
                                        @endphp

                                        @if(!empty($sale->gift_id) and $sale->buyer_id == $authUser->id)
                                            {{--  --}}
                                        @else
                                            <div class="progress cursor-pointer" data-toggle="tooltip" data-placement="top" title="{{ $progressTitle }}">
                                                <span class="progress-bar" style="width: {{ $percent }}%"></span>
                                            </div>
                                        @endif
                                    @else
                                        <div class="badges-lists">
                                            <span class="badge badge-secondary">{{ trans('update.bundle') }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="webinar-card-body w-100 d-flex flex-column">
                                    <div class="d-flex align-items-center justify-content-between">
                                         @if($item->type=='exam' && $item->quizzes && $item->quizzes->count() > 0)
                                         <a href="/panel/quizzes/{{$item->quizzes->first()->id}}/start">
                                            <h3 class="webinar-title font-weight-bold font-16 text-dark-blue">
                                                {{ $item->title }}
                                                
                                                </h3>
                                                </a>
                  <div class="quizzfile-section mt-3">
                @if(!empty($item->quizzes->first()->quizz_file))
                    @foreach(explode(',', $item->quizzes->first()->quizz_file) as $file)
                        <div class="file-item">
                            <a href="/store/{{ $file}}" target="_blank" class="file-link">
                                <i class="fa fa-file me-2"></i>
                                <span>{{ basename($file) }}</span>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
       
                                                
                                         
                                         
                                         @else
                                        <a href="{{ $item->getUrl() }}">
                                            <h3 class="webinar-title font-weight-bold font-16 text-dark-blue">
                                                {{ $item->title }}

                                                @if(!empty($item->access_days))
                                                    @if(!$item->checkHasExpiredAccessDays($sale->created_at, $sale->gift_id))
                                                        <span class="badge badge-outlined-danger ml-10">{{ trans('update.access_days_expired') }}</span>
                                                    @else
                                                        <span class="badge badge-outlined-warning ml-10">{{ trans('update.expired_on_date',['date' => dateTimeFormat($item->getExpiredAccessDays($sale->created_at, $sale->gift_id),'j M Y')]) }}</span>
                                                    @endif
                                                @endif

                                                @if($sale->payment_method == \App\Models\Sale::$subscribe and $sale->checkExpiredPurchaseWithSubscribe($sale->buyer_id, $item->id, !empty($sale->webinar) ? 'webinar_id' : 'bundle_id'))
                                                    <span class="badge badge-outlined-danger ml-10">{{ trans('update.subscribe_expired') }}</span>
                                                @endif

                                              {{--  @if(!empty($sale->webinar))
                                                    <span class="badge badge-dark ml-10 status-badge-dark">{{ trans('webinars.'.$item->type) }}</span>
                                                @endif
                                                --}}

                                                @if(!empty($sale->gift_id))
                                                    <span class="badge badge-primary ml-10">{{ trans('update.gift') }}</span>
                                                @endif
                                            </h3>
                                        </a>
                                        @endif

                                        <div class="btn-group dropdown table-actions">
                                            <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i data-feather="more-vertical" height="20"></i>
                                            </button>

                                            <div class="dropdown-menu">
                                                @if(!empty($sale->gift_id) and $sale->buyer_id == $authUser->id)
                                                    <a href="/panel/webinars/{{ $item->id }}/sale/{{ $sale->id }}/invoice" target="_blank" class="webinar-actions d-block mt-10">{{ trans('public.invoice') }}</a>
                                                @else
                                                    @if(!empty($item->access_days) and !$item->checkHasExpiredAccessDays($sale->created_at, $sale->gift_id))
                                                        <a href="{{ $item->getUrl() }}" target="_blank" class="webinar-actions d-block mt-10">{{ trans('update.enroll_on_course') }}</a>
                                                    @elseif(!empty($sale->webinar))
                                                    
                                                    @if($item->type=='exam' && $item->quizzes && $item->quizzes->count() > 0)
                                             <a href="/panel/quizzes/{{$item->quizzes->first()->id}}/start" target="_blank" class="webinar-actions d-block">صفحة الاختبار</a>

                                                    @else
                                                        <a href="{{ $item->getLearningPageUrl() }}" target="_blank" class="webinar-actions d-block">{{ trans('update.learning_page') }}</a>
                                                          @endif

                                                        @if(!empty($item->start_date) and ($item->start_date > time() or ($item->isProgressing() and !empty($nextSession))))
                                                            <button type="button" data-webinar-id="{{ $item->id }}" class="join-purchase-webinar webinar-actions btn-transparent d-block mt-10">{{ trans('footer.join') }}</button>
                                                        @endif

                                                        @if(!empty($item->downloadable) or (!empty($item->files) and count($item->files)))
                                                            <a href="{{ $item->getUrl() }}?tab=content" target="_blank" class="webinar-actions d-block mt-10">{{ trans('home.download') }}</a>
                                                        @endif

                                                        @if($item->price > 0)
                                                            <a href="/panel/webinars/{{ $item->id }}/sale/{{ $sale->id }}/invoice" target="_blank" class="webinar-actions d-block mt-10">{{ trans('public.invoice') }}</a>
                                                        @endif
                                                    @endif
                                                     @if(!$authUser->hasExams())

                                                    <a href="{{ $item->getUrl() }}?tab=reviews" target="_blank" class="webinar-actions d-block mt-10">{{ trans('public.feedback') }}</a>
                                                @endif
                                                   @endif
                                            </div>
                                        </div>
                                    </div>
                                      @php
                                     $price=0;
                                  @endphp
                                    @include(getTemplate() . '.includes.webinar.rate',['rate' => $item->getRate()])
                                      @if(!$authUser->hasExams())
                                    <div class="webinar-price-box mt-15">
                                        @if($item->price > 0)
                                            @if($item->bestTicket() < $item->price)
                                                <span class="real">{{ handlePrice($item->bestTicket(), true, true, false, null, true) }}</span>
                                                <span class="off ml-10">{{ handlePrice($item->price, true, true, false, null, true) }}</span>
                                            @else
                                                <span class="real">{{ handlePrice($item->price, true, true, false, null, true) }}</span>
                                            @endif
                                        @else
                                        
                                      @php
    $price = 0;

    if (!empty($sale) && !empty($sale->order) && !empty($sale->order->orderItems)) {
        $orderItems = json_decode($sale->order->orderItems, true);

        if (is_array($orderItems) && isset($orderItems[0]['details'])) {
            $details = json_decode($orderItems[0]['details'], true);

            if (is_array($details) && isset($details['price'])) {
                $price = $details['price'];
            }
        }
    }
@endphp

                                        
                                            <span class="real">
                                                @if(isset($price) && $price>0)
                                                
                                                {{handlePrice($price, true, true, false, null, true) }}
                                                @else
                                                {{ trans('public.free') }}
                                                
                                                @endif
                                                </span>
                                        @endif
                                    </div>

                                    
                                    <div class="d-flex align-items-center justify-content-between flex-wrap mt-auto">

                                        @if(!empty($sale->gift_id) and $sale->buyer_id == $authUser->id)
                                            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                <span class="stat-title">{{ trans('update.gift_status') }}:</span>

                                                @if(!empty($sale->gift_date) and $sale->gift_date > time())
                                                    <span class="stat-value text-warning">{{ trans('public.pending') }}</span>
                                                @else
                                                    <span class="stat-value text-primary">{{ trans('update.sent') }}</span>
                                                @endif
                                            </div>
                                        @else
                                            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                <span class="stat-title">{{ trans('public.item_id') }}:</span>
                                                <span class="stat-value">{{ $item->id }}</span>
                                            </div>
                                        @endif

                                        @if(!empty($sale->gift_id))
                                            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                <span class="stat-title">{{ trans('update.gift_receive_date') }}:</span>
                                                <span class="stat-value">{{ (!empty($sale->gift_date)) ? dateTimeFormat($sale->gift_date, 'j M Y H:i') : trans('update.instantly') }}</span>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                <span class="stat-title">{{ trans('public.category') }}:</span>
                                                <span class="stat-value">{{ !empty($item->category_id) ? $item->category->title : '' }}</span>
                                            </div>
                                        @endif

                                        @if(!empty($sale->webinar) and $item->type == 'webinar')
                                            @if($item->isProgressing() and !empty($nextSession))
                                                <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                    <span class="stat-title">{{ trans('webinars.next_session_duration') }}:</span>
                                                    <span class="stat-value">{{ convertMinutesToHourAndMinute($nextSession->duration) }} Hrs</span>
                                                </div>

                                                <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                    <span class="stat-title">{{ trans('webinars.next_session_start_date') }}:</span>
                                                    <span class="stat-value">{{ dateTimeFormat($nextSession->date,'j M Y') }}</span>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                     @if(!empty($sale->webinar) and in_array($item->type,['course','text_lesson']))
                                                      <span class="stat-title">{{ trans('public.duration') }}:</span>
                                                    <span class="stat-value">{{ $item->duration}}{{ trans('public.days') }}</span>
                                                     @else
                                                    <span class="stat-title">{{ trans('public.duration') }}:</span>
                                                    <span class="stat-value">{{ convertMinutesToHourAndMinute($item->duration) }} Hrs</span>
                                                    
                                                    @endif
                                                </div>
                                                
                                                

                                                <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                    <span class="stat-title">{{ trans('public.start_date') }}:</span>
                                                    <span class="stat-value">{{ dateTimeFormat($item->start_date,'j M Y') }}</span>
                                                </div>
                                            @endif
                                        @elseif(!empty($sale->bundle))
                                            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                <span class="stat-title">{{ trans('public.duration') }}:</span>
                                                <span class="stat-value">{{ convertMinutesToHourAndMinute($item->getBundleDuration()) }} Hrs</span>
                                            </div>
                                        @endif

                                        @if(!empty($sale->gift_id) and $sale->buyer_id == $authUser->id)
                                            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                <span class="stat-title">{{ trans('update.receipt') }}:</span>
                                                <span class="stat-value">{{ $sale->gift_recipient }}</span>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                <span class="stat-title">{{ trans('public.instructor') }}:</span>
                                                <span class="stat-value">{{ $item->teacher->full_name }}</span>
                                            </div>
                                        @endif

                                        @if(!empty($sale->gift_id) and $sale->buyer_id != $authUser->id)
                                            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                <span class="stat-title">{{ trans('update.gift_sender') }}:</span>
                                                <span class="stat-value">{{ $sale->gift_sender }}</span>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                <span class="stat-title">{{ trans('panel.purchase_date') }}:</span>
                                                <span class="stat-value">{{ dateTimeFormat($sale->created_at,'j M Y') }}</span>
                                            </div>
                                        @endif

                                    </div>
                                    
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
           @php
    $user = auth()->user();
    $url = '/classes?sort=newest';

    if ($user->branch_id == 3) {
        $url = '/en/canada' . $url;
    }elseif ($user->branch_id == 4) {
        $url = '/ar/egy' . $url;
    }elseif ($user->branch_id == 2) {
        $url = '/ar/uae' . $url;
    }
@endphp

@include(getTemplate() . '.includes.no-result', [
    'file_name' => 'student.png',
    'title' => trans('panel.no_result_purchases'),
    'hint' => trans('panel.no_result_purchases_hint'),
    'btn' => [
        'url' => $url,
        'text' => trans('panel.start_learning')
    ]
])

        @endif
    </section>

    <div class="my-30">
        {{ $sales->appends(request()->input())->links('vendor.pagination.panel') }}
    </div>

    @include('web.default.panel.webinar.join_webinar_modal')
@endsection

@push('scripts_bottom')
    <script>
        var undefinedActiveSessionLang = '{{ trans('webinars.undefined_active_session') }}';
    </script>

    <script src="/assets/default/js/panel/join_webinar.min.js"></script>
@endpush
