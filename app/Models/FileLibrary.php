<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileLibrary extends Model
{
    use HasFactory;

    protected $table = 'file_library';

    protected $fillable = [
        'name',
        'details',
        'file_path',
    ];
}
