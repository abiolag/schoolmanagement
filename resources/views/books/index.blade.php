@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Book Management</h2>
    <div>
        <a href="{{ route('books.create') }}" class="btn btn-primary me-2">
            <i class="fas fa-plus me-2"></i>Add New Book
        </a>
        <a href="{{ route('books.issue') }}" class="btn btn-success me-2">
            <i class="fas fa-book me-2"></i>Issue Books
        </a>
        <a href="{{ route('books.transactions') }}" class="btn btn-info">
            <i class="fas fa-list me-2"></i>View Transactions
        </a>
    </div>
</div>

@if($books->count() > 0)
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Book Code</th>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Class Level</th>
                        <th>Price</th>
                        <th>Quantity Available</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td>{{ $book->book_code }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->subject }}</td>
                        <td>{{ $book->class_level }}</td>
                        <td>₦{{ number_format($book->price, 2) }}</td>
                        <td>
                            <span class="{{ $book->quantity_available == 0 ? 'text-danger' : ($book->quantity_available < 10 ? 'text-warning' : 'text-success') }}">
                                {{ $book->quantity_available }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this book?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="alert alert-info">
    <h4>No Books Found</h4>
    <p>There are no books in the inventory yet. <a href="{{ route('books.create') }}">Add the first book</a>.</p>
</div>
@endif

<div class="mt-4">
    <h5>Inventory Summary</h5>
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h4>{{ $books->count() }}</h4>
                    <p class="mb-0">Total Books</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h4>{{ $books->sum('quantity_available') }}</h4>
                    <p class="mb-0">Total Quantity</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h4>₦{{ number_format($books->sum('price'), 2) }}</h4>
                    <p class="mb-0">Total Value</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection