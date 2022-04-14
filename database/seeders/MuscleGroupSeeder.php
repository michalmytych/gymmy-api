<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Training\Exercise\MuscleGroup;

class MuscleGroupSeeder extends Seeder
{
    public function run()
    {
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
