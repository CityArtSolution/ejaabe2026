@php
    app()->setLocale('en');
@endphp

@extends(getTemplate().'.layouts.canada_app')

@push('styles_top')
@endpush

@section('content')
<style>
    .modal-dialog {
        max-width: 1000px;
    }
</style>
<style>
    .custom-input-size {
        width: 100px !important;   /* تصغير العرض */
        height: 48px !important;   /* زيادة الارتفاع قليلاً */
        font-size: 16px;
        padding: 6px 12px;
        border-radius: 8px;        /* يعطيه مظهر أفضل */
    }
</style>

<div class="main_content_iner main_content_padding">

    <div class="dashboard_lg_card">
        <div class="container-fluid no-gutters">
            <div class="row">
                <div class="col-12">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-12">
                               
                            </div>
                        </div>
                                                   @if(session('success'))
      <div class="alert alert-success">
  
  
        {{ session('success')}}
        
        </div>
    
@endif
                        <div class="row">
                            <div class="col-xl-12">
                                <form method="post">
                                    <div class="single_totl_warp col-lg-12 pl-0">
                                        @csrf

                                        <h3 class="font_18 mb-2">Deposit Amount
                                        
                                                                      @if(auth()->user()->branch_id==4)
                                                                      CA$
@else
    (CA$)
@endif

                                        
                                           
                                            <span
                                                class="text-danger">*</span></h3>
        <div class="input-group mb-3 input-group-lg deposit_save_info">

            <input
                placeholder=""
                name="deposit_amount"
                type="number"
                step="any"
                min="1"
                value="{{ !empty($amount) ? $amount : '' }}"
                class="primary_input col-md-6 custom-input-size"
                required
            >

            <strong class="text-danger">{{ $errors->first('deposit_amount') }}</strong>

        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                      @if(!empty($amount))
    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="row">
                    <div class="col-12">
                        <div class="section__title3 mb_40">
                            <h3 class="mb-0">Common Select Payment Payment Method</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="deposit_lists_wrapper mb-50 d-flex justify-content-center" style="gap: 25px;">
                            
                            <!-- Visa -->
                            <div class="single_deposite" style="width: 180px;">
                                <div class="single_deposite_item text-center" style="
                                    border: 2px solid #e5e5e5; 
                                    border-radius: 12px; 
                                    padding: 12px; 
                                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                    transition: transform 0.2s ease;
                                    background-color: #fff;">
                                    <form action="{{route('depositSelect')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="deposit_amount" value="{{ $amount }}">
                                        <input type="hidden" name="method" value="Visa">
                                        <button type="submit" style="border: none; background: none; padding: 0;">
                                            <img class="submitBtn" src="{{ asset('image/visa.png') }}" alt="Visa" style="
                                                width: 150px; 
                                                height: 120px; 
                                                object-fit: contain;">
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Mada -->
                            <div class="single_deposite" style="width: 180px;">
                                <div class="single_deposite_item text-center" style="
                                    border: 2px solid #e5e5e5; 
                                    border-radius: 12px; 
                                    padding: 12px; 
                                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                    transition: transform 0.2s ease;
                                    background-color: #fff;">
                                    <form action="{{route('depositSelect')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="deposit_amount" value="{{ $amount }}">
                                        <input type="hidden" name="method" value="Mada">
                                        <button type="submit" style="border: none; background: none; padding: 0;">
                                            <img class="submitBtn" src="{{ asset('image/mada.png') }}" alt="Mada" style="
                                                width: 150px; 
                                                height: 120px; 
                                                object-fit: contain;">
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div> <!-- deposit_lists_wrapper -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

                    </div>
                </div>
            </div>
        </div>
    </div>
   

    <div class="modal fade " id="bankModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <form name="bank_payment" enctype="multipart/form-data"
                      class="single_account-form" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="modal-header pl-0">
                                    <h5 class="modal-title" id="">{{__('payment.Bank Payment')}} </h5>
                                </div>
                                <input type="hidden" name="method" value="Bank Payment">
                                <div class="row mt-3">
                                    <div class="col-xl-6 col-md-6">
                                        <label for="name" class="mb-2">@lang('setting.Bank Name')
                                            <span>*</span></label>
                                        <input type="text" required class="primary_input4 mb_20" placeholder="Bank Name"
                                               name="bank_name" value="{{@old('bank_name')}}">
                                        <span class="invalid-feedback" role="alert" id="bank_name"></span>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <label for="name" class="mb-2">@lang('setting.Branch Name')
                                            <span>*</span></label>
                                        <input type="text" required name="branch_name" class="primary_input4 mb_20"
                                               placeholder="Name of account owner" value="{{@old('branch_name')}}">
                                        <span class="invalid-feedback" role="alert" id="owner_name"></span>
                                    </div>
                                </div>
                                <div class="row mb-20">
                                    <div class="col-xl-6 col-md-6">
                                        <label for="name" class="mb-2">@lang('setting.Account Number')
                                            <span>*</span></label>
                                        <input type="text" required class="primary_input4 mb_20"
                                               placeholder="Account number" name="account_number"
                                               value="{{@old('account_number')}}">
                                        <span class="invalid-feedback" role="alert" id="account_number"></span>
                                    </div>
                                    <div
                                        class="col-xl-6 col-md-6">
                                        <label for="name" class="mb-2">@lang('setting.Account Holder')
                                            <span>*</span></label>
                                        <input type="text" required name="account_holder" class="primary_input4 mb_20"
                                               placeholder="Account Holder" value="{{@old('account_holder')}}">
                                        <span class="invalid-feedback" role="alert" id="account_holder"></span>
                                    </div>
                                    <input type="hidden" name="deposit_amount" value="{{$amount}}">
                                </div>
                                <div class="row mb-20">
                                    <div class="col-xl-6 col-md-12">
                                        <label for="name" class="mb-2">@lang('setting.Account Type')
                                            <span>*</span></label>
                                        <select class="theme_select wide update-select-arrow" name="type" required
                                                id="type" style="margin-top: -10px;">
                                            <option
                                                data-display="{{__('common.Select')}}  {{__('setting.Account Type')}}"
                                                value="">{{__('common.Select')}} {{__('setting.Account Type')}}</option>
                                            <option
                                                value="Current Account" {{(env('ACCOUNT_TYPE')? env('ACCOUNT_TYPE') : '')=='Current Account'?'selected':''}}>
                                                Current Account
                                            </option>
                                            <option
                                                value="Savings Account" {{(env('ACCOUNT_TYPE')? env('ACCOUNT_TYPE') : '')=='Savings Account'?'selected':''}}>
                                                Savings Account
                                            </option>
                                            <option
                                                value="Salary Account" {{(env('ACCOUNT_TYPE')? env('ACCOUNT_TYPE') : '')=='Salary Account'?'selected':''}}>
                                                Salary Account
                                            </option>
                                            <option
                                                value="Fixed Deposit" {{(env('ACCOUNT_TYPE')? env('ACCOUNT_TYPE') : '')=='Fixed Deposit'?'selected':''}}>
                                                Fixed Deposit
                                            </option>

                                        </select>
                                    </div>
                                    <div
                                        class="col-xl-6 col-md-12">
                                        <label for="name" class="mb-2">Cheque Slip <span>*</span></label>
                                        <input type="file" required name="image" class="primary_input4 mb_20">
                                        <span class="invalid-feedback" role="alert" id="amount_validation"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="modal-header pl-0">
                                    <h5 class="modal-title"
                                        id="exampleModalLabel">{{__('common.Bank Account Info')}}</h5>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class=" theme_line_btn  btn-sm  small_btn2 "
                                data-dismiss="modal">@lang('common.Cancel')</button>
                        <button class="  theme_btn  btn-sm  small_btn2" type="submit">@lang('payment.Payment')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <style>
        .modal-dialog {
            max-width: 1000px;
        }
    </style>

</div>

@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/payment.min.js"></script>
@endpush
