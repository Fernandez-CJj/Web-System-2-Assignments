<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function showRegister()
  {
    return view('auth.register');
  }

  public function register(Request $request): RedirectResponse
  {
    $validator = Validator::make($request->all(), [
      'student_number' => 'required|string|max:40|unique:users,student_number',
      'first_name' => 'required|string|max:100',
      'last_name' => 'required|string|max:100',
      'middle_name' => 'nullable|string|max:100',
      'birth_date' => 'required|date',
      'gender' => 'required|string|max:20',
      'phone' => 'required|string|max:30',
      'program' => 'required|string|max:120',
      'year_level' => 'required|string|max:20',
      'address' => 'required|string|max:255',
      'city' => 'required|string|max:100',
      'province' => 'required|string|max:100',
      'guardian_name' => 'required|string|max:100',
      'guardian_phone' => 'required|string|max:30',
      'email' => 'required|email|max:255|unique:users,email',
      'password' => 'required|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }

    $data = $validator->validated();
    $fullName = trim($data['first_name'] . ' ' . $data['last_name']);

    $userId = DB::table('users')->insertGetId([
      'name' => $fullName,
      'student_number' => $data['student_number'],
      'first_name' => $data['first_name'],
      'last_name' => $data['last_name'],
      'middle_name' => $data['middle_name'] ?? null,
      'birth_date' => $data['birth_date'],
      'gender' => $data['gender'],
      'phone' => $data['phone'],
      'program' => $data['program'],
      'year_level' => $data['year_level'],
      'address' => $data['address'],
      'city' => $data['city'],
      'province' => $data['province'],
      'guardian_name' => $data['guardian_name'],
      'guardian_phone' => $data['guardian_phone'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    $request->session()->put('auth_user_id', $userId);

    $this->logCustomEvent($request, $userId, 'register_success', [
      'email' => $data['email'],
      'student_number' => $data['student_number'],
    ]);

    return redirect('/dashboard')->with('success', 'Registration successful. Welcome!');
  }

  public function showLogin()
  {
    return view('auth.login');
  }

  public function login(Request $request): RedirectResponse
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required|string',
    ]);

    $user = DB::table('users')->where('email', $credentials['email'])->first();

    if (! $user || ! Hash::check($credentials['password'], $user->password)) {
      $this->logCustomEvent($request, null, 'login_failed', [
        'email' => $credentials['email'],
      ]);

      return back()->with('error', 'Invalid email or password.')->withInput();
    }

    $request->session()->put('auth_user_id', $user->id);

    $this->logCustomEvent($request, $user->id, 'login_success', [
      'email' => $user->email,
    ]);

    return redirect('/dashboard')->with('success', 'Welcome back, ' . $user->first_name . '!');
  }

  public function logout(Request $request): RedirectResponse
  {
    $userId = $request->session()->get('auth_user_id');

    if ($userId) {
      $this->logCustomEvent($request, $userId, 'logout', []);
    }

    $request->session()->forget('auth_user_id');

    return redirect('/login')->with('success', 'You are now logged out.');
  }

  private function logCustomEvent(Request $request, ?int $userId, string $event, array $details): void
  {
    DB::table('activity_logs')->insert([
      'user_id' => $userId,
      'event' => $event,
      'method' => $request->method(),
      'path' => '/' . $request->path(),
      'status_code' => 200,
      'ip_address' => $request->ip(),
      'user_agent' => $request->userAgent(),
      'details' => json_encode($details),
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }
}
