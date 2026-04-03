<?php

namespace App\Models;
use App\Mixins\Certificate\MakeCertificate;
use App\Models\Traits\CascadeDeletes;
use App\User;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Jorenvh\Share\ShareFacade;
use Spatie\CalendarLinks\Link;
class Event  extends Model
{
      use Translatable;
       protected $table = 'events';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];
   protected $casts = [
    'what_you_will_learn' => 'array',
    'event_content' => 'array',
   
    'price' => 'float',
    'status' => 'boolean',
];

protected $dates = [
    
    'created_at',
    'updated_at'
];


        public $translatedAttributes = ['title', 'location', 'what_you_will_learn','event_content','details'];

  public function getTitleAttribute()
    {
        return getTranslateAttributeValue($this, 'title');
    }
    
      public function getLocationAttribute()
    {
        return getTranslateAttributeValue($this, 'location');
    }
    
    
 public function getWhatYouWillLearnAttribute()
    {
     return getTranslateAttributeValue($this, 'what_you_will_learn');

    }
    public function getLocale()
    {
        // Get the current locale
        $locale = config('app.locale');
        
        return $locale;
    }

   public function getUrl()
    {
        return url('/'.$this->getLocale().'/event/' . $this->slug);
    }

      public function getEventcontentAttribute()
    {
        return getTranslateAttributeValue($this, 'event_content');
    }
       public function getDetailsAttribute()
    {
        return getTranslateAttributeValue($this, 'details');
    }
    


    
    
/*
public function speakers()
    {
        return $this->hasMany(Speaker::class);
    }

public function reviews()
{
    return $this->hasMany(Review::class);
}

public function reservations()
{
    return $this->hasMany(Reservation::class);
}*/
 public static function boot()
    {
        parent::boot();
           static::saving(function ($event) {
            $event->generateSlug();
        });
        
        
        self::creating(function ($model) {
            $model->branch_id = session()->get('branch_id') ?? 1;
        });
        self::updating(function ($model) {
            $model->branch_id = session()->get('branch_id')?? 1;
        });
        
    }
    
     protected function generateSlug()
{
    $slug = $this->generateSlugFromTitle($this->title);
    
    if (static::whereSlug($slug)->where('id', '!=', $this->id)->exists()) {
        $slug = $this->generateUniqueSlug($slug);
    }
    
    $this->slug = $slug;
}

protected function generateSlugFromTitle($title)
{
    $slug = \Str::slug($title);
    
    // If the slug is empty (e.g., only Arabic characters), generate a random slug
    if (empty($slug)) {
        $slug = $this->generateRandomSlug();
    }
    
    return $slug;
}

protected function generateUniqueSlug($slug, $count = 0)
{
    $newSlug = $slug;
    
    if ($count > 0) {
        $newSlug .= '-' . $count;
    }
    
    if (static::whereSlug($newSlug)->where('id', '!=', $this->id)->exists()) {
        return $this->generateUniqueSlug($slug, $count + 1);
    }
    
    return $newSlug;
}

protected function generateRandomSlug()
{
    $randomSlug = \Str::random(10);
    
    // Ensure the random slug is unique
    while (static::whereSlug($randomSlug)->where('id', '!=', $this->id)->exists()) {
        $randomSlug = \Str::random(10);
    }
    
    return $randomSlug;
}

public function registrations()
{
    return $this->hasMany(EventRegistration::class);
}

    public function addToCalendarLink()
    {

        $date = \DateTime::createFromFormat('j M Y H:i', dateTimeFormat($this->start_date, 'j M Y H:i', false));

        $link = Link::create($this->title, $date, $date); //->description('Cookies & cocktails!')

        return $link->google();
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
