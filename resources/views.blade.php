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

<div class="main_content_iner main_content_padding">

    <div class="dashboard_lg_card">
        <div class="container-fluid no-gutters">
            <div class="row">
                <div class="col-12">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('payment.Fund Deposit')}}</h3>
                                </div>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-xl-12">
                                <form>
                                    @csrf
                                    <div class="single_totl_warp col-lg-12 pl-0">
                                        <h3 class="font_18 mb-2">{{__('payment.Deposit Amount')}}
                                            @if(auth()->user()->branch_id==4)
                                                CA$
                                            @else
                                                ({{Settings('currency_symbol') ?? '৳'}})
                                            @endif
                                            <span class="text-danger">*</span>
                                        </h3>
                                        <div class="input-group mb-3 input-group-lg deposit_save_info">
                                            <input
                                                placeholder=""
                                                name="deposit_amount"
                                                type="number"
                                                step="any"
                                                min="1"
                                                value="{{!empty($amount)?$amount:''}}"
                                                class="primary_input col-md-6"
                                                required>
                                            <div class="input-group-prepend">
                                                <button type="submit" style="margin-bottom: 30px;"
                                                    class="theme_btn btn-sm  small_btn2">
                                                    {{__('payment.Save Info')}}
                                                </button>
                                            </div>
                                            <strong class="text-danger">{{$errors->first('deposit_amount')}}</strong>
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
                                                    <h3 class="mb-0">{{__('common.Select')}} {{__('payment.Payment Method')}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="deposit_lists_wrapper mb-50">
                                                    @if(isset($methods))
                                                        @foreach($methods as $key=>$gateway)
                                                            <div class="single_deposite {{$gateway->method=="Bank Payment"?'p-0 border-0':''}}">
                                                                <div class="single_deposite_item">
                                                                    <form action="{{route('depositSelect')}}" method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="deposit_amount" value="{{$amount}}">
                                                                        <input type="hidden" name="method" value="{{$gateway->method}}">
                                                                        <button type="submit" class="">
                                                                            <img class="submitBtn" src="{{asset($gateway->logo)}}" alt="">
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
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

    @if(count($records)!=0)
        <div class="main_content_iner">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="purchase_history_wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section__title3 mb_40">
                                        <h3 class="mb-0">{{__('payment.Deposit history')}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table custom_table3 mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{__('common.SL')}}</th>
                                                    <th scope="col">{{__('common.Date')}}</th>
                                                    <th scope="col">{{__('payment.Amount')}}</th>
                                                    <th scope="col">{{__('payment.Method')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($records))
                                                    @foreach ($records as $key=>$record)
                                                        <tr>
                                                            <td>{{@$key+1}}</td>
                                                            <td>{{ showDate($record->created_at) }}</td>
                                                            <td>{{@$record->amount}}</td>
                                                            <td>{{@$record->method}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <div class="mt-4">
                                            {{ $records->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/payment.min.js"></script>
@endpush
