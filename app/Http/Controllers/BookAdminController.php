<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;

class BookAdminController extends Controller
{
    public function categories()
    {
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'sort_order' => 'required|integer',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
    }

    public function books()
    {
        $books = Book::with('category')->get();
        $categories = Category::all();
        return view('admin.books', compact('books', 'categories'));
    }

    public function createBook(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:255|unique:books',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'quantity_available' => 'required|integer|min:0', // Changed from stock_quantity
        ]);

        // Add default values for required fields
        $bookData = array_merge($request->all(), [
            'book_code' => 'BK' . time(), // Generate a unique book code
            'subject' => $request->title, // Use title as subject if not provided
            'class_level' => 'general',
            'subject_type' => 'general',
            'book_type' => 'textbook',
            'publisher' => 'Unknown',
            'reorder_level' => 5, // Default reorder level
        ]);

        Book::create($bookData);

        return redirect()->route('admin.books')->with('success', 'Book created successfully.');
    }

    public function updateBookPrice(Request $request, Book $book)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $book->update(['price' => $request->price]);

        return redirect()->route('admin.books')->with('success', 'Book price updated successfully.');
    }

    public function inventory()
    {
        $books = Book::with('category')->get();
        return view('admin.inventory', compact('books'));
    }

    public function updateInventory(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity_available' => 'required|integer|min:0', // Changed from stock_quantity
        ]);

        $book = Book::find($request->book_id);
        $book->update(['quantity_available' => $request->quantity_available]);

        return redirect()->route('admin.inventory')->with('success', 'Inventory updated successfully.');
    }
}