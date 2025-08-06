<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_year',
        'full_name',
        'course',
        'year_section',
        'emergency_contact_name',
        'emergency_contact_address',
        'emergency_contact_number',
        'student_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}