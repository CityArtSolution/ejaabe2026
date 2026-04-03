@php
    $socials = getSocials();
    if (!empty($socials) and count($socials)) {
        $socials = collect($socials)->sortBy('order')->toArray();
    }

    $footerColumns = getFooterColumns();
@endphp

<style>
    .footer-social a {
        display: inline-block;
        margin-right: 15px;
        transition: transform 0.3s ease, filter 0.3s ease;
    }
    .footer-social a:last-child {
        margin-right: 0;  
    }
    .footer-social a:hover {
        transform: scale(1.2);
        filter: brightness(1.2);
        /* أو تقدر تضيف لون ظل أو تغيير لون */
        cursor: pointer;
    }
    .footer-social img {
        height: 24px; /* حجم موحد */
        width: auto;
        display: block;
    }
        .footer-links p {
        margin-bottom: 0.5rem;
    }
    .footer-links a:hover {
        text-decoration: underline;
        color: #f0ad4e; /* لون هيدر أو برتقالي فاتح عند الهور */
        transition: color 0.3s ease;
    }
    .footer-social a img {
  filter: drop-shadow(0 0 8px var(--glow-color, #00f));
}
.footer .footer-copyright-card:before {
    content: "";
    position: absolute;
    inset: 0;
    opacity: 0.15;
    background-color: #eef2f6;
    z-index: 1;
}
</style>

<footer class="footer  position-relative user-select-none" style="background:#eef2f6;direction: ltr;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-subscribe d-block d-md-flex align-items-center justify-content-between" style="background: #eef2f6;">
                </div>
            </div>
        </div>
    </div>

    @php
        $columns = ['first_column', 'second_column', 'third_column', 'forth_column'];
    @endphp

    <div class="container">
        <div class="row" style="margin-right: -4%;margin-left: -4%;">

            @foreach($columns as $column)
                @if(!empty($footerColumns[$column]))

                    @if($column != 'second_column' && $column != 'third_column' && $column != 'forth_column')
                        <div class="col-md-3 col-sm-6">
                            <span class="header d-block font-weight-bold mt-20 mb-3" style="color: #12669f !important;">Policies</span>
                            <div class="mt-20 footer-links" style="    font-weight: 500;">
                                <p style="line-height: 23px;">
                                    <a style="color:#4f547b;" href="/{{ app()->getLocale() }}/canada/policy" target="_blank" class="text-decoration-none">Privacy policies</a>
                                </p>
                                <p style="line-height: 23px;">
                                    <a style="color:#4f547b;" href="/{{ app()->getLocale() }}/canada/commitment/copyright" target="_blank" class="text-decoration-none">Commitment to intellectual property rights</a>
                                </p>
                                <p style="line-height: 23px;">
                                    <a style="color:#4f547b;" href="/{{ app()->getLocale() }}/canada/support/policy" target="_blank" class="text-decoration-none">Technical support policy</a>
                                </p>
                                <p style="line-height: 23px;">
                                    <a style="color:#4f547b;" href="/{{ app()->getLocale() }}/canada/academic" target="_blank" class="text-decoration-none">Academic integrity policy</a>
                                </p>
                                <p style="line-height: 23px;">
                                    <a style="color:#4f547b;" href="/{{ app()->getLocale() }}/canada/Virtual" target="_blank" class="text-decoration-none">Virtual attendance policy</a>
                                </p>
                            </div>
                        </div>
                    @elseif($column == 'second_column')
                        <div class="col-md-2 col-sm-6" style="    font-weight: 500;color: #12669f !important;">
                            <span class="header d-block font-weight-bold mt-20 mb-3" style="color: #12669f !important;">Company Info</span>
                            <div class="mt-20 footer-links">
                                <p style="line-height: 23px;">
                                    <a style="color:#4f547b;" href="/{{ app()->getLocale() }}/canada/classes?sort=newest" target="_blank" class="text-decoration-none">Courses</a>
                                </p>
                                <p style="line-height: 23px;">
                                    <a style="color:#4f547b;" href="/{{ app()->getLocale() }}/aboutUs/canada" target="_blank" class="text-decoration-none">About us</a>
                                </p>
                                <p style="line-height: 23px;">
                                    <a style="color:#4f547b;" href="{{ url('/en/contactus') }}" target="_blank" class="text-decoration-none">Contact us</a>
                                </p>
                                <p style="line-height: 23px;">
                                    <a style="color:#4f547b;" href="/{{ app()->getLocale() }}/canada/term" target="_blank" class="text-decoration-none">Terms and Conditions</a>
                                </p>

                            </div>

                        </div>
                    @elseif($column == 'third_column')
                        <div class="col-md-2 col-sm-6" style="text-align: center;">
                            @if(!empty($footerColumns[$column]['title']))
                                <span class="header d-block  font-weight-bold " style="color: #12669f !important; color: #12669f !important;margin: 20px 0;text-align: justify;"> Blogs & News </span>
                            @endif

                            @if(!empty($footerColumns[$column]['value']))
                        <div class="mt-20" style="
                            text-align: left;
                            color: #4f547b;
                            font-weight: 500;
                            line-height: 0.4;">
                            
                            <br>
                            <span>News</span>
                        </div>
                            @endif
                        </div>
                    @elseif($column == 'forth_column')
                        <div class="col-md-4 col-sm-6">
                            <!-- Logo -->
                            <div class="footer-logo mb-4">  <!-- مسافة أسفل اللوجو -->
                                <a href="/canada">
                                    @if(!empty($generalSettings['footer_logo']))
                                        <img src="{{ asset('store/1/657400958cf84.png') }}" class="img-cover" alt="footer logo" />
                                    @endif
                                </a>
                            </div>
                        <hr style="margin-top: 16px;
    margin-bottom: 16px;
    border: 0;
    border-top: 1px solid #4f547b">
                            <!-- Social -->
                        <div class="footer-social mb-3 mt-3"> 
                            <ul style="    gap: 24px;" class="d-flex social-icon social-icon-border-none text-22">
                            <li>
                                 <a style="font-size: 22px;color: #6e7393 !important;" href="https://www.facebook.com/EjabeeInteraction" class="icon social-icon social-icon-facebook-square text-22 text-green-700 hover:svg-white fab fa-facebook-square" target="_blank">
                                </a>
</li>
                            <li>
                                <a style="font-size: 22px;color: #6e7393 !important;" href="https://twitter.com/ejaabi" target="_blank">
                                     <style>
                                    .fontawesomesvgf {width: 1em;
                                    height: 1em;
                                    vertical-align: -.125em;
                                    fill:#4f547b;
                                    }
                                    </style>
                                <svg class="fontawesomesvgf" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                    <path d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z"></path>
                                </svg>
                            </a>
                            </li>
                            <li>
                                 <a style="font-size: 22px;color: #6e7393 !important;" href="https://www.linkedin.com/company/ejaabi" class="icon social-icon social-icon-facebook-square text-22 text-green-700 hover:svg-white fab fa-linkedin" target="_blank">
                                </a>
                            </li>
                            <li>
                                 <a style="font-size: 22px;color: #6e7393 !important;" href="https://www.instagram.com/ejaabi_sa/?hl=en" class="icon social-icon social-icon-facebook-square text-22 text-green-700 hover:svg-white fab fa-instagram" target="_blank">
                                </a>
</li>
                            <li>
                                 <a style="font-size: 22px;color: #6e7393 !important;" href="https://t.snapchat.com/6OG4LLJP" class="icon social-icon social-icon-facebook-square text-22 text-green-700 hover:svg-white fab fa-snapchat" target="_blank">
                                </a>
</li>
                            </ul>
                        </div>                       
                            <span class="header d-block  font-weight-bold text-center">{{ trans('footer.join_us_today') }}</span>
                        
                            <div class="footer-subscribe" style="background: #eef2f6;">
                        
                                <div class="subscribe-input bg-white p-10 flex-grow-1 mt-30 mt-md-0 mb-4">
                                    <form action="/newsletters" method="post">
                                        {{ csrf_field() }}
                        
                                        <div class="form-group d-flex align-items-center m-0">
                                            <div class="w-100">
                                                <input type="text" name="newsletter_email" class="form-control border-0 @error('newsletter_email') is-invalid @enderror" placeholder="{{ trans('footer.enter_email_here') }}" />
                                                @error('newsletter_email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary rounded-pill">{{ trans('footer.join') }}</button>
                                        </div>
                                    </form>
                                </div>
                        
                                <div class="subscribe-input bg-white p-10 flex-grow-1 mt-30 mt-md-20" style="justify-content: center; display: flex;">
                                    <img src="https://ejaabi.com/public/assets/pay.jpeg" style="max-width:137px" />
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach

        </div>
    </div>

    @if(getOthersPersonalizationSettings('platform_phone_and_email_position') == 'footer')
        <div class="footer-copyright-card">
            <div class="container d-flex align-items-center justify-content-between py-15">
            <!--    <div class="font-14  text-center">{{ trans('update.platform_copyright_hint') }}&copy;</div>-->

            <!--    <div class="d-flex align-items-center justify-content-center">-->
            <!--        @if(!empty($generalSettings['site_phone']))-->
            <!--            <div class="d-flex align-items-center  font-14 numen" style="color:#fff">-->
            <!--                <i data-feather="phone" width="20" height="20" class="mr-10"></i>-->
            <!--                <span style="color:#fff">{{ $generalSettings['site_phone'] }}</span>-->
            <!--            </div>-->
            <!--        @endif-->

            <!--        @if(!empty($generalSettings['site_email']))-->
            <!--            <div class="border-left mx-5 mx-lg-15 h-100"></div>-->

            <!--            <div class="d-flex align-items-center  font-14 numen">-->
            <!--                <i data-feather="mail" width="20" height="20" class="mr-10"></i>-->
            <!--                {{ $generalSettings['site_email'] }}-->
            <!--            </div>-->
            <!--        @endif-->
            <!--    </div>-->
            </div>
        </div>
    @endif

</footer>
