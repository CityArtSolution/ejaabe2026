@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
     <style>
        div.heading {
    background: #faaa4b;
    color: #fff;
    text-align: center;
    text-transform: uppercase;
    font-weight: bold;
    padding: 1.5em;
    font-size: 1.1em;
    width:100%;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
  }
  .login-container {
  border-radius: 15px;
  background: #ececec;
    margin: 2em auto;
}
.login-card {
    padding: 0px 45px 75px 45px;
}
.rtl .wizard-custom-radio .wizard-custom-radio-item:last-child label {
        border-color: #1363a1;
}
        .login-container {
            width: 100%;
            max-width: 40em;
            margin-left: auto;
            margin-right: auto;
        }

        .login-container .wizard-custom-radio .wizard-custom-radio-item label {
            border: 1px solid #1363a1 !important;
        }

        .login-container .wizard-custom-radio .wizard-custom-radio-item + .wizard-custom-radio-item label {
            margin-inline-start: -1px;
        }

        .login-container .select2-container {
            width: 100% !important;
        }

        @media (max-width: 767px) {
            .login-container {
                margin-top: 1.5em;
                margin-bottom: 2em;
            }

            div.heading {
                padding: 1.1em 1em;
                font-size: 1em;
            }

            .login-card {
                padding: 0 20px 35px;
            }

            .login-card form {
                margin-top: 25px !important;
            }
        }

        @media (max-width: 400px) {
            .login-card {
                padding: 0 6px 28px;
            }

            .login-card .wizard-custom-radio {
                flex-wrap: wrap;
            }

            .login-card .wizard-custom-radio label {
                padding-left: 8px !important;
                padding-right: 8px !important;
            }
        }
    </style>
@endpush

@section('content')

    <div class="container">
        <div class="row login-container">
            <div class="heading">{{ trans('auth.forget_password') }}</div>

            <div class="col-12 col-md-12">

                <div class="login-card">
                    <h1 class="font-20 font-weight-bold" style="display:none">{{ trans('auth.forget_password') }}</h1>

                    <form method="post" action="/forget-password" class="mt-35">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include('web.default.auth.includes.register_methods')

                        @if(!empty(getGeneralSecuritySettings('captcha_for_forgot_pass')))
                            @include('web.default.includes.captcha_input')
                        @endif


                        <button type="submit" class="btn btn-primary btn-block mt-20">{{ trans('auth.reset_password') }}</button>
                    </form>

                    <div class="text-center mt-20">
                        <span class="badge badge-circle-gray300 text-secondary d-inline-flex align-items-center justify-content-center">or</span>
                    </div>

                    <div class="text-center mt-20">
                        <span class="text-secondary">
                            <a href="/login" class="text-secondary font-weight-bold">{{ trans('auth.login') }}</a>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/js/parts/forgot_password.min.js"></script>
@endpush
