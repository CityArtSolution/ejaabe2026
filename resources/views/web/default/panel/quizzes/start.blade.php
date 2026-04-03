@php
    // Force English for branch_id = 3
    if (Auth::check() && Auth::user()->branch_id == 3) {
        App::setLocale('en');
    }
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
            margin-top: 20px;
        }
        .swal2-popup {
        width: 80% !important; /* 80% of the viewport width */
        max-width: 400px; /* Maximum width */
    }

    @media (max-width: 600px) {
        .swal2-popup {
            width: 90% !important; /* Adjust for smaller screens */
        }
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
@endpush
@section('content')
<div class="container">
<section class="mt-40">
<h2 class="font-weight-bold font-16 text-dark-blue">{{ $quiz->title }}</h2>
<p class="text-gray font-14 mt-5">

<!--<br>
@php $print_url="/panel/quizzes/$quiz->id/printquizzes";@endphp
<a href="{{ url($print_url)}}" target="_blank" class="text-gray">طباعة</a>-->

<!--| {{ trans('public.by') }}
<span class="font-weight-bold">
<a href="{{ $quiz->creator->getProfileUrl() }}" target="_blank" class="font-14"> {{ $quiz->creator->full_name }}</a>
</span>-->
</p>

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
                        <strong class="font-30 font-weight-bold text-secondary mt-5">{{  $quiz->pass_mark }}/{{  $quizQuestions->sum('grade') }}</strong>
                        <span class="font-16 text-gray">{{ trans('public.grade_min') }} </span>
                    </div>
                </div>

                <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/88.svg" width="64" height="64" alt="">
                        <strong class="font-30 font-weight-bold text-secondary mt-5">{{ $attempt_count }}/{{ $quiz->attempt }}</strong>
                        <span class="font-16 text-gray">{{ trans('quiz.attempts') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/47.svg" width="64" height="64" alt="">
                        <strong class="font-30 font-weight-bold text-secondary mt-5">{{ $totalQuestionsCount }}</strong>
                        <span class="font-16 text-gray">{{ trans('public.questions') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/clock.svg" width="64" height="64" alt="">
                        @if(!empty($quiz->time))
                            <strong class="font-30 font-weight-bold text-secondary mt-5">
                                <div class="d-flex align-items-center timer ltr" data-minutes-left="{{ $quiz->time }}"></div>
                            </strong>
                        @else
                            <strong class="font-30 font-weight-bold text-secondary mt-5">{{ trans('quiz.unlimited') }}</strong>
                        @endif
                        <span class="font-16 text-gray">{{ trans('quiz.remaining_time') }}</span>
                    </div>
                </div>


            </div>
        </div>
    </section>


                            <section class="mt-30 quiz-form">
                            <form action="/panel/quizzes/{{ $quiz->id }}/store-result" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="quiz_result_id" value="{{ $newQuizStart->id }}" />
                                <input type="hidden" name="attempt_number" value="{{ $attempt_count }}" />
                
                                @php
                                 $currentPage = request()->get('page', 1); // Get the current page from the request
                                    $questionsPerPage = 10;
                                    $totalQuestions = $quizQuestions->count();
                                    $totalPages = ceil($totalQuestions / $questionsPerPage);
                                @endphp
                
                                @foreach(range(0, $totalPages - 1) as $pageIndex)
                                    <div class="question-container {{ $pageIndex === 0 ? 'active' : '' }}" data-page="{{ $pageIndex }}">
                                        @php
                                            $startIndex = $pageIndex * $questionsPerPage;
                                            $pageQuestions = $quizQuestions->slice($startIndex, $questionsPerPage);
                                        @endphp
                
                                        @foreach($pageQuestions as $key => $question)
                                            <div class="question-card quiz-question-wrapper mb-4">
                                                <div class="rounded-lg shadow-sm py-25 px-20">
                                                    <div class="quiz-card">
                                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                                            <p class="text-gray font-15">
                                                                <span>{{ trans('quiz.question') }}: {{ $key+1 }}</span>

                                                            </p>

                                                            <div class="text-gray font-15">
                                                                <span>{{ trans('quiz.question_grade') }}: {{ $question->grade }}</span>

                                                            </div>
                                                            <div class="rounded-sm border border-gray200 p-15 font-14">
                                                                {{  $key + 1 }}/{{ $totalQuestions }}
                                                            </div>
                                                        </div>
                
                                                        <!-- Question Media -->
                                                        @if(!empty($question->image) || !empty($question->video))
                                                            <div class="quiz-question-media-card rounded-lg mt-10 mb-15">
                                                                @if(!empty($question->image))
                                                                    <img src="{{ $question->image }}" class="img-fluid rounded-lg" alt="Question Image">
                                                                @else
                                                                    <video class="video-js" controls preload="auto" width="100%">
                                                                        <source src="{{ $question->video }}" type="video/mp4"/>
                                                                    </video>
                                                                @endif
                                                            </div>
                                                        @endif
                
                                                        <!-- Question Title -->
                                                        <h3 class="font-weight-bold font-16 text-secondary mb-3">
                                                            {{ $question->title }}
                                                        </h3>
                
                                                        <!-- Question Answers -->
                                                        <div class="question-answers">
                                                            @if($question->type === \App\Models\QuizzesQuestion::$descriptive)
                                                                <textarea 
                                                                    name="question[{{ $question->id }}][answer]" 
                                                                    class="form-control" 
                                                                    rows="5" 
                                                                    placeholder="{{ trans('quiz.your_answer_here') }}"
                                                                ></textarea>
                                                            @else
                                                                <div class="answer-options">
                                                                    @php
                                                                    // Count the number of correct answers for this question
                                                                    $correctAnswersCount = $question->quizzesQuestionsAnswers->where('correct', 1)->count();
                                                                @endphp
                                                                
                                                                @foreach($question->quizzesQuestionsAnswers as $answer)
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
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                
                                <!-- Pagination Controls -->
                                <div class="d-flex align-items-center mt-30">

                                <div class="pagination-container">
                                    <button type="button" id="prevPage" class="btn btn-secondary mr-2">
                                        {{ trans('quiz.previous') }}
                                    </button>
                                    
                                   @foreach(range(0, $totalPages - 1) as $pageNum)
                                        <button 
                                            type="button" 
                                            class="btn btn-outline-secondary page-btn mr-1 {{ $pageNum === 0 ? 'active' : '' }}"
                                            data-page="{{ $pageNum }}"
                                        >
                                            {{ $pageNum + 1 }}
                                        </button>
                                    @endforeach
                                    
                                        <button type="button" id="nextPage" class="btn btn-secondary ml-2">
                                            {{ trans('quiz.next') }}
                                        </button>
                                    </div>
                    
                                    <!-- Submit Button -->
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
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                   


                       document.addEventListener('DOMContentLoaded', function() {
    const questionContainers = document.querySelectorAll('.question-container');
    const pageButtons = document.querySelectorAll('.page-btn');
    const prevButton = document.getElementById('prevPage');
    const nextButton = document.getElementById('nextPage');
    let currentPage = 0;
    const totalPages = {{ $totalPages }};

    // Timer functionality
    const timerDiv = document.querySelector('.timer');
    const quizForm = document.querySelector('.quiz-form form');
    
    if (timerDiv) {
        const quizId = '{{ $quiz->id }}'; // Get quiz ID for unique storage
        const minutes = parseInt(timerDiv.getAttribute('data-minutes-left'));
        
        // Get stored time or set initial time
        let totalSeconds;
        const storedTime = localStorage.getItem(`quiz_${quizId}_time`);
        const startTime = localStorage.getItem(`quiz_${quizId}_start_time`);
        
        // ===== ONLY CHANGE: Moved timerInterval declaration here =====
        let timerInterval;
        
        if (storedTime && startTime) {
            // Calculate remaining time considering page reloads
            const elapsedSeconds = Math.floor((Date.now() - parseInt(startTime)) / 1000);
            totalSeconds = Math.max(0, parseInt(storedTime) - elapsedSeconds);
        } else {
            // Initial setup
            totalSeconds = minutes * 60;
            localStorage.setItem(`quiz_${quizId}_time`, totalSeconds);
            localStorage.setItem(`quiz_${quizId}_start_time`, Date.now());
        }
        
        const updateTimer = () => {
            if (totalSeconds <= 0) {
                clearInterval(timerInterval);
                localStorage.removeItem(`quiz_${quizId}_time`);
                localStorage.removeItem(`quiz_${quizId}_start_time`);
                
                // Remove required attributes from all form inputs
                const allInputs = quizForm.querySelectorAll('input, textarea');
                allInputs.forEach(input => {
                    input.removeAttribute('required');
                });

                // Show alert and submit form
                Swal.fire({
                    title: 'ملاحظة',
                    text: 'انتهى وقت الاختبار! سيتم تقديم إجاباتك تلقائياً.',
                    icon: 'error',
                    confirmButtonText: 'موافق',
                    timer: 3000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didClose: () => {
                        quizForm.submit();
                        return;
                    }
                });
            }
            
            const minutesLeft = Math.floor(totalSeconds / 60);
            const secondsLeft = totalSeconds % 60;
            
            timerDiv.innerHTML = `${minutesLeft}:${secondsLeft < 10 ? '0' : ''}${secondsLeft}`;
            
            totalSeconds--;
            localStorage.setItem(`quiz_${quizId}_time`, totalSeconds);
        };

        updateTimer();
        timerInterval = setInterval(updateTimer, 1000);

        // Clear timer storage if form is submitted normally
        quizForm.addEventListener('submit', function() {
            localStorage.removeItem(`quiz_${quizId}_time`);
            localStorage.removeItem(`quiz_${quizId}_start_time`);
        });
    }

    // Form validation
    quizForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const allQuestions = document.querySelectorAll('.quiz-question-wrapper');
        let allAnswered = true;
        let unansweredQuestions = [];

        allQuestions.forEach((questionDiv, index) => {
            const questionNumber = index + 1;
            const descriptiveAnswer = questionDiv.querySelector('textarea');
            const radioAnswers = questionDiv.querySelectorAll('input[type="radio"]');
            const checkboxAnswers = questionDiv.querySelectorAll('input[type="checkbox"]');
            
            let isAnswered = false;
            
            if (descriptiveAnswer) {
                isAnswered = descriptiveAnswer.value.trim() !== '';
            } else if (radioAnswers.length > 0) {
                isAnswered = Array.from(radioAnswers).some(radio => radio.checked);
            } else if (checkboxAnswers.length > 0) {
                isAnswered = Array.from(checkboxAnswers).some(checkbox => checkbox.checked);
            }
            
            if (!isAnswered) {
                allAnswered = false;
                unansweredQuestions.push(questionNumber);
            }
        });

        if (!allAnswered) {
            const message = `يجب الاجابة على جميع الاسئلة. \الاسئلة التي  لم تجب عليها: ${unansweredQuestions.join(', ')}`;

            Swal.fire({
                title: 'ملاحظة',
                text: message,
                icon: 'error',
                confirmButtonText: 'موافق'
            });

            return false;
        }

        this.submit();
    });


    function scrollToQuizSection() {
        // Find the quiz section or the first question container
        const quizSection = document.querySelector('.quiz-form') || document.querySelector('.question-container');
        if (quizSection) {
            // Scroll with smooth behavior
            quizSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function showPage(pageIndex) {
        // Hide all containers
        questionContainers.forEach(container => {
            container.classList.remove('active');
        });

        // Show selected page
        questionContainers[pageIndex].classList.add('active');

        // Update page button styles
        pageButtons.forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-secondary');
        });
        pageButtons[pageIndex].classList.remove('btn-outline-secondary');
        pageButtons[pageIndex].classList.add('btn-primary');

        // Update navigation buttons
        prevButton.disabled = (pageIndex === 0);
        nextButton.disabled = (pageIndex === totalPages - 1);

        currentPage = pageIndex;

        // Scroll to the top of the quiz section
        scrollToQuizSection();
    }

    // Page button click events
    pageButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const pageToShow = parseInt(this.dataset.page);
            showPage(pageToShow);
        });
    });

    // Previous page button
    prevButton.addEventListener('click', function() {
        if (currentPage > 0) {
            showPage(currentPage - 1);
        }
    });

    // Next page button
    nextButton.addEventListener('click', function() {
        if (currentPage < totalPages - 1) {
            showPage(currentPage + 1);
        }
    });

    // Initial setup
    showPage(0);
    
                        });
                    </script>
                    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const printButton = document.getElementById('print-all-questions');
        
        const printableQuestionsDiv = document.getElementById('printable-questions');

        printButton.addEventListener('click', async function() {
            printButton.innerHTML=" جارى تحميل الطباعة";
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
            printButton.innerHTML="طباعة";
            printableQuestionsDiv.style.display = 'none';
        });
    });
</script>
                @endpush