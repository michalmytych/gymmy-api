<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            MuscleGroupSeeder::class,
            TrainingSeeder::class,
            ExerciseSeeder::class,
            RealizationSeeder::class,
            SeriesSeeder::class,
        ]);
    }
}
