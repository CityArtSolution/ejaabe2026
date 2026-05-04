@php
    $generalSettings = getGeneralSettings();
    view()->share('categories', \App\Models\MainCategory::getCategories());
    view()->share('navbarPages', getNavbarLinks());
    view()->share('footerPage2', \App\Models\Page::getFooterPages2());
    view()->share('footerPage3', \App\Models\Page::getFooterPages3());
@endphp

@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
    <style>
        .question-container {
            display: none;
        }
        .question-container.active {
            display: block;
        }
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        fieldset {
            display: block;
            min-inline-size: min-content;
            margin-inline: 2px;
            border-width: 2px;
            border-style: groove;
            border-color: threedface;
            border-image: initial;
            padding-block: 0.35em 0.625em;
            padding-inline: 0.75em;
        }
        legend {
            padding: 0;
            border: none;
        }
        .legend-flex {
            display: inline-block;
            white-space: nowrap;
            background-color: #0e3274;
            padding: 6px 12px;
            border-radius: 5px;
            font-weight: bold;
            color: #fff;
        }
        .question-counter-badge {
            background: #f0f4ff;
            border: 1px solid #d0d9f0;
            border-radius: 6px;
            padding: 6px 14px;
            font-size: 14px;
            font-weight: 600;
            color: #0e3274;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <section class="mt-40">
            <div class="quiz-question-wrapper mb-4">
                <div class="rounded-lg shadow-sm py-25 px-20">
                    <div class="quiz-card">
                        <h2 class="font-weight-bold font-22 text-dark-blue text-center">{{ $pageTitle }}</h2>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-30 quiz-form">
            <form action="/evaluation/{{ $quiz->id }}/store-result" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="quiz_result_id" value="{{ $newQuizStart->id }}" />
                <input type="hidden" name="attempt_number" value="{{ $attempt_count }}" />

                @php
                    /*
                     * FIX: Flatten all questions from all categories into a single
                     * ordered collection, preserving which category each belongs to.
                     * This prevents:
                     *   1. Repeated questions (caused by paginating categories not questions)
                     *   2. Wrong total counts
                     *   3. Counter resetting on each page
                     */
                    $flatQuestions = collect();

                    foreach ($quizQuestions as $cat) {
                        foreach ($cat->QuestionsCategories as $question) {
                            $flatQuestions->push([
                                'category'  => $cat,
                                'question'  => $question,
                            ]);
                        }
                    }

                    $questionsPerPage = 10;
                    $totalQuestions   = $flatQuestions->count();
                    $totalPages       = max(1, (int) ceil($totalQuestions / $questionsPerPage));
                @endphp

                <br>

                @foreach(range(0, $totalPages - 1) as $pageIndex)
                    @php
                        $startIndex    = $pageIndex * $questionsPerPage;
                        $pageQuestions = $flatQuestions->slice($startIndex, $questionsPerPage)->values();

                        // Track the last category rendered on this page so we can
                        // open/close <fieldset> blocks correctly without repeating headers.
                        $lastCatId = null;
                        $isFirstCatOnPage = true;
                    @endphp

                    <div class="question-container {{ $pageIndex === 0 ? 'active' : '' }}" data-page="{{ $pageIndex }}">

                        @foreach($pageQuestions as $itemIndex => $item)
                            @php
                                $cat      = $item['category'];
                                $question = $item['question'];

                                // Global 1-based question number across all pages
                                $globalNumber = $startIndex + $itemIndex + 1;

                                $catChanged = ($cat->id !== $lastCatId);
                            @endphp

                            {{-- Close previous fieldset when category changes (not on first item) --}}
                            @if($catChanged && !$isFirstCatOnPage)
                                </fieldset>
                    </div>{{-- .quiz-card --}}
    </div>{{-- .rounded-lg --}}
    </div>{{-- .quiz-question-wrapper --}}
    @endif

    {{-- Open new card + fieldset when category changes --}}
    @if($catChanged)
        <div class="quiz-question-wrapper mb-4">
            <div class="rounded-lg shadow-sm py-25 px-20">
                <div class="quiz-card">
                    <fieldset>
                        <legend>
                            <span class="legend-flex">{{ $cat->title }}</span>
                        </legend>
                        @php
                            $lastCatId        = $cat->id;
                            $isFirstCatOnPage = false;
                        @endphp
                        @endif

                        {{-- Question --}}
                        <div class="d-flex align-items-center justify-content-between mb-3 mt-3">
                            <span class="question-counter-badge">
                                {{ $globalNumber }} / {{ $totalQuestions }}
                            </span>
                        </div>

                        <h3 class="font-weight-bold font-16 text-secondary mb-3">
                            <span class="en_nuber">{{ $itemIndex + 1 }}</span> / {{ $question->title }}
                        </h3>

                        @php
                            $correctAnswersCount = $question->quizzesQuestionsAnswers->where('correct', 1)->count();
                        @endphp

                        <div class="question-answers">
                            @if($question->type === 'multiple')
                                <div class="answer-options">
                                    <div class="row">
                                        @foreach($question->quizzesQuestionsAnswers as $answer)
                                            <div class="col-md-2">
                                                <div class="form-check mb-2">
                                                    <input
                                                        class="form-check-input"
                                                        type="{{ $correctAnswersCount > 1 ? 'checkbox' : 'radio' }}"
                                                        name="question[{{ $question->id }}][answer]{{ $correctAnswersCount > 1 ? '[]' : '' }}"
                                                        id="answer_{{ $answer->id }}"
                                                        value="{{ $answer->id }}"
                                                    >
                                                    <label class="form-check-label" for="answer_{{ $answer->id }}">
                                                        {{ $answer->title }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            @elseif($question->type === 'descriptive')
                                <div class="form-group">
                                    <textarea
                                        class="form-control"
                                        name="question[{{ $question->id }}][written_answer]"
                                        rows="4"
                                        placeholder="اكتب إجابتك هنا..."
                                    ></textarea>
                                </div>
                            @endif
                        </div>

                        {{-- Divider between questions inside the same category --}}
                        @if(!$loop->last)
                            @php
                                $nextItem = $pageQuestions[$itemIndex + 1] ?? null;
                                $nextCatId = $nextItem ? $nextItem['category']->id : null;
                            @endphp
                            @if($nextCatId === $cat->id)
                                <hr>
                            @endif
                        @endif

                        @endforeach

                        {{-- Close the last open fieldset on this page --}}
                        @if(!$isFirstCatOnPage)
                    </fieldset>
                </div>{{-- .quiz-card --}}
            </div>{{-- .rounded-lg --}}
        </div>{{-- .quiz-question-wrapper --}}
        @endif

        </div>{{-- .question-container --}}
        @endforeach

        {{-- Pagination Controls --}}
        <div class="d-flex align-items-center justify-content-between mt-30 flex-wrap gap-3">

            <div class="pagination-container">
                <button type="button" id="prevPage" class="btn btn-secondary mr-2">
                    {{ trans('quiz.previous') }}
                </button>

                @foreach(range(0, $totalPages - 1) as $pageNum)
                    <button
                        type="button"
                        class="btn btn-outline-secondary page-btn {{ $pageNum === 0 ? 'active btn-primary' : '' }}"
                        data-page="{{ $pageNum }}"
                    >
                        {{ $pageNum + 1 }}
                    </button>
                @endforeach

                <button type="button" id="nextPage" class="btn btn-secondary ml-2">
                    {{ trans('quiz.next') }}
                </button>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="finish btn btn-lg btn-danger">
                    {{ trans('public.finish') }}
                </button>
            </div>

        </div>

        </form>
        </section>
        </div>
        @endsection

        @push('scripts_bottom')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const questionContainers = document.querySelectorAll('.question-container');
                    const pageButtons        = document.querySelectorAll('.page-btn');
                    const prevButton         = document.getElementById('prevPage');
                    const nextButton         = document.getElementById('nextPage');
                    const totalPages         = {{ $totalPages }};
                    let currentPage          = 0;

                    function showPage(pageIndex) {
                        // Bounds check
                        if (pageIndex < 0 || pageIndex >= totalPages) return;

                        // Hide all pages
                        questionContainers.forEach(c => c.classList.remove('active'));

                        // Show the target page
                        questionContainers[pageIndex].classList.add('active');

                        // Update page-number buttons
                        pageButtons.forEach(btn => {
                            btn.classList.remove('active', 'btn-primary');
                            btn.classList.add('btn-outline-secondary');
                        });
                        pageButtons[pageIndex].classList.remove('btn-outline-secondary');
                        pageButtons[pageIndex].classList.add('active', 'btn-primary');

                        // Enable / disable Prev & Next
                        prevButton.disabled = (pageIndex === 0);
                        nextButton.disabled = (pageIndex === totalPages - 1);

                        currentPage = pageIndex;

                        // Scroll to top of form
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }

                    // Page-number button clicks
                    pageButtons.forEach(btn => {
                        btn.addEventListener('click', function () {
                            showPage(parseInt(this.dataset.page, 10));
                        });
                    });

                    prevButton.addEventListener('click', () => showPage(currentPage - 1));
                    nextButton.addEventListener('click', () => showPage(currentPage + 1));

                    // Init
                    showPage(0);
                });
            </script>
        @endpush
