<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccupantProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course',
        'year_section',
        'home_address',
        'cellphone',
        'email',
        'birthday',
        'age',
        'religion',
        'scholarship',
        'blood_type',
        'allergies',
        'father_fullname',
        'father_phone',
        'mother_fullname',
        'mother_phone',
        'total_monthly',
    ];

    protected $casts = [
        'electrical_appliances' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
