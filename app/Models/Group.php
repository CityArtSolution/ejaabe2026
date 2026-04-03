<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\BranchScope;

class Group extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function groupUsers()
    {
        return $this->hasMany('App\Models\GroupUser', 'group_id', 'id');
    }
      protected static function booted()
    {
        static::addGlobalScope(new BranchScope);
    }


    public function users()
    {
        return $this->hasMany('App\Models\GroupUser', 'id', 'group_id');
    }

    public function groupRegistrationPackage()
    {
        return $this->hasOne('App\Models\GroupRegistrationPackage', 'group_id', 'id');
    }

    public function commissions()
    {
        return $this->hasMany(UserCommission::class, 'user_group_id', 'id');
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
