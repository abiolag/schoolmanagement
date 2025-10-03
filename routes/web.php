<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BookController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('students', StudentController::class);
Route::resource('payments', PaymentController::class);
Route::resource('books', BookController::class);

// Book transaction routes
Route::get('/books/issue', [BookController::class, 'showIssueForm'])->name('books.issue');
Route::post('/books/issue', [BookController::class, 'issueBook'])->name('books.issue.store');
Route::get('/books/transactions', [BookController::class, 'transactions'])->name('books.transactions');
Route::post('/books/transactions/{transaction}/status', [BookController::class, 'updateTransactionStatus'])->name('books.transactions.status');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// ... existing routes ...

// Admin Routes
/*Route::prefix('admin')->name('admin.')->group(function () {
    // Books Management
    Route::get('/categories', [BookAdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [BookAdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/books', [BookAdminController::class, 'books'])->name('books');
    Route::post('/books', [BookAdminController::class, 'createBook'])->name('books.store');
    Route::patch('/books/{book}/price', [BookAdminController::class, 'updateBookPrice'])->name('books.update-price');
    Route::get('/inventory', [BookAdminController::class, 'inventory'])->name('inventory');
    Route::post('/inventory/update', [BookAdminController::class, 'updateInventory'])->name('inventory.update');
}); */

// Book Transactions
Route::patch('/book-transactions/{transaction}/status', [BookController::class, 'updateStatus'])->name('books.update-status');

Auth::routes();

