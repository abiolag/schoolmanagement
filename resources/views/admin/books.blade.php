@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-book me-2"></i>Books Management</h4>
                </div>
                <div class="card-body">
                    <!-- Add Book Form -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>Add New Book</h5>
                            <form action="{{ route('admin.books.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="book_code" class="form-label">Book Code *</label>
                                            <input type="text" class="form-control" id="book_code" name="book_code" required>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Book Title *</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Class Category *</label>
                                            <select class="form-control" id="category_id" name="category_id" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="book_type" class="form-label">Book Type *</label>
                                            <select class="form-control" id="book_type" name="book_type" required>
                                                <option value="">Select Type</option>
                                                <optgroup label="Core Subjects">
                                                    <option value="english">English</option>
                                                    <option value="mathematics">Mathematics</option>
                                                    <option value="weekly_assessment">Weekly Assessment</option>
                                                    <option value="quantitative_reasoning">Quantitative Reasoning</option>
                                                    <option value="verbal_reasoning">Verbal Reasoning</option>
                                                </optgroup>
                                                <optgroup label="Early Years Only">
                                                    <option value="handwriting">Handwriting</option>
                                                    <option value="colouring">Colouring Book</option>
                                                </optgroup>
                                                <optgroup label="Primary Only">
                                                    <option value="english_composition">English Composition</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="subject_type" class="form-label">Subject Type</label>
                                            <select class="form-control" id="subject_type" name="subject_type">
                                                <option value="textbook">Textbook</option>
                                                <option value="workbook">Workbook</option>
                                                <option value="activity_book">Activity Book</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price (₦) *</label>
                                            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="quantity_available" class="form-label">Quantity *</label>
                                            <input type="number" class="form-control" id="quantity_available" name="quantity_available" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="publisher" class="form-label">Publisher</label>
                                            <input type="text" class="form-control" id="publisher" name="publisher">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="isbn" class="form-label">ISBN</label>
                                            <input type="text" class="form-control" id="isbn" name="isbn">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success">Add Book</button>
                            </form>
                        </div>
                    </div>

                    <!-- Books List -->
                    <h5>Books Inventory</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Book Code</th>
                                    <th>Title</th>
                                    <th>Class</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                <tr>
                                    <td><strong>{{ $book->book_code }}</strong></td>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->category->name }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark text-capitalize">
                                            {{ str_replace('_', ' ', $book->book_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.books.update-price', $book->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">₦</span>
                                                <input type="number" step="0.01" name="price" value="{{ $book->price }}" 
                                                       class="form-control form-control-sm" style="width: 100px;">
                                                <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>{{ $book->quantity_available }}</td>
                                    <td>
                                        <span class="badge bg-{{ $book->stock_status_color }}">
                                            {{ ucfirst(str_replace('_', ' ', $book->stock_status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.inventory') }}?book_id={{ $book->id }}" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-boxes"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamic book types based on category selection
    const categorySelect = document.getElementById('category_id');
    const bookTypeSelect = document.getElementById('book_type');

    categorySelect.addEventListener('change', function() {
        const categoryName = this.options[this.selectedIndex].text;
        
        // Enable/disable book types based on category
        Array.from(bookTypeSelect.options).forEach(option => {
            if (option.parentElement.label === 'Early Years Only') {
                option.disabled = !categoryName.includes('Creche') && 
                                 !categoryName.includes('Kindergarten') && 
                                 !categoryName.includes('Nursery');
            } else if (option.parentElement.label === 'Primary Only') {
                option.disabled = !categoryName.includes('Primary');
            }
        });
    });
});
</script>
@endsection
@endsection