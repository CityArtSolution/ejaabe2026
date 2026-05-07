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
        $restrictedBranchId = $this->restrictedBranchId();

        if (!empty($restrictedBranchId)) {
            $query->where('branch_id', $restrictedBranchId);
        } elseif ($request->filled('branch_id')) {
            $query->where('branch_id', $request->get('branch_id'));
        }

        if ($request->filled('section')) {
            $query->where('section', $request->get('section'));
        }

        $data = [
            'pageTitle' => trans('admin/main.showcase_slides'),
            'items' => $query->paginate(20),
            'branches' => $this->availableBranches(),
            'sections' => BranchShowcaseItem::sections(),
            'pages' => BranchShowcaseItem::pages(),
            'restrictedBranchId' => $restrictedBranchId,
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
        $data['item'] = $this->findItemForAccess($id);

        return view('admin.branch_showcase_items.create', $data);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('admin_settings');

        $item = $this->findItemForAccess($id);
        $item->update($this->validatedData($request));

        return redirect(getAdminPanelUrl('/branch-showcase-items'));
    }

    public function delete($id)
    {
        $this->authorize('admin_settings');

        $this->findItemForAccess($id)->delete();

        return redirect(getAdminPanelUrl('/branch-showcase-items'));
    }

    private function formData()
    {
        return [
            'pageTitle' => trans('admin/main.showcase_slides'),
            'branches' => $this->availableBranches(),
            'sections' => BranchShowcaseItem::sections(),
            'pages' => BranchShowcaseItem::pages(),
            'restrictedBranchId' => $this->restrictedBranchId(),
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

        $restrictedBranchId = $this->restrictedBranchId();
        if (!empty($restrictedBranchId)) {
            $data['branch_id'] = $restrictedBranchId;
        }

        $data['order'] = $data['order'] ?? 0;
        $data['status'] = $request->has('status') ? 1 : 0;

        return $data;
    }

    private function restrictedBranchId()
    {
        $user = auth()->user();

        if (!empty($user) and method_exists($user, 'isCanadaBranch') and $user->isCanadaBranch()) {
            return Branch::withoutGlobalScopes()->where('subdomain', 'canada')->value('id') ?? $user->branch_id ?? 3;
        }

        return null;
    }

    private function availableBranches()
    {
        $query = Branch::withoutGlobalScopes()->orderBy('id');
        $restrictedBranchId = $this->restrictedBranchId();

        if (!empty($restrictedBranchId)) {
            $query->where('id', $restrictedBranchId);
        }

        return $query->get();
    }

    private function findItemForAccess($id)
    {
        $query = BranchShowcaseItem::query();
        $restrictedBranchId = $this->restrictedBranchId();

        if (!empty($restrictedBranchId)) {
            $query->where('branch_id', $restrictedBranchId);
        }

        return $query->findOrFail($id);
    }
}
