@extends('admin.layouts.app')

@push('libraries_top')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('public.reveune') }}</h1>
        </div>
    </section>

    <div class="section-body">
        <section class="card">
            <div class="card-body">
                <form method="get" class="mb-0">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.from') }}</label>
                                <div class="input-group">
                                    <input type="date" id="from" class="text-center form-control" name="from" value="{{ request()->get('from') }}" placeholder="Start Date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.to') }}</label>
                                <div class="input-group">
                                    <input type="date" id="to" class="text-center form-control" name="to" value="{{ request()->get('to') }}" placeholder="End Date">
                                </div>
                            </div>
                        </div>

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
                            <th class="text-left">{{ trans('public.teacher') }}</th>
                            <th class="text-left">{{ trans('public.total students') }}</th>
                            <th class="text-left">{{ trans('public.amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportData as $item)
                            <tr>
                                <td class="text-left">{{ $item['webinar_title'] }}</td>
                                <td class="text-left">{{ $item['webinar_teacher'] }}</td>
                                <td class="text-left">{{ count($item['enrolled_students']) }}</td>
                                <td class="text-left">{{ $item['total_sales_amount'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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