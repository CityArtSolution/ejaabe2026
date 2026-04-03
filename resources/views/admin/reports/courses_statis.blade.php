@extends('admin.layouts.app')

@push('libraries_top')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('public.course statistics') }}</h1>
        </div>
    </section>
  <div class="section-body">
        <section class="card">
            <div class="card-body">
                <form method="get" class="mb-0">
                    <div class="row">
                        <!-- Category Filter -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.Category') }}</label>
                                <select name="category_id" class="form-control">
                                    <option value="">{{trans('public.Categories')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request()->get('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Webinar Type Filter -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.type') }}</label>
                                <select name="webinar_type" class="form-control">
                                    <option value="">{{ trans('public.type') }}</option>
                                    <option value="course" {{ request()->get('webinar_type') == 'course' ? 'selected' : '' }}>{{trans('public.normal course')}}</option>
                                    <option value="text_lesson" {{ request()->get('webinar_type') == 'text_lesson' ? 'selected' : '' }}>{{trans('public.text_lesson')}}</option>
                                 <option value="offline" {{ request()->get('webinar_type') == 'offline' ? 'selected' : '' }}>{{trans('webinars.offline')}}</option>
                                 <option value="webinar" {{ request()->get('webinar_type') == 'webinar' ? 'selected' : '' }}>{{trans('webinars.webinar')}}</option>

                                </select>
                            </div>
                        </div>

                        <!-- Date Range Filters -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.from') }}</label>
                                <input type="date" name="from" class="form-control" value="{{ request()->get('from') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.to') }}</label>
                                <input type="date" name="to" class="form-control" value="{{ request()->get('to') }}">
                            </div>
                        </div>

                        <!-- Search Button -->
                        <div class="col-md-3">
                            <div class="form-group mt-1">
                                <button type="submit" class="btn btn-primary mt-4">{{ trans('public.show_results') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

   
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableData" class="table table-striped font-14">
                    <thead>
                        <tr>
                            <th class="text-left">{{ trans('public.webinar') }}</th>
                <th class="text-left">{{ trans('public.category') }}</th>
                <th class="text-left">{{ trans('public.number_of_students') }}</th>
                <th class="text-left">{{ trans('public.start_date') }}</th>
                <th class="text-left">{{ trans('public.average_rating') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportData as $item)
                            <tr>
                                    <td class="text-left">{{ $item['webinar_title'] }}</td>
                    <td class="text-left">{{ $item['category_title'] }}</td>
                    <td class="text-left">{{ $item['number_of_students'] }}</td>
                    <td class="text-left">{{ $item['start_date'] }}</td>
                    <td class="text-left">{{ $item['average_rating'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
                <div class="d-flex justify-content-center mt-4">
    {{ $webinars->links() }}
</div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <!-- Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <!-- JSZip (required for Excel export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <!-- Excel Export Button -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

    @push('scripts_bottom')
        <script>
            $(document).ready(function() {
                $.noConflict(); // Use noConflict if necessary

                $('#tableData').DataTable({
                    "ordering": true,
                    "searching": true,
                    "paging": false,
                    "info": false,
                    "language": {
                        "search": "بحث:",
                        "paginate": {
                            "previous": "السابق",
                            "next": "التالي"
                        }
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        'excel'
                    ]
                });
            });
        </script>
    @endpush
@endsection