@extends('layouts.app')

@section('content')
<div class="card shadow-sm" style="max-width: 600px; margin: auto;">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0">Add New Student</h5>
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

    <form action="{{ route('students.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Student ID</label>
        <input type="text" name="student_id" class="form-control" value="{{ old('student_id') }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Course</label>
        <input type="text" name="course" class="form-control" value="{{ old('course') }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Year Level</label>
        <select name="year_level" class="form-select" required>
          <option value="">-- Select Year --</option>
          <option value="1st Year" {{ old('year_level') == '1st Year' ? 'selected' : '' }}>1st Year</option>
          <option value="2nd Year" {{ old('year_level') == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
          <option value="3rd Year" {{ old('year_level') == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
          <option value="4th Year" {{ old('year_level') == '4th Year' ? 'selected' : '' }}>4th Year</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Section</label>
        <input type="text" name="section" class="form-control" value="{{ old('section') }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Save Student</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection