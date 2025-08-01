<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DormitoryAgreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agreement_text',
        'date_signed',
        'student_name',
        'course_year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
