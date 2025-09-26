@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Payment Records</h2>
    <a href="{{ route('payments.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Record New Payment
    </a>
</div>

@if($payments->count() > 0)
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Receipt No.</th>
                        <th>Student</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Type</th>
                        <th>Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->receipt_number }}</td>
                        <td>{{ $payment->student->first_name }} {{ $payment->student->last_name }}</td>
                        <td>₦{{ number_format($payment->amount, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                        <td>{{ $payment->payment_type }}</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td>
                            <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this payment?')">
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
    <h4>No Payments Found</h4>
    <p>There are no payment records yet. <a href="{{ route('payments.create') }}">Record the first payment</a>.</p>
</div>
@endif

<div class="mt-4">
    <h5>Payment Summary</h5>
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h4>₦{{ number_format($payments->sum('amount'), 2) }}</h4>
                    <p class="mb-0">Total Payments</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection