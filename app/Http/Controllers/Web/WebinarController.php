<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\traits\CheckContentLimitationTrait;
use App\Http\Controllers\Web\traits\InstallmentsTrait;
use App\Mixins\Cashback\CashbackRules;
use App\Mixins\Installment\InstallmentPlans;
use App\Models\AdvertisingBanner;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\Favorite;
use App\Models\File;
use App\Models\QuizzesResult;
use App\Models\RewardAccounting;
use App\Models\Sale;
use App\Models\TextLesson;
use App\Models\CourseLearning;
use App\Models\WebinarChapter;
use App\Models\WebinarReport;
use App\Models\Quiz;
use App\Models\Webinar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\XapiService;

use Illuminate\Support\Facades\File as LaravelFile; // مهم
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\ScormSession;
use Illuminate\Support\Str;

class WebinarController extends Controller
{
    use CheckContentLimitationTrait;
    use InstallmentsTrait;
      protected $xapiService;

    public function __construct(XapiService $xapiService = null)
    {
        $this->xapiService = $xapiService;
    }
    
    public function saveProgress(Request $request)
    {
    $data = json_decode($request->getContent(), true);

    Log::info('Raw Request Body:', [$request->getContent()]);
    Log::info('Parsed Data:', $data ?? []);

    $userId = $data['user_id'] ?? null;
    $fileId = $data['file_id'] ?? null;

    if (!$userId || !$fileId) {
        Log::warning('Missing user_id or file_id');
        return response()->json(['status' => 'error', 'message' => 'Missing required data'], 400);
    }

    $dataToSave = [
        'user_id' => $userId,
        'file_id' => $fileId,
        'webinar_id' => $data['webinar_id'] ?? null,
        'last_accessed' => now()->toIso8601String(),
        'progress_percent' => $data['progress_percent'] ?? 0,
        'last_section_completed' => $data['last_section_completed'] ?? null,
        'quiz' => $data['quiz'] ?? ['completed' => false, 'score' => null]
    ];

    $directory = 'scorm_progress';
    $filePath = "$directory/user_{$userId}_file_{$fileId}.json";

    try {
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        Storage::put($filePath, json_encode($dataToSave, JSON_PRETTY_PRINT));
        Log::info('SCORM progress saved successfully at ' . $filePath, $dataToSave);
        Log::info('--- SCORM Request END ---');
        return response()->json(['status' => 'saved']);
    } catch (\Exception $e) {
        Log::error('SCORM Save Error: ' . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Failed to save'], 500);
    }
}

    public function asset(string $folder, ?string $path = null)
    {
        $disk = Storage::disk('local');
        $safeFolder = trim(str_replace(['..', '\\', '/'], ['','/',''], $folder), '/');
        // Our extractFolder is prefixed with 'scorm/'
        $baseDir = $disk->path('scorm/' . $safeFolder);

        if (!is_dir($baseDir)) {
            abort(404);
        }

        $requestedPath = $path ?? '';
        $requestedPath = ltrim($requestedPath, '/');
        $requestedPath = str_replace(['..', '\\'], ['', '/'], $requestedPath);

        $fullPath = $baseDir . DIRECTORY_SEPARATOR . ($requestedPath === '' ? 'index.html' : $requestedPath);
        $fullPath = realpath($fullPath) ?: $fullPath;

        // ensure the resolved path is inside the base dir
        $normalizedFull = str_replace('\\', '/', $fullPath);
        $normalizedBase = rtrim(str_replace('\\', '/', realpath($baseDir) ?: $baseDir), '/');
        if (strpos($normalizedFull, $normalizedBase) !== 0 || !file_exists($normalizedFull)) {
            abort(404);
        }

        if (is_dir($normalizedFull)) {
            // If requesting a directory, try index.html
            $indexPath = $normalizedFull . '/index.html';
            if (file_exists($indexPath)) {
                $normalizedFull = $indexPath;
            } else {
                abort(404);
            }
        }

        return response()->file($normalizedFull);
    }

    public function solve($folder, $path = null)
    {
        $filePath = public_path("store/scorm/{$folder}/{$path}");
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }
    
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    
        $mimeTypes = [
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'html' => 'text/html',
            'htm'  => 'text/html',
            'xml'  => 'application/xml',
            'json' => 'application/json',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
        ];
    
        $mimeType = $mimeTypes[$extension] ?? \Illuminate\Support\Facades\File::mimeType($filePath);
    
        return response()->file($filePath, [
            'Content-Type' => $mimeType
        ]);
}

    public function initialize(Request $request)
    {
    $user = $request->user();
    $webinarId = $request->input('webinar_id');
        
        $quiz = Quiz::where('webinar_id', $webinarId)->first();

        if (!$quiz) {
            $quiz = Quiz::create([
                'webinar_id' => $webinarId,
                'chapter_id' => null,
                'creator_id' => $user->id,
                'attempt' => null,
                'pass_mark' => 0,
                'time' => null,
                'status' => Quiz::INACTIVE,
                'certificate' => 0,
                'display_questions_randomly' => 0,
                'expiry_days' => null,
                'created_at' => time(),
                'branch_id' => $user->branch_id ?? null,
            ]);
        }
        
        $newQuizStart = QuizzesResult::create([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'results' => '',
            'user_grade' => 0,
            'status' => 'waiting',
            'created_at' => time()
        ]);
        
        $session = ScormSession::create([
            'user_id' => $user->id,
            'webinar_id' => $webinarId ,
            'session_id' => Str::uuid()->toString(),
            'data' => [],
            'initialized_at' => now(),
            'quiz_result_id' => $newQuizStart->id,
            'branch_id' => auth()->user()->branch_id,
            
        ]);

        
    return response()->json(['result' => 'true', 'session_id' => $session->session_id]);
    }

    // SetValue
    public function setValue(Request $request)
    {
        $sessionId = $request->input('session_id');
        $key = $request->input('key');
        $value = $request->input('value');

        $session = ScormSession::where('session_id', $sessionId)->firstOrFail();

        $data = $session->data ?? [];
        data_set($data, $key, $value); // يحط القيمة في JSON كـ nested key
        $session->data = $data;
        $session->last_interaction_at = now();
        $session->save();

        return response()->json(['result' => 'true']);
    }

    // GetValue
    public function getValue(Request $request)
    {
        $sessionId = $request->input('session_id');
        $key = $request->input('key');

        $session = ScormSession::where('session_id', $sessionId)->first();

        $value = '';
        if ($session) {
            $value = data_get($session->data ?? [], $key, '');
        }

        return response()->json(['value' => $value]);
    }

    // Commit (save to DB - but we already save on setValue)
    public function commit(Request $request)
    {
        $sessionId = $request->input('session_id');
        $session = ScormSession::where('session_id', $sessionId)->firstOrFail();

        $session->last_interaction_at = now();
        $session->save();

        return response()->json(['result' => 'true']);
    }

    // Finish
    public function finish(Request $request)
    {
        $sessionId = $request->input('session_id');
        $session = ScormSession::where('session_id', $sessionId)->firstOrFail();

        $score = data_get($session->data ?? [], 'cmi.core.score.raw', data_get($session->data, 'cmi.score.raw', null));
        if ($score !== null) {
            $session->score = (float)$score;
        }

        // حالة الإنجاز
        $status = data_get($session->data ?? [], 'cmi.core.lesson_status', data_get($session->data, 'cmi.completion_status', null));
        if (in_array(strtolower($status), ['completed','passed'])) {
            $session->completed = true;
        }

        $session->last_interaction_at = now();
        $session->save();
        
        $quizResult = QuizzesResult::where('id', $session->quiz_result_id)->where('user_id', $session->user_id)->first();
        
        $quizResult->update([
            'results' => json_encode($session->data),
            'user_grade' => $score,
            'status' => $session->completed ? 'passed' : 'failed',
            'updated_at' => now(),
        ]);

        return response()->json(['result' => 'true']);
    }



    public function getLastError(Request $request)
    {
        return response()->json(['error' => 0]);
    }
    
    public function course($slug, $justReturnData = false)
    {
        $user = null;

        if (auth()->check()) {
            $user = auth()->user();
        }
        
    


        if (!$justReturnData) {
            $contentLimitation = $this->checkContentLimitation($user, true);
            if ($contentLimitation != "ok") {
                return $contentLimitation;
            }
        }
        

                $course = Webinar::where('slug', $slug)
                ->with([
                'quizzes' => function ($query) {
                    $query->where('status', 'active')
                        ->with(['quizResults', 'quizQuestions']);
                },
                'tags',
                'prerequisites' => function ($query) {
                    $query->with(['prerequisiteWebinar' => function ($query) {
                        $query->with(['teacher' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }]);
                    }]);
                    $query->orderBy('order', 'asc');
                },
                'relatedCourses' => function ($query) {
                    $query->whereHas('course', function ($query) {
                        $query->where('status', 'active');
                    });
                },
                'faqs' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'webinarExtraDescription' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'chapters' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive);
                    $query->orderBy('order', 'asc');

                    $query->with([
                        'chapterItems' => function ($query) {
                            $query->orderBy('order', 'asc');
                        }
                    ]);
                },
                'files' => function ($query) use ($user) {
                    $query->join('webinar_chapters', 'webinar_chapters.id', '=', 'files.chapter_id')
                        ->select('files.*', DB::raw('webinar_chapters.order as chapterOrder'))
                        ->where('files.status', WebinarChapter::$chapterActive)
                        ->orderBy('chapterOrder', 'asc')
                        ->orderBy('files.order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'textLessons' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->withCount(['attachments'])
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'sessions' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'assignments' => function ($query) {
                    $query->where('status', WebinarChapter::$chapterActive);
                },
                'tickets' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'filterOptions',
                'category',
                'teacher',
                'reviews' => function ($query) {
                    $query->where('status', 'active');
                    $query->with([
                        'comments' => function ($query) {
                            $query->where('status', 'active');
                        },
                        'creator' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }
                    ]);
                },
                'comments' => function ($query) {
                    $query->where('status', 'active');
                    $query->whereNull('reply_id');
                    $query->with([
                        'user' => function ($query) {
                            $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                        },
                        'replies' => function ($query) {
                            $query->where('status', 'active');
                            $query->with([
                                'user' => function ($query) {
                                    $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                                }
                            ]);
                        }
                    ]);
                    $query->orderBy('created_at', 'desc');
                },
            ])
            ->withCount([
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                },
                'noticeboards'
            ])
            ->where('status', 'active')
            ->first();

        if (empty($course)) {
            return $justReturnData ? false : back();
        }

        if (!$justReturnData) {

            /* Check Not Active */
            if ($course->status != "active" and (empty($user) or (!$user->isAdmin() and !$course->canAccess($user)))) {
                $data = [
                    'pageTitle' => trans('update.access_denied'),
                    'pageRobot' => getPageRobotNoIndex(),
                ];
                return view('web.default.course.not_access', $data);
            }

            /* Installment Check */
            $installmentLimitation = $this->installmentContentLimitation($user, $course->id, 'webinar_id');

            if ($installmentLimitation != "ok") {
                return $installmentLimitation;
            }
        }

        $hasBought = $course->checkUserHasBought($user, true, true);
        $isPrivate = $course->private;

        if (!empty($user) and ($user->id == $course->creator_id or $user->organ_id == $course->creator_id or $user->isAdmin())) {
            $isPrivate = false;
        }

        if ($isPrivate and $hasBought) { // check the user has bought the course or not
            $isPrivate = false;
        }

        if ($isPrivate) {
            return $justReturnData ? false : back();
        }

        $isFavorite = false;

        if (!empty($user)) {
            $isFavorite = Favorite::where('webinar_id', $course->id)
                ->where('user_id', $user->id)
                ->first();
        }

        $webinarContentCount = 0;
        if (!empty($course->sessions)) {
            $webinarContentCount += $course->sessions->count();
        }
        if (!empty($course->files)) {
            $webinarContentCount += $course->files->count();
        }
        if (!empty($course->textLessons)) {
            $webinarContentCount += $course->textLessons->count();
        }
        if (!empty($course->quizzes)) {
            $webinarContentCount += $course->quizzes->count();
        }
        if (!empty($course->assignments)) {
            $webinarContentCount += $course->assignments->count();
        }

        $advertisingBanners = AdvertisingBanner::where('published', true)
            ->whereIn('position', ['course', 'course_sidebar'])
            ->get();

        $sessionsWithoutChapter = $course->sessions->whereNull('chapter_id');

        $filesWithoutChapter = $course->files->whereNull('chapter_id');

        $textLessonsWithoutChapter = $course->textLessons->whereNull('chapter_id');

        $quizzes = $course->quizzes->whereNull('chapter_id');

        if ($user) {
            $quizzes = $this->checkQuizzesResults($user, $quizzes);

            if (!empty($course->chapters) and count($course->chapters)) {
                foreach ($course->chapters as $chapter) {
                    if (!empty($chapter->chapterItems) and count($chapter->chapterItems)) {
                        foreach ($chapter->chapterItems as $chapterItem) {
                            if (!empty($chapterItem->quiz)) {
                                $chapterItem->quiz = $this->checkQuizResults($user, $chapterItem->quiz);
                            }
                        }
                    }
                }
            }

            if (!empty($course->quizzes) and count($course->quizzes)) {
                $course->quizzes = $this->checkQuizzesResults($user, $course->quizzes);
            }
        }

        $pageRobot = getPageRobot('course_show'); // index
        $canSale = ($course->canSale() and !$hasBought);

        /* Installments */
        $showInstallments = true;
        $overdueInstallmentOrders = $this->checkUserHasOverdueInstallment($user);

        if ($overdueInstallmentOrders->isNotEmpty() and getInstallmentsSettings('disable_instalments_when_the_user_have_an_overdue_installment')) {
            $showInstallments = false;
        }

        if ($canSale and !empty($course->price) and $course->price > 0 and $showInstallments and getInstallmentsSettings('status') and (empty($user) or $user->enable_installments)) {
            $installmentPlans = new InstallmentPlans($user);
            $installments = $installmentPlans->getPlans('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        /* Cashback Rules */
        if ($canSale and !empty($course->price) and getFeaturesSettings('cashback_active') and (empty($user) or !$user->disable_cashback)) {
            $cashbackRulesMixin = new CashbackRules($user);
            $cashbackRules = $cashbackRulesMixin->getRules('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        $instructorDiscounts = null;

        if (!empty(getFeaturesSettings('frontend_coupons_status'))) {
            $instructorDiscounts = Discount::query()
                ->where(function (Builder $query) use ($course) {
                    $query->where('creator_id', $course->creator_id);
                    $query->orWhere('creator_id', $course->teacher_id);
                })
                ->where(function (Builder $query) use ($course) {
                    $query->where('source', 'all');
                    $query->orWhere(function (Builder $query) use ($course) {
                        $query->where('source', Discount::$discountSourceCourse);

                        $query->where(function (Builder $query) use ($course) {
                            $query->whereHas('discountCourses', function ($query) use ($course) {
                                $query->where('course_id', $course->id);
                            });

                            $query->whereDoesntHave('discountCourses');
                        });
                    });
                })
                ->where('status', 'active')
                ->where('expired_at', '>', time())
                ->get();
        }

        $data = [
            'pageTitle' => $course->title,
            'pageDescription' => $course->seo_description,
            'pageRobot' => $pageRobot,
            'pageMetaImage' => $course->getImage(),
            'course' => $course,
            'isFavorite' => $isFavorite,
            'hasBought' => $hasBought,
            'user' => $user,
            'webinarContentCount' => $webinarContentCount,
            'advertisingBanners' => $advertisingBanners->where('position', 'course'),
            'advertisingBannersSidebar' => $advertisingBanners->where('position', 'course_sidebar'),
            'activeSpecialOffer' => $course->activeSpecialOffer(),
            'sessionsWithoutChapter' => $sessionsWithoutChapter,
            'filesWithoutChapter' => $filesWithoutChapter,
            'textLessonsWithoutChapter' => $textLessonsWithoutChapter,
            'quizzes' => $quizzes,
            'installments' => $installments ?? null,
            'cashbackRules' => $cashbackRules ?? null,
            'instructorDiscounts' => $instructorDiscounts,
        ];

        // check for certificate
        if (!empty($user)) {
            $course->makeCertificateForUser($user);
        }

        if ($justReturnData) {
            return $data;
        }
          /* if($course->type=="text_lesson"){

            return view('web.default.course.textcourse', $data);

        }*/

        return view('web.default.course.index', $data);
    }
    
    public function course_canada($slug, $justReturnData = false)
    {
        $user = null;

        if (auth()->check()) {
            $user = auth()->user();
        }
        
        if (!$justReturnData) {
            $contentLimitation = $this->checkContentLimitation($user, true);
            if ($contentLimitation != "ok") {
                return $contentLimitation;
            }
        }
        

                $course = Webinar::where('slug', $slug)
                ->with([
                'quizzes' => function ($query) {
                    $query->where('status', 'active')
                        ->with(['quizResults', 'quizQuestions']);
                },
                'tags',
                'prerequisites' => function ($query) {
                    $query->with(['prerequisiteWebinar' => function ($query) {
                        $query->with(['teacher' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }]);
                    }]);
                    $query->orderBy('order', 'asc');
                },
                'relatedCourses' => function ($query) {
                    $query->whereHas('course', function ($query) {
                        $query->where('status', 'active');
                    });
                },
                'faqs' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'webinarExtraDescription' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'chapters' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive);
                    $query->orderBy('order', 'asc');

                    $query->with([
                        'chapterItems' => function ($query) {
                            $query->orderBy('order', 'asc');
                        }
                    ]);
                },
                'files' => function ($query) use ($user) {
                    $query->join('webinar_chapters', 'webinar_chapters.id', '=', 'files.chapter_id')
                        ->select('files.*', DB::raw('webinar_chapters.order as chapterOrder'))
                        ->where('files.status', WebinarChapter::$chapterActive)
                        ->orderBy('chapterOrder', 'asc')
                        ->orderBy('files.order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'textLessons' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->withCount(['attachments'])
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'sessions' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'assignments' => function ($query) {
                    $query->where('status', WebinarChapter::$chapterActive);
                },
                'tickets' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'filterOptions',
                'category',
                'teacher',
                'reviews' => function ($query) {
                    $query->where('status', 'active');
                    $query->with([
                        'comments' => function ($query) {
                            $query->where('status', 'active');
                        },
                        'creator' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }
                    ]);
                },
                'comments' => function ($query) {
                    $query->where('status', 'active');
                    $query->whereNull('reply_id');
                    $query->with([
                        'user' => function ($query) {
                            $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                        },
                        'replies' => function ($query) {
                            $query->where('status', 'active');
                            $query->with([
                                'user' => function ($query) {
                                    $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                                }
                            ]);
                        }
                    ]);
                    $query->orderBy('created_at', 'desc');
                },
            ])
            ->withCount([
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                },
                'noticeboards'
            ])
            ->where('status', 'active')
            ->first();

        if (empty($course)) {
            return $justReturnData ? false : back();
        }

        if (!$justReturnData) {

            /* Check Not Active */
            if ($course->status != "active" and (empty($user) or (!$user->isAdmin() and !$course->canAccess($user)))) {
                $data = [
                    'pageTitle' => trans('update.access_denied'),
                    'pageRobot' => getPageRobotNoIndex(),
                ];
                return view('web.default.course.not_access', $data);
            }

            /* Installment Check */
            $installmentLimitation = $this->installmentContentLimitation($user, $course->id, 'webinar_id');

            if ($installmentLimitation != "ok") {
                return $installmentLimitation;
            }
        }

        $hasBought = $course->checkUserHasBought($user, true, true);
        $isPrivate = $course->private;

        if (!empty($user) and ($user->id == $course->creator_id or $user->organ_id == $course->creator_id or $user->isAdmin())) {
            $isPrivate = false;
        }

        if ($isPrivate and $hasBought) { // check the user has bought the course or not
            $isPrivate = false;
        }

        if ($isPrivate) {
            return $justReturnData ? false : back();
        }

        $isFavorite = false;

        if (!empty($user)) {
            $isFavorite = Favorite::where('webinar_id', $course->id)
                ->where('user_id', $user->id)
                ->first();
        }

        $webinarContentCount = 0;
        if (!empty($course->sessions)) {
            $webinarContentCount += $course->sessions->count();
        }
        if (!empty($course->files)) {
            $webinarContentCount += $course->files->count();
        }
        if (!empty($course->textLessons)) {
            $webinarContentCount += $course->textLessons->count();
        }
        if (!empty($course->quizzes)) {
            $webinarContentCount += $course->quizzes->count();
        }
        if (!empty($course->assignments)) {
            $webinarContentCount += $course->assignments->count();
        }

        $advertisingBanners = AdvertisingBanner::where('published', true)
            ->whereIn('position', ['course', 'course_sidebar'])
            ->get();

        $sessionsWithoutChapter = $course->sessions->whereNull('chapter_id');

        $filesWithoutChapter = $course->files->whereNull('chapter_id');

        $textLessonsWithoutChapter = $course->textLessons->whereNull('chapter_id');

        $quizzes = $course->quizzes->whereNull('chapter_id');

        if ($user) {
            $quizzes = $this->checkQuizzesResults($user, $quizzes);

            if (!empty($course->chapters) and count($course->chapters)) {
                foreach ($course->chapters as $chapter) {
                    if (!empty($chapter->chapterItems) and count($chapter->chapterItems)) {
                        foreach ($chapter->chapterItems as $chapterItem) {
                            if (!empty($chapterItem->quiz)) {
                                $chapterItem->quiz = $this->checkQuizResults($user, $chapterItem->quiz);
                            }
                        }
                    }
                }
            }

            if (!empty($course->quizzes) and count($course->quizzes)) {
                $course->quizzes = $this->checkQuizzesResults($user, $course->quizzes);
            }
        }

        $pageRobot = getPageRobot('course_show'); // index
        $canSale = ($course->canSale() and !$hasBought);

        /* Installments */
        $showInstallments = true;
        $overdueInstallmentOrders = $this->checkUserHasOverdueInstallment($user);

        if ($overdueInstallmentOrders->isNotEmpty() and getInstallmentsSettings('disable_instalments_when_the_user_have_an_overdue_installment')) {
            $showInstallments = false;
        }

        if ($canSale and !empty($course->price) and $course->price > 0 and $showInstallments and getInstallmentsSettings('status') and (empty($user) or $user->enable_installments)) {
            $installmentPlans = new InstallmentPlans($user);
            $installments = $installmentPlans->getPlans('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        /* Cashback Rules */
        if ($canSale and !empty($course->price) and getFeaturesSettings('cashback_active') and (empty($user) or !$user->disable_cashback)) {
            $cashbackRulesMixin = new CashbackRules($user);
            $cashbackRules = $cashbackRulesMixin->getRules('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        $instructorDiscounts = null;

        if (!empty(getFeaturesSettings('frontend_coupons_status'))) {
            $instructorDiscounts = Discount::query()
                ->where(function (Builder $query) use ($course) {
                    $query->where('creator_id', $course->creator_id);
                    $query->orWhere('creator_id', $course->teacher_id);
                })
                ->where(function (Builder $query) use ($course) {
                    $query->where('source', 'all');
                    $query->orWhere(function (Builder $query) use ($course) {
                        $query->where('source', Discount::$discountSourceCourse);

                        $query->where(function (Builder $query) use ($course) {
                            $query->whereHas('discountCourses', function ($query) use ($course) {
                                $query->where('course_id', $course->id);
                            });

                            $query->whereDoesntHave('discountCourses');
                        });
                    });
                })
                ->where('status', 'active')
                ->where('expired_at', '>', time())
                ->get();
        }

        $data = [
            'pageTitle' => $course->title,
            'pageDescription' => $course->seo_description,
            'pageRobot' => $pageRobot,
            'pageMetaImage' => $course->getImage(),
            'course' => $course,
            'isFavorite' => $isFavorite,
            'hasBought' => $hasBought,
            'user' => $user,
            'webinarContentCount' => $webinarContentCount,
            'advertisingBanners' => $advertisingBanners->where('position', 'course'),
            'advertisingBannersSidebar' => $advertisingBanners->where('position', 'course_sidebar'),
            'activeSpecialOffer' => $course->activeSpecialOffer(),
            'sessionsWithoutChapter' => $sessionsWithoutChapter,
            'filesWithoutChapter' => $filesWithoutChapter,
            'textLessonsWithoutChapter' => $textLessonsWithoutChapter,
            'quizzes' => $quizzes,
            'installments' => $installments ?? null,
            'cashbackRules' => $cashbackRules ?? null,
            'instructorDiscounts' => $instructorDiscounts,
        ];

        // check for certificate
        if (!empty($user)) {
            $course->makeCertificateForUser($user);
        }

        if ($justReturnData) {
            return $data;
        }
          /* if($course->type=="text_lesson"){

            return view('web.default.course.textcourse', $data);

        }*/

        return view('web.default.course.index_canada', $data);
    }
    public function course_egy($slug, $justReturnData = false)
    {
        $user = null;

        if (auth()->check()) {
            $user = auth()->user();
        }
        
        if (!$justReturnData) {
            $contentLimitation = $this->checkContentLimitation($user, true);
            if ($contentLimitation != "ok") {
                return $contentLimitation;
            }
        }
        

                $course = Webinar::where('slug', $slug)
                ->with([
                'quizzes' => function ($query) {
                    $query->where('status', 'active')
                        ->with(['quizResults', 'quizQuestions']);
                },
                'tags',
                'prerequisites' => function ($query) {
                    $query->with(['prerequisiteWebinar' => function ($query) {
                        $query->with(['teacher' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }]);
                    }]);
                    $query->orderBy('order', 'asc');
                },
                'relatedCourses' => function ($query) {
                    $query->whereHas('course', function ($query) {
                        $query->where('status', 'active');
                    });
                },
                'faqs' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'webinarExtraDescription' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'chapters' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive);
                    $query->orderBy('order', 'asc');

                    $query->with([
                        'chapterItems' => function ($query) {
                            $query->orderBy('order', 'asc');
                        }
                    ]);
                },
                'files' => function ($query) use ($user) {
                    $query->join('webinar_chapters', 'webinar_chapters.id', '=', 'files.chapter_id')
                        ->select('files.*', DB::raw('webinar_chapters.order as chapterOrder'))
                        ->where('files.status', WebinarChapter::$chapterActive)
                        ->orderBy('chapterOrder', 'asc')
                        ->orderBy('files.order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'textLessons' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->withCount(['attachments'])
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'sessions' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'assignments' => function ($query) {
                    $query->where('status', WebinarChapter::$chapterActive);
                },
                'tickets' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'filterOptions',
                'category',
                'teacher',
                'reviews' => function ($query) {
                    $query->where('status', 'active');
                    $query->with([
                        'comments' => function ($query) {
                            $query->where('status', 'active');
                        },
                        'creator' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }
                    ]);
                },
                'comments' => function ($query) {
                    $query->where('status', 'active');
                    $query->whereNull('reply_id');
                    $query->with([
                        'user' => function ($query) {
                            $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                        },
                        'replies' => function ($query) {
                            $query->where('status', 'active');
                            $query->with([
                                'user' => function ($query) {
                                    $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                                }
                            ]);
                        }
                    ]);
                    $query->orderBy('created_at', 'desc');
                },
            ])
            ->withCount([
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                },
                'noticeboards'
            ])
            ->where('status', 'active')
            ->first();

        if (empty($course)) {
            return $justReturnData ? false : back();
        }

        if (!$justReturnData) {

            /* Check Not Active */
            if ($course->status != "active" and (empty($user) or (!$user->isAdmin() and !$course->canAccess($user)))) {
                $data = [
                    'pageTitle' => trans('update.access_denied'),
                    'pageRobot' => getPageRobotNoIndex(),
                ];
                return view('web.default.course.not_access', $data);
            }

            /* Installment Check */
            $installmentLimitation = $this->installmentContentLimitation($user, $course->id, 'webinar_id');

            if ($installmentLimitation != "ok") {
                return $installmentLimitation;
            }
        }

        $hasBought = $course->checkUserHasBought($user, true, true);
        $isPrivate = $course->private;

        if (!empty($user) and ($user->id == $course->creator_id or $user->organ_id == $course->creator_id or $user->isAdmin())) {
            $isPrivate = false;
        }

        if ($isPrivate and $hasBought) { // check the user has bought the course or not
            $isPrivate = false;
        }

        if ($isPrivate) {
            return $justReturnData ? false : back();
        }

        $isFavorite = false;

        if (!empty($user)) {
            $isFavorite = Favorite::where('webinar_id', $course->id)
                ->where('user_id', $user->id)
                ->first();
        }

        $webinarContentCount = 0;
        if (!empty($course->sessions)) {
            $webinarContentCount += $course->sessions->count();
        }
        if (!empty($course->files)) {
            $webinarContentCount += $course->files->count();
        }
        if (!empty($course->textLessons)) {
            $webinarContentCount += $course->textLessons->count();
        }
        if (!empty($course->quizzes)) {
            $webinarContentCount += $course->quizzes->count();
        }
        if (!empty($course->assignments)) {
            $webinarContentCount += $course->assignments->count();
        }

        $advertisingBanners = AdvertisingBanner::where('published', true)
            ->whereIn('position', ['course', 'course_sidebar'])
            ->get();

        $sessionsWithoutChapter = $course->sessions->whereNull('chapter_id');

        $filesWithoutChapter = $course->files->whereNull('chapter_id');

        $textLessonsWithoutChapter = $course->textLessons->whereNull('chapter_id');

        $quizzes = $course->quizzes->whereNull('chapter_id');

        if ($user) {
            $quizzes = $this->checkQuizzesResults($user, $quizzes);

            if (!empty($course->chapters) and count($course->chapters)) {
                foreach ($course->chapters as $chapter) {
                    if (!empty($chapter->chapterItems) and count($chapter->chapterItems)) {
                        foreach ($chapter->chapterItems as $chapterItem) {
                            if (!empty($chapterItem->quiz)) {
                                $chapterItem->quiz = $this->checkQuizResults($user, $chapterItem->quiz);
                            }
                        }
                    }
                }
            }

            if (!empty($course->quizzes) and count($course->quizzes)) {
                $course->quizzes = $this->checkQuizzesResults($user, $course->quizzes);
            }
        }

        $pageRobot = getPageRobot('course_show'); // index
        $canSale = ($course->canSale() and !$hasBought);

        /* Installments */
        $showInstallments = true;
        $overdueInstallmentOrders = $this->checkUserHasOverdueInstallment($user);

        if ($overdueInstallmentOrders->isNotEmpty() and getInstallmentsSettings('disable_instalments_when_the_user_have_an_overdue_installment')) {
            $showInstallments = false;
        }

        if ($canSale and !empty($course->price) and $course->price > 0 and $showInstallments and getInstallmentsSettings('status') and (empty($user) or $user->enable_installments)) {
            $installmentPlans = new InstallmentPlans($user);
            $installments = $installmentPlans->getPlans('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        /* Cashback Rules */
        if ($canSale and !empty($course->price) and getFeaturesSettings('cashback_active') and (empty($user) or !$user->disable_cashback)) {
            $cashbackRulesMixin = new CashbackRules($user);
            $cashbackRules = $cashbackRulesMixin->getRules('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        $instructorDiscounts = null;

        if (!empty(getFeaturesSettings('frontend_coupons_status'))) {
            $instructorDiscounts = Discount::query()
                ->where(function (Builder $query) use ($course) {
                    $query->where('creator_id', $course->creator_id);
                    $query->orWhere('creator_id', $course->teacher_id);
                })
                ->where(function (Builder $query) use ($course) {
                    $query->where('source', 'all');
                    $query->orWhere(function (Builder $query) use ($course) {
                        $query->where('source', Discount::$discountSourceCourse);

                        $query->where(function (Builder $query) use ($course) {
                            $query->whereHas('discountCourses', function ($query) use ($course) {
                                $query->where('course_id', $course->id);
                            });

                            $query->whereDoesntHave('discountCourses');
                        });
                    });
                })
                ->where('status', 'active')
                ->where('expired_at', '>', time())
                ->get();
        }

        $data = [
            'pageTitle' => $course->title,
            'pageDescription' => $course->seo_description,
            'pageRobot' => $pageRobot,
            'pageMetaImage' => $course->getImage(),
            'course' => $course,
            'isFavorite' => $isFavorite,
            'hasBought' => $hasBought,
            'user' => $user,
            'webinarContentCount' => $webinarContentCount,
            'advertisingBanners' => $advertisingBanners->where('position', 'course'),
            'advertisingBannersSidebar' => $advertisingBanners->where('position', 'course_sidebar'),
            'activeSpecialOffer' => $course->activeSpecialOffer(),
            'sessionsWithoutChapter' => $sessionsWithoutChapter,
            'filesWithoutChapter' => $filesWithoutChapter,
            'textLessonsWithoutChapter' => $textLessonsWithoutChapter,
            'quizzes' => $quizzes,
            'installments' => $installments ?? null,
            'cashbackRules' => $cashbackRules ?? null,
            'instructorDiscounts' => $instructorDiscounts,
        ];

        // check for certificate
        if (!empty($user)) {
            $course->makeCertificateForUser($user);
        }

        if ($justReturnData) {
            return $data;
        }
          /* if($course->type=="text_lesson"){

            return view('web.default.course.textcourse', $data);

        }*/

        return view('web.default.course.index_egy', $data);
    }
    public function course_uae($slug, $justReturnData = false)
    {
        $user = null;

        if (auth()->check()) {
            $user = auth()->user();
        }
        
        if (!$justReturnData) {
            $contentLimitation = $this->checkContentLimitation($user, true);
            if ($contentLimitation != "ok") {
                return $contentLimitation;
            }
        }
        

                $course = Webinar::where('slug', $slug)
                ->with([
                'quizzes' => function ($query) {
                    $query->where('status', 'active')
                        ->with(['quizResults', 'quizQuestions']);
                },
                'tags',
                'prerequisites' => function ($query) {
                    $query->with(['prerequisiteWebinar' => function ($query) {
                        $query->with(['teacher' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }]);
                    }]);
                    $query->orderBy('order', 'asc');
                },
                'relatedCourses' => function ($query) {
                    $query->whereHas('course', function ($query) {
                        $query->where('status', 'active');
                    });
                },
                'faqs' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'webinarExtraDescription' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'chapters' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive);
                    $query->orderBy('order', 'asc');

                    $query->with([
                        'chapterItems' => function ($query) {
                            $query->orderBy('order', 'asc');
                        }
                    ]);
                },
                'files' => function ($query) use ($user) {
                    $query->join('webinar_chapters', 'webinar_chapters.id', '=', 'files.chapter_id')
                        ->select('files.*', DB::raw('webinar_chapters.order as chapterOrder'))
                        ->where('files.status', WebinarChapter::$chapterActive)
                        ->orderBy('chapterOrder', 'asc')
                        ->orderBy('files.order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'textLessons' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->withCount(['attachments'])
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'sessions' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'assignments' => function ($query) {
                    $query->where('status', WebinarChapter::$chapterActive);
                },
                'tickets' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'filterOptions',
                'category',
                'teacher',
                'reviews' => function ($query) {
                    $query->where('status', 'active');
                    $query->with([
                        'comments' => function ($query) {
                            $query->where('status', 'active');
                        },
                        'creator' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }
                    ]);
                },
                'comments' => function ($query) {
                    $query->where('status', 'active');
                    $query->whereNull('reply_id');
                    $query->with([
                        'user' => function ($query) {
                            $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                        },
                        'replies' => function ($query) {
                            $query->where('status', 'active');
                            $query->with([
                                'user' => function ($query) {
                                    $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                                }
                            ]);
                        }
                    ]);
                    $query->orderBy('created_at', 'desc');
                },
            ])
            ->withCount([
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                },
                'noticeboards'
            ])
            ->where('status', 'active')
            ->first();

        if (empty($course)) {
            return $justReturnData ? false : back();
        }

        if (!$justReturnData) {

            /* Check Not Active */
            if ($course->status != "active" and (empty($user) or (!$user->isAdmin() and !$course->canAccess($user)))) {
                $data = [
                    'pageTitle' => trans('update.access_denied'),
                    'pageRobot' => getPageRobotNoIndex(),
                ];
                return view('web.default.course.not_access', $data);
            }

            /* Installment Check */
            $installmentLimitation = $this->installmentContentLimitation($user, $course->id, 'webinar_id');

            if ($installmentLimitation != "ok") {
                return $installmentLimitation;
            }
        }

        $hasBought = $course->checkUserHasBought($user, true, true);
        $isPrivate = $course->private;

        if (!empty($user) and ($user->id == $course->creator_id or $user->organ_id == $course->creator_id or $user->isAdmin())) {
            $isPrivate = false;
        }

        if ($isPrivate and $hasBought) { // check the user has bought the course or not
            $isPrivate = false;
        }

        if ($isPrivate) {
            return $justReturnData ? false : back();
        }

        $isFavorite = false;

        if (!empty($user)) {
            $isFavorite = Favorite::where('webinar_id', $course->id)
                ->where('user_id', $user->id)
                ->first();
        }

        $webinarContentCount = 0;
        if (!empty($course->sessions)) {
            $webinarContentCount += $course->sessions->count();
        }
        if (!empty($course->files)) {
            $webinarContentCount += $course->files->count();
        }
        if (!empty($course->textLessons)) {
            $webinarContentCount += $course->textLessons->count();
        }
        if (!empty($course->quizzes)) {
            $webinarContentCount += $course->quizzes->count();
        }
        if (!empty($course->assignments)) {
            $webinarContentCount += $course->assignments->count();
        }

        $advertisingBanners = AdvertisingBanner::where('published', true)
            ->whereIn('position', ['course', 'course_sidebar'])
            ->get();

        $sessionsWithoutChapter = $course->sessions->whereNull('chapter_id');

        $filesWithoutChapter = $course->files->whereNull('chapter_id');

        $textLessonsWithoutChapter = $course->textLessons->whereNull('chapter_id');

        $quizzes = $course->quizzes->whereNull('chapter_id');

        if ($user) {
            $quizzes = $this->checkQuizzesResults($user, $quizzes);

            if (!empty($course->chapters) and count($course->chapters)) {
                foreach ($course->chapters as $chapter) {
                    if (!empty($chapter->chapterItems) and count($chapter->chapterItems)) {
                        foreach ($chapter->chapterItems as $chapterItem) {
                            if (!empty($chapterItem->quiz)) {
                                $chapterItem->quiz = $this->checkQuizResults($user, $chapterItem->quiz);
                            }
                        }
                    }
                }
            }

            if (!empty($course->quizzes) and count($course->quizzes)) {
                $course->quizzes = $this->checkQuizzesResults($user, $course->quizzes);
            }
        }

        $pageRobot = getPageRobot('course_show'); // index
        $canSale = ($course->canSale() and !$hasBought);

        /* Installments */
        $showInstallments = true;
        $overdueInstallmentOrders = $this->checkUserHasOverdueInstallment($user);

        if ($overdueInstallmentOrders->isNotEmpty() and getInstallmentsSettings('disable_instalments_when_the_user_have_an_overdue_installment')) {
            $showInstallments = false;
        }

        if ($canSale and !empty($course->price) and $course->price > 0 and $showInstallments and getInstallmentsSettings('status') and (empty($user) or $user->enable_installments)) {
            $installmentPlans = new InstallmentPlans($user);
            $installments = $installmentPlans->getPlans('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        /* Cashback Rules */
        if ($canSale and !empty($course->price) and getFeaturesSettings('cashback_active') and (empty($user) or !$user->disable_cashback)) {
            $cashbackRulesMixin = new CashbackRules($user);
            $cashbackRules = $cashbackRulesMixin->getRules('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        $instructorDiscounts = null;

        if (!empty(getFeaturesSettings('frontend_coupons_status'))) {
            $instructorDiscounts = Discount::query()
                ->where(function (Builder $query) use ($course) {
                    $query->where('creator_id', $course->creator_id);
                    $query->orWhere('creator_id', $course->teacher_id);
                })
                ->where(function (Builder $query) use ($course) {
                    $query->where('source', 'all');
                    $query->orWhere(function (Builder $query) use ($course) {
                        $query->where('source', Discount::$discountSourceCourse);

                        $query->where(function (Builder $query) use ($course) {
                            $query->whereHas('discountCourses', function ($query) use ($course) {
                                $query->where('course_id', $course->id);
                            });

                            $query->whereDoesntHave('discountCourses');
                        });
                    });
                })
                ->where('status', 'active')
                ->where('expired_at', '>', time())
                ->get();
        }

        $data = [
            'pageTitle' => $course->title,
            'pageDescription' => $course->seo_description,
            'pageRobot' => $pageRobot,
            'pageMetaImage' => $course->getImage(),
            'course' => $course,
            'isFavorite' => $isFavorite,
            'hasBought' => $hasBought,
            'user' => $user,
            'webinarContentCount' => $webinarContentCount,
            'advertisingBanners' => $advertisingBanners->where('position', 'course'),
            'advertisingBannersSidebar' => $advertisingBanners->where('position', 'course_sidebar'),
            'activeSpecialOffer' => $course->activeSpecialOffer(),
            'sessionsWithoutChapter' => $sessionsWithoutChapter,
            'filesWithoutChapter' => $filesWithoutChapter,
            'textLessonsWithoutChapter' => $textLessonsWithoutChapter,
            'quizzes' => $quizzes,
            'installments' => $installments ?? null,
            'cashbackRules' => $cashbackRules ?? null,
            'instructorDiscounts' => $instructorDiscounts,
        ];

        // check for certificate
        if (!empty($user)) {
            $course->makeCertificateForUser($user);
        }

        if ($justReturnData) {
            return $data;
        }
          /* if($course->type=="text_lesson"){

            return view('web.default.course.textcourse', $data);

        }*/

        return view('web.default.course.index_uae', $data);
    }
    // main branch
    public function courseText($slug, $justReturnData = false)
    {
        $user = null;

        if (auth()->check()) {
            $user = auth()->user();
        }


        if (!$justReturnData) {
            $contentLimitation = $this->checkContentLimitation($user, true);
            if ($contentLimitation != "ok") {
                return $contentLimitation;
            }
        }

        $course = Webinar::where('slug', $slug)
            ->with([
                'quizzes' => function ($query) {
                    $query->where('status', 'active')
                        ->with(['quizResults', 'quizQuestions']);
                },
                'tags',
                'prerequisites' => function ($query) {
                    $query->with(['prerequisiteWebinar' => function ($query) {
                        $query->with(['teacher' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }]);
                    }]);
                    $query->orderBy('order', 'asc');
                },
                'relatedCourses' => function ($query) {
                    $query->whereHas('course', function ($query) {
                        $query->where('status', 'active');
                    });
                },
                'faqs' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'webinarExtraDescription' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'chapters' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive);
                    $query->orderBy('order', 'asc');

                    $query->with([
                        'chapterItems' => function ($query) {
                            $query->orderBy('order', 'asc');
                        }
                    ]);
                },
                'files' => function ($query) use ($user) {
                    $query->join('webinar_chapters', 'webinar_chapters.id', '=', 'files.chapter_id')
                        ->select('files.*', DB::raw('webinar_chapters.order as chapterOrder'))
                        ->where('files.status', WebinarChapter::$chapterActive)
                        ->orderBy('chapterOrder', 'asc')
                        ->orderBy('files.order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'textLessons' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->withCount(['attachments'])
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'sessions' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'assignments' => function ($query) {
                    $query->where('status', WebinarChapter::$chapterActive);
                },
                'tickets' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'filterOptions',
                'category',
                'teacher',
                'reviews' => function ($query) {
                    $query->where('status', 'active');
                    $query->with([
                        'comments' => function ($query) {
                            $query->where('status', 'active');
                        },
                        'creator' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }
                    ]);
                },
                'comments' => function ($query) {
                    $query->where('status', 'active');
                    $query->whereNull('reply_id');
                    $query->with([
                        'user' => function ($query) {
                            $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                        },
                        'replies' => function ($query) {
                            $query->where('status', 'active');
                            $query->with([
                                'user' => function ($query) {
                                    $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                                }
                            ]);
                        }
                    ]);
                    $query->orderBy('created_at', 'desc');
                },
            ])
            ->withCount([
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                },
                'noticeboards'
            ])
            ->where('status', 'active')
            ->first();

        if (empty($course)) {
            return $justReturnData ? false : back();
        }

        if (!$justReturnData) {

            /* Check Not Active */
            if ($course->status != "active" and (empty($user) or (!$user->isAdmin() and !$course->canAccess($user)))) {
                $data = [
                    'pageTitle' => trans('update.access_denied'),
                    'pageRobot' => getPageRobotNoIndex(),
                ];
                return view('web.default.course.not_access', $data);
            }

            /* Installment Check */
            $installmentLimitation = $this->installmentContentLimitation($user, $course->id, 'webinar_id');

            if ($installmentLimitation != "ok") {
                return $installmentLimitation;
            }
        }

        $hasBought = $course->checkUserHasBought($user, true, true);
        $isPrivate = $course->private;

        if (!empty($user) and ($user->id == $course->creator_id or $user->organ_id == $course->creator_id or $user->isAdmin())) {
            $isPrivate = false;
        }

        if ($isPrivate and $hasBought) { // check the user has bought the course or not
            $isPrivate = false;
        }

        if ($isPrivate) {
            return $justReturnData ? false : back();
        }

        $isFavorite = false;

        if (!empty($user)) {
            $isFavorite = Favorite::where('webinar_id', $course->id)
                ->where('user_id', $user->id)
                ->first();
        }

        $webinarContentCount = 0;
        if (!empty($course->sessions)) {
            $webinarContentCount += $course->sessions->count();
        }
        if (!empty($course->files)) {
            $webinarContentCount += $course->files->count();
        }
        if (!empty($course->textLessons)) {
            $webinarContentCount += $course->textLessons->count();
        }
        if (!empty($course->quizzes)) {
            $webinarContentCount += $course->quizzes->count();
        }
        if (!empty($course->assignments)) {
            $webinarContentCount += $course->assignments->count();
        }

        $advertisingBanners = AdvertisingBanner::where('published', true)
            ->whereIn('position', ['course', 'course_sidebar'])
            ->get();

        $sessionsWithoutChapter = $course->sessions->whereNull('chapter_id');

        $filesWithoutChapter = $course->files->whereNull('chapter_id');

        $textLessonsWithoutChapter = $course->textLessons->whereNull('chapter_id');

        $quizzes = $course->quizzes->whereNull('chapter_id');

        if ($user) {
            $quizzes = $this->checkQuizzesResults($user, $quizzes);

            if (!empty($course->chapters) and count($course->chapters)) {
                foreach ($course->chapters as $chapter) {
                    if (!empty($chapter->chapterItems) and count($chapter->chapterItems)) {
                        foreach ($chapter->chapterItems as $chapterItem) {
                            if (!empty($chapterItem->quiz)) {
                                $chapterItem->quiz = $this->checkQuizResults($user, $chapterItem->quiz);
                            }
                        }
                    }
                }
            }

            if (!empty($course->quizzes) and count($course->quizzes)) {
                $course->quizzes = $this->checkQuizzesResults($user, $course->quizzes);
            }
        }

        $pageRobot = getPageRobot('course_show'); // index
        $canSale = ($course->canSale() and !$hasBought);

        /* Installments */
        $showInstallments = true;
        $overdueInstallmentOrders = $this->checkUserHasOverdueInstallment($user);

        if ($overdueInstallmentOrders->isNotEmpty() and getInstallmentsSettings('disable_instalments_when_the_user_have_an_overdue_installment')) {
            $showInstallments = false;
        }

        if ($canSale and !empty($course->price) and $course->price > 0 and $showInstallments and getInstallmentsSettings('status') and (empty($user) or $user->enable_installments)) {
            $installmentPlans = new InstallmentPlans($user);
            $installments = $installmentPlans->getPlans('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        /* Cashback Rules */
        if ($canSale and !empty($course->price) and getFeaturesSettings('cashback_active') and (empty($user) or !$user->disable_cashback)) {
            $cashbackRulesMixin = new CashbackRules($user);
            $cashbackRules = $cashbackRulesMixin->getRules('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        $instructorDiscounts = null;

        if (!empty(getFeaturesSettings('frontend_coupons_status'))) {
            $instructorDiscounts = Discount::query()
                ->where(function (Builder $query) use ($course) {
                    $query->where('creator_id', $course->creator_id);
                    $query->orWhere('creator_id', $course->teacher_id);
                })
                ->where(function (Builder $query) use ($course) {
                    $query->where('source', 'all');
                    $query->orWhere(function (Builder $query) use ($course) {
                        $query->where('source', Discount::$discountSourceCourse);

                        $query->where(function (Builder $query) use ($course) {
                            $query->whereHas('discountCourses', function ($query) use ($course) {
                                $query->where('course_id', $course->id);
                            });

                            $query->whereDoesntHave('discountCourses');
                        });
                    });
                })
                ->where('status', 'active')
                ->where('expired_at', '>', time())
                ->get();
        }

        $data = [
            'pageTitle' => $course->title,
            'pageDescription' => $course->seo_description,
            'pageRobot' => $pageRobot,
            'pageMetaImage' => $course->getImage(),
            'course' => $course,
            'isFavorite' => $isFavorite,
            'hasBought' => $hasBought,
            'user' => $user,
            'webinarContentCount' => $webinarContentCount,
            'advertisingBanners' => $advertisingBanners->where('position', 'course'),
            'advertisingBannersSidebar' => $advertisingBanners->where('position', 'course_sidebar'),
            'activeSpecialOffer' => $course->activeSpecialOffer(),
            'sessionsWithoutChapter' => $sessionsWithoutChapter,
            'filesWithoutChapter' => $filesWithoutChapter,
            'textLessonsWithoutChapter' => $textLessonsWithoutChapter,
            'quizzes' => $quizzes,
            'installments' => $installments ?? null,
            'cashbackRules' => $cashbackRules ?? null,
            'instructorDiscounts' => $instructorDiscounts,
        ];

        // check for certificate
        if (!empty($user)) {
            $course->makeCertificateForUser($user);
        }

        if ($justReturnData) {
            return $data;
        }
      

            return view('web.default.course.textcourse', $data);
    }

    // canada branch
    public function courseTextCanada($slug, $justReturnData = false)
    {
        $user = null;

        if (auth()->check()) {
            $user = auth()->user();
        }


        if (!$justReturnData) {
            $contentLimitation = $this->checkContentLimitation($user, true);
            if ($contentLimitation != "ok") {
                return $contentLimitation;
            }
        }

        $course = Webinar::where('slug', $slug)
            ->with([
                'quizzes' => function ($query) {
                    $query->where('status', 'active')
                        ->with(['quizResults', 'quizQuestions']);
                },
                'tags',
                'prerequisites' => function ($query) {
                    $query->with(['prerequisiteWebinar' => function ($query) {
                        $query->with(['teacher' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }]);
                    }]);
                    $query->orderBy('order', 'asc');
                },
                'relatedCourses' => function ($query) {
                    $query->whereHas('course', function ($query) {
                        $query->where('status', 'active');
                    });
                },
                'faqs' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'webinarExtraDescription' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'chapters' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive);
                    $query->orderBy('order', 'asc');

                    $query->with([
                        'chapterItems' => function ($query) {
                            $query->orderBy('order', 'asc');
                        }
                    ]);
                },
                'files' => function ($query) use ($user) {
                    $query->join('webinar_chapters', 'webinar_chapters.id', '=', 'files.chapter_id')
                        ->select('files.*', DB::raw('webinar_chapters.order as chapterOrder'))
                        ->where('files.status', WebinarChapter::$chapterActive)
                        ->orderBy('chapterOrder', 'asc')
                        ->orderBy('files.order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'textLessons' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->withCount(['attachments'])
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'sessions' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'assignments' => function ($query) {
                    $query->where('status', WebinarChapter::$chapterActive);
                },
                'tickets' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'filterOptions',
                'category',
                'teacher',
                'reviews' => function ($query) {
                    $query->where('status', 'active');
                    $query->with([
                        'comments' => function ($query) {
                            $query->where('status', 'active');
                        },
                        'creator' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }
                    ]);
                },
                'comments' => function ($query) {
                    $query->where('status', 'active');
                    $query->whereNull('reply_id');
                    $query->with([
                        'user' => function ($query) {
                            $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                        },
                        'replies' => function ($query) {
                            $query->where('status', 'active');
                            $query->with([
                                'user' => function ($query) {
                                    $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                                }
                            ]);
                        }
                    ]);
                    $query->orderBy('created_at', 'desc');
                },
            ])
            ->withCount([
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                },
                'noticeboards'
            ])
            ->where('status', 'active')
            ->first();

        if (empty($course)) {
            return $justReturnData ? false : back();
        }

        if (!$justReturnData) {

            /* Check Not Active */
            if ($course->status != "active" and (empty($user) or (!$user->isAdmin() and !$course->canAccess($user)))) {
                $data = [
                    'pageTitle' => trans('update.access_denied'),
                    'pageRobot' => getPageRobotNoIndex(),
                ];
                return view('web.default.course.not_access', $data);
            }

            /* Installment Check */
            $installmentLimitation = $this->installmentContentLimitation($user, $course->id, 'webinar_id');

            if ($installmentLimitation != "ok") {
                return $installmentLimitation;
            }
        }

        $hasBought = $course->checkUserHasBought($user, true, true);
        $isPrivate = $course->private;

        if (!empty($user) and ($user->id == $course->creator_id or $user->organ_id == $course->creator_id or $user->isAdmin())) {
            $isPrivate = false;
        }

        if ($isPrivate and $hasBought) { // check the user has bought the course or not
            $isPrivate = false;
        }

        if ($isPrivate) {
            return $justReturnData ? false : back();
        }

        $isFavorite = false;

        if (!empty($user)) {
            $isFavorite = Favorite::where('webinar_id', $course->id)
                ->where('user_id', $user->id)
                ->first();
        }

        $webinarContentCount = 0;
        if (!empty($course->sessions)) {
            $webinarContentCount += $course->sessions->count();
        }
        if (!empty($course->files)) {
            $webinarContentCount += $course->files->count();
        }
        if (!empty($course->textLessons)) {
            $webinarContentCount += $course->textLessons->count();
        }
        if (!empty($course->quizzes)) {
            $webinarContentCount += $course->quizzes->count();
        }
        if (!empty($course->assignments)) {
            $webinarContentCount += $course->assignments->count();
        }

        $advertisingBanners = AdvertisingBanner::where('published', true)
            ->whereIn('position', ['course', 'course_sidebar'])
            ->get();

        $sessionsWithoutChapter = $course->sessions->whereNull('chapter_id');

        $filesWithoutChapter = $course->files->whereNull('chapter_id');

        $textLessonsWithoutChapter = $course->textLessons->whereNull('chapter_id');

        $quizzes = $course->quizzes->whereNull('chapter_id');

        if ($user) {
            $quizzes = $this->checkQuizzesResults($user, $quizzes);

            if (!empty($course->chapters) and count($course->chapters)) {
                foreach ($course->chapters as $chapter) {
                    if (!empty($chapter->chapterItems) and count($chapter->chapterItems)) {
                        foreach ($chapter->chapterItems as $chapterItem) {
                            if (!empty($chapterItem->quiz)) {
                                $chapterItem->quiz = $this->checkQuizResults($user, $chapterItem->quiz);
                            }
                        }
                    }
                }
            }

            if (!empty($course->quizzes) and count($course->quizzes)) {
                $course->quizzes = $this->checkQuizzesResults($user, $course->quizzes);
            }
        }

        $pageRobot = getPageRobot('course_show'); // index
        $canSale = ($course->canSale() and !$hasBought);

        /* Installments */
        $showInstallments = true;
        $overdueInstallmentOrders = $this->checkUserHasOverdueInstallment($user);

        if ($overdueInstallmentOrders->isNotEmpty() and getInstallmentsSettings('disable_instalments_when_the_user_have_an_overdue_installment')) {
            $showInstallments = false;
        }

        if ($canSale and !empty($course->price) and $course->price > 0 and $showInstallments and getInstallmentsSettings('status') and (empty($user) or $user->enable_installments)) {
            $installmentPlans = new InstallmentPlans($user);
            $installments = $installmentPlans->getPlans('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        /* Cashback Rules */
        if ($canSale and !empty($course->price) and getFeaturesSettings('cashback_active') and (empty($user) or !$user->disable_cashback)) {
            $cashbackRulesMixin = new CashbackRules($user);
            $cashbackRules = $cashbackRulesMixin->getRules('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        $instructorDiscounts = null;

        if (!empty(getFeaturesSettings('frontend_coupons_status'))) {
            $instructorDiscounts = Discount::query()
                ->where(function (Builder $query) use ($course) {
                    $query->where('creator_id', $course->creator_id);
                    $query->orWhere('creator_id', $course->teacher_id);
                })
                ->where(function (Builder $query) use ($course) {
                    $query->where('source', 'all');
                    $query->orWhere(function (Builder $query) use ($course) {
                        $query->where('source', Discount::$discountSourceCourse);

                        $query->where(function (Builder $query) use ($course) {
                            $query->whereHas('discountCourses', function ($query) use ($course) {
                                $query->where('course_id', $course->id);
                            });

                            $query->whereDoesntHave('discountCourses');
                        });
                    });
                })
                ->where('status', 'active')
                ->where('expired_at', '>', time())
                ->get();
        }

        $data = [
            'pageTitle' => $course->title,
            'pageDescription' => $course->seo_description,
            'pageRobot' => $pageRobot,
            'pageMetaImage' => $course->getImage(),
            'course' => $course,
            'isFavorite' => $isFavorite,
            'hasBought' => $hasBought,
            'user' => $user,
            'webinarContentCount' => $webinarContentCount,
            'advertisingBanners' => $advertisingBanners->where('position', 'course'),
            'advertisingBannersSidebar' => $advertisingBanners->where('position', 'course_sidebar'),
            'activeSpecialOffer' => $course->activeSpecialOffer(),
            'sessionsWithoutChapter' => $sessionsWithoutChapter,
            'filesWithoutChapter' => $filesWithoutChapter,
            'textLessonsWithoutChapter' => $textLessonsWithoutChapter,
            'quizzes' => $quizzes,
            'installments' => $installments ?? null,
            'cashbackRules' => $cashbackRules ?? null,
            'instructorDiscounts' => $instructorDiscounts,
        ];

        // check for certificate
        if (!empty($user)) {
            $course->makeCertificateForUser($user);
        }

        if ($justReturnData) {
            return $data;
        }
      

            return view('web.default.course.textcourseCanada', $data);
    }
    // egypt branch
    public function courseTextegy($slug, $justReturnData = false)
    {
        $user = null;

        if (auth()->check()) {
            $user = auth()->user();
        }


        if (!$justReturnData) {
            $contentLimitation = $this->checkContentLimitation($user, true);
            if ($contentLimitation != "ok") {
                return $contentLimitation;
            }
        }

        $course = Webinar::where('slug', $slug)
            ->with([
                'quizzes' => function ($query) {
                    $query->where('status', 'active')
                        ->with(['quizResults', 'quizQuestions']);
                },
                'tags',
                'prerequisites' => function ($query) {
                    $query->with(['prerequisiteWebinar' => function ($query) {
                        $query->with(['teacher' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }]);
                    }]);
                    $query->orderBy('order', 'asc');
                },
                'relatedCourses' => function ($query) {
                    $query->whereHas('course', function ($query) {
                        $query->where('status', 'active');
                    });
                },
                'faqs' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'webinarExtraDescription' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'chapters' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive);
                    $query->orderBy('order', 'asc');

                    $query->with([
                        'chapterItems' => function ($query) {
                            $query->orderBy('order', 'asc');
                        }
                    ]);
                },
                'files' => function ($query) use ($user) {
                    $query->join('webinar_chapters', 'webinar_chapters.id', '=', 'files.chapter_id')
                        ->select('files.*', DB::raw('webinar_chapters.order as chapterOrder'))
                        ->where('files.status', WebinarChapter::$chapterActive)
                        ->orderBy('chapterOrder', 'asc')
                        ->orderBy('files.order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'textLessons' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->withCount(['attachments'])
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'sessions' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'assignments' => function ($query) {
                    $query->where('status', WebinarChapter::$chapterActive);
                },
                'tickets' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'filterOptions',
                'category',
                'teacher',
                'reviews' => function ($query) {
                    $query->where('status', 'active');
                    $query->with([
                        'comments' => function ($query) {
                            $query->where('status', 'active');
                        },
                        'creator' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }
                    ]);
                },
                'comments' => function ($query) {
                    $query->where('status', 'active');
                    $query->whereNull('reply_id');
                    $query->with([
                        'user' => function ($query) {
                            $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                        },
                        'replies' => function ($query) {
                            $query->where('status', 'active');
                            $query->with([
                                'user' => function ($query) {
                                    $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                                }
                            ]);
                        }
                    ]);
                    $query->orderBy('created_at', 'desc');
                },
            ])
            ->withCount([
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                },
                'noticeboards'
            ])
            ->where('status', 'active')
            ->first();

        if (empty($course)) {
            return $justReturnData ? false : back();
        }

        if (!$justReturnData) {

            /* Check Not Active */
            if ($course->status != "active" and (empty($user) or (!$user->isAdmin() and !$course->canAccess($user)))) {
                $data = [
                    'pageTitle' => trans('update.access_denied'),
                    'pageRobot' => getPageRobotNoIndex(),
                ];
                return view('web.default.course.not_access', $data);
            }

            /* Installment Check */
            $installmentLimitation = $this->installmentContentLimitation($user, $course->id, 'webinar_id');

            if ($installmentLimitation != "ok") {
                return $installmentLimitation;
            }
        }

        $hasBought = $course->checkUserHasBought($user, true, true);
        $isPrivate = $course->private;

        if (!empty($user) and ($user->id == $course->creator_id or $user->organ_id == $course->creator_id or $user->isAdmin())) {
            $isPrivate = false;
        }

        if ($isPrivate and $hasBought) { // check the user has bought the course or not
            $isPrivate = false;
        }

        if ($isPrivate) {
            return $justReturnData ? false : back();
        }

        $isFavorite = false;

        if (!empty($user)) {
            $isFavorite = Favorite::where('webinar_id', $course->id)
                ->where('user_id', $user->id)
                ->first();
        }

        $webinarContentCount = 0;
        if (!empty($course->sessions)) {
            $webinarContentCount += $course->sessions->count();
        }
        if (!empty($course->files)) {
            $webinarContentCount += $course->files->count();
        }
        if (!empty($course->textLessons)) {
            $webinarContentCount += $course->textLessons->count();
        }
        if (!empty($course->quizzes)) {
            $webinarContentCount += $course->quizzes->count();
        }
        if (!empty($course->assignments)) {
            $webinarContentCount += $course->assignments->count();
        }

        $advertisingBanners = AdvertisingBanner::where('published', true)
            ->whereIn('position', ['course', 'course_sidebar'])
            ->get();

        $sessionsWithoutChapter = $course->sessions->whereNull('chapter_id');

        $filesWithoutChapter = $course->files->whereNull('chapter_id');

        $textLessonsWithoutChapter = $course->textLessons->whereNull('chapter_id');

        $quizzes = $course->quizzes->whereNull('chapter_id');

        if ($user) {
            $quizzes = $this->checkQuizzesResults($user, $quizzes);

            if (!empty($course->chapters) and count($course->chapters)) {
                foreach ($course->chapters as $chapter) {
                    if (!empty($chapter->chapterItems) and count($chapter->chapterItems)) {
                        foreach ($chapter->chapterItems as $chapterItem) {
                            if (!empty($chapterItem->quiz)) {
                                $chapterItem->quiz = $this->checkQuizResults($user, $chapterItem->quiz);
                            }
                        }
                    }
                }
            }

            if (!empty($course->quizzes) and count($course->quizzes)) {
                $course->quizzes = $this->checkQuizzesResults($user, $course->quizzes);
            }
        }

        $pageRobot = getPageRobot('course_show'); // index
        $canSale = ($course->canSale() and !$hasBought);

        /* Installments */
        $showInstallments = true;
        $overdueInstallmentOrders = $this->checkUserHasOverdueInstallment($user);

        if ($overdueInstallmentOrders->isNotEmpty() and getInstallmentsSettings('disable_instalments_when_the_user_have_an_overdue_installment')) {
            $showInstallments = false;
        }

        if ($canSale and !empty($course->price) and $course->price > 0 and $showInstallments and getInstallmentsSettings('status') and (empty($user) or $user->enable_installments)) {
            $installmentPlans = new InstallmentPlans($user);
            $installments = $installmentPlans->getPlans('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        /* Cashback Rules */
        if ($canSale and !empty($course->price) and getFeaturesSettings('cashback_active') and (empty($user) or !$user->disable_cashback)) {
            $cashbackRulesMixin = new CashbackRules($user);
            $cashbackRules = $cashbackRulesMixin->getRules('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        $instructorDiscounts = null;

        if (!empty(getFeaturesSettings('frontend_coupons_status'))) {
            $instructorDiscounts = Discount::query()
                ->where(function (Builder $query) use ($course) {
                    $query->where('creator_id', $course->creator_id);
                    $query->orWhere('creator_id', $course->teacher_id);
                })
                ->where(function (Builder $query) use ($course) {
                    $query->where('source', 'all');
                    $query->orWhere(function (Builder $query) use ($course) {
                        $query->where('source', Discount::$discountSourceCourse);

                        $query->where(function (Builder $query) use ($course) {
                            $query->whereHas('discountCourses', function ($query) use ($course) {
                                $query->where('course_id', $course->id);
                            });

                            $query->whereDoesntHave('discountCourses');
                        });
                    });
                })
                ->where('status', 'active')
                ->where('expired_at', '>', time())
                ->get();
        }

        $data = [
            'pageTitle' => $course->title,
            'pageDescription' => $course->seo_description,
            'pageRobot' => $pageRobot,
            'pageMetaImage' => $course->getImage(),
            'course' => $course,
            'isFavorite' => $isFavorite,
            'hasBought' => $hasBought,
            'user' => $user,
            'webinarContentCount' => $webinarContentCount,
            'advertisingBanners' => $advertisingBanners->where('position', 'course'),
            'advertisingBannersSidebar' => $advertisingBanners->where('position', 'course_sidebar'),
            'activeSpecialOffer' => $course->activeSpecialOffer(),
            'sessionsWithoutChapter' => $sessionsWithoutChapter,
            'filesWithoutChapter' => $filesWithoutChapter,
            'textLessonsWithoutChapter' => $textLessonsWithoutChapter,
            'quizzes' => $quizzes,
            'installments' => $installments ?? null,
            'cashbackRules' => $cashbackRules ?? null,
            'instructorDiscounts' => $instructorDiscounts,
        ];

        // check for certificate
        if (!empty($user)) {
            $course->makeCertificateForUser($user);
        }

        if ($justReturnData) {
            return $data;
        }
      

            return view('web.default.course.textcourseegy', $data);
    }
    // uae branch
    public function courseTextuae($slug, $justReturnData = false)
    {
        $user = null;

        if (auth()->check()) {
            $user = auth()->user();
        }


        if (!$justReturnData) {
            $contentLimitation = $this->checkContentLimitation($user, true);
            if ($contentLimitation != "ok") {
                return $contentLimitation;
            }
        }

        $course = Webinar::where('slug', $slug)
            ->with([
                'quizzes' => function ($query) {
                    $query->where('status', 'active')
                        ->with(['quizResults', 'quizQuestions']);
                },
                'tags',
                'prerequisites' => function ($query) {
                    $query->with(['prerequisiteWebinar' => function ($query) {
                        $query->with(['teacher' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }]);
                    }]);
                    $query->orderBy('order', 'asc');
                },
                'relatedCourses' => function ($query) {
                    $query->whereHas('course', function ($query) {
                        $query->where('status', 'active');
                    });
                },
                'faqs' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'webinarExtraDescription' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'chapters' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive);
                    $query->orderBy('order', 'asc');

                    $query->with([
                        'chapterItems' => function ($query) {
                            $query->orderBy('order', 'asc');
                        }
                    ]);
                },
                'files' => function ($query) use ($user) {
                    $query->join('webinar_chapters', 'webinar_chapters.id', '=', 'files.chapter_id')
                        ->select('files.*', DB::raw('webinar_chapters.order as chapterOrder'))
                        ->where('files.status', WebinarChapter::$chapterActive)
                        ->orderBy('chapterOrder', 'asc')
                        ->orderBy('files.order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'textLessons' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->withCount(['attachments'])
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'sessions' => function ($query) use ($user) {
                    $query->where('status', WebinarChapter::$chapterActive)
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                },
                'assignments' => function ($query) {
                    $query->where('status', WebinarChapter::$chapterActive);
                },
                'tickets' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'filterOptions',
                'category',
                'teacher',
                'reviews' => function ($query) {
                    $query->where('status', 'active');
                    $query->with([
                        'comments' => function ($query) {
                            $query->where('status', 'active');
                        },
                        'creator' => function ($qu) {
                            $qu->select('id', 'full_name', 'avatar');
                        }
                    ]);
                },
                'comments' => function ($query) {
                    $query->where('status', 'active');
                    $query->whereNull('reply_id');
                    $query->with([
                        'user' => function ($query) {
                            $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                        },
                        'replies' => function ($query) {
                            $query->where('status', 'active');
                            $query->with([
                                'user' => function ($query) {
                                    $query->select('id', 'full_name', 'role_name', 'role_id', 'avatar', 'avatar_settings');
                                }
                            ]);
                        }
                    ]);
                    $query->orderBy('created_at', 'desc');
                },
            ])
            ->withCount([
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                },
                'noticeboards'
            ])
            ->where('status', 'active')
            ->first();

        if (empty($course)) {
            return $justReturnData ? false : back();
        }

        if (!$justReturnData) {

            /* Check Not Active */
            if ($course->status != "active" and (empty($user) or (!$user->isAdmin() and !$course->canAccess($user)))) {
                $data = [
                    'pageTitle' => trans('update.access_denied'),
                    'pageRobot' => getPageRobotNoIndex(),
                ];
                return view('web.default.course.not_access', $data);
            }

            /* Installment Check */
            $installmentLimitation = $this->installmentContentLimitation($user, $course->id, 'webinar_id');

            if ($installmentLimitation != "ok") {
                return $installmentLimitation;
            }
        }

        $hasBought = $course->checkUserHasBought($user, true, true);
        $isPrivate = $course->private;

        if (!empty($user) and ($user->id == $course->creator_id or $user->organ_id == $course->creator_id or $user->isAdmin())) {
            $isPrivate = false;
        }

        if ($isPrivate and $hasBought) { // check the user has bought the course or not
            $isPrivate = false;
        }

        if ($isPrivate) {
            return $justReturnData ? false : back();
        }

        $isFavorite = false;

        if (!empty($user)) {
            $isFavorite = Favorite::where('webinar_id', $course->id)
                ->where('user_id', $user->id)
                ->first();
        }

        $webinarContentCount = 0;
        if (!empty($course->sessions)) {
            $webinarContentCount += $course->sessions->count();
        }
        if (!empty($course->files)) {
            $webinarContentCount += $course->files->count();
        }
        if (!empty($course->textLessons)) {
            $webinarContentCount += $course->textLessons->count();
        }
        if (!empty($course->quizzes)) {
            $webinarContentCount += $course->quizzes->count();
        }
        if (!empty($course->assignments)) {
            $webinarContentCount += $course->assignments->count();
        }

        $advertisingBanners = AdvertisingBanner::where('published', true)
            ->whereIn('position', ['course', 'course_sidebar'])
            ->get();

        $sessionsWithoutChapter = $course->sessions->whereNull('chapter_id');

        $filesWithoutChapter = $course->files->whereNull('chapter_id');

        $textLessonsWithoutChapter = $course->textLessons->whereNull('chapter_id');

        $quizzes = $course->quizzes->whereNull('chapter_id');

        if ($user) {
            $quizzes = $this->checkQuizzesResults($user, $quizzes);

            if (!empty($course->chapters) and count($course->chapters)) {
                foreach ($course->chapters as $chapter) {
                    if (!empty($chapter->chapterItems) and count($chapter->chapterItems)) {
                        foreach ($chapter->chapterItems as $chapterItem) {
                            if (!empty($chapterItem->quiz)) {
                                $chapterItem->quiz = $this->checkQuizResults($user, $chapterItem->quiz);
                            }
                        }
                    }
                }
            }

            if (!empty($course->quizzes) and count($course->quizzes)) {
                $course->quizzes = $this->checkQuizzesResults($user, $course->quizzes);
            }
        }

        $pageRobot = getPageRobot('course_show'); // index
        $canSale = ($course->canSale() and !$hasBought);

        /* Installments */
        $showInstallments = true;
        $overdueInstallmentOrders = $this->checkUserHasOverdueInstallment($user);

        if ($overdueInstallmentOrders->isNotEmpty() and getInstallmentsSettings('disable_instalments_when_the_user_have_an_overdue_installment')) {
            $showInstallments = false;
        }

        if ($canSale and !empty($course->price) and $course->price > 0 and $showInstallments and getInstallmentsSettings('status') and (empty($user) or $user->enable_installments)) {
            $installmentPlans = new InstallmentPlans($user);
            $installments = $installmentPlans->getPlans('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        /* Cashback Rules */
        if ($canSale and !empty($course->price) and getFeaturesSettings('cashback_active') and (empty($user) or !$user->disable_cashback)) {
            $cashbackRulesMixin = new CashbackRules($user);
            $cashbackRules = $cashbackRulesMixin->getRules('courses', $course->id, $course->type, $course->category_id, $course->teacher_id);
        }

        $instructorDiscounts = null;

        if (!empty(getFeaturesSettings('frontend_coupons_status'))) {
            $instructorDiscounts = Discount::query()
                ->where(function (Builder $query) use ($course) {
                    $query->where('creator_id', $course->creator_id);
                    $query->orWhere('creator_id', $course->teacher_id);
                })
                ->where(function (Builder $query) use ($course) {
                    $query->where('source', 'all');
                    $query->orWhere(function (Builder $query) use ($course) {
                        $query->where('source', Discount::$discountSourceCourse);

                        $query->where(function (Builder $query) use ($course) {
                            $query->whereHas('discountCourses', function ($query) use ($course) {
                                $query->where('course_id', $course->id);
                            });

                            $query->whereDoesntHave('discountCourses');
                        });
                    });
                })
                ->where('status', 'active')
                ->where('expired_at', '>', time())
                ->get();
        }

        $data = [
            'pageTitle' => $course->title,
            'pageDescription' => $course->seo_description,
            'pageRobot' => $pageRobot,
            'pageMetaImage' => $course->getImage(),
            'course' => $course,
            'isFavorite' => $isFavorite,
            'hasBought' => $hasBought,
            'user' => $user,
            'webinarContentCount' => $webinarContentCount,
            'advertisingBanners' => $advertisingBanners->where('position', 'course'),
            'advertisingBannersSidebar' => $advertisingBanners->where('position', 'course_sidebar'),
            'activeSpecialOffer' => $course->activeSpecialOffer(),
            'sessionsWithoutChapter' => $sessionsWithoutChapter,
            'filesWithoutChapter' => $filesWithoutChapter,
            'textLessonsWithoutChapter' => $textLessonsWithoutChapter,
            'quizzes' => $quizzes,
            'installments' => $installments ?? null,
            'cashbackRules' => $cashbackRules ?? null,
            'instructorDiscounts' => $instructorDiscounts,
        ];

        // check for certificate
        if (!empty($user)) {
            $course->makeCertificateForUser($user);
        }

        if ($justReturnData) {
            return $data;
        }
      

            return view('web.default.course.textcourseuae', $data);
    }

    private function checkQuizzesResults($user, $quizzes)
    {
        $canDownloadCertificate = false;

        foreach ($quizzes as $quiz) {
            $quiz = $this->checkQuizResults($user, $quiz);
        }

        return $quizzes;
    }

    private function checkQuizResults($user, $quiz)
    {
        $canDownloadCertificate = false;

        $canTryAgainQuiz = false;
        $userQuizDone = QuizzesResult::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        if (count($userQuizDone)) {
            $quiz->user_grade = $userQuizDone->first()->user_grade;
            $quiz->result_count = $userQuizDone->count();
            $quiz->result = $userQuizDone->first();

            $status_pass = false;
            foreach ($userQuizDone as $result) {
                if ($result->status == QuizzesResult::$passed) {
                    $status_pass = true;
                }
            }

            $quiz->result_status = $status_pass ? QuizzesResult::$passed : $userQuizDone->first()->status;

            if ($quiz->certificate and $quiz->result_status == QuizzesResult::$passed) {
                $canDownloadCertificate = true;
            }
        }

        if (!isset($quiz->attempt) or (count($userQuizDone) < $quiz->attempt and $quiz->result_status !== QuizzesResult::$passed)) {
            $canTryAgainQuiz = true;
        }

        $quiz->can_try = $canTryAgainQuiz;
        $quiz->can_download_certificate = $canDownloadCertificate;

        return $quiz;
    }

    private function checkCanAccessToPrivateCourse($course, $user = null): bool
    {
        if (empty($user)) {
            $user = auth()->user();
        }

        if (empty($user)) {
            $user = apiAuth();
        }

        $canAccess = !$course->private;
        $hasBought = $course->checkUserHasBought($user);

        if (!empty($user) and ($user->id == $course->creator_id or $user->organ_id == $course->creator_id or $user->isAdmin() or $hasBought)) {
            $canAccess = true;
        }

        return $canAccess;
    }

    public function downloadFile($slug, $file_id)
    {
        $webinar = Webinar::where('slug', $slug)
            ->where('status', 'active')
            ->first();

        if (!empty($webinar) and $this->checkCanAccessToPrivateCourse($webinar)) {
            $file = File::where('webinar_id', $webinar->id)
                ->where('id', $file_id)
                ->first();

            if (!empty($file) and $file->downloadable) {
                $canAccess = true;

                if ($file->accessibility == 'paid') {
                    $canAccess = $webinar->checkUserHasBought();
                }

                if ($canAccess) {
                    if (in_array($file->storage, ['s3', 'external_link'])) {
                        return redirect($file->file);
                    }

                    $filePath = public_path($file->file);

                    if (file_exists($filePath)) {
                        $extension = \Illuminate\Support\Facades\File::extension($filePath);

                        $fileName = str_replace(' ', '-', $file->title);
                        $fileName = str_replace('.', '-', $fileName);
                        $fileName .= '.' . $extension;

                        $headers = array(
                            'Content-Type: application/' . $file->file_type,
                        );

                        return response()->download($filePath, $fileName, $headers);
                    }
                } else {
                    $toastData = [
                        'title' => trans('public.not_access_toast_lang'),
                        'msg' => trans('public.not_access_toast_msg_lang'),
                        'status' => 'error'
                    ];
                    return back()->with(['toast' => $toastData]);
                }
            }
        }

        return back();
    }

    public function showHtmlFile($slug, $file_id)
    {
        $webinar = Webinar::where('slug', $slug)->where('status', 'active')->first();
    
        if (!empty($webinar) && $this->checkCanAccessToPrivateCourse($webinar)) {
            $file = File::where('webinar_id', $webinar->id)->where('id', $file_id)->first();
    
            if (!empty($file)) {
                $canAccess = $file->accessibility !== 'paid' || $webinar->checkUserHasBought();
    
                if ($canAccess) {
                    $filePath = $file->interactive_file_path;
    
                    if (LaravelFile::exists(public_path($filePath))) {
                        $progressData = null;
                        $progressFile = "scorm_progress/user_" . auth()->id() . "_file_" . $file_id . ".json";
                        
                        if (Storage::exists($progressFile)) {
                            $progressData = json_decode(Storage::get($progressFile), true);
                        }
    
                        return view('web.default.course.learningPage.interactive_file', [
                            'pageTitle' => $file->title,
                            'path' => url($filePath),
                            'webinarId' => $webinar->id,
                            'fileId' => $file->id,
                            'progressData' => $progressData
                        ]);
                    }
    
                    abort(404);
                } else {
                    return back()->with(['toast' => [
                        'title' => trans('public.not_access_toast_lang'),
                        'msg' => trans('public.not_access_toast_msg_lang'),
                        'status' => 'error'
                    ]]);
                }
            }
        }
    
        abort(403);
}

    public function getFilePath(Request $request)
    {
        $this->validate($request, [
            'file_id' => 'required'
        ]);

        $file_id = $request->get('file_id');

        $file = File::where('id', $file_id)
            ->first();

        if (!empty($file)) {
            $webinar = Webinar::where('id', $file->webinar_id)
                ->where('status', 'active')
                ->with([
                    'files' => function ($query) {
                        $query->select('id', 'webinar_id', 'file_type')
                            ->where('status', 'active')
                            ->orderBy('order', 'asc');
                    }
                ])
                ->first();

            if (!empty($webinar)) {
                $canAccess = true;

                if ($file->accessibility == 'paid') {
                    $canAccess = $webinar->checkUserHasBought();
                }

                if ($canAccess) {
                    $path = $file->file;

                    if ($file->storage == 'upload') {
                        $path = url("/course/$webinar->slug/file/$file->id/play");
                    } elseif ($file->storage == 'upload_archive') {
                        $path = url("/course/$webinar->slug/file/$file->id/showHtml");
                    }

                    return response()->json([
                        'code' => 200,
                        'storage' => $file->storage,
                        'path' => $path,
                        'storageService' => $file->storage
                    ], 200);
                }
            }
        }

        abort(403);
    }

    public function playFile($slug, $file_id)
    {
        // this methode linked from video modal for play local video
        // and linked from file.blade for show google_drive,dropbox,iframe

        $webinar = Webinar::where('slug', $slug)
            ->where('status', 'active')
            ->first();

        if (!empty($webinar) and $this->checkCanAccessToPrivateCourse($webinar)) {
            $file = File::where('webinar_id', $webinar->id)
                ->where('id', $file_id)
                ->first();

            if (!empty($file)) {
                $canAccess = true;

                if ($file->accessibility == 'paid') {
                    $canAccess = $webinar->checkUserHasBought();
                }

                if ($canAccess) {
                    // Handle SCORM files specially
                    if ($file->interactive_type === 'custom' && !empty($file->interactive_file_path)) {
                        $progressData = null;
                        $progressFile = "scorm_progress/user_" . auth()->id() . "_file_" . $file_id . ".json";
                        
                        if (Storage::exists($progressFile)) {
                            $progressData = json_decode(Storage::get($progressFile), true);
                        }

                        return view('web.default.course.learningPage.interactive_file', [
                            'pageTitle' => $file->title,
                            'path' => url($file->interactive_file_path),
                            'webinarId' => $webinar->id,
                            'fileId' => $file->id,
                            'progressData' => $progressData
                        ]);
                    }

                    $notVideoSource = ['iframe', 'google_drive', 'dropbox'];

                    if (in_array($file->storage, $notVideoSource)) {
                        $data = [
                            'pageTitle' => $file->title,
                            'iframe' => $file->file
                        ];

                        return view('web.default.course.learningPage.interactive_file', $data);
                    } else if ($file->isVideo()) {
                        return response()->file(public_path($file->file));
                    }
                }
            }
        }

        abort(403);
    }

    public function getLesson(Request $request, $slug, $lesson_id)
    {
        $user = null;

        if (auth()->check()) {
            $user = auth()->user();
        }

        $course = Webinar::where('slug', $slug)
            ->where('status', 'active')
            ->with(['teacher', 'textLessons' => function ($query) {
                $query->orderBy('order', 'asc');
            }])
            ->first();

        if (!empty($course) and $this->checkCanAccessToPrivateCourse($course)) {
            $textLesson = TextLesson::where('id', $lesson_id)
                ->where('webinar_id', $course->id)
                ->where('status', WebinarChapter::$chapterActive)
                ->with([
                    'attachments' => function ($query) {
                        $query->with('file');
                    },
                    'learningStatus' => function ($query) use ($user) {
                        $query->where('user_id', !empty($user) ? $user->id : null);
                    }
                ])
                ->first();

            if (!empty($textLesson)) {
                $canAccess = $course->checkUserHasBought();

                if ($textLesson->accessibility == 'paid' and !$canAccess) {
                    $toastData = [
                        'title' => trans('public.request_failed'),
                        'msg' => trans('cart.you_not_purchased_this_course'),
                        'status' => 'error'
                    ];
                    return back()->with(['toast' => $toastData]);
                }

                $checkSequenceContent = $textLesson->checkSequenceContent();
                $sequenceContentHasError = (!empty($checkSequenceContent) and (!empty($checkSequenceContent['all_passed_items_error']) or !empty($checkSequenceContent['access_after_day_error'])));

                if (!empty($checkSequenceContent) and $sequenceContentHasError) {
                    $toastData = [
                        'title' => trans('public.request_failed'),
                        'msg' => ($checkSequenceContent['all_passed_items_error'] ? $checkSequenceContent['all_passed_items_error'] . ' - ' : '') . ($checkSequenceContent['access_after_day_error'] ?? ''),
                        'status' => 'error'
                    ];
                    return back()->with(['toast' => $toastData]);
                }

                $nextLesson = null;
                $previousLesson = null;
                if (!empty($course->textLessons) and count($course->textLessons)) {
                    $nextLesson = $course->textLessons->where('order', '>', $textLesson->order)->first();
                    $previousLesson = $course->textLessons->where('order', '<', $textLesson->order)->first();
                }

                if (!empty($nextLesson)) {
                    $nextLesson->not_purchased = ($nextLesson->accessibility == 'paid' and !$canAccess);
                }


                $data = [
                    'pageTitle' => $textLesson->title,
                    'textLesson' => $textLesson,
                    'course' => $course,
                    'nextLesson' => $nextLesson,
                    'previousLesson' => $previousLesson,
                ];

                return view(getTemplate() . '.course.text_lesson', $data);
            }
        }

        abort(404);
    }

    public function free(Request $request, $slug)
    {
        if (auth()->check()) {
            $user = auth()->user();

            $course = Webinar::where('slug', $slug)
                ->where('status', 'active')
                ->first();

            if (!empty($course)) {
                $checkCourseForSale = checkCourseForSale($course, $user);

                if ($checkCourseForSale != 'ok') {
                    return $checkCourseForSale;
                }

                if (!empty($course->price) and $course->price > 0) {
                    $toastData = [
                        'title' => trans('cart.fail_purchase'),
                        'msg' => trans('cart.course_not_free'),
                        'status' => 'error'
                    ];
                    return back()->with(['toast' => $toastData]);
                }

                Sale::create([
                    'buyer_id' => $user->id,
                    'seller_id' => $course->creator_id,
                    'webinar_id' => $course->id,
                    'type' => Sale::$webinar,
                    'payment_method' => Sale::$credit,
                    'amount' => 0,
                    'total_amount' => 0,
                    'created_at' => time(),
                ]);

                $notifyOptions = [
                    '[u.name]' => $user->full_name,
                    '[c.title]' => $course->title,
                    '[amount]' => trans('public.free'),
                    '[time.date]' => dateTimeFormat(time(), 'j M Y H:i'),
                ];
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
                sendNotification("new_course_enrollment", $notifyOptions, 1);

                $toastData = [
                    'title' => '',
                    'msg' => trans('cart.success_pay_msg_for_free_course'),
                    'status' => 'success'
                ];
                return back()->with(['toast' => $toastData]);
            }

            abort(404);
        } else {
            return redirect('/login');
        }
    }

    public function reportWebinar(Request $request, $id)
    {
        if (auth()->check()) {
            $user = auth()->user();

            $data = $request->all();

            $validator = Validator::make($data, [
                'reason' => 'required|string',
                'message' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'errors' => $validator->errors()
                ], 422);
            }


            $webinar = Webinar::select('id', 'status')
                ->where('id', $id)
                ->where('status', 'active')
                ->first();

            if (!empty($webinar)) {
                WebinarReport::create([
                    'user_id' => $user->id,
                    'webinar_id' => $webinar->id,
                    'reason' => $data['reason'],
                    'message' => $data['message'],
                    'created_at' => time()
                ]);

                $notifyOptions = [
                    '[u.name]' => $user->full_name,
                    '[content_type]' => trans('product.course')
                ];
                sendNotification("new_report_item_for_admin", $notifyOptions, 1);

                return response()->json([
                    'code' => 200
                ], 200);
            }
        }

        return response()->json([
            'code' => 401
        ], 200);
    }
    
    public function learningStatus(Request $request, $id)
    {
        if (auth()->check()) {
            $user = auth()->user();
 $params=[];
            $course = Webinar::where('id', $id)->first();
            if (!empty($course) and $course->checkUserHasBought($user)) {
                $data = $request->all();
                
                $item = $data['item'];
                $item_id = $data['item_id'];
                $status = $data['status'];
                  $percent=$course->getProgress(true);


/*if($item=='text_lesson_id'){
      $textLesson = TextLesson::where('webinar_id', $course->id)->where('id', $item_id)->first();
      
      dd($textLesson);
    
}*/

              
$agent = $_SERVER['HTTP_USER_AGENT'];

              $browserInfo = $this->xapiService->getBrowserInfo($agent);
                CourseLearning::where('user_id', $user->id)
                    ->where($item, $item_id)
                    ->delete();

                if ($status and $status == "true") {
                    CourseLearning::create([
                        'user_id' => $user->id,
                        $item => $item_id,
                        'created_at' => time()
                    ]);
                }

                // check for certificate
                $course->makeCertificateForUser($user);
                if($item=='file_id'){
                         $fileData = \App\Models\File::where('webinar_id', $course->id)->where('id', $item_id)->first();

                if($percent>=100){
                
             $params = [
     'name' => $user->full_name,
    'email' => $user->email,
    'activity_url' =>$course->getUrl(), // Course URL
    'activity_nameAr' =>$course->title, // Course name in Arabic
    'activity_nameEn' => $course->getTranslation('title','en')->title ?? $course->title, // Course name in English
    'activity_type' => 'http://adlnet.gov/expapi/activities/course', // Activity type
   'browser' =>$browserInfo['browser'],
     'version' =>$browserInfo['version'],
    'platform' => 'EJAABI',
    'instractor_name' =>$course->teacher->full_name,
    'instractor_email' => $course->teacher->email,
    'parent_url' => $course->getUrl(),
      'course_nameAr' => $course->title,
     'course_nameEn' =>$course->getTranslation('title','en')->title ?? $course->title,
     'type' => 'https://w3id.org/xapi/cmi5/activitytype/course',
     
];


}

else{
                
   
                $params = [
     'name' => $user->full_name,
    'email' => $user->email,
   'activity_url' => url('/course/learning/' . $course->slug),
    'activity_nameAr' =>$fileData->title, // Course name in Arabic
    'activity_nameEn' => $fileData->title, // Course name in English
    'activity_type' => 'http://adlnet.gov/expapi/activities/lesson', // Activity type
   'browser' =>$browserInfo['browser'],
     'version' =>$browserInfo['version'],
    'platform' => 'EJAABI',
    'instractor_name' =>$course->teacher->full_name,
    'instractor_email' => $course->teacher->email,
    'parent_url' => $course->getUrl(),
      'course_nameAr' => $course->title,
     'course_nameEn' =>$course->getTranslation('title','en')->title ?? $course->title,
     'type' => 'https://w3id.org/xapi/cmi5/activitytype/course',
     
];

}

$this->xapiService->createCompletedStatement($params);

           $params = [
     'name' => $user->full_name,
    'email' => $user->email,
    'course_url' =>$course->getUrl(), // Course URL
     'course_nameAr' => $course->title,
     'course_nameEn' =>$course->getTranslation('title','en')->title ?? $course->title,
    'activity_type' => 'http://adlnet.gov/expapi/activities/course', // Activity type
   'browser' =>$browserInfo['browser'],
     'version' =>$browserInfo['version'],
    'platform' => 'EJAABI',
    'instractor_name' =>$course->teacher->full_name,
    'instractor_email' => $course->teacher->email,
    'parent_url' => $course->getUrl(),
         'type' => 'https://w3id.org/xapi/cmi5/activitytype/course',
];

$isCompleted = false;
if($percent>=100){
    
    $isCompleted=true; 
}

 $percent = round($percent /100,2);
$this->xapiService->createProgressStatement($params, $percent, $isCompleted);



                
                }          
                
                

                return response()->json([], 200);
            }
        }

        abort(403);
    }

    public function learningStatus_old(Request $request, $id)
    {
        if (auth()->check()) {
            $user = auth()->user();

            $course = Webinar::where('id', $id)->first();
            if (!empty($course) and $course->checkUserHasBought($user)) {
                $data = $request->all();
                
                $item = $data['item'];
                $item_id = $data['item_id'];
                $status = $data['status'];
//dd($course->getProgress(true));
if($item=='file_id'){
    
     $fileData = \App\Models\File::where('webinar_id', $course->id)->where('id', $item_id)->first();
      
      //dd($fileData);  
}
if($item=='text_lesson_id'){
      $textLesson = TextLesson::where('webinar_id', $course->id)->where('id', $item_id)->first();
      
      dd($textLesson);
    
}

                $item = $data['item'];
                $item_id = $data['item_id'];
                $status = $data['status'];

                CourseLearning::where('user_id', $user->id)
                    ->where($item, $item_id)
                    ->delete();

                if ($status and $status == "true") {
                    CourseLearning::create([
                        'user_id' => $user->id,
                        $item => $item_id,
                        'created_at' => time()
                    ]);
                }

                // check for certificate
                $course->makeCertificateForUser($user);
                
                
                $params = [
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'activity_url' => 'https://example.com/course/123', // Course URL
    'activity_nameAr' => 'دورة تدريبية', // Course name in Arabic
    'activity_nameEn' => 'Training Course', // Course name in English
    'activity_type' => 'http://adlnet.gov/expapi/activities/course', // Activity type
    'browser' => 'Chrome',
    'version' => '133.0.0.0',
    'instractor_name' => 'Jane Smith',
    'instractor_email' => 'jane.smith@example.com',
    'platform' => 'EJAABI',
    'parent_url' => 'https://example.com/course/123', // Parent course URL
    'course_nameAr' => 'دورة تدريبية', // Parent course name in Arabic
    'course_nameEn' => 'Training Course', // Parent course name in English
    'type' => 'http://adlnet.gov/expapi/activities/course' // Parent activity type
];


   $params = [
                    'name' => $user->full_name,
                    'email' => $user->email,
                    'course_url' => $course->getUrl(),
                    'course_nameAr' => $course->title,
                    'course_nameEn' =>$course->getTranslation('title','en')->title ?? $course->title,
                    'type' => 'https://w3id.org/xapi/cmi5/activitytype/course',
                    'browser' =>$browserInfo['browser'],
                    'version' =>$browserInfo['version'],
                    'platform' => 'EJAABI',
                    'instractor_name' =>$course->teacher->full_name,
                    'instractor_email' => $quiz->webinar->teacher->email,
                    'parent_url' => $course->getUrl(),
                   
                ];

$params = [
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'activity_url' => 'https://example.com/lesson/456', // Lesson URL
    'activity_nameAr' => 'الدرس الاول', // Lesson name in Arabic
    'activity_nameEn' => 'First Lesson', // Lesson name in English
    'activity_type' => 'http://adlnet.gov/expapi/activities/lesson', // Activity type
    'browser' => 'Chrome',
    'version' => '133.0.0.0',
    'instractor_name' => 'Jane Smith',
    'instractor_email' => 'jane.smith@example.com',
    'platform' => 'EJAABI',
    'parent_url' => 'https://example.com/course/123', // Parent course URL
    'course_nameAr' => 'دورة تدريبية', // Parent course name in Arabic
    'course_nameEn' => 'Training Course', // Parent course name in English
    'type' => 'http://adlnet.gov/expapi/activities/course' // Parent activity type
];


     $params = [
                    'name' => $user->full_name,
                    'email' => $user->email,
                    'course_url' => $course->getUrl(),
                    'course_nameAr' => $course->title,
                    'course_nameEn' =>$course->getTranslation('title','en')->title ?? $course->title,
                    'type' => 'https://w3id.org/xapi/cmi5/activitytype/course',
                    'browser' =>$browserInfo['browser'],
                    'version' =>$browserInfo['version'],
                    'platform' => 'EJAABI',
                    'instractor_name' =>$course->teacher->full_name,
                    'instractor_email' => $quiz->webinar->teacher->email,
                    'parent_url' => $course->getUrl(),
                   
                ];
//$this->xapiService->createCompletedStatement($params);
                
                
                
                

                return response()->json([], 200);
            }
        }

        abort(403);
    }

    public function buyWithPoint($slug)
    {
        if (auth()->check()) {
            $user = auth()->user();

            $course = Webinar::where('slug', $slug)
                ->where('status', 'active')
                ->first();

            if (!empty($course)) {
                if (empty($course->points)) {
                    $toastData = [
                        'title' => '',
                        'msg' => trans('update.can_not_buy_this_course_with_point'),
                        'status' => 'error'
                    ];
                    return back()->with(['toast' => $toastData]);
                }

                $availablePoints = $user->getRewardPoints();

                if ($availablePoints < $course->points) {
                    $toastData = [
                        'title' => '',
                        'msg' => trans('update.you_have_no_enough_points_for_this_course'),
                        'status' => 'error'
                    ];
                    return back()->with(['toast' => $toastData]);
                }

                $checkCourseForSale = checkCourseForSale($course, $user);

                if ($checkCourseForSale != 'ok') {
                    return $checkCourseForSale;
                }

                Sale::create([
                    'buyer_id' => $user->id,
                    'seller_id' => $course->creator_id,
                    'webinar_id' => $course->id,
                    'type' => Sale::$webinar,
                    'payment_method' => Sale::$credit,
                    'amount' => 0,
                    'total_amount' => 0,
                    'created_at' => time(),
                ]);

                RewardAccounting::makeRewardAccounting($user->id, $course->points, 'withdraw', null, false, RewardAccounting::DEDUCTION);

                $toastData = [
                    'title' => '',
                    'msg' => trans('update.success_pay_course_with_point_msg'),
                    'status' => 'success'
                ];
                return back()->with(['toast' => $toastData]);
            }

            abort(404);
        } else {
            return redirect('/login');
        }
    }

    public function directPayment(Request $request)
    {
        $user = auth()->user();

        if (!empty($user) and !empty(getFeaturesSettings('direct_classes_payment_button_status'))) {
            $this->validate($request, [
                'item_id' => 'required',
                'item_name' => 'nullable',
            ]);

            $data = $request->except('_token');

            $webinarId = $data['item_id'];
            $ticketId = $data['ticket_id'] ?? null;

            $webinar = Webinar::where('id', $webinarId)
                ->where('private', false)
                ->where('status', 'active')
                ->first();

            if (!empty($webinar)) {
                $checkCourseForSale = checkCourseForSale($webinar, $user);

                if ($checkCourseForSale != 'ok') {
                    return $checkCourseForSale;
                }

                $fakeCarts = collect();

                $fakeCart = new Cart();
                $fakeCart->creator_id = $user->id;
                $fakeCart->webinar_id = $webinarId;
                $fakeCart->ticket_id = $ticketId;
                $fakeCart->special_offer_id = null;
                $fakeCart->created_at = time();

                $fakeCarts->add($fakeCart);

                $cartController = new CartController();

                return $cartController->checkout(new Request(), $fakeCarts);
            }
        }

        abort(404);
    }
    
     //الخطة السنوية للبرامج التدريبية
    public function cet_courses(Request $request)
    {
        session()->forget('selectedCategory');
$webinarsQuery = Webinar::where('status', 'active')
    ->where('private', false)
    ->where('type', 'text_lesson');

// Category filter
if (isset($request->categoryID) && !empty($request->categoryID)) {
      session()->put('selectedCategory', $request->categoryID);
    $webinarsQuery->where('category_id', $request->categoryID);
}

// NDays filter
if ($request->has('ndays') && $request->ndays) {
    $webinarsQuery->whereHas('translations', function($query) use ($request) {
       // $query->whereRaw('JSON_EXTRACT(details, "$.ndays") = ?', [$request->ndays]);
        
        $query->where('details', 'LIKE', '%ndays":"' . $request->ndays . '"%');
    });
}

// Course title filter
if ($request->has('course_title') && $request->course_title) {
    $webinarsQuery->whereHas('translations', function($query) use ($request) {
        $query->where('title', 'LIKE', '%' . $request->course_title . '%');
    });
}

// Get the results
    $webinars = $webinarsQuery->paginate(10)->withQueryString();



     
        $webinars = $webinarsQuery->paginate(10);

        $seoSettings = getSeoMetas('courses');
        $pageTitle = $seoSettings['title'] ?? '';
        $pageDescription = $seoSettings['description'] ?? '';
        $pageRobot = getPageRobot('classes');
  // Get ALL possible ndays values (separate query)
  
   $allNdaysValues =Webinar::where('status', 'active')
    ->where('private', false)
    ->where('type', 'text_lesson')->get();
  $ndaysValues = $allNdaysValues->flatMap(function ($course) {
        $details = json_decode($course->details, true);
        return is_array($details) ? array_column($details, 'ndays') : [];
    });

   
    $uniqueNdDays = $ndaysValues->unique()->sort()->values();
        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'pageRobot' => $pageRobot,
            'webinars' => $webinars,
            'coursesCount' => $webinars->total(),
            'uniqueNdDays'=>$uniqueNdDays
        ];
        
        

        return view(getTemplate() . '.pages.cet_courses', $data);


    
    }
     //الخطة السنوية للبرامج التدريبية كندا
    public function cet_courses_canada(Request $request)
    {
        session()->forget('selectedCategory');
            $webinarsQuery = Webinar::where('status', 'active')->where('private', false)->where('branch_id', 3)->where('type', 'text_lesson');

        // Category filter
        if (isset($request->categoryID) && !empty($request->categoryID)) {
              session()->put('selectedCategory', $request->categoryID);
            $webinarsQuery->where('category_id', $request->categoryID);
        }

        // NDays filter
        if ($request->has('ndays') && $request->ndays) {
            $webinarsQuery->whereHas('translations', function($query) use ($request) {
               // $query->whereRaw('JSON_EXTRACT(details, "$.ndays") = ?', [$request->ndays]);
                $query->where('details', 'LIKE', '%ndays":"' . $request->ndays . '"%');
            });
        }

        // Course title filter
        if ($request->has('course_title') && $request->course_title) {
            $webinarsQuery->whereHas('translations', function($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->course_title . '%');
            });
        }

        // Get the results
        $webinars = $webinarsQuery->paginate(10)->withQueryString();
     
        $webinars = $webinarsQuery->paginate(10);

        $seoSettings = getSeoMetas('courses');
        $pageTitle = $seoSettings['title'] ?? '';
        $pageDescription = $seoSettings['description'] ?? '';
        $pageRobot = getPageRobot('classes');
        // Get ALL possible ndays values (separate query)
          
        $allNdaysValues =Webinar::where('status', 'active')->where('private', false)->where('branch_id', 3)->where('type', 'text_lesson')->get();
           
        $ndaysValues = $allNdaysValues->flatMap(function ($course) {
            $details = json_decode($course->details, true);
            return is_array($details) ? array_column($details, 'ndays') : [];
        });
   
        $uniqueNdDays = $ndaysValues->unique()->sort()->values();
        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'pageRobot' => $pageRobot,
            'webinars' => $webinars,
            'coursesCount' => $webinars->total(),
            'uniqueNdDays'=>$uniqueNdDays
        ];
        
        return view(getTemplate() . '.pages.canada.cet_courses', $data);
    }
    public function cet_courses_egy(Request $request)
    {
        session()->forget('selectedCategory');
            $webinarsQuery = Webinar::where('status', 'active')->where('private', false)->where('branch_id', 4)->where('type', 'text_lesson');

        // Category filter
        if (isset($request->categoryID) && !empty($request->categoryID)) {
              session()->put('selectedCategory', $request->categoryID);
            $webinarsQuery->where('category_id', $request->categoryID);
        }

        // NDays filter
        if ($request->has('ndays') && $request->ndays) {
            $webinarsQuery->whereHas('translations', function($query) use ($request) {
               // $query->whereRaw('JSON_EXTRACT(details, "$.ndays") = ?', [$request->ndays]);
                $query->where('details', 'LIKE', '%ndays":"' . $request->ndays . '"%');
            });
        }

        // Course title filter
        if ($request->has('course_title') && $request->course_title) {
            $webinarsQuery->whereHas('translations', function($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->course_title . '%');
            });
        }

        // Get the results
        $webinars = $webinarsQuery->paginate(10)->withQueryString();
     
        $webinars = $webinarsQuery->paginate(10);

        $seoSettings = getSeoMetas('courses');
        $pageTitle = $seoSettings['title'] ?? '';
        $pageDescription = $seoSettings['description'] ?? '';
        $pageRobot = getPageRobot('classes');
        // Get ALL possible ndays values (separate query)
          
        $allNdaysValues =Webinar::where('status', 'active')->where('private', false)->where('branch_id', 4)->where('type', 'text_lesson')->get();
           
        $ndaysValues = $allNdaysValues->flatMap(function ($course) {
            $details = json_decode($course->details, true);
            return is_array($details) ? array_column($details, 'ndays') : [];
        });
   
        $uniqueNdDays = $ndaysValues->unique()->sort()->values();
        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'pageRobot' => $pageRobot,
            'webinars' => $webinars,
            'coursesCount' => $webinars->total(),
            'uniqueNdDays'=>$uniqueNdDays
        ];
        
        return view(getTemplate() . '.pages.egypt.cet_courses', $data);
    }
    public function cet_courses_uae(Request $request)
    {
        session()->forget('selectedCategory');
            $webinarsQuery = Webinar::where('status', 'active')->where('private', false)->where('branch_id', 2)->where('type', 'text_lesson');

        // Category filter
        if (isset($request->categoryID) && !empty($request->categoryID)) {
              session()->put('selectedCategory', $request->categoryID);
            $webinarsQuery->where('category_id', $request->categoryID);
        }

        // NDays filter
        if ($request->has('ndays') && $request->ndays) {
            $webinarsQuery->whereHas('translations', function($query) use ($request) {
               // $query->whereRaw('JSON_EXTRACT(details, "$.ndays") = ?', [$request->ndays]);
                $query->where('details', 'LIKE', '%ndays":"' . $request->ndays . '"%');
            });
        }

        // Course title filter
        if ($request->has('course_title') && $request->course_title) {
            $webinarsQuery->whereHas('translations', function($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->course_title . '%');
            });
        }

        // Get the results
        $webinars = $webinarsQuery->paginate(10)->withQueryString();
     
        $webinars = $webinarsQuery->paginate(10);

        $seoSettings = getSeoMetas('courses');
        $pageTitle = $seoSettings['title'] ?? '';
        $pageDescription = $seoSettings['description'] ?? '';
        $pageRobot = getPageRobot('classes');
        // Get ALL possible ndays values (separate query)
          
        $allNdaysValues =Webinar::where('status', 'active')->where('private', false)->where('branch_id', 2)->where('type', 'text_lesson')->get();
           
        $ndaysValues = $allNdaysValues->flatMap(function ($course) {
            $details = json_decode($course->details, true);
            return is_array($details) ? array_column($details, 'ndays') : [];
        });
   
        $uniqueNdDays = $ndaysValues->unique()->sort()->values();
        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'pageRobot' => $pageRobot,
            'webinars' => $webinars,
            'coursesCount' => $webinars->total(),
            'uniqueNdDays'=>$uniqueNdDays
        ];
        
        return view(getTemplate() . '.pages.uae.cet_courses', $data);
    }
    
    public function requestCourse(Request $request){
        
          $course= Webinar::where('status', 'active')
    ->where('private', false)
    ->where('type','course')->where('slug',$request->slug)->first();
       $seoSettings = getSeoMetas('courses');
        $pageTitle = trans('public.Request Course');
        $pageDescription = $seoSettings['description'] ?? '';
        $pageRobot = getPageRobot('classes');

        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'pageRobot' => $pageRobot,
            'course' => $course,
        ];
            return view(getTemplate() . '.pages.request_course', $data);

        
        
    }
    
    public function requestConsulting(Request $request)
    {
        
       
        $pageTitle = trans('public.Request Consulting');
        $pageDescription ='Request Consulting';
       
        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
           
            
        ];
            return view(getTemplate() . '.pages.request_consulting', $data);

    }
    
    public function storeRequestCourse(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'type' => 'required|in:course',
              'course_id' => 'required|exists:webinars,id',

            'description' => 'nullable',
        ], [
            // Custom error messages
            'name.required' => __('public.Name is required'),
            'email.required' => __('public.Email is required'),
            'email.email' => __('public.Please enter a valid email address'),
            'phone.required' => __('public.Phone number is required'),
            'phone.regex' => __('public.Please enter a valid phone number'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            // Create new service request
            $serviceRequest = \App\Models\ServiceRequest::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'type' => $request->type,
                'course_id' => $request->course_id,

                'description' => $request->description,
            ]);

            // Flash success message
            return redirect()->back()->with('success', __('public.Your course request has been submitted successfully'));

        } catch (\Exception $e) {
            // Log the error
            \Log::error('Course Request Error: ' . $e->getMessage());
            
            // Flash error message
            return redirect()->back()
                           ->with('error', __('public.Something went wrong. Please try again later'))
                           ->withInput();
        }
    }
    
    public function storeRequestConsulting(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'type' => 'required|in:consulting',
             

            'description' => 'nullable',
        ], [
            // Custom error messages
            'name.required' => __('public.Name is required'),
            'email.required' => __('public.Email is required'),
            'email.email' => __('public.Please enter a valid email address'),
            'phone.required' => __('public.Phone number is required'),
            'phone.regex' => __('public.Please enter a valid phone number'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            // Create new service request
            $serviceRequest = \App\Models\ServiceRequest::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'type' => $request->type,
               

                'description' => $request->description,
            ]);

            // Flash success message
            return redirect()->back()->with('success', __('public.Your consulting request has been submitted successfully'));

        } catch (\Exception $e) {
            // Log the error
            \Log::error('consulting Request Error: ' . $e->getMessage());
            
            // Flash error message
            return redirect()->back()
                           ->with('error', __('public.Something went wrong. Please try again later'))
                           ->withInput();
        }
    }
}
