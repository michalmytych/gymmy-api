<?php

namespace Database\Factories\Training\Realization;

use Exception;
use App\Models\Training\Exercise\Exercise;
use App\Models\Training\Realization\Series;
use App\Models\Training\Realization\Realization;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    protected $model = Series::class;

    /**
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'exercise_id'       => Exercise::first()?->id,
            'realization_id'    => Realization::first()?->id,
            'repetitions_count' => random_int(5, 15),
            'break_duration'    => 120,
            'weight'            => random_int(5, 100),
            'is_target'         => false,
        ];
    }
}
