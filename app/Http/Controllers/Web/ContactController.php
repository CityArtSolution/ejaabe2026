<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contactSettings = getContactPageSettings();

        $seoSettings = getSeoMetas('contact');
        $pageTitle = !empty($seoSettings['title']) ? $seoSettings['title'] : trans('site.contact_page_title');
        $pageDescription = !empty($seoSettings['description']) ? $seoSettings['description'] : trans('site.contact_page_title');
        $pageRobot = getPageRobot('contact');

        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'pageRobot' => $pageRobot,
            'contactSettings' => $contactSettings
        ];
        
      
        return view('web.default.pages.contact', $data);
    }

    public function store(Request $request)
    {
       
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'phone' => 'required|numeric',
            'subject' => 'required|string',
            'message' => 'required|string',
           // 'captcha' => 'required|captcha',
        ]);
         

        $data = $request->all();
        unset($data['_token']);
        $data['created_at'] = time();

      Contact::create($data);

        $notifyOptions = [
            '[c.u.title]' => $data['subject'],
            '[u.name]' => $data['name'],
            '[time.date]' => dateTimeFormat(time(), 'j M Y H:i'),
            '[c.u.message]' => $data['message'],
             '[u.mobile]' => $data['phone'],
            '[u.email]' => $data['email'],

        ];
        sendNotification('contact_message_submission_for_admin', $notifyOptions, 1);


try {
        sendNotificationToEmail('contact_message_submission_for_admin', $notifyOptions, "Info@ejaabi.com");

        
    \Log::info('Contact form email sent from: ' . $data['email']);
} catch (\Exception $exception) {
    \Log::error('Contact form email failed: ' . $exception->getMessage());
}
       // dd(sendNotification('contact_message_submission_for_admin', $notifyOptions, 1));

        return back()->with(['msg' => 'Your message has been sent and you will be replied to as soon as possible.']);
    }
}
