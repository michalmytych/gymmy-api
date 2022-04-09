<?php

namespace Database\Factories\Training\Exercise;

use App\Models\Training\Exercise\MuscleGroup;
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
