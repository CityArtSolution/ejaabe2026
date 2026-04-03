<?php

namespace App\Models\Translation;


use Illuminate\Database\Eloquent\Model;

class SliderTranslation extends Model
{

    protected $table = 'slider_translations';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];
}
