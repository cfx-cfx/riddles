<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Game;

class GamePolicy
{
    /**
     * Create a new policy instance.
     */
    public function start(User $user, Game $game): bool
    {
        return $user->is_admin || $user->id === $game->host_user_id;
    }

    public function finish(User $user, Game $game): bool
    {
        return $user->is_admin || $user->id === $game->host_user_id;
    }
}
