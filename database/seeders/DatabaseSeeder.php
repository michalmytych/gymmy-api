<?php

namespace Database\Seeders;

use App\Models\Training\Exercise;
use App\Models\Training\Series;
use App\Models\Training\Training;
use App\Models\Training\Realization;
use Illuminate\Database\Seeder;
use App\Models\Training\MuscleGroup;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

//        $trainings = Training::factory(5)->create();
//
//        $trainings
//            ->each(fn($training) => $training
//                ->exercises()
//                ->saveMany(Exercise::factory(3)->create())
//            );
//
//        Realization::factory(5)->create();
//
//        Exercise::all()
//            ->each(fn($exercise) => $exercise
//                ->series()
//                ->saveMany(Series::factory(4)->create())
//            );

        $muscleGroups = [
            ['name' => 'Kaptury'],
            ['name' => 'Bark - akton przedni'],
            ['name' => 'Bark - akton boczny'],
            ['name' => 'Bark - akton tylny'],
            ['name' => 'Góra klatki piersiowej'],
            ['name' => 'Środek/przód klatki piersiowej'],
            ['name' => 'Dół klatki piersiowej'],
            ['name' => 'Środek brzucha'],
            ['name' => 'Mięśnie ukośne brzucha brzucha'],
            ['name' => 'Mięśnie ud'],
            ['name' => 'Mięsnie goleni'],
            ['name' => 'Przedramię'],
            ['name' => 'Biceps'],
            ['name' => 'Triceps'],
            ['name' => 'Najszersze grzbietu'],
            ['name' => 'Prostowniki'],
        ];

        foreach ($muscleGroups as $muscleGroup) {
            MuscleGroup::firstOrCreate($muscleGroup);
        }
    }
}
