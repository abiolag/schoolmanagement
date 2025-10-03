<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookAdminController extends Controller
{
    public function categories()
    {
        $categories = Category::ordered()->get();
        return view('admin.categories', compact('categories'));
    }

    public function books()
    {
        $books = Book::with('category')->get();
        $categories = Category::ordered()->get();
        return view('admin.books', compact('books', 'categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:early_years,primary'
        ]);

        $sortOrder = Category::max('sort_order') + 1;

        Category::create([
            'name' => $request->name,
            'type' => $request->type,
            'sort_order' => $sortOrder
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category created successfully!');
    }

    public function updateBookPrice(Request $request, Book $book)
    {
        $request->validate([
            'price' => 'required|numeric|min:0'
        ]);

        $book->update(['price' => $request->price]);

        return back()->with('success', 'Book price updated successfully!');
    }

    public function inventory()
    {
        $books = Book::with(['category', 'inventoryTransactions'])->get();
        return view('admin.inventory', compact('books'));
    }

    public function updateInventory(Request $request, Book $book)
    {
        $request->validate([
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer',
            'notes' => 'nullable|string'
        ]);

        $newBalance = $request->type === 'in' 
            ? $book->quantity_available + $request->quantity
            : $book->quantity_available - $request->quantity;

        // Create inventory transaction
        InventoryTransaction::create([
            'book_id' => $book->id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'balance_after' => $newBalance,
            'notes' => $request->notes,
            'user_id' => Auth::id()
        ]);

        // Update book quantity
        $book->update(['quantity_available' => $newBalance]);

        return back()->with('success', 'Inventory updated successfully!');
    }

    public function createBook(Request $request)
    {
        $request->validate([
            'book_code' => 'required|unique:books',
            'title' => 'required',
            'category_id' => 'required|exists:categories,id',
            'book_type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:0',
            'publisher' => 'nullable|string',
            'isbn' => 'nullable|string'
        ]);

        Book::create($request->all());

        return redirect()->route('admin.books')->with('success', 'Book created successfully!');
    }
}