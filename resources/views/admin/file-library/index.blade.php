@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">

    {{-- ===== HEADER ===== --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">📁 مكتبة الملفات</h1>
<span class="text-sm text-gray-500">
    عدد الملفات: {{ $files->count() }}
</span>
    </div>

    {{-- ===== SUCCESS MESSAGE ===== --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- ===== UPLOAD FORM ===== --}}
    <div class="bg-white rounded-xl shadow p-6 mb-10">
        <h2 class="text-lg font-semibold mb-4">رفع ملف جديد</h2>

        <form action="{{ route('file-library.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf

            <input type="text" name="name" required
                   class="border rounded-lg px-4 py-2"
                   placeholder="اسم الملف">

            <input type="file" name="file" required
                   class="border rounded-lg px-4 py-2">

            <input type="text" name="details"
                   class="border rounded-lg px-4 py-2"
                   placeholder="تفاصيل (اختياري)">

            <div class="md:col-span-3 text-right">
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    رفع الملف
                </button>
            </div>
        </form>
    </div>

    {{-- ===== FILES TABLE ===== --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm text-right">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-4">#</th>
                    <th>الاسم</th>
                    <th>التفاصيل</th>
                    <th>التاريخ</th>
                    <th class="p-4">إجراءات</th>
                </tr>
            </thead>
            <tbody>
           @forelse($files as $i => $file)
<tr class="border-t hover:bg-gray-50">
    <td class="p-4">{{ $i + 1 }}</td>
    <td>{{ $file->name }}</td>
    <td>{{ $file->details ?? '-' }}</td>
    <td>{{ $file->created_at->toDateString() }}</td>
    <td class="p-4">
        <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank">عرض</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center p-6 text-gray-500">
        لا يوجد ملفات
    </td>
</tr>
@endforelse

            </tbody>
        </table>
    </div>
</div>

{{-- ===== EDIT MODAL ===== --}}
<div id="editModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-xl p-6">
        <h3 class="text-lg font-semibold mb-4">تعديل الملف</h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <input id="editName" name="name" class="w-full border rounded-lg px-4 py-2 mb-3">
            <textarea id="editDetails" name="details" class="w-full border rounded-lg px-4 py-2 mb-4"></textarea>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 rounded">
                    إلغاء
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded">
                    حفظ
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== DELETE MODAL ===== --}}
<div id="deleteModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-sm rounded-xl p-6 text-center">
        <h3 class="text-lg font-semibold mb-3">حذف ملف</h3>
        <p class="mb-5">هل أنت متأكد من حذف <span id="deleteFileName" class="font-bold"></span> ؟</p>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex justify-center gap-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 rounded">
                    إلغاء
                </button>
                <button class="px-4 py-2 bg-red-600 text-white rounded">
                    حذف
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== JS ===== --}}
<script>
function openEditModal(id, name, details) {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editName').value = name;
    document.getElementById('editDetails').value = details;
    document.getElementById('editForm').action = `/admin/file-library/${id}`;
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function openDeleteModal(id, name) {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteFileName').innerText = name;
    document.getElementById('deleteForm').action = `/admin/file-library/${id}`;
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection
