@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">


            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <form action="{{ getAdminPanelUrl() }}/enrollments/store" method="Post">
                                        {{ csrf_field() }}

                                        <div class="form-group">
                                            <label class="input-label">{{trans('admin/main.class')}}</label>
                                            <select name="webinar_id" class="form-control search-webinar-select2"
                                                    data-placeholder="Search classes">

                                            </select>

                                            @error('webinar_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="input-label d-block">{{ trans('admin/main.student') }}</label>
                                            <select name="user_id" class="form-control search-user-select2" data-placeholder="{{ trans('public.search_user') }}">

                                            </select>
                                            @error('user_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class=" mt-4">
                                            <button type="submit" class="btn btn-primary">{{ trans('admin/main.add') }}</button>
                                        </div>
                                    </form>
                                </div>



                                <div class="col-12 col-md-6">
                                    <form action="{{ getAdminPanelUrl() }}/enrollments/import" method="POST" enctype="multipart/form-data">
                                        @csrf
                
                                        <div class="form-group">
                                            <label>اضافة حسابات للمتدربين مع التسجيل المباشر في الدورات</label>
                                            <!--<span style="color:red">اختر الدورات المطلوبة</span>
                                            <select name="webinar_ids[]" class="form-control select2" multiple required>
                                                @foreach(\App\Models\Webinar::where('status', 'active')->get() as $webinar)
                                                    <option value="{{ $webinar->id }}">{{ $webinar->title }}</option>
                                                @endforeach
                                            </select>-->
                                            <div> <a style="color:red" href="/public/download/trainee-accounts.xlsx" >اضغط هنا  تحميل نموذج ملف الاكسيل</a></div>
                                        </div>
                
                                        <div class="form-group">
                                            
                                            <label style="color:green">ملف اكسل  فقط يحتوي على حسابات المتدربين مع ارقام الدورات المطلوب  تسجيل المتدربين فيها </label>
                                            <input type="file" name="excel_file" class="form-control" required>
                                            <small class="form-text text-muted">
                                               ملف الاكسل  يحتوي على الاعمدة التالية
                                               full_name	Mobile	Email	password	webinar_id
                                               
                                               
                                               والتي  تمثل اسم المتدرب,رقم الموبايل,الايميل,كلمة المرور,رقم الدورة التي  سيسجل المتدرب فيها تلقائيا

                                            </small>
                                        </div>
                
                                        <div class="text-right mt-4">
                                            <button class="btn btn-primary">استيراد وتسجيل</button>
                                        </div>
                                    </form>
                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

