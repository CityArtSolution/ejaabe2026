<?php

namespace App\Http\Controllers\Admin;

use App\Exports\WebinarsExport;
use App\Http\Controllers\Admin\traits\ProductBadgeTrait;
use App\Http\Controllers\Admin\traits\WebinarChangeCreator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\Traits\VideoDemoTrait;
use App\Http\Controllers\Panel\WebinarStatisticController;
use App\Mail\SendNotifications;
use App\Models\BundleWebinar;
use App\Models\Category;
use App\Models\File;
use App\Models\Gift;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\InstallmentOrder;
use App\Models\Notification;
use App\Models\Translation\QuizTranslation;
use App\Models\Quiz;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Role;
use App\Models\EvalCategory;
use App\Models\Sale;
use App\Models\Session;
use App\Models\SpecialOffer;
use App\Models\Tag;
use App\Models\TextLesson;
use App\Models\Ticket;
use App\Models\Translation\WebinarTranslation;
use App\Models\WebinarChapter;
use App\Models\WebinarChapterItem;
use App\Models\WebinarFilterOption;
use App\Models\WebinarPartnerTeacher;
use App\User;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Translation\FileTranslation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use ZipArchive;

class WebinarController extends Controller
{
    use WebinarChangeCreator, ProductBadgeTrait, VideoDemoTrait;

    public function toggleHomepage(Request $request, $id)
    {
        $webinar = Webinar::findOrFail($id);

        $webinar->show_on_homepage = $request->input('show_on_homepage') ? 1 : 0;
        $webinar->save();

        return response()->json(['success' => true]);
}

public function duplicate($id)
{
    $this->authorize('admin_webinars_create');

    $original = Webinar::with([
        'translations',
        'tags',
        'filters',
        'branches',
        'partnerInstructors',
        'quizzes.translations',
        'quizzes.questions.translations',
        'quizzes.questions.answers.translations',
        'tickets',
        'sessions',
        'files',
        'faqs',
        'textLessons',
        'assignments',
        'prerequisites',
        'chapters.chapterItems',
        'chapters.translations'
    ])->findOrFail($id);

    // 🟡 إنشاء نسخة جديدة من الدورة
    $data = $original->toArray();
    $data['title'] = $original->title . ' (Copy ' . now()->format('Y-m-d H:i') . ')';
    $data['slug']  = Webinar::makeSlug($data['title']);

    $webinar = Webinar::create([
        'type' => $original->type,
        'slug' => $data['slug'],
        'teacher_id' => $original->teacher_id,
        'creator_id' => $original->creator_id,
        'thumbnail' => $original->thumbnail,
        'image_cover' => $original->image_cover ?? $original->thumbnail,
        'video_demo' => $original->video_demo,
        'approval_logo' => $original->approval_logo,
        'video_demo_source' => $original->video_demo_source,
        'sales_count_number' => $original->sales_count_number,
        'capacity' => $original->capacity,
        'start_date' => $original->start_date,
        'timezone' => $original->timezone,
        'duration' => $original->duration,
        'support' => $original->support,
        'certificate' => $original->certificate,
        'downloadable' => $original->downloadable,
        'partner_instructor' => $original->partner_instructor,
        'subscribe' => $original->subscribe,
        'private' => $original->private,
        'forum' => $original->forum,
        'branch_id' => $original->branch_id,
        'enable_waitlist' => $original->enable_waitlist,
        'access_days' => $original->access_days,
        'price' => $original->price,
        'discount_rate' => $original->discount_rate,
        'organization_price' => $original->organization_price,
        'points' => $original->points,
        'category_id' => $original->category_id,
        'message_for_reviewer' => $original->message_for_reviewer,
        'add_to_more' => $original->add_to_more,
        'status' => Webinar::$pending,
        'created_at' => time(),
        'updated_at' => time(),
    ]);

    // 🟡 نسخ الترجمات
    foreach ($original->translations as $translation) {
        WebinarTranslation::updateOrCreate([
            'webinar_id' => $webinar->id,
            'locale' => $translation->locale,
        ], [
            'title' => $translation->title . ' (Copy)',
            'description' => $translation->description,
            'seo_description' => $translation->seo_description,
            'sections' => $translation->sections,
            'details' => $translation->details,
            'approval_name' => $translation->approval_name,
        ]);
    }

    // 🟡 نسخ الفروع
    foreach ($original->branches as $branch) {
        $webinar->branches()->attach($branch->id);
    }

    // 🟡 نسخ الفلاتر
    foreach ($original->filters as $filter) {
        WebinarFilterOption::create([
            'webinar_id' => $webinar->id,
            'filter_option_id' => $filter->filter_option_id
        ]);
    }

    // 🟡 نسخ التاغات
    foreach ($original->tags as $tag) {
        Tag::create([
            'webinar_id' => $webinar->id,
            'title' => $tag->title,
        ]);
    }

    // 🟡 نسخ الـ partners
    foreach ($original->partnerInstructors as $partner) {
        WebinarPartnerTeacher::create([
            'webinar_id' => $webinar->id,
            'teacher_id' => $partner->teacher_id,
        ]);
    }

    // 🟡 نسخ التذاكر
    foreach ($original->tickets as $ticket) {
        $newTicket = $ticket->replicate();
        $newTicket->webinar_id = $webinar->id;
        $newTicket->created_at = time();
        $newTicket->updated_at = time();
        $newTicket->save();
    }

    // 🟡 نسخ الجلسات
    foreach ($original->sessions as $session) {
        $newSession = $session->replicate();
        $newSession->webinar_id = $webinar->id;
        $newSession->created_at = time();
        $newSession->updated_at = time();
        $newSession->save();
    }

    // 🟡 نسخ الملفات
    foreach ($original->files as $file) {
        $newFile = $file->replicate();
        $newFile->webinar_id = $webinar->id;
        $newFile->created_at = time();
        $newFile->updated_at = time();
        $newFile->save();
    }

    // 🟡 نسخ الأسئلة الشائعة
    foreach ($original->faqs as $faq) {
        $newFaq = $faq->replicate();
        $newFaq->webinar_id = $webinar->id;
        $newFaq->created_at = time();
        $newFaq->updated_at = time();
        $newFaq->save();
    }

    // 🟡 نسخ الدروس النصية
    foreach ($original->textLessons as $lesson) {
        $newLesson = $lesson->replicate();
        $newLesson->webinar_id = $webinar->id;
        $newLesson->created_at = time();
        $newLesson->updated_at = time();
        $newLesson->save();
    }

    // 🟡 نسخ الواجبات
    foreach ($original->assignments as $assignment) {
        $newAssignment = $assignment->replicate();
        $newAssignment->webinar_id = $webinar->id;
        $newAssignment->created_at = time();
        $newAssignment->updated_at = time();
        $newAssignment->save();
    }

    // 🟡 نسخ المتطلبات
    foreach ($original->prerequisites as $pre) {
        $newPre = $pre->replicate();
        $newPre->webinar_id = $webinar->id;
        $newPre->created_at = time();
        $newPre->updated_at = time();
        $newPre->save();
    }

    // 🟡 نسخ الفصول + الترجمات + العناصر
    foreach ($original->chapters as $chapter) {
        $newChapter = $chapter->replicate();
        $newChapter->webinar_id = $webinar->id;
        $newChapter->created_at = time();

        $newChapter->save();

        // نسخ ترجمة الفصل
        foreach ($chapter->translations as $chTr) {
            DB::table('webinar_chapter_translations')->insert([
                'webinar_chapter_id'  => $newChapter->id,
                'locale'      => $chTr->locale,
                'title'       => $chTr->title,

            ]);
        }

        // نسخ عناصر الفصل
        foreach ($chapter->chapterItems as $item) {
            $newItem = $item->replicate();
            $newItem->chapter_id = $newChapter->id;
            $newItem->created_at = time();
            $newItem->save();
        }
    }

    // 🟡 نسخ الكويز إذا كانت الدورة Exam أو Eval
    if ($original->type == 'exam' || $original->type == 'eval') {
        foreach ($original->quizzes as $quiz) {
            $newQuiz = $quiz->replicate();
            $newQuiz->webinar_id = $webinar->id;
            $newQuiz->created_at = time();
            $newQuiz->updated_at = time();
            $newQuiz->save();

            // نسخ ترجمة الكويز
            foreach ($quiz->translations as $quizTr) {
                QuizTranslation::create([
                    'quiz_id' => $newQuiz->id,
                    'locale' => $quizTr->locale,
                    'title' => $quizTr->title,
                    'created_at' => time(),
                    'updated_at' => time(),
                ]);
            }

            // 🟡 إذا كان النوع eval ننسخ كل الأسئلة والإجابات والترجمات
            if ($original->type == 'eval') {
                foreach ($quiz->questions as $question) {
                    $newQuestion = $question->replicate();
                    $newQuestion->quiz_id = $newQuiz->id;
                    $newQuestion->created_at = time();
                    $newQuestion->updated_at = time();
                    $newQuestion->save();

                    foreach ($question->translations as $qTr) {
                        DB::table('quiz_question_translations')->insert([
                            'quizzes_question_id' => $newQuestion->id,
                            'locale' => $qTr->locale,
                            'title' => $qTr->title,
                        ]);
                    }

                    foreach ($question->answers as $answer) {
                        $newAnswer = $answer->replicate();
                        $newAnswer->question_id = $newQuestion->id;
                        $newAnswer->created_at = time();
                        $newAnswer->updated_at = time();
                        $newAnswer->save();

                        foreach ($answer->translations as $aTr) {
                            DB::table('quizzes_questions_answer_translations')->insert([
                                'quizzes_questions_answer_id' => $newAnswer->id,
                                'locale' => $aTr->locale,
                                'title' => $aTr->title,
                            ]);
                        }
                    }
                }
$originalEvalCategories = \App\Models\EvalCategory::where('quiz_id', $quiz->id)->get();

foreach ($originalEvalCategories as $cat) {
    $newCat = $cat->replicate();
    unset($newCat->locale); // إزالة أي حقل زائد لو صار
    $newCat->quiz_id = $newQuiz->id;
    $newCat->save();

    // نسخ الترجمات باستخدام Query Builder
    $catTranslations = DB::table('eval_category_translations')
        ->where('eval_category_id', $cat->id)
        ->get();

    foreach ($catTranslations as $catTr) {
        DB::table('eval_category_translations')->insert([
            'eval_category_id' => $newCat->id,  // ربط الترجمة بالقسم الجديد
            'locale' => $catTr->locale,
            'title' => $catTr->title,
        ]);
    }
}


            }
        }
    }

    return redirect(getAdminPanelUrl() . '/webinars/' . $webinar->id . '/edit?locale=' . getDefaultLocale())
        ->with('success', '✅ تم إنشاء نسخة جديدة من الدورة بجميع محتوياتها بما في ذلك التقييم والأسئلة والأجوبة والفئات.');
}



    public function index(Request $request)
    {
        $this->authorize('admin_webinars_list');

        removeContentLocale();

        $type = $request->get('type', 'webinar');
        $query = Webinar::byBranch()->where('webinars.type', $type);
        //return $query;
        $totalWebinars = $query->count();
        $totalPendingWebinars = deepClone($query)->where('webinars.status', 'pending')->count();
        $totalDurations = deepClone($query)->sum('duration');
        $totalSales = deepClone($query)->join('sales', 'webinars.id', '=', 'sales.webinar_id')
            ->select(DB::raw('count(sales.webinar_id) as sales_count'))
            ->whereNotNull('sales.webinar_id')
            ->whereNull('sales.refund_at')
            ->first();

        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();

        $inProgressWebinars = 0;
        if ($type == 'webinar') {
            $inProgressWebinars = $this->getInProgressWebinarsCount();
        }

        $query = $this->filterWebinar($query, $request)
            ->with([
                'category',
                'teacher' => function ($qu) {
                    $qu->select('id', 'full_name');
                },
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                }
            ]);

        $webinars = $query->paginate(10);

        if ($request->get('status', null) == 'active_finished') {
            foreach ($webinars as $key => $webinar) {
                if ($webinar->last_date > time()) { // is in progress
                    unset($webinars[$key]);
                }
            }
        }

        foreach ($webinars as $webinar) {
            $giftsIds = Gift::query()->where('webinar_id', $webinar->id)
                ->where('status', 'active')
                ->where(function ($query) {
                    $query->whereNull('date');
                    $query->orWhere('date', '<', time());
                })
                ->whereHas('sale')
                ->pluck('id')
                ->toArray();

            $sales = Sale::query()
                ->where(function ($query) use ($webinar, $giftsIds) {
                    $query->where('webinar_id', $webinar->id);
                    $query->orWhereIn('gift_id', $giftsIds);
                })
                ->whereNull('refund_at')
                ->get();

            $webinar->sales = $sales;
        }


        $data = [
            'pageTitle' => trans('admin/pages/webinars.webinars_list_page_title'),
            'webinars' => $webinars,
            'totalWebinars' => $totalWebinars,
            'totalPendingWebinars' => $totalPendingWebinars,
            'totalDurations' => $totalDurations,
            'totalSales' => !empty($totalSales) ? $totalSales->sales_count : 0,
            'categories' => $categories,
            'inProgressWebinars' => $inProgressWebinars,
            'classesType' => $type,
        ];
    //   return $webinars;
        $teacher_ids = $request->get('teacher_ids', null);
        if (!empty($teacher_ids)) {
            $data['teachers'] = User::select('id', 'full_name')->whereIn('id', $teacher_ids)->get();
        }

        return view('admin.webinars.lists', $data);
    }

    public function create_scorm(Request $request)
    {

        $this->authorize('admin_webinars_list');

        removeContentLocale();

        $type = $request->get('type', 'webinar');
        $query = Webinar::byBranch()->where('webinars.type', $type);
        //return $query;
        $totalWebinars = $query->count();
        $totalPendingWebinars = deepClone($query)->where('webinars.status', 'pending')->count();
        $totalDurations = deepClone($query)->sum('duration');
        $totalSales = deepClone($query)->join('sales', 'webinars.id', '=', 'sales.webinar_id')
            ->select(DB::raw('count(sales.webinar_id) as sales_count'))
            ->whereNotNull('sales.webinar_id')
            ->whereNull('sales.refund_at')
            ->first();

        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();

        $inProgressWebinars = 0;
        if ($type == 'webinar') {
            $inProgressWebinars = $this->getInProgressWebinarsCount();
        }

        $query = $this->filterWebinar($query, $request)
            ->with([
                'category',
                'teacher' => function ($qu) {
                    $qu->select('id', 'full_name');
                },
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                }
            ]);

        $webinars = $query->paginate(10);

        if ($request->get('status', null) == 'active_finished') {
            foreach ($webinars as $key => $webinar) {
                if ($webinar->last_date > time()) { // is in progress
                    unset($webinars[$key]);
                }
            }
        }

        foreach ($webinars as $webinar) {
            $giftsIds = Gift::query()->where('webinar_id', $webinar->id)
                ->where('status', 'active')
                ->where(function ($query) {
                    $query->whereNull('date');
                    $query->orWhere('date', '<', time());
                })
                ->whereHas('sale')
                ->pluck('id')
                ->toArray();

            $sales = Sale::query()
                ->where(function ($query) use ($webinar, $giftsIds) {
                    $query->where('webinar_id', $webinar->id);
                    $query->orWhereIn('gift_id', $giftsIds);
                })
                ->whereNull('refund_at')
                ->get();

            $webinar->sales = $sales;
        }


        $data = [
            'pageTitle' => trans('admin/pages/webinars.webinars_list_page_title'),
            'webinars' => $webinars,
            'totalWebinars' => $totalWebinars,
            'totalPendingWebinars' => $totalPendingWebinars,
            'totalDurations' => $totalDurations,
            'totalSales' => !empty($totalSales) ? $totalSales->sales_count : 0,
            'categories' => $categories,
            'inProgressWebinars' => $inProgressWebinars,
            'classesType' => $type,
        ];
        $teacher_ids = $request->get('teacher_ids', null);
        if (!empty($teacher_ids)) {
            $data['teachers'] = User::select('id', 'full_name')->whereIn('id', $teacher_ids)->get();
        }

        return  view('admin.webinars.create_scorm' , $data);
    }

    public function update_scorm(Request $request, $id)
    {
    $this->authorize('admin_webinars_edit');

    $webinar = Webinar::findOrFail($id);

    $this->validate($request, [
        'type' => 'required|in:webinar,course,text_lesson,exam,eval,offline',
        'title' => 'required|max:255',
        'slug' => 'max:255|unique:webinars,slug,' . $webinar->id,
        'thumbnail' => 'required_unless:type,exam,eval',
        'scorm' => ['nullable', 'file', 'mimes:zip'],
        'description' => 'required_unless:type,exam,eval',
        'teacher_id' => 'required|exists:users,id',
        'category_id' => 'required',
        'duration' => 'required_unless:type,exam,eval|numeric',
        'start_date' => 'required_if:type,webinar',
        'capacity' => 'nullable|numeric|min:0',
        'price' => 'nullable|numeric|min:0',
        'discount_rate' => 'nullable|numeric|min:0|max:100',
        'branch_id' => 'required|numeric',
    ]);

    $data = $request->all();

    // ---------- لو فيه SCORM جديد ----------
    if ($request->hasFile('scorm')) {
        $uploadedFile = $request->file('scorm');
        $originalName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $timestamp = now()->format('Ymd_His');
        $safeBaseName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $archiveName = $safeBaseName . '_' . $timestamp . '.zip';

        $disk = Storage::disk('local');
        $storedArchivePath = $disk->putFileAs('scorm_uploads', $uploadedFile, $archiveName);

        $extractFolder = 'scorm/' . $safeBaseName . '_' . $timestamp;
        $absoluteExtractPath = $disk->path($extractFolder);

        if (!is_dir($absoluteExtractPath)) {
            mkdir($absoluteExtractPath, 0755, true);
        }

        $zip = new \ZipArchive();
        $absoluteArchivePath = $disk->path($storedArchivePath);
        $realArchivePath = realpath($absoluteArchivePath) ?: $absoluteArchivePath;

        if ($zip->open($realArchivePath) === true) {
            $zip->extractTo($absoluteExtractPath);
            $zip->close();
        } else {
            return back()->withErrors(['scorm' => 'تعذّر فتح أو فك ضغط ملف SCORM']);
        }

        // قراءة manifest وتحديد launchPath
        $manifestAbsolutePath = $this->findManifest($absoluteExtractPath);
        $launchPath = null;

        if ($manifestAbsolutePath && file_exists($manifestAbsolutePath)) {
            try {
                $xml = simplexml_load_file($manifestAbsolutePath);
                if ($xml !== false) {
                    $xml->registerXPathNamespace('adlcp', 'http://www.adlnet.org/xsd/adlcp_rootv1p2');
                    $resourceMap = [];
                    if (isset($xml->resources->resource)) {
                        foreach ($xml->resources->resource as $resource) {
                            $rid = (string)($resource['identifier'] ?? '');
                            $href = (string)($resource['href'] ?? '');
                            if ($rid && $href) {
                                $resourceMap[$rid] = $href;
                            }
                        }
                    }
                    $organizations = $xml->organizations->organization ?? [];
                    foreach ($organizations as $org) {
                        foreach ($org->item as $item) {
                            if ($launchPath === null) {
                                $href = $this->findFirstHrefFromItems($item, $resourceMap);
                                if ($href) {
                                    $launchPath = $href;
                                }
                            }
                        }
                    }
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        if ($launchPath === null) {
            $launchPath = 'index.html';
        }

        // تحديث الحقول الخاصة بالـ SCORM
        $webinar->update([
            'scorm_file' => $archiveName,
            'scorm_folder' => $extractFolder,
            'scorm_launch_path' => $launchPath,
        ]);
    }

    // ---------- باقي الحقول ----------
    if ($data['type'] != Webinar::$webinar) {
        $data['start_date'] = null;
    }

    if (!empty($data['start_date']) and $data['type'] == Webinar::$webinar) {
        if (empty($data['timezone'])) {
            $data['timezone'] = getTimezone();
        }
        $startDate = convertTimeToUTCzone($data['start_date'], $data['timezone']);
        $data['start_date'] = $startDate->getTimestamp();
    }
    if (empty($data['slug'])) {
        $data['slug'] = Webinar::makeSlug($data['title']);
    }

    $data = $this->handleVideoDemoData($request, $data, "course_demo_" . time());

    $newCreatorId = !empty($data['organ_id']) ? $data['organ_id'] : $data['teacher_id'];
    $changedCreator = ($webinar->creator_id != $newCreatorId);
    $webinar->branches()->sync($data['branch_id']);

    $data['price'] = !empty($data['price']) ? convertPriceToDefaultCurrency($data['price']) : null;
    $data['organization_price'] = !empty($data['organization_price']) ? convertPriceToDefaultCurrency($data['organization_price']) : null;

    if (empty($data['image_cover'])) {
        $data['image_cover'] = $data['thumbnail'];
    }

    $webinar->update([
        'type' => $data['type'],
        'slug' => $data['slug'],
        'teacher_id' => $data['teacher_id'],
        'creator_id' => $data['teacher_id'],
        'thumbnail' => $data['thumbnail'],
        'image_cover' => $data['image_cover'] ?? $data['thumbnail'],
        'video_demo' => $data['video_demo'],
        'approval_logo' => $data['approval_logo'],
        'video_demo_source' => $data['video_demo'] ? $data['video_demo_source'] : null,
        'sales_count_number' => $data['sales_count_number'] ?? null,
        'capacity' => $data['capacity'] ?? null,
        'start_date' => $data['start_date'] ?? null,
        'timezone' => $data['timezone'] ?? null,
        'duration' => $data['duration'] ?? null,
        'support' => !empty($data['support']),
        'downloadable' => !empty($data['downloadable']),
        'partner_instructor' => !empty($data['partner_instructor']),
        'subscribe' => !empty($data['subscribe']),
        'private' => !empty($data['private']),
        'forum' => !empty($data['forum']),
        'branch_id' => $data['branch_id'],
        'enable_waitlist' => !empty($data['enable_waitlist']),
        'access_days' => $data['access_days'] ?? null,
        'price' => $data['price'],
        'discount_rate' => $data['discount_rate'] ?? 0,
        'organization_price' => $data['organization_price'] ?? null,
        'points' => $data['points'] ?? null,
        'category_id' => $data['category_id'],
        'message_for_reviewer' => $data['message_for_reviewer'] ?? null,
        'updated_at' => time(),
    ]);

    // تحديث الأقسام
    $sections = [];
    if (in_array($data['type'], ['text_lesson', 'course']) && !empty($data['section_title'])) {
        foreach ($data['section_title'] as $index => $title) {
            $sections[] = [
                'title' => $title,
                'detail' => $data['section_details'][$index] ?? '',
            ];
        }
    }
    $sectionsJson = json_encode($sections);

    // تحديث الترجمة
    WebinarTranslation::updateOrCreate([
        'webinar_id' => $webinar->id,
        'locale' => mb_strtolower($data['locale']),
    ], [
        'title' => $data['title'],
        'description' => $data['description'],
        'seo_description' => $data['seo_description'],
        'sections' => $sectionsJson,
        'approval_name' => $data['approval_name'] ?? "",
    ]);

    $webinar->branches()->sync($data['branch_id']);

    // تحديث الفلاتر
    WebinarFilterOption::where('webinar_id', $webinar->id)->delete();
    if (!empty($data['filters'])) {
        foreach ($data['filters'] as $filter) {
            WebinarFilterOption::create([
                'webinar_id' => $webinar->id,
                'filter_option_id' => $filter
            ]);
        }
    }

    // تحديث التاجز
    Tag::where('webinar_id', $webinar->id)->delete();
    if (!empty($data['tags'])) {
        foreach (explode(',', $data['tags']) as $tag) {
            Tag::create([
                'webinar_id' => $webinar->id,
                'title' => trim($tag),
            ]);
        }
    }

    return redirect(getAdminPanelUrl() . '/webinars/' . $webinar->id . '/edit?locale=' . $data['locale']);
}

    private function filterWebinar($query, $request)
    {
        $from = $request->get('from', null);
        $to = $request->get('to', null);
        $title = $request->get('title', null);
        $teacher_ids = $request->get('teacher_ids', null);
        $category_id = $request->get('category_id', null);
        $status = $request->get('status', null);
        $sort = $request->get('sort', null);

        $query = fromAndToDateFilter($from, $to, $query, 'created_at');
$query=$query->byBranch();
        if (!empty($title)) {
            $query->whereTranslationLike('title', '%' . $title . '%');
        }

        if (!empty($teacher_ids) and count($teacher_ids)) {
            $query->whereIn('teacher_id', $teacher_ids);
        }

        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        }

        if (!empty($status)) {
            $time = time();

            switch ($status) {
                case 'active_not_conducted':
                    $query->where('webinars.status', 'active')
                        ->where('start_date', '>', $time);
                    break;
                case 'active_in_progress':
                    $query->where('webinars.status', 'active')
                        ->where('start_date', '<=', $time)
                        ->join('sessions', 'webinars.id', '=', 'sessions.webinar_id')
                        ->select('webinars.*', 'sessions.date', DB::raw('max(`date`) as last_date'))
                        ->groupBy('sessions.webinar_id')
                        ->where('sessions.date', '>', $time);
                    break;
                case 'active_finished':
                    $query->where('webinars.status', 'active')
                        ->where('start_date', '<=', $time)
                        ->join('sessions', 'webinars.id', '=', 'sessions.webinar_id')
                        ->select('webinars.*', 'sessions.date', DB::raw('max(`date`) as last_date'))
                        ->groupBy('sessions.webinar_id');
                    break;
                default:
                    $query->where('webinars.status', $status);
                    break;
            }
        }

        if (!empty($sort)) {
            switch ($sort) {
                case 'has_discount':
                    $now = time();
                    $webinarIdsHasDiscount = [];

                    $tickets = Ticket::where('start_date', '<', $now)
                        ->where('end_date', '>', $now)
                        ->get();

                    foreach ($tickets as $ticket) {
                        if ($ticket->isValid()) {
                            $webinarIdsHasDiscount[] = $ticket->webinar_id;
                        }
                    }

                    $specialOffersWebinarIds = SpecialOffer::where('status', 'active')
                        ->where('from_date', '<', $now)
                        ->where('to_date', '>', $now)
                        ->pluck('webinar_id')
                        ->toArray();

                    $webinarIdsHasDiscount = array_merge($specialOffersWebinarIds, $webinarIdsHasDiscount);

                    $query->whereIn('id', $webinarIdsHasDiscount)
                        ->orderBy('created_at', 'desc');
                    break;
                case 'sales_asc':
                    $query->join('sales', 'webinars.id', '=', 'sales.webinar_id')
                        ->select('webinars.*', 'sales.webinar_id', 'sales.refund_at', DB::raw('count(sales.webinar_id) as sales_count'))
                        ->whereNotNull('sales.webinar_id')
                        ->whereNull('sales.refund_at')
                        ->groupBy('sales.webinar_id')
                        ->orderBy('sales_count', 'asc');
                    break;
                case 'sales_desc':
                    $query->join('sales', 'webinars.id', '=', 'sales.webinar_id')
                        ->select('webinars.*', 'sales.webinar_id', 'sales.refund_at', DB::raw('count(sales.webinar_id) as sales_count'))
                        ->whereNotNull('sales.webinar_id')
                        ->whereNull('sales.refund_at')
                        ->groupBy('sales.webinar_id')
                        ->orderBy('sales_count', 'desc');
                    break;

                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;

                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;

                case 'income_asc':
                    $query->join('sales', 'webinars.id', '=', 'sales.webinar_id')
                        ->select('webinars.*', 'sales.webinar_id', 'sales.total_amount', 'sales.refund_at', DB::raw('(sum(sales.total_amount) - (sum(sales.tax) + sum(sales.commission))) as amounts'))
                        ->whereNotNull('sales.webinar_id')
                        ->whereNull('sales.refund_at')
                        ->groupBy('sales.webinar_id')
                        ->orderBy('amounts', 'asc');
                    break;

                case 'income_desc':
                    $query->join('sales', 'webinars.id', '=', 'sales.webinar_id')
                        ->select('webinars.*', 'sales.webinar_id', 'sales.total_amount', 'sales.refund_at', DB::raw('(sum(sales.total_amount) - (sum(sales.tax) + sum(sales.commission))) as amounts'))
                        ->whereNotNull('sales.webinar_id')
                        ->whereNull('sales.refund_at')
                        ->groupBy('sales.webinar_id')
                        ->orderBy('amounts', 'desc');
                    break;

                case 'created_at_asc':
                    $query->orderBy('created_at', 'asc');
                    break;

                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;

                case 'updated_at_asc':
                    $query->orderBy('updated_at', 'asc');
                    break;

                case 'updated_at_desc':
                    $query->orderBy('updated_at', 'desc');
                    break;

                case 'public_courses':
                    $query->where('private', false);
                    $query->orderBy('created_at', 'desc');
                    break;

                case 'courses_private':
                    $query->where('private', true);
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }


        return $query;
    }

    private function getInProgressWebinarsCount()
    {
        $count = 0;
        $webinars = Webinar::where('type', 'webinar')
            ->where('status', 'active')
            ->where('start_date', '<=', time())
            ->whereHas('sessions')
            ->get();

        foreach ($webinars as $webinar) {
            if ($webinar->isProgressing()) {
                $count += 1;
            }
        }

        return $count;
    }

    public function create()
    {
        $this->authorize('admin_webinars_create');

        removeContentLocale();

        $teachers = User::where('role_name', Role::$teacher)->get();
        $categories = Category::where('parent_id', null)->get();

        $data = [
            'pageTitle' => trans('admin/main.webinar_new_page_title'),
            'teachers' => $teachers,
            'categories' => $categories
        ];

        return view('admin.webinars.create', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('admin_webinars_create');
        //add validation not  requred  for  exam
        $this->validate($request, [
            'type' => 'required|in:webinar,course,text_lesson,exam,eval,offline',
            'title' => 'required|max:255',
            'slug' => 'max:255|unique:webinars,slug',
            'thumbnail' => 'required_unless:type,exam,eval',
          //  'image_cover' => 'required_unless:type,exam,eval',
            'description' => 'required_unless:type,exam,eval',
            'teacher_id' => 'required|exists:users,id',
            'category_id' => 'required',
            'duration' => 'required_unless:type,exam,eval|numeric',
            'start_date' => 'required_if:type,webinar',
            'capacity' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'discount_rate' => 'nullable|numeric|min:0|max:100',
             'branch_id' => 'required|numeric',
        ]);


        $data = $request->all();
        //exam
        if ($data['type'] === 'exam') {
            $data['thumbnail'] = $data['thumbnail'] ?? 'default_thumbnail.jpg';
            $data['image_cover'] = $data['image_cover'] ?? 'default_image_cover.jpg';
            $data['description'] = $data['description'] ?? 'No description provided.';
            $data['seo_description']=NULL;
            $data['video_demo']=NULL;
            $data['approval_name']=NULL;
            $data['approval_logo']=NULL;

        }
      //eval
        if ($data['type'] === 'eval') {
            $data['thumbnail'] = $data['thumbnail'] ?? 'default_thumbnail.jpg';
            $data['image_cover'] = $data['image_cover'] ?? 'default_image_cover.jpg';
            $data['description'] = $data['description'] ?? 'No description provided.';
            $data['seo_description']=NULL;
            $data['video_demo']=NULL;
            $data['approval_name']=NULL;
            $data['approval_logo']=NULL;

        }

        if (!empty($data['capacity']) and !empty($data['sales_count_number']) and $data['sales_count_number'] > $data['capacity']) {
            return back()->withErrors([
                'sales_count_number' => [
                    trans('validation.digits_between', [
                        'attribute' => trans('update.sales_count_number'),
                        'min' => 0,
                        'max' => $data['capacity']
                    ])
                ]
            ]);
        }



        if ($data['type'] != Webinar::$webinar) {
            $data['start_date'] = null;
        }

        if (!empty($data['start_date']) and $data['type'] == Webinar::$webinar) {
            if (empty($data['timezone']) or !getFeaturesSettings('timezone_in_create_webinar')) {
                $data['timezone'] = getTimezone();
            }

            $startDate = convertTimeToUTCzone($data['start_date'], $data['timezone']);

            $data['start_date'] = $startDate->getTimestamp();
        }

        if (empty($data['slug'])) {
            $data['slug'] = Webinar::makeSlug($data['title']);
        }

        $data = $this->handleVideoDemoData($request, $data, "course_demo_" . time());

        $data['price'] = !empty($data['price']) ? convertPriceToDefaultCurrency($data['price']) : null;
        $data['organization_price'] = !empty($data['organization_price']) ? convertPriceToDefaultCurrency($data['organization_price']) : null;
        if(empty($data['image_cover'])){

             $data['image_cover']=$data['thumbnail'];
        }
        $webinar = Webinar::create([
            'type' => $data['type'],
            'slug' => $data['slug'],
            'teacher_id' => $data['teacher_id'],
            'creator_id' => $data['teacher_id'],
            'thumbnail' => $data['thumbnail'],
            'image_cover' => $data['image_cover'] ?? $data['thumbnail'],
            'video_demo' => $data['video_demo'],
            'approval_logo' => $data['approval_logo'],
            'video_demo_source' => $data['video_demo'] ? $data['video_demo_source'] : null,
            'sales_count_number' => $data['sales_count_number'] ?? null,
            'capacity' => $data['capacity'] ?? null,
            'start_date' => (!empty($data['start_date'])) ? $data['start_date'] : null,
            'timezone' => $data['timezone'] ?? null,
            'duration' => $data['duration'] ?? null,
            'support' => !empty($data['support']) ? true : false,
            'certificate' => !empty($data['certificate']) ? true : false,
            'downloadable' => !empty($data['downloadable']) ? true : false,
            'partner_instructor' => !empty($data['partner_instructor']) ? true : false,
            'subscribe' => !empty($data['subscribe']) ? true : false,
            'private' => !empty($data['private']) ? true : false,
            'forum' => !empty($data['forum']) ? true : false,
            'branch_id' => $data['branch_id'],
            'enable_waitlist' => (!empty($data['enable_waitlist'])),
            'access_days' => $data['access_days'] ?? null,
            'price' => $data['price'],
             'discount_rate' => $data['discount_rate'] ?? 0,
            'organization_price' => $data['organization_price'] ?? null,
            'points' => $data['points'] ?? null,
            'category_id' => $data['category_id'],
            'message_for_reviewer' => $data['message_for_reviewer'] ?? null,
             'add_to_more' => !empty($data['add_to_more']) ? true : false,
            'status' => Webinar::$pending,
            'created_at' => time(),
            'updated_at' => time(),
        ]);


        // Prepare sections data
            $sections = [];
                 if (in_array($data['type'] ?? null, ['text_lesson', 'course']) && !empty($data['section_title'] ?? '')) {

                foreach ($data['section_title'] as $index => $title) {
                    $sections[] = [
                        'title' => $title,
                        'detail' => $data['section_details'][$index] ?? '', // Ensure detail exists
                    ];
                }
            }

            // Encode sections data as JSON
            $sectionsJson = json_encode($sections);

              $details = [];
            if(!empty($request->dates)){
            foreach ($request->dates as $key => $date) {
                $details[] = [
                    'date' => $date,
                    'start_time' => $request->start_time[$key],
                    'end_time' => $request->end_time[$key],
                    'location' => $request->locations[$key],
                    'price' => $request->prices[$key],
                    'lang' => $request->langs[$key],
                    'ndays' => $request->days[$key],
                ];
            }
            }
            $detailsJson = json_encode($sections);
                if ($webinar) {
                    WebinarTranslation::updateOrCreate([
                        'webinar_id' => $webinar->id,
                        'locale' => mb_strtolower($data['locale']),
                    ], [
                        'title' => $data['title'],
                        'description' => $data['description'],
                        'seo_description' => $data['seo_description'],
                        'sections' => $sectionsJson,
                         'details' => $detailsJson,
                        'approval_name' => $data['approval_name'] ??  "",
                    ]);
                    $webinar->branches()->attach($data['branch_id']);
                }

         if($webinar->type=='exam' || $webinar->type=='eval'){
                //add exam

                $Quizdata = $request->get('ajax')['new'];
                $locale = $data['locale'] ?? getDefaultLocale();


                if (!empty($webinar)) {
                    $chapter = null;

                 if($webinar->type=='exam' || $webinar->type=='eval')

                    $quiz = Quiz::create([
                        'webinar_id' => $webinar->id,
                        'chapter_id' => !empty($chapter) ? $chapter->id : null,
                        'creator_id' => $webinar->creator_id,
                        'attempt' => $Quizdata['attempt'] ?? null,
                        'pass_mark' => $Quizdata['pass_mark'],
                        'time' => $Quizdata['time'] ?? null,
                        'status' => (!empty($Quizdata['status']) and $Quizdata['status'] == 'on') ? Quiz::ACTIVE : Quiz::INACTIVE,
                        'certificate' => (!empty($Quizdata['certificate']) and $Quizdata['certificate'] == 'on'),
                        'display_questions_randomly' => (!empty($Quizdata['display_questions_randomly']) and $Quizdata['display_questions_randomly'] == 'on'),
                        'expiry_days' => (!empty($Quizdata['expiry_days']) and $Quizdata['expiry_days'] > 0) ? $Quizdata['expiry_days'] : null,
                        'created_at' => time(),
                    ]);



                    if($quiz)
                {
                    QuizTranslation::updateOrCreate([
                        'quiz_id' => $quiz->id,
                        'locale' => mb_strtolower($locale),
                    ], [
                        'title' => $data['title'],
                    ]);

                }

                }
         }


                $filters = $request->get('filters', null);
                if (!empty($filters) and is_array($filters)) {
                    WebinarFilterOption::where('webinar_id', $webinar->id)->delete();
                    foreach ($filters as $filter) {
                        WebinarFilterOption::create([
                            'webinar_id' => $webinar->id,
                            'filter_option_id' => $filter
                        ]);
                    }
                }

                if (!empty($request->get('tags'))) {
                    $tags = explode(',', $request->get('tags'));
                    Tag::where('webinar_id', $webinar->id)->delete();

                    foreach ($tags as $tag) {
                        Tag::create([
                            'webinar_id' => $webinar->id,
                            'title' => $tag,
                        ]);
                    }
                }

                if (!empty($request->get('partner_instructor')) and !empty($request->get('partners'))) {
                    WebinarPartnerTeacher::where('webinar_id', $webinar->id)->delete();

                    foreach ($request->get('partners') as $partnerId) {
                        WebinarPartnerTeacher::create([
                            'webinar_id' => $webinar->id,
                            'teacher_id' => $partnerId,
                        ]);
                    }
                }


        return redirect(getAdminPanelUrl() . '/webinars/' . $webinar->id . '/edit?locale=' . $data['locale']);
    }

    public function store_scorm(Request $request)
    {
        $this->authorize('admin_webinars_create');

        $this->validate($request, [
            'type' => 'required|in:webinar,course,text_lesson,exam,eval,offline',
            'title' => 'required|max:255',
            'slug' => 'max:255|unique:webinars,slug',
            'thumbnail' => 'required_unless:type,exam,eval',
            'scorm' => ['required', 'file', 'mimes:zip'],
            'description' => 'required_unless:type,exam,eval',
            'teacher_id' => 'required|exists:users,id',
            'category_id' => 'required',
            'duration' => 'required_unless:type,exam,eval|numeric',
            'start_date' => 'required_if:type,webinar',
            'capacity' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'discount_rate' => 'nullable|numeric|min:0|max:100',
            'branch_id' => 'required|numeric',
        ]);


        $data = $request->all();

        $uploadedFile = $request->file('scorm');
        $originalName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $timestamp = now()->format('Ymd_His');
        $safeBaseName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $archiveName = $safeBaseName . '_' . $timestamp . '.zip';

        $disk = Storage::disk('local');
        $storedArchivePath = $disk->putFileAs('scorm_uploads', $uploadedFile, $archiveName);

        $extractFolder = 'scorm/' . $safeBaseName . '_' . $timestamp;
        $absoluteExtractPath = $disk->path($extractFolder);

        if (!is_dir($absoluteExtractPath)) {
            mkdir($absoluteExtractPath, 0755, true);
        }

        $zip = new ZipArchive();
        $absoluteArchivePath = $disk->path($storedArchivePath);
        $realArchivePath = realpath($absoluteArchivePath) ?: $absoluteArchivePath;

        if (!file_exists($realArchivePath)) {
            return back()->withErrors(['scorm' => 'تعذّر العثور على الملف بعد الرفع: ' . $storedArchivePath]);
        }

        $openResult = $zip->open($realArchivePath);

        if ($openResult !== true) {
            return back()->withErrors(['scorm' => 'تعذّر فتح ملف الـ ZIP. الكود: ' . $openResult . ' - ' . $this->describeZipError($openResult)]);
        }

        if (!$zip->extractTo($absoluteExtractPath)) {
            $zip->close();
            return back()->withErrors(['scorm' => 'تعذّر استخراج محتويات الملف.']);
        }
        $zip->close();

        $manifestAbsolutePath = $this->findManifest($absoluteExtractPath);

        $manifestItems = [];
        $launchPath = null;
        if ($manifestAbsolutePath && file_exists($manifestAbsolutePath)) {
            try {
                $xml = simplexml_load_file($manifestAbsolutePath);
                if ($xml !== false) {
                    $xml->registerXPathNamespace('adlcp', 'http://www.adlnet.org/xsd/adlcp_rootv1p2');
                    $xml->registerXPathNamespace('imsss', 'http://www.imsglobal.org/xsd/imsss');
                    $xml->registerXPathNamespace('lom', 'http://ltsc.ieee.org/xsd/LOM');
                    $xml->registerXPathNamespace('xsi', 'http://www.w3.org/2001/XMLSchema-instance');
                    $xml->registerXPathNamespace('ns', $xml->getDocNamespaces()[''] ?? '');

                    $organizations = $xml->organizations->organization ?? [];
                    $resourceMap = [];
                    if (isset($xml->resources) && isset($xml->resources->resource)) {
                        foreach ($xml->resources->resource as $resource) {
                            $rid = (string)($resource['identifier'] ?? '');
                            $href = (string)($resource['href'] ?? '');
                            if ($rid !== '' && $href !== '') {
                                $resourceMap[$rid] = $href;
                            }
                        }
                    }

                    $manifestDir = dirname($manifestAbsolutePath);
                    $manifestDirRelToExtract = $this->relativePath($absoluteExtractPath, $manifestDir);

                    foreach ($organizations as $organization) {
                        foreach ($organization->item as $item) {
                            $this->collectManifestItems($item, $manifestItems);
                            if ($launchPath === null) {
                                $href = $this->findFirstHrefFromItems($item, $resourceMap);
                                if ($href) {
                                    $launchPath = ltrim(($manifestDirRelToExtract !== '' ? $manifestDirRelToExtract . '/' : '') . $href, '/');
                                }
                            }
                        }
                    }

                    // If still no launch path, try index.html next to manifest
                    if ($launchPath === null) {
                        $candidate = $manifestDir . DIRECTORY_SEPARATOR . 'index.html';
                        if (file_exists($candidate)) {
                            $launchPath = ltrim(($manifestDirRelToExtract !== '' ? $manifestDirRelToExtract . '/' : '') . 'index.html', '/');
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Ignore parsing errors; we'll just not show manifest items
            }
        }
        // Build a flat list of files relative to the extract root
        $relativeFiles = $this->listFilesRecursively($absoluteExtractPath, $absoluteExtractPath);

        // Fallback: scan common launch filenames anywhere if we still don't have a working launchPath
        if ($launchPath === null) {
            $common = [
                'index_lms.html', 'index_scorm.html', 'story_html5.html', 'story.html',
                'index.html', 'launch.html', 'start.html', 'player.html'
            ];
            $lowerCandidates = array_map('strtolower', $common);
            foreach ($relativeFiles as $relativePath) {
                $lowerBase = strtolower(basename($relativePath));
                if (in_array($lowerBase, $lowerCandidates, true)) {
                    $launchPath = str_replace('\\', '/', $relativePath);
                    break;
                }
            }
        }


        if (!empty($data['capacity']) and !empty($data['sales_count_number']) and $data['sales_count_number'] > $data['capacity']) {
            return back()->withErrors([
                'sales_count_number' => [
                    trans('validation.digits_between', [
                        'attribute' => trans('update.sales_count_number'),
                        'min' => 0,
                        'max' => $data['capacity']
                    ])
                ]
            ]);
        }



        if ($data['type'] != Webinar::$webinar) {
            $data['start_date'] = null;
        }

        if (!empty($data['start_date']) and $data['type'] == Webinar::$webinar) {
            if (empty($data['timezone']) or !getFeaturesSettings('timezone_in_create_webinar')) {
                $data['timezone'] = getTimezone();
            }

            $startDate = convertTimeToUTCzone($data['start_date'], $data['timezone']);

            $data['start_date'] = $startDate->getTimestamp();
        }

        if (empty($data['slug'])) {
            $data['slug'] = Webinar::makeSlug($data['title']);
        }

        $data = $this->handleVideoDemoData($request, $data, "course_demo_" . time());

        $data['price'] = !empty($data['price']) ? convertPriceToDefaultCurrency($data['price']) : null;

        $data['organization_price'] = !empty($data['organization_price']) ? convertPriceToDefaultCurrency($data['organization_price']) : null;

        if(empty($data['image_cover'])){

             $data['image_cover']=$data['thumbnail'];
        }

        $webinar = Webinar::create([
            'type' => $data['type'],
            'slug' => $data['slug'],
            'teacher_id' => $data['teacher_id'],
            'creator_id' => $data['teacher_id'],
            'thumbnail' => $data['thumbnail'],
            'image_cover' => $data['image_cover'] ?? $data['thumbnail'],
            'video_demo' => $data['video_demo'],
            'approval_logo' => $data['approval_logo'],
            'video_demo_source' => $data['video_demo'] ? $data['video_demo_source'] : null,
            'sales_count_number' => $data['sales_count_number'] ?? null,
            'capacity' => $data['capacity'] ?? null,
            'start_date' => (!empty($data['start_date'])) ? $data['start_date'] : null,
            'timezone' => $data['timezone'] ?? null,
            'duration' => $data['duration'] ?? null,
            'support' => !empty($data['support']) ? true : false,
            'downloadable' => !empty($data['downloadable']) ? true : false,
            'partner_instructor' => !empty($data['partner_instructor']) ? true : false,
            'subscribe' => !empty($data['subscribe']) ? true : false,
            'private' => !empty($data['private']) ? true : false,
            'forum' => !empty($data['forum']) ? true : false,
            'branch_id' => $data['branch_id'],
            'enable_waitlist' => (!empty($data['enable_waitlist'])),
            'access_days' => $data['access_days'] ?? null,
            'price' => $data['price'],
            'discount_rate' => $data['discount_rate'] ?? 0,
            'organization_price' => $data['organization_price'] ?? null,
            'points' => $data['points'] ?? null,
            'category_id' => $data['category_id'],
            'message_for_reviewer' => $data['message_for_reviewer'] ?? null,
            'add_to_more' => !empty($data['add_to_more']) ? true : false,
            'status' => Webinar::$pending,
            'created_at' => time(),
            'updated_at' => time(),
            'scorm_file' => $archiveName,
            'scorm_folder' => $extractFolder,
            'scorm_launch_path' => $launchPath ?? 'index.html',
        ]);

        // Prepare sections data
        $sections = [];
        if (in_array($data['type'] ?? null, ['text_lesson', 'course']) && !empty($data['section_title'] ?? '')) {

        foreach ($data['section_title'] as $index => $title) {
            $sections[] = [
                'title' => $title,
                'detail' => $data['section_details'][$index] ?? '', // Ensure detail exists
            ];
        }
    }

        // Encode sections data as JSON
        $sectionsJson = json_encode($sections);

         $details = [];
        if(!empty($request->dates)){
            foreach ($request->dates as $key => $date) {
            $details[] = [
                'date' => $date,
                'start_time' => $request->start_time[$key],
                'end_time' => $request->end_time[$key],
                'location' => $request->locations[$key],
                'price' => $request->prices[$key],
                'lang' => $request->langs[$key],
                'ndays' => $request->days[$key],
            ];
        }
        }
        $detailsJson = json_encode($sections);
        if ($webinar) {
            WebinarTranslation::updateOrCreate([
                'webinar_id' => $webinar->id,
                'locale' => mb_strtolower($data['locale']),
            ], [
                'title' => $data['title'],
                'description' => $data['description'],
                'seo_description' => $data['seo_description'],
                'sections' => $sectionsJson,
                 'details' => $detailsJson,
                'approval_name' => $data['approval_name'] ??  "",
            ]);
            $webinar->branches()->attach($data['branch_id']);
        }

        $filters = $request->get('filters', null);
        if (!empty($filters) and is_array($filters)) {
            WebinarFilterOption::where('webinar_id', $webinar->id)->delete();
            foreach ($filters as $filter) {
                WebinarFilterOption::create([
                    'webinar_id' => $webinar->id,
                    'filter_option_id' => $filter
                ]);
            }
        }

        if (!empty($request->get('tags'))) {
            $tags = explode(',', $request->get('tags'));
            Tag::where('webinar_id', $webinar->id)->delete();

            foreach ($tags as $tag) {
                Tag::create([
                    'webinar_id' => $webinar->id,
                    'title' => $tag,
                ]);
            }
        }

        if (!empty($request->get('partner_instructor')) and !empty($request->get('partners'))) {
            WebinarPartnerTeacher::where('webinar_id', $webinar->id)->delete();

            foreach ($request->get('partners') as $partnerId) {
                WebinarPartnerTeacher::create([
                    'webinar_id' => $webinar->id,
                    'teacher_id' => $partnerId,
                ]);
            }
        }


        return redirect(getAdminPanelUrl() . '/webinars/' . $webinar->id . '/edit?locale=' . $data['locale']);
    }

    private function describeZipError(int $code): string
    {
        $map = [
            ZipArchive::ER_MULTIDISK => 'الأرشيف متعدد الأقراص غير مدعوم',
            ZipArchive::ER_RENAME => 'فشل في إعادة تسمية الملف المؤقت',
            ZipArchive::ER_CLOSE => 'فشل في إغلاق الأرشيف',
            ZipArchive::ER_SEEK => 'فشل الانتقال داخل الملف',
            ZipArchive::ER_READ => 'فشل قراءة الملف',
            ZipArchive::ER_WRITE => 'فشل كتابة الملف',
            ZipArchive::ER_CRC => 'خطأ CRC',
            ZipArchive::ER_ZIPCLOSED => 'الأرشيف مغلق',
            ZipArchive::ER_NOENT => 'لم يتم العثور على الملف',
            ZipArchive::ER_EXISTS => 'الملف موجود مسبقاً',
            ZipArchive::ER_OPEN => 'تعذّر فتح الملف',
            ZipArchive::ER_TMPOPEN => 'تعذّر فتح ملف مؤقت',
            ZipArchive::ER_ZLIB => 'خطأ Zlib',
            ZipArchive::ER_MEMORY => 'نفاد الذاكرة',
            ZipArchive::ER_CHANGED => 'تم تغيير الأرشيف',
            ZipArchive::ER_COMPNOTSUPP => 'خوارزمية الضغط غير مدعومة',
            ZipArchive::ER_EOF => 'نهاية غير متوقعة للملف',
            ZipArchive::ER_INVAL => 'وسائط غير صالحة',
            ZipArchive::ER_NOZIP => 'الملف ليس ZIP صالح',
            ZipArchive::ER_INTERNAL => 'خطأ داخلي',
            ZipArchive::ER_INCONS => 'عدم اتساق في الأرشيف',
            ZipArchive::ER_REMOVE => 'تعذّر حذف الملف',
            ZipArchive::ER_DELETED => 'تم حذف الإدخال',
            // تتضمن بعض الإصدارات هذه القيم فقط عند تفعيل التشفير:
            // ZipArchive::ER_ENCRNOTSUPP => 'التشفير غير مدعوم',
            // ZipArchive::ER_RDONLY => 'الأرشيف للقراءة فقط',
            // ZipArchive::ER_NOPASSWD => 'مطلوب كلمة مرور',
            // ZipArchive::ER_WRONGPASS => 'كلمة مرور غير صحيحة',
            // ZipArchive::ER_CANCELLED => 'تم الإلغاء',
        ];
        return $map[$code] ?? 'سبب غير معروف';
    }

    private function listFilesRecursively(string $basePath, string $rootPath): array
    {
        $results = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($basePath, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isDir()) {
                continue;
            }
            $absolutePath = $fileInfo->getPathname();
            $relativePath = ltrim(str_replace($rootPath, '', $absolutePath), DIRECTORY_SEPARATOR);
            $results[] = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);
        }

        sort($results);
        return $results;
    }

    private function findManifest(string $extractRoot): ?string
    {
        $candidate = $extractRoot . DIRECTORY_SEPARATOR . 'imsmanifest.xml';
        if (file_exists($candidate)) {
            return $candidate;
        }

        // Fallback: search recursively for imsmanifest.xml
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($extractRoot, \FilesystemIterator::SKIP_DOTS)
        );
        foreach ($iterator as $fileInfo) {
            if (!$fileInfo->isFile()) {
                continue;
            }
            if (strtolower($fileInfo->getFilename()) === 'imsmanifest.xml') {
                return $fileInfo->getPathname();
            }
        }
        return null;
    }

    private function relativePath(string $fromAbsolute, string $toAbsolute): string
    {
        $from = rtrim(str_replace('\\', '/', realpath($fromAbsolute) ?: $fromAbsolute), '/');
        $to = rtrim(str_replace('\\', '/', realpath($toAbsolute) ?: $toAbsolute), '/');
        if (strpos($to, $from) === 0) {
            $rel = ltrim(substr($to, strlen($from)), '/');
            return $rel;
        }
        return '';
    }

    private function collectManifestItems(\SimpleXMLElement $item, array &$manifestItems): void
    {
        $manifestItems[] = [
            'title' => (string)($item->title ?? ''),
            'identifier' => (string)($item['identifier'] ?? ''),
            'identifierref' => (string)($item['identifierref'] ?? ''),
        ];
        foreach ($item->item as $child) {
            $this->collectManifestItems($child, $manifestItems);
        }
    }

    private function findFirstHrefFromItems(\SimpleXMLElement $item, array $resourceMap): ?string
    {
        $ref = (string)($item['identifierref'] ?? '');
        if ($ref !== '' && isset($resourceMap[$ref])) {
            return $resourceMap[$ref];
        }
        foreach ($item->item as $child) {
            $href = $this->findFirstHrefFromItems($child, $resourceMap);
            if ($href) {
                return $href;
            }
        }
        return null;
    }
    //create eval
    public function createEval()
    {
        $this->authorize('admin_webinars_create');

        removeContentLocale();

        $teachers = User::where('role_name', Role::$teacher)->get();
        $categories = Category::where('parent_id', null)->get();

        $data = [
            'pageTitle' =>'اضافة تقييم',
            'teachers' => $teachers,
            'categories' => $categories
        ];

        return view('admin.webinars.create_eval', $data);
    }
    //create exam
    public function createExam()
    {
        $this->authorize('admin_webinars_create');

        removeContentLocale();

        $teachers = User::where('role_name', Role::$teacher)->get();
        $categories = Category::where('parent_id', null)->get();

        $data = [
            'pageTitle' =>'اضافة اختبار',
            'teachers' => $teachers,
            'categories' => $categories
        ];

        return view('admin.webinars.create_exam', $data);
    }

    public function edit(Request $request, $id)
    {

       $this->authorize('admin_webinars_edit');

        $webinar = Webinar::where('id', $id)
            ->with([
                'tickets',
                'sessions',
                'files',
                'faqs',
                'category' => function ($query) {
                    $query->with(['filters' => function ($query) {
                        $query->with('options');
                    }]);
                },
                'filterOptions',
                'prerequisites',
                'quizzes' => function ($query) {
                    $query->with([
                        'quizQuestions' => function ($query) {
                            $query->orderBy('order', 'asc');
                        }
                    ]);
                },
                'webinarPartnerTeacher' => function ($query) {
                    $query->with(['teacher' => function ($query) {
                        $query->select('id', 'full_name');
                    }]);
                },
                'tags',
                'textLessons',
                'assignments',
                'chapters' => function ($query) {
                    $query->orderBy('order', 'asc');
                    $query->with([
                        'chapterItems' => function ($query) {
                            $query->orderBy('order', 'asc');

                            $query->with([
                                'quiz' => function ($query) {
                                    $query->with([
                                        'quizQuestions' => function ($query) {
                                            $query->orderBy('order', 'asc');
                                        }
                                    ]);
                                }
                            ]);
                        }
                    ]);
                },
            ])
            ->first();

        if (empty($webinar)) {
            abort(404);
        }

        $locale = $request->get('locale', getDefaultLocale());
        storeContentLocale($locale, $webinar->getTable(), $webinar->id);

        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();

        $teacherQuizzes = Quiz::where('webinar_id', null)
            ->where('creator_id', $webinar->teacher_id)
            ->get();

        $tags = $webinar->tags->pluck('title')->toArray();
        // add exam and eval
         if($webinar->type=='exam' || $webinar->type=='eval')
      {
        $quiz = Quiz::query()->where('webinar_id', $webinar->id)
        ->with([
            'quizQuestions' => function ($query) {
                $query->orderBy('order', 'asc');
                $query->with('quizzesQuestionsAnswers');
            },
        ])
        ->first();
if($webinar->type=='eval'){
         $evalcategories = EvalCategory::where('quiz_id', $quiz->id)
            ->get();
        }
    if (empty($quiz)) {
        abort(404);
    }
      }
        $selectedBranchIds = $webinar->branches->pluck('id')->toArray();
      if (empty($selectedBranchIds)) {
        $selectedBranchIds = [session('admin_selected_branch', 1)]; // Default to 1 if session is not set
    }
        $data = [
            'pageTitle' => trans('admin/main.edit') . ' | ' . $webinar->title,
            'categories' => $categories,
            'webinar' => $webinar,
            'webinarCategoryFilters' => !empty($webinar->category) ? $webinar->category->filters : null,
            'webinarFilterOptions' => $webinar->filterOptions->pluck('filter_option_id')->toArray(),
            'tickets' => $webinar->tickets,
            'chapters' => $webinar->chapters,
            'sessions' => $webinar->sessions,
            'files' => $webinar->files,
            'textLessons' => $webinar->textLessons,
            'faqs' => $webinar->faqs,
            'assignments' => $webinar->assignments,
            'teacherQuizzes' => $teacherQuizzes,
            'prerequisites' => $webinar->prerequisites,
            'webinarQuizzes' => $webinar->quizzes,
            'webinarPartnerTeacher' => $webinar->webinarPartnerTeacher,
            'webinarTags' => $tags,
            'quiz'=>$quiz ?? null,
            'evalcategories'=>$evalcategories??null,
            'quizQuestions' => $quiz->quizQuestions ?? "",
            'defaultLocale' => getDefaultLocale(),
            'selectedBranchIds'=>$selectedBranchIds,
        ];

        //for exams
    if($webinar->type=='exam')
      {

       return view('admin.webinars.create_exam',  $data);
     }
      //for eval
    if($webinar->type=='eval')
      {

       return view('admin.webinars.create_eval',  $data);
     }
        return view('admin.webinars.create', $data);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');
        $data = $request->all();
        // return $data;
        $webinar = Webinar::find($id);
        $isDraft = (!empty($data['draft']) and $data['draft'] == 1);
        $reject = (!empty($data['draft']) and $data['draft'] == 'reject');
        $publish = (!empty($data['draft']) and $data['draft'] == 'publish');


        $rules = [
        'type' => 'required|in:webinar,course,text_lesson,exam,eval,offline',

            'title' => 'required|max:255',
            'slug' => 'max:255|unique:webinars,slug,' . $webinar->id,
            'thumbnail' => 'required_unless:type,exam',
           // 'image_cover' => 'required_unless:type,exam',
            'description' => 'required_unless:type,exam',
            'teacher_id' => 'required|exists:users,id',
            'category_id' => 'required',
            'price' => 'nullable|numeric|min:0',
            'discount_rate' => 'nullable|numeric|min:0|max:100',
            'branch_id' => 'required|numeric',
        ];



        if ($webinar->isWebinar()) {
            $rules['start_date'] = 'required|date';
            $rules['duration'] = 'required';
            $rules['capacity'] = 'nullable|numeric|min:0';
        }

        $this->validate($request, $rules);

        if ($webinar->isExam()) {
            $data['description'] = $data['description'] ?? 'No description provided.';
            $data['seo_description']=NULL;
            $data['video_demo']=NULL;
            $data['approval_name']=NULL;
            $data['approval_logo']=NULL;
        }
        if (!empty($data['capacity']) and !empty($data['sales_count_number']) and $data['sales_count_number'] > $data['capacity']) {
            return back()->withErrors([
                'sales_count_number' => [
                    trans('validation.digits_between', [
                        'attribute' => trans('update.sales_count_number'),
                        'min' => 0,
                        'max' => $data['capacity']
                    ])
                ]
            ]);
        }

        if (!empty($data['teacher_id'])) {
            $teacher = User::find($data['teacher_id']);
            $creator = !empty($data['organ_id']) ? User::find($data['organ_id']) : $webinar->creator;

            if (empty($teacher) or ($creator->isOrganization() and ($teacher->organ_id != $creator->id and $teacher->id != $creator->id))) {
                $toastData = [
                    'title' => trans('public.request_failed'),
                    'msg' => trans('admin/main.is_not_the_teacher_of_this_organization'),
                    'status' => 'error'
                ];
                return back()->with(['toast' => $toastData]);
            }
        }


        if (empty($data['slug'])) {
            $data['slug'] = Webinar::makeSlug($data['title']);
        }

        $data['status'] = $publish ? Webinar::$active : ($reject ? Webinar::$inactive : ($isDraft ? Webinar::$isDraft : Webinar::$pending));
        $data['updated_at'] = time();

        if (!empty($data['start_date']) and $webinar->type == 'webinar') {
            if (empty($data['timezone']) or !getFeaturesSettings('timezone_in_create_webinar')) {
                $data['timezone'] = getTimezone();
            }

            $startDate = convertTimeToUTCzone($data['start_date'], $data['timezone']);

            $data['start_date'] = $startDate->getTimestamp();
        } else {
            $data['start_date'] = null;
        }


        $data['support'] = !empty($data['support']) ? true : false;
        $data['certificate'] = !empty($data['certificate']) ? true : false;
        $data['downloadable'] = !empty($data['downloadable']) ? true : false;
        $data['partner_instructor'] = !empty($data['partner_instructor']) ? true : false;
        $data['subscribe'] = !empty($data['subscribe']) ? true : false;
        $data['forum'] = !empty($data['forum']) ? true : false;
        $data['private'] = !empty($data['private']) ? true : false;
        $data['enable_waitlist'] = (!empty($data['enable_waitlist']));

        if (empty($data['partner_instructor'])) {
            WebinarPartnerTeacher::where('webinar_id', $webinar->id)->delete();
            unset($data['partners']);
        }

        if ($data['category_id'] !== $webinar->category_id) {
            WebinarFilterOption::where('webinar_id', $webinar->id)->delete();
        }

        $filters = $request->get('filters', null);
        if (!empty($filters) and is_array($filters)) {
            WebinarFilterOption::where('webinar_id', $webinar->id)->delete();
            foreach ($filters as $filter) {
                WebinarFilterOption::create([
                    'webinar_id' => $webinar->id,
                    'filter_option_id' => $filter
                ]);
            }
        }

        if (!empty($request->get('tags'))) {
            $tags = explode(',', $request->get('tags'));
            Tag::where('webinar_id', $webinar->id)->delete();

            foreach ($tags as $tag) {
                Tag::create([
                    'webinar_id' => $webinar->id,
                    'title' => $tag,
                ]);
            }
        }

        if (!empty($request->get('partner_instructor')) and !empty($request->get('partners'))) {
            WebinarPartnerTeacher::where('webinar_id', $webinar->id)->delete();

            foreach ($request->get('partners') as $partnerId) {
                WebinarPartnerTeacher::create([
                    'webinar_id' => $webinar->id,
                    'teacher_id' => $partnerId,
                ]);
            }
        }

        // Product Badge
        $this->handleProductBadges($webinar, $data);

        unset($data['_token'],
            $data['current_step'],
            $data['draft'],
            $data['get_next'],
            $data['partners'],
            $data['tags'],
            $data['filters'],
            $data['ajax'],
            $data['product_badges']
        );

        $data = $this->handleVideoDemoData($request, $data, "course_demo_" . time());

        $newCreatorId = !empty($data['organ_id']) ? $data['organ_id'] : $data['teacher_id'];
        $changedCreator = ($webinar->creator_id != $newCreatorId);
        $webinar->branches()->sync($data['branch_id']);

        $data['price'] = !empty($data['price']) ? convertPriceToDefaultCurrency($data['price']) : null;
        $data['organization_price'] = !empty($data['organization_price']) ? convertPriceToDefaultCurrency($data['organization_price']) : null;

        if(empty($data['image_cover'])){

            $data['image_cover']= $data['thumbnail'];
        }
        $webinar->update([
            'slug' => $data['slug'],
            'creator_id' => $newCreatorId,
            'teacher_id' => $data['teacher_id'],
            'type' => $data['type'],
            'thumbnail' => $data['thumbnail'],
            'image_cover' => $data['image_cover'] ?? $data['thumbnail'],

            'video_demo' => $data['video_demo'] ?? $webinar->video_demo,
            'approval_logo' => $data['approval_logo'] ?? $webinar->approval_logo,
            'video_demo_source' => isset($data['video_demo']) && $data['video_demo']  ? (isset($data['video_demo_source']) ? $data['video_demo_source'] : null) : null,
            'capacity' => $data['capacity'] ?? null,
            'sales_count_number' => $data['sales_count_number'] ?? null,
            'start_date' => $data['start_date'],
            'timezone' => $data['timezone'] ?? null,
            'duration' => $data['duration'] ?? null,
            'support' => $data['support'],
            'certificate' => $data['certificate'],
            'private' => $data['private'],
            'enable_waitlist' => $data['enable_waitlist'],
            'downloadable' => $data['downloadable'],
            'partner_instructor' => $data['partner_instructor'],
            'subscribe' => $data['subscribe'],
            'forum' => $data['forum'],
            'branch_id' => $data['branch_id'],
            'access_days' => $data['access_days'] ?? null,
            'price' => $data['price'],
             'discount_rate' => $data['discount_rate'] ?? 0,
            'organization_price' => $data['organization_price'] ?? null,
            'category_id' => $data['category_id'],
            'points' => $data['points'] ?? null,
            'message_for_reviewer' => $data['message_for_reviewer'] ?? null,
         'add_to_more' => !empty($data['add_to_more']) ? true : false,

          //  'status' => $data['status'],
            'updated_at' => time(),
        ]);

  // Prepare sections data
    $sections = [];
     if (in_array($data['type'] ?? null, ['text_lesson', 'course','offline']) && !empty($data['section_title'] ?? '')) {
        foreach ($data['section_title'] as $index => $title) {
            $sections[] = [
                'title' => $title,
                'detail' => $data['section_details'][$index] ?? '', // Ensure detail exists
            ];
        }
    }

    // Encode sections data as JSON
    $sectionsJson = json_encode($sections);

    $details = [];
    if(!empty($request->dates)){
    foreach ($request->dates as $key => $date) {
        $details[] = [
            'date' => $date,
            'start_time' => $request->start_time[$key],
            'end_time' => $request->end_time[$key],
            'location' => $request->locations[$key],
            'price' => $request->prices[$key],
            'lang' => $request->langs[$key],
            'ndays' => $request->days[$key],
        ];
    }
    $details = json_encode($details);
    }
        if ($webinar) {
            WebinarTranslation::updateOrCreate([
                'webinar_id' => $webinar->id,
                'locale' => mb_strtolower($data['locale']),
            ], [
                'title' => $data['title'],
                'description' => $data['description'],
                'seo_description' => $data['seo_description'] ?? null,
                  'sections' => $sectionsJson,
                   'details'=> $details,
                   'approval_name' => $data['approval_name'] ??  "",
            ]);

            $webinar->branches()->sync($data['branch_id']);

          // update  exam
            if($webinar->type=='exam')
            {
            $quiz = Quiz::query()->findOrFail( $data['quiz_id']);
            $user = $quiz->creator;
            $quizQuestionsCount = $quiz->quizQuestions->count();
            $id=$data['quiz_id'];
            $quizData = $request->get('ajax')[$id];
            $locale = $data['locale'] ?? getDefaultLocale();



              if($quiz)
            {
            $quiz->update([
                'webinar_id' => !empty($webinar) ? $webinar->id : null,
                'chapter_id' => null,
                'attempt' => $quizData['attempt'] ?? null,
                'pass_mark' => $quizData['pass_mark'],
                'time' => $quizData['time'] ?? null,
                'status' => (!empty($quizData['status']) and $quizData['status'] == 'on') ? Quiz::ACTIVE : Quiz::INACTIVE,
                'certificate' => (!empty($quizData['certificate']) and $quizData['certificate'] == 'on'),
                'display_limited_questions' => (!empty($quizData['display_limited_questions']) and $quizData['display_limited_questions'] == 'on'),
                'display_number_of_questions' => (!empty($quizData['display_limited_questions']) and $quizData['display_limited_questions'] == 'on' and !empty($quizData['display_number_of_questions'])) ? $quizData['display_number_of_questions'] : null,
                'display_questions_randomly' => (!empty($quizData['display_questions_randomly']) and $quizData['display_questions_randomly'] == 'on'),
                'expiry_days' => (!empty($quizData['expiry_days']) and $quizData['expiry_days'] > 0) ? $quizData['expiry_days'] : null,
                'updated_at' => time(),
            ]);
        }

            if (!empty($quiz)) {
                QuizTranslation::updateOrCreate([
                    'quiz_id' => $quiz->id,
                    'locale' => mb_strtolower($locale),
                ], [
                    'title' => $data['title'],
                ]);


            }

            }



        }

        if ($publish) {
//            sendNotification('course_approve', ['[c.title]' => $webinar->title], $webinar->teacher_id);

            $createClassesReward = RewardAccounting::calculateScore(Reward::CREATE_CLASSES);
            RewardAccounting::makeRewardAccounting(
                $webinar->creator_id,
                $createClassesReward,
                Reward::CREATE_CLASSES,
                $webinar->id,
                true
            );

        } elseif ($reject) {
          //  sendNotification('course_reject', ['[c.title]' => $webinar->title], $webinar->teacher_id);
        }

        if ($changedCreator) {
            $this->webinarChangedCreator($webinar);
        }


        removeContentLocale();

        return back();
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('admin_webinars_delete');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->delete();

        return redirect(getAdminPanelUrl() . '/webinars');
    }

    public function approve(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->update([
            'status' => Webinar::$active
        ]);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => trans('update.course_status_changes_to_approved'),
            'status' => 'success'
        ];
        if($webinar->type!=''){

     return redirect(getAdminPanelUrl() . '/webinars?type='.$webinar->type)->with(['toast' => $toastData]);
        }

        return redirect(getAdminPanelUrl() . '/webinars')->with(['toast' => $toastData]);
    }

    public function reject(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->update([
            'status' => Webinar::$inactive
        ]);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => trans('update.course_status_changes_to_rejected'),
            'status' => 'success'
        ];
  if($webinar->type!=''){

     return redirect(getAdminPanelUrl() . '/webinars?type='.$webinar->type)->with(['toast' => $toastData]);
        }
        return redirect(getAdminPanelUrl() . '/webinars')->with(['toast' => $toastData]);
    }

    public function unpublish(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->update([
            'status' => Webinar::$pending
        ]);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => trans('update.course_status_changes_to_unpublished'),
            'status' => 'success'
        ];
  if($webinar->type!=''){

     return redirect(getAdminPanelUrl() . '/webinars?type='.$webinar->type)->with(['toast' => $toastData]);
        }
        return redirect(getAdminPanelUrl() . '/webinars')->with(['toast' => $toastData]);
    }

    public function search(Request $request)
    {
        $term = $request->get('term');

        $option = $request->get('option', null);

        $query = Webinar::select('id')
            ->whereTranslationLike('title', "%$term%");

        if (!empty($option) and $option == 'just_webinar') {
            $query->where('type', Webinar::$webinar);
            $query->where('status', Webinar::$active);
        }

        $webinar = $query->get();

        return response()->json($webinar, 200);
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('admin_webinars_export_excel');

        $query = Webinar::query();

        $query = $this->filterWebinar($query, $request)
            ->with(['teacher' => function ($qu) {
                $qu->select('id', 'full_name');
            }, 'sales']);

        $webinars = $query->get();

        $webinarExport = new WebinarsExport($webinars);

        return Excel::download($webinarExport, 'webinars.xlsx');
    }

    public function studentsLists(Request $request, $id)
    {
        $this->authorize('admin_webinar_students_lists');

        $webinar = Webinar::where('id', $id)
            ->with([
                'teacher' => function ($qu) {
                    $qu->select('id', 'full_name');
                },
                'chapters' => function ($query) {
                    $query->where('status', 'active');
                },
                'sessions' => function ($query) {
                    $query->where('status', 'active');
                },
                'assignments' => function ($query) {
                    $query->where('status', 'active');
                },
                'quizzes' => function ($query) {
                    $query->where('status', 'active');
                },
                'files' => function ($query) {
                    $query->where('status', 'active');
                },
            ])
            ->first();


        if (!empty($webinar)) {
            $giftsIds = Gift::query()->where('webinar_id', $webinar->id)
                ->where('status', 'active')
                ->where(function ($query) {
                    $query->whereNull('date');
                    $query->orWhere('date', '<', time());
                })
                ->whereHas('sale')
                ->pluck('id')
                ->toArray();

            $installmentSalesIds = [];
            $installmentOrders = InstallmentOrder::query()
                ->where('webinar_id', $webinar->id)
                ->where('status', 'open')
                ->get();

            foreach ($installmentOrders as $installmentOrder) {

                $salesId = $installmentOrder->payments->pluck('sale_id')->toArray();
                $installmentSalesIds = array_merge($installmentSalesIds, $salesId);
            }

            $query = User::join('sales', 'sales.buyer_id', 'users.id')
                ->leftJoin('webinar_reviews', function ($query) use ($webinar) {
                    $query->on('webinar_reviews.creator_id', 'users.id')
                        ->where('webinar_reviews.webinar_id', $webinar->id);
                })
                ->select('users.*', 'webinar_reviews.rates', 'sales.access_to_purchased_item', 'sales.id as sale_id', 'sales.gift_id', DB::raw('min(sales.created_at) as purchase_date'))
                ->where(function ($query) use ($webinar, $giftsIds, $installmentSalesIds) {
                    $query->where('sales.webinar_id', $webinar->id);
                    $query->orWhereIn('sales.gift_id', $giftsIds);
                    $query->orWhereIn('sales.id', $installmentSalesIds);
                })
                ->groupBy('sales.buyer_id')
                ->whereNull('sales.refund_at');

            $students = $this->studentsListsFilters($webinar, $query, $request)
                ->orderBy('sales.created_at', 'desc')
                ->paginate(10);

            $userGroups = Group::where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get();

            $totalExpireStudents = 0;
            if (!empty($webinar->access_days)) {
                $accessTimestamp = $webinar->access_days * 24 * 60 * 60;

                $totalExpireStudents = User::join('sales', 'sales.buyer_id', 'users.id')
                    ->select('users.*', DB::raw('sales.created_at as purchase_date'))
                    ->where(function ($query) use ($webinar, $giftsIds) {
                        $query->where('sales.webinar_id', $webinar->id);
                        $query->orWhereIn('sales.gift_id', $giftsIds);
                    })
                    ->whereRaw('sales.created_at + ? < ?', [$accessTimestamp, time()])
                    ->whereNull('sales.refund_at')
                    ->count();
            }

            $webinarStatisticController = new WebinarStatisticController();

            $allStudentsIds = User::join('sales', 'sales.buyer_id', 'users.id')
                ->select('users.*', DB::raw('sales.created_at as purchase_date'))
                ->where(function ($query) use ($webinar, $giftsIds) {
                    $query->where('sales.webinar_id', $webinar->id);
                    $query->orWhereIn('sales.gift_id', $giftsIds);
                })
                ->whereNull('sales.refund_at')
                ->pluck('id')
                ->toArray();

            $learningPercents = [];
            foreach ($allStudentsIds as $studentsId) {
                $learningPercents[$studentsId] = $webinarStatisticController->getCourseProgressForStudent($webinar, $studentsId);
            }

            foreach ($students as $key => $student) {
                if (!empty($student->gift_id)) {
                    $gift = Gift::query()->where('id', $student->gift_id)->first();

                    if (!empty($gift)) {
                        $receipt = $gift->receipt;

                        if (!empty($receipt)) {
                            $receipt->rates = $student->rates;
                            $receipt->access_to_purchased_item = $student->access_to_purchased_item;
                            $receipt->sale_id = $student->sale_id;
                            $receipt->purchase_date = $student->purchase_date;
                            $receipt->learning = $webinarStatisticController->getCourseProgressForStudent($webinar, $receipt->id);

                            $learningPercents[$student->id] = $receipt->learning;

                            $students[$key] = $receipt;
                        } else { /* Gift recipient who has not registered yet */
                            $newUser = new User();
                            $newUser->full_name = $gift->name;
                            $newUser->email = $gift->email;
                            $newUser->rates = 0;
                            $newUser->access_to_purchased_item = $student->access_to_purchased_item;
                            $newUser->sale_id = $student->sale_id;
                            $newUser->purchase_date = $student->purchase_date;
                            $newUser->learning = 0;

                            $students[$key] = $newUser;
                        }
                    }
                } else {
                    $student->learning = !empty($learningPercents[$student->id]) ? $learningPercents[$student->id] : 0;
                }
            }

            $roles = Role::all();

            $data = [
                'pageTitle' => trans('admin/main.students'),
                'webinar' => $webinar,
                'students' => $students,
                'userGroups' => $userGroups,
                'roles' => $roles,
                'totalStudents' => $students->total(),
                'totalActiveStudents' => $students->total() - $totalExpireStudents,
                'totalExpireStudents' => $totalExpireStudents,
                'averageLearning' => count($learningPercents) ? round(array_sum($learningPercents) / count($learningPercents), 2) : 0,
            ];

            return view('admin.webinars.students', $data);
        }

        abort(404);
    }

    private function studentsListsFilters($webinar, $query, $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $full_name = $request->get('full_name');
        $sort = $request->get('sort');
        $group_id = $request->get('group_id');
        $role_id = $request->get('role_id');
        $status = $request->get('status');

        $query = fromAndToDateFilter($from, $to, $query, 'sales.created_at');

        if (!empty($full_name)) {
            $query->where('users.full_name', 'like', "%$full_name%");
        }

        if (!empty($sort)) {
            if ($sort == 'rate_asc') {
                $query->orderBy('webinar_reviews.rates', 'asc');
            }

            if ($sort == 'rate_desc') {
                $query->orderBy('webinar_reviews.rates', 'desc');
            }
        }

        if (!empty($group_id)) {
            $userIds = GroupUser::where('group_id', $group_id)->pluck('user_id')->toArray();

            $query->whereIn('users.id', $userIds);
        }

        if (!empty($role_id)) {
            $query->where('users.role_id', $role_id);
        }

        if (!empty($status)) {
            if ($status == 'expire' and !empty($webinar->access_days)) {
                $accessTimestamp = $webinar->access_days * 24 * 60 * 60;

                $query->whereRaw('sales.created_at + ? < ?', [$accessTimestamp, time()]);
            }
        }

        return $query;
    }

    public function notificationToStudents($id)
    {
        $this->authorize('admin_webinar_notification_to_students');

        $webinar = Webinar::findOrFail($id);

        $data = [
            'pageTitle' => trans('notification.send_notification'),
            'webinar' => $webinar
        ];

        return view('admin.webinars.send-notification-to-course-students', $data);
    }

    public function sendNotificationToStudents(Request $request, $id)
    {
        $this->authorize('admin_webinar_notification_to_students');

        $this->validate($request, [
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        $data = $request->all();

        $webinar = Webinar::where('id', $id)
            ->with([
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                    $query->with([
                        'buyer'
                    ]);
                }
            ])
            ->first();

        if (!empty($webinar)) {
            foreach ($webinar->sales as $sale) {
                if (!empty($sale->buyer)) {
                    $user = $sale->buyer;

                    Notification::create([
                        'user_id' => $user->id,
                        'group_id' => null,
                        'sender_id' => auth()->id(),
                        'title' => $data['title'],
                        'message' => $data['message'],
                        'sender' => Notification::$AdminSender,
                        'type' => 'single',
                        'created_at' => time()
                    ]);

                    if (!empty($user->email) and env('APP_ENV') == 'production') {
                        Mail::to($user->email)->send(new SendNotifications(['title' => $data['title'], 'message' => $data['message']]));
                    }
                }
            }

            $toastData = [
                'title' => trans('public.request_success'),
                'msg' => trans('update.the_notification_was_successfully_sent_to_n_students', ['count' => count($webinar->sales)]),
                'status' => 'success'
            ];

            return redirect(getAdminPanelUrl("/webinars/{$webinar->id}/students"))->with(['toast' => $toastData]);
        }

        abort(404);
    }

    public function orderItems(Request $request)
    {
        $this->authorize('admin_webinars_edit');
        $data = $request->all();

        $validator = Validator::make($data, [
            'items' => 'required',
            'table' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $tableName = $data['table'];
        $itemIds = explode(',', $data['items']);

        if (!is_array($itemIds) and !empty($itemIds)) {
            $itemIds = [$itemIds];
        }

        if (!empty($itemIds) and is_array($itemIds) and count($itemIds)) {
            switch ($tableName) {
                case 'tickets':
                    foreach ($itemIds as $order => $id) {
                        Ticket::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'sessions':
                    foreach ($itemIds as $order => $id) {
                        Session::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'files':
                    foreach ($itemIds as $order => $id) {
                        File::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'text_lessons':
                    foreach ($itemIds as $order => $id) {
                        TextLesson::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'webinar_chapters':
                    foreach ($itemIds as $order => $id) {
                        WebinarChapter::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'webinar_chapter_items':
                    foreach ($itemIds as $order => $id) {
                        WebinarChapterItem::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                case 'bundle_webinars':
                    foreach ($itemIds as $order => $id) {
                        BundleWebinar::where('id', $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
            }
        }

        return response()->json([
            'title' => trans('public.request_success'),
            'msg' => trans('update.items_sorted_successful')
        ]);
    }

    public function getContentItemByLocale(Request $request, $id)
    {
        $this->authorize('admin_webinars_edit');

        $data = $request->all();

        $validator = Validator::make($data, [
            'item_id' => 'required',
            'locale' => 'required',
            'relation' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $webinar = Webinar::where('id', $id)->first();

        if (!empty($webinar)) {

            $itemId = $data['item_id'];
            $locale = $data['locale'];
            $relation = $data['relation'];

            if (!empty($webinar->$relation)) {
                $item = $webinar->$relation->where('id', $itemId)->first();

                if (!empty($item)) {
                    foreach ($item->translatedAttributes as $attribute) {
                        try {
                            $item->$attribute = $item->translate(mb_strtolower($locale))->$attribute;
                        } catch (\Exception $e) {
                            $item->$attribute = null;
                        }
                    }

                    return response()->json([
                        'item' => $item
                    ], 200);
                }
            }
        }

        abort(403);
    }

public function copyCourse($id)
{
    $webinar = Webinar::with([
        'translations',
        'chapters.sessions',
        'chapters.textLessons',
        'chapters.files',
        'chapters.quizzes.quizQuestions.quizzesQuestionsAnswers',
        'quizzes.quizQuestions.quizzesQuestionsAnswers',
        'tickets',
        'tags',
        'assignments',
        'faqs',
        'branches',
    ])->findOrFail($id);

    $datetime = now()->format('Y-m-d H:i');

    // 1. انسخ بيانات الدورة
    $newWebinar = new Webinar();
    $newWebinar->fill([
        'slug' => $webinar->slug . '-' . Str::random(3),
        'creator_id' => $webinar->creator_id,
        'teacher_id' => $webinar->teacher_id,
        'type' => $webinar->type,
        'thumbnail' => $webinar->thumbnail,
        'image_cover' => $webinar->image_cover,
        'video_demo' => $webinar->video_demo,
        'approval_logo' => $webinar->approval_logo,
        'video_demo_source' => $webinar->video_demo_source,
        'capacity' => $webinar->capacity,
        'sales_count_number' => 0,
        'start_date' => $webinar->start_date,
        'timezone' => $webinar->timezone,
        'duration' => $webinar->duration,
        'support' => $webinar->support,
        'certificate' => $webinar->certificate,
        'private' => $webinar->private,
        'enable_waitlist' => $webinar->enable_waitlist,
        'downloadable' => $webinar->downloadable,
        'partner_instructor' => $webinar->partner_instructor,
        'subscribe' => $webinar->subscribe,
        'forum' => $webinar->forum,
        'branch_id' => $webinar->branch_id,
        'access_days' => $webinar->access_days,
        'price' => $webinar->price,
        'discount_rate' => $webinar->discount_rate,
        'organization_price' => $webinar->organization_price,
        'category_id' => $webinar->category_id,
        'points' => $webinar->points,
        'message_for_reviewer' => $webinar->message_for_reviewer,
        'add_to_more' => $webinar->add_to_more,
        'status' => 'is_draft',
        'created_at' => time(),
        'updated_at' => time(),
    ]);
    $newWebinar->save();

    // 2. انسخ الترجمات
    foreach ($webinar->translations as $tr) {
        WebinarTranslation::create([
            'webinar_id' => $newWebinar->id,
            'locale' => $tr->locale,
            'title' => $tr->title . ' (Copy ' . $datetime . ')',
            'description' => $tr->description,
            'seo_description' => $tr->seo_description,
            'sections' => $tr->sections,
            'details' => $tr->details,
            'approval_name' => $tr->approval_name,
        ]);
    }

    // 3. انسخ الفروع
    $branchIds = $webinar->branches()->pluck('branch_id')->toArray();
    $newWebinar->branches()->sync($branchIds);

    // 4. انسخ الشابترز + محتوياتها + items
    foreach ($webinar->chapters as $chapter) {
        $newChapter = $chapter->replicate();
        $newChapter->webinar_id = $newWebinar->id;
        $newChapter->created_at = time();
        $newChapter->save();

        // نجيب الايتمز القديمة بالترتيب
        $oldItems = \DB::table('webinar_chapter_items')
            ->where('chapter_id', $chapter->id)
            ->orderBy('order')
            ->get();

        $sessionMap = [];
        foreach ($chapter->sessions as $session) {
            $newSession = $session->replicate();
            $newSession->chapter_id = $newChapter->id;
            $newSession->webinar_id = $newWebinar->id;
            $newSession->created_at = time();
            $newSession->save();
            $sessionMap[$session->id] = $newSession->id;
        }

        $lessonMap = [];
        foreach ($chapter->textLessons as $lesson) {
            $newLesson = $lesson->replicate();
            $newLesson->chapter_id = $newChapter->id;
            $newLesson->webinar_id = $newWebinar->id;
            $newLesson->created_at = time();
            $newLesson->save();
            $lessonMap[$lesson->id] = $newLesson->id;
        }

        $fileMap = [];
        foreach ($chapter->files as $file) {
            $newFile = $file->replicate();
            $newFile->chapter_id = $newChapter->id;
            $newFile->webinar_id = $newWebinar->id;
            $newFile->created_at = time();
            $newFile->save();
            $fileMap[$file->id] = $newFile->id;
        }

        $quizMap = [];
        foreach ($chapter->quizzes as $quiz) {
            $newQuiz = $quiz->replicate();
            $newQuiz->chapter_id = $newChapter->id;
            $newQuiz->webinar_id = $newWebinar->id;
            $newQuiz->created_at = time();
            $newQuiz->status = Quiz::INACTIVE;
            $newQuiz->save();

            foreach ($quiz->translations as $qt) {
                QuizTranslation::create([
                    'quiz_id' => $newQuiz->id,
                    'locale' => $qt->locale,
                    'title' => $qt->title . ' (Copy ' . $datetime . ')',
                ]);
            }

            foreach ($quiz->quizQuestions as $question) {
                $newQuestion = $question->replicate();
                $newQuestion->quiz_id = $newQuiz->id;
                $newQuestion->created_at = time();
                $newQuestion->save();

                foreach ($question->quizzesQuestionsAnswers as $answer) {
                    $newAnswer = $answer->replicate();
                    $newAnswer->question_id = $newQuestion->id;
                    $newAnswer->created_at = time();
                    $newAnswer->save();
                }
            }

            $quizMap[$quiz->id] = $newQuiz->id;
        }

        // انسخ الايتمز بالترتيب
        foreach ($oldItems as $item) {
            $newItemId = null;

            if ($item->type == 'session' && isset($sessionMap[$item->item_id])) {
                $newItemId = $sessionMap[$item->item_id];
            } elseif ($item->type == 'text_lesson' && isset($lessonMap[$item->item_id])) {
                $newItemId = $lessonMap[$item->item_id];
            } elseif ($item->type == 'file' && isset($fileMap[$item->item_id])) {
                $newItemId = $fileMap[$item->item_id];
            } elseif ($item->type == 'quiz' && isset($quizMap[$item->item_id])) {
                $newItemId = $quizMap[$item->item_id];
            }

            if ($newItemId) {
                \DB::table('webinar_chapter_items')->insert([
                    'user_id'    => $item->user_id,
                    'chapter_id' => $newChapter->id,
                    'item_id'    => $newItemId,
                    'type'       => $item->type,
                    'order'      => $item->order,
                    'created_at' => time(),
                    'branch_id'  => $item->branch_id,
                ]);
            }
        }
    }

    // 5. انسخ الكويزز المرتبطة مباشرة بالكورس
    foreach ($webinar->quizzes as $quiz) {
        $newQuiz = $quiz->replicate();
        $newQuiz->webinar_id = $newWebinar->id;
        $newQuiz->chapter_id = null;
        $newQuiz->created_at = time();
        $newQuiz->status = Quiz::INACTIVE;
        $newQuiz->save();

        foreach ($quiz->translations as $qt) {
            QuizTranslation::create([
                'quiz_id' => $newQuiz->id,
                'locale' => $qt->locale,
                'title' => $qt->title . ' (Copy ' . $datetime . ')',
            ]);
        }

        foreach ($quiz->quizQuestions as $question) {
            $newQuestion = $question->replicate();
            $newQuestion->quiz_id = $newQuiz->id;
            $newQuestion->created_at = time();
            $newQuestion->save();

            foreach ($question->quizzesQuestionsAnswers as $answer) {
                $newAnswer = $answer->replicate();
                $newAnswer->question_id = $newQuestion->id;
                $newAnswer->created_at = time();
                $newAnswer->save();
            }
        }
    }

    // 6. انسخ باقي العلاقات (tickets, tags, assignments, faqs)
    foreach ($webinar->tickets as $ticket) {
        $newTicket = $ticket->replicate();
        $newTicket->webinar_id = $newWebinar->id;
        $newTicket->created_at = time();
        $newTicket->save();
    }

    foreach ($webinar->tags as $tag) {
        $newTag = $tag->replicate();
        $newTag->webinar_id = $newWebinar->id;
        $newTag->created_at = time();
        $newTag->save();
    }

    foreach ($webinar->assignments as $assignment) {
        $newAssignment = $assignment->replicate();
        $newAssignment->webinar_id = $newWebinar->id;
        $newAssignment->created_at = time();
        $newAssignment->save();
    }

    foreach ($webinar->faqs as $faq) {
        $newFaq = $faq->replicate();
        $newFaq->webinar_id = $newWebinar->id;
        $newFaq->created_at = time();
        $newFaq->save();
    }

    return redirect()->back()->with('success', 'تم نسخ الدورة بالكامل بنجاح');
}






}
