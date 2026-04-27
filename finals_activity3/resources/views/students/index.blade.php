@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">All Students</h4>
  <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">+ Add Student</a>
</div>

<form method="GET" action="{{ route('students.index') }}" class="mb-4">
  <div class="input-group">
    <input type="text" name="search" class="form-control"
      placeholder="Search by name, student ID, or course..."
      value="{{ $search ?? '' }}">
    <button class="btn btn-outline-secondary" type="submit">Search</button>
    @if($search)
    <a href="{{ route('students.index') }}" class="btn btn-outline-danger">Clear</a>
    @endif
  </div>
</form>

@if($students->isEmpty())
<div class="alert alert-info">No students found.</div>
@else
<div class="table-responsive">
  <table class="table table-bordered table-hover bg-white">
    <thead class="table-primary">
      <tr>
        <th>QR</th>
        <th>Student ID</th>
        <th>Name</th>
        <th>Course</th>
        <th>Year & Section</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($students as $student)
      <tr>
        <td>{!! $student->qr !!}</td>
        <td>{{ $student->student_id }}</td>
        <td>{{ $student->name }}</td>
        <td>{{ $student->course }}</td>
        <td>{{ $student->year_level }} - {{ $student->section }}</td>
        <td>{{ $student->email }}</td>
        <td>
          <a href="{{ route('students.show', $student->id) }}" class="btn btn-info btn-sm">View</a>
          <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Edit</a>
          <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline"
            onsubmit="return confirm('Delete this student?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif
@endsection