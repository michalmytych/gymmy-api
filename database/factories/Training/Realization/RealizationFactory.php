<?php

namespace Database\Factories\Training\Realization;

use App\Enums\RealizationStatusType;
use App\Models\Training\Exercise\Exercise;
use App\Models\Training\Realization\Realization;
use Illuminate\Database\Eloquent\Factories\Factory;

class RealizationFactory extends Factory
{
    protected $model = Realization::class;

    public function definition(): array
    {
        $exercise = Exercise::factory()->create();

        return [
            'realizationable_id'    => $exercise->id,
            'realizationable_type'  => get_class($exercise),
            'time_started'          => now(),
            'time_ended'            => now(),
            'status'                => RealizationStatusType::RUNNING,
        ];
    }
}
