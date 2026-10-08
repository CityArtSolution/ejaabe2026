@extends(getTemplate() . '.layouts.app')

@section('content')
    @php
        $isArabic = app()->getLocale() === 'ar';
    @endphp

    <section class="container mt-50 mb-50">
        <h1 class="section-title mb-30">
            {{ $isArabic ? 'كل الفعاليات' : 'All events' }}
        </h1>

        <div class="row">
            @forelse ($events as $event)
                <div class="col-12 col-md-6 col-lg-4 mb-30">
                    <article class="blog-grid-card h-100">
                        <a href="{{ $event->getUrl() }}"
                           class="blog-grid-image d-block">
                            <img src="{{ $event->image }}"
                                 class="img-cover"
                                 alt="{{ $event->title }}"
                                 loading="lazy">
                        </a>

                        <div class="blog-grid-detail">
                            <a href="{{ $event->getUrl() }}">
                                <h2 class="blog-grid-title mt-10">
                                    {{ $event->title }}
                                </h2>
                            </a>

                            <div class="mt-15 text-gray font-14">
                                @if ($event->start_date)
                                    <div>
                                        {{ $isArabic ? 'التاريخ:' : 'Date:' }}
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') }}
                                    </div>
                                @endif

                                @if ($event->time)
                                    <div class="mt-5">
                                        {{ $isArabic ? 'الوقت:' : 'Time:' }}
                                        {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                                    </div>
                                @endif

                                @if ($event->location)
                                    <div class="mt-5">
                                        {{ $isArabic ? 'المكان:' : 'Location:' }}
                                        {{ $event->location }}
                                    </div>
                                @endif
                            </div>

                            <p class="mt-20 blog-grid-desc">
                                {{ \Illuminate\Support\Str::limit(strip_tags($event->details ?? ''), 160) }}
                            </p>

                            <a href="{{ $event->getUrl() }}"
                               class="btn btn-primary btn-sm mt-20">
                                {{ $isArabic ? 'عرض التفاصيل' : 'View details' }}
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-gray py-5">
                        {{ $isArabic ? 'لا توجد فعاليات حاليًا.' : 'No events available.' }}
                    </p>
                </div>
            @endforelse
        </div>

        @if ($events->hasPages())
            <div class="d-flex justify-content-center mt-30">
                {{ $events->links('vendor.pagination.panel') }}
            </div>
        @endif
    </section>
@endsection