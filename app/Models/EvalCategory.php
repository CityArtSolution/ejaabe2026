<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class EvalCategory extends Model implements TranslatableContract
{
    use Translatable;
    use Sluggable;

    protected $table = 'eval_categories';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];
    public $translatedAttributes = ['title'];

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

    public static function makeSlug($title)
    {
        return SlugService::createSlug(self::class, 'slug', $title);
    }

    public function getTitleAttribute()
    {
        return getTranslateAttributeValue($this, 'title');
    }
     
      public function QuestionsCategories()
    {
        return $this->hasMany('App\Models\QuizzesQuestion', 'grade', 'id');
    }

}
