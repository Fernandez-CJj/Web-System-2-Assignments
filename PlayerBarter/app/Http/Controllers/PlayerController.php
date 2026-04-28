<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlayerController extends Controller
{
    public function index(Request $request): View
    {
        $players = User::query()
            ->where('role', 'player')
            ->when($request->filled('q'), fn ($query) => $query->where('username', 'like', '%'.$request->q.'%'))
            ->when($request->filled('game'), fn ($query) => $query->where('preferred_games', 'like', '%'.$request->game.'%'))
            ->withAvg('receivedRatings', 'score')
            ->when($request->sort === 'rating', fn ($query) => $query->orderByDesc('received_ratings_avg_score'))
            ->when($request->sort === 'activity', fn ($query) => $query->latest())
            ->paginate(12)
            ->withQueryString();

        return view('players.index', compact('players'));
    }
}
