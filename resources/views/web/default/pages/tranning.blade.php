@extends(getTemplate().'.layouts.app-main')

 

@section('content')

   <!-- Start Page Title 
    ============================================= -->
    <div class="page-title-area shadow dark bg-fixed text-center text-light" style="background-image: url(/store/1/info.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1>    {{trans('app.menu_4')}}  </h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Start Breadcrumb 
    ============================================= -->
    <div class="breadcrumb-area bg-gray text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="fas fa-home"></i>  {{trans('app.menu_1')}} </a></li>
                         
                        <li class="active">     {{trans('app.menu_4')}}   </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

  <div class="about-area default-padding">
        <div class="container">
            <div class="row">
                <!-- Start About Content -->
                <div class="about-content content-left">
                    <div class="col-md-6 info">
                        <h2>    {{trans('app.menu_4')}} </h2>
                        <p>
                         {{trans('app.tra_1')}} 
                        </p>
                        
                        
                    </div>
                    <div class="col-md-6 thumb">
                        <img src="/store/1/tranning1.jpg" alt="Thumb">
                       
                    </div>
                </div>
                <!-- End About -->

            </div>
          
        </div>
    </div>
     
     
    
    <div class="services-area text-center  carousel-shadow bg-gray" style="padding-top:50px;padding-bottom: 50px;">
        <div class="container-medium">
            <div class="row">
                <div class="col-md-12">
                    <div class="site-heading text-left">
                         
                        <h2> {{trans('app.home_sec10')}}      </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                     <div class="services-items services-carousel owl-carousel owl-theme">
                        <!-- Single Item -->
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-analysis"></i>
                            </div>
                           <h4> {{trans('app.tra_2')}}  </h4>
                                <p>
                                 {{trans('app.tra_3')}} 
                                </p>
                        </div>
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-meeting"></i>
                            </div>
                            <h4>  {{trans('app.tra_4')}} </h4>
                                <p>
                              {{trans('app.tra_5')}}
                                </p>
                           
                        </div>
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-money-1"></i>
                            </div>
                            <h4>  {{trans('app.tra_6')}}  </h4>
                                <p>
                                 {{trans('app.tra_7')}} 
                                </p>
                          
                        </div>
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-result"></i>
                            </div>
                            <h4>{{trans('app.tra_8')}} </h4>
                                <p>
                             {{trans('app.tra_9')}}
                                </p>
                            
                        </div>
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-result"></i>
                            </div>
                            <h4>  {{trans('app.tra_10')}}</h4>
                                <p>
                             {{trans('app.tra_11')}}
                                </p>
                            
                        </div>
                        <!-- End Single Item -->
                    </div>
                </div>
            </div>
        </div>
    </div>
   
   
   <div class="testimonials-area carousel-shadow   bottom-less" style="padding-top:50px;padding-bottom: 50px;">
        <div class="container">
             <div class="row">
                <div class="col-md-12">
                    <div class="site-heading text-left">
                        
                        <h2>  {{trans('app.home_sec11')}}     </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="testimonial-box">
                    <div class="row">
                        <div class="testimonial-items testimonial-carousel owl-carousel owl-theme">
                            <!-- Single Item -->
                            <div class="item">
                                
                                <p>
                                  {{trans('app.tra_12')}} 
                                </p>
                                <div class="author">
                                     
                                    <div class="info">
                                        <h4> {{trans('app.tra_13')}} 	 </h4>
                                         
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Item -->
                            <!-- Single Item -->
                            <div class="item">
                                
                                <p>
                                {{trans('app.tra_14')}} 
                                </p>
                                <div class="author">
                                     
                                    <div class="info">
                                        <h4> {{trans('app.tra_15')}} </h4>
                                         
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Item -->
                             <!-- Single Item -->
                            <div class="item">
                                
                                <p> {{trans('app.tra_16')}} 
                               
                                </p>
                                <div class="author">
                                     
                                    <div class="info">
                                        <h4> {{trans('app.tra_17')}} </h4>
                                         
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Item -->
                              <!-- Single Item -->
                            <div class="item">
                                
                                <p>
                              {{trans('app.tra_18')}} 
                                </p>
                                <div class="author">
                                     
                                    <div class="info">
                                        <h4> {{trans('app.tra_19')}} 	</h4>
                                         
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Item -->
                             <!-- Single Item -->
                            <div class="item">
                                
                                <p>
                                {{trans('app.tra_20')}} 
                                </p>
                                <div class="author">
                                     
                                    <div class="info">
                                        <h4> {{trans('app.tra_21')}} </h4>
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
    
     <!-- Star Why Chose Us
    ============================================= -->
    <div class="why-chose-us-area  full text-light " >
        <div class="container-full">
            <div class="row">
                 <div class="col-md-6" >
                    <img src="/assets/demo/assets/img/environment-social-governance-flat-concept_88138-970.jpg" class="why-chose-us-area-img">
                </div>
                 <div class="col-md-6">
                <div class="item-box">
                    <div class=" info">
                        <div class="heading">
                            
                            <h2>{{trans('app.tra_22')}} </h2>
                        </div>
                        <div class="content">
                          {!! trans('app.tra_23') !!} 
                           
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Why Chose Us -->
    
     <div class="services-area text-center  carousel-shadow bg-gray" style="padding-top:50px;padding-bottom: 150px;">
        <div class="container-medium">
            <div class="row">
                <div class="col-md-12">
                    <div class="site-heading text-left">
                        
                       <h2>{{trans('app.tra_24')}} </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="services-items services-carousel owl-carousel owl-theme">
                      
                  {!! trans('app.tra_25') !!}
                </div>
            </div>
        </div>
    </div>
   
   
  <div class="about-area default-padding">
        <div class="container">
            <div class="row">
                <!-- Start About Content -->
                <div class="about-content content-left">
                    <div class="col-md-6 info">
                        {!! trans('app.tra_26') !!}
                        
                    </div>
                    <div class="col-md-6 thumb">
                        <img src="/store/1/critical-thinking.jpg" alt="Thumb">
                       
                    </div>
                </div>
                <!-- End About -->

            </div>
          
        </div>
    </div>

@endsection

