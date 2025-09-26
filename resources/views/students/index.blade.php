@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Student Management</h2>
    <a href="{{ route('students.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Enroll New Student
    </a>
</div>

@if($students->count() > 0)
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Class Level</th>
                        <th>Parent Phone</th>
                        <th>Enrollment Date</th>
                        <th>Total Paid</th>
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $student->student_id }}</td>
                        <td>
                            <a href="{{ route('students.show', $student->id) }}" class="text-primary fw-bold">
                                {{ $student->first_name }} {{ $student->last_name }}
                            </a>
                        </td>
                        <td>{{ $student->class_level }}</td>
                        <td>{{ $student->parent_phone }}</td>
                        <td>{{ \Carbon\Carbon::parse($student->enrollment_date)->format('d/m/Y') }}</td>
                        <td>₦{{ number_format($student->total_paid, 2) }}</td>
                        <td>
                            @if($student->balance > 0)
                                <span class="text-success">+₦{{ number_format(abs($student->balance), 2) }}</span>
                            @elseif($student->balance < 0)
                                <span class="text-danger">-₦{{ number_format(abs($student->balance), 2) }}</span>
                            @else
                                <span class="text-muted">₦0.00</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-info" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning" title="Edit Student">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this student?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
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
    <h4>No Students Found</h4>
    <p>There are no students enrolled yet. <a href="{{ route('students.create') }}">Click here</a> to enroll the first student.</p>
</div>
@endif
@endsection