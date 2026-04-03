<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\QuizzesQuestionsAnswer;
use Carbon\Carbon;

class EvalResultsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $results;
    protected $questions;

    public function __construct($results)
    {
        // رفع القيود
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $this->results = $results;

        // جمع كل الأسئلة من جميع النتائج بدون تكرار
        $allQuestions = collect();
        foreach ($results as $result) {
            $allQuestions = $allQuestions->merge($result->getQuestions());
        }

        // إزالة التكرار بناءً على ID وترتيبها
        $this->questions = $allQuestions->unique('id')->values();
    }

    public function collection()
    {
        return $this->results;
    }

    public function headings(): array
    {
        $headings = ['تاريخ الإجابة'];

        foreach ($this->questions as $ques) {
            $headings[] = $ques->title ?? '-';
        }

        return $headings;
    }

    public function map($result): array
    {
        $resArr = [];

        // تاريخ الإجابة
        $resArr[] = $result->created_at
            ? Carbon::parse($result->created_at)->format('Y-m-d H:i')
            : '-';

        // قراءة JSON بأمان
        try {
            $decoded = json_decode($result->results, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            $decoded = [];
            \Log::warning('Invalid JSON for result ID: ' . $result->id);
        }

        // ملء الإجابات بالترتيب الصحيح
        foreach ($this->questions as $question) {
            $answerTitle = '-';

            if (isset($decoded[$question->id]['answer'])) {
                $answerId = $decoded[$question->id]['answer'];
                $answer = QuizzesQuestionsAnswer::find($answerId);
                $answerTitle = $answer ? $answer->title : '-';
            } elseif (isset($decoded[$question->id]['written_answer'])) {
                $answerTitle = $decoded[$question->id]['written_answer'];
            }

            $resArr[] = $answerTitle;
        }

        return $resArr;
    }
}
