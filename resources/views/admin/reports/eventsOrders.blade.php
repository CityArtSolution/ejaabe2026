@extends('admin.layouts.app')

@push('libraries_top')

@endpush
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">



@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{trans('events.Events Orders')}}</h1>
        </div>
    </section>

    <div class="section-body">
        <section class="card">
            <div class="card-body">
                <form method="get" class="mb-0">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">من تاريخ</label>
                                <div class="input-group">
                                    <input type="date" id="from" class="text-center form-control" name="from" value="{{ request()->get('from') }}" placeholder="Start Date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">الى تاريخ</label>
                                <div class="input-group">
                                    <input type="date" id="to" class="text-center form-control" name="to" value="{{ request()->get('to') }}" placeholder="End Date">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mt-1">
                                <button type="submit" class="btn btn-primary mt-4">بحث</button>
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
                <table id="requestsTable" class="table table-striped font-14">
                    <thead>
                        <tr>
                            <th class="text-left">{{trans('events.event')}}</th>
                            <th class="text-left">{{trans('events.name')}}</th>
                            <th class="text-left">{{trans('public.phone')}}</th>
                            <th class="text-left">{{trans('public.email')}}</th>
                            <th class="text-left">{{trans('events.company')}}</th>
                          <th class="text-left">{{trans('events.notes')}}</th>

                            <th class="text-left">{{trans('events.date')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $item)
                            <tr>
                                <td>
                                  {{ $item->event->title}}
                                </td>
                               
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->company }}</td>

                                <td>{{ Str::limit($item->notes, 50) }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
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

            $('#requestsTable').DataTable({
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