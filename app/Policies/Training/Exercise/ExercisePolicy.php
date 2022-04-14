<?php

namespace App\Policies\Training\Exercise;

use App\Models\User;
use App\Models\Training\Exercise\Exercise;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExercisePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Exercise $exercise): bool
    {
        return $user->id === $exercise->user_id;
    }

    public function update(User $user, Exercise $exercise): bool
    {
        return $user->id === $exercise->user_id;
    }

    public function delete(User $user, Exercise $exercise): bool
    {
        return $user->id === $exercise->user_id;
    }
}
