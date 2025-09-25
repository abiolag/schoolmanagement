<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'amount', 'payment_date', 'payment_type',
        'payment_method', 'description', 'receipt_number'
    ];

    // Add this to fix date formatting issues
    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}