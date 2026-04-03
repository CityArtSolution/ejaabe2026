@extends(getTemplate().'.layouts.app-eval')

@section('content')
<div class="forms-hero position-relative" style="background-image: url('/store/1/info.jpg')">
        <div class="forms-hero-mask"></div>

        <div class="forms-hero-content container user-select-none position-relative">
            <h1 class="font-36 text-white text-center"> تم ارسال تقييمك بنجاح    </h1>
        </div>
    </div>
    <div class="d-flex-center flex-column">
        <div class="">
            <img src="/store/1/default_images/thank_you.jpg" alt="شكرا لك" class="img-fluid">
        </div>

        <h3 class="font-24 mt-30">شكرا لك</h3>
    </div>

   

    <div class="d-flex-center mt-20">
        <a href="/ar" class="btn btn-primary">العودة للصفحة الرئيسية</a>
    </div>
@endsection
