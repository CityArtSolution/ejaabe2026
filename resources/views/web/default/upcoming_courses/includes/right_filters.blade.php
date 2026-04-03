    @if(app()->getLocale()=='en')


<style>
    .cats_en {
    justify-content: left !important;
}
.category-parent.mb-2 {
    direction: rtl;
}
.category-title {
    font-weight: 500;
    font-size: 13px !important;
}
span.ms-2 {
    font-size: 12px !important;
}
.custom-control {
    display: flex  !important;

    align-items: normal !important;
}

</style>
@endif
<!--<div class="mt-20 p-20 rounded-sm shadow-lg border border-gray300 filters-container">

   <!-- <div class="">
        <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue">{{ trans('public.type') }}</h3>

        <div class="pt-10">
            @foreach(['webinar','course','text_lesson'] as $typeOption)
                <div class="d-flex align-items-center justify-content-between mt-20">
                    <label class="cursor-pointer" for="filterLanguage{{ $typeOption }}">{{ trans('webinars.'.$typeOption) }}</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="type[]" id="filterLanguage{{ $typeOption }}" value="{{ $typeOption }}" @if(in_array($typeOption, request()->get('type', []))) checked="checked" @endif class="custom-control-input">
                        <label class="custom-control-label" for="filterLanguage{{ $typeOption }}"></label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-25 pt-25 border-top border-gray300">
        <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue">{{ trans('site.more_options') }}</h3>

        <div class="pt-10">
            @foreach(['supported_courses', 'quiz_included', 'certificate_included'] as $moreOption)
                <div class="d-flex align-items-center justify-content-between mt-20">
                    <label class="cursor-pointer" for="filterLanguage{{ $moreOption }}">{{ trans('update.show_only_'.$moreOption) }}</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="moreOptions[]" id="filterLanguage{{ $moreOption }}" value="{{ $moreOption }}" @if(in_array($moreOption, request()->get('moreOptions', []))) checked="checked" @endif class="custom-control-input">
                        <label class="custom-control-label" for="filterLanguage{{ $moreOption }}"></label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <button type="submit" class="btn btn-sm btn-primary btn-block mt-30">{{ trans('site.filter_items') }}</button>
</div>-->

@php
    $urlParams = request()->all();
@endphp

@if(!empty($categoriesLists))
    @if(!empty($selectedCategory))
        <input type="hidden" name="category_id" value="{{ $selectedCategory->id }}">
    @endif

    <div class="mt-20 p-20 rounded-sm shadow-lg border border-gray300 filters-container">

        <div class="">
<h3 class="category-filter-title font-20 font-weight-bold text-dark-blue">{{ trans('categories.categories') }}</h3>

<div class="pt-10">
    @foreach($categoriesLists as $categoryItem)
        @php
            $hasSubCategories = !empty($categoryItem->subCategories) && count($categoryItem->subCategories);
        @endphp

        <div class="category-parent mb-2">
            <div class="d-flex align-items-center justify-content-between mt-20 cats_en">
                <!-- Parent Category Title and Total Count -->
                <span class="category-title">{{ $categoryItem->title }} ({{ $categoryItem->total_upcoming_courses_count }})</span>

                <!-- Parent Category Checkbox -->
                <div class="custom-control custom-checkbox me-2">
                    <input type="checkbox"
                           id="filterCategory{{ $categoryItem->id }}"
                           class="custom-control-input {{ $hasSubCategories ? 'parent-checkbox' : 'filter-checkbox' }}"
                           name="categories[]"
                           value="{{ $categoryItem->id }}"
                           data-category="{{ $categoryItem->id }}"
                           @if(in_array($categoryItem->id, request()->get('categories', []))) checked="checked" @endif
                           @if(!$hasSubCategories) onchange="this.form.submit()" @endif>
                    <label class="custom-control-label" for="filterCategory{{ $categoryItem->id }}"></label>
                </div>
            </div>

            @if($hasSubCategories)
                <div class="subcategories pl-4 mt-2" id="subcategories-{{ $categoryItem->id }}" style="display: none;">
                    @foreach($categoryItem->subCategories as $subCategory)
                        <div class="d-flex align-items-center justify-content-between mt-2 cats_en">
                            <!-- Subcategory Title and Count -->
                            <span class="ms-2">{{ $subCategory->title }} ({{ $subCategory->upcoming_courses_count }})</span>

                            <!-- Subcategory Checkbox -->
                            <div class="custom-control custom-checkbox me-2">
                                <input type="checkbox"
                                       id="filterCategory{{ $subCategory->id }}"
                                       name="categories[]"
                                       value="{{ $subCategory->id }}"
                                       class="custom-control-input filter-checkbox"
                                       @if(in_array($subCategory->id, request()->get('categories', []))) checked="checked" @endif
                                       onchange="this.form.submit()">
                                <label class="custom-control-label" for="filterCategory{{ $subCategory->id }}"></label>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>

<style>
.subcategories {
    border-left: 1px solid #e5e5e5;
    transition: all 0.3s ease;
}
.category-title {
    font-weight: 500;
}
.me-2 {
    margin-right: 0.5rem;
}
.ms-2 {
    margin-left: 0.5rem;
}
.custom-control {
    display: flex;
    align-items: center;
}
.custom-control-input {
    margin-right: 0.5rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle parent checkbox clicks to toggle subcategories visibility
    document.querySelectorAll('.parent-checkbox').forEach(checkbox => {
        checkbox.addEventListener('click', function(event) {
            // Prevent the default checkbox behavior (changing its state) on the first click
            event.preventDefault();

            const categoryId = this.dataset.category;
            const subcategoriesDiv = document.getElementById(`subcategories-${categoryId}`);

            if (subcategoriesDiv) {
                const isExpanded = subcategoriesDiv.style.display !== 'none';
                subcategoriesDiv.style.display = isExpanded ? 'none' : 'block';
            }

            // Allow the checkbox to change its state on the second click
            checkbox.addEventListener('click', function(event) {
                // Do not prevent default behavior on the second click
                // The checkbox will now change its state
            }, { once: true }); // Ensure this listener only runs once
        });
    });
});
</script>
        </div>
    </div>
@endif

@if(!empty($selectedCategory) and !empty($selectedCategory->filters))
    <div class="mt-20 p-20 rounded-sm shadow-lg border border-gray300 filters-container">

        @foreach($selectedCategory->filters as $filter)
            <div class="mt-25 pt-25 border-top border-gray300">
                <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue">{{ $filter->title }}</h3>

                @if(!empty($filter->options))
                    <div class="pt-10">
                        @foreach($filter->options as $option)
                            <div class="d-flex align-items-center justify-content-between mt-20">
                                <label class="cursor-pointer" for="filterLanguage{{ $option->id }}">{{ $option->title }}</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="filter_option[]" id="filterLanguage{{ $option->id }}" value="{{ $option->id }}" @if(in_array($option->id, request()->get('filter_option', []))) checked="checked" @endif class="custom-control-input">
                                    <label class="custom-control-label" for="filterLanguage{{ $option->id }}"></label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach

        <button type="submit" class="btn btn-sm btn-primary btn-block mt-30">{{ trans('site.filter_items') }}</button>
    </div>
@endif
