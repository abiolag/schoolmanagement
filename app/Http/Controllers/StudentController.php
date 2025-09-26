<?php
// app/Http/Controllers/StudentController.php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
        public function index()
    {
        $students = Student::with(['payments', 'bookTransactions'])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
        
        return view('students.index', compact('students'));
    }
    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date',
            'class_level' => 'required',
            'parent_phone' => 'required'
        ]);

        // Better student ID generation
        $currentYear = date('Y');
        
        // Get the highest student ID for the current year
        $lastStudent = Student::where('student_id', 'like', 'MCS' . $currentYear . '%')
                             ->orderBy('student_id', 'desc')
                             ->first();
        
        if ($lastStudent) {
            // Extract the number part and increment
            $lastNumber = intval(substr($lastStudent->student_id, -4));
            $newNumber = $lastNumber + 1;
        } else {
            // First student of the year
            $newNumber = 1;
        }
        
        $studentId = 'MCS' . $currentYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // Check if student ID already exists (safety check)
        if (Student::where('student_id', $studentId)->exists()) {
            // If exists, find the next available number
            $existingStudent = Student::where('student_id', '>=', $studentId)
                                     ->orderBy('student_id', 'desc')
                                     ->first();
            
            $lastNumber = intval(substr($existingStudent->student_id, -4));
            $studentId = 'MCS' . $currentYear . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        Student::create([
            'student_id' => $studentId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'parent_name' => $request->parent_name,
            'parent_phone' => $request->parent_phone,
            'parent_email' => $request->parent_email ?: null, // Ensure null if empty
            'address' => $request->address,
            'enrollment_date' => $request->enrollment_date ?? now(),
            'class_level' => $request->class_level
        ]);

        return redirect()->route('students.index')->with('success', 'Student enrolled successfully!');
    }

    public function show(Student $student)
    {
        $student->load(['payments', 'bookTransactions.book']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required',
            'class_level' => 'required',
            'parent_phone' => 'required',
            'enrollment_date' => 'required|date'
        ]);

        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'parent_name' => $request->parent_name,
            'parent_phone' => $request->parent_phone,
            'parent_email' => $request->parent_email ?: null,
            'address' => $request->address,
            'enrollment_date' => $request->enrollment_date,
            'class_level' => $request->class_level
        ]);

        return redirect()->route('students.show', $student->id)->with('success', 'Student information updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}