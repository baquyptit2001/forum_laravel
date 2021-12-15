<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'answer', 'user_id'];
    protected $appends = ['vote_count'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reply()
    {
        return $this->hasMany(AnswerReply::class, 'answer_id');
    }

    public function getVoteCountAttribute()
    {
        return AnswerVote::where('answer_id', $this->id)->sum('vote');
    }

}
