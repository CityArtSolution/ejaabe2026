<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchShowcaseItem;
use Illuminate\Http\Request;

class BranchShowcaseItemController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin_settings');

        $query = BranchShowcaseItem::query()->with('branch')->orderBy('branch_id')->orderBy('section')->orderBy('order');

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->get('branch_id'));
        } elseif (session()->has('admin_selected_branch')) {
            $query->where('branch_id', session()->get('admin_selected_branch'));
        }

        if ($request->filled('section')) {
            $query->where('section', $request->get('section'));
        }

        $data = [
            'pageTitle' => trans('admin/main.showcase_slides'),
            'items' => $query->paginate(20),
            'branches' => Branch::withoutGlobalScopes()->orderBy('id')->get(),
            'sections' => BranchShowcaseItem::sections(),
            'pages' => BranchShowcaseItem::pages(),
        ];

        return view('admin.branch_showcase_items.lists', $data);
    }

    public function create()
    {
        $this->authorize('admin_settings');

        return view('admin.branch_showcase_items.create', $this->formData());
    }

    public function store(Request $request)
    {
        $this->authorize('admin_settings');

        BranchShowcaseItem::create($this->validatedData($request));

        return redirect(getAdminPanelUrl('/branch-showcase-items'));
    }

    public function edit($id)
    {
        $this->authorize('admin_settings');

        $data = $this->formData();
        $data['item'] = BranchShowcaseItem::findOrFail($id);

        return view('admin.branch_showcase_items.create', $data);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('admin_settings');

        $item = BranchShowcaseItem::findOrFail($id);
        $item->update($this->validatedData($request));

        return redirect(getAdminPanelUrl('/branch-showcase-items'));
    }

    public function delete($id)
    {
        $this->authorize('admin_settings');

        BranchShowcaseItem::findOrFail($id)->delete();

        return redirect(getAdminPanelUrl('/branch-showcase-items'));
    }

    private function formData()
    {
        return [
            'pageTitle' => trans('admin/main.showcase_slides'),
            'branches' => Branch::withoutGlobalScopes()->orderBy('id')->get(),
            'sections' => BranchShowcaseItem::sections(),
            'pages' => BranchShowcaseItem::pages(),
        ];
    }

    private function validatedData(Request $request)
    {
        $data = $request->validate([
            'branch_id' => 'required|integer|exists:branches,id',
            'section' => 'required|in:' . implode(',', array_keys(BranchShowcaseItem::sections())),
            'page' => 'required|in:' . implode(',', array_keys(BranchShowcaseItem::pages())),
            'title' => 'nullable|string|max:255',
            'image' => 'required|string',
            'link' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'status' => 'nullable',
        ]);

        $data['order'] = $data['order'] ?? 0;
        $data['status'] = $request->has('status') ? 1 : 0;

        return $data;
    }
}
