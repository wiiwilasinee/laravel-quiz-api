<?php
namespace App\Services;

use App\Models\Quiz;
use Illuminate\Support\Collection;

class QuizService
{
    public function searchCollection(Collection $quizzes, string $search)
    {
        return $quizzes->filter(function(Quiz $quiz) use ($search){
            return str($quiz->name)->lower()->contains(str($search)->lower());
        });
    }
}