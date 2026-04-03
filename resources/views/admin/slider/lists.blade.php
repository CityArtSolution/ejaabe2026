@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">السلايدر</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">قائمة السلايدات</h2>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('createslide') }}" class="btn btn-primary">
                                {{ trans('admin/main.add_new') }}
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('admin/main.id') }}</th>
                                            <th>{{ trans('admin/main.title') }}</th>
                                            <th>{{ trans('admin/main.image') }}</th>
                                            <th>{{ trans('admin/main.status') }}</th>
                                            <th>{{ trans('admin/main.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sliders as $slider)
                                            <tr>
                                                <td>{{ $slider->id }}</td>
                                                <td>
                                                    <div>{{ $slider->title }}</div>
                                                </td>
                                                <td>
                                                    <img src="{{ $slider->image }}" alt="slider" width="100">
                                                </td>
                                                <td>
                                                    <span class="badge {{ $slider->status ? 'badge-success' : 'badge-danger' }}">
                                                        {{ $slider->status ? trans('admin/main.active') : trans('admin/main.inactive') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('editslide', $slider->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('deleteslide', $slider->id) }}" method="GET" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('سيتم حذف السلايد ! هل انت متاكد')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection