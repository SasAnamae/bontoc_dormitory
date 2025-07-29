<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'message', 'audience'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

}
