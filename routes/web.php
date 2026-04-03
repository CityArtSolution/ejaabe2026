<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\WebinarController;
use App\Http\Controllers\Web\canadaClass;
use App\Http\Controllers\Web\VisaPaymentController;
use App\Http\Controllers\Admin\WebinarController as AdminWebinarController;
use App\Http\Controllers\Web\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

Route::get('/send-test-email', function () {
    Mail::to('info@growthwave-sa.com')->send(new TestEmail());
    return 'Test email sent!';
});*/
Route::post('/payments/payment-request-test', [PaymentController::class, 'tamaraTest'])->name('payments.tamara.test');


Route::post('/admin/webinars/{id}/duplicate', [AdminWebinarController::class, 'duplicate'])
    ->name('admin.webinars.duplicate');

                            /* SCORM ROUTES */

Route::middleware(['auth'])->group(function () {
    Route::post('/scorm/runtime/initialize', [WebinarController::class, 'initialize'])->name('scorm.runtime.initialize');
    Route::post('/scorm/runtime/getvalue',    [WebinarController::class, 'getValue'])->name('scorm.runtime.getvalue');
    Route::post('/scorm/runtime/setvalue',    [WebinarController::class, 'setValue'])->name('scorm.runtime.setvalue');
    Route::post('/scorm/runtime/commit',      [WebinarController::class, 'commit'])->name('scorm.runtime.commit');
    Route::post('/scorm/runtime/finish',      [WebinarController::class, 'finish'])->name('scorm.runtime.finish');
    Route::post('/scorm/runtime/getlasterror',[WebinarController::class, 'getLastError'])->name('scorm.runtime.getlasterror');


});

Route::get('/scorm/solve/{folder}/{path?}', [WebinarController::class, 'solve'])->where(['folder' => '[^/]+', 'path' => '.*'])->name('scorm.asset.solve');

Route::get('/scorm/play/{folder}/{path?}', [WebinarController::class, 'asset'])->where(['folder' => "[^/]+", 'path' => '.*'])->name('scorm.asset');

Route::get('/scorm/save-progress', [WebinarController::class, 'saveProgress'])->name('scorm.progress.save');

Route::view('/pages/content-dev', 'web.default.pages.content_dev');

                            /* SCORM ROUTES END */


Route::group(['prefix' => 'my_api', 'namespace' => 'Api\Panel', 'middleware' => 'signed', 'as' => 'my_api.web.'], function () {
    Route::get('checkout/{user}', 'CartController@webCheckoutRender')->name('checkout');
    Route::get('/charge/{user}', 'PaymentsController@webChargeRender')->name('charge');
    Route::get('/subscribe/{user}/{subscribe}', 'SubscribesController@webPayRender')->name('subscribe');
    Route::get('/registration_packages/{user}/{package}', 'RegistrationPackagesController@webPayRender')->name('registration_packages');
});

Route::group(['prefix' => 'api_sessions'], function () {
    Route::get('/big_blue_button', ['uses' => 'Api\Panel\SessionsController@BigBlueButton'])->name('big_blue_button');
    Route::get('/agora', ['uses' => 'Api\Panel\SessionsController@agora'])->name('agora');
});

Route::get('/mobile-app', 'Web\MobileAppController@index')->middleware(['share'])->name('mobileAppRoute');
Route::get('/maintenance', 'Web\MaintenanceController@index')->middleware(['share'])->name('maintenanceRoute');
Route::get('/restriction', 'Web\RestrictionController@index')->middleware(['share'])->name('restrictionRoute');

Route::group(['prefix' => 'cookie-security'], function () {
    Route::post('/all', 'Web\CookieSecurityController@setAll');
    Route::post('/customize', 'Web\CookieSecurityController@setCustomize');
});

 //eval
Route::group(['namespace' => 'Panel'], function () {
    Route::get('evaluation/{id}/eval', 'QuizController@eval');
    Route::post('evaluation/{id}/store-result', 'QuizController@quizzesStoreResultEval');
    Route::get('evaluation-thanks', 'QuizController@thanks')->name('thankseval');
});

Route::group(['namespace' => 'Auth', 'middleware' => ['check_mobile_app','share', 'check_maintenance', 'check_restriction']], function () {
    Route::get('/login', 'LoginController@showLoginForm');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout');
    Route::get('/canada/login', 'LoginController@showLoginForm');
    Route::get('/egy/login', 'LoginController@showLoginForm');
    Route::get('/uae/login', 'LoginController@showLoginForm');
    Route::get('/register', 'RegisterController@showRegistrationForm');
    Route::get('/canada/register', 'RegisterController@showRegistrationForm');
    Route::get('/egy/register', 'RegisterController@showRegistrationForm');
    Route::get('/uae/register', 'RegisterController@showRegistrationForm');
    Route::post('/register', 'RegisterController@register');
    Route::post('/register/form-fields', 'RegisterController@getFormFieldsByUserType');
    Route::get('/verification', 'VerificationController@index');
    Route::post('/verification', 'VerificationController@confirmCode');
    Route::get('/verification/resend', 'VerificationController@resendCode');
    Route::get('/forget-password', 'ForgotPasswordController@showLinkRequestForm');
    Route::post('/forget-password', 'ForgotPasswordController@forgot');
    Route::get('reset-password/{token}', 'ResetPasswordController@showResetForm');
    Route::post('/reset-password', 'ResetPasswordController@updatePassword');
    Route::get('/google', 'SocialiteController@redirectToGoogle');
    Route::get('/google/callback', 'SocialiteController@handleGoogleCallback');
    Route::get('/facebook/redirect', 'SocialiteController@redirectToFacebook');
    Route::get('/facebook/callback', 'SocialiteController@handleFacebookCallback');
    Route::get('/reff/{code}', 'ReferralController@referral');
});

Route::group(['namespace' => 'Web', 'middleware' => ['check_mobile_app', 'impersonate', 'share', 'check_maintenance', 'check_restriction']], function () {
    Route::get('/stripe', function () {
        return view('web.default.cart.channels.stripe');
    });

    Route::fallback(function () {
        return view("errors.404", ['pageTitle' => trans('public.error_404_page_title')]);
    });

    // set Locale
    Route::post('/locale', 'LocaleController@setLocale')->name('appLocaleRoute');

    // set Locale
    Route::post('/set-currency', 'SetCurrencyController@setCurrency');

    Route::get('/', 'HomeController@index');
//    Route::get('/newPage', 'HomeController@newPage');
    Route::get('/canada', 'HomeController@canada');
    Route::get('/egy', 'HomeController@egy');
    Route::get('/uae', 'HomeController@uae');
    Route::get('/about', 'HomeController@about');
    Route::get('/solution', 'HomeController@solution');
    Route::get('/tranning', 'HomeController@tranning');
    Route::get('/resource', 'HomeController@resource');
    Route::get('/contactus', 'HomeController@contactus');
    Route::view('/contactusEgy', 'web.default.pages.contactusEgy');
    Route::view('/contactusUae', 'web.default.pages.contactusUae');

    Route::get('/teacher', 'HomeController@teacher');

   /* Route::group(['middleware' => ['language'],'prefix' => 'ar'], function() {
         Route::get('/', 'HomeController@index');
    Route::get('/about', 'HomeController@about');
    Route::get('/solution', 'HomeController@solution');
    Route::get('/tranning', 'HomeController@tranning');
    Route::get('/resource', 'HomeController@resource');
    Route::get('/contactus', 'HomeController@contactus');
    Route::get('/teacher', 'HomeController@teacher');

    });*/
    Route::group(['middleware' => ['language'],'prefix' => 'en'], function() {
        Route::get('/', 'HomeController@index');
        Route::get('/canada', 'HomeController@canada');
        Route::get('/uae', 'HomeController@uae');
        Route::get('/egy', 'HomeController@egy');
        Route::get('/about', 'HomeController@about');
        Route::get('/solution', 'HomeController@solution');
        Route::get('/tranning', 'HomeController@tranning');
        Route::get('/resource', 'HomeController@resource');
        Route::get('/contactus', 'HomeController@contactus');
        Route::get('/content/{link}', 'ContentsController@index');
        Route::get('/lang-training/{link}', 'LangTrainingController@index');
        Route::get('/teacher', 'HomeController@teacher');
        Route::get('/course/details/{slug}', 'WebinarController@courseText')->name('course.details');
        Route::get('/course/details/canada/{slug}', 'WebinarController@courseTextCanada')->name('course.details.canada');
        Route::get('/course/details/egy/{slug}', 'WebinarController@courseTextegy')->name('course.details.egy');
        Route::get('/course/details/uae/{slug}', 'WebinarController@courseTextuae')->name('course.details.uae');
        Route::get('/course/{slug}', 'WebinarController@course');
        Route::get('/course/{slug}/canada', 'WebinarController@course_canada');
        Route::get('/course/{slug}/egy', 'WebinarController@course_egy');
        Route::get('/course/{slug}/uae', 'WebinarController@course_uae');
        Route::get('/cet-course/plan', 'WebinarController@cet_courses')->name('cet_courses');
        Route::get('/cet-course/plan/canada', 'WebinarController@cet_courses_canada')->name('cet_courses_canada');
        Route::get('/cet-course/plan/egy', 'WebinarController@cet_courses_egy')->name('cet_courses_egy');
        Route::get('/cet-course/plan/uae', 'WebinarController@cet_courses_uae')->name('cet_courses_uae');
        Route::get('/classes', 'ClassesController@index');
        Route::get('/courses', 'ClassesController@index');
        Route::get('/canada/classes', 'canadaClass@index');
        Route::get('/egy/classes', 'canadaClass@index_egy');
        Route::get('/uae/classes', 'canadaClass@index_uae');
        Route::get('/course/{slug}/file/{file_id}/showHtml', 'WebinarController@showHtmlFile');
        Route::get('/courses/{categoryTitle?}/{subCategoryTitle?}', 'ClassesController@index');
        Route::get('/event/{slug}', 'HomeController@eventDetails');
        Route::get('/upcoming_courses/', 'UpcomingCoursesController@index');
        Route::get('/upcoming_courses/{slug}', 'UpcomingCoursesController@show');
        Route::get('/upcoming_courses/{slug}/toggleFollow', 'UpcomingCoursesController@toggleFollow');
        Route::get('/upcoming_courses/{slug}/favorite', 'UpcomingCoursesController@favorite');
        Route::post('/upcoming_courses/{id}/report', 'UpcomingCoursesController@report');
        Route::get('/categories/{categoryTitle}/{subCategoryTitle?}', 'CategoriesController@index');
        Route::get('ca/categories/{categoryTitle}/{subCategoryTitle?}', 'CategoriesController@index');
        Route::get('egy/categories/{categoryTitle}/{subCategoryTitle?}', 'CategoriesController@index_egy');
        Route::get('uae/categories/{categoryTitle}/{subCategoryTitle?}', 'CategoriesController@index_uae');
        Route::get('/contact', 'ContactController@index');
        Route::view('/canada/policy', 'web.default.pages.canada.canada_policy');
        Route::view('/canada/term', 'web.default.pages.canada.canada_policy');
        Route::view('/canada/Virtual', 'web.default.pages.Virtual_attendance');
        Route::view('/canada/commitment/copyright', 'web.default.pages.canada.canada_commitment')->name('canada.commitment');
        Route::view('/canada/support/policy', 'web.default.pages.canada.canada_support-policy')->name('canada.support.policy');
        Route::view('/canada/academic', 'web.default.pages.canada.canada_academic')->name('canada.academic');
        Route::view('/trainers/plan', 'web.default.pages.canada.canada_trainers_plan')->name('canada.trainers.plan');
        Route::view('/canada/support_terms', 'web.default.pages.canada_support_terms');
        Route::get('/blog', 'BlogController@index');
        Route::get('/blog/categories/{category}', 'BlogController@index');
        Route::get('/blog/{slug}', 'BlogController@show');
        Route::get('/request-course/{slug}', 'WebinarController@requestCourse')->name('request_course_en');
        Route::get('/request-consulting', 'WebinarController@requestConsulting')->name('request_consulting');

        Route::group(['prefix' => 'search'], function () {
            Route::get('/', 'SearchController@index');
            Route::get('/canada', 'SearchController@canada');
            Route::get('/egy', 'SearchController@egy');
            Route::get('/uae', 'SearchController@uae');
        });

        Route::get('/aboutUs/canada', function () {
            return view('web.default.includes.about_us_canada');
        });

        Route::get('/aboutUs/egy', function () {
            return view('web.default.includes.about_egy');
        });

        Route::view('/contactusEgy', 'web.default.pages.contactusEgy');

        Route::get('/aboutUs/uae', function () {
            return view('web.default.includes.about_uae');
        });

        Route::view('/contactusUae', 'web.default.pages.contactusUae');

                    /* Forms */
        Route::get('/forms/{url}', 'FormsController@index');
        Route::post('/forms/{url}/store', 'FormsController@store');


                    /* teacher form */
        Route::get('/teacher_form', 'FormsController@teacherTanks');
        Route::post('/teacher_form/store', 'FormsController@teacherForm');


                    /* pages */
        Route::group(['prefix' => 'pages'], function () {
            Route::get('/{link}', 'PagesController@index');
        });
        Route::group(['prefix' => 'pages'], function () {
            Route::get('egy/{link}', 'PagesController@index');
        });
        Route::group(['prefix' => 'pages'], function () {
            Route::get('uae/{link}', 'PagesController@index');
        });
    });

    Route::group(['middleware' => ['language'],'prefix' => 'ar'], function() {
        Route::get('/', 'HomeController@index');

        Route::get('/canada', function () {
            return redirect('/en/canada');
        });

        Route::get('/uae', 'HomeController@uae');
        Route::get('/egy', 'HomeController@egy');
        Route::get('/contact', 'ContactController@index');
        Route::get('/about', 'HomeController@about');
        Route::get('/solution', 'HomeController@solution');
        Route::get('/tranning', 'HomeController@tranning');
        Route::get('/resource', 'HomeController@resource');
        Route::get('/contactus', 'HomeController@contactus');
        Route::get('/content/{link}', 'ContentsController@index');
        Route::get('/lang-training/{link}', 'LangTrainingController@index');
        Route::get('/teacher', 'HomeController@teacher');
        Route::get('/course/details/{slug}', 'WebinarController@courseText')->name('course.details');
        Route::get('/course/details/egy/{slug}', 'WebinarController@courseTextegy')->name('course.details.egy');
        Route::get('/course/details/uae/{slug}', 'WebinarController@courseTextuae')->name('course.details.uae');
        Route::get('/course/{slug}', 'WebinarController@course');
        Route::get('/course/{slug}/egy', 'WebinarController@course_egy');
        Route::get('/course/{slug}/uae', 'WebinarController@course_uae');
        Route::get('/cet-course/plan', 'WebinarController@cet_courses')->name('cet_courses');
        Route::get('/cet-course/plan/egy', 'WebinarController@cet_courses_egy')->name('cet_courses_egy');
        Route::get('/cet-course/plan/uae', 'WebinarController@cet_courses_uae')->name('cet_courses_uae');
        Route::get('/classes', 'ClassesController@index');
        Route::get('/egy/classes', 'canadaClass@index_egy');
        Route::get('/uae/classes', 'canadaClass@index_uae');
        Route::get('/courses', 'ClassesController@index');
        Route::get('/course/{slug}/file/{file_id}/showHtml', 'WebinarController@showHtmlFile');
        Route::get('/courses/{categoryTitle?}/{subCategoryTitle?}', 'ClassesController@index');
        Route::get('/event/{slug}', 'HomeController@eventDetails');
        Route::get('/upcoming_courses/', 'UpcomingCoursesController@index');
        Route::get('/upcoming_courses/{slug}', 'UpcomingCoursesController@show');
        Route::get('/upcoming_courses/{slug}/toggleFollow', 'UpcomingCoursesController@toggleFollow');
        Route::get('/upcoming_courses/{slug}/favorite', 'UpcomingCoursesController@favorite');
        Route::post('/upcoming_courses/{id}/report', 'UpcomingCoursesController@report');
        Route::get('/categories/{categoryTitle}/{subCategoryTitle?}', 'CategoriesController@index');
        Route::get('egy/categories/{categoryTitle}/{subCategoryTitle?}', 'CategoriesController@index_egy');
        Route::get('uae/categories/{categoryTitle}/{subCategoryTitle?}', 'CategoriesController@index_uae');

                    /* Forms */
        Route::get('/forms/{url}', 'FormsController@index');
        Route::post('/forms/{url}/store', 'FormsController@store');

                    /* teacher form */
        Route::get('/teacher_form', 'FormsController@teacherTanks');
        Route::post('/teacher_form/store', 'FormsController@teacherForm');
        Route::get('/blog', 'BlogController@index');
        Route::get('/blog/categories/{category}', 'BlogController@index');
        Route::get('/blog/{slug}', 'BlogController@show');
        Route::get('/request-course/{slug}', 'WebinarController@requestCourse')->name('request_course');

        Route::group(['prefix' => 'search'], function () {
            Route::get('/', 'SearchController@index');
            Route::get('/canada', 'SearchController@canada');
            Route::get('/egy', 'SearchController@egy');
            Route::get('/uae', 'SearchController@uae');
        });

        Route::get('/aboutUs/canada', function () {
            return view('web.default.includes.about_us_canada');
        });

        Route::get('/aboutUs/egy', function () {
            return view('web.default.includes.about_egy');
        });

        Route::view('/contactusEgy', 'web.default.pages.contactusEgy');

        Route::get('/aboutUs/uae', function () {
            return view('web.default.includes.about_uae');
        });

        Route::view('/contactusUae', 'web.default.pages.contactusUae');
        Route::get('/request-consulting', 'WebinarController@requestConsulting')->name('request_consulting');

                        /* pages */
         Route::group(['prefix' => 'pages'], function () {
            Route::get('/{link}', 'PagesController@index');
        });
         Route::group(['prefix' => 'pages'], function () {
            Route::get('/egy/{link}', 'PagesController@index');
        });
         Route::group(['prefix' => 'pages'], function () {
            Route::get('/uae/{link}', 'PagesController@index');
        });
    });

    Route::group(['prefix' => 'course'], function () {
        Route::get('/details/{slug}', 'WebinarController@courseText')->name('course.details');
        Route::get('/{slug}', 'WebinarController@course');
        Route::get('/{slug}/file/{file_id}/download', 'WebinarController@downloadFile');
        Route::get('/{slug}/file/{file_id}/showHtml', 'WebinarController@showHtmlFile');
        Route::get('/{slug}/lessons/{lesson_id}/read', 'WebinarController@getLesson');
        Route::post('/getFilePath', 'WebinarController@getFilePath');
        Route::get('/{slug}/file/{file_id}/play', 'WebinarController@playFile');
        Route::get('/{slug}/free', 'WebinarController@free');
        Route::get('/{slug}/points/apply', 'WebinarController@buyWithPoint');
        Route::post('/{id}/report', 'WebinarController@reportWebinar');
        Route::post('/{id}/learningStatus', 'WebinarController@learningStatus');

        Route::group(['middleware' => 'web.auth'], function () {
            Route::get('/{slug}/installments', 'WebinarController@getInstallmentsByCourse');

            Route::post('/learning/itemInfo', 'LearningPageController@getItemInfo');
            Route::post('/learning/personalNotes', 'LearningPageController@personalNotes');
            Route::get('/learning/{slug}', 'LearningPageController@index');
            Route::get('/learning/{slug}/noticeboards', 'LearningPageController@noticeboards');
            Route::get('/assignment/{assignmentId}/download/{id}/attach', 'LearningPageController@downloadAssignment');
            Route::post('/assignment/{assignmentId}/history/{historyId}/message', 'AssignmentHistoryController@storeMessage');
            Route::post('/assignment/{assignmentId}/history/{historyId}/setGrade', 'AssignmentHistoryController@setGrade');
            Route::get('/assignment/{assignmentId}/history/{historyId}/message/{messageId}/downloadAttach', 'AssignmentHistoryController@downloadAttach');

            Route::group(['prefix' => '/learning/{slug}/forum'], function () { // LearningPageForumTrait
                Route::get('/', 'LearningPageController@forum');
                Route::post('/store', 'LearningPageController@forumStoreNewQuestion');
                Route::get('/{forumId}/edit', 'LearningPageController@getForumForEdit');
                Route::post('/{forumId}/update', 'LearningPageController@updateForum');
                Route::post('/{forumId}/pinToggle', 'LearningPageController@forumPinToggle');
                Route::get('/{forumId}/downloadAttach', 'LearningPageController@forumDownloadAttach');

                Route::group(['prefix' => '/{forumId}/answers'], function () {
                    Route::get('/', 'LearningPageController@getForumAnswers');
                    Route::post('/', 'LearningPageController@storeForumAnswers');
                    Route::get('/{answerId}/edit', 'LearningPageController@answerEdit');
                    Route::post('/{answerId}/update', 'LearningPageController@answerUpdate');
                    Route::post('/{answerId}/{togglePinOrResolved}', 'LearningPageController@answerTogglePinOrResolved');
                });
            });

            Route::post('/direct-payment', 'WebinarController@directPayment');

            Route::group(['prefix' => 'personal-notes'], function () {
                Route::get('/{id}/download-attachment', 'CoursePersonalNotesController@downloadAttachment');
            });
        });
    });

    Route::group(['prefix' => 'certificate_validation'], function () {
        Route::get('/', 'CertificateValidationController@index');
        Route::post('/validate', 'CertificateValidationController@checkValidate');
    });


    Route::group(['prefix' => 'cart'], function () {
        Route::post('/store', 'CartManagerController@store');
        Route::get('/{id}/delete', 'CartManagerController@destroy');
    });





    Route::group(['middleware' => ['web', 'web.auth_canada']], function () {
        Route::group(['prefix' => 'cart'], function () {
            Route::get('/canada', 'CartController@index_canada');
            Route::post('/coupon/validate', 'CartController@couponValidate');
            Route::post('/checkout/canada', 'CartController@checkout_canada')->name('checkout');
            Route::get('/payment_canada/canada', 'CartController@payment_canada')->name('payment_canada');
            Route::get('deposit', 'CartController@payment_canada')->name('deposit');
            Route::post('/payment-request', [PaymentController::class, 'paymentRequest'])->name('payment_request');

    // بوابة Tamara
    Route::get('/tamara/success', [PaymentController::class, 'tamaraSuccess'])->name('tamara_success');
    Route::get('/tamara/fail', [PaymentController::class, 'tamaraFail'])->name('tamara_fail');
    Route::get('/tamara/cancel', [PaymentController::class, 'tamaraCancel'])->name('tamara_cancel');

    // CanadaET و Visa و Mada و Credit و Bank كلها متوجهة من نفس الفورم
    // لو حبيت تعمل راوتات مستقلة (مثلاً لتسهيل AJAX أو Redirect):
    Route::post('/tamara', [PaymentController::class, 'paymentRequest'])->name('payment_tamara');
    Route::post('/Mada', [PaymentController::class, 'paymentRequest'])->name('payment_mada');
    Route::post('/Bank', [PaymentController::class, 'paymentRequest'])->name('payment_bank');
    Route::post('/payments/visa', [VisaPaymentController::class, 'payment'])->name('payment_visa');

   Route::get('/status', function () {
        $orderId = session('payment.order_id');
        $order = \App\Models\Order::find($orderId);
        return view('web.default.cart.status', compact('order'));
    })->name('payment_status');

        // للإشعار (Webhook)
        Route::post('/api/tamara/webhook', [PaymentController::class, 'tamaraWebhook'])->name('tamara.webhook');



        Route::post('/payments/canada', [VisaPaymentController::class, 'paymentCanada'])->name('payment_canada');
        Route::post('/payments/start', [VisaPaymentController::class, 'payment'])->name('payment_start');
        Route::get('/payments/verify', [VisaPaymentController::class, 'verify'])->name('payment_verfy');

        });


        Route::group(['prefix' => 'payments'], function () {
            Route::post('/payment-request', 'PaymentController@paymentRequest');
            Route::get('/verify/{gateway}', ['as' => 'payment_verify', 'uses' => 'PaymentController@paymentVerify']);
            Route::post('/verify/{gateway}', ['as' => 'payment_verify_post', 'uses' => 'PaymentController@paymentVerify']);
            Route::get('/status', 'PaymentController@payStatus');
            Route::get('/payku/callback/{id}', 'PaymentController@paykuPaymentVerify')->name('payku.result');
           //for  new payment gateway like  mada
            Route::get('/confirm-payment/{id}/{resourcePath}', 'PaymentController@confirm_payment')->name('payments.success_paymentss');
        });
    });

    Route::group(['middleware' => ['web', 'web.auth_egy']], function () {

        Route::group(['prefix' => 'ar'], function () {
            Route::group(['prefix' => 'cart'], function () {
                Route::get('/egy', 'CartController@index_egy');
                Route::post('/coupon/validate', 'CartController@couponValidate');
                Route::post('/checkout/egy', 'CartController@checkout_egy');
                Route::post('/deposit/select', 'CartController@depositSelectOption')->name('depositSelect');
                Route::get('/payment/callback', 'CartController@callback')->name('payment.callback');
            });
        });
        Route::group(['prefix' => 'en'], function () {
            Route::group(['prefix' => 'cart'], function () {
                Route::get('/egy', 'CartController@index_egy');
                Route::post('/coupon/validate', 'CartController@couponValidate');
                Route::post('/checkout/egy', 'CartController@checkout_egy');
                Route::post('/deposit/select', 'CartController@depositSelectOption')->name('depositSelect');
                Route::get('/payment/callback', 'CartController@callback')->name('payment.callback');
            });
        });
        Route::group(['prefix' => 'cart'], function () {
            Route::get('/egy', 'CartController@index_egy');
            Route::post('/coupon/validate', 'CartController@couponValidate');
            Route::post('/checkout/egy', 'CartController@checkout_egy');
            Route::post('/deposit/select', 'CartController@depositSelectOption')->name('depositSelect');
            Route::get('/payment/callback', 'CartController@callback')->name('payment.callback');
        });

        Route::group(['prefix' => 'payments'], function () {
            Route::post('/payment-request/egy', 'PaymentController@paymentRequest');
            Route::get('/verify/{gateway}', ['as' => 'payment_verify', 'uses' => 'PaymentController@paymentVerify']);
            Route::post('/verify/{gateway}', ['as' => 'payment_verify_post', 'uses' => 'PaymentController@paymentVerify']);
            Route::get('/status', 'PaymentController@payStatus');
            Route::get('/payku/callback/{id}', 'PaymentController@paykuPaymentVerify')->name('payku.result');
           //for  new payment gateway like  mada
            Route::get('/confirm-payment/{id}/{resourcePath}', 'PaymentController@confirm_payment')->name('payments.success_paymentss');
        });
    });


    Route::group(['middleware' => ['web', 'web.auth_uae']], function () {

        Route::group(['prefix' => 'en'], function () {
            Route::group(['prefix' => 'cart'], function () {
                Route::get('/uae', 'CartController@index_uae');
                Route::post('/coupon/validate', 'CartController@couponValidate');
                Route::post('/checkout/uae', 'CartController@checkout_uae')->name('checkout');
                Route::post('/deposit/select', 'CartController@depositSelectOption')->name('depositSelect');
                Route::get('/payment/callback', 'CartController@callback')->name('payment.callback');
            });
        });
        Route::group(['prefix' => 'ar'], function () {
            Route::group(['prefix' => 'cart'], function () {
                Route::get('/uae', 'CartController@index_uae');
                Route::post('/coupon/validate', 'CartController@couponValidate');
                Route::post('/checkout/uae', 'CartController@checkout_uae')->name('checkout');
                Route::post('/deposit/select', 'CartController@depositSelectOption')->name('depositSelect');
                Route::get('/payment/callback', 'CartController@callback')->name('payment.callback');
            });
        });
        Route::group(['prefix' => 'cart'], function () {
            Route::get('/uae', 'CartController@index_uae');
            Route::post('/coupon/validate', 'CartController@couponValidate');
            Route::post('/checkout/uae', 'CartController@checkout_uae')->name('checkout');
            Route::post('/deposit/select', 'CartController@depositSelectOption')->name('depositSelect');
            Route::get('/payment/callback', 'CartController@callback')->name('payment.callback');
        });

        Route::group(['prefix' => 'payments'], function () {
            Route::post('/payment-request/uae', 'PaymentController@paymentRequest');
            Route::get('/verify/{gateway}', ['as' => 'payment_verify', 'uses' => 'PaymentController@paymentVerify']);
            Route::post('/verify/{gateway}', ['as' => 'payment_verify_post', 'uses' => 'PaymentController@paymentVerify']);
            Route::get('/status', 'PaymentController@payStatus');
            Route::get('/payku/callback/{id}', 'PaymentController@paykuPaymentVerify')->name('payku.result');
           //for  new payment gateway like  mada
            Route::get('/confirm-payment/{id}/{resourcePath}', 'PaymentController@confirm_payment')->name('payments.success_paymentss');
        });
    });

    Route::group(['middleware' => 'web.auth'], function () {

        Route::group(['prefix' => 'laravel-filemanager'], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });

        Route::group(['prefix' => 'reviews'], function () {
            Route::post('/store', 'WebinarReviewController@store');
            Route::post('/store-reply-comment', 'WebinarReviewController@storeReplyComment');
            Route::get('/{id}/delete', 'WebinarReviewController@destroy');
            Route::get('/{id}/delete-comment/{commentId}', 'WebinarReviewController@destroy');
        });

        Route::group(['prefix' => 'favorites'], function () {
            Route::get('{slug}/toggle', 'FavoriteController@toggle');
            Route::post('/{id}/update', 'FavoriteController@update');
            Route::get('/{id}/delete', 'FavoriteController@destroy');
        });

        Route::group(['prefix' => 'comments'], function () {
            Route::post('/store', 'CommentController@store');
            Route::post('/{id}/reply', 'CommentController@storeReply');
            Route::post('/{id}/update', 'CommentController@update');
            Route::post('/{id}/report', 'CommentController@report');
            Route::get('/{id}/delete', 'CommentController@destroy');
        });

        Route::group(['prefix' => 'cart'], function () {
            Route::get('/', 'CartController@index');
            Route::post('/coupon/validate', 'CartController@couponValidate');
            Route::post('/checkout', 'CartController@checkout')->name('checkout');
            Route::post('/deposit/select', 'CartController@depositSelectOption')->name('depositSelect');
            Route::get('/payment/callback', 'CartController@callback')->name('payment.callback');


        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/{id}/follow', 'UserController@followToggle');
        });

        Route::group(['prefix' => 'become-instructor'], function () {
            Route::get('/', 'BecomeInstructorController@index')->name('becomeInstructor');
            Route::get('/packages', 'BecomeInstructorController@packages')->name('becomeInstructorPackages');
            Route::get('/packages/{id}/checkHasInstallment', 'BecomeInstructorController@checkPackageHasInstallment');
            Route::get('/packages/{id}/installments', 'BecomeInstructorController@getInstallmentsByRegistrationPackage');
            Route::post('/', 'BecomeInstructorController@store');
            Route::post('/form-fields', 'BecomeInstructorController@getFormFieldsByUserType');
        });

    });

    Route::group(['prefix' => 'meetings'], function () {
        Route::post('/reserve', 'MeetingController@reserve');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/{id}/profile', 'UserController@profile');
        Route::post('/{id}/availableTimes', 'UserController@availableTimes');
        Route::post('/{id}/send-message', 'UserController@sendMessage');
    });

    Route::group(['prefix' => 'payments'], function () {
        Route::post('/payment-request', 'PaymentController@paymentRequest');
        Route::get('/verify/{gateway}', ['as' => 'payment_verify', 'uses' => 'PaymentController@paymentVerify']);
        Route::post('/verify/{gateway}', ['as' => 'payment_verify_post', 'uses' => 'PaymentController@paymentVerify']);
        Route::get('/status', 'PaymentController@payStatus');
        Route::get('/payku/callback/{id}', 'PaymentController@paykuPaymentVerify')->name('payku.result');
           //for  new payment gateway like  mada
        Route::get('/confirm-payment/{id}/{resourcePath}', 'PaymentController@confirm_payment')->name('payments.success_paymentss');

    });

    Route::group(['prefix' => 'subscribes'], function () {
        Route::get('/apply/{webinarSlug}', 'SubscribeController@apply');
        Route::get('/apply/bundle/{bundleSlug}', 'SubscribeController@bundleApply');
    });

    Route::group(['prefix' => 'search'], function () {
        Route::get('/', 'SearchController@index');
    });

    Route::group(['prefix' => 'tags'], function () {
        Route::get('/{type}/{tag}', 'TagsController@index');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/{categoryTitle}/{subCategoryTitle?}', 'CategoriesController@index');
    });

    Route::group(['prefix' => 'canada'], function () {
        Route::group(['prefix' => 'categories'], function () {
            Route::get('{categoryTitle}/{subCategoryTitle?}', 'CategoriesController@index_canada');
        });
    });

    Route::group(['prefix' => 'egy'], function () {
        Route::group(['prefix' => 'categories'], function () {
            Route::get('{categoryTitle}/{subCategoryTitle?}', 'CategoriesController@index_egy');
        });
    });
    Route::group(['prefix' => 'uae'], function () {
        Route::group(['prefix' => 'categories'], function () {
            Route::get('{categoryTitle}/{subCategoryTitle?}', 'CategoriesController@index_uae');
        });
    });

    Route::get('/classes', 'ClassesController@index');
    Route::get('/courses', 'ClassesController@index');
     Route::get('/courses/{categoryTitle?}/{subCategoryTitle?}', 'ClassesController@index');


    Route::post('/request-consulting', 'WebinarController@storeRequestConsulting')->name('store_request_consulting');
    Route::post('/request-course', 'WebinarController@storeRequestCourse')->name('store_request_course');

    Route::post('/event/register','HomeController@register')->name('event.register');

    Route::get('/reward-courses', 'RewardCoursesController@index');

    Route::group(['prefix' => 'blog'], function () {
        Route::get('/', 'BlogController@index');
        Route::get('/categories/{category}', 'BlogController@index');
        Route::get('/{slug}', 'BlogController@show');
    });

    Route::group(['prefix' => 'contact'], function () {
        Route::get('/', 'ContactController@index');
        Route::post('/store', 'ContactController@store');
    });

    Route::group(['prefix' => 'instructors'], function () {
        Route::get('/', 'UserController@instructors');
    });

    Route::group(['prefix' => 'organizations'], function () {
        Route::get('/', 'UserController@organizations');
    });

    Route::group(['prefix' => 'load_more'], function () {
        Route::get('/{role}', 'UserController@handleInstructorsOrOrganizationsPage');
    });

    Route::group(['prefix' => 'pages'], function () {
        Route::get('/{link}', 'PagesController@index');
    });
     Route::group(['prefix' => 'pages'], function () {
        Route::get('/egy/{link}', 'PagesController@index');
    });
     Route::group(['prefix' => 'pages'], function () {
        Route::get('/uae/{link}', 'PagesController@index');
    });


    // Captcha
    Route::group(['prefix' => 'captcha'], function () {
        Route::post('create', function () {
            $response = ['status' => 'success', 'captcha_src' => captcha_src('flat')];

            return response()->json($response);
        });
        Route::get('{config?}', '\Mews\Captcha\CaptchaController@getCaptcha');
    });

    Route::post('/newsletters', 'UserController@makeNewsletter');

    Route::group(['prefix' => 'jobs'], function () {
        Route::get('/{methodName}', 'JobsController@index');
        Route::post('/{methodName}', 'JobsController@index');
    });

    Route::group(['prefix' => 'regions'], function () {
        Route::get('/provincesByCountry/{countryId}', 'RegionController@provincesByCountry');
        Route::get('/citiesByProvince/{provinceId}', 'RegionController@citiesByProvince');
        Route::get('/districtsByCity/{cityId}', 'RegionController@districtsByCity');
    });

    Route::group(['prefix' => 'instructor-finder'], function () {
        Route::get('/', 'InstructorFinderController@index');
        Route::get('/wizard', 'InstructorFinderController@wizard');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', 'ProductController@searchLists');
        Route::get('/{slug}', 'ProductController@show');
        Route::post('/{slug}/points/apply', 'ProductController@buyWithPoint');

        Route::group(['prefix' => 'reviews'], function () {
            Route::post('/store', 'ProductReviewController@store');
            Route::post('/store-reply-comment', 'ProductReviewController@storeReplyComment');
            Route::get('/{id}/delete', 'ProductReviewController@destroy');
            Route::get('/{id}/delete-comment/{commentId}', 'ProductReviewController@destroy');
        });

        Route::group(['middleware' => 'web.auth'], function () {
            Route::get('/{slug}/installments', 'ProductController@getInstallmentsByProduct');
            Route::post('/direct-payment', 'ProductController@directPayment');
        });
    });

    Route::get('/reward-products', 'RewardProductsController@index');

    Route::group(['prefix' => 'bundles'], function () {
        Route::get('/{slug}', 'BundleController@index');
        Route::get('/{slug}/free', 'BundleController@free');

        Route::group(['middleware' => 'web.auth'], function () {
            Route::get('/{slug}/favorite', 'BundleController@favoriteToggle');
            Route::get('/{slug}/points/apply', 'BundleController@buyWithPoint');

            Route::group(['prefix' => 'reviews'], function () {
                Route::post('/store', 'BundleReviewController@store');
                Route::post('/store-reply-comment', 'BundleReviewController@storeReplyComment');
                Route::get('/{id}/delete', 'BundleReviewController@destroy');
                Route::get('/{id}/delete-comment/{commentId}', 'BundleReviewController@destroy');
            });

            Route::post('/direct-payment', 'BundleController@directPayment');
        });
    });

    Route::group(['prefix' => 'forums'], function () {
        Route::get('/', 'ForumController@index');
        Route::get('/create-topic', 'ForumController@createTopic');
        Route::post('/create-topic', 'ForumController@storeTopic');
        Route::get('/search', 'ForumController@search');

        Route::group(['prefix' => '/{slug}/topics'], function () {
            Route::get('/', 'ForumController@topics');
            Route::post('/{topic_slug}/likeToggle', 'ForumController@topicLikeToggle');
            Route::get('/{topic_slug}/edit', 'ForumController@topicEdit');
            Route::post('/{topic_slug}/edit', 'ForumController@topicUpdate');
            Route::post('/{topic_slug}/bookmark', 'ForumController@topicBookmarkToggle');
            Route::get('/{topic_slug}/downloadAttachment/{attachment_id}', 'ForumController@topicDownloadAttachment');

            Route::group(['prefix' => '/{topic_slug}/posts'], function () {
                Route::get('/', 'ForumController@posts');
                Route::post('/', 'ForumController@storePost');
                Route::post('/report', 'ForumController@storeTopicReport');
                Route::get('/{post_id}/edit', 'ForumController@postEdit');
                Route::post('/{post_id}/edit', 'ForumController@postUpdate');
                Route::post('/{post_id}/likeToggle', 'ForumController@postLikeToggle');
                Route::post('/{post_id}/un_pin', 'ForumController@postUnPin');
                Route::post('/{post_id}/pin', 'ForumController@postPin');
                Route::get('/{post_id}/downloadAttachment', 'ForumController@postDownloadAttachment');
            });
        });
    });


    Route::group(['prefix' => 'upcoming_courses'], function () {
        Route::get('/', 'UpcomingCoursesController@index');
        Route::get('{slug}', 'UpcomingCoursesController@show');
        Route::get('{slug}/toggleFollow', 'UpcomingCoursesController@toggleFollow');
        Route::get('{slug}/favorite', 'UpcomingCoursesController@favorite');
        Route::post('{id}/report', 'UpcomingCoursesController@report');
    });


    Route::group(['prefix' => 'installments'], function () {
        Route::group(['middleware' => 'web.auth'], function () {
            Route::get('/request_submitted', 'InstallmentsController@requestSubmitted');
            Route::get('/request_rejected', 'InstallmentsController@requestRejected');
            Route::get('/{id}', 'InstallmentsController@index');
            Route::post('/{id}/store', 'InstallmentsController@store');
        });
    });

    Route::group(['prefix' => 'waitlists'], function () {
        Route::post('/join', 'WaitlistController@store');
    });

    Route::group(['prefix' => 'gift'], function () {
        Route::group(['middleware' => 'web.auth'], function () {
            Route::get('/{item_type}/{item_slug}', 'GiftController@index');
            Route::post('/{item_type}/{item_slug}', 'GiftController@store');
        });
    });

    /* Forms */
    Route::get('/forms/{url}', 'FormsController@index');
    Route::post('/forms/{url}/store', 'FormsController@store');
    /* teacher form */
     Route::get('/teacher_form', 'FormsController@teacherTanks');
     Route::post('/teacher_form/store', 'FormsController@teacherForm');

});

Route::get('/egy', function () {
    return redirect('/' . app()->getLocale() . '/egy');
});
Route::get('/uae', function () {
     return redirect('/' . app()->getLocale() . '/uae');
});
