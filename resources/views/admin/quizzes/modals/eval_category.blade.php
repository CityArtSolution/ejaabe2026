<div class="@if(!empty($quiz)) evalCategoryModal{{ $quiz->id }} @endif {{ empty($question_edit) ? 'd-none' : ''}}">
    <div class="custom-modal-body">
        <h2 class="section-title after-line">اقسام الاسئلة</h2>

        <div class="eval-category-form" data-action="{{ getAdminPanelUrl() }}/evalcategory/{{ empty($question_edit) ? 'store' : $question_edit->id.'/update' }}" method="post">

            <input type="hidden" name="ajax[quiz_id]" value="{{ !empty($quiz) ? $quiz->id :'' }}">
          

            <div class="row mt-3">

                @if(!empty(getGeneralSettings('content_translate')))
                    <div class="col-12">
                        <div class="form-group">
                            <label class="input-label">{{ trans('auth.language') }}</label>
                            <select name="ajax[locale]"
                                    class="form-control {{ !empty($question_edit) ? 'js-quiz-question-locale' : '' }}"
                                    data-id="{{ !empty($question_edit) ? $question_edit->id : '' }}"
                            >
                                @foreach($userLanguages as $lang => $language)
                                    <option value="{{ $lang }}" {{ (!empty($question_edit) and !empty($question_edit->locale)) ? (mb_strtolower($question_edit->locale) == mb_strtolower($lang) ? 'selected' : '') : (app()->getLocale() == $lang ? 'selected' : '') }}>{{ $language }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="ajax[locale]" value="{{ $defaultLocale }}">
                @endif

                <div class="col-12 col-md-12">
                    <div class="form-group">
                        <label class="input-label">عنوان القسم</label>
                        <textarea type="text" name="ajax[title]" class="js-ajax-title form-control" rows="1">{{ !empty($question_edit) ? $question_edit->title : '' }}</textarea>
                        <span class="invalid-feedback"></span>
                    </div>
                </div>

                

                

            </div>

           

            <div class="d-flex align-items-center justify-content-end mt-3">
                <button type="button" class="save-evalcategory btn btn-sm btn-primary">{{ trans('public.save') }}</button>
                <button type="button" class="close-swl btn btn-sm btn-danger ml-2">{{ trans('public.close') }}</button>
            </div>

        </div>
    </div>
</div>
