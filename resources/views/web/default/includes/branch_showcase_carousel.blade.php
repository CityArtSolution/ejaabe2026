@if(!empty($items) and !$items->isEmpty())
    <div class="owl-carousel customers-testimonials instructors-swiper-container">
        @foreach($items as $showcaseItem)
            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card {{ $cardClass ?? '' }} d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            @if(!empty($showcaseItem->link))
                                <a href="{{ $showcaseItem->link }}" target="_blank" rel="noopener" class="d-block w-100 h-100">
                                    <img src="{{ $showcaseItem->image }}" alt="{{ $showcaseItem->title ?? '' }}" class="img-cover" style="object-fit: contain; width: 100%; height: 100%;">
                                </a>
                            @else
                                <img src="{{ $showcaseItem->image }}" alt="{{ $showcaseItem->title ?? '' }}" class="img-cover" style="object-fit: contain; width: 100%; height: 100%;">
                            @endif
                        </div>
                        @if(!empty($showcaseItem->title))
                            <div class="instructors-card-info mt-10 text-center">{{ $showcaseItem->title }}</div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
