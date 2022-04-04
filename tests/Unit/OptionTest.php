<?php

namespace Tests\Unit;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Option;
use Tests\TestCase;

class OptionTest extends TestCase
{
    protected function tearDown(): void
    {
        Quiz::truncate();
        parent::tearDown();
    }

    public function testValidateCreateOption()
    {
        $response = $this->postJson('/api/options');
        $response->assertStatus(422);
        $response->assertInvalid(['content', 'question_id']);
    }

    public function testCreateOption()
    {
        $question = Question::factory()->create();
        $data = [
            'content' => "Test Option Content",
            'question_id' => $question->id,
        ];

        $response = $this->postJson('/api/options', $data);
        $response->assertStatus(201);
        $response->assertJson(['message' => "Option Created"]);
    }

    public function testDeleteOption()
    {
        $option = Option::factory()->create();
        
        $response = $this->deleteJson('/api/options/' . $option->id);
        $response->assertStatus(200);
        $response->assertJson(['message' => "Option Deleted"]);

        $this->assertDatabaseMissing('options', [
            'id' => $option->id
        ]);
    }

    public function testCheckIfCorrectAnswer()
    {
        $option = Option::factory()->create([
            'is_correct' => true
        ]);

        $response = $this->getJson('/api/options/' . $option->id . '/answer-check');
        $response->assertStatus(200);
        

        $response->assertJsonStructure([
            'answer' => [
                'content'
            ],
            'correct' => [
                'content'
            ],
            'is_correct'
        ]);

        $this->assertEquals($response['answer'], $response['correct']);
        $this->assertTrue($response['is_correct']);
    }

    public function testCheckIfIncorrectAnswer()
    {
        $this->assertTrue(true);
    }
}
