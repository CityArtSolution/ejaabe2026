@if(!empty($authUser))

    <div class="custom-dropdown navbar-auth-user-dropdown position-relative ml-50">
        <div class="custom-dropdown-toggle d-flex align-items-center navbar-user cursor-pointer">
            <img style="width:36px" src="{{ $authUser->getAvatar() }}" class="rounded-circle" alt="{{ $authUser->full_name }}">
            <span class="font-16 user-name ml-10 text-dark-blue font-14">{{ $authUser->full_name }}</span>
        </div>

        <div class="custom-dropdown-body pb-10">

            <div class="dropdown-user-avatar d-flex align-items-center p-15 m-15 mb-10 rounded-sm border">
                <div class="size-40 rounded-circle position-relative">
                    <img src="{{ $authUser->getAvatar() }}" class="img-cover rounded-circle" alt="{{ $authUser->full_name }}">
                </div>

                <div class="ml-5">
                    <div class="font-14 font-weight-bold text-secondary">{{ $authUser->full_name }}</div>
                    <span class="mt-5 text-gray font-12">{{ $authUser->role->caption }}</span>
                </div>
            </div>

            <ul class="my-8">
                @if($authUser->isAdmin())
                    <li class="navbar-auth-user-dropdown-item">
                        <a href="{{ getAdminPanelUrl() }}" class="d-flex align-items-center w-100 px-15 py-10 text-gray font-14 bg-transparent">
                            <img src="/assets/default/img/icons/user_menu/dashboard.svg" class="icons">
                            <span class="ml-5">{{ trans('panel.dashboard') }}</span>
                        </a>
                    </li>

                    <li class="navbar-auth-user-dropdown-item">
                        <a href="{{ getAdminPanelUrl("/settings") }}" class="d-flex align-items-center w-100 px-15 py-10 text-gray font-14 bg-transparent">
                            <img src="/assets/default/img/icons/user_menu/settings.svg" class="icons">
                            <span class="ml-5">{{ trans('panel.settings') }}</span>
                        </a>
                    </li>
                @else
                    <li class="navbar-auth-user-dropdown-item">
                        <a href="/panel" class="d-flex align-items-center w-100 px-15 py-10 text-gray font-14 bg-transparent">
                            <img src="/assets/default/img/icons/user_menu/dashboard.svg" class="icons">
                            <span class="ml-5">{{ trans('panel.dashboard') }}</span>
                        </a>
                    </li>


                    <li class="navbar-auth-user-dropdown-item">
                        <a href="{{ ($authUser->isUser()) ? '/panel/webinars/purchases' : '/panel/webinars' }}" class="d-flex align-items-center w-100 px-15 py-10 text-gray font-14 bg-transparent">
                            <img src="/assets/default/img/icons/user_menu/my_courses.svg" class="icons">
                            <span class="ml-5">{{ trans('update.my_courses') }}</span>
                        </a>
                    </li>

                    @if(!$authUser->isUser())
                        <li class="navbar-auth-user-dropdown-item">
                            <a href="/panel/financial/sales" class="d-flex align-items-center w-100 px-15 py-10 text-gray font-14 bg-transparent">
                                <img src="/assets/default/img/icons/user_menu/sales_history.svg" class="icons">
                                <span class="ml-5">{{ trans('financial.sales_history') }}</span>
                            </a>
                        </li>
                    @endif

                    <li class="navbar-auth-user-dropdown-item">
                        <a href="/panel/support" class="d-flex align-items-center w-100 px-15 py-10 text-gray font-14 bg-transparent">
                            <img src="/assets/default/img/icons/user_menu/support.svg" class="icons">
                            <span class="ml-5">{{ trans('panel.support') }}</span>
                        </a>
                    </li>

                    @if(!$authUser->isUser() and empty(getFeaturesSettings('mobile_app_status')))
                        <li class="navbar-auth-user-dropdown-item">
                            <a href="{{ $authUser->getProfileUrl() }}" class="d-flex align-items-center w-100 px-15 py-10 text-gray font-14 bg-transparent">
                                <img src="/assets/default/img/icons/user_menu/profile.svg" class="icons">
                                <span class="ml-5">{{ trans('public.profile') }}</span>
                            </a>
                        </li>
                    @endif

                    <li class="navbar-auth-user-dropdown-item">
                        <a href="/panel/setting" class="d-flex align-items-center w-100 px-15 py-10 text-gray font-14 bg-transparent">
                            <img src="/assets/default/img/icons/user_menu/settings.svg" class="icons">
                            <span class="ml-5">{{ trans('panel.settings') }}</span>
                        </a>
                    </li>
                @endif

                <li class="navbar-auth-user-dropdown-item">
                    <a href="/logout" class="d-flex align-items-center w-100 px-15 py-10 text-danger font-14 bg-transparent">
                        <img src="/assets/default/img/icons/user_menu/logout.svg" class="icons">
                        <span class="ml-5">{{ trans('auth.logout') }}</span>
                    </a>
                </li>

            </ul>

        </div>
    </div>
@else
        <style>
            .btn-custom-link {
                display: inline-block;
                padding: 9px 16px;
                font-size: 14px;
                font-weight: 600;
                color: #0d3b66; /* أزرق غامق */
                background-color: #f5f9ff; /* خلفية فاتحة */
                border: 1px solid #0d3b66;
                border-radius: 8px;
                text-decoration: none;
                transition: all 0.3s ease;
                text-align: center;
                white-space: nowrap;
                margin: 0 5px; /* مسافة أفقية بين الأزرار */
            }
        
            .btn-custom-link:hover {
                background-color: #0d3b66;
                color: #fff;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                transform: translateY(-2px);
            }
        
            .auth-buttons-canada {
                display: flex;
                gap: 10px; /* مسافة بين الزرارين */
                align-items: center;
                justify-content: flex-end;
                flex-wrap: wrap;
            }

            .auth-buttons-canada .btn-custom-link {
                margin: 0;
            }

            @media (max-width: 575.98px) {
                .auth-buttons-canada {
                    width: 100%;
                    justify-content: center;
                    gap: 6px;
                }

                .auth-buttons-canada .btn-custom-link {
                    flex: 1 1 calc(50% - 6px);
                    max-width: 150px;
                    min-width: 0;
                    padding: 8px 10px;
                    font-size: 13px;
                }
            }

            @media (max-width: 360px) {
                .auth-buttons-canada .btn-custom-link {
                    padding: 7px 8px;
                    font-size: 12px;
                }
            }
        </style>
        
        <div class="auth-buttons-canada">
            <a href="/canada/login" class="btn-custom-link">{{ trans('auth.login') }}</a>
            <a href="/canada/register" class="btn-custom-link">{{ trans('auth.register') }}</a>
        </div>
@endif
