@include('shared._game_multi_select', [
    'id' => 'preferred_games',
    'name' => 'preferred_games',
    'placeholder' => 'Select preferred games',
    'preferredGames' => $preferredGames,
    'selected' => $selected ?? [],
])
