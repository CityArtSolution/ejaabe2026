@extends(getTemplate().'.layouts.app-print')

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
    </style>
@endpush
@section('content')
<div class="container">
<section class="mt-40">
<h2 class="font-weight-bold font-16 text-dark-blue">{{ $quiz->title }}</h2>
<p class="text-gray font-14 mt-5">
<a href="{{ $quiz->webinar->getUrl() }}" target="_blank" class="text-gray">{{ $quiz->webinar->title }}</a>

<!--| {{ trans('public.by') }}
<span class="font-weight-bold">
<a href="{{ $quiz->creator->getProfileUrl() }}" target="_blank" class="font-14"> {{ $quiz->creator->full_name }}</a>
</span>-->
</p>

       
    </section>


                            <section class="mt-30 quiz-form">
                            <form action="/panel/quizzes/{{ $quiz->id }}/store-result" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="quiz_result_id" value="{{ $newQuizStart->id }}" />
                                <input type="hidden" name="attempt_number" value="{{ $attempt_count }}" />
                
                                @php
                                    $questionsPerPage = $quizQuestions->count();
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
                                            <div class="quiz-question-wrapper mb-4">
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
                    <script>
                   


                        document.addEventListener('DOMContentLoaded', function() {
                            const questionContainers = document.querySelectorAll('.question-container');
                            const pageButtons = document.querySelectorAll('.page-btn');
                            const prevButton = document.getElementById('prevPage');
                            const nextButton = document.getElementById('nextPage');
                            let currentPage = 0;
                            const totalPages = {{ $totalPages }};
                
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
                @endpush