<?php

namespace App\Policies\Training\Realization;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Training\Realization\Realization;

class RealizationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Realization $realization): bool
    {
        return $user->id === $realization->user_id;
    }

    public function update(User $user, Realization $realization): bool
    {
        return $user->id === $realization->user_id;
    }

    public function delete(User $user, Realization $realization): bool
    {
        return $user->id === $realization->user_id;
    }
}
