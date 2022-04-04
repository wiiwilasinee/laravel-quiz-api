<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;

class QuizTest extends TestCase
{

    public function tearDown() : void
    {
        Quiz::truncate();
        parent::tearDown();
    }

    public function testValidateRequestCreateQuiz()
    {
        $response = $this->postJson('/api/quizzes');
        $response->assertStatus(422);
        $response->assertInvalid([
            'name' => 'The name field is required.',
        ]);
    }

    public function testCreateQuiz()
    {
        $data = [
            'name' => $name = "Test quiz"
        ];

        $response = $this->postJson('/api/quizzes', $data);
        $response->assertStatus(201);
        $response->assertJson(['message' => "Quiz Created"]);

        $this->assertEquals($response['data']['slug'], "test-quiz");

    }

    public function testUpdateQuiz()
    {
        $quiz = Quiz::factory()->create();

        $data = [
            'name' => $name = "Test Update Quiz"
        ];
        $response = $this->patchJson('/api/quizzes/' . $quiz->id  , $data);
        $response->assertStatus(200);
        $response->assertJson(['message' => "Quiz Updated"]);

        $this->assertEquals($response['data']['slug'], $quiz->slug);
    }

    public function testDeleteQuiz()
    {
        $quiz = Quiz::factory()->create();

        $this->assertDatabaseHas('quizzes', [
            'slug' => $quiz->slug,
        ]);

        $response = $this->deleteJson('/api/quizzes/' . $quiz->id);
        $response->assertStatus(200);
        $response->assertJson(['message' => "Quiz Deleted"]);

        $this->assertDatabaseMissing('quizzes', [
            'slug' => $quiz->slug,
        ]);
    }

    public function testGettingAllQuizzes()
    {
        $response = $this->getJson('/api/quizzes');
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            '*' => [ 'id', 'name', 'slug' ]
        ]);
    }

    public function testGettingAQuiz()
    {
        $quiz = Quiz::factory()->create();

        $response = $this->getJson('/api/quizzes/' . $quiz->id);
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'id', 'name', 'slug'
        ]);
    }

    public function testGettingAQuizWithQuestions()
    {
        $quiz = Quiz::factory()
            ->has(
                Question::factory()->has(
                    Option::factory()->count(4)
                )->count(3)
            )
            ->create();
        
        $response = $this->getJson('/api/quizzes/' . $quiz->slug . '/questions');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'slug', 'name',
            'questions' => [
                '*' => [
                    'content', 'message',
                    'options' => [
                        '*' => [
                            'content'
                        ]
                    ]
                ]
            ]
        ]);
    }

    
}
