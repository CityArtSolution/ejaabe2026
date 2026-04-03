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
            <h1> نتائج الاختبارات</h1>
            
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
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.students') }}</label>
                                <select name="student_id" data-plugin-selectTwo class="form-control populate">
                                    <option value="">اختر متدرب</option>
                                    @foreach($users as $student)
                                        <option value="{{ $student->id }}" @if(request()->get('student_id') == $student->id) selected @endif>{{ $student->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                      

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">اختر مجموعة</label>
                                <select name="group_id"  class="form-control populate">
                                    <option value="">اختر مجموعة</option>
                                    @foreach($userGroups as $userGroup)
                                        <option value="{{ $userGroup->id }}" @if(request()->get('group_id') == $userGroup->id) selected @endif>{{ $userGroup->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                       


                        <div class="col-md-3">
                            <div class="form-group mt-1">
                                <label class="input-label mb-4"> </label>
                                <input type="submit" name="action" class="text-center btn btn-primary w-100" value="{{ trans('admin/main.show_results') }}">
                            </div>
                        
                            <div class="form-group mt-1">
                                <input type="submit" name="action" class="text-center btn btn-success" value="تصديرPDF">
                            
                                                    
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
                            <th class="text-left">اسم الاختبار</th>
                            <th class="text-left">المجموعة</th>
                            <th class="text-left">الجهة</th>
                            <th class="text-center">التاريخ</th>

                            <th class="text-left">اسم المتدرب</th>
                            <th class="text-left">رقم المتدرب</th>
                            <th class="text-left">عدد المحاولات</th>

                            <th class="text-center">الدرجة</th>
                          <th class="text-center">المحاولة</th>
                       
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizzesResults as $result)
                            <tr>
                                <td>
                                    <span>{{ $result->quiz->title }}</span>
                                    <small class="d-block text-left text-primary">({{ $result->quiz->webinar->title ?? "" }})</small>
                                </td>
  @php
        // Retrieve the user group using the getUserGroup method
        $userGroup = $result->user->getUserGroup();
    @endphp
                                <td class="text-left">
                                     @if($userGroup)
        <p>{{ $userGroup->name }}</p>
    @else
        <p> لاتوجد.</p>
    @endif

                                </td>
                                <td>
                             {{$result->user->organization->full_name ?? ""}}

                                </td>
                                <td class="text-center">{{ dateTimeformat($result->created_at, 'j F Y') }}</td>

                                <td class="text-left">{{ $result->user->full_name }}
                                   

                                </td>
                                <td class="text-left">{{ $result->user->id }}</td>
                                <td>{{$result->attempt_count ?? ""}}</td>
                                <td class="text-center">{{ $result->max_grade }}</td>
                              <td class="text-center">
                                <a href="/panel/quizzes/{{$result->max_grade_result_id}}/result" target=_blank>رابط المحاولة</a>
                                </td>
                            </tr>
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
