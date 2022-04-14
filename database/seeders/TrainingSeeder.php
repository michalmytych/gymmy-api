<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Training\Training;

class TrainingSeeder extends Seeder
{
    public function run()
    {
        foreach(User::all() as $user) {
            Training::factory(5)->create([
                'user_id' => $user->id
            ]);
        }
    }
}
