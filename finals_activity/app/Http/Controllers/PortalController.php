<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PortalController extends Controller
{
  public function dashboard(Request $request)
  {
    $userId = $request->session()->get('auth_user_id');

    $user = DB::table('users')->where('id', $userId)->first();
    if (! $user) {
      $request->session()->forget('auth_user_id');

      return redirect('/login')->with('error', 'Session expired. Please login again.');
    }

    return view('portal.dashboard', [
      'user' => $user,
    ]);
  }

  public function editProfile(Request $request)
  {
    $userId = $request->session()->get('auth_user_id');
    $user = DB::table('users')->where('id', $userId)->first();

    if (! $user) {
      $request->session()->forget('auth_user_id');

      return redirect('/login')->with('error', 'Session expired. Please login again.');
    }

    return view('portal.profile', ['user' => $user]);
  }

  public function updateProfile(Request $request): RedirectResponse
  {
    $userId = $request->session()->get('auth_user_id');

    $validator = Validator::make($request->all(), [
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
      'email' => 'required|email|max:255|unique:users,email,' . $userId,
    ]);

    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }

    $data = $validator->validated();

    DB::table('users')->where('id', $userId)->update([
      'name' => trim($data['first_name'] . ' ' . $data['last_name']),
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
      'updated_at' => now(),
    ]);

    DB::table('activity_logs')->insert([
      'user_id' => $userId,
      'event' => 'profile_updated',
      'method' => $request->method(),
      'path' => '/' . $request->path(),
      'status_code' => 200,
      'ip_address' => $request->ip(),
      'user_agent' => $request->userAgent(),
      'details' => json_encode(['email' => $data['email']]),
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    return redirect('/dashboard')->with('success', 'Profile updated successfully.');
  }
}
