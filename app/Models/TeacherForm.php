<?php

namespace App\Models;

use App\User;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class TeacherForm extends Model
{
    protected $table = "teacher_form";
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];


     
}
