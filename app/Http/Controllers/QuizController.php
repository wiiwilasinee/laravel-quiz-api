<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Http\Resources\QuizResource;
use App\Http\Resources\QuizQuestionsResource;
use App\Models\Quiz;
use App\Events\QuizUpdatedEvent;
use Illuminate\Http\Request;
use App\Services\QuizService;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, QuizService $service)
    {
        $quizzes = \Cache::remember('quizzes', 60*30, function() {
            return Quiz::all();
        });

        if($search = $request->search)
        {
            $quizzes = $service->searchCollection($quizzes, $search);
        }

        return response(QuizResource::collection($quizzes));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  QuizRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizRequest $request)
    {
        $quiz = Quiz::create($request->all());
        event(new QuizUpdatedEvent());
        return response([
            'message' => "Quiz Created",
            'data' => new QuizResource($quiz),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        return response(new QuizResource($quiz));
    }

     /**
     * Display the specified resource with relations.
     *
     * @param  String  $slug
     * @return \Illuminate\Http\Response
     */
    public function showWithQuestions(string $slug)
    {
        $quiz = Quiz::where('slug', $slug)->with('questions','questions.options')->firstOrFail();
        return response()->json(
            new QuizQuestionsResource($quiz)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  QuizRequest  $request
     * @param  Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(QuizRequest $request, Quiz $quiz)
    {
        $quiz->update($request->all());
        event(new QuizUpdatedEvent());
        return response([
            'message' => "Quiz Updated",
            'data' => new QuizResource($quiz),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return response(['message' => "Quiz Deleted"]);
    }
}
