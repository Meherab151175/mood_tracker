<?php

namespace App\Policies;

use App\Models\Mood;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MoodPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Mood $mood): bool
    {
        return $user->id === $mood->user_id;
    }

   

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Mood $mood): bool
    {
        return $user->id === $mood->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Mood $mood): bool
    {
        return $user->id === $mood->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Mood $mood): bool
    {
        return $user->id === $mood->user_id;
    }
}
