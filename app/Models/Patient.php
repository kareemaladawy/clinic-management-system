<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Patient extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'patients';

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function diagnosis()
    {
        return $this->hasMany(Diagnose::class);
    }
}
