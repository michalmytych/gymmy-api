<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Training\Realization\Series;

class SeriesSeeder extends Seeder
{
    public function run()
    {
        Series::factory(25)->create();
    }
}
