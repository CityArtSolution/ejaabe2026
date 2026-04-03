@extends(getTemplate().'.layouts.uae_app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <style>
        .fa-star {
            font-size: 16px; 
            margin-right: 2px; 
        }
        .subcategories {
            /* border-left: 1px solid #e5e5e5; */
            transition: all 0.3sease;
            background: #f7f6f6;
            padding: 5px;
            padding-left: 5px;
            font-size: 14px;
        }
        .webinar-card .webinar-card-body .webinar-title {
            height: auto;
        }
        .subcategories {
            border-left: 1px solid #e5e5e5;
            transition: all 0.3s ease;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .category-title {
            font-weight: 500;
            font-size: 15px;
        }
    </style>
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
    </style>
@endif
@endpush

@php
    $selectedCategories = request()->get('categories', []);
    $selectedCategoryTitle = null;

    if(!empty($selectedCategories)) {
        $selectedCategoryId = $selectedCategories[0] ?? null;
        $selectedCategory = $categories_filter->firstWhere('id', $selectedCategoryId);

        if(!$selectedCategory) {
            foreach($categories_filter as $parentCategory) {
                $selectedCategory = $parentCategory->subCategories->firstWhere('id', $selectedCategoryId);
                if($selectedCategory) break;
            }
        }

        $selectedCategoryTitle = $selectedCategory->title ?? null;
    }
@endphp


@section('content')
    <section class="site-top-banner search-top-banner opacity-04 position-relative">
        <img src="{{ getPageBackgroundSettings('categories') }}" class="img-cover" alt=""/>
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-12 col-md-9 col-lg-7">
                    <div class="top-search-categories-form">
                        <h1 class="text-white font-30 mb-15">
                            {{ $selectedCategoryTitle ?? (!empty($category) ? $category->title : trans('update.courses')) }}
                        </h1>
                        <span class="course-count-badge py-5 px-10 text-white rounded">{{ $coursesCount }} {{ trans('update.courses') }}</span>
                        <div class="search-input bg-white p-10 flex-grow-1">
                            <form action="{{ '/'.app()->getLocale().'/search/uae' }}" method="get">
                                <div class="form-group d-flex align-items-center m-0">
                                    <input type="text" name="search" class="form-control border-0" placeholder="{{ trans('home.slider_search_placeholder') }}"/>
                                    <button type="submit" class="btn btn-primary rounded-pill">{{ trans('home.find') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@php
    $categoriesSelected = request()->get('categories', []);
@endphp

    <div class="container mt-30">
        <section class="mt-lg-50 pt-lg-20 mt-md-40 pt-md-40">
            <form action="/{{app()->getLocale()}}/uae/classes" method="get" id="filtersForm">
                <div class="row mt-20">
                    <!-- Filters Column -->
                    <div class="col-12 col-lg-4">
                        <div class="mt-20 p-20 rounded-sm shadow-lg border border-gray300 filters-container">
                            <!-- Category Filter -->
                            <div class="">
                               <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue">{{ trans('public.categories') }}</h3>
                                <div class="pt-10">
                                    @foreach($categories_filter as $category)
                                        @if($category->parent_id === null)
                                            @php
                                                $totalWebinars = $category->webinars_count;
                                                foreach($category->subCategories as $sub) {
                                                    $totalWebinars += $sub->webinars_count;
                                                }
                                                $hasSubWithWebinars = $category->subCategories->where('webinars_count', '>', 0)->count() > 0;
                                            @endphp
                                
                                            @if($totalWebinars > 0)
                                                <div class="category-parent mb-2">
                                                    <div class="d-flex align-items-center justify-content-between mt-20 cats_en">
                                                        <!-- Category title -->
                                                        <span class="category-title">{{ $category->title }} ({{ $totalWebinars }})</span>
                                                        <div class="d-flex align-items-center">
                                                            <!-- Checkbox for parent category -->
                                                            <div class="custom-control custom-checkbox me-2">
                                                                @php
                                $categoriesSelected = request()->get('categories', []);
                                @endphp
                                
                                <input type="radio"
                                    id="filterCategory{{ $category->id }}"
                                    class="custom-control-input {{ $hasSubWithWebinars ? 'parent-checkbox' : 'filter-checkbox' }}"
                                    name="categories[]"
                                    value="{{ $category->id }}"
                                    data-category="{{ $category->id }}"
                                    @if(in_array($category->id, $categoriesSelected)) checked="checked" @endif
                                    @if(!$hasSubWithWebinars) onchange="this.form.submit()" @endif>
                                
                                
                                                                <label class="custom-control-label" for="filterCategory{{ $category->id }}"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                
                                                    @if($hasSubWithWebinars)
                                                        <div class="subcategories pl-4 mt-2" id="subcategories-{{ $category->id }}" style="display: none;">
                                                            @foreach($category->subCategories as $subCategory)
                                                                @if($subCategory->webinars_count > 0)
                                                                    <div class="d-flex align-items-center justify-content-between mt-2 cats_en">
                                                                        <!-- Subcategory title -->
                                                                        <span class="ms-2">{{ $subCategory->title }} ({{ $subCategory->webinars_count }})</span>
                                                                        <!-- Checkbox for subcategory -->
                                                                        <div class="custom-control custom-checkbox me-2">
                                                                            <input type="checkbox" name="categories[]"
                                                                                   id="filterCategory{{ $subCategory->id }}"
                                                                                   value="{{ $subCategory->id }}"
                                                                                   @if(in_array($subCategory->id, request()->get('categories', []))) checked="checked" @endif
                                                                                   class="custom-control-input filter-checkbox"
                                                                                   onchange="this.form.submit()">
                                                                            <label class="custom-control-label" for="filterCategory{{ $subCategory->id }}"></label>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
</div>
                                <div class="mt-25 pt-25 border-top border-gray300">
                                    <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue">{{ trans('public.reviews') }}</h3>
                                    <div class="pt-10">
                                        @foreach([5, 4, 3, 2, 1] as $rating)
                                            <div class="d-flex align-items-center justify-content-between mt-20">
                                                <label class="cursor-pointer" for="filterRating{{ $rating }}">
                                                    <!-- Display star icons based on the rating -->
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $rating)
                                                            <i class="fas fa-star text-warning"></i> <!-- Filled star -->
                                                        @else
                                                            <i class="far fa-star text-warning"></i> <!-- Empty star -->
                                                        @endif
                                                    @endfor
                                                   
                                                </label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="ratings[]" id="filterRating{{ $rating }}" value="{{ $rating }}" 
                                                        @if(in_array($rating, request()->get('ratings', []))) checked="checked" @endif 
                                                        class="custom-control-input filter-checkbox">
                                                    <label class="custom-control-label" for="filterRating{{ $rating }}"></label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Type Filter -->
                           {{-- <div class="mt-25 pt-25 border-top border-gray300">
                                <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue">{{ trans('public.type') }}</h3>
                                <div class="pt-10">
                                    @foreach(['bundle','webinar','course','text_lesson'] as $typeOption)
                                        <div class="d-flex align-items-center justify-content-between mt-20">
                                            <label class="cursor-pointer" for="filterType{{ $typeOption }}">
                                                @if($typeOption == 'bundle')
                                                    {{ trans('update.bundle') }}
                                                @else
                                                    {{ trans('webinars.'.$typeOption) }}
                                                @endif
                                            </label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="type[]" id="filterType{{ $typeOption }}" value="{{ $typeOption }}" 
                                                    @if(in_array($typeOption, request()->get('type', []))) checked="checked" @endif 
                                                    class="custom-control-input filter-checkbox">
                                                <label class="custom-control-label" for="filterType{{ $typeOption }}"></label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>--}}

                            <!-- More Options Filter -->
                          {{--  <div class="mt-25 pt-25 border-top border-gray300">
                                <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue">{{ trans('site.more_options') }}</h3>
                                <div class="pt-10">
                                    @foreach(['subscribe','certificate_included','with_quiz','featured'] as $moreOption)
                                        <div class="d-flex align-items-center justify-content-between mt-20">
                                            <label class="cursor-pointer" for="filterMoreOption{{ $moreOption }}">{{ trans('webinars.show_only_'.$moreOption) }}</label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="moreOptions[]" id="filterMoreOption{{ $moreOption }}" value="{{ $moreOption }}" 
                                                    @if(in_array($moreOption, request()->get('moreOptions', []))) checked="checked" @endif 
                                                    class="custom-control-input filter-checkbox">
                                                <label class="custom-control-label" for="filterMoreOption{{ $moreOption }}"></label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>--}}
                        </div>
                    </div>

                    <!-- Webinars List Column -->
                    <div class="col-12 col-lg-8">
                        @if(empty(request()->get('card')) or request()->get('card') == 'grid')
                            <div class="row">
                                @foreach($webinars as $webinar)
                                    <div class="col-12 col-lg-4 mt-20">
                                        @include('web.default.includes.webinar.grid-card-uae',['webinar' => $webinar])
                                    </div>
                                @endforeach
                            </div>
                        @elseif(!empty(request()->get('card')) and request()->get('card') == 'list')
                            @foreach($webinars as $webinar)
                                @include('web.default.includes.webinar.list-card-uae',['webinar' => $webinar])
                            @endforeach
                        @endif
                    </div>
                </div>
            </form>

            <!-- Pagination -->
            <div class="mt-50 pt-30">
                {{ $webinars->appends(request()->input())->links('vendor.pagination.panel') }}
            </div>
        </section>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const allCategoryCheckboxes = document.querySelectorAll(".filter-checkbox, .parent-checkbox");

    allCategoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            // نشيل check من الكل
            allCategoryCheckboxes.forEach(cb => cb.checked = false);

            // نحط check فقط على يلي ضغط عليه
            this.checked = true;

            // submit للفورم
            document.getElementById("filtersForm").submit();
        });
    });
});

</script>
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
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/js/parts/categories.min.js"></script>
    <script>
        // Automatically submit the form when a checkbox is checked/unchecked
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.filter-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    document.getElementById('filtersForm').submit();
                });
            });
        });
    </script>
@endpush