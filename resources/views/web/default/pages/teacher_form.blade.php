@extends(getTemplate().'.layouts.app')
 @push('styles_top')
  <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
<style>
    legend {
  background-color: #0e3274;
  color: #fff;
  padding: 3px 6px;
  color:#fff;
  
      border-radius: 5px;
      width:335px;
}
fieldset{
display: block;
    min-inline-size: min-content;
    margin-inline: 2px;
    border-width: 2px;
    border-style: groove;
    border-color: threedface;
    border-image: initial;
    padding-block: 0.35em 0.625em;
    padding-inline: 0.75em;
}
</style>
@endpush

@section('content')

<div class="forms-hero position-relative" style="background-image: url('/store/1/default_images/16.jpg')">
        <div class="forms-hero-mask"></div>

        <div class="forms-hero-content container user-select-none position-relative">
            <h1 class="font-36 text-white text-center">انضم إلينا كمدرب</h1>
        </div>
    </div>
    <div class="forms-body container bg-white p-20">
    
    <form action="/teacher_form/store" method="post" class="mt-30">
       {{ csrf_field() }}
     <fieldset>
        <legend>المعلومات الشخصية</legend>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="input-label" for="code">  الاسم كامل:</label>
                        <input type="text" name="full_name" class="form-control " value="" fdprocessedid="7g2tc">
                     </div>
                 </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="input-label" for="code">  الهاتف  :</label>
                        <input type="number" name="phone" class="form-control " value="" fdprocessedid="7g2tc">
                     </div>
                 </div>
                 
            </div>
             <div class="row">
                 <div class="col-md-4">
                    <div class="form-group">
                        <label class="input-label" for="code">  البريد الالكتروني  :</label>
                        <input type="text" name="email" class="form-control " value="" fdprocessedid="7g2tc">
                     </div>
                 </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="input-label" for="code">  الدولة  :</label>
                        <input type="text" name="counrty" class="form-control " value="" fdprocessedid="7g2tc">
                     </div>
                 </div>
                 <div class="col-md-4">
                    <div class="form-group">
                        <label class="input-label" for="code">  المدينه  :</label>
                        <input type="text" name="city" class="form-control " value="" fdprocessedid="7g2tc">
                     </div>
                 </div>
                 
            </div>
             <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="input-label" for="code">  اللقب المهنى  :</label>
                        <input type="text" name="professional" class="form-control " value="" fdprocessedid="7g2tc">
                     </div>
                 </div>
                 <div class="col-md-6">
                       <div class="form-group">
                        <label class="input-label">إرفاق صورة</label>
                        <div class="input-group">
                            
                            <input type="file" name="photo" id="photo" class="form-control  "/>
                        </div>
            
                    
                    </div>
                     
                    
                 </div>
                 
            </div>
                
</fieldset>
      <fieldset class="mt-20">
                <legend>   الملخص المهنى</legend>
                    <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                                <label class="input-label" for="code">  نظرة عامة موجزة على خبرتك ومهاراتك وقيمتك كمدرب    :</label>
                                <textarea rows="4" name="professional_summary1" class="form-control "></textarea>
                             </div>
                         </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="input-label" for="code">   إبراز المهارات الفريدة     :</label>
                                <textarea rows="4" name="professional_summary2" class="form-control "></textarea>
                             </div>
                         </div>
                    </div>
        </fieldset>
        <fieldset class="mt-20">
                <legend>    المهارات الأساسية</legend>
                    <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                                <label class="input-label" for="code">  اكتب من 6 الى 10 مهارات اساسية    :</label>
                                <textarea rows="4" name="basic_skills" class="form-control "></textarea>
                             </div>
                         </div>
                       
                    </div>
        </fieldset>
        
      <fieldset class="mt-20">
        <legend> الخبرة المهنية</legend>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="input-label" for="code">   المسمى الوظيفى    :</label>
                        <input type="text" name="job_title" class="form-control " value="" fdprocessedid="7g2tc">
                     </div>
                 </div>
                 <div class="col-md-4">
                    <div class="form-group">
                        <label class="input-label" for="code">  اسم الشركة  :</label>
                        <input type="text" name="company_name" class="form-control " value="" fdprocessedid="7g2tc">
                     </div>
                 </div>
                 <div class="col-md-4">
                    <div class="form-group">
                        <label class="input-label" for="code">  الموقع    :</label>
                        <input type="text" name="location" class="form-control " value="" fdprocessedid="7g2tc">
                     </div>
                 </div>
            </div>
              <div class="row">
                        <div class="col-md-6">
                              <div class="form-group">
                                <label class="input-label"> تاريخ البدء : </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                                <span class="input-group-text" id="dateRangeLabel5">
                                                    <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                                </span>
                                    </div>
                    
                                    <input type="text" name="start_date" class="form-control text-center datetimepicker @error(5) is-invalid @enderror"
                                           aria-describedby="dateRangeLabel5" autocomplete="off" value="{{ (!empty($values) and !empty($values[5])) ? $values[5] : old('fields5') }}"/>
                                </div>
                    
                                @error(5)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                         </div>
                         <div class="col-md-6">
                           <div class="form-group">
                                <label class="input-label"> تاريخ الانتهاء : </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                                <span class="input-group-text" id="dateRangeLabel5">
                                                    <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                                </span>
                                    </div>
                    
                                    <input type="text" name="end_date" class="form-control text-center datetimepicker @error(5) is-invalid @enderror"
                                           aria-describedby="dateRangeLabel5" autocomplete="off" value="{{ (!empty($values) and !empty($values[5])) ? $values[5] : old('fields5') }}"/>
                                </div>
                    
                                @error(5)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                         </div>
                         
                    </div>
             <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="input-label" for="code">   وصف موجز للوظيفة والمسؤوليات    :</label>
                         <textarea rows="4" name="brief_description" class="form-control "></textarea>
                     </div>
                 </div>
                 
                 
            </div>
                
</fieldset>
      <fieldset class="mt-20">
            <legend>   الخبرة التدريبية</legend>
                <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                            <label class="input-label" for="code">  قسم تفصيلى يسلط الضوء على مجالات التخصص (على سبيل المثال، القيادة، والامتثال، والمهارات الشخصية).    :</label>
                             <textarea rows="4" name="training_expertise" class="form-control "></textarea>
                         </div>
                     </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="input-label" for="code">    أنواع الجماهير التي يتم تدريبها (على سبيل المثال، المديرون التنفيذيون، والمديرون المتوسطون، وموظفو المستوى الأول).    :</label>
                            <textarea rows="4" name="types_audiences" class="form-control "></textarea>
                         </div>
                     </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="input-label" for="code">  الصيغ (على سبيل المثال، ورش العمل، والندوات عبر الإنترنت، والتعلم الإلكتروني، والتعليم الهجين).  </label>
                            <textarea rows="4" name="format" class="form-control "></textarea>
                         </div>
                     </div>
                   
                      
                </div>
                 
                 
                    
    </fieldset>
            <fieldset class="mt-20">
                <legend> التعليم  </legend>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label" for="code">    الدرجة       :</label>
                                <input type="text" name="degree" class="form-control " value="" fdprocessedid="7g2tc">
                             </div>
                         </div>
                         <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label" for="code">    اسم الجامعة   :</label>
                                <input type="text" name="university_name" class="form-control " value="" fdprocessedid="7g2tc">
                             </div>
                         </div>
                         <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label" for="code">  الموقع    :</label>
                                <input type="text" name="location_education" class="form-control " value="" fdprocessedid="7g2tc">
                             </div>
                         </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6">
                              <div class="form-group">
                                <label class="input-label"> تاريخ البدء : </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                                <span class="input-group-text" id="dateRangeLabel5">
                                                    <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                                </span>
                                    </div>
                    
                                    <input type="text" name="start_date_education" class="form-control text-center datetimepicker @error(5) is-invalid @enderror"
                                           aria-describedby="dateRangeLabel5" autocomplete="off" value="{{ (!empty($values) and !empty($values[5])) ? $values[5] : old('fields5') }}"/>
                                </div>
                    
                                @error(5)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                         </div>
                         <div class="col-md-6">
                           <div class="form-group">
                                <label class="input-label"> تاريخ الانتهاء : </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                                <span class="input-group-text" id="dateRangeLabel5">
                                                    <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                                </span>
                                    </div>
                    
                                    <input type="text" name="end_date_education" class="form-control text-center datetimepicker @error(5) is-invalid @enderror"
                                           aria-describedby="dateRangeLabel5" autocomplete="off" value="{{ (!empty($values) and !empty($values[5])) ? $values[5] : old('fields5') }}"/>
                                </div>
                    
                                @error(5)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                         </div>
                         
                    </div>
                      
                        
        </fieldset>
        <fieldset class="mt-20">
                    <legend>    المشاريع أو برامج التدريب الرئيسية  </legend>
                        <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-label" for="code"> قم بتسليط الضوء على البرامج الرئيسية التي قمت بتصميمها أو تقديمها أو إدارتها.</label>
                                     <textarea rows="4" name="project" class="form-control "></textarea>
                                 </div>
                             </div>
                             
                        </div>
            </fieldset>
            <fieldset class="mt-20">
                    <legend>      اللغات        </legend>
                        <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                 
                                 
                                    <label class="input-label" for="code">اللغة</label>

                                      <select name="languages[]" class="form-control" >
                                        <option value="" disabled selected>اختار اللغة</option>
                                        <option value="English">الانجليزية</option>
                                        <option value="Arabic">العربية</option>
                                        <option value="French">الفرنسية</option>
                                        
                                    </select>
           
                                                                      
                                 </div>
                             </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label"  for="code">المستوى </label>
                                  <select name="levels[]" class="form-control" >
                                    <option value="" disabled selected>اختار المستوى</option>
                                    <option value="Beginner">الأم</option>
                                    <option value="Intermediate">الطلاقة</option>
                                    <option value="Advanced">المستوى المتوسط</option>
                                </select>
                             </div>
                             </div>
                             <div class="col-md-4">
                                  <div class="form-group">
                                       <a class="btn addr" ><span class="fa fa-plus-circle"></span> اضافة لغة اخرى   </a> 
                                       <a class="btn removr" ><span class="fa fa-minus-circle"></span>  حذف لغة </a>
                                   </div>
                                 
                            </div>
                             
                        </div>
                        <div class="moreitem"></div>
                        <div>
                           
                         </div>
                        </fieldset>
                        <fieldset class="mt-20">
                    <legend>      العضوية المهنية        </legend>
                        <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-label" for="code"> قم بتسليط الضوء على البرامج الرئيسية التي قمت بتصميمها أو تقديمها أو إدارتها.</label>
                                     <textarea rows="4" name="memberships" class="form-control "></textarea>
                                 </div>
                             </div>
                             
                        </div>
            </fieldset>
    
                
            
    
        <div class="d-flex align-items-center justify-content-end mt-30">
            

            <button type="submit" class="btn btn-primary" fdprocessedid="orkilt">  ارسال </button>
        </div>
    </form>
    </div>
@endsection
@push('scripts_bottom')
<script>
    var $content = '<div class="row">'+
                             ' <div class="col-md-6">'+
                                 ' <div class="form-group"> <label class="input-label" for="code">اللغة</label> <select name="languages[]" class="form-control" >'+
                                 ' <option value="" disabled selected>اختار اللغة</option> <option value="English">الانجليزية</option> <option value="Arabic">العربية</option>'+
                                '<option value="French">الفرنسية</option></select></div> </div>'+
                             '<div class="col-md-6"> <div class="form-group"> <label class="input-label"  for="code">المستوى </label>'+
                            ' <select name="levels[]" class="form-control" ><option value="" disabled selected>اختار المستوى</option>'+
                            '<option value="Beginner">الأم</option><option value="Intermediate">الطلاقة</option> <option value="Advanced">المستوى المتوسط</option> '+
                                '</select></div></div></div>';

$(document).ready(function(){
     
  $('.addr').click(function(){ 
      
      
    $('.moreitem').append($content);
  });
   
  $('.removr').click(function(){
      
    $('.moreitem .row:last-child').remove();
  }); 
});
</script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="/assets/default/js/parts/forms.min.js"></script>
     <script src="/assets/default/js/admin/form_submissions_details.min.js"></script>
@endpush