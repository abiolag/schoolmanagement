<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('student')->orderBy('payment_date', 'desc')->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
{
    $students = Student::all();
    $selectedStudent = request('student_id');
    
    return view('payments.create', compact('students', 'selectedStudent'));
}

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_type' => 'required|string',
            'payment_method' => 'required|string',
            'description' => 'nullable|string'
        ]);

        // Generate receipt number
        $receiptNumber = 'RCPT' . date('Ymd') . str_pad(Payment::count() + 1, 4, '0', STR_PAD_LEFT);

        Payment::create([
            'student_id' => $request->student_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'payment_type' => $request->payment_type,
            'payment_method' => $request->payment_method,
            'description' => $request->description,
            'receipt_number' => $receiptNumber
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully!');
    }

    public function show(Payment $payment)
    {
        $payment->load('student');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $students = Student::all();
        return view('payments.edit', compact('payment', 'students'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_type' => 'required|string',
            'payment_method' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $payment->update($request->all());

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully!');
    }
}