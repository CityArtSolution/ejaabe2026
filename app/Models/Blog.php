<?php

namespace App\Models;

use App\Models\Traits\CascadeDeletes;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Jorenvh\Share\ShareFacade;
use App\Scopes\BranchScope;

class Blog extends Model implements TranslatableContract
{
    use Translatable;
    use Sluggable;
    use CascadeDeletes;

    protected $table = 'blog';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];

    public $morphsFunctions = ['productBadgeContent', 'deleteRequest'];
    public $translatedAttributes = ['title', 'description', 'meta_description', 'content'];

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
        return $this->belongsTo('App\Models\BlogCategory', 'category_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'blog_id', 'id');
    }

    public function deleteRequest()
    {
        return $this->morphOne(ContentDeleteRequest::class, 'targetable');
    }

    public function productBadgeContent()
    {
        return $this->morphMany(ProductBadgeContent::class, 'targetable');
    }

public function getLocale()
    {
        // Get the current locale
        $locale = config('app.locale');
        
        return $locale;
    }
    public function getUrl()
    {
        return '/'.$this->getLocale().'/blog/' . $this->slug;
    }

    public function getTitleAttribute()
    {
        return getTranslateAttributeValue($this, 'title');
    }

    public function getDescriptionAttribute()
    {
        return getTranslateAttributeValue($this, 'description');
    }

    public function getMetaDescriptionAttribute()
    {
        return getTranslateAttributeValue($this, 'meta_description');
    }

    public function getContentAttribute()
    {
        return getTranslateAttributeValue($this, 'content');
    }

    public function getShareLink($social)
    {
        $link = ShareFacade::page(url($this->getUrl()), $this->title)
            ->facebook()
            ->twitter()
            ->whatsapp()
            ->telegram()
            ->getRawLinks();

        return !empty($link[$social]) ? $link[$social] : '';
    }
    
    protected static function boot()
    {
        parent::boot();

       
        static::creating(function ($blog) {
            $blog->branch_id = session()->get('admin_selected_branch') ?? 1;
        });

       static::updating(function ($blog) {
        $blog->branch_id = session()->get('admin_selected_branch') ?? 1;
        });
    }
       public function scopeByBranch($query)
    {
        if (session()->has('admin_selected_branch')) {
            return $query->where('branch_id', session()->get('admin_selected_branch'));
        } elseif (session()->has('branch_id')) {
            return $query->where('branch_id', session()->get('branch_id'));
        }

        return $query;
    }
}
