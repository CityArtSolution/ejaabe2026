<div class="tab-pane mt-3 fade" id="registrationPackage" role="tabpanel" aria-labelledby="registrationPackage-tab">
    <div class="row">
        <div class="col-12 col-md-6">
            <form action="{{ getAdminPanelUrl() }}/users/{{ $user->id }}/userRegistrationPackage" method="Post">
                {{ csrf_field() }}

               {{-- <div class="form-group custom-switches-stacked">
                    <label class="custom-switch pl-0 d-flex align-items-center">
                        <input type="hidden" name="status" value="disabled">
                        <input type="checkbox" name="status" id="packageStatusSwitch" value="active" {{ (!empty($userRegistrationPackage) and $userRegistrationPackage->status == 'active') ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                        <span class="custom-switch-indicator"></span>
                        <label class="custom-switch-description mb-0 cursor-pointer" for="packageStatusSwitch">{{ trans('admin/main.active') }}</label>
                    </label>
                    <div class="text-muted text-small mt-1">{{ trans('update.user_registration_packages_status_hint') }}</div>
                </div>--}}

                @php
                    $packageItems = ['courses_capacity','courses_count','meeting_count'];

                    if(!empty($user) and $user->isOrganization()) {
                        $organizationPackageItems = ['instructors_count','students_count'];

                        $packageItems = array_merge($organizationPackageItems,$packageItems);
                    }
                @endphp
<!--
                @foreach($packageItems as $str)
                    <div class="form-group">
                        <label>{{ trans('update.'.$str) }}</label>
                        <input type="text" class="form-control @error($str) is-invalid @enderror" name="{{ $str }}" value="{{ !empty($userRegistrationPackage) ? $userRegistrationPackage->{$str} : '' }}">

                        @error($str)
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                @endforeach
-->

@php
    
    $userPackage = new \App\Mixins\RegistrationPackage\UserPackage($user);
    $activePackage = $userPackage->getPackage();
@endphp

 <div class="form-group">
    
                    <label class="input-label">{{ trans('admin/main.package') }}</label>
                     <select name="package_id" class="form-control @error('package_id') is-invalid @enderror">
                        <option value="">اختر الباقة</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" 
                                {{ (!empty($activePackage) && $activePackage->package_id == $package->id) ? 'selected' : '' }}>
                                {{ $package->title }} ({{ handlePrice($package->price) }})
                            </option>
                        @endforeach
                    </select>
                    @error('package_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @if(!empty($activePackage) && $activePackage->days_remained>0)
                <section>
                    <h2 class="section-title">{{ trans('financial.my_active_plan') }}</h2>
        
                    <div class="activities-container mt-25 p-20 p-lg-35">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="/assets/default/img/activity/webinars.svg" width="64" height="64" alt="">
                                    <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ $activePackage->title }}</strong>
                                    <span class="font-16 text-gray font-weight-500">{{ trans('financial.active_plan') }}</span>
                                </div>
                            </div>
        
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="/assets/default/img/activity/53.svg" width="64" height="64" alt="">
                                    <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ dateTimeFormat($activePackage->activation_date, 'j M Y') }}</strong>
                                    <span class="font-16 text-gray font-weight-500">{{ trans('update.activation_date') }}</span>
                                </div>
                            </div>
        
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="/assets/default/img/activity/54.svg" width="64" height="64" alt="">
                                    <strong class="font-30 text-dark-blue text-dark-blue font-weight-bold mt-5">{{ $activePackage->days_remained ?? trans('update.unlimited') }}</strong>
                                    <span class="font-16 text-gray font-weight-500">{{ trans('financial.days_remained') }}</span>
                                </div>
                            </div>
        
                        </div>
                    </div>
                </section>
                @else
                
                         <h2 class="section-title">يرجى اختيار باقة</h2>
                
            @endif
        

                

                <div class=" mt-4">
                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
