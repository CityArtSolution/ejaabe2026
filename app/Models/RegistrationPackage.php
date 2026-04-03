<?php

namespace App\Models;

use App\Mixins\RegistrationPackage\UserPackage;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class RegistrationPackage extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'registration_packages';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];
protected $casts = [
    'webinar_ids' => 'array'
];
    public $translatedAttributes = ['title', 'description'];

    public function getTitleAttribute()
    {
        return getTranslateAttributeValue($this, 'title');
    }

    public function getDescriptionAttribute()
    {
        return getTranslateAttributeValue($this, 'description');
    }

    public function sales()
    {
        return $this->hasMany('App\Models\Sale','registration_package_id','id');
    }


    public function activeSpecialOffer()
    {
        $activeSpecialOffer = SpecialOffer::where('registration_package_id', $this->id)
            ->where('status', SpecialOffer::$active)
            ->where('from_date', '<', time())
            ->where('to_date', '>', time())
            ->first();

        return $activeSpecialOffer ?? false;
    }

    public function getPrice()
    {
        $price = $this->price;

        $specialOffer = $this->activeSpecialOffer();
        if (!empty($specialOffer)) {
            $price = $price - ($price * $specialOffer->percent / 100);
        }

        return $price;
    }
    
      public function webinars()
    {
        return $this->belongsToMany(Webinar::class, null, 'webinar_ids')
            ->using(\DB::raw('JSON_CONTAINS(webinar_ids, CAST(id as JSON))'));
    }
}
