<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'question',
        'slug',
    ];

    protected $appends = [
        'date_created',
        'date_created_full',
        'status',
        'vote_count'
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answer(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function votes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(QuestionVote::class, 'question_id');
    }

    public function getDateCreatedAttribute()
    {
        return $this->created_at->shortRelativeDiffForHumans();
    }

    public function getDateCreatedFullAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getVoteCountAttribute(): int
    {
        return $this->votes()->where('vote', true)->count() - $this->votes()->where('vote', false)->count();
    }

    public function getStatusAttribute() {
        $array = ['', 'answered-accepted', 'answered'];
        return array_random($array);
    }
}
