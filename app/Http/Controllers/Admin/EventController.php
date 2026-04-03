<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Translation\EventTranslation;
use Illuminate\Http\Request;

class EventController extends Controller
{
    
    public function index(Request $request)
    {
                removeContentLocale();


        $this->authorize('admin_categories_list');

        $events = Event::byBranch()->orderBy('id', 'desc')->paginate(10);      
            

        $data = [
            'pageTitle' => trans('events.events'),
            'events' => $events
        ];

        return view('admin.events.lists', $data);
    }
    
        public function create()
    {
        
        $this->authorize('admin_categories_create');
    removeContentLocale();


        $data = [
            'pageTitle' => trans('events.events'),
        ];

        return view('admin.events.create', $data);
    }

      public function edit(Request $request, $id)
    {
        $this->authorize('admin_categories_edit');

        $event = Event::findOrFail($id);
      // dd($event->what_you_will_learn);

        $locale = $request->get('locale', app()->getLocale());
        storeContentLocale($locale, $event->getTable(), $event->id);
    removeContentLocale();

        $data = [
            'pageTitle' => trans('events.events'),
            'event' => $event,
        ];

        return view('admin.events.create', $data);
    }
    
    public function validateEvent(Request $request)
    {
         return $request->validate([
        'title' => 'string|max:255',
        'location' => 'string|max:255',
        'what_you_will_learn' => 'nullable|array|min:1',
        'what_you_will_learn.*' => 'nullable|string|max:255',
        'event_content' => 'nullable|array|min:1',
        'event_content.*' => 'nullable|string|max:255',
        'details' => 'nullable',
        
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'time' => 'required|date_format:H:i',
        'price' => 'nullable|numeric|min:0',
        'status' => 'required|boolean',
        'locale'=>'string'
        
    ]);
        
    }
    
        public function store(Request $request)
{
           $this->validate($request, [
        'title' => 'string|max:255',
        'location' => 'string|max:255',
        'what_you_will_learn' => 'nullable|array|min:1',
        'what_you_will_learn.*' => 'nullable|string|max:255',
        'event_content' => 'nullable|array|min:1',
        'event_content.*' => 'nullable|string|max:255',
        'details' => 'nullable',
        
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'time' => 'required|date_format:H:i',
        'price' => 'nullable|numeric|min:0',
        'status' => 'required|boolean',
        'locale'=>'string'
        ]);
//dd($data);
        $data = $request->all();
$data['what_you_will_learn']=json_encode($data['what_you_will_learn']);
$data['event_content']=json_encode($data['event_content']);

    $event = Event::create([
            'title' => $data['title'],
            'location' => $data['location'],
            'event_content' => $data['event_content'],
            'details' => $data['details'],
            'what_you_will_learn' => $data['what_you_will_learn'],
            'start_date' => $data['start_date'] ?? "",
            'end_date' => $data['end_date'] ?? "",
            'time' => $data['time'] ?? "",
            'price' => $data['price'] ?? "",
            'image' => $data['image'] ?? "",
            'link' => $data['link'] ?? "",
            'number_of_places' => $data['number_of_places'] ?? 0,

            'status' => $data['status'] ??  0

        ]);



        EventTranslation::updateOrCreate([
            'event_id' => $event->id,
            'locale' => mb_strtolower($data['locale']),
        ], [
            'title' => $data['title'],
            'location' => $data['location'],
          'what_you_will_learn' => $data['what_you_will_learn'],
          'event_content' => $data['event_content'],
          'details' => $data['details'],


        ]);

    

        removeContentLocale();

        return redirect(getAdminPanelUrl() . '/events');
    
}

 public function update(Request $request, $id)
    {
        $this->authorize('admin_categories_edit');

        $event = Event::findOrFail($id);
        
        
          $this->validate($request, [
        'title' => 'string|max:255',
        'location' => 'string|max:255',
        'what_you_will_learn' => 'nullable|array|min:1',
        'what_you_will_learn.*' => 'nullable|string|max:255',
        'event_content' => 'nullable|array|min:1',
        'event_content.*' => 'nullable|string|max:255',
        'details' => 'nullable',
        
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'nullable|date|after_or_equal:start_date',
       
        'price' => 'nullable|numeric|min:0',
        'status' => 'required|boolean',
        'locale'=>'string'
        ]);
//dd($data);
        $data = $request->all();
$data['what_you_will_learn']=json_encode($data['what_you_will_learn']);
$event_content=json_encode($data['event_content']);
//dd($event_content);
    $event->update([
           // 'title' => $data['title'],
            'location' => $data['location'],
           // 'event_content' => $data['event_content'],
          //  'details' => $data['details'],
            //'what_you_will_learn' => $data['what_you_will_learn'],
            'start_date' => $data['start_date'] ?? "",
            'end_date' => $data['end_date'] ?? "",
            'time' => $data['time'] ?? "",
            'price' => $data['price'] ?? "",
            'image' => $data['image'] ?? "",
            'link' => $data['link'] ?? "",
            'number_of_places' => $data['number_of_places'] ?? 0,

            'status' => $data['status'] ??  0

        ]);



        EventTranslation::updateOrCreate([
            'event_id' => $event->id,
            'locale' => mb_strtolower($data['locale']),
        ], [
            'title' => $data['title'],
            'location' => $data['location'],
          'what_you_will_learn' => $data['what_you_will_learn'],
          'event_content' =>$event_content,
          'details' => $data['details'],


        ]);

    

       

    removeContentLocale();

        return redirect(getAdminPanelUrl() . '/events');
        
        
    }
    
        public function destroy(Request $request, $id)
    {
        $this->authorize('admin_categories_delete');

        $event = Event::where('id', $id)->first();
//dd( $event);
        if (!empty($event)) {
            $event->delete();
           
        }

     

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => !empty($event) ? trans('update.sub_category_successfully_deleted') : trans('update.category_successfully_deleted'),
            'status' => 'success'
        ];

     return redirect()->back();
    }

    
}