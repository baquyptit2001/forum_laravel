<?php

namespace App\Http\Resources;

use App\Models\QuestionVote;
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
        $vote_up = '';
        $vote_down = '';
        if (auth('sanctum')->user()) {
            $votee = QuestionVote::where('question_id', $this->id)
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
            'title' => $this->title,
            'slug' => $this->slug,
            'question' => $this->question,
            'user' => $this->user,
            'user_id' => $this->user_id,
            'username' => $this->user->profile->display_name,
            'avatar' => env('APP_URL') . $this->user->profile->avatar,
            'status' => $this->status,
            'date_created' => $this->date_created,
            'date_created_full' => $this->date_created_full,
            'views' => $this->views,
            'vote' => $this->vote_count,
            'answers' => AnswerResource::collection($this->answer->where('id', '!=', $this->best_answer_id)),
            'answer_count' => count($this->answer),
            'best_answer' => AnswerResource::make($this->best_answer),
            'vote_up' => $vote_up,
            'vote_down' => $vote_down,
        ];
    }
}
