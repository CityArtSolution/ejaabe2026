<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileLibraryController extends Controller
{
public function index()
{
    $files = FileLibrary::latest()->get(); // Eloquent فقط

    return view('admin.file-library.index', [
        'files' => $files,
        'unreadNotifications' => collect(), // لتجنب الخطأ
        'authUser' => auth()->user(),
    ]);
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file',
            'details' => 'nullable|string',
        ]);

        $path = $request->file('file')->store('file-library', 'public');

        FileLibrary::create([
            'name' => $request->name,
            'details' => $request->details,
            'file_path' => $path,
        ]);

        return redirect()->back()->with('success', 'تم رفع الملف بنجاح');
    }

    public function update(Request $request, $id)
    {
        $file = FileLibrary::findOrFail($id);

        $file->update([
            'name' => $request->name,
            'details' => $request->details,
        ]);

        return redirect()->back()->with('success', 'تم تعديل الملف');
    }

    public function destroy($id)
    {
        $file = FileLibrary::findOrFail($id);

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect()->back()->with('success', 'تم حذف الملف');
    }
}
