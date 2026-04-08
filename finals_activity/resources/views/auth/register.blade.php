@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-head">
    <h1>Enrollment Registration</h1>
    <p>Fill out all required details. Minimum 10 fields are included as requested.</p>
  </div>

  @if (session('error'))
  <div class="flash error">{{ session('error') }}</div>
  @endif

  @if ($errors->any())
  <div class="errors">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
  </div>
  @endif

  <form method="POST" action="/register">
    @csrf
    <div class="form-grid">
      <div class="field">
        <label>Student Number</label>
        <input type="text" name="student_number" value="{{ old('student_number') }}" required>
      </div>
      <div class="field">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
      </div>

      <div class="field">
        <label>First Name</label>
        <input type="text" name="first_name" value="{{ old('first_name') }}" required>
      </div>
      <div class="field">
        <label>Last Name</label>
        <input type="text" name="last_name" value="{{ old('last_name') }}" required>
      </div>

      <div class="field">
        <label>Middle Name</label>
        <input type="text" name="middle_name" value="{{ old('middle_name') }}">
      </div>
      <div class="field">
        <label>Birth Date</label>
        <input type="date" name="birth_date" value="{{ old('birth_date') }}" required>
      </div>

      <div class="field">
        <label>Gender</label>
        <select name="gender" required>
          <option value="">Select...</option>
          <option value="Male" @selected(old('gender')==='Male' )>Male</option>
          <option value="Female" @selected(old('gender')==='Female' )>Female</option>
          <option value="Prefer not to say" @selected(old('gender')==='Prefer not to say' )>Prefer not to say</option>
        </select>
      </div>
      <div class="field">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone') }}" required>
      </div>

      <div class="field">
        <label>Program</label>
        <input type="text" name="program" value="{{ old('program') }}" required>
      </div>
      <div class="field">
        <label>Year Level</label>
        <select name="year_level" required>
          <option value="">Select...</option>
          <option value="1" @selected(old('year_level')==='1' )>1</option>
          <option value="2" @selected(old('year_level')==='2' )>2</option>
          <option value="3" @selected(old('year_level')==='3' )>3</option>
          <option value="4" @selected(old('year_level')==='4' )>4</option>
        </select>
      </div>

      <div class="field full">
        <label>Address</label>
        <input type="text" name="address" value="{{ old('address') }}" required>
      </div>

      <div class="field">
        <label>City</label>
        <input type="text" name="city" value="{{ old('city') }}" required>
      </div>
      <div class="field">
        <label>Province</label>
        <input type="text" name="province" value="{{ old('province') }}" required>
      </div>

      <div class="field">
        <label>Guardian Name</label>
        <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" required>
      </div>
      <div class="field">
        <label>Guardian Phone</label>
        <input type="text" name="guardian_phone" value="{{ old('guardian_phone') }}" required>
      </div>

      <div class="field">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <div class="field">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required>
      </div>
    </div>

    <div class="actions">
      <button class="btn btn-primary" type="submit">Register</button>
      <a class="btn btn-outline" href="/login">Back to login</a>
    </div>
  </form>
</div>
@endsection