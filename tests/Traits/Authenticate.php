<?php

namespace Tests\Traits;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * @method actingAs(Authenticatable $user, $guard = null)
 */
trait Authenticate
{
    protected User $user;

    public function setUpUser(): void
    {
        $this->user = User::factory()->create();
    }

    protected function authenticate(): TestCase
    {
        return $this->actingAs($this->user);
    }
}
