<style>
.banner-area, .banner-two-area {
  overflow: hidden;
  position: relative;
}
.banner__dot-wrp {
  position: absolute;
  bottom: 40px;
  left: 50%;
  transform: translate(-50%);
  z-index: 2;
}
.banner__shape-left1 {
  position: absolute;
  top: 30px;
  left: 0;
}
.banner__shape-left2 {
  position: absolute;
  top: 60px;
  left: 0;
}
.banner__shape-left3 {
  position: absolute;
  bottom: 0px;
  left: 0;
}
.banner__shape-right1 {
  position: absolute;
  bottom: 0px;
  right: 0;
}
@media (max-width: 767px) {
  .banner__shape-right1 {
    display: none;
  }
}
.banner__shape-right2 {
  position: absolute;
  bottom: 0px;
  right: 0;
}
@media (max-width: 767px) {
  .banner__shape-right2 {
    display: none;
  }
}
.banner__line {
  position: absolute;
  bottom: 25%;
  left: 33%;
  z-index: 2;
}
.banner__right-line1, .banner__right-line4, .banner__right-line3, .banner__right-line2 {
  position: absolute;
  top: -65px;
  right: 0;
}
.banner__content, .banner-two__content, .banner-three__content {
  padding: 140px 0;
  position: relative;
}
@media (max-width: 991px) {
  .banner__content, .banner-two__content, .banner-three__content {
    padding: 100px 0;
  }
}
.banner__content h4, .banner-two__content h4, .banner-three__content h4 {
  text-transform: uppercase;
  font-size: 18px;
  line-height: 32px;
  font-weight: 600;
  letter-spacing: 1px;
}
.banner__content h4 svg, .banner-two__content h4 svg, .banner-three__content h4 svg {
  margin-top: -4px;
}
.banner__content h1, .banner-two__content h1, .banner-three__content h1 {
  font-size: 40px;
  line-height: 40px;
  font-weight: 700;
}
@media (max-width: 991px) {
  .banner__content h1, .banner-two__content h1, .banner-three__content h1 {
    font-size: 30px;
    line-height: 25px;
  }
}
@media (max-width: 767px) {
  .banner__content h1, .banner-two__content h1, .banner-three__content h1 {
    font-size: 25px;
    line-height: 30px;
  }
}
@media (max-width: 575px) {
  .banner__content h1, .banner-two__content h1, .banner-three__content h1 {
    font-size: 20px;
    line-height: 25px;
  }
}
.banner__content p, .banner-two__content p, .banner-three__content p {
  color: var(--white);
  opacity: 90%;
  
}
.banner__slider .slide-bg {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  opacity: 1;
  z-index: -2;
  background-repeat: no-repeat;
  background-position: center top;
  background-size: cover;
  transform: scale(1);
  -webkit-transition: all 9s ease-out 0s;
  -moz-transition: all 9s ease-out 0s;
  -ms-transition: all 9s ease-out 0s;
  -o-transition: all 9s ease-out 0s;
  transition: all 9s ease-out 0s;
}
.banner__slider .swiper-slide-active .slide-bg {
  -webkit-transform: scale(1.1);
  -moz-transform: scale(1.1);
  transform: scale(1.1);
}
.banner-two__shape1 {
  position: absolute;
  right: 0;
  top: 100px;
}
@media (max-width: 575px) {
  .banner-two__shape1 {
    display: none;
  }
}
.banner-two__shape2 {
  position: absolute;
  right: 0;
  top: 130px;
}
@media (max-width: 575px) {
  .banner-two__shape2 {
    display: none;
  }
}
.banner-two__line-left {
  position: absolute;
  left: 0;
  top: 100px;
}
.banner-two__circle-solid {
  position: absolute;
  bottom: -80px;
  left: -100px;
}
.banner-two__circle-regular {
  position: absolute;
  bottom: -80px;
  left: -100px;
}
.banner-two__right-shape {
  position: absolute;
  bottom: 0;
  right: 0;
}
.banner-two__line {
  position: absolute;
  left: 17%;
  top: 25%;
  z-index: 2;
}
@media (max-width: 575px) {
  .banner-two__line {
    display: none;
  }
}
.banner-two__dot-wrp {
  bottom: 120px;
}
.banner-two__content, .banner-three__content {
  max-width: 950px;
  margin: 0 auto;
  padding: 250px 0;
}
@media (max-width: 991px) {
  .banner-two__content, .banner-three__content {
    padding: 150px 0;
  }
}
.banner-two__content h1, .banner-three__content h1 {
  font-size: 50px;
  line-height: 100px;
}
@media (max-width: 991px) {
  .banner-two__content h1, .banner-three__content h1 {
    font-size: 40px;
    line-height: 70px;
  }
}
@media (max-width: 575px) {
  .banner-two__content h1, .banner-three__content h1 {
    font-size: 23px;
    line-height: 20px;
  }
}
.banner-two__content h4, .banner-three__content h4 {
  background-color: rgba(255, 255, 255, 0.1);
  display: inline-block;
  padding: 0px 15px;
}
@media (max-width: 575px) {
  .banner-two__content h4, .banner-three__content h4 {
    padding: 0px 10px;
    font-size: 14px;
    margin-bottom: 5px;
  }
}
@media (max-width: 575px) {
  .banner-two__content p, .banner-three__content p {
    font-size: 14px;
    margin-top: 10px;
  }
}
@media (max-width: 575px) {
  .banner-two__content .btn-one, .banner-three__content .btn-one {
    margin-top: 30px;
  }
}

.btn-one {
    margin-top: 60px;
  padding: 15px 25px;
  font-weight: 600;
  color: var(--white);
  transition: var(--transition);
  text-transform: capitalize;
  position: relative;
  z-index: 1;
  overflow: hidden;
}
.btn-one i {
  margin-left: 8px;
  transition: var(--transition);
}
@media (max-width: 575px) {
  .btn-one i {
    margin-left: 3px;
    font-size: 12px;
  }
}
@media (max-width: 575px) {
  .btn-one {
    padding: 8px 18px;
    font-size: 14px;
  }
}
.btn-one::after {
  position: absolute;
  top: 0;
  right: 0;
  width: 50%;
  height: 0;
  content: "";
  background-color: var(--secondary-color);
  z-index: -1;
  transition: var(--transition);
}
.btn-one::before {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 50%;
  height: 0;
  content: "";
  background-color: var(--secondary-color);
  z-index: -1;
  transition: var(--transition);
}
.btn-one:hover {
  color: var(--white);
}
.btn-one:hover::before {
  height: 100%;
}
.btn-one:hover::after {
  height: 100%;
}
.btn-one:hover i {
  transform: translate(5px);
}

.banner__content h1, .banner-two__content h1, .banner-three__content h1{

color: #fff;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
  animation-delay: 0.5s;
  animation-duration: 2s;
}
.banner__content p, .banner-two__content p, .banner-three__content p{
 color: #fff;
 opacity:90%;
 max-width:800px;
 margin-top: 20px;
  text-shadow: 2px 2px 4px rgb(12 85 189);
  animation-delay: 0.5s;
  animation-duration: 2s;
}
.btn22{
   margin-right:5px;
    box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
    color:#0047ac;
    text-align: :center;
}
    </style>
   

        <section class="banner-area">
          
            <div class="swiper banner__slider">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
             <div class="swiper-slide">
                       
         <div class="slide-bg" data-background="/store/1/default_images/hero_1.jpg"></div>
                        
                        <div class="container">
                            <div class="banner__content">
                             <h1 data-animation="slideInRight" data-duration="2s" data-delay=".5s"
                                    class="text-white">
                                    تطوير المحتوى
                                </h1>
                                <p data-animation="slideInRight" data-duration="2s" data-delay=".7s">
                                    نلتزم  بتطوير المحتوى المرخص من المركز الوطني للتعليم الإلكتروني بإنتاج وتطوير محتوى عالي الجودة في قلب التواصل والمشاركة الفعالة.


                                </p>
                                  <a data-animation="slideInRight" data-duration="2s" data-delay=".9s" href="/classes?sort=newest"
                                   class="btn btn-sm btn-primary nav-start-a-live-btn btn-one">تفاصيل </a>
                                                      
                                   <a data-animation="slideInRight" data-duration="4s" data-delay="1s" href="/classes?sort=newest"
                                   class="btn btn-sm btn-primary nav-start-a-live-btn  btn-one btn22">الدورات التدريبية </a>
                                </div>
                        </div>
                    </div>
                    @endforeach

                    <!-----end slide--->
                           
                        </div>
                        
        </div>
        <div class="banner__dot-wrp">
            <div class="dot-light banner__dot"></div>
        </div>
    </section>	