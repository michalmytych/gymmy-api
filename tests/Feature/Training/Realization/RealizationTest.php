<?php

namespace Tests\Feature\Training\Realization;

use Tests\TestCase;
use App\Enums\RealizationStatusType;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Training\Realization\Realization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\Relation;

class RealizationTest extends TestCase
{
    use RefreshDatabase;

    public function testReturnPaginatedListOfRealizations(): void
    {
        Realization::factory(3)->create();

        $this
            ->getJson(route('training.realization.all', [
                'paginated' => true,
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->hasPagination()
                ->has('data', fn(AssertableJson $json) => $json
                    ->count(3)
                    ->each(fn(AssertableJson $json) => $json
                        ->whereAllType($this->realizationJsonStructure())
                    )
                )
            );
    }

    public function testDisablePaginationOnListOfRealizations(): void
    {
        Realization::factory(3)->create();

        $this
            ->getJson(route('training.realization.all', [
                'paginated' => false,
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->count(3)
                ->each(fn(AssertableJson $json) => $json
                    ->whereAllType($this->realizationJsonStructure())
                )
            );
    }

    public function testCompleteStartedRealization(): void
    {
        $realization = Realization::factory()->create();

        $this
            ->postJson(route('training.realization.complete', $realization))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('status', RealizationStatusType::COMPLETED)
                ->whereAllType($this->realizationJsonStructure())
            );

        $this->assertEquals(
            RealizationStatusType::COMPLETED,
            $realization->refresh()->status->value
        );
    }

    public function testCancelStartedRealization(): void
    {
        $realization = Realization::factory()->create();

        $this
            ->postJson(route('training.realization.cancel', $realization))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('status', RealizationStatusType::CANCELED)
                ->whereAllType($this->realizationJsonStructure())
            );

        $this->assertEquals(
            RealizationStatusType::CANCELED,
            $realization->refresh()->status->value
        );
    }

    private function realizationJsonStructure(): array
    {
        return [
            'id'                    => 'string',
            'parent_realization_id' => ['string', 'null'],
            'realizationable_type'  => 'string',
            'realizationable_id'    => 'string',
            'time_started'          => 'string',
            'time_ended'            => ['string', 'null'],
            'status'                => 'integer',
            'created_at'            => 'string',
            'updated_at'            => 'string',
        ];
    }
}
