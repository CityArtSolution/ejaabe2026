
@php  $generalSettings = getGeneralSettings();
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
    background-color: #0e3274;
    color: #fff;
    padding: 3px 6px;
    color: #fff;
    border-radius: 5px;
    width: 335px;
}
    </style>
@endpush
@section('content')
<div class="container">
<section class="mt-40">
  <div class="quiz-question-wrapper mb-4">
   <div class="rounded-lg shadow-sm py-25 px-20">
    <div class="quiz-card">
         <h2 class="font-weight-bold font-22 text-dark-blue text-center">    {{ $pageTitle  }}     </h2>
    </div>
   </div>
</div>
<p class="text-gray font-14 mt-5">

<!--| {{ trans('public.by') }}
<span class="font-weight-bold">
<a href="{{ $quiz->creator->getProfileUrl() }}" target="_blank" class="font-14"> {{ $quiz->creator->full_name }}</a>
</span>-->
</p>

        
    </section>


                            <section class="mt-30 quiz-form">
                            <form action="/evaluation/{{ $quiz->id }}/store-result" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="quiz_result_id" value="{{ $newQuizStart->id }}" />
                                <input type="hidden" name="attempt_number" value="{{ $attempt_count }}" />
                                 <!--<div class="quiz-question-wrapper mb-4">-->
                                 <!--  <div class="rounded-lg shadow-sm py-25 px-20">-->
                                    <!--<div class="quiz-card">-->
                            <!--<fieldset>-->
                            <!--    <legend>المعلومات الشخصية</legend>-->
                            <!--        <div class="row">-->
                            <!--            <div class="col-md-4">-->
                            <!--                <div class="form-group">-->
                            <!--                    <label class="input-label" for="code">  الاسم كامل:</label>-->
                            <!--                    <input type="text" name="full_name" class="form-control " value="" fdprocessedid="7g2tc">-->
                            <!--                 </div>-->
                            <!--             </div>-->
                                    <!--     <div class="col-md-4">-->
                                    <!--        <div class="form-group">-->
                                    <!--            <label class="input-label" for="code">  الهاتف  :</label>-->
                                    <!--            <input type="number" name="phone" class="form-control " value="" fdprocessedid="7g2tc">-->
                                    <!--         </div>-->
                                    <!--     </div>-->
                                        
                                    <!--     <div class="col-md-4">-->
                                    <!--        <div class="form-group">-->
                                    <!--            <label class="input-label" for="code">  البريد الالكتروني  :</label>-->
                                    <!--            <input type="text" name="email" class="form-control " value="" fdprocessedid="7g2tc">-->
                                    <!--         </div>-->
                                    <!--     </div>-->
                                         
                                    <!--     </div>-->
                                    <!-- <div class="row">-->
                                    <!--    <div class="col-md-12">-->
                                    <!--        <div class="form-group">-->
                                    <!--            <label class="input-label" for="code">   ملاحظات  :</label>-->
                                    <!--            <textarea  name="notes" style="height:100px" class="form-control " ></textarea>-->
                                    <!--         </div>-->
                                    <!--     </div>-->
                                         
                                    <!--</div>-->
                            
                    
                         
                            
                  <!--</fieldset>-->
                  <!--</div>-->
                  <!--</div>-->
                  <!--</div>-->
            <br>
                                @php
                                    $questionsPerPage = 10;
                                    $totalQuestions = $quizQuestions->count();
                                    $totalPages = ceil($totalQuestions / $questionsPerPage);
                                @endphp
                
                                @foreach(range(0, $totalPages - 1) as $pageIndex)
                                    <div class="question-container {{ $pageIndex === 0 ? 'active' : '' }}" data-page="{{ $pageIndex }}">
                                        @php
                                            $startIndex = $pageIndex * $questionsPerPage;
                                            $pageCatQuestions = $quizQuestions->slice($startIndex, $questionsPerPage);
                                        @endphp
                
                                        @foreach($pageCatQuestions as $key => $Cats)
                                            <div class="quiz-question-wrapper mb-4">
                                                <div class="rounded-lg shadow-sm py-25 px-20">
                                                    <div class="quiz-card">
                                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                                            <!--<p class="text-gray font-15">-->
                                                            <!--    <span>التقييم : {{ $key+1 }}</span>-->

                                                            <!--</p>-->

                                                          
                                                            <div class="rounded-sm border border-gray200 p-15 font-14">
                                                                {{  $key + 1 }}/{{ $totalQuestions }}
                                                            </div>
                                                        </div>
                                                      
                                                    <fieldset>
                                                        <!-- Cat Title -->
    <legend><span class="legend-flex">{{ $Cats->title }}</span></legend>
                                                       <style>
    legend {
        padding: 0;
        border: none;
    }

    .legend-flex {
        display: inline-block;
        white-space: nowrap;
        background-color: #0e3274; /* or your preferred color */
        padding: 6px 12px;
        border-radius: 5px;
        font-weight: bold;
  color: #fff;
  }
</style>


                                                    @foreach($Cats->QuestionsCategories as $keyq => $question)
                                                        <!-- Question Title -->
                                                        <h3 class="font-weight-bold font-16 text-secondary mb-3">
                                                          <span class="en_nuber"> {{$keyq+1}}</span> / {{ $question->title }}
                                                        </h3>
                
                                                        <!-- Question Answers -->
                                                       <!-- Question Answers -->
<div class="question-answers">
    @php
        $correctAnswersCount = $question->quizzesQuestionsAnswers->where('correct', 1)->count();
    @endphp

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

                                                       
                                                       @if($keyq+1 < $Cats->QuestionsCategories->count())
                                                        <hr>
                                                        @endif
                                                         @endforeach
                                                         </fieldset>
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