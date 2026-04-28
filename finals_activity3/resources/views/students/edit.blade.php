@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
  <div>
    <h1 class="page-title h3 mb-1">Edit Student</h1>
    <p class="text-secondary mb-0">Update the student details, picture, and QR profile data.</p>
  </div>
  <a href="{{ route('students.show', $student->id) }}" class="btn btn-outline-secondary">View Profile</a>
</div>

<div class="form-panel p-3 p-md-4">
  @if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-4">
      <div class="col-lg-4">
        <label class="form-label fw-bold">Student Picture</label>
        <div class="mb-3">
          @if($student->photo_path)
          <img src="{{ asset('storage/' . $student->photo_path) }}" alt="{{ $student->name }}" class="photo-preview">
          @else
          <span class="photo-preview photo-placeholder">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
          @endif
        </div>
        <input type="file" name="photo" class="form-control" accept="image/*">
        <p class="small text-secondary mt-2 mb-0">Leave empty to keep the current picture.</p>
      </div>

      <div class="col-lg-8">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-bold">Student ID</label>
            <input type="text" name="student_id" class="form-control" value="{{ old('student_id', $student->student_id) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Course</label>
            <input type="text" name="course" class="form-control" value="{{ old('course', $student->course) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Year Level</label>
            <select name="year_level" class="form-select" required>
              <option value="">Select year level</option>
              @foreach(['1st Year','2nd Year','3rd Year','4th Year'] as $year)
              <option value="{{ $year }}" {{ old('year_level', $student->year_level) == $year ? 'selected' : '' }}>{{ $year }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Section</label>
            <input type="text" name="section" class="form-control" value="{{ old('section', $student->section) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}">
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex flex-wrap gap-2 justify-content-end mt-4">
      <button type="submit" class="btn btn-primary">Update Student</button>
      <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
