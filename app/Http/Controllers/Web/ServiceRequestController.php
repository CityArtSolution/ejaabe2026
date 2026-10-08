<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    private function titles()
    {
        return app()->getLocale() === 'ar'
            ? [
                'consulting' => 'طلب استشارة',
                'content_development' => 'طلب خدمات تطوير المحتوى',
                'quotation' => 'طلب عرض سعر',
            ]
            : [
                'consulting' => 'Request a consultation',
                'content_development' => 'Request content development services',
                'quotation' => 'Request a quotation',
            ];
    }

    public function create($requestType)
    {
        $titles = $this->titles();

        abort_unless(isset($titles[$requestType]), 404);

        $actions = [
            'consulting' => 'store_request_consulting',
            'content_development' => 'store_request_content_development',
            'quotation' => 'store_request_quotation',
        ];

        return view(getTemplate() . '.pages.service_request', [
            'pageTitle' => $titles[$requestType],
            'requestType' => $requestType,
            'formAction' => route($actions[$requestType]),
        ]);
    }

    public function store(Request $request, $requestType)
    {
        abort_unless(isset($this->titles()[$requestType]), 404);

        $ar = app()->getLocale() === 'ar';

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => [
                'required',
                'string',
                'min:10',
                'max:30',
                'regex:/^[0-9\s\-+()]+$/',
            ],
            'company' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:10000'],
        ], [], [
            'name' => $ar ? 'الاسم' : 'Name',
            'email' => $ar ? 'البريد الإلكتروني' : 'Email',
            'phone' => $ar ? 'رقم الهاتف' : 'Phone',
            'company' => $ar ? 'الجهة أو الشركة' : 'Organization or company',
            'description' => $ar ? 'تفاصيل الطلب' : 'Request details',
        ]);

        // نوع الطلب يتحدد من الـ route، وليس من مدخلات المستخدم.
        $data['type'] = $requestType;
        $data['branch_id'] = session('branch_id') ?? 1;

        try {
            ServiceRequest::create($data);
        } catch (\Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $ar
                    ? 'تعذر إرسال الطلب. حاول مرة أخرى.'
                    : 'Unable to submit your request. Please try again.');
        }

        return back()->with('success', $ar
            ? 'تم إرسال طلبك بنجاح.'
            : 'Your request has been submitted successfully.');
    }
}