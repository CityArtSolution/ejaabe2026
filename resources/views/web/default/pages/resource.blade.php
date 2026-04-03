@extends(getTemplate().'.layouts.app-main')

 

@section('content')

   <!-- Start Page Title 
    ============================================= -->
    <div class="page-title-area shadow dark bg-fixed text-center text-light" style="background-image: url(/store/1/info.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1>   {{trans('app.menu_5')}} </h1>
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
                         
                        <li class="active">{{trans('app.menu_5')}}  </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

 <!-- Star Blog Area
    ============================================= 
    <div class="blog-area  default-padding bottom-less">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
                         <h4> {{trans('app.res_1')}} </h4>
                        <h2> {{trans('app.menu_5')}}  </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="blog-items">
                    <!-- Single Item 
                    <div class="col-md-4 col-sm-6 single-item">
                       {!! trans('app.res_2') !!} 
                    </div>
                    <!-- End Single Item 
                    <!-- Single Item 
                    <div class="col-md-4 col-sm-6 single-item">
                        {!! trans('app.res_2') !!} 
                    </div>
                    <!-- End Single Item 
                    <!-- Single Item 
                    <div class="col-md-4 col-sm-6 single-item">
                       {!! trans('app.res_2') !!} 
                    </div>
                    <!-- End Single Item 
                </div>
            </div>
        </div>
    </div>
    -->
    <div class="blog-area  default-padding bottom-less">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>

 
@endsection

