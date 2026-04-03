<div class="row mt-10">
    <div class="col-12">
        <div class="accordion-content-wrapper mt-15" id="chapterAccordion" role="tablist" aria-multiselectable="true">
            @if(!empty($webinar->chapters) and count($webinar->chapters))
                <ul class="draggable-content-lists draggable-lists-chapter" data-drag-class="draggable-lists-chapter" data-order-table="webinar_chapters">
                    @foreach($webinar->chapters as $chapter)

                        <li data-id="{{ !empty($chapter) ? $chapter->id :'' }}" data-chapter-order="{{ $chapter->order }}" class="accordion-row bg-white rounded-sm mt-20 py-15 py-lg-30 px-10 px-lg-20">
                            <div class="d-flex align-items-center justify-content-between " role="tab" id="chapter_{{ !empty($chapter) ? $chapter->id :'record' }}">
                                <div class="d-flex align-items-center" href="#collapseChapter{{ !empty($chapter) ? $chapter->id :'record' }}" aria-controls="collapseChapter{{ !empty($chapter) ? $chapter->id :'record' }}" data-parent="#chapterAccordion" role="button" data-toggle="collapse" aria-expanded="true">
                                    <span class="chapter-icon mr-10">
                                        <i data-feather="grid" class=""></i>
                                    </span>
                                    <div class="">
                                        <span class="font-weight-bold text-dark-blue d-block cursor-pointer">{{ !empty($chapter) ? $chapter->title : trans('public.add_new_chapter') }}</span>
                                        <span class="font-12 text-gray d-block">
                                            {{ !empty($chapter->chapterItems) ? count($chapter->chapterItems) : 0 }} {{ trans('public.topic') }}
                                            | {{ convertMinutesToHourAndMinute($chapter->getDuration()) }} {{ trans('public.hr') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center">

                                    @if($chapter->status != \App\Models\WebinarChapter::$chapterActive)
                                        <span class="disabled-content-badge mr-10">{{ trans('public.disabled') }}</span>
                                    @endif

                                    <div class="btn-group dropdown table-actions">
                                        <button type="button" class="add-course-content-btn mr-10 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i data-feather="plus" class=""></i>
                                        </button>
                                        <div class="dropdown-menu ">
                                            @if($webinar->isWebinar())
                                                <button type="button" class="js-add-course-content-btn d-block mb-10 btn-transparent" data-webinar-id="{{ $webinar->id }}" data-type="session" data-chapter="{{ !empty($chapter) ? $chapter->id :'' }}">
                                                    {{ trans('public.add_session') }}
                                                </button>
                                            @endif

                                            <button type="button" class="js-add-course-content-btn d-block mb-10 btn-transparent" data-webinar-id="{{ $webinar->id }}" data-type="file" data-chapter="{{ !empty($chapter) ? $chapter->id :'' }}">
                                                {{ trans('public.add_file') }}
                                            </button>

                                            @if(getFeaturesSettings('new_interactive_file'))
                                                <button type="button" class="js-add-course-content-btn d-block mb-10 btn-transparent" data-webinar-id="{{ $webinar->id }}" data-type="new_interactive_file" data-chapter="{{ !empty($chapter) ? $chapter->id :'' }}">
                                                    {{ trans('update.new_interactive_file') }}
                                                </button>
                                            @endif


                                            <button type="button" class="js-add-course-content-btn d-block mb-10 btn-transparent" data-webinar-id="{{ $webinar->id }}" data-type="text_lesson" data-chapter="{{ !empty($chapter) ? $chapter->id :'' }}">
                                                {{ trans('public.add_text_lesson') }}
                                            </button>

                                            <button type="button" class="js-add-course-content-btn d-block mb-10 btn-transparent" data-webinar-id="{{ $webinar->id }}" data-type="quiz" data-chapter="{{ !empty($chapter) ? $chapter->id :'' }}">
                                                {{ trans('public.add_quiz') }}
                                            </button>

                                            @if(getFeaturesSettings('webinar_assignment_status'))
                                                <button type="button" class="js-add-course-content-btn d-block mb-10 btn-transparent" data-webinar-id="{{ $webinar->id }}" data-type="assignment" data-chapter="{{ !empty($chapter) ? $chapter->id :'' }}">
                                                    {{ trans('update.add_new_assignments') }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <button type="button" class="js-add-chapter btn-transparent text-gray" data-webinar-id="{{ $webinar->id }}" data-chapter="{{ $chapter->id }}" data-locale="{{ mb_strtoupper($chapter->locale) }}">
                                        <i data-feather="edit-3" class="mr-10 cursor-pointer" height="20"></i>
                                    </button>

                                    <a href="{{ getAdminPanelUrl() }}/chapters/{{ $chapter->id }}/delete" class="delete-action btn btn-sm btn-transparent text-gray">
                                        <i data-feather="trash-2" class="mr-10 cursor-pointer" height="20"></i>
                                    </a>

                                    <i data-feather="move" class="move-icon mr-10 cursor-pointer text-gray" height="20"></i>

                                    <i class="collapse-chevron-icon feather-chevron-up text-gray" data-feather="chevron-down" height="20" href="#collapseChapter{{ !empty($chapter) ? $chapter->id :'record' }}" aria-controls="collapseChapter{{ !empty($chapter) ? $chapter->id :'record' }}" data-parent="#chapterAccordion" role="button" data-toggle="collapse" aria-expanded="true"></i>
                                </div>
                            </div>

                            <div id="collapseChapter{{ !empty($chapter) ? $chapter->id :'record' }}" aria-labelledby="chapter_{{ !empty($chapter) ? $chapter->id :'record' }}" class=" collapse show" role="tabpanel">
                                <div class="panel-collapse text-gray">

                                    <div class="accordion-content-wrapper mt-15" id="chapterContentAccordion{{ !empty($chapter) ? $chapter->id :'' }}" role="tablist" aria-multiselectable="true">
                                        @if(!empty($chapter->chapterItems) and count($chapter->chapterItems))
                                            <ul class="draggable-content-lists draggable-lists-chapter-{{ $chapter->id }}" data-drag-class="draggable-lists-chapter-{{ $chapter->id }}" data-order-table="webinar_chapter_items">
                                                @foreach($chapter->chapterItems as $chapterItem)
                                                    @if($chapterItem->type == \App\Models\WebinarChapterItem::$chapterSession and !empty($chapterItem->session))
                                                        @include('admin.webinars.create_includes.accordions.session' ,['session' => $chapterItem->session , 'chapter' => $chapter, 'chapterItem' => $chapterItem])
                                                    @elseif($chapterItem->type == \App\Models\WebinarChapterItem::$chapterFile and !empty($chapterItem->file))
                                                        @include('admin.webinars.create_includes.accordions.file' ,['file' => $chapterItem->file , 'chapter' => $chapter, 'chapterItem' => $chapterItem])
                                                    @elseif($chapterItem->type == \App\Models\WebinarChapterItem::$chapterTextLesson and !empty($chapterItem->textLesson))
                                                        @include('admin.webinars.create_includes.accordions.text-lesson' ,['textLesson' => $chapterItem->textLesson , 'chapter' => $chapter, 'chapterItem' => $chapterItem])
                                                    @elseif($chapterItem->type == \App\Models\WebinarChapterItem::$chapterAssignment and !empty($chapterItem->assignment))
                                                        @include('admin.webinars.create_includes.accordions.assignment' ,['assignment' => $chapterItem->assignment , 'chapter' => $chapter, 'chapterItem' => $chapterItem])
                                                    @elseif($chapterItem->type == \App\Models\WebinarChapterItem::$chapterQuiz and !empty($chapterItem->quiz))
                                                        @include('admin.webinars.create_includes.accordions.quiz' ,['quizInfo' => $chapterItem->quiz , 'chapter' => $chapter, 'chapterItem' => $chapterItem])
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @else
                                            @include(getTemplate() . '.includes.no-result',[
                                                'file_name' => 'meet.png',
                                                'title' => trans('update.chapter_content_no_result'),
                                                'hint' => trans('update.chapter_content_no_result_hint'),
                                            ])
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                @include(getTemplate() . '.includes.no-result',[
                    'file_name' => 'meet.png',
                    'title' => trans('update.chapter_no_result'),
                    'hint' => trans('update.chapter_no_result_hint'),
                ])
            @endif
        </div>
            @push('scripts_bottom')

<script>
    $(document).ready(function () {
        // Function to populate Vimeo video selector
        function populateVimeoSelector(partId, selectedVideoUrl = null) {
            const vimeoSelector = $('#vimeo-video-selector-' + partId);
            const vimeoVideoSelect = vimeoSelector.find('.js-vimeo-video');

            // Clear existing options
            vimeoVideoSelect.empty();
            vimeoVideoSelect.append('<option value="" disabled selected>{{ trans('webinars.select_vimeo_video_placeholder') }}</option>');

            // Fetch videos from Vimeo and populate the select
            @foreach(getVideosFromVimeo() as $video)
                (function () {
                    const videoUrl = "{{ $video['full_url'] }}";
                    const videoName = "{{ $video['name'] }}";
                    const isSelected = (selectedVideoUrl === videoUrl) ? 'selected' : '';
                    vimeoVideoSelect.append(`<option value="${videoUrl}" ${isSelected}>${videoName}</option>`);
                })();
            @endforeach

            // Show the Vimeo video selector
            vimeoSelector.show();
        }

        // Event delegation for storage type change
        $(document).on('change', '.js-file-storage', function () {
            const selectedStorage = $(this).val(); // Get the selected storage value
            const partId = $(this).data('part-id') || 'new'; // Use 'new' as a placeholder if no partId is available

            if (selectedStorage === 'vimeo') {
                // Get the current file_path value (if any)
                const filePathInput = $(`#file_path_${partId}`);
                const selectedVideoUrl = filePathInput.val();

                // Populate the Vimeo video selector with the selected video (if any)
                populateVimeoSelector(partId, selectedVideoUrl);
            } else {
                // Hide the Vimeo video selector if another storage is selected
                $('#vimeo-video-selector-' + partId).hide();
            }
        });

        // Event delegation for Vimeo video selection
        $(document).on('change', '.js-vimeo-video', function () {
            const selectedVideoUrl = $(this).val(); // Get the selected video URL
            const partId = $(this).closest('.vimeo-video-selector').attr('id').split('-')[3]; // Extract the part ID or use 'new'

            // Update the file_path input field with the selected video URL
            const filePathInput = $(`#file_path_${partId}`);
            filePathInput.val(selectedVideoUrl);
        });

        // Initialize Vimeo selectors for existing files on page load
        $('.js-file-storage').each(function () {
            const selectedStorage = $(this).val();
            const partId = $(this).data('part-id') || 'new';

            if (selectedStorage === 'vimeo') {
                 let selectedVideoUrl;
                 let videourll;
                // Get the current file_path value (if any)
                const filePathInput = $(`#file_path_${partId}`);
                console.log(partId);
                if(partId==='new'){
                     videourll = $('.js-file-path').val();
                     selectedVideoUrl = videourll;
                    
                }
                else{
                    
                   selectedVideoUrl = filePathInput.val();  
                }
                
                

                // Populate the Vimeo video selector with the selected video (if any)
                populateVimeoSelector(partId, selectedVideoUrl);
            }
        });
    });
</script>
    @endpush

    </div>
</div>
