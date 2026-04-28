<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'username' => ['required', 'alpha_dash', 'max:40', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
            'preferred_games' => ['nullable', 'string', 'max:255'],
            'trading_preferences' => ['nullable', 'string', 'max:1000'],
        ]);

        $attributes['role'] = 'player';
        $user = User::create($attributes);
        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Welcome to PlayerBarter.');
    }
}
