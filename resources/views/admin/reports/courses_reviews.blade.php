@extends('admin.layouts.app')

@push('libraries_top')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('public.courses_reviews') }}</h1>
        </div>
    </section>

    <div class="section-body">
        <section class="card">
            <div class="card-body">
                <form method="get" class="mb-0">
                    <div class="row">
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
                            <th class="text-left">{{ trans('product.content_quality') }}</th>
                            <th class="text-left">{{ trans('product.instructor_skills') }}</th>
                            <th class="text-left">{{ trans('product.purchase_worth') }}</th>
                            <th class="text-left">{{ trans('product.support_quality') }}</th>
                            <th class="text-left">{{ trans('product.How useful are the guidelines?') }}</th>
                            <th class="text-left">{{ trans('public.final_rate') }}</th>
                            <th class="text-left">{{ trans('public.review Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportData as $item)
                            <tr>
                                <td class="text-left">{{ $item['webinar_title'] }}</td>
                                <td class="text-left">{{ $item['content_quality'] }}</td>
                                <td class="text-left">{{ $item['instructor_skills'] }}</td>
                                <td class="text-left">{{ $item['purchase_worth'] }}</td>
                                <td class="text-left">{{ $item['support_quality'] }}</td>
                                <td class="text-left">{{ $item['guides'] }}</td>
                                <td class="text-left">{{ $item['final_rate'] }}</td>
                                <td class="text-left">{{ $item['created_at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-4">
                {{ $reviews->links() }}
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