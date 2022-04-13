<?php

namespace Database\Factories\Training;

use App\Models\Training\Training;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingFactory extends Factory
{
    protected $model = Training::class;

    public function definition(): array
    {
        return [
            'name'        => 'Training ' . $this->faker->word(),
            'description' => 'Description ' . $this->faker->realText(),
        ];
    }
}
