@extends('layouts.app')

@section('content')
<div class="card shadow-sm" style="max-width: 600px; margin: auto;">
  <div class="card-header bg-warning">
    <h5 class="mb-0">Edit Student</h5>
  </div>
  <div class="card-body">
    @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('students.update', $student->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label class="form-label">Student ID</label>
        <input type="text" name="student_id" class="form-control" value="{{ old('student_id', $student->student_id) }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Course</label>
        <input type="text" name="course" class="form-control" value="{{ old('course', $student->course) }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Year Level</label>
        <select name="year_level" class="form-select" required>
          <option value="">-- Select Year --</option>
          @foreach(['1st Year','2nd Year','3rd Year','4th Year'] as $yr)
          <option value="{{ $yr }}" {{ old('year_level', $student->year_level) == $yr ? 'selected' : '' }}>{{ $yr }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Section</label>
        <input type="text" name="section" class="form-control" value="{{ old('section', $student->section) }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}">
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-warning">Update Student</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection