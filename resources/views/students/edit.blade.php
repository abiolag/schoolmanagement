@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Student: {{ $student->first_name }} {{ $student->last_name }}</h2>
    <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Student Profile
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID</label>
                        <input type="text" class="form-control bg-light" id="student_id" value="{{ $student->student_id }}" readonly disabled>
                        <small class="text-muted">Student ID cannot be changed</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="enrollment_date" class="form-label">Enrollment Date *</label>
                        <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" 
                               value="{{ old('enrollment_date', $student->enrollment_date->format('Y-m-d')) }}" required>
                        @error('enrollment_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <h5 class="mt-4 mb-3 border-bottom pb-2">Personal Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name *</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" 
                               value="{{ old('first_name', $student->first_name) }}" required>
                        @error('first_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name *</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" 
                               value="{{ old('last_name', $student->last_name) }}" required>
                        @error('last_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth *</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                               value="{{ old('date_of_birth', $student->date_of_birth->format('Y-m-d')) }}" required>
                        @error('date_of_birth')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender *</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $student->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="class_level" class="form-label">Class Level *</label>
                        <input type="text" class="form-control" id="class_level" name="class_level" 
                               value="{{ old('class_level', $student->class_level) }}" required>
                        @error('class_level')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <h5 class="mt-4 mb-3 border-bottom pb-2">Parent/Guardian Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="parent_name" class="form-label">Parent/Guardian Name</label>
                        <input type="text" class="form-control" id="parent_name" name="parent_name" 
                               value="{{ old('parent_name', $student->parent_name) }}">
                        @error('parent_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="parent_phone" class="form-label">Parent Phone *</label>
                        <input type="tel" class="form-control" id="parent_phone" name="parent_phone" 
                               value="{{ old('parent_phone', $student->parent_phone) }}" required>
                        @error('parent_phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="parent_email" class="form-label">Parent Email (Optional)</label>
                        <input type="email" class="form-control" id="parent_email" name="parent_email" 
                               value="{{ old('parent_email', $student->parent_email) }}">
                        <small class="text-muted">Optional field</small>
                        @error('parent_email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $student->address) }}</textarea>
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-save me-2"></i>Update Student
                    </button>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary btn-lg w-100">
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
        // Calculate and display age when date of birth changes
        const dobInput = document.getElementById('date_of_birth');
        const ageDisplay = document.createElement('small');
        ageDisplay.className = 'form-text text-muted';
        dobInput.parentNode.appendChild(ageDisplay);

        function calculateAge() {
            const dob = new Date(dobInput.value);
            if (!isNaN(dob.getTime())) {
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const monthDiff = today.getMonth() - dob.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                ageDisplay.textContent = `Age: ${age} years`;
            } else {
                ageDisplay.textContent = '';
            }
        }

        dobInput.addEventListener('change', calculateAge);
        calculateAge(); // Calculate initial age
    });
</script>
@endsection
@endsection