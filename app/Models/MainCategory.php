<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Scopes\BranchScope;

class MainCategory extends Model implements TranslatableContract
{
    use Translatable;
    use Sluggable;

    protected $table = 'maincategories';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];

    static $cacheKey = 'maincategories';

    public $translatedAttributes = ['title'];

    public function getTitleAttribute()
    {
        return getTranslateAttributeValue($this, 'title');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
      protected static function booted()
    {
        static::addGlobalScope(new BranchScope);
    }

    public static function makeSlug($title)
    {
        return SlugService::createSlug(self::class, 'slug', $title);
    }


    public function category()
    {
        return $this->belongsTo('App\Models\MainCategory', 'parent_id', 'id');
    }

    public function subCategories()
    {
        return $this->hasMany($this, 'parent_id', 'id')->orderBy('order', 'asc');
    }

    public function filters()
    {
        return $this->hasMany('App\Models\Filter', 'category_id', 'id');
    }

  

    

    public function getUrl()
    {
        $url = '/'.app()->getLocale();

       /* if (!empty($this->category)) {
            $url .= $this->category->slug . '/';
        }*/
         

        $url .= $this->slug;

        return $url;
    }

    static function getCategories()
    {
        $categories = cache()->remember(self::$cacheKey, 24 * 60 * 60, function () {
            return self::whereNull('parent_id')
                ->with([
                    'subCategories' => function ($query) {
                        $query->orderBy('order', 'asc');
                    },
                ])
                ->orderBy('order', 'asc')
                ->get();
        });

        return $categories;
    }

    

    
}
