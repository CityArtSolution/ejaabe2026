<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mixins\Cashback\CashbackAccounting;
use App\Models\Accounting;
use App\Models\BecomeInstructor;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentChannel;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\ReserveMeeting;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Sale;
use App\Models\TicketUser;
use App\PaymentChannels\ChannelManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\XapiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
     protected $xapiService;

    public function __construct(XapiService $xapiService)
    {
        $this->xapiService = $xapiService;
    }
    
    protected $order_session_key = 'payment.order_id';

    public function paymentRequest(Request $request)
    {
        $this->validate($request, [
            'gateway' => 'required'
        ]);

        $user = auth()->user();
        // return $user;
        $gateway = $request->input('gateway');
        $orderId = $request->input('order_id');

        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->first();

        if ($order->type === Order::$meeting) {
            $orderItem = OrderItem::where('order_id', $order->id)->first();
            $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();
            $reserveMeeting->update(['locked_at' => time()]);
        }

        if ($gateway === 'credit') {

            if ($user->getAccountingCharge() < $order->total_amount) {
                $order->update(['status' => Order::$fail]);

                session()->put($this->order_session_key, $order->id);

                return redirect('/payments/status');
            }

            $order->update([
                'payment_method' => Order::$credit
            ]);

            $this->setPaymentAccounting($order, 'credit');

            $order->update([
                'status' => Order::$paid
            ]);

            session()->put($this->order_session_key, $order->id);

            return redirect('/payments/status');
        }

        if ($gateway === 'Mada') {
            $url = "https://eu-prod.oppwa.com/v1/checkouts";
          // $url = "https://eu-test.oppwa.com/v1/checkouts";
            //$accessToken = 'OGFjN2E0Yzc5Mzk0YmRjODAxOTM5NzM2ZjFhNzA2NDF8Ulh5az9pd2ZNdXprRVpRYjdFcWs=';
          // $accessToken = 'OGFjOWE0Y2M3MzkwMGUxOTAxNzM5NDA4MzFiMjI2NzR8SDlFbU5wZmViOA==';

         $entityId='8ac9a4cc73900e190173940e3eba26a0';

            $currency='SAR';
            $price=$order->total_amount;   
             $data = "entityId=$entityId" .
                        "&amount=$price" .
                        "&currency=$currency" .
                          "&integrity=true".
                        "&paymentType=DB".
                        "&integrity=true";
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
               curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization:Bearer OGFjOWE0Y2M3MzkwMGUxOTAxNzM5NDA4MzFiMjI2NzR8SDlFbU5wZmViOA=='));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
           
//$responseData = request();
           // return $responseData;
            $responseArray = json_decode($responseData, true);

            $checkout_idd = $responseArray['id'] ?? 'F46927F1016D8DE35D0FBFBB9024D90C.uat01-vm-tx04';
       // $responseData = request();
       $checkoutData['checkout_idd'] = $checkout_idd;
       $checkoutData['gateway'] = 'Mada';
       $checkoutData['order_id'] =$order->id;

       
       
       return view(getTemplate() . '.cart.mada', ['checkoutData' => $checkoutData]);

       


        }

        if ($gateway === 'CanadaET') {
        $url = "https://eu-prod.oppwa.com/v1/checkouts";
        $accessToken = 'OGFjOWE0Y2M3MzkwMGUxOTAxNzM5NDA4MzFiMjI2NzR8SDlFbU5wZmViOA==';
        $entityId = '8ac9a4cc73900e190173940dee79269a';
        $currency = 'SAR';
        $price = $order->total_amount;

        $data = http_build_query([
            'entityId' => $entityId,
            'amount' => $price,
            'currency' => $currency,
            'paymentType' => 'DB',
            'integrity' => 'true'
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization:Bearer ' . $accessToken
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $responseData = curl_exec($ch);

        if (curl_errno($ch)) {
            return back()->withErrors(['error' => 'Curl Error: ' . curl_error($ch)]);
        }
        curl_close($ch);

        $responseArray = json_decode($responseData, true);
        $checkout_idd = $responseArray['id'] ?? null;

        if (!$checkout_idd) {
            return back()->withErrors(['error' => 'Failed to get Checkout ID from gateway']);
        }

        // تجهيز بيانات الدفع
        $checkoutData = [
            'checkout_idd' => $checkout_idd,
            'gateway' => 'CanadaET',
            'order_id' => $order->id,
            'amount' => $price,
            'methods' => 'CanadaET', // استدعاء طرق الدفع
            // 'records' => $this->getDepositHistory(), // عرض سجل الدفعات السابقة
        ];

        return view('web.default.cart.canada_cart_depost', $checkoutData);
    }
if ($gateway === 'Tamara') {
    $installments = request('installments', 4); // القيمة الافتراضية 4 دفعات

    $response = Http::withHeaders([
        'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhY2NvdW50SWQiOiIyY2RhMzczMS0yZmMyLTQxNjQtYWI5Ni03NWM2ODg4NjM2MmQiLCJ0eXBlIjoibWVyY2hhbnQiLCJzYWx0IjoiNTdjMDA5OGItMDJiNy00ZDBlLTliNGItZWJlNzE3M2UwM2NmIiwicm9sZXMiOlsiUk9MRV9NRVJDSEFOVCJdLCJpc010bHMiOmZhbHNlLCJpYXQiOjE3NTA4Mjg5MzAsImlzcyI6IlRhbWFyYSBQUCJ9.ruT8UJOphhHhcX2R1J-7OT-WpWWlras2gZY6lB9VIeY5H-yvBUVker8aBr-m-a4IAh4zEqs6SBIBBWNG09Sdb_xLgF0G0NdAG1gFHFvvWtjsUO7xLPf1zM3pul4JJ-4kbO4yN-ohfM6t7DooTbhlKK0tZl560tUp6gjRuFy7BS_hIFWiBwrQ80xrYxtqPzlP5P3P7-RedjQV6F_DDBKNBTiKs0ANIzQFEN3AiYRkBH1bIau1RqPvx0N1movsLhFmQWRSozxeQjEYv-yRq075_UNaharYS5m-jjU3c10XD0X288qjq7fdk_oOrINHbJN0Bovmo5JX-7-0D6rYEkeyCA',
        'Content-Type' => 'application/json',
    ])->post('https://api.tamara.co/checkout', [
        "order_reference_id" => 'ORD-' . strtoupper(Str::random(6)) . '-' . time(),
        "order_number" => 'INV-' . strtoupper(Str::random(6)) . '-' . time(),
        "description" => "Order through Tamara instalments",
        "payment_type" => "PAY_BY_INSTALMENTS", // ✅ للدفع بالتقسيط
        "instalments" => (int) $installments,   // عدد الدفعات من الواجهة
        "total_amount" => [
            "amount" => $order->total_amount,
            "currency" => "SAR"
        ],
        "shipping_amount" => [
            "amount" => 0,
            "currency" => "SAR"
        ],
        "tax_amount" => [
            "amount" => 0,
            "currency" => "SAR"
        ],
        "country_code" => "SA",
        "consumer" => [
            "first_name" => $user->full_name,
            "last_name" => $user->full_name,
            "phone_number" => $user->mobile,
            "email" => $user->email,
            "national_id" => $user->mobile,
            "country_code" => "SA"
        ],
        "shipping_address" => [
            "first_name" => $user->full_name,
            "last_name" => $user->full_name,
            "line1" => "Riyadh street",
            "city" => "Riyadh",
            "country_code" => "SA"
        ],
        "items" => [
            [
                "name" => "Order #{$order->id}",
                "type" => "Physical",
                "reference_id" => (string) $order->id,
                "sku" => "SKU-{$order->id}",
                "quantity" => 1,
                "unit_price" => [
                    "amount" => $order->total_amount,
                    "currency" => "SAR"
                ],
                "discount_amount" => [
                    "amount" => 0,
                    "currency" => "SAR"
                ],
                "tax_amount" => [
                    "amount" => 0,
                    "currency" => "SAR"
                ],
                "total_amount" => [
                    "amount" => $order->total_amount,
                    "currency" => "SAR"
                ]
            ]
        ],
        "merchant_url" => [
            "success" => "https://demo.ejaabi.com/payment/success",
            "failure" => "https://demo.ejaabi.com/payment/fail",
            "cancel" => "https://demo.ejaabi.com/payment/cancel",
            "notification" => "https://demo.ejaabi.com/payment/webhook"
        ],
        "platform" => "Laravel",
        "is_mobile" => false,
        "locale" => "ar_SA"
    ]);

    $data = $response->json();

    if (!empty($data['checkout_url'])) {
        return redirect()->away($data['checkout_url']);
    }

    dd($data);
}



elseif($gateway === 'Bank') {
    
        $checkoutData['gateway'] = 'offline';
       $checkoutData['order_id'] =$order->id;
 //return $checkoutData;
        

       
       return view(getTemplate() . '.cart.mada', ['checkoutData' => $checkoutData]);

       
    
    
    
}
        $paymentChannel = PaymentChannel::where('id', $gateway)
            ->where('status', 'active')
            ->first();

        if (!$paymentChannel) {
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('public.channel_payment_disabled'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }

        $order->payment_method = Order::$paymentChannel;
        $order->save();


        try {
            $channelManager = ChannelManager::makeChannel($paymentChannel);
            $redirect_url = $channelManager->paymentRequest($order);

            if (in_array($paymentChannel->class_name, PaymentChannel::$gatewayIgnoreRedirect)) {
                return $redirect_url;
            }

            return Redirect::away($redirect_url);

        } catch (\Exception $exception) {
            
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }
    }
    public function confirm_payment(Request $request)
{
    
    $gateWayName=$request->input('gateway');
    $checkoutId =$request->input('id');
    $entityId="";
    $user = auth()->user();

    $orderId=$request->input('order_id');
    
    $order = Order::where('id', $orderId)
    ->where('user_id', $user->id)
    ->first();
    
    

     if($gateWayName=='Mada'){
        $entityId='8ac9a4cc73900e190173940e3eba26a0';
     }

     if($gateWayName=='Visa'){
        $entityId='8ac9a4cc73900e190173940dee79269a';
     }

$url = "https://eu-prod.oppwa.com/v1/checkouts/" . $checkoutId . "/payment";
//    $url = "https://eu-test.oppwa.com/v1/checkouts/" . $checkoutId . "/payment";

        $url .= "?entityId=$entityId";
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjOWE0Y2M3MzkwMGUxOTAxNzM5NDA4MzFiMjI2NzR8SDlFbU5wZmViOA=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // This should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

    /*
       $url = "https://eu-test.oppwa.com/v1/checkouts/" . $checkoutId . "/payment";
	$url .= "?entityId=8ac7a4c79394bdc801939736f17e063d";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'Authorization:Bearer OGFjN2E0Yzc5Mzk0YmRjODAxOTM5NzM2ZjFhNzA2NDF8Ulh5az9pd2ZNdXprRVpRYjdFcWs='));
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$responseData = curl_exec($ch);
	if(curl_errno($ch)) {
		return curl_error($ch);
	}
	curl_close($ch);
    $response = json_decode($responseData, true);
    */
    $response = json_decode($responseData, true);
    
    

    $successCodes = [
    '000.100.110',
    '000.000.000',
    '000.000.100',	
    '000.100.111',
    '000.100.112'
];
    // if (isset($response['result']) && $response['result']['code'] === '000.100.110') {

     if (isset($response['result']) && in_array($response['result']['code'], $successCodes)) {

            

        $order->update([
         'payment_method' => Order::$paymentChannel

            ]);

            $this->setPaymentAccounting($order);

            $order->update([
                'status' => Order::$paid
            ]);

            session()->put($this->order_session_key, $order->id);

       $toastData = [
                'title' =>'الدفع',
                'msg' => 'تم الدفع بنجاح',
                'status' => 'success'
            ];
            
               $course_id=$order->orderItems()->first()->webinar_id ?? "";
            $course=\App\Models\Webinar::find($course_id);
            if($course){
            $user=auth()->user();

            $agent = $_SERVER['HTTP_USER_AGENT'];

            $browserInfo = $this->xapiService->getBrowserInfo($agent);

              $params = [
                  'name' => $user->full_name,
                  'email' => $user->email,
                  'verb' => 'registered', // or any other verb
                  'course_url' => $course->getUrl(),
                  'course_nameAr' => $course->title,
                  'course_nameEn' =>$course->getTranslation('title','en')->title ?? $course->title,
                  'type' => 'https://w3id.org/xapi/cmi5/activitytype/course',
                  'browser' =>$browserInfo['browser'],
                  'version' =>$browserInfo['version'],
                  'platform' => 'EJAABI',
                  'instractor_name' =>$course->teacher->full_name,
                  'instractor_email' => $course->teacher->email,
                  'parent_url' => $course->getUrl(),
              ];
      //registred verb
              $this->xapiService->createStatement($params);
              $params = [
                  'name' => $user->full_name,
                  'email' => $user->email,
                  'verb' => 'initialized', // or any other verb
                  'course_url' => $course->getUrl(),
                  'course_nameAr' => $course->title,
                  'course_nameEn' =>$course->getTranslation('title','en')->title ?? $course->title,
                  'type' => 'https://w3id.org/xapi/cmi5/activitytype/course',
                  'browser' =>$browserInfo['browser'],
                  'version' =>$browserInfo['version'],
                  'platform' => 'EJAABI',
                  'instractor_name' =>$course->teacher->full_name,
                  'instractor_email' => $course->teacher->email,
                  'parent_url' => $course->getUrl(),
              ];
              //initailized  course
              $this->xapiService->createStatement($params);
            }
            return redirect('/panel/webinars/purchases')->with(['toast' => $toastData]);
        

     
        
     }
     elseif( $response['result']['code'] === '100.550.312'){
         
         dd($response);
        return Redirect::back()->with('message', 'Amount is outside allowed ticket size boundaries');  
     }
      else {
          dd($response['result']);
         
     
     }



}

    public function paymentVerify(Request $request, $gateway)
    {
        $paymentChannel = PaymentChannel::where('class_name', $gateway)
            ->where('status', 'active')
            ->first();

        try {
            $channelManager = ChannelManager::makeChannel($paymentChannel);
            $order = $channelManager->verify($request);

            return $this->paymentOrderAfterVerify($order);

        } catch (\Exception $exception) {
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];
            return redirect('cart')->with(['toast' => $toastData]);
        }
    }
    
    public function tamaraSuccess(Request $request)
{
    // ✅ الخطوة 1: الحصول على order_id من رابط العودة
    $orderId = $request->query('order_id');

    if (!$orderId) {
        return redirect('/cart')->with('error', 'لم يتم تحديد رقم الطلب');
    }

    // ✅ الخطوة 2: استعلام الطلب (مثال ثابت)
    // لو عندك جدول الطلبات في قاعدة البيانات
    $order = \App\Models\Order::where('tamara_order_id', $orderId)->first();

    // لو ما عندك جدول حقيقي، فقط استخدم مثال مؤقت
    if (!$order) {
        // مثال فقط لتجربة الكود بدون قاعدة بيانات
        $order = (object)[
            'id' => 999,
            'tamara_order_id' => $orderId,
            'status' => 'pending',
        ];
    }

    // ✅ الخطوة 3: إعداد طلب التحقق من الدفع من Tamara API
    $apiUrl = "https://api-sandbox.tamara.co/payments/orders/{$orderId}";
    $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhY2NvdW50SWQiOiIyY2RhMzczMS0yZmMyLTQxNjQtYWI5Ni03NWM2ODg4NjM2MmQiLCJ0eXBlIjoibWVyY2hhbnQiLCJzYWx0IjoiNTdjMDA5OGItMDJiNy00ZDBlLTliNGItZWJlNzE3M2UwM2NmIiwicm9sZXMiOlsiUk9MRV9NRVJDSEFOVCJdLCJpc010bHMiOmZhbHNlLCJpYXQiOjE3NTA4Mjg5MzAsImlzcyI6IlRhbWFyYSBQUCJ9.ruT8UJOphhHhcX2R1J-7OT-WpWWlras2gZY6lB9VIeY5H-yvBUVker8aBr-m-a4IAh4zEqs6SBIBBWNG09Sdb_xLgF0G0NdAG1gFHFvvWtjsUO7xLPf1zM3pul4JJ-4kbO4yN-ohfM6t7DooTbhlKK0tZl560tUp6gjRuFy7BS_hIFWiBwrQ80xrYxtqPzlP5P3P7-RedjQV6F_DDBKNBTiKs0ANIzQFEN3AiYRkBH1bIau1RqPvx0N1movsLhFmQWRSozxeQjEYv-yRq075_UNaharYS5m-jjU3c10XD0X288qjq7fdk_oOrINHbJN0Bovmo5JX-7-0D6rYEkeyCA";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $token",
            "Content-Type: application/json"
        ],
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    // ✅ الخطوة 4: فحص حالة الدفع من Tamara
    if (isset($result['order_status']) && in_array($result['order_status'], ['authorised', 'captured'])) {

        // مثال لتحديث حالة الطلب في قاعدة البيانات
        if (method_exists($order, 'update')) {
            $order->update([
                'status' => 'paid',
                'payment_method' => 'Tamara',
            ]);
        }

        // ✅ نجاح الدفع
        return redirect('/panel/webinars/purchases')
            ->with('success', 'تم الدفع بنجاح عبر تمارا ✅');
    }

    // ❌ فشل التحقق من الدفع
    if (method_exists($order, 'update')) {
        $order->update(['status' => 'failed']);
    }

    return redirect('/payments/status')
        ->with('error', 'فشل الدفع عبر تمارا ❌');
}

public function tamaraWebhook(Request $request)
{
    $data = $request->all();

    // مثال: Tamara تبعتك order_id + status
    $orderId = $data['order_id'] ?? null;
    $status = $data['status'] ?? null;

    // حدث حالة الطلب في قاعدة البيانات
    if ($status === 'approved') {
        Order::where('tamara_order_id', $orderId)->update(['status' => 'paid']);
    } elseif ($status === 'rejected') {
        Order::where('tamara_order_id', $orderId)->update(['status' => 'failed']);
    }

    return response()->json(['message' => 'ok']);
}

    /*
     * | this methode only run for payku.result
     * */
    public function paykuPaymentVerify(Request $request, $id)
    {
        $paymentChannel = PaymentChannel::where('class_name', PaymentChannel::$payku)
            ->where('status', 'active')
            ->first();

        try {
            $channelManager = ChannelManager::makeChannel($paymentChannel);

            $request->request->add(['transaction_id' => $id]);

            $order = $channelManager->verify($request);

            return $this->paymentOrderAfterVerify($order);

        } catch (\Exception $exception) {
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];
            return redirect('cart')->with(['toast' => $toastData]);
        }
    }

    private function paymentOrderAfterVerify($order)
    {
        if (!empty($order)) {

            if ($order->status == Order::$paying) {
                $this->setPaymentAccounting($order);

                $order->update(['status' => Order::$paid]);
            } else {
                if ($order->type === Order::$meeting) {
                    $orderItem = OrderItem::where('order_id', $order->id)->first();

                    if ($orderItem && $orderItem->reserve_meeting_id) {
                        $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();

                        if ($reserveMeeting) {
                            $reserveMeeting->update(['locked_at' => null]);
                        }
                    }
                }
            }

            session()->put($this->order_session_key, $order->id);
            
              $course_id=$order->orderItems()->first()->webinar_id ?? "";
            $course=\App\Models\Webinar::find($course_id);
            if($course){
            $user=auth()->user();

            $agent = $_SERVER['HTTP_USER_AGENT'];

            $browserInfo = $this->xapiService->getBrowserInfo($agent);

              $params = [
                  'name' => $user->full_name,
                  'email' => $user->email,
                  'verb' => 'registered', // or any other verb
                  'course_url' => $course->getUrl(),
                  'course_nameAr' => $course->title,
                  'course_nameEn' =>$course->getTranslation('title','en')->title ?? $course->title,
                  'type' => 'https://w3id.org/xapi/cmi5/activitytype/course',
                  'browser' =>$browserInfo['browser'],
                  'version' =>$browserInfo['version'],
                  'platform' => 'EJAABI',
                  'instractor_name' =>$course->teacher->full_name,
                  'instractor_email' => $course->teacher->email,
                  'parent_url' => $course->getUrl(),
              ];
      //registred verb
              $this->xapiService->createStatement($params);
              $params = [
                  'name' => $user->full_name,
                  'email' => $user->email,
                  'verb' => 'initialized', // or any other verb
                  'course_url' => $course->getUrl(),
                  'course_nameAr' => $course->title,
                  'course_nameEn' =>$course->getTranslation('title','en')->title ?? $course->title,
                  'type' => 'https://w3id.org/xapi/cmi5/activitytype/course',
                  'browser' =>$browserInfo['browser'],
                  'version' =>$browserInfo['version'],
                  'platform' => 'EJAABI',
                  'instractor_name' =>$course->teacher->full_name,
                  'instractor_email' => $course->teacher->email,
                  'parent_url' => $course->getUrl(),
              ];
              //initailized  course
              $this->xapiService->createStatement($params);
            }

            return redirect('/payments/status');
        } else {
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];

            return redirect('cart')->with($toastData);
        }
    }

    public function setPaymentAccounting($order, $type = null)
    {
        $cashbackAccounting = new CashbackAccounting();

        if ($order->is_charge_account) {
            Accounting::charge($order);

            $cashbackAccounting->rechargeWallet($order);
        } else {
            foreach ($order->orderItems as $orderItem) {
                $sale = Sale::createSales($orderItem, $order->payment_method);

                if (!empty($orderItem->reserve_meeting_id)) {
                    $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();
                    $reserveMeeting->update([
                        'sale_id' => $sale->id,
                        'reserved_at' => time()
                    ]);

                    $reserver = $reserveMeeting->user;

                    if ($reserver) {
                        $this->handleMeetingReserveReward($reserver);
                    }
                }

                if (!empty($orderItem->gift_id)) {
                    $gift = $orderItem->gift;

                    $gift->update([
                        'status' => 'active'
                    ]);

                    $gift->sendNotificationsWhenActivated($orderItem->total_amount);
                }

                if (!empty($orderItem->subscribe_id)) {
                    Accounting::createAccountingForSubscribe($orderItem, $type);
                } elseif (!empty($orderItem->promotion_id)) {
                    Accounting::createAccountingForPromotion($orderItem, $type);
                } elseif (!empty($orderItem->registration_package_id)) {
                    Accounting::createAccountingForRegistrationPackage($orderItem, $type);

                    if (!empty($orderItem->become_instructor_id)) {
                        BecomeInstructor::where('id', $orderItem->become_instructor_id)
                            ->update([
                                'package_id' => $orderItem->registration_package_id
                            ]);
                    }
                } elseif (!empty($orderItem->installment_payment_id)) {
                    Accounting::createAccountingForInstallmentPayment($orderItem, $type);

                    $this->updateInstallmentOrder($orderItem, $sale);
                } else {
                    // webinar and meeting and product and bundle

                    Accounting::createAccounting($orderItem, $type);
                    TicketUser::useTicket($orderItem);

                    if (!empty($orderItem->product_id)) {
                        $this->updateProductOrder($sale, $orderItem);
                    }
                }
            }

            // Set Cashback Accounting For All Order Items
            $cashbackAccounting->setAccountingForOrderItems($order->orderItems);
        }

        Cart::emptyCart($order->user_id);
    }

    public function payStatus(Request $request)
    {
        $orderId = $request->get('order_id', null);

        if (!empty(session()->get($this->order_session_key, null))) {
            $orderId = session()->get($this->order_session_key, null);
            session()->forget($this->order_session_key);
        }

        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->first();

        if (!empty($order)) {
            $data = [
                'pageTitle' => trans('public.cart_page_title'),
                'order' => $order,
            ];

            return view('web.default.cart.status_pay', $data);
        }

        return redirect('/panel');
    }

    private function handleMeetingReserveReward($user)
    {
        if ($user->isUser()) {
            $type = Reward::STUDENT_MEETING_RESERVE;
        } else {
            $type = Reward::INSTRUCTOR_MEETING_RESERVE;
        }

        $meetingReserveReward = RewardAccounting::calculateScore($type);

        RewardAccounting::makeRewardAccounting($user->id, $meetingReserveReward, $type);
    }

    private function updateProductOrder($sale, $orderItem)
    {
        $product = $orderItem->product;

        $status = ProductOrder::$waitingDelivery;

        if ($product and $product->isVirtual()) {
            $status = ProductOrder::$success;
        }

        ProductOrder::where('product_id', $orderItem->product_id)
            ->where(function ($query) use ($orderItem) {
                $query->where(function ($query) use ($orderItem) {
                    $query->whereNotNull('buyer_id');
                    $query->where('buyer_id', $orderItem->user_id);
                });

                $query->orWhere(function ($query) use ($orderItem) {
                    $query->whereNotNull('gift_id');
                    $query->where('gift_id', $orderItem->gift_id);
                });
            })
            ->update([
                'sale_id' => $sale->id,
                'status' => $status,
            ]);

        if ($product and $product->getAvailability() < 1) {
            $notifyOptions = [
                '[p.title]' => $product->title,
            ];
            sendNotification('product_out_of_stock', $notifyOptions, $product->creator_id);
        }
    }

    private function updateInstallmentOrder($orderItem, $sale)
    {
        $installmentPayment = $orderItem->installmentPayment;

        if (!empty($installmentPayment)) {
            $installmentOrder = $installmentPayment->installmentOrder;

            $installmentPayment->update([
                'sale_id' => $sale->id,
                'status' => 'paid',
            ]);

            /* Notification Options */
            $notifyOptions = [
                '[u.name]' => $installmentOrder->user->full_name,
                '[installment_title]' => $installmentOrder->installment->main_title,
                '[time.date]' => dateTimeFormat(time(), 'j M Y - H:i'),
                '[amount]' => handlePrice($installmentPayment->amount),
            ];

            if ($installmentOrder and $installmentOrder->status == 'paying' and $installmentPayment->type == 'upfront') {
                $installment = $installmentOrder->installment;

                if ($installment) {
                    if ($installment->needToVerify()) {
                        $status = 'pending_verification';

                        sendNotification("installment_verification_request_sent", $notifyOptions, $installmentOrder->user_id);
                        sendNotification("admin_installment_verification_request_sent", $notifyOptions, 1); // Admin
                    } else {
                        $status = 'open';

                        sendNotification("paid_installment_upfront", $notifyOptions, $installmentOrder->user_id);
                    }

                    $installmentOrder->update([
                        'status' => $status
                    ]);

                    if ($status == 'open' and !empty($installmentOrder->product_id) and !empty($installmentOrder->product_order_id)) {
                        $productOrder = ProductOrder::query()->where('installment_order_id', $installmentOrder->id)
                            ->where('id', $installmentOrder->product_order_id)
                            ->first();

                        $product = Product::query()->where('id', $installmentOrder->product_id)->first();

                        if (!empty($product) and !empty($productOrder)) {
                            $productOrderStatus = ProductOrder::$waitingDelivery;

                            if ($product->isVirtual()) {
                                $productOrderStatus = ProductOrder::$success;
                            }

                            $productOrder->update([
                                'status' => $productOrderStatus
                            ]);
                        }
                    }
                }
            }


            if ($installmentPayment->type == 'step') {
                sendNotification("paid_installment_step", $notifyOptions, $installmentOrder->user_id);
                sendNotification("paid_installment_step_for_admin", $notifyOptions, 1); // For Admin
            }

        }
    }

}
