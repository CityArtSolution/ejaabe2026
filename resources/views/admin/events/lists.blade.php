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
            <h1>{{ trans('events.events') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('events.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{ trans('events.events') }}</div>
            </div>
        </div>
           <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                              
                             @can('admin_webinars_create')
                                <div class="text-right" style="padding-left: 2rem;">
                                    <a href="{{ getAdminPanelUrl() }}/events/create"target=_blank class="btn btn-success">{{trans('events.create')}}</a>
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
                                 <th class="text-left">{{ trans('events.image') }}</th>

                                        <th class="text-left">{{ trans('events.title') }}</th>
                                        <th>{{ trans('events.location') }}</th>
                                        <th>{{ trans('events.start_date') }}</th>
                                        <th>{{ trans('events.time') }}</th>
                                        <th>{{ trans('branches.status') }}</th>

                                          <th>{{ trans('branches.action') }}</th>
                                    </tr>
                                    @foreach($events as $event)

                                        <tr>
                                            <td class="text-left"><img src="{{ $event->image }}" width="100"/></td>

                                            <td>
                                                {{ $event->title }}      
                                            </td>
                                            <td class="text-left">{{ $event->location }}</td>
                                            <td>
                                                
                                                
                                                {{ !empty($event) ? \Carbon\Carbon::parse($event->start_date)->format('Y-m-d'):""}}
                                            </td>
                                            <td>
                                                
                                                {{ !empty($event) ? $event->time:""}}
                                            </td>
                                            <td>
                                                @if($event->status)
                                                    <span class="badge bg-success">{{ trans('branches.enabled') }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ trans('branches.disabled') }}</span>
                                                @endif
                                            </td>
                                               <td>
                                                   @if($event && $event->slug)
                                              <a href="/{{app()->getlocale()}}/event/{{$event->slug}}"
                                    class="btn-transparent btn-sm text-primary" target=_blank title="معاينه">
                                     <i class="fa fa-eye"></i>
                                           </a>
                                           @endif
               
                                                @can('admin_categories_edit')
                                                 <a href="{{ getAdminPanelUrl()}}/events/{{$event->id}}/edit" class="btn-transparent btn-sm text-primary">
    <i class="fa fa-edit"></i>
</a>
                                                @endcan
                                                @can('admin_categories_delete')
                                                
                                                @include('admin.includes.delete_button', [
    'url' => route('admin.events.delete', ['id' => $event->id]),
    'deleteConfirmMsg' => trans('branches.category_delete_confirm_msg')
])
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $events->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
