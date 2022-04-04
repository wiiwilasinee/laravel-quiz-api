<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OptionResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->is_correct) {
            $correctAnswer = $this;
        } else {
            $correctAnswer = $this->question->options()->correct()->first();
        }
        return [
            'answer' => new OptionResource($this),
            'correct' => $correctAnswer ? new OptionResource($correctAnswer) : null,
            'is_correct' => $this->is_correct
        ];
    }
}
