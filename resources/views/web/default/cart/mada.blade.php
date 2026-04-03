@extends(getTemplate().'.layouts.app')

@section('content')
@if($checkoutData['gateway']=="Mada")
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-body">
                        <script>
                            var wpwlOptions = {
                                locale: "{{app()->getLocale()}}",
                                style: "card",
                                paymentTarget: "_top",
                                brandDetection: true,
                                onReady: function() {
                                    $('.wpwl-wrapper-brand').hide();
                                    $('.wpwl-label-brand').hide();
                                    $('.wpwl-control-brand').hide();
                                    console.log('Widget ready');
                                },
                                onError: function(error) {
                                    console.error('Widget error:', error);
                                }
                            }
                        </script>

                     <!--   <script src="https://eu-prod.oppwa.com/v1/paymentWidgets.js?checkoutId={{$checkoutData['checkout_idd']}}"></script>-->
                        
                          <script src="https://eu-prod.oppwa.com/v1/paymentWidgets.js?checkoutId={{$checkoutData['checkout_idd']}}"
                      	integrity="integrity"
	crossorigin="anonymous"></script>

                         <form action="{{ route('payments.success_paymentss', [
                            'id' => $checkoutData['checkout_idd'], 
                            'resourcePath' => 'resourcePath',
                            'order_id'=>$checkoutData['order_id'],
                            'gateway'=>'Mada'
                            
                        ]) }}" 
                        class="paymentWidgets" 
                        data-brands="MADA">
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if($checkoutData['gateway']=="Visa")
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-body">
                        <script>
                            var wpwlOptions = {
                                locale: "{{app()->getLocale()}}",
                                style: "card",
                                useSummaryPage: false,
                                paymentTarget: "_top",
                                onReady: function() {
                                    console.log('Widget ready');
                                },
                                onError: function(error) {
                                    console.error('Widget error:', error);
                                }
                            }
                        </script>

                      <script src="https://eu-prod.oppwa.com/v1/paymentWidgets.js?checkoutId={{$checkoutData['checkout_idd']}}"
                      	integrity="integrity"
	crossorigin="anonymous"></script>
	
                     <!--    <script 
	src="https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$checkoutData['checkout_idd'] }}"
	integrity="integrity"
	crossorigin="anonymous">
</script>-->

                        <form action="{{ route('payments.success_paymentss', [
                            'id' => $checkoutData['checkout_idd'], 
                            'resourcePath' => 'resourcePath',
                            'order_id'=>$checkoutData['order_id'],
                            'gateway'=>'Visa'
                            
                        ]) }}" 
                        class="paymentWidgets" 
                        data-brands="VISA MASTER">
                            
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if($checkoutData['gateway']=="offline")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-body">
                    <form action="/panel/financial/charge" method="post" enctype="multipart/form-data" class="mt-25">
                        {{ csrf_field() }}
                        <div class="">
                            <div class="row">

                                <!-- اسم البنك -->
                                <div class="col-12 col-lg-4 mb-25 mb-lg-0">
                                    <div class="form-group">
                                        <label class="input-label">اسم البنك</label>
                                        <input type="text" name="bank_name" value="{{ old('bank_name') }}" class="form-control @error('bank_name') is-invalid @enderror" placeholder="أدخل اسم البنك">
                                        @error('bank_name')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- اسم صاحب التحويل -->
                                <div class="col-12 col-lg-4 mb-25 mb-lg-0">
                                    <div class="form-group">
                                        <label class="input-label">اسم صاحب التحويل</label>
                                        <input type="text" name="transfer_name" value="{{ old('transfer_name') }}" class="form-control @error('transfer_name') is-invalid @enderror" placeholder="أدخل اسم صاحب التحويل">
                                        @error('transfer_name')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- رقم الإيصال -->
                                <div class="col-12 col-lg-4 mb-25 mb-lg-0">
                                    <div class="form-group">
                                        <label class="input-label">رقم الإيصال / رقم التحويل</label>
                                        <input type="text" name="receipt_number" value="{{ old('receipt_number') }}" class="form-control @error('receipt_number') is-invalid @enderror" placeholder="أدخل رقم الإيصال">
                                        @error('receipt_number')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- التاريخ -->
                                <div class="col-12 col-lg-4 mb-25 mb-lg-0">
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('public.date_time') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="dateRangeLabel">
                                                    <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                                                </span>
                                            </div>
                                            <input type="date" name="date" value="{{ old('date') }}" class="form-control datetimepicker @error('date') is-invalid @enderror" aria-describedby="dateRangeLabel"/>
                                            @error('date')
                                            <div class="invalid-feedback"> {{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- صورة الإيصال -->
                                <div class="col-12 col-lg-4 mb-25 mb-lg-0">
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('update.attach_the_payment_photo') }}</label>

                                        <label for="attachmentFile" id="attachmentFileLabel" class="custom-upload-input-group">
                                            <span class="custom-upload-icon text-white">
                                                <i data-feather="upload" width="18" height="18" class="text-white"></i>
                                            </span>
                                            <div class="custom-upload-input"></div>
                                        </label>

                                        <input type="file" name="attachment" id="attachmentFile"
                                               class="form-control h-auto invisible-file-input @error('attachment') is-invalid @enderror"
                                               value=""/>
                                        @error('attachment')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" name="order_id" value="{{ $checkoutData['order_id'] ?? 0 }}">
                                <input type="hidden" name="gateway" value="offline">

                                <!-- زر الإرسال -->
                                <div class="col-12 col-lg-3">
                                    <div class="mt-30">
                                        <button type="submit" id="submitChargeAccountForm" class="btn btn-primary btn-sm">
                                            {{ trans('public.pay') }}
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.panel-shadow {
    box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.panel-shadow:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.font-14 {
    font-size: 14px;
}

.text-secondary {
    color: #6c757d;
}

.text-gray {
    color: #495057;
}

.custom-upload-input-group {
    display: flex;
    align-items: center;
    background-color: #0d6efd;
    padding: 10px;
    border-radius: 6px;
    cursor: pointer;
    color: #fff;
    justify-content: center;
}

.custom-upload-icon {
    margin-right: 8px;
}

.invisible-file-input {
    display: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('attachmentFile');
    const fileLabel = document.querySelector('.custom-upload-input');

    fileInput.addEventListener('change', function () {
        if (this.files && this.files.length > 0) {
            fileLabel.textContent = this.files[0].name;
        } else {
            fileLabel.textContent = '';
        }
    });
});
</script>
     
                
                
            </div>
             </div>

@endif
@endsection

<style>
.wpwl-container {
    margin: 20px auto;
}
.wpwl-form {
    max-width: 500px;
    margin: 0 auto;
}
.wpwl-label {
    color: #333;
}
.wpwl-control {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
</style>