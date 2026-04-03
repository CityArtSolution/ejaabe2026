<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\BranchScope;

class Contact extends Model
{
    protected $table = 'contacts';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];
    
    
      protected static function boot()
    {
        parent::boot();

       
        static::creating(function ($blog) {
            $blog->branch_id = session()->get('branch_id') ?? 1;
        });

       static::updating(function ($blog) {
        $blog->branch_id = session()->get('branch_id') ?? 1;
        });
    }
    
       protected static function booted()
    {
        static::addGlobalScope(new BranchScope);
    }

}


