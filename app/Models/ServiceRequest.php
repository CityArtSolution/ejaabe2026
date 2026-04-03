<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Modules\CourseSetting\Entities\Course;
use App\Models\OrganizationCourse;

class ServiceRequest extends Model
{
    protected $table = 'service_requests';

    protected $fillable = ['name', 'email', 'phone', 'description', 'type','course_id'];


     public function scopeByBranch($query)
    {
        if (session()->has('admin_selected_branch')) {
            return $query->where('branch_id', session()->get('admin_selected_branch') ?? 1);
        } elseif (session()->has('branch_id')) {
            return $query->where('branch_id', session()->get('branch_id') ?? 1);
        }

        return $query;
    }
    // Define the valid enum values for the 'type' field
/*
    public function getTypeAttribute($value)
    {
        return ucfirst($value);
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = strtolower($value);
    }*/
public function webinar()
{
    return $this->belongsTo(Webinar::class, 'course_id');
}
}

