@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-head">
    <h1>Student Portal Login</h1>
    <p>Sign in with your account to continue.</p>
  </div>

  @if (session('success'))
  <div class="flash success">{{ session('success') }}</div>
  @endif

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

  <form method="POST" action="/login">
    @csrf
    <div class="form-grid">
      <div class="field full">
        <label for="email">Email Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
      </div>

      <div class="field full">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
      </div>
    </div>

    <div class="actions">
      <button class="btn btn-primary" type="submit">Login</button>
      <a class="btn btn-outline" href="/register">Create account</a>
    </div>
  </form>
</div>
@endsection