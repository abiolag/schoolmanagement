<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_code', 'title', 'subject', 'class_level', 'price', 'quantity_available'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity_available' => 'integer'
    ];

    public function bookTransactions()
    {
        return $this->hasMany(BookTransaction::class);
    }
}