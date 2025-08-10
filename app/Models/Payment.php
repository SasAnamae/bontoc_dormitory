<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentsExport;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_month',
        'amount',
        'dorm_fee',
        'appliances',
        'appliance_fee',
        'or_number',
        'paid_at',
        'receipt_photo',
        'status',
    ];

    protected $casts = [
    'paid_at' => 'datetime',
    ];


    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
        
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeWithCashier($query)
    {
        return $query->with('cashier');
    }
    public function download()
    {
        return Excel::download(new PaymentsExport, 'payments.xlsx');
    }
}
