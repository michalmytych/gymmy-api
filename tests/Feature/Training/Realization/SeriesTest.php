<?php

namespace Tests\Feature\Training\Realization;

use Tests\TestCase;
use App\Models\Training\Realization\Series;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Training\Realization\Realization;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreOnRealization()
    {
        $realization = Realization::factory()->create();

        $this
            ->postJson(route('training.realization.series.store-on-realization', $realization), [
                'repetitions_count' => 12,
                'weight_kg'         => 45,
            ])
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->whereAll([
                    'id'                => Series::first()->id,
                    'realization_id'    => $realization->id,
                    'repetitions_count' => 12,
                    'weight_kg'         => 45,
                ])
                ->etc()
            );
    }
}
