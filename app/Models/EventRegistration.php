<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'name',
        'phone',
        'email',
        'company',
        'notes',
       
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the event that the registration belongs to.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
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

    /*
     public static function boot()
    {
        parent::boot();
        
        
        self::creating(function ($model) {
            $model->branch_id = session()->get('branch_id') ?? 1;
        });
        self::updating(function ($model) {
            $model->branch_id = session()->get('branch_id')?? 1;
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
    }*/
}