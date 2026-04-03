<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvalCategory;
use App\Models\Translation\EvalCategoryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EvalCategoriesController extends Controller
{
    public function index()
    {
       // $this->authorize('admin_blog_categories');
        removeContentLocale();

        $evalCategories = EvalCategory::get();

        $data = [
            'pageTitle' => trans('admin/pages/blog.blog_categories'),
            'evalCategories' => $evalCategories
        ];

        return view('admin.eval.categories', $data);
    }


    public function store(Request $request)
    {
        $data = $request->get('ajax');

        $rules = [
            'quiz_id' => 'required|exists:quizzes,id',
            'title' => 'required',
             
        ];

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json([
                'code' => 422,
                'errors' => $validate->errors()
            ], 422);
        }

          

        $category = EvalCategory::create([
            'slug' => EvalCategory::makeSlug($data['title']),
            'quiz_id'=> $data['quiz_id']
        ]);

        EvalCategoryTranslation::query()->updateOrCreate([
            'eval_category_id' => $category->id,
            'locale' => mb_strtolower($data['locale']),
        ], [
            'title' => $data['title'],
        ]);


        if (!empty($category)) {
           
            return response()->json([
                'code' => 200
            ], 200);
        }

        return response()->json([
            'code' => 422
        ], 422);
    }
    

    

    public function update(Request $request, $category_id)
    {
        
        
         $data = $request->get('ajax');

        $rules = [
            'quiz_id' => 'required|exists:quizzes,id',
            'title' => 'required',
             
        ];

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json([
                'code' => 422,
                'errors' => $validate->errors()
            ], 422);
        }
       $category = EvalCategory::findOrFail($category_id);

       // $data = $request->all();
        

        EvalCategoryTranslation::query()->updateOrCreate([
            'eval_category_id' => $category->id,
            'locale' => mb_strtolower($data['locale']),
        ], [
            'title' => $data['title'],
        ]);


        if (!empty($category)) {
           
            return response()->json([
                'code' => 200
            ], 200);
        }

        return response()->json([
            'code' => 422
        ], 422);
        
        
        
        
    }

    public function destroy($category_id)
    {
       // EvalCategoryTranslation::where('eval_category_id',$category_id)->delete();
         EvalCategory::where('id', $category_id)
            ->delete();

        return redirect()->back();
    }
}
