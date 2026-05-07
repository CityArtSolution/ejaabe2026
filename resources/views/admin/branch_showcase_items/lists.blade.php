@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.showcase_slides') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.showcase_slides') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header justify-content-between">
                    <form action="{{ getAdminPanelUrl('/branch-showcase-items') }}" method="get" class="d-flex align-items-center">
                        @if(empty($restrictedBranchId))
                            <select name="branch_id" class="form-control mr-2">
                                <option value="">{{ trans('admin/main.all_branches') }}</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name ?: ('Branch #' . $branch->id) }}</option>
                                @endforeach
                            </select>
                        @endif
                        <select name="section" class="form-control mr-2">
                            <option value="">{{ trans('admin/main.all_sections') }}</option>
                            @foreach($sections as $key => $label)
                                <option value="{{ $key }}" {{ request('section') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">{{ trans('admin/main.show_results') }}</button>
                    </form>
                    <a href="{{ getAdminPanelUrl('/branch-showcase-items/create') }}" class="btn btn-primary">{{ trans('admin/main.add_new') }}</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped font-14">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin/main.id') }}</th>
                                    <th>{{ trans('branches.branch') }}</th>
                                    <th>{{ trans('admin/main.section') }}</th>
                                    <th>{{ trans('admin/main.page') }}</th>
                                    <th>{{ trans('admin/main.image') }}</th>
                                    <th>{{ trans('admin/main.order') }}</th>
                                    <th>{{ trans('admin/main.status') }}</th>
                                    <th>{{ trans('admin/main.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ optional($item->branch)->name ?: ('Branch #' . $item->branch_id) }}</td>
                                        <td>{{ $sections[$item->section] ?? $item->section }}</td>
                                        <td>{{ $pages[$item->page] ?? $item->page }}</td>
                                        <td>
                                            <img src="{{ $item->image }}" alt="{{ $item->title }}" width="80" height="50" style="object-fit: contain;">
                                            @if(!empty($item->title))
                                                <div class="mt-1">{{ $item->title }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $item->order }}</td>
                                        <td>
                                            <span class="badge {{ $item->status ? 'badge-success' : 'badge-danger' }}">{{ $item->status ? trans('admin/main.active') : trans('admin/main.inactive') }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ getAdminPanelUrl('/branch-showcase-items/' . $item->id . '/edit') }}" class="btn-transparent text-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @include('admin.includes.delete_button', ['url' => getAdminPanelUrl('/branch-showcase-items/' . $item->id . '/delete'), 'btnClass' => ''])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center">
                        {{ $items->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
