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

class Slider extends Model
{
    use Translatable;
    use CascadeDeletes;

    protected $table = 'sliders';
    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
        'image',
        'button1_title',
        'button1_link',
        'button2_title',
        'button2_link',
        'status'
    ];
    protected $casts = [
        'status' => 'boolean'
    ];
    public $translatedAttributes = ['title', 'description', 'button1_title', 'button2_title','button1_link','button2_link'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
  
       protected static function booted()
    {
        static::addGlobalScope(new BranchScope);
    }


    public function getTitleAttribute()
    {
        return getTranslateAttributeValue($this, 'title');
    }

    public function getDescriptionAttribute()
    {
        return getTranslateAttributeValue($this, 'description');
    }

    public function getButton1TitleAttribute()
    {
        return getTranslateAttributeValue($this, 'button1_title');
    }

    public function getButton1LinkAttribute()
    {
        return getTranslateAttributeValue($this, 'button1_link');
    }

    public function getButton2TitleAttribute()
    {
        return getTranslateAttributeValue($this, 'button2_title');
    }

    public function getButton2LinkAttribute()
    {
        return getTranslateAttributeValue($this, 'button2_link');
    }

   /* public function getContentAttribute()
    {
        return getTranslateAttributeValue($this, 'content');
    }*/
    
    
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
