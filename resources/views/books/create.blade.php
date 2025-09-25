@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Add New Book</h2>
    <a href="{{ route('books.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Books
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="book_code" class="form-label">Book Code *</label>
                        <input type="text" class="form-control" id="book_code" name="book_code" required>
                        <small class="text-muted">Unique identifier for the book</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Book Title *</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject *</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="class_level" class="form-label">Class Level *</label>
                        <input type="text" class="form-control" id="class_level" name="class_level" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="price" class="form-label">Price (₦) *</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="quantity_available" class="form-label">Quantity Available *</label>
                        <input type="number" class="form-control" id="quantity_available" name="quantity_available" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Add Book</button>
        </form>
    </div>
</div>
@endsection