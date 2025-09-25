@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Payment</h2>
    <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Payment Details
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('payments.update', $payment->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Student</label>
                <div class="form-control bg-light">
                    <strong>{{ $payment->student->first_name }} {{ $payment->student->last_name }}</strong>
                    <br>
                    <small class="text-muted">ID: {{ $payment->student->student_id }} | Class: {{ $payment->student->class_level }}</small>
                </div>
                <small class="text-muted">Student cannot be changed after payment is recorded.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Receipt Number</label>
                <div class="form-control bg-light">
                    {{ $payment->receipt_number }}
                </div>
                <small class="text-muted">Receipt number cannot be changed.</small>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount (₦) *</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" 
                               value="{{ old('amount', $payment->amount) }}" required>
                        @error('amount')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payment_date" class="form-label">Payment Date *</label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" 
                               value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" required>
                        @error('payment_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payment_type" class="form-label">Payment Type *</label>
                        <select class="form-control" id="payment_type" name="payment_type" required>
                            <option value="tuition" {{ old('payment_type', $payment->payment_type) == 'tuition' ? 'selected' : '' }}>Tuition Fee</option>
                            <option value="books" {{ old('payment_type', $payment->payment_type) == 'books' ? 'selected' : '' }}>Books</option>
                            <option value="uniform" {{ old('payment_type', $payment->payment_type) == 'uniform' ? 'selected' : '' }}>Uniform</option>
                            <option value="registration" {{ old('payment_type', $payment->payment_type) == 'registration' ? 'selected' : '' }}>Registration</option>
                            <option value="exam" {{ old('payment_type', $payment->payment_type) == 'exam' ? 'selected' : '' }}>Examination Fee</option>
                            <option value="other" {{ old('payment_type', $payment->payment_type) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('payment_type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method *</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="card" {{ old('payment_method', $payment->payment_method) == 'card' ? 'selected' : '' }}>Debit/Credit Card</option>
                            <option value="check" {{ old('payment_method', $payment->payment_method) == 'check' ? 'selected' : '' }}>Check</option>
                            <option value="online" {{ old('payment_method', $payment->payment_method) == 'online' ? 'selected' : '' }}>Online Payment</option>
                        </select>
                        @error('payment_method')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description / Notes</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $payment->description) }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-save me-2"></i>Update Payment
                    </button>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-secondary btn-lg w-100">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection