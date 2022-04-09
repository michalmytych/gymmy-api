<?php

namespace Database\Factories\Training\Exercise;

use App\Models\Training\Exercise\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExerciseFactory extends Factory
{
    protected $model = Exercise::class;

    public function definition(): array
    {
        return [
            'name'             => 'Exercise ' . $this->faker->word(),
            'break_duration_s' => $this->faker->randomNumber(4),
            'description'      => $this->faker->realText(),
        ];
    }
}
