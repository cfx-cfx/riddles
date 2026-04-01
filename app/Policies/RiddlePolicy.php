<?php

namespace App\Policies;

use App\Models\Riddle;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Enums\RiddleStatus;

class RiddlePolicy
{
    public function before(User $user): bool|null
    {
        if ($user->is_admin) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // посредник auth
        return true;
    }

    public function adminOrAuthor(User $user, Riddle $riddle): bool
    {
        // админ авторизуется через before
        return $user->id === $riddle->user_id;
    }

    public function adminOnly(User $user): bool
    {
        return false;
    }

    public function update(User $user, Riddle $riddle): bool
    {
        return $user->id === $riddle->user_id && in_array($riddle->status->value, ['draft', 'blocked']);
    }
}
