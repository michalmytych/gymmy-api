<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'              => 'Test user',
            'email'             => 'test@gmail.com',
            'email_verified_at' => now(),
            'password'          => bcrypt('password'),
            'remember_token'    => Str::random(10),
        ];
    }

    public function unverified(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
