<?php

namespace App\Policies\Training;

use App\Models\User;
use App\Models\Training\Training;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrainingPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Training $training): bool
    {
        return $user->id === $training->user_id;
    }

    public function update(User $user, Training $training): bool
    {
        return $user->id === $training->user_id;
    }

    public function delete(User $user, Training $training): bool
    {
        return $user->id === $training->user_id;
    }
}
