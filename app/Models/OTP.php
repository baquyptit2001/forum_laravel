<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;

    protected $fillable = [
        'OTP', 
        'user_id', 
        'status'
    ];

    protected $appends = [
        'OTP', 
        'user_id', 
        'status',
        'expired'
    ];

    public function getExpiredAttribute()
    {
        return $this->created_at->addMinutes(5) > $this->created_at;
    }
}
