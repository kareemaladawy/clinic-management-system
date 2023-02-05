<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


class Doctor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'doctors';

    protected $guarded = [];

    protected $hidden = ['password'];


    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function diagnosis()
    {
        return $this->hasMany(Diagnose::class);
    }

    public function scopePopular($query)
    {
        return $query->where('views', '>=', 5);
    }
}
