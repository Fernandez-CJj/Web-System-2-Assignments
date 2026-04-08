@extends('layouts.app')

@section('content')
<div class="card">
  <div class="topbar">
    <div>
      <h2 style="margin: 0; font-family: 'Space Grotesk', 'Segoe UI', sans-serif;">Welcome, {{ $user->first_name }} {{ $user->last_name }}</h2>
      <p style="margin: 6px 0 0; color: #6a6259;">Enrollment Student Portal Dashboard</p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center;">
      <a class="btn btn-outline" href="/profile">Update Profile</a>
      <form method="POST" action="/logout">
        @csrf
        <button class="btn btn-secondary" type="submit">Logout</button>
      </form>
    </div>
  </div>

  @if (session('success'))
  <div class="flash success">{{ session('success') }}</div>
  @endif

  <div class="meta">
    <div class="meta-item">
      <small>Student Number</small>
      <strong>{{ $user->student_number }}</strong>
    </div>
    <div class="meta-item">
      <small>Program / Year</small>
      <strong>{{ $user->program }} - {{ $user->year_level }}</strong>
    </div>
    <div class="meta-item">
      <small>Contact</small>
      <strong>{{ $user->phone }}</strong>
    </div>
  </div>

</div>
@endsection