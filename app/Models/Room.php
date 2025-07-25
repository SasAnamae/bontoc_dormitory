<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
     
   protected $fillable = [
        'dormitory_id',
        'name',
        'photo',
        'total_beds',
        'bed_type',
        'num_decks',
        'occupied_beds',
        'available_beds',
    ];

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class);
    }

    public function beds()
    {
        return $this->hasMany(Bed::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
