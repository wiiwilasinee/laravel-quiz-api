<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\OptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('quizzes', QuizController::class);
Route::get('quizzes/{slug}/questions', [QuizController::class, 'showWithQuestions'])->name('quiz.questions');
Route::apiResource('questions', QuestionController::class)->only(['store', 'destroy']);
Route::apiResource('options', OptionController::class)->only(['store', 'destroy']);
Route::get('options/{option}/answer-check', [OptionController::class, 'checkAnswer'])->name('option.answer');

