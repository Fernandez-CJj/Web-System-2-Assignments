<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit', [
            'preferredGames' => User::PREFERRED_GAMES,
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $attributes = $request->validate([
            'username' => ['required', 'alpha_dash', 'max:40', Rule::unique('users')->ignore($user->id)],
            'preferred_games' => ['nullable', 'array'],
            'preferred_games.*' => ['string', Rule::in(User::PREFERRED_GAMES)],
            'trading_preferences' => ['nullable', 'string', 'max:1000'],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $attributes['profile_photo_path'] = $request->file('profile_picture')->store('profile-pictures', 'public');
        }

        unset($attributes['profile_picture']);
        $attributes['preferred_games'] = implode(', ', $attributes['preferred_games'] ?? []);
        $user->update($attributes);

        return back()->with('status', 'Profile updated.');
    }

    public function show(User $user): View
    {
        return view('players.show', [
            'player' => $user->load([
                'items' => fn ($query) => $query->whereIn('availability_status', ['available', 'reserved'])->with('images')->latest(),
                'receivedRatings.rater',
            ]),
        ]);
    }
}
