@extends(getTemplate().'.layouts.app')

<style>
.question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    font-family: sans-serif;
}
    .quiz-result-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }
    .quiz-summary {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .question-card {
        margin-bottom: 20px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
    }
    .answer-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 5px;
        position: relative;
    }
    .answer-item.selected {
        background-color: #e6f3ff;
        border: 1px solid #007bff;
    }
    .answer-item.correct {
        background-color: #d4edda;
        border: 1px solid #28a745;
    }
    .answer-item.incorrect {
        background-color: #f8d7da;
        border: 1px solid #dc3545;
    }
    .answer-item .feedback {
        margin-left: 10px;
        font-size: 0.8em;
        color: #6c757d;
    }
    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .radio-container {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }
    .radio-container input[type="radio"] {
        margin-right: 10px;
    }
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }
    .page-btn {
        margin: 0 5px;
    }
    .answer-list {
        list-style-type: none;
        padding: 0;
    }
    .answer-list li {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 12px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        background-color: #f8f9fa;
    }
    .answer-list li.correct {
        background-color: #d4edda;
        border-color: #28a745;
    }
    .answer-list li.incorrect {
        background-color: #fff8f8;
        border-color: #fcc0c5;
    }
    .answer-list li .feedback {
        margin-left: 10px;
        font-size: 0.8em;
        color: #4391ff
    }
    span.student_answer{
          color: #fff;
    background: #7420e0;
    font-size: 14px;
    }
    span.badge.badge-success.ml-auto {
    color: #0047ac;
}
label {
    display: inline-block;
    margin:.1rem !important;
}
.font-weight-bold {
    font-weight: 700 !important;
    padding-bottom: .5rem;
}
strong.font-30.font-weight-bold.text-secondary.mt-5 {
    font-family: sans-serif;
}
@media print {
        body * {
            visibility: hidden;
        }
        #printable-questions, #printable-questions * {
            visibility: visible;
        }
        #printable-questions {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>
@section('content')
<div class="container">
        <div class="activities-container shadow-sm rounded-lg mt-25 p-20 p-lg-35">
            <div class="row">
            <div class="text-center mb-4">
                <button id="print-all-questions" class="btn btn-primary">طباعة</button>
            </div>
        
            <div id="printable-questions" style="display: none;">
                <!-- All questions and answers will be inserted here -->
            </div>
        </div>
            <div class="row">
                <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/58.svg" width="64" height="64" alt="">
                        <strong class="font-30 font-weight-bold text-secondary mt-5">{{ $quiz->pass_mark }}/{{ $quiz->time }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('quiz.quiz_time') }} /{{ trans('quiz.pass_mark') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/88.svg" width="64" height="64" alt="">
                        <strong class="font-30 font-weight-bold text-secondary mt-5">{{ $numberOfAttempt }}/{{ $quiz->attempt }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('quiz.attempts') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/45.svg" width="64" height="64" alt="">
                        <strong class="font-30 font-weight-bold text-secondary mt-5">{{ $quizResult->user_grade }}/{{  $questionsSumGrade }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('quiz.your_grade') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/44.svg" width="64" height="64" alt="">
                        <strong class="font-30 font-weight-bold text-{{ ($quizResult->status == 'passed') ? 'primary' : ($quizResult->status == 'waiting' ? 'warning' : 'danger') }} mt-5">
                            {{ trans('quiz.'.$quizResult->status) }}
                        </strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('public.status') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="mt-30 quiz-form">
        <form action="{{ !empty($newQuizStart) ? '/panel/quizzes/'. $newQuizStart->quiz->id .'/update-result' : '' }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="quiz_result_id" value="{{ !empty($newQuizStart) ? $newQuizStart->id : ''}}" class="form-control" placeholder=""/>
            <input type="hidden" name="attempt_number" value="{{  $numberOfAttempt }}" class="form-control" placeholder=""/>
            <input type="hidden" class="js-quiz-question-count" value="{{ $quizQuestions->count() }}"/>

            @php
                $currentPage = request()->get('page', 1); // Get the current page from the request
                $questionsPerPage = 10; // Number of questions per page
                $startIndex = ($currentPage - 1) * $questionsPerPage; // Calculate the starting index for the current page
                $paginatedQuestions = $quizQuestions->slice($startIndex, $questionsPerPage); // Slice the questions for the current page
                $totalQuestions = $quizQuestions->count(); // Total number of questions
                $totalPages = ceil($totalQuestions / $questionsPerPage); // Total number of pages
            @endphp

            @foreach($paginatedQuestions as $index => $question)
            
                <div class="question-card">
                    <div class="question-header">
                        <h4>{{ trans('quiz.question') }} {{ $index + 1 }}</h4>
                        <div>
                            <span>{{ trans('quiz.question_grade') }}: {{ $question->grade }}</span> | 
                            <span>{{ trans('quiz.your_grade') }}: {{ 
                                (!empty($userAnswers[$question->id]) && !empty($userAnswers[$question->id]["status"])) 
                                ? $userAnswers[$question->id]["grade"] 
                                : 0 
                            }}</span>
                        </div>
                    </div>

                    <p class="font-weight-bold">{{ $question->title }}?</p>

                    @if($question->type === \App\Models\QuizzesQuestion::$descriptive)
                        {{-- Descriptive Question Handling --}}
                        <div class="form-group">
                            <label>{{ trans('quiz.student_answer') }}</label>
                            <textarea class="form-control" readonly>
                                {{ 
                                    (!empty($userAnswers[$question->id]) ? $userAnswers[$question->id]['answer'] : '') 
                                }}
                            </textarea>
                        </div>
                        @if(!empty($question->correct))
                            <div class="form-group">
                                <label>{{ trans('quiz.correct_answer') }}</label>
                                <textarea class="form-control" readonly>{{ $question->correct }}</textarea>
                            </div>
                        @endif
                    @else
                        {{-- Multiple Choice Questions --}}
                        <ul class="answer-list">
                            @foreach($question->quizzesQuestionsAnswers as $answer)
                                <li class="{{ 
                                    (!empty($userAnswers[$question->id]) && (int)$userAnswers[$question->id]['answer'] === $answer->id) 
                                    ? 'selected' 
                                    : '' 
                                }} {{ $answer->correct ? 'correct' : 'incorrect' }}">
                                    <div class="radio-container">
                                        <input 
                                            id="answer-{{ $answer->id }}" 
                                            type="radio" 
                                            disabled 
                                            name="question[{{ $question->id }}][answer]" 
                                            value="{{ $answer->id }}"
                                            {{ 
                                                (!empty($userAnswers[$question->id]) && 
                                                (int)$userAnswers[$question->id]['answer'] === $answer->id) 
                                                ? 'checked' 
                                                : '' 
                                            }}
                                        >
                                    </div>

                                    <label for="answer-{{ $answer->id }}" class="flex-grow-1">
                                        {{ $answer->title }}
                                       {{-- @if(!empty($userAnswers[$question->id]) && 
                                            (int)$userAnswers[$question->id]['answer'] === $answer->id)
                                            <span class="badge badge-info ml-2 student_answer">
                                                {{ trans('quiz.student_answer') }}
                                            </span>
                                        @endif--}}

                                        @if(!empty($userAnswers[$question->id]) && 
                                            in_array($answer->id,(array)$userAnswers[$question->id]['answer']))
                                            <span class="badge badge-info ml-2 student_answer">
                                                {{ trans('quiz.student_answer') }}
                                            </span>
                                        @endif

                                        {{-- @if(!empty($answer->feedback))
                                            <span class="feedback">
                                                ({{ $answer->feedback }})
                                            </span>
                                        @endif --}}
                                    </label>

                                    @if($answer->correct)
                                        <span class="badge badge-success ml-auto">
                                            {{ trans('quiz.correct') }}
                                        </span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                          <ul class="answer-feedback">
                            @foreach($question->quizzesQuestionsAnswers as $answer)
                            @if(!empty($answer->feedback))
                            <li style="padding: 1.1rem;background: #fafcff;">
                               
                                    <span class="feedback">
                                        ({{ $answer->feedback }})
                                    </span>
                                
                               
                            </li>
                            @continue
                            @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </form>

        {{-- Pagination --}}
        <div class="pagination-container">
            @if($currentPage > 1)
                <a href="?page={{ $currentPage - 1 }}" class="btn btn-secondary mr-2">
                    {{ trans('quiz.previous') }}
                </a>
            @else
                <button type="button" class="btn btn-secondary mr-2" disabled>
                    {{ trans('quiz.previous') }}
                </button>
            @endif

            @for($i = 1; $i <= $totalPages; $i++)
                <a href="?page={{ $i }}" class="btn btn-outline-secondary page-btn mr-1 {{ $i == $currentPage ? 'active' : '' }}">
                    {{ $i }}
                </a>
            @endfor

            @if($currentPage < $totalPages)
                <a href="?page={{ $currentPage + 1 }}" class="btn btn-secondary ml-2">
                    {{ trans('quiz.next') }}
                </a>
            @else
                <button type="button" class="btn btn-secondary ml-2" disabled>
                    {{ trans('quiz.next') }}
                </button>
            @endif
        </div>
    </section>
</div>
@endsection

@push('scripts_bottom')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Optional: Add subtle animations
        const questionCards = document.querySelectorAll('.question-card');
        questionCards.forEach((card, index) => {
            card.style.opacity = 0;
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease';
                card.style.opacity = 1;
            }, index * 100);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const printButton = document.getElementById('print-all-questions');
        const printableQuestionsDiv = document.getElementById('printable-questions');

        printButton.addEventListener('click', async function() {
            // Clear previous content
            printableQuestionsDiv.innerHTML = '';

            // Collect all questions from the current page
            const currentPageQuestions = document.querySelectorAll('.question-card');
            currentPageQuestions.forEach(question => {
                printableQuestionsDiv.appendChild(question.cloneNode(true));
            });

            // Collect questions from other pages
            const totalPages = {{ $totalPages }};
            const currentPage = {{ $currentPage }};

            for (let page = 1; page <= totalPages; page++) {
                if (page === currentPage) continue; // Skip the current page

                const response = await fetch(`?page=${page}`);
                const text = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(text, 'text/html');

                const questions = doc.querySelectorAll('.question-card');
                questions.forEach(question => {
                    printableQuestionsDiv.appendChild(question.cloneNode(true));
                });
            }

            // Show the printable div and trigger print
            printableQuestionsDiv.style.display = 'block';
            window.print();
            printableQuestionsDiv.style.display = 'none';
        });
    });
</script>

@endpush