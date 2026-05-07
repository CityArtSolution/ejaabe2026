@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ !empty($item) ? trans('admin/main.edit') : trans('admin/main.new') }} {{ trans('admin/main.showcase_slide') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl('/branch-showcase-items') }}">{{ trans('admin/main.showcase_slides') }}</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl('/branch-showcase-items/' . (!empty($item) ? $item->id . '/update' : 'store')) }}" method="post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label class="input-label">{{ trans('branches.branch') }}</label>
                                    @if(!empty($restrictedBranchId))
                                        @php $restrictedBranch = $branches->first(); @endphp
                                        <input type="hidden" name="branch_id" value="{{ $restrictedBranchId }}">
                                        <input type="text" class="form-control" value="{{ optional($restrictedBranch)->name ?: ('Branch #' . $restrictedBranchId) }}" disabled>
                                    @else
                                        <select name="branch_id" class="form-control @error('branch_id') is-invalid @enderror">
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ old('branch_id', $item->branch_id ?? session('admin_selected_branch', 1)) == $branch->id ? 'selected' : '' }}>{{ $branch->name ?: ('Branch #' . $branch->id) }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @error('branch_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.section') }}</label>
                                    <select name="section" class="form-control @error('section') is-invalid @enderror">
                                        @foreach($sections as $key => $label)
                                            <option value="{{ $key }}" {{ old('section', $item->section ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('section')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.show_on') }}</label>
                                    <select name="page" class="form-control @error('page') is-invalid @enderror">
                                        @foreach($pages as $key => $label)
                                            <option value="{{ $key }}" {{ old('page', $item->page ?? 'both') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('page')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.title') }}</label>
                                    <input type="text" name="title" value="{{ old('title', $item->title ?? '') }}" class="form-control @error('title') is-invalid @enderror">
                                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('public.image') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="button" class="input-group-text admin-file-manager" data-input="image" data-preview="holder">
                                                <i class="fa fa-chevron-up"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="image" id="image" value="{{ old('image', $item->image ?? '') }}" class="form-control @error('image') is-invalid @enderror">
                                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.link') }}</label>
                                    <input type="text" name="link" value="{{ old('link', $item->link ?? '') }}" class="form-control @error('link') is-invalid @enderror">
                                    @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.order') }}</label>
                                    <input type="number" name="order" value="{{ old('order', $item->order ?? 0) }}" class="form-control @error('order') is-invalid @enderror">
                                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group mt-30 d-flex align-items-center cursor-pointer">
                                    <div class="custom-control custom-switch align-items-start">
                                        <input type="checkbox" name="status" class="custom-control-input" id="statusSwitch" {{ old('status', !isset($item) || $item->status ? 'on' : null) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="statusSwitch"></label>
                                    </div>
                                    <label for="statusSwitch" class="mb-0">{{ trans('admin/main.active') }}</label>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ trans('admin/main.save_change') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
