<?php

namespace Tests\Feature\Training\Realization;

use Tests\TestCase;
use Tests\Traits\Authenticate;
use App\Models\Training\Training;
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

    public function testCannotStoreOnTrainingRealization(): void
    {
        $training = Training::factory()->create();

        $realization = Realization::factory()->create([
            'status'               => RealizationStatusType::RUNNING,
            'realizationable_id'   => $training->id,
            'realizationable_type' => get_class($training),
        ]);

        $this
            ->authenticate()
            ->postJson(route('training.realization.series.store-on-realization', $realization), [
                'repetitions_count' => 12,
                'weight_kg'         => 45,
            ])
            ->assertStatus(400)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('message', 'training.realization.cannot-add-series-to-training-realization')
                ->etc()
            );
    }

    /**
     * @dataProvider badStatusesForStoringSeriesDataProvider
     */
    public function testCannotStoreOnFinishedRealization(int $status): void
    {
        $realization = Realization::factory()->create(['status' => $status]);

        $this
            ->authenticate()
            ->postJson(route('training.realization.series.store-on-realization', $realization), [
                'repetitions_count' => 12,
                'weight_kg'         => 45,
            ])
            ->assertStatus(400)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('message', 'training.realization.cannot-add-series-to-finished-realization')
                ->etc()
            );
    }

    public function badStatusesForStoringSeriesDataProvider(): array
    {
        return [
            'Completed realization' => [RealizationStatusType::COMPLETED],
            'Canceled realization'  => [RealizationStatusType::CANCELED],
        ];
    }
}
