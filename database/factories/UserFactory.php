<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name'              => $this->faker->unique()->name(),
            'email'             => $this->faker->unique()->email(),
            'email_verified_at' => now(),
            'password'          => bcrypt($this->faker->sentence(3)),
            'remember_token'    => Str::random(10),
        ];
    }

    public function testUser(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'name'           => 'Test user',
                'email'          => 'test@gmail.com',
                'password'       => bcrypt('password'),
                'remember_token' => 'Always_the_same_remember_token',
            ];
        });
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
