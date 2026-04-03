<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class VisaPaymentController extends Controller
{
        public function payment(Request $request, $lang = null)
    {
        try {
            $userCarts = auth()->check() ? Cart::where('creator_id', auth()->id())->get() : collect();
    
            $cartsCount = Cart::where('creator_id', Auth::id())->count();
            if ($cartsCount == 0) {
                return redirect('/');
            }
    
            // البوابة من الفورم
            $method = strtolower($request->input('gateway'));
            session()->put('gateway', $method);
    
            if ($method == 'mada') {
                $entityId = '8ac9a4cc73900e190173940e3eba26a0';
                $currency = 'SAR';
            } elseif ($method == 'visa') {
                $entityId = '8ac9a4cc73900e190173940dee79269a';
                $currency = 'SAR';
            } else {
                return back()->withErrors(['msg' => 'بوابة غير صحيحة']);
            }
    
            // حساب السعر
            $carts = Cart::join('webinars', 'cart.webinar_id', '=', 'webinars.id')
                ->select('cart.*', 'webinars.price', 'webinars.discount_rate')
                ->where('cart.creator_id', Auth::id())
                ->get();
    $price = 0;

foreach ($carts as $cart) {
    $price += $cart->price; // فقط السعر الأساسي بدون خصم
}

// إذا موجودة قيمة محفوظة في الجلسة، استخدمها
if (session()->has('total_amount')) {
    $price = session()->get('total_amount');
} else {
    session()->put('total_amount', $price);
}

// صياغة السعر بشكل منسق
$price = number_format($price);
            // إنشاء checkout
            $url = "https://eu-prod.oppwa.com/v1/checkouts";
            $data = "entityId=$entityId&amount=$price&currency=$currency&paymentType=DB";
           
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization:Bearer OGFjOWE0Y2M3MzkwMGUxOTAxNzM5NDA4MzFiMjI2NzR8SDlFbU5wZmViOA=='
            ]);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
    
            $responseArray = json_decode($responseData, true);
            $checkout_id = $responseArray['id'] ?? null;

            if (!$checkout_id) {
                return back()->withErrors(['msg' => 'خطأ في إنشاء الطلب']);
            }
    
            session()->put('checkout_id', $checkout_id);
    
            // جهز البيانات للـ Blade
            return view('web.default.cart.pay', [
                'checkout_id' => $checkout_id,
                'price' => $price,
                'count' => $cartsCount,                       
                'userCarts' => $userCarts,
                'totalCashbackAmount' => 0, // أو احسبه من عندك
                'order' => (object)[
                    'id' => uniqid(),
                    'user' => Auth::user(),
                    'total_amount' => $price,
                ],
                'razorpay' => false,
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function verify(Request $request)
    {
        try {
            $checkout_id = session()->get('checkout_id');
            $method = session()->get('gateway');

            if (!$checkout_id || !$method) {
                return redirect('/')->with('error', 'جلسة الدفع غير صالحة');
            }

            if ($method == 'mada') {
                $entityId = '8ac9a4cc73900e190173940e3eba26a0';
            } elseif ($method == 'visa') {
                $entityId = '8ac9a4cc73900e190173940dee79269a';
            } else {
                return redirect('/')->with('error', 'بوابة غير صحيحة');
            }

            $url = "https://eu-prod.oppwa.com/v1/checkouts/$checkout_id/payment";
            $url .= "?entityId=" . $entityId;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization:Bearer OGFjOWE0Y2M3MzkwMGUxOTAxNzM5NDA4MzFiMjI2NzR8SDlFbU5wZmViOA=='
            ]);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);

            $response = json_decode($responseData, true);

            if (isset($response['result']['code']) && strpos($response['result']['code'], '000.000') === 0) {
                // نجاح الدفع
                return redirect('/')->with('success', 'تم الدفع بنجاح');
            } else {
                return redirect('/')->with('error', 'فشل الدفع');
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
