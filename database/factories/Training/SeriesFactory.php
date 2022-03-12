<?php

namespace Database\Factories\Training;

use App\Models\Training\Exercise;
use App\Models\Training\Realization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Training\Series>
 */
class SeriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'exercise_id' => Exercise::first()?->id,
            'realization_id' => Realization::first()?->id,
            'repetitions_count' => random_int(5, 15),
            'break_duration' => 120,
            'weight' => random_int(5, 100),
            'is_target' => false
        ];
    }
}
