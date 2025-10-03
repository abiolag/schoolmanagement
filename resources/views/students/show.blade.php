@extends('layouts.app')

@section('content')
<!-- In the header section, update the buttons -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Student Profile: {{ $student->first_name }} {{ $student->last_name }}</h2>
    <div>
        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-2"></i>Edit Student Info
        </a>
        <a href="{{ route('payments.create') }}?student_id={{ $student->id }}" class="btn btn-success me-2">
            <i class="fas fa-money-bill me-2"></i>Record Payment
        </a>
        <a href="{{ route('books.issue') }}?student_id={{ $student->id }}" class="btn btn-info me-2">
            <i class="fas fa-book me-2"></i>Issue Books
        </a>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Students
        </a>
    </div>
</div>

<!-- Student Information Card -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Student Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Student ID:</strong> {{ $student->student_id }}</p>
                <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
                <p><strong>Age:</strong> {{ \Carbon\Carbon::parse($student->date_of_birth)->age }} years</p>
                <p><strong>Gender:</strong> {{ $student->gender }}</p>
                <p><strong>Class Level:</strong> {{ $student->class_level }}</p>
                <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}</p>
                <p><strong>Enrollment Date:</strong> {{ \Carbon\Carbon::parse($student->enrollment_date)->format('d/m/Y') }}</p>
                <p><strong>Enrollment Duration:</strong> {{ \Carbon\Carbon::parse($student->enrollment_date)->diffInMonths(now()) }} months</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Parent/Guardian Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Parent Name:</strong> {{ $student->parent_name }}</p>
                <p><strong>Parent Phone:</strong> {{ $student->parent_phone }}</p>
                <p><strong>Parent Email:</strong> {{ $student->parent_email ?? 'Not provided' }}</p>
                <p><strong>Address:</strong> {{ $student->address }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Financial Summary</h5>
            </div>
            <div class="card-body text-center">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="border rounded p-2 bg-light">
                            <h4 class="text-success mb-0">₦{{ number_format($student->total_paid, 2) }}</h4>
                            <small>Total Paid</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-2 bg-light">
                            <h4 class="text-primary mb-0">₦{{ number_format($student->total_book_cost, 2) }}</h4>
                            <small>Book Costs</small>
                        </div>
                    </div>
                </div>
                <div class="border rounded p-3 mb-3 {{ $student->balance >= 0 ? 'bg-success text-white' : 'bg-danger text-white' }}">
                    <h3 class="mb-0">₦{{ number_format(abs($student->balance), 2) }}</h3>
                    <small>{{ $student->balance >= 0 ? 'Credit Balance' : 'Amount Due' }}</small>
                </div>
                <div class="border rounded p-2 bg-light">
                    <h5 class="mb-0">{{ $student->pending_books }}</h5>
                    <small>Pending Book Deliveries</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payments Section -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Payment History</h5>
    </div>
    <div class="card-body">
        @if($student->payments->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Receipt No.</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Method</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->payments as $payment)
                    <tr>
                        <td>{{ $payment->receipt_number }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                        <td class="text-success">₦{{ number_format($payment->amount, 2) }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($payment->payment_type) }}</span></td>
                        <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span></td>
                        <td>{{ $payment->description ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-active">
                        <td colspan="2" class="text-end"><strong>Total Paid:</strong></td>
                        <td class="text-success"><strong>₦{{ number_format($student->total_paid, 2) }}</strong></td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="alert alert-info">
            <p class="mb-0">No payment records found for this student.</p>
        </div>
        @endif
    </div>
</div>

<!-- Books Section -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-book me-2"></i>Book Transactions</h5>
    </div>
    <div class="card-body">
        @if($student->bookTransactions->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Subject</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Amount</th>
                        <th>Transaction Date</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->bookTransactions as $transaction)
                    <tr>
                        <td>{{ $transaction->book->title }}</td>
                        <td>{{ $transaction->book->subject }}</td>
                        <td>{{ $transaction->quantity }}</td>
                        <td>₦{{ number_format($transaction->unit_price, 2) }}</td>
                        <td class="text-primary">₦{{ number_format($transaction->total_amount, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}</td>
                        <td>
                            @if($transaction->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($transaction->status == 'collected')
                                <span class="badge bg-success">Collected</span>
                            @else
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>
                        <td>{{ $transaction->notes ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-active">
                        <td colspan="4" class="text-end"><strong>Total Book Costs:</strong></td>
                        <td class="text-primary"><strong>₦{{ number_format($student->total_book_cost, 2) }}</strong></td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="alert alert-info">
            <p class="mb-0">No book transactions found for this student.</p>
        </div>
        @endif
    </div>
</div>
        <!-- Books Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-book me-2"></i>Book Orders & Deliveries</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3 bg-light">
                            <h4 class="text-primary mb-0">{{ $student->book_orders->count() }}</h4>
                            <small>Total Books Ordered</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3 bg-light">
                            <h4 class="text-success mb-0">{{ $student->delivered_books }}</h4>
                            <small>Books Delivered</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3 bg-light">
                            <h4 class="text-warning mb-0">{{ $student->pending_books }}</h4>
                            <small>Pending Delivery</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3 bg-light">
                            <h4 class="text-info mb-0">₦{{ number_format($student->total_book_cost, 2) }}</h4>
                            <small>Total Book Costs</small>
                        </div>
                    </div>
                </div>

                @if($student->book_orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Book</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->book_orders as $transaction)
                                <tr>
                                    <td>
                                        <strong>{{ $transaction->book->title }}</strong><br>
                                        <small class="text-muted">{{ $transaction->book->book_code }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark text-capitalize">
                                            {{ str_replace('_', ' ', $transaction->book->book_type) }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>₦{{ number_format($transaction->unit_price, 2) }}</td>
                                    <td class="text-primary">₦{{ number_format($transaction->total_amount, 2) }}</td>
                                    <td>{{ $transaction->transaction_date->format('M d, Y') }}</td>
                                    <td>
                                        @if($transaction->status == 'pending')
                                            <span class="badge bg-warning">Pending Delivery</span>
                                        @elseif($transaction->status == 'collected')
                                            <span class="badge bg-success">Collected</span>
                                        @else
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->status == 'pending')
                                            <form action="{{ route('books.update-status', $transaction->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="collected">
                                                <button type="submit" class="btn btn-sm btn-success" 
                                                        onclick="return confirm('Mark this book as collected?')">
                                                    <i class="fas fa-check"></i> Mark Collected
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No book orders found for this student.</p>
                        <a href="{{ route('books.issue') }}?student_id={{ $student->id }}" class="btn btn-primary">
                            <i class="fas fa-book me-2"></i>Issue Books to Student
                        </a>
                    </div>
                @endif
            </div>
        </div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <a href="{{ route('payments.create') }}?student_id={{ $student->id }}" class="btn btn-success w-100 mb-2">
                    <i class="fas fa-money-bill me-2"></i>Record Payment
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('books.issue') }}?student_id={{ $student->id }}" class="btn btn-info w-100 mb-2">
                    <i class="fas fa-book me-2"></i>Issue Books
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning w-100 mb-2">
                    <i class="fas fa-edit me-2"></i>Edit Profile
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('students.index') }}" class="btn btn-secondary w-100 mb-2">
                    <i class="fas fa-list me-2"></i>All Students
                </a>
            </div>
        </div>
    </div>
</div>
@endsection