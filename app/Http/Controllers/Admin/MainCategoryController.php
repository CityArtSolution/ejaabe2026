<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\Translation\MainCategoryTranslation;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    public function index()
    {
        removeContentLocale();

        $this->authorize('admin_categories_list');

        $categories = MainCategory::where('parent_id', null)
            ->with([
                'subCategories'
            ])
            ->orderBy('id', 'desc')
            ->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/categories.categories_list_page_title').'  الرئيسية ',
            'categories' => $categories
        ];

// dd($categories);
        return view('admin.maincategories.lists', $data);
    }

    public function create()
    {
        $this->authorize('admin_categories_create');


        $data = [
            'pageTitle' => trans('admin/main.category_new_page_title'),
        ];

        return view('admin.maincategories.create', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('admin_categories_create');

        $this->validate($request, [
            'title' => 'required|min:3|max:128',
            'slug' => 'nullable|max:255|unique:maincategories,slug',
        ]);

        $data = $request->all();

        if (!empty($data['order'])) {
            $order = $data['order'];
        } else {
            $order = MainCategory::whereNull('parent_id')->count() + 1;
        }

        $category = MainCategory::create([
            'slug' => $data['slug'] ?? MainCategory::makeSlug($data['title']),
            'icon' => !empty($data['icon']) ? $data['icon'] : null,
            'order' => $order,
        ]);

        MainCategoryTranslation::updateOrCreate([
            'main_category_id' => $category->id,
            'locale' => mb_strtolower($data['locale']),
        ], [
            'title' => $data['title'],
        ]);

        $hasSubCategories = (!empty($request->get('has_sub')) and $request->get('has_sub') == 'on');
        $this->setSubCategory($category, $request->get('sub_categories'), $hasSubCategories, $data['locale']);

        cache()->forget(MainCategory::$cacheKey);

        removeContentLocale();

        return redirect(getAdminPanelUrl() . '/maincategories');
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('admin_categories_edit');

        $category = MainCategory::findOrFail($id);
        $subCategories = MainCategory::where('parent_id', $category->id)
            ->orderBy('order', 'asc')
            ->get();

        $locale = $request->get('locale', app()->getLocale());
        storeContentLocale($locale, $category->getTable(), $category->id);

        $data = [
            'pageTitle' => trans('admin/pages/maincategories.edit_page_title'),
            'category' => $category,
            'subCategories' => $subCategories
        ];

        return view('admin.maincategories.create', $data);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('admin_categories_edit');

        $category = MainCategory::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|min:3|max:255',
            'slug' => 'nullable|max:255|unique:categories,slug,' . $category->id,
        ]);

        $data = $request->all();

        $category->update([
            'icon' => !empty($data['icon']) ? $data['icon'] : null,
            'slug' => $data['slug'] ?? MainCategory::makeSlug($data['title']),
            'order' => $data['order'] ?? $category->order,
        ]);

        MainCategoryTranslation::updateOrCreate([
            'main_category_id' => $category->id,
            'locale' => mb_strtolower($data['locale']),
        ], [
            'title' => $data['title'],
        ]);

        $hasSubCategories = (!empty($request->get('has_sub')) and $request->get('has_sub') == 'on');
        $this->setSubCategory($category, $request->get('sub_categories'), $hasSubCategories, $data['locale']);


        cache()->forget(MainCategory::$cacheKey);

        removeContentLocale();

        return redirect(getAdminPanelUrl() . '/maincategories');
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('admin_categories_delete');

        $category = MainCategory::where('id', $id)->first();
        $parent = !empty($category->parent_id) ? $category->parent_id : null;

        if (!empty($category)) {
            MainCategory::where('parent_id', $category->id)
                ->delete();

            $category->delete();
        }

        cache()->forget(MainCategory::$cacheKey);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => !empty($parent) ? trans('update.sub_category_successfully_deleted') : trans('update.category_successfully_deleted'),
            'status' => 'success'
        ];

        return !empty($parent) ? back()->with(['toast' => $toastData]) : redirect(getAdminPanelUrl() . '/maincategories')->with(['toast' => $toastData]);
    }

    public function search(Request $request)
    {
        $term = $request->get('term');

        $option = $request->get('option', null);

        $query = MainCategory::select('id')
            ->whereTranslationLike('title', "%$term%");

        /*if (!empty($option)) {

        }*/

        $categories = $query->get();

        return response()->json($categories, 200);
    }

    public function setSubCategory(MainCategory $category, $subCategories, $hasSubCategories, $locale)
    {
        $order = 1;
        $oldIds = [];

        if ($hasSubCategories and !empty($subCategories) and count($subCategories)) {
            foreach ($subCategories as $key => $subCategory) {
                $check = MainCategory::where('id', $key)->first();

                if (is_numeric($key)) {
                    $oldIds[] = $key;
                }

                if (!empty($subCategory['title'])) {
                    $checkSlug = 0;
                    if (!empty($subCategory['slug'])) {
                        $checkSlug = MainCategory::query()->where('slug', $subCategory['slug'])->count();
                    }

                    $slug = (!empty($subCategory['slug']) and ($checkSlug == 0 or ($checkSlug == 1 and $check->slug == $subCategory['slug']))) ? $subCategory['slug'] : MainCategory::makeSlug($subCategory['title']);

                    if (!empty($check)) {
                        $check->update([
                            'order' => $order,
                            'icon' => $subCategory['icon'] ?? null,
                            'slug' => $slug,
                        ]);

                        MainCategoryTranslation::updateOrCreate([
                            'main_category_id' => $check->id,
                            'locale' => mb_strtolower($locale),
                        ], [
                            'title' => $subCategory['title'],
                        ]);
                    } else {

                        $new = MainCategory::create([
                            'parent_id' => $category->id,
                            'slug' => $slug,
                            'icon' => $subCategory['icon'] ?? null,
                            'order' => $order,
                        ]);

                        MainCategoryTranslation::updateOrCreate([
                            'main_category_id' => $new->id,
                            'locale' => mb_strtolower($locale),
                        ], [
                            'title' => $subCategory['title'],
                        ]);

                        $oldIds[] = $new->id;
                    }

                    $order += 1;
                }
            }
        }

        MainCategory::where('parent_id', $category->id)
            ->whereNotIn('id', $oldIds)
            ->delete();

        return true;
    }
}
