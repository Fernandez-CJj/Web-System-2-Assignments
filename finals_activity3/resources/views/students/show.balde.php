@extends('layouts.app')

@section('content')
<div class="card shadow-sm" style="max-width: 650px; margin: auto;">
  <div class="card-header bg-info text-white">
    <h5 class="mb-0">Student Profile</h5>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-7">
        <table class="table table-borderless">
          <tr>
            <th>Student ID</th>
            <td>{{ $student->student_id }}</td>
          </tr>
          <tr>
            <th>Name</th>
            <td>{{ $student->name }}</td>
          </tr>
          <tr>
            <th>Course</th>
            <td>{{ $student->course }}</td>
          </tr>
          <tr>
            <th>Year Level</th>
            <td>{{ $student->year_level }}</td>
          </tr>
          <tr>
            <th>Section</th>
            <td>{{ $student->section ?? 'N/A' }}</td>
          </tr>
          <tr>
            <th>Email</th>
            <td>{{ $student->email ?? 'N/A' }}</td>
          </tr>
        </table>
      </div>
      <div class="col-md-5 text-center">
        <p class="text-muted small mb-1">Scan to view student data</p>
        {!! $qr !!}
        <p class="text-muted small mt-1">Contains all student info</p>
      </div>
    </div>

    <div class="d-flex gap-2 mt-3">
      <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">Edit</a>
      <form action="{{ route('students.destroy', $student->id) }}" method="POST"
        onsubmit="return confirm('Delete this student?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">Delete</button>
      </form>
      <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
  </div>
</div>
@endsection