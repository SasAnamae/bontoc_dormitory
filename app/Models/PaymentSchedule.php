<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PaymentSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rate', 'due_date','additional_fee', 'total_due'];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'schedule_id');
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'payment_schedule_user')
                    ->withPivot('additional_fee')
                    ->withPivot('total_due')
                    ->withTimestamps();
    }

}
