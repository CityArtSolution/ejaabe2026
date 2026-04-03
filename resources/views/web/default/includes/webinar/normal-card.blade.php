<div class="webinar-card h-100">
    <figure>
        <div class="p-20">
            <a href="{{ $webinar->getUrl() . '/uae' }}" class="">
                <img src="{{ $webinar->getImage() }}" class="img-cover shadow"style="	border-radius: .75rem;box-shadow: 0 6px 18px -8px rgba(0,0,0,0.5);height: 250px"alt="{{ $webinar->title }}">
            </a>
        </div>

        <div class="px-3 pb-4">
            <a href="{{ $webinar->getUrl() . '/uae' }}">
                <h3 class="mt-1 webinar-title font-weight-bold font-16 text-dark-blue">{{ clean($webinar->title, 'title') }}</h3>
            </a>
            <div class="d-flex justify-content-between mt-20">
                <div class="d-flex align-items-center">
                    <i data-feather="clock" width="20" height="20" class="webinar-icon"></i>
                    @if (in_array($webinar->type, ['text_lesson', 'course']))
                        <span class="duration font-14 ml-5"> {{ !empty($webinar->duration) ? $webinar->duration : 0 }}
                            {{ trans('public.days') }}</span>
                    @else
                        <span class="duration font-14 ml-5">{{ convertMinutesToHourAndMinute($webinar->duration) }}
                            {{ trans('home.hours') }}</span>
                    @endif
                </div>

                <a href="{{ $webinar->getUrl() . '/uae' }}">
                    <h3 style="font-weight: 600;background-color: #DDE6FD;border: 2px solid #DDE6FD;color: #4671DD;border-radius: 2rem;padding: .25rem .75rem;cursor: pointer;font-size:15px">
                        {{ Config::get('app.locale') === 'ar' ? 'اقرأ المزيد' : 'Read More' }}
                    </h3>
                </a>

            </div>
        </div>
    </figure>
</div>
