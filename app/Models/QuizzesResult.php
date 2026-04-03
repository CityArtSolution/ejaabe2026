<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizzesResult extends Model
{
    static $passed = 'passed';
    static $failed = 'failed';
    static $waiting = 'waiting';

    public $timestamps = false;

    protected $guarded = ['id'];

    public function quiz()
    {
        return $this->belongsTo('App\Models\Quiz', 'quiz_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }


    public function getQuestions()
    {
        $quiz = $this->quiz;

        if ($quiz->display_limited_questions and !empty($quiz->display_number_of_questions)) {

            $results = json_decode($this->results, true);
            $quizQuestionIds = [];

            if (!empty($results)) {
                foreach ($results as $id => $v) {
                    if (is_numeric($id)) {
                        $quizQuestionIds[] = $id;
                    }
                }
            }

            $quizQuestions = $quiz->quizQuestions()->whereIn('id',$quizQuestionIds)->get();
        } else {
            $quizQuestions = $quiz->quizQuestions;
        }

        return $quizQuestions;
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
