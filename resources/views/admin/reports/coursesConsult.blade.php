@extends('admin.layouts.app')

@push('libraries_top')

@endpush
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">




@section('content')
    <section class="section">
        <div class="section-header">
            {{--<h1>طلبات الخدمات</h1>--}}
            <h1>{{ $pageTitle }}</h1>
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
                @php
    $serviceLabels = [
        'course' => 'دورة تدريبية',
        'consulting' => 'طلب استشارة',
        'content_development' => 'طلب خدمات تطوير المحتوى',
        'quotation' => 'طلب عرض سعر',
    ];
@endphp
                <table id="requestsTable" class="table table-striped font-14">
                    <thead>
                        <tr>
                            <th class="text-left">نوع الخدمة</th>
                            <th class="text-left">العنوان</th>
                            <th class="text-left">اسم العميل</th>
                            <th class="text-left">رقم الهاتف</th>
                            <th class="text-left">البريد الإلكتروني</th>
                            <th class="text-left">الوصف</th>
                            <th class="text-left">تاريخ الطلب</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $request)
                            <tr>
                                            <td>{{ $serviceLabels[$item->type] ?? $item->type }}</td>

            <td>
                {{ $item->type === 'course'
                    ? optional($item->webinar)->title
                    : ($serviceLabels[$item->type] ?? '—') }}
            </td>

            <td>{{ $item->name }}</td>
         
            <td>{{ $item->phone }}</td>
            <td>{{ $item->email }}</td>

            <td>
                <details>
                    <summary>عرض التفاصيل</summary>
                    <div style="white-space: pre-wrap; overflow-wrap: anywhere; min-width: 180px;">{{ $item->description ?: '—' }}</div>
                </details>
            </td>

            <td>{{ $item->created_at->format('Y-m-d') }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
           <div class="mt-3">
    {{ $items->links() }}
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