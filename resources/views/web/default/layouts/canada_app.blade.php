<!DOCTYPE html>
<html lang="en">

<head>
    @include('web.default.includes.metas')
    <meta name="robots" content="noindex, nofollow">

    <title>{{ $pageTitle ?? '' }}{{ !empty($generalSettings['site_name']) ? (' - '.$generalSettings['site_name']) : '' }}</title>

    <!-- General CSS File -->
    <link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/toast/jquery.toast.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/simplebar/simplebar.css">
    <link rel="stylesheet" href="{{ asset('assets/default/css/app.css?v=') . time() }}">

    <script src="https://kit.fontawesome.com/ea345573be.js" crossorigin="anonymous"></script>

    @stack('styles_top')
    @stack('scripts_top')

    <style>
        {!! getThemeFontsSettings() !!}
        {!! getThemeColorsSettings() !!}
    </style>

    @if(!empty($generalSettings['preloading']) and $generalSettings['preloading'] == '1')
        @include('admin.includes.preloading')
    @endif
</head>

<body>
<div id="app" class="{{ (!empty($floatingBar) && $floatingBar->position == 'top' && $floatingBar->fixed) ? 'has-fixed-top-floating-bar' : '' }}">
    @if(!empty($floatingBar) && $floatingBar->position == 'top')
        @include('web.default.includes.floating_bar')
    @endif

    @if(!isset($appHeader))
        @include('web.default.includes.top_nav_canda')
        @include('web.default.includes.navbar_canada')
    @endif

    @if(!empty($justMobileApp))
        @include('web.default.includes.mobile_app_top_nav')
    @endif

    @yield('content')

    @if(!isset($appFooter))
        @include('web.default.includes.canada_footer')
    @endif

    @include('web.default.includes.advertise_modal.index')

    @if(!empty($floatingBar) && $floatingBar->position == 'bottom')
        @include('web.default.includes.floating_bar')
    @endif
</div>

<!-- Template JS File -->
<script src="/assets/default/js/app.js"></script>
<script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
<script src="/assets/default/vendors/moment.min.js"></script>
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/default/vendors/toast/jquery.toast.min.js"></script>
<script type="text/javascript" src="/assets/default/vendors/simplebar/simplebar.min.js"></script>
<link rel="stylesheet" href="/path/to/flaticon.css">
<link rel="stylesheet" href="/public/assets/demo/assets/css/flaticon-set.css">

<style>
.flaticon-result:before { color: black; }
.flaticon-creativity:before { color: black; }
.flaticon-meeting:before { color: black; }

.modern-services-area .item::before {
    position: absolute;
    left: 0;
    bottom: 0;
    content: "";
    height: 70%;
    width: 100%;
    background: #103b88;
    z-index: -1;
    border-radius: 8px;
    transition: all 0.35s ease-in-out;
    opacity: 0;
}
</style>
@if(empty($justMobileApp) && checkShowCookieSecurityDialog())
    @include('web.default.includes.cookie-security')
@endif

<script>
    var deleteAlertTitle = '{{ trans('public.are_you_sure') }}';
    var deleteAlertHint = '{{ trans('public.deleteAlertHint') }}';
    var deleteAlertConfirm = '{{ trans('public.deleteAlertConfirm') }}';
    var deleteAlertCancel = '{{ trans('public.cancel') }}';
    var deleteAlertSuccess = '{{ trans('public.success') }}';
    var deleteAlertFail = '{{ trans('public.fail') }}';
    var deleteAlertFailHint = '{{ trans('public.deleteAlertFailHint') }}';
    var deleteAlertSuccessHint = '{{ trans('public.deleteAlertSuccessHint') }}';
    var forbiddenRequestToastTitleLang = '{{ trans('public.forbidden_request_toast_lang') }}';
    var forbiddenRequestToastMsgLang = '{{ trans('public.forbidden_request_toast_msg_lang') }}';
</script>

@if(session()->has('toast'))
    <script>
        (function () {
            "use strict";
            $.toast({
                heading: '{{ session()->get('toast')['title'] ?? '' }}',
                text: '{{ session()->get('toast')['msg'] ?? '' }}',
                bgColor: '@if(session()->get('toast')['status'] == 'success') #43d477 @else #f63c3c @endif',
                textColor: 'white',
                hideAfter: 10000,
                position: 'bottom-right',
                icon: '{{ session()->get('toast')['status'] }}'
            });
        })(jQuery)
    </script>
@endif

@include('web.default.includes.purchase_notifications')

@stack('styles_bottom')
@stack('scripts_bottom')

<script src="/assets/default/js/parts/main.min.js"></script>

<script>
    @if(session()->has('registration_package_limited'))
        (function () {
            "use strict";
            handleLimitedAccountModal('{!! session()->get('registration_package_limited') !!}')
        })(jQuery)

        {{ session()->forget('registration_package_limited') }}
    @endif

    {!! !empty(getCustomCssAndJs('js')) ? getCustomCssAndJs('js') : '' !!}
</script>
</body>
</html>
