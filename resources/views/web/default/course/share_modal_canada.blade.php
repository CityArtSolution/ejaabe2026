<div class="d-none" id="courseShareModal">
    <h3 class="section-title after-line font-20 text-dark-blue mb-25">{{ trans('public.share') }}</h3>

    <div class="text-center">
        <i data-feather="share-2" width="50" height="50" class="webinar-icon"></i>

        <p class="mt-20 font-14">{{ trans('public.share_this_course_with_others') }}</p>

        <div class="position-relative d-flex align-items-center justify-content-between p-15 mt-15 border border-gray250 rounded-sm mt-5">
            <div class="js-course-share-link font-weight-bold px-16 text-ellipsis font-14">{{ $course->getUrl() . '/canada' }}</div>

            <button type="button" class="js-course-share-link-copy btn btn-primary btn-sm font-14 font-weight-500 flex-none" data-toggle="tooltip" data-placement="top" title="{{ trans('public.copy') }}">{{ trans('public.copy') }}</button>
        </div>

   <div class="mt-4 row justify-content-center">
    <a href="{{ $course->getShareLink('telegram') }}" target="_blank" class="social-icon telegram">
        <i class="fab fa-telegram-plane"></i>
    </a>

    <a href="{{ $course->getShareLink('whatsapp') }}" target="_blank" class="social-icon whatsapp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <a href="{{ $course->getShareLink('facebook') }}" target="_blank" class="social-icon facebook">
        <i class="fab fa-facebook-f"></i>
    </a>

    <a href="{{ $course->getShareLink('twitter') }}" target="_blank" class="social-icon x-twitter">
        <i class="fab fa-x-twitter"></i>
    </a>
</div>

<style>
.social-icon {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    color: #fff;
    font-size: 24px;
    transition: 0.3s;
    text-decoration: none;
    margin: 0 8px; /* 👈 مسافة يمين ويسار */
}

.social-icon.telegram {
    background-color: #0088cc;
}

.social-icon.whatsapp {
    background-color: #25D366;
}

.social-icon.facebook {
    background-color: #3b5998;
}

.social-icon.x-twitter {
    background-color: #000;
}

.social-icon:hover {
    transform: scale(1.1);
    opacity: 0.9;
}
</style>

    </div>

    <div class="mt-30 d-flex align-items-center justify-content-end">
        <button type="button" class="btn btn-sm btn-danger ml-10 close-swl">{{ trans('public.close') }}</button>
    </div>
</div>
