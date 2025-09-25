@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Issue Books to Students</h2>
    <a href="{{ route('books.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Books
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('books.issue.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                 <div class="mb-3">
                <label for="student_id" class="form-label">Student *</label>
                <select class="form-control" id="student_id" name="student_id" required>
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" 
                            {{ (old('student_id') == $student->id || $selectedStudent == $student->id) ? 'selected' : '' }}>
                            {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_id }}) - {{ $student->class_level }}
                        </option>
                    @endforeach
                </select>
                 </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="book_id" class="form-label">Book *</label>
                        <select class="form-control" id="book_id" name="book_id" required>
                            <option value="">Select Book</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" data-price="{{ $book->price }}" data-quantity="{{ $book->quantity_available }}">
                                    {{ $book->title }} - ₦{{ number_format($book->price, 2) }} ({{ $book->quantity_available }} available)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity *</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="transaction_date" class="form-label">Transaction Date *</label>
                        <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="pending">Pending Delivery</option>
                            <option value="collected">Collected</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Optional notes"></textarea>
            </div>

            <div class="alert alert-info">
                <strong>Total Amount: </strong> ₦<span id="totalAmount">0.00</span>
            </div>

            <button type="submit" class="btn btn-primary">Issue Book</button>
        </form>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookSelect = document.getElementById('book_id');
        const quantityInput = document.getElementById('quantity');
        const totalAmountSpan = document.getElementById('totalAmount');

        function calculateTotal() {
            const selectedOption = bookSelect.options[bookSelect.selectedIndex];
            const price = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) : 0;
            const quantity = parseInt(quantityInput.value) || 0;
            const total = price * quantity;
            totalAmountSpan.textContent = total.toFixed(2);
        }

        bookSelect.addEventListener('change', calculateTotal);
        quantityInput.addEventListener('input', calculateTotal);
        
        // Initial calculation
        calculateTotal();
    });
</script>
@endsection
@endsection