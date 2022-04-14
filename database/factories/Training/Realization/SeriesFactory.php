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
        $exerciseRealization = Realization::firstWhere('realizationable_type', get_class(new Exercise));

        if (!$exerciseRealization) {
            $exercise = Exercise::factory()->create();

            $exerciseRealization = Realization::factory()->create([
                'realizationable_type' => get_class($exercise),
                'realizationable_id'   => $exercise->id,
            ]);
        }

        return [
            'realization_id'    => $exerciseRealization->id,
            'repetitions_count' => random_int(5, 15),
            'weight_kg'         => random_int(5, 100),
        ];
    }
}
