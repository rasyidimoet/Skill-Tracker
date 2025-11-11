<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'category',
        'target_hours',
        'color',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function practiceSessions()
    {
        return $this->hasMany(PracticeSession::class);
    }

    public function getTotalPracticeTimeAttribute()
    {
        return $this->practiceSessions()->sum('minutes_practiced');
    }

    public function getTotalPracticeHoursAttribute()
    {
        return round($this->total_practice_time / 60, 1);
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->target_hours === 0) return 0;
        return min(100, round(($this->total_practice_hours / $this->target_hours) * 100));
    }
}