<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OptionRequest;
use App\Models\Option;
use App\Http\Resources\AnswerResource;


class OptionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  OptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OptionRequest $request)
    {
        $option = Option::create($request->all());
        return response(['message' => "Option Created"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Option  $option
     * @return \Illuminate\Http\Response
     */
    public function destroy(Option $option)
    {
        $option->delete();
        return response(['message' => "Option Deleted"]);
    }


     /**
     * Display the answer resource.
     *
     * @param  Option  $option
     * @return \Illuminate\Http\Response
     */
    public function checkAnswer(Option $option)
    {
        if($option->is_correct === false)
        {
            $option->load('question');
        }
        return response()->json(
            new AnswerResource($option)
        );
    }
}
