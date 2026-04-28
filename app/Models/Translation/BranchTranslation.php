<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Model;

class BranchTranslation extends Model
{
    protected $table = 'branch_translations';
    public $timestamps = false;
    protected $dateFormat = 'U';
//    protected $guarded = ['id'];
    protected $fillable = [
        'branch_id',
        'name',
        'address',
        'locale'
    ];
}
