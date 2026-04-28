<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $students = Student::when($search, function ($query) use ($search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%")
                    ->orWhere('course', 'like', "%{$search}%")
                    ->orWhere('year_level', 'like', "%{$search}%")
                    ->orWhere('section', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        })->latest()->paginate(8)->withQueryString();

        $students->getCollection()->transform(function ($student) {
            $student->qr = QrCode::size(80)->generate(
                route('students.show', $student->id)
            );
            return $student;
        });

        return view('students.index', compact('students', 'search'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'name'       => 'required',
            'course'     => 'required',
            'year_level' => 'required',
            'section'    => 'nullable|string|max:255',
            'email'      => 'nullable|email|max:255',
            'photo'      => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'student_id',
            'name',
            'course',
            'year_level',
            'section',
            'email',
        ]);
        $data['photo_path'] = $request->file('photo')->store('student-photos', 'public');

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        $qr = QrCode::size(250)->generate(json_encode([
            'student_id' => $student->student_id,
            'name'       => $student->name,
            'course'     => $student->course,
            'year_level' => $student->year_level,
            'section'    => $student->section,
            'email'      => $student->email,
            'picture'    => $student->photo_path ? asset('storage/' . $student->photo_path) : null,
        ]));

        return view('students.show', compact('student', 'qr'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_id' => 'required|unique:students,student_id,' . $student->id,
            'name'       => 'required',
            'course'     => 'required',
            'year_level' => 'required',
            'section'    => 'nullable|string|max:255',
            'email'      => 'nullable|email|max:255',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'student_id',
            'name',
            'course',
            'year_level',
            'section',
            'email',
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo_path) {
                Storage::disk('public')->delete($student->photo_path);
            }

            $data['photo_path'] = $request->file('photo')->store('student-photos', 'public');
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->photo_path) {
            Storage::disk('public')->delete($student->photo_path);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
