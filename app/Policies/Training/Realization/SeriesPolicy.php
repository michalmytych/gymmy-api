<?php

namespace App\Policies\Training\Realization;

use App\Models\User;
use App\Models\Training\Realization\Series;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeriesPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Series $series): bool
    {
        return $user->id === $series->realization->user_id;
    }

    public function update(User $user, Series $series): bool
    {
        return $user->id === $series->realization->user_id;
    }

    public function delete(User $user, Series $series): bool
    {
        return $user->id === $series->realization->user_id;
    }
}
