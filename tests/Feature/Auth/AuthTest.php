<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterUser(): void
    {
        $this
            ->postJson(route('auth.register'), [
                'name'             => '::name::',
                'email'            => 'test@gmail.com',
                'password'         => '::password::',
                'confirm_password' => '::password::',
            ])
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->whereType('token', 'string')
            );
    }

    public function testLoginUser(): void
    {
        User::create([
            'name'     => '::name::',
            'email'    => 'test@gmail.com',
            'password' => bcrypt('::password::'),
        ]);

        $this
            ->postJson(route('auth.login'), [
                'email'    => 'test@gmail.com',
                'password' => '::password::',
            ])
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->whereType('token', 'string')
            );
    }
}
