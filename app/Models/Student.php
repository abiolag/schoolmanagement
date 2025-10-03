<?php
// app/Models/Student.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
    'student_id', 'first_name', 'last_name', 'date_of_birth',
    'gender', 'parent_name', 'parent_phone', 'parent_email', // parent_email is included but optional
    'address', 'enrollment_date', 'class_level'
     ];

    // Add date casting
    protected $casts = [
        'date_of_birth' => 'date',
        'enrollment_date' => 'date'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function bookTransactions()
    {
        return $this->hasMany(BookTransaction::class);
    }

    // Use accessor for total_paid with default value
    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('amount') ?? 0;
    }

    // Use accessor for total_book_cost with default value
    public function getTotalBookCostAttribute()
    {
        return $this->bookTransactions()->sum('total_amount') ?? 0;
    }

    public function getBalanceAttribute()
    {
        return $this->total_paid - $this->total_book_cost;
    }

    public function getPendingBooksAttribute()
    {
        return $this->bookTransactions()->where('status', 'pending')->count();
    }



        public function getBookOrdersAttribute()
    {
        return $this->bookTransactions()->with('book')->get();
    }



    public function getDeliveredBooksAttribute()
    {
        return $this->bookTransactions()->where('status', 'collected')->count();
    }
    }