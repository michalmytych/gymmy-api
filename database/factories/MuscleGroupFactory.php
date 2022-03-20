<?php

namespace Database\Factories;

use App\Models\Training\MuscleGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class MuscleGroupFactory extends Factory
{
    protected $model = MuscleGroup::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word()
        ];
    }
}
