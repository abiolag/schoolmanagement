@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Record New Payment</h2>
    <a href="{{ route('payments.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Payments
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('payments.store') }}" method="POST">
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
                    @error('student_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount (₦) *</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" 
                               value="{{ old('amount') }}" placeholder="Enter amount" required>
                        @error('amount')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payment_date" class="form-label">Payment Date *</label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" 
                               value="{{ old('payment_date', date('Y-m-d')) }}" required>
                        @error('payment_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payment_type" class="form-label">Payment Type *</label>
                        <select class="form-control" id="payment_type" name="payment_type" required>
                            <option value="">Select Payment Type</option>
                            <option value="tuition" {{ old('payment_type') == 'tuition' ? 'selected' : '' }}>Tuition Fee</option>
                            <option value="books" {{ old('payment_type') == 'books' ? 'selected' : '' }}>Books</option>
                            <option value="uniform" {{ old('payment_type') == 'uniform' ? 'selected' : '' }}>Uniform</option>
                            <option value="registration" {{ old('payment_type') == 'registration' ? 'selected' : '' }}>Registration</option>
                            <option value="exam" {{ old('payment_type') == 'exam' ? 'selected' : '' }}>Examination Fee</option>
                            <option value="other" {{ old('payment_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('payment_type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method *</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="">Select Payment Method</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Debit/Credit Card</option>
                            <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Check</option>
                            <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online Payment</option>
                        </select>
                        @error('payment_method')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="receipt_number" class="form-label">Receipt Number (Auto-generated)</label>
                        <input type="text" class="form-control" id="receipt_number" value="Will be auto-generated" readonly disabled>
                        <small class="text-muted">Receipt number is automatically generated</small>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description / Notes</label>
                <textarea class="form-control" id="description" name="description" rows="3" 
                          placeholder="Optional: Enter any additional notes about this payment">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-save me-2"></i>Record Payment
                    </button>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-lg w-100">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-focus on student select
        document.getElementById('student_id').focus();
        
        // Format amount field on blur
        const amountInput = document.getElementById('amount');
        amountInput.addEventListener('blur', function() {
            if (this.value) {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });
    });
</script>
@endsection
@endsection