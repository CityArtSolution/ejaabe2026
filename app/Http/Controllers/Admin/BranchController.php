<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Translation\BranchTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BranchController extends Controller
{
    const ADMIN_SELECTED_BRANCH = 'admin_selected_branch';

    public function index()
    {
        removeContentLocale();

        $this->authorize('admin_categories_list');

        $branches = Branch::orderBy('id', 'desc')->paginate(10);


        $data = [
            'pageTitle' => trans('admin/pages/branches.branches_list_page_title'),
            'branches' => $branches
        ];

        return view('admin.branches.lists', $data);
    }

    public function create()
    {
        $this->authorize('admin_categories_create');


        $data = [
            'pageTitle' => trans('admin/main.branch_new_page_title'),
        ];

        return view('admin.branches.create', $data);
    }
    public function edit(Request $request, $id)
    {
        $this->authorize('admin_categories_edit');

        $branch = Branch::findOrFail($id);


        $locale = $request->get('locale', app()->getLocale());
        storeContentLocale($locale, $branch->getTable(), $branch->id);

        $data = [
            'pageTitle' => trans('admin/pages/categories.edit_page_title'),
            'branch' => $branch,
        ];

        return view('admin.branches.create', $data);
    }


    public function store(Request $request)
    {
        // Check for observers
//        dd(\DB::select('SHOW COLUMNS FROM branch_translations'));
//        dd(\Event::getListeners('eloquent.creating: App\Models\Branch'));
//        dd(\DB::select('SHOW COLUMNS FROM branches'));
//        dd($request->all());
        $this->authorize('admin_categories_create');

        $this->validate($request, [
            'name' => 'required|min:3|max:128',
            'subdomain' => 'nullable|max:255|unique:branches,subdomain',
            'status' => 'boolean',
            'email'=>'email'

        ]);

        $data = $request->all();

//        dd($data,$request,$data['name']);

//dd( $data);

        $branch = Branch::create([

            'slug' => Str::slug($data['name']),
            'address' => $data['address'],
            'subdomain' => $data['subdomain'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'currency' => $data['currency'] ?? "",
            'location' => $data['location'] ?? "",
            'home_page' => $data['home_page'] ?? "",
            'status' => $data['status'] ??  0,



        ]);

//        $branch = new Branch();
// Force these into the main table attributes
//        $branch->fill([
//            'slug' => Str::slug($data['name']),
//            'address' => $data['address'],
//            'subdomain' => $data['subdomain'],
//            'phone_number' => $data['phone_number'],
//            'email' => $data['email'],
//            'currency' => $data['currency'] ?? "",
//            'location' => $data['location'] ?? "",
//            'home_page' => $data['home_page'] ?? "",
//            'status' => $data['status'] ??  0,
//            $data['locale'] => [          // ← Astrotomic way to save translations
//                'name'    => $data['name'],
//                'address' => $data['address'],
//            ],
//        ]);
//        $branch->save();
//

        BranchTranslation::updateOrCreate([
            'branch_id' => $branch->id,
            'locale' => mb_strtolower($data['locale']),
        ], [
            'name' => $data['name'],
            'address' => $data['address'],

        ]);


        cache()->forget(branch::$cacheKey);

        removeContentLocale();

        return redirect(getAdminPanelUrl() . '/branches');
    }


    public function update(Request $request, $id)
    {
        $this->authorize('admin_categories_edit');

        $branch = Branch::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|min:3|max:128',
            'subdomain' => [
                'nullable',
                'max:255',
                function ($attribute, $value, $fail) use ($branch,$id) {
                    // Check if the subdomain is already taken by another branch
                    if ($value && Branch::where('subdomain', $value)->where('id', '!=', $id)->exists()) {
                        $fail('هذا السب دومين محجوز لاحد الفروع.');
                    }
                },
            ],
            'status' => 'boolean',
            'email'=>'email'
        ]);

        $data = $request->all();

        $branch->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'subdomain' => $data['subdomain'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'currency' => $data['currency'] ?? "",
            'location' => $data['location'] ?? "",
            'home_page' => $data['home_page'] ?? "",
            'status' => $data['status'] ??  0,
        ]);

        BranchTranslation::updateOrCreate([
            'branch_id' => $branch->id,
            'locale' => mb_strtolower($data['locale']),
        ], [
            'name' => $data['name'],
            'address' => $data['address'],
        ]);



        cache()->forget(Branch::$cacheKey);

        removeContentLocale();

        return redirect(getAdminPanelUrl() . '/branches');
    }


    public function updateBranchSession($id)
    {
        $branch = \App\Models\Branch::find($id);

        if ($branch) {
            session()->put([self::ADMIN_SELECTED_BRANCH => $id]);
        } else {
            session()->forget(self::ADMIN_SELECTED_BRANCH);
        }

        return redirect()->back();
    }

    public function clearBranchSession()
    {
        session()->forget(self::ADMIN_SELECTED_BRANCH);
        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('admin_categories_delete');

        $branch = Branch::where('id', $id)->first();

        if (!empty($branch)) {
            $branch->delete();

        }

        cache()->forget(Branch::$cacheKey);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => !empty($branch) ? trans('update.sub_category_successfully_deleted') : trans('update.category_successfully_deleted'),
            'status' => 'success'
        ];

        return !empty($branch) ? back()->with(['toast' => $toastData]) : redirect(getAdminPanelUrl() . '/branches')->with(['toast' => $toastData]);
    }


}
