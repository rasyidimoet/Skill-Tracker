<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticeSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill_id',
        'user_id',
        'session_date',
        'minutes_practiced',
        'what_was_practiced',
        'notes',
        'confidence_level'
    ];

    protected $casts = [
        'session_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function getPracticeHoursAttribute()
    {
        return round($this->minutes_practiced / 60, 2);
    }
}