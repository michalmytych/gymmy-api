<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Training\Training;
use App\Models\Training\Exercise\Exercise;
use App\Models\Training\Realization\Realization;

class RealizationSeeder extends Seeder
{
    public function run()
    {
        foreach (Training::all() as $training) {
            Realization::factory()->create([
                'realizationable_type' => get_class($training),
                'realizationable_id'   => $training->id,
            ]);
        }

        foreach (Exercise::all() as $exercise) {
            if ($exercise->trainings()->exists()) {
                Realization::factory()->create([
                    'realizationable_id'    => $exercise->id,
                    'realizationable_type'  => get_class($exercise),
                    'parent_realization_id' => Realization::firstWhere(
                        'realizationable_id',
                        $exercise
                            ->trainings
                            ->first()
                            ->id
                    ),
                ]);
            }
        }
    }
}
