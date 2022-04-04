<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Quiz;
use App\Models\Question;

class QuestionTest extends TestCase
{
    protected function tearDown() : void
    {
        Quiz::truncate();
        parent::tearDown();
    }

    public function testValidationCreateQuestion()
    {
        $response = $this->postJson('/api/questions');
        $response->assertStatus(422);

        $response->assertInvalid(['quiz_id', 'content']);
    }

    public function testCreateQuestion()
    {
        $quiz = Quiz::factory()->create();
        $data = [
            'content' => 'Test Question',
            'message' => 'Test extra message',
            'quiz_id' => $quiz->id
        ];

        $response = $this->postJson('/api/questions', $data);
        $response->assertStatus(201);
        $response->assertJson(['message' => "Question Created"]);

    }

    public function testDeleteQuestion()
    {

        $question = Question::factory()->create();

        $response = $this->deleteJson('/api/questions/' . $question->id);
        $response->assertStatus(200);
        $response->assertJson(['message' => "Question Deleted"]);

        $this->assertDatabaseMissing('quizzes', [
            'id' => $question->id,
        ]);

    }
}
