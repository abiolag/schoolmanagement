<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookTransaction;
use App\Models\Student;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_code' => 'required|unique:books',
            'title' => 'required',
            'subject' => 'required',
            'class_level' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:0'
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    public function show(Book $book)
    {
        $book->load('bookTransactions.student');
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'subject' => 'required',
            'class_level' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:0'
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }

    // Book Transactions (Issuing books to students)
    public function showIssueForm()
    {
        $students = Student::all();
        $books = Book::all();
        $selectedStudent = request('student_id');
        
        return view('books.issue', compact('students', 'books', 'selectedStudent'));
    }

    public function issueBook(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date'
        ]);

        $book = Book::find($request->book_id);

        if ($book->quantity_available < $request->quantity) {
            return back()->with('error', 'Not enough books available. Only ' . $book->quantity_available . ' left.');
        }

        // Create book transaction
        BookTransaction::create([
            'student_id' => $request->student_id,
            'book_id' => $request->book_id,
            'quantity' => $request->quantity,
            'unit_price' => $book->price,
            'total_amount' => $book->price * $request->quantity,
            'transaction_date' => $request->transaction_date,
            'status' => $request->status ?? 'pending',
            'notes' => $request->notes
        ]);

        // Update book quantity
        $book->decrement('quantity_available', $request->quantity);

        return redirect()->route('books.transactions')->with('success', 'Book issued successfully!');
    }

    public function transactions()
    {
        $transactions = BookTransaction::with(['student', 'book'])->orderBy('transaction_date', 'desc')->get();
        return view('books.transactions', compact('transactions'));
    }

    public function updateTransactionStatus(Request $request, BookTransaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,collected,cancelled'
        ]);

        $transaction->update(['status' => $request->status]);

        return back()->with('success', 'Transaction status updated successfully!');
    }
}