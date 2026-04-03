<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\FeatureWebinar;
use App\Models\SpecialOffer;
use App\Models\Ticket;
use App\Models\Webinar;
use App\Models\WebinarFilterOption;
use App\Models\WebinarReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class canadaClass extends Controller
{
    public $tableName = 'webinars';
    public $columnId = 'webinar_id';
    
    public function index(Request $request, $categorySlug=null, $subCategorySlug = null)
    {
        
        $webinarsQuery = Webinar::whereNotIn('category_id', [612, 613])->where('webinars.status', 'active')
            ->where('private', false)->where('branch_id', 3);
         if (!empty($categorySlug)) {

            $categoryQuery = Category::query()->whereNotIn('id', [612, 613])->where('slug', $categorySlug)->first();
         if (!empty($subCategorySlug)) {
                $categoryQuery = Category::query()->where('slug', $subCategorySlug)->first();
                
            }
             $webinarsQuery->where('category_id', $categoryQuery->id);
         }
        
        if ($request->has('categories')) {
            $categories = $request->get('categories');
            $webinarsQuery->whereIn('category_id', $categories);
        }

    $allWebinars= $webinarsQuery->get();  
    $pricesFromColumn = $allWebinars->pluck('price')->filter()->unique()->sort()->values();
    
    // Extract prices from the `details` JSON field
    $pricesFromDetails = $allWebinars->flatMap(function ($webinar) {
        $details = json_decode($webinar->details, true);
        return is_array($details) && isset($details['price']) ? [$details['price']] : [];
    })->filter()->unique()->sort()->values();
    
    // Combine and deduplicate prices
    $uniquePrices = $pricesFromColumn->merge($pricesFromDetails)->unique()->sort()->values();

        // Handle review (rating) filter
        if ($request->has('ratings')) {
            $ratings = $request->get('ratings');
            $webinarsQuery->where(function ($query) use ($ratings) {
                foreach ($ratings as $rating) {
                    $query->orWhereHas('reviews', function ($q) use ($rating) {
                        $q->where('status', 'active')
                          ->selectRaw('webinar_id, AVG(rates) as avg_rate')
                          ->groupBy('webinar_id')
                          ->having('avg_rate', '>=', $rating)
                          ->having('avg_rate', '<', $rating + 1);
                    });
                }
            });
        }
    
        // Handle duration (ndays) filter
      if ($request->has('ndays') && !empty($request->ndays)) {
    $ndays = $request->ndays;

    // If ndays is an array, use whereIn
    if (is_array($ndays)) {
        $webinarsQuery->where(function ($query) use ($ndays) {
            $query->whereIn('duration', $ndays) // Check duration field
                  ->orWhereHas('translations', function($q) use ($ndays) {
                      $q->where(function ($subQuery) use ($ndays) {
                          foreach ($ndays as $day) {
                              $subQuery->orWhere('details', 'LIKE', '%ndays":"' . $day . '"%');
                          }
                      });
                  });
        });
    } else {
        // If ndays is a single value
        $webinarsQuery->where(function ($query) use ($ndays) {
            $query->where('duration', $ndays) // Check duration field
                  ->orWhereHas('translations', function($q) use ($ndays) {
                      $q->where('details', 'LIKE', '%ndays":"' . $ndays . '"%');
                  });
        });
    }
}

        if ($request->has('prices') && !empty($request->prices)) {
            $prices = $request->prices;
        
            $webinarsQuery->where(function ($query) use ($prices) {
                // Case 1: Price in the `price` column
                $query->whereIn('price', $prices);
        
                // Case 2: Price in the `details` JSON field
                $query->orWhereHas('translations', function ($q) use ($prices) {
                    $q->where(function ($subQuery) use ($prices) {
                        foreach ($prices as $price) {
                            $subQuery->orWhere('details', 'LIKE', '%price":"' . $price . '"%');
                        }
                    });
                });
            });
        }
        // Handle other filters (type, more options, etc.)
        $webinarsQuery = $this->handleFilters($request, $webinarsQuery);
    
        // Sorting
        $sort = $request->get('sort', null);
        if (empty($sort) or $sort == 'newest') {
            $webinarsQuery->orderBy("{$this->tableName}.created_at", 'desc');
        }
    
        // Paginate results
        $webinars = $webinarsQuery->paginate(9);
    
     $categories = Category::whereNotIn('id', [612, 613])
    ->where(function ($query) {
        // Get categories that have direct webinars in branch 3
        $query->whereHas('webinars', function ($q) {
            $q->where('webinars.status', 'active')
              ->where('private', false)
              ->where('branch_id', 3);
        })
        // OR get parent categories that have subcategories with webinars in branch 3
        ->orWhereHas('subCategories.webinars', function ($q) {
            $q->where('webinars.status', 'active')
              ->where('private', false)
              ->where('branch_id', 3);
        });
    })
    // Count direct webinars
    ->withCount(['webinars' => function ($query) {
        $query->where('webinars.status', 'active')
              ->where('private', false)
              ->where('branch_id', 3);
    }])
    // Load subcategories with their webinar counts
    ->with(['subCategories' => function ($query) {
        $query->withCount(['webinars' => function ($q) {
            $q->where('webinars.status', 'active')
              ->where('private', false)
              ->where('branch_id', 3);
        }]);
    }])
    ->orderBy('order', 'asc')
    ->get();

      
        $allNdaysValues = Webinar::where('status', 'active')
    ->where('private', false)
    ->whereIn('type', ['text_lesson', 'course', 'offline', 'webinar'])
    ->get();

$ndaysValues = $allNdaysValues->flatMap(function ($course) {
    if ($course->duration > 0) {
        return [$course->duration];
    }
   $details = json_decode($course->details, true);
    return is_array($details) ? array_column($details, 'ndays') : [];
})->unique()->sort()->values();
    
        // SEO and other data
        $seoSettings = getSeoMetas('classes');
        $pageTitle = $seoSettings['title'] ?? '';
        $pageDescription = $seoSettings['description'] ?? '';
        $pageRobot = getPageRobot('classes');
    
        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'category'=>$categoryQuery??'',
            'pageRobot' => $pageRobot,
            'webinars' => $webinars,
            'coursesCount' => $webinars->total(),
            'categories_filter' => $categories,
            'ndaysValues' => $ndaysValues, 
            'uniquePrices' => $uniquePrices,
        ];
    
        return view(getTemplate() . '.pages.classescanada', $data);
    }
    public function index_egy(Request $request, $categorySlug=null, $subCategorySlug = null)
    {
        
        $webinarsQuery = Webinar::where('webinars.status', 'active')->where('private', false)->where('branch_id', 4);
        
         if (!empty($categorySlug)) {
            $categoryQuery = Category::query()->where('branch_id', 4)->where('slug', $categorySlug)->first();
         if (!empty($subCategorySlug)) {
                $categoryQuery = Category::query()->where('slug', $subCategorySlug)->first();
                
            }
             $webinarsQuery->where('category_id', $categoryQuery->id);
         }
        
        if ($request->has('categories')) {
            $categories = $request->get('categories');
            $webinarsQuery->whereIn('category_id', $categories);
        }

    $allWebinars= $webinarsQuery->get();  
    $pricesFromColumn = $allWebinars->pluck('price')->filter()->unique()->sort()->values();
    
    // Extract prices from the `details` JSON field
    $pricesFromDetails = $allWebinars->flatMap(function ($webinar) {
        $details = json_decode($webinar->details, true);
        return is_array($details) && isset($details['price']) ? [$details['price']] : [];
    })->filter()->unique()->sort()->values();
    
    // Combine and deduplicate prices
    $uniquePrices = $pricesFromColumn->merge($pricesFromDetails)->unique()->sort()->values();

        // Handle review (rating) filter
        if ($request->has('ratings')) {
            $ratings = $request->get('ratings');
            $webinarsQuery->where(function ($query) use ($ratings) {
                foreach ($ratings as $rating) {
                    $query->orWhereHas('reviews', function ($q) use ($rating) {
                        $q->where('status', 'active')
                          ->selectRaw('webinar_id, AVG(rates) as avg_rate')
                          ->groupBy('webinar_id')
                          ->having('avg_rate', '>=', $rating)
                          ->having('avg_rate', '<', $rating + 1);
                    });
                }
            });
        }
    
        // Handle duration (ndays) filter
      if ($request->has('ndays') && !empty($request->ndays)) {
    $ndays = $request->ndays;

    // If ndays is an array, use whereIn
    if (is_array($ndays)) {
        $webinarsQuery->where(function ($query) use ($ndays) {
            $query->whereIn('duration', $ndays) // Check duration field
                  ->orWhereHas('translations', function($q) use ($ndays) {
                      $q->where(function ($subQuery) use ($ndays) {
                          foreach ($ndays as $day) {
                              $subQuery->orWhere('details', 'LIKE', '%ndays":"' . $day . '"%');
                          }
                      });
                  });
        });
    } else {
        // If ndays is a single value
        $webinarsQuery->where(function ($query) use ($ndays) {
            $query->where('duration', $ndays) // Check duration field
                  ->orWhereHas('translations', function($q) use ($ndays) {
                      $q->where('details', 'LIKE', '%ndays":"' . $ndays . '"%');
                  });
        });
    }
}

        if ($request->has('prices') && !empty($request->prices)) {
            $prices = $request->prices;
        
            $webinarsQuery->where(function ($query) use ($prices) {
                // Case 1: Price in the `price` column
                $query->whereIn('price', $prices);
        
                // Case 2: Price in the `details` JSON field
                $query->orWhereHas('translations', function ($q) use ($prices) {
                    $q->where(function ($subQuery) use ($prices) {
                        foreach ($prices as $price) {
                            $subQuery->orWhere('details', 'LIKE', '%price":"' . $price . '"%');
                        }
                    });
                });
            });
        }
        // Handle other filters (type, more options, etc.)
        $webinarsQuery = $this->handleFilters($request, $webinarsQuery);
    
        // Sorting
        $sort = $request->get('sort', null);
        if (empty($sort) or $sort == 'newest') {
            $webinarsQuery->orderBy("{$this->tableName}.created_at", 'desc');
        }
    
        // Paginate results
        $webinars = $webinarsQuery->paginate(9);
    
     $categories = Category::whereNotIn('id', [612, 613])
    ->where(function ($query) {
        // Get categories that have direct webinars in branch 3
        $query->whereHas('webinars', function ($q) {
            $q->where('webinars.status', 'active')
              ->where('private', false)
              ->where('branch_id', 4);
        })
        // OR get parent categories that have subcategories with webinars in branch 3
        ->orWhereHas('subCategories.webinars', function ($q) {
            $q->where('webinars.status', 'active')
              ->where('private', false)
              ->where('branch_id', 4);
        });
    })
    // Count direct webinars
    ->withCount(['webinars' => function ($query) {
        $query->where('webinars.status', 'active')
              ->where('private', false)
              ->where('branch_id', 4);
    }])
    // Load subcategories with their webinar counts
    ->with(['subCategories' => function ($query) {
        $query->withCount(['webinars' => function ($q) {
            $q->where('webinars.status', 'active')
              ->where('private', false)
              ->where('branch_id', 4);
        }]);
    }])
    ->orderBy('order', 'asc')
    ->get();

      
        $allNdaysValues = Webinar::where('status', 'active')
    ->where('private', false)
    ->whereIn('type', ['text_lesson', 'course', 'offline', 'webinar'])
    ->get();

$ndaysValues = $allNdaysValues->flatMap(function ($course) {
    if ($course->duration > 0) {
        return [$course->duration];
    }
   $details = json_decode($course->details, true);
    return is_array($details) ? array_column($details, 'ndays') : [];
})->unique()->sort()->values();
    
        // SEO and other data
        $seoSettings = getSeoMetas('classes');
        $pageTitle = $seoSettings['title'] ?? '';
        $pageDescription = $seoSettings['description'] ?? '';
        $pageRobot = getPageRobot('classes');
    
        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'category'=>$categoryQuery??'',
            'pageRobot' => $pageRobot,
            'webinars' => $webinars,
            'coursesCount' => $webinars->total(),
            'categories_filter' => $categories,
            'ndaysValues' => $ndaysValues, 
            'uniquePrices' => $uniquePrices,
        ];
    
        return view(getTemplate() . '.pages.classesEgy', $data);
    }
    public function index_uae(Request $request, $categorySlug=null, $subCategorySlug = null)
    {
        
        $webinarsQuery = Webinar::where('webinars.status', 'active')->where('private', false)->where('branch_id', 2);
        
         if (!empty($categorySlug)) {
            $categoryQuery = Category::query()->where('branch_id', 2)->where('slug', $categorySlug)->first();
         if (!empty($subCategorySlug)) {
                $categoryQuery = Category::query()->where('slug', $subCategorySlug)->first();
                
            }
             $webinarsQuery->where('category_id', $categoryQuery->id);
         }
        
        if ($request->has('categories')) {
            $categories = $request->get('categories');
            $webinarsQuery->whereIn('category_id', $categories);
        }

    $allWebinars= $webinarsQuery->get();  
    $pricesFromColumn = $allWebinars->pluck('price')->filter()->unique()->sort()->values();
    
    // Extract prices from the `details` JSON field
    $pricesFromDetails = $allWebinars->flatMap(function ($webinar) {
        $details = json_decode($webinar->details, true);
        return is_array($details) && isset($details['price']) ? [$details['price']] : [];
    })->filter()->unique()->sort()->values();
    
    // Combine and deduplicate prices
    $uniquePrices = $pricesFromColumn->merge($pricesFromDetails)->unique()->sort()->values();

        // Handle review (rating) filter
        if ($request->has('ratings')) {
            $ratings = $request->get('ratings');
            $webinarsQuery->where(function ($query) use ($ratings) {
                foreach ($ratings as $rating) {
                    $query->orWhereHas('reviews', function ($q) use ($rating) {
                        $q->where('status', 'active')
                          ->selectRaw('webinar_id, AVG(rates) as avg_rate')
                          ->groupBy('webinar_id')
                          ->having('avg_rate', '>=', $rating)
                          ->having('avg_rate', '<', $rating + 1);
                    });
                }
            });
        }
    
        // Handle duration (ndays) filter
      if ($request->has('ndays') && !empty($request->ndays)) {
    $ndays = $request->ndays;

    // If ndays is an array, use whereIn
    if (is_array($ndays)) {
        $webinarsQuery->where(function ($query) use ($ndays) {
            $query->whereIn('duration', $ndays) // Check duration field
                  ->orWhereHas('translations', function($q) use ($ndays) {
                      $q->where(function ($subQuery) use ($ndays) {
                          foreach ($ndays as $day) {
                              $subQuery->orWhere('details', 'LIKE', '%ndays":"' . $day . '"%');
                          }
                      });
                  });
        });
    } else {
        // If ndays is a single value
        $webinarsQuery->where(function ($query) use ($ndays) {
            $query->where('duration', $ndays) // Check duration field
                  ->orWhereHas('translations', function($q) use ($ndays) {
                      $q->where('details', 'LIKE', '%ndays":"' . $ndays . '"%');
                  });
        });
    }
}

        if ($request->has('prices') && !empty($request->prices)) {
            $prices = $request->prices;
        
            $webinarsQuery->where(function ($query) use ($prices) {
                // Case 1: Price in the `price` column
                $query->whereIn('price', $prices);
        
                // Case 2: Price in the `details` JSON field
                $query->orWhereHas('translations', function ($q) use ($prices) {
                    $q->where(function ($subQuery) use ($prices) {
                        foreach ($prices as $price) {
                            $subQuery->orWhere('details', 'LIKE', '%price":"' . $price . '"%');
                        }
                    });
                });
            });
        }
        // Handle other filters (type, more options, etc.)
        $webinarsQuery = $this->handleFilters($request, $webinarsQuery);
    
        // Sorting
        $sort = $request->get('sort', null);
        if (empty($sort) or $sort == 'newest') {
            $webinarsQuery->orderBy("{$this->tableName}.created_at", 'desc');
        }
    
        // Paginate results
        $webinars = $webinarsQuery->paginate(9);
    
     $categories = Category::whereNotIn('id', [612, 613])
    ->where(function ($query) {
        // Get categories that have direct webinars in branch 3
        $query->whereHas('webinars', function ($q) {
            $q->where('webinars.status', 'active')
              ->where('private', false)
              ->where('branch_id', 2);
        })
        // OR get parent categories that have subcategories with webinars in branch 3
        ->orWhereHas('subCategories.webinars', function ($q) {
            $q->where('webinars.status', 'active')
              ->where('private', false)
              ->where('branch_id', 2);
        });
    })
    // Count direct webinars
    ->withCount(['webinars' => function ($query) {
        $query->where('webinars.status', 'active')
              ->where('private', false)
              ->where('branch_id', 2);
    }])
    // Load subcategories with their webinar counts
    ->with(['subCategories' => function ($query) {
        $query->withCount(['webinars' => function ($q) {
            $q->where('webinars.status', 'active')
              ->where('private', false)
              ->where('branch_id', 2);
        }]);
    }])
    ->orderBy('order', 'asc')
    ->get();

      
        $allNdaysValues = Webinar::where('status', 'active')
    ->where('private', false)
    ->whereIn('type', ['text_lesson', 'course', 'offline', 'webinar'])
    ->get();

$ndaysValues = $allNdaysValues->flatMap(function ($course) {
    if ($course->duration > 0) {
        return [$course->duration];
    }
   $details = json_decode($course->details, true);
    return is_array($details) ? array_column($details, 'ndays') : [];
})->unique()->sort()->values();
    
        // SEO and other data
        $seoSettings = getSeoMetas('classes');
        $pageTitle = $seoSettings['title'] ?? '';
        $pageDescription = $seoSettings['description'] ?? '';
        $pageRobot = getPageRobot('classes');
    
        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'category'=>$categoryQuery??'',
            'pageRobot' => $pageRobot,
            'webinars' => $webinars,
            'coursesCount' => $webinars->total(),
            'categories_filter' => $categories,
            'ndaysValues' => $ndaysValues, 
            'uniquePrices' => $uniquePrices,
        ];
    
        return view(getTemplate() . '.pages.classesuae', $data);
    }
    
     public function handleFilters($request, $query)
    {
        $upcoming = $request->get('upcoming', null);
        $isFree = $request->get('free', null);
        $withDiscount = $request->get('discount', null);
        $isDownloadable = $request->get('downloadable', null);
        $sort = $request->get('sort', null);
        $filterOptions = $request->get('filter_option', []);
        $typeOptions = $request->get('type', []);
        $moreOptions = $request->get('moreOptions', []);

        $query->whereHas('teacher', function ($query) {
            $query->where('status', 'active')
                ->where(function ($query) {
                    $query->where('ban', false)
                        ->orWhere(function ($query) {
                            $query->whereNotNull('ban_end_at')
                                ->where('ban_end_at', '<', time());
                        });
                });
        });

        if ($this->tableName == 'webinars') {

            if (!empty($upcoming) and $upcoming == 'on') {
                $query->whereNotNull('start_date')
                    ->where('start_date', '>=', time());
            }

            if (!empty($isDownloadable) and $isDownloadable == 'on') {
                $query->where('downloadable', 1);
            }

            if (!empty($typeOptions) and is_array($typeOptions)) {
                $query->whereIn("{$this->tableName}.type", $typeOptions);
            }

            if (!empty($moreOptions) and is_array($moreOptions)) {
                if (in_array('subscribe', $moreOptions)) {
                    $query->where('subscribe', 1);
                }

                if (in_array('certificate_included', $moreOptions)) {
                    $query->whereHas('quizzes', function ($query) {
                        $query->where('certificate', 1)
                            ->where('status', 'active');
                    });
                }

                if (in_array('with_quiz', $moreOptions)) {
                    $query->whereHas('quizzes', function ($query) {
                        $query->where('status', 'active');
                    });
                }

                if (in_array('featured', $moreOptions)) {
                    $query->whereHas('feature', function ($query) {
                        $query->whereIn('page', ['home_categories', 'categories'])
                            ->where('status', 'publish');
                    });
                }
            }
        }

        if (!empty($isFree) and $isFree == 'on') {
            $query->where(function ($qu) {
                $qu->whereNull('price')
                    ->orWhere('price', '0');
            });
        }

        if (!empty($withDiscount) and $withDiscount == 'on') {
            $now = time();
            $webinarIdsHasDiscount = [];

            $tickets = Ticket::where('start_date', '<', $now)
                ->where('end_date', '>', $now)
                ->whereNotNull("{$this->columnId}")
                ->get();

            foreach ($tickets as $ticket) {
                if ($ticket->isValid()) {
                    $webinarIdsHasDiscount[] = $ticket->{$this->columnId};
                }
            }

            $specialOffersItemIds = SpecialOffer::where('status', 'active')
                ->where('from_date', '<', $now)
                ->where('to_date', '>', $now)
                ->pluck("{$this->columnId}")
                ->toArray();

            $webinarIdsHasDiscount = array_merge($specialOffersItemIds, $webinarIdsHasDiscount);

            $webinarIdsHasDiscount = array_unique($webinarIdsHasDiscount);

            $query->whereIn("{$this->tableName}.id", $webinarIdsHasDiscount);
        }

        if (!empty($sort)) {
            if ($sort == 'expensive') {
                $query->whereNotNull('price');
                $query->where('price', '>', 0);
                $query->orderBy('price', 'desc');
            }

            if ($sort == 'inexpensive') {
                $query->whereNotNull('price');
                $query->where('price', '>', 0);
                $query->orderBy('price', 'asc');
            }

            if ($sort == 'bestsellers') {
                $query->leftJoin('sales', function ($join) {
                    $join->on("{$this->tableName}.id", '=', "sales.{$this->columnId}")
                        ->whereNull('refund_at');
                })
                    ->whereNotNull("sales.{$this->columnId}")
                    ->select("{$this->tableName}.*", "sales.{$this->columnId}", DB::raw("count(sales.{$this->columnId}) as salesCounts"))
                    ->groupBy("sales.{$this->columnId}")
                    ->orderBy('salesCounts', 'desc');
            }

            if ($sort == 'best_rates') {
                $query->leftJoin('webinar_reviews', function ($join) {
                    $join->on("{$this->tableName}.id", '=', "webinar_reviews.{$this->columnId}");
                    $join->where('webinar_reviews.status', 'active');
                })
                    ->whereNotNull('rates')
                    ->select("{$this->tableName}.*", DB::raw('avg(rates) as rates'))
                    ->groupBy("{$this->tableName}.id")
                    ->orderBy('rates', 'desc');
            }
        }

        if (!empty($filterOptions) and is_array($filterOptions)) {
            $webinarIdsFilterOptions = WebinarFilterOption::whereIn('filter_option_id', $filterOptions)
                ->pluck($this->columnId)
                ->toArray();

            $query->whereIn("{$this->tableName}.id", $webinarIdsFilterOptions);
        }

        return $query;
    }

}
