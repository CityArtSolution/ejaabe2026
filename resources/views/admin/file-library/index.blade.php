@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>مكتبة الملفات</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">مكتبة الملفات</div>
            </div>
        </div>

        <div class="section-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>رفع ملف جديد</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('file-library.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-12 col-md-4 form-group">
                                        <label>اسم الملف</label>
                                        <input type="text" name="name" required class="form-control" value="{{ old('name') }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group">
                                        <label>الملف</label>
                                        <input type="file" name="file" required class="form-control">
                                    </div>

                                    <div class="col-12 col-md-4 form-group">
                                        <label>تفاصيل (اختياري)</label>
                                        <input type="text" name="details" class="form-control" value="{{ old('details') }}">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">رفع الملف</button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>عدد الملفات: {{ $files->count() }}</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>التفاصيل</th>
                                        <th class="text-center">التاريخ</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @forelse($files as $i => $file)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $file->name }}</td>
                                            <td>{{ $file->details ?? '-' }}</td>
                                            <td class="text-center">{{ $file->created_at->toDateString() }}</td>
                                            <td>
                                                <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" class="btn-sm btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="عرض">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <button type="button" class="btn-transparent text-primary js-edit-file"
                                                        data-action="{{ route('file-library.update', $file->id) }}"
                                                        data-name="{{ $file->name }}"
                                                        data-details="{{ $file->details }}"
                                                        title="{{ trans('admin/main.edit') }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <form action="{{ route('file-library.destroy', $file->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الملف؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-transparent text-danger" title="{{ trans('admin/main.delete') }}">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">لا يوجد ملفات</td>
                                        </tr>
                                    @endforelse

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="editFileModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editFileForm" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">تعديل الملف</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>اسم الملف</label>
                            <input type="text" id="editFileName" name="name" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label>تفاصيل (اختياري)</label>
                            <textarea id="editFileDetails" name="details" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('editFileModal');
            // خارج المحتوى الرئيسي حتى لا تظهر النافذة خلف الخلفية المعتمة
            document.body.appendChild(modal);

            document.querySelectorAll('.js-edit-file').forEach(function (button) {
                button.addEventListener('click', function () {
                    document.getElementById('editFileForm').action = button.dataset.action;
                    document.getElementById('editFileName').value = button.dataset.name;
                    document.getElementById('editFileDetails').value = button.dataset.details;
                    $(modal).modal('show');
                });
            });
        });
    </script>
@endsection
