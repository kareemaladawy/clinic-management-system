<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $table = 'slots';

    protected $guarded = [];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('state', 'available');
    }

    public function scopeTaken($query)
    {
        return $query->where('state', 'taken');
    }
}
