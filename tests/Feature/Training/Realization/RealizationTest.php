<?php

namespace Tests\Feature\Training\Realization;

use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Training\Realization\Realization;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    public function testDisablePaginationOnListOfTrainings(): void
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
