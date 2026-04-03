@extends(getTemplate().'.layouts.egy_app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Cairo', sans-serif !important;
    }
    .hero-slider .flickity-page-dots .dot {
    width: 30px;
    height: 4px;
    opacity: 1;
    background: rgba(255, 255, 255, 0.5);
    border: 0 solid white;
    border-radius: 0;
}
.hero-slider .flickity-page-dots {
    bottom: 30px;
}
.flickity-page-dots {
    position: absolute;
    width: 100%;
    bottom: -25px;
    padding: 0;
    margin: 0;
    list-style: none;
    text-align: center;
    line-height: 1;
}
.flickity-page-dots .dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    margin: 0 8px;
    background: #333;
    border-radius: 50%;
    opacity: .25;
    cursor: pointer;
}
.hero-slider .flickity-page-dots .dot.is-selected {
    background: #309df0;
    border: 0 solid #309df0;
}
.hero-btn-primary {
    background: #309df0;
}
.hero-content::before {
        background: #309df0;
}
.progress-bar {
   
    background: #309df0;
}
.modern-services-area .item::before {
        background: #309df0;
}
.modern-services-area .item .icon i {
    color:#309df0;
}
.home-sections .section-title {
    color:#309df0;
}
.section_our_solution .row {
  align-items: center;
}

.our_solution_category {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
}

.our_solution_category .solution_cards_box {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.solution_cards_box .solution_card {
  flex: 0 50%;
  background: #fff;
  box-shadow: 0 2px 4px 0 rgba(136, 144, 195, 0.2),
    0 5px 15px 0 rgba(37, 44, 97, 0.15);
  border-radius: 15px;
  margin: 8px;
  padding: 10px 15px;
  position: relative;
  z-index: 1;
  overflow: hidden;
  min-height: 265px;
  transition: 0.7s;
}

.solution_cards_box .solution_card:hover {
  background: #309df0;
  color: #fff;
  transform: scale(1.1);
  z-index: 9;
}

.solution_cards_box .solution_card:hover::before {
  background: rgb(85 108 214 / 10%);
}

.solution_cards_box .solution_card:hover .solu_title h3,
.solution_cards_box .solution_card:hover .solu_description p {
  color: #fff;
}

.solution_cards_box .solution_card:before {
  content: "";
  position: absolute;
  background: rgb(85 108 214 / 5%);
  width: 170px;
  height: 400px;
  z-index: -1;
  transform: rotate(42deg);
  right: -56px;
  top: -23px;
  border-radius: 35px;
}

.solution_cards_box .solution_card:hover .solu_description button {
  background: #fff !important;
  color: #309df0;
}

.solution_card .so_top_icon {
}

.solution_card .solu_title div {
  color: #212121;
  font-size: 1.3rem;
  margin-top: 13px;
  margin-bottom: 13px;
}

.solution_card .solu_description p {
    font-size: 22px;
    text-align: center;
    margin-bottom: 15px;
}

.solution_card .solu_description button {
  border: 0;
  border-radius: 15px;
  background: linear-gradient(
    140deg,
    #42c3ca 0%,
    #42c3ca 50%,
    #42c3cac7 75%
  ) !important;
  color: #fff;
  font-weight: 500;
  font-size: 1rem;
  padding: 5px 16px;
}

.our_solution_content div {
  text-transform: capitalize;
  margin-bottom: 1rem;
  font-size: 2.5rem;
}

.our_solution_content p {
}

.hover_color_bubble {
  position: absolute;
  background: rgb(54 81 207 / 15%);
  width: 100rem;
  height: 100rem;
  left: 0;
  right: 0;
  z-index: -1;
  top: 16rem;
  border-radius: 50%;
  transform: rotate(-36deg);
  left: -18rem;
  transition: 0.7s;
}

.solution_cards_box .solution_card:hover .hover_color_bubble {
  top: 0rem;
}

.solution_cards_box .solution_card .so_top_icon {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: #fff;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}

.solution_cards_box .solution_card .so_top_icon img {
  width: 40px;
  height: 50px;
  object-fit: contain;
}

/*start media query*/
@media screen and (min-width: 320px) {
  .sol_card_top_3 {
    position: relative;
    top: 0;
  }

  .our_solution_category {
    width: 100%;
    margin: 0 auto;
  }

  .our_solution_category .solution_cards_box {
    flex: auto;
  }
}

@media only screen and (min-width: 768px) {
  .our_solution_category .solution_cards_box {
    flex: 1;
  }
}

@media only screen and (min-width: 1024px) {
  .sol_card_top_3 {
    position: relative;
    top: -3rem;
  }

  .our_solution_category {
    width: 91%;
    margin: 0 auto;
  }
}
.flaticon-creativity:before{
    color: #348dea !important;
}
.flaticon-result:before {
    color: #348dea !important;
}
.flaticon-meeting:before {
    color: #348dea !important;
}


.site-heading {
  position: relative;
  padding: 2rem 1rem;
}

.sub-title {
  font-size: 1.3rem;
  color: #348dea;
  margin-bottom: 0.5rem;
  letter-spacing: 1px;
}

.main-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: #1a1a1a;
  position: relative;
}

.underline {
  width: 60px;
  height: 4px;
  background: linear-gradient(90deg, #309df0, #3192eb);
  margin: 1rem auto 0;
  border-radius: 2px;
  animation: slide 1s ease-in-out infinite alternate;
}

/* أنميشن للخط */
@keyframes slide {
  0% { transform: translateX(-20px); opacity: 0.5; }
  100% { transform: translateX(20px); opacity: 1; }
}

.latest-classes-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 2rem 2.5rem;
    border-radius: 1.25rem;
    background: rgba(255, 255, 255, 0.7);  /* خلفية زجاجية فاتحة */
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    margin-bottom: 2rem;
}

.latest-classes-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
}

.latest-classes-card .title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b; /* أزرق غامق احترافي */
    margin-bottom: .4rem;
}

.latest-classes-card .hint {
    font-size: 1rem;
    color: #475569; /* رمادي أزرق */
    margin: 0;
}

.latest-classes-card .cta-btn {
    background: #2563eb;
    color: #fff;
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(37,99,235,0.25);
}

.latest-classes-card .cta-btn:hover {
    background: #1e40af;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(37,99,235,0.35);
}
.about-line {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .8rem;
    margin: 1rem;
}

.about-line span {
    display: block;
    width: 60px;
    height: 2px;
    background: linear-gradient(to right, #2563eb, #38bdf8);
    border-radius: 2px;
    animation: expand 2s infinite alternate;
}

.about-line i {
    font-size: 1rem;
    color: #2563eb;
    animation: pulse 1.5s infinite;
}

.about-hint {
    font-size: 1rem;
    color: #475569;
    max-width: 600px;
    margin: 0 auto;
}

/* أنيميشن */
@keyframes expand {
    from { width: 30px; }
    to { width: 80px; }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}
</style>

@endpush

@section('content')
    @if (!empty($heroSectionData))
        <section class="hero-slider swiper">
            <!-- Progress Bar -->
            <div class="slider-progress">
                <div class="progress-bar"></div>
            </div>

            <!-- Animated Background -->
            <div class="animated-bg"></div>

           <div class="swiper-wrapper" style="padding-bottom:50px">
    @foreach ($sliders as $slider)
        <div class="swiper-slide">
            <div class="hero-slide" style="background-image: url('{{ asset($slider->image) }}')">
                <div class="hero-content">
                    <h1 class="hero-title">{{ $slider->title }}</h1>
                    <p class="hero-description">{{ $slider->description }}</p>
                    <div class="hero-buttons">
                        <a href="{{ $slider->button1_link }}" class="hero-btn hero-btn-primary" target="_blank">
                            <span>{{ $slider->button1_title }}</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                        <a href="{{ $slider->button2_link }}" class="hero-btn hero-btn-secondary" target="_blank">
                            <span>{{ $slider->button2_title }}</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 16v-4M12 8h.01" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>


            <!-- Navigation -->
            <div class="customised-slider-nav-wrapper">
                <div class="customised-pagination">
                    <div class="row">
                        @foreach ($sliders as $index => $slider)
                            <div class="col-6 col-md-4 padding-10">
                                <button class="customised-pagination-bullet" data-slide-index="{{ $index }}"
                                    title="{{ $slider->title }}">

                                    <div class="icon">
                                        <img src="/store/services/icon-{{ $index + 1 }}.png" alt="Service 1"
                                            class="service-logo">
                                    </div>
                                    <span>{{ $slider->title }}</span>

                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
<div class="container">
    <div class="row">
        <div class="col-12 my-5">
          <div class="site-heading text-center">
            <h4 class="sub-title animate__animated animate__fadeInDown">{{ __('messages.why_learn') }}</h4>
            <h2 class="main-title animate__animated animate__fadeInUp">{{ __('messages.many_courses') }}</h2>
            <div class="underline"></div>
          </div>
        </div>  
        <div class="col-12 col-md-4">
            <div class="section_our_solution">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="our_solution_category">
            <div class="solution_cards_box">
              <div class="solution_card">
                <div class="hover_color_bubble"></div>
                <div class="so_top_icon">
                    <g>
                      <g>
                        <g>
                          <g>
                            <div class="icon">
                                <i style="font-size:39px" class="flaticon-creativity"></i>
                            </div>
                          </g>
                          <g>
                            <g>
                              <g>
                                <g>
                                  <g>
                                    <path fill="#fff9e9" d="m17.5 504.177h226.14l79.96-79.605v-355.86c0-5.523-4.477-10-10-10h-296.1c-5.523 0-10 4.477-10 10v425.466c0 5.522 4.477 9.999 10 9.999z"></path>
                                  </g>
                                  <path fill="#fff4d6" d="m313.601 58.712h-40c5.523 0 10 4.477 10 10v355.861l-.258 40.078 40.258-40.078v-355.861c0-5.523-4.477-10-10-10z"></path>
                                </g>
                              </g>
                            </g>
                            <path fill="#ffeec2" d="m243.64 504.177v-70.253c0-5.523 4.477-10 10-10h69.96z"></path>
                          </g>
                        </g>
                        <g>
                          <path fill="#fed23a" d="m468.636 248.58-33.372.165v-50.826c0-9.183 7.463-16.662 16.673-16.708h.007c9.217-.046 16.693 7.371 16.693 16.562v50.807z"></path>
                          <path fill="#54b1ff" d="m451.96 504.177c-10.362-10.277-16.196-24.263-16.208-38.857l-.062-73.973c0-.644.524-1.169 1.171-1.173l30.038-.149c.647-.003 1.171.517 1.171 1.161l.062 74.079c.012 14.531-5.749 28.472-16.015 38.756z"></path>
                          <path fill="#fdf385" d="m451.959 469.333h-.01c-14.434.072-26.14-11.542-26.14-25.935v-213.527c0-6.778 5.477-12.283 12.255-12.316l27.626-.137c6.826-.034 12.378 5.49 12.378 12.316v213.436c0 14.38-11.687 26.091-26.109 26.163z"></path>
                          <path fill="#faee6e" d="m465.69 217.417-23.769.118c6.037.79 10.708 5.94 10.708 12.198v213.437c0 9.823-5.455 18.397-13.507 22.87 3.79 2.115 8.164 3.317 12.826 3.293h.01c14.422-.072 26.109-11.783 26.109-26.163v-213.436c.001-6.826-5.551-12.351-12.377-12.317z"></path>
                          <path fill="#54b1ff" d="m491.274 247.925-71.615.355c-7.305.036-13.226 5.968-13.226 13.248 0 7.281 5.921 13.153 13.226 13.117l58.389-.29v77.489c0 7.281 5.921 13.153 13.226 13.117 7.305-.036 13.226-5.968 13.226-13.248v-90.672c0-7.28-5.922-13.152-13.226-13.116z"></path>
                          <g>
                            <path fill="#3da7ff" d="m491.274 247.925-38.441.188-.167 26.311 25.381-.067v77.489c0 7.281 5.921 13.153 13.226 13.117 7.305-.036 13.226-5.968 13.226-13.248v-90.672c.001-7.282-5.921-13.154-13.225-13.118z"></path>
                          </g>
                        </g>
                      </g>
                      <g fill="#060606">
                        <path d="m373.147 20.122-295.44-19.761c-9.631-.638-17.984 6.665-18.629 16.293l-2.311 34.557h-39.267c-9.649 0-17.5 7.851-17.5 17.5v425.466c0 9.649 7.851 17.5 17.5 17.5h226.141c1.96 0 3.902-.801 5.292-2.185l34.138-33.987c.347.074.701.133 1.065.157l58.282 3.898c9.302.614 18.005-6.952 18.629-16.293l28.393-424.515c.639-9.528-6.766-17.993-16.293-18.63zm-122.006 465.902v-52.1c0-1.378 1.122-2.5 2.5-2.5h51.9zm94.939-23.757c-.244 1.51-1.131 2.286-2.66 2.327l-46.28-3.096 31.752-31.611c1.414-1.407 2.209-3.32 2.209-5.315v-355.86c0-9.649-7.851-17.5-17.5-17.5h-77.993c-9.697 0-9.697 15 0 15h77.993c1.379 0 2.5 1.122 2.5 2.5v347.712h-62.46c-9.649 0-17.5 7.851-17.5 17.5v62.753h-218.641c-1.378 0-2.5-1.122-2.5-2.5v-425.465c0-1.378 1.122-2.5 2.5-2.5h178.168c9.697 0 9.697-15 0-15h-123.868l2.244-33.556c.244-1.511 1.131-2.286 2.661-2.327l295.44 19.76c1.511.244 2.287 1.131 2.328 2.661z"></path>
                        <path d="m267.827 237.047h-204.553c-4.142 0-7.5 3.358-7.5 7.5s3.358 7.5 7.5 7.5h204.553c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5z"></path>
                        <path d="m267.827 289.332h-204.553c-4.142 0-7.5 3.358-7.5 7.5s3.358 7.5 7.5 7.5h204.553c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5z"></path>
                        <path d="m55.774 192.262c0 4.142 3.358 7.5 7.5 7.5h204.553c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-204.553c-4.142 0-7.5 3.358-7.5 7.5z"></path>
                        <path d="m91.807 139.977c0 4.142 3.358 7.5 7.5 7.5h132.487c4.142 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.5-7.5h-132.487c-4.142 0-7.5 3.358-7.5 7.5z"></path>
                        <path d="m194.755 438.787c-13.489.036-26.978.065-40.467.086-4.534.007-9.067.013-13.6.016-8.215.006-13.75-1.643-15.59-10.679-1.556-7.64-12.364-6.613-14.464 0-5.19 16.337-13.774 9.936-18.582-1.053-4.797-10.963-6.027-23.233-8.122-34.9-1.54-8.573-14.506-6.17-14.732 1.994-.298 10.751-1.302 21.331-4.031 31.758-2.815 10.758-7.034 21.097-11.222 31.376-3.651 8.961 10.867 12.816 14.464 3.988 3.711-9.108 7.427-18.266 10.193-27.714 5.14 12.36 15.774 26.34 30.927 18.101 2.819-1.533 5.452-3.712 7.763-6.253 7.88 9.106 19.609 8.388 30.584 8.375 15.627-.02 31.254-.054 46.881-.095 9.649-.025 9.667-15.025-.002-15z"></path>
                        <path d="m505.932 246.439c-3.897-3.878-9.255-5.867-14.695-6.014l-5.668.028v-10.719c0-6.529-3.878-13.427-9.433-16.862v-15.098c0-31.069-48.372-30.934-48.372.146v15.1c-5.659 3.498-9.455 9.741-9.455 16.852v10.982c-24.966 1.7-25.037 39.745.028 41.232.16 33.575.152 66.6-.028 100.737-.049 9.414 14.949 9.966 15 .079.18-34.166.188-67.22.029-100.823l37.211-.185s-.048 110.848-.048 160.784c0 24.338-37.219 24.5-37.219-.253l.013-13.677c.585-9.68-14.387-10.583-14.973-.904v12.834c0 11 3.402 20.316 9.988 26.869.586 15.693 7.198 30.878 18.369 41.956 3.205 3.18 7.642 2.208 10.744-.182 11.365-11.385 17.769-26.394 18.169-42.414 4.951-4.931 9.908-9.896 9.908-26.896l.006-68.351c12.97 3.689 26.494-6.348 26.494-19.946v-90.672c0-5.523-2.155-10.709-6.068-14.603zm-72.623-5.727v-10.841c0-2.219 1.523-4.08 3.573-4.633l30.025-.149c.84.208 1.615.605 2.243 1.231.915.911 1.419 2.123 1.419 3.414v10.794zm18.671-52c4.604 0 9.155 4.514 9.155 9.062v12.166l-18.372.091v-12.111c.001-5.053 4.133-9.183 9.217-9.208zm-.011 303.901c-3.487-4.942-6.009-10.531-7.417-16.406 2.322.503 4.674.765 7.027.765 2.627 0 5.253-.326 7.839-.957-1.374 5.964-3.892 11.587-7.449 16.598zm45.031-140.899c0 7.101-11.452 7.66-11.452.131 0 0 .013-70.974.021-77.48.005-4.196-3.483-7.509-7.558-7.509l-58.389.29c-7.242 0-7.073-11.331.074-11.366l71.615-.355c3.463.295 5.359 2.168 5.688 5.617v90.672z"></path>
                      </g>
                    </g>
                </div>
                <div class="solu_title">
                  <pre style="text-align:center;margin:11px 0;">1</pre>
                </div>
                <div class="solu_description">
                  <p>
                    {{ __('messages.point_1') }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
        <div class="col-12 col-md-4">
            <div class="section_our_solution">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="our_solution_category">
            <div class="solution_cards_box">
              <div class="solution_card">
                <div class="hover_color_bubble"></div>
                <div class="so_top_icon">
                    <div class="icon">
                        <i style="font-size:39px" class="flaticon-result"></i>
                    </div>   
                    <g>
                      <g>
                        <g>
                          <g>
                            <path fill="#fae19e" d="m47.478 452.317 295.441 19.76c5.511.369 10.277-3.8 10.645-9.31l28.393-424.517c.369-5.511-3.8-10.276-9.31-10.645l-295.441-19.76c-5.511-.369-10.276 3.8-10.645 9.31l-28.394 424.517c-.368 5.511 3.8 10.277 9.311 10.645z"></path>
                          </g>
                          <g>
                            <g>
                              <g>
                                <g>
                                  <g>
                                    <path fill="#fff9e9" d="m17.5 504.177h226.14l79.96-79.605v-355.86c0-5.523-4.477-10-10-10h-296.1c-5.523 0-10 4.477-10 10v425.466c0 5.522 4.477 9.999 10 9.999z"></path>
                                  </g>
                                  <path fill="#fff4d6" d="m313.601 58.712h-40c5.523 0 10 4.477 10 10v355.861l-.258 40.078 40.258-40.078v-355.861c0-5.523-4.477-10-10-10z"></path>
                                </g>
                              </g>
                            </g>
                            <path fill="#ffeec2" d="m243.64 504.177v-70.253c0-5.523 4.477-10 10-10h69.96z"></path>
                          </g>
                        </g>
                        <g>
                          <path fill="#fed23a" d="m468.636 248.58-33.372.165v-50.826c0-9.183 7.463-16.662 16.673-16.708h.007c9.217-.046 16.693 7.371 16.693 16.562v50.807z"></path>
                          <path fill="#54b1ff" d="m451.96 504.177c-10.362-10.277-16.196-24.263-16.208-38.857l-.062-73.973c0-.644.524-1.169 1.171-1.173l30.038-.149c.647-.003 1.171.517 1.171 1.161l.062 74.079c.012 14.531-5.749 28.472-16.015 38.756z"></path>
                          <path fill="#fdf385" d="m451.959 469.333h-.01c-14.434.072-26.14-11.542-26.14-25.935v-213.527c0-6.778 5.477-12.283 12.255-12.316l27.626-.137c6.826-.034 12.378 5.49 12.378 12.316v213.436c0 14.38-11.687 26.091-26.109 26.163z"></path>
                          <path fill="#faee6e" d="m465.69 217.417-23.769.118c6.037.79 10.708 5.94 10.708 12.198v213.437c0 9.823-5.455 18.397-13.507 22.87 3.79 2.115 8.164 3.317 12.826 3.293h.01c14.422-.072 26.109-11.783 26.109-26.163v-213.436c.001-6.826-5.551-12.351-12.377-12.317z"></path>
                          <path fill="#54b1ff" d="m491.274 247.925-71.615.355c-7.305.036-13.226 5.968-13.226 13.248 0 7.281 5.921 13.153 13.226 13.117l58.389-.29v77.489c0 7.281 5.921 13.153 13.226 13.117 7.305-.036 13.226-5.968 13.226-13.248v-90.672c0-7.28-5.922-13.152-13.226-13.116z"></path>
                          <g>
                            <path fill="#3da7ff" d="m491.274 247.925-38.441.188-.167 26.311 25.381-.067v77.489c0 7.281 5.921 13.153 13.226 13.117 7.305-.036 13.226-5.968 13.226-13.248v-90.672c.001-7.282-5.921-13.154-13.225-13.118z"></path>
                          </g>
                        </g>
                      </g>
                      <g fill="#060606">
                        <path d="m373.147 20.122-295.44-19.761c-9.631-.638-17.984 6.665-18.629 16.293l-2.311 34.557h-39.267c-9.649 0-17.5 7.851-17.5 17.5v425.466c0 9.649 7.851 17.5 17.5 17.5h226.141c1.96 0 3.902-.801 5.292-2.185l34.138-33.987c.347.074.701.133 1.065.157l58.282 3.898c9.302.614 18.005-6.952 18.629-16.293l28.393-424.515c.639-9.528-6.766-17.993-16.293-18.63zm-122.006 465.902v-52.1c0-1.378 1.122-2.5 2.5-2.5h51.9zm94.939-23.757c-.244 1.51-1.131 2.286-2.66 2.327l-46.28-3.096 31.752-31.611c1.414-1.407 2.209-3.32 2.209-5.315v-355.86c0-9.649-7.851-17.5-17.5-17.5h-77.993c-9.697 0-9.697 15 0 15h77.993c1.379 0 2.5 1.122 2.5 2.5v347.712h-62.46c-9.649 0-17.5 7.851-17.5 17.5v62.753h-218.641c-1.378 0-2.5-1.122-2.5-2.5v-425.465c0-1.378 1.122-2.5 2.5-2.5h178.168c9.697 0 9.697-15 0-15h-123.868l2.244-33.556c.244-1.511 1.131-2.286 2.661-2.327l295.44 19.76c1.511.244 2.287 1.131 2.328 2.661z"></path>
                        <path d="m267.827 237.047h-204.553c-4.142 0-7.5 3.358-7.5 7.5s3.358 7.5 7.5 7.5h204.553c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5z"></path>
                        <path d="m267.827 289.332h-204.553c-4.142 0-7.5 3.358-7.5 7.5s3.358 7.5 7.5 7.5h204.553c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5z"></path>
                        <path d="m55.774 192.262c0 4.142 3.358 7.5 7.5 7.5h204.553c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-204.553c-4.142 0-7.5 3.358-7.5 7.5z"></path>
                        <path d="m91.807 139.977c0 4.142 3.358 7.5 7.5 7.5h132.487c4.142 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.5-7.5h-132.487c-4.142 0-7.5 3.358-7.5 7.5z"></path>
                        <path d="m194.755 438.787c-13.489.036-26.978.065-40.467.086-4.534.007-9.067.013-13.6.016-8.215.006-13.75-1.643-15.59-10.679-1.556-7.64-12.364-6.613-14.464 0-5.19 16.337-13.774 9.936-18.582-1.053-4.797-10.963-6.027-23.233-8.122-34.9-1.54-8.573-14.506-6.17-14.732 1.994-.298 10.751-1.302 21.331-4.031 31.758-2.815 10.758-7.034 21.097-11.222 31.376-3.651 8.961 10.867 12.816 14.464 3.988 3.711-9.108 7.427-18.266 10.193-27.714 5.14 12.36 15.774 26.34 30.927 18.101 2.819-1.533 5.452-3.712 7.763-6.253 7.88 9.106 19.609 8.388 30.584 8.375 15.627-.02 31.254-.054 46.881-.095 9.649-.025 9.667-15.025-.002-15z"></path>
                        <path d="m505.932 246.439c-3.897-3.878-9.255-5.867-14.695-6.014l-5.668.028v-10.719c0-6.529-3.878-13.427-9.433-16.862v-15.098c0-31.069-48.372-30.934-48.372.146v15.1c-5.659 3.498-9.455 9.741-9.455 16.852v10.982c-24.966 1.7-25.037 39.745.028 41.232.16 33.575.152 66.6-.028 100.737-.049 9.414 14.949 9.966 15 .079.18-34.166.188-67.22.029-100.823l37.211-.185s-.048 110.848-.048 160.784c0 24.338-37.219 24.5-37.219-.253l.013-13.677c.585-9.68-14.387-10.583-14.973-.904v12.834c0 11 3.402 20.316 9.988 26.869.586 15.693 7.198 30.878 18.369 41.956 3.205 3.18 7.642 2.208 10.744-.182 11.365-11.385 17.769-26.394 18.169-42.414 4.951-4.931 9.908-9.896 9.908-26.896l.006-68.351c12.97 3.689 26.494-6.348 26.494-19.946v-90.672c0-5.523-2.155-10.709-6.068-14.603zm-72.623-5.727v-10.841c0-2.219 1.523-4.08 3.573-4.633l30.025-.149c.84.208 1.615.605 2.243 1.231.915.911 1.419 2.123 1.419 3.414v10.794zm18.671-52c4.604 0 9.155 4.514 9.155 9.062v12.166l-18.372.091v-12.111c.001-5.053 4.133-9.183 9.217-9.208zm-.011 303.901c-3.487-4.942-6.009-10.531-7.417-16.406 2.322.503 4.674.765 7.027.765 2.627 0 5.253-.326 7.839-.957-1.374 5.964-3.892 11.587-7.449 16.598zm45.031-140.899c0 7.101-11.452 7.66-11.452.131 0 0 .013-70.974.021-77.48.005-4.196-3.483-7.509-7.558-7.509l-58.389.29c-7.242 0-7.073-11.331.074-11.366l71.615-.355c3.463.295 5.359 2.168 5.688 5.617v90.672z"></path>
                      </g>
                    </g>
                </div>
                <div class="solu_title">
                  <pre style="text-align:center;margin:11px 0;">2</pre>
                </div>
                <div class="solu_description">
                  <p>
                    {{ __('messages.point_2') }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
        <div class="col-12 col-md-4">
            <div class="section_our_solution">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="our_solution_category">
            <div class="solution_cards_box">
              <div class="solution_card">
                <div class="hover_color_bubble"></div>
                <div class="so_top_icon">
                    <div class="icon">
                        <i style="font-size:39px" class="flaticon-meeting"></i>
                    </div>
                    <g>
                      <g>
                        <g>
                          <g>
                            <path fill="#fae19e" d="m47.478 452.317 295.441 19.76c5.511.369 10.277-3.8 10.645-9.31l28.393-424.517c.369-5.511-3.8-10.276-9.31-10.645l-295.441-19.76c-5.511-.369-10.276 3.8-10.645 9.31l-28.394 424.517c-.368 5.511 3.8 10.277 9.311 10.645z"></path>
                          </g>
                          <g>
                            <g>
                              <g>
                                <g>
                                  <g>
                                    <path fill="#fff9e9" d="m17.5 504.177h226.14l79.96-79.605v-355.86c0-5.523-4.477-10-10-10h-296.1c-5.523 0-10 4.477-10 10v425.466c0 5.522 4.477 9.999 10 9.999z"></path>
                                  </g>
                                  <path fill="#fff4d6" d="m313.601 58.712h-40c5.523 0 10 4.477 10 10v355.861l-.258 40.078 40.258-40.078v-355.861c0-5.523-4.477-10-10-10z"></path>
                                </g>
                              </g>
                            </g>
                            <path fill="#ffeec2" d="m243.64 504.177v-70.253c0-5.523 4.477-10 10-10h69.96z"></path>
                          </g>
                        </g>
                        <g>
                          <path fill="#fed23a" d="m468.636 248.58-33.372.165v-50.826c0-9.183 7.463-16.662 16.673-16.708h.007c9.217-.046 16.693 7.371 16.693 16.562v50.807z"></path>
                          <path fill="#54b1ff" d="m451.96 504.177c-10.362-10.277-16.196-24.263-16.208-38.857l-.062-73.973c0-.644.524-1.169 1.171-1.173l30.038-.149c.647-.003 1.171.517 1.171 1.161l.062 74.079c.012 14.531-5.749 28.472-16.015 38.756z"></path>
                          <path fill="#fdf385" d="m451.959 469.333h-.01c-14.434.072-26.14-11.542-26.14-25.935v-213.527c0-6.778 5.477-12.283 12.255-12.316l27.626-.137c6.826-.034 12.378 5.49 12.378 12.316v213.436c0 14.38-11.687 26.091-26.109 26.163z"></path>
                          <path fill="#faee6e" d="m465.69 217.417-23.769.118c6.037.79 10.708 5.94 10.708 12.198v213.437c0 9.823-5.455 18.397-13.507 22.87 3.79 2.115 8.164 3.317 12.826 3.293h.01c14.422-.072 26.109-11.783 26.109-26.163v-213.436c.001-6.826-5.551-12.351-12.377-12.317z"></path>
                          <path fill="#54b1ff" d="m491.274 247.925-71.615.355c-7.305.036-13.226 5.968-13.226 13.248 0 7.281 5.921 13.153 13.226 13.117l58.389-.29v77.489c0 7.281 5.921 13.153 13.226 13.117 7.305-.036 13.226-5.968 13.226-13.248v-90.672c0-7.28-5.922-13.152-13.226-13.116z"></path>
                          <g>
                            <path fill="#3da7ff" d="m491.274 247.925-38.441.188-.167 26.311 25.381-.067v77.489c0 7.281 5.921 13.153 13.226 13.117 7.305-.036 13.226-5.968 13.226-13.248v-90.672c.001-7.282-5.921-13.154-13.225-13.118z"></path>
                          </g>
                        </g>
                      </g>
                      <g fill="#060606">
                        <path d="m373.147 20.122-295.44-19.761c-9.631-.638-17.984 6.665-18.629 16.293l-2.311 34.557h-39.267c-9.649 0-17.5 7.851-17.5 17.5v425.466c0 9.649 7.851 17.5 17.5 17.5h226.141c1.96 0 3.902-.801 5.292-2.185l34.138-33.987c.347.074.701.133 1.065.157l58.282 3.898c9.302.614 18.005-6.952 18.629-16.293l28.393-424.515c.639-9.528-6.766-17.993-16.293-18.63zm-122.006 465.902v-52.1c0-1.378 1.122-2.5 2.5-2.5h51.9zm94.939-23.757c-.244 1.51-1.131 2.286-2.66 2.327l-46.28-3.096 31.752-31.611c1.414-1.407 2.209-3.32 2.209-5.315v-355.86c0-9.649-7.851-17.5-17.5-17.5h-77.993c-9.697 0-9.697 15 0 15h77.993c1.379 0 2.5 1.122 2.5 2.5v347.712h-62.46c-9.649 0-17.5 7.851-17.5 17.5v62.753h-218.641c-1.378 0-2.5-1.122-2.5-2.5v-425.465c0-1.378 1.122-2.5 2.5-2.5h178.168c9.697 0 9.697-15 0-15h-123.868l2.244-33.556c.244-1.511 1.131-2.286 2.661-2.327l295.44 19.76c1.511.244 2.287 1.131 2.328 2.661z"></path>
                        <path d="m267.827 237.047h-204.553c-4.142 0-7.5 3.358-7.5 7.5s3.358 7.5 7.5 7.5h204.553c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5z"></path>
                        <path d="m267.827 289.332h-204.553c-4.142 0-7.5 3.358-7.5 7.5s3.358 7.5 7.5 7.5h204.553c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5z"></path>
                        <path d="m55.774 192.262c0 4.142 3.358 7.5 7.5 7.5h204.553c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-204.553c-4.142 0-7.5 3.358-7.5 7.5z"></path>
                        <path d="m91.807 139.977c0 4.142 3.358 7.5 7.5 7.5h132.487c4.142 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.5-7.5h-132.487c-4.142 0-7.5 3.358-7.5 7.5z"></path>
                        <path d="m194.755 438.787c-13.489.036-26.978.065-40.467.086-4.534.007-9.067.013-13.6.016-8.215.006-13.75-1.643-15.59-10.679-1.556-7.64-12.364-6.613-14.464 0-5.19 16.337-13.774 9.936-18.582-1.053-4.797-10.963-6.027-23.233-8.122-34.9-1.54-8.573-14.506-6.17-14.732 1.994-.298 10.751-1.302 21.331-4.031 31.758-2.815 10.758-7.034 21.097-11.222 31.376-3.651 8.961 10.867 12.816 14.464 3.988 3.711-9.108 7.427-18.266 10.193-27.714 5.14 12.36 15.774 26.34 30.927 18.101 2.819-1.533 5.452-3.712 7.763-6.253 7.88 9.106 19.609 8.388 30.584 8.375 15.627-.02 31.254-.054 46.881-.095 9.649-.025 9.667-15.025-.002-15z"></path>
                        <path d="m505.932 246.439c-3.897-3.878-9.255-5.867-14.695-6.014l-5.668.028v-10.719c0-6.529-3.878-13.427-9.433-16.862v-15.098c0-31.069-48.372-30.934-48.372.146v15.1c-5.659 3.498-9.455 9.741-9.455 16.852v10.982c-24.966 1.7-25.037 39.745.028 41.232.16 33.575.152 66.6-.028 100.737-.049 9.414 14.949 9.966 15 .079.18-34.166.188-67.22.029-100.823l37.211-.185s-.048 110.848-.048 160.784c0 24.338-37.219 24.5-37.219-.253l.013-13.677c.585-9.68-14.387-10.583-14.973-.904v12.834c0 11 3.402 20.316 9.988 26.869.586 15.693 7.198 30.878 18.369 41.956 3.205 3.18 7.642 2.208 10.744-.182 11.365-11.385 17.769-26.394 18.169-42.414 4.951-4.931 9.908-9.896 9.908-26.896l.006-68.351c12.97 3.689 26.494-6.348 26.494-19.946v-90.672c0-5.523-2.155-10.709-6.068-14.603zm-72.623-5.727v-10.841c0-2.219 1.523-4.08 3.573-4.633l30.025-.149c.84.208 1.615.605 2.243 1.231.915.911 1.419 2.123 1.419 3.414v10.794zm18.671-52c4.604 0 9.155 4.514 9.155 9.062v12.166l-18.372.091v-12.111c.001-5.053 4.133-9.183 9.217-9.208zm-.011 303.901c-3.487-4.942-6.009-10.531-7.417-16.406 2.322.503 4.674.765 7.027.765 2.627 0 5.253-.326 7.839-.957-1.374 5.964-3.892 11.587-7.449 16.598zm45.031-140.899c0 7.101-11.452 7.66-11.452.131 0 0 .013-70.974.021-77.48.005-4.196-3.483-7.509-7.558-7.509l-58.389.29c-7.242 0-7.073-11.331.074-11.366l71.615-.355c3.463.295 5.359 2.168 5.688 5.617v90.672z"></path>
                      </g>
                    </g>
                </div>
                <div class="solu_title">
                  <pre style="text-align:center;margin:11px 0;">3</pre>
                </div>
                <div class="solu_description">
                  <p>
                    {{ __('messages.point_3') }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>

@foreach($homeSections as $homeSection)
<!--لو في اقسام ترند -->
@if($homeSection->name == \App\Models\HomeSection::$trend_categories and !empty($trendCategories) and !$trendCategories->isEmpty())
<section class="home-sections home-sections-swiper container">
    <h2 class="section-title">{{ trans('home.trending_categories') }}</h2>
    <p class="section-hint">{{ trans('home.trending_categories_hint') }}</p>


    <div class="swiper-container trend-categories-swiper px-12 mt-40">
        <div class="swiper-wrapper py-20">
            @foreach($trendCategories as $trend)
            <div class="swiper-slide">
                <a href="{{ $trend->category->getUrl() }}">
                    <div class="trending-card d-flex flex-column align-items-center w-100">
                        <div class="trending-image d-flex align-items-center justify-content-center w-100" style="background-color: {{ $trend->color }}">
                            <div class="icon mb-3">
                                <img src="{{ $trend->getIcon() }}" width="10" class="img-cover" alt="{{ $trend->category->title }}">
                            </div>
                        </div>

                        <div class="item-count px-10 px-lg-20 py-5 py-lg-10">{{ $trend->category->webinars_count }} {{ trans('product.course') }}</div>

                        <h3>{{ $trend->category->title }}</h3>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="swiper-pagination trend-categories-swiper-pagination"></div>
    </div>
</section>-->
@endif
<!--لو في فصول مميزة -->
@if($homeSection->name == \App\Models\HomeSection::$featured_classes and !empty($featureWebinars) and !$featureWebinars->isEmpty())
<section class="home-sections home-sections-swiper container">
    <div class="latest-classes-card">
        <div class="text-content">
            <h2 class="title">{{ trans('home.featured_classes') }}</h2>
            <p class="hint">{{ trans('home.featured_classes_hint') }}</p>
        </div>
    </div>

    <div class="feature-slider-container position-relative d-flex justify-content-center mt-10">
        <div class="swiper-container features-swiper-container pb-25">
            <div class="swiper-wrapper py-10">
                @foreach($featureWebinars as $feature)
                <div class="swiper-slide">

                    <a href="{{ $feature->webinar->getUrl() }}">
                        <div class="feature-slider d-flex h-100" style="background-image: url('{{ $feature->webinar->getImage() }}')">
                            <div class="mask"></div>
                            <div class="p-5 p-md-25 feature-slider-card">
                                <div class="d-flex flex-column feature-slider-body position-relative h-100">
                                    @if($feature->webinar->bestTicket() < $feature->webinar->price)
                                    <span class="badge badge-danger mb-2 ">{{ trans('public.offer',['off' => $feature->webinar->bestTicket(true)['percent']]) }}</span>
                                    @endif
                                    <a href="{{ $feature->webinar->getUrl() }}">
                                        <h3 class="card-title mt-1">{{ $feature->webinar->title }}</h3>
                                    </a>

                                    <div class="user-inline-avatar mt-15 d-flex align-items-center">
                                        <div class="avatar bg-gray200">
                                            <img src="{{ $feature->webinar->teacher->getAvatar() }}" class="img-cover" alt="{{ $feature->webinar->teacher->full_naem }}">
                                        </div>
                                        <a href="{{ $feature->webinar->teacher->getProfileUrl() }}" target="_blank" class="user-name font-14 ml-5">{{ $feature->webinar->teacher->full_name }}</a>
                                    </div>

                                    <p class="mt-25 feature-desc text-gray">{{ $feature->description }}</p>

                                    @include('web.default.includes.webinar.rate',['rate' => $feature->webinar->getRate()])

                                    <div class="feature-footer mt-auto d-flex align-items-center justify-content-between">
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <i data-feather="clock" width="20" height="20" class="webinar-icon"></i>
                                                <span class="duration ml-5 text-dark-blue font-14">{{ convertMinutesToHourAndMinute($feature->webinar->duration) }} {{ trans('home.hours') }}</span>
                                            </div>

                                            <div class="vertical-line mx-10"></div>

                                            <div class="d-flex align-items-center">
                                                <i data-feather="calendar" width="20" height="20" class="webinar-icon"></i>
                                                <span class="date-published ml-5 text-dark-blue font-14">{{ dateTimeFormat(!empty($feature->webinar->start_date) ? $feature->webinar->start_date : $feature->webinar->created_at,'j M Y') }}</span>
                                            </div>
                                        </div>

                                        <div class="feature-price-box">
                                            @if(!empty($feature->webinar->price ) and $feature->webinar->price > 0)
                                            @if($feature->webinar->bestTicket() < $feature->webinar->price)
                                            <span class="real">{{ handlePrice($feature->webinar->bestTicket(), true, true, false, null, true, null, 'USD') }}</span>
                                            @else
                                            {{ handlePrice($feature->webinar->price, true, true, false, null, true, null, 'USD') }}
                                            @endif
                                            @else
                                            @if($feature->webinar->type!='text_lesson')
                                            {{ trans('public.free') }}
                                            @endif
                                            @endif


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <div class="swiper-pagination features-swiper-pagination"></div>
    </div>
</section>
@endif
<!--أحدث الحزم-->
@if($homeSection->name == \App\Models\HomeSection::$latest_bundles and !empty($latestBundles) and !$latestBundles->isEmpty())
<section class="home-sections home-sections-swiper container">
<div class="latest-classes-card">
    <div class="text-content">
            <h2 class="title">{{ trans('update.latest_bundles') }}</h2>
            <p class="hint">{{ trans('update.latest_bundles_hint') }}</p>
        </div>

        <a href="/classes?type[]=bundle" class="cta-btn">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container latest-bundle-swiper px-12">
            <div class="swiper-wrapper py-10">
                @foreach($latestBundles as $latestBundle)
                <div class="swiper-slide">
                    @include('web.default.includes.webinar.grid-card-egy',['webinar' => $latestBundle])
                </div>
                @endforeach

            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination bundle-webinars-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif
<!--الدورات القادمة-->
@if($homeSection->name == \App\Models\HomeSection::$upcoming_courses and !empty($upcomingCourses) and !$upcomingCourses->isEmpty())
<section class="home-sections home-sections-swiper container">
<div class="latest-classes-card">
    <div class="text-content">
            <h2 class="title">{{ trans('update.upcoming_courses') }}</h2>
            <p class="hint">{{ trans('update.upcoming_courses_home_section_hint') }}</p>
        </div>

        <a href="/upcoming_courses?sort=newest" class="cta-btn">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container upcoming-courses-swiper px-12">
            <div class="swiper-wrapper py-20">
                @foreach($upcomingCourses as $upcomingCourse)
                <div class="swiper-slide">
                    @include('web.default.includes.webinar.upcoming_course_grid_card',['upcomingCourse' => $upcomingCourse])
                </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination upcoming-courses-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif
<!--أحدث الفصول-->
@if($homeSection->name == \App\Models\HomeSection::$latest_classes and !empty($latestWebinars) and !$latestWebinars->isEmpty())
<section class="home-sections home-sections-swiper container">
<div class="latest-classes-card">
    <div class="text-content">
        <h2 class="title">{{ trans('home.latest_classes') }}</h2>
        <p class="hint">{{ trans('home.latest_webinars_hint') }}</p>
    </div>
    <a href="{{ '/'.app()->getLocale().'/egy/classes?sort=newest' }}" class="cta-btn">
        {{ trans('home.view_all') }}
    </a>
</div>


    <div class="mt-10 position-relative">
        <div class="latest-webinars-swiper px-12">
           <div class="row mt-20">
                    
                @foreach($latestWebinars->slice(0, 6) as $latestWebinar)
                
                <div class="col-12 col-lg-4">
                    @include('web.default.includes.webinar.list-card-egy',['webinar' => $latestWebinar])
                </div>
                @endforeach

            </div>
        </div>

       
    </div>
</section>
@endif
<!--افضل التقييمات-->
@if($homeSection->name == \App\Models\HomeSection::$best_rates and !empty($bestRateWebinars) and !$bestRateWebinars->isEmpty())
<section class="home-sections home-sections-swiper container">
<div class="latest-classes-card">
    <div class="text-content">
            <h2 class="title">{{ trans('home.best_rates') }}</h2>
            <p class="hint">{{ trans('home.best_rates_hint') }}</p>
        </div>

        <a href="/classes?sort=best_rates" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container best-rates-webinars-swiper px-12">
            <div class="swiper-wrapper py-20">
                @foreach($bestRateWebinars as $bestRateWebinar)
                <div class="swiper-slide">
                    @include('web.default.includes.webinar.grid-card-egy',['webinar' => $bestRateWebinar])
                </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination best-rates-webinars-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif
<!--لافتة إعلانية كاملة-->
@if($homeSection->name == \App\Models\HomeSection::$full_advertising_banner and !empty($advertisingBanners1) and count($advertisingBanners1))
<div class="home-sections container">
    <div class="row">
        @foreach($advertisingBanners1 as $banner1)
        <div class="col-{{ $banner1->size }}">
            <a href="{{ $banner1->link }}">
                <img src="{{ $banner1->image }}" class="img-cover rounded-sm" alt="{{ $banner1->title }}">
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif
<!--الأكثر مبيعا-->
@if($homeSection->name == \App\Models\HomeSection::$best_sellers and !empty($bestSaleWebinars) and !$bestSaleWebinars->isEmpty())
<section class="home-sections container">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="section-title">{{ trans('home.best_sellers') }}</h2>
            <p class="section-hint">{{ trans('home.best_sellers_hint') }}</p>
        </div>

        <a href="/classes?sort=bestsellers" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container best-sales-webinars-swiper px-12">
            <div class="swiper-wrapper py-20">
                @foreach($bestSaleWebinars as $bestSaleWebinar)
                <div class="swiper-slide">
                    @include('web.default.includes.webinar.grid-card-egy',['webinar' => $bestSaleWebinar])
                </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination best-sales-webinars-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$discount_classes and !empty($hasDiscountWebinars) and !$hasDiscountWebinars->isEmpty())
<section class="home-sections container">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="section-title">{{ trans('home.discount_classes') }}</h2>
            <p class="section-hint">{{ trans('home.discount_classes_hint') }}</p>
        </div>

        <a href="/classes?discount=on" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container has-discount-webinars-swiper px-12">
            <div class="swiper-wrapper py-20">
                @foreach($hasDiscountWebinars as $hasDiscountWebinar)
                <div class="swiper-slide">
                    @include('web.default.includes.webinar.grid-card-egy',['webinar' => $hasDiscountWebinar])
                </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination has-discount-webinars-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$free_classes and !empty($freeWebinars) and !$freeWebinars->isEmpty())
<section class="home-sections home-sections-swiper container">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="section-title">{{ trans('home.free_classes') }}</h2>
            <p class="section-hint">{{ trans('home.free_classes_hint') }}</p>
        </div>

        <a href="/classes?free=on" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
    </div>

    <div class="mt-10 position-relative">
        <div class="swiper-container free-webinars-swiper px-12">
            <div class="swiper-wrapper py-20">

                @foreach($freeWebinars as $freeWebinar)
                <div class="swiper-slide">
                    @include('web.default.includes.webinar.grid-card-egy',['webinar' => $freeWebinar])
                </div>
                @endforeach

            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination free-webinars-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$testimonials and !empty($testimonials) and !$testimonials->isEmpty())
<div class="position-relative home-sections testimonials-container">

    <div id="parallax1" class="ltr">
        <div data-depth="0.2" class="gradient-box left-gradient-box"></div>
    </div>

    <section class="container home-sections home-sections-swiper">
        <div class="text-center my-40">
            <h2 class="section-title">{{trans('app.clients')}} </h2>
            <div class="about-line">
                <span></span>
                <i class="fas fa-star-of-life"></i> 
                <span></span>
            </div>
        </div>

        <div class="position-relative mt-20">
            <div class="swiper-container organization-swiper-container px-12">
                <div class="swiper-wrapper py-20">



                    <div class="swiper-slide">

                        <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                            <div class="home-organizations-avatar">
                                <img src="https://canada.ejaabi.com/public/uploads/main/images/10-09-2024/66dfec472cf2d.png" class="img-cover " alt="">
                            </div>



                            <div class="bottom-gradient"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">

                        <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                            <div class="home-organizations-avatar">
                                <img src="https://canada.ejaabi.com/public/uploads/main/images/09-09-2024/66df29d33d845.jpeg" class="img-cover" alt=""      style="object-fit: contain; width: 100%; height: 100%;" />
                            </div>



                            <div class="bottom-gradient"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">

                        <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                            <div class="home-organizations-avatar">
                                <img src="https://canada.ejaabi.com/public/uploads/main/images/10-09-2024/66dfec5251fe1.png" class="img-cover"      style="object-fit: contain; width: 100%; height: 100%;" alt="">
                            </div>



                            <div class="bottom-gradient"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">

                        <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                            <div class="home-organizations-avatar">
                                <img src="https://canada.ejaabi.com/public/uploads/main/images/10-09-2024/66dfec66afcda.png" class="img-cover"     style="object-fit: contain; width: 100%; height: 100%;"  alt="">
                            </div>



                            <div class="bottom-gradient"></div>
                        </div>
                    </div>
                    <!--<div class="swiper-slide">-->

                    <!--    <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">-->
                    <!--        <div class="home-organizations-avatar">-->
                    <!--            <img src="https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeb708b082.png" class="img-cover" alt="">-->
                    <!--        </div>-->



                    <!--        <div class="bottom-gradient"></div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>

            </div>

            <div class="d-flex justify-content-center">
                <div class="swiper-pagination organization-swiper-pagination"></div>
            </div>
        </div>
    </section>

    <div id="parallax2" class="ltr">
        <div data-depth="0.4" class="gradient-box right-gradient-box"></div>
    </div>

    <div id="parallax3" class="ltr">
        <div data-depth="0.8" class="gradient-box bottom-gradient-box"></div>
    </div>
</div>
@endif

@if($homeSection->name == \App\Models\HomeSection::$subscribes and !empty($subscribes) and !$subscribes->isEmpty())
<div class="home-sections position-relative subscribes-container pe-none user-select-none">
    <div id="parallax4" class="ltr d-none d-md-block">
        <div data-depth="0.2" class="gradient-box left-gradient-box"></div>
    </div>

    <section class="container home-sections home-sections-swiper">
        <div class="text-center">
            <h2 class="section-title">{{ trans('home.subscribe_now') }}</h2>
            <p class="section-hint">{{ trans('home.subscribe_now_hint') }}</p>
        </div>

        <div class="position-relative mt-30">
            <div class="swiper-container subscribes-swiper px-12">
                <div class="swiper-wrapper py-20">

                    @foreach($subscribes as $subscribe)
                    @php
                    $subscribeSpecialOffer = $subscribe->activeSpecialOffer();
                    @endphp

                    <div class="swiper-slide">
                        <div class="subscribe-plan position-relative bg-white d-flex flex-column align-items-center rounded-sm shadow pt-50 pb-20 px-20">
                            @if($subscribe->is_popular)
                            <span class="badge badge-primary badge-popular px-15 py-5">{{ trans('panel.popular') }}</span>
                            @elseif(!empty($subscribeSpecialOffer))
                            <span class="badge badge-danger badge-popular px-15 py-5">{{ trans('update.percent_off', ['percent' => $subscribeSpecialOffer->percent]) }}</span>
                            @endif

                            <div class="plan-icon">
                                <img src="{{ $subscribe->icon }}" class="img-cover" alt="">
                            </div>

                            <h3 class="mt-20 font-30 text-secondary">{{ $subscribe->title }}</h3>
                            <p class="font-weight-500 text-gray mt-10">{{ $subscribe->description }}</p>

                            <div class="d-flex align-items-start mt-30">
                                @if(!empty($subscribe->price) and $subscribe->price > 0)
                                @if(!empty($subscribeSpecialOffer))
                                <div class="d-flex align-items-end line-height-1">
                                    <span class="font-36 text-primary">{{ handlePrice($subscribe->getPrice(), true, true, false, null, true) }}</span>
                                    <span class="font-14 text-gray ml-5 text-decoration-line-through">{{ handlePrice($subscribe->price, true, true, false, null, true) }}</span>
                                </div>
                                @else
                                <span class="font-36 text-primary line-height-1">{{ handlePrice($subscribe->price, true, true, false, null, true) }}</span>
                                @endif
                                @else
                                <span class="font-36 text-primary line-height-1">{{ trans('public.free') }}</span>
                                @endif
                            </div>

                            <ul class="mt-20 plan-feature">
                                <li class="mt-10">{{ $subscribe->days }} {{ trans('financial.days_of_subscription') }}</li>
                                <li class="mt-10">
                                    @if($subscribe->infinite_use)
                                    {{ trans('update.unlimited') }}
                                    @else
                                    {{ $subscribe->usable_count }}
                                    @endif
                                    <span class="ml-5">{{ trans('update.subscribes') }}</span>
                                </li>
                            </ul>

                            @if(auth()->check())
                            <form action="/panel/financial/pay-subscribes" method="post" class="w-100">
                                {{ csrf_field() }}
                                <input name="amount" value="{{ $subscribe->price }}" type="hidden">
                                <input name="id" value="{{ $subscribe->id }}" type="hidden">

                                <div class="d-flex align-items-center mt-50 w-100">
                                    <button type="submit" class="btn btn-primary {{ !empty($subscribe->has_installment) ? '' : 'btn-block' }}">{{ trans('update.purchase') }}</button>

                                    @if(!empty($subscribe->has_installment))
                                    <a href="/panel/financial/subscribes/{{ $subscribe->id }}/installments" class="btn btn-outline-primary flex-grow-1 ml-10">{{ trans('update.installments') }}</a>
                                    @endif
                                </div>
                            </form>
                            @else
                            <a href="/login" class="btn btn-primary btn-block mt-50">{{ trans('update.purchase') }}</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
            <div class="d-flex justify-content-center">
                <div class="swiper-pagination subscribes-swiper-pagination"></div>
            </div>

        </div>
    </section>

    <div id="parallax5" class="ltr d-none d-md-block">
        <div data-depth="0.4" class="gradient-box right-gradient-box"></div>
    </div>

    <div id="parallax6" class="ltr d-none d-md-block">
        <div data-depth="0.6" class="gradient-box bottom-gradient-box"></div>
    </div>
</div>
@endif

@if($homeSection->name == \App\Models\HomeSection::$find_instructors and !empty($findInstructorSection))
<section class="home-sections home-sections-swiper container find-instructor-section position-relative">
    <div class="row align-items-center">
        <div class="col-12 col-lg-6">
            <div class="">
                <h2 class="font-36 font-weight-bold text-dark">{{ $findInstructorSection['title'] ?? '' }}</h2>
                <p class="font-16 font-weight-normal text-gray mt-10">{{ $findInstructorSection['description'] ?? '' }}</p>

                <div class="mt-35 d-flex align-items-center">
                    @if(!empty($findInstructorSection['button1']) and !empty($findInstructorSection['button1']['title']) and !empty($findInstructorSection['button1']['link']))
                    <a href="{{ $findInstructorSection['button1']['link'] }}" class="btn btn-primary mr-15">{{ $findInstructorSection['button1']['title'] }}</a>
                    @endif

                    @if(!empty($findInstructorSection['button2']) and !empty($findInstructorSection['button2']['title']) and !empty($findInstructorSection['button2']['link']))
                    <a href="{{ $findInstructorSection['button2']['link'] }}" class="btn btn-outline-primary">{{ $findInstructorSection['button2']['title'] }}</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mt-20 mt-lg-0">
            <div class="position-relative ">
                <img src="{{ $findInstructorSection['image'] }}" class="find-instructor-section-hero" alt="{{ $findInstructorSection['title'] }}">
                <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle">
                <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots">

                <div class="example-instructor-card bg-white rounded-sm shadow-lg  p-5 p-md-15 d-flex align-items-center">
                    <div class="example-instructor-card-avatar">
                        <img src="/assets/default/img/home/toutor_finder.svg" class="img-cover rounded-circle" alt="user name">
                    </div>

                    <div class="flex-grow-1 ml-15">
                        <span class="font-14 font-weight-bold text-secondary d-block">{{ trans('update.looking_for_an_instructor') }}</span>
                        <span class="text-gray font-12 font-weight-500">{{ trans('update.find_the_best_instructor_now') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$reward_program and !empty($rewardProgramSection))
<section class="home-sections home-sections-swiper container reward-program-section position-relative">
    <div class="row align-items-center">
        <div class="col-12 col-lg-6">
            <div class="position-relative reward-program-section-hero-card">
                <img src="{{ $rewardProgramSection['image'] }}" class="reward-program-section-hero" alt="{{ $rewardProgramSection['title'] }}">

                <div class="example-reward-card bg-white rounded-sm shadow-lg p-5 p-md-15 d-flex align-items-center">
                    <div class="example-reward-card-medal">
                        <img src="/assets/default/img/rewards/medal.png" class="img-cover rounded-circle" alt="medal">
                    </div>

                    <div class="flex-grow-1 ml-15">
                        <span class="font-14 font-weight-bold text-secondary d-block">{{ trans('update.you_got_50_points') }}</span>
                        <span class="text-gray font-12 font-weight-500">{{ trans('update.for_completing_the_course') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mt-20 mt-lg-0">
            <div class="">
                <h2 class="font-36 font-weight-bold text-dark">{{ $rewardProgramSection['title'] ?? '' }}</h2>
                <p class="font-16 font-weight-normal text-gray mt-10">{{ $rewardProgramSection['description'] ?? '' }}</p>

                <div class="mt-35 d-flex align-items-center">
                    @if(!empty($rewardProgramSection['button1']) and !empty($rewardProgramSection['button1']['title']) and !empty($rewardProgramSection['button1']['link']))
                    <a href="{{ $rewardProgramSection['button1']['link'] }}" class="btn btn-primary mr-15">{{ $rewardProgramSection['button1']['title'] }}</a>
                    @endif

                    @if(!empty($rewardProgramSection['button2']) and !empty($rewardProgramSection['button2']['title']) and !empty($rewardProgramSection['button2']['link']))
                    <a href="{{ $rewardProgramSection['button2']['link'] }}" class="btn btn-outline-primary">{{ $rewardProgramSection['button2']['title'] }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$become_instructor and !empty($becomeInstructorSection))
<section class="home-sections home-sections-swiper container find-instructor-section position-relative">
    <div class="row align-items-center">
        <div class="col-12 col-lg-6">
            <div class="">
                <h2 class="font-36 font-weight-bold text-dark">{{ $becomeInstructorSection['title'] ?? '' }}</h2>
                <p class="font-16 font-weight-normal text-gray mt-10">{{ $becomeInstructorSection['description'] ?? '' }}</p>

                <div class="mt-35 d-flex align-items-center">
                    @if(!empty($becomeInstructorSection['button1']) and !empty($becomeInstructorSection['button1']['title']) and !empty($becomeInstructorSection['button1']['link']))
                    <a href="{{ empty($authUser) ? '/login' : (($authUser->isUser()) ? $becomeInstructorSection['button1']['link'] : '/panel/financial/registration-packages') }}" class="btn btn-primary mr-15">{{ $becomeInstructorSection['button1']['title'] }}</a>
                    @endif

                    @if(!empty($becomeInstructorSection['button2']) and !empty($becomeInstructorSection['button2']['title']) and !empty($becomeInstructorSection['button2']['link']))
                    <a href="{{ empty($authUser) ? '/login' : (($authUser->isUser()) ? $becomeInstructorSection['button2']['link'] : '/panel/financial/registration-packages') }}" class="btn btn-outline-primary">{{ $becomeInstructorSection['button2']['title'] }}</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mt-20 mt-lg-0">
            <div class="position-relative ">
                <img src="{{ $becomeInstructorSection['image'] }}" class="find-instructor-section-hero" alt="{{ $becomeInstructorSection['title'] }}">
                <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle">
                <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots">

                <div class="example-instructor-card bg-white rounded-sm shadow-lg border p-5 p-md-15 d-flex align-items-center">
                    <div class="example-instructor-card-avatar">
                        <img src="/assets/default/img/home/become_instructor.svg" class="img-cover rounded-circle" alt="user name">
                    </div>

                    <div class="flex-grow-1 ml-15">
                        <span class="font-14 font-weight-bold text-secondary d-block">{{ trans('update.become_an_instructor') }}</span>
                        <span class="text-gray font-12 font-weight-500">{{ trans('update.become_instructor_tagline') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$forum_section and !empty($forumSection))
<section class="home-sections home-sections-swiper container find-instructor-section position-relative">
    <div class="row align-items-center">
        <div class="col-12 col-lg-6 mt-20 mt-lg-0">
            <div class="position-relative ">
                <img src="{{ $forumSection['image'] }}" class="find-instructor-section-hero" alt="{{ $forumSection['title'] }}">
                <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle">
                <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots">
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="">
                <h2 class="font-36 font-weight-bold text-dark">{{ $forumSection['title'] ?? '' }}</h2>
                <p class="font-16 font-weight-normal text-gray mt-10">{{ $forumSection['description'] ?? '' }}</p>

                <div class="mt-35 d-flex align-items-center">
                    @if(!empty($forumSection['button1']) and !empty($forumSection['button1']['title']) and !empty($forumSection['button1']['link']))
                    <a href="{{ $forumSection['button1']['link'] }}" class="btn btn-primary mr-15">{{ $forumSection['button1']['title'] }}</a>
                    @endif

                    @if(!empty($forumSection['button2']) and !empty($forumSection['button2']['title']) and !empty($forumSection['button2']['link']))
                    <a href="{{ $forumSection['button2']['link'] }}" class="btn btn-outline-primary">{{ $forumSection['button2']['title'] }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$video_or_image_section and !empty($boxVideoOrImage))
<section class="home-sections home-sections-swiper position-relative">
    <div class="home-video-mask"></div>
    <div class="container home-video-container d-flex flex-column align-items-center justify-content-center position-relative" style="background-image: url('{{ $boxVideoOrImage['background'] ?? '' }}')">
        <a href="{{ $boxVideoOrImage['link'] ?? '' }}" class="home-video-play-button d-flex align-items-center justify-content-center position-relative">
            <i data-feather="play" width="36" height="36" class=""></i>
        </a>

        <div class="mt-50 pt-10 text-center">
            <h2 class="home-video-title">{{ $boxVideoOrImage['title'] ?? '' }}</h2>
            <p class="home-video-hint mt-10">{{ $boxVideoOrImage['description'] ?? '' }}</p>
        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$instructors and !empty($instructors) and !$instructors->isEmpty())
<section class="home-sections container" >
    <div class="text-center my-40">
        <div>
            <h2 class="section-title">{{trans('app.comapny')}} </h2>
            <div class="about-line">
                <span></span>
                <i class="fas fa-star-of-life"></i> 
                <span></span>
            </div>
        </div>


    </div>

    <div class="position-relative mt-20 ltr">
        <div class="owl-carousel customers-testimonials instructors-swiper-container">


            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://canada.ejaabi.com/public/uploads/main/images/22-05-2024/664d96b0442a6.jpeg" alt="" class="img-cover">
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://canada.ejaabi.com/public/uploads/main/images/22-05-2024/664d96d1d67c1.png" alt=""      style="object-fit: contain; width: 100%; height: 100%;" />

                            
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>
            
            
             <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://canada.ejaabi.com/public/uploads/main/images/22-05-2024/664d96deb01c4.png" alt=""      style="object-fit: contain; width: 100%; height: 100%;" />

                            
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://canada.ejaabi.com/public/uploads/main/images/02-12-2023/656ae1e67060d.jpeg" alt="" class=" img-cover">
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://ejaabi.com/public/uploads/main/images/04-12-2023/656e2faf5e7a3.jpeg" alt="" class=" img-cover">
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://ejaabi.com/public/uploads/main/images/19-05-2024/6649ba3691866.jpg" alt="" class=" img-cover">
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
<img src="https://canada.ejaabi.com/public/uploads/main/images/27-12-2023/658c10b1e31d2.png" 
     alt="" 
     style="object-fit: contain; width: 100%; height: 100%;" />
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
@endif

@if($homeSection->name == \App\Models\HomeSection::$half_advertising_banner and !empty($advertisingBanners2) and count($advertisingBanners2))
<div class="home-sections container">
    <div class="row">
        @foreach($advertisingBanners2 as $banner2)
        <div class="col-{{ $banner2->size }}">
            <a href="{{ $banner2->link }}">
                <img src="{{ $banner2->image }}" class="img-cover rounded-sm" alt="{{ $banner2->title }}">
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

@if($homeSection->name == \App\Models\HomeSection::$organizations and !empty($organizations) and !$organizations->isEmpty())
<section class="home-sections home-sections-swiper container">
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="section-title">{{ trans('home.organizations') }}</h2>
            <p class="section-hint">{{ trans('home.organizations_hint') }}</p>
        </div>

        <a href="/organizations" class="btn btn-border-white">{{ trans('home.all_organizations') }}</a>
    </div>

    <div class="position-relative mt-20">
        <div class="swiper-container organization-swiper-container px-12">
            <div class="swiper-wrapper py-20">

                @foreach($organizations as $organization)
                <div class="swiper-slide">
                    <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                        <div class="home-organizations-avatar">
                            <img src="{{ $organization->getAvatar(120) }}" class="img-cover rounded-circle" alt="{{ $organization->full_name }}">
                        </div>
                        <a href="{{ $organization->getProfileUrl() }}" class="mt-25 d-flex flex-column align-items-center justify-content-center">
                            <h3 class="home-organizations-title">{{ $organization->full_name }}</h3>
                            <p class="home-organizations-desc mt-10">{{ $organization->bio }}</p>
                            <span class="home-organizations-badge badge mt-15">{{ $organization->webinars_count }} {{ trans('panel.classes') }}</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="swiper-pagination organization-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif
@endforeach
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
    <script src="/assets/default/js/parts/home.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const heroSlider = new Swiper('.hero-slider', {
                effect: 'slide',
                speed: 1000,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination', // Keep this for default pagination (dots)
                    clickable: true,
                },
                on: {
                    init: function() {
                        updateProgress(this);
                    },
                    slideChange: function() {
                        updateProgress(this);
                    },
                }
            });

            // Add event listeners to custom navigation buttons
            document.querySelectorAll('.customised-pagination-bullet').forEach((bullet, index) => {
                bullet.addEventListener('click', () => {
                    heroSlider.slideTo(index);
                });
            });

            // Update active state for custom buttons
            heroSlider.on('slideChange', function() {
                document.querySelectorAll('.customised-pagination-bullet').forEach((bullet, index) => {
                    if (index === heroSlider.activeIndex) {
                        bullet.classList.add('customised-pagination-bullet-active');
                    } else {
                        bullet.classList.remove('customised-pagination-bullet-active');
                    }
                });
            });

            function updateProgress(swiper) {
                const progress = document.querySelector('.progress-bar');
                progress.style.width = '0%';

                setTimeout(() => {
                    progress.style.width = '100%';
                }, 100);
            }
        });
    </script>
@endpush
