<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScormSession extends Model
{
    protected $fillable = [
        'user_id', 'webinar_id', 'session_id', 'data', 'completed', 'score', 'initialized_at', 'last_interaction_at','quiz_result_id'
    ];

    protected $casts = [
        'data' => 'array',
        'initialized_at' => 'datetime',
        'last_interaction_at' => 'datetime',
        'completed' => 'boolean',
    ];
    
        public function webinar()
    {
        return $this->belongsTo(Webinar::class, 'webinar_id');
    }
}
