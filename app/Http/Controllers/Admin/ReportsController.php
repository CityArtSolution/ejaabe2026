<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;
use App\Models\Setting;
use App\Models\Translation\SettingTranslation;
use App\Models\WebinarReport;
use App\Models\Webinar;
use App\Models\Sale;
use App\Models\Category;
use App\Models\WebinarReview;


use App\Models\ServiceRequest;
use App\Models\EventRegistration;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function reasons(Request $request)
    {
        $this->authorize('admin_report_reasons');

        $value = [];

        $settings = Setting::where('name', 'report_reasons')->first();

        $locale = $request->get('locale', getDefaultLocale());
        storeContentLocale($locale, $settings->getTable(), $settings->id);

        if (!empty($settings) and !empty($settings->value)) {
            $value = json_decode($settings->value, true);
        }


        $data = [
            'pageTitle' => trans('admin/pages/setting.report_reasons'),
            'value' => $value,
        ];


        return view('admin.reports.reasons', $data);
    }

    public function storeReasons(Request $request)
    {
        $this->authorize('admin_report_reasons');

        $name = 'report_reasons';

        $values = $request->get('value', null);

        if (!empty($values)) {
            $locale = $request->get('locale', getDefaultLocale());

            $values = array_filter($values, function ($val) {
                if (is_array($val)) {
                    return array_filter($val);
                } else {
                    return !empty($val);
                }
            });

            $values = json_encode($values);
            $values = str_replace('record', rand(1, 600), $values);

            $settings = Setting::updateOrCreate(
                ['name' => $name],
                [
                    'updated_at' => time(),
                ]
            );

            SettingTranslation::updateOrCreate(
                [
                    'setting_id' => $settings->id,
                    'locale' => mb_strtolower($locale)
                ],
                [
                    'value' => $values,
                ]
            );

            cache()->forget('settings.' . $name);
        }

        removeContentLocale();

        return back();
    }

    public function webinarsReports()
    {
        $this->authorize('admin_webinar_reports');

        $reports = WebinarReport::with(['user' => function ($query) {
            $query->select('id', 'full_name');
        }, 'webinar' => function ($query) {
            $query->select('id', 'slug');
        }])->orderBy('created_at', 'desc')
            ->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/comments.classes_reports'),
            'reports' => $reports
        ];

        return view('admin.webinars.reports', $data);
    }

    public function delete($id)
    {
        $this->authorize('admin_webinar_reports_delete');

        $report = WebinarReport::findOrFail($id);

        $report->delete();

        return redirect()->back();
    }
    
    //reports


    //courses &consulting requests
    public function show_requests(Request $request)
    {
        $query = ServiceRequest::with('webinar')
            ->whereIn('type', ['course', 'consulting'])
            ->orderBy('id', 'desc');
    
        if (session()->has('admin_selected_branch')) {
            $branchId = session()->get('admin_selected_branch') ?? 1;
            $query->whereHas('webinar', function ($q) use ($branchId){
                $q->where('branch_id', $branchId);
            });
        } elseif (session()->has('branch_id')) {
            $branchId = session()->get('branch_id') ?? 1;
            $query->whereHas('webinar', function ($q) use ($branchId){
                $q->where('branch_id', $branchId);
            });
        }
    
        if ($request->get('from')) {
            $query->whereDate('created_at', '>=', $request->get('from'));
        }
        if ($request->get('to')) {
            $query->whereDate('created_at', '<=', $request->get('to'));
        }
    
        $items = $query->paginate(10);
        
        $data = [
            'pageTitle' => trans('public.Courses & Consulting requests'),
            'items' => $items
        ];
            
        return view('admin.reports.coursesConsult', $data);
}
    
    
    //events regitrations requests
    public function events_orders(Request $request)
    {
        $query = EventRegistration::with('event')->latest();
    
        if (session()->has('admin_selected_branch')) {
            $branchId = session()->get('admin_selected_branch') ?? 1;
            $query->whereHas('event', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        } elseif (session()->has('branch_id')) {
            $branchId = session()->get('branch_id') ?? 1;
            $query->whereHas('event', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }
    
        if ($request->get('from')) {
            $query->whereDate('created_at', '>=', $request->get('from'));
        }
        if ($request->get('to')) {
            $query->whereDate('created_at', '<=', $request->get('to'));
        }
    
        $events = $query->paginate(10);
    
        $data = [
            'pageTitle' => trans('events.Events Orders'),
            'events' => $events
        ];
    
        return view('admin.reports.eventsOrders', $data);
}
    
    
    //reveune-list
    public function reveune_list(Request $request)
    {
    $startDate = $request->input('from');
    $endDate   = $request->input('to');

    $startTimestamp = $startDate ? strtotime($startDate . ' 00:00:00') : null;
    $endTimestamp   = $endDate ? strtotime($endDate . ' 23:59:59') : null;

    $query = Webinar::with(['sales' => function ($q) {
            $q->whereNull('refund_at');
        }, 'teacher'])
        ->whereHas('sales', function ($q) use ($startTimestamp, $endTimestamp) {
            $q->whereNull('refund_at');

            if ($startTimestamp && $endTimestamp) {
                $q->whereBetween('created_at', [$startTimestamp, $endTimestamp]);
            }
        });

    if (session()->has('admin_selected_branch')) {
        $branchId = session()->get('admin_selected_branch') ?? 1;
        $query->where('branch_id', $branchId);
    } elseif (session()->has('branch_id')) {
        $branchId = session()->get('branch_id') ?? 1;
        $query->where('branch_id', $branchId);
    }

    $webinars = $query->get();

    $reportData = $webinars->map(function ($webinar) {
        return [
            'webinar_title'      => $webinar->title,
            'webinar_teacher'    => optional($webinar->teacher)->full_name,
            'enrolled_students'  => $webinar->sales->pluck('buyer_id')->toArray(),
            'total_sales_amount' => $webinar->sales->sum('total_amount'),
        ];
    });

    $data = [
        'pageTitle'   => trans('public.reveune'),
        'reportData'  => $reportData
    ];

    return view('admin.reports.reveune', $data);
}

    
    public function course_statistics(Request $request)
    {
        $categoryId  = $request->input('category_id');
        $webinarType = $request->input('webinar_type');
    
        $startDate = $request->input('from');
        $endDate   = $request->input('to');
    
        $startTimestamp = $startDate ? strtotime($startDate) : null;
        $endTimestamp   = $endDate ? strtotime($endDate . ' 23:59:59') : null;
    
        // Query to get webinars with filters
        $query = Webinar::with(['category', 'sales', 'reviews'])
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->when($webinarType, function ($q) use ($webinarType) {
                $q->where('type', $webinarType);
            })
            ->when($startTimestamp && $endTimestamp, function ($q) use ($startTimestamp, $endTimestamp) {
                $q->whereBetween('created_at', [$startTimestamp, $endTimestamp]);
            });
    
        if (session()->has('admin_selected_branch')) {
            $branchId = session()->get('admin_selected_branch') ?? 1;
            $query->where('branch_id', $branchId);
        } elseif (session()->has('branch_id')) {
            $branchId = session()->get('branch_id') ?? 1;
            $query->where('branch_id', $branchId);
        }
    
        $webinars = $query->paginate(10);
    
        $reportData = $webinars->map(function ($webinar) {
            // Get enrolled students (buyers)
            $studentsIds = $webinar->sales->pluck('buyer_id')->toArray();
    
            $start_date = $webinar->start_date ? date('Y-m-d', $webinar->start_date): null;
    
            $averageRating = $webinar->reviews->avg('rates');
    
            return [
                'webinar_title'      => $webinar->title,
                'category_title'     => optional($webinar->category)->title,
                'number_of_students' => count($studentsIds),
                'start_date'         => $start_date,
                'average_rating'     => $averageRating ? round($averageRating, 2) : '',
            ];
        });
    
        $data = [
            'pageTitle'   => trans('public.course statistics'),
            'reportData'  => $reportData,
            'webinars'    => $webinars,
            'categories'  => Category::all(), // For category filter dropdown
        ];
    
        return view('admin.reports.courses_statis', $data);
}

    
    public function courses_reviews(Request $request)
    {
        // Get filters from the request (optional)
        $startDate = $request->input('from');
        $endDate = $request->input('to');
    
        // Convert date strings to timestamps if provided
        $startTimestamp = $startDate ? strtotime($startDate) : null;
        $endTimestamp = $endDate ? strtotime($endDate . ' 23:59:59') : null;
    
        // Query to get webinar reviews with filters
        $query = WebinarReview::with('webinar')
            ->when($startTimestamp && $endTimestamp, function ($q) use ($startTimestamp, $endTimestamp) {
                $q->whereBetween('created_at', [$startTimestamp, $endTimestamp]);
            });
            
        if (session()->has('admin_selected_branch')) {
            $branchId = session()->get('admin_selected_branch') ?? 1;
            $query->where('branch_id', $branchId);
        } elseif (session()->has('branch_id')) {
            $branchId = session()->get('branch_id') ?? 1;
            $query->where('branch_id', $branchId);
        }
    
        $reviews = $query->paginate(10);
        // Format the report data
        $reportData = $reviews->map(function ($review) {
            return [
                'webinar_title' => $review->webinar->title,
                'content_quality' => $review->content_quality,
                'instructor_skills' => $review->instructor_skills,
                'purchase_worth' => $review->purchase_worth,
                'support_quality' => $review->support_quality,
                'guides' => $review->guides,
                'final_rate' => $review->rates,
                'created_at' => date('Y-m-d H:i:s', $review->created_at), // Format timestamp
            ];
        });
    
        $data = [
            'pageTitle' => trans('public.courses_reviews'),
            'reportData' => $reportData,
            'reviews' => $reviews
        ];
        
        return view('admin.reports.courses_reviews', $data);
    }



}
