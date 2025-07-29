<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentReport extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'title', 'message', 'admin_response', 'status'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
