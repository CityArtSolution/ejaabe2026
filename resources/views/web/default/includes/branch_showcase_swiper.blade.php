@if(!empty($items) and !$items->isEmpty())
    <div class="swiper-container organization-swiper-container px-12">
        <div class="swiper-wrapper py-20">
            @foreach($items as $showcaseItem)
                <div class="swiper-slide">
                    <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                        <div class="home-organizations-avatar">
                            @if(!empty($showcaseItem->link))
                                <a href="{{ $showcaseItem->link }}" target="_blank" rel="noopener" class="d-block w-100 h-100">
                                    <img src="{{ $showcaseItem->image }}" class="img-cover" style="object-fit: contain; width: 100%; height: 100%;" alt="{{ $showcaseItem->title ?? '' }}">
                                </a>
                            @else
                                <img src="{{ $showcaseItem->image }}" class="img-cover" style="object-fit: contain; width: 100%; height: 100%;" alt="{{ $showcaseItem->title ?? '' }}">
                            @endif
                        </div>
                        <div class="bottom-gradient"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination organization-swiper-pagination"></div>
        </div>
    </div>
@endif
