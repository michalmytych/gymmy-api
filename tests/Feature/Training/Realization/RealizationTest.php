<?php

namespace Tests\Feature\Training\Realization;

use Tests\TestCase;
use Tests\Traits\Authenticate;
use App\Models\Training\Training;
use App\Enums\RealizationStatusType;
use App\Models\Training\Exercise\Exercise;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Training\Realization\Realization;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RealizationTest extends TestCase
{
    use Authenticate, RefreshDatabase;

    public function testReturnPaginatedListOfRealizations(): void
    {
        Realization::factory(3)->create();

        $this
            ->authenticate()
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
            ->authenticate()
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
            ->authenticate()
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
            ->authenticate()
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

    public function testRealizeTraining(): void
    {
        $training = Training::factory()->create();

        $structure = $this->realizationJsonStructure();

        unset($structure['parent_realization_id']);
        unset($structure['time_ended']);

        $this
            ->authenticate()
            ->postJson(route('training.realization.realize-training', $training))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('status', RealizationStatusType::RUNNING)
                ->whereAllType($structure)
            );
    }

    public function testRealizeExercise(): void
    {
        $exercise = Exercise::factory()->create();

        $training = Training::factory()->create();

        $training
            ->exercises()
            ->sync([$exercise->id]);

        $trainingRealization = Realization::factory()->create([
            'realizationable_id'   => $training->id,
            'realizationable_type' => get_class($training),
        ]);

        $structure = $this->realizationJsonStructure();

        unset($structure['time_ended']);

        $this
            ->authenticate()
            ->postJson(route('training.realization.realize-exercise', [
                'exercise'           => $exercise,
                'parent_realization' => $trainingRealization,
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('status', RealizationStatusType::RUNNING)
                ->where('parent_realization_id', $trainingRealization->id)
                ->whereAllType($structure)
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
