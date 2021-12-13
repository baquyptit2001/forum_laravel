<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'question' => $this->question,
            'user' => $this->user->username,
            'status' => $this->status,
            'date_created' => $this->date_created,
            'date_created_full' => $this->date_created_full,
            'views' => $this->views,
            'vote' => $this->vote_count,
            'answers' => AnswerResource::collection($this->answer),
            'answer_count' => count($this->answer),
        ];
    }
}
