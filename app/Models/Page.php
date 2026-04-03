<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'pages';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];
    static $cacheKey = 'pages1';
    public $translatedAttributes = ['title', 'seo_description', 'content'];

    public function getTitleAttribute()
    {
        return getTranslateAttributeValue($this, 'title');
    }

    public function getSeoDescriptionAttribute()
    {
        return getTranslateAttributeValue($this, 'seo_description');
    }

    public function getContentAttribute()
    {
        return getTranslateAttributeValue($this, 'content');
    }
     static function getFooterPages2()
    {
       $pagesId=[10,11,12,13,14,15];
        $pages = cache()->remember(self::$cacheKey, 24 * 60 * 60, function () use ($pagesId) {
            return self::whereIn('id',$pagesId)
                ->get();
        });
 
        return $pages;
    }
     static function getFooterPages3()
    {
         $pagesId=[16,17];
        $pages = cache()->remember(self::$cacheKey.'2', 24 * 60 * 60, function () use ($pagesId) {
            return self::whereIn('id',$pagesId)
                ->get();
        });

        return $pages;
    }
}
