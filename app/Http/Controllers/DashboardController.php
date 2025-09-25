<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Payment;
use App\Models\BookTransaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalPayments = Payment::sum('amount');
        $pendingBooks = BookTransaction::where('status', 'pending')->count();
        $collectedBooks = BookTransaction::where('status', 'collected')->count();
        
        $recentPayments = Payment::with('student')
            ->orderBy('payment_date', 'desc')
            ->take(5)
            ->get();
            
        $pendingDeliveries = BookTransaction::with(['student', 'book'])
            ->where('status', 'pending')
            ->orderBy('transaction_date', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalStudents', 
            'totalPayments', 
            'pendingBooks',
            'collectedBooks',
            'recentPayments',
            'pendingDeliveries'
        ));
    }
}