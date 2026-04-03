@extends('admin.layouts.app')

@push('styles_top')
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{!empty($branch) ?trans('/admin/main.edit'): trans('admin/main.new') }} {{ trans('branches.branch') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('branches.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ getAdminPanelUrl() }}/branches">{{ trans('branches.branches') }}</a>
                </div>
                <div class="breadcrumb-item">{{!empty($branch) ?trans('/admin/main.edit'): trans('branches.new') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/branches/{{ !empty($branch) ? $branch->id.'/update' : 'store' }}"
                                  method="Post">
                                {{ csrf_field() }}

                                @if(!empty(getGeneralSettings('content_translate')))
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('auth.language') }}</label>
                                        <select name="locale" class="form-control {{ !empty($branch) ? 'js-edit-content-locale' : '' }}">
                                            @foreach($userLanguages as $lang => $language)
                                                <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>{{ $language }}</option>
                                            @endforeach
                                        </select>
                                        @error('locale')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                @else
                                    <input type="hidden" name="locale" value="{{ getDefaultLocale() }}">
                                @endif

                                <div class="form-group">
                                    <label>{{ trans('public.name') }}</label>
                                    <input type="text" name="name"
                                           class="form-control  @error('name') is-invalid @enderror"
                                           value="{{ !empty($branch) ? $branch->name : old('name') }}"
                                           placeholder="{{ trans('branches.name') }}" required/>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('branches.subdomain') }}</label>
                                    <input type="text" name="subdomain"
                                           class="form-control  @error('subdomain') is-invalid @enderror"
                                           value="{{ !empty($branch) ? $branch->subdomain : old('subdomain') }}" required/>
                                    @error('subdomain')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.address') }}</label>
                                    <input type="text" name="address"
                                           class="form-control  @error('address') is-invalid @enderror"
                                           value="{{ !empty($branch) ? $branch->address : old('address') }}"/>
                                    @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label>{{ trans('public.phone') }}</label>
                                    <input type="text" name="phone_number"
                                           class="form-control  @error('phone_number') is-invalid @enderror"
                                           value="{{ !empty($branch) ? $branch->phone_number : old('phone_number') }}"/>
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('public.email') }}</label>
                                    <input type="email" name="email"
                                           class="form-control  @error('email') is-invalid @enderror"
                                           value="{{ !empty($branch) ? $branch->email : old('email') }}"/>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{ trans('branches.location') }}</label>
                                    <input type="text" name="location"
                                           class="form-control  @error('location') is-invalid @enderror"
                                           value="{{ !empty($branch) ? $branch->location : old('location') }}"/>
                                    @error('location')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('branches.home_page') }}</label>
                                    <input type="text" name="home_page"
                                           class="form-control  @error('location') is-invalid @enderror"
                                           value="{{ !empty($branch) ? $branch->home_page : old('home_page') }}"/>
                                    @error('home_page')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{ trans('branches.currency') }}</label>
                                    <input type="text" name="currency"
                                           class="form-control  @error('currency') is-invalid @enderror"
                                           value="{{ !empty($branch) ? $branch->currency : old('currency') }}"/>
                                    <div class="text-muted text-small mt-1">{{ trans('branches.currency') }}</div>
                                    @error('currency')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">{{ trans('public.status') }}</label>
<select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
    <option disabled selected>{{ trans('public.status') }}</option>
    <option value="1" {{ (old('status', !empty($branch) ? $branch->status : '') == 1) ? 'selected' : '' }}>
        {{ trans('branches.enabled') }}
    </option>
    <option value="0" {{ (old('status', !empty($branch) ? $branch->status : '') == 0) ? 'selected' : '' }}>
        {{ trans('branches.disabled') }}
    </option>
</select>
@error('status')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
                                </div>

                              
                           
                                                    </div>
                                               
                                     
                                </div>

                                <div class="text-right mt-4">
                                    <button class="btn btn-primary">{{ trans('branches.submit') }}</button>
                                </div>
                            </form>

                       

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>

    <script src="/assets/default/js/admin/categories.min.js"></script>
@endpush
