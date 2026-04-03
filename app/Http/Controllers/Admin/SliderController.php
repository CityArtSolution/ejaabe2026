<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Translation\SliderTranslation;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        removeContentLocale();

        $sliders = Slider::byBranch()->where('status', 1)->get();
        
        
        return view('admin.slider.lists', compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }
    public function store_old(Request $request)
    {
        $validated = $request->validate([
            'title.en' => 'required|string',
            'title.ar' => 'required|string',
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
            'image' => 'required|mimes:jpeg,png',
            'button1_title.en' => 'nullable|string',
            'button1_title.ar' => 'nullable|string',
            'button1_link.en' => 'nullable|string',
            'button1_link.ar' => 'nullable|string',
            'button2_title.en' => 'nullable|string',
            'button2_title.ar' => 'nullable|string',
            'button2_link.en' => 'nullable|string',
            'button2_link.ar' => 'nullable|string',
        ]);

        Slider::create([
            'title' => [
                'en' => $validated['title']['en'],
                'ar' => $validated['title']['ar']
            ],
            'description' => [
                'en' => $validated['description']['en'] ?? null,
                'ar' => $validated['description']['ar'] ?? null
            ],
            'image' => $validated['image'],
            'button1_title' => [
                'en' => $validated['button1_title']['en'] ?? null,
                'ar' => $validated['button1_title']['ar'] ?? null
            ],
            'button1_link' => [
                'en' => $validated['button1_link']['en'] ?? null,
                'ar' => $validated['button1_link']['ar'] ?? null
            ],
            'button2_title' => [
                'en' => $validated['button2_title']['en'] ?? null,
                'ar' => $validated['button2_title']['ar'] ?? null
            ],
            'button2_link' => [
                'en' => $validated['button2_link']['en'] ?? null,
                'ar' => $validated['button2_link']['ar'] ?? null
            ],
        ]);

        return redirect()->route('listslides')->with('success', 'Slider created successfully');
    }

    public function edit(Request $request, $post_id)
    {
        $this->authorize('admin_blog_edit');

        $slider= Slider::findOrFail($post_id);

        $locale = $request->get('locale', app()->getLocale());

        //dd( $slider->getTable() );
        storeContentLocale($locale, $slider->getTable(), $slider->id);


        $data = [
            'pageTitle' => trans('admin/pages/blog.create_slider'),
             'slider' => $slider,
        ];

        return view('admin.slider.create', $data);
    }


    public function store(Request $request)
{
    //$this->authorize('admin_slider_create');
    //dd(\Schema::getColumnListing('sliders')); // This will show all columns in the table
    $this->validate($request, [
        'title'=> 'required|string',
        'image'=> 'required|string',
        'button1_title'=> 'nullable|string|max:255',
        'button2_title'=> 'nullable|string|max:255',
        'button1_link'=> 'nullable|string|max:255',
        'button2_link'=> 'nullable|string|max:255',
        'description'=> 'nullable|string|max:500',
        'status'=>'nullable'
    ]);
      $data = $request->all();

    try {
       // \DB::beginTransaction();

       $slider = Slider::create([
        'title' => $data['title'],
        'description' => $data['description'],
        'image' => $data['image'],
        'button1_title' => $data['button1_title'],
        'button1_link' => $data['button1_link'],
        'button2_title' => $data['button2_title'],
        'button2_link' => $data['button2_link'],
        'status' => $request->status ? 1 : 0,
    ]);
       /* $slider = new Slider();
        $slider->title = $data['title'];
        $slider->description = $data['description'];
        $slider->image = $data['image'];
        $slider->button1_title = $data['button1_title'];
        $slider->button1_link = $data['button1_link'];
        $slider->button2_title = $data['button2_title'];
        $slider->button2_link = $data['button2_link'];
        $slider->status = ($data['status'] == 'on') ? 1 : 0;
       *
        $slider->save();
        */
        if ($slider) {
            SliderTranslation::updateOrCreate([
                'slider_id' => $slider->id,
                'locale' => mb_strtolower($data['locale']),
            ], [
                'title' => $data['title'],
                'description' => $data['description'],
                'button1_title' => $data['button1_title'],
                'button2_title' => $data['button2_title'],
                'button1_link' => $data['button1_link'],
                'button2_link' => $data['button2_link'],
    
    
            ]);
    
         
        }
        removeContentLocale();

        //\DB::commit();
        return redirect()->route('listslides')->with('success', 'Slider created successfully');
    } catch (\Exception $e) {
       // \DB::rollBack();
        //dd($e->getMessage());
        \Log::error('Slider Creation Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error creating slider: ' . $e->getMessage());
    }
   


   
    

    return redirect(getAdminPanelUrl().'/sliders');
}


    public function update(Request $request, $post_id)
    {

        $this->validate($request, [
            'title'=> 'required|string',
            'image'=> 'required|string',
            'button1_title'=> 'nullable|string|max:255',
            'button2_title'=> 'nullable|string|max:255',
            'button1_link'=> 'nullable|string|max:255',
            'button2_link'=> 'nullable|string|max:255',
            'description'=> 'nullable|string|max:500',
            'status'=>'nullable'
        ]);
    
        $data = $request->all();

        $slider = Slider::findOrFail($post_id);

// dd( $data  );
       $slider->update([
          
            'status' => $request->status ? 1 : 0,
            'image' => $data['image'],
            'updated_at'=>time()

            
        ]);

        if ($slider) {
            // First, find the specific translation
            $translation = SliderTranslation::where('slider_id', $slider->id)
                ->where('locale', mb_strtolower($data['locale']))
                ->first();
                
            
             // dd($translation->id);
            if ($translation) {
                // If translation exists, update it
                $translation->update([
                    
                     'title' =>$data['title'],
                    'description' =>$data['description'],
                    'button1_title' => $data['button1_title'],
                    'button2_title' => $data['button2_title'],
                    'button1_link' => $data['button1_link'],
                    'button2_link' => $data['button2_link'],
                ]);

              
            } else {
            
                // If translation doesn't exist, create new
                SliderTranslation::create([
                    'slider_id' => $slider->id,
                    'locale' => mb_strtolower($data['locale']),
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'button1_title' => $data['button1_title'],
                    'button2_title' => $data['button2_title'],
                    'button1_link' => $data['button1_link'],
                    'button2_link' => $data['button2_link'],
                ]);
            }
        }

       
    
            removeContentLocale();

        

        return redirect()->route('listslides')->with('success', 'Slider created successfully');
    }

    public function delete($slider_id)
    {
        $this->authorize('admin_blog_delete');

        $slider = Slider::findOrFail($slider_id);

        if($slider){

            SliderTranslation::where('slider_id',$slider_id)->delete();

            $slider->delete();
        }
       

        return redirect(getAdminPanelUrl().'/slider');
    }


}