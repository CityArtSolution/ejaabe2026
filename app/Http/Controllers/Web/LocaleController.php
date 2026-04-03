<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

class LocaleController extends Controller
{
    public function setLocale(Request $request)
    {
        // Validate input
        $request->validate([
            'locale' => 'required|string|in:AR,EN,ar,en', // السماح بالقيم الصحيحة فقط
        ]);

        // تحويل القيمة لحروف كبيرة (ar => AR, en => EN)
        $locale = strtoupper(trim($request->input('locale')));
        $allowedLocales = ['AR', 'EN'];

        // إذا القيمة غير مدعومة، اجعلها افتراضية EN
        if (!in_array($locale, $allowedLocales)) {
            $locale = 'EN';
        }

        // جلب اللغات المدعومة من الإعدادات العامة
        $generalSettings = getGeneralSettings();
        $userLanguages = $generalSettings['user_languages'] ?? [];

        if (in_array($locale, $userLanguages)) {
            if (Auth::check()) {
                // المستخدم مسجل الدخول، حدث قيمة اللغة في جدول users
                $user = Auth::user();
                $user->update([
                    'language' => $locale
                ]);
            } else {
                // مستخدم غير مسجل الدخول، خزّن اللغة في كوكيز لمدة 30 يوم
                Cookie::queue('user_locale', $locale, 30 * 24 * 60);
            }
        }

        // إعادة التوجيه إلى الرابط السابق أو العودة للصفحة الحالية
        $previousUrl = $request->input('previous_url');
        return !empty($previousUrl) ? redirect($previousUrl) : redirect()->back();
    }
}
