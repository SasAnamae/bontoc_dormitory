<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
