@extends('admin.layouts.app')

@push('libraries_top')

@endpush
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@section('content')



    <section class="section">
        <div class="section-header">
            <h1> نتائج التقييمات</h1>
            
        </div>
    </section>

    <div class="section-body">

        <section class="card">
            <div class="card-body">
                <form method="get" class="mb-0">

                    <div class="row">
                       
                        {{--<div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                                <div class="input-group">
                                    <input type="date" id="from" class="text-center form-control" name="from" value="{{ request()->get('from') }}" placeholder="Start Date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                                <div class="input-group">
                                    <input type="date" id="to" class="text-center form-control" name="to" value="{{ request()->get('to') }}" placeholder="End Date">
                                </div>
                            </div>
                        </div>--}}

                        
                      

                       

                       


                        <div class="col-md-3">
                           
                        
                            <div class="form-group mt-1">
                              
                            
                                                    
                                <input type="submit" name="action" class="text-center btn btn-warning" value="تصدير الى اكسل">
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
                <table id="quizzesResultsTable" class="table table-striped font-14">
                    <thead>
                        <tr>
                            <th class="text-left">اسم المتدرب</th>
                            <th class="text-left">البريد الإلكتروني</th>
                            <th class="text-left">الهاتف</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizzesResults as $result)
                        
                        @php 
                        
                        $res=json_decode($result->results);
                        if(isset($res->info)) {
                        @endphp
                            <tr>
                                <td>
                                    <span>{{ $res->info->name }}</span>
                                  
                                </td>
                                <td class="text-left">
                             <span>{{ $res->info->email }}</span>
                                </td>
                                <td class="text-left">
                           <span> {{ $res->info->phone }}</span>

                                </td>
                               
                            </tr>
                            @php } else{  @endphp
                             <tr>
                                <td>
                                    <span>-</span>
                                  
                                </td>
                                <td class="text-left">
                             <span>-</span>
                                </td>
                                <td class="text-left">
                           <span> -</span>

                                </td>
                               
                            </tr>
                         @php   }
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    
        <script>
            $(document).ready(function() {
                $.noConflict();

                $('#quizzesResultsTable').DataTable({
                    
                    "ordering": false, // Disable sorting
                "searching": false, // Disable filtering (search)
                "paging": true, // Enable pagination (optional)
                "info": false // Disable table information (optional)
,
                "language": {
    "paginate": {
        "previous": "السابق",
        "next": "التالي"
    }
}
                });
            });
        </script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('select[data-plugin-selectTwo]').select2({
            placeholder: "اختر متدرب", // Placeholder text
            allowClear: true, // Allow clearing the selection
            width: '100%' // Make the dropdown full width
        });
    });
</script>

@endsection
