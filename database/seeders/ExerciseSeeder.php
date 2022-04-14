<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Training\Training;
use App\Models\Training\Exercise\Exercise;
use App\Models\Training\Exercise\MuscleGroup;

class ExerciseSeeder extends Seeder
{
    public function run()
    {
        foreach (Training::all() as $training) {
            $training
                ->exercises()
                ->sync(
                    Exercise::factory(5)->create([
                        'user_id' => $training->user_id,
                    ])->pluck('id')
                );
        }

        foreach (Exercise::all() as $exercise) {
            $exercise->muscleGroups()->sync(
                MuscleGroup::query()
                    ->inRandomOrder()
                    ->take(3)
                    ->pluck('id')
            );
        }
    }
}
