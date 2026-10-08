@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.'.(!empty($slider) ? 'edit_slider' : 'create_slider')) }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.slider') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/slider/{{ (!empty($slider) ? $slider->id.'/update' : 'store') }}" method="post">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        @if(!empty(getGeneralSettings('content_translate')) and !empty($userLanguages))
                                            <div class="form-group">
                                                <label class="input-label">{{ trans('auth.language') }}</label>
                                                <select name="locale" class="form-control {{ !empty($slider) ? 'js-edit-content-locale' : '' }}">
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
                                            <label>{{ trans('admin/main.title') }}</label>
                                            <input type="text" name="title"
                                                   class="form-control  @error('title') is-invalid @enderror"
                                                   value="{{ !empty($slider) ? $slider->title : old('title') }}"
                                                   placeholder="{{ trans('admin/main.choose_title') }}"/>
                                            @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        {{--<div class="form-group">
                                            <label class="input-label">{{ trans('public.cover_image') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="input-group-text admin-file-manager" data-input="image" data-preview="holder">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="image" id="image" value="{{ (!empty($slider)) ? $slider->image : old('image') }}" class="form-control @error('image') is-invalid @enderror" placeholder="{{ trans('update.slider_cover_image_placeholder') }}"/>
                                                @error('image')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>--}}
                                        
                                         <div class="form-group">
                                          <label class="form-label">{{ app()->getLocale()=='ar' ? 'الفرع'  : 'branch' }}</label>
                                            <select class="form-select select2" name="branch_id" required>
                                                @foreach(\App\Models\Branch::get() as $branch)
                                                <option value="{{ $branch->id }}"     {{ $branch->id == old('branch_id') || (!empty($slider) && $slider->branch_id) ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="input-label">{{ trans('public.cover_image') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="input-group-text admin-file-manager" data-input="image_locale" data-preview="holder">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="image_locale" id="image_locale" value="{{ (!empty($slider)) ? $slider->image_locale : old('image_locale') }}" class="form-control @error('image') is-invalid @enderror" placeholder="{{ trans('update.slider_cover_image_placeholder') }}"/>
                                                @error('image_locale')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                         <div class="form-group">
                                            <label class="input-label">{{ app()->getLocale()=='ar' ? 'الصورة الصغيرة 1' : 'small image 1' }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="input-group-text admin-file-manager" data-input="image_1" data-preview="holder">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="image_1" id="image_1" value="{{ (!empty($slider)) ? $slider->image_1 : old('image_1') }}" class="form-control @error('image_1') is-invalid @enderror" placeholder="{{ app()->getLocale()=='ar' ? 'الصورة الصغيرة 1' : 'small image 1' }}"/>
                                                @error('image_1')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="input-label">{{ app()->getLocale()=='ar' ? 'الصورة الصغيرة 2' : 'small image 2' }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="input-group-text admin-file-manager" data-input="image_2" data-preview="holder">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="image_2" id="image_2" value="{{ (!empty($slider)) ? $slider->image_2 : old('image_2') }}" class="form-control @error('image_2') is-invalid @enderror" placeholder="{{ app()->getLocale()=='ar' ? 'الصورة الصغيرة 2' : 'small image 2' }}"/>
                                                @error('image_2')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="input-label">{{ app()->getLocale()=='ar' ? 'الصورة الصغيرة 3' : 'small image 3' }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="input-group-text admin-file-manager" data-input="image_3" data-preview="holder">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="image_3" id="image_3" value="{{ (!empty($slider)) ? $slider->image_3 : old('image_3') }}" class="form-control @error('image_3') is-invalid @enderror" placeholder="{{ app()->getLocale()=='ar' ? 'الصورة الصغيرة 3' : 'small image 3' }}"/>
                                                @error('image_3')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('admin/main.description') }}</label>
                                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ !empty($slider) ? $slider->description : old('description') }}</textarea>
                                            @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('admin/main.button1_title') }}</label>
                                            <input type="text" name="button1_title"
                                                   class="form-control"
                                                   value="{{ !empty($slider) ? $slider->button1_title : old('button1_title') }}"/>
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('admin/main.button1_link') }}</label>
                                            <input type="text" name="button1_link"
                                                   class="form-control"
                                                   value="{{ !empty($slider) ? $slider->button1_link : old('button1_link') }}"/>
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('admin/main.button2_title') }}</label>
                                            <input type="text" name="button2_title"
                                                   class="form-control"
                                                   value="{{ !empty($slider) ? $slider->button2_title : old('button2_title') }}"/>
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('admin/main.button2_link') }}</label>
                                            <input type="text" name="button2_link"
                                                   class="form-control"
                                                   value="{{ !empty($slider) ? $slider->button2_link : old('button2_link') }}"/>
                                        </div>

                                        <div class="form-group mt-30 d-flex align-items-center cursor-pointer">
                                            <div class="custom-control custom-switch align-items-start">
                                                <input type="checkbox" name="status" class="custom-control-input" id="statusSwitch" {{ (!empty($slider) and $slider->status == '0') ? '' : 'checked' }}>
                                                <label class="custom-control-label" for="statusSwitch"></label>
                                            </div>
                                            <label for="statusSwitch" class="mb-0">{{ trans('admin/main.active') }}</label>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-1">{{ trans('admin/main.save_change') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@push('scripts_bottom')
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
@endpush

@endsection