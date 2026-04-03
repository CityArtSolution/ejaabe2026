<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExamsResultsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->results;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            trans('اسم الاختبار'),
            trans('المجموعة'),
            trans('الجهة'),
            trans('التاريخ'),
            trans('اسم المتدرب'),
            trans('رقم المتدرب'),
            trans('عدد المحاولات'),
            trans('الدرجة'),
            trans('المحاولة'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($result): array
    {
                $userGroupName = $result->user->getUserGroup() ? $result->user->getUserGroup()->first()->name : 'N/A';

        return [
            $result->quiz->title,
            $userGroupName,
            $result->user->organization->full_name  ?? "" ,
            dateTimeformat($result->created_at, 'j F Y'),        
            $result->user->full_name ?? "",
            $result->user->id,
            $result->attempt_count,
            $result->max_grade,
           url("/panel/quizzes/".$result->max_grade_result_id."/result"),
        ];
    }
}
