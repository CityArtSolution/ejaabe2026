@extends(getTemplate().'.layouts.canada_app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
  <link href="/assets/demo/assets/css/flaticon-set.css" rel="stylesheet">
<style>
    .home-sections {
        margin-top:80px !important;
    }
    </style>
@endpush
@section('content')


   <section class="cart-banner position-relative text-center">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-12 col-md-9 col-lg-7">
                    <h1 class="font-30 text-white font-weight-bold">  {{trans('app.about')}}  </h1>
                </div>
            </div>
        </div>
    </section>
@if( App::getLocale()=='ar')
    <section class="home-sections position-relative">
   <div data-anim-wrap="" class="container animated">
           <div class="row y-gap-50 justify-between items-center">
            <div class="col-lg-8  sm:pr-15">
              
                      <h2>رسالة رئيس مجلس المديرين</h2>

                <div class="composition -type-8">
                   
                     <p class="text-dark-1 mt-30">
                    شكلت السنوات الماضية نقطة تحول رئيسية لمجتمعنا. جنبًا إلى جنب مع رؤية المملكة العربية السعودية الطموحة 2030.  من خلال طرح هذه التغييرات ، فقد اختبرنا القوة الهائلة والقيمة الهائلة لمنظمات التمكين الإيجابي والأشخاص ذوي المعرفة والمهارات القوية ليكونوا متوافقين مع المتطلبات الأساسية والتغييرات الديناميكية..
                </p>
                </div>
            </div>

            <div class="col-lg-4">
    <div class="-el-1" style="position: relative;">
        <img src="https://canada.ejaabi.com/public/uploads/main/images/05-08-2024/66b0c18e44253.jpeg" alt="image" style="max-height: 300px;">
        <div class="author-name" style="position: relative; background-color: rgb(240 243 246); color: #1363a1; padding: 10px;max-width:270px;text-align:center">
د. رائد الحمداني        </div>
    </div>
</div>
        </div>
        <br>
        <hr>
        <div class="row y-gap-50 justify-between items-center">
            <div class="col-lg-6 pr-50 sm:pr-15">
                <div class="composition -type-8">
                    <div class="-el-1"><img src="https://ejaabi.com/public/uploads/main/images/09-12-2023/65740261a4699.png" alt="image" style="max-height:300px"></div>
                </div>
            </div>

            <div class="col-lg-5">

                <br>
                <h2 class="text-30 lh-16"> نبذة عن التفاعل الإيجابي</h2>
                <p class="text-dark-1 mt-30">
                    التفاعل الإيجابي للتدريب والاستشارات (إيجابي) من أهم بيوت الخبرة في مجال التدريب والاستشارات الإدارية والتعليمية المتكاملة للمؤسسات والأفراد في القطاعين العام والخاص.  مع المهنيين ذوي الخبرة والكفاءات الوطنية والدولية، يواكب التفاعل الإيجابي التطورات في مختلف قطاعات الأعمال. هذا التفاعل الإيجابي جعلها وجهة موثوقة منذ عام 2011..
                </p>
                 

            </div>
        </div>
    </div>
    </section>
    
   <section class="home-sections container">
    <div class="text-center my-40">
        <div>
            <h2 class="section-title">من نحن </h2>
            <p class="section-hint"></p>
        </div>


    </div>
             <div class="modern-services-area bottom-less">
        <div class="container">
            
                <div class="services-box text-center">
                    <div class="row">
                    <!-- Single Item -->
                    <div class="single-item col-md-4 col-sm-6">
                        <div class="item noground">
                            <div class="icon">
                                <i class="flaticon-hr"></i>
                            </div>
                            <div class="content">
                                <h4>  	 رؤيتنا   </h4>
                                <p>
                                  أن نكون مرجعاً موثوقاً في مجال التدريب والاستشارات محلياً وإقليمياً.
                                </p>
                               
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                    <!-- Single Item -->
                    <div class="single-item col-md-4 col-sm-6">
                        <div class="item noground">
                            <div class="icon">
                                <i class="flaticon-value"></i>
                            </div>
                            <div class="content">
                                <h4>  قيمنا 	</h4>
                                <p>
                                   <p>- المسئولية&nbsp;</p>

<p>- والابتكار</p>
<p>- الالتزام</p>
                                </p>
                                
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                    <!-- Single Item -->
                    <div class="single-item col-md-4 col-sm-6">
                        <div class="item noground">
                            <div class="icon">
                                
                                <i class="flaticon-start"></i>
                            </div>
                            <div class="content">
                                <h4>   	رسالتنا</h4>
                                <p>
                                 نعمل مع محترفين ذوي خبرة استثنائية لتوفير رأس مال فكري يواكب المتغيرات المحلية والدولية، ونعتمد أفضل الممارسات المهنية في تقديم خدماتنا في كلا المجالين:

 التدريب.

الاستشارات الإدارية والتعليمية.
                                </p>
                                
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                     
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
    @else 
      <section class="home-sections position-relative">
   <div data-anim-wrap="" class="container animated">
           <div class="row y-gap-50 justify-between items-center">
            <div class="col-lg-8 pr-50 sm:pr-15">
              
                      <h2>Message from CEO</h2>

                <div class="composition -type-8">
                   
                     <p class="text-dark-1 mt-30">
The past years marked a major turning point for our society. Along with the ambitious 2030 Vision of the Kingdom of Saudi Arabia. In throwing these changes in, we have experienced the great power and value of empowering organizations and individuals positively with a solid knowledge and skills to be compatible with the basic requirements and dynamic changes.

                </p>
                </div>
            </div>

            <div class="col-lg-4">
    <div class="-el-1" style="position: relative;">
        <img src="https://canada.ejaabi.com/public/uploads/main/images/05-08-2024/66b0c18e44253.jpeg" alt="image" style="max-height: 300px;">
        <div class="author-name" style="position: relative; background-color: rgb(240 243 246); color: #1363a1; padding: 10px;max-width:270px;text-align:center">
Dr./Raed Alhamdani
        </div>
    </div>
</div>
        </div>
        <br>
        <hr>
        <div class="row y-gap-50 justify-between items-center">
            <div class="col-lg-6 pr-50 sm:pr-15">
                <div class="composition -type-8">
                    <div class="-el-1"><img src="https://ejaabi.com/public/uploads/main/images/09-12-2023/65740261a4699.png" alt="image" style="max-height:300px"></div>
                </div>
            </div>

            <div class="col-lg-5">

                <br>
                <h2 class="text-30 lh-16"> About Us</h2>
                <p class="text-dark-1 mt-30">
                    Positive interaction for training and consulting (Ejaabi) is one of the most important houses of expertise in the field of training, integrated administrative, and educational consultations for enterprises and individuals in the both public and private sectors.  With experienced professionals, national and international competencies, Positive Interaction is keeping pace with developments in various business sectors. This has made positive interaction a trusted destination since 2011.
                </p>
                 

            </div>
        </div>
    </div>
    </section>
    
   <section class="home-sections container">
    <div class="text-center my-40">
        <div>
            <h2 class="section-title">About Us   </h2>
            <p class="section-hint"></p>
        </div>


    </div>
             <div class="modern-services-area bottom-less">
        <div class="container">
            
                <div class="services-box text-center">
                    <div class="row">
                    <!-- Single Item -->
                    <div class="single-item col-md-4 col-sm-6">
                        <div class="item noground">
                            <div class="icon">
                                <i class="flaticon-creativity"></i>
                            </div>
                            <div class="content">
                                <h4>  	 Our Vision   </h4>
                                <p>
                                To be a reliable reference in the field of consulting and training locally and regionally.
                                </p>
                               
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                    <!-- Single Item -->
                    <div class="single-item col-md-4 col-sm-6">
                        <div class="item noground">
                            <div class="icon">
                                <i class="flaticon-result"></i>
                            </div>
                            <div class="content">
                                <h4>  Our Values 	</h4>
                                <p>
                                   <p>Responsibility</p>
<p>Empowerment.</p>
<p>Commitment</p>
<p> innovation.</p>


                                
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                    <!-- Single Item -->
                    <div class="single-item col-md-4 col-sm-6">
                        <div class="item noground">
                            <div class="icon">
                                
                                <i class="flaticon-meeting"></i>
                            </div>
                            <div class="content">
                                <h4>   	Our Mission</h4>
                                <p>
                               

We are working with exceptional experienced professionals to provide an intellectual capital that keeps pace with local and international changes, adopting the best professional practices in providing our services in both fields:

     •Training.

•Administrative and educational consulting.
                                </p>
                                
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                     
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
    @endif
<section class="home-sections container" style="margin-top: 140px !important">
    <div class="text-center my-40">
        <div>
            <h2 class="section-title">{{trans('app.comapny')}} </h2>
            <p class="section-hint"></p>
        </div>


    </div>

    <div class="position-relative mt-20 ltr">
        <div class="owl-carousel customers-testimonials instructors-swiper-container">


            <div class="item">
                <div class="shadow-effect">
                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                        <div class="instructors-card-avatar">
                            <img src="https://ejaabi.com/public/uploads/main/images/02-12-2023/656ae01bdedbe.jpeg" alt="" class="img-cover">
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
                            <img src="https://ejaabi.com/public/uploads/main/images/02-12-2023/656ae4cda1168.png" alt="" class="img-cover">
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
                            <img src="https://ejaabi.com/public/uploads/main/images/27-12-2023/658c10b1e31d2.png" alt="" class=" img-cover">
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
                            <img src="https://ejaabi.com/public/uploads/main/images/19-05-2024/6649bdb36f0cd.png" alt="" class=" img-cover">
                        </div>
                        <div class="instructors-card-info mt-10 text-center">


                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
<div class="position-relative home-sections testimonials-container">

 
        <section class="home-sections container">
            <div class="text-center my-40">
                <div>
                    <h2 class="section-title">{{ trans('app.clients') }} </h2>
                    <p class="section-hint"></p>
                </div>


            </div>


            <div class="position-relative mt-20 ltr">

                <div class="owl-carousel customers-testimonials instructors-swiper-container">
                    <div class="item">
                        <div class="shadow-effect">
                            <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                                <div class="instructors-card-avatar">
                                    <img src="https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeaca39a58.jpeg"
                                        alt="" class="img-cover">
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
                                    <img src="https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfefa364dfb.jpeg"
                                        alt="" class="img-cover">
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
                                    <img src="https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfea64e8494.jpeg"
                                        alt="" class=" img-cover">
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
                                    <img src="https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeac220c6e.jpeg"
                                        alt="" class=" img-cover">
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
                                    <img src="https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeb708b082.png"
                                        alt="" class=" img-cover">
                                </div>
                                <div class="instructors-card-info mt-10 text-center">


                                </div>
                            </div>
                        </div>
                    </div>



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
 
@endsection
@push('scripts_bottom')
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
<script src="/assets/default/js/parts/home.min.js"></script>

@endpush