<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function practiceSessions()
    {
        return $this->hasMany(PracticeSession::class);
    }

    public function getTotalPracticeTimeAttribute()
    {
        return $this->practiceSessions()->sum('minutes_practiced');
    }
}