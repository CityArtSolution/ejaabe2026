@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/bootstrap-timepicker/bootstrap-timepicker.min.css">

    <link rel="stylesheet" href="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.css">
    <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
     <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <style>
        .bootstrap-timepicker-widget table td input {
            width: 35px !important;
        }

        .select2-container {
            z-index: 1212 !important;
        }
        .choose_type {
            color: red !important;
            font-weight:800;
        }
        select#type{

                background: #e4f7e6;
        }
                .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            font-size: 28px;
            font-weight: bold;
            color: #1363a1;
            margin-bottom: 24px;
            text-align: center;
        }

        .error-container {
            margin-bottom: 16px;
            padding: 16px;
            border: 1px solid #fecaca;
            border-radius: 8px;
            background-color: #fef2f2;
            color: #1363a1;
        }

        .error-list {
            list-style: disc;
            padding-right: 24px;
        }

        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 24px;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #1363a1;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .form-input[type="file"] {
            padding: 8px;
            border: 2px dashed #d1d5db;
            background-color: #f9fafb;
            cursor: pointer;
        }

        .form-input[type="file"]:hover {
            border-color: #1363a1;
            background-color: #fef2f2;
        }

        .button-group {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1363a1 0%, #52a7e9 100%);
            color: white;
            font-weight: bold;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .btn-link {
            color: #6b7280;
            text-decoration: underline;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .btn-link:hover {
            color: #1363a1;
        }

        .preview-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 24px;
            margin-top: 32px;
        }

        .preview-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #374151;
        }

        .iframe-container {
            position: relative;
            width: 100%;
            height: 70vh;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .iframe-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .preview-info {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.8;
        }

        .preview-info code {
            background-color: #f3f4f6;
            padding: 4px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }

        .preview-link {
            margin-top: 8px;
        }

        .preview-link a {
            color: #1363a1;
            text-decoration: underline;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .preview-link a:hover {
            color: #b91c1c;
        }

        @media (max-width: 768px) {
            .container {
                padding: 16px;
            }

            .page-title {
                font-size: 24px;
            }

            .form-container {
                padding: 16px;
            }

            .button-group {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-primary {
                text-align: center;
            }
        }

    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{!empty($webinar) ?trans('/admin/main.edit'): trans('admin/main.new') }} {{ trans('admin/main.class') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ getAdminPanelUrl() }}/webinars">{{ trans('admin/main.classes') }}</a>
                </div>
                <div class="breadcrumb-item">{{!empty($webinar) ?trans('/admin/main.edit'): trans('admin/main.new') }}</div>
            </div>
        </div>

        <div class="section-body">

<script>
    function updateShowOnHomepage(webinarId) {
        if (!webinarId) return;

        let showValue = document.getElementById('showOnHomepageToggle').checked ? 1 : 0;

        fetch('{{ getAdminPanelUrl() }}/webinars/' + webinarId + '/toggle-homepage', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                show_on_homepage: showValue
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ أثناء التحديث.');
            }
        })
        .catch(error => {
            console.error(error);
            alert('فشل في الاتصال بالسيرفر.');
        });
    }
</script>
       <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(!empty($webinar->scorm_file))
                <form method="post" action="{{ getAdminPanelUrl() }}/webinars/{{ !empty($webinar) ? $webinar->id.'/update/scorm/webinar' : 'store' }}" id="webinarForm" class="webinar-form" enctype="multipart/form-data">
                @else
                <form method="post" action="{{ getAdminPanelUrl() }}/webinars/{{ !empty($webinar) ? $webinar->id.'/update' : 'store' }}" id="webinarForm" class="webinar-form" enctype="multipart/form-data">
                @endif
                    {{ csrf_field() }}
                    <section class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="section-title after-line mb-0">{{ trans('public.basic_information') }}</h2>
                        <br>
                        @if(!empty($webinar))
                             <div class="form-group mb-0 d-flex align-items-center">
                            <label class="input-label mb-0 mr-2">عرض في الصفحة الرئيسية</label>

                            <label class="custom-switch mb-0 ml-2">
                                <input type="checkbox" id="showOnHomepageToggle"
                                       {{ $webinar->show_on_homepage ? 'checked' : '' }}
                                       onchange="updateShowOnHomepage({{ $webinar->id }})">
                                <span class="custom-switch-slider"></span>
                            </label>
                        </div>
                        <style>
                            .custom-switch {
                                position: relative;
                                display: inline-block;
                                width: 40px;
                                height: 24px;
                                }

                                .custom-switch input {
                                display: none;
                                }

                                .custom-switch-slider {
                                position: absolute;
                                cursor: pointer;
                                top: 0;
                                left: 0;
                                right: 0;
                                bottom: 0;
                                background-color: #ccc;
                                transition: .4s;
                                border-radius: 24px;
                                }

                                .custom-switch-slider:before {
                                position: absolute;
                                content: "";
                                height: 18px;
                                width: 18px;
                                left: 3px;
                                bottom: 3px;
                                background-color: white;
                                transition: .4s;
                                border-radius: 50%;
                                }

                                .custom-switch input:checked + .custom-switch-slider {
                                background-color: #28a745;
                                }

                                .custom-switch input:checked + .custom-switch-slider:before {
                                transform: translateX(26px);
                                }

                                                        </style>
                        @endif
                    </section>

                    <div class="row">
                        <div class="col-12 col-md-5">
                            @if(!empty(getGeneralSettings('content_translate')))
                                <div class="form-group">
                                    <label class="input-label">{{ trans('auth.language') }}</label>
                                    <select name="locale" class="form-control {{ !empty($webinar) ? 'js-edit-content-locale' : '' }}">
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

                            @if(!empty($webinar->scorm_file))
                            <div class="form-group mt-15">
                                <label class="input-label d-none choose_type">{{ trans('panel.course_type') }}*</label>
                                <select name="type" id="type" class="d-none custom-select @error('type') is-invalid @enderror" required>
                                    <option value="offline" selected>{{ trans('webinars.offline') }}</option>
                                </select>
                            </div>
                            @else
                          <div class="form-group mt-15">
                            <label class="input-label d-block choose_type">{{ trans('panel.course_type') }}*</label>
                            <select name="type" id="type" class="custom-select @error('type') is-invalid @enderror" required>
                                <option value="" disabled selected>{{ trans('admin/main.select_course_type') }}</option> <!-- Default option -->
                                <option value="text_lesson" @if((!empty($webinar) and $webinar->isTextCourse()) or old('type') == \App\Models\Webinar::$textLesson) selected @endif>{{ trans('webinars.text_course') }}</option>
                                <option value="course" @if((!empty($webinar) and $webinar->isCourse()) or old('type') == \App\Models\Webinar::$course) selected @endif>{{  trans('admin/main.face to face') }}</option>
                                <option value="offline" @if((!empty($webinar) and $webinar->isOffline()) or old('type') == \App\Models\Webinar::$offline) selected @endif>{{ trans('webinars.offline') }}</option>
                                <option value="webinar" @if((!empty($webinar) and $webinar->isWebinar()) or old('type') == \App\Models\Webinar::$webinar) selected @endif>{{ trans('webinars.webinar') }}</option>
                            </select>
                                @error('type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @endif

                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('admin/main.course title') }}</label>
                                                <input type="text" name="title" value="{{ !empty($webinar) ? $webinar->title : old('title') }}" class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                                                @error('title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                          <!--  <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('update.points') }}</label>
                                                <input type="number" name="points" value="{{ !empty($webinar) ? $webinar->points : old('points') }}" class="form-control @error('points')  is-invalid @enderror" placeholder="Empty means inactive this mode"/>
                                                @error('points')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>-->

                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('webinars.class_url') }}-{{ trans('admin/main.url_auto') }}</label>
                                                <input type="text" name="slug" value="{{ !empty($webinar) ? $webinar->slug : old('slug') }}" class="form-control @error('slug')  is-invalid @enderror" placeholder=""/>
                                               {{-- <div class="text-muted text-small mt-1">{{ trans('admin/main.class_url_hint') }}</div>--}}
                                                @error('slug')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            @if(!empty($webinar) and $webinar->creator->isOrganization())
                                                <div class="form-group mt-15 ">
                                                    <label class="input-label d-block">{{ trans('admin/main.organization') }}</label>

                                                    <select name="organ_id" data-search-option="just_organization_role" class="form-control search-user-select2" data-placeholder="{{ trans('search_organization') }}">
                                                        <option value="{{ $webinar->creator->id }}" selected>{{ $webinar->creator->full_name }}</option>
                                                    </select>
                                                </div>
                                            @endif

                                             @php
                                            $adminSelectedBranch = session('admin_selected_branch', 1);

                                            if (!isset($selectedBranchIds)) {
                                                $selectedBranchIds = [$adminSelectedBranch];
                                            }
                                        @endphp
                                        <label class="form-label">{{ trans('branches.branches') }}</label>
                                            <select class="form-select select2" name="branch_id" required>
                                                @foreach(\App\Models\Branch::get() as $branch)
                                                <option value="{{ $branch->id }}"     {{ $branch->id == old('branch_id', $webinar->branch_id ?? $selectedBranchIds[0]) ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                                </option>
                                                @endforeach
                                            </select>


                                        </div>
                                    </div>
                                    <div class="row">
                                           <div class="col-12">
                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('webinars.description') }}<span style="color:red">*</span></label>
                                                <textarea id="summernote" name="description" class="form-control @error('description')  is-invalid @enderror" placeholder="{{ trans('forms.webinar_description_placeholder') }}">{!! !empty($webinar) ? $webinar->description : old('description')  !!}</textarea>
                                                @error('description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>


                                    </div>
                            @if(empty($webinar->scorm_file))
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <!-- add sections -->
                            <div id="sections-container" style="display: {{ (!empty($webinar) && ($webinar->type === 'text_lesson' || $webinar->type === 'course' || $webinar->type === 'offline')) || (old('type') === 'text_lesson' || old('type') === 'course' || old('type') === 'offline') ? 'block' : 'none' }}">
                                            <label class="input-label d-block" style="background: #b8c3ed;color: #fff; padding: 5px;
                            color: #000;font-weight: 700;font-size: 15px;">{{ trans('public.sections') }}</label>

                                            <div id="sections">  <!-- Added this container div -->
                                                @if(!empty($webinar) && !is_null($webinar->sections) && $webinar->sections)
                                                    @foreach (json_decode($webinar->sections, true) as $section)
                                                        <div class="section">
                                                            <input type="text" name="section_title[]" class="form-control" value="{{ $section['title'] ?? '' }}">
                                                            <div class="summernote-container">
                                                                <textarea name="section_details[]" class="summernote form-control">{{ $section['detail'] ?? '' }}</textarea>
                                                            </div>
                                                            <button type="button" class="btn btn-danger remove-section">{{__('public.Remove')}}</button>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="section">
                                                        <input type="text" name="section_title[]" class="form-control" placeholder="{{__('public.name_section')}}">
                                                        <div class="summernote-container">
                                                            <textarea name="section_details[]" class="summernote form-control"></textarea>
                                                        </div>
                                                        <button type="button" class="btn btn-danger remove-section">{{__('public.Remove')}}</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                            <button type="button" class="btn btn-primary" id="add-section" style="display: {{ (!empty($webinar) && ($webinar->type === 'text_lesson' || $webinar->type === 'course' || $webinar->type === 'offline')) || (old('type') === 'text_lesson' || old('type') === 'course' || old('type') === 'offline') ? 'block' : 'none' }}">
                                {{ __('public.Add Section') }}
                            </button>
                                    </div>
    </div>
                            </div>
                            @endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any existing Summernote editors
    initializeSummernote();

    // Handle type selection change
    document.getElementById('type').addEventListener('change', function() {
        const sectionsContainer = document.getElementById('sections-container');
        const coursedetailscontainer = document.getElementById('course-details-container');

        if (this.value !='webinar') {
            sectionsContainer.style.display = 'block';
            $('#add-section').show();
          if (this.value === 'text_lesson')  {
            coursedetailscontainer.style.display = 'block';
            $('.add').show();
            initializeSummernote();
           }
           else{
                coursedetailscontainer.style.display = 'none';
            $('.add').hide();

           }

        } else {
            sectionsContainer.style.display = 'none';
            $('#add-section').hide();
            coursedetailscontainer.style.display = 'none';
            $('.add').hide();
        }
    });

    // Add new section
    document.getElementById('add-section').addEventListener('click', function() {
        const sectionTemplate = `
            <div class="section">
                <input type="text" name="section_title[]" class="form-control" placeholder="{{__('public.name_section')}}">
                <div class="summernote-container">
                    <textarea name="section_details[]" class="summernote form-control"></textarea>
                </div>
                <button type="button" class="btn btn-danger remove-section">{{__('public.Remove')}}</button>
            </div>
        `;

        const sectionsContainer = document.getElementById('sections');
        sectionsContainer.insertAdjacentHTML('beforeend', sectionTemplate);

        // Initialize Summernote for the newly added section
        const newSection = sectionsContainer.lastElementChild;
        const newSummernote = newSection.querySelector('.summernote');
        $(newSummernote).summernote({
            height: 200
        });
    });

    // Remove section using event delegation
    document.getElementById('sections-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-section')) {
            const sectionsCount = document.querySelectorAll('.section').length;

            if (sectionsCount > 1) {
                e.target.closest('.section').remove();
            } else {
                alert('You cannot remove the last section!');
            }
        }
    });

    // Function to initialize Summernote
    function initializeSummernote() {
        $('.summernote').each(function() {
            $(this).summernote({
                height: 200
            });
        });
    }
});
</script>

<style>
.section {
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 5px;
}

.section input {
    margin-bottom: 10px;
}

.summernote-container {
    margin-bottom: 10px;
}

.remove-section {
    margin-top: 10px;
}

#add-section {
    margin-top: 15px;
}
</style>



                                    <div class="row">
                                        <div class="col-12 col-md-5">


<div class="form-group mt-15">
    <label class="input-label d-block">{{ trans('admin/main.select_a_instructor') }}</label>

    <select name="teacher_id" data-search-option="except_user" class="form-control search-user-select22"
            data-placeholder="{{ trans('public.select_a_teacher') }}"
    >
        @if(!empty($webinar) && $webinar->teacher->id != auth()->user()->id)
            <option value="{{ $webinar->teacher->id }}" selected>{{ $webinar->teacher->full_name }}</option>
        @endif
        <option value="{{ auth()->user()->id }}" {{ (empty($webinar) || $webinar->teacher->id == auth()->user()->id) ? 'selected' : '' }}>
            {{ auth()->user()->full_name }}
        </option>
    </select>

    @error('teacher_id')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>


                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.seo_description') }}</label>
                                                <input type="text" name="seo_description" value="{{ !empty($webinar) ? $webinar->seo_description : old('seo_description') }}" class="form-control @error('seo_description')  is-invalid @enderror"/>
                                                <div class="text-muted text-small mt-1">{{ trans('admin/main.seo_description_hint') }}</div>
                                                @error('seo_description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.thumbnail_image') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="input-group-text admin-file-manager" data-input="thumbnail" data-preview="holder">
                                                            <i class="fa fa-upload"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" name="thumbnail" id="thumbnail" value="{{ !empty($webinar) ? $webinar->thumbnail : old('thumbnail') }}" class="form-control @error('thumbnail')  is-invalid @enderror"/>
                                                    <div class="input-group-append">
                                                        <button type="button" class="input-group-text admin-file-view" data-input="thumbnail">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    @error('thumbnail')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.cover_image') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="input-group-text admin-file-manager" data-input="cover_image" data-preview="holder">
                                                            <i class="fa fa-upload"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" name="image_cover" id="cover_image" value="{{ !empty($webinar) ? $webinar->image_cover : old('image_cover') }}" class="form-control @error('image_cover')  is-invalid @enderror"/>
                                                    <div class="input-group-append">
                                                        <button type="button" class="input-group-text admin-file-view" data-input="cover_image">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    @error('image_cover')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.approval_name') }}</label>
                                                <input type="text" name="approval_name" value="{{ !empty($webinar) ? $webinar['approval_name'] : old('approval_name') }}" class="form-control @error('approval_name')  is-invalid @enderror" placeholder=""/>
                                                @error('approval_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.approval_logo') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="input-group-text admin-file-manager" data-input="approval_logo" data-preview="holder">
                                                            <i class="fa fa-upload"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" name="approval_logo" id="approval_logo" value="{{ !empty($webinar) ? $webinar->approval_logo : old('approval_logo') }}" class="form-control @error('approval_logo')  is-invalid @enderror"/>
                                                    <div class="input-group-append">
                                                        <button type="button" class="input-group-text admin-file-view" data-input="approval_logo">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    @error('approval_logo')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group mt-25">
                                                <label class="input-label">{{ trans('public.demo_video') }} ({{ trans('public.optional') }})</label>


                                                <div class="">
                                                    <label class="input-label font-12">{{ trans('public.source') }}</label>
                                                    <select name="video_demo_source"
                                                            class="js-video-demo-source form-control"
                                                    >
                                                        @foreach(\App\Models\Webinar::$videoDemoSource as $source)
                                                            <option value="{{ $source }}" @if(!empty($webinar) and $webinar->video_demo_source == $source) selected @endif>{{ trans('update.file_source_'.$source) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="js-video-demo-other-inputs form-group mt-0 {{ (empty($webinar) or $webinar->video_demo_source != 'secure_host') ? '' : 'd-none' }}">
                                                <label class="input-label font-12">{{ trans('update.path') }}</label>
                                                <div class="input-group js-video-demo-path-input">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="js-video-demo-path-upload input-group-text admin-file-manager {{ (empty($webinar) or empty($webinar->video_demo_source) or $webinar->video_demo_source == 'upload') ? '' : 'd-none' }}" data-input="demo_video" data-preview="holder">
                                                            <i class="fa fa-upload"></i>
                                                        </button>

                                                        <button type="button" class="js-video-demo-path-links rounded-left input-group-text input-group-text-rounded-left  {{ (empty($webinar) or empty($webinar->video_demo_source) or $webinar->video_demo_source == 'upload') ? 'd-none' : '' }}">
                                                            <i class="fa fa-link"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" name="video_demo" id="demo_video" value="{{ !empty($webinar) ? $webinar->video_demo : old('video_demo') }}" class="form-control @error('video_demo')  is-invalid @enderror"/>
                                                    @error('video_demo')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group js-video-demo-secure-host-input {{ (!empty($webinar) and $webinar->video_demo_source == 'secure_host') ? '' : 'd-none' }}">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="input-group-text">
                                                            <i class="fa fa-upload"></i>
                                                        </button>
                                                    </div>
                                                    <div class="custom-file js-ajax-s3_file">
                                                        <input type="file" name="video_demo_secure_host_file" class="custom-file-input cursor-pointer" id="video_demo_secure_host_file" accept="video/*">
                                                        <label class="custom-file-label cursor-pointer" for="video_demo_secure_host_file">{{ trans('update.choose_file') }}</label>
                                                    </div>

                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>




                                    <div class="row">


                                    <!----dates and locations and prices--->
                                     <div class="col-12">
                                   <div class="form-group mt-15">
                                    <div id="course-details-container" style="display: {{ (!empty($webinar) && $webinar->type === 'text_lesson') || old('type') === 'text_lesson' ? 'block' : 'none' }}">
                                        <label class="input-label d-block" style="background: #159904;color: #fff; padding: 5px;">
                                            {{trans('public.Dates and locations')}}
                                            </label>
                                            @if(!empty($webinar) && !is_null($webinar->details) && $webinar->details)
                                            @foreach (json_decode($webinar->details, true) as $detail)

                                                <div class="course-detail">
                                                    <div class="row">
                                                        <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                            <div class="primary_input">
                                                         {{--<input type="date" class="form-control" name="dates[]"
                                                            value="{{ !empty($detail['date']) ? \Carbon\Carbon::parse($detail['date'])->format('Y-m-d') : '' }}"
                                                            placeholder="{{ __('public.Date') }}">--}}
                                                        <input type="date" class="form-control" name="dates[]"
                                                            @php
                                                                $formattedDate = '';
                                                                if (!empty($detail['date'])) {
                                                                    try {
                                                                        try {
                                                                            $formattedDate = \Carbon\Carbon::createFromFormat('m/d/Y', $detail['date'])->format('Y-m-d');
                                                                        } catch (\Exception $e) {
                                                                            $formattedDate = \Carbon\Carbon::createFromFormat('d/m/y', $detail['date'])->format('Y-m-d');
                                                                        }
                                                                    } catch (\Exception $e) {
                                                                        $formattedDate = '';
                                                                    }
                                                                }
                                                            @endphp
                                                            value="{{ $formattedDate }}"
                                                            placeholder="{{ __('public.Date') }}">

                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                            <div class="primary_input">
                                                                <input type="text" class="form-control" name="start_time[]" value="{{ isset($detail['start_time']) ? $detail['start_time'] : '' }}" placeholder="{{ __('public.Time From') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                            <div class="primary_input">
                                                                <input type="text" class="form-control" name="end_time[]" value="{{ isset($detail['end_time']) ? $detail['end_time'] : '' }}" placeholder="{{ __('public.Time To') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                            <div class="primary_input">
                                                                <input type="text" class="form-control" name="locations[]" value="{{ isset($detail['location']) ? $detail['location'] : '' }}" placeholder="{{ __('public.Location') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                            <div class="primary_input">
                                                                <input type="number" class="form-control" name="prices[]" value="{{ isset($detail['price']) ? $detail['price'] : '' }}" placeholder="{{ __('public.Price') }}">
                                                            </div>
                                                        </div>
                                                <div class="col-xl-4 makeResize responsiveResize mb-25">
    <select class="primary_select" name="langs[]">
        <option data-display="{{ __('public.Select Lang') }}" value="">{{ __('public.Select Lang') }}</option>

        {{-- Bilingual option --}}


        @foreach ($userLanguages as $lang => $language)
            @if (in_array(strtolower($lang), ['ar', 'en']))
                <option value="{{ $lang }}" @if (isset($detail['lang']) && $lang == $detail['lang']) selected @endif>
                    {{ $language }}
                </option>
            @endif
        @endforeach
            <option value="bilingual" @if (isset($detail['lang']) && $detail['lang'] == 'bilingual') selected @endif>
            Bilingual
        </option>
    </select>
</div>


                                                        <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                            <div class="primary_input">
<input class="form-control" name="days[]" placeholder="{{ __('public.No Of Days') }}" type="text"
       value="{{ old('days.0', $detail['ndays'] ?? '') }}"
       oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                            <button type="button" class="btn btn-danger remove remove-detail"><i class="fas fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                        <div class="course-detail">
                                            <div class="row">
                                                <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                    <div class="primary_input">
                                                        <input type="text" class="form-control date1" name="dates[]" placeholder="{{ __('public.Date') }}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                    <div class="primary_input">
                                                        <input type="text" class="form-control" name="start_time[]" placeholder="{{ __('public.Time From') }}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                    <div class="primary_input">
                                                        <input type="text" class="form-control" name="end_time[]" placeholder="{{ __('public.Time To') }}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                    <div class="primary_input">
                                                        <input type="text" class="form-control" name="locations[]" placeholder="{{ __('public.Location') }}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                    <div class="primary_input">
                                                        <input type="number" class="form-control" name="prices[]" placeholder="{{ __('public.Price') }}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                    <select class="form-control" name="langs[]">
                                                        <option data-display="{{ __('public.Select Lang') }}" value="">{{ __('public.Select Lang') }} </option>
                                                        @foreach ($userLanguages as $lang => $language)
                                                        <option value="{{ $lang }}">
                                                            {{ $language }}
                                                        </option>
                                                    @endforeach
                                                        <option value="all">{{ __('public.bilingual') }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                    <div class="primary_input">
                                                        <input class="form-control" name="days[]" placeholder="{{ __('public.No Of Days') }}" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 makeResize responsiveResize mb-25">
                                                    <button type="button" class="btn btn-danger remove remove-detail"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <button type="button" class="btn btn-primary  add add-more-detail">{{ __('public.Add More') }}</button>

                                    <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Initialize datepicker for existing fields
                                        initializeDatepickers();

                                        // Add new detail
                                        document.querySelector('.add-more-detail').addEventListener('click', function() {

                                            const template = document.querySelector('.course-detail').cloneNode(true);

                                            // Clear all input values
                                            template.querySelectorAll('input').forEach(input => input.value = '');
                                            template.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

                                            // Reinitialize datepicker for new row
                                            template.querySelectorAll('.date1').forEach(element => {
                                                $(element).datepicker({
                                                    autoclose: true,
                                                    format: 'yyyy-mm-dd'
                                                });
                                            });

                                            document.getElementById('course-details-container').appendChild(template);
                                        });

                                        // Remove detail
                                        document.getElementById('course-details-container').addEventListener('click', function(e) {
                                            if (e.target.closest('.remove-detail')) {
                                                const detailsCount = document.querySelectorAll('.course-detail').length;

                                                if (detailsCount > 1) {
                                                    e.target.closest('.course-detail').remove();
                                                } else {
                                                    alert('You cannot remove the last detail!');
                                                }
                                            }
                                        });

                                        function initializeDatepickers() {
                                            $('.date1').datepicker({
                                                autoclose: true,
                                                format: 'yyyy-mm-dd'
                                            });
                                        }
                                    });
                                    </script>
                                     </div>

                                    </div>
                                    <!---end-->
                                </section>

                                <section class="mt-3">
                                    <h2 class="section-title after-line">{{ trans('public.additional_information') }}</h2>
                                    <div class="row">
                                        <div class="col-12 col-md-6">


                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('update.sales_count_number') }}</label>
                                                <input type="number" name="sales_count_number" value="{{ !empty($webinar) ? $webinar->sales_count_number : old('sales_count_number') }}" class="form-control @error('sales_count_number')  is-invalid @enderror"/>
                                                @error('sales_count_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                                <p class="mt-1 text-muted text-gray">{{ trans('update.product_sales_count_number_hint') }}</p>
                                            </div>

                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.capacity') }}</label>
                                                <input type="number" name="capacity" value="{{ !empty($webinar) ? $webinar->capacity : old('capacity') }}" class="form-control @error('capacity')  is-invalid @enderror"/>
                                                @error('capacity')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="row mt-15">
                                                @if(empty($webinar) or (!empty($webinar) and $webinar->isWebinar()))
                                                    <div class="col-12 col-md-6 js-start_date {{ (!empty(old('type')) and old('type') != \App\Models\Webinar::$webinar) ? 'd-none' : '' }}">
                                                        <div class="form-group">
                                                            <label class="input-label">{{ trans('public.start_date') }}</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="dateInputGroupPrepend">
                                                                        <i class="fa fa-calendar-alt "></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" name="start_date" value="{{ (!empty($webinar) and $webinar->start_date) ? dateTimeFormat($webinar->start_date, 'Y-m-d H:i', false, false, $webinar->timezone) : old('start_date') }}" class="form-control @error('start_date')  is-invalid @enderror datetimepicker" aria-describedby="dateInputGroupPrepend"/>
                                                                @error('start_date')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="input-label">{{ trans('public.duration') }} ({{trans('public.durhits')}})</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="timeInputGroupPrepend">
                                                                    <i class="fa fa-clock"></i>
                                                                </span>
                                                            </div>


                                                            <input type="number" name="duration" value="{{ !empty($webinar) ? $webinar->duration : old('duration') }}" class="form-control @error('duration')  is-invalid @enderror"/>
                                                            @error('duration')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if(getFeaturesSettings('timezone_in_create_webinar'))
                                                @php
                                                    $selectedTimezone = getGeneralSettings('default_time_zone');

                                                    if (!empty($webinar) and !empty($webinar->timezone)) {
                                                        $selectedTimezone = $webinar->timezone;
                                                    }
                                                @endphp

                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('update.timezone') }}</label>
                                                    <select name="timezone" class="form-control select2" data-allow-clear="false">
                                                        @foreach(getListOfTimezones() as $timezone)
                                                            <option value="{{ $timezone }}" @if($selectedTimezone == $timezone) selected @endif>{{ $timezone }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('timezone')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            @endif

                                            <!--<div class="form-group mt-30 d-flex align-items-center justify-content-between">
                                                <label class="" for="supportSwitch">{{ trans('panel.support') }}</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="support" class="custom-control-input" id="supportSwitch" {{ !empty($webinar) && $webinar->support ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="supportSwitch"></label>
                                                </div>
                                            </div>-->
                                            @if(empty($webinar->scorm_file))
                                            <div class="form-group mt-30 d-flex align-items-center justify-content-between">
                                                <label class="" for="includeCertificateSwitch">{{ trans('update.include_certificate') }}</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="certificate" class="custom-control-input" id="includeCertificateSwitch" {{ !empty($webinar) && $webinar->certificate ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="includeCertificateSwitch"></label>
                                                </div>
                                            </div>
                                            @endif
                                           {{-- <div class="form-group mt-30 d-flex align-items-center justify-content-between">
                                                <label class="cursor-pointer" for="downloadableSwitch">{{ trans('home.downloadable') }}</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="downloadable" class="custom-control-input" id="downloadableSwitch" {{ !empty($webinar) && $webinar->downloadable ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="downloadableSwitch"></label>
                                                </div>
                                            </div>--}}

                                            <div class="form-group mt-30 d-flex align-items-center justify-content-between">
                                                <label class="" for="partnerInstructorSwitch">{{ trans('public.partner_instructor') }}</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="partner_instructor" class="custom-control-input" id="partnerInstructorSwitch" {{ !empty($webinar) && $webinar->partner_instructor ? 'checked' : ''  }}>
                                                    <label class="custom-control-label" for="partnerInstructorSwitch"></label>
                                                </div>
                                            </div>

                                            <!--<div class="form-group mt-30 d-flex align-items-center justify-content-between">-->
                                            <!--    <label class="" for="forumSwitch">{{ trans('update.course_forum') }}</label>-->
                                            <!--    <div class="custom-control custom-switch">-->
                                            <!--        <input type="checkbox" name="forum" class="custom-control-input" id="forumSwitch" {{ !empty($webinar) && $webinar->forum ? 'checked' : ''  }}>-->
                                            <!--        <label class="custom-control-label" for="forumSwitch"></label>-->
                                            <!--    </div>-->
                                            <!--</div>-->

                                           <!-- <div class="form-group mt-30 d-flex align-items-center justify-content-between">
                                                <label class="" for="subscribeSwitch">{{ trans('public.subscribe') }}</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="subscribe" class="custom-control-input" id="subscribeSwitch" {{ !empty($webinar) && $webinar->subscribe ? 'checked' : ''  }}>
                                                    <label class="custom-control-label" for="subscribeSwitch"></label>
                                                </div>
                                            </div>-->

                                            <div class="form-group mt-30 d-flex align-items-center justify-content-between">
                                                <label class="" for="privateSwitch">{{ trans('webinars.private') }}</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="private" class="custom-control-input" id="privateSwitch" {{ (!empty($webinar) and $webinar->private) ? 'checked' : ''  }}>
                                                    <label class="custom-control-label" for="privateSwitch"></label>
                                                </div>
                                            </div>

                                           <!-- <div class="form-group mt-30 d-flex align-items-center justify-content-between">
                                                <label class="" for="enable_waitlistSwitch">{{ trans('update.enable_waitlist') }}</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="enable_waitlist" class="custom-control-input" id="enable_waitlistSwitch" {{ (!empty($webinar) and $webinar->enable_waitlist) ? 'checked' : ''  }}>
                                                    <label class="custom-control-label" for="enable_waitlistSwitch"></label>
                                                </div>
                                            </div>-->
                                            @if(empty($webinar->scorm_file))
                                            @if(!empty($webinar) and $webinar->type!='webinar')
                                              <div class="form-group mt-30 d-flex align-items-center justify-content-between">
                                                <label class="cursor-pointer" for="add_to_more">{{ trans('public.add to more courses') }}</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="add_to_more" class="custom-control-input" id="add_to_more" {{ !empty($webinar) && $webinar->add_to_more ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="add_to_more"></label>
                                                </div>
                                            </div>
                                            @endif
                                            @endif

                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('update.access_days') }}</label>
                                                <input type="text" name="access_days" value="{{ !empty($webinar) ? $webinar->access_days : old('access_days') }}" class="form-control @error('access_days')  is-invalid @enderror"/>
                                                @error('access_days')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                                <p class="mt-1">- {{ trans('update.access_days_input_hint') }}</p>
                                            </div>





                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.price') }}{{trans('public.sr')}}</label>
                                                <input type="text" name="price" value="{{ (!empty($webinar) and !empty($webinar->price)) ? convertPriceToUserCurrency($webinar->price) : old('price') }}" class="form-control @error('price')  is-invalid @enderror" placeholder="{{ trans('public.0_for_free') }}"/>
                                                @error('price')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                                 <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.Discount Rate') }} %</label>
                                                <input type="text" name="discount_rate" value="{{ (!empty($webinar) and !empty($webinar->discount_rate)) ? $webinar->discount_rate : old('discount_rate') }}" class="form-control @error('discount_rate')  is-invalid @enderror" placeholder="%"/>
                                                @error('discount_rate')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            @if(!empty($webinar) and $webinar->creator->isOrganization())
                                                <div class="form-group mt-15">
                                                    <label class="input-label">{{ trans('update.organization_price') }} ({{ $currency }})</label>
                                                    <input type="number" name="organization_price" value="{{ (!empty($webinar) and $webinar->organization_price) ? convertPriceToUserCurrency($webinar->organization_price) : old('organization_price') }}" class="form-control @error('organization_price')  is-invalid @enderror" placeholder=""/>
                                                    @error('organization_price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                    <p class="font-12 text-gray mt-1">- {{ trans('update.organization_price_hint') }}</p>
                                                </div>
                                            @endif

                                            {{-- Product Badges --}}
                                            @if(!empty($webinar))
                                                @include('admin.product_badges.content_include', ['itemTarget' => $webinar])
                                            @endif

                                            <div id="partnerInstructorInput" class="form-group mt-15 {{ (!empty($webinar) && $webinar->partner_instructor) ? '' : 'd-none' }}">
                                                <label class="input-label d-block">{{ trans('public.select_a_partner_teacher') }}</label>

                                                <select name="partners[]" multiple data-search-option="just_teacher_role" class="js-search-partner-user form-control {{ (!empty($webinar) && $webinar->partner_instructor) ? 'search-user-select22' : '' }}"
                                                        data-placeholder="{{ trans('public.search_instructor') }}"
                                                >
                                                    @if(!empty($webinarPartnerTeacher))
                                                        @foreach($webinarPartnerTeacher as $partner)
                                                            @if(!empty($partner) and $partner->teacher)
                                                                <option value="{{ $partner->teacher->id }}" selected>{{ $partner->teacher->full_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>

                                                <div class="text-muted text-small mt-1">{{ trans('admin/main.select_a_partner_hint') }}</div>
                                            </div>


                                            <div class="form-group mt-15">
                                                <label class="input-label d-block">{{ trans('public.tags') }}</label>
                                                <input type="text" name="tags" data-max-tag="5" value="{{ !empty($webinar) ? implode(',',$webinarTags) : '' }}" class="form-control inputtags" placeholder="{{ trans('public.type_tag_name_and_press_enter') }} ({{ trans('admin/main.max') }} : 5)"/>
                                            </div>


                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.category') }}</label>

                                         <select id="categories" class="custom-select @error('category_id')  is-invalid @enderror" name="category_id" required>
    @php
        $firstCategory = null;
        if ($categories->isNotEmpty()) {
            // Get the first available category or subcategory
            $firstCategory = $categories->first();
            if (!empty($firstCategory->subCategories) && $firstCategory->subCategories->isNotEmpty()) {
                $firstCategory = $firstCategory->subCategories->first();
            }
        }
    @endphp

    <option disabled>{{ trans('public.choose_category') }}</option>
    @foreach($categories as $category)
        @if(!empty($category->subCategories) && count($category->subCategories))
            <optgroup label="{{  $category->title }}">
                @foreach($category->subCategories as $subCategory)
                    <option value="{{ $subCategory->id }}"
                        {{ (!empty($webinar) && $webinar->category_id == $subCategory->id) ? 'selected' :
                           (empty($webinar) && $firstCategory && $firstCategory->id == $subCategory->id ? 'selected' : '') }}>
                        {{ $subCategory->title }}
                    </option>
                @endforeach
            </optgroup>
        @else
            <option value="{{ $category->id }}"
                {{ (!empty($webinar) && $webinar->category_id == $category->id) ? 'selected' :
                   (empty($webinar) && $firstCategory && $firstCategory->id == $category->id ? 'selected' : '') }}>
                {{ $category->title }}
            </option>
        @endif
    @endforeach
</select>

@error('category_id')
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror


                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group mt-15 {{ (!empty($webinarCategoryFilters) and count($webinarCategoryFilters)) ? '' : 'd-none' }}" id="categoriesFiltersContainer">
                                        <span class="input-label d-block">{{ trans('public.category_filters') }}</span>
                                        <div id="categoriesFiltersCard" class="row mt-3">

                                            @if(!empty($webinarCategoryFilters) and count($webinarCategoryFilters))
                                                @foreach($webinarCategoryFilters as $filter)
                                                    <div class="col-12 col-md-3">
                                                        <div class="webinar-category-filters">
                                                            <strong class="category-filter-title d-block">{{ $filter->title }}</strong>
                                                            <div class="py-10"></div>

                                                            @foreach($filter->options as $option)
                                                                <div class="form-group mt-3 d-flex align-items-center justify-content-between">
                                                                    <label class="text-gray font-14" for="filterOptions{{ $option->id }}">{{ $option->title }}</label>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" name="filters[]" value="{{ $option->id }}" {{ ((!empty($webinarFilterOptions) && in_array($option->id,$webinarFilterOptions)) ? 'checked' : '') }} class="custom-control-input" id="filterOptions{{ $option->id }}">
                                                                        <label class="custom-control-label" for="filterOptions{{ $option->id }}"></label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                </section>

                                @if(!empty($webinar))
                                   <!-- <section class="mt-30">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h2 class="section-title after-line">{{ trans('admin/main.price_plans') }}</h2>
                                            <button id="webinarAddTicket" type="button" class="btn btn-primary btn-sm mt-3">{{ trans('admin/main.add_price_plan') }}</button>
                                        </div>

                                        <div class="row mt-10">
                                            <div class="col-12">

                                                @if(!empty($tickets) and !$tickets->isEmpty())
                                                    <div class="table-responsive">
                                                        <table class="table table-striped text-center font-14">

                                                            <tr>
                                                                <th>{{ trans('public.title') }}</th>
                                                                <th>{{ trans('public.discount') }}</th>
                                                                <th>{{ trans('public.capacity') }}</th>
                                                                <th>{{ trans('public.date') }}</th>
                                                                <th></th>
                                                            </tr>

                                                            @foreach($tickets as $ticket)
                                                                <tr>
                                                                    <th scope="row">{{ $ticket->title }}</th>
                                                                    <td>{{ $ticket->discount }}%</td>
                                                                    <td>{{ $ticket->capacity }}</td>
                                                                    <td>{{ dateTimeFormat($ticket->start_date, 'j M Y') }} - {{ dateTimeFormat($ticket->end_date, 'j M Y') }}</td>
                                                                    <td>
                                                                        <button type="button" data-ticket-id="{{ $ticket->id }}" data-webinar-id="{{ !empty($webinar) ? $webinar->id : '' }}" class="edit-ticket btn-transparent text-primary mt-1" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                                            <i class="fa fa-edit"></i>
                                                                        </button>

                                                                        @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/tickets/'. $ticket->id .'/delete', 'btnClass' => ' mt-1'])
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </table>
                                                    </div>
                                                @else
                                                    @include('admin.includes.no-result',[
                                                        'file_name' => 'ticket.png',
                                                        'title' => trans('public.ticket_no_result'),
                                                        'hint' => trans('public.ticket_no_result_hint'),
                                                    ])
                                                @endif
                                            </div>
                                        </div>
                                    </section>-->

                                    @if(empty($webinar->scorm_file))
                                    @include('admin.webinars.create_includes.contents')
                                    @endif

                                    @if(empty($webinar->scorm_file))
                                            <section class="mt-30">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h2 class="section-title after-line">{{ trans('public.prerequisites') }}</h2>
                                                    <button id="webinarAddPrerequisites" type="button" class="btn btn-primary btn-sm mt-3">{{ trans('public.add_prerequisites') }}</button>
                                                </div>

                                                <div class="row mt-10">
                                                    <div class="col-12">
                                                        @if(!empty($prerequisites) and !$prerequisites->isEmpty())
                                                            <div class="table-responsive">
                                                                <table class="table table-striped text-center font-14">

                                                                    <tr>
                                                                        <th>{{ trans('public.title') }}</th>
                                                                        <th class="text-left">{{ trans('public.instructor') }}</th>
                                                                        <th>{{ trans('public.price') }}</th>
                                                                        <th>{{ trans('public.publish_date') }}</th>
                                                                        <th>{{ trans('public.forced') }}</th>
                                                                        <th></th>
                                                                    </tr>

                                                                    @foreach($prerequisites as $prerequisite)
                                                                        @if(!empty($prerequisite->prerequisiteWebinar->title))
                                                                            <tr>
                                                                                <th>{{ $prerequisite->prerequisiteWebinar->title }}</th>
                                                                                <td class="text-left">{{ $prerequisite->prerequisiteWebinar->teacher->full_name }}</td>
                                                                                <td>{{  handlePrice($prerequisite->prerequisiteWebinar->price) }}</td>
                                                                                <td>{{ dateTimeFormat($prerequisite->prerequisiteWebinar->created_at,'j F Y | H:i') }}</td>
                                                                                <td>{{ $prerequisite->required ? trans('public.yes') : trans('public.no') }}</td>

                                                                                <td>
                                                                                    <button type="button" data-prerequisite-id="{{ $prerequisite->id }}" data-webinar-id="{{ !empty($webinar) ? $webinar->id : '' }}" class="edit-prerequisite btn-transparent text-primary mt-1" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                                                        <i class="fa fa-edit"></i>
                                                                                    </button>

                                                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/prerequisites/'. $prerequisite->id .'/delete', 'btnClass' => ' mt-1'])
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach

                                                                </table>
                                                            </div>
                                                        @else
                                                            @include('admin.includes.no-result',[
                                                                'file_name' => 'comment.png',
                                                                'title' => trans('public.prerequisites_no_result'),
                                                                'hint' => trans('public.prerequisites_no_result_hint'),
                                                            ])
                                                        @endif
                                                    </div>
                                                </div>
                                    </section>
                                            {{-- Related Course --}}
                                            @include('admin.webinars.relatedCourse.add_related_course', [
                                                    'relatedCourseItemId' => $webinar->id,
                                                     'relatedCourseItemType' => 'webinar',
                                                     'relatedCourses' => $webinar->relatedCourses
                                                ])

                                            <section class="mt-30">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h2 class="section-title after-line">{{ trans('public.faq') }}</h2>
                                                    <button id="webinarAddFAQ" type="button" class="btn btn-primary btn-sm mt-3">{{ trans('public.add_faq') }}</button>
                                                </div>

                                                <div class="row mt-10">
                                                    <div class="col-12">
                                                        @if(!empty($faqs) and !$faqs->isEmpty())
                                                            <div class="table-responsive">
                                                                <table class="table table-striped text-center font-14">

                                                                    <tr>
                                                                        <th>{{ trans('public.title') }}</th>
                                                                        <th>{{ trans('public.answer') }}</th>
                                                                        <th></th>
                                                                    </tr>

                                                                    @foreach($faqs as $faq)
                                                                        <tr>
                                                                            <th>{{ $faq->title }}</th>
                                                                            <td>
                                                                                <button type="button" class="js-get-faq-description btn btn-sm btn-gray200">{{ trans('public.view') }}</button>
                                                                                <input type="hidden" value="{{ $faq->answer }}"/>
                                                                            </td>

                                                                            <td class="text-right">
                                                                                <button type="button" data-faq-id="{{ $faq->id }}" data-webinar-id="{{ !empty($webinar) ? $webinar->id : '' }}" class="edit-faq btn-transparent text-primary mt-1" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </button>

                                                                                @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/faqs/'. $faq->id .'/delete', 'btnClass' => ' mt-1'])
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach

                                                                </table>
                                                            </div>
                                                        @else
                                                            @include('admin.includes.no-result',[
                                                                'file_name' => 'faq.png',
                                                                'title' => trans('public.faq_no_result'),
                                                                'hint' => trans('public.faq_no_result_hint'),
                                                            ])
                                                        @endif
                                                    </div>
                                                </div>
                                    </section>
                                            @foreach(\App\Models\WebinarExtraDescription::$types as $webinarExtraDescriptionType)
                                                <section class="mt-30 extraDesc">
                                                    @if($webinarExtraDescriptionType!='company_logos')
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h2 class="section-title after-line">{{ trans('update.'.$webinarExtraDescriptionType) }}</h2>
                                                        <button id="add_new_{{ $webinarExtraDescriptionType }}" type="button" class="btn btn-primary btn-sm mt-3">{{ trans('update.add_'.$webinarExtraDescriptionType) }}</button>
                                                    </div>
                                                    @endif

                                                    @php
                                                        $webinarExtraDescriptionValues = $webinar->webinarExtraDescription->where('type',$webinarExtraDescriptionType);
                                                    @endphp

                                                    <div class="row mt-10">
                                                        <div class="col-12">
                                                            @if(!empty($webinarExtraDescriptionValues) and count($webinarExtraDescriptionValues))
                                                              @if($webinarExtraDescriptionType!='company_logos')
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped text-center font-14">

                                                                      <tr>

                                                                                <th>{{ trans('public.title') }}</th>

                                                                            <th></th>
                                                                        </tr>

                                                                        @foreach($webinarExtraDescriptionValues as $extraDescription)
                                                                            <tr>

                                                                                    <td>{{ $extraDescription->value }}
                                                                                    <br>
                                                                                    @if($extraDescription->attached)
                                                                                    <a href="/{{$extraDescription->attached}}" target=_blank>{{ __('public.showfile')}}  </a>
                                                                                    @endif

                                                                                    </td>


                                                                                <td class="text-right">
                                                                                    <button type="button" data-item-id="{{ $extraDescription->id }}" data-webinar-id="{{ !empty($webinar) ? $webinar->id : '' }}" class="edit-extraDescription btn-transparent text-primary mt-1" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                                                        <i class="fa fa-edit"></i>
                                                                                    </button>

                                                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/webinar-extra-description/'. $extraDescription->id .'/delete', 'btnClass' => ' mt-1'])
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach

                                                                    </table>
                                                                </div>
                                                                @endif
                                                            @else
                                                                @include('admin.includes.no-result',[
                                                                     'file_name' => 'faq.png',
                                                                     'title' => trans("update.{$webinarExtraDescriptionType}_no_result"),
                                                                     'hint' => trans("update.{$webinarExtraDescriptionType}_no_result_hint"),
                                                                ])
                                                            @endif
                                                        </div>
                                                    </div>
                                        </section>
                                            @endforeach

                                            <section class="mt-30">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h2 class="section-title after-line">{{ trans('public.quiz_certificate') }}</h2>
                                                    <button id="webinarAddQuiz" type="button" class="btn btn-primary btn-sm mt-3">{{ trans('public.add_quiz') }}</button>
                                                </div>
                                                <div class="row mt-10">
                                                    <div class="col-12">
                                                        @if(!empty($webinarQuizzes) and !$webinarQuizzes->isEmpty())
                                                            <div class="table-responsive">
                                                                <table class="table table-striped text-center font-14">

                                                                    <tr>
                                                                        <th>{{ trans('public.title') }}</th>
                                                                        <th>{{ trans('public.questions') }}</th>
                                                                        <th>{{ trans('public.total_mark') }}</th>
                                                                        <th>{{ trans('public.pass_mark') }}</th>
                                                                        <th>{{ trans('public.certificate') }}</th>
                                                                        <th></th>
                                                                    </tr>

                                                                    @foreach($webinarQuizzes as $webinarQuiz)
                                                                        <tr>
                                                                            <th>{{ $webinarQuiz->title }}</th>
                                                                            <td>{{ $webinarQuiz->quizQuestions->count() }}</td>
                                                                            <td>{{ $webinarQuiz->quizQuestions->sum('grade') }}</td>
                                                                            <td>{{ $webinarQuiz->pass_mark }}</td>
                                                                            <td>{{ $webinarQuiz->certificate ? trans('public.yes') : trans('public.no') }}</td>
                                                                            <td>
                                                                                <button type="button" data-webinar-quiz-id="{{ $webinarQuiz->id }}" data-webinar-id="{{ !empty($webinar) ? $webinar->id : '' }}" class="edit-webinar-quiz btn-transparent text-primary mt-1" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </button>

                                                                                @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/webinar-quiz/'. $webinarQuiz->id .'/delete', 'btnClass' => ' mt-1'])
                                                                            </td>
                                                                            @endforeach
                                                                        </tr>

                                                                </table>
                                                            </div>
                                                        @else
                                                            @include('admin.includes.no-result',[
                                                                'file_name' => 'cert.png',
                                                                'title' => trans('public.quizzes_no_result'),
                                                                'hint' => trans('public.quizzes_no_result_hint'),
                                                            ])
                                                        @endif
                                                    </div>
                                                </div>
                                    </section>
                                        @endif
                                    @endif
                               <!-- <section class="mt-3">
                                    <h2 class="section-title after-line">{{ trans('public.message_to_reviewer') }}</h2>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mt-15">
                                                <textarea name="message_for_reviewer" rows="10" class="form-control">{{ (!empty($webinar) && $webinar->message_for_reviewer) ? $webinar->message_for_reviewer : old('message_for_reviewer') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </section>-->

                                <input type="hidden" name="draft" value="no" id="forDraft"/>
                                @if(!empty($webinar->scorm_file))
                                <div class="container">
                                    <div class="form-group">
                                        <label class="form-label">حزمة SCORM (ZIP)</label>
                                        <input type="file" name="scorm" accept=".zip" class="form-input" required>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" id="saveAndPublish" class="btn btn-success">{{ !empty($webinar) ? trans('admin/main.save_and_publish') : trans('admin/main.save_and_continue') }}</button>

                                        @if(!empty($webinar))
                                            <button type="button" id="saveReject" class="btn btn-warning">{{ ($webinar->status == "active") ? trans('update.unpublish') : trans('public.reject') }}</button>

                                            @include('admin.includes.delete_button',[
                                                    'url' => getAdminPanelUrl().'/webinars/'. $webinar->id .'/delete',
                                                    'btnText' => trans('public.delete'),
                                                    'hideDefaultClass' => true,
                                                    'btnClass' => 'btn btn-danger'
                                                    ])
                                        @endif
                                    </div>
                                </div>
                            </form>


                            @include('admin.webinars.modals.prerequisites')
                            @include('admin.webinars.modals.quizzes')
                            @include('admin.webinars.modals.ticket')
                            @include('admin.webinars.modals.chapter')
                            @include('admin.webinars.modals.session')
                            @include('admin.webinars.modals.file')
                            @include('admin.webinars.modals.interactive_file')
                            @include('admin.webinars.modals.faq')
                            @include('admin.webinars.modals.testLesson')
                            @include('admin.webinars.modals.assignment')
                            @include('admin.webinars.modals.extra_description')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script>
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
        var titleLang = '{{ trans('admin/main.title') }}';
        var zoomJwtTokenInvalid = '{{ trans('admin/main.teacher_zoom_jwt_token_invalid') }}';
        var editChapterLang = '{{ trans('public.edit_chapter') }}';
        var requestFailedLang = '{{ trans('public.request_failed') }}';
        var thisLiveHasEndedLang = '{{ trans('update.this_live_has_been_ended') }}';
        var quizzesSectionLang = '{{ trans('quiz.quizzes_section') }}';
        var filePathPlaceHolderBySource = {
            upload: '{{ trans('update.file_source_upload_placeholder') }}',
            youtube: '{{ trans('update.file_source_youtube_placeholder') }}',
            vimeo: '{{ trans('update.file_source_vimeo_placeholder') }}',
            external_link: '{{ trans('update.file_source_external_link_placeholder') }}',
            google_drive: '{{ trans('update.file_source_google_drive_placeholder') }}',
            dropbox: '{{ trans('update.file_source_dropbox_placeholder') }}',
            iframe: '{{ trans('update.file_source_iframe_placeholder') }}',
            s3: '{{ trans('update.file_source_s3_placeholder') }}',
        }
    </script>

    <script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>

    <script src="/assets/default/vendors/moment.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/assets/default/vendors/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <script src="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>

    <script src="/assets/default/js/admin/quiz.min.js"></script>
   <!--<script src="/assets/admin/js/webinar.min.js"></script>-->



   <script>


  "use strict";

  // form serialize to Object
  $.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
      if (o[this.name]) {
        if (!o[this.name].push) {
          o[this.name] = [o[this.name]];
        }
        o[this.name].push(this.value || '');
      } else {
        o[this.name] = this.value || '';
      }
    });
    return o;
  };
  function randomString() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    for (var i = 0; i < 5; i++) text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
  }


  $('body').on('click', '.close-swl', function (e) {
    e.preventDefault();
    Swal.close();
  });
  if (jQuery().summernote) {
    makeSummernote($('#summernote'), 400);
  }
  $('body').on('click', '#saveAndPublish', function (e) {
    e.preventDefault();
    $('#forDraft').val('publish');
    $('#webinarForm').trigger('submit');
  });
  $('body').on('click', '#saveAsDraft', function (e) {
    e.preventDefault();
    $('#forDraft').val(1);
    $('#webinarForm').trigger('submit');
  });
  $('body').on('click', '#saveReject', function (e) {
    e.preventDefault();
    $('#forDraft').val('reject');
    $('#webinarForm').trigger('submit');
  });
  $('#partnerInstructorSwitch').on('change.bootstrapSwitch', function (e) {
    var isChecked = e.target.checked;
    if (isChecked) {
      $('#partnerInstructorInput').removeClass('d-none');
      handleSearchableSelect2('js-search-partner-user', adminPanelPrefix + '/users/search', 'name');
    } else {
      $('#partnerInstructorInput').addClass('d-none');
    }
  });
  $('body').on('change', '#categories', function (e) {
    e.preventDefault();
    var category_id = this.value;
    $.get(adminPanelPrefix + '/filters/get-by-category-id/' + category_id, function (result) {
      if (result && typeof result.filters !== "undefined" && result.filters.length) {
        var html = '';
        Object.keys(result.filters).forEach(function (key) {
          var filter = result.filters[key];
          var options = [];
          if (filter.options.length) {
            options = filter.options;
          }
          html += '<div class="col-12 col-md-3">\n' + '<div class="webinar-category-filters">\n' + '<strong class="category-filter-title d-block">' + filter.title + '</strong>\n' + '<div class="py-10"></div>\n' + '\n';
          if (options.length) {
            Object.keys(options).forEach(function (index) {
              var option = options[index];
              html += '<div class="form-group mt-20 d-flex align-items-center justify-content-between">\n' + '<label class="" for="filterOption' + option.id + '">' + option.title + '</label>\n' + '<div class="custom-control custom-checkbox">\n' + '<input type="checkbox" name="filters[]" value="' + option.id + '" class="custom-control-input" id="filterOption' + option.id + '">\n' + '<label class="custom-control-label" for="filterOption' + option.id + '"></label>\n' + '</div>\n' + '</div>\n';
            });
          }
          html += '</div></div>';
        });
        $('#categoriesFiltersContainer').removeClass('d-none');
        $('#categoriesFiltersCard').html(html);
      } else {
        $('#categoriesFiltersContainer').addClass('d-none');
        $('#categoriesFiltersCard').html('');
      }
    });
  });


  $('body').on('click', '#webinarAddTicket', function (e) {
    e.preventDefault();
    var add_ticket_modal = '<div id="addTicketModal">';
    add_ticket_modal += $('#webinarTicketModal').html();
    add_ticket_modal += '</div>';
    Swal.fire({
      html: add_ticket_modal,
      showCancelButton: false,
      showConfirmButton: false,
      customClass: {
        content: 'p-0 text-left'
      },
      width: '48rem'
    });
    resetDatePickers();
  });
  $('body').on('click', '#saveTicket', function (e) {
    e.preventDefault();
    var $this = $(this);
    var form = $('#addTicketModal .js-form');
    handleWebinarItemForm(form, $this);
  });



  $(document).ready(function () {
    var style = getComputedStyle(document.body);
    var primaryColor = style.getPropertyValue('--primary');
    function updateToDatabase(table, idString) {
      $.post(adminPanelPrefix + '/webinars/order-items', {
        table: table,
        items: idString
      }, function (result) {
        if (result && result.title && result.msg) {
          $.toast({
            heading: result.title,
            text: result.msg,
            bgColor: primaryColor,
            textColor: 'white',
            hideAfter: 10000,
            position: 'bottom-right',
            icon: 'success'
          });
        }
      });
    }
    function setSortable(target) {
      if (target.length) {
        target.sortable({
          group: 'no-drop',
          handle: '.move-icon',
          axis: "y",
          update: function update(e, ui) {
            var sortData = target.sortable('toArray', {
              attribute: 'data-id'
            });
            var table = e.target.getAttribute('data-order-table');
            updateToDatabase(table, sortData.join(','));
          }
        });
      }
    }
    var items = [];
    var draggableContentLists = $('.draggable-content-lists');
    if (draggableContentLists.length) {
      var _iterator = _createForOfIteratorHelper(draggableContentLists),
        _step;
      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var item = _step.value;
          items.push($(item).attr('data-drag-class'));
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }
    }
    if (items.length) {
      var _iterator2 = _createForOfIteratorHelper(items),
        _step2;
      try {
        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
          var _item = _step2.value;
          var tag = $('.' + _item);
          if (tag.length) {
            setSortable(tag);
          }
        }
      } catch (err) {
        _iterator2.e(err);
      } finally {
        _iterator2.f();
      }
    }
    var $fileForms = $('.file-form');
    if ($fileForms && $fileForms.length) {
      $fileForms.each(function (key) {
        if ($fileForms[key]) {
          var $form = $($fileForms[key]);
          var source = $form.find('.js-file-storage').val();
          var fileType = $form.find('.js-ajax-file_type').val();
          handleShowFileInputsBySource($form, source, fileType);
          var secureHostType = $form.find('.js-secure-host-upload-type-field input:checked').val();
          if (secureHostType && source === 'secure_host') {
            handleSecureHostUploadType($form, secureHostType);
          }
        }
      });
    }
    if ($('.accordion-content-wrapper .attachments-select2').length) {
      $('.accordion-content-wrapper .attachments-select2').select2({
        multiple: true,
        width: '100%'
      });
    }
    var summernoteTarget = $('.accordion-content-wrapper .js-content-summernote');
    if (summernoteTarget.length) {
      makeSummernote(summernoteTarget, 400, function (contents, $editable) {
        $('.js-hidden-content-summernote').val(contents);
      });
    }
  });
  $('body').on('change', '.js-webinar-content-locale', function (e) {
    e.preventDefault();
    var $this = $(this);
    var $form = $(this).closest('.js-content-form');
    var locale = $this.val();
    var webinarId = $this.attr('data-webinar-id');
    var item_id = $this.attr('data-id');
    var relation = $this.attr('data-relation');
    var fields = $this.attr('data-fields');
    fields = fields.split(',');
    $this.addClass('loadingbar gray');
    var path = adminPanelPrefix + '/webinars/' + webinarId + '/getContentItemByLocale';
    var data = {
      item_id: item_id,
      locale: locale,
      relation: relation
    };
    $.post(path, data, function (result) {
      if (result && result.item) {
        var item = result.item;
        Object.keys(item).forEach(function (key) {
          var value = item[key];
          if ($.inArray(key, fields) !== -1) {
            var element = $form.find('.js-ajax-' + key);
            element.val(value);
          }
          if (relation === 'textLessons' && key === 'content') {
            var summernoteTarget = $form.find('.js-content-' + item_id);
            if (summernoteTarget.length) {
              summernoteTarget.summernote('destroy');
              summernoteTarget.val(value);
              $('.js-hidden-content-' + item_id).val(value);
              makeSummernote(summernoteTarget, 400, function (contents, $editable) {
                $('.js-hidden-content-' + item_id).val(contents);
              });
            }
          }
        });
        $this.removeClass('loadingbar gray');
      }
    }).fail(function (err) {
      $this.removeClass('loadingbar gray');
    });
  });
  function handleFileFormSubmit(form, $this) {
    var data = serializeObjectByTag(form);
    var action = form.attr('data-action');
    $this.addClass('loadingbar primary').prop('disabled', true);
    form.find('input').removeClass('is-invalid');
    form.find('textarea').removeClass('is-invalid');
    var formData = new FormData();
    var s3Input = form.find('.js-s3-file-input');
    var hasFileForUpload = false;
    if (s3Input && s3Input.prop('files') && s3Input.prop('files')[0]) {
      formData.append('s3_file', s3Input.prop('files')[0]);
      hasFileForUpload = true;
    }
    var items = form.find('input, textarea, select').serializeArray();
    $.each(items, function () {
      formData.append(this.name, this.value);
    });
    var source = form.find('.js-file-storage').val();
    form.find('.progress').addClass('d-none');
    $.ajax({
      url: action,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      xhr: function xhr() {
        var xhr = new window.XMLHttpRequest();
        var percentComplete = 0;
        xhr.upload.addEventListener("progress", function (event) {
          if (event.lengthComputable && (source === "s3" || source === "secure_host") && hasFileForUpload) {
            percentComplete = event.loaded / event.total * 100;
            var percentage = Math.round(percentComplete) - 1;
            form.find('.progress').removeClass('d-none');
            var bar = form.find('.progress .progress-bar');
            bar.css("width", percentage + '%');
            bar.text(percentage + '%');
          }
        }, false);
        return xhr;
      },
      success: function success(result) {
        if (result && result.code === 200) {
          //window.location.reload();
          Swal.fire({
            icon: 'success',
            html: '<h3 class="font-20 text-center text-dark-blue py-25">' + saveSuccessLang + '</h3>',
            showConfirmButton: false,
            width: '25rem'
          });
          setTimeout(function () {
            window.location.reload();
          }, 500);
        }
      },
      error: function error(err) {
        $this.removeClass('loadingbar primary').prop('disabled', false);
        var errors = err.responseJSON;
        if (errors && errors.errors) {
          Object.keys(errors.errors).forEach(function (key) {
            var error = errors.errors[key];
            var element = form.find('.js-ajax-' + key);
            element.addClass('is-invalid');
            element.parent().find('.invalid-feedback').text(error[0]);
          });
        }
      }
    });
  }

  window.handleWebinarItemForm = function (form, $this) {
    var data = serializeObjectByTag(form);
    var action = form.attr('data-action');
    $this.addClass('loadingbar primary').prop('disabled', true);
    form.find('input').removeClass('is-invalid');
    form.find('textarea').removeClass('is-invalid');

    $.post(action, data, function (result) {
        if (result && result.code === 200) {
            // Show success message
            Swal.fire({
                icon: 'success',
                html: '<h3 class="font-20 text-center text-dark-blue py-25">' + saveSuccessLang + '</h3>',
                showConfirmButton: false,
                width: '25rem',
                timer: 2000
            });

            // Get the current URL and make an AJAX request with cache disabled
            var currentUrl = window.location.href;
            $.ajax({
                url: currentUrl,
                method: 'GET',
                cache: false,

                success: function(response) {
                    // Extract the chapter accordion content from the response
                    var newContent = $(response).find('#chapterAccordion').html();
                    $('#chapterAccordion').html(newContent);

                    // Reinitialize feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }

                    // Remove loading state
                    $this.removeClass('loadingbar primary').prop('disabled', false);

                    // Close modal
                    var modalHtml = $('#chapterModalHtml');
                    if (modalHtml.length) {
                        modalHtml.addClass('d-none');
                    }
                },
                error: function() {
                    // Fallback to simple load if ajax fails
                    $('.draggable-content-lists').load(currentUrl + '.draggable-content-lists', function() {
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }
                    });
                }
            });
        }
    }).fail(function (err) {
        $this.removeClass('loadingbar primary').prop('disabled', false);
        var errors = err.responseJSON;

        if (errors && errors.status === 'zoom_token_invalid') {
            Swal.fire({
                icon: 'error',
                html: '<h3 class="font-20 text-center text-dark-blue py-25">' + errors.zoom_error_msg + '</h3>',
                showConfirmButton: false,
                width: '25rem',
                timer: 2000
            });
        }

        if (errors && errors.errors) {
            Object.keys(errors.errors).forEach(function (key) {
                var error = errors.errors[key];
                var element = form.find('.js-ajax-' + key);
                if (key === 'zoom-not-complete-alert') {
                    form.find('.js-zoom-not-complete-alert').removeClass('d-none');
                } else {
                    element.addClass('is-invalid');
                    element.parent().find('.invalid-feedback').text(error[0]);
                }
            });
        }
    });
};

window.handleWebinarItemForm1 = function (form, $this) {
    // Create FormData object manually since we're using a div instead of form
    var formData = new FormData();

    // Add all input values to FormData
    form.find('input, textarea, select').each(function() {
        var input = $(this);
        var name = input.attr('name');

        if (input.attr('type') === 'file') {
            // Handle file inputs
            var files = input[0].files;
            if (files.length > 0) {
                formData.append(name, files[0]);
            }
        } else {
            // Handle other inputs
            formData.append(name, input.val());
        }
    });

    var action = form.attr('data-action');

    $this.addClass('loadingbar primary').prop('disabled', true);
    form.find('input').removeClass('is-invalid');
    form.find('textarea').removeClass('is-invalid');
    form.find('file').removeClass('is-invalid');

    $.ajax({
        url: action,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(result) {
            console.log(result);
            if (result && result.code === 200) {
                Swal.fire({
                    icon: 'success',
                    html: '<h3 class="font-20 text-center text-dark-blue py-25">' + saveSuccessLang + '</h3>',
                    showConfirmButton: false,
                    width: '25rem',
                    timer: 2000
                });

                // Show loading indicator
                $('.extraDesc').html('<div class="loading-indicator">Loading...</div>');

                // Fetch updated data for the `.extraDesc` section
                $.get(window.location.href, function (response) {
                    var $newContent = $(response).find('.extraDesc').html(); // Extract the updated content
                    $('.extraDesc').html($newContent); // Update the `.extraDesc` section
                });

                var modalHtml = $('#chapterModalHtml');
                if (modalHtml.length) {
                    modalHtml.addClass('d-none');
                }
                $this.removeClass('loadingbar primary').prop('disabled', false);
            }
        },
        error: function(err) {
            $this.removeClass('loadingbar primary').prop('disabled', false);
            var errors = err.responseJSON;
            if (errors && errors.status === 'zoom_token_invalid') {
                Swal.fire({
                    icon: 'error',
                    html: '<h3 class="font-20 text-center text-dark-blue py-25">' + errors.zoom_error_msg + '</h3>',
                    showConfirmButton: false,
                    width: '25rem'
                });
            }
            if (errors && errors.errors) {
                Object.keys(errors.errors).forEach(function (key) {
                    var error = errors.errors[key];
                    var element = form.find('.js-ajax-' + key);
                    if (key === 'zoom-not-complete-alert') {
                        form.find('.js-zoom-not-complete-alert').removeClass('d-none');
                    } else {
                        element.addClass('is-invalid');
                        element.parent().find('.invalid-feedback').text(error[0]);
                    }
                });
            }
        }
    });
};
  $('body').on('click', '.save-chapter', function (e) {
    e.preventDefault();
    var $this = $(this);
    var form = $this.closest('.chapter-form');
    var cid=$this.closest('id');
    handleWebinarItemForm(form, $this);
  });
  $('body').on('click', '.js-add-chapter', function (e) {
    var $this = $(this);
    var webinarId = $this.attr('data-webinar-id');
    var type = $this.attr('data-type');
    var itemId = $this.attr('data-chapter');
    var locale = $this.attr('data-locale');
    var random = itemId ? itemId : randomString();
    var clone = $('#chapterModalHtml').clone();
    clone.removeClass('d-none');
    var cloneHtml = clone.prop('innerHTML');
    cloneHtml = cloneHtml.replaceAll('record', random);
    clone.html('<div id="chapterModal' + random + '">' + cloneHtml + '</div>');
    Swal.fire({
      html: clone,
      showCancelButton: false,
      showConfirmButton: false,
      customClass: {
        content: 'p-0 text-left'
      },
      width: '36rem',
      onOpen: function onOpen() {
        var modal = $('#chapterModal' + random);
        modal.find('input.js-chapter-webinar-id').val(webinarId);
        modal.find('input.js-chapter-type').val(type);
        if (itemId) {
          modal.find('.section-title').text(editChapterLang);
          var path = adminPanelPrefix + '/chapters/' + itemId + '/update';
          modal.find('.chapter-form').attr('data-action', path);
          $.get(adminPanelPrefix + '/chapters/' + itemId + '?locale=' + locale, function (result) {
            if (result && result.chapter) {
              modal.find('.js-ajax-title').val(result.chapter.title);
              var status = modal.find('.js-chapter-status-switch');
              if (result.chapter.status === 'active') {
                status.prop('checked', true);
              } else {
                status.prop('checked', false);
              }
              var checkedAllContents = result.chapter.check_all_contents_pass && result.chapter.check_all_contents_pass !== "0";
              modal.find('.js-chapter-check-all-contents-pass').prop('checked', checkedAllContents);
              var localeSelect = modal.find('.js-chapter-locale');
              localeSelect.val(locale);
              localeSelect.addClass('js-webinar-content-locale');
              localeSelect.attr('data-id', itemId);
            }
          });
        }
      }
    });
  });
  $('body').on('click', '.js-add-course-content-btn, .add-new-interactive-file-btn', function (e) {
    e.preventDefault();
    var $this = $(this);
    var type = $this.attr('data-type');
    var chapterId = $this.attr('data-chapter');
    var contentTagId = '#chapterContentAccordion' + chapterId;
    var key = randomString();
    var html = '';
    switch (type) {
      case 'file':
        var newFileForm = $('#newFileForm');
        newFileForm.find('.chapter-input').val(chapterId);
        html = newFileForm.html();
        html = html.replace(/record/g, key);
        $(contentTagId).prepend(html);
        break;
      case 'new_interactive_file':
        var newInteractiveFileForm = $('#newInteractiveFileForm');
        newInteractiveFileForm.find('.chapter-input').val(chapterId);
        html = newInteractiveFileForm.html();
        html = html.replace(/record/g, key);
        $(contentTagId).prepend(html);
        break;
      case 'session':
        var newSessionForm = $('#newSessionForm');
        newSessionForm.find('.chapter-input').val(chapterId);
        html = newSessionForm.html();
        html = html.replace(/record/g, key);
        $(contentTagId).prepend(html);
        break;
      case 'text_lesson':
        var newTextLessonForm = $('#newTextLessonForm');
        newTextLessonForm.find('.chapter-input').val(chapterId);
        html = newTextLessonForm.html();
        html = html.replace(/record/g, key);
        html = html.replaceAll('attachments-select2', 'attachments-select2-' + key);
        html = html.replaceAll('js-content-summernote', 'js-content-summernote-' + key);
        html = html.replaceAll('js-hidden-content-summernote', 'js-hidden-content-summernote-' + key);
        $(contentTagId).prepend(html);
        $('.attachments-select2-' + key).select2({
          multiple: true,
          width: '100%'
        });
        if (jQuery().summernote) {
          makeSummernote($('.js-content-summernote-' + key), 400, function (contents, $editable) {
            $('.js-hidden-content-summernote-' + key).val(contents);
          });
        }
        break;
      case 'assignment':
        var newAssignmentForm = $('#newAssignmentForm');
        newAssignmentForm.find('.chapter-input').val(chapterId);
        html = newAssignmentForm.html();
        html = html.replace(/record/g, key);
        $(contentTagId).prepend(html);
        break;
      case 'quiz':
        var newQuizForm = $('#newQuizForm');
        newQuizForm.find('.chapter-input').val(chapterId);
        html = newQuizForm.html();
        html = html.replace(/record/g, key);
        $(contentTagId).prepend(html);
        break;
    }
    resetDatePickers();
    feather.replace();
  });
  $('body').on('click', '.js-change-content-chapter', function (e) {
    e.preventDefault();
    var $this = $(this);
    var itemId = $this.attr('data-item-id');
    var itemType = $this.attr('data-item-type');
    var chapterId = $this.attr('data-chapter-id');
    var random = randomString();
    var clone = $('#changeChapterModalHtml').clone();
    clone.removeClass('d-none');
    var cloneHtml = clone.prop('innerHTML');
    clone.html('<div id="changeChapterModalHtml' + random + '">' + cloneHtml + '</div>');
    Swal.fire({
      html: clone,
      showCancelButton: false,
      showConfirmButton: false,
      customClass: {
        content: 'p-0 text-left'
      },
      width: '36rem',
      onOpen: function onOpen() {
        var modal = $('#changeChapterModalHtml' + random);
        modal.find('input.js-item-id').val(itemId);
        modal.find('input.js-item-type').val(itemType);
        modal.find('.js-ajax-chapter_id').val(chapterId).change();
      }
    });
  });
  $('body').on('click', '.save-change-chapter', function (e) {
    e.preventDefault();
    var $this = $(this);
    var form = $this.closest('.change-chapter-form');
    handleWebinarItemForm(form, $this);
  });

  // ======
  // contents files
  function handleShowFileInputsBySource($form, source, fileType) {
    var featherIconsConf = {
      width: 20,
      height: 20
    };
    var icon = feather.icons['upload'].toSvg(featherIconsConf);
    var $fileTypeVolumeInputs = $form.find('.js-file-type-volume');
    var $volumeInputs = $form.find('.js-file-volume-field');
    var $typeInputs = $form.find('.js-file-type-field');
    var $downloadableInput = $form.find('.js-downloadable-input');
    var $onlineViewerInput = $form.find('.js-online_viewer-input');
    var $filePathInputGroup = $form.find('.js-file-path-input');
    var $s3FilePathInputGroup = $form.find('.js-s3-file-path-input');
    var $filePathButton = $form.find('.js-file-path-input button');
    var $filePathInput = $form.find('.js-file-path-input input');
    var $secureHostUploadTypeField = $form.find('.js-secure-host-upload-type-field');
    $filePathButton.addClass('panel-file-manager');
    $filePathInputGroup.removeClass('d-none');
    $s3FilePathInputGroup.addClass('d-none');
    $volumeInputs.addClass('d-none');
    $typeInputs.removeClass('d-none'); // parent is hidden or visible
    $secureHostUploadTypeField.addClass('d-none');
    $s3FilePathInputGroup.find('input').removeAttr("accept");
    switch (source) {
      case 'youtube':
      case 'vimeo':
      case 'iframe':
        $fileTypeVolumeInputs.addClass('d-none');
        $fileTypeVolumeInputs.find('select').val('');
        $downloadableInput.find('input').prop('checked', false);
        $downloadableInput.addClass('d-none');
        $onlineViewerInput.find('input').prop('checked', false);
        $onlineViewerInput.addClass('d-none');
        icon = feather.icons['link'].toSvg(featherIconsConf);
        $filePathButton.removeClass('panel-file-manager');
        break;
      case 'external_link':
      case 's3':
        $fileTypeVolumeInputs.removeClass('d-none');
        if (fileType && fileType === 'video') {
          $downloadableInput.removeClass('d-none');
        } else {
          $downloadableInput.find('input').prop('checked', false);
          $downloadableInput.addClass('d-none');
        }
        if (source === 'external_link') {
          icon = feather.icons['external-link'].toSvg(featherIconsConf);
          $filePathButton.removeClass('panel-file-manager');
          $volumeInputs.removeClass('d-none');
        } else if (source === 's3') {
          $filePathInputGroup.addClass('d-none');
          $s3FilePathInputGroup.removeClass('d-none');
        }
        if (fileType && fileType === 'pdf') {
          $onlineViewerInput.removeClass('d-none');
        } else {
          $onlineViewerInput.find('input').prop('checked', false);
          $onlineViewerInput.addClass('d-none');
        }
        break;
      case 'secure_host':
        $fileTypeVolumeInputs.addClass('d-none');
        $fileTypeVolumeInputs.find('select').val('');
        $filePathInputGroup.addClass('d-none');
        $s3FilePathInputGroup.removeClass('d-none');
        $downloadableInput.find('input').prop('checked', false);
        $downloadableInput.addClass('d-none');
        $onlineViewerInput.addClass('d-none');
        $secureHostUploadTypeField.removeClass('d-none');
        $s3FilePathInputGroup.find('input').attr('accept', "video/mp4,video/x-m4v,video/*");
        break;
      case 'google_drive':
        $fileTypeVolumeInputs.removeClass('d-none');
        $volumeInputs.removeClass('d-none');
        $downloadableInput.find('input').prop('checked', false);
        $downloadableInput.addClass('d-none');
        if (fileType && fileType === 'pdf') {
          $onlineViewerInput.removeClass('d-none');
        } else {
          $onlineViewerInput.find('input').prop('checked', false);
          $onlineViewerInput.addClass('d-none');
        }
        icon = feather.icons['box'].toSvg(featherIconsConf);
        $filePathButton.removeClass('panel-file-manager');
        break;
      case 'upload':
        $fileTypeVolumeInputs.removeClass('d-none');
        $downloadableInput.removeClass('d-none');
        if (fileType && fileType === 'pdf') {
          $onlineViewerInput.removeClass('d-none');
        } else {
          $onlineViewerInput.find('input').prop('checked', false);
          $onlineViewerInput.addClass('d-none');
        }
    }
    if (fileType && (fileType === 'image' || fileType === 'document' || fileType === 'powerpoint' || fileType === 'sound' || fileType === 'archive' || fileType === 'project')) {
      $downloadableInput.find('input').prop('checked', true);
      $downloadableInput.addClass('d-none');
    }
    if (icon) {
      $filePathButton.html(icon);
    }
    if (filePathPlaceHolderBySource) {
      $filePathInput.attr('placeholder', filePathPlaceHolderBySource[source]);
    }
  }
  function handleSecureHostUploadType($form, value) {
    var $pathInput = $form.find('.js-secure-host-path-input');
    var $uploadInput = $form.find('.js-s3-file-path-input');
    var $fileTypeVolumeInputs = $form.find('.js-file-type-volume');
    var $volumeInputs = $form.find('.js-file-volume-field');
    var $typeInputs = $form.find('.js-file-type-field');
    $typeInputs.addClass('d-none');
    if (value === "manual") {
      $fileTypeVolumeInputs.removeClass('d-none');
      $volumeInputs.removeClass('d-none');
      $pathInput.removeClass('d-none');
      $uploadInput.addClass('d-none');
    } else {
      $fileTypeVolumeInputs.addClass('d-none');
      $volumeInputs.addClass('d-none');
      $pathInput.addClass('d-none');
      $uploadInput.removeClass('d-none');
    }
  }
  $('body').on('change', '.js-secure-host-upload-type-field input', function (e) {
    e.preventDefault();
    var value = $(this).val();
    var $form = $(this).closest('.file-form');
    handleSecureHostUploadType($form, value);
  });
  $('body').on('click', '.js-save-file', function (e) {
    e.preventDefault();
    var $this = $(this);
    var form = $this.closest('.file-form');
    handleFileFormSubmit(form, $this);
  });
  $('body').on('change', '.js-file-storage', function (e) {
    e.preventDefault();
    var value = this.value;
    var formGroup = $(this).closest('form');
    var fileType = formGroup.find('.js-ajax-file_type').val();
    handleShowFileInputsBySource(formGroup, value, fileType);
  });
  $('body').on('change', '.js-ajax-file_type', function (e) {
    e.preventDefault();
    var value = $(this).val();
    var formGroup = $(this).closest('form');
    var source = formGroup.find('.js-file-storage').val();
    handleShowFileInputsBySource(formGroup, source, value);
  });

  // Sessions
  $('body').on('change', '.js-api-input', function (e) {
    e.preventDefault();
    var sessionForm = $(this).closest('.session-form');
    var value = this.value;
    sessionForm.find('.js-zoom-not-complete-alert').addClass('d-none');
    sessionForm.find('.js-agora-chat-and-rec').addClass('d-none');
    if (value === 'big_blue_button') {
      sessionForm.find('.js-local-link').addClass('d-none');
      sessionForm.find('.js-api-secret').removeClass('d-none');
      sessionForm.find('.js-moderator-secret').removeClass('d-none');
    } else if (value === 'zoom') {
      sessionForm.find('.js-local-link').addClass('d-none');
      sessionForm.find('.js-api-secret').addClass('d-none');
      sessionForm.find('.js-moderator-secret').addClass('d-none');
      if (hasZoomApiToken && hasZoomApiToken !== 'true') {
        sessionForm.find('.js-zoom-not-complete-alert').removeClass('d-none');
      }
    } else if (value === 'agora') {
      sessionForm.find('.js-agora-chat-and-rec').removeClass('d-none');
      sessionForm.find('.js-api-secret').addClass('d-none');
      sessionForm.find('.js-local-link').addClass('d-none');
      sessionForm.find('.js-moderator-secret').addClass('d-none');
    } else if (value === 'jitsi') {
      sessionForm.find('.js-local-link').addClass('d-none');
      sessionForm.find('.js-api-secret').addClass('d-none');
      sessionForm.find('.js-moderator-secret').addClass('d-none');
    } else {
      sessionForm.find('.js-local-link').removeClass('d-none');
      sessionForm.find('.js-api-secret').removeClass('d-none');
      sessionForm.find('.js-moderator-secret').addClass('d-none');
    }
  });
  $('body').on('click', '.js-save-session', function (e) {
    e.preventDefault();
    var $this = $(this);
    var form = $this.closest('.session-form');
    handleWebinarItemForm(form, $this);
  });
  $('body').on('click', '.js-session-has-ended', function () {
    $.toast({
      heading: requestFailedLang,
      text: thisLiveHasEndedLang,
      bgColor: '#f63c3c',
      textColor: 'white',
      hideAfter: 10000,
      position: 'bottom-right',
      icon: 'error'
    });
  });

  // Text lession
  $('body').on('click', '.js-save-text_lesson', function (e) {
    e.preventDefault();
    var $this = $(this);
    var form = $this.closest('.text_lesson-form');
    handleWebinarItemForm(form, $this);
  });

  // assignments

  $('body').on('click', '.js-save-assignment', function (e) {
    e.preventDefault();
    var $this = $(this);
    var form = $this.closest('.assignment-form');
    handleWebinarItemForm(form, $this);
  });
  $('body').on('click', '.assignment-attachments-add-btn', function (e) {
    var $container = $(this).closest('.js-assignment-attachments-items');
    var mainRow = $container.find('.assignment-attachments-main-row');
    var copy = mainRow.clone();
    copy.removeClass('assignment-attachments-main-row');
    copy.removeClass('d-none');
    var removeBtn = copy.find('.assignment-attachments-remove-btn');
    if (removeBtn) {
      removeBtn.removeClass('d-none');
    }
    var copyHtml = copy.prop('innerHTML');
    copyHtml = copyHtml.replaceAll('assignmentTemp', randomString());
    copyHtml = copyHtml.replaceAll('btn-primary', 'btn-danger');
    copyHtml = copyHtml.replaceAll('assignment-attachments-add-btn', 'assignment-attachments-remove-btn');
    copy.html(copyHtml);
    $container.append(copy);
  });
  $('body').on('click', '.assignment-attachments-remove-btn', function (e) {
    e.preventDefault();
    $(this).closest('.js-ajax-attachments').remove();
  });



  $('body').on('click', '.cancel-accordion', function (e) {
    e.preventDefault();
    $(this).closest('.accordion-row').remove();
  });


  $('body').on('click', '#webinarAddPrerequisites', function (e) {
    e.preventDefault();
    var add_prerequisites_modal = '<div id="addPrerequisitesModal">';
    add_prerequisites_modal += $('#webinarPrerequisitesModal').html();
    add_prerequisites_modal += '</div>';
    add_prerequisites_modal = add_prerequisites_modal.replaceAll('prerequisites-select', 'prerequisites-select2');
    add_prerequisites_modal = add_prerequisites_modal.replaceAll('str_', '');
    Swal.fire({
      html: add_prerequisites_modal,
      showCancelButton: false,
      showConfirmButton: false,
      customClass: {
        content: 'p-0 text-left'
      },
      width: '48rem',
      onOpen: function onOpen() {
        handleSearchableSelect2('prerequisites-select2', adminPanelPrefix + '/webinars/search', 'title');
      }
    });
  });
  $('body').on('click', '#savePrerequisites', function (e) {
    e.preventDefault();
    var $this = $(this);
    var form = $('#addPrerequisitesModal .js-prerequisites-form');
    handleWebinarItemForm(form, $this);
  });


  $('body').on('click', '#webinarAddFAQ', function (e) {
    e.preventDefault();
    var add_faq_modal = '<div id="addFAQsModal">';
    add_faq_modal += $('#webinarFaqModal').html();
    add_faq_modal += '</div>';
    Swal.fire({
      html: add_faq_modal,
      showCancelButton: false,
      showConfirmButton: false,
      customClass: {
        content: 'p-0 text-left'
      },
      width: '48rem'
    });
  });
  $('body').on('click', '#saveFAQ', function (e) {
    e.preventDefault();
    var $this = $(this);
    var form = $('#addFAQsModal .js-faq-form');
    handleWebinarItemForm(form, $this);
  });


  $('body').on('click', '#add_new_learning_materials', function (e) {
    e.preventDefault();
    var key = randomString();
    var html = '<div id="extraDescriptionModal">';
    html += $('#extraDescriptionForm').html();
    html += '</div>';
    Swal.fire({
      html: html,
      showCancelButton: false,
      showConfirmButton: false,
      customClass: {
        content: 'p-0 text-left'
      },
      width: '48rem',
      onOpen: function onOpen() {
        $('#extraDescriptionModal input[name="type"]').val('learning_materials');
      }
    });
  });
  function handleCompanyLogosInputHtml(key) {
    var html = '<div id="extraDescriptionModal">';
    html += $('#extraDescriptionForm').html();
    html += '</div>';
    var modalHtml = $(html);
    modalHtml.find('.js-form-groups').children().remove();
    modalHtml.find('.js-form-groups').append('<div class="form-group">\n' + '            <label class="input-label">image</label>\n' + '            <div class="input-group">\n' + '                <div class="input-group-prepend">\n' + '                    <button type="button" class="input-group-text admin-file-manager" data-input="image_' + key + '" data-preview="holder">\n' + '                        <i class="fa fa-upload"></i>\n' + '                    </button>\n' + '                </div>\n' + '                <input type="text" name="value" id="image_' + key + '" class="form-control"/>\n' + '            </div>\n' + '        </div>');
    var mainHtml = '<div id="extraDescriptionModal">';
    mainHtml += modalHtml.html();
    mainHtml += '</div>';
    return mainHtml;
  }
  $('body').on('click', '#add_new_company_logos', function (e) {
    e.preventDefault();
    var key = randomString();
    var html = handleCompanyLogosInputHtml(key);
    Swal.fire({
      html: html,
      showCancelButton: false,
      showConfirmButton: false,
      customClass: {
        content: 'p-0 text-left'
      },
      width: '48rem',
      onOpen: function onOpen() {
        $('#extraDescriptionModal input[name="type"]').val('company_logos');
      }
    });
  });
  $('body').on('click', '#add_new_requirements', function (e) {
    e.preventDefault();
    var key = randomString();
    var html = '<div id="extraDescriptionModal">';
    html += $('#extraDescriptionForm').html();
    html += '</div>';
    Swal.fire({
      html: html,
      showCancelButton: false,
      showConfirmButton: false,
      customClass: {
        content: 'p-0 text-left'
      },
      width: '48rem',
      onOpen: function onOpen() {
        $('#extraDescriptionModal input[name="type"]').val('requirements');
      }
    });
  });
  $('body').on('click', '#saveExtraDescription', function (e) {
    e.preventDefault();
    var $this = $(this);
    var form = $('#extraDescriptionModal .js-form');
   // handleWebinarItemForm(form, $this);
     handleWebinarItemForm1(form, $this);

  });
  $('body').on('click', '.edit-extraDescription', function (e) {
    e.preventDefault();
    var $this = $(this);
    editExtraDescription($this);
  });
  $('body').on('change', '.js-edit-extraDescription-locale-ajax', function (e) {
    e.preventDefault();
    var $this = $(this);
    var locale = $this.val();
    editExtraDescription($this, locale);
  });
  function editExtraDescription($this, locale) {
    var item_id = $this.attr('data-item-id');
    var webinar_id = $this.attr('data-webinar-id');
    var rendomKey = randomString();
    var edit_data = {
      item_id: webinar_id,
      locale: locale
    };
    $.post(adminPanelPrefix + '/webinar-extra-description/' + item_id + '/edit', edit_data, function (result) {
      if (result && result.webinarExtraDescription) {
        var webinarExtraDescription = result.webinarExtraDescription;
        var html = '<div id="extraDescriptionModal">';
        html += $('#extraDescriptionForm').html();
        html += '</div>';
        if (webinarExtraDescription.type === 'company_logos') {
          html = handleCompanyLogosInputHtml(rendomKey);
        }
        html = html.replaceAll(adminPanelPrefix + '/webinar-extra-description/store', adminPanelPrefix + '/webinar-extra-description/' + item_id + '/update');
        Swal.fire({
          html: html,
          showCancelButton: false,
          showConfirmButton: false,
          customClass: {
            content: 'p-0 text-left'
          },
          width: '48rem',
          onOpen: function onOpen() {
            var $modal = $('#extraDescriptionModal');
            Object.keys(webinarExtraDescription).forEach(function (key) {
              $modal.find('[name="' + key + '"]').val(webinarExtraDescription[key]);
            });
            var localeSelect = $modal.find('select[name="locale"]');
            if (localeSelect) {
              localeSelect.addClass('js-edit-extraDescription-locale-ajax');
              localeSelect.attr('data-item-id', item_id);
              localeSelect.attr('data-webinar-id', webinar_id);
            }
          }
        });
      }
    });
  }


  $('body').on('click', '#webinarAddQuiz', function (e) {
    var _this = this;
    e.preventDefault();
    var add_quiz_modal = '<div id="addQuizModal">';
    add_quiz_modal += $('#quizzesModal').html();
    add_quiz_modal += '</div>';
    add_quiz_modal = add_quiz_modal.replaceAll('quiz-select2', 'quiz-select22');
    Swal.fire({
      html: add_quiz_modal,
      showCancelButton: false,
      showConfirmButton: false,
      customClass: {
        content: 'p-0 text-left'
      },
      width: '30rem',
      onOpen: function onOpen() {
        $(".quiz-select22").select2({
          placeholder: $(_this).data('placeholder'),
          allowClear: true,
          width: '100%'
        });
      }
    });
  });
  $('body').on('click', '#saveQuiz', function (e) {
    e.preventDefault();
    var $this = $(this);
    var form = $('#addQuizModal .js-form');
    handleWebinarItemForm(form, $this);
  });


  function editTicket($this) {
    var locale = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
    var ticket_id = $this.attr('data-ticket-id');
    var webinar_id = $this.attr('data-webinar-id');
    var edit_data = {
      item_id: webinar_id,
      locale: locale
    };
    $.post(adminPanelPrefix + '/tickets/' + ticket_id + '/edit', edit_data, function (result) {
      if (result && result.ticket) {
        var ticket = result.ticket;
        var edit_ticket_modal = '<div id="addTicketModal">';
        edit_ticket_modal += $('#webinarTicketModal').html();
        edit_ticket_modal += '</div>';
        edit_ticket_modal = edit_ticket_modal.replaceAll(adminPanelPrefix + '/tickets/store', adminPanelPrefix + '/tickets/' + ticket_id + '/update');
        Swal.fire({
          html: edit_ticket_modal,
          showCancelButton: false,
          showConfirmButton: false,
          customClass: {
            content: 'p-0 text-left'
          },
          width: '48rem',
          onOpen: function onOpen() {
            $('.date-range-picker').daterangepicker({
              locale: {
                format: 'YYYY-MM-DD'
              },
              drops: 'down',
              opens: 'right',
              startDate: moment(ticket.start_date * 1000).toDate(),
              endDate: moment(ticket.end_date * 1000).toDate()
            });
            delete ticket.start_date;
            delete ticket.end_date;
            Object.keys(ticket).forEach(function (key) {
              $('#addTicketModal').find('[name="' + key + '"]').val(ticket[key]);
            });
            var localeSelect = $('#addTicketModal').find('select[name="locale"]');
            if (localeSelect) {
              localeSelect.addClass('js-edit-ticket-locale-ajax');
              localeSelect.attr('data-ticket-id', ticket_id);
              localeSelect.attr('data-webinar-id', webinar_id);
            }
          }
        });
      }
    });
  }
  $('body').on('click', '.edit-ticket', function (e) {
    e.preventDefault();
    var $this = $(this);
    loadingSwl();
    editTicket($this);
  });
  $('body').on('change', '.js-edit-ticket-locale-ajax', function (e) {
    e.preventDefault();
    var $this = $(this);
    var locale = $this.val();
    editTicket($this, locale);
  });



  function editChapter($this) {
    var locale = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
    var chapter_id = $this.attr('data-chapter-id');
    var webinar_id = $this.attr('data-webinar-id');
    var edit_data = {
      item_id: webinar_id,
      locale: locale
    };
    $.post(adminPanelPrefix + '/chapters/' + chapter_id + '/edit', edit_data, function (result) {
      if (result && result.chapter) {
        var chapter = result.chapter;
        var html = '<div id="editChapterModal">';
        html += $('#webinarChapterModal').html();
        html += '</div>';
        html = html.replaceAll(adminPanelPrefix + '/chapters/store', adminPanelPrefix + '/chapters/' + chapter_id + '/update');
        var nameId = randomString();
        html = html.replaceAll('record', nameId);
        Swal.fire({
          html: html,
          showCancelButton: false,
          showConfirmButton: false,
          customClass: {
            content: 'p-0 text-left'
          },
          width: '48rem',
          onOpen: function onOpen() {
            var $modal = $('#editChapterModal');
            Object.keys(chapter).forEach(function (key) {
              if (key === 'status') {
                var checked = chapter.status === 'active';
                $modal.find('[name="' + key + '"]').prop('checked', checked);
              } else if (key === 'check_all_contents_pass') {
                var checkedAllContents = chapter.check_all_contents_pass && chapter.check_all_contents_pass !== "0";
                $modal.find('[name="' + key + '"]').prop('checked', checkedAllContents);
              } else {
                $modal.find('[name="' + key + '"]').val(chapter[key]);
              }
            });
            var localeSelect = $modal.find('select[name="locale"]');
            if (localeSelect) {
              localeSelect.addClass('js-edit-chapter-locale-ajax');
              localeSelect.attr('data-chapter-id', chapter_id);
              localeSelect.attr('data-webinar-id', webinar_id);
            }
          }
        });
      }
    });
  }
  $('body').on('click', '.edit-chapter', function (e) {
    e.preventDefault();
    var $this = $(this);
    loadingSwl();
    editChapter($this);
  });
  $('body').on('change', '.js-edit-chapter-locale-ajax', function (e) {
    e.preventDefault();
    var $this = $(this);
    var locale = $this.val();
    editChapter($this, locale);
  });



  function editSession($this) {
    var locale = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
    var session_id = $this.attr('data-session-id');
    var webinar_id = $this.attr('data-webinar-id');
    var edit_data = {
      item_id: webinar_id,
      locale: locale
    };
    $.post(adminPanelPrefix + '/sessions/' + session_id + '/edit', edit_data, function (result) {
      if (result && result.session) {
        var session = result.session;
        var edit_session_modal = '<div id="addSessionModal">';
        edit_session_modal += $('#webinarSessionModal').html();
        edit_session_modal += '</div>';
        edit_session_modal = edit_session_modal.replaceAll(adminPanelPrefix + '/sessions/store', adminPanelPrefix + '/sessions/' + session_id + '/update');
        var nameId = randomString();
        edit_session_modal = edit_session_modal.replaceAll('record', nameId);
        Swal.fire({
          html: edit_session_modal,
          showCancelButton: false,
          showConfirmButton: false,
          customClass: {
            content: 'p-0 text-left'
          },
          width: '48rem',
          onOpen: function onOpen() {
            var $modal = $('#addSessionModal');
            var datetimepicker = $('.datetimepicker');
            datetimepicker.val(session.date);
            datetimepicker.daterangepicker({
              locale: {
                format: 'YYYY-MM-DD HH:mm'
              },
              singleDatePicker: true,
              timePicker: true,
              timePicker24Hour: true
            });
            delete session.date;
            Object.keys(session).forEach(function (key) {
              if (key === 'session_api') {
                var apiInput = $modal.find('.js-api-input[value="' + session[key] + '"]');
                apiInput.prop('checked', true);
                $modal.find('.js-api-input').prop('disabled', true);
                if (session[key] !== 'local') {
                  $modal.find('.js-ajax-api_secret').prop('disabled', true);
                  $modal.find('.js-ajax-date').prop('disabled', true);
                  $modal.find('.js-ajax-duration').prop('disabled', true);
                  $modal.find('.js-ajax-link').prop('disabled', true);
                }
                if (session[key] === 'big_blue_button') {
                  $modal.find('.js-moderator-secret').removeClass('d-none');
                  $modal.find('.js-ajax-moderator_secret').prop('disabled', true);
                } else if (session[key] === 'zoom') {
                  $modal.find('.js-local-link').addClass('d-none');
                  $modal.find('.js-api-secret').addClass('d-none');
                  $modal.find('.js-moderator-secret').addClass('d-none');
                } else if (session[key] === 'agora') {
                  $modal.find('.js-agora-chat-and-rec').removeClass('d-none');
                  $modal.find('.js-api-secret').addClass('d-none');
                  $modal.find('.js-local-link').addClass('d-none');
                  $modal.find('.js-moderator-secret').addClass('d-none');
                }
              } else if (key === 'status') {
                var checked = session.status === 'active';
                $modal.find('[name="' + key + '"]').prop('checked', checked);
              } else if (key === 'check_previous_parts' || key === 'access_after_day') {
                var sequenceContentSwitchChecked = session.check_previous_parts || session.access_after_day !== null;
                if (sequenceContentSwitchChecked) {
                  $modal.find('.js-sequence-content-switch').prop('checked', true);
                  $modal.find('[name="check_previous_parts"]').prop('checked', session.check_previous_parts);
                  $modal.find('[name="access_after_day"]').val(session.access_after_day);
                  $modal.find('.js-sequence-content-inputs').removeClass('d-none');
                }
              } else if (key === 'agora_settings') {
                var agora_settings = JSON.parse(session.agora_settings);
                if (agora_settings && agora_settings['chat'] && (agora_settings['chat'] === true || agora_settings['chat'] === 'true')) {
                  $modal.find('[name="agora_chat"]').prop('checked', true);
                }
                if (agora_settings && agora_settings['record'] && (agora_settings['record'] === true || agora_settings['record'] === 'true')) {
                  $modal.find('[name="agora_record"]').prop('checked', true);
                }
              } else {
                $modal.find('[name="' + key + '"]').val(session[key]);
              }
            });
            var localeSelect = $modal.find('select[name="locale"]');
            if (localeSelect) {
              localeSelect.addClass('js-edit-session-locale-ajax');
              localeSelect.attr('data-session-id', session_id);
              localeSelect.attr('data-webinar-id', webinar_id);
            }
          }
        });
      }
    });
  }
  $('body').on('click', '.edit-session', function (e) {
    e.preventDefault();
    var $this = $(this);
    loadingSwl();
    editSession($this);
  });
  $('body').on('change', '.js-edit-session-locale-ajax', function (e) {
    e.preventDefault();
    var $this = $(this);
    var locale = $this.val();
    editSession($this, locale);
  });
  $('body').on('change', '.js-video-demo-source', function (e) {
    e.preventDefault();
    var value = $(this).val();
    var $otherSources = $('.js-video-demo-other-inputs');
    var $secureHostSource = $('.js-video-demo-secure-host-input');
    if (value === "secure_host") {
      $otherSources.addClass('d-none');
      $secureHostSource.removeClass('d-none');
    } else {
      $otherSources.removeClass('d-none');
      $secureHostSource.addClass('d-none');
      var $filePathUploadButton = $('.js-video-demo-path-input .js-video-demo-path-upload');
      var $filePathLinkButton = $('.js-video-demo-path-input .js-video-demo-path-links');
      var $filePathInput = $('.js-video-demo-path-input input');
      $filePathUploadButton.addClass('d-none');
      $filePathLinkButton.addClass('d-none');
      if (value === 'upload') {
        $filePathUploadButton.removeClass('d-none');
      } else {
        $filePathLinkButton.removeClass('d-none');
      }
      if (videoDemoPathPlaceHolderBySource) {
        $filePathInput.attr('placeholder', videoDemoPathPlaceHolderBySource[value]);
      }
    }
  });


  $('body').on('click', '.edit-prerequisite', function (e) {
    e.preventDefault();
    var $this = $(this);
    var prerequisite_id = $this.attr('data-prerequisite-id');
    var webinar_id = $this.attr('data-webinar-id');
    loadingSwl();
    var edit_data = {
      item_id: webinar_id
    };
    $.post(adminPanelPrefix + '/prerequisites/' + prerequisite_id + '/edit', edit_data, function (result) {
      if (result && result.prerequisite) {
        var prerequisite = result.prerequisite;
        var edit_prerequisite_modal = '<div id="addPrerequisitesModal">';
        edit_prerequisite_modal += $('#webinarPrerequisitesModal').html();
        edit_prerequisite_modal += '</div>';
        edit_prerequisite_modal = edit_prerequisite_modal.replaceAll('prerequisites-select', 'prerequisites-select2');
        edit_prerequisite_modal = edit_prerequisite_modal.replaceAll(adminPanelPrefix + '/prerequisites/store', adminPanelPrefix + '/prerequisites/' + prerequisite_id + '/update');
        edit_prerequisite_modal = edit_prerequisite_modal.replaceAll('str_', '');
        Swal.fire({
          html: edit_prerequisite_modal,
          showCancelButton: false,
          showConfirmButton: false,
          customClass: {
            content: 'p-0 text-left'
          },
          width: '48rem',
          onOpen: function onOpen() {
            $('.prerequisites-select2').append('<option selected="selected" value="' + prerequisite.webinar_id + '">' + prerequisite.webinar_title + '</option>');
            if (prerequisite.required === 1) {
              $('#addPrerequisitesModal').find('[name="required"]').prop('checked', true);
            }
            handleSearchableSelect2('prerequisites-select2', adminPanelPrefix + '/webinars/search', 'title');
          }
        });
      }
    });
  });

   function editFaq($this) {
    var locale = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
    var faq_id = $this.attr('data-faq-id');
    var webinar_id = $this.attr('data-webinar-id');
    var edit_data = {
      item_id: webinar_id,
      locale: locale
    };
    $.post(adminPanelPrefix + '/faqs/' + faq_id + '/edit', edit_data, function (result) {
      if (result && result.faq) {
        var faq = result.faq;
        var edit_faq_modal = '<div id="addFAQsModal">';
        edit_faq_modal += $('#webinarFaqModal').html();
        edit_faq_modal += '</div>';
        edit_faq_modal = edit_faq_modal.replaceAll(adminPanelPrefix + '/faqs/store', adminPanelPrefix + '/faqs/' + faq_id + '/update');
        Swal.fire({
          html: edit_faq_modal,
          showCancelButton: false,
          showConfirmButton: false,
          customClass: {
            content: 'p-0 text-left'
          },
          width: '48rem',
          onOpen: function onOpen() {
            var $modal = $('#addFAQsModal');
            Object.keys(faq).forEach(function (key) {
              $modal.find('[name="' + key + '"]').val(faq[key]);
            });
            var localeSelect = $modal.find('select[name="locale"]');
            if (localeSelect) {
              localeSelect.addClass('js-edit-faq-locale-ajax');
              localeSelect.attr('data-faq-id', faq_id);
              localeSelect.attr('data-webinar-id', webinar_id);
            }
          }
        });
      }
    });
  }
  $('body').on('click', '.edit-faq', function (e) {
    e.preventDefault();
    var $this = $(this);
    loadingSwl();
    editFaq($this);
  });
  $('body').on('change', '.js-edit-faq-locale-ajax', function (e) {
    e.preventDefault();
    var $this = $(this);
    var locale = $this.val();
    editFaq($this, locale);
  });
  $('body').on('click', '.js-get-faq-description', function (e) {
    e.preventDefault();
    var $this = $(this);
    var answer = $this.parent().find('input').val();
    var html = '<div class="my-2">' + answer + '</div>';
    Swal.fire({
      html: html,
      showCancelButton: false,
      showConfirmButton: false,
      customClass: {
        content: 'p-0 text-left'
      },
      width: '30rem'
    });
  });


  $('body').on('click', '.edit-webinar-quiz', function (e) {
    e.preventDefault();
    var $this = $(this);
    var webinar_quiz_id = $this.attr('data-webinar-quiz-id');
    var webinar_id = $this.attr('data-webinar-id');
    loadingSwl();
    var edit_data = {
      item_id: webinar_id
    };
    $.post(adminPanelPrefix + '/webinar-quiz/' + webinar_quiz_id + '/edit', edit_data, function (result) {
      var _this2 = this;
      if (result && result.webinarQuiz) {
        var webinar_quiz = result.webinarQuiz;
        var edit_webinar_quiz_modal = '<div id="addQuizModal">';
        edit_webinar_quiz_modal += $('#quizzesModal').html();
        edit_webinar_quiz_modal += '</div>';
        edit_webinar_quiz_modal = edit_webinar_quiz_modal.replaceAll(adminPanelPrefix + '/webinar-quiz/store', adminPanelPrefix + '/webinar-quiz/' + webinar_quiz_id + '/update');
        edit_webinar_quiz_modal = edit_webinar_quiz_modal.replaceAll('quiz-select2', 'quiz-select22');
        Swal.fire({
          html: edit_webinar_quiz_modal,
          showCancelButton: false,
          showConfirmButton: false,
          customClass: {
            content: 'p-0 text-left'
          },
          width: '30rem',
          onOpen: function onOpen() {
            $('.quiz-select22').append('<option selected="selected" value="' + webinar_quiz.id + '">' + webinar_quiz.title + '</option>');
            $(".quiz-select22").select2({
              placeholder: $(_this2).data('placeholder'),
              allowClear: true,
              width: '100%'
            });
            $('#addQuizModal').find('[name="chapter_id"]').val(webinar_quiz.chapter_id);
          }
        });
      }
    });
  });


  $('body').on('change', 'select[name="type"]', function () {
    var value = this.value;
    var webinarItem = ['capacity', 'start_date'];
    var show = true;
    if (value !== 'webinar') {
      show = false;
    }
    for (var _i = 0, _webinarItem = webinarItem; _i < _webinarItem.length; _i++) {
      var item = _webinarItem[_i];
      if (show) {
        $('.js-' + item).removeClass('d-none');
      } else {
        $('.js-' + item).addClass('d-none');
      }
    }
  });
  $('body').on('change', '.js-sequence-content-switch', function () {
    var parent = $(this).closest('.js-content-form');
    var sequenceContentInputs = parent.find('.js-sequence-content-inputs');
    sequenceContentInputs.addClass('d-none');
    if (this.checked) {
      sequenceContentInputs.removeClass('d-none');
    }
  });
  $('body').on('click', '#bundleAddNewCourses', function (e) {
    e.preventDefault();
    var html = '<div id="addBundleWebinarModal">';
    html += $('#bundleWebinarsModal').html();
    html += '</div>';
    html = html.replaceAll('bundleWebinars-select', 'bundleWebinars-select2');
    html = html.replaceAll('str_', '');
    Swal.fire({
      html: html,
      showCancelButton: false,
      showConfirmButton: false,
      customClass: {
        content: 'p-0 text-left'
      },
      width: '48rem',
      onOpen: function onOpen() {
        handleSearchableSelect2('bundleWebinars-select2', adminPanelPrefix + '/webinars/search', 'title');
      }
    });
  });
  $('body').on('click', '#saveBundleWebinar', function (e) {
    e.preventDefault();
    var $this = $(this);
    var form = $('#addBundleWebinarModal .js-form');
    handleWebinarItemForm(form, $this);
  });
  $('body').on('click', '.edit-bundle-webinar', function (e) {
    e.preventDefault();
    var $this = $(this);
    var item_id = $this.attr('data-item-id');
    var bundle_id = $this.attr('data-bundle-id');
    loadingSwl();
    var edit_data = {
      item_id: bundle_id
    };
    $.post(adminPanelPrefix + '/bundle-webinars/' + item_id + '/edit', edit_data, function (result) {
      if (result && result.bundleWebinar) {
        var bundleWebinar = result.bundleWebinar;
        var selectHtml = "<option value=\"".concat(bundleWebinar.webinar_id, "\" selected>").concat(bundleWebinar.webinar_title, "</option>");
        $('#bundleWebinarsModal .bundleWebinars-select').html(selectHtml);
        var html = '<div id="addBundleWebinarModal">';
        html += $('#bundleWebinarsModal').html();
        html += '</div>';
        html = html.replaceAll('bundleWebinars-select', 'bundleWebinars-select2');
        html = html.replaceAll(adminPanelPrefix + '/bundle-webinars/store', adminPanelPrefix + '/bundle-webinars/' + item_id + '/update');
        html = html.replaceAll('str_', '');
        Swal.fire({
          html: html,
          showCancelButton: false,
          showConfirmButton: false,
          customClass: {
            content: 'p-0 text-left'
          },
          width: '48rem',
          onOpen: function onOpen() {
            handleSearchableSelect2('bundleWebinars-select2', adminPanelPrefix + '/webinars/search', 'title');
          }
        });
      }
    });
  });
  $('body').on('change', '.js-interactive-type', function () {
    var fileForm = $(this).closest('.file-form');
    var $fileName = fileForm.find('.js-interactive-file-name-input');
    $fileName.addClass('d-none');
    if ($(this).val() === 'custom') {
      $fileName.removeClass('d-none');
    }
  });
  feather.replace();



   </script>


@endpush
