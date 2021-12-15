<?php

namespace App\Http\Resources;

use App\Models\AnswerVote;
use Illuminate\Http\Resources\Json\JsonResource;

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
        $vote_up = '';
        $vote_down = '';
        if (auth('sanctum')->user()) {
            $votee = AnswerVote::where('answer_id', $this->id)
                ->where('user_id', auth('sanctum')->user()->id)
                ->first();
            if ($votee) {
                if($votee->vote == 1){
                    $vote_up = 'upvote-on';
                } else {
                    $vote_down = 'downvote-on';
                }
            }
        }
        return [
            'id' => $this->id,
            'user' => UserResource::make($this->user),
            'answer' => $this->answer,
            'created_at' => $this->created_at->diffForHumans(),
            'reply' => $this->reply,
            'vote' => $this->vote_count,
            'vote_up' => $vote_up,
            'vote_down' => $vote_down,
        ];
    }
}
