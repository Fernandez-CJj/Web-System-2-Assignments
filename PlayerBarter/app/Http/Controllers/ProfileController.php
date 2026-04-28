<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $attributes = $request->validate([
            'username' => ['required', 'alpha_dash', 'max:40', Rule::unique('users')->ignore($user->id)],
            'preferred_games' => ['nullable', 'string', 'max:255'],
            'trading_preferences' => ['nullable', 'string', 'max:1000'],
        ]);

        $user->update($attributes);

        return back()->with('status', 'Profile updated.');
    }

    public function show(User $user): View
    {
        return view('players.show', [
            'player' => $user->load([
                'items' => fn ($query) => $query->whereIn('availability_status', ['available', 'reserved'])->latest(),
                'receivedRatings.rater',
            ]),
        ]);
    }
}
