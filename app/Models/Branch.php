<?php


namespace App\Models;

use App\Models\Traits\CascadeDeletes;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Jorenvh\Share\ShareFacade;
use App\User;


class Branch extends Model
{

    use Translatable;
    use CascadeDeletes;
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];

    static $cacheKey = 'branches';
    protected $casts = [
        'status' => 'boolean',
    ];
    protected $fillable = [

        'slug',
        'address',
        'subdomain',
        'phone_number',
        'email',
        'currency',
        'location',
        'home_page',
        'status',
    ];

       public $translatedAttributes = ['name', 'address'];

    public function webinars()
{
    return $this->belongsToMany(Webinar::class)
                ->withTimestamps();
}
       public function getNameAttribute()
    {
        return getTranslateAttributeValue($this, 'name');
    }

    public function getAddressAttribute()
    {
        return getTranslateAttributeValue($this, 'address');
    }
     public function users()
    {
        return $this->hasMany(User::class);
    }

    public function isTranslationDirty($translation): bool
    {
        return false;
    }


    /*
     public function courses()
    {
        return $this->hasMany(Course::class);
    }
     public function branchCourses()
    {
        return $this->belongsToMany(Course::class);
    }

        public function benfits() :float
    {
    //dd($this->courseEnrolled()->get()->sum('reveune'));
       return $this->courseEnrolled()->sum('purchase_price') - $this->courseEnrolled()->sum('reveune');
    }


    public function students()
    {
        return $this->hasMany(User::class)->where('role_id',3);
    }

    public function courseEnrolled()
    {
        return $this->hasMany(CourseEnrolled::class);
    }

        public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    */

}
