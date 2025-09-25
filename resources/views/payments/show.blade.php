@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Payment Details</h2>
    <div>
        <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-2"></i>Edit Payment
        </a>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Payments
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Payment Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Receipt Number:</div>
                    <div class="col-sm-8">{{ $payment->receipt_number }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Amount Paid:</div>
                    <div class="col-sm-8 fs-5 text-success">₦{{ number_format($payment->amount, 2) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Payment Date:</div>
                    <div class="col-sm-8">{{ \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Payment Type:</div>
                    <div class="col-sm-8">
                        <span class="badge bg-info text-dark">{{ ucfirst($payment->payment_type) }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Payment Method:</div>
                    <div class="col-sm-8">
                        <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                    </div>
                </div>
                @if($payment->description)
                <div class="row">
                    <div class="col-sm-4 fw-bold">Description:</div>
                    <div class="col-sm-8">{{ $payment->description }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Student Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Student ID:</div>
                    <div class="col-sm-8">{{ $payment->student->student_id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Name:</div>
                    <div class="col-sm-8">{{ $payment->student->first_name }} {{ $payment->student->last_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Class Level:</div>
                    <div class="col-sm-8">{{ $payment->student->class_level }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 fw-bold">Parent Phone:</div>
                    <div class="col-sm-8">{{ $payment->student->parent_phone }}</div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('students.show', $payment->student->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i>View Student Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Payment History</h5>
            </div>
            <div class="card-body">
                @php
                    $studentPayments = $payment->student->payments()->orderBy('payment_date', 'desc')->get();
                @endphp
                
                @if($studentPayments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($studentPayments as $studentPayment)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">{{ $studentPayment->payment_date->format('M d, Y') }}</small>
                                    <br>
                                    <span class="badge bg-light text-dark">{{ ucfirst($studentPayment->payment_type) }}</span>
                                </div>
                                <div class="text-end">
                                    <strong>₦{{ number_format($studentPayment->amount, 2) }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $studentPayment->receipt_number }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No other payment records found for this student.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection