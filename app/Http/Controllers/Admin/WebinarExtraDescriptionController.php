<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation\WebinarExtraDescriptionTranslation;
use App\Models\UpcomingCourse;
use App\Models\Webinar;
use App\Models\WebinarExtraDescription;
use Illuminate\Http\Request;

class WebinarExtraDescriptionController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('admin_webinars_edit');

        $this->validate($request, [
            //'type' => 'required|in:' . implode(',', WebinarExtraDescription::$types),
            'value' => 'required',
            'attached'=>'file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:6048'
        ]);
        
        

        $data = $request->all();
        if(empty($data['type'])){
            $data['type']='learning_materials';
            
        }

        if (empty($data['locale'])) {
            $data['locale'] = getDefaultLocale();
        }

        $creator = $this->getCreator($data);

        if (!empty($creator)) {
            $columnName = !empty($data['webinar_id']) ? 'webinar_id' : 'upcoming_course_id';
            $columnValue = !empty($data['webinar_id']) ? $data['webinar_id'] : $data['upcoming_course_id'];

            $order = WebinarExtraDescription::query()->where('creator_id', $creator->id)
                    ->where($columnName, $columnValue)
                    ->where('type', $data['type'])
                    ->count() + 1;
       $filePath="";
             if ($request->hasFile('attached')) {
        $file = $request->file('attached');
        $originalName = $file->getClientOriginalName();
        $filePath = public_path('store/' . $originalName);
        
        // If file already exists, add timestamp to filename
        if (file_exists($filePath)) {
            $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileName = $nameWithoutExtension . '_' . time() . '.' . $extension;
        } else {
            $fileName = $originalName;
        }
        
        // Store in public/store directory
        $file->move(public_path('store'), $fileName);
        
        // If you need to save the file path in database
        $filePath = 'store/' . $fileName;
             }
            $webinarExtraDescription = WebinarExtraDescription::create([
                'creator_id' => $creator->id,
                'webinar_id' => !empty($data['webinar_id']) ? $data['webinar_id'] : null,
                'upcoming_course_id' => !empty($data['upcoming_course_id']) ? $data['upcoming_course_id'] : null,
                'type' => $data['type'],
                'order' => $order,
                'link'=>$data['link']?? "",
                'attached'=>$filePath ?? NULL,
                'created_at' => time()
            ]);

            if (!empty($webinarExtraDescription)) {
                WebinarExtraDescriptionTranslation::updateOrCreate([
                    'webinar_extra_description_id' => $webinarExtraDescription->id,
                    'locale' => mb_strtolower($data['locale']),
                ], [
                    'value' => $data['value'],
                ]);
            }
        }
        //return redirect()->back();

        return response()->json([
            'code' => 200,
        ], 200);
    }

    private function getCreator($data)
    {
        $creator = false;

        if (!empty($data['webinar_id'])) {
            $webinar = Webinar::findOrFail($data['webinar_id']);

            $creator = $webinar->creator;
        } elseif (!empty($data['upcoming_course_id'])) {
            $upcomingCourse = UpcomingCourse::findOrFail($data['upcoming_course_id']);

            $creator = $upcomingCourse->creator;
        }

        return $creator;
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');

        $webinarExtraDescription = WebinarExtraDescription::find($id);

        if (!empty($webinarExtraDescription)) {
            $locale = $request->get('locale', app()->getLocale());
            if (empty($locale)) {
                $locale = app()->getLocale();
            }
            storeContentLocale($locale, $webinarExtraDescription->getTable(), $webinarExtraDescription->id);

            $webinarExtraDescription->value = $webinarExtraDescription->getValueAttribute();
            $webinarExtraDescription->locale = mb_strtoupper($locale);



  $data = [
        'webinarExtraDescription' => [
            'id' => $webinarExtraDescription->id,
            'value' => $webinarExtraDescription->value,
            'link' => $webinarExtraDescription->link,
            'attached' => $webinarExtraDescription->attached,
            'locale' => $webinarExtraDescription->locale ?? app()->getLocale(),
            // Add any other fields you need
        ]
    ];
    
    
        return response()->json($data);

         /*   return response()->json([
                'webinarExtraDescription' => $webinarExtraDescription
            ], 200);
            
            */
        }

        return response()->json([], 422);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');

        $this->validate($request, [
           // 'type' => 'required|in:' . implode(',', WebinarExtraDescription::$types),
            'value' => 'required',
            'attached'=>'file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:6048'
        ]);

        $data = $request->all();
if(empty($data['type'])){
            $data['type']='learning_materials';
            
        }

        if (empty($data['locale'])) {
            $data['locale'] = getDefaultLocale();
        }

        $webinarExtraDescription = WebinarExtraDescription::find($id);
       $filePath="";
        if ($webinarExtraDescription) {
            
            
             if ($request->hasFile('attached')) {
        $file = $request->file('attached');
        $originalName = $file->getClientOriginalName();
        $filePath = public_path('store/' . $originalName);
        
        // If file already exists, add timestamp to filename
        if (file_exists($filePath)) {
            $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileName = $nameWithoutExtension . '_' . time() . '.' . $extension;
        } else {
            $fileName = $originalName;
        }
        
        // Store in public/store directory
        $file->move(public_path('store'), $fileName);
        
        // If you need to save the file path in database
        $filePath = 'store/' . $fileName;
             }
            
            
            $webinarExtraDescription->link=$data['link'] ?? NULL;
             $webinarExtraDescription->attached=$filePath  ?? NULL;
            $webinarExtraDescription->save();

            WebinarExtraDescriptionTranslation::updateOrCreate([
                'webinar_extra_description_id' => $webinarExtraDescription->id,
                'locale' => mb_strtolower($data['locale']),
            ], [
                'value' => $data['value'],
                
            ]);
        }
     //   return redirect()->back();

        return response()->json([
            'code' => 200,
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');

        WebinarExtraDescription::find($id)->delete();

        return redirect()->back();
    }
    
    public function deleteAttachment(Request $request)
{
    try {
        $id = $request->input('id');
        $fileName = $request->input('file');
        
        // Get your model instance
        $item = WebinarExtraDescription::findOrFail($id);
        
        // Delete file from storage
        $filePath = public_path('store/' . $fileName);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        // Update database record
        $item->update(['attached' => null]);
        
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}
}
