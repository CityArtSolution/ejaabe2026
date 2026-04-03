<style>
.corse-imge{
    transition: transform 0.5s ease;
}
.corse-imge:hover{
    transform: scale(1.05) rotate(2deg);
}
/* ====== الكاتيجوري ====== */
.webinar-card-body span {
  color: #475569;
  font-size: 0.9rem;
}

.webinar-card-body span a {
  color: #2563eb;
  font-weight: 600;
  text-decoration: underline;
  transition: color 0.3s ease;
}

.webinar-card-body span a:hover {
  color: #0ea5e9;
}
</style>
<div class="webinar-card webinar-list webinar-list-2 mt-30" style="max-width: 370px;">
    <div class="image-box" style="overflow: hidden;">
        <div class="badges-lists">
            @if($webinar->bestTicket() < $webinar->price)
                <span class="badge badge-danger">{{ trans('public.offer',['off' => $webinar->bestTicket(true)['percent']]) }}</span>
            @elseif(empty($isFeature) and !empty($webinar->feature))
                <span class="badge badge-warning">{{ trans('home.featured') }}</span>
            @elseif($webinar->type == 'webinar')
                @if($webinar->start_date > time())
                    <span class="badge badge-primary">{{  trans('panel.not_conducted') }}</span>
                @elseif($webinar->isProgressing())
                    <span class="badge badge-secondary">{{ trans('webinars.in_progress') }}</span>
                @else
                    <span class="badge badge-secondary">{{ trans('public.finished') }}</span>
                @endif
            @else
               {{-- <span class="badge badge-primary">{{ trans('webinars.'.$webinar->type) }}</span>--}}
            @endif
        </div>

        <a href="{{ $webinar->getUrl() }}/egy">
            <img src="{{ $webinar->getImage() }}" class="img-cover corse-imge" style="border-radius: 24px 24px 0 0;" alt="{{ $webinar->title }}">
        </a>

        <div class="progress-and-bell d-flex align-items-center">
            @if($webinar->type == 'webinar')
                <a href="{{ $webinar->addToCalendarLink() }}" target="_blank" class="webinar-notify d-flex align-items-center justify-content-center">
                    <i data-feather="bell" width="20" height="20" class="webinar-icon"></i>
                </a>
            @endif

            @if($webinar->type == 'webinar')
                <div class="progress ml-10">
                    <span class="progress-bar" style="width: {{ $webinar->getProgress() }}%"></span>
                </div>
            @endif
        </div>
    </div>
    <div class="webinar-card-body w-100 d-flex flex-column">
        <div style="text-align: center;">
            <a href="{{ $webinar->getUrl() . '/egy' }}">
                <h1 class="mt-15 webinar-title font-weight-bold font-16 text-dark-blue" style="font-size: 18px;">{{ clean($webinar->title,'title') }}</h1>
            </a>
        </div>
        @if(!empty($webinar->category))
            <span class="d-block font-14 mt-10" style="text-align: right;">{{ trans('public.in') }} <a href="/{{app()->getLocale()}}/egy{{ $webinar->category->getUrl() }}" target="_blank" class="text-decoration-underline">{{ $webinar->category->title }}</a></span>
        @endif
        @include(getTemplate() . '.includes.webinar.rate',['rate' => $webinar->getRate()])
        <div class="d-flex justify-content-between mt-auto">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center">                    
                     @if(in_array($webinar->type,['text_lesson','course']))
                                         <i data-feather="clock" width="20" height="20" class="webinar-icon"></i>

                                <span class="duration ml-5 font-14">{{ !empty($webinar->duration) ? $webinar->duration : 0 }} {{ trans('public.days') }}</span>
                                @else
                                                    <i data-feather="clock" width="20" height="20" class="webinar-icon"></i>
                    <span class="duration ml-5 font-14">{{ convertMinutesToHourAndMinute($webinar->duration) }} {{ trans('home.hours') }}</span>
                                @endif
                </div>

                <div class="vertical-line h-25 mx-15"></div>

               {{-- <div class="d-flex align-items-center">
                    <i data-feather="calendar" width="20" height="20" class="webinar-icon"></i>
                    <span class="date-published ml-5 font-14">{{ dateTimeFormat(!empty($webinar->start_date) ? $webinar->start_date : $webinar->created_at,'j M Y') }}</span>
                </div>--}}
            </div>

            <div class="webinar-price-box" style="position: absolute;background: #ffffff;padding: 7px;width: 16%;text-align: center;top: 5px;right: 6px;border-radius: 66px;">
                @if(!empty($webinar->price) and $webinar->price > 0)
                    @if($webinar->bestTicket() < $webinar->price)
                        <span class="off" style="font-size: 12px;color:green">{{ handlePrice($webinar->price, false, true, false, null, true) }} {{getBranchCurrency(4)}}</span>
                        <span class="real" style="font-size: 12px;color:green">{{ handlePrice($webinar->bestTicket(), false, true, false, null, true) }} {{getBranchCurrency(4)}}</span>
                    @else
                        <span class="real" style="font-size: 12px;color:green">{{ handlePrice($webinar->price, false, true, false, null, true) }} {{getBranchCurrency(4)}}</span>
                    @endif
                @else
                  @if($webinar->type!='text_lesson')
                    <span class="real" style="font-size: 14px;">{{ trans('public.free') }}</span>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
