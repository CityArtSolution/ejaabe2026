@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <style>
      .form-container {
          padding: 2rem;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .form-label {
            font-weight: 500;
            color: #333;
             margin-top: 0.7rem;
            margin-bottom: 0.8rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(128, 90, 213, 0.25);
            border-color: #1363a1;
        }

        .submit-btn {
            background: #1363a1;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: #6B46C1;
            transform: translateY(-2px);
        }

        .error-text {
            color: #DC2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* RTL Support */
        [dir="rtl"] .form-container {
            text-align: right;
        }

        [dir="rtl"] .form-label {
            text-align: right;
        }
    </style>
</style>
@endpush

@section('content')


    <div class="container mt-30">

        <section class="mt-lg-50 pt-lg-20 mt-md-40 pt-md-40">
            
            
            <div id="topFilters" class="shadow-lg border border-gray300 rounded-sm p-10 p-md-20">
    <div class="row align-items-center">
        <div class="col-lg-12 d-flex align-items-center">
             <h3 class="text-24 fw-500">{{__('public.Request Consulting')}}<b></h3>


            </div>

            
        </div>
        </div>
        
                        <div class="row mt-20">
                    <div class="col-12 col-lg-12">
                        
                
                  @if(Session::has('success'))

                <div class="alert alert-success">
                    {{ __('public.Operation successful') }}
                </div>
            @endif
           
                <div class="container">
        <div class="form-container">
            <form class="needs-validation" id="myForm" action="{{route('store_request_consulting')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="consulting">
           
                <div class="row g-4">
                    <!-- Name Field -->
                    <div class="col-12">
                        <label class="form-label">{{__('public.name')}}</label>
                        @if($errors->has('name'))
                            <span class="error-text">{{$errors->first('name')}}</span>
                        @endif
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control @error('name') is-invalid @enderror" 
                       
                            value="{{old('name')}}"
                            required
                        >
                    </div>

                    <!-- Email Field -->
                    <div class="col-12">
                        <label class="form-label">{{__('public.email')}}</label>
                        @if($errors->has('email'))
                            <span class="error-text">{{$errors->first('email')}}</span>
                        @endif
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                          
                            value="{{old('email')}}"
                            required
                        >
                    </div>

                    <!-- Phone Field -->
                    <div class="col-12">
                        <label class="form-label">{{__('public.phone')}}</label>
                        @if($errors->has('phone'))
                            <span class="error-text">{{$errors->first('phone')}}</span>
                        @endif
                        <input 
                            type="tel" 
                            name="phone" 
                            class="form-control @error('phone') is-invalid @enderror" 
                            pattern="[0-9]+" 
                           
                            value="{{old('phone')}}"
                            required
                        >
                    </div>


                    <!-- Details Field -->
                    <div class="col-12">
                        <label class="form-label">{{__('public.details')}}</label>
                        @if($errors->has('details'))
                            <span class="error-text">{{$errors->first('details')}}</span>
                        @endif
                        <textarea 
                            name="description" 
                            class="form-control @error('description') is-invalid @enderror" 
                            rows="5" 
                        >{{old('details')}}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="submit-btn btn btn-primary">
                            {{__('public.Request Consulting')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
            </div>

   
</div>

</div>



           
           
        </section>
    </div>

@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>

    <script src="/assets/default/js/parts/categories.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endpush
