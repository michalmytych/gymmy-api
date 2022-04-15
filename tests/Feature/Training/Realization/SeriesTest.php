<?php

namespace Tests\Feature\Training\Realization;

use Tests\TestCase;
use Tests\Traits\Authenticate;
use App\Enums\RealizationStatusType;
use App\Models\Training\Realization\Series;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Training\Realization\Realization;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesTest extends TestCase
{
    use Authenticate, RefreshDatabase;

    public function testStoreOnRealization()
    {
        $realization = Realization::factory()->create([
            'status' => RealizationStatusType::RUNNING,
        ]);

        $this
            ->authenticate()
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
