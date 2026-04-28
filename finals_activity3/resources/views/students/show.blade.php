@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
  <div>
    <h1 class="page-title h3 mb-1">Student Profile</h1>
    <p class="text-secondary mb-0">Picture, QR code, and related student fields in one profile.</p>
  </div>
  <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back to List</a>
</div>

<div class="student-card p-3 p-md-4">
  <div class="row g-4 align-items-start">
    <div class="col-lg-4 text-center text-lg-start">
      @if($student->photo_path)
      <img src="{{ asset('storage/' . $student->photo_path) }}" alt="{{ $student->name }}" class="profile-photo mb-3">
      @else
      <span class="profile-photo photo-placeholder mb-3">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
      @endif
      <h2 class="h4 mb-1">{{ $student->name }}</h2>
      <p class="text-secondary mb-0">{{ $student->student_id }}</p>
    </div>

    <div class="col-lg-5">
      <div class="row g-3">
        <div class="col-sm-6">
          <div class="field-label">Student ID</div>
          <div class="field-value">{{ $student->student_id }}</div>
        </div>
        <div class="col-sm-6">
          <div class="field-label">Full Name</div>
          <div class="field-value">{{ $student->name }}</div>
        </div>
        <div class="col-sm-6">
          <div class="field-label">Course</div>
          <div class="field-value">{{ $student->course }}</div>
        </div>
        <div class="col-sm-6">
          <div class="field-label">Year Level</div>
          <div class="field-value">{{ $student->year_level }}</div>
        </div>
        <div class="col-sm-6">
          <div class="field-label">Section</div>
          <div class="field-value">{{ $student->section ?? 'N/A' }}</div>
        </div>
        <div class="col-sm-6">
          <div class="field-label">Email</div>
          <div class="field-value">{{ $student->email ?? 'N/A' }}</div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 text-center">
      <div class="qr-box p-3 border rounded bg-white">
        {!! $qr !!}
      </div>
      <p class="small text-secondary mt-2 mb-0">Scan to view the encoded student data.</p>
    </div>
  </div>

  <div class="d-flex flex-wrap gap-2 justify-content-end mt-4 pt-3 border-top">
    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('students.destroy', $student->id) }}" method="POST"
      onsubmit="return confirm('Delete this student record? This will also remove the saved picture.')">
      @csrf
      @method('DELETE')
      <button class="btn btn-outline-danger">Delete</button>
    </form>
  </div>
</div>
@endsection
