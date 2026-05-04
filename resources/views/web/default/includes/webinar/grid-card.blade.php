<div class="webinar-card">
    <figure>
        <div class="image-box">
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
                @elseif(!empty($webinar->type))
                    {{--<span class="badge badge-primary">{{ trans('webinars.'.$webinar->type) }}</span>--}}
                @endif

                @include('web.default.includes.product_custom_badge', ['itemTarget' => $webinar])
            </div>

            <a href="{{ $webinar->getUrl() }}">
                <img src="{{ $webinar->getImage() }}" class="img-cover" alt="{{ $webinar->title }}">
            </a>


            @if($webinar->checkShowProgress())
                <div class="progress">
                    <span class="progress-bar" style="width: {{ $webinar->getProgress() }}%"></span>
                </div>
            @endif

            @if($webinar->type == 'webinar')
                <a href="{{ $webinar->addToCalendarLink() }}" target="_blank" class="webinar-notify d-flex align-items-center justify-content-center">
                    <i data-feather="bell" width="20" height="20" class="webinar-icon"></i>
                </a>
            @endif
        </div>

        <figcaption class="webinar-card-body">

            <a href="{{ $webinar->getUrl() }}">
                <h3 class="mt-15 webinar-title font-weight-bold font-16 text-dark-blue">{{ clean($webinar->title,'title') }}</h3>
            </a>
            <div class="d-flex justify-content-between mt-20">
                <div class="d-flex align-items-center">
                    <i data-feather="clock" width="20" height="20" class="webinar-icon"></i>

                     @if(in_array($webinar->type,['text_lesson','course']))
                                 <span class="duration font-14 ml-5"> {{ !empty($webinar->duration) ? $webinar->duration : 0 }} {{ trans('public.days') }}</span>
                                @else

                         <span class="duration font-14 ml-5">{{ convertMinutesToHourAndMinute($webinar->duration) }} {{ trans('home.hours') }}</span>

                                @endif



                </div>

            </div>

        </figcaption>
    </figure>
</div>
