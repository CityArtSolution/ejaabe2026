@extends(getTemplate().'.layouts.app-main')

 

@section('content')

   <!-- Start Page Title 
    ============================================= -->
    <div class="page-title-area shadow dark bg-fixed text-center text-light" style="background-image: url(/store/1/info.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1>  {{trans('app.menu_3')}}   </h1>
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
                        <li><a href="#"><i class="fas fa-home"></i> {{trans('app.menu_1')}}</a></li>
                         
                        <li class="active"> {{trans('app.menu_3')}}  </li>
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
                        <h2>  {{trans('app.home_sec3')}}    </h2>
                        <p>
                          {{trans('app.solution_1')}} 
                        </p>
                        
                        
                    </div>
                    <div class="col-md-6 thumb">
                        <img src="/store/1/{{trans('app.img_tran')}}.jpg" alt="Thumb">
                       
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
                        <h4>{{trans('app.soltion_2')}} </h4>
                        <h2>  {{trans('app.home_sec3')}}    </h2>
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
                           <h4> {{trans('app.sol_3')}}  1</h4>
                                <p>
                                 {{trans('app.sol_4')}}
                                </p>
                        </div>
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-meeting"></i>
                            </div>
                            <h4>{{trans('app.sol_3')}} 2</h4>
                                <p>
                                {{trans('app.sol_5')}}
                                </p>
                           
                        </div>
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-money-1"></i>
                            </div>
                            <h4>{{trans('app.sol_3')}} 3</h4>
                                <p>
                               {{trans('app.sol_6')}}
                                </p>
                          
                        </div>
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-result"></i>
                            </div>
                            <h4>{{trans('app.sol_3')}} 4</h4>
                                <p>
                              {{trans('app.sol_7')}}
                                </p>
                            
                        </div>
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-result"></i>
                            </div>
                            <h4>{{trans('app.sol_3')}} 5</h4>
                                <p>
                              {{trans('app.sol_8')}}
                                </p>
                            
                        </div>
                        <!-- End Single Item -->
                    </div>
                </div>
            </div>
        </div>
    </div>
   
   
   <div class="modern-services-area   bottom-less" style="padding-top:50px;padding-bottom: 50px;">
        <div class="container">
             <div class="row">
                <div class="col-md-12">
                    <div class="site-heading text-left">
                        
                        <h2>{{trans('app.home_sec4')}}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="services-box text-center">
                    <!-- Single Item -->
                    <div class="single-item col-md-3 col-sm-6">
                        <div class="item">
                            <div class="icon">
                                <i class="flaticon-creativity"></i>
                            </div>
                            <div class="content">
                                <h4>  {{trans('app.sol_9')}}</h4>
                                <p>
                                {{trans('app.sol_10')}}
                                </p>
                                
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                    <!-- Single Item -->
                    <div class="single-item col-md-3 col-sm-6">
                        <div class="item">
                            <div class="icon">
                                <i class="flaticon-result"></i>
                            </div>
                            <div class="content">
                                <h4> {{trans('app.sol_11')}}  </h4>
                                <p>
                              {{trans('app.sol_12')}}
                                </p>
                              
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                    <!-- Single Item -->
                    <div class="single-item col-md-3 col-sm-6">
                        <div class="item">
                            <div class="icon">
                                <i class="flaticon-meeting"></i>
                            </div>
                            <div class="content">
                                <h4>{{trans('app.sol_13')}} </h4>
                                <p>
                               {{trans('app.sol_14')}}
                                </p>
                               
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                    <!-- Single Item -->
                    <div class="single-item col-md-3 col-sm-6">
                        <div class="item">
                            <div class="icon">
                                <i class="flaticon-money-1"></i>
                            </div>
                            <div class="content">
                                <h4> 	 {{trans('app.sol_15')}}   </h4>
                                <p>
                                 {{trans('app.sol_16')}}
                                </p>
                                
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                </div>
            </div>
        </div>
    </div>
    
    <div class="features-area   bottom-less bg-gray" style="padding-top:50px;padding-bottom: 150px;">
        <div class="container">
             <div class="row">
                <div class="col-md-12">
                    <div class="site-heading text-left">
                        
                        <h2>{{trans('app.sol_17')}}   </h2>
                    </div>
                </div>
            </div>
           <div class="row">
            <div class="col-md-12">
                <div class="feature-style-one-items">
                    <div class="row">
                        <!-- Single Item -->
                        <div class="feature-style-one col-md-3 col-sm-6">
                            <div class="item">
                                <img src="/assets/demo/assets/img/it-solution/icon-1.png" alt="Icon">
                                <h4>{{trans('app.sol_18')}}    </h4>
                                <p>
                               {{trans('app.sol_19')}} 
                                </p>
                               
                            </div>
                        </div>
                        <!-- Single Item -->
                        <!-- Single Item -->
                        <div class="feature-style-one col-md-3 col-sm-6">
                            <div class="item">
                                <img src="/assets/demo/assets/img/it-solution/icon-6.jpg" alt="Icon">
                                <h4>	 {{trans('app.sol_20')}}   </h4>
                                <p>
                               {{trans('app.sol_21')}} 
                                </p>
                                
                            </div>
                        </div>
                        <!-- Single Item -->
                        <!-- Single Item -->
                        <div class="feature-style-one col-md-3 col-sm-6">
                            <div class="item">
                                <img src="/assets/demo/assets/img/it-solution/icon-2.png" alt="Icon">
                                <h4>  	 {{trans('app.sol_22')}}   </h4>
                                <p>
                              {{trans('app.sol_23')}} 
                                </p>
                               
                            </div>
                        </div>
                        <!-- Single Item -->
                         <!-- Single Item -->
                        <div class="feature-style-one col-md-3 col-sm-6">
                            <div class="item">
                                <img src="/assets/demo/assets/img/it-solution/icon-3.png" alt="Icon">
                                <h4>   {{trans('app.sol_24')}}     </h4>
                                <p>
                              {{trans('app.sol_25')}} 
                                </p>
                               
                            </div>
                        </div>
                        <!-- Single Item -->
                    </div>
                </div>
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
                        <h2>  {{trans('app.home_sec6')}}          </h2>
                        <p>
                         {{trans('app.sol_26')}}              </p>
                        
                        
                    </div>
                    <div class="col-md-6 thumb">
                        <img src="/store/1/{{trans('app.img_elear')}}.jpg" alt="Thumb">
                       
                    </div>
                </div>
                <!-- End About -->

            </div>
          
        </div>
    </div>
<div class="services-area text-center  carousel-shadow bg-gray" style="padding-top:50px;padding-bottom: 150px;">
        <div class="container-medium">
            <div class="row">
                <div class="col-md-12">
                    <div class="site-heading text-left">
                        <h4> {{trans('app.soltion_2')}} </h4>
                        <h2>  {{trans('app.home_sec6')}}      </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="services-items services-carousel owl-carousel owl-theme">
                        <!-- Single Item -->
                        
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        
                        <!-- End Single Item -->
                   <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-analysis"></i>
                            </div>
                           <h4> {{trans('app.sol_3')}}   1</h4>
                                <p>
                              {{trans('app.sol_26')}} 
                                </p>
                        </div>
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-meeting"></i>
                            </div>
                            <h4>{{trans('app.sol_3')}}  2</h4>
                                <p>
                             {{trans('app.sol_27')}} 
                                </p>
                           
                        </div>
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-money-1"></i>
                            </div>
                            <h4>{{trans('app.sol_3')}}  3</h4>
                                <p>
                               {{trans('app.sol_29')}} 
                                </p>
                          
                        </div>
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-result"></i>
                            </div>
                            <h4>{{trans('app.sol_3')}}  4</h4>
                                <p>
                              {{trans('app.sol_30')}} 
                                </p>
                            
                        </div>
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-result"></i>
                            </div>
                            <h4>{{trans('app.sol_3')}}  5</h4>
                                <p>
                          {{trans('app.sol_31')}} 
                                </p>
                            
                        </div>
                       <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-result"></i>
                            </div>
                            <h4>{{trans('app.sol_3')}}  6</h4>
                                <p>
                             {{trans('app.sol_32')}} 
                                </p>
                            
                        </div>
                        <div class="item h_245">
                            <div class="icon">
                                <i class="flaticon-result"></i>
                            </div>
                            <h4>{{trans('app.sol_3')}}  7</h4>
                                <p>
                           {{trans('app.sol_33')}} 
                                </p>
                            
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

