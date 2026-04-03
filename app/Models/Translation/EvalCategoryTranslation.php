<?php

namespace App\Models\Translation;


use Illuminate\Database\Eloquent\Model;

class EvalCategoryTranslation extends Model
{

    protected $table = 'eval_category_translations';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];
}
