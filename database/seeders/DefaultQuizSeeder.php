<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quiz;

class DefaultQuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quiz = new Quiz;
        $quiz->name = "Family Quiz";
        $quiz->save();

        $question1 = $quiz->questions()->create([
            'content' => "Who is the Special in the Lego Movie",
        ]);

        $question1->options()->createMany([
            ['content' => "Batman"],
            ['content' => "Emmet Brickowski", 'is_correct' => true],
            ['content' => "MetalBeard"],

        ]);

        $question2 = $quiz->questions()->create([
            'content' => "What colour are most buses in London",
        ]);

        $question2->options()->createMany([
            ['content' => "Red", 'is_correct' => true],
            ['content' => "Orange"],
            ['content' => "Blue"],
            ['content' => "White"],

        ]);

        $question3 = $quiz->questions()->create([
            'content' => "How many planets are in our solar system",
        ]);

        $question3->options()->createMany([
            ['content' => "Seven"],
            ['content' => "Two"],
            ['content' => "Eight", 'is_correct' => true],
            ['content' => "Nine"],

        ]);

        $question4 = $quiz->questions()->create([
            'content' => "What is taller, an elephant or a giraffe",
            'message' => "They are the tallest animal and can grow up to nearly six metres tall!",
        ]);

        $question4->options()->createMany([
            ['content' => "Giraffe", 'is_correct' => true],
            ['content' => "Elephant"],

        ]);
    }
}
