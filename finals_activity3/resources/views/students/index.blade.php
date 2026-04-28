@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
  <div>
    <h1 class="page-title h3 mb-1">Student Directory</h1>
    <p class="text-secondary mb-0">Manage student pictures, QR profiles, and complete records.</p>
  </div>
  <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
</div>

<div class="panel p-3 p-md-4 mb-4">
  <form method="GET" action="{{ route('students.index') }}">
    <div class="row g-2 align-items-center">
      <div class="col-12 col-md">
        <input type="text" name="search" class="form-control form-control-lg"
          placeholder="Search by name, ID, course, year, section, or email"
          value="{{ $search ?? '' }}">
      </div>
      <div class="col-12 col-md-auto d-flex gap-2">
        <button class="btn btn-primary btn-lg flex-fill" type="submit">Search</button>
        @if($search)
        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary btn-lg">Clear</a>
        @endif
      </div>
    </div>
  </form>
</div>

@if($students->count() === 0)
<div class="empty-state">
  <h2 class="h5 mb-2">No students found</h2>
  <p class="text-secondary mb-3">Add a student with a picture and QR profile to get started.</p>
  <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
</div>
@else
<div class="panel overflow-hidden">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Picture</th>
          <th>Student</th>
          <th>Course</th>
          <th>Year / Section</th>
          <th>Email</th>
          <th>QR Code</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($students as $student)
        <tr>
          <td>
            @if($student->photo_path)
            <img src="{{ asset('storage/' . $student->photo_path) }}" alt="{{ $student->name }}" class="student-photo">
            @else
            <span class="student-photo photo-placeholder">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
            @endif
          </td>
          <td>
            <div class="fw-bold">{{ $student->name }}</div>
            <div class="small text-secondary">{{ $student->student_id }}</div>
          </td>
          <td>{{ $student->course }}</td>
          <td>{{ $student->year_level }}{{ $student->section ? ' / ' . $student->section : '' }}</td>
          <td>{{ $student->email ?? 'N/A' }}</td>
          <td class="qr-box" style="width: 92px;">{!! $student->qr !!}</td>
          <td>
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('students.show', $student->id) }}" class="btn btn-outline-primary btn-sm">View</a>
              <a href="{{ route('students.edit', $student->id) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
              <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                onsubmit="return confirm('Delete this student record? This will also remove the saved picture.')">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger btn-sm">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="px-3 py-3 border-top">
    {{ $students->links('pagination::bootstrap-5') }}
  </div>
</div>
@endif
@endsection
