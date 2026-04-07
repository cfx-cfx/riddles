<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('game.{game}', function ($user) {
    if ($user->banned_at) {
        return false;
    }

    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});

Broadcast::channel('game', function ($user) {
    return !$user->banned_at;
});
