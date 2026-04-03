<div class="swiper-slide">
    <div class="hero-slide" style="background-image: url({{ $slider->image }})">
        <div class="hero-content">
            <!-- Title with Animation -->
            <h1 class="hero-title" data-swiper-parallax="-500">{{ $slider->title }}</h1>
            <!-- Description with Animation -->
            <p class="hero-description" data-swiper-parallax="-300">{{ $slider->description }}</p>
            <!-- Buttons with Animation -->
            <div class="hero-buttons" data-swiper-parallax="-100">
                <a href="{{ $slider->button1_link }}" class="hero-btn hero-btn-primary" target="_blank">
                    <span>{{ $slider->button1_title }}</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="{{ $slider->button2_link }}" class="hero-btn hero-btn-secondary" target="_blank">
                    <span>{{ $slider->button2_title }}</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 16v-4M12 8h.01" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
