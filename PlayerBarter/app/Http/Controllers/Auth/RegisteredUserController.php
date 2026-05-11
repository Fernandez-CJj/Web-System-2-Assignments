<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register', ['preferredGames' => User::PREFERRED_GAMES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'username' => ['required', 'alpha_dash', 'max:40', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
            'preferred_games' => ['nullable', 'array'],
            'preferred_games.*' => ['string', Rule::in(User::PREFERRED_GAMES)],
            'trading_preferences' => ['nullable', 'string', 'max:1000'],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('profile_picture')) {
            $attributes['profile_photo_path'] = $request->file('profile_picture')->store('profile-pictures', 'public');
        }

        unset($attributes['profile_picture']);
        $attributes['preferred_games'] = implode(', ', $attributes['preferred_games'] ?? []);
        $attributes['role'] = 'player';
        $user = User::create($attributes);
        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Welcome to PlayerBarter.');
    }
}
