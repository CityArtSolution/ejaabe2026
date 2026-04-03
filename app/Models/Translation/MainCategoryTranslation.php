<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Model;

class MainCategoryTranslation extends Model
{
    protected $table = 'maincategory_translations';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];
}
