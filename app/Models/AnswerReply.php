<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerReply extends Model
{
    use HasFactory;

    protected $appends = ['date_created', 'replier'];

    protected $fillable = [
        'answer_id',
        'user_id',
        'body',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getReplierAttribute(): string
    {
        return User::where('id', $this->user_id)->first()->username;
    }

    public function getDateCreatedAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
