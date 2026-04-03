<?php

namespace App\Imports;

use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\Translation\QuizzesQuestionTranslation;
use App\Models\QuizzesQuestionsAnswer;
use App\Models\Translation\QuizzesQuestionsAnswerTranslation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuizQuestionsImport implements ToModel, WithHeadingRow
{
    protected $quizId;
    protected $supportedLocales = ['ar', 'en'];

    public function __construct($quizId)
    {
        $this->quizId = $quizId;
    }

    private function getTranslationContent($row, $field, $locale)
    {
        $content = $row["{$field}_{$locale}"] ?? null;
        
        if (empty($content)) {
            // If content is empty for the current locale, get content from the other locale
            $otherLocale = ($locale === 'ar') ? 'en' : 'ar';
            $content = $row["{$field}_{$otherLocale}"] ?? null;
        }

        return $content;
    }

    private function isCorrectAnswer($correctAnswers, $currentNumber)
    {
        if (empty($correctAnswers)) {
            return false;
        }

        // Handle both single number and comma-separated numbers
        if (strpos($correctAnswers, ',') !== false) {
            // Multiple correct answers
            $correctAnswerArray = array_map('trim', explode(',', $correctAnswers));
            return in_array((string)$currentNumber, $correctAnswerArray);
        } else {
            // Single correct answer
            return (string)$correctAnswers === (string)$currentNumber;
        }
    }

    public function model(array $row)
    {
        if (empty(array_filter($row))) {
            return null; // Return null to skip the row
        }
    
        $quiz = Quiz::findOrFail($this->quizId);
        $creator = $quiz->creator;
        $order = QuizzesQuestion::query()->where('quiz_id', $quiz->id)->count() + 1;

        // Create question
        $quizQuestion = QuizzesQuestion::create([
            'quiz_id' => $this->quizId,
            'creator_id' => $creator->id,
            'grade' => $row['grade'],
            'type' => $row['type'],
            'image' => $row['image'] ?? null,
            'video' => $row['video'] ?? null,
            'order' => $order,
            'created_at' => time()
        ]);

        // Create question translations for each locale
        foreach ($this->supportedLocales as $locale) {
            $title = $this->getTranslationContent($row, 'title', $locale);
            $correct = $this->getTranslationContent($row, 'correct_answer', $locale);

            if ($title) {
                QuizzesQuestionTranslation::updateOrCreate([
                    'quizzes_question_id' => $quizQuestion->id,
                    'locale' => mb_strtolower($locale),
                ], [
                    'title' => $title,
                    'correct' => $correct,
                ]);
            }
        }

        $quiz->increaseTotalMark($quizQuestion->grade);

        // Handle multiple choice answers
        if ($quizQuestion->type == QuizzesQuestion::$multiple) {
            for ($i = 1; $i <= 10; $i++) {
                $hasAnswer = false;
                $answerContents = [];
                $feedbackContents = [];

                // Get answer content and feedback for each locale with fallback
                foreach ($this->supportedLocales as $locale) {
                    $answerContent = $this->getTranslationContent($row, "answer_{$i}", $locale);
                    $feedbackContent = $this->getTranslationContent($row, "feedback_{$i}", $locale);
                    
                    if ($answerContent) {
                        $hasAnswer = true;
                        $answerContents[$locale] = $answerContent;
                        $feedbackContents[$locale] = $feedbackContent;
                    }
                }

                if ($hasAnswer) {
                    $questionAnswer = QuizzesQuestionsAnswer::create([
                        'question_id' => $quizQuestion->id,
                        'creator_id' => $creator->id,
                        'image' => $row["answer_{$i}_image"] ?? null,
                        'correct' => $this->isCorrectAnswer($row['correct_answer_number'], $i),
                        'created_at' => time()
                    ]);

                    // Create answer translations with feedback
                    foreach ($this->supportedLocales as $locale) {
                        // If content doesn't exist for this locale, use content from the other locale
                        $content = $answerContents[$locale] ?? $answerContents[($locale === 'ar') ? 'en' : 'ar'] ?? null;
                        $feedback = $feedbackContents[$locale] ?? $feedbackContents[($locale === 'ar') ? 'en' : 'ar'] ?? null;

                        if ($content) {
                            QuizzesQuestionsAnswerTranslation::updateOrCreate([
                                'quizzes_questions_answer_id' => $questionAnswer->id,
                                'locale' => mb_strtolower($locale),
                            ], [
                                'title' => $content,
                                'feedback' => $feedback,
                            ]);
                        }
                    }
                }
            }
        }

        return $quizQuestion;
    }
}