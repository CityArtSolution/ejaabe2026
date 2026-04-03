@extends('admin.layouts.app')

@push('libraries_top')

@endpush
<style>
.badge {
    vertical-align: middle;
    padding: 7px 12px;
    font-weight: 600;
    color: #fff;
    </style>
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('branches.branches') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('branches.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{ trans('branches.branches') }}</div>
            </div>
        </div>
           <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                              
                             @can('admin_webinars_create')
                                <div class="text-right" style="padding-left: 2rem;">
                                    <a href="{{ getAdminPanelUrl() }}/branches/create"target=_blank class="btn btn-success">{{ trans('branches.new') }}</a>
                                </div>
                            @endcan
                            </div>
                            </div>
                            </div>
                            </div>
                           

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th class="text-left">{{ trans('public.name') }}</th>
                                        <th>{{ trans('branches.subdomain') }}</th>
                                        <th>{{ trans('public.status') }}</th>
                                        <th>{{ trans('public.action') }}</th>
                                    </tr>
                                    @foreach($branches as $branch)

                                        <tr>
                                            <td>
                                                {{ $branch->name }}      
                                            </td>
                                            <td class="text-left">{{ $branch->subdomain }}</td>
                                            <td>
                                                @if($branch->status)
                                                    <span class="badge bg-success">{{ trans('branches.enabled') }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ trans('branches.disabled') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @can('admin_categories_edit')
                                                    <a href="{{ getAdminPanelUrl() }}/branches/{{ $branch->id }}/edit"
                                                       class="btn-transparent btn-sm text-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('admin_categories_delete')
                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/branches/'.$branch->id.'/delete', 'deleteConfirmMsg' => trans('branches.category_delete_confirm_msg')])
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $branches->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
